<?php
	require_once('Connections/zkizblog.php'); 
	include_once("include/common.inc.php");
	include_once("include/rfPosts.class.php");
	//relation_type 1:ban 2:follow 3:disable notification 4:enable notification

	//settings
	$datetime = safe(gmdate("Y-m-d H:i:s", time()+28800));
	$title = "";
	$tmpAtlist=array();
	$fid = intval($_REQUEST['fid']);
	$ip = getIP();
	$type_info = dbRow("SELECT * FROM zf_contenttype WHERE id = {$fid}");
	$blackwords[] = "<a href";
	$blackwords[] = "http://www.facebook.com/profile.php";
	
	$gType = in_array($_GET['type'], ["reply","post","quote"])?$_GET['type']:"post";
	
	
	
	if($fid != 0){
		if($type_info['allowguest'] == 0 && !$isLog){screenMessage("錯誤","本區(fid:{$fid}) 禁止訪客發貼。","/viewforum.php?fid=$fid");}
		if(in_array($gId,explode(",",$type_info['banned_member']))){screenMessage("錯誤","你已版本版主加入黑名單, 不能發帖。");}
		if(!$type_info){screenMessage("錯誤","不正確的版塊(fid:$fid)");}
	}
	
	//Check and trim for content / title
	foreach(['content','title','picurl'] as $post_key){
		if(isRussian($_POST[$post_key]) || str_ireplace($blackwords, '', $_POST[$post_key]) != $_POST[$post_key] ){
			screenMessage("Error",'Bad Words Detected');
		}
		$_POST[$post_key] = trim($_POST[$post_key]);
	}
	
	
	
	if(isset($_POST["posttype"])){
		if($_POST['content']==""){screenMessage("發怖失敗","內容不可為空","");}
		if(!$isLog ||  $my['postnum'] < $g_low_post_captcha ){
			$code=$_POST['g-recaptcha-response'];
			//$_POST['g-recaptcha-response'] / RECAPTCHA_V2_KEY / getIP()
			$arrQuery = ["secret"=>RECAPTCHA_V2_KEY,"response"=>$_POST['g-recaptcha-response'],"remoteip"=>getIP()];
			$google_check_json = file_get_contents(
				"https://www.google.com/recaptcha/api/siteverify?".http_build_query($arrQuery)
			);
			$result = json_decode($google_check_json,true);
			
			if($result["success"] != true){screenMessage("驗證失敗","請重試","");}
		}
		//@人
		preg_match_all('/\[@(.+?)\]/i',safe($_POST['content']." "), $tmpAtList);
		if(!empty($tmpAtList[1])){
			$arrAtList = array_slice(array_unique($tmpAtList[1]),0,$RFG['max_allow_at']);
		}
	
		if($_POST["posttype"]=="modify"){exit;}
		
		if($_POST["posttype"]=="post"){
			
			$title = safe($_POST['title']);
			$subtitle = safe($_POST['subtitle']);
			
			$picurl = (substr($_POST['picurl'],0,4) == "http")?safe($_POST['picurl']):"";
			$content = safe($_POST['content']);
			$price = intval($_POST['price']);
			$special = $_POST['wiki']=='true'?'4':'0';
			$special = $_POST['resource']=='true'?'5':'0';
			$tags = explode(",",$_POST['tags']);

            if(mb_strlen($_POST['title']) > 150){
                screenMessage("ERROR","Title too long(limit:150)");
            }

			$lastTID = rfPosts::newThread(
				$_POST['title'], 
				$_POST['subtitle'], 
				$fid, $_POST['content'], $picurl, $datetime, $ip, $gId, 
				$special, $price,$tags, ($_POST["also_subscribe"]==1));


			if($lastTID < 0){
				screenMessage("ERROR","ERROR CODE:$lastTID");
			}
			
			if(!empty($arrAtList)){
				sendNotifications($arrAtList,"","{$my['username']}在發表<strong>{$title}</strong>時提及了你。","{$g_domain}/thread.php?tid={$lastTID}");
			}
			
			addNews($gUsername,$title,1,"{$g_domain}/thread.php?tid={$lastTID}");
			
			setcookie("previous_post_fid",$fid,time()+3600*24*30);
			
			if($my['plurkkey']!="" && $_POST['noplurk']!="true"){
				$plurk = getPlurk($my['plurkkey']);
				if($plurk){
					$plurk->add_plurk('en', 'shares', "{$g_domain}/thread.php?tid={$lastTID} ($title)");
				}
			}
			/*
			if($my['facebook']=="1"){
			
				$fb = getFacebook();
				
				if ($fb['me']) {
					$arr_post = [
					'name'=>$title,				'message'=> $title,
					'description'=>$content,	'link' =>"{$g_domain}/thread.php?tid={$lastTID}"
					];
					if($picurl!=""){$arr_post['picture'] = $picurl;	}
				
					$statusUpdate = $fb['object']->api('/me/feed', 'POST', $arr_post);
				}
			}
			*/
			if($_GET['post_action']=='die'){die("<a href='thread.php?tid=$lastTID'>$title</a>");}
			if($_GET['post_action']=='exit'){exit;}
			setcookie("justpost","true",time()+10);
			header("LOCATION: thread.php?tid={$lastTID}");
			exit;
		}
		
		if($_POST["posttype"]=="reply" || $_POST["posttype"]=="quote"){
			
			if(!isset($_POST['tid'])){
				//look for tracing
				if(isset($_POST['tracing'])){
					$_input = intval($_POST['tracing']);
					$tid = dbRs("SELECT tid FROM zf_pages_tracing WHERE tag = {$_input}");
					
				}else{
					return false;
				
				}
			}else{
				$tid = safe($_POST['tid']);
			}
			
			//defense
			$pageinfo = dbRow("SELECT authorid, title, type, special,commentnum, is_closed FROM zf_contentpages WHERE id=$tid");
			if($pageinfo['is_closed'] == '1'){exit;}

			$picurl = (substr($_POST['picurl'],0,4) == "http")?safe($_POST['picurl']):"";
			$content = safe($_POST['content']);
			$price = intval($_POST['price']);
			
			$pid  = intval($_POST['pid']);
			$pid = $pid<1?0:$pid;
			
			rfPosts::replyThread($fid, $tid, $pid, $content, $picurl, $datetime, $ip, $gId,$gUsername, $price, $pageinfo['authorid'],($_POST["also_subscribe"]=="1"));
			

			if(!empty($arrAtList)){
				sendNotifications($arrAtList,"","{$my['username']}在<strong>{$pageinfo['title']}</strong>的回覆中提及了你。","{$g_domain}/thread.php?tid={$tid}&amp;floorid={$pageinfo['commentnum']}");
			}
			
			if($pageinfo['special']!=5 && $pageinfo['commentnum'] <= 2000){
				$includeZids = dbAr("SELECT a.username FROM zf_user a, zf_relation b WHERE a.id = b.source_zid AND target_zid = $tid AND relation_type=4");
				sendNotifications($includeZids,'username',"<b>$gUsername</b> 對 <b>{$pageinfo['title']}</b> 做出回應","{$g_domain}/thread.php?tid=$tid&lastpage=1");
				addNews($gUsername,$pageinfo['title'],4,"{$g_domain}/thread.php?tid=$tid&lastpage=1");
			}
			
			if($_GET['post_action']=='die'){		
				require_once('include/bbcode.php');
				$bbcode = new BBCode;
				die($bbcode->parse($_POST['content']));
			}
			
			header("LOCATION: thread.php?tid={$tid}&lastpage=1#footer");
			exit;
		}
	}
	
	//Web Page
	$content = $_POST['content'];
	$gTid = intval($_GET['tid']);
	if ($gType == "reply") {
		
		$row_getThread = dbRow("SELECT a.title, name, type, authorid, special FROM zf_contentpages a, zf_contenttype b WHERE a.type=b.id AND a.id = $gTid");
		
		$follownav = array('<a href="viewforum.php?fid='.$row_getThread['type'].'">'.$row_getThread['name'].'</a>',$row_getThread['title'],"回覆");
		
		$fid=$row_getThread['type'];
		$h4 = "回覆";
	}
	
	if ($gType == "quote") {
		$gRid = intval($_GET['rid']);
		
		$row_getThread = dbRow("SELECT title, name, type, authorid, special FROM zf_contentpages a, zf_contenttype b WHERE a.type = b.id AND a.id = $gTid");
		$content = dbRs("SELECT content from zf_reply WHERE id = $gRid");
		$content = preg_replace('/\[hide\]([\s\S]*)\[\/hide\]/', 'Hidden Content', $content);
		$content = preg_replace('/\[login\]([\s\S]*)\[\/login\]/', 'Hidden Content', $content);
		$content = preg_replace('/\[sell\]([\s\S]*)\[\/sell\]/', 'Hidden Content', $content);
		$content = preg_replace('/\[auth([\s\S]*)\[\/auth\]/', 'Hidden Content', $content);
		$content = preg_replace('/\[fbhide([\s\S]*)\[\/fbhide\]/', 'Hidden Content', $content);
		$content = "[quote floor='{$_GET['name']}']".$content."[/quote]";
		
		$follownav = array('<a href="viewforum.php?fid='.$row_getThread['type'].'">'.$row_getThread['name'].'</a>',$row_getThread['title'],"引用回應");
		
		$fid=$row_getThread['type'];
		$h4 = "引用回應";
	}
	if ($gType == "post") {
		if($fid == 0){
			$fid = $_COOKIE['previous_post_fid'];
		}
	if($fid){
		$row_getType = dbRow("SELECT id, name FROM zf_contenttype WHERE id = $fid");}
		$h4 = "發表主題";
	}
	
	if ($_GET['special'] == "wiki"){
		$title = $_GET['title'];
	}
	$htmltitle=$h4;
	include(template("header"));
	include(template("post"));
	include(template("footer"));
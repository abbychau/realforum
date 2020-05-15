<?php 
	define('LITE_HEADER',true);
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php'); 
	$ajaxGetId = intval($_GET['id']);
	
	header('Access-Control-Allow-Origin: *');
	if(
		!in_array(
			parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST),
			array("realblog.zkiz.com","realblog.zkiz.com")
		)
	){
		//die("Not Validated");
	}
	//
	if($_GET['type'] == "1"){
		echo dbRs("SELECT count(*) as ce FROM zf_reply WHERE tid = ?",[$ajaxGetId]);
		exit;
	}
	//找用戶
	if($_GET['type'] == "2"){
		$tmp = dbRs("SELECT id FROM zf_user WHERE username = ?",[$_GET['id']]);
		echo $tmp==false?"查無此人":$tmp;
	}
	//設定pm 己讀
	if($_GET['type'] == "changepm"){
		$isread = ($_GET['isread']=="true")?1:0;
		dbQuery("UPDATE zf_pm SET isread = $isread WHERE id = $ajaxGetId");
	}
    if($_GET['type'] == "readAllPm"){
        if(!$isLog){die("ERROR");}
        dbQuery("UPDATE zf_pm SET isread = 1 WHERE to_id = $gId");
    }
	//刪pm
	if($_GET['type'] == "delpm"){
		$pmers = dbRow("SELECT to_id, from_id FROM zf_pm WHERE id = $ajaxGetId");
		if($pmers['to_id'] != $gId && $pmers['from_id'] != $gId){
			die("Access Denied");
		}
		if($gId == $pmers['to_id']){
			dbQuery("UPDATE zf_pm SET `del_receiver` = '1' WHERE id = $ajaxGetId");
		}
		if($gId == $pmers['from_id']){
			dbQuery("UPDATE zf_pm SET `del_sender` = '1' WHERE id = $ajaxGetId");
		}
		exit;
	}
	
	//查知通數
	if($_GET['type'] == "notify"){
		echo dbRs("SELECT count(*) FROM zm_notification WHERE `read` = 0 AND zid = '{$gUsername}'");
		exit;
	}
	//查會員勛章
	if($_GET['type'] == "achievements"){
		
		$data = dbAr("SELECT name,rank,description FROM `zm_badges` a, zm_zid_badge b WHERE a.id = b.badge AND b.zid = ? order by rank desc",[$_GET['zid']]);
		echo json_encode($data);
		exit;
	}
	//加tag
	if($_GET['type']=="tags"){
		$tid = intval($_GET['tid']);
		updateThreadTags($_GET['tag'],$tid);
		exit;
	}
	
	//引用回覆
	if($_GET['type']=="replycontent"){
		
		$content =  dbRs("SELECT content FROM zf_reply WHERE id = $ajaxGetId");
		$content=preg_replace('/\[hide\]([\s\S]*)\[\/hide\]/', 'Hidden Content'.time(), $content);
		$content=preg_replace('/\[login\]([\s\S]*)\[\/login\]/', 'Hidden Content'.time(), $content);
		$content=preg_replace('/\[sell\]([\s\S]*)\[\/sell\]/', 'Hidden Content'.time(), $content);
		$content=preg_replace('/\[auth([\s\S]*)\[\/auth\]/', 'Hidden Content'.time(), $content);
		$content=preg_replace('/\[fbhide([\s\S]*)\[\/fbhide\]/', 'Hidden Content'.time(), $content);
		echo $content;
		exit;
	}
	
	//摘錄
	if($_GET['type']=="quote"){
		$quote = trim($_GET['quote']);
		$tid = intval($_GET['tid']);
		$last_quote = dbRs("SELECT (SELECT DATE_ADD(`timestamp`, INTERVAL 3 MINUTE) FROM zm_quote WHERE zid = $gId ORDER BY id DESC LIMIT 1) < CURRENT_TIMESTAMP");
		
		
		if(mb_strlen($quote,'utf8')>140){
			$error = "摘錄長度不可超過140字。";
		}
		if(mb_strlen($quote,'utf8')<5){
			$error = "摘錄長度少於5字。";
			}
		if(!$isLog){
			$error = "必須先登入才可以摘錄。";
		}
		
		if($last_quote != 1 && $last_quote != ""){
			$error = "摘錄間隔不可少於3分鐘, 請再等等。";
		}
		
		if($my['postnum'] < 5){
			$error = "至少發貼5篇才可以摘錄。";
		}
		
		if($error == ""){
			dbQuery("INSERT INTO zm_quote VALUES(NULL, $gId, ?, ?,CURRENT_TIMESTAMP)"
			,[$quote,"{$g_domain}/thread.php?tid={$tid}"]);
			die("1");
		}else{
			die($error);
		}
		exit;
	}
	
	//關閉廣告
	if($_GET['type']=="close_ads"){
	
		if($my['score1']<10){
			die("1");
		}
		
		if(!$isLog){
			die("2");
		}
		
		useMoney(10,$gId);
		setcookie("no_ads", md5(date("Ymd").$gId), time()+60*60*24);
		die("0");
		
	}
	
	//自動取tag(comma delimited)
	if($_GET['type']=="extract_tags"){
		$tags = extractTagsFromString(trim($_GET['str']));
		if(is_array($tags)){
		echo implode(",",$tags);
		}else{
		
		}
	}
	if ((isset($_POST["type"])) && ($_POST["type"] == "add_bookmark")) {
		if (!$isLog){die("要使用收藏功能請先登入");}
		dbQuery("INSERT INTO zf_bookmark (title, url, zid) VALUES (?, ?, ?)",
		[$_POST['name'],$_POST['url'],$gId,]);
		
		echo "1";
		exit;
	}
	if ((isset($_POST["type"])) && ($_POST["type"] == "del_bookmark")) {
		dbQuery("delete from zf_bookmark where id = ?",[intval($_POST['id'])]);
		echo "1";
		exit;
	}
	//addToFavouriteBoard
	if($_GET['action']=="addToFavouriteBoard"){
		if(!$isLog){die("ERROR");}
		$fid = intval($_GET['fid']);
		dbQuery("INSERT INTO zf_favourite_board SET zid = $gId , fid = $fid");
		die("done");
	}
	if($_GET['action']=="removeFavouriteBoard"){
		if(!$isLog){die("ERROR");}
		$fid = intval($_GET['fid']);
		dbQuery("DELETE FROM zf_favourite_board WHERE zid = $gId AND fid = $fid");
		die("done");
	}
	if($_GET['action']=="getRecommendedForums"){
		$gCate=2;
		$getForumsInCate = dbAr("SELECT cate, postcount, id, name, allowguest, icon FROM zf_contenttype WHERE cate = $gCate ORDER BY postcount DESC");
		echo json_encode($getForumsInCate,JSON_UNESCAPED_UNICODE);
		exit;
	}
	
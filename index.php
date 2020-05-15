<?php
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php');
	
	if(!isset($_GET['home'])){
		header("location:/viewforum.php");
		exit;
	}

	$strGrabSQL = "SELECT * FROM zf_attention WHERE username = '$gUsername' LIMIT 100";
	if($_GET['action']=='delete'){
		dbQuery("DELETE FROM `zf_attention` WHERE username = '$gUsername' AND code = ?",[$_GET['code']]);
		$redis->delete($strGrabSQL);
	}
	
	if($_POST['code']!=''){
		if(!is_numeric($code)){
			screenMessage("Error", "Wrong code number. (we only need for example : 5).");
		}
		dbQuery("INSERT IGNORE INTO `zf_attention` (`username`,`code`)VALUES ('$gUsername',?)",[$_POST['code']]);
		$redis->delete($strGrabSQL);
	}
	
	//quotes
	$quote = dbRow("SELECT a.zid, b.username, quote,  `from` ,  `timestamp` AS  'datetime'	FROM zm_quote a, zf_user b	WHERE a.zid = b.id	ORDER BY a.id DESC 	LIMIT 1");
	
	
	$gCate = intval($my['prefered_cate'])?intval($my['prefered_cate']):2;
	$tags=dbAr("SELECT * FROM zm_tags ORDER BY timestamp DESC LIMIT 20");
	foreach($tags as $v){ $keywords.= str_replace("\"","'",$v['tag']).",";}
	$keywords = substr($keywords,0,-1);
	$htmltitle = "RealForum 首頁"; 
	
	if (!$getForumsInCate) {
		$myCateName = dbRs("SELECT name FROM zf_cate WHERE id = $gCate");
		$getForumsInCate = cacheGet("RF_FORUM_IN_CATE_{$gCate}");
	}
	if(!isset($getForumsInPerfBoard) && $isLog){
		$getForumsInPerfBoard=dbAr("SELECT postcount, id, name, allowguest, icon FROM zf_contenttype WHERE id IN(SELECT fid FROM zf_favourite_board WHERE zid = {$my['id']}) ORDER BY postcount DESC");
	}
	
	$newTopics = dbAr("SELECT a.authorid, a.id as tid, b.id as fid, commentnum, a.title as title, b.name as forumname, authorusername, lastdatetime, lastid, a.lastusername FROM `zf_contentpages` a, `zf_contenttype` b where a.type = b.id AND cate = $gCate AND isshow = 1 ORDER BY a.lastdatetime DESC LIMIT 20",[],60);
	
	$rbHotTopic = dbRow("SELECT a.id, c.pic, c.username, blogname, title, content, commentnum,datetime FROM  `zb_contentpages` a, zb_user b, zf_user c WHERE b.username=c.username AND a.ownerid = b.id AND b.blacklisted = 0 AND a.datetime >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY views DESC LIMIT 1",[],3600);
	//$birthday = dbAr("SELECT id,username,birthday FROM zf_user WHERE birthday =  CURDATE()", 3600);
	
	$headAdv = cacheGet("RF_AD_1");;
	/*
	if($isLog){
		$bannedZid = dbAr("SELECT target_zid FROM zf_relation WHERE source_zid = $gId AND relation_type = 1"); //1=ban 2=friend
		$bannedZid = groupAssoc($bannedZid,'target_zid');
	}
	*/
	$attentionInfo = dbAr($strGrabSQL, [],7200);

	if(sizeof($attentionInfo)>0){
		
		foreach($attentionInfo as $k){
			if(is_numeric( $k['code'])){
                $pure_k[] = $k['code'];
				$tmpCode = symbolize($k['code']);
				$attention_codes[] = $tmpCode;
			}
		}
		if($pure_k){
            $csv = implode(",",$pure_k);
            $webbCodes = dbAr("SELECT * FROM stock_webblink WHERE stockcode IN ({$csv})");
            foreach ($webbCodes as $v){
                $webbCode[$v['stockcode']] = $v['webbcode'];
                $issueCode[$v['stockcode']] = $v['issue'];
            }
        }
        if($attention_codes) {
            $stockinfo = getStockInfo($attention_codes);
        }
		//print_r($stockinfo);exit;
	}
	$gHideCateInSidebar = true;
	
	$hotStockArr =dbAr("SELECT b.*, a.title FROM zf_contentpages a, zf_pages_tracing b WHERE a.id = b.tid AND a.type = 128 ORDER BY count_weekly DESC LIMIT 10", [],600);

if($_SERVER["HTTP_X_PJAX"]){
    if($my['notification']){
        $htmltitle = "({$my['notification']})".$htmltitle;
    }
    echo "<title>{$htmltitle}</title>";
    include(template("index"));
}else{

    include(template("header"));
    include(template("index"));
    include(template("footer"));

}


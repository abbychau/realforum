<?php
include_once('Connections/zkizblog.php');
include_once('include/common.inc.php');
require('include/bbcode.php');
$bbcode = new BBCode;

if ($_GET['k'] = 1) {
    setcookie("keiji", "true", time() + 180000);
}
$maxRows_getReply = 30;
$order = "ASC";
$poll_max_width = 600;
$gTid = intval($_GET['tid']);



if ($_GET['tracing'] != "") {
	$tracing = sprintf("%04d",intval($_GET['tracing']));
	$tid = dbRs("SELECT tid FROM `zf_pages_tracing` WHERE tag = '$tracing'");
	header("Location: /thread.php?tid=$tid");
	exit;
}


if ($gTid == "") {
    screenMessage("Error", "Missing Thread ID.");
}



if ($_GET['wikiterm'] != "") {
    $wikiterm = htmlentities($_GET['wikiterm']);
    $gTid = dbRs("SELECT id FROM zf_contentpages WHERE title = ? AND special = 4",[$_GET['wikiterm']]);

    if ($gTid == false || $gTid == '') {
        header("location: post.php?fid=196&type=post&special=wiki&title=$wikiterm");
        exit;
    }

}

if ($_GET['floorid']) {
    $floorid = intval($_GET['floorid']);
    $numOfAbove = dbRs("SELECT count(*) FROM zf_reply WHERE tid = $gTid AND id <= $floorid");
    $tmpPage = round($numOfAbove / $maxRows_getReply);
    header("location: thread.php?tid=$gTid&page=$tmpPage#$numOfAbove");
    exit;
}

switch ($_GET['action']) {
    case "prevtopic":
        $tmpTid = dbRs("SELECT id FROM zf_contentpages WHERE id < $gTid AND type = (SELECT `type` FROM zf_contentpages WHERE id = $gTid) ORDER BY id DESC LIMIT 1");
        $tmpTid = ($tmpTid == "") ? $gTid : $tmpTid;
        header("LOCATION: /thread.php?tid=$tmpTid");
        break;
    case "nexttopic":
        $tmpTid = dbRs("SELECT id FROM zf_contentpages WHERE id > $gTid AND type = (SELECT `type` FROM zf_contentpages WHERE id = $gTid) ORDER BY id ASC LIMIT 1");
        $tmpTid = ($tmpTid == "") ? $gTid : $tmpTid;
        header("LOCATION: /thread.php?tid=$tmpTid");
        break;
}

//donation
if ($_GET['message'] == "donate_success") {
    if (time() - decrypt($_GET['checksum']) < 1800) {
        dbQuery("UPDATE zf_contentpages SET donation = donation + 5");
        $donated = true;
    }
}

$currentPage = $_SERVER["PHP_SELF"] . (isset($_SERVER['QUERY_STRING']) ? "?" . htmlentities($_SERVER['QUERY_STRING']) : "");
$currentPagePure = $_SERVER["PHP_SELF"];

$row_getThread = dbRow("SELECT is_closed,donation, isdigest, commentnum, views, a.title, type, authorid, username, special, isshow FROM zf_contentpages a, zf_user c WHERE c.id = a.authorid AND a.id = {$gTid}");
// die($row_getThread['authorid']."X");
// if (sizeof($row_getThread) == 0 || $row_getThread['authorid'] == 14 || $row_getThread['authorid'] == 830) {
//     //screenMessage("錯誤", "找不到主題或主題已被刪除。");
//     header("location:https://articles.zkiz.com/?rfid=$gTid");
// }
if ($row_getThread['type'] == "") {
    screenMessage("錯誤", "分類錯誤");
}
if ($row_getThread['isshow'] == 0) {
    screenMessage("Error", "This thread is being hidden");
}

if ($row_getThread['type'] == 119 && $gUserGroup < 5) {
    screenMessage("錯誤", "This board is under maintainance.");
}


//END of handling
$boardInfo = dbRow("SELECT * FROM zf_contenttype WHERE id = {$row_getThread['type']}");
if ($boardInfo['cate'] == 6 || $boardInfo['id'] == 44) {
    $gNoAds = true;
}

if (in_array($gId, explode(",", $boardInfo['banned_member']))) {
    $is_banned = true;
}
dbQuery("UPDATE zf_contentpages SET views=views+1, count_weekly=count_weekly+1 WHERE id = $gTid");

//GET Author Recent Topics
$authorRecentTopics = dbAr("SELECT id, title, `create_timestamp` FROM zf_contentpages WHERE authorid = {$row_getThread['authorid']} ORDER BY id DESC LIMIT 6", 60*15);

//GET purchased rid
$purchased = dbAr("SELECT rid FROM zf_purchase WHERE zid= $gId");
foreach ($purchased as $v) {
    $prid[] = $v['rid'];
} //transpose


//RENEW TAGS
if ($_GET['renewtag'] != "") {

    clearTag($gTid, 1);
    $tmpTags = extractTagsFromString($row_getThread['title']);
    insertTag($tmpTags, $gTid, 1);

    header("location:thread.php?tid=$gTid");
}

//ADD 1 TAG
$tmp_url = urldecode(prevURL());
if (stristr($tmp_url, "?tag=")) {
    $fromTag = explode("?tag=", $tmp_url);
}
if (stristr($tmp_url, "?code=")) {
    $fromTag = explode("?code=", $tmp_url);
}

if (isset($fromTag) && sizeof($fromTag) == 2) {
    $urls = explode("&", $fromTag[1]);
    $tags = updateThreadTags($urls[0], $gTid);
} else {
    $tags = getTags($gTid);
    $noTag = sizeof($tags) == 0 ? true : false;
}


//GET ADMINS
$isMod = dbRs("SELECT count(1) as ce FROM `zf_admin` WHERE fid = {$row_getThread['type']} AND ownerid = {$gId}");


//GET REPLY
$gPage = isset($_GET['page']) ? intval($_GET['page']) : 0;
$startRow_getReply = $gPage * $maxRows_getReply;

//GET POLL
if ($row_getThread['special'] == 1) {
    $pollInfo = dbRow("SELECT * FROM zf_poll WHERE tid = {$gTid}");

    $items = unserialize($pollInfo['items']);
    $users = unserialize($pollInfo['users']);
}
if ($row_getThread['special'] == 4) {
    $order = 'DESC';
    $maxRows_getReply = 5;
    $startRow_getReply = 0; //wiki
}


$totalRows_getReply = dbRs("SELECT count(1) as ce FROM zf_reply WHERE tid = {$gTid}",60); //get total rows
$totalPages_getReply = ceil($totalRows_getReply / $maxRows_getReply) - 1; //totalpage


if ($_GET['lastpage'] == "1") {
    header("location:thread.php?tid={$gTid}&page=$totalPages_getReply#lastpost");
}

$bannedZid = dbAr("SELECT target_zid FROM zf_relation WHERE source_zid = $gId AND relation_type = 1",60); //1=ban 2=friend
$bannedZid = groupAssoc($bannedZid, 'target_zid');

$getReply = dbAr("
	SELECT score_trade, is_rbenabled, comment, a.id as id, fid, timestamp,price, modrecord, content, picurl, datetime, ip, authorid, isfirstpost, praise, username,alias, gender, pic, email, url, lastlogin, signature, usertype, postnum, gp, score1, score2, score3, issign, gold, silver, bronze
	FROM zf_reply a, zf_user b 
	WHERE a.authorid = b.id 
    AND tid = {$gTid}
	ORDER BY a.id $order
	LIMIT {$startRow_getReply}, {$maxRows_getReply}");
// AND tid = {$gTid}
if (!$getReply) {
//echo "
//	SELECT score_trade, is_rbenabled, comment, a.id as id, fid, timestamp,price, modrecord, content, picurl, datetime, ip, authorid, isfirstpost, praise, username,alias, gender, pic, email, url, lastlogin, signature, usertype, postnum, gp, score1, score2, score3, issign, gold, silver, bronze
//	FROM zf_reply a, zf_user b
//	WHERE a.authorid = b.id
//    AND tid = {$gTid}
//	ORDER BY a.id $order
//	LIMIT {$startRow_getReply}, {$maxRows_getReply}";
    //SELECT score_trade, is_rbenabled, comment, a.id as id, fid, timestamp,price, modrecord, content, picurl, datetime, ip, authorid, isfirstpost, praise, username,alias, gender, pic, email, url, lastlogin, signature, usertype, postnum, gp, score1, score2, score3, issign, gold, silver, bronze FROM zf_reply a, zf_user b WHERE a.authorid = b.id AND tid = 333029 ORDER BY a.id ASC LIMIT 0, 30
    screenMessage("錯誤", '回覆或作者可能已被刪除, 請回主題頁查看', "/thread.php?tid=$gTid");
}
$row_getReply = $getReply[0];

// die($row_getReply['authorid']."X");

//$authorLatest = dbAr("SELECT * FROM zf_contentpages WHERE authorid = {$row_getReply['authorid']} ORDER BY id DESC LIMIT 5");
$queryString_getReply = qryStrE("page", $_SERVER['QUERY_STRING']);

$title = $row_getThread['title'];
$description = str_replace("\n", "", mb_substr($row_getReply['content'], 0, 200, "utf8")) . "...";
$keywords = "$title, " . $boardInfo['name'] . ", RealForum";
$htmltitle = "$title - " . $boardInfo['name'];
$noguest = ($boardInfo['allowguest'] == 0) ? true : false;
$is_closed = ($row_getThread['is_closed'] == 1) ? true : false;

$able_to_reply = !$is_closed && (!$noguest || $isLog) && !$is_banned;



if(in_array($boardInfo['is_private'],["1","2"]) && $gUserGroup < 8){
	
	if(trim($boardInfo['private_member']) != "*"){
		
		$private_members = explode(",",$boardInfo['private_member']);
		
		if(in_array($gId,$private_members)){
			
		}else{
			screenMessage("Private Board","Specified members only");
		}
		
	}else{
		
		if(!$isLog ){
			screenMessage("Private Board","Specified members only");
		}
		
	}
}








preg_match('/\[img\](.*?)\[\/img\]/i', $row_getReply['content'], $ogImages);
$ogImage = str_replace(array("[img]", "[/img]"), "", $ogImages[0]);

$isReplied = (dbRs("SELECT count(*) FROM zf_reply WHERE tid = {$gTid} AND authorid = {$gId}") > 0 && $isLog);

$secAdv = cacheGet("RF_AD_2");

$isLiked = ($_COOKIE[$gTid] == $gTid * 2) ? true : false;

$tmpIntro = mb_substr(str_replace(array("\n", "\r"), "", $row_getReply['content']), 0, 100, 'utf8');
$description = "{$row_getThread['title']},$tmpIntro,論壇, zkiz, realforum";

	$stock_code = dbRs("SELECT tag FROM zf_pages_tracing where tid = $gTid");
	if($stock_code){
		$news_id_arr = getEntryByTag($stock_code,3,8);
		if($news_id_arr){
			$news_ids = implode(",",$news_id_arr);
			$news_subc = "publicpost_id IN ($news_ids) ";
			//echo "SELECT * FROM `stock_publicpost` WHERE ($news_subc) ORDER BY publicpost_id DESC LIMIT 8";
			$getNewNews = dbAr("SELECT * FROM `stock_publicpost` WHERE ($news_subc) ORDER BY publicpost_id DESC LIMIT 8",1);
		}
	}


//$redis->hIncrBy('THREAD_HIT_COUNT_WEEKLY', $gTid, 1);
//$redis->hIncrBy('THREAD_HIT_COUNT_DAILY', $gTid, 1);
if($_SERVER["HTTP_X_PJAX"]){
    if($my['notification']){
        $htmltitle = "({$my['notification']})".$htmltitle;
    }
    echo "<title>{$htmltitle}</title>";include(template("thread"));
}else{

    include(template("header"));
    include(template("thread"));
    include(template("footer"));

}

/*
if ($row_getThread['special'] == 4) {
    include(template("wiki"));
} else {

}

*/
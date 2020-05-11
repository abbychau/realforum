<?php
include_once(dirname(__FILE__)."/../../lib/common_init.php");

//vars
$zkizblog = $conn;
//$mygooglekeyword = getSearchEngineQuery();
$default_types = array("原創","轉貼","分享","貼圖","閒聊","大發現","狂賀","下載",date("n月j日"));
$g_domain = "http://realforum.zkiz.com";
$g_low_post_captcha = 10;

if($_GET['app'] == "1" || $_COOKIE['is_app'] == "1"){
	setcookie("is_app", "1", time()+3600*24*365);
	$isApp = true;
}else{
	$isApp = false;
}

//if($gUsername!="abbychau"){die("under maintainance, check back in 30 mins");}

if(!defined('LITE_HEADER')){
	$hotZone = cacheGet("RF_HOT_ZONE");
	$getNewTopic = cacheGet("RF_NEW_THREADS");//cron_15min.php
	$recentTags = dbAr("SELECT tag FROM zm_tags ORDER BY timestamp DESC LIMIT 15", 60);
	//$getNewTopic = dbAr("SELECT * FROM zf_contenttype WHERE cate <> 6 ORDER BY `datetime` DESC LIMIT 10",60);
}
/*
	$getNew = $getForums;
	usort($getNew,"compareDatetime");
	array_splice($getNew, 10);
*/
$_time = time();
$ip = getIP();
if(!$isLog){$gUsername=$ip;}
//dbQuery("INSERT INTO zm_online (zid,username,time,ip)VALUES({$gId},'{$gUsername}', {$_time}, '{$ip}') ON DUPLICATE KEY UPDATE time={$_time}, ip = '{$ip}'",60*4);

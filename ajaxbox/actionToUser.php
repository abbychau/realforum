<?php
	define('LITE_HEADER',true);
require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');

if(!$isLog){die("Please Login First");}

if(isset($_POST['zid']) && $_POST['action']=='blockUser'){
	$targetZid = intval($_POST['zid']);
	dbQuery("INSERT IGNORE INTO zf_relation SET source_zid = {$gId}, target_zid = {$targetZid}, relation_type = 1");
	echo "1";
	exit;
}

if(isset($_POST['zid']) && $_POST['action']=='unblockUser'){
	$targetZid = intval($_POST['zid']);
	dbQuery("DELETE FROM zf_relation WHERE source_zid = {$gId} AND target_zid = {$targetZid} AND relation_type = 1");
	echo "1";
	exit;
}

if(isset($_POST['tid']) && $_POST['action'] == 'toggleNotification'){
	$targetTid = intval($_POST['tid']);
	$isBannedNotify = dbRs("SELECT count(1) FROM zf_relation WHERE source_zid = {$gId} AND target_zid = {$targetTid} AND relation_type = 3");
	if($isBannedNotify >= 1){
		dbQuery("DELETE FROM zf_relation WHERE source_zid = {$gId} AND target_zid = {$targetTid} AND relation_type = 3");
		echo "1";
		exit;
	}else{
		dbQuery("INSERT INTO zf_relation SET source_zid = {$gId}, target_zid = {$targetTid}, relation_type = 3");
		echo "2";
		exit;
	}
}
if(isset($_POST['tid']) && $_POST['action'] == 'turnOnNotification'){
	$targetTid = intval($_POST['tid']);
	dbQuery("INSERT IGNORE INTO zf_relation SET source_zid = {$gId}, target_zid = {$targetTid}, relation_type = 4");
	echo "1";
	exit;
}
if(isset($_POST['tid']) && $_POST['action'] == 'turnOffNotification'){
	$targetTid = intval($_POST['tid']);
	dbQuery("DELETE FROM zf_relation WHERE source_zid = {$gId} AND target_zid = {$targetTid} AND relation_type = 4");
	dbQuery("INSERT IGNORE INTO zf_relation SET source_zid = {$gId}, target_zid = {$targetTid}, relation_type = 3");
	echo "1";
	exit;
}

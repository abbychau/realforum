<?php 
require_once('Connections/zkizblog.php'); 
include_once('include/common.inc.php');
require_once('include/bbcode.php');
$bbcode = new bbcode();
$pay_per_pm = 1;

if($isLog != true){
	screenMessage("請先登入","登入後方可使用短訊息系統","http://members.zkiz.com/login.php");
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {

	$message = safe(trim($_POST['content']));//message
	$title = safe($_POST['title']); //title
	if($my['score1']<=0){
		screenMessage("金錢不足", "你的金錢不夠，每封PM 要消費1金錢");
	}
	if(stristr($_POST['to_id'],",")){
		$zids = explode(",",safe($_POST['to_id']));
		
		$amount = sizeof($zids) * $pay_per_pm;
		useMoney($amount,$gId);
		
		foreach($zids as $rid){
			$rid = trim($rid);
			if($rid != ""){
				dbQuery("INSERT into zf_pm SET from_id = $gId, to_id = $rid, title = '$title' ,message = '$message'");
			}
		}
		
	}else{
		$rid = safe($_POST['to_id']);
		useMoney($pay_per_pm,$gId);
		dbQuery("INSERT into zf_pm SET from_id = $gId, to_id = $rid, title = '$title' ,message = '$message'");
	}

	
	if(dbRs("SELECT pm2email FROM zf_user WHERE id = $rid") == 1){
		$receiveremail = dbRs("SELECT email FROM zf_user WHERE id = $rid");
		mail($receiveremail,"你在RealForum 收到短訊息了($title)",$message);
	}
	
}

if($_GET['action'] == "sent"){
$query_getType = "SELECT a.id, b.username as ufrom, b.id as user_id, message, title, timestamp, isread, from_id 
FROM zf_pm a, zf_user b 
WHERE b.id = a.to_id 
AND a.from_id = $gId 
AND del_sender = 0
ORDER BY timestamp DESC LIMIT 50";
$h4title = "寄件箱";
$actsent = true;
}else{
$query_getType = "SELECT a.id, b.username as ufrom, b.id as user_id, message, title, timestamp, isread, from_id 
FROM zf_pm a, zf_user b 
WHERE b.id = a.from_id 
AND a.to_id = $gId 
AND del_receiver = 0
ORDER BY timestamp DESC LIMIT 50";
$h4title = "收件箱";
$actsent = false;
}
$mails = dbAr($query_getType);
$totalRows_getType = sizeof($mails);
foreach($mails as $v){
	$contacts[$v['user_id']] = $v['ufrom'];
}
$htmltitle = "PM 系統";

include(template("header"));
include(template("pm"));
include(template("footer"));

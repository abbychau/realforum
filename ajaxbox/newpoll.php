<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');

if(!$isLog){die("Please Login First");}


$tid = intval($_GET['tid']);
if($tid==""){$tid=$_POST['fellowid'];}

//DELL POLL
if ((isset($_POST["realdel"])) && ($_POST["realdel"] == "true")) {

if($gId != dbRs("SELECT authorid FROM zf_contentpages WHERE id = {$tid}") && $gUserGroup < 8){die("Access Denied! pos:3");}else{$isAdmin=true;}

if(!$isAdmin){die("Access Denied! pos:1");}
	mysql_query("DELETE FROM zf_poll WHERE fellowid = {$tid}");
	mysql_query("UPDATE zf_contentpages SET special = 0 where `id` = {$tid}");
	header("Location:/thread.php?tid={$tid}");
}

//NEW POLL
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formnp")) {
//if(!$isAdmin){die("Access Denied2!");}
	$lines = explode("\n", trim($_POST['items']));
	$number_lines = count($lines);
	foreach($lines as $val){
		$items[] = $val;
		$users[] = array("");
	}
	
	$insertSQL = sprintf("INSERT INTO zf_poll (`items`, `option`, `fellowid`, `users`) VALUES (%s, %s, %s, %s)",
		GetSQLValueString(serialize($items), "text"),
		GetSQLValueString($_POST['option'], "int"),
		GetSQLValueString($_POST['fellowid'], "int"),
		GetSQLValueString(serialize($users),"text"));

	mysql_query($insertSQL);
	mysql_query("UPDATE zf_contentpages SET special = 1 where `id` = {$tid}");
	
	header("Location:/thread.php?tid={$tid}");
}

//Vote for Poll
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "poll")) {

	
	
	$mycheck = $_POST['option'];
	if(sizeof($mycheck)==0){die("Please select an option at least.");}

	$getReply = mysql_query("SELECT `option`, users FROM zf_poll WHERE fellowid={$tid}");
	$row_getReply = mysql_fetch_assoc($getReply);
	$string=$row_getReply['users'];
	$users=unserialize($string);
	
	foreach ($users as $v1) {
	foreach($v1 as $v){
		if($v == $gUsername){
			die("You've been a voter.");
		}
	}
	}

	
	
	if($row_getReply['option']==1){
		foreach ($mycheck as $val){$users[$val-1][] = $gUsername;}
	}else{
		$users[$mycheck-1][] = $gUsername;
	}

	mysql_query("UPDATE zf_poll SET users = '".serialize($users)."' WHERE fellowid = {$tid}");
	mysql_free_result($getReply);
	
	header("Location:/thread.php?tid={$tid}");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RealAjax</title>
</head>
<body style="margin:0px;">
<? if($_GET['act']=="add"){ ?>
<form action="<?=$_SERVER['PHP_SELF'];?>" method="post" id="formnp" name="formnp" >
  <label>投票選項(一行一個) :<br />
    <textarea name="items" id="items" cols="45" rows="10"></textarea>
  </label>
  <br />
  <label>
    <input name="option" type="radio" value="0" checked />單選
  </label>
  <label>
    <input type="radio" name="option" value="1" />多選
  </label>
  <input type="hidden" name="MM_insert" value="formnp" /><input type="hidden" name="fellowid" value="<?php echo $_GET['tid'];?>" /><br />
  <input type="submit" name="button" id="button" value="送出" />
</form>
<? } ?>
<? if($_GET['act']=="del"){ ?>
<form name="formdel" method="post" action="ajaxbox/newpoll.php">
	確認要刪除這個貼的投票和投票紀錄嗎?(這個操作不能復原)
    <input type="hidden" value="true" name="realdel" />
    <input type="hidden" value="<?=$_GET['tid'];?>" name="fellowid" />
    <input type="submit" name="button" id="button" value="確認" />
</form>
<? } ?>
</body></html>
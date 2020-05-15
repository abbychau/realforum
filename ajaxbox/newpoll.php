<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');

if(!$isLog){die("Please Login First");}


$tid = intval($_GET['tid']);
if($tid==""){$tid=$_POST['tid'];}

//DELL POLL
if ((isset($_POST["realdel"])) && ($_POST["realdel"] == "true")) {

if($gId != dbRs("SELECT authorid FROM zf_contentpages WHERE id = {$tid}") && $gUserGroup < 8){die("Access Denied! pos:3");}else{$isAdmin=true;}

if(!$isAdmin){die("Access Denied! pos:1");}
	dbQuery("DELETE FROM zf_poll WHERE tid = {$tid}");
	dbQuery("UPDATE zf_contentpages SET special = 0 where `id` = {$tid}");
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
	
	$insertSQL = sprintf("INSERT INTO zf_poll (`items`, `option`, `tid`, `users`) VALUES (%s, %s, %s, %s)",
		GetSQLValueString(serialize($items), "text"),
		GetSQLValueString($_POST['option'], "int"),
		GetSQLValueString($_POST['tid'], "int"),
		GetSQLValueString(serialize($users),"text"));

		dbQuery($insertSQL);
		dbQuery("UPDATE zf_contentpages SET special = 1 where `id` = {$tid}");
	
	header("Location:/thread.php?tid={$tid}");
}

//Vote for Poll
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "poll")) {

	
	
	$mycheck = $_POST['option'];
	if(sizeof($mycheck)==0){die("Please select an option at least.");}

	$row_getReply = dbRow("SELECT `option`, users FROM zf_poll WHERE tid={$tid}");
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

	dbQuery("UPDATE zf_poll SET users = '".serialize($users)."' WHERE tid = {$tid}");
	
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
  <input type="hidden" name="MM_insert" value="formnp" /><input type="hidden" name="tid" value="<?php echo $_GET['tid'];?>" /><br />
  <input type="submit" name="button" id="button" value="送出" />
</form>
<? } ?>
<? if($_GET['act']=="del"){ ?>
<form name="formdel" method="post" action="ajaxbox/newpoll.php">
	確認要刪除這個貼的投票和投票紀錄嗎?(這個操作不能復原)
    <input type="hidden" value="true" name="realdel" />
    <input type="hidden" value="<?=$_GET['tid'];?>" name="tid" />
    <input type="submit" name="button" id="button" value="確認" />
</form>
<? } ?>
</body></html>
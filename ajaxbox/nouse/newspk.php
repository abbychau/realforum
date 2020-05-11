<?php 
require_once('../Connections/zkizblog.php'); 
require_once('../include/common.inc.php');
$colname_getbookmark = "-1";
if ($gId!="") {
  $colname_getbookmark = $gId;
}else{die("要使用Real-Speaker請先登入");}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["type"])) && ($_POST["type"] == "add")) {
  $insertSQL = sprintf("INSERT INTO zf_speaker (ownerid, content, color) VALUES (%s, %s, %s)",
                       GetSQLValueString($gId, "text"),
                       GetSQLValueString($_POST['content'], "text"),
                       GetSQLValueString($_POST['color'], "text"));

  $updateSQL = "update zf_user set score1 = score1 - 2 where id = $gId";

  mysql_select_db($database_zkizblog, $zkizblog);
  $Result1 = mysql_query($insertSQL, $zkizblog) or die("sql1");
  $Result2 = mysql_query($updateSQL, $zkizblog) or die("sql2");
  die("發佈成功!");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<div style="padding:10px">
<h4 style="margin-top:-10px">新增Real-Speaker 廣播</h4>
 
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
訊息: <input type="text" name="content" /><br />
顏色: <select name="color">
  <option value="99ff00">#99ff00</option>
  <option value="ff00ff">#ff00ff</option>
  <option value="33ffff">#33ffff</option>
</select>
<span style="background-color:#99ff00">#99ff00</span>
<span style="background-color:#ff00ff">#ff00ff</span>
<span style="background-color:#33ffff">#33ffff</span><br>
<br>
注意: 發佈廣播會減少1 金錢<br>
<br />
  <input type="submit" name="Submit" value="廣播" />
  <input type="hidden" name="type" value="add" />
  <input type="hidden" name="url" value="<?=$_SERVER['PHP_SELF'];?>" />
</form>
</div></body></html>
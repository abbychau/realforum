<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
require_once('../include/common.inc.php');

$typeid = intval($_GET['typeid']);
if($typeid==""){$typeid = intval($_POST['tid']);}

//authorize
if(modRank($typeid)==0 && $gUserGroup <= 7){die("Access Denied");}


$type_info = dbRow("SELECT * FROM zf_contenttype WHERE id = $typeid");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['tid'])) {
	$updateSQL = sprintf("UPDATE zf_contenttype SET allowguest=%s,is_private=%s,private_member=%s,banned_member=%s WHERE id=%s",
		   GetSQLValueString($_POST["is_guest"], "text"),
		   GetSQLValueString($_POST["is_private"], "text"),
		   GetSQLValueString($_POST["private_member"], "text"),
		   GetSQLValueString($_POST["banned_member"], "text"),
		   GetSQLValueString($_POST['tid'], "int"));
	dbQuery($updateSQL);

	$updateGoTo = "/viewforum.php?fid=$typeid";
	
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	
	header(sprintf("Location: %s", $updateGoTo));
}

?>
<h3>發貼和瀏覽權限</h3>

<hr/>

<form action="<?php echo $editFormAction; ?>"  method="POST">
	
	<h4>容許訪客發貼?</h4>
	<label><input type="radio" name="is_guest" value="1" <?=$type_info['allowguest']=="1"?"checked='checked'":'';?> />是</label>
	<label><input type="radio" name="is_guest" value="0" <?=$type_info['allowguest']=="0"?"checked='checked'":'';?> />否</label><br />
	
	<!--
	<strong>容許瀏覽貼子和貼子列表?</strong>	
	<label><input type="radio" name="is_guest" value="1" <?=$type_info['allowguest']=="1"?"checked='checked'":'';?> />是</label>
	<label><input type="radio" name="is_guest" value="0" <?=$type_info['allowguest']=="0"?"checked='checked'":'';?> />否</label><br />
	-->
<hr />
	<h4>私密模式</h4>
	
	
	<label><input type="radio" name="is_private" value="0" <?=$type_info['is_private']=="0"?"checked='checked'":'';?> />關閉私密模式</label>
	<label><input type="radio" name="is_private" value="1" <?=$type_info['is_private']=="1"?"checked='checked'":'';?> />其他人無法瀏覽帖子</label>
	<label><input type="radio" name="is_private" value="2" <?=$type_info['is_private']=="2"?"checked='checked'":'';?> />其他人無法瀏覽列表和帖子</label>
	<br />
	(在私密模式時,只有指定用戶能瀏覽帖子和帖子列表)
	
	<br /><br />
	
	<strong>容許以下用戶瀏覽:</strong><br />
	用戶ID:<input type="text" name="private_member" value="<?=$type_info['private_member'];?>" />(用,分隔，輸入*準許所有已登入會員)<br />
	
<hr />
	
	
	<h4>禁止發貼群</h4>
	不容許以下用戶發貼:<br />
	用戶ID:<input type="text" name="banned_member" value="<?=$type_info['banned_member'];?>" />(用, 分隔)
<hr />
	
	<input name="tid" type="hidden" value="<?php echo $_GET['typeid']; ?>" />
	<input type="submit" name="button" id="button" value="確定" class='btn btn-primary' />
</form>
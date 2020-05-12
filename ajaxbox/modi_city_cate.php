<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
require_once('../include/common.inc.php');

$typeid = intval($_GET['typeid']);
if($typeid==""){$typeid = intval($_POST['tid']);}

//authorize
if(modRank($typeid)!=1 && $gUserGroup <= 8){die("Access Denied");}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE zf_contenttype SET cate=%s WHERE id=%s",
					GetSQLValueString($_POST['cate'], "text"),
					GetSQLValueString($_POST['tid'], "int"));

	mysql_select_db($database_zkizblog, $zkizblog);
	$Result1 = mysql_query($updateSQL, $zkizblog) or die(mysql_error());

	$updateGoTo = "/viewforum.php?fid=".$_GET['typeid'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	useMoney(30);
	header(sprintf("Location: %s", $updateGoTo));
}

$typeid = isset($_GET['typeid'])?intval($_GET['typeid']):"-1";

$cates = dbAr("SELECT * FROM zf_cate ORDER BY id");
$typeInfo = dbRow("SELECT * FROM zf_contenttype WHERE id = $typeid");
?>
<h4>修改分類</h4>
修改分類功能已經關閉, 如要修改分類, 請以PM 通知"亞貝"或"greatsoup"。
<? if($gUsername == "abbychau" || $gUsername == "greatsoup"){?>
<form action="<?php echo $editFormAction; ?>" name="form1" method="post">
	<select name="cate">
		<?php foreach($cates as $cate){ ?>
		<option value="<?=$cate['id'];?>" <?php if($typeInfo['cate']==$cate['id']){echo "selected='selected'";} ?>><?=$cate['name'];?></option>
		<? }?>
	</select>
	
	<br />
	<input type="submit" name="button" id="button" value="確定" />
	<input name="confirm" type="hidden" value="yo" />
	<input name="tid" type="hidden" value="<?php echo $_GET['typeid']; ?>" />
	<input type="hidden" name="MM_update" value="form1" />
</form>
<? } ?>
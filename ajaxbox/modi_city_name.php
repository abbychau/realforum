<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
	require_once('../include/common.inc.php');
	
	$typeid = mysql_real_escape_string($_GET['typeid']);
	if($typeid==""){$typeid = mysql_real_escape_string($_POST['tid']);}
	
	//authorize
	if(modRank($typeid)==0 && $gUserGroup <= 8){die("Access Denied");}
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		
		$p = array_map('mysql_real_escape_string', $_POST);
		dbQuery("UPDATE zf_contenttype SET name='{$p['intro']}' WHERE id='{$p['tid']}'");
		dbQuery("UPDATE zf_user SET score1=score1-1 WHERE id=$gId");
		header("Location: /viewforum.php?fid=$typeid");
		
	}
	
	$introtxt = dbRs("SELECT name FROM zf_contenttype WHERE id = {$typeid}");
?>

<form action="<?=$_SERVER['PHP_SELF']; ?>" name="form1" method="POST">
    <h4>修改版塊名</h4>
	<input name="intro" type="text" id="intro" value="<?=$introtxt; ?>" size="24">
	<br />
	<input type="submit" name="button" id="button" value="確定">
	<br />
	<br />
	注意:修改版名會扣除你身上10金錢 
	<input name="confirm" type="hidden" value="yo">
	<input name="tid" type="hidden" value="<?php echo $_GET['typeid']; ?>" />
	<input type="hidden" name="MM_update" value="form1">
</form>

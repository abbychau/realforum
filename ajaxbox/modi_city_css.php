<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
require_once('../include/common.inc.php');

$fid = intval($_REQUEST['fid']);

//authorize
if(modRank($fid)==0 && $gUserGroup <= 8){die("Access Denied");}

if (isset($_POST["fid"])) {

    dbQuery("UPDATE zf_contenttype SET css=? WHERE id=?",[$p['css'],$p['fid']]);
    header("Location: /viewforum.php?fid=$fid");

}

$css = dbRs("SELECT css FROM zf_contenttype WHERE id = {$fid}");
?>
<h4>CSS</h4>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="POST">
    
    <textarea style='width:500px;height:300px' name="css"><?=$css; ?></textarea><br />
    <input type="submit" name="button" value="確定" />
    <input name="fid" type="hidden" value="<?=$fid ?>" />
</form>

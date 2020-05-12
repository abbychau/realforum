<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
	require_once('../include/common.inc.php');
	
	$fid = intval($_REQUEST['fid']);
	
	//authorize
	if(modRank($fid)==0 && $gUserGroup <= 8){die("Access Denied");}
	
	if (isset($_POST["toZid"]) && is_numeric($_POST['toZid'])) {
		if (isset($_POST["fid"]) && is_numeric($_POST['fid'])){
			if(dbRs("SELECT ownerid FROM zf_admin WHERE fid = '{$_POST['fid']}' AND ownerid='{$gId}' AND rank = 1")){
				dbQuery("UPDATE zf_admin SET rank='1' WHERE fid = '{$_POST['fid']}' AND ownerid='{$_POST['toZid']}'");
				dbQuery("UPDATE zf_admin SET rank='2' WHERE fid = '{$_POST['fid']}' AND ownerid='{$gId}'");
				screenMessage("退位成功","你已由版主變為副版主","/viewforum.php?fid=$fid");
			}
		}
	}
	?>
	<script type="text/javascript">
function toZid(name){
$.get('/ajaxdata.php',{id:name, type: '2'},
	function(data){
		document.getElementById('to_id').value = data;
		document.getElementById('to_id2').value = data;
	});
}
</script>

ZID轉換:<input name="to_id" type="text" id="to_id" size="10" maxlength="30" value="" /><input name="" type="button" value="名字轉為ZID" onclick="toZid(document.getElementById('to_id').value);" />

	<form action="<?=$_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return confirm('讓位後將失去城主資格, 確定要讓位嗎?');">
		<h4>退位</h4>
		退位給: <input id='to_id2' name="toZid" pattern="\d*" />(輸入ZID, eg. 1)
		<br />
		<input type="submit" name="button" value="確定" />
		<input name="fid" type="hidden" value="<?=$fid ?>" />
	</form>

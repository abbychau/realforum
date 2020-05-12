<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
	require_once('../include/common.inc.php'); 
	
	$tid = intval($_GET['tid']);
	$id = intval($_GET['id']);
	if($id==""){$id = intval($_POST['id']);}
	if(!isset($_GET['tid'])){$tid = intval($_POST['tid']);}
	//authorize
	$fid = dbRs("SELECT fid FROM zf_reply WHERE fellowid = {$tid}");
	if(modRank($fid)==0 && $gUserGroup <= 7){die("Access Denied Required=7 Your Rank=".modRank($fid));}
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
		$pid = intval($_POST['id']);
		$tid = intval($_POST['tid']);
		$reason = safe($_POST['reason']);
		
		$reply_content = dbRow("SELECT * FROM zf_reply WHERE id = $pid");
		$original = dbRow("SELECT id, username FROM zf_user WHERE id = {$reply_content['authorid']}");
		
		$content = safe($reply_content['content']);
		//die("INSERT INTO zm_archive SET title = 'RealForum 回貼刪除 - PID:$pid TID:$tid', content='$content', type=1");
		$insertID=dbQuery("INSERT INTO zm_archive SET title = 'RealForum 回貼刪除 - PID:$pid TID:$tid', content='$content', type=1");
		
		$new_content = '[member]'.$original['username'].'[/member]所發的貼子已被[member]'.$gUsername."[/member](管理組:$gUserGroup) 刪除了。(原因:$reason) 存檔ID:[archive]{$insertID}[/archive]";
		
		dbQuery("UPDATE zf_reply SET modrecord='', content = '{$new_content}', picurl = '', authorid = '-101' WHERE id=$pid");
		die("<strong>己成功刪除!</strong>");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Chatbox</title>
	</head>
	<body style="margin:0px; padding:0px; font-size:12px;">
		<?if($_GET['floor']!='1'){?>
			<fieldset><legend>刪除帖子id <?=$id; ?></legend>
				<form name="form2" method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
					<label>
						<input type="submit" name="button" id="button" value="刪除">
					</label>
					<input type="text" name="reason" value="廣告" onclick="this.value=''" />
					<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
					<input name="tid" type="hidden" value="<?php echo $_GET['tid']; ?>" />
					<input type="hidden" name="MM_update" value="form2" />
				</form>
			</fieldset>
		<?}?>
		
	</body>
</html>
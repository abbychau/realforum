<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
	require_once('../include/common.inc.php');
	
	$tid = safe($_GET['tid']);
	if($tid==""){$tid = safe($_POST['tid']);}
	
	//authorization
	$fid=dbRs("SELECT type FROM zf_contentpages WHERE id = {$tid}");
	//die(modRank($fid));
	if(isset($_POST['adminact'])){
		if(modRank($fid) == 0 && $gUserGroup < 7  && $_POST['adminact']!=7){die("Access Denied");}
	}
	
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	
	
	if ((isset($_POST["confirm"])) && ($_POST["confirm"] == "true")) {
		
		$tid = safe($_POST['tid']);
		$tofid = safe($_POST['tofid']);
		$sctofid = safe($_POST['sctofid']);
		$ausername = dbRs("SELECT authorid FROM zf_contentpages WHERE id = {$tid}");
		
		$title = dbRs("SELECT title FROM zf_contentpages WHERE id=$tid");
		switch($_POST['adminact']){
			case 1;
			dbQuery("UPDATE zf_contentpages SET isshow = 0 WHERE id=$tid");
			//dbQuery("DELETE FROM zf_reply WHERE fellowid=$tid");
			$stract = "刪除";
			break;
			case 2;
			dbQuery("UPDATE zf_contentpages SET isshow=2 WHERE id=$tid");
			$stract = "置頂";
			break;
			case 3:
			dbQuery("UPDATE zf_contentpages SET isshow=1 WHERE id=$tid");
			$stract = "解除置頂";
			break;
			case 4:
			dbQuery("UPDATE zf_contentpages SET isdigest=1 WHERE id=$tid");
			$stract = "精華";
			break;
			case 5:
			dbQuery("UPDATE zf_contentpages SET isdigest=0 WHERE id=$tid");
			$stract = "解除精華";
			break;
			case 6:
			dbQuery("UPDATE `zf_contentpages` SET TYPE =$tofid WHERE id =$tid");
			dbQuery("UPDATE `zf_reply` SET fid =$tofid WHERE fellowid =$tid");
			$stract = "移動";
			break;
			case 7:
			$threadInfo = dbRow("SELECT title FROM zf_contentpages WHERE id = $tid");
			if($threadInfo['type'] == $sctofid){
				screenMessage("錯誤","不能在同一版塊中建立捷徑");
			}
			dbQuery("INSERT INTO `zf_contentpages` (`id` ,`title`  ,`views` ,`isshow` ,`isdigest` ,`special` ,`type` ,`commentnum` ,`tpraise` ,`lastid` ,`authorid` ,`lastdatetime`) VALUES(NULL,'{$threadInfo['title']}','','1', '0','-{$tid}',  '$sctofid','0','0','0','$gId', CURRENT_TIMESTAMP)");
			$stract = "創建捷徑";
			break;
			case 9:
			dbQuery("UPDATE zf_contentpages SET is_closed = 1 WHERE id = $tid");
			$stract = "關閉";
			break;
			case 10:
			dbQuery("UPDATE zf_contentpages SET is_closed = 0 WHERE id = $tid");
			$stract = "開放";
			break;
		}
		/*
		dbQuery("UPDATE zf_contenttype a SET
		lasttitle=(SELECT title FROM zf_contentpages b WHERE a.id = b.type ORDER BY lastdatetime DESC LIMIT 1), 
		lastusername=(SELECT username FROM zf_contentpages c, zf_user d WHERE c.lastid = d.id AND c.type=a.id ORDER BY lastdatetime DESC LIMIT 1), 
		datetime=(SELECT lastdatetime FROM zf_contentpages b WHERE a.id = b.type ORDER BY lastdatetime DESC LIMIT 1), 
		lastaid=(SELECT lastid FROM zf_contentpages b WHERE a.id = b.type ORDER BY lastdatetime DESC LIMIT 1)");
		*/
		$pmMSG = safe("<b>{$gUsername}</b>剛把你的主題:<b>{$title}</b>{$stract}了");
		
		sendNotification($ausername,$pmMSG,"{$g_domain}/thread.php?tid=$tid");
		
		dbQuery("INSERT INTO `zf_transaction` VALUES ($tid,  '$stract',  '$gUsername', CURRENT_TIMESTAMP)");
		
		//dbQuery("INSERT into zf_pm SET from_id = $gId, to_id = $aid, title = '$pmTitle' ,message = '$pmMSG'");
		//$receiveremail = dbRs("SELECT email FROM zf_user WHERE id = $aid");
		//mail($receiveremail,"你在RealForum 收到短訊息了($pmTitle)",$pmMSG);
		
		if($tid != "" && $_POST['adminact']!=6){
			header("Location:/thread.php?tid={$tid}");
		}
		
		header("Location:/viewforum.php?fid=$fid");
	}
	
	$forumArr = dbAr("SELECT id, name FROM zf_contenttype ORDER BY id");
	$boardopt = boardSelect(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title></title>
	</head>
	
	<body style="margin:0px;">
		<form style="line-height:170%" class='dtform' name="main" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="if(getElementById('tofid').value<1){return false;}">
			<div style='padding:5px 0'>
			<?if(modRank($fid) > 0 || $gUserGroup >= 8){?>
				<input type="radio" name="adminact" value="1" />刪除<br />
				<input type="radio" name="adminact" value="2" />置頂
				<input type="radio" name="adminact" value="3" />解除置頂<br />
				<input type="radio" name="adminact" value="4" />精華
				<input type="radio" name="adminact" value="5" />解除精華<br />
				<input type="radio" name="adminact" value="9" />關閉(不能再回覆)
				<input type="radio" name="adminact" value="10" />開放(可回覆)<br />
				<input type="radio" name="adminact" value="6" />移動主題
				<select name="tofid" id="tofid">
					<?=$boardopt;?>
				</select><br />
			<?}?>
			<input type="radio" name="adminact" value="7" />在
			<select name="sctofid" id="sctofid">
				<?=$boardopt;?>
			</select>建立捷徑<br />
			
			<input name="tid" type="hidden" value="<?php echo $_GET['tid']; ?>" />
			<input name="confirm" type="hidden" value="true" />
			</div>
			<input class='btn btn-primary'  type="submit" name="button" class="button" value="確定">
		</form>
		<br />
		<?if(modRank($fid) > 0 || $gUserGroup >= 8){?>
			<a class='btn btn-default' onclick="dialog('ajaxbox/modititle.php?tid=<?=$tid; ?>&admin=true');">修改標題</a>
			<a class='btn btn-default' href="/split_thread.php?tid=<?=$tid; ?>">分割主題</a>
		<?}?>
	</body>
</html>			
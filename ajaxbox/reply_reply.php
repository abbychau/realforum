<?php 
	define('LITE_HEADER',true);
require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');
if(!$isLog){die("請先登入");}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	$postTargetID = intval($_POST['target']);
	$postID = intval($_POST['id']);
	$postTID =  intval($_POST['tid']);
	$says = htmlentities($_POST['says']);
	$pmContent = "<b>{$gUsername}</b>給你留言”{$says}”! TID:{$postTID}";
	$replyInfo = dbRow("SELECT fid, comment FROM zf_reply WHERE id = ?",$postID);
	
	$bannedUser = dbRs("SELECT banned_member FROM zf_contenttype WHERE id = {$replyInfo['fid']}");
	if(stristr($bannedUser,",")){
		$bannedUsers = explode(",",$bannedUser);
		$isBanned = in_array($gId,$bannedUsers);
	}else{
		$isBanned = $gId==$bannedUser;
	}
	if($isBanned){die("你在本區的黑名單中");}
	
	$comment = $replyInfo['comment'];
	$comments = unserialize($comment);
	$comments[] = array(
		"zid"		=>$gId,
		"username"	=>$gUsername,
		"content"	=>str_replace('\"',"",$_POST['says']), 
		"timestamp"	=>time()
	);
	$comment = serialize($comments);
	dbQuery("UPDATE zf_reply SET comment = ? WHERE id= ?",[$comment,$postID]);
	//dbQuery("UPDATE zf_user SET score1 = score1 - $amount WHERE id={$gId}");
		
	sendNotification(
		dbRs("SELECT username FROM zf_user WHERE id = $postTargetID"),
		$pmContent,
		"{$g_domain}/thread.php?tid={$postTID}"
	);
	
	header("Location:/thread.php?tid={$_POST['tid']}&page={$_POST['page']}");
}

?>

<form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
	<input type="hidden" name="amount" id="amount" value="5" />
<input type="text" name="says" style="width:280px;border:none;border-bottom:1px solid #CCC" maxlength="50" />
	<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
	<input name="tid" type="hidden" value="<?php echo $_GET['tid']; ?>" />
	<input name="page" type="hidden" value="<?php echo $_GET['page']; ?>" />
	
	<input name="target" type="hidden" value="<?php echo $_GET['target']; ?>" />
	<input type="hidden" name="MM_update" value="form2" />
	<input type="submit" class='button' name="button" value="留言">

</form>
	<script type="text/javascript">

		$(".button").button();
	</script>

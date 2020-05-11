<?php 
	
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
	
	$tid = intval($_GET['tid']);
	$id = intval($_GET['id']);
	if($id==""){$id = intval($_POST['id']);}
	
	//authorization
	if(dbRs("SELECT authorid FROM zf_reply WHERE id = {$id}") != $gId && $gUserGroup < 8){die("Access Denied!");}
	
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		$updateSQL = sprintf("UPDATE zf_reply SET content=%s, picurl=%s,price=%s, timestamp=CURRENT_TIMESTAMP WHERE id=%s",
		GetSQLValueString($_POST['content'], "text"),
		GetSQLValueString($_POST['picurl'], "text"),
		GetSQLValueString($_POST['price'], "int"),
		GetSQLValueString($_POST['id'], "int"));
		
		$Result1 = dbQuery($updateSQL);
		header("Location:/thread.php?tid={$_POST['tid']}&page={$_POST['page']}"); 
	}
	
	$row_getContent = dbRow("SELECT * FROM zf_reply WHERE id = {$id}");
	
?>

<script type="text/javascript">
	//<![CDATA[
	function youtubeIDextract(url){var youtube_id; youtube_id = url.replace(/^[^v]+v.(.{11}).*/,"$1"); return youtube_id;}
	function checknull(){
		if($.trim(document.getElementById('modcontent<?php echo $_GET['tid']; ?>').value) == ""){alert('請輸入內容');return false;}
	}
	//]]>
</script>

<form name="form1" method="post" action="<?php echo $editFormAction; ?>" onsubmit="return checknull();">
	<textarea name="content" id="modcontent<?php echo $_GET['tid']; ?>" class='form-control' style="height:300px"><?php echo $row_getContent['content']; ?></textarea>
	<br />
	<div class="input-group input-group-sm">
		<input name="picurl" class='form-control' type="text" id="picurl" value="<?php echo $row_getContent['picurl']; ?>" placeholder='圖片/Flash/PDF 連結' size="60" />
		<div class="input-group-btn">
			<button type="submit" class="btn btn-default" onclick="document.form1.picurl.value='http://www.youtube.com/v/'+youtubeIDextract(document.form1.picurl.value);return false;;">Youtube 網址轉換</button>
		</div>
	</div>
	<br />
	<div class="input-group input-group-sm">
		售價(在[sell]及[/sell]中的內容會在付費後展示):<input name="price" class='form-control' type="text" value="<?php echo $row_getContent['price']; ?>" size="10" />
	</div>
	
	<hr />
	
	
	<input class="btn btn-primary" type="submit" value="確定修改" />
	<button class="btn btn-default btn-sm" onclick="window.open('/xheditor.php','myWindow','status=0,width=800,height=630');return false;">外部編輯工具</button>
	<input name="confirm" type="hidden" value="yo" />
	<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>" />
	<input name="tid" type="hidden" value="<?php echo $_GET['tid']; ?>" />
	<input name="page" type="hidden" value="<?php echo $_GET['page']; ?>" />
	<input type="hidden" name="MM_update" value="form1">
</form>
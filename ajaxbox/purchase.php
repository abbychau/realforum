<?php 
	define('LITE_HEADER',true);
require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');
$rate = 0.8;

$grid = $_GET['id']==""?intval($_POST['id']):intval($_GET['id']);


if(!$isLog){die("請先登入");}
if($_GET['target']==$gId){die("不可以購買自己的帖子");}
if(dbRs("SELECT count(*) FROM zf_purchase WHERE rid={$grid} AND zid={$gId}")>0){
die("在之前你已經購買此帖子。");
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	
	
	$money = dbRs("SELECT score1 FROM zf_user WHERE id = $gId");
	$price = dbRs("SELECT price FROM zf_reply WHERE id = $grid");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
if($money<$price){die("Not Enough Money");}

	$postTargetID = intval($_POST['target']);
	$postTID =  intval($_POST['tid']);
	
	
	$pmTitle = "[系統]你帖子被購買了";
	$total = $price * $rate;
	
	$modrecord = "{$gUsername}用＄{$price}購買了!";

	dbQuery("UPDATE zf_reply SET revenue = revenue + {$price}, modrecord = CONCAT_WS(' | ', modrecord,'{$modrecord}') WHERE id={$grid}");
	
	dbQuery("UPDATE zf_user SET score1 = score1 - $price WHERE id={$gId}");
	dbQuery("UPDATE zf_user SET score1 = score1 + $total WHERE id={$postTargetID}");
	//dbQuery("INSERT into zf_pm SET from_id = {$gId}, to_id = {$postTargetID}, title = '{$pmTitle}', message = '{$pmContent}'");
	
	
	$pmContent = "<b>{$gUsername}</b>支付<b>{$price}</b>購買了你的帖子(TID:{$postTID})。";

	sendNotification($postTargetID,$pmContent,"{$g_domain}/thread.php?tid={$postTID}");

	
	
	dbQuery("INSERT into zf_purchase SET rid = {$grid}, zid = {$gId}, spent = {$price}");
	
	
	if($_POST['tid']!=""){
		header("Location:/thread.php?tid=".$_POST['tid']); 
	}else{
		header("Location:/index.php"); 
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RealAjax</title>

</head>
<body style="margin:0px;">
文章號:<?=$grid; ?> 售價: <?=$price;?>。<br />
你現有$<?=$money;?>，<?if($money<$price){echo "錢不夠。";}else{?>你確定要購買這個帖子嗎？
<br />
<form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
	<input name="id" type="hidden" value="<?=$grid; ?>">
	<input name="tid" type="hidden" value="<?php echo $_GET['tid']; ?>" />
	<input type="hidden" name="MM_update" value="form2" />
	<input name="target" type="hidden" value="<?php echo $_GET['target']; ?>" />
<div class="demo">
	<input type="submit" name="button" value="購買">
</div>
</form>
	<script type="text/javascript">
		$("input:submit, input:button", ".demo").button();
	</script>
<?}?>
</body>
</html>

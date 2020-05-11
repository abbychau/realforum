<?php 
require_once('Connections/zkizblog.php'); 
require('include/common.inc.php');
$htmltitle="合併城市";
if(!$isLog){
	die("Please Login First");
}
$cost = 10;

if(isset($_POST['city_from']) && isset($_POST['city_to']) && $_POST['city_from'] != $_POST['city_to']){
	
	$city_to = safe($_POST['city_to']);
	$city_from = safe($_POST['city_from']);

	$city_to_owner = dbRs("SELECT ownerid FROM zf_admin WHERE rank = 1 AND fid = $city_to");
	$city_from_owner = dbRs("SELECT ownerid FROM zf_admin WHERE rank = 1 AND fid = $city_from");
	
	if($city_to_owner != $city_from_owner || $city_to_owner != $gId){
		die("What are you doing here!?");
	}
	
	useMoney($cost,$gId);
	dbQuery("UPDATE `zf_reply` SET fid = '$city_to' WHERE fid = '$city_from'");
	dbQuery("UPDATE `zf_contentpages` SET type = '$city_to' WHERE type = '$city_from'");
	dbQuery("DELETE FROM `zf_contenttype` WHERE id = '$city_from'");
	dbQuery("DELETE FROM `zf_admin` WHERE fid = '$city_from'");
	
	header("location: viewforum.php?fid={$city_to}");
	exit;
}


$cities = dbAr("SELECT id, name FROM zf_contenttype a, zf_admin b where a.id = b.fid AND ownerid = {$gId} AND b.rank=1");

include_once("templatecode/header.php");
?>

<h1>合併城市</h1>

<div class='panel panel-default' style='padding:2em'>
<form id="form1" name="form1" method="POST" onsubmit="return confirm('合併後將不能還原。你確定嗎?'); return false; }">
由副城:
<select name='city_from'>
	<?php foreach ($cities as $row_getCities){ ?>
	<option value="<?=$row_getCities['id'];?>"><?php echo $row_getCities['name']; ?>(fid:<?=$row_getCities['id'];?>)</option>
	<?php }?>
</select>

到主城:
<select name='city_to'>
	<?php foreach ($cities as $row_getCities){ ?>
	<option value="<?=$row_getCities['id'];?>"><?php echo $row_getCities['name']; ?>(fid:<?=$row_getCities['id'];?>)</option>
	<?php }?>
</select>
<br />
<input type="submit" value="合併" class="button" />

  <br />
  注意：<br />
- 合併後將會扣除$<?=$cost;?>，不足<?=$cost;?>金錢的不能使用本功能。(你需要支付$<?=$cost;?>)<br />
- 申請後會以主城的所以設定為準, 包括版主、版規等等。<br />
- 你必需為兩城的城主方為進行此操作, 否則請主城為副城的城主各自修書一封到"亞貝"的PM信箱申請。<br />
- 申請後會自動跳到合併後的主城, 請進行必要的設定。
  <br />

</form>
</div>
<?php
include_once("templatecode/footer.php");
?>
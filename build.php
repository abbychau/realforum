<?php 
require_once('Connections/zkizblog.php'); 
require('include/common.inc.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if($_GET['kw']==""){screenMessage("錯誤","請輸入板名");}
if(!$isLog){screenMessage("錯誤","請先登入");}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

	dbQuery("INSERT INTO zf_contenttype (name) VALUES (?)",[$_POST['name']]);
	$lastid = mysql_insert_id();
	dbQuery("UPDATE zf_user SET score1 = score1 - 50 where id = {$gId}");
	dbQuery("INSERT INTO `zf_admin` (`fid` ,`ownerid`)VALUES ('{$lastid}', '{$gId}')");

        cacheSet("RF_FORUM_ADMIN_{$lastid}",dbAr("SELECT ownerid, username, rank FROM `zf_admin` a, zf_user b WHERE a.ownerid = b.id AND fid = {$lastid}"));

	
	header("Location:viewforum.php?fid=".$lastid);
}


$UserScore = dbRs("SELECT score1 FROM zf_user WHERE id = {$gId}");

$htmltitle = "建立新板";
?>
<?php include_once('templatecode/header.php');?> 
<h1>建立<?php echo $_GET['kw']; ?>板</h1>
<div class="well">

	
	<p>你已經來到 <?php echo $_GET['kw']; ?>板，這裡還沒有被創建。</p>
	
	你現有金錢<?=$UserScore; ?>。<br />
	
	<?php if($UserScore>49){ ?>
	<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
		<input type="submit" class='btn btn-primary' name="button" value="按我建立新的<?php echo $_GET['kw']; ?>板" />
		<input name="name" type="hidden" value="<?php echo $_GET['kw']; ?>" />
		<input type="hidden" name="MM_insert" value="form1" />
	</form>
	
	<br />
	
	名稱: <?php echo $_GET['kw']; ?>板<br />
	成立後暫定板主: <?php echo $gUsername; ?><br />
	成立後暫定板主ID: <?php echo $gId; ?><br />
	<?php }else{ ?>
		對不起, 你暫時不能創建新板<br />
		如要創建新板, 必須擁有50以上的金錢啊~
	<?php } ?>
	<br /><br />
	<strong>注意: </strong><br />
	1. 如系統發覺建立的版塊是垃圾版塊，版塊會被自動刪除。<br />
	2. 創建後會成為暫代板主。<br />
	3. Real Forum 管理人員有權在任何時間修改板主人選和名單。<br />
	4. 創建新板會扣減50金錢
</div>


<h2>開其他新區</h2>
<div class='' style='max-width:320px'>
		<form action="search.php" method="get" name="hdform2">
		<div class="input-group">
			<input name="kw" type="text" placeholder="輸入區名"  class="form-control" />
			<div class="input-group-btn">
				
				<input type="submit" value="確定" class="btn btn-default" />
			</div>
		</div>
	</form>
</div>
<hr />
<?php 
include_once('templatecode/footer.php');
?>

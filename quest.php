<?php 
require('Connections/zkizblog.php'); 
require('include/common.inc.php');
function questQuery($sql,$isRs=0){
	global $gId, $pId, $gUsername;
	$from = array('{userid}','{typeid}','{username}');
	$to = array($gId, $pId, $gUsername);
	$tmp = str_replace($from,$to,$sql);
	if($isRs==0){
		dbQuery($tmp);
		return 0;
	}else{
		return dbRs($tmp);
	}
}

$action = trim($_GET['action']);
$pId = intval($_GET['id']);

if($isLog==false){die("Please Login First!");}
$htmltitle = "任務"; 
$nosidebar = true;


//GET user info
$row_getUserInfo = dbRow("SELECT * FROM zf_user WHERE id = {$gId}");


if($action==""){
	$quests = dbAr("SELECT * FROM zf_quest");
}

if($action=="view"){
	$row = dbRow("SELECT * FROM zf_quest WHERE id = {$pId}");
	
	$meet1 = questQuery($row['firstcondition'],1);
	
	$record = dbRow("SELECT * FROM zf_quest_record WHERE questid = {$pId} AND zid = {$gId} AND finishtime = '00000000000000'");
	$isReceived = $record['id']==""?0:1;
	//die($isReceived);
}

if($action=="accept"){
	$row = dbRow("SELECT * FROM zf_quest WHERE id = {$pId}");

	$meet1 = questQuery($row['firstcondition'],1);
	$isReceived = dbRs("SELECT count(*) FROM zf_quest_record WHERE questid = {$pId} AND zid = {$gId} AND finishtime = '00000000000000'");

	if($meet1 == 1 && $isReceived == 0){ 
		dbQuery("INSERT INTO zf_quest_record (zid, questid) VALUES ({$gId}, {$pId})");
		$allowed = true;
		
		//check for immediate holdback
		if($row['finishcondition']==""){
			$ismeet = 1;
		}else{
			$ismeet = questQuery($row['finishcondition'],1);
		}
		
		//if meet finish then give award
		if($ismeet == 1){ 
			dbQuery("UPDATE zf_quest_record SET finishtime = NOW() WHERE questid = {$pId} AND zid = {$gId}");
			questQuery($row['awardsql'],0);
			$finished = true; 
		}else{
			$finished = false;
		} 
	
		//
	}else{
		screenMessage("無法交付任務","你沒有接受任務或不符合此任務的條件。");
	}
}

//holdback quest
if($action=="holdback"){
	$row = dbRow("SELECT * FROM zf_quest WHERE id = {$pId}");
	
	//check if finished
	if($row['finishcondition']==""){
		$ismeet = 1;
	}else{
		$ismeet = questQuery($row['finishcondition'],1);
	}
	$isReceived = dbRs("SELECT count(*) FROM zf_quest_record WHERE questid = {$pId} AND zid = {$gId} AND finishtime = '00000000000000'");
	
	//if finished then
	if($ismeet == 1 && $isReceived == 1){ 
		dbQuery("UPDATE zf_quest_record SET finishtime = NOW() WHERE questid = {$pId} AND zid = {$gId}");
		questQuery($row['awardsql'],0);
		$finished = true;
	}else{
		$finished = false;
	} 
}

include_once('templatecode/header.php'); ?>

<h1>任務</h1>
	
	<hr />
	<div class='row'>
<div class="col-xs-12 col-md-3">
	<h4>您的資料</h4>
	<img src="<?=isAvatarSet($my["username"])?getAvatarURL($my["username"],200):"images/noavatar.gif"; ?>" alt="avatar" width="190" /><br />
	<strong>ZID:</strong> <?php echo $row_getUserInfo['id']; ?><br />
	<strong>用戶名:</strong> <?php echo $row_getUserInfo['username']; ?><br />
	<?php if($row_getUserInfo['url']!=""){ ?>
	<strong>網站:</strong> <a href="<?php echo $row_getUserInfo['url']; ?>">按此進入</a><br /><?php } ?>
	<strong>最後登入時間:</strong><br />
	<?php echo $row_getUserInfo['lastlogin']; ?><br />
	<strong>用戶組:</strong> <?php echo $row_getUserInfo['usertype']; ?><br />
	<strong>發貼數:</strong> <?php echo $row_getUserInfo['postnum']; ?><br />
	<strong>金錢:</strong> <?php echo $row_getUserInfo['score1']; ?><br />
	<strong>秘寶:</strong> <?php echo $row_getUserInfo['score2']; ?>
</div>
<style>
	.myContainer{ float:left;padding-right:1em}
	</style>
<div class="col-xs-12 col-md-9">

<?php if($action==""){
	foreach($quests as $row){ ?>
	<div class='well'>
    <div class='myContainer'><img src="<?=$row['image'];?>" alt="money" /></div>
    <div class='myContainer'>
		<h4><?=$row['title'];?></h4>
		<?=$row['description']; ?><br /><br />

		<a class="btn btn-default" href="quest.php?action=view&amp;id=<?=$row['id'];?>">詳請</a>
    </div>
    <div style="clear:both"></div>
	</div>
	<? }?>
<? }?>

<?php if($action=="view"){	?>
	<div class='well'>
    <div class='myContainer'><img src="<?=$row['image'];?>" alt="money" /></div>
    <div class='myContainer'>
    
    <h4><?=$row['title'];?></h4><?=$row['description']; ?><br />
    
	<? if($isReceived == 0){ ?>
	    <? if($meet1 == 1){ ?>
			<a class="btn btn-default" href="quest.php?action=accept&amp;id=<?=$row['id'];?>">接收任務</a>
        <? }else{ ?>
			<strong>你沒有資格接受這個任務</strong>
		<? } ?>
    <? }else{ ?>
        <strong>你已經接受這個任務</strong><br /><br />
        - 開始時間: <?=$record['applytime'];?><br /><br />
        <a class="btn btn-default" href="quest.php?action=holdback&amp;id=<?=$row['id'];?>">交付任務</a>
    <? } ?>
    


    </div>
    <div style="clear:both"></div>
    </div>
<? }?>


<?php if($action=="accept"){ ?>
	<div class='well'>
    <div class='myContainer'><img src="<?=$row['image'];?>" alt="money" /></div>
    <div class='myContainer'>
		<h4><?=$row['title'];?></h4>
		<?=$row['description']; ?><br />

		<?php if($allowed == true){ ?>
        	<strong>申請接受了!</strong>
        <?php } ?>
		
		<?php if($finished == true){ ?>
			<br /><br />
        	<strong>在接受任務的同時，任務已經完成了!</strong><br />		
			任務成功交付了。<br />
			獎勵已存入的你賬戶。
        <?php } ?>

    </div>
    <div style="clear:both"></div>
    </div>
<? }?>

<?php if($action=="holdback"){ ?>
	<div class='well'>
    <div class='myContainer'><img src="<?=$row['image'];?>" alt="money" /></div>
    <div class='myContainer'>
		<h4><?=$row['title'];?></h4>
		<?=$row['description']; ?><br />
	<br />

	<strong>
		<?php if($finished == true){ ?>
			任務成功交付了。<br />
			獎勵已存入的你賬戶。
		<?php }else{ ?>
			你尚未完成任務，你在完成後再交付。
		<?php } ?></strong>
    </div>
    <div style="clear:both"></div>
    </div>
<? }?>
</div>

<div class='clear'></div>

<hr />
<?php include_once('templatecode/footer.php'); ?>
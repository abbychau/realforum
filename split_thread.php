<?php
    include_once('Connections/zkizblog.php');
    include_once('include/common.inc.php');
	require('include/bbcode.php');
	$bbcode = new BBCode;
	
	if(!$isLog){
		screenMessage("錯誤","請先登入");
	}
	
	$gTid=intval($_GET['tid']);
	
	if($gTid == ""){screenMessage("Error","Missing Thread ID.");}
	

	
	$threadInfo = dbRow("SELECT is_closed,donation, isdigest, commentnum, views, a.title, type, authorid, username, special, isshow FROM zf_contentpages a, zf_user c WHERE c.id = a.authorid AND a.id = {$gTid}");
	
	
	if(sizeof($threadInfo)==0){
		screenMessage("錯誤","找不到主題。");
	}
	if($threadInfo['type']==""){
		screenMessage("錯誤","分類錯誤");
	}
	if($threadInfo['isshow']==0){
		screenMessage("Error","This thread is being hidden");
	}
	if($threadInfo['type'] == 119 && $gUserGroup < 5){
		screenMessage("錯誤","This board is under maintainance.");
	}
	
	
	//GET ADMINS
	$isMod = dbRs("SELECT count(*) as ce FROM `zf_admin` WHERE fid = {$threadInfo['type']} AND ownerid = {$gId}");
	if($isMod==0 && $my['usertype'] <= 8){screenMessage("錯誤","你不是版主, 無法進行此操作");}
	
	$boardInfo = dbRow("SELECT * FROM zf_contenttype WHERE id = {$threadInfo['type']}");
	if($boardInfo['cate']==6 || $boardInfo['id'] == 44){
		$gNoAds = true;
	}
	if(in_array($gId,explode(",",$boardInfo['banned_member']))){
		screenMessage("錯誤","你已被版主列入黑名單, 不可以分割帖子。");
	}
	
	if($_POST['ridlist']!=""){
	
		$result = preg_replace("/[^a-zA-Z0-9,]+/", "", $_POST['ridlist']);
		$result = trim($result,",");
		$replyArr= explode(",",$result);
		
		$oldTid = intval($_POST['tid']);
		$targetTid = intval($_POST['targetTid']);
		
		if($targetTid){ 
			$newThreadID=$targetTid;
		}else{
			$title = trim($_POST['title']);
			$subtitle= trim($_POST['subtitle']);
			$lastid = end($replyArr);
			$fid = intval($_POST['fid']);
			$special = 0;
			$newThreadID = dbQuery("INSERT INTO zf_contentpages (title,subtitle, type, lastid,authorid,special,create_timestamp) VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP)",
			[$title,$subtitle,$fid,$lastid,$gId,$special]
			); 
		}
		
		dbQuery("UPDATE zf_reply SET tid = $newThreadID WHERE id IN ({$result})");
		dbQuery("UPDATE zf_reply SET isfirstpost = 0 WHERE tid = $newThreadID");
		dbQuery("UPDATE zf_reply SET isfirstpost = 1 WHERE id = {$result[0]}");
		
		//Finished, screen Message
		$oldThreadUrl = "/thread.php?tid=$oldTid";
		$newThreadUrl = "/thread.php?tid=$newThreadID";
		screenMessage("已成功分割","進入舊主題:<a href='$oldThreadUrl'>$oldThreadUrl</a><br />進入新主題:<a href='$newThreadUrl'>$newThreadUrl</a>");
		exit;
	}

	$getReply = dbAr("	SELECT score_trade, is_rbenabled, comment, a.id as id, fid, timestamp,price, modrecord, content, picurl, datetime, ip, authorid, isfirstpost, praise, username,alias, gender, pic, email, url, lastlogin, signature, usertype, postnum, gp, score1, score2, score3, issign, gold, silver, bronze
	FROM zf_reply a, zf_user b 
	WHERE a.authorid = b.id and 
	tid = {$gTid} 
	ORDER BY a.id ASC");

	if(!$getReply){	screenMessage("Error",'No article found.');	}

	//GET purchased rid
	$purchased = dbAr("SELECT rid FROM zf_purchase WHERE zid= $gId");
	foreach($purchased as $v){$prid[] = $v['rid'];} //transpose
	
	$title = "分割主題:".$threadInfo['title'];
	$description = str_replace("\n","",mb_substr($getReply[0]['content'],0,200,"utf8"))."...";
	$keywords = "$title, ".$boardInfo['name'].", RealForum";
	$htmltitle = "$title - ".$boardInfo['name'];

	$isReplied = (dbRs("SELECT count(*) FROM zf_reply WHERE tid = {$gTid} AND authorid = {$gId}")>0 && $isLog);

	include(template("header"));

?>
<script>
	var str = "";
	function refreshIDlist(){
		str="";
		$(".idItem:checked").each(function(){str = str+","+this.value;});
		$(".statusbar").html(str);
		$(".ridlist").val(str);
	}
	
</script>
<div  style='position:fixed;right:0;background:#EEE;bottom:0'>
<span class=''>SELECTED:</span><span class='statusbar'>Nothing</span>
</div>
<ol class="breadcrumb">
	<li><a href="/">RealForum</a></li>
	<li><a href="<?="viewforum.php?fid={$threadInfo['type']}";?>"><?=$boardInfo['name'];?></a></li>
	<li class="active"><?=mb_substr($title,0,40,"utf-8").(mb_strlen($title,"utf-8")>40?"...":"");?></li>
</ol>

<div class="page-header">
	<h1 id="title"><?=$title;?> <small>by: <strong><?=$threadInfo['username'];?></strong></small></h1>
</div>



<div class=''>
	
	<?php 
		foreach($getReply as $v) {
			++$initNum;
			
			if($_GET['authoronly']=="" || $_GET['authoronly']==$v['authorid']){?>
			
			<a id="<?=$initNum; ?>"></a>
			<div class="panel panel-default">
				<div class='panel-body'>
						
					<div style='font-size:12px;float:right'>
						
						<?if($v['authorid']>0){?>
							<?=$v['username'];?>: 
							<a href="<?=curURL();?>#<?=$initNum ?>" style='color: inherit;'><?=$initNum ?>樓</a> - 
							
							
							發表於:<?=timeago(strtotime($v['datetime'])); ?>
							<?php if(strtotime($v['timestamp']) - strtotime($v['datetime']) > 60){ ?>
								- 最後修改:<?=timeago(strtotime($v['timestamp']));?>
							<?php } ?>
							
						<? } ?>
						<strong>
						<?if($v['isfirstpost']==0){?>
						選取這個帖子:<input type="checkbox" onclick="refreshIDlist()" class='idItem' value="<?=$v['id'];?>">
						<?}else{?>
						樓主不能移動
						<?}?>
						</strong>
					</div>
					
					<div >
						
						<div  >
							
							<?php 
								//$isBought: NBBC GLOBAL
								if(sizeof($prid)>0){
									$isBought=in_array($v['id'],$prid); 
								}else{$isBought=false;}
							?>
							
									<div class='reply_content'>

										<?=$bbcode->parse($v['content']);	?>
									</div>
									<?php parsePicurl($v['picurl']);?>
							
						</div>
						
						
						<?php if($v['comment'] != ""){ $comments=unserialize($v['comment']);?>
						<strong>留言</strong>
							<?php foreach($comments as $comment){?>
								<div class='reply_comment'>
									<a href='userinfo.php?zid=<?=$comment['zid'];?>'><?=$comment['username'];?></a> : <?=htmlspecialchars($comment['content']);?>
									(<?=timeago($comment['timestamp']);?>)
								</div>
							<?php }?>
						<?php } ?>
					</div>
					
				</div>
			</div>
		<?php } ?>

		
	<?php } ?>

</div>

<div class='panel panel-default'>
	<form method='post'>
	<input type='hidden' name='ridlist' class='ridlist' />
	<input class='form-control' type='text' name='title' placeholder='新標題' />
	<input class='form-control' type='text' name='subtitle' placeholder='副標題(選填)' />
	<input class='form-control' type='text' name='targetTid' placeholder='目標標題ID(選填)' />
	<input type='hidden' name='tid' value='<?=$gTid;?>' />
	<select class='form-control' name='fid'><?=boardSelect(true,$threadInfo['type']);?></select>
	<input type='submit' style='width:100%' class='btn btn-primary' value='移動所選取的所有回覆至新主題' />
	</form>
</div>
<?
	include(template("footer"));


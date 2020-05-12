<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php');
	require_once('../include/common.inc.php');
	$rate = 0.8;
	
	if(!$isLog){die("請先登入");}
	
	$gPid = intval($_REQUEST['id']);
	
	$replyInfo = dbRow("SELECT fid, comment FROM zf_reply WHERE id = $gPid");
	
	$bannedUser = dbRs("SELECT banned_member FROM zf_contenttype WHERE id = {$replyInfo['fid']}");
	
	if(stristr($bannedUser,",")){
		$bannedUsers = explode(",",$bannedUser);
		$isBanned = in_array($gId,$bannedUsers);
		}else{
		$isBanned = $gId==$bannedUser;
	}
	if($isBanned){die("你在本區的黑名單中");}
	
	
	if($_GET['action']=="1"){
		if($_POST['says']==""){
			die("請寫入訊息");
		}
	}else if($_GET['action']=="2" || $_GET['action']=="4"){
		$word="BJ"; $sign = "-";
		if($_GET['action']=="2"){
			$amount = 5;
		}else{
			$amount = 10;
		}
	}else if($_GET['action']=="3" || $_GET['action']=="5"){
		$word="GJ"; $sign = "+";
		if($_GET['action']=="3"){
			$amount = 5;
		}else{
			$amount = 10;
		}
	}
	
	if($_GET['target']==$gId){die("不可以向自己{$word}");}
	
	
	if (isset($_POST["from_ajax"])) {
	
		$postID = intval($_POST['id']);
		$postTargetID = intval($_POST['target']);
		$postTID =  intval($_POST['tid']);
		$says = $_POST['says']==""?"":" (".htmlentities($_POST['says']).")";
		
		$targetInfo = dbRow("SELECT * FROM zf_user WHERE id = {$postTargetID}");
		
		//exceptions
		if($my['score1']<$amount){echo "金錢不足, 你需要至少{$amount}金錢, 而你卻只有{$my['score1']}。"; exit;}
		if($targetInfo['score1']<$amount && $_GET['action']=="blame"){echo "{$targetInfo['username']}的金錢太少了，不能被ＢＪ了。"; exit;}
		if($targetInfo['nobj'] == 1 && ($_GET['action']=="2" || $_GET['action']=="4")){echo "{$targetInfo['username']}現在不接收ＢＪ。"; exit;}
		
		$pmTitle = "[系統]你收到{$word}了";
		$total = $amount * $rate;
		
		
		if($_GET['action']=="1"){
		
		if($_POST['anonymous']==1){
			$pmContent = "某人給你留言”{$says}”! TID:{$postTID}";
			$pmUser = "匿名";
		}else{
			$pmContent = "<b>{$gUsername}</b>給你留言”{$says}”! TID:{$postTID}";
			$pmUser = $gUsername;
		}
			
			$comment = $replyInfo['comment'];
			$comments = unserialize($comment);
			$comments[] = array(
				"zid"		=> 733,
				"username"	=> $pmUser,
				"content"	=>str_replace('\"',"",$_POST['says']), 
				"timestamp"	=>time()
			);
			dbQuery("UPDATE zf_reply SET comment = ? WHERE id=?",[serialize($comments),$postID]);
			
			
			}else{
			if($_POST['anonymous']==1){
				$pmContent = "在PID:{$postTID}, 某人發給你<b>{$amount}{$word}</b>。";
				$modrecord = "匿名: {$word} x {$amount}";
				$payment = $amount;
				}else{
				
				$pmContent = "<b>{$gUsername}</b>在({$postTID})發給你<b>{$amount}{$word}</b>! ".($says==""?"沒有留言":"並說[{$says}]")."。";
				$modrecord = "{$gUsername}: {$word} x {$amount} {$says}";
				$payment = $amount;
			}
			
			dbQuery("UPDATE zf_reply SET praise = praise {$sign} {$amount}, modrecord = CONCAT_WS(' | ', modrecord,?) WHERE id={$postID}",[$modrecord]);
			dbQuery("UPDATE zf_contentpages SET tpraise = tpraise {$sign} {$amount} WHERE id={$postTID}");
			dbQuery("UPDATE zf_user SET score1 = score1 - $payment WHERE id={$gId}");
			dbQuery("UPDATE zf_user SET score1 = score1 $sign $total, gp = gp {$sign} $amount WHERE id={$postTargetID}");
			
		}
		
		sendNotification(
		dbRs("SELECT username FROM zf_user WHERE id = $postTargetID"),
		$pmContent,
		"{$g_domain}/thread.php?tid={$postTID}"
		);
		echo "<b>成功提交!</b>";
		exit;
	}
	
?>

<div class='gjcontainer'>
	
	
	<div class="input-group">
	      <span class="input-group-addon">
        <input type="checkbox" id="anonymous<?=$gPid;?>" value="1"  /><label>匿名</label>
      </span>
	  
		<input type="text" class="form-control" id="says<?=$gPid;?>" />
		<div class="input-group-btn">
		
			<button type="button" class="btn btn-default" tabindex="-1" id="actionbutton<?=$gPid;?>" placeholder='訊息' onclick="doGJ(<?=$_GET['id']; ?>,<?=$_GET['tid']; ?>,<?=$_GET['target']; ?>,$('#says<?=$gPid;?>').val(),$('#anonymous<?=$gPid;?>').is(':checked')?1:0)">留言</button>
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                <span class="caret"></span>
			</button>
			<ul class="dropdown-menu pull-right" role="menu">
                <li><a onclick="$('#actionbutton<?=$gPid;?>').html($(this).html());tmpAction=1;">留言</a></li>
                <li><a onclick="$('#actionbutton<?=$gPid;?>').html($(this).html());tmpAction=2;">留言＋５ＢＪ</a></li>
                <li><a onclick="$('#actionbutton<?=$gPid;?>').html($(this).html());tmpAction=4;">留言＋１０ＢＪ</a></li>
                <li><a onclick="$('#actionbutton<?=$gPid;?>').html($(this).html());tmpAction=3;">留言＋５ＧＪ</a></li>
                <li><a onclick="$('#actionbutton<?=$gPid;?>').html($(this).html());tmpAction=5;">留言＋１０ＧＪ</a></li>
			</ul>
		</div>
		
	</div><!-- /.input-group -->
	
</div>
<script type="text/javascript">
	var tmpAction = 1;
	
	function doGJ(id,tid,target,says,anonymous){
		$('.gjcontainer').html('提交中...');
		$.post("/ajaxbox/gjreply.php?action="+tmpAction,
		{'id':id,'tid':tid,'target':target,'from_ajax': 1,'says': says,'anonymous':anonymous},
		function(data){
			$('.gjcontainer').html(data);
		}
		);
	}
	/*
		$("#slider-range-min").slider({
		range: "min",
		value: 5,
		min: 1,
		max: 50,
		slide: function(event, ui) {
		$("#amounts").html('$' + ui.value);
		}
		});
		$("#amounts").html('$' + $("#slider-range-min").slider("value"));
	*/
</script>

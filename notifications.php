<?php 
	require_once('Connections/zkizblog.php'); 
	
	if (!$isLog){screenMessage("錯誤","請先登入","http://members.zkiz.com/login.php");}
	
	
	
	if ($_GET["type"] == "clickthrough"){
		$getID = safe(base64_decode($_GET['id']));
		dbQuery("UPDATE zm_notification SET `read` = 1 WHERE link = '$getID' AND zid='$gUsername'");
		
		header("location:$getID");
		exit;
	}
	if ($_GET["type"] == "clear"){
		dbQuery("UPDATE zm_notification SET `read` = 1 WHERE zid = '$gUsername'");
		echo json_encode(true);
		exit;
	}
	
	$getNoti = dbAr("SELECT content, link, time, count(*) as ce FROM zm_notification WHERE zid = '$gUsername' AND `read` = 0 GROUP BY link");
?>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
		<style>
			a {color:#333;font-weight:bold;font-size:1em;text-decoration:none}
			.blocka{padding:1em;}
			
		</style>
	</head>
	<body>
		
		<?php foreach($getNoti as $v) { ?>
			<div class="blocka">
				<a href="/notifications.php?type=clickthrough&id=<?=base64_encode($v['link']);?>"><?=$v['content'];?>(<?=timeago(strtotime($v['time']));?>) 
				<?if($v['ce']>1){?>
					x <?=$v['ce'];?>
				<?}?>
				</a>
			</div>
		<?php } ?>
		
		<div class="blocka" id='lblNoNotice'>沒有通知</div>
		
		
		<div class="blocka">
			<a id='lblClearAll' onclick='clearAll()'>清除所有</a>
		</div>
		
		<script type='text/javascript'>
			function clearAll(){
				$.get("notification.php",{type:'clear'},function(){
					//$('#noti').hide('fast');
					$('#lblNoNotice').show();
					$('#lblClearAll').hide();
					$('.items').remove();
					//$("#notify").html("0");
				});
			}
			<?php if(sizeof($getNoti)!=0){?>
				$('#lblNoNotice').hide();
				<?php }else{ ?>
				$('#lblClearAll').hide();
			<?php } ?>
		</script>
	</body>
</html>
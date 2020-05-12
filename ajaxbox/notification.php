<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
require_once('../include/common.inc.php');


if (!$isLog){die("請先登入");}

$getNoti = dbAr("SELECT content, link, time FROM zm_notification WHERE zid = '$gUsername' AND `read` = 0 ORDER BY link LIMIT 50");
if ($_GET["type"] == "clickthrough"){
	dbQuery("UPDATE zm_notification SET `read` = 1 WHERE link = :link AND zid='$gUsername'",['link'=>base64_decode($_GET['id'])]);
	$getID = urldecode($getID);
	header("location:$getID");
}
if ($_GET["type"] == "clear"){
	dbQuery("UPDATE zm_notification SET `read` = 1 WHERE zid = '$gUsername'");
	echo json_encode(true);
	exit;
}
?>
<div style='padding:0;width:300px;font-size:12px'>
<div style='padding:0.2em 0.5em'>
<a id='lblClearAll' onclick='clearAll()' class='btn btn-default btn-xs'>清除所有</a>
<a  class='btn btn-default btn-xs' href='http://members.zkiz.com/notifications.php'>查看其他</a>
</div>
<?php foreach($getNoti as $v) { ?>
	<div style='padding:0.2em 0.5em;border-top:1px #CCC solid;margin-top:0.2em'>
    <a href="/ajaxbox/notification.php?type=clickthrough&id=<?=base64_encode($v['link']);?>"><?=$v['content'];?>(<?=timeago(strtotime($v['time']));?>)</a>
	<?if($v['ce']>1){?>
        <span class='label label-default label-xs'><?=$v['ce'];?></span>
	<?}?>
	</div>
<?php } ?>

<div style='padding:0.2em 0.5em 0 0.5em;border-top:1px #CCC solid;margin-top:0.2em;' id='lblNoNotice'>沒有通知</div>

</div>

<script type='text/javascript'>
function clearAll(){
	$.get("/ajaxbox/notification.php",{type:'clear'},function(){
		$('#noti').hide('fast');
		$('#lblNoNotice').show();$('#lblClearAll').hide();$('.items').remove();$("#notify").html("0");
	});
	$.get("/realforum/ajaxbox/notification.php",{type:'clear'},function(){
		$('#noti').hide('fast');
		$('#lblNoNotice').show();$('#lblClearAll').hide();$('.items').remove();$("#notify").html("0");
	});
}
<?php if(sizeof($getNoti)!=0){?>
$('#lblNoNotice').hide();
<?php } ?>
</script>
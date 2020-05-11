<script type="text/javascript">
function stripHtml(strIn){
	var matchTag = /<(?:.|\s)*?>/g;
	return strIn.replace(matchTag, "");
}
function reply(toId, title, fromDiv){
	$('#to_id').val(toId);
	$('#title').val('回覆: ' + title);
	$('#content').val("[quote]\n" + stripHtml(document.getElementById(fromDiv).innerHTML) + "\n[/quote]"); 
	$('#content').focus();
}
function delPm(pmid){
	$.get('ajaxdata.php',{id:pmid, type: 'delpm'}); 
	$('#pm' + pmid).hide('fast');
}
function togRead(pmid,iRead){
	$.get('ajaxdata.php',{id:pmid, type: 'changepm', isread: iRead});
	if(iRead){
		$('#pm'+pmid).css({'border':'4px solid #666'});
	}else{
		$('#pm'+pmid).css({'border':'4px solid #930'});
	}
}
function toZid(name){
$.get('ajaxdata.php',{id:name, type: '2'},
  function(data){
		document.getElementById('to_id').value = data;
  });
}
</script>
<style>
	.readpm{}
	.unreadpm{}
</style>
<h3>PM 系統</h3>

<div>
<? if ($actsent){?>
切換到<a href="pm.php">收件箱</a>
<? }else{?>
切換到<a href="pm.php?action=sent">寄件箱</a>
<? } ?>
</div>



<?php if (sizeof($mails) > 0){?>
<?php foreach($mails as $row_getType){ ?>
<blockquote style="border:<?php if($row_getType['isread']==1){echo '4px solid #666';}else{echo '4px solid #930';} ?>; padding:6px" id="pm<?php echo $row_getType['id'];?>" class="reply">

	<div style="float:right">
	<? if(!$actsent){?>
		標示已讀
		<input name="isread" type="checkbox" <?php if($row_getType['isread']==1){ ?>checked="CHECKED"<?php } ?> onchange="togRead('<?php echo $row_getType['id'];?>',this.checked)" />
	<? } ?>
		<input type="button" onclick="delPm('<?php echo $row_getType['id'];?>')" value="刪除" />
	</div>

	標題: <strong><?php echo htmlspecialchars($row_getType['title']);?></strong>
	<a style="font-size:12px; color:#bbbbbb; font-weight:100; text-decoration:none; cursor:pointer" onclick="reply('<?php echo $row_getType['from_id'];?>','<?=str_replace("'","",$row_getType['title']); ?>','<?="msg".(++$i);?>');">回覆</a>&nbsp;<br />
	內容: <br />
	<div style="padding-left:10px" id="<?="msg".$i;?>"><?php echo $bbcode->Parse($row_getType['message']);?></div><br />
<?=$actsent?"收件人":"發件人";?>: <a href="userinfo.php?zid=<?php echo $row_getType['from_id'];?>"><?php echo $row_getType['ufrom'];?></a><br />
	時間: <?php echo $row_getType['timestamp'];?>
</blockquote>
<?php } ?>
<?php }else{ ?>
沒有信息
<?php }?>
<hr />
<h4>發送信息</h4>
<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	收件人ZID:<input name="to_id" type="text" id="to_id" size="30" maxlength="30" value="<?php echo $_GET['toid']; ?>" />
	<input name="" type="button" value="名字轉為ZID" onclick="toZid(document.getElementById('to_id').value);" />
	(可用","分隔各用戶, 每條短訊發出將扣取 0.5 壇幣)
	<br />
	標題:<input name="title" type="text" size="50" id="title" style="width:280px"/><br />
	內容:<br />
	<textarea name="content" id="content" class="ed" cols="90" style="width:280px" rows="15"></textarea>
	<br />
	<input type="hidden" name="MM_insert" value="form2" />
	<input type="submit" name="Submit" value="送出" />
</form>

<script type="text/javascript">
/* <![CDATA[ */

function showurl(id){
url = "<?=curURL();?>#" + id;

txt = '<embed width="62" height="24" align="middle" flashvars="txt='+url+'" src="/images/Copy.swf" quality="high" wmode="transparent" allowscriptaccess="sameDomain" pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash">';

return "<fieldset><legend>此回帖的路徑</legend>" + url + txt + "</fieldset>";
}
/* ]]> */
</script>

<div class="mainborder" >


<?php if($donated == true){ ?>
<div class="ui-state-highlight ui-corner-all" style="margin: 5px 0; padding: 0 .7em 0;"> 
	<p style="margin:5px"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
	<strong>謝謝!</strong> 你的捐款令我們做得更好!</p>
</div>
<?}?>
<div class="tdvfnav ">



<h3><?=mb_substr($title,0,60,"utf-8").(mb_strlen($title,"utf-8")>60?"...":""); ?></h3>
@<a href='viewforum.php?fid=<?=$row_getThread['type'];?>'><?=$boardInfo['name'];?></a><br />
(人氣:<?php echo $row_getThread['views']; ?> 回覆:<?php echo $row_getThread['commentnum']; ?>
<? if($row_getThread['donation']>0){?>捐款: $<?php echo $row_getThread['donation']; ?><?}?>
)<br />
<div class='pagination'>
	<?php pagin($page, $currentPagePure, $queryString_getReply, $totalPages_getReply);?>
</div>
<div class='clear'></div>
<div >



<iframe src="http://www.facebook.com/plugins/like.php?href=<?=htmlspecialchars(curURL());?>&amp;layout=button_count&amp;show_faces=true&amp;width=70&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px; margin-bottom:-8px"></iframe>
	<?php if($able_to_reply){?>
		<a href="post.php?type=post&amp;fid=<?=$row_getThread['type'];?>"><img src="images/newthread.gif" alt="new thread" /></a>
		<a href="post.php?type=reply&amp;tid=<?=$gTid;?>"><img src="images/newreply.gif" alt="new reply" /></a>
	<?php } ?>
</div>
<div class="clear"></div>
</div>
<div style="padding-bottom:0px;">



<div class="clear"></div>



<?php $initNum = $startRow_getReply;?>
<?php if($row_getThread['special'] == 1){ ?>
<fieldset style="margin:10px; padding:15px;"><legend>本主題附有投票欄(放在投票人數上面可以看到名單)</legend>
<form id="poll" name="poll" method="post" action="/ajaxbox/newpoll.php?tid=<?=$gTid;?>">


	<div style="float:left; font-weight:bold; padding-right:20px; line-height:20px;">
	<?php 
	foreach($items as $val){
		$i++;
		if ($pollInfo['option'] == 0){?>
			<input name="option" type="radio" value="<?=$i;?>" />
		<? }else{ ?>
			<input name="option[]" type="checkbox" value="<?=$i;?>" />
		<? } ?>
		<?=$val;?>
		<br />
	<? } ?>
	</div>

	<div class="left">
	<?php 
	
	foreach($users as $line){$maxsize = max(sizeof($line), $maxsize);}
	foreach($users as $line){
		$strow = "";
		if(sizeof($line)>1){
			foreach($line as $val){$strow .= $strow==""?$val:", ".$val;}
		}
	
		$ratio = round(((sizeof($line)-1) / $maxsize) * 300 ) . "px";
		echo "<div style='width:$ratio; height:20px; float:left' class='ui-widget-header clear'></div>
		<div style='padding:1px' class='left' title='$strow'>(共".(sizeof($line)-1)."人)</div>";	

	} 
	?>
	</div>
<div style="clear:both"></div>
<input type="hidden" name="MM_insert" value="poll" />
<input type="hidden" name="tid" value="<?=$_GET['tid'];?>" />
<input name="" type="submit" value="投票" />
</form>
</fieldset>
<?php } ?>

<?php foreach($getReply as $v){ ?>
<?++$initNum ?>
<?if($_GET['authoronly']=="" || $_GET['authoronly']==$v['authorid']){?>

<a name="<?=$initNum ?>"></a>

<?php 
//$isBought: NBBC GLOBAL
if(sizeof($prid)>0){
$isBought=in_array($v['id'],$prid); 
}else{$isBought=false;}
?>

<div class="ui-widget-content reply clear">
	

	<div style=" line-height:25px;" class="" id="floor<?=$initNum;?>">
<?if($v['authorid']>0){?>
<table class='ui-widget-header authorbar' width='100%'><tr>
<td width="40">

	<img width='40' src='<?=$v['pic']==""?"images/noavatar.gif":$v['pic']; ?>' alt="avatar" />
	</td>
<td width="" style='font-size:12px;'>
	<a onclick="$('#modiwindow<?=$v['id']; ?>').toggle('slow').html(showurl(<?=$initNum ?>));">[<?=$initNum ?>樓]</a>
	
	
	<strong>發表於:</strong><?=timeago(strtotime($v['datetime'])); ?>
	<br />
	<?php if($v['authorid']==733){?>
		<img src='images/ranks/rank0.gif' />訪客
		Guest (IP: <?=$v['ip']; ?>)
	<?php }else{?>
		<?=gId2rank($v['usertype']);?>
		<a href="userinfo.php?zid=<?=$v['authorid']; ?>"><?=$v['username']; ?></a>
		<?php if($v['alias']!=""){echo "(".$v['alias'].")";}?>
		<a href="pm.php?toid=<?=$v['authorid']; ?>"><img src="images/pm.png" alt="pm" /></a>


	<?php }?>
</td>

</tr></table>
<?}?>
	<div>


	
		<?=$bbcode->Parse($v['content']); ?>
		
	
	
	<?php parsePicurl($v['picurl']);?>
	<?php if(strtotime($v['timestamp']) - strtotime($v['datetime']) > 60){ ?>
	<div class="contentmodinfo">最後修改:<?=$v['timestamp'];?></div>
	<?php } ?>
	
	<?php if($v['modrecord'] != ""){ ?>
	<div class="contentmodinfo" style="color:green">其他紀錄:<?=$v['modrecord'];?></div>
	<?php } ?>
    
<br />
<?if($v['authorid']>0){?>
	<a onclick="location.href='post.php?type=quote&amp;rid=<?=$v['id']; ?>&amp;tid=<?=$gTid;?>&amp;name=<?=$initNum ?>'">引用回覆</a>
	<?php if($v['price']>0){?>
	<a class="buyspan" onclick="dialog('ajaxbox/purchase.php?id=<?=$v['id']; ?>&amp;tid=<?=$gTid; ?>&amp;target=<?=$v['authorid'];?>','購買');">購買($<?=$v['price'];?>)</a>
	<?php } ?>
	
	<a onclick="dialog('ajaxbox/gjreply.php?id=<?=$v['id']; ?>&amp;tid=<?=$gTid; ?>&amp;target=<?=$v['authorid'];?>','GJ!');">
		GJ! x <?php if($v['praise']>0){?><?=$v['praise']; ?><?php }else{?><?=$v['praise']; }?>
	</a>
<?}?>
	</div>

	</div>
<div style="clear:both"></div>
	<?if($v['signature']!=""  && $v['isfirstpost']==1){?>
	<div class="sigbox" style="border-top:1px dotted">
		<?=$bbcode->Parse(trim($v['signature'])); ?>
		
	</div>
	
	<?}?>
</div>


<?php } ?>
<?php } ?>
</div>


<div class="reply ui-widget-content">
<div class='pagination'>
	<?php pagin($page, $currentPagePure, $queryString_getReply, $totalPages_getReply);?>
</div>
<div class='clear'></div>
<iframe src="http://www.facebook.com/plugins/like.php?href=<?=htmlspecialchars(curURL());?>&amp;layout=button_count&amp;show_faces=true&amp;width=70&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px; margin-bottom:-8px"></iframe>
	<?php if($able_to_reply){?>
		<a href="post.php?type=post&amp;fid=<?=$row_getThread['type'];?>"><img src="images/newthread.gif" alt="new thread" /></a>
		<a href="post.php?type=reply&amp;tid=<?=$gTid;?>"><img src="images/newreply.gif" alt="new reply" /></a>
	<?php } ?>


<br />

<div id="adsb4post">


<?php if($able_to_reply){?>
<?php include(template("quickpost"));?>
<?php } ?>

</div>
</div>





</div>

<script type="text/javascript">
/* <![CDATA[ */
var maxpage = <?=$totalPages_getReply;?>;
var currentpage = <?=$page;?>;

/* ]]> */
</script>
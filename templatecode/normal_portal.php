<div class="mainborder">

<div class="tdvfnav">


<div style="height:54px;">
<?php if($row_getType['icon'] != ""){ ?>
<div class="left" style="padding-top:8px">
<img src="<?=$row_getType['icon'];?>" alt="icon" width="50" />
</div>
<?php } ?>
<div class="left">
	<?=buildhome();?> &raquo; <strong><?php echo $htmltitle; ?></strong><br />
	<a href='/rss.php?fid=<?=$gfid;?>' style='text-decoration:none; font-size:12px;'>按此訂閱RSS<img src='/images/rss.png' alt='RSS Feed' /></a><br />
	管理人員: <abbr title="(粗體:版主 斜體:版副)"><?php echo $master;?></abbr>
</div>
<div class="right" style="padding:10px;border-right:1px #CCC solid">
<strong style="font-size:20px"><?=$citysize; ?></strong><br />
帖子
</div>
<div class="right" style="padding:10px">
<strong style="font-size:20px"><?php echo $totalRows_getConList; ?></strong><br />
主題
</div>
<?if ($isadmin == 1 || $isadmin == 9) {?>
<div class="right" style="padding:8px">
	<a onclick="dialog('ajaxbox/forum_highlight.php?typeid=<?=$gfid;?>','修改本區高亮',false,640)">修改本區高亮</a>
	<a onclick="dialog('ajaxbox/modiintro.php?typeid=<?=$gfid;?>','修改本區公告')">本區公告</a>
	<a onclick="dialog('ajaxbox/modicityname.php?typeid=<?=$gfid;?>','修改本區名稱')">本區名稱</a>
	<a onclick="dialog('ajaxbox/modicityicon.php?typeid=<?=$gfid;?>','修改本區圖示')">本區圖示</a><br />
	<a onclick="dialog('ajaxbox/modimods.php?typeid=<?=$gfid;?>','修改本區版副')">本區版副</a>
	<a onclick="dialog('ajaxbox/modiisguest.php?typeid=<?=$gfid;?>','容許訪客發貼')">容許訪客發貼</a>
	<a onclick="dialog('ajaxbox/modicate.php?typeid=<?=$gfid;?>','分類')">分類</a>
	
</div>
<?}?>
</div>
<div class="clear"></div>


<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="250" valign="top">
<div style="padding:3px">
<form method="get" action="search.php" id="fidforum">
	
<input type="text" name="fidq" size="10" class="text ui-widget-content ui-corner-all" value="搜尋本版" onclick="this.value=''" style="padding:5px;float:left;height:18px;width:180px; margin:1px 1px -1px 1px" />
<input type="hidden" name="fid" value="<?=$gfid;?>" />
<a class="button" onclick="$('#fidforum').submit();"><span class="ui-icon ui-icon-search"></span></a>
</form>
</div>
<div style="padding-left:5px">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2146633441538112";
/* RF 版規旁 */
google_ad_slot = "7781310872";
google_ad_width = 234;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</td>
<td valign="top">
	<table width="100%" cellspacing="0" cellpadding="2">
	<tr ><td valign="top" class="ui-widget-header">版主公告</td></tr>
	<tr ><td valign="top" class="ui-widget-content" style="border-top:none">
	<div style="min-height:60px; max-height:100px; overflow-y:auto">
	<?php echo trim($row_getType['intro']) == "" ? "沒有公告" : $bbcode->Parse($row_getType['intro']); ?>
	</div>
	</td>
	</tr></table>
</td>

</tr>
</table>

此區版面修改中...
<div class="clear"></div>

<div style="float:right">
<?if($gtag!=""){?><a href='viewforum.php?fid=<?=$gfid;?>' class='button'>所有文章</a><?}?>
	<?php if(($noguest != true || $isLog == true)&& $isnormal == true){?>
		<a href="#adsb4post" class='button'>發新主題</a>
	<?php } ?>
</div>
<div class="clear"></div>
</div>



<div style='width:400px' class='left'>
	<?php foreach($getConList as $v){ ?>

	<div class='left' style='width:90px; height:20px; line-height:20px; margin:3px; overflow:hidden'>
		<? if($gtag == trim($v)){?><img src="/images/topichot.gif" alt='hot'/><? }else{ ?><img src="/images/topicnew.gif" alt='new' /><?}?>
		<a <? if($gtag == trim($v)){?>style='font-weight:bold'<?}?> title='<?=trim($v);?>' href="viewforum.php?tag=<?=trim($v);?>&amp;fid=<?=$gfid;?>">
		<?=$v ?></a>

	</div>
	<?php } ?>
</div>
<div style='width:550px; border-left:1px solid; padding-left:10px' class='left'>
<h3><?if($gtag==""){?>最新文章<?}else{?><?=$gtag;?><?}?></h3>
<table width="100%" border="0" cellpadding="1" cellspacing="0" class="viewmain">
	<tr class="ui-widget-header" style="font-weight:normal">
		<td width="25"></td>
		<td style="padding:5px">標題<a href="viewforum.php?fid=<?=$gfid;?>&amp;order=gp" <?=$gorder=="gp"?"style='font-weight:bold'":"";?> >GP</a></td>
		<td width="30">
			<a href="viewforum.php?fid=<?=$gfid;?>&amp;order=commentnum" <?=$gorder=="commentnum"?"style='font-weight:bold'":"";?>>回覆</a>
		</td>
		<td width="30">
			<a href="viewforum.php?fid=<?=$gfid;?>&amp;order=views" <?=$gorder=="views"?"style='font-weight:bold'":"";?> >人氣</a>
		</td>
	</tr>
	<?php foreach($latest as $v){ ?>
	<tr class="articlelist ui-widget-content" valign="top">
		<td align="center">
			<? if($v['commentnum'] > 20){?><img src="/images/topichot.gif" alt='hot' /><?}else{ ?><img src="/images/topicnew.gif" alt='new' /><?}?>
		</td>
		<td style="padding:8px">
		<a target="_blank" href='thread.php?tid=<?=$v['id'];?>'><?=$v['title'];?></a>
		<?php if($row_getConList['tpraise']>0){echo "<strong>GP x ".$row_getConList['tpraise']."</strong>";} ?>
		</td>
		<td><span style="color:red"><?=$v['commentnum']; ?></span></td>
		<td><?php echo $v['views']; ?></td>
	</tr>
	<?php } ?>
</table>
</div>

<div style="padding:10px" class='clear' id="adsb4post">

<?php if($noguest != ture || $isLog == true){?>
	<?php if($row_getType['name']!=""){include_once("templatecode/quickpost.php");} ?>
<?php }else{ ?>
	本版塊必需先登入才可以發表主題!
<?php } ?>
</div>
</div>

<script type="text/javascript">
/* <![CDATA[ */
var maxpage = <?=$totalPages_getConList;?>;
var currentpage = <?=$page;?>;

	$(document).keydown(
	
	function(e){
if (e == null) {
key = event.keyCode;
tagname = e.srcElement.tagName;
} else { // mozilla
key = e.which;
tagname = e.target.tagName;
}	
		if(tagname == 'INPUT' || tagname == 'TEXTAREA') return;

		if(key == 39 && currentpage != maxpage) {
			window.location = 'viewforum.php?fid=<?=$gfid?>&page=<?=($page+1)?>';
		}
		if(key == 37 && currentpage != 0) {
			window.location = 'viewforum.php?fid=<?=$gfid?>&page=<?=($page-1)?>';
		}
		if(key == 74) {
			window.location = 'index.php';
		}
	}
	
	);
/* ]]> */
</script>
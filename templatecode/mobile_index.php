<table width="100%">
	<tr class="indexstat">
		<td align="center" style=" border-right:1px solid #CCC"><strong><?=dbRs("SELECT count(*) FROM zf_reply");?></strong><br />貼子</td>
		<td style=" border-right:1px solid #CCC" align="center"><strong><?=dbRs("SELECT count(*) FROM zf_contentpages");?></strong><br />主題</td>
		<td style=" border-right:1px solid #CCC" align="center"><strong><?=dbRs("SELECT count(*) FROM zf_user");?></strong><br />會員</td>
		<td align="center"><strong><?=dbRs("SELECT count(*) FROM zf_reply WHERE date(datetime) = date(now()) ");?> 帖</strong><br />今日</td>
	</tr>
</table>
<? if(!$isLog){?>
	<strong>快速登入</strong>
	<br />
	<form name="loginform" method="post" action="http://members.zkiz.com/processlogin.php">
		名稱:<input type="text" name="username" style="width:90px" />
		密碼:<input type="password" name="password" style="width:90px" />
		<input type="hidden" name="refer" value="<?=curURL();?>" />
	<input type="submit" name="Submit" value="登入" /></form>
	<hr />	
<? }?>
<a class='button' href='#forumlist' style='width:160px;padding:5px;background:#CCC'>到板塊列表</a>
<div class='ui-widget-content reply'>
	<div class="ui-widget-header">各區最後回覆</div>
	<?php foreach($getNew as $v){?>
		<div style='border-bottom:1px solid #CCC;padding:3px'>
			
			
			<div style="font-weight:bold">
				<a href="thread.php?tid=<?php echo $v['lasttid']; ?>">	
				<?=htmlspecialchars($v['lasttitle']); ?>				
				</a>
				<?php if($v['subtitle']!=""){?>
					
				<?php } ?>
			</div>
			
			<div class='mason_small'>
				<?=timeago(strtotime($v['datetime'])); ?> 
				@<a href="viewforum.php?fid=<?=$v['id'];?>"><?=$v['name'];?></a>
				~<a href="userinfo.php?zid=<?=$v['lastaid']?>"><?=$v['lastusername']?></a>
				
			</div>
		</div>
	<?php }?>
</div>
<a id="forumlist"></a>
<?$getCate = dbAr("SELECT * FROM zf_cate ORDER BY `order`");$getForums=dbAr("SELECT * FROM zf_contenttype ORDER BY postcount");?>
<?php foreach($getCate as $row_getCate) { 
	if($row_getCate['id']==6 && ($userinfo['birthday']=='0000-00-00' || getAge($userinfo['birthday'])<18 )){break;}
$tmpi = 0;?>
<div class='ui-widget-content reply'>
	<div class="ui-widget-header"><?=$row_getCate['name']?></div>
	<?php foreach($getForums as $row_getForums) { ?>
		<?php if($row_getForums['cate']==$row_getCate['id'] && $row_getForums['postcount']!= 0){?>
			<table>
				<tr>
					<td class="ui-widget-content bottom-only" width="25%">
						
						<?php if($row_getForums['icon_blob']!=""){?>
							<img width="<?=$picwidth;?>" height="<?=$picwidth;?>" src="data:image/jpg;base64,<?=base64_encode($row_getForums['icon_blob']);?>" class="left" alt="zone_icon" style="margin:2px 5px 2px 2px" /> 
						<?php } ?>
						
						<div class="">
							<div style="padding:2px 0">
								<strong style="font-size:16px"><a href="viewforum.php?fid=<?php echo $row_getForums['id']; ?>"><?php echo htmlspecialchars($row_getForums['name']); ?></a></strong>
								<br />
								(主題:<?=$row_getForums['threadcount']; ?> 回覆:<?=$row_getForums['postcount']; ?>)
								<?php if($row_getForums['allowguest']==1 || $isLog){?><a href="post.php?fid=<?php echo $row_getForums['id']; ?>&amp;type=post" style="font-weight:bold;text-decoration:none">+</a><?php } ?>
							</div>
							
							<a href="thread.php?tid=<?php echo $row_getForums['lasttid']; ?>&amp;lastpage=1"><?php echo mb_substr($row_getForums['lasttitle'],0,12,'UTF-8')."..."; ?></a>
						</div>
						</td>
				</tr>
			</table>
		<?php } ?>	
	<?php } ?>
</div>
<?php } ?>

<div class='ui-widget-content reply'>
	<a href="http://feeds.feedburner.com/RealForum" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon16x16.png" alt="" style="vertical-align:middle;border:0"/></a>&nbsp;<a href="http://feeds.feedburner.com/RealForum" rel="alternate" type="application/rss+xml">在閱讀器訂閱</a>
	<br />
	<form action="search.php" method="get" name="hdform2" onmouseover="document.hdform2.kw.focus()">
		<input name="kw" type="text" size="40" style="width:150px" />
		<input name="" type="submit" value="版塊搜尋" />
		<input type="hidden" name="MM_update" value="form" />
	</form><br />
	<a class="button" href="createworld.php">按此申請無盡的選擇</a>
	
	<div class="clear"></div>
</div>
<script type="text/javascript">
	$(function() {
		
		$("#accordion").accordion(
		{autoHeight: false,
		navigation: true}
		).show();
	});
	
	
</script>
<div style="padding:4px">
	
	<?php if($boardInfo['icon'] != ""){ ?>
		<div class="left">
			<img src="<?=$boardInfo['icon'];?>" alt="icon" width="60" />
			
		</div>
	<?php } ?>	
	<div class="left">
		<h3><?php echo $htmltitle; ?></h3>
	</div>
	
	<div class="clear"></div>
	(主題:<?php echo $totalRows_getConList; ?>) 
	
	<form method="get" action="search.php" id="fidforum">
		
		<input type="text" name="fidq" size="10" class="" value="搜尋本版" onclick="this.value=''"  />
		<input type="hidden" name="fid" value="<?=$gfid;?>" />
		<input type='submit' value='搜索' />
		<?php if(($noguest != true || $isLog == true)&& $isnormal == true){?><a href="post.php?type=post&amp;fid=<?=$gfid;?>"><img src="images/newthread.gif" alt="new thread" /></a><?php } ?>
	</form>
	
	<div class="clear"></div>
	<div class='pagination'>
	<?php pagin($page, $currentPage, $queryString_getConList, $totalPages_getConList);?>
	</div>
</div>


<?php if($totalRows_getConList>0){ ?>
	<table width="100%" cellspacing="0" cellpadding="1">
		
		<?php foreach($getConList as $row_getConList){ ?>
			
			<?php 
				if($row_getConList['special'] < 0){$totid = abs($row_getConList['special']);}else{$totid = $row_getConList['id'];}
			$commentnum = $row_getConList['commentnum']-1;?>
			
			<tr class="articlelist ui-widget-content authorbar" style='font-size:12px;padding:0;margin:0;background:#EDEDED'>
				<?php if($row_getConList['special'] >= 0){ ?>
					<td align="center">by:</td>
					<td><a href="userinfo.php?zid=<?php echo $row_getConList['authorid']; ?>"><?php echo $row_getConList['aname']; ?></a></td>
					<td><span style="color:red"><?=$commentnum+1; ?></span></td>
					<td><?php echo $row_getConList['views']; ?></td>
					<td>
						<?php if($commentnum >= 0){?>
							<a href="userinfo.php?zid=<?php echo $row_getConList['lastid']; ?>"><?php echo $row_getConList['rname']; ?></a>
							<?=timeago(strtotime($row_getConList['lastdatetime'])); ?>
							<?php }else{?>
							未有回覆
						<?}?>
					</td>
					<?php }else{ ?> 
					<td colspan="5"><a href="userinfo.php?zid=<?php echo $row_getConList['authorid']; ?>"><?php echo $row_getConList['aname']; ?></a> : <?=timeago(strtotime($row_getConList['lastdatetime'])); ?></td>
				<?php }?>
			</tr>
			
			<tr class="articlelist ui-widget-content" valign="top">
				<td style="padding:8px" colspan="5">
					<div>
					<a style='font-size:1.05em;' href="thread.php?tid=<?=$totid;?>"><?=htmlspecialchars($row_getConList['title']); ?></a>
					</div>
					<?php if($commentnum>$reply_perpage){ ?>
						<div class="left pagination clear">
							<?php 
								$nop = floor($commentnum/$reply_perpage);
								
								for($i=$j=0;$i<=$nop;$i++){
									if($i < 8 || $i+2 > $nop){
										echo "&nbsp;<a href=\"thread.php?page=".$i."&amp;tid=".$row_getConList['id']."\">".($i+1)."</a>";
										}else{
										if($j++ < 1){
											echo " ..";
										}
									}
								}
							?>
						</div>
					<?php } ?>
					
					<div class='left' style='padding:5px'>
					<?php if($row_getConList['isdigest'] == 1){ ?><span style="color:#F60; font-weight:bold">[精華]</span><?php } ?>
					<?php if($row_getConList['isshow'] == 2){ ?><span style="color:#06C; font-weight:bold">[置頂]</span><?php } ?>
					<?php if($row_getConList['special'] == 1){ ?><span style="color:#600; font-weight:bold">[投票]</span><?php } ?>
					<?php if($row_getConList['special'] < 0){ ?><span style="color:#2D2; font-weight:bold">[捷徑]</span><?php } ?>
					<?php if($row_getConList['tpraise'] > 0){echo "<strong>GP x ".$row_getConList['tpraise']."</strong>";} ?>
					</div>

					<div class='clear'></div>
				</td>
			</tr>
			
		<?php }//end while ?>
		
	</table>
	
	
	<div>
		<div class="pagination">
			<?php pagin($page, $currentPage, $queryString_getConList, $totalPages_getConList);?>
		</div>
		<div class='clear'>
			<?php if(($noguest != true || $isLog == true)&& $isnormal == true){?>
				<a href="post.php?type=post&amp;fid=<?=$gfid;?>"><img src="images/newthread.gif" alt="new thread" /></a>
			<?php } ?>
		</div>
		<br />
	</div>
	<?php }else{ ?>
	<div style="padding:10px">
		這個地方未有貼子，趕快發一個吧!
	</div>
<?php } ?>
<div id="adsb4post" style="padding:10px 0"></div>

<?php if($noguest != ture || $isLog == true){?>
	<?php if($boardInfo['name']!=""){include(template("quickpost"));} ?>
<?php }else{ ?>
	本版塊必需先登入才可以發表主題!
<?php } ?>

<?if ($isadmin == 1 || $isadmin == 9) {?>
	<div style="padding:8px">
		
		<a onclick="dialog('ajaxbox/modiintro.php?typeid=<?=$gfid;?>','修改本區公告')">本區公告</a>
		<a onclick="dialog('ajaxbox/modicityname.php?typeid=<?=$gfid;?>','修改本區名稱')">本區名稱</a>
		<a onclick="dialog('ajaxbox/modicityicon.php?typeid=<?=$gfid;?>','修改本區圖示')">本區圖示</a><br />
		<a onclick="dialog('ajaxbox/modimods.php?typeid=<?=$gfid;?>','修改本區版副')">本區版副</a>
		<a onclick="dialog('ajaxbox/modiisguest.php?typeid=<?=$gfid;?>','容許訪客發貼')">容許訪客發貼</a>
		<a onclick="dialog('ajaxbox/modicate.php?typeid=<?=$gfid;?>','分類')">分類</a>
		
	</div>
<?}?>	
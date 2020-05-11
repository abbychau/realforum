	
<h1><?php echo $row_getUserInfo['username']; ?></h1>

<div style='margin:0 0 1em 0'>
	<div>
		<ul class='nav nav-pills nav-pills-sm left'>
		<li <?if($gShow=='quote'){?>class="active"<?}?>>
		<a href="userinfo.php?zid=<?=$gZid;?>&show=quote">摘錄</a>
		</li>
		<li <?if($gShow=='reply'){?>class="active"<?}?>>
		<a href="userinfo.php?zid=<?=$gZid;?>&show=reply">回覆</a>
		</li>
		<li <?if($gShow=='topic'){?>class="active"<?}?>>
		<a href="userinfo.php?zid=<?=$gZid;?>&show=topic">主題</a>
		</li>
		<li <?if($gShow=='replied_topics'){?>class="active"<?}?>>
		<a href="userinfo.php?zid=<?=$gZid;?>&show=replied_topics">回覆主題表</a>
		</li>
		
		</ul>
		<!--
			<a href="userinfoxxxxxx.php?zid=<?=$gZid;?>&show=repliedtopic" <?if($gShow=='repliedtopic'){?>style="font-weight:bold"<?}?>>參與的主題</a>
		-->
	</div>
	<div class='right'>
		<a class='btn btn-primary'><i class="fa fa-facebook"></i> 分享到 Facebook</a>
	</div>
	
	<div class='clear'></div>
</div>

<?if(sizeof($cities)>0 && ($gShow !='quote')){?>
	<div class='well'>
	<ul class='nav nav-pills nav-pills-sm'>
		<?php foreach ($cities as $row_getCities){ ?>
			<li  <?if($gCate==$row_getCities['id']){?>class='active'<?}?>>
				<a href="userinfo.php?zid=<?=$gZid;?>&cate=<?=$row_getCities['id']; ?>&show=<?=$gShow;?>">
					<?php echo $row_getCities['name']; ?> 
				</a>
			</li>

			<?if($gCate==$row_getCities['id']){?>
			<li class='active'>
			<a target='_blank' href='/viewforum.php?fid=<?=$row_getCities['id'];?>'><span class='glyphicon glyphicon-new-window'></span></a>
			</li>
			<?}?>
		<?php }?>
	</ul>
	</div>
<?}?>

<div class='row'>
	

	<div class='col-xs-12 col-sm-12'>
		<div class='panel panel-default panel-body'>
		<?php if(!$getConList){?>
			沒有記錄
			<?}else{?>
			<table width="100%"  class='viewmain table table-hover table-bordered'>
				
				<thead style="font-weight:bold">
					<?if($gShow == "topic" || $gShow == "reply"){?>
						<th style="padding:5px">標題</th>
						<th width="30">回覆</th>
						<th width="30">人氣</th>
						<?if($gShow != "reply"){?>
						<th width="130">版塊</th>
						<?}?>
					<?php } ?>
					<?if($gShow == "quote"){?>
						<th style="padding:5px">摘錄</th>
						<th width="130">日期</th>
						<th width="50">來源</th>
					<? }?>
				</thead>
				
				
				
				<?php foreach($getConList as $row_getConList){?>
					<?if($gShow == "topic" || $gShow == "reply" || $gShow == "repliedtopic"){?>
						<tr class="">
							<td style='padding:5px;'>
								<a href="thread.php?tid=<?php echo $row_getConList['id']; ?>"><?php echo $row_getConList['title']; ?></a>
								<?php if($row_getConList['isdigest'] == 1){ ?>
									<span style="color:#F60; font-weight:bold">[精華]</span>
								<?php } ?>
								<?php if($row_getConList['isshow'] == 2){ ?>
									<span style="color:#06C; font-weight:bold">[置頂]</span>
								<?php } ?>
							</td>
							<td width="70"><?php echo $row_getConList['commentnum']; ?></td>
							<td width="70"><?php echo $row_getConList['views']; ?></td>
							<?if($gShow != "reply"){?>
								<td><?=$row_getConList['forumname'];?></td>
							<?}?>
						</tr>
						<?if($gShow == "reply"){?>
							<tr class="">
								<td colspan="4">
									<div style="padding:5px; overflow:hidden; font-size:9pt ">
										<span class='label label-default'>發表於<strong><?=$row_getConList['datetime'];?></strong></span>
										<div style="margin-top:1em">
										<?=nl2br(mb_substr($row_getConList['content'],0,200,"UTF8")); ?>
										<? (mb_strlen($row_getConList['content'],"utf8")>200)?"...":"";?>
										<br />
										<? if($row_getConList['picurl']){?>
										<strong>圖片/PDF:</strong> <a href="<?=$row_getConList['picurl'];?>"><?=$row_getConList['picurl'];?></a>
										<?}?>
										</div>
									</div>
								</td>
							</tr>
						<?}?>
					<?}?>
					<?if($gShow == "quote"){?>
						<tr class="">
							<td style='padding:8px'>
								<span class="glyphicon glyphicon-tag"></span> <?=$row_getConList['quote'];?>
							</td>
							<td style='font-size:9pt'>
								<?=timeago(strtotime($row_getConList['timestamp']));?>
							</td>
							<td>
								<a href='<?=$row_getConList['from'];?>'>連結</a>
							</td>
						</tr>
					<? }?>
					<?if($gShow == "replied_topics"){?>
						<tr class="">
							<td colspan="3" style='padding:8px'>
								<div style="font-weight:bold;">
								<a href="/thread.php?tid=<?=$row_getConList['id'];?>"><?=$row_getConList['title'];?></a>
								</div>
								<small>
								查看: <?=$row_getConList['views'];?> 回覆: <?=$row_getConList['commentnum'];?> 最後回覆: <?=timeago(strtotime($row_getConList['lastdatetime']));?>
								</small>	
							</td>
						</tr>
					<?}?>
				<? } ?>
				
			</table>
			<?php pagin($page, $currentPage, qryStrE("page", $_SERVER['QUERY_STRING']), $totalPages_getConList);?>
		<?}?>
		
		</div>
	</div>
</div>

<h1><a href="userinfo.php?zid=<?=$gZid;?>" style="text-decoration:none"><?php echo $row_getUserInfo['username']; ?></a></h1>
<small>
	<form method="get" action="search.php" id="aidforum">
		<div class="input-group input-group-sm">
			<input type="text" name="akw" placeholder="搜尋<?php echo $row_getUserInfo['username']; ?>"  class="form-control"  />
			<input type="hidden" name="aid" value="<?=$gZid;?>" />
			<div class="input-group-btn">
				<a class="btn btn-default btn-sm" onclick="$('#aidforum').submit();">搜尋</a>
			</div>
		</div>
	</form>
</small>
	

<?if(sizeof($cities)>0){?>
	<div class='well'>
	<ul class='nav nav-pills'>
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
		<a href="userinfo.php?zid=<?=$gZid;?>&show=replied_topics">回覆過的主題</a>
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

<div class='row'>
	
	<div class='col-xs-12 col-sm-3'>
		<div class='panel panel-body'>
			<?php if($row_getUserInfo['pic']!=""){ ?><img src="<?php echo $row_getUserInfo['pic']; ?>" alt="avatar" width="100%" /><br /><?php } ?>
			<strong>ZID:</strong> <?php echo $row_getUserInfo['id']; ?><br />
			<strong>用戶名:</strong> <?php echo $row_getUserInfo['username']; ?><a href="pm.php?toid=<?=$row_getUserInfo['id']; ?>"><img src="images/pm.png" alt="pm" /></a><br />
			<?php if($row_getUserInfo['url']!=""){ ?>
			<strong>網站:</strong> <a href="<?php echo $row_getUserInfo['url']; ?>">按此進入</a><br /><?php } ?>
			<strong>最後登入時間:</strong><br />
			<?=$row_getUserInfo['lastlogin']; ?><br />
			<strong>用戶組:</strong> <?php echo $row_getUserInfo['usertype']; ?><br />
			<strong>發貼數:</strong> <?php echo $row_getUserInfo['postnum']; ?><br />
			
			<strong>金錢:</strong> <?php echo $row_getUserInfo['score1']; ?><br />
			<strong>秘寶:</strong> <?php echo $row_getUserInfo['score2']; ?>
			<?php if($row_getUserInfo['bronze']+$row_getUserInfo['silver']+$row_getUserInfo['gold']){?>
				<?php 
					$badgetext = "成就:";
					$badgetext .= $row_getUserInfo['gold']?"{$row_getUserInfo['gold']}金":"";
					$badgetext .= $row_getUserInfo['silver']?"{$row_getUserInfo['silver']}銀":"";
					$badgetext .= $row_getUserInfo['bronze']?"{$row_getUserInfo['bronze']}銅":"";
				?>
				
				<div class='pd5 medals' title="<?=$badgetext;?>" style="cursor:pointer;font-size:8px" onclick="checkArch(<?=$row_getUserInfo['authorid'];?>)">
					<div class="gold left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $row_getUserInfo['gold']);?></div>
					<div class="silver left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $row_getUserInfo['silver']);?></div>
					<div class="bronze left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $row_getUserInfo['bronze']);?></div>
				</div>
			<?}?>
			<? if($row_getUserInfo['signature'] != ""){?>
				<hr />
				<strong>簽名:</strong><br />
				<?php echo $bbcode->Parse($row_getUserInfo['signature']); ?>
			<?}?>
		</div>
		
		<?if(sizeof($cities)>0){?>
			<div class='panel panel-default'>
			<div class='panel-heading'>
				<h3 class='panel-title'>領有城鎮</h3>
			</div>
				<div class='panel-body'>
					<?php foreach ($cities as $row_getCities){ ?>
						<a href="viewforum.php?fid=<?php echo $row_getCities['id']; ?>"><?php echo $row_getCities['name']; ?></a><br />
					<?php }?>
				
			</div>
			</div>
		<?}?>
	</div>
	<div class='col-xs-12 col-sm-9'>
		<div class='panel panel-default panel-body'>
		<?php if(!$getConList){?>
			沒有記錄
			<?}else{?>
			<table width="100%"  class='viewmain table table-hover table-bordered'>
				
				<tr style="font-weight:bold">
					<?if($gShow == "topic" || $gShow == "reply" || $gShow == "repliedtopic"){?>
						<td style="padding:5px">標題</td>
						<td width="30">回覆</td>
						<td width="30">人氣</td>
						<?if($gShow != "reply"){?>
						<td width="130">版塊</td>
						<?}?>
					<?php } ?>
					<?if($gShow == "quote"){?>
						<td style="padding:5px">摘錄</td>
						<td width="130">日期</td>
						<td width="50">來源</td>
					<? }?>
				</tr>
				
				
				
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
								<td colspan="4" >
									<div style="padding:5px; overflow:hidden; opacity:0.9 ">
										發表於<strong><?=$row_getConList['datetime'];?></strong><br /><br />
										<?php echo $bbcode->Parse(mb_substr($row_getConList['content'],0,200,"UTF8")); ?>...<br />
										<?php parsePicurl($row_getConList['picurl']);?>
									</div>
								</td>
							</tr>
						<?}?>
					<?}?>
					<?if($gShow == "quote"){?>
						<tr class="">
							<td class='bold' style='padding:8px'>
								<?=$row_getConList['quote'];?>
							</td>
							<td style='font-size:12px'>
								<?=$row_getConList['timestamp'];?>
							</td>
							<td>
								<a href='<?=$row_getConList['from'];?>'>連結</a>
							</td>
						</tr>
					<? }?>
					<?if($gShow == "replied_topics"){?>
						<tr class="">
							<td >
							<small>
								<?=$row_getConList['views'];?> / 
								<?=$row_getConList['commentnum'];?>
							</small>	
							</td>
							<td class='bold' style='padding:8px'>
							<small>
								<?=$row_getConList['datetime'];?>
							</small>
							</td>
							<td class='bold' style='padding:8px'>
								<a href="/thread.php?tid=<?=$row_getConList['id'];?>"><?=$row_getConList['title'];?></a>
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

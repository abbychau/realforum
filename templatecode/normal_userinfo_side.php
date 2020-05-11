	
	<div class="well">
		
			<?php if(isAvatarSet($row_getUserInfo["username"])){ ?><img src="<?=getAvatarURL($row_getUserInfo["username"],200) ?>" alt="avatar" width="100%" /><br /><?php } ?>
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
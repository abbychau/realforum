<?php 
	require('Connections/zkizblog.php'); 
	require('include/common.inc.php');
	if($isLog==false){die("Please Login First!");}
	
	function archQuery($sql){
		global $gId, $pId, $gUsername;
		$tmp = str_replace('{zid}',$gId,$sql);
		return dbRs($tmp);
	}
	
	$pId = intval($_GET['id']);
	$htmltitle = "成就系統";
	
	
	if($_GET['action']=="claim"){
		$row = dbRow("SELECT * FROM zm_badges WHERE id = {$pId}");
		$claimInfo = dbRow("SELECT * FROM zm_zid_badge WHERE zid = {$gId} AND badge = {$pId}");
		if($claimInfo){
			//claimed
			
			}else{
			
			
			$current_process = archQuery($row['sql']);
			$requirement = $row['minimum'];
			$rank = $row['rank'];
			
			if($current_process>=$requirement){
				$rankName = array(1=>"bronze",2=>"silver",3=>"gold");
				dbQuery("UPDATE zf_user SET {$rankName[$rank]} = {$rankName[$rank]} + 1 WHERE id = {$gId}");
				dbQuery("INSERT IGNORE INTO zm_zid_badge SET zid = {$gId}, badge = {$pId}");
				} else {
				
			}
			
		}
	}
	
	$archs = dbAr("SELECT * FROM zm_badges");
	$acquired_arr = dbAr("SELECT * FROM zm_zid_badge WHERE zid = {$gId}");
	foreach($acquired_arr as $v){
		$acquired[] = $v['badge'];
	}
	
include_once('templatecode/header.php'); ?>

<h1><a href='/achievements.php'>成就</a></h1>

	
	<div class="panel panel-default panel-body">
		<div class='row'>
			<div class='col-xs-12 col-sm-6'>
			
				<?php if($my['pic']!=""){ ?><img src="<?php echo $my['pic']; ?>" alt="avatar" width="200" /><br /><?php } ?>
			</div>
			<div class='col-xs-12 col-sm-6'>
				<strong>ZID:</strong> <?php echo $my['id']; ?><br />
				<strong>用戶名:</strong> <?php echo $my['username']; ?><br />
				<?php if($my['url']!=""){ ?>
				<strong>網站:</strong> <a href="<?php echo $my['url']; ?>">按此進入</a><br /><?php } ?>
				<strong>最後登入時間:</strong><br />
				<?php echo $my['lastlogin']; ?><br />
				<strong>用戶組:</strong> <?php echo $my['usertype']; ?><br />
				<strong>發貼數:</strong> <?php echo $my['postnum']; ?><br />
				<strong>金錢:</strong> <?php echo $my['score1']; ?><br />
				<strong>秘寶:</strong> <?php echo $my['score2']; ?>
			</div>
		</div>
	</div>
	
	<div class='panel panel-default panel-body'>
		<style>
			.archs{float:left;width:150px;
			padding:0.7em;
			margin: 2px 2px 2px 1em;
            }
			.archs a{color:#fff;font-weight:bold}
			.rank3{background:#883;}
			.rank2{background:#888;}
			.rank1{background:#88C;}
			.rank3, .rank2,.rank1{color:#FFF;}
			.finished-icon,.unfinished-icon{padding:7px 0}
			.unfinished-icon{color:#AAA;}
			.finished-icon{color:#333;}
		</style>
		<div class="clear"></div>
		
		
		
		<?php if($_GET['action']=="claim"){ ?>
			<div class='archs rank<?=$row['rank'];?>' style='width:auto'>
				<?=$row['rank'];?>級成就<br/>
				<span style="font-size:20px;font-weight:bold"><?=$row['name'];?></span><br />
				<?=$row['description']; ?>
			</div>
			<div class='clear'>
				<? if($claimInfo){?>
					在<?=$claimInfo['timestamp'];?>已經達成<strong><?=$row['name'];?></strong>成就了!
					<?}else{?>
					
					<?	if($current_process>=$requirement){?>
						恭喜你達成目標, 取得<strong><?=$row['name'];?></strong>成就!
						<button onclick="postToFeed()">分享到Facebook</button>
						<script> 
							function postToFeed() {
								// calling the API ...
								var obj = {
									method: 'feed',
									redirect_uri: '<?=$g_domain;?>/achievements.php',
									link: '<?=$g_domain;?>/achievements.php',
									picture: 'http://openstudiocoach.com/wp-content/uploads/2011/05/achievement.jpg',
									name: '成就',
									caption: 'RF成就: <?=$row['name'];?>',
									description: '我在RealForum 解鎖<?=$row['name'];?>成就了!'
								};
								
								function callback(response) {
									//
								}
								
								FB.ui(obj, callback);
							}
							
						</script>
						
						
						<? }else{ ?>
						很抱歉, 你還未達成目標... 進度: <strong><?=$current_process?> / <?=$requirement;?></strong>
					<? } ?>
				<?}?>
			</div>
			<? }else{?>
			選取下面成就標題以解鎖成就。
		<?}?>
		<hr />
		<div class='row'>
			<?php for($i = 1; $i <=3 ;$i++){?>
				<div class=' col-xs-12 col-sm-6 col-md-4'>
					<h3><?=$i;?>級成就</h3>
					<? foreach($archs as $row){ ?>
						<?if($row['rank']==$i){?>
							<div class='left' style="font-size:60px;line-height:60px;">
								<?if($acquired && in_array($row['id'],$acquired)){?>
									<span class='finished-icon glyphicon glyphicon-ok-circle'></span>
									<?}else{?>
									<span class='unfinished-icon glyphicon glyphicon-remove-circle'></span>
								<?}?>
							</div>
							<div class='archs rank<?=$row['rank'];?>'>
								<a href="?action=claim&amp;id=<?=$row['id'];?>" style='font-size:18px;font-weight:bold'><?=$row['name'];?></a><br />
								<?=$row['description']; ?>
							</div>
							<div class='clear'></div>
						<? } ?>
						
					<? } ?>
				</div>
			<? } ?>
		</div>
		
	</div>
	
<hr />
<?php include_once('templatecode/footer.php'); ?>							
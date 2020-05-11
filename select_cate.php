<?php 
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php');
	
	if($_GET['select_id']){
		$cate = intval($_GET['select_id']);
		dbQuery("UPDATE zf_user SET prefered_cate = $cate WHERE id = $gId");
		header("location:index.php");
		exit;
	}
	$getCate = dbAr("SELECT * FROM zf_cate ORDER BY `order`");
	
	function compareDatetime($a,$b){
		return $a['datetime']>$b['datetime']? -1 : 1;
	}
	
	$getForums = dbAr("SELECT * FROM zf_contenttype WHERE lastaid != 0 ORDER BY `order` ASC, `postcount` DESC");
	
	$htmltitle = "版塊列表"; 
	
	include(template("header"));
	
?>
<style type="text/css">
	
	.item{
	padding: 0.2em;
	background-color: white;
	border: 1px solid #DEDEDE;
	float: left;
	}
	
</style>


<h1>選擇偏好分類</h1>
<hr />
<div class='panel'>
	<div class="panel-body">
	<?php foreach($getCate as $row_getCate) {?>
		
		<?php if($row_getCate['id']==6 && ($userinfo['birthday']=='0000-00-00' || getAge($userinfo['birthday'])<18 )){break;}?>
		
		<div style='max-height:1000px;'>
			
			<h2><?=$row_getCate['name'];?> <a href="/select_cate.php?select_id=<?=$row_getCate['id'];?>" class='btn btn-primary'>選擇此類</a></h2>

            <div class="row">
            <?php foreach($getForums as $row_getForums) { ?>
			
				<?php if($row_getForums['cate']==$row_getCate['id'] && $row_getForums['postcount']!= 0){?>
					
					<?php $allid[] = $row_getForums['id']; ?>
					
					<div class='col-xs-12 col-sm-6 col-md-3'>
						
						<?php if($row_getCate['id']==0){?>
							<a class='newsmallfont' href="viewforum.php?fid=<?php echo $row_getForums['id']; ?>"><?=htmlspecialchars($row_getForums['name']); ?></a>
						<?}else{?>

								<strong>
									<a href="viewforum.php?fid=<?php echo $row_getForums['id']; ?>"><?php echo htmlspecialchars($row_getForums['name']); ?></a>
								</strong>
						
								<div class='newsmallfont'>(帖子數:<?=$row_getForums['postcount']; ?>)</div>
							
						<? } ?>
					</div>
				<? } ?>
			<? } ?>
            </div>
		</div>
		<div class='clear'></div>
		
	<?php } ?>
    </div>
</div>

<hr />

<? include(template("footer")); ?>
<?
	include_once($_SERVER['DOCUMENT_ROOT'].'/Connections/zkizblog.php');
	if(!$getForums){
		$getForums = dbAr("SELECT cate, postcount, id, name, allowguest FROM zf_contenttype ORDER BY postcount DESC", 3600);
	}
	if(!$getCate){
		$getCate = dbAr("SELECT `font-icon`, name, id FROM zf_cate ORDER BY `order`", 3600);
	}
?>

<ul class="nav nav-pills nav-stacked">
	<?php foreach($getCate as $row_getCate) { ?>
	
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class='glyphicon <?=$row_getCate['font-icon'];?>'></span> <?=$row_getCate['name']?><span class="caret"></span>
			</a>
			<ul class="dropdown-menu" role="menu">
				<?php foreach($getForums as $row_getForums) { ?>
					<?php if($row_getForums['cate']==$row_getCate['id'] && $row_getForums['postcount']!= 0){?>
						<li><a href="viewforum.php?fid=<?php echo $row_getForums['id']; ?>"><?php echo htmlspecialchars($row_getForums['name']); ?>(<?php echo $row_getForums['postcount']; ?>)</a></li>
					<?php } ?>	
				<?php } ?>	
			</ul>
		</li>
	<?php } ?>
</ul>

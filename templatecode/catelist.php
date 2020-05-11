<?
	include_once($_SERVER['DOCUMENT_ROOT'].'/Connections/zkizblog.php');
	$catelist = dbAr("SELECT cate, postcount, id, name, allowguest FROM zf_contenttype WHERE cate = 2 ORDER BY postcount DESC");
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">版塊列表</h4>
	</div>
	
	
	<ul class="list-group">
	<?php foreach($catelist as $v) { ?>
	
		<li  class="list-group-item"><a href="viewforum.php?fid=<?php echo $v['id']; ?>"><?php echo htmlspecialchars($v['name']); ?>(<?php echo $v['postcount']; ?>)</a></li>
		
	<?php } ?>
	</ul>
</div>

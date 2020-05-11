<?php 
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php');


function compareDatetime($a,$b){
	return $a['datetime']>$b['datetime']? -1 : 1;
}

$getNew = dbAr("SELECT * FROM zf_contenttype ORDER BY `datetime`  DESC LIMIT 10");
	usort($getNew,"compareDatetime");
	
	$htmltitle = "最後回覆"; 
	
	
	$nosidebar = true;
	
	
	include(template("header"));
	
?>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.1/masonry.pkgd.min.js"></script> 
<style type="text/css">
	
	.masonary .item{
	padding:3px;
	width:230px;
	margin:4px;
	background-color: white;
	border: 1px solid #DEDEDE;
	}
	
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			各區最後回覆
		</h3>
	</div>
	<ul class="list-group">
		<?php foreach($getNew as $v){?>
				<li class="list-group-item">
					<a href="thread.php?tid=<?php echo $v['lasttid']; ?>"><?=htmlspecialchars($v['lasttitle']); ?></a>
					<?php if($v['subtitle']!=""){?><?php } ?>
					<span class="badge" style='font-size:0.7em'><?=timeago(strtotime($v['datetime'])); ?></span>
					<span class="badge" style='font-size:0.7em'><a href="userinfo.php?zid=<?=$v['lastaid']?>"><?=$v['lastusername']?></a></span>
					<span class="badge" style='font-size:0.7em'><a href="viewforum.php?fid=<?=$v['id'];?>"><?=$v['name'];?></a></span>
				</li>
			<?php }?>
	</ul>
</div>

<script type='text/javascript'>
	$(window).load(function(){
		
		
		$(".masonary").masonry({
			itemSelector : '.item',  
			cornerStampSelector: '.corner-stamp'
		});
	});
</script>
<?
	include(template("footer"));
?>
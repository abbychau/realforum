<?php
	include("Connections/zkizblog.php");
	include("include/common.inc.php");
	
	$htmltitle="RealForum 排行榜";
	$postRank = dbAr("SELECT postnum, username, id FROM zf_user WHERE id != 733 ORDER BY postnum DESC LIMIT 15");
	$hotZone = dbAr("SELECT id,name,postcount FROM zf_contenttype ORDER BY postcount DESC LIMIT 15");
	$hotReply = dbAr("SELECT id,title,commentnum FROM zf_contentpages ORDER BY commentnum DESC LIMIT 15");
	$hotViewReply = dbAr("SELECT id,title,views FROM zf_contentpages ORDER BY views DESC LIMIT 15");
	$hotPraiseReply = dbAr("SELECT id,title,tpraise FROM zf_contentpages ORDER BY tpraise DESC LIMIT 15");
	
	//$birthday = dbAr("SELECT id,username,birthday FROM zf_user WHERE birthday != '0000-00-00' ORDER BY birthday");
	$achievement = dbAr("SELECT id,pic,username,gold,silver,bronze FROM zf_user WHERE bronze != 0 ORDER BY gold DESC, silver DESC, bronze DESC LIMIT 20");
	
	include("templatecode/header.php");
?>


<h1>排行榜</h1>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">發貼排行</a></li>
		<li><a href="#tabs-2">分區排行</a></li>
		<li><a href="#tabs-3">最多回覆</a></li>
		<li><a href="#tabs-4">最多查看</a></li>
		<li><a href="#tabs-5">最多GP</a></li>
		<li><a href="#tabs-7">成就榜</a></li>
		<li><a href="#tabs-8">升級表</a></li>
	</ul>
	<div id="tabs-1">
		<ol>
			<?foreach($postRank as $v){
			?>
			<li>
				<a href="userinfo.php?zid=<?=$v['id']?>"><?=$v['username']?></a>(<?=$v['postnum']?>)
			</li>
			<? } ?>
		</ol>	
	</div>
	<div id="tabs-2">
		<ol>
			<?foreach($hotZone as $v){
			?>
			<li>
				<a href="viewforum.php?fid=<?=$v['id']?>"><?=$v['name']?></a>(<?=$v['postcount']?>)
			</li>
			<? } ?>
		</ol>
	</div>
	<div id="tabs-3">
		<ol>
			<?foreach($hotReply as $v){
			?>
			<li>
				<a href="thread.php?tid=<?=$v['id']?>"><?=$v['title']?></a>(<?=$v['commentnum']?>)
			</li>
			<? } ?>
		</ol>
	</div>
	<div id="tabs-4">
		<ol>
			<?foreach($hotViewReply as $v){
			?>
			<li>
				<a href="thread.php?tid=<?=$v['id']?>"><?=$v['title']?></a>(<?=$v['views']?>)
			</li>
			<? } ?>
		</ol>
	</div>
	<div id="tabs-5">
		<ol>
			<?foreach($hotPraiseReply as $v){
			?>
			<li>
				<a href="thread.php?tid=<?=$v['id']?>"><?=$v['title']?></a>(<?=$v['tpraise']?>)
			</li>
			<? } ?>
		</ol>
	</div>
	<div id="tabs-7">
		<table border="1"  style="font-size:18px">
			<tr style="font-weight:bold"><td>會員</td><td>金</td><td>銀</td><td>銅</td></tr>
			<? foreach($achievement as $v){?>
				<tr><td><img src="<?=$v['pic'];?>" alt="avatar" width="100" /><br /><a href="/m/<?=$v['username'];?>"><?=$v['username'];?></a></td><td><?=$v['gold'];?></td><td><?=$v['silver'];?></td><td><?=$v['bronze'];?></td></tr>
			<?}?>
		</table>
	</div>
	<div id="tabs-8">
		<table border="1">
			<tr><td>等級</td><td>發貼數</td></tr>
			<? 
				$tmpprev = -1;
				for($i=1;$i<=100;$i++){
					$postnum = rank2postnum($i);
					if($tmpprev!=$postnum){?>
					<tr><td><?=$i;?></td><td><?=$postnum;?></td></tr>
					<?
					$tmpprev=$postnum;} 
				?>
			<?}?>
		</table>
	</div>
</div>
<script type='text/javascript'>
	$( "#tabs" ).tabs().show();
</script>
<hr />
<?
	include("templatecode/footer.php");
?>			

<? if((stristr($_SERVER['PHP_SELF'],"/cate.php") || stristr($_SERVER['PHP_SELF'] ,"/index.php")) && $my['prefered_cate'] == 2 ){?>
<div class="panel panel-default">
	<div class="panel-heading"><h3 class="panel-title"><span class='glyphicon glyphicon-star'></span> 本週熱門股票</h3></div>
	<div class='panel-body' >
		<ol style="margin-left: -2em;">
			<?foreach($hotStockArr as $v){?>
				
				<li><a href='/thread.php?tid=<?=$v['tid'];?>'><em><strong><?=$v['tag']?></strong></em> : <?=$v['title'];?></a></li>
				<?if (++$i == 10){break;}?>
			<?}?>
		</ol>
	</div>
</div>
<? } ?>


<? if(!$gNoAds && !$gNoSideAds){?>
	<div class='panel panel-default' style='overflow:hidden;'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- rf_responsive_side -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4549800596928715"
     data-ad-slot="9406326986"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	</div>
<?}?>

<?if(false && $isLog){?>
<div><?include(template('bookmark'));?></div>
<?}?>
<?if(false && $getForumsInCate && !stristr($_SERVER['PHP_SELF'],"viewforum.php")){?>
	<? if(!$gHideCateInSidebar){?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">同區版塊</h4>
			</div>
			
		
		<ul class="list-group">
			<? foreach($getForumsInCate as $v){?>
				<li  class="list-group-item"><a href="viewforum.php?fid=<?=$v['id'];?>"><?=$v['name'];?></a></li>
			<?}?>
			
		</ul>
	</div>
	<a href='/forums.php' target='_blank' class='btn btn-default' style='width:100%'>所有版塊列表</a>
	<?}?>
<?}else{?>
	
	<div class='panel panel-default'>
		
		
		<div class="btn-group" style='width:100%'>
			<a href='/forums.php' class='btn btn-default' style='width:50%'>版塊列表</a>
			<a href='/info_board_last_reply.php' class='btn btn-default' style='width:50%'>各區最後回覆</a>
		</div>
	</div>
<?}?>
<div class='panel panel-default'>
	<div class='panel-heading'>
		<h4 class='panel-title'>最近搜索</h4>
	</div>
	
	
	<div class='panel-body' style="">
		<? foreach($recentTags as $tag1){?>
			<span class='badge'><a href="gSearchResult.php?q=<?=str_replace(" ","+",$tag1['tag']);?>"><?=mb_substr($tag1['tag'],0,12,'utf8');?></a></span>
		<?}?>
		
		<form method="get" action="/gSearchResult.php"  style='width:100%;padding:0.1em'>
			<div class="input-group input-group-sm">
				
				<input type="text" name="q" placeholder="全文搜索"  class="form-control" value="<?=htmlentities($_GET['q']);?>"  />
				<div class="input-group-btn">
					<button type='submit' class="btn btn-default">搜尋</button>
				</div>
			</div>
		</form>
	</div>
</div>

	
	
	<? if(!$gNoAds && false){?>
	<div style='overflow:hidden;max-height:300px'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- RealForum Responsive Frame -->
<ins class="adsbygoogle"
     style="display:block;"
     data-ad-client="ca-pub-4549800596928715"
     data-ad-slot="6886034184"
     data-ad-format="auto"  data-ad-region="ads2"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	</div>
	<?}?>
	
<? if(
	//!(stristr($_SERVER['PHP_SELF'] ,"cate") || stristr($_SERVER['PHP_SELF'],"index.php")) &&
	cacheGet("RF_LAST_THREAD_PER_BOARD")
	){?>
	<div class='scroll_container'>
<div class="panel panel-default snap" data-spy="affix" data-offset-top="2100">
	<div class="panel-heading">
		<h4 class="panel-title">每區新帖</h4>
	</div>
	<ul class="list-group">
		<?php foreach(cacheGet("RF_LAST_THREAD_PER_BOARD") as $v){ ?>
			<li class="list-group-item">
				<a href="viewforum.php?fid=<?=$v['id'];?>"><?=mb_substr(htmlspecialchars($v['name']),0,10,'utf-8'); ?></a><br />
				　<a href="/thread.php?tid=<?=$v['lasttid']; ?>" title='由<?=$v['lastusername']?>在<?=timeago(strtotime($v['datetime'])); ?>於<?=$v['name'];?>發表'><?=mb_substr(htmlspecialchars($v['lasttitle']),0,30,'utf-8'); ?></a> (<?=timeago(strtotime($v['datetime'])); ?>)
			</li>
		<?}?>
	</ul>
	
<? if(!$gNoAds && !$gNoSideAds){?>
	<div class='panel panel-default' style='overflow:hidden;'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- rf_responsive_side -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4549800596928715"
     data-ad-slot="9406326986"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	</div>
<?}?>
</div>
</div>

<?}?>
<? if(in_array(basename($_SERVER["SCRIPT_FILENAME"]),["cate.php","index.php"])){
?>
<div class="fb-page" data-href="https://www.facebook.com/zkizcom" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/zkizcom"><a href="https://www.facebook.com/zkizcom">zkiz.com</a></blockquote></div></div>
<?}?>



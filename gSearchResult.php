<?php
    include_once('Connections/zkizblog.php');
    include_once('include/common.inc.php');
	
	$gQ = htmlentities($_GET['q']);
	if(in_array($gQ,["中壢陪搖傳播妹"])){
		$gNoAds = true;
	}
	$gBoard = intval($_GET['board']);
    $htmltitle="全文搜尋 - $gQ";
    $relatedTags = getRelatedTag($gQ);
	if ($gBoard) {
		$cate = dbAr("SELECT cate FROM zf_contenttype WHERE id=$gBoard");
		
		$getForumsInCate = cacheGet("RF_FORUM_IN_CATE_{$cate}");
		
	}
	include(template("header"));

?>
<ol class="breadcrumb">
	<li><a href="/"><span class='glyphicon glyphicon-home'></span> 主頁</a></li>
	<li><a href="/gSearchResult.php">全文搜尋</a></li>
	<li class="active"><?=$gQ;?></li>
	<div class='right'></div>
	
</ol>

<? if($relatedTags){?>
<div class="panel panel-default panel-body pd5">
    <? foreach($relatedTags as $v){?>
        <div style="width:100px;margin-bottom:2px" class="left">
        <a class='btn btn-sm btn-info tag-search' href="/gSearchResult.php?q=<?=$v['tag'];?>"> <span class='glyphicon glyphicon-tag'></span> <?=$v['tag'];?></a>
        </div>

    <?}?>
    <div class="clear"></div>
</div>
<?}?>

<div class="row">
	<div class="<?if($getForumsInCate){?>col-lg-10<?}else{?>col-lg-12<?}?>">
	<form method="get" action="/gSearchResult.php"  style='width:100%;padding:0.1em'>
		<div class="input-group input-group-sm">
			
			<input type="text" name="q" placeholder="全文搜索"  class="form-control" value="<?=$gQ;?>"  />
			<div class="input-group-btn">
				<button type='submit' class="btn btn-default">搜尋</button>
			</div>
		</div>
	</form>

<script>
  (function() {
    var cx = '013715907533463635700:g2eaqs-x1uu';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>


<gcse:searchresults-only></gcse:searchresults-only>
</div>
<?if($getForumsInCate){?>
<div class="col-lg-2">
				
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
				
</div>
<?}?>
</div>
<? if(!$gBoard){?>
    <a class="btn btn-default" href='http://www.zkiz.com/tag.php?tag=<?=$gQ;?>' target="_blank">按我用 ZKIZ TAG 搜尋 [<?=$gQ;?>]</a>
<?}?>
<hr />
<?include(template("footer"));?>
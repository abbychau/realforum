<div class="row">
	<div class='col-xs-12 col-sm-12 col-lg-12'>
		
		<a href="http://realblog.zkiz.com/compose.php" target="_blank" class='btn btn-default'><span class="glyphicon glyphicon-pencil"></span> 發表Blog</a>
		<a href='/plugin/viewforum_linkgen.php' class='btn btn-default'><span class="glyphicon glyphicon-list-alt"></span> 自選版塊連結產生器</a>
			
			<a class='btn btn-primary' href='/attention_input.php'><span class="glyphicon glyphicon-list-alt"></span>新聞通知系統(新加股價資訊)</a>
			<a class='btn btn-default' href='/cate.php'><span class="glyphicon glyphicon-list-alt"></span>cate(testing)</a>
	</div>
</div>
<hr />
<div class="panel panel-default" style="overflow:hidden">
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad Unit #rf_top_728x90 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-4549800596928715"
     data-ad-host="ca-host-pub-6853971558538556"
     data-ad-slot="7870101388"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

<div class="row">
	<div class='item col-xs-12 col-sm-3 col-lg-4'>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class='glyphicon glyphicon-th-large'></span> 本週熱門版塊
			</h3>
		</div>
		<ul class="list-group">
			<? foreach($hotZone as $v){ ?>
				<li class="list-group-item" style='padding:0.2em'>
					<div class='row'>

						<div class='col-xs-8'>
							<a style='font-weight:bold' href='viewforum.php?fid=<?=$v['fid'];?>'><?=$v['name'];?></a><br />
							(<?=$v['ce'];?>)
						</div>
						<div class='col-xs-4'>
								<img src="<?=$v['icon']?$v['icon']:"https://addons.cdn.mozilla.net/img/uploads/addon_icons/435/435262-64.png";?>" alt="zone_icon" style="margin:2px 5px 2px 2px;display:block;width:100%;max-width:2.5em" /> 
						</div>
					</div>
					

					
					
				</li>
				
					<?/*if($i++==0){?>
						<li class="list-group-item" style='padding:0.2em;overflow:hidden'>
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad Unit #rf_main_mid_1_ATF_234x60 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:234px;height:60px"
     data-ad-client="ca-pub-4549800596928715"
     data-ad-host="ca-host-pub-6853971558538556"
     data-ad-slot="7329998180"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</li>
					<?}*/?>
				
			<? } ?>
		</ul>
	</div>
	<div class='panel panel-default pd5'>
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fzkizcom&amp;width&amp;height=395&amp;colorscheme=light&amp;show_faces=false&amp;header=false&amp;stream=true&amp;show_border=false&amp;appId=100109476753790" scrolling="no" frameborder="0" style="border:none; overflow:hidden;width:100%;height:400px;" allowTransparency="true"></iframe>
	<iframe src="//www.facebook.com/plugins/facepile.php?app_id=255045087298&amp;href=https%3A%2F%2Fwww.facebook.com%2Fzkizcom&amp;action=Comma+separated+list+of+action+of+action+types&amp;width&amp;max_rows=7&amp;colorscheme=light&amp;size=large&amp;show_count=true&amp;appId=255045087298" scrolling="no" frameborder="0" style="border:none; overflow:hidden;width:100%;height:400px" allowTransparency="true"></iframe>
	</div>
</div>

<div class='col-xs-12 col-sm-9 col-lg-8'>



<div class="panel panel-default">
<div class='panel-body adv_space'>
<?=$headAdv['content'] ?>
</div>
<div class='pd5' style='color:#CCC'>此廣告由<a href='/m/<?=$headAdv['username'];?>'><?=$headAdv['username'];?></a>所買。想在這裡下廣告嗎? <a href="/advertisement.php">請按我</a></div>
</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class='glyphicon glyphicon-fire'></span> RF 熱門主題
			</h3>
		</div>
		<ul class="list-group">
			<?php foreach($hotTopics as $v){?>
				<? if(sizeof($bannedZid) == 0 || !in_array($v['authorid'],$bannedZid)){ ?>
					<li class="list-group-item">
						<a href="viewforum.php?fid=<?=$v['fid'];?>"><?=$v['forumname'];?></a> :
						<a style='font-weight:bold' href="thread.php?tid=<?=$v['tid'];?>"><?=$v['title'];?></a>
						<span class='badge'><?=$v['rank'];?></span>
					</li>
				<? } ?>
			<? } ?>
		</ul>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class='glyphicon glyphicon-fire'></span> RB熱門文章
			</h3>
		</div>
		<div class='panel-body'>
			
			<div class='row'>
				
				<div class='col-md-8'> 
					<h4><a href="http://realblog.zkiz.com/<?=$rbHotTopic['username'];?>/<?=$rbHotTopic['id'];?>"><?=$rbHotTopic['title'];?></a></h4>
					<?=mb_substr(strip_tags($rbHotTopic['content']),0,100,'utf-8');?>...
				</div>
				
				<div class='col-md-4'> 
					<img src="<?=$rbHotTopic['pic'];?>" width='130' style='padding:5px;' /><br />
					<a href="http://realblog.zkiz.com/<?=$rbHotTopic['username'];?>"><?=$rbHotTopic['blogname'];?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><span class='glyphicon glyphicon-star'></span> 最新金句</h3>
		</div>
		<div class='panel-body'><span><?=$quote['quote'];?></span><br />
			<?=timeago(strtotime($quote['datetime'])); ?> 	
			by :<a href="userinfo.php?zid=<?=$quote['zid'];?>&amp;show=quote"><?=$quote['username'];?></a><a href="<?=$quote['from'];?>">來源</a>
			
		</div>
	</div>
	<? if(!$isMobile){ ?>
	<hr />
	<iframe class="item" src="http://tv.zkiz.com/?box=1" border="0" style="border:1px solid #CCC;width:100%;height:350px" ></iframe>
	<? } ?>
</div>



</div>
<a id="lastreply"></a>
<hr />


<?php if($birthday){?>
	<h3>
		今日壽星
	</h3>
	<div>
		<?php foreach($birthday as $v){?>
			<a href="/m/<?=$v['username'];?>"><?=$v['username'];?></a>
		<?}?>
	</div>
<?}?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class=' glyphicon glyphicon-tree-deciduous'></span> 集放區</h3>
	</div>
	<div class='panel-body'>
		<div class="row">
			<div class='col-xs-12 col-sm-3 col-lg-3'>
				<a href='http://abby.zkiz.com/apps/zkiz_premium/download.htm'>zkiz windows client</a>
			</div>
			<div class='col-xs-12 col-sm-3 col-lg-3'>
				<a class='btn btn-default' href='/trade.php'><span class="glyphicon glyphicon-list-alt"></span> 交易所</a>
			</div>
			<div class='col-xs-12 col-sm-3 col-lg-3'>
				<a href='https://chrome.google.com/webstore/detail/fhpdnpodmpbcoldmepgfobhlngdancik?hl=zh-TW&gl=HK'>Chrome Extension</a>
			</div>
			<div class='col-xs-12 col-sm-3 col-lg-3'>
				<a href="http://tv.zkiz.com">tv.zkiz.com</a>
			</div>
		</div>
		<hr />
		
		<form action="search.php" method="get" name="hdform2">
		<div class="input-group">
			<input name="kw" type="text" placeholder="輸入名字開新區"  class="form-control" />
			<div class="input-group-btn">
				
				<input type="submit" value="確定" class="btn btn-default" />
			</div>
		</div>
	</form>
		<hr />
				
			<a class="btn btn-default btn-sm" href="http://feeds.feedburner.com/RealForum" rel="alternate" type="application/rss+xml">
				<span class="glyphicon glyphicon-leaf"></span> FeedBurner訂閱
			</a>
			<a class="btn btn-default btn-sm" href="merge.php">
				<span class="glyphicon glyphicon-leaf"></span> 按此合併城市
			</a>
			<a class="btn btn-default btn-sm" href="createworld.php">
				<span class="glyphicon glyphicon-leaf"></span> 按此申請無盡的選擇
			</a>	
	</div>
</div>

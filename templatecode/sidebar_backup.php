
<!--
<? if(!(stristr($_SERVER['PHP_SELF'] ,"cate") || stristr($_SERVER['PHP_SELF'],"index.php"))){?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">最新主題</h4>
	</div>
	<ul class="list-group">
		<?php foreach($getNewTopic as $v){ ?>
			
			<?if($previousForumid!=$v['forumid']){?>
			<?if(++$o711==1){?></li><?}?>
			<li class="list-group-item" style="">
				<a href="viewforum.php?fid=<?=$v['forumid'];?>"><?=$v['forumname'];?></a>
				<? $previousForumid=$v['forumid'];?><br />
			<? } ?>
			
			<span style="background:#EEE">
			<?php if($v['isdigest'] == 1 || $v['isshow'] == 2 || $v['views'] > 70 || $v['commentnum'] > 10){ ?>
			<strong>
				<?php if($v['isdigest'] == 1){ ?>[精華]<? } ?>
				<?php if($v['isshow'] == 2){ ?>[置頂]<? } ?>
				<?php if($v['views'] > 70 || $v['commentnum'] > 10){ ?>[熱門]<? } ?>
			</strong>
			<? } ?>
			
			<a style="word-break: break-all;" href="thread.php?tid=<?=$v['id']; ?>" title='由<?=$v['aname']?>在<?=timeago(strtotime($v['datetime'])); ?>於<?=$v['forumname'];?>發表。已被瀏覽<?php echo $v['views']; ?>次。'><?=mb_substr(htmlspecialchars($v['title']),0,30,'utf-8'); ?></a>
			</span>　
			
			
			
		<?php } ?>
	</ul>
</div>
<?}?>

		<?include(template('forumlist'));?>
-->
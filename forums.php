<?php
require_once 'Connections/zkizblog.php';
require_once 'include/common.inc.php';

// //ONE newest PIC or VIDEO
// $getPic = dbAr("SELECT b.title, picurl, fellowid FROM zf_reply a, zf_contentpages b
// WHERE picurl <> ''
// AND (
// (picurl LIKE '%youtube.com/v/%' AND SUBSTRING(picurl, -1) <> '/')
// OR lower(SUBSTRING(picurl, -3)) IN ('jpg','gif','png','bmp','jpeg')
// )
// AND b.id = a.fellowid
// ORDER BY datetime DESC LIMIT 6",60*10);
// foreach($getPic as $i=>$row_getPic){
//     if(is_numeric(strpos($row_getPic['picurl'], "youtube.com/v/"))){
//         preg_match('/youtube\.com\/v\/([\w\-]+)/', $row_getPic['picurl'], $match);
//         $arrfiles[]="http://img.youtube.com/vi/".$match[1]."/0.jpg";
//         $pic[$i]['file']="http://img.youtube.com/vi/".$match[1]."/0.jpg";
//         $pic[$i]['thumb']="http://img.youtube.com/vi/".$match[1]."/1.jpg";
//         }else{
//         $pic[$i]['file']=$row_getPic['picurl'];
//         $pic[$i]['thumb']=$row_getPic['picurl'];
//     }
//     $pic[$i]['link']="thread.php?tid=".$row_getPic['fellowid'];
//     $pic[$i]['title']=$row_getPic['title'];
// }

// function compareDatetime($a,$b){
//     return $a['datetime']>$b['datetime']? -1 : 1;
// }
$getCate = dbAr("SELECT * FROM zf_cate ORDER BY `order`");

$getForums = dbAr("SELECT * FROM zf_contenttype ORDER BY `order` ASC, `postcount` DESC");
$htmltitle = "版塊列表";
$nosidebar = true;
$picwidth = 30;

include template("header");

?>
<style type="text/css">

	.item{
	width:100%;
	padding:0.2em;
	border-bottom:1px solid #DDD;
	}

</style>

<div class='panel' style='padding:1em'>

	<?php foreach ($getCate as $row_getCate) {?>

		<?php unset($allid);if ($row_getCate['id'] == 6 && ($userinfo['birthday'] == '0000-00-00' || getAge($userinfo['birthday']) < 18)) {break;}?>



		<div class='board_of_<?=$row_getCate['id'];?>' style='max-height:1000px;'>

			<h2><?=$row_getCate['name'];?></h2>


			<?php foreach ($getForums as $row_getForums) {?>



				<?php if ($row_getForums['cate'] == $row_getCate['id'] && $row_getForums['postcount'] != 0) {?>
					<?$showcate[$row_getCate['id']] = true;?>
					<?php $allid[] = $row_getForums['id'];?>

					<div class='item'>

						<?php if ($row_getCate['id'] == 0) {?>
							<a class='newsmallfont' href="viewforum.php?fid=<?php echo $row_getForums['id']; ?>"><?=htmlspecialchars($row_getForums['name']);?></a>
						<?} else {?>

							<?php if ($row_getForums['icon'] != "") {?>
								<img width="<?=$picwidth;?>" height="<?=$picwidth;?>" src="<?=$row_getForums['icon'];?>" class="left" alt="zone_icon" style="margin:2px 5px 2px 2px; border-radius:2px; border:1px solid #EEE" />
							<?} else {?>
								<div style='margin:2px 5px 2px 2px;height:<?=$picwidth;?>px;width:<?=$picwidth;?>px' class='left'></div>
							<?}?>
							<div>
								<strong>
									<a href="viewforum.php?fid=<?php echo $row_getForums['id']; ?>"><?php echo htmlspecialchars($row_getForums['name']); ?></a>
								</strong>

								<!-- <?php if ($row_getForums['allowguest'] == 1 || $isLog) {?>
									<a class='newsmallfont' href="post.php?fid=<?php echo $row_getForums['id']; ?>&amp;type=post">發帖</a>
								<?php }?><br /> -->

								<span class='newsmallfont'>(帖子數:<?=$row_getForums['postcount'];?>)</span>

							</div>
							<div class='clear'></div>
						<?}?>
					</div>
				<?}?>

			<?}?>

			<div class='clear'></div>
			<!-- <?if ($allid) {?>
			<a href='viewforum.php?fid=<?=implode("_", $allid);?>' >"<?=$row_getCate['name'];?>"區塊全部帖子</a><?php unset($allid);?>
			<?}?> -->
		</div>
        <?php if (!isset($showcate[$row_getCate['id']])) {?>
                <script>
                //$(document).load(function(){
                    $(".board_of_<?=$row_getCate['id'];?>").hide()
                //});
                </script>
            <?}?>

	<?php }?>


<hr />
<h2>開新區</h2>
<div class='' style='max-width:320px'>
	<form action="search.php" method="get" name="hdform2">
		<div class="input-group">
			<input name="kw" type="text" placeholder="輸入區名"  class="form-control" />
			<div class="input-group-btn">

				<input type="submit" value="確定" class="btn btn-default" />
			</div>
		</div>
	</form>
</div>

</div>



<hr />
<!-- <script type='text/javascript'>
	$(window).load(function(){


		$(".masonary").masonry({
			itemSelector : '.item',
			cornerStampSelector: '.corner-stamp'
		});
	});
</script> -->
<?
include template("footer");
?>
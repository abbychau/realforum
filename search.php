<?php
require_once('Connections/zkizblog.php');
require_once('include/common.inc.php');
$htmltitle = "搜尋";

//搜版塊
if (isset($_GET["kw"])) {
	if (trim($_GET["kw"]) == "") {
		screenMessage("Error", "Cannot search empty keyword");
	}
	$getKw = trim($_GET['kw']);

	$tmpFid = dbRs("SELECT id FROM zf_contenttype WHERE name = ?", [$getKw]);
	if ($tmpFid != false) {
		header("LOCATION: /viewforum.php?fid=$tmpFid");
	} else {
		$likeList = dbAr("SELECT * FROM zf_contenttype WHERE name LIKE ?", ["%$getKw%"]);

		if (!$likeList) {
			header("LOCATION: /build.php?kw=" . urlencode($_GET["kw"]));
			exit;
		}
	}
}

//搜全文
if (isset($_GET['q']) && false) {
	exit;
	//performance issue;
	$q = trim($_GET["q"]);

	if ($isLog == true) {

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
		$startRow_getConList = $page * $maxRows;

		$pageArr = dbAr("SELECT a.id, datetime, title, fellowid, content FROM zf_reply a, zf_contentpages b WHERE a.fellowid = b.id AND content LIKE ? ORDER BY a.id DESC LIMIT $page, 20",["%$q%"]);

		useMoney(1, $gId);
		$queryString = qryStrE("page", $_SERVER['QUERY_STRING']);
	}
}

//搜版塊文
if (isset($_GET['fid'])) {
	exit;
	//performance issue;
	$q = trim($_GET["fidq"]);
	$fid = intval($_GET["fid"]);
	if ($isLog == true) {

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
		$startRow_getConList = $page * $maxRows;

		$pageArr = dbAr("SELECT `datetime`, title, fellowid, content FROM zf_reply a, zf_contentpages b WHERE a.fellowid = b.id AND title LIKE ? AND a.fid = $fid ORDER BY a.id DESC LIMIT $page, 20", ["%$q%"]);
		$queryString = qryStrE("page", $_SERVER['QUERY_STRING']);
	}
}

//搜作者
if (isset($_GET['aid'])) {
	exit;
	//injection or performance issue;
	$q = trim($_GET["akw"]);
	$aid = intval($_GET["aid"]);

	$page = isset($_GET['page']) ? $_GET['page'] : 0;
	$startRow_getConList = $page * $maxRows;

	$pageArr = dbAr("SELECT `datetime`, title, fellowid, content FROM zf_reply a, zf_contentpages b WHERE a.fellowid = b.id AND title LIKE ? AND a.authorid = $aid ORDER BY a.id DESC LIMIT $page, 20", ["%$q%"]);
	$queryString = qryStrE("page", $_SERVER['QUERY_STRING']);
}

//搜用戶
if (isset($_GET['member'])) {
	if ($_GET["member"] == "") {
		screenMessage("Error", "Cannot search empty member id.");
	}
	$user = strtolower(trim($_GET['member']));
	$zid = dbRs("SELECT id FROM zf_user WHERE lower(username) = ?", [$user]);
	if ($zid == false) {
		screenMessage("錯誤", "找不到用戶, 請返回", prevURL());
	} else {
		header("location: /userinfo.php?zid=$zid");
	}
}

include(template('header'));
?>
<div class="panel panel-default">
	<div class=" panel-body">
		<form action="search.php">

			<input type="text" name="q" style="width:300px" value="<?= $q ?>" class="pd5 text ui-widget-content ui-corner-all" />
			<input type="submit" name="Submit" value="搜尋" class='button' />
		</form>


		<hr />

		<?php
		if (isset($_GET['q']) || isset($_GET['fidq'])) {
			if ($isLog == true) {
		?>

				<?php foreach ($pageArr as $v) { ?>

					<div class='ui-widget-header' style='padding:5px'>
						<strong><a href="thread.php?tid=<?php echo $v["fellowid"]; ?>"><?= $v["title"]; ?></a></strong>
					</div>


					<div class='ui-widget-content' style='border-top:0; margin-bottom:10px'>
						<a href='thread.php?tid=<?php echo $v["fellowid"]; ?>&floorid=<?php echo $v['id']; ?>' class='button'>到該樓層</a>
						<div style='max-height:200px;overflow-y:scroll'>
							<?php echo nl2br(str_replace($q, "<strong>$q</strong>", $v["content"])); ?>
						</div>
					</div>

				<?php } ?>
				<?php if ($page > 0) { ?><a class="left" href="?page=<?= ($page - 1) . $queryString; ?>&">上二十項</a><? } ?>
				<?php if (sizeof($pageArr) >= 20) { ?><a class="right" href="?page=<?= ($page + 1) . $queryString; ?>">下二十項</a><? } ?>



				<?php } else { ?>請先登入!<?php } ?>
			<?php } ?>

			<? if (isset($_GET['aid'])) { ?>
				<blockquote>

					<?php foreach ($pageArr as $v) { ?>
						<div style="border:2px #ccc solid; padding:5px; margin:5px">
							<strong><a href="thread.php?tid=<?php echo $v["fellowid"]; ?>"><?= $v["title"]; ?></a></strong>
							<hr />
							<?php echo nl2br(str_replace($q, "<strong>$q</strong>", $v["content"])); ?>
						</div>
					<?php } ?>
					<?php if ($page > 0) { ?><a class="left" href="?page=<?= ($page - 1) . $queryString; ?>">上二十項</a><? } ?>
					<?php if (sizeof($pageArr) >= 20) { ?><a class="right" href="?page=<?= ($page + 1) . $queryString; ?>">下二十項</a><? } ?>

				</blockquote>
			<? } ?>


			<?php if ($_GET['kw']) { ?>

				<? if ($likeList) { ?>
					<strong>你是要找以下的版塊嗎?</strong>
					<br />

					<? foreach ($likeList as $row_getForums) { ?>

						<div class='well'>
							<?php if ($row_getForums['icon'] != "") { ?>
								<img src="<?= htmlspecialchars($row_getForums['icon']); ?>" height="40" class="left" style="margin:2px 5px 2px 2px" />
							<?php } ?>

							<div class="indexforumlistitem">
								<div style="padding:2px 0">
									<strong style="font-size:16px"><a href="viewforum.php?fid=<?php echo $row_getForums['id']; ?>"><?php echo htmlspecialchars($row_getForums['name']); ?></a></strong>
									(<?php echo $row_getForums['postcount']; ?>)
									<?php if ($row_getForums['allowguest'] != 0) { ?><a href="post.php?fid=<?php echo $row_getForums['id']; ?>&type=post" style="font-weight:bold;text-decoration:none">+</a><?php } ?>
								</div>

								<a href="thread.php?tid=<?php echo $row_getForums['lasttid']; ?>&amp;lastpage=1"><?php echo $row_getForums['lasttitle'] ?></a>
								by: <a href="userinfo.php?zid=<?= $row_getForums['lastaid']; ?>"><?= $row_getForums['lastusername']; ?></a>
							</div>
						</div>


					<? } ?>


				<? } else { ?>
					<strong>沒有這個版塊呢!</strong>


				<? } ?>
				<strong>
					按下面的按鈕可以開一個新的版塊啊!
				</strong>
				<br />
				<a class="btn btn-default" href="build.php?kw=<?= $getKw; ?>">建立名為"<?= $getKw; ?>"的新版塊</a>

				<hr />
			<?php } ?>

	</div>
</div>


<?php include(template('footer')); ?>
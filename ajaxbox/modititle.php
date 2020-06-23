<?php
define('LITE_HEADER', true);
require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');

$tid = intval($_GET['tid']);
if ($tid == "") {
	$tid = intval($_POST['tid']);
}
$page = intval($_GET['page']);
if ($page == "") {
	$page = intval($_POST['page']);
}

//authorization
$fid = dbRs("SELECT type FROM zf_contentpages WHERE id = {$tid}");
$isauthor = dbRs("SELECT count(*) FROM zf_contentpages WHERE id = {$tid} AND authorid = {$gId}");
if (modRank($fid) == 0 && $gUserGroup <= 7 && $isauthor == 0) {
	die("Access Denied!");
}
//

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$titles = dbRow("SELECT title,subtitle FROM zf_contentpages WHERE id = {$tid}");

if ((isset($_POST["title"])) && ($_POST["title"] != "")) {
	$page = intval($_POST['page']);
	
	dbQuery(
		"UPDATE zf_contentpages SET title = ?, subtitle = ? WHERE id=?",
		[$_POST['title'], $_POST['subtitle'], $tid]
	);

	header("Location:/thread.php?tid={$tid}&page={$page}");
}


$forumArr = dbAr("SELECT id, name FROM zf_contenttype ORDER BY cate");

?>
<form name="formmodi" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="if(getElementById('titlein').value==""){return false;}">

	<input type="text" name="title" id="titlein" value="<?= $titles['title']; ?>" placeholder='修改標題' class='form-control' />
	<input type="text" name="subtitle" value="<?= $titles['subtitle']; ?>" placeholder='修改副標題' class='form-control' />
	<hr />
	<input type="submit" name="button" class="btn btn-primary" value="確定" />

	<input type="hidden" name="tid" value="<?= $tid; ?>" />
	<input type="hidden" name="page" value="<?= $page; ?>" />
</form>
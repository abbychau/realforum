<?php
define('LITE_HEADER', true);
require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');

$typeid = intval($_GET['typeid']);
if ($typeid == "") {
    $typeid = intval($_POST['tid']);
}

//authorize
if (modRank($typeid) == 0 && $gUserGroup <= 8) {
    die("Access Denied");
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if (isset($_POST["MM_update"])) {
    if ($_POST["MM_update"] == "intro") {
        dbQuery(
            "UPDATE zf_contenttype SET `intro`=? WHERE id=?",
            [
                $_POST['intro'],
                intval($_POST['tid'])
            ]
        );
    }

    if ($_POST["MM_update"] == "notice") {
        dbQuery("UPDATE zf_contenttype SET top_notice=? WHERE id=?",[$_POST['top_notice'],$_POST['tid']]);
    }
    
    header("Location:" . "/viewforum.php?fid=" . $_POST['tid']);
}
$row_getIntro = dbRow("SELECT * FROM zf_contenttype WHERE id = $typeid");

?>

<h4>版塊: <?php echo $row_getIntro['name']; ?></h4>
<h5>修改公告</h5>
<form action="<?php echo $editFormAction; ?>" method="POST">
    <textarea name="intro" cols="50" rows="12" style="width:100%" onkeyup="if(this.value.length>=999){alert('不可多於1000字!');}"><?php echo htmlspecialchars($row_getIntro['intro']); ?></textarea>
    <br />
    <input type="submit" name="button" id="button" value="確定">
    <input name="confirm" type="hidden" value="yo">
    <input name="tid" type="hidden" value="<?php echo $_GET['typeid']; ?>" />
    <input type="hidden" name="MM_update" value="intro">

</form>
<h5>修改頂部告示</h5>
<form action="<?php echo $editFormAction; ?>" method="POST">
    <textarea name="top_notice" cols="50" rows="3" style="width:100%" onkeyup="if(this.value.length>=249){alert('不可多於250字!');}"><?php echo htmlspecialchars($row_getIntro['top_notice']); ?></textarea>
    <br />
    <input type="submit" name="button" id="button" value="確定">
    <input name="confirm" type="hidden" value="yo">
    <input name="tid" type="hidden" value="<?php echo $_GET['typeid']; ?>" />
    <input type="hidden" name="MM_update" value="notice">

</form>
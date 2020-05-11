<?
include_once($_SERVER['DOCUMENT_ROOT'].'/Connections/zkizblog.php');
$getForums = dbAr("SELECT cate, postcount, id, name, allowguest FROM zf_contenttype ORDER BY id DESC");

$getCate = dbAr("SELECT name, id FROM zf_cate ORDER BY `order`");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>LIST</title>
<base href="<?=$g_domain;?>/" target="main">
</head>
<body text="#CC0000" bgcolor="#FFFFFF" alink="#FF0099" vlink="#003333" style='font-family:細明體'>
<font size="2">
<a href='<?=$g_domain;?>/post.php?type=post'>發帖</a>
<a href='http://realblog.zkiz.com/compose.php'>發Blog</a>
<br />
<br />
<div id="accordion2">

<strong>特別</strong><br />

	<a href="viewforum.php?type=all">全區</a><br />
    <a href="viewforum.php?type=digest">精華區</a><br />
    
<br />

<?php foreach($getCate as $row_getCate) { ?>

<strong><?=$row_getCate['name']?></strong><br />

	<?php foreach($getForums as $row_getForums) { ?>
		<?php if($row_getForums['cate']==$row_getCate['id'] && $row_getForums['postcount']!= 0){?>
	<a href="viewforum.php?fid=<?php echo $row_getForums['id']; ?>"><?php echo htmlspecialchars($row_getForums['name']); ?></a>(<?php echo $row_getForums['postcount']; ?>)
	<?php if($row_getForums['allowguest']!=0){?><a href="post.php?fid=<?php echo $row_getForums['id']; ?>&type=post" style="font-weight:bold;text-decoration:none">+</a><?php } ?><br />

		<?php } ?>	
	<?php } ?>

<br />
<?php } ?>


</div>
</font>

</body>
</html>
<?php
if ($_GET['type'] == "url"){
	
	$handle = @fopen(htmlspecialchars_decode($_GET['url']), "r");
    
    while (!feof($handle)) {
        $part = fread($handle, 2048);
        $tcontent .= $part;
        if (eregi("</head>", $part)) break;
    }
    fclose($handle);
    $lines = preg_split("/\r?\n|\r/", $tcontent); // turn the content in rows
    $is_title = false; 
	$is_descr = false;
    $close_tag = ($xhtml) ? " />" : ">"; // new in ver. 1.01
    foreach ($lines as $val) {
        if (eregi("<title>(.*)</title>", $val, $title)) {
            $title = $title[1];
            $is_title = true;
        }
        if (eregi("<meta name=\"description\" content=\"(.*)\"([[:space:]]?/)?>", $val, $descr)) {
            $content = $descr[1];
            $is_descr = true;
        }
        if ($is_title && $is_descr) break;
    }
	$nav = '<a href="index.php"><strong>Real Forum</strong></a> → <a href="viewforum.php?fid=1"><strong>吹水</strong></a>';
	$nosidebar = true;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Share to RealForum" />
<meta name="keywords" content="Share, Real Blog, RealForum" />
<meta name="generator" content="RealForum 1.5.0" />
<meta name="author" content="abbychau" />
<meta name="copyright" content="2009 abbychau" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" href="/css/base.css" />
<title>分享到RealForum</title>

</head>
<body>

<div style="padding:10px; background-color:#FFF; background-image:none; border:3px solid #CCCCCC">
分享至: <?=$nav; ?>
<form action="/post.php" method="post" name="form1">
<h4>標題</h4>
<input type="textfield" style="width: 90%;" value="<?=htmlspecialchars($title);?>" name="title" />

<h4>內容</h4>
<textarea style="width: 90%; height: 230px" id="area2" name="content">
<?=$content;?><br />
<?=$_GET['url'];?>
</textarea>

<h4>圖片/影片路徑</h4>
<input type="textfield" style="width: 600px;" value="" name="picurl" />
<br />
<input type="hidden" name="posttype" value="<?=$_GET['type'];?>" />
<input type="hidden" name="fid" value="1" />
<input type="hidden" name="tid" value="<?=$_GET['tid'];?>" />
<input type="submit" value="發表" />
</form>
<br /><br />
</div>
</body></html>
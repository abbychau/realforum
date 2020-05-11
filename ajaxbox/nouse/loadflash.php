<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>flash load</title>
</head>

<body style="margin:0px; padding:0px; background-color:#999">
        <object width="100%" height="100%" style="">
		<param name="wmode" value="transparent" />
        <param name="movie" value="<?php echo $_GET['url']; ?>"></param>
        <param name="allowFullScreen" value="true"></param>
        <param name="allowscriptaccess" value="always"></param>
        <embed src="<?php echo $_GET['url']; ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="100%" height="100%"></embed>
		</object>
</body>
</html>

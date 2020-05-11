<?php include("../Connections/zkizblog.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Real-Speaker</title>
</head>

<body style="margin:0px; background-image:url(../images/blackbar.gif);">
<marquee onmouseout="this.start();" onmouseover="this.stop();" scrolldelay="150" scrollamount="5" direction="left" style="color:#FFF; font-size:12px; margin-top:5px">
<?php
$query_getThread = "SELECT b.username, a.id, a.ownerid, a.content, a.color FROM zf_speaker a, zf_user b WHERE a.ownerid=b.id order by id desc LIMIT 10";
$getThread = mysql_query($query_getThread, $zkizblog) or die(mysql_error());
$row_getThread = mysql_fetch_assoc($getThread);

do{
$str .= $row_getThread['username'].":<span style='color:#".$row_getThread['color']."'>".$row_getThread['content']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
} while ($row_getThread = mysql_fetch_assoc($getThread));

echo "<span style='color:#ff9900; font-weight:bold;'> = Real-Speaker = &nbsp;&nbsp;&nbsp;&nbsp;</span>".$str;

?>
</marquee>
</body>
</html>

<?php
require_once ('Connections/zkizblog.php');

if($_POST['username']=="" || $_POST['password']==""){
	screenMessage("密碼或用戶名錯誤!","請重新登入<br /> <a href='http://members.zkiz.com/forgotpw.php' target='_blank'>忘記密碼</a>");
}

$username = trim($_POST['username']);
if (loginGlobal($username,$_POST['password'])) {
	if($_POST['refer']!=""){header("location:".$_POST['refer']);exit;}
	if($_SERVER['HTTP_REFERER']!=""){header("location:".$_SERVER['HTTP_REFERER']);exit;}
	header("location:http://zkiz.com");exit;
} else {
	screenMessage("密碼或用戶名錯誤!","請重新登入<br /> <a href='http://members.zkiz.com/forgotpw.php' target='_blank'>忘記密碼</a>");
}


$htmltitle = "登入";
include_once ("header.php");
?>
<h3>登入</h3>
<?=$msg;?>
<br />
<a href="javascript:history.back()">回上一頁</a><br />
<?php if($_POST['refer']!=""){ ?><a href="<?=$_POST['refer'];?>">回到建議頁面</a>(<?=$_POST['refer'];?>)<?php } ?>
<?php if($_SERVER['HTTP_REFERER']!=""){ ?><a href="<?=$_SERVER['HTTP_REFERER'];?>">回到登入前頁面</a>(<?=$_SERVER['HTTP_REFERER'];?>)<?php } ?>
<?php include_once("footer.php");?>

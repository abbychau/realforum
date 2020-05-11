<?php 
require_once('Connections/zkizblog.php'); 
require_once('include/common.inc.php');

if($_COOKIE['RF_Sess_Cookie']!=""){
	setcookie('RF_Sess_Cookie', "", time()-3600,"",".zkiz.com");
	$isLog = false;
	header("location:".prevURL());
}else{
	header("location: index.php");
}

?>


<?
include_once($_SERVER['DOCUMENT_ROOT'].'/Connections/zkizblog.php');
//$getForums = dbAr("SELECT cate, postcount, id, name, allowguest FROM zf_contenttype ORDER BY id DESC");

//$getCate = dbAr("SELECT name, id FROM zf_cate ORDER BY `order`");
if(isset($_GET['to'])){
	$url = base64_decode($_GET['to']);
}else{
	$url = "index.php";
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="description" content="zkiz.com提供, 吹水, 遊戲, 論壇, 可以自行創建版塊" /> 
<title>RealForum♪</title> 
<meta name="generator" content="RealForum 3.0" /> 
<meta name="author" content="abbychau" /> 

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
setInterval(function(){
$(document.getElementById("top").contentDocument).find("#a").html(self.parent.frames["main"].location.href);
console.log(  );
},1000);
</script>

<frameset rows="30,*">
<frame name='top' id='top' src="keiji_top.php"></frame>
<frameset cols="260,*">
  <frame src="keiji_list.php" />
  
  <frame src="<?=$url;?>" name='main' id='main' />  
  
</frameset>
</frameset>
</HEAD>
</HTML>

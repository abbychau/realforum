<?php 
require_once('Connections/zkizblog.php');
include('include/common.inc.php');
?>
<?php 
$id = $_GET['id'];
if($id=="stickerwall"){$htmltitle = "貼紙牆";}
if($id=="component_check"){$htmltitle = "分析你的成分";}
if($id=="transbbcode"){$htmltitle = "轉帖工具";}
if($id=="makeidentity"){$htmltitle = "四國身分證產生器";}
if($id=="moss_code"){$htmltitle = "摩斯密碼轉換器";}
if($id=="mentalage"){$htmltitle = "精神年齡鑑定";}

if(!isset($htmltitle)){
	screenMessage("Error","Undefined Plugin");
}
?>
<?php include_once('templatecode/header.php'); ?>
<div class="mainborder" style="padding:20px">
<?php include_once("plugin/$id/$id.php"); ?>
</div>
<?php include_once('templatecode/footer.php'); ?>
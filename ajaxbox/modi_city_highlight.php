<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');

$typeid = intval($_GET['typeid']);
if($typeid==""){$typeid = intval($_POST['typeid']);}

//authorize
//modRank($typeid)!=1 && 
if(modRank($typeid)==0 && $gUserGroup <= 8){die("Access Denied");}

/*
$tmptags = dbAr("SELECT title FROM zf_contentpages WHERE type = $typeid");
foreach ($tmptags as $v){
$ins[] = str_replace(array("專區","專欄","新聞","related:","關係:") , "" , $v['title']);
}
$tmptags = serialize($ins);
dbQuery("update zf_contenttype set highlight = '$tmptags' WHERE id = $typeid");
*/



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);}

if ($_POST['tags']!="") {
	$tag = trim($_POST['tags']);
	$tag = str_replace('\r','\n',$tag);
	$tag = str_replace('\n\n','\n',$tag);
	$tag = trim($tag);
	$tags = explode('\n',$tag);
	$tmptag = serialize($tags);
	dbQuery("update zf_contenttype set highlight = ? WHERE id = $typeid",[$tmptag]);
	header(sprintf("Location: %s", prevURL()));
}

$tag_raw = dbRs("SELECT highlight FROM zf_contenttype WHERE id = $typeid");
if($tag_raw != ""){
	$tags = unserialize($tag_raw);
	$tagsText = implode("\n",$tags);
}
?>
<h4>修改Highlight</h4>

<form name="modtags" action="<?=$editFormAction;?>" method="post">
<textarea name="tags" style="width:100%; height:300px"><?=$tagsText;?></textarea>
<input type='hidden' name='typeid' value='<?=$typeid;?>' />
<br />
<input type='submit' value='修改'/>
</form>

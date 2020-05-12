<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php');
require_once('../include/common.inc.php');

$typeid = intval($_GET['typeid']);
if($typeid==""){$typeid = intval($_POST['tid']);}

//authorize
if(modRank($typeid)!=1 && $gUserGroup <= 7){die("Access Denied");}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);}

if ($_GET['del']!="") {
	$uid = intval($_GET['del']);
	dbQuery("DELETE FROM zf_admin WHERE ownerid = $uid AND fid = $typeid");
	cacheSet("RF_FORUM_ADMIN_{$typeid}",dbAr("SELECT ownerid, username, rank FROM `zf_admin` a, zf_user b WHERE a.ownerid = b.id AND fid = {$typeid}"));
	header(sprintf("Location: %s", prevURL()));
}
if ($_POST['zid']!="") {
	$zid = intval($_POST['zid']);
	dbQuery("INSERT INTO `zf_admin` (`fid` ,`ownerid` ,`rank`)VALUES ('$typeid', '$zid',  '2')");
	
	cacheSet("RF_FORUM_ADMIN_{$typeid}",dbAr("SELECT ownerid, username, rank FROM `zf_admin` a, zf_user b WHERE a.ownerid = b.id AND fid = {$typeid}"));
	header(sprintf("Location: %s", prevURL()));
}

$getMods = dbAr("SELECT ownerid,rank,username FROM zf_admin a,zf_user b WHERE a.ownerid=b.id AND a.fid = $typeid");

?>
<script type="text/javascript">
function toZid(name){
$.get('/ajaxdata.php',{id:name, type: '2'},
	function(data){
		document.getElementById('to_id').value = data;
	});
}
</script>

<h4>修改版副</h4>

ZID轉換:<input name="to_id" type="text" id="to_id" size="10" maxlength="30" value="" /><input name="" type="button" value="名字轉為ZID" onclick="toZid(document.getElementById('to_id').value);" />
<br /><br />
<strong>現有版主</strong>
<br />
<table border="1" cellpadding="5">
<?php foreach($getMods as $row){?>
	<?=$i++%3 == 0?"<tr>":""?>
	<td>
	
<?if($row['rank']==1){?>
	<strong><?=$row['username'];?>(id:<?=$row['ownerid'];?>)</strong>
<?}else{?>
	<?=$row['username'];?>(id:<?=$row['ownerid'];?>) <a href="/ajaxbox/modi_city_mods.php?del=<?=$row['ownerid'];?>&typeid=<?=$typeid;?>">刪除</a>
<?php } ?>
	
	</td>
	<?=$i%3 == 0?"</tr>":""?>
<?php } ?>
</table>
<br /><br />
<strong>增加版副</strong>
<br />
<form name="addadmin" action="/ajaxbox/modi_city_mods.php" method="post">
zid:<input type="text" size="20" name="zid" /><input type="submit" value="增加" />
<input type="hidden" value="<?=$typeid;?>" name="tid">
</form>
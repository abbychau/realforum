<?
include("Connections/zkizblog.php");
include("include/common.inc.php");

if($_GET['move']=="true"){
	$_GET = array_map("intval", $_GET);
	if(in_array(dbRs("SELECT symbol FROM zgame_maze WHERE x={$_GET['x']} AND y = {$_GET['y']} AND mazeid={$_GET['mazeid']} "),array("x","t","h"))){
		//die("wall");
	}else{
		dbQuery("UPDATE zgame_maze_user SET x={$_GET['x']}, y = {$_GET['y']} WHERE zid = $gId");
	}
}
$myinfo = dbRow("SELECT * FROM zgame_maze_user WHERE zid = $gId");
$siteinfo = dbRow("SELECT * FROM zgame_maze WHERE x = {$myinfo['x']} AND y = {$myinfo['y']} AND mazeid = {$myinfo['mazeid']}");
if($siteinfo['light']!=0){
	$myinfo['torch'] = 4;
}
if($siteinfo['to']!=""){
	list($tox,$toy,$toid)=explode(",",$siteinfo['to']);
	dbQuery("UPDATE zgame_maze_user SET x={$tox}, y = {$toy}, mazeid={$toid} WHERE zid = $gId");
	//die("UPDATE zgame_maze_user SET x={$tox}, y = {$toy}, mazeid={$toid} WHERE zid = $gId");
	$myinfo = dbRow("SELECT * FROM zgame_maze_user WHERE zid = $gId");
}

$around = dbAr("SELECT * FROM zgame_maze WHERE 
x >= {$myinfo['x']} - {$myinfo['torch']} AND x <= {$myinfo['x']} + {$myinfo['torch']} AND 
y >= {$myinfo['y']} - {$myinfo['torch']} AND y <= {$myinfo['y']} + {$myinfo['torch']} AND
mazeid = {$myinfo['mazeid']}
");

$gridsize = ($myinfo['torch']*2 + 1) * 32;
$margintop = max((340 - $gridsize) /2,0);
$marginleft = max((340 - $gridsize) /2,0);

?>

<div id='movementscope' style='position:absolute;left:<?=$marginleft ;?>px;top:<?=$margintop ;?>px;height:<?=$gridsize;?>px;width:<?=$gridsize;?>px;'>
<? foreach($around as $v){?>
	<? if($v['x'] != $lastx){echo "<div class='clear'></div>";}$lastx = $v['x'];?>
	
	<div class='maze block<?=$v['symbol'];?> <?=($v['x']==$myinfo['x'] && $v['y']==$myinfo['y'])?"current":"";?>' 
	<?if(!in_array($v['symbol'],array("x","t","h"))){?>
	onclick='javascript:mazego(<?=$v['x'];?>,<?=$v['y'];?>,<?=$myinfo['mazeid'];?>)'
	<?}?>
	>
		<?=($v['x']==$myinfo['x'] && $v['y']==$myinfo['y'])?"<img id='chara' src='maze_default_chara.png' alt='chara' />":"";?>
	</div>
<? }?>
</div>
<script>
$('#toolbar').html('test2');
</script>

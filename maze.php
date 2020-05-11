<?
include("Connections/zkizblog.php");
include("include/common.inc.php");

$myinfo = dbRow("SELECT * FROM zgame_maze_user WHERE zid = $gId");
if(sizeof($myinfo)==0){
dbQuery("INSERT INTO `zgame_maze_user` (
`zid` ,
`mazeid` ,
`x` ,
`y` ,
`torch` ,
`hp` ,
`sp` ,
`atk` ,
`def`
)
VALUES (
'$gId',  '2',  '30',  '30',  '1',  '10',  '10',  '1',  '1'
)");
$myinfo = dbRow("SELECT * FROM zgame_maze_user WHERE zid = $gId");

}

$htmltitle = "Maze";
$description = "A mystery dungeon is waiting for all people";

include_once("templatecode/header.php");
?>
<style type='text/css'>
.blockx{background:grey}
.blocko{background:white}
.blockg{background:green}
.blockt{background:DarkGreen }
.blockm{background:BurlyWood}
.blockh{background:Brown}
.blockw{background:gold}
.maze{float:left; width:32px;height:32px; cursor:pointer; overflow:hidden}
.blocko:hover,.blockm:hover,.blockw:hover{background:#EEE}

.gamediv{height:352px;float:left; color:white;background:black;position:relative}
</style>
<script type='text/javascript'>

function mazego(ix,iy,imazeid){
	$('#gamecon').fadeOut(500,
	
	function(){
		$.get("mazeajax.php",{x:ix,y:iy,mazeid:imazeid,move:'true'},function(data){
			$('#gamecon').html(data);
			$('#gamecon').fadeIn(500);
		});
	}
	
	
	);
	
}

</script>
<div class='forumnav'>
<? echo buildNav(array("Maze"));?>
</div>
<div class='clear'></div>
<div class='gamediv' style='width:120px;border-right:1px #CCC solid;'>
<div style='padding:5px;'>
<img height='100' style='margin:1px 3px' src='<?=isAvatarSet($my["username"])?getAvatarURL($my["username"],150):"images/noavatar.gif"; ?>' alt="avatar" /><br />
名稱: <?=$gUsername;?><br />
等級: <?=$currank;?>級<br />
生命: <?=$myinfo['hp'];?><br />
體力: <span id='datasp'><?=$myinfo['sp'];?></span><br />
攻擊: <?=$myinfo['atk'];?><br />
防禦: <?=$myinfo['def'];?><br />

<hr />
物品:<br />
火把: LV<?=$myinfo['torch'];?><br />
金錢: 0
</div>
</div>
<div class='gamediv' style='width:352px;'>
<div  id='gamecon' >



<div id='toolbar' style='position:absolute;left:5px;bottom:5px;width:200px;background:#DDD;opacity:0.8;padding:3px;color:black'>
<a onclick='' class='button'>test</a>
</div>
</div>
</div>
<script>
mazego(<?=$myinfo['x'];?>,<?=$myinfo['y'];?>,<?=$myinfo['mazeid'];?>);
</script>
<?
include_once("templatecode/footer.php");
?>
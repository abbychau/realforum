<?php 
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php');


function compareDatetime($a,$b){
	return $a['datetime']>$b['datetime']? -1 : 1;
}

$getForums = dbAr("SELECT * FROM zf_contenttype ORDER BY `order` ASC, `postcount` DESC");
$getNew = $getForums;
	usort($getNew,"compareDatetime");
	
	$htmltitle = "各區最後回覆"; 
	
	
	$nosidebar = true;
	
	
	include(template("header"));
	
?>

		<h1>各區最後回覆
		</h1>
<div class='panel panel-default pd5'>
		<table class="table table-default">
		<thead>
		<tr>
		
			<th>主題</th>
			<th width="70">時間</th>
			<th width="90">會員</th>
			<th>版塊</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($getNew as $v){?>
				<tr>
					<td><a href="thread.php?tid=<?php echo $v['lasttid']; ?>"><?=htmlspecialchars(mb_substr($v['lasttitle'],0,50)); ?></a>
						<?php if($v['subtitle']!=""){?><br /><?=$v['subtitle'];?><?php } ?>
						</td>
					
					<td><small><?=timeago(strtotime($v['datetime'])); ?></small></td>
					<td><small><a href="userinfo.php?zid=<?=$v['lastaid']?>"><?=$v['lastusername']?></a></small></td>
					<td><small><a href="viewforum.php?fid=<?=$v['id'];?>"><?=$v['name'];?></a></small></td>
				</tr>
		<?php }?>
		</tbody>
	</table>
</div>

<?
	include(template("footer"));
?>
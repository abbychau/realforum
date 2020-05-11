
在線會員:
<div style='font-size:10pt'>
<?php

$total_online = cacheGet("TOTAL_ONLINE");

$onlineCount = 0;
$onlineGuest = 0; 
foreach($total_online as $v){ 
	if($v['zid']!=733 && $v['zid']!=0){?>
	<div style="width:120px;float:left;"><a class='onlinea' href="/userinfo.php?zid=<?=$v['zid'];?>"><?=$v['username'];?></a></div>
	<?php 
		++$onlineCount;
		}else{
		++$onlineGuest;
	}
}
?>
<div class="clear"></div>
</div>
有<strong><?=$onlineCount;?></strong>個會員和<strong><?=$onlineGuest;?></strong>個訪客

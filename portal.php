<?php
include_once ('Connections/zkizblog.php');
include_once ('include/common.inc.php');
require_once('include/nbbc.php');

$gfid = mysql_real_escape_string($_GET['fid']);
$gtype = mysql_real_escape_string($_GET['type']);
$gorder = mysql_real_escape_string($_GET['order']);
$pfid = ($_POST['fid'] == 0) ? 1 : intval($_POST['fid']);
$currentPage = $_SERVER["PHP_SELF"];

////GET CONLIST////
$maxRows_getConList = 30;
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$startRow_getConList = $page * $maxRows_getConList;

	

	

	//GET ADMINS
	$isadmin = 0;
	$admins = dbAr("SELECT ownerid, username, rank FROM `zf_admin` a, zf_user b WHERE a.ownerid = b.id AND fid = {$gfid} ORDER BY rank");
	foreach($admins as $row) {
		if($row['rank']==1){
			$master .= "<strong>".$row['username']."</strong> ";
		}else{
			$master .= "<em>".$row['username']."</em> ";
		}
		if($gId == $row['ownerid']){$isadmin = $row['rank'];}
	}
	$isnormal = true;
	

if($gUserGroup >= 8){$isadmin = 9;}
$master = $master=="" ? "沒有版主" : $master;

	$row_getType = dbRow("SELECT id, name, intro, allowguest, icon FROM zf_contenttype WHERE id = {$gfid}");
	
//Main list of articles in board
$getConList = dbAr("SELECT d.id, content, title
				   
FROM `zf_reply` a, zf_contenttype b, zf_user c , zf_contentpages d

WHERE a.authorid = c.id 
AND a.fellowid = d.id
AND b.id = d.type
AND b.id = $gfid

order by lastdatetime desc
LIMIT $startRow_getConList, $maxRows_getConList");


//get total rows
$totalRows_getConList = dbRs("SELECT count(*) as ce FROM zf_contentpages WHERE 1=1 $extcon");
$totalPages_getConList = ceil($totalRows_getConList / $maxRows_getConList) - 1; //and totalpage too ^^


//query string
$queryString_getConList = qryStrE("page", $_SERVER['QUERY_STRING']);


//city size
$q2 = sprintf("SELECT count(*) as ce FROM zf_reply a WHERE fid = %s", GetSQLValueString($gfid, "int"));
$r2 = mysql_fetch_assoc(mysql_query($q2, $zkizblog));


$htmltitle = $htmltitle==""?$row_getType['name']:$htmltitle;
$noguest = ($row_getType['allowguest'] == 0)?true:false;

include_once ("templatecode/header.php");
?>

<div class="mainborder">

<div class="tdvfnav">


<div style="height:54px;">
<?php if($row_getType['icon'] != ""){ ?>
<div class="left" style="padding-top:8px">
<img src="<?=$row_getType['icon'];?>" alt="icon" width="50" />
</div>
<?php } ?>
<div class="left">
	<strong><a href="index.php">Real Forum</a></strong> → <strong><?php echo $htmltitle; ?></strong><br />
	<a href='/rss.php?fid=<?=$gfid;?>' style='text-decoration:none; font-size:12px;'>按此訂閱RSS<img src='/images/rss.png' alt='RSS Feed' /></a><br />
	管理人員: <abbr title="(粗體:版主 斜體:版副)"><?php echo $master;?></abbr>
</div>
<div class="right" style="padding:10px;border-right:1px #CCC solid">
<strong style="font-size:20px"><?php echo $r2['ce']; ?></strong><br />
帖子
</div>
<div class="right" style="padding:10px">
<strong style="font-size:20px"><?php echo $totalRows_getConList; ?></strong><br />
主題
</div>
<?if ($isadmin == 1 || $isadmin == 9) {?>
<div class="right" style="padding:8px">
	
	<a onclick="dialog('ajaxbox/modiintro.php?typeid=<?=$gfid;?>','修改本區公告')">本區公告</a>
	<a onclick="dialog('ajaxbox/modicityname.php?typeid=<?=$gfid;?>','修改本區名稱')">本區名稱</a>
	<a onclick="dialog('ajaxbox/modicityicon.php?typeid=<?=$gfid;?>','修改本區圖示')">本區圖示</a><br />
	<a onclick="dialog('ajaxbox/modimods.php?typeid=<?=$gfid;?>','修改本區版副')">本區版副</a>
	<a onclick="dialog('ajaxbox/modiisguest.php?typeid=<?=$gfid;?>','容許訪客發貼')">容許訪客發貼</a>
	<a onclick="dialog('ajaxbox/modicate.php?typeid=<?=$gfid;?>','分類')">分類</a>
	
</div>
<?}?>
</div>
<div class="clear"></div>


<table width="100%" cellspacing="0" cellpadding="0">
<tr><td valign="top">
	<table width="100%" cellspacing="0" cellpadding="2">
	<tr class="ui-widget-header"><td valign="top">版主公告</td></tr>
	<tr><td>
	<?php echo trim($row_getType['intro']) == "" ? "沒有公告" : $bbcode->Parse($row_getType['intro']); ?>
	</td>
	</tr></table>
</td>
<td width="250" valign="top">
<script type="text/javascript"><!--
google_ad_client = "pub-2146633441538112";
/* 250x250, 已建立 2010/7/5 */
google_ad_slot = "0082086043";
google_ad_width = 250;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</td>
</tr>
</table>


<div class="clear"></div>
<div class="left">
	<?php pagin($page, $currentPage, $queryString_getConList, $totalPages_getConList);?>
</div>
<div style="float:right">
	<?php if(($noguest != true || $isLog == true)&& $isnormal == true){?><a href="post.php?type=post&amp;fid=<?=$gfid;?>"><img src="images/newthread.gif" alt="new thread" /></a><?php } ?>
</div>
<div class="clear"></div>
</div>


<?php if($totalRows_getConList>0){ ?>
	<?php foreach($getConList as $row_getConList){ ?>

	<?php 
	if($row_getConList['special'] < 0){$totid = abs($row_getConList['special']);}else{$totid = $row_getConList['id'];}
	$commentnum = $row_getConList['commentnum']-1;?>
		<a href="thread.php?tid=<?=$totid;?>">
		<?php echo htmlspecialchars($row_getConList['title']); ?></a>

        
	<?php if($isLog){ ?> 
		<a style="font-size:12px; color:#CCC; font-weight:100; text-decoration:none; cursor:pointer" onClick="dialog('ajaxbox/delthread.php?tid=<?php echo $row_getConList['id']; ?>&amp;fid=<?=$gfid; ?>','管理',false,360);">管理</a>
	<?php }?>
    
    <br/>
    
<div class="reply">
<?php echo $bbcode->Parse($row_getConList['content']); ?>
</div>
	<?php }//end while ?>


<div style="padding:10px">
<div style="float:left" class="pagin">
	<?php pagin($page, $currentPage, $queryString_getConList, $totalPages_getConList);?>
</div>
<div style="float:right">
	<?php if(($noguest != true || $isLog == true)&& $isnormal == true){?>
		<a href="post.php?type=post&amp;fid=<?=$gfid;?>"><img src="images/newthread.gif" alt="new thread" /></a>
	<?php } ?>
</div>
<br />

<?php }else{ ?>
<div style="padding:10px">
這個地方未有貼子，趕快發一個吧!
<?php } ?><br />

<script type="text/javascript"><!--
google_ad_client = "pub-2146633441538112";
/* 468x60, 已建立 2009/8/12 */
google_ad_slot = "1675737649";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<br /><br />
<?php if($noguest != ture || $isLog == true){?>
	<?php if($row_getType['name']!=""){include_once("templatecode/quickpost.php");} ?>
<?php }else{ ?>
	本版塊必需先登入才可以發表主題!
<?php } ?>
</div>
</div>
<?php 
include_once("templatecode/footer.php");
?>

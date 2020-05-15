<?php 
require_once('../Connections/zkizblog.php');
if($_GET['fid']!=""){
$ArrFiltrate=array("'",";","union"); 
$fid = str_replace($ArrFiltrate,"",$_GET['fid']);
$fidq = "a.type = ".$fid." AND";
$forumname = dbRs("SELECT name from zf_contenttype where fid = ".$fid, $zkizblog);

}
	header("Content-type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<rss version='2.0'>
  <channel>
    <title>最近7日發帖</title>
    <link>{$g_domain}</link>
    <description>Real Forum RSS Feed</description>
	<pubDate>".date("r")."</pubDate>
    <lastBuildDate>".date("r")."</lastBuildDate>";
	
	//START ITEMS
	
	
	$getConList = dbAr("SELECT count(*) as ce, authorid, username FROM zf_reply a, zf_user b where DATEDIFF(CURDATE(), datetime) < 7 AND a.authorid = b.id group by authorid order by ce DESC limit 10");
		
	foreach($getConList as $row_getConList) {
		echo "<item>\n";
		echo "<title>".$row_getConList['username']." (".$row_getConList['ce']."篇)"."</title>\n";
		echo "<link>{$g_domain}/userinfo.php?zid=".$row_getConList['authorid']."</link>\n";
		echo "<description>".$row_getConList['authorid']."(".$row_getConList['ce'].")"."</description>\n";
		echo "</item>\n";
		}
		
		//END ITEMS
	echo "\n</channel>\n</rss>";

exit;

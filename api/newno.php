<?php 
require_once('../Connections/zkizblog.php');

	header("Content-type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<rss version='2.0'>
  <channel>
    <title>最新發帖</title>
    <link>{$g_domain}</link>
    <description>Real Forum RSS Feed</description>
	<pubDate>".date("r")."</pubDate>
    <lastBuildDate>".date("r")."</lastBuildDate>";
	
	//START ITEMS
	
	$query_getConList = "SELECT SQL_CACHE a.fid, a.fellowid, a.username, a.datetime, commentnum, substr(a.title,1,30) as title, b.views, b.isshow, b.isdigest, b.id FROM zf_view_thread a, zf_contentpages b WHERE isfirstpost = 1 AND a.fellowid = b.id ORDER BY id DESC LIMIT 10";
	$getConList = mysql_query($query_getConList, $zkizblog) or die(mysql_error());
	$row_getConList = mysql_fetch_assoc($getConList);

if($row_getNew['isdigest'] == 1){ echo '<span style="color:#F60; font-weight:bold">[精華]</span>';} 
if($row_getNew['isshow'] == 2){ echo '<span style="color:#06C; font-weight:bold">[置頂]</span>'; } 
echo '('.$row_getNew['views'].'/'.$row_getNew['commentnum'].')';
	
	do {
		echo "<item>\n";
		echo "<title>".htmlspecialchars($row_getNew['title'])."</title>\n";
		echo "<link>{$g_domain}/thread.php?tid=".$row_getNew['fellowid']."</link>\n";
		echo "<description>"."作者:".$row_getNew['username']." 發表日期:".$row_getNew['datetime']."</description>\n";
		echo "</item>\n";
		} while ($row_getConList = mysql_fetch_assoc($getConList));
		
		//END ITEMS
	echo "\n</channel>\n</rss>";
mysql_free_result($getConList);

exit;

?>
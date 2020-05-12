<?php 
	require_once('Connections/zkizblog.php');
	include_once('include/common.inc.php');
	require_once('include/nbbc.php');
	
	$fidq = $_GET['fid']==""?"":"AND type IN (".intval($_GET['fid']).")";
	
	$conlist = dbAr("SELECT * FROM zf_contenttype b order by datetime DESC");
	
	header("Content-type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
	<rss version='2.0'>
	<channel>
    <title>Real Forum".$forumname." 最新主題</title>
    <link>{$g_domain}</link>
    <description>Real Forum RSS Feed</description>
	
   	<lastBuildDate>".date("r")."</lastBuildDate>";
	
	//START ITEMS
	
	
	
	
	foreach($conlist as $row_getConList){
		$sp="";
		if($row_getConList['isdigest'] == 1){$sp.="[精華]";}
		if($row_getConList['isshow'] == 2){$sp.="[置頂]";}
		echo "<item>\n";
		echo "<title>".$row_getConList['lasttitle'].$sp."</title>\n";
		echo "<link>{$g_domain}/thread.php?tid=".$row_getConList['lasttid']."</link>\n";
		echo "<pubDate>".date(DATE_RSS,strtotime($row_getConList['datetime']))."</pubDate>\n";
		echo "<description>
		<![CDATA[
		作者:".$row_getConList['lastusername']."<br />".
		"位於:".$row_getConList['name']."<hr />".
		"]]>
		</description>\n";
		echo "</item>\n";
	}
	
	//END ITEMS
	echo "\n</channel>\n</rss>";
	
	exit;
	
?>
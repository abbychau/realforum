<?php
include_once('Connections/zkizblog.php');
die();
$e = dbAr("SELECT id, tags FROM zf_contentpages WHERE tags <> '' AND tags <> 'N;'");
header("content-type:text/plain");
header('Content-Disposition: attachment; filename="downloaded.sql"');
foreach ($e as $v){
	$tag_arr = unserialize($v['tags']);
	if($tag_arr){
	foreach($tag_arr as $tag){
		$t[] = array('type' => 1, 'entry_id'=>$v['id'], 'name'=> trim(($tag)));
	}
	}
}

$e = dbAr("SELECT id, tags FROM zb_contentpages WHERE tags <> ''");
foreach ($e as $v){
	$tag_arr = explode(",",$v['tags']);
	foreach($tag_arr as $tag){
		$t[] = array('type' => 2, 'entry_id'=>$v['id'], 'name'=> trim(($tag)));
	}
}

$e = dbAr("SELECT publicpost_id id, tags FROM stock_publicpost WHERE tags <> ''");
foreach ($e as $v){
	$tag_arr = explode(",",$v['tags']);
	foreach($tag_arr as $tag){
		$t[] = array('type' => 3, 'entry_id'=>$v['id'], 'name'=> trim(($tag)));
	}
}

foreach($t as $v){
	dbQuery("INSERT IGNORE INTO zm_tags SET id = ?",$v['name']);
}

foreach($t as $v){
	dbQuery("INSERT IGNORE INTO zm_tags_entry SET tag_id = (SELECT id FROM zm_tags WHERE tag = ?), entry_type = ?, entry_id=?",[[$v['name']],$v['type'],$v['entry_id']]);
}
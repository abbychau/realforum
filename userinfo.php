<?php 
	
	require_once('Connections/zkizblog.php'); 
	include_once('include/common.inc.php');
	require_once('include/bbcode.php');
	$bbcode=new bbcode();
	
	$gZid = intval($_GET['zid']);
	$gCate = intval($_GET['cate']);
	$gShow = "topic";
	
	//GET user info
	$row_getUserInfo = dbRow("SELECT * FROM zf_user WHERE id = $gZid");
	if(!$row_getUserInfo){
		screenMessage("Error","Member banned or not found.");
	}
	$maxRows_getConList = 30;
	$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
	$startRow_getConList = $page * $maxRows_getConList;
	$cateSql = ($gCate=="")?"":"AND a.type = '$gCate'";
	
	
	//GET user posts
	if($_GET['show'] == "reply"){
		$gShow="reply";
		$query_getConList = "SELECT isdigest, isshow, c.`datetime`, a.`id`, `title`,views, commentnum, content, picurl,praise
		
		FROM `zf_contentpages` a,zf_reply c
		WHERE c.tid = a.id AND a.isshow != 0 AND c.authorid = {$gZid} AND isfirstpost != 1
		
		$cateSql
		
		order by c.`id` desc
		LIMIT $startRow_getConList, $maxRows_getConList";
		
		$cateSql = ($gCate=="")?"":"AND a.fid = '$gCate'";
		$totalRows_getConList = dbRs("SELECT count(*) as ce FROM zf_reply a WHERE authorid = $gZid $cateSql");
	}else if($_GET['show'] == "replied_topics"){
		$gShow="replied_topics";
		
		screenMessage("Feature Disabled","Feature disabled due to high traffic");
		exit;
		$query_getConList = "SELECT distinct a.`id`, isdigest, isshow, a.`lastdatetime`, `title`, views, commentnum
		FROM `zf_contentpages` a 
		INNER JOIN (select distinct tid from zf_reply where authorid = {$gZid} ORDER BY `id` desc limit $maxRows_getConList) b 
		ON a.id = b.tid
		WHERE a.isshow != 0
		$cateSql ORDER BY a.id
		LIMIT $startRow_getConList, $maxRows_getConList";
		
		$totalRows_getConList = dbRs("SELECT count(distinct a.tid) FROM zf_reply a WHERE a.authorid = $gZid",3600*10);
		
	}else if($_GET['show'] == "topic" || $_GET['show'] == ""){
	
		$gShow="topic";
		
		$query_getConList = "SELECT isdigest, isshow, a.`create_timestamp`, a.`id`, `title`, b.name as forumname, b.id as forumid,  views, commentnum
		
		FROM 
		zf_contentpages a,
		zf_contenttype b
		WHERE 
		b.id = a.type
		AND a.isshow != 0
		AND a.authorid = $gZid
		
		$cateSql
		
		order by a.`id` desc
		LIMIT $startRow_getConList, $maxRows_getConList
		";
		
		$totalRows_getConList = dbRs("SELECT count(*) as ce FROM zf_contentpages a WHERE authorid = $gZid $cateSql AND a.isshow != 0");
	}else if($_GET['show'] == "quote"){
	
		$gShow="quote";
		
		$query_getConList = "SELECT * FROM zm_quote WHERe zid = $gZid order by `id` desc limit $startRow_getConList, $maxRows_getConList";
		$totalRows_getConList = dbRs("SELECT count(1) FROM zm_quote WHERE zid = $gZid");
	}
	$getConList = dbAr($query_getConList);
	
	$totalPages_getConList = ceil($totalRows_getConList/$maxRows_getConList)-1; 
	$cities = dbAr("SELECT id, name FROM zf_contenttype a, zf_admin b where a.id = b.fid AND ownerid = {$gZid} AND rank = 1");
	
	$htmltitle = $row_getUserInfo['username'];
	$gCustomSidebar = "userinfo_side";
	include(template("header"));
	include(template("userinfo"));
	include(template("footer"));

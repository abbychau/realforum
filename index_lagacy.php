<?php 
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php');
	
	//quotes
	$quote = dbRow("SELECT  a.zid, b.username, quote,  `from` ,  `timestamp` AS  'datetime'
	FROM zm_quote a, zf_user b WHERE a.zid = b.id ORDER BY a.id DESC LIMIT 1");
	
	/*
		function compareDatetime($a,$b){
		return $a['datetime']>$b['datetime']? -1 : 1;
		}
	*/
	
	//$getCate = dbAr("SELECT * FROM zf_cate ORDER BY `order`");
	
	//top 10 members
	/*
		$getMember = dbAr("SELECT count(*) as ce, authorid, username 
		FROM zf_reply a, zf_user b 
		WHERE date(datetime) = date(now()) 
		AND authorid <> 733 
		AND a.authorid = b.id 
		GROUP BY authorid 
		order by ce DESC LIMIT 10",60*30);
	*/
	$tags=dbAr("SELECT * FROM zm_tags ORDER BY timestamp DESC LIMIT 20");
	foreach($tags as $v){ $keywords.= str_replace("\"","'",$v['tag']).",";}
	$keywords = substr($keywords,0,-1);
	$htmltitle = "RealForum 首頁"; 
	
	
	$rfHotTopic = dbAr("SELECT (views+commentnum*3) as rank, a.authorid, a.id as tid, b.id as fid, commentnum, a.title as title, b.name as forumname FROM `zf_contentpages` a, `zf_contenttype` b where a.type = b.id AND cate <>6 AND datediff(CURRENT_TIMESTAMP, create_timestamp) < 7 ORDER BY rank DESC LIMIT 50",[], 7200);
	$hottedFid = array();
	foreach($rfHotTopic as $k=>$v){
		if(!in_array($v['fid'],$hottedFid)){
			$hottedFid[] = $v['fid'];
			$hotTopics[$v['fid']] = $v;
		}else{
			if($hotTopics[$v['fid']]['rank'] < $v['rank']){
				$hotTopics[$v['fid']] = $v;
			}
		}
	}

	usort($hotTopics, function ($a, $b){return strcmp($a["rank"], $b["rank"]);});
	
	$rbHotTopic = dbRow("SELECT a.id, c.pic, c.username, blogname, title, content, commentnum,datetime FROM  `zb_contentpages` a, zb_user b, zf_user c WHERE b.username=c.username AND a.ownerid = b.id AND b.blacklisted = 0 AND a.datetime >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY views DESC LIMIT 1",[],3600);
	$birthday = dbAr("SELECT id,username,birthday FROM zf_user WHERE birthday =  CURDATE()",[], 3600);
	
	$headAdv = dbRow("SELECT content, username FROM zf_advertisement_record a, zf_user b WHERE a.zid = b.id AND advertisement_id = 1 ORDER BY a.id DESC LIMIT 1");
	
	if($isLog){
		$bannedZid = dbAr("SELECT target_zid FROM zf_relation WHERE source_zid = $gId AND relation_type = 1"); //1=ban 2=friend
		$bannedZid = groupAssoc($bannedZid,'target_zid');
	}
	
	include(template("header"));
	include(template("index_lagacy"));
	include(template("footer"));

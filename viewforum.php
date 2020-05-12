<?php
	include_once ('Connections/zkizblog.php');
	include_once ('include/common.inc.php');
	require_once('include/bbcode.php');
	$bbcode = new bbcode();
	
	$gfid = intval($_GET['fid']);
	$gtype = trim($_GET['type']);
	
	$pfid = ($_POST['fid'] == 0) ? 1 : intval($_POST['fid']);
	$currentPage = $_SERVER["PHP_SELF"];
	$gIsAtlease1 = isset($_GET['atleast1']);
	$gIsMyPosts = isset($_GET['myPosts']);
	
	if($_POST['batchdelete'] == 'true' && $gUserGroup > 7){
		$ids = implode(',',$_POST['deletearr']);
		dbQuery("UPDATE zf_contentpages SET isshow = 0 WHERE `id` IN($ids)");
	}
	
	////GET CONLIST////
	$reply_perpage = 30;
	$maxRows_getConList = 40;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 0;
	$startRow_getConList = $page * $maxRows_getConList;
	
	if(strstr($gfid,"_")){
		$gtype="selected";
		$fids = str_replace("_",",",$_GET['fid']);
		foreach($fids as $v){
			$gFids[] = intval($v);
		}
		$gFids = array_unique($gFids);
		$strFids = implode(",",$gFids);
	}
	if(!$gfid){
		$gtype= $gtype=="digest"?"digest":"all";
	}
	
	switch ($gtype) {
		case "selected":
		$extcon = "AND type IN ( $strFids ) ";
		if(isset($_GET['pin'])){$isshowsql = "isshow DESC,";}
		$htmltitle = "自選區塊(在$gfid)";
		break;
		
		case "all":
		$htmltitle = "全區";
		break;
		
		case "digest":
		$extcon = "AND isdigest = 1 ";
		$htmltitle = "精華區";
		break;
		
		default:
		$extcon = "AND type = $gfid ";
		$isshowsql = "isshow DESC,";
		$boardInfo = dbRow("SELECT * FROM zf_contenttype WHERE id = {$gfid}");
		
		
		if($boardInfo==false){
			screenMessage("錯誤","所選的版塊不存在");
			exit;
		}
		
		if(in_array($gId,explode(",",$boardInfo['banned_member']))){
			$is_banned=true;
		}
		
		//GET ADMINS
		$isadmin = 0;
		$admins = cacheGet("RF_FORUM_ADMIN_{$gfid}");
		foreach($admins as $row) {
			if($row['rank']==1){
				$main_mod['username'] = $row['username'];
				$main_mod['ownerid'] = $row['ownerid'];
			}else{
				
				$tmp['username'] = $row['username'];
				$tmp['ownerid'] 		= $row['ownerid'];
				
				$sub_mod[] = $tmp;
			}
			if($gId == $row['ownerid']){$isadmin = $row['rank'];}
		}
		$isnormal = true;
		
		break;
	}
	switch ($_GET['order']){
		case 'commentnum':
		$ordersql = 'commentnum desc,';
		break;
		case 'views':
		$ordersql = 'views desc,';
		break;
		case 'gp':
		//$ordersql = 'tpraise desc,';
		break;
        case 'topictime':
            $ordersql = 'create_timestamp desc,';
        break;
		default:
		break;
	}
	
	
	$q = htmlentities(safe($_GET['q']));
	if(mb_strlen($q,'utf8')>1){
		//$extcon .= "AND title LIKE '%$q%'";
		header("location:gSearchResult.php?q={$q}+{$boardInfo['name']}&board={$gfid}");
		exit;
	}
	
	if($gUserGroup >= 8){$isadmin = 1;}
	//$master = $master=="" ? "沒有版主" : $master;
	
	
	$highlights = unserialize($boardInfo['highlight']);
	if($gIsAtlease1){
		$isAtLeaseSQL = " AND commentnum > 1 ";
	}
	if($gIsMyPosts && $isLog){
		$isMyPostSQL = " AND a.authorid = $gId ";
	}
	//Main list of articles in board
	//aname:authorname
	//rname:last-replyer-name
	$getConList = dbAr("SELECT is_closed,tpraise, isdigest, isshow, a.`id`, `title`,`subtitle`, authorusername as aname, views, commentnum, a.lastdatetime, a.create_timestamp, lastusername as rname, authorid, lastid,special
	
	FROM `zf_contentpages` a 
	WHERE isshow != 0
	$extcon $isAtLeaseSQL $isMyPostSQL
	order by $isshowsql $ordersql lastdatetime desc LIMIT $startRow_getConList, $maxRows_getConList");
	//get total rows
	$totalRows_getConList = $boardInfo["threadcount"]?$boardInfo["threadcount"]:dbRs("select count(*) from zf_contentpages where isshow !=0",3600);
	$totalPages_getConList = ceil($totalRows_getConList / $maxRows_getConList) - 1; //and totalpage too ^^
	
	//query string
	$queryString_getConList = qryStrE("page", $_SERVER['QUERY_STRING']);
	
	
	//city size
	if($gtype == 'selected'){
		$citysize = dbRs("SELECT count(*) as ce FROM zf_reply WHERE fid IN (" . str_replace("_",",",$gfid) . ") ",60);
		}else{
		$citysize = dbRs("SELECT count(*) as ce FROM zf_reply ".($gfid==""?"":"WHERE fid = $gfid"),60);
	}
	
	$htmltitle = $htmltitle==""?$boardInfo['name']:$htmltitle;
	$noguest = ($boardInfo['allowguest'] == 0)?true:false;
	
	if($boardInfo['cate']==6 || $boardInfo['id']==44){
		$gNoAds = true;
	}
	
	
	if($boardInfo['is_private']=="2" && $gUserGroup < 8){
		
		if(trim($boardInfo['private_member']) != "*"){
			
			$private_members = explode(",",$boardInfo['private_member']);
			
			if(in_array($gId,$private_members) || $isadmin ){
				
			}else{
				screenMessage("Private Board","Specified members only");
			}
			
		}else{
			
			if(!$isLog && !$isadmin){
				screenMessage("Private Board","Specified members only");
			}
			
		}
	}
	if($isLog){
		$bannedZid = dbAr("SELECT target_zid FROM zf_relation WHERE source_zid = $gId AND relation_type = 1"); //1=ban 2=friend
		$bannedZid = groupAssoc($bannedZid,'target_zid');
	}
	/*
		if($isLog){
		function cmp2($a, $b){
		return $b['last_visit'] - $a['last_visit'];
		}
		$vf_arr=getSessionStorage('vf_arr');
		$vf_arr[$gfid]['name'] = $boardInfo['name'];
		$vf_arr[$gfid]['last_visit'] = time();
		$vf_arr[$gfid]['fid'] = $gfid;
		usort($vf_arr,'cmp2');
		$vf_arr = array_slice($vf_arr, 0, 8);
		writeSessionStorage('vf_arr',$vf_arr);
		}
	*/
	$tmpIntro = mb_substr(str_replace(array("\n","\r"),"",$boardInfo['intro']),0,100,'utf8');
	$annuAdv = cacheGet("RF_AD_3");
	$sbAdv = cacheGet("RF_AD_4");
	$description = "{$boardInfo['name']},$tmpIntro,論壇, zkiz, realforum";
	
	if (!$getForumsInCate && $boardInfo['cate'] > 0) {
		
		$getForumsInCate = cacheGet("RF_FORUM_IN_CATE_{$boardInfo['cate']}");
	}

if($_SERVER["HTTP_X_PJAX"]){
    if($my['notification']){
        $htmltitle = "({$my['notification']})".$htmltitle;
    }
    echo "<title>{$htmltitle}</title>";
    include(template("viewforum"));
}else{

    include(template("header"));
    include(template("viewforum"));
    include(template("footer"));

}

	
//echo($_COOKIE['viewforum']);
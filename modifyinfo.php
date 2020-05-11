<?php 
	require('Connections/zkizblog.php'); 
	require('include/common.inc.php'); 
	
	if (!$isLog){screenMessage("錯誤","請先登入","http://members.zkiz.com/login.php");}
	//$fb = getFacebook();
	/*
		if($_GET['connect']=="weibo"){
		require('../share/connection/weibooauth.php');
		
		$weibo = new WeiboOAuth(
		'2398907781',
		'ca52f85cda39ea76f0c6bdc73f26f47c'
		);
		$keys = $weibo->getRequestToken();
		$keysi = serialize($keys);
		dbQuery("UPDATE zf_user SET weibo = '$keysi' WHERE id = $gId");
		header("LOCATION:".$weibo->getAuthorizeURL( $keys['oauth_token'] ,false , "{$g_domain}/modifyinfo.php" ));
		}
	*/
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		$updateSQL = sprintf(
		"UPDATE zf_user SET alias=%s, email=%s, url=%s,plurkkey=%s,facebook=%s, signature=%s, pic=%s,gender=%s, pm2email=%s, nobj=%s WHERE id=%s",
		GetSQLValueString(substr($_POST['alias'],0,30), "text"),
		GetSQLValueString($_POST['email'], "text"),
		GetSQLValueString($_POST['url'], "text"),
		GetSQLValueString($_POST['plurkkey'], "text"),
		GetSQLValueString($_POST['facebook'], "text"),
		GetSQLValueString(substr($_POST['signature'],0,500), "text"),
		GetSQLValueString($_POST['pic'], "text"),
		GetSQLValueString($_POST['gender'], "int"),
		GetSQLValueString($_POST['pm2email'], "int"),
		GetSQLValueString($_POST['nobj'], "int"),
		GetSQLValueString($gId, "int")
		);
		dbQuery($updateSQL);
	}
	
	$row_getinfo = dbRow("SELECT * FROM zf_user WHERE id = $gId");
	$relations = dbAr("SELECT a.target_zid , b.username FROM zf_relation a, zf_user b WHERE source_zid = $gId AND relation_type <> 3 AND target_zid = b.id");
	$htmltitle = "修改信息";
	include(template('header')); 
	include(template('modifyinfo')); 
	include(template('footer'));  
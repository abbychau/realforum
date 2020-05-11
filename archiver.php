<?php
	include("Connections/zkizblog.php");
	include("include/bbcode.php");
	$bbcode = new bbcode();
	
	switch($_GET['action']){
		case 'fid':
		$fid = safe($_GET['fid']);
		$threads = dbAr("SELECT * FROM zf_contentpages WHERE type = $fid ORDER BY id ASC LIMIT 0,50");
		
		$title = dbRs("SELECT name FROM zf_contenttype WHERE id = $fid");
		
		$description = "$title,論壇, zkiz, realforum";
		
		$description = "$title";
		break;
		
		case 'tid':
		$tid = safe($_GET['tid']);
		$replies = dbAr("SELECT * FROM zf_reply WHERE fellowid = $tid ORDER BY id ASC LIMIT 50");
		$title = dbRs("SELECT title FROM zf_contentpages WHERE id = $tid");
		$tmpIntro = mb_substr(str_replace(array("\n","\r"),"",$replies[0]['content']),0,100,'utf8');
		$description = "$title,$tmpIntro,論壇, zkiz, realforum";
		break;
		
		default:
		$forums = dbAr("SELECT * FROM zf_contenttype");
		
		$title = "RealForum - realforum.zkiz.com";
		$description = "$title";
		break;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
	<base href="<?=$g_domain;?>/" /> 
	<title> <?=$title;?> - Powered by RealForum Archiver</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf8" /> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="keywords" content="<?=$keywords;?>" /> 
	<meta name="description" content="<?=$description;?>" /> 
	<meta name="generator" content="RealForum Archiver 1.0" /> 
	<meta name="author" content="RealForum Team" /> 
	<meta name="copyright" content="2010 zkiz.com" />
	<style type="text/css"> 
		img{max-width:90%}
	</style>
	<body>
		<?
			switch($_GET['action']){
				case 'fid':
			?>
			<a href="/viewforum.php?fid=<?=$fid;?>">檢視此版塊完整版</a>
			<ul>
				<? foreach($threads as $v){?>
					<li><a href="/archiver/tid-<?=$v['id'];?>.html"><?=$v['title'];?></a></li>
				<? } ?>
			</ul>
			<a href="/viewforum.php?fid=<?=$fid;?>">檢視此版塊完整版</a>
			<?
				break;
				
				case 'tid':
			?>
			<a href="/thread.php?tid=<?=$tid;?>">檢視此主題完整版</a>
			<ul>
				<? foreach($replies as $v){?>
					<li><?=$bbcode->Parse($v['content']);?>
						<?=$v['picurl']=""?"":"<br /><a href='{$v['picurl']}'>{$v['picurl']}</a>";?>
					</li>
				<? } ?>
			</ul>
			<a href="/thread.php?tid=<?=$tid;?>">檢視此主題完整版</a>
			<?
				break;
				
				default:
			?>
			<a href="/">檢視RealForum完整版</a>
			<ul>
				<? foreach($forums as $v){?>
					<li><a href="/archiver/fid-<?=$v['id'];?>.html"><?=$v['name'];?></a></li>
				<? } ?>
			</ul>
			<a href="/">檢視RealForum完整版</a>
			<?
				break;
			}
		?>
	</body>
</html>
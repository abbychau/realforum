<?php
	//推演陣
	
	function parseAndPrintTree($root, $tree) {
	
		$return = array();
		if(!is_null($tree) && count($tree) > 0) {
			echo '<ul>';
			foreach($tree as $child => $parent) {
				if($parent == $root) {                    
					unset($tree[$child]);
					echo '<li>'.$GLOBALS['text'][$child];
					parseAndPrintTree($child, $tree);
					echo '</li>';
				}
			}
			echo '</ul>';
		}
	}
	
	
	$text['A'] = "AAAAA";
	$text['B'] = "AAAAB";
	$text['C'] = "AAAAC";
	$text['D'] = "應設立國民教育科";
	$text['E'] = "AAAAE";
	$text['F'] = "AAAAF";
	$text['G'] = "但是：教育本身不應涉及道得標準";
	$text['H'] = "但是：";
	$tree = array(
    'H' => 'G',
    'F' => 'G',
    'G' => 'D',
    'E' => 'D',
    'A' => 'E',
    'B' => 'C',
    'C' => 'E',
	'D' => null
	);
	
	$title = "賭博應否合法化";
	
	
	parseAndPrintTree(null,$tree);
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="http://realblog.zkiz.com/rssdata/4.xml" title="RSS 2.0" type="application/rss+xml" rel="alternate"/><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="description" content=""/>
<meta name="keywords" content="推論"/>
<title>RealDeduction</title>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="http://cdn.topost.me/eco_ui_7/ecoui7.css"/>
<style type="text/css">
	.outerwrapper{border:none;}*{font-size:12px;font-family:"細明體";}pre{overflow-x:scroll}.contentbody{font-size:15px;font-family:"細明體"}
</style>
</head>
<body>
	
</body>
</html>
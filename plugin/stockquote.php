<?php
include(dirname(__FILE__)."/../Connections/zkizblog.php");
include(dirname(__FILE__)."/../include/common.inc.php");
include(dirname(__FILE__)."/simple_html_dom.php");

$s = file_get_contents("http://hk.finance.yahoo.com/q?s=0005.HK");

$dom = str_get_html($s);

$result = $dom->find('div#quote-bar');
foreach($result as $v) {echo $v->outertext . '<br>';} 
?>
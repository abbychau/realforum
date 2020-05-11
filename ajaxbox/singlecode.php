<?php
	define('LITE_HEADER',true);
	include(dirname(__FILE__)."/../Connections/zkizblog.php");
include(dirname(__FILE__)."/../include/common.inc.php");
include(dirname(__FILE__)."/../plugin/simple_html_dom.php");
$getcode=$_GET['code'];

useMoney(0.1,$gId);

$s = file_get_contents("http://hk.finance.yahoo.com/q?s=".sprintf("%04d", $getcode).".HK");

$dom = str_get_html($s);

$result = $dom->find('div.yfi_rt_quote_summary_rt_top');
$title = $dom->find('div.title');

?>
<div>
	
	<?php
foreach($title as $v) {echo $v->outertext . '<br />';}
?>
<?php
foreach($result as $v) {echo $v->outertext . '<br />';}
?>
</div>
<div >
<a onclick="$('#quickresult').hide('fast')" class='closebtn'>關閉</a>
</div>


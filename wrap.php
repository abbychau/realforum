<?php
require_once('Connections/zkizblog.php');
mysql_select_db($database_zkizblog, $zkizblog);
if($_GET['prop'] == "rand"){
$tn = dbRs("SELECT id FROM zf_contentpages ORDER BY rand() LIMIT 1");
}
if($_GET['prop'] == "new"){
$tn = dbRs("SELECT max(id) AS ce FROM zf_contentpages");
}
if($_GET['prop'] == "old"){
$tn = dbRs("SELECT id AS ce FROM zf_contentpages order by lastdatetime limit 1");
}
header("location:thread.php?tid=".$tn);
?>
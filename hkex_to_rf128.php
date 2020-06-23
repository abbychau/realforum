<?
	require_once('../lib/common_init.php');
	include_once("../realforum.zkiz.com/include/rfPosts.class.php");
	if(!$gId){
		die("Please Login");
	}
	if($_POST['picurl']){
		$tid = dbRs("SELECT tid FROM zf_pages_tracing WHERE tag = ?",[$_POST['code']]);
		if(!$tid){
			echo "tid not exist in tracing table";
		}else{
			rfPosts::replyThread(128, $tid, 0, $_POST['comment'], $_POST['picurl'], getIP(), $gId,$gUsername, 0, 14, true);
			$donePosting = true;
		}
	}
?>

<? if($donePosting){?>
	DONE Posting
	<pre style='max-height:100px;overflow-y:scroll'><? print_r($queryRecord); ?></pre>
<?}?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head> 
<body>
<form method="post">

url:<input type="text" name="picurl" />
code:<input type="text" name="code" />
comment:<textarea name="comment"></textarea>
<input type="submit" />

</form>
</body>
</html>
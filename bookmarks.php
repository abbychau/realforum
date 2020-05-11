<?php 
	
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php'); 
	if (!$isLog){screenMessage("錯誤","請先登入","http://members.zkiz.com/login.php");}
	

	if ((isset($_POST["type"])) && ($_POST["type"] == "del")) {
		$insertSQL = sprintf("delete from zf_bookmark where id = %s",
		GetSQLValueString($_POST['id'], "int"));
		dbQuery($insertSQL, $zkizblog);
		echo "1";
		exit;
	}
	
	if ((isset($_POST["type"])) && ($_POST["type"] == "add")) {
		$insertSQL = sprintf("INSERT INTO zf_bookmark (title, url, zid) VALUES (%s, %s, %s)",
		GetSQLValueString($_POST['name'], "text"),
		GetSQLValueString($_POST['url'], "text"),
		GetSQLValueString($gId, "int"),
		GetSQLValueString(($_POST['name']==$gUsername?'1':'0'), "int"));
		
		dbQuery($insertSQL, $zkizblog);
		echo "1";
		exit;
	}
	
$getbookmark = dbAr("SELECT * FROM zf_bookmark WHERE zid = $gId order by id DESC");
include(template("header"));
?>

<div id="mainbookmark">
	
	<?php 
		if (sizeof($getbookmark)>0){ 
			foreach($getbookmark as $row_getbookmark){ 
			?>
			<div class="ui-widget-content blocka" id="bookmark<?=$row_getbookmark['id'];?>">
				<a href="<?=$row_getbookmark['url'];?>"><?php echo htmlspecialchars($row_getbookmark['title']); ?></a>
				<a onclick="$.post('/ajaxbox/bookmark.php',{type:'del',id:<?=$row_getbookmark['id'];?>},function(data){if(data=='1'){$('#bookmark<?=$row_getbookmark['id'];?>').hide('fast');}})" style="cursor:pointer"><img src="/images/delete.gif" alt="delete" /></a>
				
				<div style='font-size:12px;color:#AAA'><?=htmlspecialchars($row_getbookmark['url']);?></div>
				
			</div> 
		<?php }?>
		<? } else { ?>
		未有任何收藏
	<?php } ?>
	<form id="form1" name="form1" method="POST" action="<?=$_SERVER['PHP_SELF']; ?>">
		標題: <input type="text" name="name" id="bm_title" style="width:250px;border:0;border-bottom:1px #BBB solid;" value="<?=$_GET['title']; ?>"/><br />
		網址: <input type="text" name="url" id="bm_url" style="width:250px;border:0;border-bottom:1px #BBB solid;"value="<?=$_GET['url']; ?>" /><br />
		<a class="button" onclick="$.post('/ajaxbox/bookmark.php',{type:'add',url:$('#bm_url').val(),name:$('#bm_title').val()},function(data){if(data=='1'){$('#mainbookmark').prepend('<div>已加入<?=$_GET['title']; ?></div>');}})">收藏</a>
	</form>	
</div>
<script>$(".button").button();</script>
<?include(template("footer"));?>
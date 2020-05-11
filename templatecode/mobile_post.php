<style>
.titleprefix a{text-decoration:none;display:block;float:left;background:#DDD;font-weight:bold;margin:2px;padding:2px}

</style>
<div style="margin:3px;width:98%">
<h3>發新主題</h3>
<script type="text/javascript">
//<![CDATA[
	function youtubeIDextract(url){var youtube_id; youtube_id = url.replace(/^[^v]+v.(.{11}).*/,"$1"); return youtube_id;}
	function quickpost(event){if((event.ctrlKey && event.keyCode == 13) || (event.altKey && event.keyCode == 83)){document.form2.Submit.click();}}
	function addtitle(str){document.form2.title.value = str + document.form2.title.value;}
	function checknull(){
	if(document.getElementById('qptitle').value=='標題'){alert('請輸入標題');return false;}
	if($.trim(document.getElementById('content').value) == ""){alert('請輸入內容');return false;}
	}
//]]>
</script>

<form id="form2" name="form2" method="post" action="/post.php" onsubmit="return checknull();"> 
發表於：<select name='fid' style="width:310px"><?=boardSelect(true,$gfid);?></select>
<div class="titleprefix">
	<?php if($gTid==""){?>
	<?php if($_GET['special']!="wiki"){?>
		<a onclick="addtitle('[原創]');">[原創]</a><a onclick="addtitle('[轉貼]');">[轉貼]</a><a onclick="addtitle('[分享]');">[分享]</a><a onclick="addtitle('[貼圖]');">[貼圖]</a><a onclick="addtitle('[閒聊]');">[閒聊]</a><a onclick="addtitle('[大發現]');">[大發現]</a><a onclick="addtitle('[狂賀]');">[狂賀]</a><a onclick="addtitle('[<?=date("n月j日");?>]');">[<?=date("n月j日");?>]</a>
	<?php }?>
	
	<div class='clear'>
	<input name="title" type="text" style="width:100%;font-size:16px; " value="<?=htmlspecialchars($title);?>" id="qptitle" onfocus="if(this.value=='標題'){this.value=''}" />
	</div>
	<? } ?>
</div>

<textarea name="content" id="content" style="width: 100%;height: 400px;background-image:url(/images/edbg.gif);background-position:center;background-repeat:no-repeat; " rows="15" cols="100" ><?=$content;?></textarea>


	
    <?php if (!$isLog){ ?>
		<br />
<?php 
  require_once('include/recaptchalib.php');
  $publickey = "6LdC_8ISAAAAALIir1r8PCOSLx2_OTZ2LcF_T1QJ"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
?>
    <?php } ?>
    
    <?php if($error == 1){echo "<strong>驗證碼錯誤, 請重新輸入</strong>";} ?>
    <input type="hidden" name="posttype" value="<?=$_GET['type'];?>" />
    <input type="hidden" name="tid" value="<?=$_GET['tid'];?>" />
    <input type="submit" name="Submit" value="送出" class="button" />
	
	


</form>

<?php if (!$isLog){ ?>
<script type="text/javascript">
document.getElementById('recaptcha_response_field').value="請輸入以上的認證碼(登入後可以直接發表)";
</script>
<?php }?>



</div>
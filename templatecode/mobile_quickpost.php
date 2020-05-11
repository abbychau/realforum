<script type="text/javascript">
//<![CDATA[
	function youtubeIDextract(url){var youtube_id; youtube_id = url.replace(/^[^v]+v.(.{11}).*/,"$1"); return youtube_id;}
	function quickpost(event){if((event.ctrlKey && event.keyCode == 13) || (event.altKey && event.keyCode == 83)){document.form2.Submit.click();}}
	function addtitle(str){
		if(document.form2.title.value == "標題"){
			document.form2.title.value = "";
		}
		document.form2.title.value = str + document.form2.title.value;
	}
	function checknull(){
	if(document.getElementById('qptitle').value=='標題'){alert('請輸入標題');return false;}
	if($.trim(document.getElementById('content').value) == ""){alert('請輸入內容');return false;}
	document.form2.submit.disabled = 'disabled';
	return true;
	}
	function doSomething(){document.form2.Submit.click(); }
	
	var buttonstr = "<br /><a onclick='openback()' class='ui-corner-all' style='padding:3px'>返回上面</a>";
	function openback(){
		$('#fileframe').toggle();
		$('body').scrollTo( $('#adsb4post'), 800 );
		
	}
	
//]]>
</script>

<form id="form2" name="form2" method="post" action="/post.php" onsubmit="doCheck();return checknull();"> 
<div class="titleprefix" style='margin:5px'>
	<?php if($gTid==""){?>
	<a onclick="addtitle('[原創]');">[原創]</a><a onclick="addtitle('[轉貼]');">[轉貼]</a><a onclick="addtitle('[分享]');">[分享]</a><a onclick="addtitle('[貼圖]');">[貼圖]</a><a onclick="addtitle('[閒聊]');">[閒聊]</a><a onclick="addtitle('[大發現]');">[大發現]</a><a onclick="addtitle('[狂賀]');">[狂賀]</a><a onclick="addtitle('[下載]');">[下載]</a><a onclick="addtitle('[<?=date("n月j日");?>]');">[<?=date("n月j日");?>]</a><br />
	<input name="title" class="text ui-widget-content ui-corner-all" type="text" style="width:300px;margin:2px 0;font-size:16px;padding:3px;" value="標題" id="qptitle" onfocus="if(this.value=='標題'){this.value=''}" />
	<? } ?>
	

		<textarea name="content" id="content"
		style="width: 100%;height: 250px;" rows="8" cols="100"><?=$content;?></textarea>
		<script type="text/javascript">
			$('#content').addClass('richeditor text ui-widget-content ui-corner-all');
		</script>
	
    <span id="correctPos">圖片/flash/PDF 地址(包括&quot;http://&quot;): </span>
	<br /><input name="picurl" type="text" id="textfield" value="" style="width:300px;padding:3px" class="text ui-widget-content ui-corner-all" />
    <a href="javascript:" onclick="document.form2.picurl.value='http://www.youtube.com/v/'+youtubeIDextract(document.form2.picurl.value)">
    Youtube 網址轉換</a>
	<div id="fileframe" style='display:none'></div>
    <?php if(!$isLog ||  $my['postnum'] < 15 ){ ?>
		<br />
<?php 
  require_once('include/recaptchalib.php');
  $publickey = "6LdC_8ISAAAAALIir1r8PCOSLx2_OTZ2LcF_T1QJ"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
?>
    <?php } ?>
    
    <?php if($error == 1){echo "<strong>驗證碼錯誤, 請重新輸入</strong>";} ?>
    <input type="hidden" name="quickpost" value="true" /><br />
    <input type="hidden" name="fid" value="<?php echo $gTid ? $rpFid : $_GET['fid']; ?>" />
    <input type="hidden" name="tid" value="<?=$gTid;?>" />
    <input type="hidden" name="posttype" value="<?=($gTid=="")?"post":"reply";?>" />
    <input type="submit" name="Submit" value="送出(Ctrl+Enter)" class="button" style="padding:5px 20px" />
</div>
</form>
<script>
$(".titleprefix>a").button();
$(".titleprefix>a>*").css('padding','1px');
$(".editbar>a").button();
$(".editbar>a>*").css('padding','1px');
$(".editbar>button").button();
$(".editbar>button").css('padding','1px');
$(".editbar>button").css('background-repeat','no-repeat');
$(".editbar>button").css('margin','0');
</script>
<?php if (!$isLog){ ?>
<script type="text/javascript">
document.getElementById('recaptcha_response_field').value="請輸入以上的認證碼(登入後可以直接發表)";
</script>
<?php }?>
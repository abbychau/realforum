<script type="text/javascript" src="http://www.dropbox.com/static/api/1/dropbox.js" id="dropboxjs" data-app-key="hjpbt9wmc4sews6"></script>
<script type="text/javascript">
	//<![CDATA[
	var RecaptchaOptions = {
		theme : 'white'
	};
	
	function youtubeIDextract(url){var youtube_id; youtube_id = url.replace(/^[^v]+v.(.{11}).*/,"$1"); return youtube_id;}
	function quickpost(event){if((event.ctrlKey && event.keyCode == 13) || (event.altKey && event.keyCode == 83)){document.form2.Submit.click();}}
	function addtitle(str){
        $('#qptitle').val(str + $('#qptitle').val());
	}
	function checknull(){
		<?php if($gTid==""){?>
			if($('#qptitle').val() =='標題' || $('#qptitle').val() == ""){alert('請輸入標題');return false;}
		<?}?>
		if($.trim(document.getElementById('content').value) == ""){alert('請輸入內容');return false;}
		
		
		$('#form2').hide();
		$('#postingmsg').show();

		closeModal();
		$.post("/post.php?post_action=die", $("#form2").serialize(),function(data){
			//alert(data);
			if(data=='cap_error'){
				$('#capfailmsg').show();
				
				}else{
				var now = new Date();
				var timenow = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
				$('#content').val("");
				$('#textfield').val("");
				$('#qptitle').val("");
				$('#qpsubtitle').val("");
				$('#qptags').val("");
				
				<?php if($gTid!=""){?>
					$('#myposthead').show();
					var nowfield='<div class="contentmodinfo">發表於:'+timenow+'</div>';
					$('#mypost').append(data + nowfield);
					//$('body').scrollTo( $('#myposthead'), 800 );
					<?}else{?>
					$('#sucspan').html(data);
					$('#sucmsg').show();
				<?}?>
			}
			
			$('#postingmsg').hide();
			$('#form2').show();
			return false;
		});		
		
		document.form2.submit.disabled = 'disabled';
		<?php if($gTid==""){?>
			return true;
			<?}else{?>
			return false;
		<?}?>
		
	}
	
	function extractTags(){
		if($("#qptitle").val() == ""){
			alert("請先填入標題");
			return false;
		}
		$.get("/ajaxdata.php",{"str":$("#qptitle").val(),"type":"extract_tags"},function(data){
			$("#qptags").val(data);
			
			if(data == ""){
				$("#autotag").html("沒有適合的Tag");
				}else{
				$("#autotag").html("己加入");
			}
			//$("#autotag").attr('onclick','').unbind('click');
		});
		return false;
	}
	
	
	function doSomething(){checknull(); }
	
	var buttonstr = "<br /><a onclick='openback()' class='ui-corner-all' style='padding:3px'>返回上面</a>";
	function openback(){
		$('#fileframe').toggle();
		//$('body').scrollTo( $('#adsb4post'), 800 );
		
	}
	
	//]]>
</script>

<div class="alert alert-warning hide2" id='postingmsg'> 
	<strong>發表中!</strong> 請稍候...(不要關閉頁面)
</div>
<div class="alert alert-warning hide2" id='sucmsg'>
	<strong>已成功發表!</strong><span id='sucspan'></span>
</div>
<div class="alert alert-warning hide2" id='capfailmsg'>
	<strong>驗證碼錯誤!</strong>
</div>
<div id="qpinfo"></div>
<a id="correctPos"></a>
<style>
	#qpmainform {
		border:1px solid #CCC;
		
	}
#qpmainform .form-control, #qpmainform button, #qpmainform .btn{
	border:none;
	border-bottom:1px solid #CCC;
	border-radius:0px;
	
}
 
	
</style>
<h4><?=$gTid==""?"新主題":"新回覆";?></h4>
<div id="qpmainform" class='clear' >
	<form id="form2" name="form2" method="post" action="/post.php"> 
		<?php if($gTid==""){?>
			<div class='viewforum_highlight'>
			<ul class="nav nav-pills">
				
				<?if(sizeof($highlights)>1){?>
					<?foreach($highlights as $highlight){?><li><a class='addtitle' onclick="addtitle('[<?=$highlight;?>]');"><?=$highlight;?></a></li><?}?>
					<?}else{?>
					<?foreach($default_types as $highlight){?><li><a class='addtitle' onclick="addtitle('[<?=$highlight;?>]');"><?=$highlight;?></a></li><?}?>
				<?}?>
				
				</ul>
			</div>
			<input name="title" class="form-control" type="text" id="qptitle" placeholder="標題" maxlength="150" required />
		<? } ?>
		
		<div class="richeditor">
			<div class='serif'>
				<div class="btn-toolbar">
				<span id="colorpicker201" class="colorpicker201"></span>
					<div class="btn-group  btn-group-sm">
						<button type='button'  class="btn btn-default btn-xs" title="粗體" onclick="wrapTag('b');" type="button"><span class='glyphicon glyphicon-bold'></span></button>
						<button type='button'  class="btn btn-default btn-xs" title="斜體" onclick="wrapTag('i');" type="button"><span class='glyphicon glyphicon-italic'></span></button>
						<button type='button'  class="btn btn-default btn-xs" title="底線" onclick="wrapTag('u');" type="button"><span class='glyphicon glyphicon-text-width'></span></button>
						<button type='button'  class="btn btn-default btn-xs" title="字體顏色" onclick="showColorGrid2('none')" type="button"><span class='glyphicon glyphicon-tint'></span>字色</button>
						<button type='button'  class="btn btn-default btn-xs" title="字體大小" onclick="AddTag('[size=16px]','[/size]')" type="button">字Size</button>
						
					</div>
					<div class="btn-group  btn-group-sm">
						<button type='button'  class="btn btn-default btn-xs" title="超連結" onclick="wrapTag('url');" type="button">Link</button>
						<button type='button'  class="btn btn-default btn-xs" title="圖片" onclick="wrapTag('img');" type="button"><span class='glyphicon glyphicon-camera'></span></button>
						<button type='button'  class="btn btn-default btn-xs" title="列表" onclick="AddTag('[ul][li]','[/li][/ul]')" type="button"><span class='glyphicon glyphicon-th-list'></span></button>
					</div>
					<div class="btn-group  btn-group-sm">
						<button type='button'  class="btn btn-default btn-xs" title="引用" onclick="wrapTag('quote');" type="button">引用</button>
						<button type='button'  class="btn btn-default btn-xs" title="代碼" onclick="wrapTag('code');" type="button">Code</button>
						<button type='button'  class="btn btn-default btn-xs" title="Ascii Art" onclick="wrapTag('aa');" type="button">Ascii</button>
					</div>
					<div class="btn-group  btn-group-sm">
						<button type='button'  class="btn btn-default btn-xs" title="隱藏(回貼後可見)" onclick="wrapTag('hide');" type="button"><span class='glyphicon glyphicon-eye-close'></span></button>
						<button type='button'  class="btn btn-default btn-xs" title="出售(購買後可見)" onclick="wrapTag('sell');$('#selling_price').show();" type="button"><span class='glyphicon glyphicon-usd'></span></button>
					</div>
					<div class="btn-group  btn-group-sm">
						<button type='button'  class="btn btn-default btn-xs" title="Youtube" onclick="InsertYoutube(youtubeIDextract(prompt('Youtube URL')));" type="button">YT</button>
						<button type='button'  class="btn btn-default btn-xs" title="Nico Nico" onclick="wrapTag('nico');" type="button">ニコ</button>
						<button type='button'  class="btn btn-default btn-xs" title="RB" onclick="wrapTag('realblog');" type="button">RB</button>
						<button type='button'  class="btn btn-default btn-xs" title="Stock" onclick="wrapTag('stock');" type="button">股</button>
						<button type='button'  class="btn btn-default btn-xs" title="表情符號" onclick="$('#smileyContainer').append(createSmiley()).toggle();" type="button">表情</button>
					</div>
					<div class="btn-group  btn-group-sm">
						<!--a class="btn btn-default" onclick="$('#qpsubs').toggle();">其他選項 <b class='caret'></b></a-->
						<a class="btn btn-default" onclick="minimalWin('<?=$g_domain;?>/images/fddraw.swf?maxtext=90000',800,400)"><span class=' glyphicon glyphicon-pencil'></span> 繪畫</a>
						<? if($isLog){?><a class="btn btn-default" onclick="minimalWin('http://members.zkiz.com/filebox.php?box=1',800,600)"><span class='glyphicon glyphicon-cloud-upload'></span> 文件盒(上傳)</a><?}?>
					</div>
					<input type="dropbox-chooser" data-link-type="direct"  name="selected-file" id="db-chooser" />
				</div>
			</div>
			
			<div id='qpsubs' class='pd5'>
				
				<?php if($gTid==""){?>
					<input name="subtitle" class="form-control" type="text" id="qpsubtitle" placeholder="副標題" />
				<?}?>
				<div class="input-group">
				<input name="picurl" class="form-control" type="text" id="textfield" placeholder='圖片/flash/PDF 地址(包括&quot;http://&quot;):'/>
					<div class="input-group-btn">
						<button id='autotag' onclick="document.form2.picurl.value='http://www.youtube.com/v/'+youtubeIDextract(document.form2.picurl.value);return false;" class='btn btn-default'>Youtube 網址轉換</button>
					</div>
				</div>
				
				<input id='selling_price' name="price" type="text" class="form-control" placeholder="售價(在[sell]及[/sell]中的內容會在付費後展示)" style='display:none' />
				
				<abbr title="別人回覆時,收到系統通知">接受回覆通知</abbr>: <input type="checkbox" name="also_subscribe" value="1" CHECKED />
				<?php if($gTid==""){?>
					
					<abbr title="這主題當作說明使用, 其他人可以修改">維基主題</abbr>: <input type="checkbox" name="wiki" value="true" />
					<abbr title="這主題常用以作回覆後觀看, 回覆後不會給其他人發通知">資源主題</abbr>: <input type="checkbox" name="resource" value="true" />
					<?if($my['plurkkey']!=""){?>
						<abbr title="填寫plurk 後會出現, 勾選後不推到plurk">不要推到 plurk</abbr>: <input type="checkbox" name="noplurk" value="true" />
					<?}?>
					<?if($my['facebook']!=""){?>
						<abbr title="連結Facebook 後會出現, 勾選後不推到Facebook">不要推到 Facebook</abbr>: <input type="checkbox" name="nofacebook" value="true" />
					<?}?>
				<? } ?>
				
			</div>
			
			
			
			
			
			<textarea name="content" id="content" class='form-control'
			style="height: 250px;" onkeyup="javascript:return ctrlEnter(event);" required ><?=$content;?></textarea>
			
			<?php if($gTid==""){?>
				
				<div class="input-group">
				<input name="tags" class="form-control" type="text" id="qptags" placeholder="TAGS (以逗號分隔)" />
					<div class="input-group-btn">
						<button id='autotag' onclick="extractTags();return false;" class='btn btn-default'>自動Tag</button>
					</div>
				</div>
			<?}?>
			
		</div>
		<div id='smileyContainer' style='display:none;height:300px;overflow-y:scroll'></div>
		
		<?php if(!$isLog ||  $my['postnum'] < $g_low_post_captcha ){ ?>
			<div style='margin-top:3px'>
			發貼總數五篇以下的會員需要輸入Captcha: <br />
				<script src='https://www.google.com/recaptcha/api.js'></script>
				<div class="g-recaptcha" data-sitekey="6LdZOgkTAAAAAAOpVl8Bfdky9zdmjho7wSURgBnm"></div>
			</div>
		<?php } ?>
		
		<input type="hidden" name="quickpost" value="true" />
		<input type="hidden" name="fid" value="<?php echo $gTid ? $rpFid : intval($_GET['fid']); ?>" />
		<input type="hidden" name="tid" value="<?=$gTid;?>" />
		<input type="hidden" name="posttype" value="<?=($gTid=="")?"post":"reply";?>" />
		<input type="hidden" name="pid" id="reply_pid" />
		<input type="button" name="Submit" value="送出(Ctrl+Enter)" class="btn btn-primary" style="padding:5px 20px; margin:4px 0" onclick='checknull()'/>
	
	</form>
	
</div>

<style type='text/css'>.colorpicker201{visibility:hidden;display:none;position:absolute;background:#FFF;z-index:999;}</style>

<script type='text/javascript'>
	function minimalWin(url,width,height){
		window.open( url, "myWindow", "status = 1, height = "+height+", width = "+width+", resizable = no,location=no,status=no,scrollbars=no,menubar=no,toolbar=no" );
	}
	
	document.getElementById("db-chooser").addEventListener("DbxChooserSuccess",
	function(e) {
		AddTag(e.files[0].link,"");
		//alert("Here's the chosen file: " + )
	}, false
	);
	
	function InsertYoutube(str) {
		AddTag("[youtube]" + str, "[/youtube]");
	}
	
	
	function AddTag(openTag, closeTag) {
		var textArea = $('#content');
		var len = textArea.val().length;
		var start = textArea[0].selectionStart;
		var end = textArea[0].selectionEnd;
		var selectedText = textArea.val().substring(start, end);
		var replacement = openTag + selectedText + closeTag;
		textArea.val(textArea.val().substring(0, start) + replacement + textArea.val().substring(end, len));
	}
	function wrapTag(tag){
		AddTag("["+tag+"]", "[/"+tag+"]");
	}
	
	function setCCbldSty2(objID, prop, val) {
		switch (prop) {
			case "bc":
			if (objID != 'none') {
				document.getElementById(objID).style.backgroundColor = val;
			};
			break;
			case "vs":
			document.getElementById(objID).style.visibility = val;
			break;
			case "ds":
			document.getElementById(objID).style.display = val;
			break;
			case "tp":
			document.getElementById(objID).style.top = val;
			break;
			case "lf":
			document.getElementById(objID).style.left = val;
			break;
		}
	}
	
	function putOBJxColor2(Samp, pigMent, textBoxId) {
		if (pigMent != 'x') {
			AddTag('[color=#' + pigMent + ']', '[/color]');
			setCCbldSty2(Samp, 'bc', pigMent);
		}
		setCCbldSty2('colorpicker201', 'vs', 'hidden');
		setCCbldSty2('colorpicker201', 'ds', 'none');
	}
	
	function showColorGrid2(Sam, textBoxId) {
		var objX = new Array('00', '33', '66', '99', 'CC', 'FF');
		var c = 0;
		var xl = '"none","x", ""';
		var mid = '';
		
		mid += '<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="border:solid 0px #F0F0F0;padding:2px;"><tr>';
		mid += "<td colspan='17' align='left' style='margin:0;padding:2px;height:12px;' ><input type='text' size='12' id='o5582n66' value='#FFFFFF'><input type='text' size='2' style='width:14px;' id='o5582n66a' onclick='javascript:alert(\"click on selected swatch below...\");' value='' style='border:solid 1px #666;'></td><td colspan='1' align='right' onclick='javascript:putOBJxColor2(" + xl + ")'><span style='border:1px solid #CCC; padding:1px 3px;cursor:pointer'>X</span></td></tr><tr>";
		var br = 1;
		for (o = 0; o < 6; o++) {
			mid += '</tr><tr>';
			for (y = 0; y < 6; y++) {
				if (y == 3) {
					mid += '</tr><tr>';
				}
				for (x = 0; x < 6; x++) {
					var grid = '';
					grid = objX[o] + objX[y] + objX[x];
					var b = "'none','" + grid + "', ''";
					mid += '<td style="background-color:#' + grid + '" onclick="javascript:onclick=putOBJxColor2(' + b + ');" onmouseover=javascript:document.getElementById("o5582n66").value="#' + grid + '";javascript:document.getElementById("o5582n66a").style.backgroundColor="#' + grid + '"; width="12" height="12"></td>';
					c++;
				}
			}
		}
		mid += "</tr></table>";
		document.getElementById('colorpicker201').innerHTML = mid;
		setCCbldSty2('colorpicker201', 'vs', 'visible');
		setCCbldSty2('colorpicker201', 'ds', 'inline');
	}
	
	
	function smileLine(file) {
		return ("<img src=\"\/images\/smileys\/" + file + ".gif\" onclick=\"AddTag('[emot]" + file + "[/emot]','')\" alt='" + file + "' \/>");
	}
	
	function createSmiley() {
		
		var str = '';
		
		var emot=[
		
		['peanuts1','peanuts2','peanuts3','369','Adore','Agree1','Angel','Angry','Ass','at_at','Banghead','Biggrin','Bomb','Bouncer','Bouncy','Bye','Censored','Chicken','Clown','Cry1','Dead','Devil','Donno','Fire1','Flowerface','Frown','Fuck','Good','Hehe','Hoho','Kill','Kill2','Kiss','Love','No','Offtopic','Oh','Photo','Shocking','Slick','Smile','Sosad','Surprise','Tongue','Wink','Wonder','Wonder2','Yipes','Z'],
		
		['90553490','90553493','90553496','90553498','90553501','90553503','90553505','90553508','90553510','90553512','90553515','90553519','90553522','90553525','90553527','90553529','90553531','90553535','90553537','91150448','91150449','91150452','91150456','91150458','91150460','91150464','91150468','91150469','91150471','93422746','93422747','93422749','93422750','93422753','93422754','93422755','93422756','93422757','93422758','93422760'],
		
		['bigsmile','evil','sneaky','saint','confuse','worry','neutral','irritated','bigeyes','cool','bigwink','anime','sweatdrop','lookright','lookleft','laugh','smile3','wink3','teeth','boggle','blue','sleepy','heart','star'],
		
		['s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47'],
		
		['7_0','7_1','7_2','7_3','7_4','7_5','7_6','7_7','7_8','7_9','7_10','7_11','7_12','7_13','7_14','7_15','7_16','7_17','7_18','7_19','7_20'],
		
		['m0','m1','m2','m3','m4','m5','m6','m7','m8','m9','m10','m11','m12','m13','m14','m15','m16','m17','m18','m19','m20','m21','m22','m23','m24','m25','m26','m27','m28','m29','m30','m31','m32','m33','m34','m35']
		
		];
		var length = emot.length, element = null;
		for (var i = 0; i < emot.length; i++) {
			for(var j=0;j < emot[i].length;j++){
				str += smileLine(emot[i][j]);
			}
			str += "<hr />";
		}
		
		return $(str);
		//$('#' + dom).html(str);
	}
</script>

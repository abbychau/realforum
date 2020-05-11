<style>.btnEmot{background: url(http://destiny.xfiles.to/ubbthreads/images/icons/default/smiley3.gif);}
#post_container .nav-pills li a{padding:0.2em; font-size:small; margin-bottom:0.2em}
	</style>
<script>$("#nav_new_post").addClass("active");</script>
<script type="text/javascript" src="http://www.dropbox.com/static/api/1/dropbox.js" id="dropboxjs" data-app-key="hjpbt9wmc4sews6"></script>
<script src="http://share.zkiz.com/js/xheditor1.2.1/xheditor-1.2.1.min.js"></script>
<script src="http://share.zkiz.com/js/xheditor1.2.1/xheditor_lang/zh-tw.js"></script>
<script type="text/javascript" src="http://share.zkiz.com/js/xheditor1.2.1/xheditor_plugins/ubb.js"></script>

<ol class="breadcrumb" style=''>
	<li><a href="/">主頁</a></li>
	<? if($fid){?>
		<li><a href='/viewforum.php?fid=<?=$type_info['id'];?>'><?=$type_info['name'];?></a></li>
	<? } ?>
	<li class="active"><?=$h4;?></li>
</ol>

<div class="panel"><div class="panel-body" id='post_container'>
<form id="form2" name="form2" method="post" action="/post.php" onsubmit="return checknull();"> 

	<div style='padding-bottom:0.5em'>
		<?php if($gTid==""){?>
			<?php if($_GET['special']!="wiki"){?>
			
			<ul class="nav nav-pills">
			
				<? foreach($default_types as $v){?>
				<li><a onclick="addtitle('[<?=$v;?>]');">[<?=$v;?>]</a></li>
				<?}?>
			</ul>
			

			<?php } ?>
			<div class='row'>
				<div class='col-xs-12 col-md-8'>
					<input name="title" type="text" style="" class='form-control' value="<?=htmlspecialchars($title);?>" id="qptitle" placeholder='標題' />
				</div>
				
				<?php if($_GET['type'] != "reply" && $_GET['type'] != "quote") {?>
					<div class='col-xs-12 col-md-4'>
						<select class='form-control' name='fid'><?=boardSelect(true,$fid);?></select>
					</div>
				<?}?>
			</div>
		<? } ?>
		
	</div>
	<textarea id="elm1" name="content" rows="12" cols="80" style="width: 90%"><?=$content;?></textarea>
	<div id="smileypicker"></div>
	
	
	<div class="btn-group  btn-group-sm">
		<a class="btn btn-default" onclick="minimalWin('/images/fddraw.swf?maxtext=90000',800,400)">繪畫</a>
		<? if($isLog){?><a class="btn btn-default" onclick="minimalWin('http://members.zkiz.com/filebox.php?box=1',800,600)">文件盒(上傳)</a><?}?>
	</div>
	<input type="dropbox-chooser" name="selected-file" id="db-chooser"/>
	<div class='clear'></div>
	
	
	<div class='panel panel-body pd5'>
		
		<?php if($gTid==""){?>
			<input name="subtitle" class="form-control" id="qpsubtitle" placeholder="副標題" />
			<input name="tags" class="form-control" type="text" id="qpsubtitle" placeholder="TAGS" />
		<?}?>
		
		<input name="picurl" type="text" id="textfield"  class="form-control" placeholder='圖片/flash/PDF 地址(包括&quot;http://&quot;):'/>
		<a  onclick="document.form2.picurl.value='http://www.youtube.com/v/'+youtubeIDextract(document.form2.picurl.value)" class="btn btn-default">Youtube 網址轉換</a><br />
		<input name="price" type="text" value="" class="form-control" placeholder="售價(在[sell]及[/sell]中的內容會在付費後展示)" />
		
		<?php if($gTid==""){?>
			<div>
			<abbr title="別人回覆時,收到系統通知">接受回覆通知</abbr>: <input type="checkbox" name="also_subscribe" value="1" />
			<abbr title="這主題當作說明使用, 其他人可以修改">維基主題</abbr>: <input type="checkbox" name="wiki" value="true" />
			<abbr title="這主題常用以作回覆後觀看, 回覆後不會給其他人發通知">資源主題</abbr>: <input type="checkbox" name="resource" value="true" />
			<?if($my['plurkkey']!=""){?>
				<abbr title="填寫plurk 後會出現, 勾選後不推到plurk">不要推到 plurk</abbr>: <input type="checkbox" name="noplurk" value="true" />
			<?}?>
			</div>
		<? } ?>
		
	</div>
	
	
	
	<?php if(!$isLog ||  $my['postnum'] < $g_low_post_captcha ){ ?>
				<script src='https://www.google.com/recaptcha/api.js'></script>
				<div class="g-recaptcha" data-sitekey="6LdZOgkTAAAAAAOpVl8Bfdky9zdmjho7wSURgBnm"></div>
	<?php } ?>
	
	<input type="hidden" name="posttype" value="<?=$gType;?>" />
	<input type="hidden" name="tid" value="<?=$gTid;?>" />
	
	<br />
	<input type="submit" name="Submit" value="送出(Ctrl+Enter)"  class="btn btn-primary" style='width:150px' />
	
	
</form>

</div></div>

<script type="text/javascript">
	//<![CDATA[
	var editor;
	
	$(document).ready(function(){
		
		$(pageInit);
		$(".editbar>a").button();
		$("#db-chooser").bind(
		"DbxChooserSuccess",
		function(e) {
			AddTag(e.files[0].link,"");
		}, 
		false
		);
		
	});
	
	
	
	function smileLine(file){
		return ("<img src=\"\/images\/smileys\/" + file +".gif\" onclick=\"InsertEmot('" + file + "')\" alt='" + file + "' \/>");
	}
	
	function createSmiley(dom){
		
		var str = '';
		
		str += smileLine('peanuts1');
		str += smileLine('peanuts2');
		str += smileLine('peanuts3');
		
		str += smileLine('369');
		str += smileLine('Adore');
		str += smileLine('Agree1');
		str += smileLine('Angel');
		str += smileLine('Angry');
		str += smileLine('Ass');
		str += smileLine('at_at');
		str += smileLine('Banghead');
		str += smileLine('Biggrin');
		str += smileLine('Bomb');
		str += smileLine('Bouncer');
		str += smileLine('Bouncy');
		str += smileLine('Bye');
		str += smileLine('Censored');
		str += smileLine('Chicken');
		str += smileLine('Clown');
		str += smileLine('Cry1');
		str += smileLine('Dead');
		str += smileLine('Devil');
		str += smileLine('Donno');
		str += smileLine('Fire1');
		str += smileLine('Flowerface');
		str += smileLine('Frown');
		str += smileLine('Fuck');
		str += smileLine('Good');
		str += smileLine('Hehe');
		str += smileLine('Hoho');
		str += smileLine('Kill');
		str += smileLine('Kill2');
		str += smileLine('Kiss');
		str += smileLine('Love');
		str += smileLine('No');
		str += smileLine('Offtopic');
		str += smileLine('Oh');
		str += smileLine('Photo');
		str += smileLine('Shocking');
		str += smileLine('Slick');
		str += smileLine('Smile');
		str += smileLine('Sosad');
		str += smileLine('Surprise');
		str += smileLine('Tongue');
		str += smileLine('Wink');
		str += smileLine('Wonder');
		str += smileLine('Wonder2');
		str += smileLine('Yipes');
		str += smileLine('Z');
		
		str += "<hr />";
		
		str += smileLine('90553490');
		str += smileLine('90553493');
		str += smileLine('90553496');
		str += smileLine('90553498');
		str += smileLine('90553501');
		str += smileLine('90553503');
		str += smileLine('90553505');
		str += smileLine('90553508');
		str += smileLine('90553510');
		str += smileLine('90553512');
		str += smileLine('90553515');
		str += smileLine('90553519');
		str += smileLine('90553522');
		str += smileLine('90553525');
		str += smileLine('90553527');
		str += smileLine('90553529');
		str += smileLine('90553531');
		str += smileLine('90553535');
		str += smileLine('90553537');
		str += smileLine('91150448');
		str += smileLine('91150449');
		str += smileLine('91150452');
		str += smileLine('91150456');
		str += smileLine('91150458');
		str += smileLine('91150460');
		str += smileLine('91150464');
		str += smileLine('91150468');
		str += smileLine('91150469');
		str += smileLine('91150471');
		str += smileLine('93422746');
		str += smileLine('93422747');
		str += smileLine('93422749');
		str += smileLine('93422750');
		str += smileLine('93422753');
		str += smileLine('93422754');
		str += smileLine('93422755');
		str += smileLine('93422756');
		str += smileLine('93422757');
		str += smileLine('93422758');
		str += smileLine('93422760');
		
		
		
		str += "<hr/>";
		str += smileLine('smile');
		str += smileLine('frown');
		str += smileLine('bigsmile');
		str += smileLine('angry');
		str += smileLine('evil');
		str += smileLine('sneaky');
		str += smileLine('saint');
		str += smileLine('surprise');		
		str += smileLine('confuse');
		str += smileLine('worry');
		str += smileLine('neutral');
		str += smileLine('irritated');
		str += smileLine('tongue');
		str += smileLine('bigeyes');
		str += smileLine('cool');
		str += smileLine('wink');
		str += smileLine('bigwink');
		str += smileLine('anime');
		str += smileLine('sweatdrop');
		str += smileLine('lookright');
		str += smileLine('lookleft');
		str += smileLine('laugh');
		str += smileLine('smile3');
		str += smileLine('wink3');
		str += smileLine('teeth');
		str += smileLine('boggle');
		str += smileLine('blue');
		str += smileLine('sleepy');
		str += smileLine('heart');
		str += smileLine('star');
		str += "<hr/>";
		
		str += smileLine('s01');
		str += smileLine('s02');
		str += smileLine('s03');
		str += smileLine('s04');
		str += smileLine('s05');
		str += smileLine('s06');
		str += smileLine('s07');
		str += smileLine('s08');
		str += smileLine('s09');
		str += smileLine('s10');
		str += smileLine('s11');
		str += smileLine('s12');
		str += smileLine('s13');
		str += smileLine('s14');
		str += smileLine('s15');
		str += smileLine('s16');
		str += smileLine('s17');
		str += smileLine('s18');
		str += smileLine('s19');
		str += smileLine('s20');
		str += smileLine('s21');
		str += smileLine('s22');
		str += smileLine('s23');
		str += smileLine('s24');
		str += smileLine('s25');
		str += smileLine('s26');
		str += smileLine('s27');
		str += smileLine('s28');
		str += smileLine('s29');
		str += smileLine('s30');
		str += smileLine('s31');
		str += smileLine('s32');
		str += smileLine('s33');
		str += smileLine('s34');
		str += smileLine('s35');
		str += smileLine('s36');
		str += smileLine('s37');
		str += smileLine('s38');
		str += smileLine('s39');
		str += smileLine('s40');
		str += smileLine('s41');
		str += smileLine('s42');
		str += smileLine('s43');
		str += smileLine('s44');
		str += smileLine('s45');
		str += smileLine('s46');
		str += smileLine('s47');
		str += "<hr/>";
		str += smileLine('7_0');
		str += smileLine('7_1');
		str += smileLine('7_2');
		str += smileLine('7_3');
		str += smileLine('7_4');
		str += smileLine('7_5');
		str += smileLine('7_6');
		str += smileLine('7_7');
		str += smileLine('7_8');
		str += smileLine('7_9');
		str += smileLine('7_10');
		str += smileLine('7_11');
		str += smileLine('7_12');
		str += smileLine('7_13');
		str += smileLine('7_14');
		str += smileLine('7_15');
		str += smileLine('7_16');
		str += smileLine('7_17');
		str += smileLine('7_18');
		str += smileLine('7_19');
		str += smileLine('7_20');
		str += "<hr/>";
		str += smileLine('m0');
		str += smileLine('m1');
		str += smileLine('m2');
		str += smileLine('m3');
		str += smileLine('m4');
		str += smileLine('m5');
		str += smileLine('m6');
		str += smileLine('m7');
		str += smileLine('m8');
		str += smileLine('m9');
		str += smileLine('m10');
		str += smileLine('m11');
		str += smileLine('m12');
		str += smileLine('m13');
		str += smileLine('m14');
		str += smileLine('m15');
		str += smileLine('m16');
		str += smileLine('m17');
		str += smileLine('m18');
		str += smileLine('m19');
		str += smileLine('m20');
		str += smileLine('m21');
		str += smileLine('m22');
		str += smileLine('m23');
		str += smileLine('m24');
		str += smileLine('m25');
		str += smileLine('m26');
		str += smileLine('m27');
		str += smileLine('m28');
		str += smileLine('m29');
		str += smileLine('m30');
		str += smileLine('m31');
		str += smileLine('m32');
		str += smileLine('m33');
		str += smileLine('m34');
		str += smileLine('m35');
		
		$('#'+dom).html(str);
	}	
	
	
	
	
	
	function minimalWin(url,width,height){
		window.open( url, "myWindow", "status = 1, height = "+height+", width = "+width+", resizable = no,location=no,status=no,scrollbars=no,menubar=no,toolbar=no" );
	}
	
	
	
	function pageInit()
	{
		var plugins={
			emot:{
				c:'btnEmot',
				t:'表情',
				h:0,
				e:function(){$('#smileypicker').dialog({width: 525,height: 302,title:"表情符號"});createSmiley('smileypicker');}
			}
		};
		editor = $('#elm1').xheditor({plugins:plugins,tools:'Cut,Copy,Paste,Pastetext,|,Fontface,FontSize,|,Bold,Italic,Underline,Strikethrough,|,FontColor,BackColor,|,SelectAll,Removeformat,|,Align,List,|,Outdent,Indent,|,Link,Unlink,Anchor,|,Img,Flash,Media,Table,emot,|,Source,Preview,Print,Fullscreen',showBlocktag:false,forcePtag:false,beforeSetSource:ubb2html,beforeGetSource:html2ubb,width:990,height:300,shortcuts:{'ctrl+enter':submitForm},emotPath:"/images/smileys/"});
		neatWidth();
	}
	function InsertEmot(str){editor.pasteText('[emot]'+str+'[/emot]');}
	function submitForm(){$("#form2").submit();}
	
	
	
	function youtubeIDextract(url){var youtube_id; youtube_id = url.replace(/^[^v]+v.(.{11}).*/,"$1"); return youtube_id;}
	function quickpost(event){if((event.ctrlKey && event.keyCode == 13) || (event.altKey && event.keyCode == 83)){document.form2.Submit.click();}}
	function addtitle(str){document.form2.title.value = str + document.form2.title.value;}
	function checknull(){
		if($('qptitle').val()=='標題'){alert('請輸入標題');return false;}
		if($.trim(editor.getSource()) == ""){alert('請輸入內容');return false;}
	}
	function neatWidth(){$(".xheLayout").width($("#post_container").width());}
	setInterval(neatWidth,1000);
	//]]>
</script>

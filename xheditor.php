<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="http://share.zkiz.com/js/xheditor1.2.1/xheditor-1.2.1.min.js"></script>
<script src="http://share.zkiz.com/js/xheditor1.2.1/xheditor_lang/zh-tw.js"></script>
<script type="text/javascript" src="http://share.zkiz.com/js/xheditor1.2.1/xheditor_plugins/ubb.js"></script>
<div id='wrap'>
<textarea name="content" id="elm1"></textarea>
</div>
<script>
$('#elm1').xheditor({tools:'Cut,Copy,Paste,Pastetext,|,Fontface,FontSize,|,Bold,Italic,Underline,Strikethrough,|,FontColor,BackColor,|,SelectAll,Removeformat,|,Align,List,|,Outdent,Indent,|,Link,Unlink,Anchor,|,Img,Flash,Media,Table,emot,|,Source,Preview,Print,Fullscreen',showBlocktag:false,forcePtag:false,beforeSetSource:ubb2html,beforeGetSource:html2ubb,width:800,height:600});
setInterval(function(){$(".xheLayout").width($("#wrap").width());},2000);
</script>
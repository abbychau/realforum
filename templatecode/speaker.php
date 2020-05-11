<div style="width:200px; max-height:400px; background-color:#083463; padding:10px; position:absolute; right:5px; float:right" id="spkbox">
	<span style="color:#FFF; text-decoration:none" id="speaker"></span>
	<a class="thickbox" href="ajaxbox/newspk.php?KeepThis=true&amp;TB_iframe=true&amp;height=200&amp;width=350">發表</a>
	<script type="text/javascript">
		$.get("ajaxdata.php", { type: "speaker" }, function(data){document.getElementById('speaker').innerHTML=(""+data+"");});
	</script>
</div>
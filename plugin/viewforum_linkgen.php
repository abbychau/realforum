<?php
	include(dirname(__FILE__)."/../Connections/zkizblog.php");
	include(dirname(__FILE__)."/../include/common.inc.php");
	$cities = dbAr("SELECT id, name FROM zf_contenttype");
	
	$htmltitle = "自選版塊連結產生器";
	include(template("header"));
?>


<h1>自選版塊連結產生器</h1>


<div class='row'>
	<div class='col-md-6'>
		
			<select multiple="multiple" style='height:550px;width:100%' id='selector1'>
				<?=boardSelect(true);?>
			</select>
		
	</div>
	<div class='col-md-6'>
		<div class='well'>
			<a id='imploded_url'  style='' ></a>
			<br />
			提示：<br />
			- 把產生出來的連結加入我的最愛以方便瀏覽。<br />
			- 按住Ctrl 可以分別選定多個。<br />
			- 按住Shift 可以按範圍選定多個。<br />
		</div>
	</div>
	
	
</div>
<script>
	$('#selector1').on('change',function(){
		
		$('#imploded_url').html('http://realforum.zkiz.com/viewforum.php?fid='+$(this).val().join('_')).attr('href',$('#imploded_url').html());
	}
	);
</script>
<hr />
<?include(template("footer"));
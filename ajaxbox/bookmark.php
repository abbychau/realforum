<?php 
	if (!$isLog){die("要使用收藏功能請先登入");}
	$getbookmark = dbAr("SELECT * FROM zf_bookmark WHERE zid = $gId order by id DESC");
	
	$_GET['title'] = str_replace(" - RealForum","",$_GET['title']);
	$_GET['title'] = preg_replace("/\([0-9]+\)/","",$_GET['title']);
?>


<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">收藏夾</h4>
	</div>
	<ul class="list-group" id="mainbookmark">
		<?if (sizeof($getbookmark)>0){ ?>
			<?foreach($getbookmark as $row_getbookmark){?>
				<li class="list-group-item" id="bookmark<?=$row_getbookmark['id'];?>">
					<div class='left'>
						<a title="<?=htmlspecialchars($row_getbookmark['url']);?>" href="<?=$row_getbookmark['url'];?>"><?=htmlspecialchars($row_getbookmark['title']); ?></a>
					</div>
					<div class="right">
						<a data-bookmarkid="<?=$row_getbookmark['id'];?>" style="cursor:pointer"><span class='glyphicon glyphicon-remove'></span></a>
					</div>
					<div class='clear'></div>
				</li>
			<?}?>
		<?}else{?>
			<li class="list-group-item" id="msg_no_bookmarks">
				未有任何收藏。
			</li>
		<?}?>
	</ul>
	<div class='panel-body'>
		<form id="form1" name="form1" method="POST" action="<?=$_SERVER['PHP_SELF']; ?>">
		<div class="input-group input-group-sm">
			
			<input placeholder='標題' type="text" class="form-control" name="name" id="bm_title" value="<?=$_GET['title']; ?>"/>
			
			<div class="input-group-btn">
				<a class="btn btn-default btn-sm" id="bookmark_button">收藏</a>
				<button type="button" class="btn btn-default dropdown-toggle" onclick='$("#bm_url").toggle();'>
					<span class="caret"></span>
				</button>
			</div>
			
		</div>
		<div>
			<input placeholder='網址' class="form-control hide2" type="text" name="url" id="bm_url" class='' value="<?=$_GET['url']; ?>" />				
		</div>
	</form>	
	</div>
</div>



<script>
	$("#bookmark_button").on("click",function(){
		$.post('/ajaxdata.php',{type:'add_bookmark',url:$('#bm_url').val(),name:$('#bm_title').val()},
		function(data){
			if(data=='1'){
				$('#mainbookmark').prepend('<li class="list-group-item"><a href="'+$('#bm_url').val()+'">'+$('#bm_title').val()+'</a></li>');
			}
		}
		);
		
	});
	$("a[data-bookmarkid]").on("click",function(){
		var bookmarkid = $(this).attr("data-bookmarkid");
		$.post('/ajaxdata.php',{type:'del_bookmark',id: bookmarkid},
			function(data){
				if(data=='1'){
					$('#bookmark' + bookmarkid).hide('fast');
				}
			}
		);
	});
</script>
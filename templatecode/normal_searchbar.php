	
	<form name="searchform" id="searchform<?=$seed;?>" method="get" action="search.php" onsubmit="chk()">
	
	<div style="padding:4px;float:left">
		<span class="ui-icon ui-icon-search "></span>
	</div>
	
		<input type="text" id="searchfield<?=$seed;?>" name="kw" class="text ui-widget-content ui-corner-all" value="搜尋" onclick="this.value=''" style="padding:5px;float:left;height:17px;width:400px; margin-right:1px" />
		
		<input type="radio" name="searchtype" id="radio1<?=$seed;?>" onclick="changeprop<?=$seed;?>(this.value)" value="1" /><label for="radio1<?=$seed;?>">版塊</label>
		<input type="radio" name="searchtype" id="radio2<?=$seed;?>" onclick="changeprop<?=$seed;?>(this.value)" value="2" /><label for="radio2<?=$seed;?>">TAG</label>
		<input type="radio" name="searchtype" id="radio3<?=$seed;?>" onclick="changeprop<?=$seed;?>(this.value)" value="3" /><label for="radio3<?=$seed;?>">全文</label>
		<input type="radio" name="searchtype" id="radio4<?=$seed;?>" onclick="changeprop<?=$seed;?>(this.value)" value="4" /><label for="radio4<?=$seed;?>">股票編號</label>

		<input type="submit" name="go" value="搜尋" style="width:40px" />
	</form>
	<script type="text/javascript">

	function changeprop<?=$seed;?>(id){
		if(id == "1"){
			$('#searchfield<?=$seed;?>').attr("name","kw");
			$('#searchform<?=$seed;?>').attr("action","/search.php");
		}
		if(id == "2"){
			$('#searchfield<?=$seed;?>').attr("name","tag");
			$('#searchform<?=$seed;?>').attr("action","http://zkiz.com/tag.php");
		}
		if(id == "3"){
			$('#searchfield<?=$seed;?>').attr("name","q");
			$('#searchform<?=$seed;?>').attr("action","/search.php");
		}
		if(id == "4"){
			$('#searchfield<?=$seed;?>').attr("name","code");
			$('#searchform<?=$seed;?>').attr("action","http://stock.zkiz.com/query.php");
		}
		
		createCookie("searchprop",id,7);
		
	}
	if(readCookie("searchprop")!=null){
		changeprop<?=$seed;?>(readCookie("searchprop"));
		$('#radio'+readCookie("searchprop")+'<?=$seed;?>').attr("checked","checked");
	}else{
		$('#radio1<?=$seed;?>').attr("checked","checked");
	}
	</script>
<script type="text/javascript">
	$( "#searchfield<?=$seed;?>" ).autocomplete({
		source: "/ajaxdata.php?type=tags",
		minLength: 2,
		select: function( event, ui ) {
			$( "#searchform<?=$seed;?>" ).val(ui.item.value);
		}
	});
</script>
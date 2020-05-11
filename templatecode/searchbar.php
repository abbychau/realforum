<?
$tags1 = dbAr("SELECT tag FROM zm_tags ORDER BY timestamp DESC");
foreach($tags1 as $tag1){$str[] = $tag1['tag'];}
?>

	<form name="searchform" id="searchform<?=$seed;?>" method="get" action="search.php" onsubmit="chk()">
	
	<div style="padding:4px;float:left">
		<span class="ui-icon ui-icon-search "></span>
	</div>
	
		<input type="text" id="searchfield<?=$seed;?>" name="kw" class="text ui-widget-content ui-corner-all" />
		<input type="radio" name="searchtype" id="radio1<?=$seed;?>" onclick="changeprop<?=$seed;?>(this.value)" value="1" /><label for="radio1<?=$seed;?>">版塊</label>
		<input type="radio" name="searchtype" id="radio2<?=$seed;?>" onclick="changeprop<?=$seed;?>(this.value)" value="2" /><label for="radio2<?=$seed;?>">TAG</label>
		<input type="radio" name="searchtype" id="radio3<?=$seed;?>" onclick="changeprop<?=$seed;?>(this.value)" value="3" /><label for="radio3<?=$seed;?>">全文</label>
		<input type="radio" name="searchtype" id="radio4<?=$seed;?>" onclick="changeprop<?=$seed;?>(this.value)" value="4" /><label for="radio4<?=$seed;?>">股票編號</label>

		<input type="submit" name="go" value="搜尋" style="width:40px" />
<? for($cc=0;$cc<5;$cc++){?><a href="http://zkiz.com/tag.php?tag=<?=$str[$cc];?>"><?=$str[$cc];?></a> <?}?>
	</form>

	<script type="text/javascript">

	function changeprop<?=$seed;?>(id){
		if(id == "1"){
			$('#searchfield<?=$seed;?>').attr("name","kw");
			$('#searchform<?=$seed;?>').attr("action","<?=$g_domain;?>/search.php");
		}
		if(id == "2"){
			$('#searchfield<?=$seed;?>').attr("name","tag");
			$('#searchform<?=$seed;?>').attr("action","http://zkiz.com/tag.php");
		}
		if(id == "3"){
			$('#searchfield<?=$seed;?>').attr("name","q");
			$('#searchform<?=$seed;?>').attr("action","<?=$g_domain;?>/search.php");
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
	var availableTags = <?=json_encode($str);?>;
	$( "#searchfield<?=$seed;?>" ).autocomplete({
		source: availableTags
	});
</script>
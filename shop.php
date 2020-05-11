<?php
include(dirname(__FILE__)."/Connections/zkizblog.php");
include(dirname(__FILE__)."/include/common.inc.php");
include(dirname(__FILE__)."/plugin/simple_html_dom.php");
/*
SELECT DISTINCT `code` , chinese
FROM `stock_list`
ORDER BY code
*/

if($_GET['getItem'] == '1'){
	
}

if($_POST['action'] == 'buy'){
	$code=safe($_POST['code']);
	$amount=safe($_POST['amount']);
	$price = getPrice($code);
	

	
	$estimation = round($price * 1.0005 * $amount,2);
	
	useMoney($estimation,$gId,'score3');
	dbQuery("INSERT INTO `zf_stock_tran` (`id` ,`zid` ,`item` ,`action`,`amount`,`estimation`)VALUES (NULL ,  '$gId',  '$code',  'BUY', $amount, $estimation)");
		
	dbQuery("INSERT INTO `zf_stock_hold` (`zid` ,`item` ,`amount` ,`estimation`) VALUES ({$gId}, '$code',  '$amount',  '$estimation') ON DUPLICATE KEY UPDATE amount=amount+$amount , estimation = estimation + $estimation");
	
}
$holding = dbAr("SELECT * FROM  `zf_stock_hold`  WHERE zid = $gId");

$htmltitle = "神秘商店";

include(template("header"));
?>

<script>
	function refreshPrice(icode,ititle){
		$('#item_title').html($("#stock_selector option:selected").text());
		$('#hidden_code').val(icode);
		$('#current_item').html("Loading...");
		$.get("trade.php",{getPrice:'1',code:icode},function(data){
			$('#current_item').html("$"+data + " (價格只供參考, 買入時可能會有變動)");
			
		});
		
	}
	
	$(document).ready(function() {
		$( "#selectable" ).selectable({
			selected: function(event, ui) {
			
				select_item($(ui.selected).attr('item_id'),$(ui.selected).attr('sprite_x'),$(ui.selected).attr('sprite_y'));
				
			}
		});
	});
	
	function select_item(item_no, x, y){
		$('#hidden_code').val(item_no);
		$('#description').html($("li[item_id="+item_no+"]").attr('desc'));
		$('#current_item_icon').css("background-position-x", x *34 +"px");
		$('#current_item_icon').css("background-position-y", y *34 +"px");
	}
	
</SCRIPT>
<style>
	#selectable .ui-selecting { background: #FECA40; }
	#selectable .ui-selected { border:#CCC 2px solid }
	#selectable { list-style-type: none; margin: 0; padding: 0; width: 300px; }
	#selectable li { margin: 3px; }
	
	.item_grid{width:34px; height:34px; background-image:url(http://cdn.topost.me/real_css_lib-rev1/34x34icons180709.png);}
	
	.eq_icon{border:3px #CCC dashed; width:45px; height:45px; margin:3px}
	.long{width:300px; border:1px #ccc solid}
</style
<div class="ui-widget-content pd5" style="margin-bottom:5px">
	<h3><?=$htmltitle?></h3>
	
	<table cellpadding="5">
		<tr>
			<td>
				
<ol id="selectable">
	<li class="ui-widget-content item_grid" item_id="1" sprite_x="0" sprite_y="14" desc='透視鏡' ></li>
</ol>
				
			</td>
			<td valign='top'>
				
				<div class='ui-widget-content pd5'>
					<form method='post' id='form1'>
						<h4 id='item_title'></h4>
						
						<div id='current_item_icon item_grid' class='left'></div>
						<div class='left pd5' id='description'></div>
						
						<div class='clear'></div>
						<input type='hidden' name='code' id='hidden_code' value="none"/>
						<a id='submit_btn' class='button hide2' onclick="$('#form1').submit();">確定買入</a>
					</form>
					<?if($success_message!=""){?>
						<fieldset>
							<?=$success_message;?>
						</fieldset>
					<?}?>
					<br />
				</div>
				
				<div class='ui-widget-content pd5' style='margin-top:3px'>
					<div class='left eq_icon' id='eq1_icon'></div>
					<div class='left eq_icon' id='eq2_icon'></div>
					<div class='clear'></div>
				</div>		
				
				
				
				
				
			</td>
		</tr>
	</table>
	
	
	
	
</div>
<?
include(template("footer"));

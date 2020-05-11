
<script>
	function refreshPrice(icode){
		$('#item_title').html($("#stock_selector option:selected").text());
		$('#hidden_code').val(icode);
		$('#current_price').html("Loading...");
		$.get("trade.php",{getPrice:1,code:icode},function(data){
			$('#current_price').html("$"+data + " (價格只供參考, 買入時可能會有變動)");
			
		});
		
	}
	
	<!--
	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
		
		return true;
	}
	//-->
</SCRIPT>

<div class="tdvfnav  ui-widget-content bottomround">
	<h3><?=$htmltitle?></h3>
	
	
	<select id='stock_selector' onchange="refreshPrice($(this).val());" style='width:100%'>
		<?php foreach($tradingItems as $cateName => $cateArray){?>
			<optgroup label='<?=$cateName;?>'>
				<?php foreach($cateArray as $code => $name){?>
					<option value='<?=$code;?>'><?=$name;?></option>
				<?}?>
			</optgroup>
		<?}?>
	</select>
	<div class='ui-widget-content'>
		
		<form method='post' 
		onsubmit="if($('#hidden_code').val()=='none'){alert('請選擇一隻產品');return false;}if($('#txt_amount').val()==''){alert('請輸入數量');return false;}" id='form1'>
			<h4 id='item_title'></h4>
			<span id='current_price' >請選擇右邊</span><br />
			購買: <input type='text' name='amount' id='txt_amount' onkeypress="return isNumberKey(event)" size='7'/>單位<br />
			<input type='hidden' name='code' id='hidden_code' value="none"/>
			<input type='hidden' name='action' value='buy' id='trade_action' />
			<a class='button' onclick="$('#trade_action').val('buy');$('#form1').submit();">買入</a>
			<a class='button' onclick="$('#trade_action').val('sell');$('#form1').submit();">賣出</a>
		</form>
		<?if($success_message!=""){?>
			<fieldset>
				<?=$success_message;?>
			</fieldset>
		<?}?>
		<br /><br />
		<br />
		提示：<br />
		- 要先把COINS 換成T-Currency 才可以進行買賣。<br />
		- 按左邊可提供即時報價, 每次收費0.1 coin<br />
		<button class='button' onclick="dialog('/ajaxbox/currencyExchange.php','找換店');">按此打開找換店</button>
		<br />
	</div>
	<div class='ui-widget-content'>
		持股:<br />
		<table>
			<? foreach($holding as $v){?>
				<tr>
					<td><?=$valueChart[$v['item']];?></td><td> * <strong><?=$v['amount'];?></strong></td></tr>
			<?}?>
		</table>
	</div>
	
	<div class='clear'></div>
	
	
</div>
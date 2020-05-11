
<script>
	
	function refreshPrice(icode,ititle){
		if(icode =='0000.HK'){return false;}
		
		if($('#txt_code').val() !=""){
			$('#item_title').html($("#stock_selector option[value='"+pad($('#txt_code').val(),4)+'.HK'+"']").text());
			}else{
			$('#item_title').html($("#stock_selector option:selected").text());
		}
		
		if($('#item_title').html() == ""){
			$("#current_price").html("不能交易這股票.");
			$('#hidden_code').val("none");
			return;
		}
		$('#hidden_code').val(icode);
		$('#current_price').html("Loading...");
		$.get("trade.php?getPrice=1&code="+icode,function(data){
			$('#current_price').html("$"+data + " (價格只供參考, 買入時可能會有變動)");
			$('#chart').attr('src',"	http://charts.aastocks.com/servlet/Charts?fontsize=12&15MinDelay=T&lang=1&titlestyle=2&Indicator=1&indpara1=10&indpara2=20&indpara3=50&indpara4=0&indpara5=0&scheme=1&com=100&chartwidth=400&chartheight=220&stockid="+$('#txt_code').val()+"&period=47&type=1&subChart1=14&ref1para1=0&ref1para2=0&ref1para3=0")
		});		
	}
	function pad(num, size) {
		var s = num+"";
		while (s.length < size) s = "0" + s;
		return s;
	}
	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}
		return true;
	}
</SCRIPT>
<h1><?=$htmltitle?></h1>
<div class="panel">
	<div class='panel-body'>
		
		<strong>Coin:</strong><?=$my['score1'];?> 
		<strong>GP:</strong> <?=$my['score2'];?> 
		<strong>Trade Currency:</strong> <?=$my['score3'];?>
		<?if($success_message!=""){?>
			<hr />
			<?=$success_message;?>
		<?}?>
		
		
		<table cellpadding="5" width="100%">
			<tr>
				<td width="50%" valign='top'>
					<div class='well'>
						輸入號碼: <input type='text' name='amount' id='txt_code' onkeypress="return isNumberKey(event);" size='7' /><button type="button" onclick="refreshPrice(pad($('#txt_code').val(),4)+'.HK');return false;">報價</button>
						<select id='stock_selector' multiple="multiple" style='height:250px; width:100%;' onchange="$('#txt_code').val(parseInt($(this).val()));refreshPrice($(this).val());">
							<?php foreach($tradingItems as $cateName => $cateArray){?>
								<optgroup label='<?=$cateName;?>'>
									<?php foreach($cateArray as $code => $name){?>
										<option value='<?=$code;?>'><?=$name;?></option>
									<?}?>
								</optgroup>
							<?}?>
						</select>
					</div>
				</td>
				<td valign='top'>
					
					<div class='well'>
						<form method='post' 
						onsubmit="if($('#hidden_code').val()=='none'){alert('請選擇一隻產品');return false;}if($('#txt_amount').val()==''){alert('請輸入數量');return false;}" id='form_trade'>
							<strong style='display:block' id='item_title'></strong>
							<span id='current_price' >請選擇左邊</span><br />
							<input type='text' name='amount' id='txt_amount' onkeypress="return isNumberKey(event)" size='7'/>單位
							<a class='btn btn-default btn-sm' onclick="$('#trade_action').val('buy');$('#form_trade').submit();">買入</a>
							<a class='btn btn-default btn-sm' onclick="$('#trade_action').val('sell');$('#form_trade').submit();">賣出</a>
							
							<input type='hidden' name='code' id='hidden_code' value="none"/>
							<input type='hidden' name='action' value='buy' id='trade_action' />
						</form>
						
						<img id='chart' width='100%' />
					</div>
				</td>
			</tr>
		</table>
		<h4>概況</h4>

		<div class='well'>
			
			<table class='table table-condensed'>
				<thead>
				<tr style='font-weight:bold'>
					<th>編號</th>
					<th>數量</th>
					<th>現價</th>			
					<th>總價</th>	
				</tr>
				</thead>
				<? foreach($holding as $v){?>
					<? $subTotal = $dataArr[$v['item']]["lastprice"] * $v['amount'];?>
					<tr>
						<td><?=$valueChart[$v['item']];?><br />
							<?=$cateInfo[$v['item']][1];?>
							</td>
						<td><?=$v['amount'];?></td>
						<td><?=$dataArr[$v['item']]["lastprice"];?></td>
						<td><?=$subTotal;?></td>
					</tr>
					<? 
						$tmpTotal += $subTotal;
						$pie[$cateInfo[$v['item']][0]]['value'] += $subTotal;
						$pie[$cateInfo[$v['item']][0]]['name'] = $cateInfo[$v['item']][1];
					?>
				<?}?>
				<tr style='font-weight:bold'>
					<td></td>
					<td></td>
					<td>總計</td>			
					<td><?=$tmpTotal;?></td>	
				</tr>
			</table>
		</div>	
		<div class=''>
		<? foreach($pie as $v){
			$t[] = $v["value"]/$tmpTotal;
			$chl[] = $v["name"];
		}?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
	google.load("visualization", "1", {packages:["corechart"]});
	function drawChart() {
	var data = google.visualization.arrayToDataTable([
	['種類', '比重'],
	<? foreach($pie as $v){?>
	['<?=$v["name"];?>',     <?=$v["value"];?>],
	<?}?>
	]);

	var options = {
	title: '<?=$gUsername;?>的倉',
	pieHole: 0.4,
	};

	var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
	chart.draw(data, options);
	}
	google.setOnLoadCallback(drawChart);
</script>
<!--
		<img src="http://chart.apis.google.com/chart?cht=p3&chd=t:<?=implode(",",$t);?>&chs=600x200&chl=<?=implode("|",$chl);?>" />
-->
		<div id="donutchart" style="width: 700px; height: 400px;"></div>
		</div>
		<table cellpadding="5" width="100%">
			<tr>
				<td width="400" valign='top'>
					<div class='well'>
						
						提示：<br />
						- 按左邊可提供即時報價, 每次收費0.02 coin<br />
						- 有獎活動進行中, 請參閱 <a href='/thread.php?tid=70328'>[原創]交易所比賽安排</a><br />
						
					</div>
				</td>
				<td valign='top'>
					
					<div class='well'>
						<h4>排行榜:</h4>
						<ol>
							
							<?foreach($ranking as $v){?>
								<li><a href='userinfo.php?zid=<?=$v['id'];?>'><?=$v['username'];?></a> : TC<?=$v['score_trade'];?></li>
							<?}?>
						</ol>
					</div>
				</td>
			</tr>
		</table>
		
	</div>
</div>
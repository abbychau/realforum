<?php
	include(dirname(__FILE__)."/Connections/zkizblog.php");
	include(dirname(__FILE__)."/include/common.inc.php");
	include(dirname(__FILE__)."/plugin/simple_html_dom.php");
	
	$time1 = date('09:30:00');
	$time2 = date('16:00:00');
	$timeNow=date('H:i');
	
	$hkStock = dbAr("SELECT DISTINCT concat(lpad(`code`,4,0),'.HK') code , chinese, english FROM `stock_list` ORDER BY code",60*60*24*15);
	$cateArr = dbAr("SELECT concat(lpad(`stock_id`,4,0),'.HK') code, name,cate_id FROM stock_cate a, stock_stock_cate b WHERE a.id = b.cate_id",60*60*24);
	foreach($cateArr as $v){
		$cateInfo[$v["code"]] = [$v["cate_id"],$v["name"]];
	}
	
	foreach ($hkStock as $v){
		$tmpHK[$v['code']] = $v['code']." ".($v['chinese']==""?$v['english']:$v['chinese']);
	}
	
	$tradingItems = array(
		'港股'=>$tmpHK,
		//'指數'=>['^HSI'=>'恒指 ^HSI','^DJI'=>'道指 ^DJI'],
		//'貴金屬'=>['SP_GOLD'=>'黃金']
	);
	$valueChart=array();
	foreach($tradingItems as $v){
		$valueChart = array_merge($valueChart, $v);
	}
	
	function getPrice($code){
		if(left($code,2) != "SP"){
			return getStockPrice($code);
			}else{
			return getGoldPrice();
		}
	}
	
	function getStockPrice($code){
		$info = getStockInfo($code);
		$price = $info["lastprice"];
		if($price <= 0){die("Internal Error [trade.php -> stock]");}
		return $price;
	}
	function getGoldPrice(){
		$s = file_get_contents("http://www.hsbc.com.hk/1/2/hk/investments/mkt-info/gold");$dom = str_get_html($s);$result = $dom->find('td.hsbcAlign06');
		$price = $result[0]->plaintext;
		$price = str_replace(",","",$price);
		if($price <= 0){screenMessage("Error","Internal Error{trade.php gold}");}
		return $price;
	}
	function getForeignMoney(){
		$s = file_get_contents("http://www.hsbc.com.hk/1/2/hk/investments/mkt-info/gold");$dom = str_get_html($s);$result = $dom->find('td.hsbcAlign06');
		$price = $result[0]->plaintext;
		$price = str_replace(",","",$price);
		if($price <= 0){screenMessage("Error","Internal Error{trade.php fm}");}
		return $price;
	}
	if($_GET['getPrice']){
		//useMoney(0.01,$gId);
		echo getPrice($_GET['code']);
		exit;
	}
	
	if($_POST['action'] == 'buy' || $_POST['action'] == 'sell'){
		$time1 = strtotime('09:30:00');
		$time2 = strtotime('16:00:00');
		$timeNow=date('H:i');
		if($timeNow <= $time2 && $time1 <= $timeNow){
			screenMessage("交易時段外不能交易","交易時段為上午九時半至下午四時");
		}else{
			
			if($_POST['action'] == 'buy' ){
				if(!is_numeric($_POST['code'])){
					screenMessage("股票代碼不正確");
				}
				$code=$_POST['code'];
				$amount=intval($_POST['amount']);
				$price = getPrice($code);
				if($price == 0){
					screenMessage("錯誤", "很抱歉, 不能取得正確的股價, 請重新再試");
				}
				
				$estimation = round($price * 1.002 * $amount,2);
				
				useMoney($estimation,$gId,'score3');
				dbQuery("INSERT INTO `zf_stock_tran` (`id` ,`zid` ,`item` ,`action`,`amount`,`estimation`)
				VALUES (NULL ,  '$gId',  ?,  'BUY', ?, $estimation)"
				,[$code,$amount]
				);
				
				dbQuery("INSERT INTO `zf_stock_hold` (`zid` ,`item` ,`amount` ,`estimation`) VALUES ({$gId}, '$code',  '$amount',  '$estimation') ON DUPLICATE KEY UPDATE amount=amount+$amount , estimation = estimation + $estimation");
				
				$success_message = "你已成功以 TC ".round($price * 1.002,2)." 購買 $code $amount 股, 合共 TC $estimation 。";
				
				dbQuery("DELETE FROM zf_stock_hold WHERE amount = 0");
			}
			if($_POST['action'] == 'sell'){
				if(!is_numeric($_POST['code'])){
					screenMessage("股票代碼不正確");
				}
				$code=$_POST['code'];
				$amount=intval($_POST['amount']);
				$price = getStockPrice($code);
				
				if($price == 0){
					screenMessage("錯誤", "很抱歉, 不能取得正確的股價, 請重新再試");
				}
				
				$estimation = round($price * 0.998 * $amount,2);
				
				$held = intval(dbRs("SELECT amount FROM zf_stock_hold WHERE `zid`= $gId AND item = '$code'"));
				if($held<$amount){
					screenMessage("股數不足", "你要出售 $amount 可是你只有 $held","trade.php");
					exit;
				}
				addMoney($estimation,$gId,'score3');
				
				dbQuery("INSERT INTO `zf_stock_tran` (`id` ,`zid` ,`item` ,`action`,`amount`,`estimation`)VALUES (NULL ,  '$gId',  '$code',  'SELL', $amount, $estimation)");
				
				dbQuery("UPDATE `zf_stock_hold` set amount=amount-? WHERE item = ? AND zid = '$gId'",[$amount,$code]);
				
				$success_message = "你已成功以 TC ".round($price * 0.995,2)." 出售 $code $amount 股, 合共 TC $estimation 。";
				
			}
		}
	}
	
	
	$holding = dbAr("SELECT * FROM  `zf_stock_hold`  WHERE zid = $gId");
	
	$htmltitle = "交易所";
	
	if(sizeof($holding)>0){
		foreach($holding as $v){
			$codes[] = $v["item"];
		}
		$dataArr = getStockInfoFromYahoo($codes);
	}
	$ranking = dbAr("SELECT id, username, score_trade FROM zf_user ORDER BY score_trade DESC LIMIT 10");
	
	
	include(template("header"));
	include(template("trade"));
	if( $tmpTotal){
		dbQuery("UPDATE zf_user SET score_trade = $tmpTotal  WHERE id = {$my['id']}",[],1800);
	}
	include(template("footer"));

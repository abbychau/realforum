<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
	require_once('../include/common.inc.php');
	
	$amount = intval($_POST["amount"]);
	$coinToTc = 1000;
	
	if ($amount > 0 && $isLog) {
		
		$tc = $coinToTc * $amount;
		
		useMoney($amount, $gId);
		
		dbQuery("UPDATE zf_user SET score3 = score3 + {$tc} WHERE id = $gId");
		
		header(sprintf("Location: ".prevURL()));
	}
	
?>
匯率: <br />
1 Coin To <?=$coinToTc;?> T-Currency<br />
<br />

<form method="POST" action='/ajaxbox/currencyExchange.php'>
	把<input type='text' name='amount' size='6'/>Coins 換成 T-Currency。<br />
	<input type='submit' value='兌換' /> 
	
</form>

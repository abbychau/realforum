<?php 
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php'); 
	
	if (!$isLog){screenMessage("錯誤","請先登入","http://members.zkiz.com/login.php");}
	$strGrabSQL = "SELECT * FROM zf_attention WHERE username = '$gUsername' LIMIT 100";
	if($_GET['action']=='delete'){
		dbQuery("DELETE FROM `zf_attention` WHERE username = :username AND code = :code",['username'=>$gUsername,'code'=>$_GET['code']]);
		$redis->delete($strGrabSQL);
	}
	
	if($_POST['code']!=''){
		if(!is_numeric($_POST['code'])){
			screenMessage("Error", "Wrong code number. (we only need for example : 5).");
		}
		dbQuery("INSERT INTO `zf_attention` (`username`,`code`)VALUES (:username,:code)",['username'=>$gUsername,'code'=>$_GET['code']]);
		$redis->delete($strGrabSQL);
	}
	
	$attentionInfo = dbAr($strGrabSQL, 7200);
	

	
	if(sizeof($attentionInfo)>0){

		foreach($attentionInfo as $k){
			if(is_numeric( $k['code'])){
				$tmpCode = symbolize($k['code']);
				if(cacheValid("HK_STOCK:".$tmpCode)){
					$stockinfo[$tmpCode] = cacheGet("HK_STOCK:".$tmpCode);
				}else{
					$arrUncached[] = $tmpCode;
				}
			}
		}
		
	}
	
	$htmltitle = "新聞通知系統";
	include(template("header"));
?>


<h1>RealForum 新聞通知系統</h1>
在你輸入相關的股票號碼 (eg. 0005) 後，當有系統有相關的新聞或通告時，會通知你去留意。
<div class="panel panel-default">
	<div class='panel-body'>
	<h3>關注Tag列表</h3>
	<? if($attentionInfo){?>
		<table class='table table-default'>
			<thead><th>Tag</th><th>股票資訊</th><th>刪除</th></thead>
			<? foreach($attentionInfo as $v){?>
				<tr><td><?=$v['code'];?></td>
				<td>
					<?if(is_numeric($v['code'])){?>
						<?=$stockinfo[symbolize($v['code'])]['ename'];?><br />
						$<?=$stockinfo[symbolize($v['code'])]['price'];?>
						(<?=$stockinfo[symbolize($v['code'])]['todaychange'];?>)<br />
						
					<?}?>
				</td>
				
				<td><a href='attention_input.php?action=delete&amp;code=<?=$v['code'];?>'>刪除</a></tr>
				<?}?>
				
			</table>
			<?}else{?>
			未關注任何Tag
		<?}?>
		<h3>請輸入你想留意的股票號碼或留意的tag</h3>
		<form method='post'>
			<input type='text' name='code' />
			<input type='submit' value='加入' class='btn btn-default' />
		</form>
	</div>
</div>


<hr />
<?include(template("footer"));?>
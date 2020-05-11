<?php require_once('Connections/zkizblog.php'); 
	//////////////////////
	$row_getinfo = dbRow("SELECT * FROM zf_item WHERE uid = $gId") or die(mysql_error());
	//////////////////////
	$moneyHeld = dbRs("SELECT score1 FROM zf_user WHERE id = $gId") or die(mysql_error());
	/////////////////////
	if (isset($_POST["MM_update"])) {
		if($_POST["MM_update"]=="1"){$word = "orange";$price="10";}
		if($_POST["MM_update"]=="2"){$word = "italic";$price="9";}
		if($_POST["MM_update"]=="3"){$word = "bold";$price="9";}
		if($_POST["MM_update"]=="4"){$word = "up";$price="9";}
		if($moneyHeld<$price){die("你不夠錢喔!!");}
		dbQuery("UPDATE zf_user SET score1=score1-$price WHERE id=$gId");
		dbQuery("INSERT IGNORE INTO zf_item SET uid = $gId");
		dbQuery("UPDATE zf_item SET $word = $word + 1");
		header("LOCATION:items.php");
	}
?>
<?php include_once('templatecode/header.php'); ?>
<h3>系統城 - 商店街</h3>
<p><strong>歡迎來到商店街, 你可以在這裡買入各識的道具來令到自己的冒險更加順利, 建出來的樓更加強大!
	你要買哪一個道具呢?
	
</strong><br />
現在賣的都是試用品，大有可能找不到地方應用的! 要注意喔!! </p>
<table width="100%" border="0" cellpadding="10" cellspacing="10" style="border:solid 3px #999; background-color:#FFF; margin-bottom:3px">
	<tr>
	<td><?php if($row_getinfo){?>你現有物品:　<strong>變橙劑</strong><?php echo $row_getinfo['orange'];?>個　<strong>大風車</strong><?php echo $row_getinfo['italic'];?>個　<strong>鋼根加固</strong><?php echo $row_getinfo['bold'];?>個　<strong>雲頂建築技術</strong><?php echo $row_getinfo['up'];?>個　<strong>金錢</strong><?=$moneyHeld;?><?php }else{ ?>你沒購買過任何東西<?php } ?></td></tr>
</table>
<table width="100%" border="0" cellpadding="10" cellspacing="10" style="border:solid 3px #999; background-color:#FFF">
	<tr>
		<td width="33%" align="center"><form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
			<img src="/images/orange.jpg" alt="orange" /><br />
			$10<br />
			<input value="買入一支變橙劑" type="submit" /><input type="hidden" name="MM_update" value="1">
			<br />
		</form></td>
		<td align="left" style="font-size:14">偶氮染料(偶氮基兩端連接芳基的一類有機化合物)是紡織品服裝在印染工藝中應用最廣泛的一類合成染料，用於多種天然和合成纖維的染色和印花，也用於油漆、塑料、橡膠等的著色。在特殊條件下，它能分解產生20多種致癌芳香胺，經過活化作用改變人體的DNA結構引起病變和誘發癌症。<br />
		<strong>這個變橙劑可以將帖子標題的顏色變橙!</strong></td>
	</tr>
	<tr>
		<td align="center"><form id="form2" name="form2" method="post" action="<?php echo $editFormAction; ?>">
			<img src="/images/italic.jpg" alt="italic" /><br />
			$9 <br />
			<input value="買入一個大風車" type="submit" />
			<input type="hidden" name="MM_update" value="2" />
			<br />
		</form></td>
		<td align="left" style="font-size:14">風車是一種帶有可調節的葉片或梯級橫木的輪子用來收集風力擁用的機械能的裝置。
			
			<br />
			在中國，使用風車的歷史很早。在遼陽三道壕東漢晚期的漢墓壁畫上，就畫有風車的圖樣。距今已有1700多年的歷史。明代開始應用風力來驅動水車以灌溉農田。
			
			<br />
		<strong>在RealForum 購買的這個強力大風車可以將帖子標題的角度吹斜!</strong></td>
	</tr>
	<tr>
		<td align="center"><form id="form3" name="form3" method="post" action="<?php echo $editFormAction; ?>">
			<img src="/images/bold.jpg" alt="bold" /><br />
			$9 <br />
			<input value="買入鋼根加固" type="submit" />
			<input type="hidden" name="MM_update" value="3" />
			<br />
		</form></td>
		<td align="left">我公司施工技術專業，質量可靠，設備齊全。我們企業的宗旨是：「以人為本，認真求實、誠信、質優、高效、創新」。有意者請聯繫，我願竭盡全力為您服務。<strong>令到你的帖子更強更粗!</strong></td>
	</tr>
	<tr>
		<td align="center" style="font-size:14"><form id="form4" name="form4" method="post" action="<?php echo $editFormAction; ?>">
			<img src="/images/up.jpg" alt="up" /><br />
			$50 <br />
			<input value="引進雲頂建築技術" type="submit" />
			<input type="hidden" name="MM_update" value="4" />
			<br />
		</form></td>
		<td align="left" style="font-size:14">雲頂高原，位於馬來半島，海拔2000米，是蒂迪旺沙山脈其中一個山峰，亦為一個著名的山區渡假村（即雲頂娛樂城）。雲頂高原橫跨馬來西亞的彭亨州及雪蘭莪州，距離吉隆坡市中心僅51公里，可從高速公路上山，車程約45分鐘，而外國遊客則需要從吉隆坡國際機場乘坐「機場直透快鐵」到吉隆坡中環廣場，轉乘巴士到纜車站，再登上高原。<br />
		<strong>把帖子放在雲頂, 遊客便可以輕鬆地在山頂看到你的帖了!</strong></td>
	</tr>
</table>
<br />&nbsp;<br />
<?php include_once('templatecode/footer.php'); ?>
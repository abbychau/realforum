<style>
input[type=text], textarea
{
	width:95%, padding:3px; border:1px #CCC solid;
}
</style>
<div style="padding:5px">
	<h3>修改信息</h3>
	
	
	<h4>基本信息</h4>
	<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
		
		使用者名稱:<br />
		<input name="username" type="text" disabled="disabled" value="<?php echo $row_getinfo['username']; ?>" />
		<br />
		
		
		密碼:<br />
		<a href='http://members.zkiz.com/modifyinfo.php'>按我修改</a><br />
				
		別名:<br />
		<input name="alias" type="text" value="<?php echo $row_getinfo['alias']; ?>" /><br />
				
		性別:<br />
		<select name="gender">
			<option value="0" <?php if (!(strcmp(0, $row_getinfo['gender']))) {echo "selected=\"selected\"";} ?>>未設定</option>
			<option value="1" <?php if (!(strcmp(1, $row_getinfo['gender']))) {echo "selected=\"selected\"";} ?>>男</option>
			<option value="2" <?php if (!(strcmp(2, $row_getinfo['gender']))) {echo "selected=\"selected\"";} ?>>女</option>
		</select>
		<br />
		
		
		生日:<br />
		<input name="birthday" type="text" id="datepicker" value="<?php echo $row_getinfo['birthday']; ?>" />(YYYY-MM-DD)<br />
		
		
		E-mail:<br />
		<input name="email" type="text" value="<?php echo $row_getinfo['email']; ?>" />      <br />
		
		
		網站: <br />
		
			<input name="url" type="text" value="<?php echo $row_getinfo['url']; ?>" />
		<br />
		
		
		<td align="right" valign="top">簽名:<br />
			<textarea name="signature"  rows="6"><?php echo htmlspecialchars($row_getinfo['signature']); ?></textarea>
			<br />
			
			
			<td align="right" valign="top">頭像: <br />

					<img src='<?=$my["pic"]?$my["pic"]:"images/noavatar.gif" ?>' width="150" />
					<br />
					<a href="http://members.zkiz.com/modifyinfo.php" class='button'>修改</a>

				
			</table>
			<h4>聯動設定</h4>
			Plurk API Key:
			<br />
			
			<input type='text' name='plurkkey' value="<?php echo htmlspecialchars($row_getinfo['plurkkey']); ?>"/><br />
			(填入API Key 後聯動會自動開始; 格式是: APIKEY|賬號|密碼 )<br />
			API Key 可到<a href='http://www.plurk.com/API'>這裡</a>申請
			<br />
			
			Facebook 聯動:
			<br />
			
			<?if($fb['me']){?>
				Connected to Facebook as <br /><a href='<?=$fb['me']['link'];?>'><strong><?=$fb['me']['name'];?></strong></a>
				<?}else{?>
				<a href='<?=$fb['object']->getLoginUrl(array("read_stream","publish_stream"));?>'>
				Connect to Facebook
				</a>
				
			<?php } ?>
			<br />
			是否在發主題時推到FB: <input type='checkbox' name='facebook' value="1" <?=$row_getinfo['facebook']=="1"?"checked":"";?> />
			<br />
			
			新浪微博:
			<br />
			
			<?if($me['weibo']==""){?>
				按我<a href="modifyinfo.php?connect=weibo">連接</a>
				<?}else{?>
				Connected. <br /><a href="modifyinfo.php?connect=weibo">Re-connect</a>
			<?}?><br />
			因為GFW 的關係，新浪微博未能和zkiz.com 聯動。
			<br />
		</table>
		
		<h4>功能設定</h4>
		
		收PM 時傳送E-Mail:
		<br />
		
		<select name="pm2email">
			<option value="0" <?php if (0==$row_getinfo['pm2email']) {echo "selected=\"selected\"";} ?>>否</option>
			<option value="1" <?php if (1==$row_getinfo['pm2email']) {echo "selected=\"selected\"";} ?>>是</option>
		</select>
		<br />
		
		不願收取BJ:
		<br />
		
		<select name="nobj">
			<option value="0" <?php if (0==$row_getinfo['nobj']) {echo "selected=\"selected\"";} ?>>否</option>
			<option value="1" <?php if (1==$row_getinfo['nobj']) {echo "selected=\"selected\"";} ?>>是</option>
		</select>
		<br />
	</table>		
	<br />
	<input class="button" type="submit" name="Submit" value="提交修改" />
	<input type="hidden" name="MM_update" value="form1">
</form>
</div>
<script>
	$(function() {
		$( "#datepicker" ).datepicker( { 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true
		});
	});
</script>													
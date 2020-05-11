<div class="page-header">
	<h1>修改信息</h1>
</div>
<style>
	.regform {padding:1em}
	.regform input{border:0; border-bottom:1px #BBB solid; width:100%}
	.regform td{padding:8px 3px}
	.regform textarea{padding:3px;border:1px #BBB solid;}
</style>
<div class="panel panel-default panel-body regform">
	<h4>基本信息</h4>
	<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
		<table style='width:100%;max-width:600px' border="0" cellpadding="8">
			<tr>
				<td width="170" align="right">使用者名稱:</td>
				<td><input name="username" type="text" disabled="disabled" value="<?php echo $row_getinfo['username']; ?>" /></td>
			</tr>
			<tr>
				<td width="170" align="right">密碼:</td>
				<td><a href='http://members.zkiz.com/modifyinfo.php'>按我修改</a></td>
			</tr>
			
			<tr>
				<td align="right">別名:</td>
				<td><input name="alias" type="text" value="<?php echo $row_getinfo['alias']; ?>" /></td>
			</tr>
			<tr>
				<td align="right">性別:</td>
				<td>
					<select name="gender">
						<option value="0" <?php if (!(strcmp(0, $row_getinfo['gender']))) {echo "selected=\"selected\"";} ?>>未設定</option>
						<option value="1" <?php if (!(strcmp(1, $row_getinfo['gender']))) {echo "selected=\"selected\"";} ?>>男</option>
						<option value="2" <?php if (!(strcmp(2, $row_getinfo['gender']))) {echo "selected=\"selected\"";} ?>>女</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" valign='top'>生日:</td>
				<td><input name="birthday" type="text" id="datepicker" value="<?php echo $row_getinfo['birthday']; ?>" />(YYYY-MM-DD)</td>
			</tr>
			<tr>
				<td align="right">E-mail:</td>
				<td><input name="email" type="text" value="<?php echo $row_getinfo['email']; ?>" />      </td>
			</tr>
			<tr>
				<td align="right">網站: </td>
				<td><label>
					<input name="url" type="text" value="<?php echo $row_getinfo['url']; ?>" size="50" />
				</label></td>
			</tr>
			<tr>
				<td align="right" valign="top">簽名:</td>
				<td><textarea name="signature" cols="40" rows="6"><?php echo htmlspecialchars($row_getinfo['signature']); ?></textarea>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top">頭像: </td>
				<td>
				
<?php if(file_exists(getAvatarRealPath($gUsername,150))){?>
	
	<img src="<?=getAvatarURL($gUsername,150)?>" alt="avatar" />
	<?}else{?>
	還未設定頭像!
<?}?>
(<a href='http://members.zkiz.com/modifyinfo.php'>按我設置</a>)
				
				</td>
			</tr>
		</table>
		<h4>聯動設定</h4>
		<table width="600" border="0" cellpadding="5">
			<tr><td width="170" align="right" valign='top'>
				Plurk API Key:
			</td>
			<td align="left" valign='top'>
				<input type='text' name='plurkkey' size='40' value="<?php echo htmlspecialchars($row_getinfo['plurkkey']); ?>"/><br />
				(填入API Key 後聯動會自動開始; 格式是: APIKEY|賬號|密碼 )<br />
				API Key 可到<a href='http://www.plurk.com/API'>這裡</a>申請
			</td></tr>
			<tr><td align="right" valign='top'>
				Facebook 聯動:
				</td><td>
				
				<?if($fb['me']){?>
					已由<a href='<?=$fb['me']['link'];?>'><strong><?=$fb['me']['name'];?></strong></a> 連接到Facebook
                    <a class='btn btn-xs btn-default' href='<?=$fb['object']->getLogoutUrl(array( 'next' => 'http://realforum.zkiz.com/modifyinfo.php' ));?>'>斷開連接</a>
					<?}else{?>
					<a href='<?=$fb['object']->getLoginUrl(array("read_stream","publish_actions"));?>'>連接到Facebook</a>
					
				<?php } ?>
				<br />
				是否在發主題時推到FB: <input type='checkbox' name='facebook' size='40' value="1" <?=$row_getinfo['facebook']=="1"?"checked":"";?> />
			</td></tr>
			<tr><td align="right" valign='top'>
				新浪微博:
			</td>
			<td>
				<?if($me['weibo']==""){?>
					按我<a href="modifyinfo.php?connect=weibo">連接</a>
					<?}else{?>
					Connected. <br /><a href="modifyinfo.php?connect=weibo">Re-connect</a>
				<?}?><br />
				因為GFW 的關係，新浪微博未能和zkiz.com 聯動。
			</td></tr>
		</table>
		
		<h4>功能設定</h4>
		<table width="600" border="0" cellpadding="5">
			<tr><td width="170" align="right">
				收PM 時傳送E-Mail:
			</td>
			<td align="left">
				<select name="pm2email">
					<option value="0" <?php if (0==$row_getinfo['pm2email']) {echo "selected=\"selected\"";} ?>>否</option>
					<option value="1" <?php if (1==$row_getinfo['pm2email']) {echo "selected=\"selected\"";} ?>>是</option>
				</select>
			</td></tr>
			<tr><td width="170" align="right">
				不願收取BJ:
			</td>
			<td align="left">
				<select name="nobj">
					<option value="0" <?php if (0==$row_getinfo['nobj']) {echo "selected=\"selected\"";} ?>>否</option>
					<option value="1" <?php if (1==$row_getinfo['nobj']) {echo "selected=\"selected\"";} ?>>是</option>
				</select>
			</td></tr>
		</table>		
		<br />
		<input class="btn btn-primary" type="submit" name="Submit" value="提交修改" />
		<input type="hidden" name="MM_update" value="form1">
	</form>

</div>
<hr />
	關係
	<? print_r($relation);?>
	
<script>
	$(function() {
		$( "#datepicker" ).datepicker( { 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true
		});
	});
</script>
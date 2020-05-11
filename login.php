<?php
	require('Connections/zkizblog.php'); 
	require('include/common.inc.php');
$htmltitle = "登入";
include_once('templatecode/header.php'); ?>
<h2>登入(this link is temporary avaliable only)</h2>
<table border="0" align="center" cellpadding="10" cellspacing="10">
<tr>
	<td>
		
		<?php if(!$isLog){ ?>
			<?php if($_GET['msg']==1){?>
				<span style="color:#F00">賬戶或密碼錯誤, 請重新輸入</span><br />
			<?php }?>
			<form id="form1" name="form1" method="POST" action="processlogin.php">
			  <table width="200" border="0">
				<tr>
					<td>使用者名稱:<br /><input type="text" name="username" class="text ui-widget-content ui-corner-all" /></td>
				</tr>
				<tr>
					<td>密碼:<br /><input type="password" name="password" class="text ui-widget-content ui-corner-all" /></td>
				</tr>
				<tr>
					<td><input type="hidden" value="<?=$_SERVER['HTTP_REFERER']==""?$_GET['url']:$_SERVER['HTTP_REFERER'];?>" name="refer" />
						<input type="submit" name="Submit" class="button" value="登入" />
						<a href="forgotpw.php">忘記密碼?</a>
						</td> 
				</tr>
			</table>
			</form>
		<?php }else{ ?>
			你已經登入!
		<?php } ?>
	</td>
</tr>
</table>
<script type="text/javascript">
$('.button').button().css('font-size','14px');
</script>
<?php include_once('templatecode/footer.php'); ?>

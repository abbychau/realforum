

<?include_once("templatecode/onlinemembers.php");?>




<div class="clear">
</div>


</div>

</div>


<?php
	$time = explode(' ', microtime());
	$time = $time[1] + $time[0];
	$total_time = round(($time - $start), 4)*1000;
?>



<style>
	.grayfooter div{border-top:1px solid; padding:5px}
</style>

<div id='toTop' style="padding: 5px 3px;
bottom: 5px;
right: 5px;position:fixed;cursor:pointer" onclick="$('html, body').animate({scrollTop:0}, 'fast');"  class='rf_fixed'>
	
	<img width="38" height="38" src="http://www.gaelanrommes.com/wp-content/themes/yin_and_yang/images/layout/top-button.png" alt="Back to top" />
</div>

<div class='grayfooter'>
	<div>
		<?php if ($isLog){ ?>
			己登入: <?=gId2rank($gUserGroup,"b");?>: <?=$gUsername;?> (Gold: <?=$my['score1'];?>)
			<a href="http://members.zkiz.com/logout.php?refresh=<?=curURL();?>">登出</a>
		<?}?>
	</div>
	<div>
		Paged in <?=$total_time;?>ms (Q=<?=$queryno;?>) @ <?=date("Y-n-j h:i A");?>	
	</div>
	<div>
		
		回貼後回到:<a onclick="createCookie('afterpost','thread',30);window.location.reload();">貼子</a>
		<a onclick="createCookie('afterpost','viewforum',30);window.location.reload();">主題列表(預設)</a><br />
		<a onclick="createCookie('rf_template','normal',30);window.location.reload();">使用桌面版</a><br />
	</div>
	<div>
		<a href="http://ec.zkiz.com"><img width="40" src="http://share.zkiz.com/official/EC.jpg" alt="Endless Choice" border="0" /></a>
		<a href="http://realblog.zkiz.com"><img width="40" src="http://share.zkiz.com/official/RB.jpg" alt="Real Blog" border="0"  /></a>
		<a href="http://realforum.zkiz.com"><img width="40" src="http://share.zkiz.com/official/RF.jpg" alt="Real Forum" border="0"  /></a>
		<a href="http://stock.zkiz.com"><img width="40" src="http://share.zkiz.com/official/ST.jpg" alt="ZKIZ.com" border="0"  /></a>
		<a href="http://www.zkiz.com"><img width="40" src="http://share.zkiz.com/official/ZKIZ.jpg" alt="ZKIZ.com" border="0"  /></a>
	</div>
	<div class="clear"></div>
	
</div>


<a name="footer" id="footer"></a>





<script type="text/javascript">
	/*$(".button").button();*/
	/*$(".bold_button").button().css('font-weight','bold');*/
	/*$(".radioset").buttonset();*/
		$(window).scroll(function () {
		
		if ( $(window).width() > 1000 ) {
			
			if ($('body').scrollTop() > 1000) {
				$('#toTop').fadeIn('fast');
				} else {
				$('#toTop').fadeOut('fast');
			}
			
		}
		
	});
</script>



</div>


</body>
</html>
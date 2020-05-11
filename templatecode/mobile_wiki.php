
<script type="text/javascript">
/* <![CDATA[ */
function jump(to){
location.href='thread.php?tid=<?=$gTid?>&page=' + (Math.ceil(to / <?=$maxRows_getReply;?>)-1) + "#" + to;
}
function addtag(str){
location.href='thread.php?tid=<?=$gTid?>&addtag=' + str;
}
function showurl(id){
url = "<?=curURL();?>#" + id;

txt = '<embed width="62" height="24" align="middle" flashvars="txt='+url+'" src="/images/Copy.swf" quality="high" wmode="transparent" allowscriptaccess="sameDomain" pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash">';

return "<fieldset><legend>此回帖的路徑</legend>" + url + txt + "</fieldset>";
}
/* ]]> */
</script>

<div class="mainborder">


<?php if($donated == true){ ?>
<div class="ui-state-highlight ui-corner-all" style="margin: 5px 0; padding: 0 .7em 0;"> 
	<p style="margin:5px"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
	<strong>謝謝!</strong> 你的捐款令我們做得更好!</p>
</div>
<?}?>
<div class="tdvfnav">


<div style="height:40px;float:left; max-width:700px">
<?=buildNav(array("<a href='viewforum.php?fid={$rpFid}'>{$row_getThread['name']}</a>", mb_substr($title,0,60,"utf-8").(mb_strlen($title,"utf-8")>60?"...":""))); ?>
<br />
建立者: <strong><?=$row_getThread['username'];?></strong>
<?php if($gUserGroup>=7){?>
<a style="color:#bbbbbb;" onclick="dialog('ajaxbox/delthread.php?id=<?=$row_getReply['id']; ?>&tid=<?=$gTid; ?>','管理',false,360);">管理</a>
<?php }?>



</div>



<div class="right" style="padding:5px;">
<strong style="font-size:20px"><?php echo $row_getThread['views']; ?></strong><br />
人氣
</div>
<div class="right" style="padding:5px;">
<strong style="font-size:20px"><?php echo $row_getThread['commentnum']; ?></strong><br />
回覆
</div>
<? if($row_getThread['donation']>0){?>
<div class="right" style="padding:5px;">
<strong style="font-size:20px">$<?php echo $row_getThread['donation']; ?></strong><br />
捐款
</div>
<?}?>

<div class="right" style="padding:5px">

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="threaddonate">
<!-- Identify your business so that you can collect the payments. -->
<input type="hidden" name="business" value="abbychau@gmail.com">
<!-- Specify a Donate button. -->
<input type="hidden" name="cmd" value="_donations">
<!-- Specify details about the contribution -->
<input type="hidden" name="item_name" value="RealForum Thread id:<?=$gTid; ?> Donation">
<input type="hidden" name="item_number" value="Donate to Thread(id:<?=$gTid; ?>)">
<input type="hidden" name="amount" value="5.00">
<input type="hidden" name="currency_code" value="HKD">
<input type="hidden" name="return" value="https://realforum.zkiz.com/thread.php?tid=<?=$gTid; ?>&message=donate_success&checksum=<?=encrypt(time());?>">
<input type="hidden" name="cancel_return" value="https://realforum.zkiz.com/thread.php?tid=<?=$gTid; ?>&message=donate_canceled">
<!-- Display the payment button. -->

</form>

</div>
<div class="clear"></div>
</div>
<div style="padding-bottom:0px;">





<?php $initNum = $startRow_getReply;?>

<?php do { ?>
<?++$initNum ?>
<?if($_GET['authoronly']=="" || $_GET['authoronly']==$row_getReply['authorid']){?>

<a name="<?=$initNum ?>"></a>


<?if($initNum==1){?>
<script>
function loadinto(iid){
$('#adsb4post').toggle();
$('body').scrollTo( $('#adsb4post'), 800 );
$.get("ajaxdata.php", {type : "replycontent", id: iid},function(data){
		$('#content').html(data);
	}
);
}
</script>
<div class="authorbarright right">
<a onclick="loadinto(<?=$row_getReply['id'];?>)" class='linksidefunction button withicon'>
<span class="ui-icon ui-icon-pencil insidebutton"></span>修改
</a>

	<a class='linksidefunction button' onclick="convert(0,'floor<?=$initNum;?>')">繁->簡</a>
	<a class='linksidefunction button' onclick="convert(1,'floor<?=$initNum;?>')">簡->繁</a>

	
	<a onclick="dialog('ajaxbox/gjreply.php?id=<?=$row_getReply['id']; ?>&amp;tid=<?=$gTid; ?>&amp;target=<?=$row_getReply['authorid'];?>','GJ!');" class='linksidefunction button withicon'>
		<span class="ui-icon ui-icon-heart insidebutton"></span>
		GJ! x <?php if($row_getReply['praise']>0){?><?=$row_getReply['praise']; ?><?php }else{?><?=$row_getReply['praise']; }?>
	</a>
	
<a onclick="$('#threaddonate').submit()" class='linksidefunction button withicon'>
<span class="ui-icon ui-icon-star insidebutton"></span>為此文章捐贈五元
</a>
</div>	
<?}?>

<div class="ui-widget-content reply clear">
	
	<div style="width:100%; font-size:16px;">
<?if($initNum==1){?>

<h1 style="padding:5px;margin:0; display:block; font-size:16px; border-bottom:1px solid" id="title"><?=$title?></h1>



<div class="threadtitlebar" style='font-size:12px'> 
<strong>Tags:</strong>
<?if(!$noTag){?>
	<? foreach($tags as $v){?>
	<a style="font-weight:bold; text-decoration:underline" href="http://zkiz.com/tag.php?tag=<?=$v;?>"><?=$v;?></a>
	<? }?>
<? }?>
	<div class="right">
	
	
	<a href="<?=$currentPage;?>&amp;renewtag=1">自動TAG</a> | 
		加入TAG:
		<input type="text" style="width:50px; border:none;border-bottom:1px solid #CCC; background:none" onkeydown="if(event.keyCode==13){addtag(this.value);}" /> 
		
<? if(($row_getReply['authorid'] == $gId || ($gUserGroup>7) || $isMod) && $isLog == true){?>
	|&nbsp;<a class="linksidefunction" onclick="$('#title').load('ajaxbox/modititle.php?tid=<?=$gTid; ?>');">修改標題/建立捷徑</a>
<? } ?>

		
	</div>
</div>

<div class="clear"></div>
<div style='padding:10px 0'><?=$bbcode->Parse($row_getReply['content']); ?></div>
<?}?>
<div style='font-size:12px'>

	<img width='20' src='<?=$row_getReply['pic']==""?"images/noavatar.gif":$row_getReply['pic']; ?>' alt="avatar" />
<a href="userinfo.php?zid=<?=$row_getReply['authorid']; ?>"><?=$row_getReply['username']; ?></a>
	

<?php if($row_getReply['alias']!=""){echo "(".$row_getReply['alias'].")";}?>
在<?=$row_getReply['timestamp'];?>作出修改。
<?if($initNum!=1){?>
<a onclick="$('#backup<?=$initNum;?>').toggle()">按此看副本存檔</a>
<div id='backup<?=$initNum;?>' style='display:none'><?=$bbcode->Parse($row_getReply['content']); ?></div>
<?}?>
</div>
<?if($initNum==1){?>
<hr />
<!-- AddThis Button BEGIN -->
<span style="float:left;font-size:15px;line-height:32px">分享到：</span>
<div class="addthis_toolbox addthis_32x32_style addthis_default_style left">
<a class="addthis_button_facebook"></a>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_plurk"></a>
<a class="addthis_button_funp"></a>
<a class="addthis_button_digg"></a>
<a class="addthis_button_xanga"></a>
<a class="addthis_button_blogger"></a>
<a class="addthis_button_googlereader"></a>
<a class="addthis_button_googlebuzz"></a>
<a class="addthis_button_live"></a>
<a class="addthis_button_email"></a>
</div>
<script type="text/javascript">var addthis_config = {"username":"abbychau", "data_track_clickback":true};</script><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=abbychau"></script><!-- AddThis Button END -->
<div class='left'>
<a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">分享</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>

<iframe src="http://www.facebook.com/plugins/like.php?href=<?=htmlspecialchars(curURL());?>&amp;layout=button_count&amp;show_faces=true&amp;width=70&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px; margin-bottom:-8px"></iframe>
</div>
<div class='clear'></div>
<hr />
<?}?>
	
		
		
	
	
	<?php parsePicurl($row_getReply['picurl']);?>
	<?php if(strtotime($row_getReply['timestamp']) - strtotime($row_getReply['datetime']) > 60){ ?>
	<div class="contentmodinfo">最後修改:<?=$row_getReply['timestamp'];?></div>
	<?php } ?>
	
	<?php if($row_getReply['modrecord'] != ""){ ?>
	<div class="contentmodinfo" style="color:green">其他紀錄:<?=$row_getReply['modrecord'];?></div>
	<?php } ?>
    

	</div>


<div style="clear:both"></div>

</div>
<div style="clear:both;padding-left:10px">
<?if($row_getReply['isfirstpost']==1){?>
<script type="text/javascript"><!--
google_ad_client = "pub-2146633441538112";
/* 468x60, 已建立 2009/8/12 */
google_ad_slot = "1675737649";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?}?>
</div>

<?php } ?>
<?php } while ($row_getReply = mysql_fetch_assoc($getReply)); ?>
</div>



<div id="adsb4post" style='display:none'>



<?php if($noguest != ture || $isLog == true){?>
<?php include_once("templatecode/quickpost.php");?>
<?php } ?>

</div>






</div>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="<?=($description == "")?"zkiz.com提供, 吹水, 遊戲, 論壇, 可以自行創建版塊":$description." - RealForum(formerly X-Kizz)";?>" />
		<meta name="keywords" content="<?=$keywords;?>" />
		<title><?=htmlentities($htmltitle, ENT_COMPAT, "UTF-8"); ?> - RealForum</title>
		<meta name="generator" content="RealForum 3.0" />
		<meta name="author" content="abbychau" />
		<meta name="copyright" content="2009 abbychau" />
		<meta content="no" name="apple-mobile-web-app-capable" />
		<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
		<link rel="apple-touch-icon" href="http://share.zkiz.com/iosicon/rf.gif"/>
		<link href="http://rf.m.zkiz.com/images/startup.png" rel="apple-touch-startup-image" />
		<link rel="archives" title="RealForum" href="<?=$g_domain;?>/archiver/" /> 
		<link rel="alternate" type="application/rss+xml" title="RealForum 主題更新" href="<?=$g_domain;?>/rss.php" />
		<link rel="shortcut icon" href="/favicon.ico" />
		
		<link rel="stylesheet" type="text/css" href="http://abby.zkiz.com/ecoui.css" />	
		<link rel="stylesheet" type="text/css" href="//dl.dropboxusercontent.com/u/15015062/cdn/real_css_lib-rev1/mobile_base.css"/> 
		<link rel="stylesheet" type="text/css" href="//dl.dropboxusercontent.com/u/15015062/cdn/prettify-1-Jun-2011/prettify.css" />
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
		<script type="text/javascript" src="http://share.zkiz.com/js/real.jslib.js"></script>
		<script type="text/javascript" src="//dl.dropboxusercontent.com/u/15015062/cdn/prettify-1-Jun-2011/prettify.js"></script>
		
		<style type="text/css">
			*{font-size: 12pt;}
			.authorbar *{font-size:12px}
		</style>
		<script type="text/javascript">
			/* <![CDATA[ */
			var lastdropdown = "none";
			var docTitle = document.title;
			
			// increase the default animation speed to exaggerate the effect
			$.fx.speeds._default = 1000;
			$(function() {
				$('#showajax').dialog({
					autoOpen: false,
					show: 'highlight',
					hide: 'highlight'
				});
			});
			function dialog(url, title, iframe,width){
				if(iframe==true){
					$('#showajax').html('<iframe style="border:none;width:100%" src="'+url+'"></iframe>').dialog('open');
					}else{
					$('#showajax').load(url).dialog('open');
				}
				$('#showajax').dialog( "option", "title", title );
				if(width>1){
					$('#showajax').dialog( "option", "width", width );
				}
			}
			function stock(num){
				alert(num); 
			}
			function dropdown(using, url, ioffset, iwidth,iframe){
				if(window.lastdropdown!=using){$( "#showajax2" ).hide();}
				window.lastdropdown=using;
				
				$("#showajax2").toggle();
				
				if(iframe==true){
					$('#showajax2').html('<iframe style="border:none;width:100%;height:450px" src="'+url+'"></iframe>');
					}else{
					$('#showajax2').load(url);
				}
				
			}
			setInterval("checkNoti()",1000*60);
			
			function checkNoti(){
				$.get('ajaxdata.php',{type: 'notify'},
				function(data){
					$('#notify').html(data);
					if(data != '0'){
						document.title = docTitle + '(' + data + ')';
						}else{
						document.title = docTitle;
					}
				});
			}
			checkNoti();
			
			/* ]]> */
		</script>
		<script type="text/javascript">
			
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-4293967-12']);
			_gaq.push(['_trackPageview']);
			
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			
		</script>
	</head>
	<body>
		
		<a name="top" id="top"></a>
		<div class="wrapper" style="width:100%">
			
			
			<style>
				.noline a{width:25%;display:block;float:left; text-align:center;padding:3px 0;}
				.ui-widget-content{margin-left:0;margin-right:0}
				.ajaxbox{border:0}
				.pagination{padding:5px 1px}
				.pagination a{text-decoration:none;padding:0.3em;background-color:#DDD;border-radius:2px;}
				.pagination li{float:left;list-style-type:none;margin:0.1em}
			</style>
			<?php if(!$isApp){?>
				<div class="navPanel ui-widget-header" style="border-top:none;background:#EEE;position:fixed;width:100%;top:0;border:0">
					
					<div class="noline">
						
						<a href="/index.php" style="font: italic Georgia, 'Times New Roman', 'Bitstream Charter', Times, serif;">RF首頁</a>
						
						
						<?php if (!$isLog){ ?>
							<a id="reg" onclick="dropdown('reg','http://members.zkiz.com/reg.php?box=1','0 30',500,true);">註冊</a>
							<a style="cursor:pointer" onclick="$('#showlogin').dialog({modal:true,width:200});">登入</a> 
							<?php } else { ?>
							
							
							<a href="/pm.php">短信息(<?=dbRs("SELECT count(*) FROM zf_pm WHERE isread = 0 AND to_id = {$gId} AND del_receiver = 0");?>)</a>
							
							<a onclick="dropdown('notibox','ajaxbox/notification.php','0 30')" id="notibox">通知(<span id="notify"></span>)</a>
						<?php } ?>
						
						<a onclick='$("#searching").toggle()'>搜尋</a>
						<div class='clear'></div>
					</div>
					<div class='ajaxbox ui-widget-content' id='searching' style='right:0;z-index:5'>
						
						<form method="get" action="http://zkiz.com/tag.php">
							<input type="text" size="50" name="tag" value="Tag 搜尋" onclick="this.value=''" style="padding:5px;float:left;height:17px;width:150px; margin-right:1px" />
							<input type='submit' value='搜尋'/>
							
						</form>
					</div>
					<div class=" ajaxbox ui-widget-content" id="showajax2" style="right:0;z-index:5"><img src="images/loadingAnimation.gif" alt="loading" /></div>
				</div>
			<?}?>
			
			<?php if (!$isLog){ ?>
				<div id="showlogin" style="display:none;" title="登入">
					<form name="loginform" method="post" action="/login.php">
						名稱:<input type="text" name="username" />
						<div style="height:6px"></div>
						密碼:<input type="password" name="password" />
						<div style="height:6px"></div>
						<input type="hidden" name="refer" value="<?=curURL();?>" />
					<input type="submit" name="Submit" value="登入" /></form>
				</div>	
			<?php } ?>
			<div id="ee" class="ui-widget-content  " <?php if(!$isApp){?>style="border:0px;width:100%;margin-top:38px"<?}?>>
				
				
				<div id="showajax" ></div>
				
				
			<div class="indexBlock " style=" padding-bottom:10px; margin:0">						
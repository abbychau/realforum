<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title><?=htmlentities($htmltitle, ENT_COMPAT, "UTF-8"); ?> - RealForum</title>
		<!-- RBy_sxU1TucPONNMK19f4HXPEvA -->
		<meta name="generator" content="RealForum 3.1 security patch" />
		<meta name="author" content="abbychau" />
		<meta name="dcterms.rightsHolder" content="2009-2015 abbychau" />
		<meta name="description" content="<?=($description == "")?"zkiz.com提供, 吹水, 遊戲, 論壇, 可以自行創建版塊":htmlspecialchars($description);?>" />
		<meta name="keywords" content="<?=htmlspecialchars($keywords);?>" />	
        
		<meta property="og:title" content="<?=htmlentities($htmltitle, ENT_COMPAT, "UTF-8"); ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="<?=curURL();?>" />
		<?php if($ogImage!=""){?><meta property="og:image" content="<?=$ogImage;?>" /><?}?>
		<meta property="og:site_name" content="<?=htmlentities("RealForum",ENT_COMPAT, "UTF-8");?>" />
		<meta property="og:description" content="<?=($description == "")?"zkiz.com提供, 吹水, 遊戲, 論壇, 可以自行創建版塊":htmlspecialchars($description);?>" />
		<meta property="fb:app_id" content="255045087298" />
		
		<link rel="archives" title="RealForum" href="<?=$g_domain;?>/archiver/" /> 
		<link rel="alternate" type="application/rss+xml" title="RealForum 主題更新" href="<?=$g_domain;?>/rss.php" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="manifest" href="/manifest.json" />
		
        <!--<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">-->
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css" />
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.1/themes/smoothness/jquery-ui.css" />
		
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" />
		
        <script type="text/javascript">
            var adblock = true;
		</script>
        <script type="text/javascript" src="/js/adframe.js"></script>
        <script type="text/javascript">
            if(adblock) {
                alert("Please do not enable adblock on our site. We rely on them.");
			}
		</script>
		<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
		<script src="//code.jquery.com/ui/1.10.1/jquery-ui.min.js" defer></script>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/1.9.6/jquery.pjax.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
		
		
		<script type="text/javascript">
			var _mfq = _mfq || [];
			(function() {
				var mf = document.createElement("script");
				mf.type = "text/javascript"; mf.async = true;
				mf.src = "//cdn.mouseflow.com/projects/c9599629-6102-4c6b-8e8b-6b60ab8db5f4.js";
				document.getElementsByTagName("head")[0].appendChild(mf);
			})();
		</script>
        <script src="//share.zkiz.com/js/real.jslib.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="/js/respond.min.js"></script>
			<style>.snapperLeft{display:none} #globalLeftBar{display:none;}</style>
		<![endif]-->


		<?php if(!$gNoAds){?>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-4549800596928715",
                enable_page_level_ads: true
            });
        </script>
		<?}?>
		<style type='text/css'>
			
			<?if(""!=$_COOKIE['allfont']){$allfont=$_COOKIE['allfont'];}
				else{$allfont='Roboto,Helvetica,Arial,sans-serif';}
			?>
			
			html{font-family:Sans-Serif;}
			.label{font-size:1em;}
			.body_withfixedbar{margin-top:60px}
            
			.adv_space{border-left:3px solid #CCC; padding:.5em 1em;font-size:9pt; border-radius:0;margin:.5em 0}
			.adv_space hr{padding:0;margin:.5em}
			.margin0{margin:0;}
			
			
			.scroll_container .affix{ top: <?=$_COOKIE['topbarDefault']!="normal"?"50":"5"?>px;}
			
			a:focus, a:active,a{outline:none !important}
			blockquote{font-size:inherit}
			#noticeBox{position:fixed; top:250px; right:50%; width:150px; margin-right:-75px; padding: 20px;display:none;background:#DEDEDE;color:#000;border:2px solid #000; border-radius:1em;font-weight:bold;z-index:10}
			.bbcode_img{max-width:100%}
			body{
			color:black;
			font-size:15px;
			font-family: <?=$allfont;?>;
			word-break: break-all;
			padding:10px 0 0 0;
			<?if(""!=$_COOKIE['bgcolor']){?>	background-color:<?=$_COOKIE['bgcolor'];?>;	<?}?>
			}
			#ee{}
			h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {font-family: <?=$allfont;?>;}
			.turnleft{transform: rotate(270deg);-ms-transform: rotate(270deg); -webkit-transform: rotate(270deg); }
			.turnright{transform: rotate(90deg);-ms-transform: rotate(90deg); -webkit-transform: rotate(90deg); }
			.turn180{transform: rotate(180deg);-ms-transform: rotate(180deg); -webkit-transform: rotate(180deg); }
			
			a{cursor:pointer;color:#00507f}
			.clear{clear:both;}
			.left{float:left;}
			.right{float:right;}
			.badge a{color:white}
			.label a{color:white}
			
			
            @media (max-width: 767px){
			.navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
			color:#CCC;
			}
			.navbar-nav .open .dropdown-menu {
			color:#CCC;
			}
            }
			
			
			
			.bbcode_auth{background: url(images/bbeditor/authuser.gif) no-repeat;}
			.bbcode_code{border-left:#338 3px solid;width:95%;margin:5px 0 3px;}
			.bbcode_code_body{padding:5px;}
			.bbcode_code_head{border-bottom:#CCC 1px solid;padding:2px 2px 2px 5px;}
			.bbcode_columns{border:#999 1px solid;border-collapse:collapse;width:100%;}
			.bbcode_green{border-left:#383 3px solid;width:95%;margin:5px 0 3px;}
			
			.embed_container75{position: relative;width:100%;max-width:680px;}
			.embed_container75:before{	content: "";	display: block;	padding-top: 75%;}
			.embed_container125{position: relative;width:100%;max-width:680px;}
			.embed_container125:before{content: "";display: block;	padding-top: 125%;}
			.embed_picurl{position:absolute;top: 0;left: 0;bottom: 0;right: 0;}
			.bbcode_list{padding-left:40px;}
			.bbcode_quote{opacity:0.9;-moz-opacity:.9 filter: alpha(opacity=90);margin:5px 0 3px;border-left:#888 1px solid;margin-bottom:1em;}
			.bbcode_quote_body{padding:1em;}
			.bbcode_quote_head{border-bottom:#888 1px solid;font-weight:bold;padding:0.2em 1em;}
			.bbcode_red{border-left:#833 3px solid;width:95%;margin:5px 0 3px;}
			.bbcode_wiki{font-style:italic;border-bottom:1px dashed;}
			.bbcode_yellow_back{background:#F0F0F0;}
			
			
			.ajaxbox{-webkit-box-shadow:#CCC 0 0 1em;-moz-box-shadow:#CCC 0 0 1em;position:absolute;display:none;padding:5px;}
			.alt_back{background:#EEE;}
			
			.authorinfo{float:left;width:125px;padding-left:5px;border-right:solid 1px;}
			
			.blocka{display:block;margin:3px;padding:3px;}
			.bold a,.bold{font-weight:700;}
			.bottomlink a{padding-right:3px;padding-left:3px;}
			.buyspan{color:#F60;font-weight:700;cursor:pointer;background:url(/images/coin.gif) no-repeat;background-color:#FFF;padding-left:15px;}
			.catebar{border-bottom:0;}
			.catebar a{display:block;text-decoration:none;float:left;padding:4px 7px;color:#616161}
			
			.ext_link_selections button{display:block;width:150px;height:30px;margin:2px;}
			.fbhide,.authorname{display:none;}
			.fbhidecontainer{border:1px dashed;padding:5px;}
			.hide2{display:none}
			.insidebutton{left:.2em;position:absolute;top:50%;margin:-8px 5px 0 0;}
			.lbdiv{white-space:nowrap;line-height:17px;height:52px;width:300px;float:left;overflow:hidden;margin:2px;padding:5px;}
			.navFellow{display:none;position:absolute;}
			.nols{list-style:none;margin-left:-20px;overflow-x:hidden;}
			.pd5{padding:0.2em;}
			.reply{margin-bottom:10px;border-left:0;border-right:0;overflow:hidden;padding:15px;}
			
			.rf_fixed{position:fixed;}
			.withicon{padding-left:10px;}
			
			.gold{  font-size:2em;color:#f4ca16;font-weight:bold;}
			.silver{font-size:2em;color:#c1c3c2;font-weight:bold;}
			.bronze{font-size:2em;color:#c59564;font-weight:bold;}
			.boxshadow{box-shadow: 0 0 10px rgba(0, 0, 0, .9);}
			#top_icon{font: 22px Tahoma, Helvetica, Arial, Sans-Serif;color: #222;text-shadow: 0px 1px 2px #555;}
			#top_icon:hover{text-decoration:none}
			.adv_space{max-height:200px;overflow:hidden;}
			
			.google_pdf_nbbc{
			<?php if($is_mobile){?>
				width:300px; height:300px; border:0;
				<?}else{?>
				width:600px; height:600px; border:0;
				
			<?}?>
			}
			.newsmallfont{font-size:12px;}
			
			.sidebarPanelBody a{display: block;margin-top:1em;font-size:1.1em;font-weight:bold}
			
			.input-xs {
			height: 22px;
			padding: 2px 5px;
			font-size: 12px;
			line-height: 1.5;
			border-radius: 3px;
			}

		</style>
		<script src="/js/ChromePushManager.js" ></script>
		<script>
			//<![CDATA[
			
			//Global Variable
			var docTitle = document.title;
			var isFirstNotification = 0;
			var isMobile = {
				Android: function() {
					return navigator.userAgent.match(/Android/i) ? true : false;
				},
				BlackBerry: function() {
					return navigator.userAgent.match(/BlackBerry/i) ? true : false;
				},
				iOS: function() {
					return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
				},
				Windows: function() {
					return navigator.userAgent.match(/IEMobile/i) ? true : false;
				},
				any: function() {
					return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
				}
			};
			
			//Global Functions
			
			
			function quicksearch(){
				
				$.get('/ajaxbox/singlecode.php',{code:$('#quickstock').val()},function(data){
					$('#quickresult').html(data);
					$(".closebtn").button({icons: {primary: "ui-icon-close"},text: false});
				});
				
			}
			function quickNotice(str){
				$("#noticeBox").html(str);
				$("#noticeBox").fadeIn( function() {
					setTimeout( function(){$("#noticeBox").fadeOut("fast");}, 2000);
				});
			}
			
			function renewTitleAndNoti(){
				if($('#notify').html() != '0'){
					document.title = '(' + $('#notify').html() + ')' + docTitle;
					$('#notify').removeClass("label-default").addClass("label-success");
					$('#notify').show();
					}else{
					document.title = docTitle;
					$('#notify').removeClass("label-success").addClass("label-default");
					$('#notify').hide();
				}
			}
			function domToModal(dom,title){
				$('#modelDialog').find(".modal-body").empty().append(dom);
				$('#modelDialog').find(".modal-title").html(title);
				$('#modelDialog').modal({ keyboard: false}).modal('show');
			}
			function closeModal(){
				$('#modelDialog').modal('hide');
				
			}
			function dialog(url, title, iframe,width,height){
				var tempContent;
				if(height == undefined){height=600;}
				if(iframe==true){
					tempContent = '<iframe id="dialogiframe" style="border:none;height:'+height+'px;width:100%" src="'+url+'"></iframe>';
					$('#modelDialog').find(".modal-body").html(tempContent);
					}else{
					$('#modelDialog').find(".modal-body").load(url);
				}
				$('#modelDialog').modal({ keyboard: false}).modal('show');
				$('#modelDialog').find(".modal-title").html(title);
				if(width>1){
					//$('#modelDialog').css("width", width );
				}
			}
			function dropdown(url,iframe){
				
				$("#showajax2").html('<img src="/images/loadingAnimation.gif" />');
				
				$("#showajax2").toggle('fast');
				
				if(iframe==true){
					$('#showajax2').html('<iframe  style="border:none;width:100%;height:470px" src="'+url+'"></iframe>');
					}else{
					$('#showajax2').load(url);
				}
				
			}
			function iframe_box_load(url){
				$("#iframe_boxi").attr('src',url);
				$("#iframe_box").show("fast");
				$("#iframe_box_url").val(url);
			}
			function navPop(dom){
				
				$(".white-background").removeClass("white-background");
				if(!$("#"+dom).is(":visible")){
					$("#"+dom).parent().addClass("white-background");
				}
				
				$("#"+dom).toggle();
				
			}
			
			function load_chatroom(){
				$('#chatroom_load').toggle();
				if($('#chatroom_load').is(":visible")){
					$('#chatroom_iframe').attr('src', '//chat.zkiz.com/?box=true');
					createCookie("chatroom","on",30);
					}else{
					$('#chatroom_iframe').attr('src', '');
					createCookie("chatroom","off",30);
				}
			}
			function toggle_navbarfixed(){
				$("#navbar").toggleClass("navbar-fixed-top");
				$("body").toggleClass("body_withfixedbar");
				
				$(".scroll_container .affix").css("top",$("#navbar").hasClass("navbar-fixed-top")?50:5);
				
				//$("navFixIcon").toggleClass("glyphicon glyphicon-chevron-up");
				createCookie("topbarDefault",$("#navbar").hasClass("navbar-fixed-top")?"fixed":"normal", 300);
			}
			
			/*
				//Queue-jump
				if (supports_html5_storage()) {
				var theme = localStorage.theme;
				if (theme) {
				$('#bs3_theme_css').attr('href', theme);
				}
				} else {
				$('#theme-dropdown').hide();
				}
			*/
			//Document Ready Queue
			$(document).ready(function(){
				/*
                $(document).pjax('a', '#ee');
                $(document).pjax('.thread_main_content_pagin a','.thread_main_content');
                $(document).on('pjax:start', function() { NProgress.start(); });
                $(document).on('pjax:success', function() { window.scrollTo(0,0); });
                $(document).on('pjax:end',   function() { NProgress.done();  });
				*/
                var kkeys = [];
                $(this).keydown(function(e){
                    kkeys.push( e.keyCode );
                    if ( kkeys.toString().indexOf( "38,38,40,40,37,39,37,39,66,65" ) >= 0 ){
                        $(this).unbind('keydown', arguments.callee);
                        domToModal($('<div><iframe width="420" height="315" src="//www.youtube.com/embed/m5DCrVmLvfo?autoplay=1" frameborder="0" allowfullscreen></iframe></div>'),"573");
					}
				});
				
				$( "[title]" ).tooltip();
				//$("#affix_sidebar").width($("#affix_sidebar").parent().width());
				
                $(function() {
					var $affix = $(".snap"),
					$parent = $affix.parent(),
					resize = function() { $affix.width($parent.width()); };
					$(window).resize(resize);
					resize();
				});
				
				$('#btnNotificationButton').click(
				function() {
					if ($('#desktopTest').is(':hidden')) {
						dialog('/ajaxbox/notification.php',"通知");
						}else{
						if(!$('#noti').is(":visible")){
							navPop('noti');
							$.get('/ajaxbox/notification.php',function(data){
								$('#noti').html(data);
								$(".closebtn").button({icons: {primary: "ui-icon-close"},text: false});
							});
							}else{
							navPop('noti');
						}
					}
				}
				);
				/*
					$('body').on('click', '.change-style-menu-item', function() {
					var theme_name = $(this).attr('rel');
					if(theme_name!=""){
					var theme = "//netdna.bootstrapcdn.com/bootswatch/3.0.0/" + theme_name + "/bootstrap.min.css";
					}else{
					var theme = "/css/bs3.css";
					}
					
					$('#bs3_theme_css').attr('href', theme);
					if (supports_html5_storage()) {
					localStorage.theme = theme;
					}
					});
				*/
				$(window).scroll(function () {
					
					if ( $(window).width() > 1000 ) {
						
						if ($('body').scrollTop() > 1000) {
							$('#toTop').fadeIn('fast');
							} else {
							$('#toTop').fadeOut('fast');
						}
						
					}
					
				});
				
				
				prettyPrint();
				<?if($isLog){?>
					
					var myScore1 =  parseFloat(<?=$my['score1'];?>);
					var prevScore1 = parseFloat(readCookie("prevScore1"));
					if(prevScore1!=myScore1){
						var fltDiff = Math.abs(prevScore1 - myScore1).toFixed(2);
						
						if(prevScore1>myScore1){
							quickNotice("金錢 -" + fltDiff);
							}else{
							quickNotice("金錢 +" + fltDiff);
						}
						createCookie('prevScore1',myScore1,30);
					}
					
					
					setInterval(
					function (){
						if(isFirstNotification++ > 0){
							$.get('/ajaxdata.php',{type: 'notify'},
							function(data){
								
								if(data != '0'){
									if($('#notify').html() < data && readCookie("mute")!="true"){
										$('#noti_mp3').trigger("play");
									}
								}
								$('#notify').html(data);
								renewTitleAndNoti();
							});
						}
					}
					,1000*30);
					
					renewTitleAndNoti();
					
					if(readCookie("chatroom")=="on"){
						$('#chatroom_load').show();
						$('#chatroom_iframe').attr('src', '//chat.zkiz.com/?box=true');
					}
					
					
					
				<?}?>
				
				
				
				
			});
			
			
			
			//Facebook Function Register
			window.fbAsyncInit = function() {
				FB.init({
					appId      : '255045087298', // App ID
					channelURL : '//www.zkiz.com/share/channel.html', // Channel File
					status     : true, // check login status
					cookie     : true, // enable cookies to allow the server to access the session
					oauth      : true, // enable OAuth 2.0
					xfbml      : true,  // parse XFBML
					  version: 'v3.3'
				});
				
				// Additional initialization code here
				FB.Event.subscribe('comment.create', function(response){
					//comment_noti();
				});
				FB.Event.subscribe('edge.remove', function(href, widget) {
					createCookie("<?=$gTid?>", 0, 30);
					$(".realcontent").hide();
				});
				FB.Event.subscribe('edge.create', function(response){
					createCookie("<?=$gTid?>", <?=$gTid*2;?>, 30);
					$(".realcontent").show('slow');
				});
				
			};
			

			
	
			
			//Google Analytic
			
			/* ]]> */
		</script>
		<script async defer src="https://connect.facebook.net/zh_HK/sdk.js"></script>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			ga('create', 'UA-4293967-12', 'zkiz.com');
			ga('require', 'displayfeatures');
			ga('send', 'pageview');
			
			
			var isPushEnabled = false;
			
			
			
			//apikey:AIzaSyAXXHsJBIKRMICyEoKND4ck7624vKyltIs
			//projid:73328766179
			//push code
			// Generate the user private channel
			var channel = generateUserChannel();
			
			$(document).ready(function() {
				
				// we're ready ...
				// check if current browser is Chrome
				var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
				if(!is_chrome) {
					//alert("this demo requires Chrome 42+");
				}
				
				// update the UI  
				$('#curl').text('curl "//realforum.zkiz.com/send" --data "AK=B2N59F&AT=SomeToken&C=' + channel + '&M=hello"');
				$('#channel').text(channel);
				
				// start Chrome Push Manager to obtain device id and register it with Realtime
				// a service worker will be launched in background to receive the incoming push notifications
				// var chromePushManager = new ChromePushManager('./service-worker.js', function(error, registrationId){
					
				// 	if (error) {
				// 		//alert(error);
				// 		$("#curl").text("Oops! Something went wrong. It seems your browser does not support Chrome Push Notification. Please try using Chrome 42+");
				// 		$("#sendButton").text("No can do ... this browser doesn't support push notifications");
				// 		$("#sendButton").css("background-color","red");
				// 	};
					
				// 	// connect to Realtime server
				// 	loadOrtcFactory(IbtRealTimeSJType, function (factory, error) {
				// 		if (error != null) {
				// 			alert("Factory error: " + error.message);
				// 			} else {
				// 			if (factory != null) {
				// 				// Create Realtime Messaging client
				// 				client = factory.createClient();
				// 				client.setClusterUrl('https://realforum.zkiz.com/server/ssl/2.1/');
								
				// 				client.onConnected = function (theClient) {
				// 					// client is connected
									
				// 					// subscribe users to their private channels
				// 					theClient.subscribeWithNotifications(channel, true, registrationId,
				// 					function (theClient, channel, msg) {
				// 						// while you are browsing this page you'll be connected to Realtime
				// 						// and receive messages directly in this callback
				// 						console.log("Received message from realtime server:", msg);
				// 					});
				// 				};
								
				// 				// Perform the connection
				// 				// In this example we are using a Realtime application key without any security
				// 				// so you should replace it with your own appkey and follow the guidelines
				// 				// to configure it
				// 				client.connect('B2N59F', 'myAuthenticationToken');
				// 			}
				// 		}
				// 	});
				// });    
			});
			
			// generate a GUID
			function S4() {
				return (((1+Math.random())*0x10000)|0).toString(16).substring(1); 
			}
			
			// generate the user private channel and save it at the local storage
			// so we always use the same channel for each user
			function generateUserChannel(){
				userChannel = localStorage.getItem("channel");
				if (userChannel == null || userChannel == "null"){ 
					guid = (S4() + S4() + "-" + S4() + "-4" + S4().substr(0,3) + "-" + S4() + "-" + S4() + S4() + S4()).toLowerCase();               
					userChannel = 'channel-' + guid;
					localStorage.setItem("channel", userChannel);
				}
				return userChannel;
			}
			
			// send a message to the user private channel to trigger a push notification
			function send(){
				if (client) {
					client.send(channel, "This will trigger a push notification");
				};
			}
		</script>
	</head>
	
	<body style='border:none' <? if($_COOKIE['topbarDefault'] != "normal"){?>class='body_withfixedbar'<?}?> data-spy="scroll" data-target=".scroll_container">
		<div id="fb-root"></div>
		<a id="top"></a>
		<div id="noticeBox"></div>
		<div class="wrapper clear container" >
			<?include(template('navbar'));?>
			<div class='row'>
				
				<div class='col-xs-12 col-md-<?=($gNoSidebar?12:9);?>' id="ee">
					<?if($isLog && !file_exists(getAvatarRealPath($gUsername,150))){?>
						<div class="alert alert-warning">
							<strong>提示!</strong> 你還沒有設定頭像呢!(<a href='/modifyinfo.php'>按我設置</a>)
						</div>
					<? } ?>					
<style scoped>
.navbar-inverse{background:#9f7973}
.navbar-inverse .navbar-nav>li>a,.navbar-inverse .navbar-brand{color:#EEE}
.navbar-nav>li>a{padding:0.8em;color:white}
.navbar .container{}
.navbar-brand{padding:0.7em 1em 0.3em 1em;}
.navbar{min-height:0;}
.navbar-default{background:none;border:none}
.navbar-brand{height:inherit}
.navbar .top-search-bar{width:130px;margin-top:0.4em;margin-bottom:0;}
#navbar_searchfield::-webkit-input-placeholder {color: #DDD;}
#navbar_searchfield::placeholder{
	color:#DDD
}
#navbar_searchfield{
	box-shadow: none;
	color:#DDD;
	background:transparent;
	border:0;
	border-bottom:2px #EEE solid;
}
#pm_num,#notify{
    position: absolute;
    top: 7px;
    left: 22px;
    margin: 0;
    padding: 1px 2px 2px;
    border-radius: .5em;
    font-size: 12px;
    background: red;
}
</style>

<div class="navbar navbar-inverse navbar-fixed-top navbar-static-top" id='navbar'>
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" style="border:0">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">RF</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<?php if($isLog){?>
					<li class="dropdown">
						<a id='btnNotificationButton'><span class='glyphicon glyphicon-bell'></span> <span id="notify" class='<?=$my['notification']?"show":"hide";?> label label-default'><?=$my['notification'];?></span> <span class="hidden-md hidden-lg hidden-sm">通知</span></a><div id="noti" class="dropdown-menu"></div>
					</li>
					<li id='nav_pm'>
						<a href="/pm.php"><span class='glyphicon glyphicon-envelope'></span><span id="pm_num" class='<?=$my['unread_pm']?"show":"hide";?> label label-default'><?=$my['unread_pm'];?></span> <span class="hidden-md hidden-lg hidden-sm">私信</span></a>
					</li>
				<?}?>


				<!--li class='dropdown'>
					<a onclick="$('#zM2').load('/templatecode/forumlist.php').toggle();">版塊列表<b class="caret"></b></a>
					<ul class="dropdown-menu" id='zM2'>
					</ul>
				</li-->

				<li id="nav_new_post">
					<a href="/post.php?type=post" style='font-weight:bold' id='navbar_newpost_button'><span class='glyphicon glyphicon-pencil'></span> 發帖</a>
				</li>
                <li><a href="viewforum.php"><span class="glyphicon glyphicon-home"></span> 全區</a></li>
			</ul>

			<ul class='nav navbar-nav navbar-right' style='margin-right:0'>



				<?php if($isLog){?>
					<li class="dropdown">

						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='<?=$my['pic']?$my['pic']:"/images/noavatar.gif";?>' style='width:1em' /> <?=$gUsername;?><b class="caret"></b></a>

						<ul class="dropdown-menu">
							<li>
								<? $lv = postnum2rank($my['postnum']);?>
								<table style='background:transparent'>
									<tr><td style='font-weight:bold;padding:0 5px;' align='right'><span class='glyphicon glyphicon-usd'></span></td><td><?=$my['score1'];?></td></tr>
									<tr><td style='font-weight:bold;padding:0 5px;' align='right'>T</td><td><?=$my['score3'];?></td></tr>
									<tr><td style='font-weight:bold;padding:0 5px;' align='right'>GP</td><td><?=$my['gp'];?></td></tr>
									<tr><td style='font-weight:bold;padding:0 5px;' align='right'>LV</td><td><?=$lv;?></td></tr>
									<tr><td style='font-weight:bold;padding:0 5px;' align='right'>EXP</td><td><?=$my['postnum'];?> / <?=rank2postnum($lv+1);?></td></tr>
								</table>
							</li>
							<li class="divider"></li>
							<li><a href='/userinfo.php?zid=<?=$gId;?>'><span class='glyphicon glyphicon-user'></span> 個人檔案</a></li>
							<li><a href="/modifyinfo.php"><span class=' glyphicon glyphicon-pencil'></span> 修改信息</a></li>
							<li class="divider"></li>
							<li><a onclick="$('#footersettings').modal('show');"><span class='glyphicon glyphicon-wrench'></span> 設置</a></li>
							<li><a href='/logout.php'><span class='glyphicon glyphicon-log-out'></span> 登出</a></li>
						</ul>
					</li>

					<?}else{?>

					<li class="dropdown">	

						<a href="#" class="dropdown-toggle" data-toggle="dropdown">登入<b class="caret"></b></a>

						<div id="noti" class="dropdown-menu pd5">

							<form name="form1" method="post" action="http://members.zkiz.com/processlogin.php">
								<input name="username" type="text" placeholder="使用者名稱" class="form-control">
								<input name="password" type="password" placeholder="密碼" class="form-control">

								<input type="hidden" name="refer" value="<?=curURL();?>" />
								<button type="submit" class="btn btn-success">登入</button>
							</form>
						</div>
					</li>
					<li><a href="http://members.zkiz.com/reg.php" target="_blank">註冊</a></li>
				<?}?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-th-list'></span><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="quest.php"><i class="fa fa-space-shuttle"></i> 任務</a></li>
						<li><a href="achievements.php"><span class='glyphicon glyphicon-certificate'></span> 成就系統</a></li>
						<li><a href="viewforum.php?type=digest">精華區</a></li>
						<li><a href="operation_record.php">管理操作紀錄</a></li>
						<li><a href="ranks.php">排行榜</a></li>
                        						<li><a href="forums.php">Boards</a></li>

						<li class="divider"></li>
						<!--li><a onclick="load_bookmark()">切換收藏夾</a>	</li-->
                        <li id="nav_new_topic">
					<a href="/viewforum.php?order=topictime&amp;type=all"><span class='glyphicon glyphicon-asterisk'></span> 新帖</a>
				</li>
						<li>	<a onclick="load_chatroom()">切換聊天室</a></li>
						<li class="divider"></li>
						<li><a href="/plugin.php?id=transbbcode">轉貼工具</a></li>
						<li><a href="/plugin.php?id=stickerwall">貼紙牆</a></li>
						<li><a href="/plugin.php?id=makeidentity">身份證製造機</a></li>
					</ul>
				</li>
<!--
				<li>

					<a onclick="toggle_navbarfixed()"><span class='glyphicon glyphicon-chevron-up'></span></a>

				</li>
-->
			</ul>
			<form class="navbar-form navbar-right top-search-bar" method="get" action="/gSearchResult.php" style="width:140px">
				<div class="input-group input-group-sm">
					<input type="text" name="q" placeholder="&#xF002; 關鍵字搜尋" style="font-size:.9em;font-family:Arial, FontAwesome"  class="form-control left" id="navbar_searchfield" />
				</div>
			</form>
		</div><!--/.navbar-collapse -->
	</div>
</div>


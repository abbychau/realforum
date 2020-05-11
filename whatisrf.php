<?php
include("Connections/zkizblog.php");
include("include/common.inc.php");

$htmltitle="甚麼是RealForum?";
$description="RealForum 是一個可以自由發展意見和主題的社區。很不少和普偏論壇不一樣的地方，敬請加倍注意...";
include(template('header'));
?>
<style>
	.my{background:#EEE;border-radius:1em; padding:1em;margin:1em 0}
	.my p{padding:1em;display:block;margin:0 1em 1em 1em}
</style>
<div class="my">
<h3>甚麼是RealForum?</h3>
<p>
RealForum 是一個可以自由發展意見和主題的社區。很不少和普偏論壇不一樣的地方，敬請加倍注意：
<ol>
	<li>版塊的建立無需經任何管理人員批準，發貼有足夠數目以賺夠足夠金錢的人都可以開設自己的版塊。</li>
	<li>這裡沒有任何版主以上的管理人員，所有版塊都由版主自己操作。唯［系統主任］和［系統補導員］在各個版塊都有版主權限，以作緊急支援，現今各有一人。</li>
	<li>任何有足夠金錢的會員都可以任意評分，包括正評和負評。</li>
</ol>
</p>

<h3>如何使用RealForum?</h3>
<form action="search.php" method="get" name="hdform2">
<p>
	
建議在首頁中的"本週熱門版塊"中找找自已感興趣的版面瀏覽。如沒有的話，可以在"版塊"中尋找其他，再沒有的話，可以在這裡輸入一個關鍵字建立自己的版塊。

	<input name="kw" type="text" size="40" style="width:150px;border:1px solid #CCC">
	<input type="submit" value="尋找版塊／開新區" style="border:1px solid #CCC">

</p>
</form>
<h3>開新區後版主可以做甚麼?</h3>
<p>
成為版主後進入自已的版塊會出現紅圈內的按鈕<br />
<img src="http://img.ctrlv.in.s3.amazonaws.com/img/518159b1748ef.png" alt="circle"/><br />
點擊［版主設定選項］後可以設定該版的分類、公告、名稱、ＩＣＯＮ、副版主、是否容許訪客發貼、黑名單、只容許特定用戶發貼以至ＣＳＳ設定等。<br />
<br />
CSS設定範例：<a href="<?=$g_domain;?>/viewforum.php?fid=132">動漫遊戲音樂</a>區。
<pre style="margin:0 40px">
.navPanel{
font-size: 14px;
background:url(http://archive.mikuchan.org/miku/src/130761492222.jpg);
line-height: 100%;
border-bottom: 1px solid #DDD;
padding: 500px 0 0px 0;
position: relative;
}
.innerNavPanel{
background:rgba(255,255,255,0.7);
padding:5px;
border-radius:3px;
}
body{background: url(http://th01.deviantart.net/fs41/300W/i/2009/039/5/6/Vocaloid___Megurine_Luka_by_taziko.jpg);
background-position: 100% 100%;
background-repeat: no-repeat;
background-attachment: fixed;}

.thread_main_content,.viewmain {
border: 10px solid rgb(179, 134, 134);
margin-top: 5px;
background: rgba(233, 233, 233, 0.9);
border-radius: 10px;
}
</pre>
</p>
<h3>受到惡意留言可以怎麼做？</h3>
<p>
	在這個社區的大多是成年人，因此在大多數情況下可以以理相喻。但RF 還是提供了系統性的對策。
	<ol>
	<li>簡便的方法是把對方封鎖，以後他的回覆將會隱藏起來。封鎖方法:<br /><img src="http://snag.gy/gVMKC.jpg" /></li>
	<li>如覺得對方留言不佳，可以以BJ示意，如出現罵戰或甚至出現［BJ戰爭］的話，你可以在［設定］（<a href="<?=$g_domain;?>/modifyinfo.php">傳送</a>）中選擇［不願收取BJ］，但這時你的發貼收益會減半。</li>
	</ol>
	
</p>

<h3>怎麼賺取金錢?</h3>
<p>
賺錢方法如下：
<table border="1" style="margin-left:30px">
	<tr style="font-weight:bold"><td>動作</td><td>可賺金錢</td></tr>
<tr><td>在RealForum開主題</td><td>$1.0</td></tr>
<tr><td>在RealForum回覆</td><td>$0.4 - 0.6 (字數&gt;15 : 0.6, &lt;15 : 0.4)</td></tr>
<tr><td>在RealForum發表的主題被回覆</td><td>$0.3</td></tr>
<tr><td>在RealForum帖子被GJ</td><td>GJ 數 * 0.7</td></tr>
<tr><td>在RealBlog 發新文章</td><td>$3</td></tr>
</table>
</p>
<h3>金錢有甚麼用途?</h3>
<p>
	<table border="1" style="margin-left:30px">
	<tr style="font-weight:bold"><td>動作</td><td>可賺金錢</td></tr>
<tr><td>在RealForum開區</td><td>$50</td></tr>
<tr><td>在RealForum帖子被BJ</td><td>$(頁數*2)</td></tr>
<tr><td>在RealForum BJ/GJ帖子</td><td>$(BJ數)</td></tr>
<tr><td>在Endless Choice 開通劇本</td><td>$(BJ/GJ數)</td></tr>
<tr><td>在RealBlog 發新文章</td><td>$20</td></tr>
<tr><td>在RealForum 即時報價</td><td>$0.2</td></tr>
<tr><td>搜尋tag</td><td>$0.2</td></tr>
<tr><td>在RealForum 搜尋全文</td><td>$1</td></tr>
<tr><td>在RealForum 發短訊</td><td>$1</td></tr>
</table>
</p>
<h3>對論壇有建議可以怎麼做？</h3>
<p>
	有以下三種途徑:
	<ol>
<li>可以PM聯絡：<a href="<?=$g_domain;?>/pm.php?toid=1">abbychau</a></li>
<li>E-Mail：abbychau (at) gmail.com</li>
<li>或到版務區發貼：<a href="<?=$g_domain;?>/viewforum.php?fid=194">傳送</a></li>
</ol>
</p>

</div>

<div class="fb-comments" notify="true" data-href="<?=$g_domain;?>/whatisrf.php" data-num-posts="10" data-width="990"></div>

<?
include(template('footer'));
?>
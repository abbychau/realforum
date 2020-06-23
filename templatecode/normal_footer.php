<div class="clear"></div>



<?php
	if(!isset($getTodayPostnum)){
		$getTodayPostnum = dbAr("SELECT  `id` ,  `username` ,  `postnum_today` FROM  `zf_user` ORDER BY  `postnum_today` DESC LIMIT 10");
	}
?>
<div style='margin-top:5px'></div>

<div class="clear"></div>

</div><!--row-->
<? if(!$gNoSidebar){?>
	<div class='hidden-xs hidden-sm col-xs-12 col-md-3' style='font-size:13px;overflow:hidden;' id='globalLeftBar'>
		<? include(template($gCustomSidebar?$gCustomSidebar:'frame_left')); ?>
	</div>
<?}?>
</div><!--wrapper clear container-->

<div class="row">
<div class="well col-md-9" style="margin:1em 0 0 0;border-bottom:0;border-bottom-right-radius:0;border-bottom-left-radius:0">

    <div class='row links'>

        <div class='col-xs-12 col-md-3'>
            <h5>今日發貼排名</h5>
            <div class='small'>
                <ol>
                    <?php foreach($getTodayPostnum as $v){ ?>

                        <li>
                            <a href="/userinfo.php?zid=<?=$v['id']; ?>"><?=$v['username']; ?></a>(<?=$v['postnum_today']; ?>)
                        </li>

                    <?php } ?>
                </ol>
            </div>
        </div>
        <div class='col-xs-12 col-md-9'>
            <form method="get" action="/search.php">
                <div class="input-group input-group-sm pd5">
                    <input type="text" name="member" placeholder="搜尋用戶" class="form-control"  />
                    <div class="input-group-btn">
                        <button type='submit' class="btn btn-default">搜尋</button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            </form>
            <!--
            <form method="get" action="/search.php">
                <div class="input-group input-group-sm pd5">
                    <input type="text" name="kw" placeholder="全文搜尋" class="form-control"  />
                    <div class="input-group-btn">
                        <button type='submit' class="btn btn-default">Search</button>
                    </div>
                </div>
            </form>
            -->
            <br />
            <a onclick="createCookie('rf_template','mobile',30);window.location.reload();">使用舊手機版</a>  |
            <a onclick="createCookie('rf_template','normal',30);window.location.reload();">使用新版</a>
            <br />

            <a href="/whatisrf.php">甚麼是RealForum</a> | <a href="https://readme.zkiz.com">Code Documentations</a>
            <br />

            <a href="/keiji.php?to=<?=base64_encode(curURL());?>" target="_parent" id='split_mode'>分欄模式</a> |
            <a href="<?=curURL();?>" target="_parent" id='normal_mode'>普通模式</a>
            <?if($isLog){?>
                | <a href='/quest.php?action=accept&id=1'>每日禮包</a>
            <?}?>
        </div>

    </div>

    <hr />

    <a target="_blank" class='badge' href="http://www.zkiz.com">Home</a>
    <a target="_blank" class='badge' href="http://realblog.zkiz.com">RealBlog</a>
    <a target="_blank" class='badge' href="http://stock.zkiz.com">Stock</a>
    <a target="_blank" class='badge' href="http://ec.zkiz.com">Endless Choice</a>
    <a target="_blank" class='badge' href="http://fancy.zkiz.com">Fancy Buzz</a>
    <a target="_blank" class='badge' href="http://gloomy.zkiz.com">Gloomy Sunday</a>
    <a target="_blank" class='badge' href="http://wiki.zkiz.com">ZKIZ Wiki</a>
    <a target="_blank" class='badge' href="http://widgets.zkiz.com">RealWidgets</a>
    <br />



    <hr />

    <?//include_once(dirname(__FILE__)."/onlinemembers.php");?>
	<a target="_blank" href="http://smallcounter.com/cc_stats/1503221191/"><img alt="geo stats" border="0" src="http://smallcounter.com/online/ccc.php?id=1503221191"></a>
     
    <hr />
    <div style='font-size:9pt'>
        Powered by <a href='http://wiki.zkiz.com/RealForum'><strong>RealForum</strong></a><br />
        Paged in <?=logEndTime();?>ms (Q=<?=sizeof($queryRecord);?> + R=<?=sizeof($redisRecord);?>) @ <?=date("Y-n-j h:i A e");?><br />
        <a href="/archiver/">Archiver</a> | 廣告聯繫: abbychau (at) gmail.com
    </div>


</div>
</div>
</div>

<? include_once(dirname(__FILE__) . '/normal_floating.php');  ?>
<? if($gId==1){?>
<!--
<script type="text/javascript">

/*
Q:<?=sizeof($queryRecord);?>

<?print_r($queryRecord);?>


R:<?=sizeof($redisRecord);?>

<?print_r($redisRecord);?>
*/
</script>
-->
<?}?>
</body>
</html>	
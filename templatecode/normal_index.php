
<? if(intval($my['prefered_cate'])==0 && $isLog){ ?>
    <div class="alert alert-warning">
        <strong>提示!</strong> 你還沒有選擇偏好的分類呢!(<a href='/select_cate.php'>按我設置</a>)
    </div>
<? } ?>

<!--<div class="panel panel-default" style="overflow:hidden">-->
<!--    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
<!--     rf_responsive_side -->
<!--    <ins class="adsbygoogle"-->
<!--         style="display:block"-->
<!--         data-ad-client="ca-pub-4549800596928715"-->
<!--         data-ad-slot="9406326986"-->
<!--         data-ad-format="auto"></ins>-->
<!--    <script>-->
<!--        (adsbygoogle = window.adsbygoogle || []).push({});-->
<!--    </script>-->
<!--</div>-->





<? if($isLog && $my['prefered_cate'] == 2){?>
<div class='panel'>
    <div class="panel-body">
        <style scoped>
            #attention_list td,#attention_list th{padding:3px;font-size:small}
        </style>
        <? if($attentionInfo){?>
            <table class='table table-default' id="attention_list">
                <thead><th>Tag</th><th>股票資訊</th><th></th><th></th></thead>
                <? foreach($attentionInfo as $v){?>
                    <tr>
                        <td>
                            <a style='font-weight:bold' href='http://realforum.zkiz.com/thread.php?tracing=<?=$v['code'];?>'><?=$v['code'];?></a>
                        </td>
                        <td>
                            <?if(is_numeric($v['code'])){?>
                                <? $tmpInfo = $stockinfo[$v['code']]; ?>
                                <? $changeColor = left($tmpInfo['change'],1)=="+"?"green":"red";?>
                                <?=$tmpInfo['name'];?>
                                $<?=$tmpInfo['price'];?>
                                <span style='display:hidden;color:<?=$changeColor;?>;'>(<?=$tmpInfo['change'];?>)</span>
                            <?}?>
                        </td>
                        <td style="font-size:9pt">
                            <a style="font-size:11px;" class="label label-default" href="http://realforum.zkiz.com/thread.php?tracing=<?=$v['code'];?>"><span class="glyphicon glyphicon-book"></span> RF專帖</a>
                            <a class=""  href='http://realforum.zkiz.com/gSearchResult.php?q=<?=sprintf("%04d",$v['code']);?>'><span class="glyphicon glyphicon-search"></span>搜索</a>


                            <div style="display: inline" class="dropdown">
                                <button class="btn btn-default dropdown-toggle btn-xs" type="button" id="dropdownMenu<?=$v['code'];?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    資訊
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="資訊">
                                    <li><a target="_blank" href="http://stock.zkiz.com/query.php?code=<?=$v['code'];?>">集財網</a>
                                    </li><li><a target="_blank" href='http://investors.morningstar.com/ownership/shareholders-overview.html?t=0<?=sprintf("%04d",$v['code']);?>&region=HKG&culture=en-US'>基金持股</a>
                                    </li><li><a target="_blank" href='https://webb-site.com/dbpub/orgdata.asp?code=<?=$v['code'];?>'>Webb-site</a>
                                    </li><li><a target="_blank" href='https://webb-site.com/ccass/choldings.asp?issue=<?=$issueCode[$v['code']];?>'>Webb-site CCASS</a>
                                    </li><li><a target="_blank" href='https://webb-site.com/dbpub/events.asp?i=<?=$issueCode[$v['code']];?>'>Webb-site Events</a>
                                    </li><li><a target="_blank" href='http://alphainvestments.hk/quote.php?stock_no=<?=$v['code'];?>'>Alpha Investment</a>
                                    </li>
                                </ul>
                            </div>


                        </td>
                        <td>
                            <a href='index.php?action=delete&amp;code=<?=$v['code'];?>'><span class="glyphicon glyphicon-remove"></span></a>
                    </tr>
                <?}?>

            </table>
        <?}else{?>
            <div class="panel pd5">未關注任何Tag, 關注後可追踪股價和收取新聞提示。</div>
        <?}?>
        <form method='post' action='index.php'>
            <div class="input-group input-group-sm">

                <input type='text' name='code' class="form-control" placeholder='請輸入你想留意的股票號碼或留意的tag'/>
                <div class="input-group-btn">
                    <input type='submit' value='加入' class='btn btn-default' />
                </div>

            </div>

        </form>



        <? if(!$isLog){ ?>

            <div class="alert  alert-info">
                登入後才可關注Tag, 追踪股價和收取新聞提示。
            </div>

        <? } ?>
    </div>
</div>
<? } ?>


<? if($isLog){?>
    <div style="font-size:9pt;color:#666;margin-bottom:.5em">
        你現在選擇的分類是<strong><?=$myCateName;?></strong>。
        <a style="font-size:9pt;color:#666" href='/select_cate.php'>選擇其他分類...</a>
        <a style="font-size:9pt;color:#666" href='/forums.php'>瀏覽其他板塊...</a>
    </div>
<?}?>

<? if($getForumsInCate){?>


    <div class='panel'>
        <div class='panel-body'>
            <div class="row">
                <? foreach($getForumsInCate as $v){?>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3" style="padding:5px">
                        <div style='border:1px #eee solid ;border-radius:3px;'>
                            <div class='left pd5'>
                                <?if($v['icon']){?>
                                    <img src='<?=$v['icon'];?>' height="40" width="40" alt="icon" />
                                <?}else{?>
                                <?}?>
                            </div>
                            <div class='left pd5'>
                                <a href="viewforum.php?fid=<?=$v['id'];?>"><?=$v['name'];?></a><br />
                                帖子數: <?=$v['postcount'];?>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
<?}?>
<script>
    function removeFavouriteBoard(ifid) {
        $.get('/ajaxdata.php', {action: "removeFavouriteBoard", fid:ifid},
            function (data) {
                if (data == 'done') {
                    $('#favBoard'+ifid).remove();
                } else {
                    alert(data);
                }
            }
        );
    }
</script>

<div class="panel">
    <div class="panel-body">
            <table class='table table-default'>

                <?php foreach($newTopics as $v){?>

                    <? if(!isset($bannedZid) || sizeof($bannedZid) == 0 || !in_array($v['authorid'],$bannedZid)){ ?>
                        <tr>
                            <td style="font-size:9pt">
                                <? if(isAvatarSet($v["lastusername"])){?>
                                    <img src="<?=getAvatarURL($v["lastusername"],50);?>" alt="avatar" width="48" height="48" style="border-radius:2px" />
                                <?}else{?>
                                    <img src="/images/noavatar.gif" alt="avatar" width="48" height="48" style="border-radius:2px" />
                                <?}?></td>
                            <td>
                                
                                
                                <a style='font-weight:bold' href="thread.php?tid=<?=$v['tid'];?>"><?=$v['title'];?></a><br />
                                <span class='badge'><?=$v['rank'];?></span>
                                <a class="label label-default" style="font-size:9pt;background-color:<?=str2color($v["fid"]);?>" href="viewforum.php?fid=<?=$v['fid'];?>"><?=$v['forumname'];?></a>
                                <span style='font-size:0.8em;color:#CCC'><?=timeago(strtotime($v['lastdatetime']))?></span>
                            </td>
                        </tr>
                    <? } ?>
                <? } ?>

            </table>
    </div>
    <div class="panel-body">

        <?php foreach($getNewTopic as $v){?>
                <?if($previousForumid!=$v['forumid']){?>
                    <a style='font-weight:bold' href="viewforum.php?fid=<?=$v['forumid'];?>"><?=$v['forumname'];?></a>
                    <? $previousForumid=$v['forumid'];?>
                <?}?>
                <?php if($v['isdigest'] == 1 || $v['isshow'] == 2 || $v['views'] > 70 || $v['commentnum'] > 10){ ?>
                    <span class="label label-primary">
							<?php if($v['isdigest'] == 1){ ?>精華<? } ?>
                        <?php if($v['isshow'] == 2){ ?>置頂<? } ?>
                        <?php if($v['views'] > 70 || $v['commentnum'] > 10){ ?>熱門<? } ?></span>
                <? } ?>
                <a style="white-space: nowrap; display: block; margin:0 0 0 1em; overflow: hidden" href="thread.php?tid=<?=$v['id']; ?>" title='由<?=$v['aname']?>在<?=timeago(strtotime($v['datetime'])); ?>於<?=$v['forumname'];?>發表。已被瀏覽<?php echo $v['views']; ?>次。'><?=mb_substr(htmlspecialchars($v['title']),0,50,'utf-8'); ?></a>

        <?php } ?>
    </div>
</div>




<div class='panel panel-default'>
    <div class="panel-body">
    <? if($getForumsInPerfBoard){?>
        己收藏的板塊
        <div class='clear'></div>
        <? foreach($getForumsInPerfBoard as $v){?>
            <div style='width:33%;float:left;padding:0.1em;' id='favBoard<?=$v['id'];?>'>
                <div style='border:1px #eee solid ;border-radius:3px;'>
                    <div class='left pd5'>
                        <img src='<?=$v['icon'];?>' height="40" alt="<?=$v['name'];?> icon" />
                    </div>
                    <div class='left pd5'>
                        <a href="viewforum.php?fid=<?=$v['id'];?>"><?=$v['name'];?></a><br />
                        帖子數: <?=$v['postcount'];?>

                    </div>
                    <div class='right'><a onclick='removeFavouriteBoard(<?=$v['id'];?>)' title='移除'><span class='glyphicon glyphicon-remove'></span></a></div>
                    <div class='clear'></div>
                </div>
            </div>
        <?}?>
    <?}else{?>
        你可以點選版塊下的"收藏本版"來加到版塊到這裡。
    <?}?>

        <div class='clear'></div>
        <hr />
        <div style='padding:0.5em; background:#EEE; margin:0 0 .5em'>
            最新金句:
            <span title='<?=timeago(strtotime($quote['datetime'])); ?>'><?=$quote['quote'];?></span>
            by:<a href="userinfo.php?zid=<?=$quote['zid'];?>&amp;show=quote"><?=$quote['username'];?></a>
            <a href="<?=$quote['from'];?>">來源主題</a>
        </div>


    </div>
</div>



<div class="row">
    <div class='col-xs-12 col-sm-4 col-lg-4'>

        <form action="search.php" method="get" name="hdform2">
            <div class="input-group">
                <input name="kw" type="text" placeholder="輸入名字開新區"  class="form-control" />
                <div class="input-group-btn">

                    <input type="submit" value="確定" class="btn btn-default" />
                </div>
            </div>
        </form>
    </div>
    <div class='col-xs-12 col-sm-8 col-lg-8'>

        <a href="http://realblog.zkiz.com/compose.php" target="_blank" class='btn btn-default'><span class="glyphicon glyphicon-pencil"></span> 發表Blog</a>
        <a href='/plugin/viewforum_linkgen.php' class='btn btn-default'><span class="glyphicon glyphicon-list-alt"></span> 自選版塊連結產生器</a>
        <a class='btn btn-default' href='/trade.php'><span class="glyphicon glyphicon-list-alt"></span> 交易所</a>
        <a class='btn btn-default' href='/attention_input.php'><span class="glyphicon glyphicon-list-alt"></span> ZKIZ 新聞通知系統</a>
    </div>
</div>





<hr style="padding:0;margin:.5em" />







<div class="panel panel-default" style="overflow:hidden">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- rf_responsive_side -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-4549800596928715"
         data-ad-slot="9406326986"
         data-ad-format="auto"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>



<? if($isLog){?>
    <div class="panel">
        <div class="panel-body">
            <h3>通知</h3>
            <?php $vn = dbAr("SELECT * FROM zm_notification WHERE zid = '$gUsername' ORDER BY id DESC LIMIT 20"); ?>

            <?php foreach($vn as $v){?>

                <? if($v['content']){?>
                    <div style='border-bottom:1px solid #EEE; padding:.2em; font-size:10pt'>
                        <a href="<?=urldecode($v['link']);?>"><?=$v['content'];?></a> <small><?=$v['time'];?></small>
                    </div>
                <?}?>

            <? }?>

        </div>
    </div>
<? }?>
<div>
    <div class="adv_space">
        <?=$headAdv['content'] ?>
        <hr />
        <div class='pd5' style='color:#BBB'>此廣告由<a href='/m/<?=$headAdv['username'];?>'><?=$headAdv['username'];?></a>所買。想在這裡下廣告嗎? <a href="/advertisement.php">請按我</a></div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class='glyphicon glyphicon-fire'></span> RB熱門文章
            </h3>
        </div>
        <div class='panel-body'>

            <div class='row'>

                <div class='col-md-8'>
                    <h4><a href="http://realblog.zkiz.com/<?=$rbHotTopic['username'];?>/<?=$rbHotTopic['id'];?>"><?=$rbHotTopic['title'];?></a></h4>
                    <?=mb_substr(strip_tags($rbHotTopic['content']),0,100,'utf-8');?>...
                </div>

                <div class='col-md-4'>
                    <? if(isAvatarSet($rbHotTopic['username'],150)){?>
                        <img src="<?=getAvatarURL($rbHotTopic['username'],150);?>" width='130' style='padding:5px;'  alt="avatar of <?=$rbHotTopic['username'];?> "/><br />
                    <?}?>
                    <a href="http://realblog.zkiz.com/<?=$rbHotTopic['username'];?>"><?=$rbHotTopic['blogname'];?></a>
                </div>
            </div>
        </div>
    </div>

</div>


<hr />


<?php if($birthday){?>
    <h3>
        今日壽星
    </h3>
    <div>
        <?php foreach($birthday as $v){?>
            <a href="/m/<?=$v['username'];?>"><?=$v['username'];?></a>
        <?}?>
    </div>
<?}?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class=' glyphicon glyphicon-tree-deciduous'></span> 集放區</h3>
    </div>
    <div class='panel-body'>
        <div class="row">
            <div class='col-xs-12 col-sm-3 col-lg-3'>
                <a href='http://abby.zkiz.com/apps/zkiz_premium/download.htm'>zkiz windows client</a>
            </div>
            <div class='col-xs-12 col-sm-3 col-lg-3'>
                <a href='/trade.php'>交易所</a>
            </div>
            <div class='col-xs-12 col-sm-3 col-lg-3'>
                <a href='https://chrome.google.com/webstore/detail/fhpdnpodmpbcoldmepgfobhlngdancik?hl=zh-TW&amp;gl=HK'>Chrome Extension</a>
            </div>
            <div class='col-xs-12 col-sm-3 col-lg-3'>
                <a href="http://tv.zkiz.com">tv.zkiz.com</a>
            </div>
        </div>
        <hr />

        <a class="btn btn-default btn-sm" href="http://feeds.feedburner.com/RealForum" rel="alternate" type="application/rss+xml">
            <span class="glyphicon glyphicon-leaf"></span> FeedBurner訂閱
        </a>
        <a class="btn btn-default btn-sm" href="merge.php">
            <span class="glyphicon glyphicon-leaf"></span> 按此合併城市
        </a>
        <a class="btn btn-default btn-sm" href="createworld.php">
            <span class="glyphicon glyphicon-leaf"></span> 按此申請無盡的選擇
        </a>
        <a class="btn btn-default btn-sm" href="select_cate.php">
            <span class="glyphicon glyphicon-leaf"></span> 選擇首頁關注版塊
        </a>
        <a class="btn btn-default btn-sm" href="forums.php">
            <span class="glyphicon glyphicon-leaf"></span> 版塊列表
        </a>

    </div>
</div>

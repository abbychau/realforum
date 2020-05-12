<?if($_GET['order']=='topictime' && $_GET['type']=="all"){?>
    <script>$("#nav_new_topic").addClass("active");</script>
<?}?>
<style>
    #modlist{width:200px;float:left;font-size:0.8em}
    #modDiagContent{width:650px; border:1px #BBB solid; padding:4px; display:none;margin:0 4px 0 4px;font-size:0.8em}
    
    .viewforum_title_container .statbox{padding:8px;float:right}
    .statbox_data{font-size:20px;font-weight:bold}
    .viewforum_main_icon{float:left;padding:0 10px 0 0;width:100px}

    .viewforum_noti{margin-bottom:5px;width:100%}
    .viewforum_noti td{padding:5px;}
    .viewforum_nav{margin-bottom:5px}
    .viewforum_highlight .nav-pills li a{padding:0.2em; font-size:small}
    .viewforum_highlight{max-height:100px;overflow-y:scroll;}
    .viewforum_announcement{font-size:9pt;line-height:auto;border-left:3px #CCC solid; border-radius:0;padding:.5em 1em ;margin:1em 0;}

    .posters{font: 12px/1.5 Tahoma;}
    .topic_stat{font: 12px/1.5 Tahoma;}

    .threadtag_digest{color:#F60; font-weight:bold}
    .threadtag_top{color:#06C; font-weight:bold}
    .threadtag_vote{color:#600; font-weight:bold}
    .threadtag_shortcut{color:#2D2; font-weight:bold}

    .main_table .list_item{padding:.5em 0;border-bottom:1px dashed #DDD}
    .main_table .th_sorting{padding:.5em; background:#EEE;font-size:10pt}


    /**/
    .vf_rightlayout{
        position: fixed;bottom:0; left:0;
    }

    .col_commentnum {
        width: 4em
    }

    .adsboard {
        overflow: hidden;
        width: calc(90%);
    }
    .fixed{
        position:fixed;width: inherit;
    }
    <?=$boardInfo['css'];?>
</style>
<script>
    function addToFavouriteBoard() {
        $.get('/ajaxdata.php', {action: "addToFavouriteBoard", fid:<?=$gfid;?>},
            function (data) {
                if (data == 'done') {
                    alert("已加入");
                } else {
                    alert(data);
                }
            }
        );
    }
</script>

<div id='modDiag' class='hide2' title="版主設定選項">
    <ul id="modlist">
        <li><a onclick="modDialog('ajaxbox/modi_city_highlight.php?typeid=<?= $gfid; ?>','設定主題分類',false,350)">主題分類</a>
        </li>
        <li><a onclick="modDialog('ajaxbox/modi_city_intro.php?typeid=<?= $gfid; ?>','修改公告')">公告及置頂告示</a></li>
        <li><a onclick="modDialog('ajaxbox/modi_city_name.php?typeid=<?= $gfid; ?>','修改本區名稱')">本區名稱</a></li>
        <li><a onclick="modDialog('ajaxbox/modi_city_icon.php?typeid=<?= $gfid; ?>','修改圖示')">修改圖示</a></li>
        <li><a onclick="modDialog('ajaxbox/modi_city_mods.php?typeid=<?= $gfid; ?>','修改版副')">修改版副</a></li>
        <li><a onclick="modDialog('ajaxbox/modi_city_isguest.php?typeid=<?= $gfid; ?>','發貼和瀏覽權限')">發貼和瀏覽權限</a></li>
        <li><a onclick="modDialog('ajaxbox/modi_city_css.php?fid=<?= $gfid; ?>','修改CSS')">修改CSS</a></li>
        <li><a onclick="modDialog('ajaxbox/modi_city_cate.php?typeid=<?= $gfid; ?>','分類')">分類</a></li>
        <li><a onclick="modDialog('ajaxbox/modi_city.php?fid=<?= $gfid; ?>','退位')">退位</a></li>
    </ul>
    <div class='left' id='modDiagContent'></div>
    <div class='clear'></div>
</div>

<? if ($boardInfo['top_notice']) { ?>
    <div class="alert alert-warning alert-dismissable">
        <strong>本版告示:</strong> <?= $boardInfo['top_notice']; ?>
    </div>
<?}else{?>

<?}?>


<?php if(!$gNoAds && false){?>
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
<?}?>



<div class='clear'></div>

<div class='row'>
    <div class='col-sm-12 col-md-12 col-lg-12'>

        <div class="panel">
            <div class="panel-body">
                <h1 style='margin-top:3px'><?php if ($boardInfo['icon'] != "") { ?><img src="<?= $boardInfo['icon']; ?>" width="100" alt="icon" class='viewforum_main_icon'/><?php } ?><?= $htmltitle; ?> <small><?= $totalRows_getConList; ?>主題 <?= $citysize; ?>帖子</small></h1>
                <a onclick='addToFavouriteBoard()' class='btn btn-default'><span class='glyphicon glyphicon-heart'></span> 收藏本板</a>

                <div class="fb-like" data-href="http://realforum.zkiz.com/viewforum.php?fid=<?=$gfid;?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>

                <a class='btn btn-default btn-xs' href='/rss.php?fid=<?= $gfid; ?>'><span class="glyphicon glyphicon-bookmark"></span> 按此訂閱RSS</a>



                <div class="clear" >
                    <? if ($gfid) { ?>
                        <div class="viewforum_announcement">
                            <? if (trim($boardInfo['intro']) != "") { ?>
                                <h4><span class=' glyphicon glyphicon-bell'></span> 版主公告</h4>
                                <?= $bbcode->Parse($boardInfo['intro']); ?>
                            <? } ?>
                            <div style='font-size:small;border-top:1px solid #ddd; padding:.5em 0 0 0; margin:.5em 0 0 0'>

                                <strong>版主:<strong> <a
                                            href='userinfo.php?zid=<?=$main_mod['ownerid']; ?>'><?= $main_mod['username']; ?></a>
                                        <? if ($sub_mod) { ?>
                                            <strong>副版主:</strong> <? foreach ($sub_mod as $v) { ?><a
                                                href='userinfo.php?zid=<?= $v['ownerid']; ?>'><?= $v['username']; ?></a> <? } ?>
                                        <? } ?>
										                            <? if ($isadmin > 0 || $my['usertype'] >= 8) { ?>
                                <? if ($gtype != 'all' && $gtype != 'selected') { ?>
                                    <a onclick="$('#modDiag').dialog({width:1000,height:600,modal:true})"
                                       class='btn btn-default btn-xs'><span class=' glyphicon glyphicon-wrench'></span> 版主設定選項</a>
                                <? } ?>
                            <?}?>
                            </div>

                        </div>
                    <? } ?>



                    <? if ($gfid) { ?>

                        <form method="get" action="/gSearchResult.php" id="fidforum"
                              onsubmit="$('#realq').val($('#fidq').val() + ' <?= $htmltitle ?> RealForum');">
                            <div class="input-group">
                                <input type="text" class="form-control" value='<?=$q;?>' placeholder="搜尋本版" id="fidq"/>
                                <input type="hidden" name="q" id="realq"/>
								<span class="input-group-btn">
									
									<button class="btn btn-default" onclick="$('#fidforum').submit();" type="button">
										搜尋!
									</button>
								</span>
                            </div>
                            <!-- /input-group -->
                        </form>
                    <? } ?>

                    <? if (false && ($gtype == 'all' || $gtype == 'selected')) { ?>
                        <form method="get" action="/gSearchResult.php">
                            <div class="input-group">
                                <input type="text" class="form-control" value='<?=$q;?>' placeholder="搜尋所有版塊" id="fidq"/>
                                <input type="hidden" name="q" id="realq"/>
								<span class="input-group-btn">
									<button class="btn btn-default" onclick="$('#fidforum').submit();" type="button">
										搜尋!
									</button>
								</span>
                            </div>
                            <!-- /input-group -->
                        </form>
                    <? } ?>

                </div>
            </div>
        </div>
        <div class='row' style='margin-top:0.3em;margin-bottom:0.3em'>
            <div class="col-md-9" >
                <?php pagin($page, $currentPage, $queryString_getConList, $totalPages_getConList); ?>
            </div>
            <div class='col-md-3 margin0 pull-right'>
                <div class='right'>
                    <?php if (($noguest != true || $isLog == true) && !$is_banned) { ?>
                        <a href="post.php?type=post&amp;fid=<?= $gfid; ?>"
                           class='btn btn-primary'><span class="glyphicon glyphicon-pencil"></span> 發表主題</a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class='clear'></div>


        <?php if ($totalRows_getConList > 0) { ?>
            

                    <? if($gtype!="all"){ ?>
                        <div class='viewforum_highlight'>
                            <ul class="nav nav-pills">
                                <li <? if ($_GET['q'] == ""){ ?>class="active"<? } ?>><a href="viewforum.php?fid=<?= $gfid; ?>">全部</a></li>

                                <? if ( isset($highlights) && is_array($highlights) && sizeof($highlights) > 1) { ?>
                                    <? foreach ($highlights as $highlight) { ?>
                                        <li <? if ($_GET['q'] == "[{$highlight}]"){ ?> class="active"<? } ?>><a href="viewforum.php?fid=<?= $gfid; ?>&amp;q=[<?= $highlight; ?>]"><?= $highlight; ?></a></li>
                                    <? } ?>
                                <? } ?>
                            </ul>
                        </div>
                        <hr />

                    <?}?>

                    <div class="main_table">
                        <? if ($_GET['batchdelete'] == '1') { ?>
                        <form action='viewforum.php?fid=<?= $gfid; ?>&batchdelete=1&type=<?= $gtype; ?>' method='post' id='delform'>
                            <? } ?>
                            <div class='th_sorting'>
                                排序:
                                <a href="viewforum.php?fid=<?= $gfid; ?>&amp;order=commentnum">回覆數<?= $gorder == "commentnum" ? " ▼" : ""; ?></a>

                                <a href="viewforum.php?fid=<?= $gfid; ?>&amp;order=views">人氣數<?= $gorder == "views" ? " ▼" : ""; ?></a>

                                <a href="viewforum.php?fid=<?= $gfid; ?>&amp;order=gp">GP數 <?= $gorder == "gp" ? "▼" : ""; ?></a>
                                <a href="viewforum.php?fid=<?= $gfid; ?>&amp;order=topictime">主題發表時間 <?= $gorder == "topictime" ? "▼" : ""; ?></a>
                                <a href="viewforum.php?fid=<?= $gfid; ?>">最後回覆時間 <?= $gorder == "" ? "▼" : ""; ?></a>
                                <br />
                                篩選:
                                <a href="viewforum.php?fid=<?= $gfid; ?><?=$gorder?"&amp;order=$gorder":"";?><?= $gIsAtlease1 ?"":"&amp;atleast1";?><?=$gIsMyPosts?"&amp;myPosts":"";?>">大於1回覆 <?= $gIsAtlease1 ? "&#10004;" : ""; ?></a>
                                <? if($isLog){?>
                                    <a href="viewforum.php?fid=<?= $gfid; ?><?=$gorder?"&amp;order=$gorder":"";?><?= $gIsAtlease1?"&amp;atleast1":"";?><?=$gIsMyPosts?"":"&amp;myPosts";?>">自己的主題 <?= $gIsMyPosts ? "&#10004;" : ""; ?></a>
                                <?}?>

                                <? if ($isadmin > 0 || $my['usertype'] >= 8) { ?>
                                    <? if ($_GET['batchdelete'] == '1') { ?>
                                        <a href="viewforum.php?fid=<?= $gfid; ?>&type=<?= $gtype; ?>" class='btn btn-default btn-xs'><span class='glyphicon glyphicon-remove'></span> 關閉批量刪貼</a>
                                        <script>
                                            $(document).ready(function() {
                                                $('#selectall').click(function(event) {
                                                    $('.delbox').each(function() { //loop through each checkbox
                                                        this.checked = true;  //select all checkboxes with class "checkbox1"
                                                    });
                                                });

                                            });
                                        </script>
                                        <a id='selectall' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-remove'></span> 全選這頁</a>
                                    <? } else { ?>
                                        <a href="viewforum.php?fid=<?= $gfid; ?>&amp;batchdelete=1&type=<?= $gtype; ?>"
                                           class='btn btn-default btn-xs'><span class='glyphicon glyphicon-remove'></span> 開啟批量刪貼</a>
                                    <? } ?>
                                <? } ?>


                            </div>
                            <?php foreach ($getConList as $v) { ?>
                                <? if (
                                        (!isset($bannedZid) || sizeof($bannedZid) == 0) || 
                                        (isset($bannedZid) && !in_array($v['authorid'], $bannedZid))
                                        ) { ?>
                                    <?php
                                    if ($v['special'] < 0) {
                                        $totid = abs($v['special']);
                                    } else {
                                        $totid = $v['id'];
                                    }
                                    $totids[] = $totid;
                                    if ($v['lastid'] != $gId) {
                                        $totidsnm[] = $totid;
                                    }
                                    $commentnum = $v['commentnum'] - 1;?>


                                    <? if ($v['isshow'] != 2 && ++$iss == 1) { ?>
                                        <div class="list_item">
                                            以上是頂置主題
                                        </div>
                                    <? } ?>
                                    <? if ($iss == 20) { ?>
                                        <div class="list_item">
                                            <? if (!$gNoAds) { ?>
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
                                            <? } ?>
                                        </div>
                                    <? } ?>
                                    <div class="list_item">

                                        <?php if ($v['is_closed'] == 1) { ?><strong>[已關閉]</strong><? } ?>
                                        <?php $titles = preg_split('/(\[[^\]]*\])/i', htmlspecialchars($v['title']), -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); ?>
                                        <? foreach ($titles as $title) { ?>
                                            <? if (right($title, 1) == "]" && left($title, 1) == "[") { ?>
                                                <a href="viewforum.php?fid=<?= $gfid; ?>&amp;q=<?= $title; ?>" class='left titletag'><?= $title; ?></a>
                                            <? } else { ?>
                                                <a class='threadlink' href="thread.php?tid=<?= $totid; ?>"
                                                   <? if ($_COOKIE['blank_viewforum'] == true){ ?>target='_blank'<? } ?>  ><?= $title; ?></a>
                                            <? } ?>
                                        <? } ?>
                                        <?php if ($v['isdigest'] == 1) { ?><span class='threadtag_digest'>[精華]</span><?php } ?>
                                        <?php if ($v['isshow'] == 2) { ?><span class='threadtag_top'>[置頂]</span><?php } ?>
                                        <?php if ($v['special'] == 1) { ?><span class='threadtag_vote'>[投票]</span><?php } ?>
                                        <?php if ($v['special'] < 0) { ?><span class='threadtag_shortcut'>[捷徑]</span><?php } ?>
                                        <?php if ($commentnum > $reply_perpage) { ?>
                                            <span class="threadpage">
												<?php
                                                $nop = floor($commentnum / $reply_perpage);

                                                for ($i = $j = 0; $i <= $nop; $i++) {
                                                    if ($i < 8 || $i + 2 > $nop) {
                                                        echo "&nbsp;<a href=\"thread.php?page=" . $i . "&amp;tid=" . $v['id'] . "\">" . ($i + 1) . "</a>";
                                                    } else {
                                                        if ($j++ < 1) {
                                                            echo " ..";
                                                        }
                                                    }
                                                }
                                                ?>
											</span>
                                        <?php } ?>
                                        <?php if ($v['tpraise'] > 0) {
                                            echo "<strong>GP x " . $v['tpraise'] . "</strong>";
                                        } ?>


                                        <?if($v['subtitle']){?>
                                            <br />
                                            <small>
                                                <?=$v['subtitle'];?>
                                            </small>
                                        <?}?>

                                        <div class="clear"></div>
                                        <div class='topic_stat left'>
                                            <? if ($_GET['batchdelete'] == '1') { ?>
                                                <input type='checkbox' class='delbox' name='deletearr[]' value='<?= $v['id']; ?>'/>
                                            <? } else { ?>

                                                <?php if ($v['is_closed'] == 1) { ?>
                                                    <span class='glyphicon glyphicon-eye-close'></span>
                                                <? } else { ?>
                                                    <? if ($commentnum > 20) { ?>

                                                        <span class='glyphicon glyphicon-flash'></span>
                                                    <? } else { ?>
                                                        <span class='glyphicon glyphicon-file'></span>
                                                    <? } ?>
                                                <? } ?>

                                            <? } ?>
                                            回覆: <span style="color:red;font-size:10pt"><?= $commentnum + 1; ?></span>
                                            瀏覽: <span style="font-size:10pt"><?php echo $v['views']; ?></span>
                                        </div>


                                        <div class='posters right hidden-xs'>

                                            <?php if ($commentnum >= 0) { ?>
                                                <a class='right' href="userinfo.php?zid=<?= $v['lastid']; ?>"><span
                                                        class='glyphicon glyphicon-arrow-up'></span> <?= $v['rname']; ?> <?= timeago(strtotime($v['lastdatetime'])); ?>
                                                </a>
                                            <?php } ?>


                                            <?php if ($v['special'] >= 0) { ?>

                                                <? if ($gtype == 'all' || $gtype == 'selected') { ?>
                                                    <a class=' left' href='/viewforum.php?fid=<?= $v['forumid']; ?>'><?= $v['forumname']; ?></a>
                                                <? } ?>
                                                <a class=' right' href="userinfo.php?zid=<?= $v['authorid']; ?>">
                                                    <span class='glyphicon glyphicon-pencil'></span> <?= $v['aname']; ?> <?= timeago(strtotime($v['create_timestamp'])); ?>
                                                </a>


                                            <?php } else { ?>
                                                <a href="userinfo.php?zid=<?php echo $v['authorid']; ?>"><?php echo $v['aname']; ?></a> : <?= timeago(strtotime($v['lastdatetime'])); ?>
                                            <?php } ?>



                                            <?php if ($isLog && $isadmin > 0) { ?>
                                                <a onclick="dialog('ajaxbox/delthread.php?tid=<?= $v['id']; ?>&amp;fid=<?= $gfid; ?>','管理',false,600);"
                                                   class='right'><span class='glyphicon glyphicon-wrench'></span></a>
                                            <?php } ?>


                                        </div>

                                        <div class='clear'></div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <? if ($_GET['batchdelete'] == '1') { ?>
                                <div class='list_item'>
                                    <input type='hidden' name='batchdelete' value='true'/>
                                    <a class='deletebtn' onclick="if(confirm('你確定嗎?')){$('#delform').submit();}">刪除</a>
                                </div>
                            <? } ?>


                            <? if ($_GET['batchdelete'] == '1') { ?>
                        </form>
                    <? } ?>

                    </div>
                
        <?php } else { ?>
            <div class='well'>
                沒有貼子，趕快發一個吧!
            </div>
        <?php } ?>


        <div class='row' style='margin-top:0.3em;margin-bottom:0.3em'>
            <div class="col-md-9" >
                <?php pagin($page, $currentPage, $queryString_getConList, $totalPages_getConList); ?>
            </div>
            <div class='col-md-3 margin0 pull-right'>
                <div class='right'>
                    <?php if (($noguest != true || $isLog == true) && !$is_banned) { ?>
                        <a href="post.php?type=post&amp;fid=<?= $gfid; ?>"
                           class='btn btn-primary'><span class="glyphicon glyphicon-pencil"></span> 發表主題</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div>
            <?php if ($is_banned) { ?>
                你已被此版版主加到黑名單中, 暫時不能發貼, 如有疑問, 請聯絡此版版主。
            <?php } ?>
            <?php if ($noguest && !$isLog) { ?>
                此版不容許訪客發貼, 請先登入。
            <? } ?>
        </div>

    </div>


</div>
<div id='quickpost_container'>
    <?php if (!$noguest || $isLog) { ?>
        <?php if (!$is_banned) { ?>
            <?php if ($boardInfo['name'] != "") {?>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        <? include_once("templatecode/quickpost.php");?>
                    </div></div>
            <?} ?>
        <? } else { ?>

        <? } ?>
    <?php } else { ?>
        本版塊必需先登入才可以發表主題!
    <?php } ?>
</div>
<hr/>
<!--
<small><a onclick="openall()">開啟所有</a> | <a onclick="openallbutnotme()">開啟所有新回覆</a></small>
-->

    <div class='hidden-sm hidden-xs hidden-md col-lg-12'>
        <div class='scroll_container'>
            <div class=''>
                <?if($getForumsInCate){?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">同區版塊</h4>
                        </div>


                        <ul class="nav nav-pills nav-stacked">
                            <? foreach($getForumsInCate as $v){?>
                                <li style="padding:0;font-size:9pt;<?=$v["id"]==$gfid?"background:#EEE":"font-weight:normal";?>"><a href="viewforum.php?fid=<?=$v['id'];?>"><?=$v['name'];?></a></li>
                            <?}?>

                        </ul>
                    </div>
                <?}?>

            </div>




            <? if($my['score1']>=500 && $gfid == 128){?>
                <div class="panel panel-body">
                    (此區域為金錢500以上會員專用)
                    <form method='post' action='post.php'>
                        <input type="text" placeholder='No.' name="tracing" />
                        <br />
                        <input type="text" placeholder='PicURL' name="picurl" />
                        <br />
                        <input type='hidden' name='posttype' value='reply' />
                        <input type='hidden' name='price' value='0' />
                        <input type='hidden' name='also_subscribe' value='1' />
                        <input type="text" placeholder='Comments' name="content" style='width:100%;height:40px' />
                        <input type='submit' value="發到號碼貼" />
                    </form>
                </div>
            <?}?>



            <? if (!$gNoAds) { ?>
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

            <? } ?>
            <div class='adv_space'>
                <?= $sbAdv['content'] ?>
                <hr style="padding:0;margin:.5em"/>
                <div class='pd5' style='color:#BBB;font-size:9pt'>此廣告由<a href='/m/<?= $sbAdv['username']; ?>'><?= $sbAdv['username']; ?></a>所買。想在這裡下廣告嗎?
                    <a href="/advertisement.php">請按我</a></div>
            </div>

        </div>
    </div>
<script type='text/javascript'>
    /* <![CDATA[ */
    /*
     $(window).scroll(function(){

     $(".vf_rightlayout").css("top",

     Math.min(
     Math.max(
     70,
     $(".vf_leftlayout").position().top - $(this).scrollTop()
     ),
     $("#qpmainform").offset().top - $(window).scrollTop() - $(".vf_rightlayout").height()
     )
     );
     });
     */
    function modDialog(url, title) {

        $('#modDiagContent').load(url).show();
        $('#modDiag').dialog("option", 'title', title);

    }
    <?php if(sizeof($totids)>0){?>
    function openall() {
        if (confirm("This will open all the threads in the list, are you sure?")) {
            var myarr = new Array(<?=implode(",",$totids);?>);
            for (var key in myarr) {
                window.open('thread.php?tid=' + myarr[key]);
            }
        }

    }
    <?}?>
    <?php if(sizeof($totidsnm)>0){?>
    function openallbutnotme() {
        if (confirm("This will open all the threads that the last reply is not you in the list, are you sure?")) {
            var myarr2 = new Array(<?=implode(",",$totidsnm);?>);
            for (var key in myarr2) {
                window.open('thread.php?tid=' + myarr2[key]);
            }
        }
    }
    <?}?>


    var maxpage = <?=$totalPages_getConList;?>;
    var currentpage = <?=$page;?>;

    $(document).ready(
        function () {

            $("#navbar_newpost_button").attr('href', "/post.php?type=post&fid=<?=$gfid;?>");

            $("#modlist").menu({
                select: function (event, ui) {
                    var link = ui.item.children("a:first");
                    if (link.attr("target") || event.metaKey || event.shiftKey || event.ctrlKey) {
                        return;
                    }
                }
            });
        }
    );

    $(document).keydown(

        function (e) {
            if (e == null) {
                key = event.keyCode;
                tagname = e.srcElement.tagName;
            } else { // mozilla
                key = e.which;
                tagname = e.target.tagName;
            }
            if (tagname == 'INPUT' || tagname == 'TEXTAREA') return;

            if (key == 39 && currentpage != maxpage) {
                window.location = 'viewforum.php?fid=<?=$gfid?>&page=<?=($page+1)?>';
            }
            if (key == 37 && currentpage != 0) {
                window.location = 'viewforum.php?fid=<?=$gfid?>&page=<?=($page-1)?>';
            }
            if (key == 74) {
                window.location = 'index.php';
            }
        }

    );
    /* ]]> */
</script>
<script src="/js/tc_sc_conv.js"></script>
<script src="/js/bootstrap-confirmation.js"></script>
<style scoped>
    .tag-search{margin-right:3px;margin-left:0}
    .thread_floor_container{}
    .thread_floor_content_td{
    }
    .reply_commnet{border-top:1px #ccc solid; padding:2px 5px; font-size:12px}
    .reply_content{
    <? if(isset($_COOKIE['reply_fontsize']) && $_COOKIE['reply_fontsize'] != 0){?>
        font-size:<?=$_COOKIE['reply_fontsize'];?>px;
    <?}else{?>
        font-size:16px;
    <?}?>
	word-break:break-all;
    }
    .reply_container{word-break: break-all;}
    .medals{clear:both}
    .well{overflow:hidden}
    .titleAndName{float:left;margin-right:0.3em}
    #dummy_reply{}

    #goldShare{position:absolute;z-index:10;}
    .rank1,.rank2,.rank3{padding:2px;border:1px #CCC solid;margin:2px}
    .rank3{background:#FFCCCC}
    .rank2{background:#CCFFCC;}
    .rank1{background:#CCCCFF;}

    .contentmodinfo{font-size:small}
    .avatar,.replyAvatar{width:50px;}
    .thread_floor_author{margin-bottom:1em;padding:0.5em;font-size:9pt}

    .breadcrumb{border-bottom: 3px solid #AAA;border-radius: 0;}
    #thread_title_box{margin-bottom:1em}
    .reply_comment_container{background:#EEE;border-top:2px #CCC solid; padding:0.5em 1em;margin-top:0.5em}
    .reply_comment{margin-bottom:2px}
    .page-header .badge{padding:4px}

    .shareaholic-share-buttons-container.wrapped ul.shareaholic-share-buttons{margin:0 !important}
    <?=$boardInfo['css'];?>
</style>

<? if($boardInfo['top_notice']){?>
    <div class="alert alert-warning alert-dismissable">
        <strong>本版告示:</strong> <?=$boardInfo['top_notice'];?>
    </div>
<?}?>


<button id='goldShare' class='btn btn-info hide2'>摘錄!</button>
<div class="fb-quote"></div>

<div style="padding: 5px 3px; bottom: 5px; right: 47px; cursor: pointer; display: block;z-index:90; opacity:.85" onclick="$('html, body').animate({scrollTop:0}, 'fast');" class="rf_fixed">

    <?php if($gPage!=0){?>
        <a href="thread.php?tid=<?=$gTid;?>" style="display:block; padding:.6em .9em; background:#AAA;border-radius:1em;color:white">
            <span class="glyphicon glyphicon-step-backward"></span>
        </a>
    <?}?>
    <?php if($gPage!=$totalPages_getReply){?>
        <a href="thread.php?tid=<?=$gTid;?>&amp;lastpage=1" style="display:block; padding:.6em .9em; background:#AAA;border-radius:1em;color:white">
            <span class="glyphicon glyphicon-step-forward"></span>
        </a>
    <?}?>
</div>



<script type="text/javascript">
    /* <![CDATA[ */

    jQuery.fn.highlightShare = function (dom, callback) {

        var shareDom = dom;

        var funGetSelectTxt = function () {
            var txt = "";
            if (document.selection) {
                txt = document.selection.createRange().text;    // IE
            } else {
                txt = document.getSelection();
            }
            return txt.toString();
        };

        shareDom.click(
            function () {
                var txt = funGetSelectTxt();
                if (txt) {
                    callback(txt);
                }
            }
        );

        this.each(
            function () {
                $(this).mouseup(
                    function (e) {
                        if (e.which == 1) {
                            e = e || window.event;
                            var txt = funGetSelectTxt(), sh = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
                            var left = (e.clientX - 40 < 0) ? e.clientX + 20 : e.clientX - 40, top = (e.clientY - 40 < 0) ? e.clientY + sh + 20 : e.clientY + sh - 40;
                            if (txt.length >= 5) {
                                shareDom.show();
                                shareDom.css("left", left + "px");
                                shareDom.css("top", top + "px");
                            } else {
                                shareDom.hide();
                            }
                        }
                    }
                );
            }
        );
    };
    <?php if($isLog && $_COOKIE['disable_goldshare']!=1){?>
    $(document).ready(
        function(){

            $("#navbar_newpost_button").attr('href', "/post.php?type=post&fid=<?=$row_getThread['type'];?>");

            $(".reply_content").highlightShare(
                $("#goldShare"),
                function(e){

                    var answer = confirm("確定要摘錄'" + e + "'嗎?");
                    if (answer){


                        $.get(
                            "/ajaxdata.php",
                            {type:"quote",quote:e,tid:<?=$gTid?>},
                            function(data){
                                if(data==1){
                                    alert("成功發表!");
                                }else{
                                    alert(data);
                                }
                            }
                        );
                    }
                }
            );
        }
    );
    <?php }?>

    function jump(to){
        location.href='thread.php?tid=<?=$gTid?>&page=' + (Math.ceil(to / <?=$maxRows_getReply;?>)-1) + "#" + to;
    }
    function addtag(str){
        if(str!=''){
            $('#tagInput').val('插入中...');
            $('#tagInput').attr('disabled','disabled');
            $.get(
                'ajaxdata.php',
                {type:'tags',tag:str,tid:<?=$gTid?>},
                function(){
                    $('#tagOutput').append('<a href="http://zkiz.com/tag.php?tag='+str+'">'+str+'</a>');
                    $('#tagInput').val('');
                    $('#tagInput').removeAttr('disabled');
                }
            );
        }else{
            alert('Tag 不可為空');
        }
        //location.href='thread.php?tid=<?=$gTid?>&addtag=' + str;
    }
    function deltag(str){
        if(str!=''){
            $('#tagInput').val('插入中...');
            $('#tagInput').attr('disabled','disabled');
            $.get(
                'ajaxdata.php',
                {type:'deltag',tag:str,tid:<?=$gTid?>},
                function(){
                    location.reload();
                }
            );
        }else{
            alert('Tag 不可為空');
        }
        //location.href='thread.php?tid=<?=$gTid?>&addtag=' + str;
    }
    function showurl(id){
        url = "<?=curURL();?>#" + id;

        txt = '<embed width="62" height="24" align="middle" flashvars="txt='+url+'" src="/images/Copy.swf" quality="high" wmode="transparent" allowscriptaccess="sameDomain" pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash">';

        return "<fieldset><legend>此回帖的路徑</legend>" + url + txt + "</fieldset>";
    }

    function loadinto(iid,floor,ipid,by){
        //$('body').scrollTo( $('#adsb4post'), 800 );
        domToModal($('#quickpost'),'回覆');
        if(iid>0){
            $('#qpinfo').html("引用內容載入中...");
            $('#qpmainform').hide();
            $.get("ajaxdata.php", {type : "replycontent", id: iid},function(data){
                    $('#content').val("[quote floor=" + floor + " by='"+by+"']"+data+"[/quote]\n\n");
                    $('#qpinfo').html("");
                    $('#qpmainform').show();
                    $('#reply_pid').val(ipid);
                }
            );
        }
    }

    function block_user(id){
        if(confirm("確定要封鎖這個會員嗎? 封鎖後這個會員的回覆將會被自動隱藏")){
            $.post("/ajaxbox/actionToUser.php",{zid:id,action:'blockUser'},function(data){
                if(data=="1"){
                    document.location.reload(true);
                }

            });
        }
    }
    function unblock_user(id){
        if(confirm("確定要解除封鎖這個會員嗎?")){
            $.post("/ajaxbox/actionToUser.php",{zid:id,action:'unblockUser'},function(data){
                if(data=="1"){
                    document.location.reload(true);
                }

            });
        }
    }
    function toggleReceiveNotice(id){
        if(confirm("切換本主題的通知接收嗎?")){
            $.post("/ajaxbox/actionToUser.php",{tid:id,action:'toggleNotification'},function(data){
                if(data=="1"){
                    alert("本主題的通知接收現在為開啟。");
                }else if(data=="2"){
                    alert("本主題的通知接收現在為關閉。");
                }else{
                    alert(data);
                }
            });
        }
    }
    function turnOnNotification(id){
        $.post("/ajaxbox/actionToUser.php",{tid:id,action:'turnOnNotification'},function(data){
            if(data=="1"){
                alert("本主題的通知接收現在為開啟。");
            }else{
                alert(data);
            }
        });
    }
    function turnOffNotification(id){
        $.post("/ajaxbox/actionToUser.php",{tid:id,action:'turnOffNotification'},function(data){
            if(data=="1"){
                alert("本主題的通知接收現在為關閉。");
            }else{
                alert(data);
            }
        });
    }
    /* ]]> */
</script>

<div id='modiwindow'></div>

<?php if($donated == true){ ?>
    <div class="ui-state-highlight ui-corner-all" style="margin: 5px 0; padding: 0 .7em 0;">
        <p style="margin:5px"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong>謝謝!</strong> 你的捐款令我們做得更好!</p>
    </div>
<?}?>


<ol class="breadcrumb">
    <li><a href="/"><span class='glyphicon glyphicon-home'></span> 主頁</a></li>
    <li><a href="<?="viewforum.php?fid={$row_getThread['type']}";?>"><?=$boardInfo['name'];?></a></li>
    <li class="active"><?=mb_substr($title,0,40,"utf-8").(mb_strlen($title,"utf-8")>40?"...":"");?></li>
</ol>


<?if($stock_code){?>
<div class='panel'>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <? $stockInfo=getStockInfo($stock_code);
					 if($stockInfo){
					 foreach($stockInfo as $k=>$v){echo properCase($k).": $v<br />";}
						 }

					?>
                <div style='font-size:1em;;padding-left:0.5em;display:none'>
                    <span style="font-size:36px">$<?=$stockInfo['price'];?></span><br />
                    今日最高: $<?=$stockInfo['high'];?> / 最低: $<?=$stockInfo['low'];?><br />
                    賬面價值: $<?=$stockInfo['bookvalue'];?> /	市值: $<?=$stockInfo['marketcap'];?><br />
                    成交量: <?=$stockInfo['volume'];?><br />
                    52週範圍: $<?=$stockInfo['52low'];?>-<?=$stockInfo['52high'];?><br />
                    50天平均: <?=$stockInfo['fifma'];?><br />
                    市盈率: <?=$stockInfo['per'];?> / 息率: <?=$stockInfo['dividend'];?><br />
                    <small style="font-size:9pt"><?=$stockInfo['date']." ".$stockInfo['time'];?></small>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
<!--http://charts.aastocks.com/servlet/Charts?fontsize=12&15MinDelay=T&lang=1&titlestyle=2&Indicator=1&indpara1=10&indpara2=20&indpara3=50&indpara4=0&indpara5=0&scheme=1&com=100&chartwidth=500&chartheight=300&stockid=05&period=2&type=1&subChart1=14&ref1para1=0&ref1para2=0&ref1para3=0-->
                <img src="http://charts.aastocks.com/servlet/Charts?fontsize=12&15MinDelay=T&lang=1&titlestyle=2&Indicator=1&indpara1=10&indpara2=20&indpara3=50&indpara4=0&indpara5=0&scheme=1&com=100&chartwidth=400&chartheight=300&stockid=<?=symbolize($stock_code);?>&period=2&type=1&subChart1=14&ref1para1=0&ref1para2=0&ref1para3=0"
                     style="width:100%;max-width:300px" alt="trend chart" />
            </div>
        </div>

        <? if($getNewNews){?>
            <hr />
            <? foreach ($getNewNews as $v){?>
                <?=timeago(strtotime($v['timestamp']));?> :	<a href='http://www.zkiz.com/news.php?id=<?=$v['publicpost_id'];?>'><?=$v['title'];?></a><br />
            <?}?>
            <a href='http://stock.zkiz.com/query.php?code=<?=$stock_code;?>' class='right btn btn-default'>顯示所有</a>
            <div class='clear'></div>

        <?}?>



    </div>
</div>
<?}?>
<div class='row' style='margin-top:0.3em;margin-bottom:0.3em'>

    <div class='col-md-4 margin0'>
        <?php if($able_to_reply){?>
            <a onclick='loadinto()' class='btn btn-primary'><span class='glyphicon glyphicon-comment'></span> 回覆</a>
        <?php } ?>
    </div>

    <div class="col-md-8  pull-right" >

        <div class='right thread_main_content_pagin'>
            <?php pagin($gPage, $currentPagePure, $queryString_getReply, $totalPages_getReply);?>
        </div>
        <div class='right'>

            <a href='/viewforum.php?fid=<?=$row_getThread['type'];?>' class='btn btn-default'><span class='glyphicon glyphicon-menu-left'></span> 返回列表</a>

        </div>
        <div class="clear"></div>

    </div>

</div>

<div class='thread_main_content'>


    <?php
    $initNum = $startRow_getReply;
    ?>
    <?php if($row_getThread['special'] == 1){ ?>
        <fieldset style="margin:10px; padding:15px;"><legend>本主題附有投票欄(放在投票人數上面可以看到名單)</legend>
            <form id="poll" name="poll" method="post" action="/ajaxbox/newpoll.php?tid=<?=$gTid;?>">


                <div style="float:left; font-weight:bold; padding-right:20px; line-height:20px;">
                    <?php
                    foreach($items as $val){
                        $i++;
                        if ($pollInfo['option'] == 0){?>
                            <input name="option" type="radio" value="<?=$i;?>" />
                        <? }else{ ?>
                            <input name="option[]" type="checkbox" value="<?=$i;?>" />
                        <? } ?>
                        <?=$val;?>
                        <br />
                    <? } ?>
                </div>

                <div class="left">
                    <?php

                    foreach($users as $line){$maxsize = max(sizeof($line), $maxsize);}
                    foreach($users as $line){
                        $strow = "";
                        if(sizeof($line)>1){
                            foreach($line as $val){$strow .= $strow==""?$val:", ".$val;}
                        }

                        $ratio = round(((sizeof($line)-1) / $maxsize) * 600 ) . "px";
                        echo "<div style='width:$ratio; height:20px; float:left' class='ui-widget-header clear'></div>
							<div style='padding:1px' class='left' title='$strow'>(共".(sizeof($line)-1)."人)</div>";

                    }
                    ?>
                </div>
                <div class='clear'></div>
                <input type="hidden" name="MM_insert" value="poll" />
                <input type="hidden" name="tid" value="<?=$gTid;?>" />
                <input name="" type="submit" value="投票" />
            </form>
        </fieldset>
    <?php } ?>

    <?php
    foreach($getReply as $row_getReply) {
        ++$initNum;

        if($_GET['authoronly']=="" || $_GET['authoronly']==$row_getReply['authorid']){?>
<?php
if($row_getReply['authorid'] == 14||$row_getReply['authorid'] == 830){?>
  <div class="panel panel-default">
                <div class="panel-heading" style="font-size:9pt;">
                    This author is being removed.
                    </div></div>

<?    continue;
}
?>
            <a id="<?=$initNum; ?>"></a>
            <div class="panel panel-default">
                <div class="panel-heading" style="font-size:9pt;">



                    <?if($row_getReply['authorid']>0){?>

                        <?php if($row_getReply['authorid']==733){?>
                            訪客<br/>
                            Guest (IP: <?=$row_getReply['ip']; ?>)
                        <?php }else{?>

                            <div class='titleAndName'>
                                <?=gId2rank($row_getReply['usertype']);?><br/>
                                <a href="userinfo.php?zid=<?=$row_getReply['authorid']; ?>"><?=$row_getReply['username']; ?></a>
                                <?php if($row_getReply['alias']!=""){echo "(".$row_getReply['alias'].")";}?>
                                <br />
                                <?php if($row_getReply['is_rbenabled']){?>
                                    <a href='http://realblog.zkiz.com/<?=$row_getReply['username'];?>'><img src='//share.zkiz.com/images/RB.jpg' alt='rbenabled'  title='按此觀看此用戶的Real Blog' /></a>
                                <?php } ?>
                                <a href="pm.php?toid=<?=$row_getReply['authorid']; ?>"><span class='glyphicon glyphicon-envelope' title='PM'></span></a>


                                <?if(in_array($row_getReply['authorid'],$bannedZid)){?>
                                    <a onclick="unblock_user(<?=$row_getReply['authorid'];?>)"><span class='glyphicon glyphicon-ok' title='解除封鎖'></span></a>
                                <?php }else{ ?>

                                    <a onclick="block_user(<?=$row_getReply['authorid'];?>)"><span class='glyphicon glyphicon-ban-circle' title='封鎖'></span></a>
                                <?php } ?>
                            </div>
                        <?php }?>
                        <img src='<?=isAvatarSet($row_getReply["username"])?getAvatarURL($row_getReply["username"],100):"images/noavatar.gif"; ?>'  onclick="$('#detailProfile<?=$initNum;?>').toggle();" style='cursor:help' alt="avatar" class='avatar' />

                        <?if ($row_getReply['score_trade'] != ""){?>

                        <?}?>
                        <?php if($row_getReply['authorid']!=733){?>
                            <div class='pd5 hide2' id='detailProfile<?=$initNum;?>'>
                                <div <?php if($gUserGroup!=9){?>class='hide2'<?}?>><?=$row_getReply['ip'];?></div>
                                <strong>金錢</strong>: <?=$row_getReply['score1']; ?> <br />
                                <strong>帖數</strong>: <?=$row_getReply['postnum']; ?><br />
                                <strong>ＧＰ</strong>: <?=$row_getReply['gp'];?><br />
                                <strong>ＬＶ</strong>: <?=postnum2rank($row_getReply['postnum']);?><br />
                                <strong><a href='/trade.php'>交易所</a></strong>: <?=$row_getReply['score_trade']; ?><br />
                            </div>


                            <?php if($row_getReply['bronze']+$row_getReply['silver']+$row_getReply['gold']){?>
                                <?php
                                $badgetext = "成就:";
                                $badgetext .= $row_getReply['gold']?"{$row_getReply['gold']}金":"";
                                $badgetext .= $row_getReply['silver']?"{$row_getReply['silver']}銀":"";
                                $badgetext .= $row_getReply['bronze']?"{$row_getReply['bronze']}銅":"";
                                ?>

                                <div class='pd5 medals' title="<?=$badgetext;?>" style="cursor:pointer;font-size:6px" onclick="checkArch(<?=$row_getReply['authorid'];?>)">
                                    <div class="gold left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $row_getReply['gold']);?></div>
                                    <div class="silver left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $row_getReply['silver']);?></div>
                                    <div class="bronze left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $row_getReply['bronze']);?></div>
                                </div>
                            <?}?>
                            <div class="clear"></div>
                        <?}?>
                        <div class="clear"></div>
                    <?}?>


                </div>

                <div class='panel-body'>




                    <div class='authorIs<?=$row_getReply['authorid'];?>' id="floorContainer<?=$initNum;?>" style="display:<?=(in_array($row_getReply['authorid'],$bannedZid)&&$initNum!=1)?"none":"block";?>" >

                        <div  >

                            <?php
                            //$isBought: NBBC GLOBAL
                            if(isset($prid) && sizeof($prid)>0){
                                $isBought=in_array($row_getReply['id'],$prid);
                            }else{$isBought=false;}
                            ?>



                            <div id="modiwindow<?=$row_getReply['id']; ?>" style="display:none;"></div>

                            <div class="row" id="floor<?=$initNum;?>">

                                <div class='thread_floor_content_td col-xs-12 col-md-12 col-lg-12'>

                                    <? if($initNum==2){?>
                                        <div class="adv_space">
                                            <?=$secAdv['content'] ?><hr />
                                            <div class='pd5' style='color:#CCC'>此廣告由<a href='/m/<?=$secAdv['username'];?>'><?=$secAdv['username'];?></a>所買。想在這裡下廣告嗎? <a href="/advertisement.php">請按我</a></div>
                                        </div>
                                    <?}?>
                                    <div class='reply_content'>
                                        <?if($initNum==1){?>
                                            <h1 id="title"><?=$title;?>
                                                <small>人氣: <?php echo $row_getThread['views']; ?>
                                                    回覆: <?php echo $row_getThread['commentnum']; ?></small>
                                            </h1>

                                            <div class='left' id='tagOutput'>
            <?if(!$noTag){?>
                <? foreach($tags as $v){?>
                    <span class='glyphicon glyphicon-tag'></span><a target="_blank" href='http://realforum.zkiz.com/gSearchResult.php?q=<?=urlencode($v);?>' class='tag-search' data-searchvalue='<?=htmlspecialchars($v);?>'><?=$v;?></a>
                <? }?>
            <? }?>
        </div>

        <?if($isLog){?>
            <div class="input-group input-group-xs" style='width:150px;float:left'>
                <input type="text" id='tagInput' placeholder='新增TAG' onkeydown="if(event.keyCode==13){addtag(this.value);}"  class="form-control input-xs" />
                <div class="input-group-btn">
                    <? if(($row_getReply['authorid'] == $gId || ($gUserGroup>7) || $isMod) && $isLog == true){?>
                        <a href="<?=$currentPage;?>&amp;renewtag=1" class='btn btn-default btn-xs'>自動TAG</a>
                    <?}?>
                </div>
            </div>
        <?}?>
        <div class="clear"></div>
<hr />
                                        <?}?>

                                        <div class="clear"></div>
                                        <div >
                                            <?=$bbcode->parse($row_getReply['content']);?>
                                        </div>
                                        <div class='clear'></div>

                                        <?if($initNum == 1){?>
                                              <div class="fb-send" 
    data-href="<?=curURL();?>" 
    data-layout="button_count">
  </div>
  <div class="fb-share-button" 
    data-href="<?=curURL();?>" 
    data-layout="button_count">
  </div>
                                            <?if($isLog){?>
                                                <a class="btn btn-success" rel="shadowbox" href="http://realblog.zkiz.com/compose.php?rftid=<?=$gTid;?>" style='margin-top: 0.4em;
											padding: 0em 0.8em;'>RealBlog</a>
                                            <?}?>
                                            <div class='well clear' style='font-size:10pt;max-width:500px;margin-top:1em'>
                                                <?if($authorRecentTopics){?>
                                                    <span class='badge'><?=$row_getReply['username'];?>的最新主題</span>
                                                    <?foreach($authorRecentTopics as $u){?>

                                                        <ul style="margin-bottom: 2px">
                                                            <li><?=timeago(strtotime($u['create_timestamp']));?> : <a href='/thread.php?tid=<?=$u['id'];?>'><?=$u['title'];?></a></li>
                                                        </ul>
                                                    <?}?>
                                                <?}?>

                                            </div>

                                        <?}?>
                                    </div>

                                    <?php parsePicurl($row_getReply['picurl']);?>

                                    <?if($row_getReply['praise'] || $row_getReply['modrecord']){?>
                                        <hr />
                                        <?if($row_getReply['praise']){?>
                                            <div class="contentmodinfo">總評分: <?=$row_getReply['praise'];?></div>
                                        <? } ?>

                                        <?php if($row_getReply['modrecord']){ ?>
                                            <div class="contentmodinfo" style="color:green">紀錄: <?=$row_getReply['modrecord'];?></div>
                                        <?php } ?>


                                    <?}?>

                                    <? if($initNum != 1){?>
                                        <?if($row_getReply['signature']){?>
                                            <div class="contentmodinfo" style='overflow:hidden; max-height:200px; margin-top:1em; padding:0.5em; border-top:1px solid #888;opacity:0.5'>
                                                <?=$bbcode->Parse(trim($row_getReply['signature'])); ?>
                                                ~<?=$row_getReply['username']; ?>
                                            </div>
                                        <?}else{?>

                                        <?}?>
                                    <?}?>


                                </div>



                            </div>



                        </div>


                        <?php if($row_getReply['comment'] != ""){ $comments=array_reverse(unserialize($row_getReply['comment']));?>
                            <div class="reply_comment_container">
                                <?php foreach($comments as $comment){?>
                                    <div class='reply_comment'>
                                        <a href='userinfo.php?zid=<?=$comment['zid'];?>'><?=$comment['username'];?></a> : <?=htmlspecialchars($comment['content']);?>
                                        (<?=timeago($comment['timestamp']);?>)
                                    </div>
                                <?php }?>
                            </div>
                        <?php } ?>
                    </div>

                </div>

                <div class="panel-footer">

                    <?php if(in_array($row_getReply['authorid'],$bannedZid)&&$initNum!=1){?>
                        <a onclick="$('#floorContainer<?=$initNum;?>').toggle('fast');">已封鎖會員(<?=$row_getReply['username'];?>)的留言</a>
                    <? }else{ ?>
                        <?php if($gUserGroup>=7){?>
                            <a onclick="dialog('ajaxbox/delthread.php?id=<?=$row_getReply['id']; ?>&tid=<?=$gTid; ?>','管理',false,600);" class='btn btn-default btn-xs'>管理</a>
                        <? }?>
                        <div class=' right' style='font-size:12px'>
                            <?if($initNum - sizeof($getReply) == $startRow_getReply){?>
                                <a id="lastpost"></a>
                            <?}?>

                            <?if($row_getReply['authorid']>0){?>
                                <a href="<?=curURL();?>#<?=$initNum ?>" style='color: inherit;'><?=$initNum ?>樓</a> -


                                發表於:<?=timeago(strtotime($row_getReply['datetime'])); ?>
                                <?php if(strtotime($row_getReply['timestamp']) - strtotime($row_getReply['datetime']) > 60){ ?>
                                    - 最後修改:<?=timeago(strtotime($row_getReply['timestamp']));?>
                                <?php } ?>

                            <? } ?>

                            <?if($row_getReply['authorid']>0){?>

                                <?php if($row_getReply['price']>0){?>
                                    <a  class="btn btn-default" onclick="dialog('ajaxbox/purchase.php?id=<?=$row_getReply['id']; ?>&amp;tid=<?=$gTid; ?>&amp;target=<?=$row_getReply['authorid'];?>','購買');">
                                        <span class="ui-icon ui-icon-unlocked insidebutton"></span>
                                        Buy!($<?=$row_getReply['price'];?>)</a>
                                <?php } ?>
                            <?}?>

                        </div>
                        <div class='clear'></div>
                    <?}?>

                    <div class='clear'></div>
                    <div class="row" style="    border-top: 1px #Eee solid;
    padding-top: .5em;
    margin-top: .5em;">
                        <? if($initNum == 1){?>

                            <div class="col-lg-6 col-md-12">
                                <?if($is_closed){?>	<span class='badge'>已關閉</span><?}?>



                                <? if($isLog){?>
                                    <a onclick='turnOnNotification(<?=$gTid?>)' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-volume-up'></span> 訂閱主題</a>
                                    <a onclick='turnOffNotification(<?=$gTid?>)' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-volume-off'></span> 退訂主題</a>

                                <?}?>




                                <? if(($row_getReply['authorid'] == $gId || ($gUserGroup>7) || $isMod) && $isLog == true){?>
                                    <?php if ($row_getReply['isfirstpost']==1 && $row_getThread['special'] != 1){ ?>
                                        <a  class="btn btn-default btn-xs" onclick="dialog('ajaxbox/newpoll.php?act=add&amp;id=<?=$row_getReply['id']; ?>&amp;tid=<?=$gTid; ?>','插入投票',false);">插入投票</a>
                                    <?php } ?>
                                    <?php if($row_getThread['special'] == 1){ ?>
                                        <a  class="btn btn-default btn-xs" onclick="dialog('ajaxbox/newpoll.php?act=del&amp;tid=<?=$gTid; ?>','刪除投票',false);">刪除投票</a>
                                    <?php } ?>
                                    <input type="text" style='font-size:9pt;width:5em;padding:1px 3px' placeholder='跳到樓層' onkeydown="if(event.keyCode==13){jump(this.value);}" />
                                <? } ?>
                                <a href="<?=curURL();?>&amp;action=prevtopic" title="快捷鍵：a" class='btn btn-default btn-xs'><span class='glyphicon glyphicon-arrow-left'></span></a>
                                <a href="<?=curURL();?>&amp;action=nexttopic" title="快捷鍵：d" class='btn btn-default btn-xs'><span class='glyphicon glyphicon-arrow-right'></span></a>

                            </div>


                        <?}?>

                        <?if($row_getReply['authorid']>0){?>


                            <div class="col-lg-6 col-md-12 pull-right">
                                <div class="pull-right btn-group btn-group-xs ">
                                    <?php if(($isMod || $gUserGroup>6) && $initNum!=1) {?>
                                        <button class="btn btn-default" onclick="dialog('ajaxbox/modreply.php?id=<?=$row_getReply['id']; ?>&amp;tid=<?=$gTid; ?>&amp;floor=<?=$initNum ?>&amp;paramlink=<?=base64_encode(curURL()."#".$initNum);?>','管理<?=$initNum ?>樓',true,400,200);">刪除</button>
                                    <?php } ?>

                                    <?php if(($row_getReply['authorid'] == $gId || $gUserGroup==9) && $isLog == true){?>
                                        <button class="btn btn-default"  onclick="dialog('ajaxbox/thread_modi_post.php?id=<?=$row_getReply['id']; ?>&amp;tid=<?=$gTid; ?>&amp;page=<?=$gPage;?>','編輯');">編輯</button>
                                    <?php } ?>

                                    <button class="btn btn-default" onclick="convert(0,'floor<?=$initNum;?>')">簡</button>
                                    <button class="btn btn-default" onclick="convert(1,'floor<?=$initNum;?>')">繁</button>


                                    <? if($_GET['authoronly']==""){?>
                                        <a  class="btn btn-default" href="<?=$currentPage;?>&amp;authoronly=<?=$row_getReply['authorid']?>">只看該作者</a>
                                    <?}else{?>
                                        <a  class="btn btn-default" href="thread.php?tid=<?=$gTid;?>">顯示全部帖子</a>
                                    <?}?>



                                    <button class="btn btn-default" onclick="loadinto('<?=$row_getReply['id'];?>','<?=$initNum;?>','<?=$row_getReply['id'];?>','<?=$row_getReply['username'];?>')">引用回覆</button>
                                    <?php if(!$is_banned){?>
                                        <button class="btn btn-default" onclick="dialog('ajaxbox/gjreply.php?id=<?=$row_getReply['id']; ?>&amp;tid=<?=$gTid; ?>&amp;target=<?=$row_getReply['authorid'];?>&amp;page=<?=$gPage;?>','留言');">留言</button>
                                    <?}?>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?if($initNum==1 && false){?>
            <div class='panel panel-default pd5'>

                <div class='row'>


                </div>


                <?if(sizeof($backlinks)>0){?>
                    <div class='ui-widget-header' style='border-left:0;border-right:0;padding:3px'>延伸閱讀</div>

                    <div style='margin:7px;'>

                        <?foreach ($backlinks as $v){?>
                            <div style='font-size:14px;margin:2px;padding:2px'>
                                <a  href='<?=urldecode($v->url);?>'><?=$v->title;?></a><br />
                                <span style='font-size:12px;color:#CCC'><?=urldecode($v->url);?></span>
                            </div>
                        <?}?>

                    </div>
                <?}?>


            </div>
        <?}?>

        <? if($initNum%7==5 && !$gNoAds){?>
            <div class="panel">
        <div class="panel-body">

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
            <div class="panel-footer">
                廣告
            </div>
            </div>
        <?}?>
    <?php } ?>


    <div class='hide2 panel panel-default' id='myposthead'>







        <div class="panel-body" id="dummy_reply">






            <div class='thread_floor_author well'>

                <?php if(!$isLog){?>
                    訪客<br/>
                    Guest (IP: <?=getIP(); ?>)
                <?php }else{?>

                    <div class='titleAndName'>
                        <?=gId2rank($my['usertype']);?><br/>
                        <a href="userinfo.php?zid=<?=$my['id']; ?>"><?=$my['username']; ?></a>
                        <?=$my['alias']?"({$my['alias']})":""?>
                        <br />
                        <?php if($my['is_rbenabled']){?>
                            <a href='http://realblog.zkiz.com/<?=$my['username'];?>'><img src='//share.zkiz.com/images/RB.jpg' alt='rbenabled'  title='按此觀看此用戶的Real Blog' /></a>
                        <?php } ?>
                        <a href="pm.php?toid=<?=$my['id']; ?>"><span class='glyphicon glyphicon-envelope' title='PM'></span></a>

                    </div>
                <?php }?>
                <img src='<?=$my['pic']==""?"images/noavatar.gif":$my['pic']; ?>'  onclick="$('#detailProfile_my').toggle();" style='cursor:help' alt="avatar" class='avatar' />


                <?php if($isLog){?>
                    <div class='pd5 hide2' id='detailProfile_my'>
                        <strong>金錢</strong>: <?=$my['score1']; ?> <br />
                        <strong>帖數</strong>: <?=$my['postnum']; ?><br />
                        <strong>ＧＰ</strong>: <?=$my['gp'];?><br />
                        <strong>ＬＶ</strong>: <?=postnum2rank($my['postnum']);?><br />
                        <strong><a href='/trade.php'>交易所</a></strong>: <?=$my['score_trade']; ?><br />
                    </div>


                    <?php if($my['bronze']+$my['silver']+$my['gold']){?>
                        <?php
                        $badgetext = "成就:";
                        $badgetext .= $my['gold']?"{$my['gold']}金":"";
                        $badgetext .= $my['silver']?"{$my['silver']}銀":"";
                        $badgetext .= $my['bronze']?"{$my['bronze']}銅":"";
                        ?>

                        <div class='pd5 medals' title="<?=$badgetext;?>" style="cursor:pointer;font-size:6px" onclick="checkArch(<?=$my['authorid'];?>)">
                            <div class="gold left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $my['gold']);?></div>
                            <div class="silver left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $my['silver']);?></div>
                            <div class="bronze left"><?=str_repeat("<span class='glyphicon glyphicon-certificate'></span>", $my['bronze']);?></div>
                        </div>
                    <?}?>
                    <div class="clear"></div>
                <?}?>
                <div class="clear"></div>
            </div>






            <div class=''>
                <div id='mypost'></div>
                <div class="contentmodinfo">
                    (提示:如要觀看隱藏內容, <a href='thread.php?tid=<?=$gTid;?>' style='font-weight:bold'>按此</a>回到第一頁)
                </div>
            </div>
        </div>

    </div>
</div>



<div class='row' style='margin:0.3em 0;'>

    <div class="col-md-12  pull-right" >

        <div class='right thread_main_content_pagin'>
            <?php pagin($gPage, $currentPagePure, $queryString_getReply, $totalPages_getReply);?>
        </div>
        <div class='right'>

            <a href='/viewforum.php?fid=<?=$row_getThread['type'];?>' class='btn btn-default'><span class='glyphicon glyphicon-menu-left'></span> 返回列表</a>

        </div>
        <div class="clear"></div>

    </div>
</div>
<div class='panel panel-default'>
    <div class='panel-body'>
        <? if($isLog){?>
            <a onclick='turnOnNotification(<?=$gTid?>)' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-volume-up'></span> 訂閱主題</a>
            <a onclick='turnOffNotification(<?=$gTid?>)' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-volume-off'></span> 退訂主題</a>

        <?}?>
    </div>
</div>
<div>

    <?php if($able_to_reply){?>
        <div>
            <?php if($row_getThread['special'] == 5){?>
                <strong>這主題被設定為資源貼, 並不會對用戶發出回覆通知。</strong>
            <?php }?>
        </div>
        <div id='quickpost'>
            <?php if($row_getThread['commentnum']>2000){?>
                <strong>這主題回覆數己超過2000, 系統將不會對用戶發出回覆通知, 如有需要可以考慮另開新貼。</strong>
            <?php } ?>
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <?php include_once("templatecode/quickpost.php");?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if($is_banned){?>
        你已被此版版主加到黑名單中, 暫時不能發貼, 如有疑問, 請聯絡此版版主。
    <?php } ?>
    <?php if($noguest && !$isLog){?>
        此版不容許訪客發貼, 請先登入。
    <?}?>
</div>

<ol class="breadcrumb" style='margin-top:5px; margin-bottom:0'>
    <li><a href="/">主頁</a></li>
    <li><a href="<?="viewforum.php?fid={$row_getThread['type']}";?>"><?=$boardInfo['name'];?></a></li>
    <li class="active"><?=mb_substr($title,0,40,"utf-8").(mb_strlen($title,"utf-8")>40?"...":"");?></li>

</ol>




<script type="text/javascript">
    /* <![CDATA[ */
    function checkArch(id){
        $.getJSON(
            "/ajaxdata.php",{zid:id,type:"achievements"},
            function(data){
                var items = [];
                $.each(data, function(key, val) {
                    items.push('<div class="rank'+val.rank+'">' + val.name + ":" + val.description + '</div>');
                });

                domToModal(
                    $('<div/>', {
                        'class': 'archList',
                        html: items.join('') + "<hr /> <a href='/achievements.php' target='_blank'>按我進入成就系統</a>"
                    }),"成就");
            }
        );
    }
    if(readCookie("<?=$gTid?>")=="true"){
        $(".fbhide").show();
    }
    $(".fbhidecontainer").html('<a id="ShareToDownload" class="btn btn-primary"><i class="fa fa-facebook"></i> 分享至 Facebook 以查看隱藏內容</a> <hr /><fb:like show_faces="true" width="450" href="<?=$g_domain;?>/thread.php?tid=<?=$gTid;?>"></fb:like><div class="fb-like" data-href="http://www.facebook.com/zkizcom" data-send="false" data-width="150" data-show-faces="true"></div>');

    $('#ShareToDownload').on('click', function() {
        FB.ui({
                display: 'popup',
                method:  'share',
                href:    location.href,
            },
            function(response) {
                if (response &&  !response.error) {

                    $('.fbhidecontainer').fadeOut(function(){ $('.realcontent').fadeIn() });
                } else {
                    alert('必須先分享到Facebook 才可以查看隱藏內容。');
                }
            });
    });
    /*
     $('a.confirm_url').after(
     function(){
     var u = this.href;
     if (u.match(/^(https?|ftp):\/\//i) && (u.match(/^https?:\/\/[0-9a-zA-Z_.]+\.zkiz\.com/i) )) return;
     return ' <a href="'+u+'" target="_blank" style="display:inline-block" title="新視窗打開"><span class="ui-icon ui-icon-newwin"></span></a> <a style="display:inline-block" onclick="iframe_box_load(\''+u+'\')" target="_blank" title="iframe 打開"><span class="ui-icon ui-icon-image"></span></a><div class="clear"></div>';
     }
     );
     //
     $('a.confirm_url').click(function () {
     var self = $(this);
     var u = self.attr('href');
     self.attr('target', '_blank');
     //if (GetCookie('ignore_outlink') == 1) return;
     if (u.match(/^(https?|ftp):\/\//i) && (u.match(/^https?:\/\/[0-9a-zA-Z_.]+\.zkiz\.com/i) )) return;
     var bg = $('<div>'+u+'</div>');
     var goButton = $('<button class="btn btn-default">新視窗前往</button>').appendTo(bg).click(function () {
     window.open(u, "_blank");
     $('#modelDialog').modal('close');
     });
     var iframeButton = $('<button class="btn btn-default">iframe打開</button>').appendTo(bg).click(function (){
     iframe_box_load(u);
     $('#modelDialog').modal('close');
     });
     domToModal(bg,"打開外部網頁選項");
     //bg.modal({width:190});
     return false;
     });
     */
    var maxpage = <?=$totalPages_getReply;?>;
    var currentpage = <?=$gPage==""?0:$gPage;?>;

    $(document).keydown(

        function(e){

            if (e == null) {
                key = event.keyCode;
                tagname = e.srcElement.tagName;
            } else { // mozilla
                key = e.which;
                tagname = e.target.tagName;
            }

            if(tagname == 'INPUT' || tagname == 'TEXTAREA') return;

            if(key == 39 && currentpage != maxpage) {
                window.location = 'thread.php?tid=<?=$gTid?>&page=<?=($gPage+1)?>';
            }
            if(key == 37 && currentpage != 0) {
                window.location = 'thread.php?tid=<?=$gTid?>&page=<?=($gPage-1)?>';
            }
            if(key == 74) {
                window.location = 'index.php';
            }
            if(key == 75) {
                window.location = 'viewforum.php?fid=<?=$row_getThread['type']; ?>';
            }
        }

    );
    var selectedURL;
    $(document).ready(function(){
            $('.xtag-search').click(
                function(){
                    selectedURL = $(this).attr('data-searchvalue');
                }

            ).confirmation(
                {
                    title: '要用何種方法搜尋呢?',
                    btnOkLabel:'搜尋 ZKIZ Tag',
                    btnOkIcon : '',
                    btnCancelIcon : '',
                    btnCancelLabel:'全文搜尋',
                    onConfirm: function(){
                        window.open('http://zkiz.com/tag.php?tag='+selectedURL,"_blank");
                        return false;
                    },
                    onCancel: function(){
                        window.open('http://realforum.zkiz.com/gSearchResult.php?q='+selectedURL,"_blank");
                        return false;
                    },
                    singleton: true
                }
            );
        }
    );

    /* ]]> */
</script>

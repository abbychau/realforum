<script type="text/javascript">
    function stripHtml(strIn) {
        var matchTag = /<(?:.|\s)*?>/g;
        return strIn.replace(matchTag, "");
    }
    function reply(toId, toName, title, fromDiv) {
        $('#to_id').val(toId);
        $('#title').val('回覆: ' + title);
        $('#content').val( ( isMobile ? "\n\n" : "") + "[quote]\n" + stripHtml(document.getElementById(fromDiv).innerHTML) + "\n" + stripHtml(toName) + "(id:" + toId + ")" + "\n[/quote]\n\n");
        $('#content').focus();
    }
    function delPm(pmid) {
        $.get('ajaxdata.php', {id: pmid, type: 'delpm'});
        $('#cpm' + pmid).hide('fast');
    }
    function togRead(pmid, iRead) {
        $.get('ajaxdata.php', {id: pmid, type: 'changepm', isread: iRead});
        if (iRead) {
            $('#pm' + pmid).hide();
        } else {
            $('#pm' + pmid).show();
        }
    }
    function togReadAll() {
        $.get('ajaxdata.php', {type: 'readAllPm'}, function () {
            $('.pmcontents').hide();
        });

    }
    function toZid(name) {
        $.get('ajaxdata.php', {id: name, type: '2'},
            function (data) {
                document.getElementById('to_id').value = data;
            });
    }
    function newConversation(){
        var username = prompt("請輸入你要對行聊天的人(未完成)");
        if(username){
            $.get("/ajaxdata.php",{type:2,id:username},function(data){
                if(isNaN(data)){
                    alert(data);
                }else{
                    $("#conversationContainer").append("<iframe src='http://chat.zkiz.com/?box=true&from=<?=$gId;?>&to="+data+"'></iframe>");
                }
            });
        }
    }
    $("#nav_pm").addClass("active");
</script>
<style>
    iframe{border:none; background:inherit;margin:0}
</style>

<ol class="breadcrumb">
    <li><a href="/">RealForum</a></li>
    <li class="active">PM 系統</li>
    <li>
        <? if ($actsent) { ?>
            <strong>寄件箱</strong>
            <a href="pm.php">切換到收件箱</a>
        <? } else { ?>
            <strong>收件箱</strong>
            <a href="pm.php?action=sent">切換到寄件箱</a>
        <? } ?>
        <a onclick="togReadAll()" class="btn btn-default">所有標示已讀</a>
    </li>
</ol>

<div class="row">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <?php if (sizeof($mails) > 0) { ?>
            <?php foreach ($mails as $row_getType) { ?>


                <div class="panel panel-default" id="cpm<?php echo $row_getType['id']; ?>">
                    <div class="panel-heading">
                        <div style="float:right">
                            <? if (!$actsent) { ?>
                                標示已讀
                                <input name="isread" type="checkbox"
                                       <?php if ($row_getType['isread'] == 1){ ?>checked="CHECKED"<?php } ?>
                                       onchange="togRead('<?php echo $row_getType['id']; ?>',this.checked)"/>
                            <? } ?>
                            <input type="button" class='btn btn-default btn-xs' onclick="delPm('<?php echo $row_getType['id']; ?>')" value="刪除" />
                        </div>

                        <strong><?php echo htmlspecialchars($row_getType['title']); ?></strong>
                        <a class='btn btn-default btn-xs'
                           onclick="reply('<?php echo $row_getType['from_id']; ?>','<?=$row_getType['ufrom']; ?>','<?=str_replace("'", "", $row_getType['title']); ?>','<?= "msg" . (++$i); ?>');">回覆</a>

                    </div>
                    <div class="panel-body pmcontents" style='display:<?=($row_getType['isread'] == 1)?'none':'block';?>' id="pm<?=$row_getType['id']; ?>">

                        <div style="padding-left:20px"
                             id="<?= "msg" . $i; ?>"><?php echo $bbcode->Parse($row_getType['message']); ?></div>
                        <br/>
                        <?= $actsent ? "收件人" : "發件人"; ?>: <a
                            href="userinfo.php?zid=<?php echo $row_getType['from_id']; ?>"><?php echo $row_getType['ufrom']; ?></a><br/>
                        時間: <?php echo $row_getType['timestamp']; ?>

                    </div>
                </div>

            <?php } ?>
        <?php } else { ?>
            沒有信息
        <?php } ?>

    </div>
    <div class="col-md-3 col-sm-4 hidden-xs">
        <div class="panel panel-default">
            <div class="panel-body">
                <a onclick="newConversation()" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 新增對話</a>
                <div id="conversationContainer"></div>
            </div>

        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">發送信息</div>
    <div class="panel-body">
        <form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            收件人ZID:<input name="to_id" type="text" id="to_id" size="30" maxlength="30"
                          value="<?php echo $_GET['toid']; ?>"/>
            <input name="" type="button" value="名字轉為ZID" onclick="toZid(document.getElementById('to_id').value);"/>
            (可用","分隔各用戶, 每條短訊發出將扣取 1 壇幣)
            <br/>
            <?php if (sizeof($contacts) > 0) { ?>
                <?php foreach ($contacts as $i => $v) { ?>
                    <a onclick='$("#to_id").val($("#to_id").val()+",<?= $i; ?>");'><?php echo $v; ?></a>
                <?php } ?>
            <? } ?>
            <br/>
            標題:<input name="title" type="text" size="50" id="title"/><br/>
            內容:<br/>
            <textarea name="content" id="content" class="ed" cols="90" rows="15" style='font-size:12px'></textarea>
            <br/>
            <input type="hidden" name="MM_insert" value="form2"/>
            <input type="submit" name="Submit" value="送出" class='button'/>
        </form>
    </div>
</div>

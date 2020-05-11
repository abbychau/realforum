<?php
include_once('classes/mysql.php');
if(!isset($db)){$db = new DbConn("localhost","zkizcom78f_forum","aassddff","zkizcom78f_forum");}

$mod_upposts = $db->query("SELECT isdigest, isshow, `datetime`, a.`id`, `title`, b.name as forumname, b.id as forumid, c.username as aname, views, commentnum, isshow, a.lastdatetime, d.username as rname

FROM `zf_contentpages` a, zf_contenttype b, zf_user c , zf_user d
WHERE a.authorid = c.id 
AND b.id = a.type
AND d.id = a.lastid

order by lastdatetime desc LIMIT 10",true,(60*2));


?>
<div style="font-weight:bold; border-bottom:1px #CCC solid">最後更新主題</div>
<ul class="nols" style="width:100%;overflow:hidden">

<?php foreach($mod_upposts as $row){ ?>
<li style="white-space:nowrap">
    <a href="thread.php?tid=<?php echo $row['id']; ?>" title="<?php echo "作者:".$row['aname']." 最後回覆:".$row['rname']." 時間:".$row['lastdatetime']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
    <?php if($row['isdigest'] == 1){ ?><span style="color:#F60; font-weight:bold">[精華]</span><?php } ?>
    <?php if($row['isshow'] == 2){ ?><span style="color:#06C; font-weight:bold">[置頂]</span><?php } ?>
    (<?php echo $row['views']; ?>/<?php echo $row['commentnum']; ?>)
</li>
<?php } ?>
</ul>
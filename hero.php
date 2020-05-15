<?php
include_once("Connections/zkizblog.php");

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_POST["reg"])) && ($_POST["reg"] == "reg")) {

/////GET AND DIE on score1 < certain
if($my['score1']<100){die("你不足$100 呢!");}


/////INSERT
$insertsql = "INSERT INTO `zf_hero` (`zid`, `job`) VALUES ('".$gId."', '".$_POST['job']."')";
dbQuery($insertsql);

$insertsql2 = "UPDATE `zf_user` SET score1 = score1 - 100 WHERE id = $gId";
dbQuery($insertsql2);
}

/////GET user info
$row_getUserInfo = dbRow("SELECT * FROM zf_user a, zf_view_authorgj b, zf_hero c WHERE a.id=b.authorid AND a.id=c.zid AND a.id = %d", $gId);


$lv = round(pow(($row_getUserInfo['postnum']*12)+$row_getUserInfo['exp'],0.909)/30);
$htmltitle="RF 大冒險";
include_once("templatecode/header.php");
?>

<?php if($isLog == false){ ?>
<h3>登入</h3>
請先<a style="cursor:pointer" onclick="$('#showajax').toggle('slow').load('login.php');" href="#">登入</a>
<?php }elseif($totalRows_getUserInfo==0){?>
<div class="tback" style="margin-top:5px">
<div class="boxtitle">
<strong>登記</strong>
</div>
<div style="padding:10px">
因為冒險世界十分危險, 要進行冒險必轉職<br />
<br />
<form method="post" name="reg" action="<?=$currentPage; ?>">
你: 我要當...<br />
<input name="job" type="radio" value="1" checked />豬肉佬<br />
<input name="job" type="radio" value="2" checked />魚佬<br />
<input name="job" type="radio" value="3" checked />燒酒佬<br />
<input name="reg" type="hidden" value="reg" />
<br />
註意: 要轉職的話需要$100 手續費(用來幫你孝敬師父的啊...)<br />
不過現在是測試佳節, 裡面沒東西玩不要怪我喔!<br />

<br />
<input type="submit" value="按此登記" />
</form>
</div>
</div>
<?php }else{ ?>
<h3>RF 大冒險</h3>
<div style="float:left; width:120px;">
  <img style="margin-top:10px" width='120' height='120' src='<?=isAvatarSet($my["username"])?getAvatarURL($my["username"],150):"images/noavatar.gif"; ?>' alt="avatar" /><br />
  <?php if($row_getUserInfo['authorid']==0){?>
    Guest (IP: <?=$row_getUserInfo['ip']; ?>)
  <?php }else{?>
    <a href="userinfo.php?zid=<?=$row_getUserInfo['authorid']; ?>"><?=$row_getUserInfo['username']; ?></a>
    <a href="pm.php?toid=<?=$row_getUserInfo['authorid']; ?>"><img src="images/pm.png" alt="pm" /></a>
    <br />
    <strong>金錢</strong>:<?=$row_getUserInfo['score1']; ?> <br />
    <strong>秘寶</strong>:<?=$row_getUserInfo['score2']; ?> <br />
    <strong>發帖數</strong>:<?=$row_getUserInfo['postnum']; ?><br />
    <strong>等級</strong>:LV<?=$lv;?><br />
    <strong>GJ</strong>:<?=$row_getUserInfo['gj'];?>
<hr />
<br />
  <?php }?>
</div>
<div style="margin-left:140px;">


  <div class="tback" style="margin-top:5px">
  <div class="boxtitle"><strong>基本數值</strong></div>
  <div style="padding:10px">
    <strong>職業</strong>: <?php 
    switch($row_getUserInfo['job']){
        //體質, 力量, 敏捷
        case 1: 
            echo "豬肉佬"; 
            $x = 4*$lv;	$y = 4*$lv;	$z = 2*$lv;
            break;
        case 2: 
            echo "魚佬"; 
            $x = 2*$lv;	$y = 5*$lv;	$z = 3*$lv;
            break;
        case 3: 
            echo "燒酒佬"; 
            $x = 2*$lv;	$y = 3*$lv;	$z = 5*$lv;
            break;
    }
    ?> <br />
    <strong>血量</strong>: <?=round(pow((0.6*$x + 0.4*$lv),1.5)); ?><br />
    <strong>攻擊</strong>: <?=round(pow((0.6*$y + 0.4*$lv),1.5)/10); ?><br />
    <strong>防禦</strong>: <?=round(pow((0.6*$z + 0.4*$lv),1.5)/10); ?><br />
  </div>
  

  <div class="boxtitle">
  <strong>行動</strong>
  </div>
  <div style="padding:10px">
  到武器店　到裝備店　找江湖術士　找小明　到餐廳　去森林　去山洞　去湖泊
  </div>

  
  </div>
</div>
<?php }?>
<?php 
include_once("templatecode/footer.php");
?>
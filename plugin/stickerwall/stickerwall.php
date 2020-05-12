<?php 
	$query_getSticker = "SELECT * FROM zf_sticker";
	$arrStickers = dbAr($query_getSticker);
	
	$uptypes=array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/x-png');
	$max_file_size=500000;   //上傳文件大小限制, 單位BYTE
	$destination_folder="blocks/"; //上傳文件路徑
	
	if ($_POST["alt"] != ""){
		
		if (!is_uploaded_file($_FILES["upfile"]["tmp_name"])){die("文件不存在！");}
		
		$file = $_FILES["upfile"];
		$filename = $file["tmp_name"];
		$image_size = getimagesize($filename); 
		$width = $image_size[0];
		$height = $image_size[1];
		
		if($max_file_size < $file["size"]){die("文件太大！");}
		if(!in_array($file["type"], $uptypes)){die("只能上傳這些格式(jpeg,jpg,png,pjpeg,gif,png)！");exit;}
		if(!file_exists($destination_folder)){mkdir($destination_folder);}
		if($width%20 != 0 || $height%15 != 0){die("長的倍數不是20或闊的倍數不是15");}
		if($width*$height > $_POST['pixel']){die("購買像數不足");}
		
		$pinfo=pathinfo($file["name"]);
		$ftype=$pinfo["extension"];
		$destination = $destination_folder.time().".".$ftype;
		if(file_exists($destination)){die("上傳失敗, 請重試!");exit;}  
		if(!move_uploaded_file ($filename, $destination)){die("上傳文件出錯!");exit;}
		
		$pinfo=pathinfo($destination);
		$fname = $pinfo['basename'];
		$href = trim($_POST['href']);
		$alt = trim($_POST['alt']);
		$ownerid = intval($gId);
		$x = intval($_POST['x']);
		$y = intval($_POST['y']);
		$src = "/".$destination_folder.$fname;
		$dmoney = round($_GET['pixel']/10);
		
		$row_gets1 = dbRs("SELECT score1 FROM zf_user where id = $ownerid");
		if($dmoney > $row_gets1['score1']){die('金錢不足, 你需要$dmoney 金錢!');}
		
		dbQuery("INSERT INTO zf_sticker (`left`,`top`,`src`,`href`,`alt`,`ownerid`) VALUES (?,?,?,?,?,?)",
	[$x, $y, $src, $href, $alt, $ownerid]);
		dbQuery("UPDATE zf_user set score1 = score1 - $dmoney where id = {$ownerid}");
	}
?>
<div class='panel panel-default panel-body'>
	
	<h1>RealForum 貼紙牆</h1>
	<div style="height:900px">
		<div style="background-image:url(/images/15grid2.gif); background-repeat:no-repeat; width:700px; height:900px; position:absolute" class="gridpage">
			<?php foreach($arrStickers as $row_getSticker){ ?>
				<div style="top:<?php echo $row_getSticker['top']*15;?>px; left:<?php echo $row_getSticker['left']*20;?>px; position:absolute; margin:0px; padding:0px">
					<a href="<?php echo $row_getSticker['href'];?>"> <img src="<?php echo $row_getSticker['src'];?>" alt="<?php echo $row_getSticker['alt'];?>" style="border:none" /></a>
				</div>
			<?php } ?>
		</div>
	</div>
	
</div>
<div class='panel panel-default panel-body'>
	
	<fieldset><legend>置放帖紙</legend>
		<form enctype="multipart/form-data" method="post" name="upform" action="<?php echo($_SERVER['PHP_SELF'].'?id='.$_GET['id']); ?>">
			購買像數(像數 = 長x闊x300):<input name="pixel" type="text" size="6" maxlength="6" />(收費為: 1金錢/10像數)<br />
			選擇你要置放貼紙左上角的座標 X:<input name="x" type="text" size="4" maxlength="4" />(0-39)
			Y:<input name="y" type="text" size="4" maxlength="4" />(0-59)(如和其他貼紙重疊, 可能會被覆蓋)<br />
			介紹:<input name="alt" type="text" size="50" maxlength="50" /><br />
			網址連結:<input name="href" type="text" size="50" maxlength="50" value="http://" /><br />
			<input name="upfile" type="file"  size="35" />
			允許上傳的文件類型為: jpg|jpeg|png|pjpeg|gif|bmp|x-png (最大500kB)
			<br />
			<br />
			<input type="submit" value="確定" class='btn btn-default' />
		</form>
	</fieldset>
</div>

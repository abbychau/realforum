<?php 
	define('LITE_HEADER',true);
	require_once('../Connections/zkizblog.php'); 
	require_once('../include/common.inc.php');
	
	$typeid = intval($_GET['typeid']);
	if($typeid==""){$typeid = intval($_POST['tid']);}
	
	//authorize
	if(modRank($typeid)==0 && $my['usertype'] <= 8){die("Access Denied");}
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if (isset($_POST['submit'])) {
		
		define('DESIRED_IMAGE_WIDTH', 100);
		define('DESIRED_IMAGE_HEIGHT', 100);
		
		if($_FILES['Image1']['tmp_name']!=""){
			$source_path = $_FILES['Image1']['tmp_name'];
			
			// Add file validation code here
			list($source_width, $source_height, $source_type) = getimagesize($source_path);
			switch ($source_type) {
				case IMAGETYPE_GIF:
				$source_gdim = imagecreatefromgif($source_path);
				break;
				
				case IMAGETYPE_JPEG:
				$source_gdim = imagecreatefromjpeg($source_path);
				break;
				
				case IMAGETYPE_PNG:
				$source_gdim = imagecreatefrompng($source_path);
				break;
			}
			$source_aspect_ratio = $source_width / $source_height;
			$desired_aspect_ratio = DESIRED_IMAGE_WIDTH / DESIRED_IMAGE_HEIGHT;
			if ($source_aspect_ratio > $desired_aspect_ratio) {
				
				// Triggered when source image is wider
				$temp_height = DESIRED_IMAGE_HEIGHT;
				$temp_width = ( int )(DESIRED_IMAGE_HEIGHT * $source_aspect_ratio);
				} else {
				
				// Triggered otherwise (i.e. source image is similar or taller)
				$temp_width = DESIRED_IMAGE_WIDTH;
				$temp_height = ( int )(DESIRED_IMAGE_WIDTH / $source_aspect_ratio);
			}
			
			// Resize the image into a temporary GD image
			$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
			imagecopyresampled($temp_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height);
			
			// Copy cropped region from temporary image into the desired GD image
			$x0 = ($temp_width - DESIRED_IMAGE_WIDTH) / 2;
			$y0 = ($temp_height - DESIRED_IMAGE_HEIGHT) / 2;
			$desired_gdim = imagecreatetruecolor(DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);
			imagecopy($desired_gdim, $temp_gdim, 0, 0, $x0, $y0, DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);
			
			// header( 'Content-type: image/jpeg' );
			$filename = "../images/zoneicon/".time().".png";
			imagepng($desired_gdim, $filename, 8);
			ob_start(); imagejpeg($desired_gdim,NULL,80); $pngimagedata = ob_get_contents(); ob_end_clean();
						
			imagedestroy($desired_gdim);
			//$filename = substr($filename,2,strlen($filename)-2);
			}else{
			$filename="";
		}
		//dbQuery("UPDATE zf_contenttype SET icon_blob='{$pngimagedata}' WHERE id={$typeid}");
		dbQuery("UPDATE zf_contenttype SET icon='{$filename}' WHERE id={$typeid}");
		dbQuery("UPDATE zf_user SET score1=score1-8 WHERE id={$gId}");
		
		$updateGoTo = "/viewforum.php?fid=".$_GET['typeid'];
		if (isset($_SERVER['QUERY_STRING'])) {
			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
		}
		header(sprintf("Location: %s", $updateGoTo));
	}
	
	
	$getIntro = dbRow("SELECT * FROM zf_contenttype WHERE id = {$typeid}");
?>
<h4>修改圖示</h4>
現在城標:<br />
<img src="<?=$getIntro['icon'];?>" alt="zone_icon" style="margin:2px 5px 2px 2px" /> 
<br />

<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data">


<input type="file" name="Image1"><br />
<input type="submit" name="submit" value="上傳">
<input name="tid" type="hidden" value="<?php echo $_GET['typeid']; ?>" /><br />
注意:<br />
- 修改城標會扣除你身上8金錢<br />
- 城標會在首頁和帖子列表上方顯示
</form>

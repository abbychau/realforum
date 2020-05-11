<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>upload imageshack</title>
<style type="text/css">
fieldset{border:1px #444 solid}
body{font-size:12px; color:#444}
</style>
</head>
<body style="background-color:#FFF; margin:20px">

<fieldset>
	<legend>Imageshack</legend>
	<form action="http://imageshack.us/" method="post" encType="multipart/form-data"> 
		<input class="textfield" type="file" size="30" name="fileupload"><br />
		<input type="hidden" value="1048576" name="MAX_FILE_SIZE" /> 
		<input type="hidden" name="aff" />
		<input type="hidden" value="blank" name="type" /> 
		<input type="hidden" value="iframe" name="where" /> 
		大小:最大1.5MB<br />
		支援格式: JPG, JPEG, PNG, GIF, BMP, TIF, TIFF<br />
		<input type="submit" value="按此上傳" class="thickbox">
	</form>
</fieldset>

<fieldset>
	<legend>Imagehost</legend>
	<script>
	function Upload()
	{
		button = document.getElementById("button");
		button.style.fontWeight = "normal";
		button.value = " Uploading... ";
		button.disabled = true;
	}</script>
	<form method="post" action="http://www.imagehost.org/" enctype="multipart/form-data" onsubmit="javascript:Upload(); return true;"> 
		File: <input name="file[]" type="file" size="20" /><br />
		大小: 100 MB<br />
		支援格式: 任何<br />
		<input type="submit" id="button" value="Upload" /> <br />
	</form>	
	<div style="font-size:0.95em;color:#A0A0A0;margin-top:5px;"><small>By uploading a file you agree to our <a href="http://www.imagehost.org/?p=tos" style="color:#808080">Terms of Service</a></div> 
</fieldset>
<fieldset>
	<legend>也可以利用以下服務來上傳檔案</legend>
	<a href="http://www.go2upload.com/">Go2Up</a>
	<a href="http://www.imagehost.org/">ImgHost</a>
	<a href="http://www.freemega.net/">Freemega</a>
	<a href="http://www.funkyimg.com/">FunkyImg</a>
	<a href="http://www.imagebam.com/">Imgbam</a>
	<a href="http://upload.imagefap.com/upload.php">Imgfap</a>
	<a href="http://www.imagerise.com/">Imgrise</a>
	<a href="http://www.imageshack.us/">Imgshack</a>
	<a href="http://www.imagevenue.com/">Imgvenue</a>
	<a href="http://www.imghost.sk/">ImgHost</a>
	<a href="http://www.imagehosting.mafyje.com/">ImgHost</a>
	<a href="http://www.imgup.eu/">Imgup</a>
	<a href="http://www.pic.leech.it/">Pic</a>
	<a href="http://www.pixhost.org/">PixHost</a>
</fieldset>






</body></html>
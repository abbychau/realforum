<?
$form = "<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='2000000'>
<INPUT NAME='imgfile' TYPE='file'>
<input type='submit' name='submit' value='Add Image'>
</form>";

if ($submit) {
dump($_FILES);
$width = 300;
$height = 300;
$res = graphics_resize($width,$height,"TEST","Photos");
if ($res) {
print "<img src='Photos/TEST.jpg'>";
}

} else {
print $form;
}

function graphics_load_jpeg($imgname)
{
debug("Opening file $imgname");

$im = @imagecreatefromjpeg($imgname); /* Attempt to open */

if (!$im) { /* See if it failed */
debug("Failed to open image $imgname");
$im = imagecreate(150, 30); /* Create a blank image */
$bgc = imagecolorallocate($im, 255, 255, 255);
$tc = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
/* Output an errmsg */
imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
}
return $im;
}

function graphics_resize(&$w,&$h,$name,$dir) {
Global $imgfile;

$uploaddir = "$dir/";
$uploadfile = $uploaddir . $_FILES['imgfile']['name'];

if ($_FILES['imgfile']['type'] == 'image/pjpeg' 戌 $_FILES['imgfile']['type'] == 'image/jpeg') {
$srcimg = graphics_load_jpeg($_FILES['imgfile']['tmp_name']);
} else { return 0;}

$dstimg = imageCreate($w,$h);
imageCopyresized($dstimg,$srcimg,0,0,0,0,$w,$h,imagesx($srcimg),imagesy($srcimg));
imageJpeg($dstimg,"$dir/$name.jpg");
imageDestroy($srcimg);
imageDestroy($dstimg);
return 1;
}

function debug($msg) {
print "<pre>$msg</pre>";
}

function dump($var) {
print "<pre>";
print_r($var);
print "</pre>";
}
?> 
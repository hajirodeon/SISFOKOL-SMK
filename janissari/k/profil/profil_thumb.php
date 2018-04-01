<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL JANISSARI                          ///////
/////// (customization)                             ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh :                               ///////
/////// Agus Muhajir, S.Kom                         ///////
/////// URL     :                                   ///////
///////     *http://sisfokol.wordpress.com          ///////
//////      *http://hajirodeon.wordpress.com        ///////
/////// E-Mail  :                                   ///////
///////     * hajirodeon@yahoo.com                  ///////
///////     * hajirodeon@gmail.com                  ///////
/////// HP/SMS  : 081-829-88-54                     ///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////



session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");

nocache;

//nilai
$filenya = "profil_thumb.php";
$judul = "Membuat Thumbnail Profil";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$juduli = $judul;







//query data
$qdt = mysql_query("SELECT DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
						"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
						"DATE_FORMAT(tgl_lahir, '%Y') AS lthn, ".
						"user_blog.* ".
						"FROM user_blog ".
						"WHERE kd_user = '$kd1_session'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_tmp_lahir = balikin($rdt['tmp_lahir']);
$dt_tgl = nosql($rdt['ltgl']);
$dt_bln = nosql($rdt['lbln']);
$dt_thn = nosql($rdt['lthn']);
$dt_foto_path = $rdt['foto_path'];


//nek null foto
if (empty($dt_foto_path))
	{
	$nil_foto = "../../../img/foto_blank.jpg";
	$folder_foto = "../../../img";
	}
else
	{
	//gawe thumbnail
	$nil_foto = "../../../filebox/profil/$kd1_session/$dt_foto_path";
	$folder_foto = "../../../filebox/profil/$kd1_session";
	}




$upload_dir = $folder_foto;
$upload_path = $upload_dir."/";
$large_image_prefix = "resize_";
$thumb_image_prefix = "thumb_";
$large_image_name = $dt_foto_path;
//$thumb_image_name = $thumb_image_prefix.$dt_foto_path.".jpg";
$thumb_image_name = $thumb_image_prefix.$dt_foto_path;
$max_file = "1148576";
$max_width = "500";
$thumb_width = "100";
$thumb_height = "100";


function resizeImage($image,$width,$height,$scale) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,90);
	chmod($image, 0777);
	return $image;
}


function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$thumb_image_name,90);
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}


function getHeight($image) {
	$sizes = getimagesize($image);
	$height = $sizes[1];
	return $height;
}

function getWidth($image) {
	$sizes = getimagesize($image);
	$width = $sizes[0];
	return $width;
}


$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;

if(!is_dir($upload_dir)){
	mkdir($upload_dir, 0777);
	chmod($upload_dir, 0777);
}


if (file_exists($large_image_location)){
	if(file_exists($thumb_image_location)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
	}else{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
   	$large_photo_exists = "";
	$thumb_photo_exists = "";
}


if (isset($_POST["upload_thumbnail"]) && strlen($large_photo_exists)>0) {
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail
	header("location:".$_SERVER["PHP_SELF"]);
	exit();
}


if ($_GET['a']=="delete" && strlen($_GET['t'])>0){
//get the file locations
	$large_image_location = $upload_path.$large_image_prefix.$_GET['t'].".jpg";
	$thumb_image_location = $upload_path.$thumb_image_prefix.$_GET['t'].".jpg";
	if (file_exists($large_image_location)) {
		unlink($large_image_location);
	}
	if (file_exists($thumb_image_location)) {
		unlink($thumb_image_location);
	}
	header("location:".$_SERVER["PHP_SELF"]);
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="generator" content="SISFOKOL" />
	<title>Membuat Thumbnail></title>
	<link href="../../../inc/style/sisfokol.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../../../inc/js/jquery.js"></script>
	<script type="text/javascript" src="../../../inc/js/jquery.imgareaselect.min.js"></script>
</head>
<body>
<?php
$current_large_image_width = getWidth($large_image_location);
$current_large_image_height = getHeight($large_image_location);
?>

<script type="text/javascript">
function preview(img, selection)
	{
	var scaleX = <?php echo $thumb_width;?> / selection.width;
	var scaleY = <?php echo $thumb_height;?> / selection.height;

	$('#thumbnail + div > img').css({
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
	}

	$(document).ready(function ()
		{
		$('#save_thumb').click(function()
			{
			var x1 = $('#x1').val();
			var y1 = $('#y1').val();
			var x2 = $('#x2').val();
			var y2 = $('#y2').val();
			var w = $('#w').val();
			var h = $('#h').val();
			if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h=="")
				{
				alert("Set Terlebih Dahulu...!!");
				return false;
				}
			else
				{
				return true;
				}
			});
	});


	$(window).load(function ()
		{
		$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview });
	});

</script>

<h1><?php $judul;?></h1>
<?php
//Display error message if there are any
if(strlen($error)>0)
	{
	echo "<ul><li><strong>Error!</strong></li><li>".$error."</li></ul>";
	}

if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0)
	{
	echo $large_photo_exists."&nbsp;".$thumb_photo_exists;
	echo "<p>
	[<a href=\"".$_SERVER["PHP_SELF"]."?a=delete&t=".$dt_foto_path."\">Hapus Thumbnail</a>].
	<input name=\"btnKLR\" type=\"button\" value=\"KELUAR\" onClick=\"window.close();\">
	</p>";
	//Clear the time stamp session
	$dt_foto_path= "";
	}
else
	{
	if(strlen($large_photo_exists)>0)
		{
		?>
		<h2><?php echo $judul;?></h2>
		<div align="center">
			<img src="<?php echo $upload_path.$large_image_name;?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />

			<div style="float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
				<img src="<?php echo $upload_path.$large_image_name;?>" style="position: relative;" alt="Thumbnail Preview" />
			</div>

			<br style="clear:both;"/>
			<form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail" value="Simpan Thumbnail" id="save_thumb" />
			</form>
		</div>
		<hr />
		<?php
		}
	}
?>
</body>
</html>

<?php
//diskonek
xclose($koneksi);
exit();
?>
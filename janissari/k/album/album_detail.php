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

//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/class/pagingx.php");
require("../../../inc/class/thumbnail_images.php");
require("../../../inc/class/paging2.php");
$tpl = LoadTpl("../../../template/janissari.html");


nocache;

//nilai
$filenya = "album_detail.php";
$judul = "Detail Album";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$judulx = $judul;
$limit = 5; //batas data per page
$alkd = nosql($_REQUEST['alkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


//focus
$diload = "document.formx.filex.focus();";



//judul album
$qbum = mysql_query("SELECT * FROM user_blog_album ".
						"WHERE kd_user = '$kd1_session' ".
						"AND kd = '$alkd'");
$rbum = mysql_fetch_assoc($qbum);
$bum_judul = balikin($rbum['judul']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$page = nosql($_REQUEST['page']);
	$alkd = nosql($_REQUEST['alkd']);

	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM user_blog_album_filebox ".
					"WHERE kd_album = '$alkd'";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kdx = nosql($_POST["$yuhu"]);

		//file-nya
		$qfle = mysql_query("SELECT * FROM user_blog_album_filebox ".
								"WHERE kd_album = '$alkd' ".
								"AND kd = '$kdx'");
		$rfle = mysql_fetch_assoc($qfle);
		$fle_filex = $rfle['filex'];
		$thumb_filex = "thumb_$fle_filex";

		//hapus file
		$path1 = "../../../filebox/album/$alkd/$fle_filex";
		chmod($path1,0777);
		unlink ($path1);

		//hapus thumbnail
		$path2 = "../../../filebox/album/$alkd/$thumb_filex";
		chmod($path2,0777);
		unlink ($path2);

		//hapus query
		mysql_query("DELETE FROM user_blog_album_filebox ".
						"WHERE kd_album = '$alkd' ".
						"AND kd = '$kdx'");
		}
	while ($data = mysql_fetch_assoc($result));

	//re-direct
	$ke = "$filenya?alkd=$alkd";
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$page = nosql($_REQUEST['page']);
	$alkd = nosql($_REQUEST['alkd']);

	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM user_blog_album_filebox ".
					"WHERE kd_album = '$alkd' ".
					"ORDER BY filex ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;

		$kdi = "kd";
		$kdi2 = "$kdi$i";
		$kdix = nosql($_POST["$kdi2"]);

		$keti = "ket";
		$keti2 = "$keti$i";
		$ketix = cegah($_POST["$keti2"]);

		//update
		mysql_query("UPDATE user_blog_album_filebox SET ket = '$ketix', ".
						"postdate = '$today' ".
						"WHERE kd_album = '$alkd' ".
						"AND kd = '$kdix'");
		}
	while ($data = mysql_fetch_assoc($result));

	//re-direct
	$ke = "$filenya?alkd=$alkd&page=$page";
	xloc($ke);
	exit();
	}





//upload image
if ($_POST['btnUPL'])
	{
	//ambil nilai
	$alkd = nosql($_POST['alkd']);
	$filex_namex = strip(strtolower($_FILES['filex']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$ke = "$filenya?alkd=$alkd";
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".jpg")
			{
			//nilai
			$filex1 = "../../../filebox/album/$alkd/$filex_namex";
			$path1 = "../../../filebox/album/$alkd";
			$path2 = "../../../filebox/album/$alkd/$filex_namex";
			chmod($path1,0777);
			chmod($path2,0777);

			//cek, sudah ada belum
			if (!file_exists($filex1))
				{
				//mengkopi file
				move_uploaded_file($_FILES['filex']['tmp_name'],"../../../filebox/album/$alkd/$filex_namex");

				//query
				mysql_query("INSERT INTO user_blog_album_filebox(kd, kd_album, filex) VALUES ".
								"('$x', '$alkd', '$filex_namex')");

				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?alkd=$alkd";
				xloc($ke);
				exit();
				}
			else
				{
				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?alkd=$alkd";
				$pesan = "File : $filex_namex, Sudah Ada. Ganti Yang Lain...!!";
				pekem($pesan,$ke);
				exit();
				}
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$ke = "$filenya?alkd=$alkd";
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();


//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/js/checkall.js");
require("../../../inc/menu/janissari.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#FDF0DE" valign="top">
<td>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td>';

xheadline($judul);
echo ' (<a href="album.php" title="Daftar Album">Daftar Album</a>)</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
Judul Album :
<br>
<font color="'.$warnaheader.'"><strong>'.$bum_judul.'</strong></font>
[<a href="album.php?s=edit&alkd='.$alkd.'" title="Edit">EDIT</a>]
<br>
<br>

<input name="filex" type="file" size="30">
<input name="alkd" type="hidden" value="'.$alkd.'">
<input name="btnUPL" type="submit" value="UPLOAD">
</td>
</tr>
</table>
<br>';

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM user_blog_album_filebox ".
				"WHERE kd_album = '$alkd' ".
				"ORDER BY filex ASC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?alkd=$alkd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//nek ada
if ($count != 0)
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
    	<tr bgcolor="'.$warnaheader.'">
	<td width="50%">
	<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	<input type="submit" name="btnSMP" value="SIMPAN">
	</td>
	<td align="right">
	<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
	</td>
    	</tr>
	</table>

	<table width="100%" border="1" cellpadding="3" cellspacing="0">';

	do
  		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}

		$nomer = $nomer + 1;
		$kd = nosql($data['kd']);
		$y_filex = balikin($data['filex']);
		$y_ket = balikin($data['ket']);

		//jml komentar
		$qjko = mysql_query("SELECT * FROM user_blog_album_msg ".
								"WHERE kd_user_blog_album = '$kd'");
		$rjko = mysql_fetch_assoc($qjko);
		$tjko = mysql_num_rows($qjko);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td width="1" valign="top">
		<input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
		<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
		</td>
		<td align="center" width="100" valign="top">';

		//gawe thumnail
		$obj_img2 = new thumbnail_images();
		$obj_img2->PathImgOld = "$sumber/filebox/album/$alkd/$y_filex";
		$obj_img2->PathImgNew = "../../../filebox/album/$alkd/thumb_$y_filex";
		$obj_img2->NewWidth = 200;
		if (!$obj_img2->create_thumbnail_images())
			{
			echo '<font color="red"><strong>Gagal Membuat Thumbnail...!</strong></font>';
			}
		else
			{
			echo '<a href="album_detail_view.php?alkd='.$alkd.'&fkd='.$kd.'" title="'.$y_filex.'"><img src="'.$obj_img2->PathImgNew.'" width="200" border="1"></a>';
			}


		echo '</td>
		<td valign="top">
		Nama File :
		<br>
		<strong>'.$y_filex.'</strong>
		<br>
		<br>

		Keterangan :
		<br>
		<textarea name="ket'.$nomer.'" cols="60" rows="5" wrap="virtual">'.$y_ket.'</textarea>

		<p>
		[<font color="red"><strong>'.$tjko.'</strong></font> Komentar].
		[<a href="album_detail_view.php?alkd='.$alkd.'&fkd='.$kd.'" title="'.$y_filex.'">Beri Komentar</a>].
		</p>
		</td>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
    	<tr bgcolor="'.$warnaheader.'">
	<td width="50%">
	<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	<input type="submit" name="btnSMP" value="SIMPAN">
	<input name="page" type="hidden" value="'.$page.'">
	</td>
	<td align="right">
	<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
	</td>
    	</tr>
	</table>';
	}
else
	{
	echo '<font color="red"><strong>TIDAK ADA FOTO. Silahkan Entry Dahulu...!!</strong></font>';
	}


echo '<br>
<br>
<br>
</td>
<td width="1%">
</td>

<td width="1%">';

//ambil sisi
require("../../../inc/menu/k_sisi.php");

echo '<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
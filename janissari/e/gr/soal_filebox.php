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




//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
$tpl = LoadTpl("../../../template/window.html");


nocache;

//nilai
$filenya = "soal_filebox.php";
$judul = "FileBox Image & Video :";
$judulku = $judul;
$juduly = $judul;
$s = nosql($_REQUEST['s']);
$katkd = nosql($_REQUEST['katkd']);
$solkd = nosql($_REQUEST['solkd']);
$filekd = nosql($_REQUEST['filekd']);
$ke = "$filenya?katkd=$katkd&solkd=$solkd";


//focus....focus...
$diload = "document.formx.filex.focus();";







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//hapus
if ($s == "hapus")
	{
	//nilai
	$katkd = nosql($_REQUEST['katkd']);
	$solkd = nosql($_REQUEST['solkd']);
	$filekd = nosql($_REQUEST['filekd']);

	//query
	$qcc = mysql_query("SELECT * FROM guru_mapel_soal_filebox ".
				"WHERE kd_guru_mapel_soal = '$katkd' ".
				"AND kd_guru_mapel_soal_detail = '$solkd' ".
				"AND kd = '$filekd'");
	$rcc = mysql_fetch_assoc($qcc);

	//hapus file
	$cc_filex = $rcc['filex'];
	$path1 = "../../../filebox/e/soal/$katkd/$solkd/$cc_filex";
	chmod($path1,0777);
	unlink ($path1);

	//hapus query
	mysql_query("DELETE FROM guru_mapel_soal_filebox ".
			"WHERE kd_guru_mapel_soal = '$katkd' ".
			"AND kd_guru_mapel_soal_detail = '$solkd' ".
			"AND kd = '$filekd'");

	//null-kan
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}





//upload image
if ($_POST['btnUPL'])
	{
	//ambil nilai
	$katkd = nosql($_POST['katkd']);
	$solkd = nosql($_POST['solkd']);
	$filex_namex = strip(strtolower($_FILES['filex']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//nilai
		$filex1 = "../../../filebox/e/soal/$katkd/$solkd/$filex_namex";
		$filex2 = "../../../filebox/e/soal/$katkd/$solkd";
		chmod($filex2,0777);

		//cek, sudah ada belum
		if (!file_exists($filex1))
			{
			//mengkopi file
			copy($_FILES['filex']['tmp_name'],"../../../filebox/e/soal/$katkd/$solkd/$filex_namex");

			//query
			mysql_query("INSERT INTO guru_mapel_soal_filebox(kd, kd_guru_mapel_soal, kd_guru_mapel_soal_detail, filex) VALUES ".
					"('$solkd', '$katkd', '$solkd', '$filex_namex')");

			//null-kan
			xclose($koneksi);

			//re-direct
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//re-direct
			$pesan = "File : $filex_namex, Sudah Ada. Ganti Yang Lain...!!";
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



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="'.$e_warnaover.'" width="100%" border="0" cellpadding="3" cellspacing="0">
<tr>
<td>';

xheadline($judul);
echo '<br>
<input name="filex" type="file" size="30">
<input name="katkd" type="hidden" value="'.$katkd.'">
<input name="solkd" type="hidden" value="'.$solkd.'">
<input name="btnUPL" type="submit" value="UPLOAD">
</td>
</tr>
</table>

<table bgcolor="'.$e_warna02.'" width="100%" height="150" border="0" cellpadding="3" cellspacing="0">
<tr valign="top">
<td>';

//koleksi file
$qfle = mysql_query("SELECT * FROM guru_mapel_soal_filebox ".
						"WHERE kd_guru_mapel_soal = '$katkd' ".
						"AND kd_guru_mapel_soal_detail = '$solkd' ".
						"ORDER BY filex ASC");
$rfle = mysql_fetch_assoc($qfle);
$tfle = mysql_num_rows($qfle);

//nek gak null
if ($tfle != 0)
	{
	do
		{
		//nilai
		$nomer = $nomer + 1;
		$fle_kd = nosql($rfle['kd']);
		$fle_filex = $rfle['filex'];

		echo '* <input name="filex'.$nomer.'" type="text" value="'.$sumber.'/filebox/e/soal/'.$katkd.'/'.$solkd.'/'.$fle_filex.'" size="75" readonly="true">';
		echo '  [<a href="'.$ke.'&s=hapus&filekd='.$fle_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>]';
		echo '<br><br>';
		}
	while ($rfle = mysql_fetch_assoc($qfle));
	}

echo '</td>
</tr>
</table>

<table bgcolor="'.$e_warnaheader.'" width="100%" border="0" cellpadding="3" cellspacing="0">
<tr>
<td>
<input name="btnKLR" type="button" value="KELUAR" onClick="window.close();">
</td>
</tr>
</table>
<br><br><br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>
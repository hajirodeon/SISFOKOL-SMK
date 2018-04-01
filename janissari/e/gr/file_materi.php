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
require("../../../inc/cek/e_gr.php");
require("../../../inc/class/paging.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$gmkd = nosql($_REQUEST['gmkd']);
$filenya = "file_materi.php?gmkd=$gmkd";


//focus
$diload = "document.formx.ket.focus();";



//PROSES /////////////////////////////////////////////////////////////////////////////////////////////////
//hapus
if ($s == "hapus")
	{
	//nilai
	$filekd = nosql($_REQUEST['filekd']);
	$gmkd = nosql($_REQUEST['gmkd']);

	//query
	$qcc = mysql_query("SELECT * FROM guru_mapel_file_materi ".
							"WHERE kd_guru_mapel = '$gmkd' ".
							"AND kd = '$filekd'");
	$rcc = mysql_fetch_assoc($qcc);

	//hapus file
	$cc_filex = $rcc['filex'];
	$path1 = "../../../filebox/e/materi/$gmkd/$filekd/$cc_filex";
	chmod($path1,0777);
	unlink ($path1);

	//hapus query
	mysql_query("DELETE FROM guru_mapel_file_materi ".
					"WHERE kd_guru_mapel = '$gmkd' ".
					"AND kd = '$filekd'");

	//null-kan
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}





//upload image
if ($_POST['btnUPL'])
	{
	//ambil nilai
	$ket = cegah($_POST['ket']);
	$filex_namex = strip(strtolower($_FILES['filex']['name']));
	$filesize = 1;


	//nek null
	if ((empty($ket)) OR (empty($filex_namex)))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//nilai folder //////////////////////////////////////////////////////////////
		$path1 = "../../../filebox/e/materi/$gmkd";
		chmod($path1,0777);

		//cek, sudah ada belum folder-nya...
		if (!file_exists($path1))
			{
			mkdir("$path1", $chmod);
			}


		//nilai folder //////////////////////////////////////////////////////////////
		$path2 = "../../../filebox/e/materi/$gmkd/$x";

		//cek, sudah ada belum folder-nya...
		if (!file_exists($path2))
			{
			mkdir("$path2", $chmod);
			}


		chmod($path2,0777);

		//nilai file-nya...
		$filex1 = "../../../filebox/e/materi/$gmkd/$x/$filex_namex";

		//cek, sudah ada belum
		if (!file_exists($filex1))
			{
			//mengkopi file
			copy($_FILES['filex']['tmp_name'],"../../../filebox/e/materi/$gmkd/$x/$filex_namex");

			//query
			mysql_query("INSERT INTO guru_mapel_file_materi(kd, kd_guru_mapel, ket, filex, postdate) VALUES ".
							"('$x', '$gmkd', '$ket', '$filex_namex', '$today')");

			//null-kan
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//re-direct
			$pesan = "File : $filex_namex, Sudah Ada. Ganti Yang Lain...!!";
			pekem($pesan,$filenya);
			exit();
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");


//view : guru ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika belum pilih mapel
if (empty($gmkd))
	{
	//re-direct
	$ke = "mapel.php";
	xloc($ke);
	exit();
	}

//nek mapel telah dipilih
else
	{
	//mapel-nya...
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.* ".
							"FROM guru_mapel, m_mapel ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);

	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "file_materi.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> File Materi";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td>
		<p>
		<big><strong>:::File Materi...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>


		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		Keterangan :
		<br><input name="ket" type="text" size="50">
		<br>
		File : <input name="filex" type="file" size="30">
		<input name="gmkd" type="hidden" value="'.$gmkd.'">
		<input name="btnUPL" type="submit" value="SIMPAN & UPLOAD">
		</td>
		</tr>
		</table>
		<br>';

		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM guru_mapel_file_materi ".
						"WHERE kd_guru_mapel = '$gmkd' ".
						"ORDER BY postdate DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = $filenya;
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);

		//nek gak null
		if ($count != 0)
			{
			echo '<table width="950" border="0" cellpadding="3" cellspacing="0">
			<tr valign="top">
			<td>
			<UL>';

			do
				{
				//nilai
				$nomer = $nomer + 1;
				$fle_kd = nosql($data['kd']);
				$fle_ket = balikin($data['ket']);
				$fle_filex = $data['filex'];
				$fle_postdate = $data['postdate'];
				$file_path = "../../../filebox/e/materi/$gmkd/$fle_kd/$fle_filex";

				echo '<LI> <em>'.$fle_ket.'</em>
				<br>
				FileName : <strong>'.$fle_filex.'</strong>
				<br>
				FileSize : <strong>'.my_filesize($file_path).'</strong>
				<br>
				PostDate : <strong>'.$fle_postdate.'</strong>
				<br>
				[<a href="'.$file_path.'" title="Download" target="_blank">Download</a>].
				[<a href="'.$filenya.'&s=hapus&filekd='.$fle_kd.'" title="Hapus"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
				</LI>
				<br><br>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</UL>
			</td>
			</tr>
			</table>
			<table width="950" border="0" cellpadding="3" cellspacing="0">
			<tr valign="top">
			<td>
			<hr>
			<strong><font color="blue">'.$count.'</font></strong> Data '.$pagelist.'
			<hr>
			</td>
			</tr>
			</table>';
			}

		//gak ada data
		else
			{
			echo '<strong><font color="blue">Belum Ada File Materi. Silahkan Entry Dulu...!!</font></strong>';
			}
		}

	//jika tidak
	else
		{
		//re-direct
		$pesan = "Silahkan Lihat Daftar Mata Pelajaran.";
		$ke = "mapel.php";
		pekem($pesan,$ke);
		exit();
		}
	}
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
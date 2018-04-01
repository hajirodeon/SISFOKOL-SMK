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
$grsw = nosql($_REQUEST['grsw']);
$filenya = "file_materi.php?gmkd=$gmkd";






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
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.*, m_user.* ".
							"FROM guru_mapel, m_mapel, m_user ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = m_user.kd ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);
	$pel_usnm = balikin($rpel['nama']);

	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "file_materi.php?gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm] --> File Materi";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e_grsw.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td>
		<p>
		<big><strong>:::File Materi...</strong></big>
		</p>
		</td>
  		</tr>
		</table>';

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
			echo '<strong><font color="blue">Belum Ada File Materi.</font></strong>';
			}

		echo '<br><br><br>
		</td>
		</tr>
		</table>';
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
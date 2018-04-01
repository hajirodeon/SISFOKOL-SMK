<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v4.0_(NyurungBAN)                          ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS	: 081-829-88-54                                 ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////






session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_sw.php");
require("../../../inc/class/paging.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$gmkd = nosql($_REQUEST['gmkd']);
$tankd = nosql($_REQUEST['tankd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$filenya = "tanya.php?gmkd=$gmkd&page=$page";



//focus
$diload = "document.formx.tanya.focus();";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($s == "hapus")
	{
	//nilai
	$tkd = nosql($_REQUEST['tkd']);
	$gmkd = nosql($_REQUEST['gmkd']);

	//hapus
	mysql_query("DELETE FROM guru_mapel_tanya ".
					"WHERE kd_guru_mapel = '$gmkd' ".
					"AND kd = '$tkd'");

	//re-direct
	$ke = "tanya.php?gmkd=$gmkd";
	xloc($ke);
	exit();
	}





//nek simpan tanya
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_REQUEST['s']);
	$gmkd = nosql($_REQUEST['gmkd']);
	$tanya = cegah($_REQUEST['tanya']);

	//cek
	if (empty($tanya))
		{
		//re-direct
		$pesan = "Input Pertanyaan Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "tanya.php?gmkd=$gmkd&s=tanya";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//insert
		mysql_query("INSERT INTO guru_mapel_tanya(kd, kd_guru_mapel, dari, tanya, postdate) VALUES ".
						"('$x', '$gmkd', '$kd1_session', '$tanya', '$today')");

		//re-direct
		$ke = "tanya.php?gmkd=$gmkd";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
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
		$filenya = "tanya.php?gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm] --> Tanya";
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
    		<td width="100">
		<p>
		<big><strong>:::Tanya...</strong></big>
		(<a href="'.$filenya.'&s=tanya" title="Tanya / Konsultasi">Tulis Tanya/Konsultasi</a>)
		</p>
		</td>
  		</tr>
		</table>';


		//jika jawab
		if ($s == "tanya")
			{
			echo '<strong>Pertanyaan / Konsultasi :</strong>
			<br>
			<textarea name="tanya" cols="75" rows="10" wrap="virtual"></textarea>
			<br>
			<input name="gmkd" type="hidden" value="'.$gmkd.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}

		//jika daftar tanya
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT guru_mapel.*, guru_mapel_tanya.* ".
							"FROM guru_mapel, guru_mapel_tanya ".
							"WHERE guru_mapel_tanya.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd = '$gmkd' ".
							"AND guru_mapel_tanya.dari = '$kd1_session' ".
							"ORDER BY guru_mapel_tanya.postdate DESC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = $filenya;
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//nek ada
			if ($count != 0)
				{
				echo '<table width="950" border="0" cellpadding="3" cellspacing="0">';

				do
			  		{
					$nomer = $nomer + 1;

					$d_kd = nosql($data['kd']);
					$d_tanya = balikin($data['tanya']);
					$d_jawaban = balikin($data['jawaban']);
					$d_postdate = $data['postdate'];

					//jika null
					if (empty($d_jawaban))
						{
						$d_jawaban = "-";
						}


					echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
					<p>
					<strong>'.$d_tanya.'</strong>
					<br>

					Jawaban :
					<br>
					<em>'.$d_jawaban.'</em>
					<br>
					<br>

					<em>[Postdate : '.$d_postdate.'].</em>
					[<a href="'.$filenya.'&s=hapus&tkd='.$d_kd.'" title="Hapus..."><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>]
					</p>
					</td>
					</tr>';
			  		}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="950" border="0" cellspacing="0" cellpadding="3">
			    	<tr>
				<td align="right">
				<hr>
				<font color="blue"><strong>'.$count.'</strong></font> Data '.$pagelist.'
				<hr>
				</td>
			    	</tr>
				</table>';
				}
			else
				{
				echo '<font color="blue"><strong>Belum Ada Data Pertanyaan. Silahkan Bertanya / Konsultasi. . .</strong></font>';
				}
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
xclose($koneksi);
exit();
?>
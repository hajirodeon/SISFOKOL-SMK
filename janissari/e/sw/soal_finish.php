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
require("../../../inc/cek/e_sw.php");
require("../../../inc/class/paging.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$gmkd = nosql($_REQUEST['gmkd']);
$katkd = nosql($_REQUEST['katkd']);
$s = nosql($_REQUEST['s']);
$filenya = "soal_finish.php?gmkd=$gmkd&katkd=$katkd";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika usai
if ($s == "selesai")
	{
	//update
	mysql_query("UPDATE siswa_mapel_soal ".
					"SET waktu_akhir = '$today' ".
					"WHERE kd_user = '$kd1_session' ".
					"AND kd_guru_mapel = '$gmkd' ".
					"AND kd_guru_mapel_soal = '$katkd'");

	//re-direct
	xloc($filenya);
	exit();
	}





//jika lagi... pelajaran yang sama
if ($_POST['btnLGI'])
	{
	//ambil nilai
	$gmkd = nosql($_POST['gmkd']);
	$katkd = nosql($_POST['katkd']);

	//kosongkan session rimer
	$_SESSION['x_sesi'] = "";


	//kosongkan pengerjaan yang telah ada
	mysql_query("DELETE FROM siswa_mapel_soal ".
					"WHERE kd_user = '$kd1_session' ".
					"AND kd_guru_mapel = '$gmkd' ".
					"AND kd_guru_mapel_soal = '$katkd'");

	mysql_query("DELETE FROM siswa_mapel_soal_detail ".
					"WHERE kd_user = '$kd1_session' ".
					"AND kd_guru_mapel = '$gmkd' ".
					"AND kd_guru_mapel_soal = '$katkd'");

	//re-direct
	$ke = "soal.php?s=baru&gmkd=$gmkd&katkd=$katkd";
	xloc($ke);
	exit();
	}





//kerjakan topik lain
if ($_POST['btnPEL'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);

	//kosongkan session rimer
	$_SESSION['x_sesi'] = "";

	//re-direct
	$ke = "soal.php?s=detail&gmkd=$gmkd";
	xloc($ke);
	exit();
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
		$filenya = "soal_finish.php?gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm] --> Ujian Selesai";
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
		<big><strong>:::Soal...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>';

		//rincian ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//topik/bab
		$qmpx = mysql_query("SELECT * FROM guru_mapel_soal ".
								"WHERE kd_guru_mapel = '$gmkd'");
		$rowmpx = mysql_fetch_assoc($qmpx);
		$mpx_kd = nosql($rowmpx['kd']);
		$mpx_judul = balikin($rowmpx['judul']);
		$mpx_bobot = nosql($rowmpx['bobot']);
		$mpx_menit = nosql($rowmpx['waktu']);


		//soal
		$qsol = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
								"WHERE kd_guru_mapel_soal = '$katkd'");
		$rsol = mysql_fetch_assoc($qsol);
		$tsol = mysql_num_rows($qsol);


		//soal yang dikerjakan
		$qsyd = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
								"WHERE kd_user = '$kd1_session' ".
								"AND kd_guru_mapel = '$gmkd' ".
								"AND kd_guru_mapel_soal = '$katkd'");
		$rsyd = mysql_fetch_assoc($qsyd);
		$tsyd = mysql_num_rows($qsyd);


		//jml. jawaban BENAR
		$qju = mysql_query("SELECT siswa_mapel_soal_detail.*, guru_mapel_soal_detail.* ".
								"FROM siswa_mapel_soal_detail, guru_mapel_soal_detail ".
								"WHERE siswa_mapel_soal_detail.kd_guru_mapel_soal_detail = guru_mapel_soal_detail.kd ".
								"AND siswa_mapel_soal_detail.kd_user = '$kd1_session' ".
								"AND siswa_mapel_soal_detail.kd_guru_mapel = '$gmkd' ".
								"AND siswa_mapel_soal_detail.kd_guru_mapel_soal = '$katkd' ".
								"AND siswa_mapel_soal_detail.jawab = guru_mapel_soal_detail.kunci");
		$rju = mysql_fetch_assoc($qju);
		$tju = mysql_num_rows($qju);


		//jml. jawaban SALAH
		$tsalah = round($tsyd - $tju);

		//waktu mulai dan akhir
		$qjux = mysql_query("SELECT * FROM siswa_mapel_soal ".
								"WHERE kd_user = '$kd1_session' ".
								"AND kd_guru_mapel = '$gmkd' ".
								"AND kd_guru_mapel_soal = '$katkd'");
		$rjux = mysql_fetch_assoc($qjux);
		$wk_mulai = $rjux['waktu_mulai'];
		$wk_akhir = $rjux['waktu_akhir'];


		//skor
		$total_skor = round($tju*$mpx_bobot);

		echo 'Judul/Topik/Bab : <strong>'.$mpx_judul.'.</strong>
		<br>

		Bobot Soal : <strong>'.$mpx_bobot.'.</strong>
		<br>

		Batas Waktu Pengerjaan : <strong>'.$mpx_menit.' Menit.</strong>
		<br>

		Jumlah Soal : <strong>'.$tsol.'.</strong>
		<br>
		<br>

		Waktu Mulai Pengerjaan : <strong>'.$wk_mulai.'</strong>
		<br>

		Waktu Selesai Pengerjaan : <strong>'.$wk_akhir.'</strong>
		<br>

		Jumlah Soal yang Dikerjakan : <strong>'.$tsyd.'.</strong>
		<br>

		Jumlah Jawaban Benar : <strong>'.$tju.'.</strong>
		<br>

		Jumlah Jawaban Salah : <strong>'.$tsalah.'.</strong>
		<br>
		<br>

		Total Skor : <strong>'.$total_skor.'.</strong>
		<br>
		<br>
		<br>

		Report Jawaban [<a href="soal_finish_pdf.php?swkd='.$kd1_session.'&gmkd='.$gmkd.'&katkd='.$katkd.'" target="_blank"><img src="'.$sumber.'/img/pdf.gif" width="16" height="16" border="0"></a>].
		<br>
		<br>
		<input name="gmkd" type="hidden" value="'.$gmkd.'">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="btnLGI" type="submit" value="Kerjakan Lagi">
		<input name="btnPEL" type="submit" value="Ujian Judul/Topik/Bab Lain">

		<br><br><br>';
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
<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v5.0_(PernahJaya)                          ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://omahbiasawae.com/                          ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsw.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "pelanggaran.php";
$judul = "Data Pelanggaran";
$judulku = "[$siswa_session : $nis2_session.$nm2_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?page=$page";












//isi *START
ob_start();

//menu
require("../../inc/menu/admsw.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">';

//daftar
$qdata = mysql_query("SELECT m_bk_point.*, siswa_pelanggaran.*, ".
			"DATE_FORMAT(siswa_pelanggaran.tgl, '%d') AS utgl, ".
			"DATE_FORMAT(siswa_pelanggaran.tgl, '%m') AS ubln,  ".
			"DATE_FORMAT(siswa_pelanggaran.tgl, '%Y') AS uthn ".
			"FROM m_bk_point, siswa_pelanggaran ".
			"WHERE siswa_pelanggaran.kd_point = m_bk_point.kd ".
			"AND siswa_pelanggaran.kd_siswa = '$kd2_session'");
$rdata = mysql_fetch_assoc($qdata);
$tdata = mysql_num_rows($qdata);


//jika ada
if ($tdata != 0)
	{
	echo '<p>
	<table width="980" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Tanggal</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Data Pelanggaran</font></strong></td>
	</tr>';

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

		//nilai
		$dt_utgl = nosql($rdata['utgl']);
		$dt_ubln = nosql($rdata['ubln']);
		$dt_uthn = nosql($rdata['uthn']);
		$dt_no = nosql($rdata['no']);
		$dt_nama = balikin($rdata['nama']);
		$dt_point = nosql($rdata['point']);
		$dt_sanksi = balikin($rdata['sanksi']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">
		<td valign=\"top\">
		$nomer.
		</td>
		<td valign=\"top\">
		<strong>$dt_utgl/$dt_ubln/$dt_uthn</strong>
		</td>
		<td>
		$dt_nama. [<strong>Point:$dt_point</strong>].
		<br>
		<em>$dt_sanksi</em>
		<hr>
		</td>
		</tr>";
		}
	while ($rdata = mysql_fetch_assoc($qdata));

	echo '</table>
	</p>';




	//jml.skor
	$qkorx = mysql_query("SELECT SUM(m_bk_point.point) AS pot ".
				"FROM siswa_pelanggaran, m_bk_point ".
				"WHERE siswa_pelanggaran.kd_point = m_bk_point.kd ".
				"AND siswa_pelanggaran.kd_siswa = '$kd2_session'");
	$rkorx = mysql_fetch_assoc($qkorx);
	$rkox_pot = nosql($rkorx['pot']);



	//jika empty
	if (empty($rkox_pot))
		{
		$i_ket = "";
		}

	//jika <= 20
	else if ($rkox_pot <= 20)
		{
		$i_ket = "Dibina oleh Wali Kelas / Konselor Sekolah / orang tua atau wali murid.";
		}

	else if (($rkox_pot >= 21) AND ($rkox_pot <= 30))
		{
		$i_ket = "Dibina oleh Wali Kelas / Konselor Sekolah / orang tua atau wali murid.";
		}

	else if (($rkox_pot >= 31) AND ($rkox_pot <= 50))
		{
		$i_ket = "Dibina oleh Wali Kelas / Konselor Sekolah / Waka Kesiswaan, orang tua atau wali murid.";
		}

	else if (($rkox_pot >= 51) AND ($rkox_pot <= 65))
		{
		$i_ket = "Dibina oleh Wali Kelas / Konselor Sekolah / Kesiswaan dengan peringatan keras I / orang tua atau wali murid.";
		}

	else if (($rkox_pot >= 66) AND ($rkox_pot <= 85))
		{
		$i_ket = "Dibina oleh Wali Kelas / Konselor Sekolah / Kesiswaan dengan peringatan keras II / orang tua atau wali murid.";
		}

	else if (($rkox_pot >= 86) AND ($rkox_pot <= 99))
		{
		$i_ket = "<strong>Dibina oleh Wali Kelas / Konselor Sekolah / Kesiswaan dengan peringatan keras III / orang tua atau wali murid</strong>.";
		}

	else if ($rkox_pot >= 100)
		{
		$i_ket = "<strong>Dikeluarkan / dikembalikan kepada orang tua atau wali murid</strong>.";
		}

	echo "<p>
	Total Skor : <strong>$rkox_pot</strong>
	</p>
	<p>
	[<font color=\"blue\">$i_ket</font>]
	</p>";
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>BELUM ADA DATA PELANGGARAN</strong>.
	</font>
	</p>';
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
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
require("../../inc/cek/admortu.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "prestasi.php";
$judul = "Data Prestasi";
$judulku = "[$ortu_session : $nis21_session.$nm21_session] ==> $judul";
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
require("../../inc/menu/admortu.php");

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
$qdata = mysql_query("SELECT m_bk_prestasi.*, siswa_prestasi.*, ".
			"DATE_FORMAT(siswa_prestasi.tgl, '%d') AS utgl, ".
			"DATE_FORMAT(siswa_prestasi.tgl, '%m') AS ubln,  ".
			"DATE_FORMAT(siswa_prestasi.tgl, '%Y') AS uthn ".
			"FROM m_bk_prestasi, siswa_prestasi ".
			"WHERE siswa_prestasi.kd_prestasi = m_bk_prestasi.kd ".
			"AND siswa_prestasi.kd_siswa = '$kd21_session'");
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
	<td><strong><font color="'.$warnatext.'">Data Prestasi</font></strong></td>
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

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">
		<td valign=\"top\">
		$nomer.
		</td>
		<td valign=\"top\">
		<strong>$dt_utgl/$dt_ubln/$dt_uthn</strong>
		</td>
		<td>
		$dt_nama. [<strong>Point:$dt_point</strong>].
		<hr>
		</td>
		</tr>";
		}
	while ($rdata = mysql_fetch_assoc($qdata));

	echo '</table>
	</p>';




	//jml.skor
	$qkorx = mysql_query("SELECT SUM(m_bk_prestasi.point) AS pot ".
				"FROM siswa_prestasi, m_bk_prestasi ".
				"WHERE siswa_prestasi.kd_prestasi = m_bk_prestasi.kd ".
				"AND siswa_prestasi.kd_siswa = '$kd21_session'");
	$rkorx = mysql_fetch_assoc($qkorx);
	$rkox_pot = nosql($rkorx['pot']);



	echo "<p>
	Total Skor : <strong>$rkox_pot</strong>
	</p>";
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>BELUM ADA DATA PRESTASI</strong>.
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
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
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/window.html");


nocache;

//nilai
$filenya = "siswa_harian_lain_prt.php";
$jnskd = nosql($_REQUEST['jnskd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);


//keuangan lain
$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
			"WHERE kd = '$jnskd'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_nama = balikin($rdt['nama']);


//judul
$judul = "Laporan Harian : $dt_nama";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa_harian_lain.php?jnskd=$jnskd&tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln&utgl=$utgl";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top" align="center">
<td>

<p>
<big>
<strong>LAPORAN HARIAN</strong>
</big>
</p>

<p>
<big>
<strong>PEMBAYARAN '.strtoupper($dt_nama).'</strong>
</big>
</p>

<p>
<big>
<strong>'.$sek_nama.'</strong>
</big>
</p>

</td>
</tr>
<table>
<br>
<br>

Hari, Tanggal : <strong>'.$arrhari[$hari].', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>';



//query
$qcc = mysql_query("SELECT DISTINCT(siswa_uang_lain.kd_siswa) AS swkd, ".
			"m_siswa.*, m_uang_lain.* ".
			"FROM siswa_uang_lain, m_siswa, m_uang_lain ".
			"WHERE siswa_uang_lain.kd_siswa = m_siswa.kd ".
			"AND siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
			"AND m_uang_lain.kd_jenis = '$jnskd' ".
			"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
			"AND siswa_uang_lain.nilai <> '' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%d')) = '$utgl' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%m')) = '$ubln' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%Y')) = '$uthn' ".
			"ORDER BY round(m_siswa.nis) ASC");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);


echo '<br>
<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="10"><strong><font color="'.$warnatext.'">No.</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Kelas</font></strong></td>
<td width="10" align="center"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
<td width="200" align="center"><strong><font color="'.$warnatext.'">Nominal</font></strong></td>
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

	$i_nomer = $i_nomer + 1;
	$i_swkd = nosql($rcc['swkd']);
	$i_nis = nosql($rcc['nis']);
	$i_nama = balikin($rcc['nama']);


	//jumlah bayar lain
	$qjmx = mysql_query("SELECT * FROM siswa_uang_lain, m_uang_lain ".
				"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
				"AND m_uang_lain.kd_jenis = '$jnskd' ".
				"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
				"AND siswa_uang_lain.nilai <> '' ".
				"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%d')) = '$utgl' ".
				"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%Y')) = '$uthn' ".
				"AND siswa_uang_lain.kd_siswa = '$i_swkd'");
	$rjmx = mysql_fetch_assoc($qjmx);
	$tjmx = mysql_num_rows($qjmx);


	//ketahui jumlah uang lain-nya...
	$qjmx1 = mysql_query("SELECT SUM(siswa_uang_lain.nilai) AS total ".
				"FROM siswa_uang_lain, m_uang_lain ".
				"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
				"AND m_uang_lain.kd_jenis = '$jnskd' ".
				"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
				"AND siswa_uang_lain.nilai <> '' ".
				"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%d')) = '$utgl' ".
				"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%Y')) = '$uthn' ".
				"AND siswa_uang_lain.kd_siswa = '$i_swkd'");
	$rjmx1 = mysql_fetch_assoc($qjmx1);
	$tjmx1 = mysql_num_rows($qjmx1);
	$jmx1_total = nosql($rjmx1['total']);




	//ruang kelas
	$qnily = mysql_query("SELECT m_uang_lain.*, siswa_kelas.* ".
				"FROM m_uang_lain, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = m_uang_lain.kd_tapel ".
				"AND siswa_kelas.kd_kelas = m_uang_lain.kd_kelas ".
				"AND m_uang_lain.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_siswa = '$i_swkd'");
	$rnily = mysql_fetch_assoc($qnily);
	$tnily = mysql_num_rows($qnily);
	$nily_kelkd = nosql($rnily['kd_kelas']);



	//kelasnya...
	$qkel = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$nily_kelkd'");
	$rkel = mysql_fetch_assoc($qkel);
	$kel_kelas = balikin($rkel['kelas']);



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$i_nomer.'</td>
	<td>'.$i_nis.'</td>
	<td>'.$i_nama.'</td>
	<td>'.$kel_kelas.'</td>
	<td align="right">'.$tjmx.'</td>
	<td align="right">'.xduit2($jmx1_total).'</td>
   	</tr>';
	}
while ($rcc = mysql_fetch_assoc($qcc));


//jumlah bayar lain
$qjmx = mysql_query("SELECT * FROM siswa_uang_lain, m_uang_lain ".
			"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
			"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
			"AND siswa_uang_lain.nilai <> '' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%d')) = '$utgl' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%m')) = '$ubln' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%Y')) = '$uthn'");
$rjmx = mysql_fetch_assoc($qjmx);
$tjmx = mysql_num_rows($qjmx);


//ketahui jumlah uang lain-nya...
$qjmx1 = mysql_query("SELECT SUM(siswa_uang_lain.nilai) AS total ".
			"FROM siswa_uang_lain, m_uang_lain ".
			"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
			"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
			"AND siswa_uang_lain.nilai <> '' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%d')) = '$utgl' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%m')) = '$ubln' ".
			"AND round(DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%Y')) = '$uthn'");
$rjmx1 = mysql_fetch_assoc($qjmx1);
$tjmx1 = mysql_num_rows($qjmx1);
$jmx1_total = nosql($rjmx1['total']);




echo '<tr bgcolor="'.$warnaover.'">
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="right"><strong>'.$tjmx.'</strong></td>
<td align="right"><strong>'.xduit2($jmx1_total).'</strong></td>
</tr>
</table>
<br>
<br>
<br>



<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="400" align="center">
</td>

<td valign="top" width="200" align="center">
<p>
<strong>'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
</p>
<p>
<strong>Bendahara</strong>
<br>
<br>
<br>
<br>
<br>
(<strong>'.$nm8_session.'</strong>)
</p>
</td>
</tr>
<table>
</form>';
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
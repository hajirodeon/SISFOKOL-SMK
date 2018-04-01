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
$filenya = "siswa_harian_syukuran.php";
$judul = "Laporan Harian : Uang Syukuran";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa_harian_syukuran.php?tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln&utgl=$utgl";
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
<strong>PEMBAYARAN UANG SYUKURAN</strong>
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
$qcc = mysql_query("SELECT siswa_uang_syukuran.*, ".
			"siswa_uang_syukuran.kd_siswa AS kd_siswa, ".
			"siswa_uang_syukuran.kd AS pkd, ".
			"m_siswa.* ".
			"FROM siswa_uang_syukuran, m_siswa ".
			"WHERE siswa_uang_syukuran.kd_siswa = m_siswa.kd ".
			"AND siswa_uang_syukuran.nilai <> '' ".
			"AND siswa_uang_syukuran.kd_tapel = '$tapelkd' ".
			"AND round(DATE_FORMAT(siswa_uang_syukuran.tgl_bayar, '%d')) = '$utgl' ".
			"AND round(DATE_FORMAT(siswa_uang_syukuran.tgl_bayar, '%m')) = '$ubln' ".
			"AND round(DATE_FORMAT(siswa_uang_syukuran.tgl_bayar, '%Y')) = '$uthn' ".
			"ORDER BY round(m_siswa.nis) ASC");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);



echo '<br>
<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Kelas</font></strong></td>
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
	$i_pkd = nosql($rcc['pkd']);
	$i_swkd = nosql($rcc['kd_siswa']);
	$i_nis = nosql($rcc['nis']);
	$i_nama = balikin($rcc['nama']);


	//jumlah bayar
	$qjmx = mysql_query("SELECT * FROM siswa_uang_syukuran ".
				"WHERE nilai <> '' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$utgl' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn' ".
				"AND kd_siswa = '$i_swkd' ".
				"AND kd_tapel = '$tapelkd' ".
				"AND kd = '$i_pkd'");
	$rjmx = mysql_fetch_assoc($qjmx);
	$tjmx = mysql_num_rows($qjmx);
	$jmx_nilai = nosql($rjmx['nilai']);



	//kelas
	$qnil = mysql_query("SELECT * FROM siswa_kelas ".
				"WHERE kd_siswa = '$i_swkd' ".
				"AND kd_tapel = '$tapelkd'");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_kelkd = nosql($rnil['kd_kelas']);
	$swp_kelkd = nosql($rnil['kd_kelas']);
	$swp_rukd = nosql($rnil['kd_ruang']);

	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$swp_kelkd'");
	$rkelx = mysql_fetch_assoc($qkelx);
	$kelx_kelas = balikin($rkelx['kelas']);

	$qkelx2 = mysql_query("SELECT * FROM m_ruang ".
				"WHERE kd = '$swp_rukd'");
	$rkelx2 = mysql_fetch_assoc($qkelx2);
	$kelx2_ruang = balikin($rkelx2['ruang']);

	$swp_kelas = "$kelx_kelas - $kelx2_ruang";


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$i_nis.'</td>
	<td>'.$i_nama.'</td>
	<td>'.$swp_kelas.'</td>
	<td align="right">'.xduit2($jmx_nilai).'</td>
   	</tr>';
	}
while ($rcc = mysql_fetch_assoc($qcc));


//ketahui jumlah uang nya...
$qjmx1 = mysql_query("SELECT SUM(nilai) AS total ".
			"FROM siswa_uang_syukuran ".
			"WHERE nilai <> '' ".
			"AND kd_tapel = '$tapelkd' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$utgl' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
$rjmx1 = mysql_fetch_assoc($qjmx1);
$tjmx1 = mysql_num_rows($qjmx1);
$jmx1_total = nosql($rjmx1['total']);

echo '<tr bgcolor="'.$warnaover.'">
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="right"><strong>'.xduit2($jmx1_total).'</strong></td>
</tr>
</table>

<br>
<br>
<br>

<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="200" align="center">
<p>
</p>
</td>

<td valign="top" width="200" align="center">
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
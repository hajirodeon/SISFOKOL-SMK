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
$tpl = LoadTpl("../../template/nota.html");


nocache;

//nilai
$filenya = "siswa_lain_prt.php";
$jnskd = nosql($_REQUEST['jnskd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$nis = nosql($_REQUEST['nis']);
$swkd = nosql($_REQUEST['swkd']);
$kelkd = nosql($_REQUEST['kelkd']);



//keuangan lain
$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
			"WHERE kd = '$jnskd'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_nama = balikin($rdt['nama']);


//judul
$judul = "Keuangan Siswa : $dt_nama";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa_lain.php?jnskd=$jnskd&tapelkd=$tapelkd&smtkd=$smtkd&nis=$nis&swkd=$swkd&kelkd=$kelkd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="300" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">


<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">
<P>
<big>
<strong><u>BUKTI PEMBAYARAN '.strtoupper($dt_nama).'</u></strong>
</big>
</P>
<P>
<big>
<strong><u>'.$sek_nama.'</u></strong>
</big>
</P>

<hr height="1">
</td>
</tr>
</table>
<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="100">
Hari, Tanggal
</td>
<td width="1">:</td>
<td>
<strong>'.$arrhari[$hari].', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Nomor Induk
</td>
<td width="1">:</td>
<td>
<strong>'.$nis.'</strong>
</td>
</tr>';

//cek
$qcc = mysql_query("SELECT * FROM m_siswa ".
						"WHERE nis = '$nis'");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);
$cc_kd = nosql($rcc['kd']);
$cc_nama = balikin($rcc['nama']);


//yang dibayar, hari ini. . .
$qccx = mysql_query("SELECT SUM(siswa_uang_lain.nilai) AS total ".
			"FROM siswa_uang_lain, m_uang_lain ".
			"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
			"AND m_uang_lain.kd_jenis = '$jnskd' ".
			"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
			"AND siswa_uang_lain.kd_siswa = '$cc_kd' ".
			"AND DATE_FORMAT(tgl_bayar, '%d') = '$tanggal' ".
			"AND DATE_FORMAT(tgl_bayar, '%m') = '$bulan' ".
			"AND DATE_FORMAT(tgl_bayar, '%Y') = '$tahun'");
$rccx = mysql_fetch_assoc($qccx);
$ccx_nilai = nosql($rccx['total']);


//tapel
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);


//semester
$qstx = mysql_query("SELECT * FROM m_smt ".
			"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_smt = nosql($rowstx['smt']);


//ruang kelas
$qnily = mysql_query("SELECT m_uang_lain.*, siswa_kelas.* ".
			"FROM m_uang_lain, siswa_kelas ".
			"WHERE siswa_kelas.kd_tapel = m_uang_lain.kd_tapel ".
			"AND siswa_kelas.kd_kelas = m_uang_lain.kd_kelas ".
			"AND m_uang_lain.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_siswa = '$cc_kd'");
$rnily = mysql_fetch_assoc($qnily);
$tnily = mysql_num_rows($qnily);
$nily_kelkd = nosql($rnily['kd_kelas']);




//kelasnya...
$qkel = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$nily_kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = balikin($rkel['kelas']);



echo '<tr valign="top">
<td valign="top" width="100">
Nama Siswa
</td>
<td width="1">:</td>
<td>
<strong>'.$cc_nama.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Kelas/Ruang
</td>
<td width="1">:</td>
<td>
<strong>'.$kel_kelas.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Pembayaran
</td>
<td width="1">:</td>
<td>
<strong>'.$dt_nama.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Tahun Pelajaran
</td>
<td width="1">:</td>
<td>
<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Semester
</td>
<td width="1">:</td>
<td>
<strong>'.$stx_smt.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Total
</td>
<td width="1">:</td>
<td>
<strong>'.xduit2($ccx_nilai).'</strong>
</td>
</tr>


</table>
<br>
<br>
<br>

<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="300" align="center">
</td>
<td valign="top" align="center">
<strong>'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
<br>
<br>
<br>
(<strong>'.$nm8_session.'</strong>)
</td>
</tr>
<table>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="jnskd" type="hidden" value="'.$jnskd.'">
<input name="kelkd" type="hidden" value="'.$nil_kelkd.'">
<input name="swkd" type="hidden" value="'.$cc_kd.'">
<input name="nis" type="hidden" value="'.$nis.'">
</td>
</tr>
</table>


</td>
</tr>
</table>
<i>Code : '.$today3.'</i>

</form>
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
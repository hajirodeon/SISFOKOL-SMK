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



///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMP_v4.0_(NyurungBAN)                          ///////
/////// (Sistem Informasi Sekolah untuk SMP)                    ///////
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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/window.html");


nocache;

//nilai
$filenya = "siswa_spp_prt.php";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulku = $judul;
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$nis = nosql($_REQUEST['nis']);


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa_spp.php?tapelkd=$tapelkd&nis=$nis";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="500" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">


<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">
<P>
<big>
<strong><u>BUKTI PEMBAYARAN SPP</u></strong>
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
<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="200">
Hari, Tanggal
</td>
<td width="1">:</td>
<td>
<strong>'.$arrhari[$hari].', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
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



//ketahui posting terakhir
$qswpx = mysql_query("SELECT siswa_uang_spp.*, siswa_kelas.* ".
						"FROM siswa_uang_spp, siswa_kelas ".
						"WHERE siswa_kelas.kd_tapel = siswa_uang_spp.kd_tapel ".
						"AND siswa_kelas.kd_kelas = siswa_uang_spp.kd_kelas ".
						"AND siswa_uang_spp.kd_tapel = '$tapelkd' ".
						"AND siswa_uang_spp.kd_siswa = siswa_kelas.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$cc_kd' ".
						"AND siswa_uang_spp.lunas = 'true' ".
						"AND DATE_FORMAT(siswa_uang_spp.tgl_bayar, '%d') = '$tanggal' ".
						"AND DATE_FORMAT(siswa_uang_spp.tgl_bayar, '%m') = '$bulan' ".
						"AND DATE_FORMAT(siswa_uang_spp.tgl_bayar, '%Y') = '$tahun' ".
						"ORDER BY siswa_uang_spp.postdate DESC");
$rswpx = mysql_fetch_assoc($qswpx);
$tswpx = mysql_num_rows($qswpx);
$swpx_tgl = $rswpx['postdate'];



//ketahui nilai per bulan
$qnil = mysql_query("SELECT m_uang_spp.*, siswa_kelas.* ".
						"FROM m_uang_spp, siswa_kelas ".
						"WHERE siswa_kelas.kd_tapel = m_uang_spp.kd_tapel ".
						"AND siswa_kelas.kd_kelas = m_uang_spp.kd_kelas ".
						"AND m_uang_spp.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_siswa = '$cc_kd'");
$rnil = mysql_fetch_assoc($qnil);
$tnil = mysql_num_rows($qnil);
$nil_kelkd = nosql($rnil['kd_kelas']);
$nil_rukd = nosql($rnil['kd_ruang']);
$nil_uang = nosql($rnil['nilai']);

//ketahui kelas
$qkeli = mysql_query("SELECT * FROM m_kelas ".
								"WHERE kd = '$nil_kelkd'");
$rkeli = mysql_fetch_assoc($qkeli);
$keli_kelas = balikin($rkeli['kelas']);


//ketahui ruang
$qrui = mysql_query("SELECT * FROM m_ruang ".
								"WHERE kd = '$nil_rukd'");
$rrui = mysql_fetch_assoc($qrui);
$rui_ruang = balikin($rrui['ruang']);


//ketahui bulan yang sedang dibayar
$qswp = mysql_query("SELECT siswa_uang_spp.*, siswa_kelas.* ".
						"FROM siswa_uang_spp, siswa_kelas ".
						"WHERE siswa_kelas.kd_tapel = siswa_uang_spp.kd_tapel ".
						"AND siswa_kelas.kd_kelas = siswa_uang_spp.kd_kelas ".
						"AND siswa_uang_spp.kd_tapel = '$tapelkd' ".
						"AND siswa_uang_spp.kd_siswa = siswa_kelas.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$cc_kd' ".
						"AND siswa_uang_spp.lunas = 'true' ".
						"AND DATE_FORMAT(siswa_uang_spp.tgl_bayar, '%d') = '$tanggal' ".
						"AND DATE_FORMAT(siswa_uang_spp.tgl_bayar, '%m') = '$bulan' ".
						"AND DATE_FORMAT(siswa_uang_spp.tgl_bayar, '%Y') = '$tahun' ".
						"AND siswa_uang_spp.postdate = '$swpx_tgl'");
$rswp = mysql_fetch_assoc($qswp);
$tswp = mysql_num_rows($qswp);


//total uang
$cc_sebesar = $tswp * $nil_uang;


echo '<tr valign="top">
<td valign="top" width="200">
Nama Siswa
</td>
<td width="1">:</td>
<td>
<strong>'.$cc_nama.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Kelas/Ruang
</td>
<td width="1">:</td>
<td>
<strong>'.$keli_kelas.'/'.$rui_ruang.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Pembayaran
</td>
<td width="1">:</td>
<td>
<strong>SPP</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Jumlah Bulan Yang Dibayar
</td>
<td width="1">:</td>
<td>
<strong>'.$tswp.'</strong> Bulan,

Sebesar :
<strong>'.xduit2($cc_sebesar).'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Bulan
</td>
<td width="1">:</td>
<td>';

do
	{
	//nilai
	$swp_bln = nosql($rswp['bln']);
	$swp_thn = nosql($rswp['thn']);

	echo "<strong>$arrbln[$swp_bln] $swp_thn, </strong>";
	}
while ($rswp = mysql_fetch_assoc($qswp));

echo '</td>
</tr>
</table>
<br>
<br>
<br>

<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="200" align="center">
</td>
<td valign="top" align="center">
<strong>jakarta, '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
<br>
<br>
<br>
<br>
<br>
(<strong>ADMINISTRATOR</strong>)
</td>
</tr>
<table>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$nil_kelkd.'">
<input name="swkd" type="hidden" value="'.$cc_kd.'">
<input name="nis" type="hidden" value="'.$nis.'">
</td>
</tr>
</table>
<br>
<br>

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
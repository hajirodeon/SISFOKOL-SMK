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
$filenya = "siswa_history_prt.php";
$swkd = nosql($_REQUEST['swkd']);
$nis = nosql($_REQUEST['nis']);


//judul
$judul = "History Tabungan Siswa";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;



//siswa-nya
$qcc = mysql_query("SELECT * FROM m_siswa ".
			"WHERE nis = '$nis'");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);
$cc_nama = balikin($rcc['nama']);





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa.php?swkd=$swkd&nis=$nis";
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
<strong>HISTORY TABUNGAN SISWA</strong>
</big>
</p>

<p>
<big>
<strong>'.$nis.'.'.$cc_nama.'</strong>
</big>
</p>

</td>
</tr>
<table>
<br>
<br>';


//data tabungan
$qdata = mysql_query("SELECT * FROM siswa_tabungan ".
				"WHERE kd_siswa = '$swkd' ".
				"ORDER BY postdate DESC");
$rdata = mysql_fetch_assoc($qdata);
$tdata = mysql_num_rows($qdata);



echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="200" align="center"><strong><font color="'.$warnatext.'">Tanggal</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">Debet</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">Kredit</font></strong></td>
<td width="200" align="center"><strong><font color="'.$warnatext.'">Saldo</font></strong></td>
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

	//nilai
	$d_tgl = $rdata['tgl'];
	$d_debet = nosql($rdata['debet']);
	$d_nilai = nosql($rdata['nilai']);
	$d_saldo = nosql($rdata['saldo']);
	$d_postdate = $rdata['postdate'];


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$d_postdate.'</td>';

	//jika debet
	if ($d_debet == "true")
		{
		echo '<td align="right">'.xduit2($d_nilai).'</td>
		<td>-</td>';
		}

	//kredit
	else
		{
		echo '<td>-</td>
		<td align="right">'.xduit2($d_nilai).'</td>';
		}

	echo '<td align="right">'.xduit2($d_saldo).'</td>
	</tr>';
	}
while ($rdata = mysql_fetch_assoc($qdata));

echo '</table>
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
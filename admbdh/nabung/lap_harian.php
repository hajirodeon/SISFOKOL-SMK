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
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "lap_harian.php";
$judul = "Laporan Tabungan Harian";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$ke = "$filenya?tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln&utgl=$utgl";



//focus...
if (empty($tapelkd))
{
$diload = "document.formx.tapel.focus();";
}
else if (empty($utgl))
{
$diload = "document.formx.utglx.focus();";
}
else if (empty($ubln))
{
$diload = "document.formx.ublnx.focus();";
}






//isi *START
ob_start();

//menu
require("../../inc/menu/admbdh.php");

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
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tanggal : ';
echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
{
echo '<p>
<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
</p>';
}
else if (empty($utgl))
{
echo '<p>
<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!</strong></font>
</p>';
}
else if (empty($ubln))
{
echo '<p>
<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
</p>';
}
else
{


//query
$qcc = mysql_query("SELECT siswa_tabungan.*, ".
						"siswa_tabungan.kd_siswa AS kd_siswa, ".
						"siswa_tabungan.kd AS pkd, ".
						"siswa_tabungan.postdate AS pdate, ".
						"m_siswa.* ".
						"FROM siswa_tabungan, m_siswa ".
						"WHERE siswa_tabungan.kd_siswa = m_siswa.kd ".
						"AND round(DATE_FORMAT(siswa_tabungan.tgl, '%d')) = '$utgl' ".
						"AND round(DATE_FORMAT(siswa_tabungan.tgl, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(siswa_tabungan.tgl, '%Y')) = '$uthn' ".
						"ORDER BY siswa_tabungan.postdate DESC");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);


//jika ada
if ($tcc != 0)
{
echo '<br>
<table width="900" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="100"><strong><font color="'.$warnatext.'">Waktu</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="200"><strong><font color="'.$warnatext.'">DEBET</font></strong></td>
<td width="200"><strong><font color="'.$warnatext.'">KREDIT</font></strong></td>
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
	$i_nilai = nosql($rcc['nilai']);
	$i_status = nosql($rcc['debet']);
	$i_postdate = $rcc['pdate'];



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$i_postdate.'</td>
	<td>'.$i_nis.'</td>
	<td>'.$i_nama.'</td>';

	//jika debet
	if ($i_status == "true")
		{
		echo '<td align="right">'.xduit2($i_nilai).'</td>
		<td>-</td>';
		}
	else
		{
		echo '<td>-</td>
		<td align="right">'.xduit2($i_nilai).'</td>';
		}

	echo '</tr>';
	}
while ($rcc = mysql_fetch_assoc($qcc));


//ketahui jumlah uang nya... [DEBET]
$qjmx1 = mysql_query("SELECT SUM(nilai) AS total ".
						"FROM siswa_tabungan ".
						"WHERE round(DATE_FORMAT(tgl, '%d')) = '$utgl' ".
						"AND round(DATE_FORMAT(tgl, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl, '%Y')) = '$uthn' ".
						"AND debet = 'true'");
$rjmx1 = mysql_fetch_assoc($qjmx1);
$tjmx1 = mysql_num_rows($qjmx1);
$jmx1_total = nosql($rjmx1['total']);



//ketahui jumlah uang nya... [KREDIT]
$qjmx2 = mysql_query("SELECT SUM(nilai) AS total ".
						"FROM siswa_tabungan ".
						"WHERE round(DATE_FORMAT(tgl, '%d')) = '$utgl' ".
						"AND round(DATE_FORMAT(tgl, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl, '%Y')) = '$uthn' ".
						"AND debet = 'false'");
$rjmx2 = mysql_fetch_assoc($qjmx2);
$tjmx2 = mysql_num_rows($qjmx2);
$jmx2_total = nosql($rjmx2['total']);


//uang yang ada
$uang_ada = round($jmx1_total - $jmx2_total);


echo '<tr bgcolor="'.$warnaover.'">
<td></td>
<td></td>
<td></td>
<td align="right"><strong>'.xduit2($jmx1_total).'</strong></td>
<td align="right"><strong>'.xduit2($jmx2_total).'</strong></td>
</tr>
</table>
<br>

<p>
Jumlah Uang Yang Ada :
<br>
<big>
<strong>'.xduit2($uang_ada).'</strong>
</big>
</p>';
}
else
{
echo '<p>
<font color="red">
<strong>Tidak Ada Data</strong>
</font>
</p>';
}



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
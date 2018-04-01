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
$filenya = "siswa_tgl_lain.php";
$jnskd = nosql($_REQUEST['jnskd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$utgl2 = nosql($_REQUEST['utgl2']);
$ubln2 = nosql($_REQUEST['ubln2']);
$uthn2 = nosql($_REQUEST['uthn2']);


//jika satu digit
if (strlen($utgl) == 1)
	{
	$utgl = "0$utgl";
	}

if (strlen($utgl2) == 1)
	{
	$utgl2 = "0$utgl2";
	}

if (strlen($ubln) == 1)
	{
	$ubln = "0$ubln";
	}

if (strlen($ubln2) == 1)
	{
	$ubln2 = "0$ubln2";
	}

$ke = "$filenya?jnskd=$jnskd&tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln&utgl=$utgl&uthn2=$uthn2&ubln2=$ubln2&utgl2=$utgl2";


//keuangan lain
$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
			"WHERE kd = '$jnskd'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_nama = balikin($rdt['nama']);


//judul
$judul = "Laporan Per Tanggal : $dt_nama";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;



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
else if (empty($utgl2))
{
$diload = "document.formx.utglx2.focus();";
}
else if (empty($ubln2))
{
$diload = "document.formx.ublnx2.focus();";
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

	echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mulai Tanggal : ';
echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&tapelkd='.$tapelkd.'&utgl='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln1[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>,

Sampai : ';
echo "<select name=\"utglx2\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl2.'">'.$utgl2.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'&utgl2='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx2\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln2.''.$uthn2.'" selected>'.$arrbln1[$ubln2].' '.$uthn2.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'&utgl2='.$utgl2.'&ubln2='.$ibln.'&uthn2='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'&utgl2='.$utgl2.'&ubln2='.$ibln.'&uthn2='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
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
else if ((empty($utgl)) OR (empty($utgl2)))
{
echo '<p>
<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!</strong></font>
</p>';
}
else if ((empty($ubln)) OR (empty($ubln2)))
{
echo '<p>
<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
</p>';
}
else
{
//nilai
$tgl_awal = "$uthn:$ubln:$utgl";
$tgl_akhir = "$uthn2:$ubln2:$utgl2";


//query
$qcc = mysql_query("SELECT DISTINCT(siswa_uang_lain.tgl_bayar) AS tglku ".
			"FROM siswa_uang_lain, m_siswa, m_uang_lain ".
			"WHERE siswa_uang_lain.kd_siswa = m_siswa.kd ".
			"AND siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
			"AND siswa_uang_lain.nilai <> '' ".
			"AND m_uang_lain.kd_jenis = '$jnskd' ".
			"AND (siswa_uang_lain.tgl_bayar >= '$tgl_awal' ".
			"AND siswa_uang_lain.tgl_bayar <= '$tgl_akhir') ".
			"ORDER BY siswa_uang_lain.tgl_bayar ASC");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);


//jika ada
if ($tcc != 0)
	{
	echo '<p>[<a href="siswa_tgl_lain_prt.php?jnskd='.$jnskd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'&utgl2='.$utgl2.'&ubln2='.$ubln2.'&uthn2='.$uthn2.'"><img src="'.$sumber.'/img/print.gif" border="0" width="16" height="16"></a>]</p>';

	do
		{
		//nilai
		$cc_tgl = $rcc['tglku'];

		//query
		$qcc1 = mysql_query("SELECT DISTINCT(siswa_uang_lain.kd_siswa) AS swkd ".
					"FROM siswa_uang_lain, m_siswa, m_uang_lain ".
					"WHERE siswa_uang_lain.kd_siswa = m_siswa.kd ".
					"AND siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
					"AND m_uang_lain.kd_jenis = '$jnskd' ".
					"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
					"AND siswa_uang_lain.nilai <> '' ".
					"AND siswa_uang_lain.tgl_bayar = '$cc_tgl' ".
					"ORDER BY round(m_siswa.nis) ASC");
		$rcc1 = mysql_fetch_assoc($qcc1);
		$tcc1 = mysql_num_rows($qcc1);


		//jika ada
		if ($tcc1 != 0)
		{
		echo '<br>
		<strong>'.$cc_tgl.'</strong>
		<br>

		<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Kelas</font></strong></td>
		<td width="10" align="center"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
		<td width="200" align="center"><strong><font color="'.$warnatext.'">Nominal '.$dt_nama.'</font></strong></td>
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
			$i_swkd = nosql($rcc1['swkd']);

			//detail
			$qsw = mysql_query("SELECT * FROM m_siswa ".
						"WHERE kd = '$i_swkd'");
			$rsw = mysql_fetch_assoc($qsw);
			$tsw = mysql_num_rows($qsw);

			$i_nis = nosql($rsw['nis']);
			$i_nama = balikin($rsw['nama']);



			//jumlah bayar lain
			$qjmx = mysql_query("SELECT * FROM siswa_uang_lain, m_uang_lain ".
						"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
						"AND m_uang_lain.kd_jenis = '$jnskd' ".
						"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
						"AND siswa_uang_lain.nilai <> '' ".
						"AND siswa_uang_lain.tgl_bayar = '$cc_tgl' ".
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
						"AND siswa_uang_lain.tgl_bayar = '$cc_tgl' ".
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
			echo '<td>'.$i_nis.'</td>
			<td>'.$i_nama.'</td>
			<td>'.$kel_kelas.'</td>
			<td align="right">'.$tjmx.'</td>
			<td align="right">'.xduit2($jmx1_total).'</td>
			</tr>';
			}
		while ($rcc1 = mysql_fetch_assoc($qcc1));
		}


		//jumlah bayar lain
		$qjmx = mysql_query("SELECT * FROM siswa_uang_lain, m_uang_lain ".
					"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
					"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
					"AND m_uang_lain.kd_jenis = '$jnskd' ".
					"AND siswa_uang_lain.nilai <> '' ".
					"AND tgl_bayar = '$cc_tgl'");
		$rjmx = mysql_fetch_assoc($qjmx);
		$tjmx = mysql_num_rows($qjmx);


		//ketahui jumlah uang lain-nya...
		$qjmx1 = mysql_query("SELECT SUM(siswa_uang_lain.nilai) AS total ".
					"FROM siswa_uang_lain, m_uang_lain ".
					"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
					"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
					"AND m_uang_lain.kd_jenis = '$jnskd' ".
					"AND siswa_uang_lain.nilai <> '' ".
					"AND tgl_bayar = '$cc_tgl'");
		$rjmx1 = mysql_fetch_assoc($qjmx1);
		$tjmx1 = mysql_num_rows($qjmx1);
		$jmx1_total = nosql($rjmx1['total']);

		echo '<tr bgcolor="'.$warnaover.'">
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><strong>'.$tjmx.'</strong></td>
		<td align="right"><strong>'.xduit2($jmx1_total).'</strong></td>
		</tr>
		</table>';
		}
	while ($rcc = mysql_fetch_assoc($qcc));

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
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
$filenya = "tunggakan_spp_prt.php";
$judul = "Laporan Tunggakan SPP";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$rukd = nosql($_REQUEST['rukd']);






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "tunggakan_spp.php?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="900" border="0" cellspacing="0" cellpadding="3">
<tr valign="top" align="center">
<td>


<p>
<big>
<strong>LAPORAN TUNGGAKAN SPP</strong>
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



<table bgcolor="'.$warnaover.'" width="900" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>,

Kelas : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>,

Ruang : ';
//ruang
$qstx = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$rukd'");
$rowstx = mysql_fetch_assoc($qstx);
$ruang = balikin($rowstx['ruang']);

echo '<strong>'.$ruang.'</strong>
</td>
</tr>
</table>
<br>';


//kondisi
if (empty($kelkd))
	{
	$q_kelkd = "siswa_kelas.kd_kelas <> '' ";
	}
else
	{
	$q_kelkd = "siswa_kelas.kd_kelas = '$kelkd' ";
	}


if (empty($rukd))
	{
	$q_rukd = "siswa_kelas.kd_ruang <> '' ";
	}
else
	{
	$q_rukd = "siswa_kelas.kd_ruang = '$rukd' ";
	}


//query
$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
			"siswa_kelas.*, siswa_kelas.kd AS skkd ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND $q_kelkd ".
			"AND $q_rukd ".
			"ORDER BY round(m_siswa.nis) ASC");
$rdata = mysql_fetch_assoc($qdata);
$tdata = mysql_num_rows($qdata);




//nek ada
if ($tdata != 0)
	{
	//cacah tapel
	$qtpel = mysql_query("SELECT * FROM m_tapel ".
				"WHERE kd = '$tapelkd'");
	$rtpel = mysql_fetch_assoc($qtpel);
	$tpel_thn1 = nosql($rtpel['tahun1']);
	$tpel_thn2 = nosql($rtpel['tahun2']);


	echo '<table width="900" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>NIS</strong></td>
	<td><strong>Nama</strong></td>';

	for ($w=1;$w<=12;$w++)
		{
		//nilainya
		if ($w<=6) //bulan juli sampai desember
			{
			$ibln = $w + 6;
			$ithn = $tpel_thn1;
			}

		if ($w>6) //bulan januari sampai juni
			{
			$ibln = $w - 6;
			$ithn = $tpel_thn2;
			}

		echo '<td width="50" align="center"><strong>'.$arrbln2[$ibln].'<br>'.$ithn.'</strong></td>';
		}

	echo '</tr>';


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

		$i_kd = nosql($rdata['mskd']);
		$i_skkd = nosql($rdata['skkd']);
		$i_nis = nosql($rdata['nis']);
		$i_nama = balikin2($rdata['nama']);



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">'.$i_nis.'</td>
		<td valign="top">'.$i_nama.'</td>';

		for ($w=1;$w<=12;$w++)
			{
			//nilainya
			if ($w<=6) //bulan juli sampai desember
				{
				$ibln = $w + 6;
				$ithn = $tpel_thn1;
				}

			if ($w>6) //bulan januari sampai juni
				{
				$ibln = $w - 6;
				$ithn = $tpel_thn2;
				}


			//nilainya
			$qpinu = mysql_query("SELECT * FROM siswa_uang_spp ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_siswa = '$i_kd' ".
						"AND round(bln) = '$ibln' ".
						"AND round(thn) = '$ithn'");
			$rpinu = mysql_fetch_assoc($qpinu);
			$tpinu = mysql_num_rows($qpinu);
			$pinu_tgl = $rpinu['tgl_bayar'];
			$pinu_lunas = nosql($rpinu['lunas']);

			//nek gak ada
			if ((empty($pinu_tgl)) OR ($pinu_tgl == "0000-00-00") OR (empty($pinu_lunas)) OR ($pinu_lunas == "false"))
				{
				$pinu_x = "-";
				}
			//nek ada
			else
				{
				$pinu_x = "<font color=\"blue\">LUNAS</font>";
				}

			echo '<td align="center"><strong>'.$pinu_x.'</strong></td>';
			}

		echo '</tr>';
		}
	while ($rdata = mysql_fetch_assoc($qdata));

	echo '</table>';
	}

else
	{
	echo '<p>
	<font color="red"><strong>TIDAK ADA DATA.</strong></font>
	</p>';
	}

echo '<br>
<br>
<br>

<table width="900" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="200" align="center">
<p>
&nbsp;
</p>
<p>
<strong>Bendahara Yayasan</strong>
<br>
<br>
<br>
<br>
<br>
(..................................)
</p>
</td>

<td valign="top" width="200" align="center">
</td>

<td valign="top" width="200" align="center">
<p>
<strong>jakarta, '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
</p>
<p>
<strong>Bendahara</strong>
<br>
<br>
<br>
<br>
<br>
(..................................)
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
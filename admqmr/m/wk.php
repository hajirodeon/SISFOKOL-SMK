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
require("../../inc/cek/admqmr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "wk.php";
$judul = "Wali Kelas";
$judulku = "[$qmr_session : $nip19_session.$nm19_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$ke = "$filenya?tapelkd=$tapelkd&keakd=$keakd&kompkd=$kompkd";





//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($keakd))
	{
	$diload = "document.formx.keahlian.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.kompetensi.focus();";
	}










//isi *START
ob_start();

//menu
require("../../inc/menu/admqmr.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/js/checkall.js");
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
$tpxkd = nosql($rowtpx['kd']);
$tpxtahun1 = nosql($rowtpx['tahun1']);
$tpxtahun2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpxkd.'">'.$tpxtahun1.'/'.$tpxtahun2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd <> '$tapelkd' ".
			"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tptahun1 = nosql($rowtp['tahun1']);
	$tptahun2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tptahun1.'/'.$tptahun2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,


Program Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keakd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin2($rowkeax['program']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keakd' ".
			"ORDER BY program ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin2($rowkea['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>,




Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd = '$kompkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['kompetensi']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['kompetensi']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>
</td>
</tr>
</table>
<br>';


//nek drg
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Diplih...!</strong></font>';
	}

else if (empty($keakd))
	{
	echo '<font color="#FF0000"><strong>PROGRAM KEAHLIAN Belum Diplih...!</strong></font>';
	}

else if (empty($kompkd))
	{
	echo '<font color="#FF0000"><strong>KOMPETENSI KEAHLIAN Belum Diplih...!</strong></font>';
	}

else
	{
	//query
	$q = mysql_query("SELECT m_walikelas.*, m_walikelas.kd AS mwkd, ".
				"m_pegawai.*, m_pegawai.kd AS mpkd, m_kelas.* ".
				"FROM m_walikelas, m_pegawai, m_kelas ".
				"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
				"AND m_walikelas.kd_kelas = m_kelas.kd ".
				"AND m_walikelas.kd_tapel = '$tapelkd' ".
				"AND m_walikelas.kd_keahlian = '$keakd'".
				"AND m_walikelas.kd_keahlian_kompetensi = '$kompkd'".
				"ORDER BY round(m_kelas.no) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	//detail
	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Kelas</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
	</tr>';

	//nek ada
	if ($total != 0)
		{
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
			$i_nomer = $i_nomer + 1;
			$i_kd = nosql($row['mwkd']);
			$i_mpkd = nosql($row['mpkd']);
			$i_nip = nosql($row['nip']);
			$i_nama = balikin($row['nama']);
			$i_kelas = balikin($row['kelas']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_nomer.'.</td>
			<td>'.$i_kelas.'</td>
			<td>'.$i_nip.'</td>
			<td>'.$i_nama.'</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));
		}

	echo '</table>
	<table width="600" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td align="right"><strong><font color="#FF0000">'.$total.'</font></strong> Data. '.$pagelist.'</td>
	</tr>
	</table>';
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
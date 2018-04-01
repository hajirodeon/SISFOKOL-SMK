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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "rumus.php";
$judul = "Rumus Nilai";
$judulku = "[$waka_session : $nip10_session. $nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$s = nosql($_REQUEST['s']);






//focus
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}
else if (empty($keakd))
	{
	$diload = "document.formx.keahlian.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.kompetensi.focus();";
	}





//PROSES ///////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnSMP'])
	{
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);



	//data jenis
	$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
				"ORDER BY no ASC");
	$rku = mysql_fetch_assoc($qku);
	
	do
		{
		$ku_kd = nosql($rku['kd']);
		$ku_no = nosql($rku['no']);
		$ku_jenis = balikin($rku['jenis']);


		//ambil nilai
		$yuk = "persen_teori";
		$yuhu = "$yuk$ku_no";
		$nilku = nosql($_POST["$yuhu"]);

		$yuk2 = "persen_praktek";
		$yuhu2 = "$yuk2$ku_no";
		$nilku2 = nosql($_POST["$yuhu2"]);

		$yuk3 = "persen_kd";
		$yuhu3 = "$yuk3$ku_no";
		$nilku3 = nosql($_POST["$yuhu3"]);

		$yuk4 = "persen_uts";
		$yuhu4 = "$yuk4$ku_no";
		$nilku4 = nosql($_POST["$yuhu4"]);

		$yuk5 = "persen_uas";
		$yuhu5 = "$yuk5$ku_no";
		$nilku5 = nosql($_POST["$yuhu5"]);




		//cek
		$qcc = mysql_query("SELECT * FROM rumus_nilai ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_keahlian = '$keakd' ".
					"AND kd_keahlian_kompetensi = '$kompkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_jenis = '$ku_kd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
	
		//jika ada
		if ($tcc != 0)
			{
			mysql_query("UPDATE rumus_nilai SET persen_teori = '$nilku', ".
					"persen_praktek = '$nilku2', ".
					"persen_kd = '$nilku3', ".
					"persen_uts = '$nilku4', ".
					"persen_uas = '$nilku5', ".
					"postdate = '$today' ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_keahlian = '$keakd' ".
					"AND kd_keahlian_kompetensi = '$kompkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_jenis = '$ku_kd'");
			}
		else
			{
			mysql_query("INSERT INTO rumus_nilai(kd, kd_tapel, kd_keahlian, ".
					"kd_keahlian_kompetensi, kd_smt, kd_jenis, ".
					"persen_teori, persen_praktek, persen_kd, ".
					"persen_uts, persen_uas, postdate) VALUES ".
					"('$x', '$tapelkd', '$keakd', ".
					"'$kompkd', '$smtkd', '$ku_kd', ".
					"'$nilku', '$nilku2', '$nilku3', ".
					"'$nilku4', '$nilku5', '$today')");
			}
	

		}
	while ($rku = mysql_fetch_assoc($qku));
	}















//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admwaka.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" bgcolor="'.$warnaover.'" cellspacing="0" cellpadding="3">
<tr valign="top">
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

echo '</select>,

Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qsmtx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowsmtx = mysql_fetch_assoc($qsmtx);
$smtx_kd = nosql($rowsmtx['kd']);
$smtx_smt = nosql($rowsmtx['smt']);

echo '<option value="'.$smtx_kd.'">'.$smtx_smt.'</option>';

$qsmt = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowsmt = mysql_fetch_assoc($qsmt);

do
	{
	$smt_kd = nosql($rowsmt['kd']);
	$smt_smt = nosql($rowsmt['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$smt_kd.'">'.$smt_smt.'</option>';
	}
while ($rowsmt = mysql_fetch_assoc($qsmt));

echo '</select>,


Program Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
				"WHERE kd = '$keakd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['program']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keakd' ".
			"ORDER BY program ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&keakd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
				"WHERE kd_keahlian = '$keakd' ".
				"AND kd = '$kompkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['kompetensi']);
$keax_singk = nosql($rowkeax['singkatan']);

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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&keakd='.$keakd.'&kompkd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="keakd" type="hidden" value="'.$keakd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
</td>
</tr>
</table>
<br>';

//cek
if (empty($tapelkd))
	{
	echo '<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>';
	}
else if (empty($smtkd))
	{
	echo '<strong><font color="#FF0000">SEMESTER Belum Dipilih...!</font></strong>';
	}
else if (empty($keakd))
	{
	echo '<strong><font color="#FF0000">PROGRAM KEAHLIAN Belum Dipilih...!</font></strong>';
	}
else if (empty($kompkd))
	{
	echo '<strong><font color="#FF0000">KOMPETENSI KEAHLIAN Belum Dipilih...!</font></strong>';
	}
else
	{
	//data jenis
	$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
				"ORDER BY no ASC");
	$rku = mysql_fetch_assoc($qku);
	
	do
		{
		$ku_kd = nosql($rku['kd']);
		$ku_no = nosql($rku['no']);
		$ku_jenis = balikin($rku['jenis']);




		//datanya
		$qcc = mysql_query("SELECT * FROM rumus_nilai ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_keahlian = '$keakd' ".
					"AND kd_keahlian_kompetensi = '$kompkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_jenis = '$ku_kd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_p_praktek = nosql($rcc['persen_praktek']);
		$cc_p_teori = nosql($rcc['persen_teori']);
		$cc_p_kd = nosql($rcc['persen_kd']);
		$cc_p_uts = nosql($rcc['persen_uts']);
		$cc_p_uas = nosql($rcc['persen_uas']);
		$cc_postdate = $rcc['postdate'];


		echo '<p>
		<hr>
		<i>
		Per Entri Terakhir : '.$cc_postdate.'
		</i>
		<hr>
		</p>';


		//jika produktif
		if ($ku_jenis == "Produktif")
			{
			echo '<p>
			<b>
			'.$ku_no.'. '.$ku_jenis.'
			</b>
			<br>
			Bobot N.P = <input name="persen_praktek'.$ku_no.'" type="text" value="'.$cc_p_praktek.'" size="5">% .
			<br>
			Bobot N.TK = <input name="persen_teori'.$ku_no.'" type="text" value="'.$cc_p_teori.'" size="5">% .
			<br>
			N.P = N.KD + N.UPK
			<br>
			N.R = N.P + N.TK
			</p>

			<input name="jnskd'.$ku_no.'" type="hidden" value="'.$ku_kd.'">
			<input name="jns'.$ku_no.'" type="hidden" value="'.$ku_jenis.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<br>';
			}
		else
			{
			echo '<p>
			<b>
			'.$ku_no.'. '.$ku_jenis.'
			</b>
			<br>
			Bobot N.KD = <input name="persen_kd'.$ku_no.'" type="text" value="'.$cc_p_kd.'" size="5">% .
			<br>
			Bobot N.UTS = <input name="persen_uts'.$ku_no.'" type="text" value="'.$cc_p_uts.'" size="5">% .
			<br>
			Bobot N.UAS = <input name="persen_uas'.$ku_no.'" type="text" value="'.$cc_p_uas.'" size="5">% .
			<br>
			N.R = N.KD + N.UTS + N.UAS
			</p>

			<input name="jnskd'.$ku_no.'" type="hidden" value="'.$ku_kd.'">
			<input name="jns'.$ku_no.'" type="hidden" value="'.$ku_jenis.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<br>';	
			}
		}
	while ($rku = mysql_fetch_assoc($qku));
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

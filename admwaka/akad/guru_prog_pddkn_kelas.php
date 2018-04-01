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
$filenya = "guru_prog_pddkn_kelas.php";
$judul = "Guru Mata Pelajaran per Kelas";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$singkatan = nosql($_REQUEST['singkatan']);
$s = nosql($_REQUEST['s']);
$ke = "$filenya?tapelkd=$tapelkd&singkatan=$singkatan&keakd=$keakd&kompkd=$kompkd&kelkd=$kelkd&jnskd=$jnskd";



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
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$singkatan = nosql($_POST['singkatan']);
	$kelkd = nosql($_POST['kelkd']);
	$jnskd = nosql($_POST['jnskd']);
	$pelkd = nosql($_POST['pelkd']);
	$gurkd = nosql($_POST['gurkd']);

	//nek null
	if ((empty($pelkd)) OR (empty($gurkd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qc = mysql_query("SELECT m_guru_prog_pddkn.*, m_guru.*, m_pegawai.* ".
					"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
					"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
					"AND m_guru.kd_pegawai = m_pegawai.kd ".
					"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd' ".
					"AND m_guru_prog_pddkn.kd_guru = '$gurkd'");
		$rc = mysql_fetch_assoc($qc);
		$tc = mysql_num_rows($qc);
		$c_nip = nosql($rc['nip']);
		$c_nama = balikin2($rc['nama']);


		//nek ada, msg
		if ($tc != 0)
			{
			//re-direct
			$pesan = "Program Pendidikan dengan Guru : [$c_nip].$c_nama, SUDAH ADA. SILAHKAN GANTI...!";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			mysql_query("INSERT INTO m_guru_prog_pddkn(kd, kd_guru, kd_prog_pddkn) VALUES ".
					"('$x', '$gurkd', '$pelkd')");

			//re-direct
			xloc($ke);
			exit();
			}
		}
	}



//jika hapus
if ($s == "hapus")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$keakd = nosql($_REQUEST['keakd']);
	$kompkd = nosql($_REQUEST['kompkd']);
	$singkatan = nosql($_REQUEST['singkatan']);
	$kelkd = nosql($_REQUEST['kelkd']);
	$jnskd = nosql($_REQUEST['jnskd']);
	$pkd = nosql($_REQUEST['pkd']);
	$gkd = nosql($_REQUEST['gkd']);

	//query
	mysql_query("DELETE FROM m_guru_prog_pddkn ".
			"WHERE kd = '$gkd'");

	//re-direct
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//menu
require("../../inc/menu/admwaka.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//VIEW //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$ke.'">
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
	$kea_singk = nosql($rowkea['singkatan']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kea_kd.'&singkatan='.$kea_singk.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd <> '$kelkd' ".
			"AND kelas LIKE '%$singkatan%' ".
			"ORDER BY round(no) ASC, ".
			"kelas ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kompkd.'&singkatan='.$singkatan.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,

Jenis Mata Pelajaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd = '$jnskd'");
$rowjnx = mysql_fetch_assoc($qjnx);

$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = nosql($rowjnx['jenis']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY jenis ASC");
$rowjn = mysql_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['jenis']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kompkd.'&singkatan='.$singkatan.'&kelkd='.$kelkd.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>

<input name="tapelkd" type="hidden" value="'.nosql($_REQUEST['tapelkd']).'">
<input name="keakd" type="hidden" value="'.nosql($_REQUEST['keakd']).'">
<input name="kompkd" type="hidden" value="'.nosql($_REQUEST['kompkd']).'">
<input name="singkatan" type="hidden" value="'.nosql($_REQUEST['singkatan']).'">
<input name="kelkd" type="hidden" value="'.nosql($_REQUEST['kelkd']).'">


</td>
</tr>
</table>
<br>';

//nilai
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$singkatan = nosql($_REQUEST['singkatan']);

//nek blm
if (empty($tapelkd))
	{
	echo '<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>';
	}
else if (empty($keakd))
	{
	echo '<strong><font color="#FF0000">PROGRAM KEAHLIAN Belum Dipilih...!</font></strong>';
	}
else if (empty($kompkd))
	{
	echo '<strong><font color="#FF0000">KOMPETENSI KEAHLIAN Belum Dipilih...!</font></strong>';
	}
else if (empty($kelkd))
	{
	echo '<strong><font color="#FF0000">KELAS Belum Dipilih...!</font></strong>';
	}
else if (empty($jnskd))
	{
	echo '<strong><font color="#FF0000">JENIS MATA PELAJARAN Belum Dipilih...!</font></strong>';
	}
else
	{
	echo 'TAMBAH --> <select name="pelkd">
	<option value="" selected>-PROGRAM PENDIDIKAN-</option>';
	//daftar mapel
	$qbs = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn.*, m_prog_pddkn.kd AS mmkd ".
				"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keakd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn.kd_jenis = '$jnskd' ".
				"ORDER BY round(m_prog_pddkn.no) ASC, ".
				"round(m_prog_pddkn.no_sub) ASC");
	$rbs = mysql_fetch_assoc($qbs);

	do
		{
		$bskd = nosql($rbs['mmkd']);
		$bspel = balikin2($rbs['prog_pddkn']);

		echo '<option value="'.$bskd.'">'.$bspel.'</option>';
		}
	while ($rbs = mysql_fetch_assoc($qbs));

	echo '</select>';


	echo '<select name="gurkd">
	<option value="" selected>-GURU-</option>';

	//daftar guru
	$qg = mysql_query("SELECT m_guru.*, m_guru.kd AS mgkd, m_pegawai.* ".
				"FROM m_guru, m_pegawai ".
				"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
				"AND m_guru.kd_tapel = '$tapelkd' ".
				"AND m_guru.kd_keahlian = '$keakd' ".
				"AND m_guru.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_guru.kd_kelas = '$kelkd' ".
				"ORDER BY round(m_pegawai.nip) ASC");
	$rg = mysql_fetch_assoc($qg);

	do
		{
		$gkd = nosql($rg['mgkd']);
		$gnip = nosql($rg['nip']);
		$gnama = balikin2($rg['nama']);

		echo '<option value="'.$gkd.'">'.$gnip.'. '.$gnama.'</option>';
		}
	while ($rg = mysql_fetch_assoc($qg));

	echo '</select>
	<input name="tapelkd" type="hidden" value="'.nosql($_REQUEST['tapelkd']).'">
	<input name="keakd" type="hidden" value="'.nosql($_REQUEST['keakd']).'">
	<input name="kompkd" type="hidden" value="'.nosql($_REQUEST['kompkd']).'">
	<input name="tapelkd" type="hidden" value="'.nosql($_REQUEST['tapelkd']).'">
	<input name="kelkd" type="hidden" value="'.nosql($_REQUEST['kelkd']).'">
	<input name="btnSMP" type="submit" value="SIMPAN"></p>';

	//query
	$q = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn.*, m_prog_pddkn.kd AS mmkd ".
				"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keakd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn.kd_jenis = '$jnskd' ".
				"ORDER BY round(m_prog_pddkn.no, m_prog_pddkn.no_sub) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	if ($total != 0)
		{
		echo '<table width="600" border="1" cellpadding="3" cellspacing="0">
	    	<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong>No.</strong></td>
	    	<td valign="top"><strong><font color="'.$warnatext.'">Nama Mata Pelajaran</font></strong></td>
	    	<td width="300" valign="top"><strong><font color="'.$warnatext.'">Guru</font></strong></td>
	    	</tr>';

		do {
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
			$mmkd = nosql($row['mmkd']);
			$pel = balikin2($row['prog_pddkn']);

			echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";

			echo '<td width="17"><input name="kdx'.$nomer.'" type="hidden" value="'.$mmkd.'">'.$nomer.'. </td>
    			<td>'.$pel.'</td>
			<td>';

			//guru-nya
			$quru = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, m_guru.*, m_guru_prog_pddkn.*, ".
						"m_guru_prog_pddkn.kd AS mgmkd ".
						"FROM m_pegawai, m_guru, m_guru_prog_pddkn ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_guru_prog_pddkn.kd_guru = m_guru.kd ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"AND m_guru.kd_keahlian = '$keakd' ".
						"AND m_guru.kd_keahlian_kompetensi = '$kompkd' ".
						"AND m_guru.kd_kelas = '$kelkd' ".
						"AND m_guru_prog_pddkn.kd_prog_pddkn = '$mmkd'");
			$ruru = mysql_fetch_assoc($quru);


			do
				{
				$gkd = nosql($ruru['mgmkd']);
				$mpkd = nosql($ruru['mpkd']);
				$gnam = balikin2($ruru['nama']);

				//nek null
				if (empty($gkd))
					{
					echo "-";
					}
				else
					{
					echo '<strong>*</strong> '.$gnam.'
					[<a href="'.$ke.'&s=hapus&pkd='.$mmkd.'&gkd='.$gkd.'" title="HAPUS --> '.$gnam.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>]. <br>';
					}
				}
			while ($ruru = mysql_fetch_assoc($quru));


			echo '</td>
    			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="600" border="0" cellspacing="0" cellpadding="3">
	    	<tr>
	    	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
	    	</tr>
	  	</table>';
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
?>
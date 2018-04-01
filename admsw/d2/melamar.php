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
require("../../inc/cek/admsw.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "melamar.php";
$judul = "Form Lowongan Pelamar Kerja";
$judulku = "[$siswa_session : $nis2_session.$nm2_session] ==> $judul";
$judulx = $judul;
$kd = nosql($_REQUEST['kd']);
$s = nosql($_REQUEST['s']);
$tapelkd  = nosql($_REQUEST['tapelkd']);
$lowkd  = nosql($_REQUEST['lowkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//jika null
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($lowkd))
	{
	$diload = "document.formx.low.focus();";
	}




//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//lamar sekarang
if ($_POST['btnLMR'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$lowkd = nosql($_POST['lowkd']);


	//re-direct
	$ke = "$filenya?kd=$x&tapelkd=$tapelkd&lowkd=$lowkd&s=baru";
	xloc($ke);
	exit();
	}




//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}




//kirim lamaran
if ($_POST['btnSMP'])
	{
	//nilai
	$kd = nosql($_POST['kd']);
	$tapelkd = nosql($_POST['tapelkd']);
	$lowkd = nosql($_POST['lowkd']);
	$e_notes = cegah($_POST['e_notes']);
	$e_nama = cegah($_POST['e_nama']);
	$e_panggilan = cegah($_POST['e_panggilan']);
	$e_kelamin = cegah($_POST['e_kelamin']);
	$e_tmp = cegah($_POST['e_tmp']);
	$e_tgl = cegah($_POST['e_tgl']);
	$e_agama = cegah($_POST['e_agama']);
	$e_nikah = cegah($_POST['e_nikah']);
	$e_tb = cegah($_POST['e_tb']);
	$e_bb = cegah($_POST['e_bb']);
	$e_kerja = cegah($_POST['e_kerja']);
	$e_noktp = cegah($_POST['e_noktp']);
	$e_masaktp = cegah($_POST['e_masaktp']);
	$e_alamat = cegah($_POST['e_alamat']);
	$e_kab = cegah($_POST['e_kab']);
	$e_prop = cegah($_POST['e_prop']);
	$e_kodepos = cegah($_POST['e_kodepos']);
	$e_alamat2 = cegah($_POST['e_alamat2']);
	$e_kab2 = cegah($_POST['e_kab2']);
	$e_prop2 = cegah($_POST['e_prop2']);
	$e_kodepos2 = cegah($_POST['e_kodepos2']);
	$e_pddkn = cegah($_POST['e_pddkn']);
	$e_namasekolah = cegah($_POST['e_namasekolah']);
	$e_kotasekolah = cegah($_POST['e_kotasekolah']);
	$e_jurusan = cegah($_POST['e_jurusan']);
	$e_nilai = cegah($_POST['e_nilai']);
	$e_tahun = cegah($_POST['e_tahun']);
	$e_asal = cegah($_POST['e_asal']);
	$e_nohp = cegah($_POST['e_nohp']);




	mysql_query("UPDATE bkk_calon SET no_tes = '$e_notes', ".
			"nama = '$e_nama', ".
			"panggilan = '$e_panggilan', ".
			"kelamin = '$e_kelamin', ".
			"tmp_lahir = '$e_tmp', ".
			"tgl_lahir = '$e_tgl', ".
			"agama = '$e_agama', ".
			"nikah = '$e_nikah', ".
			"tb = '$e_tb', ".
			"bb = '$e_bb', ".
			"pernah_kerja = '$e_kerja', ".
			"no_ktp = '$e_noktp', ".
			"masa_ktp = '$e_masaktp', ".
			"alamat = '$e_alamat', ".
			"kab = '$e_kab', ".
			"propinsi = '$e_prop', ".
			"kode_pos = '$e_kodepos', ".
			"alamat2 = '$e_alamat2', ".
			"kab2 = '$e_kab2', ".
			"propinsi2 = '$e_prop2', ".
			"kode_pos2 = '$e_kodepos2', ".
			"nohp = '$e_nohp', ".
			"pendidikan = '$e_pddkn', ".
			"nama_sekolah = '$e_namasekolah', ".
			"kota_sekolah = '$e_kotasekolah', ".
			"jurusan = '$e_jurusan', ".
			"nilai = '$e_nilai', ".
			"tahun_lulus = '$e_tahun', ".
			"asal_lamaran = '$e_asal', ".
			"postdate = '$today' ".
			"WHERE kd = '$kd' ".
			"AND kd_lowongan = '$lowkd'");




	//re-direct
	$pesan = "NO.TES Anda : $e_notes. Terima Kasih. Anda Telah Berhasil Melakukan Pendaftaran Suatu Lowongan. ".
			"Informasi lebih lanjur, silahkan hubungi bagian BKK.";
	$ke = "$sumber/admsw";
	pekem($pesan,$ke);
	exit();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();

//menu
require("../../inc/menu/admsw.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();



//isi *START
ob_start();


//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
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

echo '<option value="'.$tpx_kd.'" selected>--'.$tpx_thn1.'/'.$tpx_thn2.'--</option>';

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


Lowongan : ';
echo "<select name=\"low\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM bkk_lowongan ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND kd = '$lowkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_nama = balikin($rowtpx['nama']);

echo '<option value="'.$tpx_kd.'" selected>--'.$tpx_nama.'--</option>';

$qtp = mysql_query("SELECT * FROM bkk_lowongan ".
			"WHERE kd_tapel = '$tapelkd' ".
			"ORDER BY nama ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = balikin($rowtp['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&lowkd='.$tpkd.'">'.$tpth1.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';



//cek
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($lowkd))
	{
	echo '<p>
	<strong><font color="#FF0000">NAMA LOWONGAN Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	//jika belum lamar, detail aja
	if (empty($s))
		{
		//detail lowongan
		$qdt = mysql_query("SELECT * FROM bkk_lowongan ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd = '$lowkd'");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);

		//jika ada
		if ($tdt != 0)
			{
			$dt_nama = balikin2($rdt['nama']);
			$dt_isi = balikin2($rdt['isi']);


			echo '<p>
			<big>
			<strong>'.$dt_nama.'</strong>
			</big>
			</p>


			<p>
			'.$dt_isi.'
			</p>


			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="lowkd" type="hidden" value="'.$lowkd.'">
			<INPUT type="submit" name="btnLMR" value="LAMAR SEKARANG >>">';
			}
		else
			{
			echo '<p>
			<font color="red">
			DESKRIPSI LOWONGAN BELUM ADA. Silahkan Hubungi Bagian BKK.
			</font>
			</p>';
			}
		}


	//jika add ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($s == "baru")
		{
		//ketahui nomer pendaftaran
		$qpd = mysql_query("SELECT MAX(no_tes) AS noreg ".
					"FROM bkk_calon ".
					"WHERE kd_tapel = '$tapelkd'");
		$rpd = mysql_fetch_assoc($qpd);
		$pd_noreg = nosql($rpd['noreg']);

		//jika null
		if (empty($pd_noreg))
			{
			$yo1 = "01";
			$noregx = $yo1;

			//cek lagi
			$qcc = mysql_query("SELECT * FROM bkk_calon ".
						"WHERE kd = '$kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);


			//jika ada, cuekin aja
			if ($tcc != 0)
				{
				//enjoy aja...
				}
			else
				{
				//insert
				mysql_query("INSERT INTO bkk_calon(kd, kd_tapel, kd_lowongan, no_tes) VALUES ".
						"('$kd', '$tapelkd', '$lowkd', '$noregx')");
				}
			}
		else
			{
			//cek lagi
			$qcc = mysql_query("SELECT * FROM bkk_calon ".
						"WHERE kd = '$kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);


			//jika ada, cuekin aja
			if ($tcc != 0)
				{
				//enjoy aja...
				$noregx = round($pd_noreg);
				}
			else
				{
				$noregx = round($pd_noreg + 1);

				//insert
				mysql_query("INSERT INTO bkk_calon(kd, kd_tapel, kd_lowongan, no_tes) VALUES ".
						"('$kd', '$tapelkd', '$lowkd', '$noregx')");
				}

			}



		//data query
		$qnil = mysql_query("SELECT * FROM bkk_lowongan ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd = '$lowkd'");
		$rnil = mysql_fetch_assoc($qnil);
		$e_nama = balikin($rnil['nama']);


		echo '<table border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="100">
		Nama Lowongan
		</td>
		<td>:
		<input name="lowongan" type="text" value="'.$e_nama.'" size="50" class="input" readonly>
		</td>
		</tr>
		</table>

		<p>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="150">
		No.Tes
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_notes" type="text" value="'.$noregx.'" size="10" class="input" readonly>
		</td>
		</tr>

		<tr>
		<td width="150">
		Nama Pelamar
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_nama" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Panggilan
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_panggilan" type="text" value="" size="20">
		</td>
		</tr>

		<tr>
		<td width="150">
		Jenis Kelamin (L/P)
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_kelamin" type="text" value="" size="1">
		</td>
		</tr>

		<tr>
		<td width="150">
		Tempat, Tanggal Lahir
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_tmp" type="text" value="" size="20">,
		<input name="e_tgl" type="text" value="" size="20">
		</td>
		</tr>

		<tr>
		<td width="150">
		Agama
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_agama" type="text" value="" size="20">
		</td>
		</tr>

		<tr>
		<td width="150">
		Status Nikah / Belum Nikah
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_nikah" type="text" value="" size="20">
		</td>
		</tr>

		<tr>
		<td width="150">
		Tinggi Badan
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_tb" type="text" value="" size="5"> Cm.
		</td>
		</tr>

		<tr>
		<td width="150">
		Berat Badan
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_bb" type="text" value="" size="5">Kg.
		</td>
		</tr>

		<tr>
		<td width="150">
		Pernah Bekerja di
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_kerja" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		No.KTP
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_noktp" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Masa Berlaku KTP
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_masaktp" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Alamat
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_alamat" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Kabupaten/Kota
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_kab" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Propinsi
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_prop" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Kode Pos
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_kodepos" type="text" value="" size="5">
		</td>
		</tr>

		<tr>
		<td width="150">
		Alamat Saat ini
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_alamat2" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Kabupaten/Kota
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_kab2" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Propinsi
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_prop2" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Kode Pos
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_kodepos2" type="text" value="" size="5">
		</td>
		</tr>

		<tr>
		<td width="150">
		No.HP
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_nohp" type="text" value="" size="30">
		</td>
		</tr>


		<tr>
		<td width="150">
		Pendidikan
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_pddkn" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Nama Sekolah
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_namasekolah" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Kota
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_kotasekolah" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Jurusan
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_jurusan" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Nilai
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_nilai" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Tahun Lulus
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_tahun" type="text" value="" size="30">
		</td>
		</tr>

		<tr>
		<td width="150">
		Asal Lamaran
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_asal" type="text" value="" size="30">
		</td>
		</tr>
		</table>
		<br>
		<INPUT type="hidden" name="s" value="'.$s.'">
		<INPUT type="hidden" name="kd" value="'.$kd.'">
		<INPUT type="hidden" name="lowkd" value="'.$lowkd.'">
		<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
		<INPUT type="submit" name="btnBTL" value="BATAL">
		<INPUT type="submit" name="btnSMP" value="KIRIM >>">
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
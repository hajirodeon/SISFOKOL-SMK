<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pel_hari_entry.php";
$judul = "Entry Jadwal Pelajaran";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$kd = nosql($_REQUEST['kd']);
$s = nosql($_REQUEST['s']);


//focus
$diload = "document.formx.hari.focus();";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "pel_hari.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}





//nek simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$kd = nosql($_POST['kd']);
	$hari = nosql($_POST['hari']);
	$jam = nosql($_POST['jam']);
	$pel = nosql($_POST['pel']);
	$ruang1 = nosql($_POST['ruang1']);
	$ruang2 = nosql($_POST['ruang2']);
	$lama = nosql($_POST['lama']);


	//nek null
	if ((empty($hari)) OR (empty($ruang1)) OR (empty($jam)) OR (empty($pel)) OR (empty($lama)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
		$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//nek edit
		if ($s == "edit")
			{
			//dapatkan lama jam mengajar...
			for($j=1;$j<=$lama;$j++)
				{
				//jika satu...
				if ($j == "1")
					{
					$ku_jam = $jam;
					}

				else
					{
					$ku_jam = $dd;
					}

				//query
				$qkuji = mysql_query("SELECT * FROM m_jam ".
							"WHERE kd = '$jam'");
				$rkuji = mysql_fetch_assoc($qkuji);
				$tkuji = mysql_num_rows($qkuji);
				$kuji_jam = nosql($rkuji['jam']);

				//jenjang max penambahan
				$kuji_max = round($kuji_jam + ($j - 1));


				//terpilih
				$qkujix = mysql_query("SELECT * FROM m_jam ".
							"WHERE jam = '$kuji_max'");
				$rkujix = mysql_fetch_assoc($qkujix);
				$tkujix = mysql_num_rows($qkujix);
				$kujix_kd = nosql($rkujix['kd']);


				//netralkan dahulu
				mysql_query("DELETE FROM jadwal ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd = '$kd'");

				//query
				mysql_query("INSERT INTO jadwal(kd, kd_tapel, kd_smt, kd_kelas, ".
								"kd_jam, kd_hari, kd_guru_prog_pddkn, kd_ruang1, kd_ruang2, postdate) VALUES ".
								"('$x', '$tapelkd', '$smtkd', '$kelkd', ".
								"'$kujix_kd', '$hari', '$pel', '$ruang1', '$ruang2', '$today')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "pel_hari.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd";
			xloc($ke);
			exit();
			}

		else if (empty($s)) //nek baru
			{
			//cek terisi...
			$qcc = mysql_query("SELECT * FROM jadwal ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_kelas = '$kelkd' ".
									"AND kd_jam = '$jam' ".
									"AND kd_hari = '$hari'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);


			//cek telah mengajar pada kelas berbeda, pada hari, jam, dan guru sama [gak boleh tubrukan...].
			$qcc1 = mysql_query("SELECT jadwal.*, m_guru_prog_pddkn.* ".
									"FROM jadwal, m_guru_prog_pddkn ".
									"WHERE jadwal.kd_guru_prog_pddkn = m_guru_prog_pddkn.kd ".
									"AND jadwal.kd_tapel = '$tapelkd' ".
									"AND jadwal.kd_smt = '$smtkd' ".
									"AND jadwal.kd_kelas = '$kelkd' ".
									"AND jadwal.kd_jam = '$jam' ".
									"AND jadwal.kd_hari = '$hari'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$tcc1 = mysql_num_rows($qcc1);



			//dapatkan lama jam mengajar...
			for($j=1;$j<=$lama;$j++)
				{
				//query
				$qkuji = mysql_query("SELECT * FROM m_jam ".
							"WHERE kd = '$jam'");
				$rkuji = mysql_fetch_assoc($qkuji);
				$tkuji = mysql_num_rows($qkuji);
				$kuji_jam = nosql($rkuji['jam']);


				//jenjang max penambahan
				$kuji_max = round($kuji_jam + ($j - 1));


				//terpilih
				$qkujix = mysql_query("SELECT * FROM m_jam ".
							"WHERE jam = '$kuji_max'");
				$rkujix = mysql_fetch_assoc($qkujix);
				$tkujix = mysql_num_rows($qkujix);
				$kujix_kd = nosql($rkujix['kd']);


				//query
				mysql_query("INSERT INTO jadwal(kd, kd_tapel, kd_smt, kd_kelas, ".
								"kd_jam, kd_hari, kd_guru_prog_pddkn, kd_ruang1, kd_ruang2, postdate) VALUES ".
								"('$x', '$tapelkd', '$smtkd', '$kelkd', ".
								"'$kujix_kd', '$hari', '$pel', '$ruang1', '$ruang2', '$today')");
				}

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "pel_hari.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd";
			xloc($ke);
			exit();
			}

		}
	}





//nek edit
if ($s == "edit")
	{
	//query
	$qdir = mysql_query("SELECT * FROM jadwal ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd = '$kd'");
	$rdir = mysql_fetch_assoc($qdir);
	$dir_harikd = nosql($rdir['kd_hari']);
	$dir_jamkd = nosql($rdir['kd_jam']);
	$dir_gmkd = nosql($rdir['kd_guru_prog_pddkn']);
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
require("../../inc/js/number.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" bgcolor="'.$warnaover.'" cellspacing="0" cellpadding="3">
<tr valign="top">
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

Semester : ';
//terpilih
$qsmtx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowsmtx = mysql_fetch_assoc($qsmtx);
$smtx_kd = nosql($rowsmtx['kd']);
$smtx_smt = nosql($rowsmtx['smt']);

echo '<strong>'.$smtx_smt.'</strong>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
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
						"ORDER BY no ASC, ".
						"kelas ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>
</td>
</tr>
</table>
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<p>
<strong>Hari : </strong>
<br>';


//hari-terpilih
$qhrix = mysql_query("SELECT * FROM m_hari ".
			"WHERE kd = '$dir_harikd'");
$rhrix = mysql_fetch_assoc($qhrix);
$hrix_kd = nosql($rhrix['kd']);
$hrix_hr = balikin($rhrix['hari']);

echo '<select name="hari">
<option value="'.$hrix_kd.'" selected>'.$hrix_hr.'</option>';
//hari
$qhri = mysql_query("SELECT * FROM m_hari ".
						"WHERE kd <> '$hrix_kd' ".
						"ORDER BY round(no) ASC");
$rhri = mysql_fetch_assoc($qhri);

do
	{
	$hri_kd = nosql($rhri['kd']);
	$hri_hr = balikin($rhri['hari']);

	echo '<option value="'.$hri_kd.'">'.$hri_hr.'</option>';
	}
while ($rhri = mysql_fetch_assoc($qhri));

echo '</select>
</p>


<p>
<strong>Jam ke-: </strong>
<br>';


//jam-terpilih
$qjmx = mysql_query("SELECT * FROM m_jam ".
			"WHERE kd = '$dir_jamkd'");
$rjmx = mysql_fetch_assoc($qjmx);
$jmx_kd = nosql($rjmx['kd']);
$jmx_jam = nosql($rjmx['jam']);

echo '<select name="jam">
<option value="'.$jmx_kd.'" selected>'.$jmx_jam.'</option>';
//jam
$qjm = mysql_query("SELECT * FROM m_jam ".
			"WHERE kd <> '$jmx_kd' ".
			"ORDER BY round(jam) ASC");
$rjm = mysql_fetch_assoc($qjm);

do
	{
	$jm_kd = nosql($rjm['kd']);
	$jm_hr = nosql($rjm['jam']);

	echo '<option value="'.$jm_kd.'">'.$jm_hr.'</option>';
	}
while ($rjm = mysql_fetch_assoc($qjm));

echo '</select>
</p>


<p>
<strong>Lama Mengajar : </strong>
<br>
<input type="text" name="lama" value="'.$lama.'" size="2" maxlength="1" onKeyPress="return numbersonly(this, event)"> Jam
<br><br>

<strong>Mata Pelajaran :</strong><br>';

//program pendidikan-terpilih
$qpelx = mysql_query("SELECT jadwal.*, m_guru.*, m_guru_prog_pddkn.*, m_guru_prog_pddkn.kd AS mmkd ".
						"FROM jadwal, m_guru, m_guru_prog_pddkn ".
						"WHERE jadwal.kd_guru_prog_pddkn = m_guru_prog_pddkn.kd ".
						"AND m_guru_prog_pddkn.kd_guru = m_guru.kd ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"AND m_guru.kd_kelas = '$kelkd' ".
						"AND jadwal.kd = '$kd'");
$rpelx = mysql_fetch_assoc($qpelx);
$pelx_kd = nosql($rpelx['mmkd']);
$pelx_progkd = nosql($rpelx['kd_prog_pddkn']);
$pelx_nip = nosql($rpelx['nip']);
$pelx_nm = balikin($rpelx['nama']);


//mapel
$q1 = mysql_query("SELECT * FROM m_prog_pddkn ".
					"WHERE kd = '$pelx_progkd'");
$r1 = mysql_fetch_assoc($q1);
$pelx_pel = balikin($r1['mapel']);


echo '<select name="pel">
<option value="'.$pelx_kd.'" selected>'.$pelx_pel.' ['.$pelx_nip.'. '.$pelx_nm.']</option>';

//mata pelajaran
$qpel = mysql_query("SELECT m_pegawai.*, m_guru_prog_pddkn.*, ".
						"m_guru_prog_pddkn.kd AS mmkd ".
						"FROM m_pegawai, m_guru, m_guru_prog_pddkn ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_guru_prog_pddkn.kd_guru = m_guru.kd ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"AND m_guru.kd_kelas = '$kelkd' ".
						"ORDER BY m_pegawai.nama ASC");
$rpel = mysql_fetch_assoc($qpel);

do
	{
	$pel_kd = nosql($rpel['mmkd']);
	$pel_progkd = nosql($rpel['kd_prog_pddkn']);
	$pel_nip = nosql($rpel['nip']);
	$pel_nm = balikin($rpel['nama']);

	//mapel
	$q1 = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd = '$pel_progkd'");
	$r1 = mysql_fetch_assoc($q1);
	$pel_pel = balikin($r1['prog_pddkn']);

	echo '<option value="'.$pel_kd.'">'.$pel_pel.' ['.$pel_nip.']. '.$pel_nm.'</option>';
	}
while ($rpel = mysql_fetch_assoc($qpel));

echo '</select>
</p>


<p>
<strong>Ruang #1 : </strong>
<br>';


//terpilih
$qhrix = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$dir_rukd'");
$rhrix = mysql_fetch_assoc($qhrix);
$hrix_kd = nosql($rhrix['kd']);
$hrix_ruang = balikin($rhrix['ruang']);

echo '<select name="ruang1">
<option value="'.$hrix_kd.'" selected>'.$hrix_ruang.'</option>';
//hari
$qhri = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd <> '$hrix_kd' ".
						"ORDER BY ruang ASC");
$rhri = mysql_fetch_assoc($qhri);

do
	{
	$hri_kd = nosql($rhri['kd']);
	$hri_hr = balikin($rhri['ruang']);

	echo '<option value="'.$hri_kd.'">'.$hri_hr.'</option>';
	}
while ($rhri = mysql_fetch_assoc($qhri));

echo '</select>

</p>



<p>
<strong>Ruang #2 : </strong>
<br>';


//terpilih
$qhrix = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$dir_rukd2'");
$rhrix = mysql_fetch_assoc($qhrix);
$hrix_kd = nosql($rhrix['kd']);
$hrix_ruang = balikin($rhrix['ruang']);

echo '<select name="ruang2">
<option value="'.$hrix_kd.'" selected>'.$hrix_ruang.'</option>';
//hari
$qhri = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd <> '$hrix_kd' ".
						"ORDER BY ruang ASC");
$rhri = mysql_fetch_assoc($qhri);

do
	{
	$hri_kd = nosql($rhri['kd']);
	$hri_hr = balikin($rhri['ruang']);

	echo '<option value="'.$hri_kd.'">'.$hri_hr.'</option>';
	}
while ($rhri = mysql_fetch_assoc($qhri));

echo '</select>

</p>


<p>
<input name="s" type="hidden" value="'.$s.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="kd" type="hidden" value="'.$kd.'">
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>
</td>
</tr>
</table>
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
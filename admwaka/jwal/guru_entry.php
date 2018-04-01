<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "guru_entry.php";
$judul = "Entry Guru Mengajar";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$gurkd = nosql($_REQUEST['gurkd']);





//focus
$diload = "document.formx.kprp.focus();";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$gurkd = nosql($_POST['gurkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "guru.php?tapelkd=$tapelkd&smtkd=$smtkd&gurkd=$gurkd";
	xloc($ke);
	exit();
	}





//nek simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$gurkd = nosql($_POST['gurkd']);
	$kprp = nosql($_POST['kprp']);
	$hari = nosql($_POST['hari']);
	$jam = nosql($_POST['jam']);
	$lama = nosql($_POST['lama']);


	//nek null
	if ((empty($kprp)) OR (empty($hari)) OR (empty($jam)) OR (empty($lama)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
		$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&gurkd=$gurkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//detail
		$qrpx = mysql_query("SELECT m_guru_prog_pddkn.*, m_guru.* ".
							"FROM m_guru_prog_pddkn, m_guru ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru_prog_pddkn.kd = '$kprp'");
		$rrpx = mysql_fetch_assoc($qrpx);
		$rpx_kelkd = nosql($rrpx['kd_kelas']);


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
							"kd_jam, kd_hari, kd_guru_prog_pddkn, postdate) VALUES ".
							"('$x', '$tapelkd', '$smtkd', '$rpx_kelkd', ".
							"'$kujix_kd', '$hari', '$kprp', '$today')");
			}


		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$ke = "guru.php?tapelkd=$tapelkd&smtkd=$smtkd&gurkd=$gurkd";
		xloc($ke);
		exit();
		}
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

echo '<strong>'.$smtx_smt.'</strong>,

Guru : ';
//terpilih
$qgrx = mysql_query("SELECT m_pegawai.* ".
						"FROM m_pegawai, m_guru ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"AND m_pegawai.kd = '$gurkd'");
$rowgrx = mysql_fetch_assoc($qgrx);
$grx_kd = nosql($rowgrx['kd']);
$grx_nip = nosql($rowgrx['nip']);
$grx_nm = balikin($rowgrx['nama']);

echo '<strong>['.$grx_nip.']. '.$grx_nm.'</strong>
</td>
</tr>
</table>
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<strong>Kelas/Pelajaran : </strong>
<br>';
echo '<select name="kprp">
<option value="" selected></option>';

//query
$qkui = mysql_query("SELECT m_guru.*, m_guru_prog_pddkn.*, m_guru_prog_pddkn.kd AS mgkd ".
						"FROM m_guru, m_guru_prog_pddkn ".
						"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"AND m_guru.kd_pegawai = '$gurkd'");
$rkui = mysql_fetch_assoc($qkui);



do
	{
	$kui_kd = nosql($rkui['mgkd']);
	$kui_kelkd = nosql($rkui['kd_kelas']);
	$kui_pelkd = nosql($rkui['kd_prog_pddkn']);


	//kelas
	$qbtx = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$kui_kelkd'");
	$rowbtx = mysql_fetch_assoc($qbtx);
	$kui_kelas = balikin($rowbtx['kelas']);
	$kui_ruang = balikin($rowbtx['ruang']);


	//pddkn
	$qcc2 = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$kui_pelkd'");
	$rcc2 = mysql_fetch_assoc($qcc2);
	$kui_pel = balikin($rcc2['xpel']);

	echo '<option value="'.$kui_kd.'">'.$kui_kelas.' / '.$kui_pel.'</option>';
	}
while ($rkui = mysql_fetch_assoc($qkui));

echo '</select>
<br><br>
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
<br><br>
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
<br><br>

<strong>Lama Mengajar : </strong>
<br>
<input type="text" name="lama" value="'.$lama.'" size="2" maxlength="1" onKeyPress="return numbersonly(this, event)"> Jam
<br><br>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="gurkd" type="hidden" value="'.$gurkd.'">
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
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
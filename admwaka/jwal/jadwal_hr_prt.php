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



//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
$tpl = LoadTpl("../../template/print.html");



nocache;

//nilai
$filenya = "jadwal_prt.php";
$judul = "Jadwal Pelajaran";
$judulku = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$hrkd = nosql($_REQUEST['hrkd']);
$s = nosql($_REQUEST['s']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "pel_hari.php?tapelkd=$tapelkd&smtkd=$smtkd&keakd=$keakd&hrkd=$hrkd&kompkd=$kompkd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
xheadline($judul);

echo '<table width="1000" bgcolor="'.$warnaover.'" cellspacing="0" cellpadding="3">
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


Program Keahlian : ';
//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
				"WHERE kd = '$keakd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['program']);

echo '<strong>'.$keax_pro.'</strong>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Kompetensi Keahlian : ';
//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
				"WHERE kd_keahlian = '$keakd' ".
				"AND kd = '$kompkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['kompetensi']);
$keax_singk = nosql($rowkeax['singkatan']);

echo '<strong>'.$keax_pro.'</strong>,


Hari : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_hari ".
			"WHERE kd = '$hrkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = balikin($rowbtx['hari']);

echo '<strong>'.$btxkelas.'</strong>
</td>
</tr>
</table>
<br>



<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="3%">&nbsp;</td>';

//kelas
$qhri = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kelas LIKE '%$keax_singk%' ".
			"ORDER BY kelas ASC, round(no) ASC");
$rhri = mysql_fetch_assoc($qhri);

do
	{
	$hri_kd = nosql($rhri['kd']);
	$hri_hr = balikin($rhri['kelas']);

	echo '<td><strong>'.$hri_hr.'</strong></td>';
	}
while ($rhri = mysql_fetch_assoc($qhri));

echo '</tr>';


//jam
$qjm = mysql_query("SELECT * FROM m_jam ".
			"ORDER BY round(jam) ASC");
$rjm = mysql_fetch_assoc($qjm);

do
	{
	//nilai
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

	$jm_kd = nosql($rjm['kd']);
	$jm_jam = nosql($rjm['jam']);


	//kelas
	$qhri = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kelas LIKE '%$keax_singk%' ".
				"ORDER BY kelas ASC, round(no) ASC");
	$rhri = mysql_fetch_assoc($qhri);


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td width="3%"><strong>'.$jm_jam.'.</strong></td>';

	do
		{
		$hri_kd = nosql($rhri['kd']);
		$hri_hr = balikin($rhri['kelas']);


		//datane...
		$qdte = mysql_query("SELECT jadwal.kd AS jdkd, jadwal.kd_ruang1 AS rukd1, ".
					"jadwal.kd_ruang2 AS rukd2, jadwal.kd_guru_prog_pddkn AS gpkd ".
					"FROM jadwal ".
					"WHERE jadwal.kd_tapel = '$tapelkd' ".
					"AND jadwal.kd_smt = '$smtkd' ".
					"AND jadwal.kd_keahlian = '$keakd' ".
					"AND jadwal.kd_keahlian_kompetensi = '$kompkd' ".
					"AND jadwal.kd_kelas = '$hri_kd' ".
					"AND jadwal.kd_jam = '$jm_kd' ".
					"AND jadwal.kd_hari = '$hrkd'");
		$rdte = mysql_fetch_assoc($qdte);
		$tdte = mysql_num_rows($qdte);


		echo '<td width="16%">';

		do
			{
			$dte_kd = nosql($rdte['jdkd']);
			$dte_rukd = nosql($rdte['rukd1']);
			$dte_rukd2 = nosql($rdte['rukd2']);
			$dte_gpkd = nosql($rdte['gpkd']);




			//guru ne
			$qku1 = mysql_query("SELECT * FROM m_guru_prog_pddkn ".
						"WHERE kd = '$dte_gpkd'");
			$rku1 = mysql_fetch_assoc($qku1);
			$ku1_gurkd = nosql($rku1['kd_guru']);
			$ku1_progkd = nosql($rku1['kd_prog_pddkn']);


			//guru ne
			$qku2 = mysql_query("SELECT kd_pegawai FROM m_guru ".
						"WHERE kd = '$ku1_gurkd'");
			$rku2 = mysql_fetch_assoc($qku2);
			$ku2_pkd = nosql($rku2['kd_pegawai']);







			//detail e
			$qcc1 = mysql_query("SELECT nip, nama FROM m_pegawai ".
						"WHERE kd = '$ku2_pkd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$dte_nip = nosql($rcc1['nip']);
			$dte_nm = balikin($rcc1['nama']);


			//pddkn
			$qcc2 = mysql_query("SELECT prog_pddkn FROM m_prog_pddkn ".
						"WHERE kd = '$ku1_progkd'");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$dte_pel = balikin($rcc2['prog_pddkn']);



			//ruang e
			$qru1 = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$dte_rukd'");
			$rru1 = mysql_fetch_assoc($qru1);
			$ru1_ruang = balikin($rru1['ruang']);


			//ruang e
			$qru2 = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$dte_rukd2'");
			$rru2 = mysql_fetch_assoc($qru2);
			$ru2_ruang = balikin($rru2['ruang']);


			//nek ada
			if ($tdte != 0)
				{
				echo '<strong>'.$dte_pel.'</strong>
				<br>
				<em>'.$dte_nip.'. '.$dte_nm.'.</em>
				<br>
				[Ruang : '.$ru1_ruang.', '.$ru2_ruang.'].
				<br>';
				}
			else
				{
				echo '-';
				}
			}
		while ($rdte = mysql_fetch_assoc($qdte));

		echo '</td>';
		}
	while ($rhri = mysql_fetch_assoc($qhri));

	echo '</tr>';
	}
while ($rjm = mysql_fetch_assoc($qjm));

echo '</table>
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
xclose($koneksi);
exit();
?>
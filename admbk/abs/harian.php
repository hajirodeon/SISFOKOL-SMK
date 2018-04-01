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
require("../../inc/cek/admbk.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "harian.php";
$judul = "Absensi Harian Siswa";
$judulku = "[$bk_session : $nip91_session.$nm91_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$swkd = nosql($_REQUEST['swkd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$ke = "$filenya?tapelkd=$tapelkd&keakd=$keakd&kompkd=$kompkd&kelkd=$kelkd&".
		"swkd=$swkd&ubln=$ubln&uthn=$uthn";



//cacah tapel
$qtpel = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rtpel = mysql_fetch_assoc($qtpel);
$tpel_thn1 = nosql($rtpel['tahun1']);
$tpel_thn2 = nosql($rtpel['tahun2']);


//siswa kelas
$qsike = mysql_query("SELECT * FROM siswa_kelas ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND kd_keahlian = '$keakd' ".
			"AND kd_keahlian_kompetensi = '$kompkd' ".
			"AND kd_kelas = '$kelkd' ".
			"AND kd_siswa = '$swkd'");
$rsike = mysql_fetch_assoc($qsike);
$sike_kd = nosql($rsike['kd']);




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

else if (empty($swkd))
	{
	$diload = "document.formx.siswa.focus();";
	}

else if (empty($ubln))
	{
	$diload = "document.formx.ubln.focus();";
	}

else if (empty($uthn))
	{
	$diload = "document.formx.uthn.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);
	$swkd = nosql($_POST['swkd']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tkhir = nosql($_POST['tkhir']);


	//looping
	for ($p=1;$p<=$tkhir;$p++)
		{
		$xijam = "ijam";
		$xijam1 = "$xijam$p";
		$xijamxx = nosql($_POST["$xijam1"]);

		$ximnt = "imnt";
		$ximnt1 = "$ximnt$p";
		$ximntxx = nosql($_POST["$ximnt1"]);

		$xiabs = "iabs";
		$xiabs1 = "$xiabs$p";
		$xiabsxx = nosql($_POST["$xiabs1"]);

		$xiperlu = "iperlu";
		$xiperlu1 = "$xiperlu$p";
		$xiperluxx = cegah($_POST["$xiperlu1"]);


		//khusus
		$tgl_abs = "$uthn:$ubln:$p";
		$jam_abs = "$xijamxx:$ximntxx";


		//cek
		$qcc = mysql_query("SELECT * FROM siswa_absensi ".
					"WHERE kd_siswa_kelas = '$sike_kd' ".
					"AND round(DATE_FORMAT(tgl, '%d')) = '$p' ".
					"AND round(DATE_FORMAT(tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(tgl, '%Y')) = '$uthn'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_sakd = nosql($rcc['kd']);
		$cc_abskd = nosql($rcc['kd_absensi']);



		//nek ada
		if ($tcc != 0)
			{
			//cek, jika berbeda
			if ($cc_abskd <> $xiabsxx)
				{
				//update
				mysql_query("UPDATE siswa_absensi SET kd_absensi = '$xiabsxx', ".
						"jam = '$jam_abs', ".
						"keperluan = '$xiperluxx', ".
						"postdate = '$today' ".
						"WHERE kd = '$cc_sakd'");
				}
			else
				{
				//update
				mysql_query("UPDATE siswa_absensi SET kd_absensi = '$xiabsxx', ".
						"jam = '$jam_abs', ".
						"keperluan = '$xiperluxx' ".
						"WHERE kd = '$cc_sakd'");
				}
			}
		else
			{
			//insert
			$xx = md5("$x$p");

			mysql_query("INSERT INTO siswa_absensi(kd, kd_siswa_kelas, kd_absensi, tgl, jam, keperluan) VALUES ".
					"('$xx', '$sike_kd', '$xiabsxx', '$tgl_abs', '$jam_abs', '$xiperluxx')");
			}
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//menu
require("../../inc/menu/admbk.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
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
$qprgx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd = '$kompkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['kompetensi']);
$prgx_singk = nosql($rowprgx['singkatan']);

echo '<option value="'.$prgx_kd.'">'.$prgx_prog.'</option>';

$qprg = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowprg = mysql_fetch_assoc($qprg);

do
	{
	$prg_kd = nosql($rowprg['kd']);
	$prg_prog = balikin($rowprg['kompetensi']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$prg_kd.'">'.$prg_prog.'</option>';
	}
while ($rowprg = mysql_fetch_assoc($qprg));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna01.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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
			"AND kelas LIKE '%$prgx_singk%' ".
			"ORDER BY kelas ASC, no ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,


Siswa : ';
echo "<select name=\"siswa\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qswx = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_keahlian = '$keakd' ".
			"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_siswa = '$swkd'");
$rowswx = mysql_fetch_assoc($qswx);
$swx_kd = nosql($rowswx['mskd']);
$swx_nis = nosql($rowswx['nis']);
$swx_nm = balikin($rowswx['nama']);


echo '<option value="'.$swx_kd.'">'.$swx_nis.'. '.$swx_nm.'</option>';

$qsw = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_keahlian = '$keakd' ".
			"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_siswa <> '$swkd' ".
			"ORDER BY round(m_siswa.nis) ASC");
$rowsw = mysql_fetch_assoc($qsw);

do
	{
	$sw_kd = nosql($rowsw['mskd']);
	$sw_nis = nosql($rowsw['nis']);
	$sw_nm = balikin($rowsw['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&swkd='.$sw_kd.'">'.$sw_nis.'. '.$sw_nm.'</option>';
	}
while ($rowsw = mysql_fetch_assoc($qsw));

echo '</select>,


Bulan : ';
echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kompkd='.$kompkd.'&keakd='.$keakd.'&kelkd='.$kelkd.''.
				'&swkd='.$swkd.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kompkd='.$kompkd.'&keakd='.$keakd.'&kelkd='.$kelkd.''.
				'&swkd='.$swkd.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>



<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="keakd" type="hidden" value="'.$keakd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="swkd" type="hidden" value="'.$swkd.'">
<input name="ubln" type="hidden" value="'.$ubln.'">
<input name="uthn" type="hidden" value="'.$uthn.'">

</td>
</tr>
</table>
<br>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
	}
else if (empty($keakd))
	{
	echo '<font color="#FF0000"><strong>PROGRAM KEAHLIAN Belum Dipilih...!</strong></font>';
	}
else if (empty($kompkd))
	{
	echo '<font color="#FF0000"><strong>KOMPETENSI KEAHLIAN Belum Dipilih...!</strong></font>';
	}
else if (empty($kelkd))
	{
	echo '<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>';
	}
else if (empty($swkd))
	{
	echo '<font color="#FF0000"><strong>SISWA Belum Dipilih...!</strong></font>';
	}
else if (empty($_REQUEST['ubln']))
	{
	echo '<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>';
	}
else if (empty($_REQUEST['uthn']))
	{
	echo '<font color="#FF0000"><strong>TAHUN Belum Dipilih...!</strong></font>';
	}
else
	{
	echo '<table width="750" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
    	<td width="30"><strong>Tgl.</strong></td>
	<td width="75"><strong>Hari</strong></td>
	<td width="150"><strong>Jam</strong></td>
	<td width="100"><strong>Ket.</strong></td>
	<td><strong>Keperluan</strong></td>
	<td width="150"><strong>Postdate</strong></td>
	</tr>';

	//mendapatkan jumlah tanggal maksimum dalam suatu bulan
	$tgl = 0;
	$bulan = $ubln;
	$bln = $bulan + 1;
	$thn = $uthn;

	$lastday = mktime (0,0,0,$bln,$tgl,$thn);

	//total tanggal dalam sebulan
	$tkhir = strftime ("%d", $lastday);

	//lopping tgl
	for ($i=1;$i<=$tkhir;$i++)
		{
		//ketahui harinya
		$day = $i;
		$month = $bulan;
		$year = $thn;


		//mencari hari
		$a = substr($year, 2);
			//mengambil dua digit terakhir tahun

		$b = (int)($a/4);
			//membagi tahun dengan 4 tanpa memperhitungkan sisa

		$c = $month;
			//mengambil angka bulan

		$d = $day;
			//mengambil tanggal

		$tot1 = $a + $b + $c + $d;
			//jumlah sementara, sebelum dikurangani dengan angka kunci bulan

		//kunci bulanan
		if ($c == 1)
			{
			$kunci = "2";
			}

		else if ($c == 2)
			{
			$kunci = "7";
			}

		else if ($c == 3)
			{
			$kunci = "1";
			}

		else if ($c == 4)
			{
			$kunci = "6";
			}

		else if ($c == 5)
			{
			$kunci = "5";
			}

		else if ($c == 6)
			{
			$kunci = "3";
			}

		else if ($c == 7)
			{
			$kunci = "2";
			}

		else if ($c == 8)
			{
			$kunci = "7";
			}

		else if ($c == 9)
			{
			$kunci = "5";
			}

		else if ($c == 10)
			{
			$kunci = "4";
			}

		else if ($c == 11)
			{
			$kunci = "2";
			}

		else if ($c == 12)
			{
			$kunci = "1";
			}

		$total = $tot1 - $kunci;

		//angka hari
		$hari = $total%7;

		//jika angka hari == 0, sebenarnya adalah 7.
		if ($hari == 0)
			{
			$hari = ($hari +7);
			}

		//kabisat, tahun habis dibagi empat alias tanpa sisa
		$kabisat = (int)$year % 4;

		if ($kabisat ==0)
			{
			$hri = $hri-1;
			}



		//hari ke-n
		if ($hari == 3)
			{
			$hri = 4;
			$dino = "Rabu";
			}

		else if ($hari == 4)
			{
			$hri = 5;
			$dino = "Kamis";
			}

		else if ($hari == 5)
			{
			$hri = 6;
			$dino = "Jum'at";
			}

		else if ($hari == 6)
			{
			$hri = 7;
			$dino = "Sabtu";
			}

		else if ($hari == 7)
			{
			$hri = 1;
			$dino = "Minggu";
			}

		else if ($hari == 1)
			{
			$hri = 2;
			$dino = "Senin";
			}

		else if ($hari == 2)
			{
			$hri = 3;
			$dino = "Selasa";
			}


		//nek minggu, abang ngi wae
		if ($hri == 1)
			{
			$warna = "red";
			$mggu_attr = "disabled";
			}
		else
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				$mggu_attr = "";
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				$mggu_attr = "";
				}
			}


		//nilai data
		$qdtf = mysql_query("SELECT * FROM siswa_absensi ".
					"WHERE kd_siswa_kelas = '$sike_kd' ".
					"AND round(DATE_FORMAT(tgl, '%d')) = '$i' ".
					"AND round(DATE_FORMAT(tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(tgl, '%Y')) = '$uthn'");
		$rdtf = mysql_fetch_assoc($qdtf);
		$dtf_perlu = balikin($rdtf['keperluan']);
		$dtf_abskd = balikin($rdtf['kd_absensi']);
		$dtf_postdate = $rdtf['postdate'];
		$dtf_jam_xjam = substr($rdtf['jam'],0,2);
		$dtf_jam_xmnt = substr($rdtf['jam'],3,2);

		//nek empty
		if ($dtf_jam_xjam == "00")
			{
			$dtf_jam_xjam = "";

			if ($dtf_jam_xmnt == "00")
				{
				$dtf_jam_xmnt = "";
				}
			}




		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i.'.</td>
		<td>'.$dino.'</td>
		<td>
		<input name="ijam'.$i.'" type="text" value="'.$dtf_jam_xjam.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)" '.$mggu_attr.'>
		<input name="imnt'.$i.'" type="text" value="'.$dtf_jam_xmnt.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)" '.$mggu_attr.'>
		</td>
		<td>';

		echo '<select name="iabs'.$i.'" '.$mggu_attr.'>';

		//absensinya
		$qbein = mysql_query("SELECT * FROM m_absensi ".
								"WHERE kd = '$dtf_abskd'");
		$rbein = mysql_fetch_assoc($qbein);
		$bein_kd = nosql($rbein['kd']);
		$bein_abs = balikin($rbein['absensi']);


		echo '<option value="'.$bein_kd.'" selected>'.$bein_abs.'</option>';

		//absensi
		$qsen = mysql_query("SELECT * FROM m_absensi ".
								"WHERE kd <> '$bein_kd' ".
								"ORDER BY absensi ASC");
		$rsen = mysql_fetch_assoc($qsen);

		do
			{
			$sen_kd = nosql($rsen['kd']);
			$sen_abs = balikin($rsen['absensi']);

			echo '<option value="'.$sen_kd.'">'.$sen_abs.'</option>';
			}
		while ($rsen = mysql_fetch_assoc($qsen));

		echo '</select>';


		echo '</td>
		<td>
		<input name="iperlu'.$i.'" type="text" value="'.$dtf_perlu.'" size="20" '.$mggu_attr.'>
		</td>
		<td>
		'.$dtf_postdate.'
		</td>
		</tr>';
		}

	echo '</table>
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="keakd" type="hidden" value="'.$keakd.'">
	<input name="kompkd" type="hidden" value="'.$kompkd.'">
	<input name="kelkd" type="hidden" value="'.$kelkd.'">
	<input name="swkd" type="hidden" value="'.$swkd.'">
	<input name="ubln" type="hidden" value="'.$ubln.'">
	<input name="uthn" type="hidden" value="'.$uthn.'">
	<input name="tkhir" type="hidden" value="'.$tkhir.'">
	<input name="btnSMP" type="submit" value="SIMPAN">';
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
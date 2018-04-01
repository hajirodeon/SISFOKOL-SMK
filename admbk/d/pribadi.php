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
require("../../inc/class/paging.php");
require("../../inc/cek/admbk.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "pribadi.php";
$judul = "Penilaian Sikap/Perilaku/Pribadi Siswa";
$judulku = "[$bk_session : $nip91_session.$nm91_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
		"keahkd=$keahkd&kompkd=$kompkd&page=$page";



//PROSES //////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$jml = nosql($_POST['jml']);


	for ($k=1;$k<=$jml;$k++)
		{
		$xkdt = "skkd";
		$xkdt1 = "$k$xkdt";
		$xkdtxx = nosql($_POST["$xkdt1"]);


		//query
		$qkst = mysql_query("SELECT * FROM m_pribadi ".
					"ORDER BY pribadi ASC");
		$rkst = mysql_fetch_assoc($qkst);
		$tkst = mysql_num_rows($qkst);

		//ambil semua
		do
			{
			//nilai
			$noxzi = $noxzi + 1;
			$xyz = md5("$x$noxzi$K");
			$t_kd = nosql($rkst['kd']);

			$xkst = "predikat";
			$xkst1 = "$k$xkst$t_kd";
			$xkstxx = nosql($_POST["$xkst1"]);

			$xket = "ket";
			$xket1 = "$k$xket$t_kd";
			$xketxx = nosql($_POST["$xket1"]);


			//cek
			$qcc = mysql_query("SELECT * FROM siswa_pribadi ".
						"WHERE kd_siswa_kelas = '$xkdtxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_pribadi = '$t_kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE siswa_pribadi SET predikat = '$xkstxx', ".
						"ket = '$xketxx' ".
						"WHERE kd_siswa_kelas = '$xkdtxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_pribadi = '$t_kd'");
				}
			//jika blm ada
			else
				{
				mysql_query("INSERT INTO siswa_pribadi(kd, kd_siswa_kelas, kd_smt, kd_pribadi, predikat, ket) VALUES ".
						"('$xyz', '$xkdtxx', '$smtkd', '$t_kd', '$xkstxx', '$xketxx')");
				}
			}
		while ($rkst = mysql_fetch_assoc($qkst));
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}





//jika reset
if ($_POST['btnRST'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$jml = nosql($_POST['jml']);


	for ($k=1;$k<=$jml;$k++)
		{
		$xkdt = "skkd";
		$xkdt1 = "$k$xkdt";
		$xkdtxx = nosql($_POST["$xkdt1"]);



		//query
		$qkst = mysql_query("SELECT * FROM m_pribadi ".
					"ORDER BY pribadi ASC");
		$rkst = mysql_fetch_assoc($qkst);
		$tkst = mysql_num_rows($qkst);

		//ambil semua
		do
			{
			//nilai
			$noxzi = $noxzi + 1;
			$xyz = md5("$x$noxzi");
			$t_kd = nosql($rkst['kd']);


			//update null
			mysql_query("DELETE FROM siswa_pribadi ".
					"WHERE kd_siswa_kelas = '$xkdtxx' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_pribadi = '$t_kd'");
			}
		while ($rkst = mysql_fetch_assoc($qkst));
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}
///////////////////////////////////////////////////////////////////////////////////////////////////



//focus....focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($keahkd))
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
else if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}



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
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
xheadline($judul);



echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
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
$qprgx = mysql_query("SELECT * FROM m_keahlian ".
				"WHERE kd = '$keahkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['program']);

echo '<option value="'.$prgx_kd.'">'.$prgx_prog.'</option>';

$qprg = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keahkd' ".
			"ORDER BY program ASC");
$rowprg = mysql_fetch_assoc($qprg);

do
	{
	$prg_kd = nosql($rowprg['kd']);
	$prg_prog = balikin($rowprg['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keahkd='.$prg_kd.'">'.$prg_prog.'</option>';
	}
while ($rowprg = mysql_fetch_assoc($qprg));

echo '</select>,




Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qprgx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keahkd' ".
			"AND kd = '$kompkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['kompetensi']);
$prgx_singk = nosql($rowprgx['singkatan']);

echo '<option value="'.$prgx_kd.'">'.$prgx_prog.'</option>';

$qprg = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keahkd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowprg = mysql_fetch_assoc($qprg);

do
	{
	$prg_kd = nosql($rowprg['kd']);
	$prg_prog = balikin($rowprg['kompetensi']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$prg_kd.'">'.$prg_prog.'</option>';
	}
while ($rowprg = mysql_fetch_assoc($qprg));

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
$btxno = nosql($rowbtx['no']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd <> '$kelkd' ".
			"AND kelas LIKE '%$prgx_singk%' ".
			"ORDER BY kelas ASC, ".
			"round(no) ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,


Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="keahkd" type="hidden" value="'.$keahkd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="page" type="hidden" value="'.$page.'">
<br>';


//nek drg
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
	}

else if (empty($keahkd))
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

else if (empty($smtkd))
	{
	echo '<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>';
	}


else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
			"siswa_kelas.*, siswa_kelas.kd AS skkd ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_keahlian = '$keahkd' ".
			"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
			"ORDER BY round(m_siswa.nis) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&smtkd=$smtkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);




	echo '<br>
	<table width="900" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>NIS</strong></td>
	<td valign="top"><strong>Nama</strong></td>';

	//daftar pribadi
	$qdt = mysql_query("SELECT * FROM m_pribadi ".
				"ORDER BY pribadi ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_kd = nosql($rdt['kd']);
		$dt_pribadi = balikin($rdt['pribadi']);

		echo '<td width="150"><strong>'.$dt_pribadi.'</strong></td>';
		}
	while ($rdt = mysql_fetch_assoc($qdt));

	echo '<td width="150" valign="top"><strong>Prestasi</strong></td>
	</tr>';

	if ($count != 0)
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

			$nomer = $nomer + 1;
			$i_kd = nosql($data['mskd']);
			$skkd = nosql($data['skkd']);
			$kd_kelas = nosql($data['kd_kelas']);
			$nis = nosql($data['nis']);
			$nama = balikin($data['nama']);




			//data point prestasi
			$qdtx2 = mysql_query("SELECT SUM(m_bk_prestasi.point) AS poi ".
						"FROM m_bk_prestasi, siswa_prestasi ".
						"WHERE siswa_prestasi.kd_prestasi = m_bk_prestasi.kd ".
						"AND siswa_prestasi.kd_siswa = '$i_kd'");
			$rdtx2 = mysql_fetch_assoc($qdtx2);
			$dtx2_point = nosql($rdtx2['poi']);

			//jika null
			if (empty($dtx2_point))
				{
				$dtx2_point = "0";
				}



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">
			'.$nis.'
			<INPUT type="hidden" name="'.$nomer.'skkd" value="'.$skkd.'">
			</td>
			<td valign="top">
			'.$nama.'
			</td>';


			//daftar pribadi
			$qdt = mysql_query("SELECT * FROM m_pribadi ".
						"ORDER BY pribadi ASC");
			$rdt = mysql_fetch_assoc($qdt);

			do
				{
				//nilai
				$dt_kd = nosql($rdt['kd']);
				$dt_pribadi = balikin($rdt['pribadi']);




				//pertimbangan dari point yang ada
				//data point pelanggaran
				$qdtx = mysql_query("SELECT SUM(m_bk_point.point) AS poi ".
							"FROM m_bk_point, m_bk_point_jenis, siswa_pelanggaran ".
							"WHERE siswa_pelanggaran.kd_point = m_bk_point.kd ".
							"AND m_bk_point.kd_jenis = m_bk_point_jenis.kd ".
							"AND siswa_pelanggaran.kd_siswa = '$i_kd' ".
							"AND m_bk_point_jenis.kd_pribadi = '$dt_kd'");
				$rdtx = mysql_fetch_assoc($qdtx);
				$dtx_point = nosql($rdtx['poi']);

				//jika null
				if (empty($dtx_point))
					{
					$dtx_point = "0";
					}



				//pribadinya...
				$qprix = mysql_query("SELECT * FROM siswa_pribadi ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_pribadi = '$dt_kd'");
				$rprix = mysql_fetch_assoc($qprix);
				$tprix = mysql_num_rows($qprix);
				$prix_predikat = nosql($rprix['predikat']);
				$prix_ket = balikin($rprix['ket']);



				echo '<td>
				<strong>'.$dtx_point.'</strong> Point.
				<br>
				<select name="'.$nomer.'predikat'.$dt_kd.'">
				<option value="'.$prix_predikat.'" selected>'.$prix_predikat.'</option>
				<option value="B">B (0 - 60)</option>
				<option value="C">C (61 - 99)</option>
				<option value="K">K (100 <=)</option>
				</select>
				<br>
				<input name="'.$nomer.'ket'.$dt_kd.'" type="text" size="10" value="'.$prix_ket.'">
				</td>';
				}
			while ($rdt = mysql_fetch_assoc($qdt));


			echo '<td><strong>'.$dtx2_point.'</strong> Point.</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));
		}

	echo '</table>';



	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="250">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnRST" type="submit" value="RESET">
	<input name="jml" type="hidden" value="'.$count.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="total" type="hidden" value="'.$count.'">
	<font color="#FF0000"><strong>'.$count.'</strong></font> Data.
	</tr>
	</table>
	</form>';
	}


echo '<br>
<br>
<br>';


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
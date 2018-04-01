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
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nil_absensi.php";
$judul = "Absensi";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$s = nosql($_REQUEST['s']);
$pertemuan = nosql($_REQUEST['pertemuan']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page&".
			"pertemuan=$pertemuan&utgl=$utgl&ubln=$ubln&uthn=$uthn";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$pertemuan = nosql($_POST['pertemuan']);
	$utgl = nosql($_POST['utgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_absen = "$uthn:$ubln:$utgl";
	$page = nosql($_POST['page']);


	//hapus
	mysql_query("DELETE FROM siswa_nilai_absensi ".
					"WHERE kd_smt = '$smtkd' ".
					"AND kd_prog_pddkn = '$progkd' ".
					"AND pertemuan = '$pertemuan'");

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd";
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$pertemuan = nosql($_POST['pertemuan']);
	$utgl = nosql($_POST['utgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_absen = "$uthn:$ubln:$utgl";
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//daftar siswa
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"ORDER BY m_siswa.nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	do
		{
		//nilai
		$i_nomer = $i_nomer + 1;
		$xyz = md5("$x$i_nomer");
		$i_skkd = nosql($data['skkd']);
		$i_nis = nosql($data['nis']);
		$i_nama = balikin($data['nama']);


		//ambil nilai
		$xnh1 = "nilai";
		$xnh2 = "$i_skkd$xnh1";
		$xnhx = nosql($_POST["$xnh2"]);


		//cek
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_absensi ".
								"WHERE kd_siswa_kelas = '$i_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd' ".
								"AND pertemuan = '$pertemuan'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);


		//jika ada, update
		if ($txpel != 0)
			{
			mysql_query("UPDATE siswa_nilai_absensi SET tanggal = '$tgl_absen', ".
							"kd_absensi = '$xnhx' ".
							"WHERE kd_siswa_kelas = '$i_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd' ".
							"AND pertemuan = '$pertemuan'");
			}

		//jika blm ada, insert
		else
			{
			mysql_query("INSERT INTO siswa_nilai_absensi(kd, kd_siswa_kelas, tanggal, kd_absensi, ".
							"pertemuan, kd_smt, kd_prog_pddkn) VALUES ".
							"('$xyz', '$i_skkd', '$tgl_absen', '$xnhx', ".
							"'$pertemuan', '$smtkd', '$progkd')");
			}
		}
	while ($data = mysql_fetch_assoc($result));



	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&".
				"smtkd=$smtkd&progkd=$progkd&pertemuan=$pertemuan&".
				"utgl=$utgl&ubln=$ubln&uthn=$uthn";
	xloc($ke);
	exit();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//focus....focus...
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}

else if (empty($pertemuan))
	{
	$diload = "document.formx.pertemuan.focus();";
	}

else if (empty($utgl))
	{
	$diload = "document.formx.utglx.focus();";
	}

else if (empty($ubln))
	{
	$diload = "document.formx.ublnx.focus();";
	}




//isi *START
ob_start();

//menu
require("../../inc/menu/admgr.php");

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


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php?tapelkd='.$tapelkd.'" title="Daftar Standar Mata Pelajaran">Daftar Mata Pelajaran</a>]</td>
</tr>
</table>

<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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



Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&progkd='.$progkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>


<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mata Pelajaran : ';

//terpilih
$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd = '$progkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_pel = balikin($rowstdx['prog_pddkn']);

echo '<strong>'.$stdx_pel.'</strong>
</td>
</tr>
</table>


<p>
Pertemuan Ke-';
echo "<select name=\"pertemuan\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$pertemuan.'" selected>'.$pertemuan.'</option>';

for ($i=1;$i<=31;$i++)
	{
	//cek, jika suatu pertemuan telah entri...
	$qcc = mysql_query("SELECT siswa_nilai_absensi.*, ".
				"round(DATE_FORMAT(tanggal, '%d')) AS tgl, ".
				"round(DATE_FORMAT(tanggal, '%m')) AS bln, ".
				"round(DATE_FORMAT(tanggal, '%Y')) AS thn ".
				"FROM siswa_kelas, siswa_nilai_absensi ".
				"WHERE siswa_nilai_absensi.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kelkd' ".
				"AND siswa_nilai_absensi.kd_smt = '$smtkd' ".
				"AND siswa_nilai_absensi.kd_prog_pddkn = '$progkd' ".
				"AND siswa_nilai_absensi.pertemuan = '$i'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);
	$cc_tgl = nosql($rcc['tgl']);
	$cc_bln = nosql($rcc['bln']);
	$cc_thn = nosql($rcc['thn']);

	echo'<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&progkd='.$progkd.'&smtkd='.$smtkd.'&pertemuan='.$i.'&utgl='.$cc_tgl.'&ubln='.$cc_bln.'&uthn='.$cc_thn.'">'.$i.' ['.$cc_tgl.' '.$arrbln[$cc_bln].''.$cc_thn.']</option>';
	}

echo '</select>,

Tanggal : ';
echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&smtkd='.$smtkd.'&pertemuan='.$pertemuan.'&utgl='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&smtkd='.$smtkd.'&pertemuan='.$pertemuan.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&smtkd='.$smtkd.'&pertemuan='.$pertemuan.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>
</p>';




//nek drg
if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($pertemuan))
	{
	echo '<p>
	<font color="#FF0000"><strong>PERTEMUAN Ke Barapa...?</strong></font>
	</p>';
	}

else if (empty($utgl))
	{
	echo '<p>
	<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!!</strong></font>
	</p>';
	}

else if (empty($ubln))
	{
	echo '<p>
	<font color="#FF0000"><strong>BULAN Belum Dipilih...!!</strong></font>
	</p>';
	}

else
	{
	//daftar siswa
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"ORDER BY m_siswa.nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&".
					"progkd=$progkd&smtkd=$smtkd&".
					"pertemuan=$pertemuan&utgl=$utgl&ubln=$ubln&uthn=$uthn";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>NIS</strong></td>
	<td><strong>NAMA</strong></td>
	<td width="50"><strong>Ket.</strong></td>';

	//daftar absensi
	$qabs = mysql_query("SELECT * FROM m_absensi ".
				"ORDER BY absensi2 ASC");
	$rabs = mysql_fetch_assoc($qabs);

	do
		{
		//nilai
		$abs_kd = nosql($rabs['kd']);
		$abs_absensi2 = nosql($rabs['absensi2']);

		echo '<td width="50"><strong>Jml. '.$abs_absensi2.'</strong></td>';
		}
	while ($rabs = mysql_fetch_assoc($qabs));

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

		$std_skkd = nosql($data['skkd']);
		$std_no = nosql($data['no_absen']);
		$std_nis = nosql($data['nis']);
		$std_nama = balikin($data['nama']);


		//nilai ne...
		$qxnil = mysql_query("SELECT m_absensi.*, m_absensi.kd AS makd, ".
					"siswa_nilai_absensi.* ".
					"FROM m_absensi, siswa_nilai_absensi ".
					"WHERE siswa_nilai_absensi.kd_absensi = m_absensi.kd ".
					"AND siswa_nilai_absensi.kd_siswa_kelas = '$std_skkd' ".
					"AND siswa_nilai_absensi.kd_smt = '$smtkd' ".
					"AND siswa_nilai_absensi.kd_prog_pddkn = '$progkd' ".
					"AND siswa_nilai_absensi.pertemuan = '$pertemuan'");
		$rxnil = mysql_fetch_assoc($qxnil);
		$txnil = mysql_num_rows($qxnil);
		$xnil_makd = nosql($rxnil['makd']);
		$xnil_absensi2 = nosql($rxnil['absensi2']);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$std_nis.'
		</td>
		<td>
		'.$std_nama.'
		</td>
		<td>';


		echo '<select name="'.$std_skkd.'nilai">
		<option value="'.$xnil_makd.'" selected>'.$xnil_absensi2.'</option>';


		//daftar absensi
		$qabs = mysql_query("SELECT * FROM m_absensi ".
										"ORDER BY absensi2 ASC");
		$rabs = mysql_fetch_assoc($qabs);

		do
			{
			//nilai
			$abs_kd = nosql($rabs['kd']);
			$abs_absensi2 = nosql($rabs['absensi2']);

			echo '<option value="'.$abs_kd.'">'.$abs_absensi2.'</option>';
			}
		while ($rabs = mysql_fetch_assoc($qabs));
		
		echo '<option value="">-</option>';

		echo '</select>
		</td>';

		//daftar absensi
		$qabs = mysql_query("SELECT * FROM m_absensi ".
										"ORDER BY absensi2 ASC");
		$rabs = mysql_fetch_assoc($qabs);

		do
			{
			//nilai
			$abs_kd = nosql($rabs['kd']);

			//total...
			$qsubx = mysql_query("SELECT * FROM siswa_nilai_absensi ".
											"WHERE kd_siswa_kelas = '$std_skkd' ".
											"AND kd_smt = '$smtkd' ".
											"AND kd_prog_pddkn = '$progkd' ".
											"AND kd_absensi = '$abs_kd'");
			$rsubx = mysql_fetch_assoc($qsubx);
			$tsubx = mysql_num_rows($qsubx);

			echo '<td width="50">'.$tsubx.'</td>';
			}
		while ($rabs = mysql_fetch_assoc($qabs));
		
		echo '</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>

	<table width="600" border="0" cellspacing="0" cellpadding="3">
 	<tr>
   	<td width="200">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="kelkd" type="hidden" value="'.$kelkd.'">
	<input name="smtkd" type="hidden" value="'.$smtkd.'">
	<input name="progkd" type="hidden" value="'.$progkd.'">
	<input name="pertemuan" type="hidden" value="'.$pertemuan.'">
	<input name="utgl" type="hidden" value="'.$utgl.'">
	<input name="ubln" type="hidden" value="'.$ubln.'">
	<input name="uthn" type="hidden" value="'.$uthn.'">
	<input name="btnHPS" type="submit" value="HAPUS">
	<input name="btnSMP" type="submit" value="SIMPAN">
	</td>
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
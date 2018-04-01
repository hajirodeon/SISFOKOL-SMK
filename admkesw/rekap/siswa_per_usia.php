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
require("../../inc/cek/admkesw.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_per_usia.php";
$judul = "Rekap Data : Siswa (Berdasarkan Usia)";
$judulku = "[$kesw_session : $nip12_session. $nm12_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&page=$page";








//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($utgl))
	{
	$diload = "document.formx.utglx.focus();";
	}
else if (empty($ubln))
	{
	$diload = "document.formx.ublnx.focus();";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi *START
ob_start();

//menu
require("../../inc/menu/admkesw.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="500">
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


Tanggal : ';
echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$itgl.'">'.$itgl.'</option>';
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

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="utgl" type="hidden" value="'.$utgl.'">
<input name="ubln" type="hidden" value="'.$ubln.'">
<input name="uthn" type="hidden" value="'.$uthn.'">
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
	}
else if ((empty($utgl)) OR (empty($ubln)) OR (empty($uthn)))
	{
	echo '<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!</strong></font>';
	}

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT DISTINCT(m_siswa.nis) AS msnis ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"ORDER BY m_siswa.nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);




	//nek ada
	if ($count != 0)
		{
		echo '<p>
		[<a href="siswa_per_usia_pdf.php?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'"><img src="'.$sumber.'/img/pdf.gif" border="0" width="16" height="16"></a>]
		</p>

		<table width="100%" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td width="50"><strong>NISN</strong></td>
		<td width="150"><strong>Nama</strong></td>
		<td width="5"><strong>L/P</strong></td>
		<td width="150"><strong>TTL.</strong></td>
		<td width="10"><strong>Usia</strong></td>
		<td width="100"><strong>Asal Sekolah</strong></td>
		<td width="75"><strong>R.UASBN</strong></td>
		<td width="75"><strong>Nama ORTU</strong></td>
		<td width="75"><strong>Pddkn. ORTU</strong></td>
		<td width="75"><strong>Pekerjaan ORTU</strong></td>
		<td><strong>Alamat</strong></td>
		</tr>';

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
			$i_nis = nosql($data['msnis']);

			//detail
			$qdtx = mysql_query("SELECT m_siswa.*, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
						"m_siswa.kd AS mskd ".
						"FROM m_siswa ".
						"WHERE m_siswa.nis = '$i_nis'");
			$rdtx = mysql_fetch_assoc($qdtx);

			$i_kd = nosql($rdtx['mskd']);
			$i_nisn = nosql($rdtx['nisn']);
			$i_nama = balikin($rdtx['nama']);
			$i_kd_kelamin = nosql($rdtx['kd_kelamin']);
			$i_tmp_lahir = balikin2($rdtx['tmp_lahir']);
			$i_tgl_lahir = nosql($rdtx['tgl']);
			$i_bln_lahir = nosql($rdtx['bln']);
			$i_thn_lahir = nosql($rdtx['thn']);


			//kelamin
			$qmin = mysql_query("SELECT * FROM m_kelamin ".
						"WHERE kd = '$i_kd_kelamin'");
			$rmin = mysql_fetch_assoc($qmin);
			$min_kelamin = balikin2($rmin['kelamin']);


			//orang tua - ayah
			$qtun = mysql_query("SELECT * FROM m_siswa_ayah ".
						"WHERE kd_siswa = '$i_kd'");
			$rtun = mysql_fetch_assoc($qtun);
			$tun_nama = balikin2($rtun['nama']);
			$tun_kd_pendidikan = nosql($rtun['kd_pendidikan']);
			$dt_ayah_pekerjaan = balikin($rtun['kd_pekerjaan']);

			$qayah_pek = mysql_query("SELECT * FROM m_pekerjaan ".
							"WHERE kd = '$dt_ayah_pekerjaan'");
			$rayah_pek = mysql_fetch_assoc($qayah_pek);
			$dt_ayah_pekerjaan = balikin($rayah_pek['pekerjaan']);


			//terpilih
			$qpki = mysql_query("SELECT * FROM m_pendidikan ".
						"WHERE kd = '$tun_kd_pendidikan'");
			$rpki = mysql_fetch_assoc($qpki);
			$dt_ayah_pendidikan = balikin($rpki['pendidikan']);



			//lulusan dari
			$qpend = mysql_query("SELECT * FROM m_siswa_pendidikan ".
						"WHERE kd_siswa = '$i_kd'");
			$rpend = mysql_fetch_assoc($qpend);
			$nama_sekolah = balikin2($rpend['nama_sekolah']);
			$uasbn = nosql($rpend['r_uasbn']);


			//tmp_tinggal
			$qtpg = mysql_query("SELECT * FROM m_siswa_tmp_tinggal ".
						"WHERE kd_siswa = '$i_kd'");
			$rtpg = mysql_fetch_assoc($qtpg);
			$dt_alamat = balikin($rtpg['alamat']);

			//ketahui usianya
			//jika null
			if ((empty($i_thn_lahir)) OR ($i_thn_lahir == "0000"))
				{
				$selisih_thn = 0;
				}
			else
				{
				if (($utgl >= $i_tgl_lahir) AND ($ubln >= $i_bln_lahir) AND ($uthn >= $i_thn_lahir))
					{
					$selisih_thn = round($uthn - $i_thn_lahir);
					}
				else
					{
					$selisih_thn = round($uthn - ($i_thn_lahir + 1));
					}
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">
			'.$i_nis.'
			</td>
			<td valign="top">
			'.$i_nisn.'
			</td>
			<td valign="top">
			'.$i_nama.'
			</td>
			<td valign="top">
			'.$min_kelamin.'
			</td>
			<td valign="top">
			'.$i_tmp_lahir.', '.$i_tgl_lahir.' '.$arrbln1[$i_bln_lahir].' '.$i_thn_lahir.'
			</td>
			<td valign="top">
			'.$selisih_thn.'
			</td>
			<td valign="top">
			'.$nama_sekolah.'
			</td>
			<td valign="top">
			'.$uasbn.'
			</td>

			<td valign="top">
			'.$tun_nama.'
			</td>

			<td valign="top">
			'.$dt_ayah_pendidikan.'
			</td>

			<td valign="top">
			'.$dt_ayah_pekerjaan.'
			</td>

			<td valign="top">
			'.$dt_alamat.'
			</td>

			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="250">
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA</strong>
		</font>.
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
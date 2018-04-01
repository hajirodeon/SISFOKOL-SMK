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
require("../../inc/cek/admwaka.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_kenaikan.php";
$judul = "Kenaikan Kelas";
$judulku = "[$waka_session : $nip10_session. $nm10_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keakd=$keakd&kompkd=$kompkd&skkd=$skkd&swkd=$swkd";




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





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//kenaikan kelas
if ($_POST['btnSMP6'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$tpfkd = nosql($_POST['tpfkd']);
	$tpfthn1 = nosql($_POST['tpfthn1']);
	$tpfthn2 = nosql($_POST['tpfthn2']);
	$kelasx = nosql($_POST['kelasx']);
	$page = nosql($_POST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//nek null
	if (empty($tpfkd))
		{
		//re-direct
		$pesan = "Tahun Pelajaran : $tpfthn1/$tpfthn2, Belum Ada. Silahkan Anda Setting Dahulu Tahun Pelajaran Tersebut...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keakd=$keakd&kompkd=$kompkd";
		pekem($pesan,$ke);
		exit();
		}

	else if (empty($kelasx))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Kenaikan atau Tinggal Kelas, Belum Ditentukan. Silahkan Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keakd=$keakd&kompkd=$kompkd";
		pekem($pesan,$ke);
		exit();
		}

	else
		{
		//looping
		for ($i=1;$i<=$limit;$i++)
			{
			//ambil nilai
			$xyz = md5("$today3$i");
			$yuk = "item";
			$yuhu = "$yuk$i";
			$x_mskd = nosql($_POST["$yuhu"]);


			//siswa_kelas //////////////////////////////////////////////////////////////////////////////
			//cek
			$qcc3 = mysql_query("SELECT * FROM siswa_kelas ".
						"WHERE kd_tapel = '$tpfkd' ".
						"AND kd_keahlian = '$keakd' ".
						"AND kd_keahlian_kompetensi = '$kompkd' ".
						"AND kd_siswa = '$x_mskd'");
			$rcc3 = mysql_fetch_assoc($qcc3);
			$tcc3 = mysql_num_rows($qcc3);


			//nek ada
			if ($tcc3 != 0)
				{
				$x3_skkd = nosql($rcc3['kd']);

				//update
				mysql_query("UPDATE siswa_kelas SET kd_kelas = '$kelasx' ".
						"WHERE kd_tapel = '$tpfkd' ".
						"AND kd_keahlian = '$keakd' ".
						"AND kd_keahlian_kompetensi = '$kompkd' ".
						"AND kd_siswa = '$x_mskd'");
				}
			else
				{
				$x3_skkd = $xyz;

				//insert
				mysql_query("INSERT INTO siswa_kelas(kd, kd_siswa, kd_tapel, ".
						"kd_keahlian, kd_keahlian_kompetensi, kd_kelas) VALUES ".
						"('$xyz', '$x_mskd', '$tpfkd', ".
						"'$keakd', '$kompkd', '$kelasx')");
				}




			//kenaikan /////////////////////////////////////////////////////////////////////////////////
			if ($kelasx == $kelkd)
				{
				//tinggal kelas
				$naik_ket = "false";
				}
			else
				{
				//naik kelas
				$naik_ket = "true";
				}



			//cek
			$qcc1 = mysql_query("SELECT * FROM siswa_naik ".
						"WHERE kd_tapel = '$tpfkd' ".
						"AND kd_siswa_kelas = '$x3_skkd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$tcc1 = mysql_num_rows($qcc1);

			if ($tcc1 != 0)
				{
				//siswa_naik
				mysql_query("UPDATE siswa_naik SET naik = '$naik_ket', ".
						"kd_kelas = '$kelasx' ".
						"WHERE kd_tapel = '$tpfkd' ".
						"AND kd_siswa_kelas = '$x3_skkd'");
				}
			else
				{
				//siswa_naik
				mysql_query("INSERT INTO siswa_naik(kd, kd_tapel, kd_kelas, kd_siswa_kelas, ".
						"naik) VALUES ".
						"('$xyz', '$tpfkd', '$kelasx', '$x3_skkd', '$naik_ket')");
				}
			}
		}



	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keakd=$keakd&kompkd=$kompkd&page=$page";
	xloc($ke);
	exit();
	}





//kelulusan
if ($_POST['btnSMP7'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$tpfkd = nosql($_POST['tpfkd']);
	$lulus = nosql($_POST['lulus']);
	$page = nosql($_POST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}



	//nek null
	if (empty($lulus))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Kelulusan Belum Ditentukan. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keakd=$keakd&kompkd=$kompkd";
		pekem($pesan,$ke);
		exit();
		}

	else
		{
		//looping
		for ($i=1;$i<=$limit;$i++)
			{
			//ambil nilai
			$xyz = md5("$today3$i");
			$yuk = "item";
			$yuhu = "$yuk$i";
			$x_skkd = nosql($_POST["$yuhu"]);


			//update
			mysql_query("UPDATE siswa_kelas SET kd_kelas = '$kelasx', ".
					"kd_keahlian = '$keakd', ".
					"kd_keahlian_kompetensi = '$kompkd' ".
					"WHERE kd_tapel = '$tpfkd' ".
					"AND kd = '$x_skkd'");


			//cek
			$qcc = mysql_query("SELECT * FROM siswa_lulus ".
						"WHERE kd_tapel = '$tpfkd' ".
						"AND kd_siswa_kelas = '$x_skkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE siswa_lulus SET lulus = '$lulus' ".
						"WHERE kd_tapel = '$tpfkd' ".
						"AND kd_siswa_kelas = '$x_skkd'");
				}
			else
				{
				//baru
				mysql_query("INSERT INTO siswa_lulus(kd, kd_tapel, kd_siswa_kelas, lulus) VALUES ".
						"('$xyz', '$tpfkd', '$x_skkd', '$lulus')");
				}
			}


		//re-direct
		$pesan = "Lulus atau Tidak Lulus, Berhasil Dilakukan.";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keakd=$keakd&kompkd=$kompkd&smtkd=$smtkd&skkd=$skkd&swkd=$swkd";
		pekem($pesan,$ke);
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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
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
$qprgx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keakd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['program']);

echo '<option value="'.$prgx_kd.'">'.$prgx_prog.'</option>';

$qprg = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keakd' ".
			"ORDER BY program ASC");
$rowprg = mysql_fetch_assoc($qprg);

do
	{
	$prg_kd = nosql($rowprg['kd']);
	$prg_prog = balikin($rowprg['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$prg_kd.'">'.$prg_prog.'</option>';
	}
while ($rowprg = mysql_fetch_assoc($qprg));

echo '</select>,



Kompetensi Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

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
$btxno = nosql($rowbtx['no']);
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

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="keakd" type="hidden" value="'.$keakd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
</td>
</tr>
</table>';



//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($keakd))
	{
	echo '<p>
	<font color="#FF0000"><strong>PROGRAM KEAHLIAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kompkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KOMPETENSI KEAHLIAN Belum Dipilih...!</strong></font>
	</p>';
	}


else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
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
			"AND siswa_kelas.kd_keahlian = '$keakd' ".
			"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
			"ORDER BY round(nis) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keakd=$keakd&kompkd=$kompkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	//nek ada
	if ($count != 0)
		{
		echo '<br>
		<table width="700" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="50"><strong>NIS</strong></td>
		<td width="150"><strong>Nama</strong></td>
		<td><strong>Ket.</strong></td>
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

			$i_nomer = $i_nomer + 1;
			$i_mskd = nosql($data['mskd']);
			$i_nis = nosql($data['nis']);
			$i_nama = balikin($data['nama']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$i_nomer.'" type="hidden" value="'.$i_mskd.'">
			<input type="checkbox" name="item'.$i_nomer.'" value="'.$i_mskd.'">
			</td>
			<td valign="top">
			'.$i_nis.'
			</td>
			<td valign="top">
			'.$i_nama.'
			</td>
			<td valign="top">';

			//jika kenaikan kelas (X, XI)
			if (($btxno == "1") OR ($btxno == "2"))
				{
				//terjemahkan tapel
				$tpy_thn1 = $tpx_thn1 + 1;
				$tpy_thn2 = $tpx_thn2 + 1;

				$qtpf = mysql_query("SELECT * FROM m_tapel ".
							"WHERE tahun1 = '$tpy_thn1' ".
							"AND tahun2 = '$tpy_thn2'");
				$rtpf = mysql_fetch_assoc($qtpf);
				$tpf_kd = nosql($rtpf['kd']);

				//terjemahkan kelas
				$qbf = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$kelkd'");
				$rbf = mysql_fetch_assoc($qbf);
				$bf_no = nosql($rbf['no']);
				$bf_nox = $bf_no + 1;
				$bf_noy = $bf_no - 1;

				echo 'Tahun Pelajaran Baru : <strong>'.$tpy_thn1.'/'.$tpy_thn2.'</strong>, ';

				//siswa_kelas terbaru...
				$qsk = mysql_query("SELECT * FROM siswa_kelas ".
							"WHERE kd_tapel = '$tpf_kd' ".
							"AND kd_keahlian = '$keakd' ".
							"AND kd_siswa = '$i_mskd'");
				$rsk = mysql_fetch_assoc($qsk);
				$tsk = mysql_num_rows($qsk);
				$sk_skkd = nosql($rsk['kd']);


				//naik...?
				$qnuk = mysql_query("SELECT * FROM siswa_naik ".
							"WHERE kd_tapel = '$tpf_kd' ".
							"AND kd_siswa_kelas = '$sk_skkd'");
				$rnuk = mysql_fetch_assoc($qnuk);
				$nuk_kelkd = nosql($rnuk['kd_kelas']);
				$nuk_naik = nosql($rnuk['naik']);

				//terjemahkan kelas
				$qbf2 = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$nuk_kelkd'");
				$rbf2 = mysql_fetch_assoc($qbf2);
				$bf2_kelas = nosql($rbf2['kelas']);



				if ($nuk_naik == "true")
					{
					$nuk_naik_ket = "<strong><font color=\"blue\">Naik Kelas : $bf2_kelas</font></strong>";
					}
				else if ($nuk_naik == "false")
					{
					$nuk_naik_ket = "<strong><font color=\"red\">Tinggal Kelas : $bf2_kelas</font></strong>";
					}
				else
					{
					$nuk_naik_ket = "-";
					}

				echo $nuk_naik_ket;
				}

			//jika kelulusan
			else if ($btxno == "3")
				{
				//terjemahkan tapel
				$tpy_thn1 = $tpx_thn1 + 1;
				$tpy_thn2 = $tpx_thn2 + 1;

				//tapel baru
				$qtpf = mysql_query("SELECT * FROM m_tapel ".
							"WHERE tahun1 = '$tpy_thn1' ".
							"AND tahun2 = '$tpy_thn2'");
				$rtpf = mysql_fetch_assoc($qtpf);
				$tpf_kd = nosql($rtpf['kd']);


				//status kelulusan
				$qlus = mysql_query("SELECT * FROM siswa_lulus ".
							"WHERE kd_tapel = '$tpf_kd' ".
							"AND kd_siswa_kelas = '$i_skkd'");
				$rlus = mysql_fetch_assoc($qlus);
				$lus_nilai = nosql($rlus['lulus']);

				//lulus ato tidal
				if ($lus_nilai == "true")
					{
					$lus_ket = "<font color=\"blue\">Lulus</font>";
					}
				else if ($lus_nilai == "false")
					{
					$lus_ket = "<font color=\"red\">Tidak Lulus</font>";
					}

				echo 'Tahun Pelajaran Baru : <strong>'.$tpy_thn1.'/'.$tpy_thn2.'</strong>,
				<strong>'.$lus_ket.'</strong>';
				}



			echo '</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="250">
		<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="keakd" type="hidden" value="'.$keakd.'">
		<input name="kompkd" type="hidden" value="'.$kompkd.'">
		<input name="total" type="hidden" value="'.$count.'">
		</td>
		<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
		</tr>
		</table>';




		//jika kenaikan kelas (VII, VII)
		if (($btxno == "1") OR ($btxno == "2"))
			{
			//terjemahkan tapel
			$tpy_thn1 = $tpx_thn1 + 1;
			$tpy_thn2 = $tpx_thn2 + 1;

			$qtpf = mysql_query("SELECT * FROM m_tapel ".
						"WHERE tahun1 = '$tpy_thn1' ".
						"AND tahun2 = '$tpy_thn2'");
			$rtpf = mysql_fetch_assoc($qtpf);
			$tpf_kd = nosql($rtpf['kd']);

			//terjemahkan kelas
			$qbf = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
			$rbf = mysql_fetch_assoc($qbf);
			$bf_no = nosql($rbf['no']);
			$bf_nox = $bf_no + 1;
			$bf_noy = $bf_no - 1;

			echo '<br>
			<p>
			<big><strong>Keterangan Naik/Tinggal Kelas :</strong></big>
			<br>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td>
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keakd" type="hidden" value="'.$keakd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="tpfkd" type="hidden" value="'.$tpf_kd.'">
			<input name="tpfthn1" type="hidden" value="'.$tpy_thn1.'">
			<input name="tpfthn2" type="hidden" value="'.$tpy_thn2.'">
			<input name="page" type="hidden" value="'.$page.'">
			Tahun Pelajaran Baru : <strong>'.$tpy_thn1.'/'.$tpy_thn2.'</strong>,
			Kelas Baru : ';

			//naik...?
			$qnuk = mysql_query("SELECT siswa_naik.*, m_kelas.*, m_kelas.kd AS mkkd ".
						"FROM siswa_naik, m_kelas ".
						"WHERE siswa_naik.kd_kelas = m_kelas.kd ".
						"AND siswa_naik.kd_tapel = '$tpf_kd'");
			$rnuk = mysql_fetch_assoc($qnuk);
			$nuk_mkkd = nosql($rnuk['mkkd']);
			$nuk_kelas = nosql($rnuk['kelas']);
			$nuk_naik = nosql($rnuk['naik']);


			if ($nuk_naik == "true")
				{
				$nuk_naik_ket = "Naik Kelas : $nuk_kelas";
				}
			else if ($nuk_naik == "false")
				{
				$nuk_naik_ket = "Tinggal Kelas : $nuk_kelas";
				}
			else
				{
				$nuk_naik_ket = "-";
				}

			echo '<select name="kelasx">
			<option value="" selected></option>';

			$qbt = mysql_query("SELECT * FROM m_kelas ".
						"WHERE no <= '$bf_nox' ".
						"AND no > '$bf_noy' ".
						"AND kelas LIKE '%$prgx_singk%' ".
						"ORDER BY kelas ASC, round(no) DESC");
			$rowbt = mysql_fetch_assoc($qbt);

			do
				{
				$btkd = nosql($rowbt['kd']);
				$btno = nosql($rowbt['no']);
				$btkelas = balikin($rowbt['kelas']);

				//tinggal kelas
				if ($btno == $btxno)
					{
					$kel_ket = "Tinggal Kelas : $btkelas";
					}

				//naik kelas
				else
					{
					$kel_ket = "Naik Kelas : $btkelas";
					}

				echo '<option value="'.$btkd.'">'.$kel_ket.'</option>';
				}
			while ($rowbt = mysql_fetch_assoc($qbt));

			echo '</select>
			<input name="btnSMP6" type="submit" value="SIMPAN">
			</td>
			</tr>
			</table>
			</p>';
			}

		//jika kelulusan
		else if ($btxno == "3")
			{
			//terjemahkan tapel
			$tpy_thn1 = $tpx_thn1 + 1;
			$tpy_thn2 = $tpx_thn2 + 1;

			//tapel baru
			$qtpf = mysql_query("SELECT * FROM m_tapel ".
						"WHERE tahun1 = '$tpy_thn1' ".
						"AND tahun2 = '$tpy_thn2'");
			$rtpf = mysql_fetch_assoc($qtpf);
			$tpf_kd = nosql($rtpf['kd']);


			//status kelulusan
			$qlus = mysql_query("SELECT * FROM siswa_lulus ".
						"WHERE kd_tapel = '$tpf_kd' ".
						"AND kd_siswa_kelas = '$skkd'");
			$rlus = mysql_fetch_assoc($qlus);
			$lus_nilai = nosql($rlus['lulus']);

			//lulus ato tidal
			if ($lus_nilai == "true")
				{
				$lus_ket = "Lulus";
				}
			else if ($lus_nilai == "false")
				{
				$lus_ket = "Tidak Lulus";
				}

			echo '<br>
			<p>
			<big><strong>Keterangan Lulus/Tidak Lulus :</strong></big>
			<br>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td>
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keakd" type="hidden" value="'.$keakd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="tpfkd" type="hidden" value="'.$tpf_kd.'">
			<input name="tpfthn1" type="hidden" value="'.$tpy_thn1.'">
			<input name="tpfthn2" type="hidden" value="'.$tpy_thn2.'">
			<input name="page" type="hidden" value="'.$page.'">
			Tahun Pelajaran Baru : <strong>'.$tpy_thn1.'/'.$tpy_thn2.'</strong>,
			<select name="lulus">
			<option value="" selected></option>
			<option value="true">Lulus</option>
			<option value="false">Tidak Lulus</option>
			</select>
			<input name="btnSMP7" type="submit" value="SIMPAN">
			</td>
			</tr>
			</table>
			</p>';
			}
		}
	else
		{
		echo '<p>
		<strong>
		<font color="red">
		TIDAK ADA DATA.
		</font>
		</strong>
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
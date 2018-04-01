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
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_sip.php";
$judul = "Keuangan Siswa : Uang SIP";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$nis = nosql($_REQUEST['nis']);

$ke = "$filenya?tapelkd=$tapelkd&nis=$nis";





//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();isodatetime();";
	}
else if (empty($nis))
	{
	$diload = "document.formx.nis.focus();isodatetime();";
	}
else
	{
	$diload = "isodatetime();document.formx.nil_bayar.focus();";
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($s == "hapus")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$swkd = nosql($_REQUEST['swkd']);
	$nis = nosql($_REQUEST['nis']);
	$kd = nosql($_REQUEST['kd']);


	//query
	mysql_query("DELETE FROM siswa_uang_pangkal ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND kd_siswa = '$swkd' ".
			"AND kd = '$kd'");


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&nis=$nis";
	xloc($ke);
	exit();
	}





//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$nis = nosql($_POST['nis']);
	$swkd = nosql($_POST['swkd']);

	//update
	mysql_query("DELETE FROM siswa_uang_pangkal ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND kd_siswa = '$swkd' ".
			"AND DATE_FORMAT(tgl_bayar, '%d') = '$tanggal' ".
			"AND DATE_FORMAT(tgl_bayar, '%m') = '$bulan' ".
			"AND DATE_FORMAT(tgl_bayar, '%Y') = '$tahun'");


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&nis=$nis";
	xloc($ke);
	exit();
	}





//nek ok
if ($_POST['btnOK'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$nis = nosql($_POST['nis']);

	//jika null
	if (empty($nis))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&nis=$nis";
		xloc($ke);
		exit();
		}
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$nis = nosql($_POST['nis']);
	$swkd = nosql($_POST['swkd']);
	$nil_bayar = nosql($_POST['nil_bayar']);


	//total uang pangkal
	$qpkl = mysql_query("SELECT * FROM m_uang_pangkal ".
				"WHERE kd_tapel = '$tapelkd'");
	$rpkl = mysql_fetch_assoc($qpkl);
	$pkl_nilai = nosql($rpkl['nilai']);


	//yang telah dibayar
	$qcc = mysql_query("SELECT SUM(nilai) AS nilai FROM siswa_uang_pangkal ".
				"WHERE kd_siswa = '$swkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$cc_nilai = nosql($rcc['nilai']);


	//cek
	if (empty($nil_bayar))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&nis=$nis";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika melebihi...
		if (($cc_nilai + $nil_bayar) > $pkl_nilai)
			{
			//re-direct
			$pesan = "Jumlah Uang SIP Yang Dibayarkan, Melebihi Jumlah Total Sisa Yang Ada. Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&nis=$nis";
			pekem($pesan,$ke);
			exit();
			}

		//jika kurang
		else if ((($cc_nilai + $nil_bayar) < $pkl_nilai) OR (($cc_nilai + $nil_bayar) == $pkl_nilai))
			{
			mysql_query("INSERT INTO siswa_uang_pangkal (kd, kd_tapel, kd_siswa, tgl_bayar, nilai, postdate) VALUES ".
					"('$x', '$tapelkd', '$swkd', '$today', '$nil_bayar', '$today3')");
			}


		//re-direct
		$ke = "siswa_sip_prt.php?tapelkd=$tapelkd&nis=$nis";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//menu
require("../../inc/menu/admbdh.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/js/jam.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Angkatan Tahun Pelajaran : ';

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

echo '</select>
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

else
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td valign="top" width="350">

	<p>
	Hari/Tanggal/Jam :
	<br>
	<input name="display_tgl" type="text" size="25" value="'.$arrhari[$hari].', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'" class="input" readonly>
	<input type="text" name="display_jam" size="5" style="text-align:right" class="input" readonly>
	</p>

	<p>
	NIS :
	<br>
	<input name="nis"
	type="text"
	size="20"
	value="'.$nis.'"
	onKeyDown="var keyCode = event.keyCode;
	if (keyCode == 13)
		{
		document.formx.btnOK.focus();
		document.formx.btnOK.submit();
		}">
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="btnOK" type="submit" value=">>">
	</p>';

	if (!empty($nis))
		{
		//siswa
		$qcc = mysql_query("SELECT * FROM m_siswa ".
					"WHERE nis = '$nis'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_kd = nosql($rcc['kd']);
		$cc_nama = balikin($rcc['nama']);


		//ketahui kode siswa, dari suatu siswa_kelas
		$qske = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
					"FROM siswa_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$cc_kd' ".
					"ORDER BY m_tapel.tahun1 ASC");
		$rske = mysql_fetch_assoc($qske);
		$tske = mysql_num_rows($qske);
		$ske_tapelkd = nosql($rske['kd_tapel']);


		//kelas terakhir
		$qnil = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
					"FROM siswa_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$cc_kd' ".
					"ORDER BY m_tapel.tahun1 DESC");
		$rnil = mysql_fetch_assoc($qnil);
		$tnil = mysql_num_rows($qnil);
		$nil_kelkd = nosql($rnil['kd_kelas']);
		$swp_kelkd = nosql($rnil['kd_kelas']);


		$qkelx = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd = '$swp_kelkd'");
		$rkelx = mysql_fetch_assoc($qkelx);
		$kelx_kelas = balikin($rkelx['kelas']);


		$swp_kelas = "$kelx_kelas";


		//jika benar
		if ($tapelkd == $ske_tapelkd)
			{
			//nek ada
			if ($tcc != 0)
				{
				echo '<p>
				Nama Siswa :
				<br>
				<input name="nama" type="text" value="'.$cc_nama.'" size="30" class="input" readonly>
				</p>

				<p>
				Kelas :
				<br>
				<input name="kelas" type="text" value="'.$swp_kelas.'" size="10" class="input" readonly>
				</p>

				<p>
				Jumlah Uang Yang Dibayar :
				<br>
				Rp.
				<input name="nil_bayar"
				type="text"
				size="10"
				value=""
				style="text-align:right"
				onKeyDown="var keyCode = event.keyCode;
				if (keyCode == 13)
					{
					document.formx.btnSMP.focus();
					document.formx.btnSMP.submit();
					}"
				onKeyPress="return numbersonly(this, event)">,00
				</p>';


				//total uang pangkal
				$qpkl = mysql_query("SELECT * FROM m_uang_pangkal ".
										"WHERE kd_tapel = '$tapelkd'");
				$rpkl = mysql_fetch_assoc($qpkl);
				$pkl_nilai = nosql($rpkl['nilai']);


				//yang telah dibayar
				$qccx = mysql_query("SELECT SUM(nilai) AS nilai FROM siswa_uang_pangkal ".
										"WHERE kd_siswa = '$cc_kd'");
				$rccx = mysql_fetch_assoc($qccx);
				$ccx_nilai = nosql($rccx['nilai']);

				//sisa
				$nil_sisa = $pkl_nilai - $ccx_nilai;


				echo '<p>
				Sisa :
				<br>
				Rp.	<input name="nil_sisa" type="text" size="10" value="'.$nil_sisa.'" style="text-align:right" class="input" readonly>,00
				</p>

				<p>
				<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
				<input name="swkd" type="hidden" value="'.$cc_kd.'">
				<input name="btnSMP" type="submit" value="SIMPAN dan CETAK">
				<input name="btnBTL" type="submit" value="BATAL">
				</p>';
				}

			else
				{
				echo '<p>
				<font color="red">
				<strong>NIS : '.$nis.', Tidak Ditemukan. Harap Diperhatikan...!!</strong>
				<font>
				</p>';
				}
			}
		else
			{
			echo '<p>
			<font color="red">
			<strong>Siswa dengan NIS : '.$nis.', Bukan Dari Angkatan Tahun Pelajaran ini.</strong>
			</font>
			</p>';
			}
		}



	echo '</td>
	<td width="10">&nbsp;</td>
	<td valign="top">';

	//nek ada
	if ($tcc != 0)
		{
		echo '<p>
		<table border="1" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td valign="top">
		<strong>HISTORY PEMBAYARAN</strong>
		<br>
		('.xduit2($pkl_nilai).')
		<p>';

		//total bayar
		$qdftx2 = mysql_query("SELECT SUM(nilai) AS total ".
					"FROM siswa_uang_pangkal ".
					"WHERE kd_siswa = '$cc_kd' ".
					"AND kd_tapel = '$tapelkd'");
		$rdftx2 = mysql_fetch_assoc($qdftx2);
		$dftx2_total = nosql($rdftx2['total']);


		//keterangan
		if ($dftx2_total == $pkl_nilai)
			{
			$nil_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
			}
		else
			{
			$nil_ket = "<font color=\"blue\"><strong>Belum Lunas</strong></font>";
			}



		//daftar
		$qdftx = mysql_query("SELECT siswa_uang_pangkal.*, ".
					"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
					"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
					"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
					"FROM siswa_uang_pangkal ".
					"WHERE kd_siswa = '$cc_kd' ".
					"AND kd_tapel = '$tapelkd' ".
					"ORDER BY tgl_bayar DESC");
		$rdftx = mysql_fetch_assoc($qdftx);
		$tdftx = mysql_num_rows($qdftx);

		echo '<table border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
		<td width="50" align="center"><strong><font color="'.$warnatext.'">&nbsp;</font></strong></td>
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
			$dft_kd = nosql($rdftx['kd']);
			$dft_bln = nosql($rdftx['bln']);
			$dft_thn = nosql($rdftx['thn']);
			$dft_nilai = nosql($rdftx['nilai']);
			$dft_xtgl = nosql($rdftx['xtgl']);
			$dft_xbln = nosql($rdftx['xbln']);
			$dft_xthn = nosql($rdftx['xthn']);
			$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";

			//jika null
			if ($dft_tgl_bayar == "00/00/0000")
				{
				$dft_tgl_bayar = "-";
				}

			$dft_hapus = "[<a href=\"$filenya?s=hapus&tapelkd=$tapelkd&nis=$nis&swkd=$cc_kd&kd=$dft_kd\">HAPUS</a>]";



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			'.$dft_tgl_bayar.'
			</td>
			<td align="right">
			'.xduit2($dft_nilai).'
			</td>
			<td>
			[<a href="'.$filenya.'?s=hapus&tapelkd='.$tapelkd.'&nis='.$nis.'&swkd='.$cc_kd.'&kd='.$dft_kd.'">HAPUS</a>]
			</td>
			</tr>';
			}
		while ($rdftx = mysql_fetch_assoc($qdftx));

		echo '</table>
		<p>
		Total Bayar :
		<br>
		Rp.	<input name="nil_total" type="text" size="10" value="'.$dftx2_total.'" style="text-align:right" class="input" readonly>,00
		</p>

		<p>
		Keterangan :
		<br>
		'.$nil_ket.'
		</p>
		</p>';


		echo '</td>
		</tr>
		</table>
		</p>';
		}

	echo '</td>
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
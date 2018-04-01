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



///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMP_v4.0_(NyurungBAN)                          ///////
/////// (Sistem Informasi Sekolah untuk SMP)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS	: 081-829-88-54                                 ///////
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
$filenya = "siswa_spp.php";
$judul = "Keuangan Siswa : Uang SPP";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$nis = nosql($_REQUEST['nis']);
$jml_bln = nosql($_REQUEST['jml_bln']);

$ke = "$filenya?tapelkd=$tapelkd&nis=$nis&jml_bln=$jml_bln";



//jika null, isikan satu
if (empty($jml_bln))
{
$jml_bln = 1;
}




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
$diload = "isodatetime();document.formx.jml_bln.focus();";
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
mysql_query("UPDATE siswa_uang_spp SET lunas = 'false', ".
				"tgl_bayar = '0000-00-00', ".
				"postdate = '$today3', ".
				"nilai = '' ".
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
$kelkd = nosql($_POST['kelkd']);


//re-direct
$ke = "$filenya?tapelkd=$tapelkd";
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
$kelkd = nosql($_POST['kelkd']);
$nis = nosql($_POST['nis']);
$jml_bln = nosql($_POST['jml_bln']);
$swkd = nosql($_POST['swkd']);



//ketahui nilai per bulan
$qnil = mysql_query("SELECT m_uang_spp.*, siswa_kelas.* ".
						"FROM m_uang_spp, siswa_kelas ".
						"WHERE siswa_kelas.kd_tapel = m_uang_spp.kd_tapel ".
						"AND siswa_kelas.kd_kelas = m_uang_spp.kd_kelas ".
						"AND m_uang_spp.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$tnil = mysql_num_rows($qnil);
$nil_uang = nosql($rnil['nilai']);


//cek
$qswp = mysql_query("SELECT * FROM siswa_uang_spp ".
						"WHERE kd_siswa = '$swkd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND lunas = 'false' ".
						"LIMIT $jml_bln");
$rswp = mysql_fetch_assoc($qswp);
$tswp = mysql_num_rows($qswp);

do
	{
	//nilai
	$swp_bln = nosql($rswp['bln']);
	$swp_thn = nosql($rswp['thn']);

	//update
	mysql_query("UPDATE siswa_uang_spp SET lunas = 'true', ".
					"tgl_bayar = '$today', ".
					"postdate = '$today3', ".
					"nilai = '$nil_uang' ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_kelas = '$kelkd' ".
					"AND kd_siswa = '$swkd' ".
					"AND bln = '$swp_bln' ".
					"AND thn = '$swp_thn'");
	}
while ($rswp = mysql_fetch_assoc($qswp));




//re-direct
$ke = "siswa_spp_prt.php?tapelkd=$tapelkd&nis=$nis";
xloc($ke);
exit();
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/js/jam.js");
require("../../inc/menu/admbdh.php");
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
<td valign="top" width="500">

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
	}"
onKeyPress="return numbersonly(this, event)">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="btnOK" type="submit" value=">>">
</p>';

if (!empty($nis))
{
//cek
$qcc = mysql_query("SELECT * FROM m_siswa ".
						"WHERE nis = '$nis'");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);
$cc_kd = nosql($rcc['kd']);
$cc_nama = balikin($rcc['nama']);


//ketahui nilai per bulan
$qnil = mysql_query("SELECT m_uang_spp.*, siswa_kelas.* ".
						"FROM m_uang_spp, siswa_kelas ".
						"WHERE siswa_kelas.kd_tapel = m_uang_spp.kd_tapel ".
						"AND siswa_kelas.kd_kelas = m_uang_spp.kd_kelas ".
						"AND m_uang_spp.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_siswa = '$cc_kd'");
$rnil = mysql_fetch_assoc($qnil);
$tnil = mysql_num_rows($qnil);
$nil_kelkd = nosql($rnil['kd_kelas']);
$nil_uang = nosql($rnil['nilai']);

//total uang
$cc_sebesar = $jml_bln * $nil_uang;


//ketahui bulan yang belum dibayar
$qswp = mysql_query("SELECT siswa_uang_spp.*, siswa_kelas.* ".
						"FROM siswa_uang_spp, siswa_kelas ".
						"WHERE siswa_kelas.kd_tapel = siswa_uang_spp.kd_tapel ".
						"AND siswa_kelas.kd_kelas = siswa_uang_spp.kd_kelas ".
						"AND siswa_uang_spp.kd_tapel = '$tapelkd' ".
						"AND siswa_uang_spp.kd_siswa = siswa_kelas.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$cc_kd' ".
						"AND siswa_uang_spp.lunas = 'false' ".
						"LIMIT $jml_bln");
$rswp = mysql_fetch_assoc($qswp);
$tswp = mysql_num_rows($qswp);


//entry null spp
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		//cek
		$qccu = mysql_query("SELECT * FROM siswa_uang_spp ".
								"WHERE kd_siswa = '$cc_kd' ".
								"AND kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$nil_kelkd' ".
								"AND bln = '$ibln' ".
								"AND thn = '$tpx_thn1'");
		$rccu = mysql_fetch_assoc($qccu);
		$tccu = mysql_num_rows($qccu);

		//nek belum ada, insert
		if (empty($tccu))
			{
			$xyz = md5("$x$i");
			mysql_query("INSERT INTO siswa_uang_spp (kd, kd_siswa, kd_tapel, kd_kelas, bln, thn) VALUES ".
							"('$xyz', '$cc_kd', '$tapelkd', '$nil_kelkd', '$ibln', '$tpx_thn1')");
			}
		}

	if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		//cek
		$qccu = mysql_query("SELECT * FROM siswa_uang_spp ".
								"WHERE kd_siswa = '$cc_kd' ".
								"AND kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$nil_kelkd' ".
								"AND bln = '$ibln' ".
								"AND thn = '$tpx_thn2'");
		$rccu = mysql_fetch_assoc($qccu);
		$tccu = mysql_num_rows($qccu);

		//nek belum ada, insert
		if (empty($tccu))
			{
			$xyz = md5("$x$i");
			mysql_query("INSERT INTO siswa_uang_spp (kd, kd_siswa, kd_tapel, kd_kelas, bln, thn) VALUES ".
							"('$xyz', '$cc_kd', '$tapelkd', '$nil_kelkd', '$ibln', '$tpx_thn2')");
			}
		}
	}



//nek ada
if ($tcc != 0)
{
echo '<p>
Nama Siswa :
<br>
<input name="nama" type="text" value="'.$cc_nama.'" size="30" class="input" readonly>
</p>

<p>
Pembayaran :
<br>
<input name="bayar" type="text" value="SPP" size="30" class="input" readonly>
</p>

<p>
Jumlah Bulan Yang Dibayar : ';
echo "<select name=\"jml_bln\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$jml_bln.'">'.$jml_bln.'</option>';
for($i=1;$i<=12;$i++)
{
echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&nis='.$nis.'&jml_bln='.$i.'">'.$i.'</option>';
}
echo '</select> Bulan,

Sebesar :
Rp. <input name="sebesar" type="text" value="'.$cc_sebesar.'" size="20" class="input" readonly>,00
</p>

<p>
Bulan :
<br>
<textarea name="bayar_bln" cols="65" rows="2" wrap="virtual" class="input" readonly>';

do
	{
	//nilai
	$swp_bln = nosql($rswp['bln']);
	$swp_thn = nosql($rswp['thn']);

	echo "$arrbln[$swp_bln] $swp_thn, ";
	}
while ($rswp = mysql_fetch_assoc($qswp));

echo '</textarea>
</p>

<p>
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$nil_kelkd.'">
<input name="swkd" type="hidden" value="'.$cc_kd.'">
<input name="btnSMP" type="submit" value="SIMPAN dan CETAK">
<input name="btnBTL" type="submit" value="RESET">
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


echo '</td>
<td width="10">&nbsp;</td>
<td valign="top">';

//nek ada
if ($tcc != 0)
{
echo '<p>
<table height="300" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top">


<strong>HISTORY PEMBAYARAN</strong>
('.xduit2($nil_uang).'/Bulan)';


//daftar
$qdftx = mysql_query("SELECT siswa_uang_spp.*, ".
						"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
						"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
						"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
						"FROM siswa_uang_spp ".
						"WHERE kd_siswa = '$cc_kd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$nil_kelkd'");
$rdftx = mysql_fetch_assoc($qdftx);
$tdftx = mysql_num_rows($qdftx);

echo '<table border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="120" align="center"><strong><font color="'.$warnatext.'">Bulan</font></strong></td>
<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
<td width="100" align="center"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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
	$dft_status = nosql($rdftx['lunas']);

	//jika null
	if ($dft_tgl_bayar == "00/00/0000")
		{
		$dft_tgl_bayar = "-";
		}


	//nek lunas
	if ($dft_status == 'true')
		{
		$dft_status_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
		$dft_hapus = "[<a href=\"$filenya?s=hapus&tapelkd=$tapelkd&nis=$nis&swkd=$cc_kd&kd=$dft_kd\">HAPUS</a>]";
		}
	else if ($dft_status == 'false')
		{
		$dft_status_ket = "<font color=\"blue\"><strong>Belum Bayar</strong></font>";
		$dft_hapus = "-";
		}

	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td align="right">
	'.$arrbln[$dft_bln].' '.$dft_thn.'
	</td>
	<td>
	'.$dft_tgl_bayar.'
	</td>
	<td>
	'.$dft_status_ket.'
	</td>
	<td>
	'.$dft_hapus.'
	</td>
	</tr>';
	}
while ($rdftx = mysql_fetch_assoc($qdftx));

echo '</table>';


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
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
$filenya = "m_beasiswa.php";
$judul = "Data Master Beasiswa";
$judulku = "[$bk_session : $nip91_session.$nm91_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$s = nosql($_REQUEST['s']);

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd";






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}



//jika edit
if ($s == "edit")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$smtkd = nosql($_REQUEST['smtkd']);
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT m_beasiswa.*, ".
				"DATE_FORMAT(tanggal_awal, '%d') AS awal_tgl, ".
				"DATE_FORMAT(tanggal_awal, '%m') AS awal_bln, ".
				"DATE_FORMAT(tanggal_awal, '%Y') AS awal_thn, ".
				"DATE_FORMAT(tanggal_akhir, '%d') AS akhir_tgl, ".
				"DATE_FORMAT(tanggal_akhir, '%m') AS akhir_bln, ".
				"DATE_FORMAT(tanggal_akhir, '%Y') AS akhir_thn ".
				"FROM m_beasiswa ".
				"WHERE kd_tapel = '$tapelkd' ".
				"AND kd_smt = '$smtkd' ".
				"AND kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_jenis = balikin($rowx['jenis']);
	$e_dari = balikin($rowx['dari']);
	$e_awal_tgl = nosql($rowx['awal_tgl']);
	$e_awal_bln = nosql($rowx['awal_bln']);
	$e_awal_thn = nosql($rowx['awal_thn']);
	$e_akhir_tgl = nosql($rowx['akhir_tgl']);
	$e_akhir_bln = nosql($rowx['akhir_bln']);
	$e_akhir_thn = nosql($rowx['akhir_thn']);
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$e_jenis = cegah2($_POST['e_jenis']);
	$e_dari = cegah2($_POST['e_dari']);
	$awal_tgl = nosql($_POST['awal_tgl']);
	$awal_bln = nosql($_POST['awal_bln']);
	$awal_thn = nosql($_POST['awal_thn']);
	$tgl_awal = "$awal_thn:$awal_bln:$awal_tgl";
	$akhir_tgl = nosql($_POST['akhir_tgl']);
	$akhir_bln = nosql($_POST['akhir_bln']);
	$akhir_thn = nosql($_POST['akhir_thn']);
	$tgl_akhir = "$akhir_thn:$akhir_bln:$akhir_tgl";


	//nek null
	if ((empty($e_jenis)) OR (empty($e_dari)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if (empty($s))
			{
			///cek
			$qcc = mysql_query("SELECT * FROM m_beasiswa ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND jenis = '$e_jenis' ".
						"AND dari = '$e_dari");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Data Jenis Beasiswa ini, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO m_beasiswa(kd, kd_tapel, kd_smt, ".
						"jenis, dari, tanggal_awal, tanggal_akhir, postdate) VALUES ".
						"('$x', '$tapelkd', '$smtkd', ".
						"'$e_jenis','$e_dari', '$tgl_awal', '$tgl_akhir', '$today')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($ke);
				exit();
				}
			}


		//jika update
		else if ($s == "edit")
			{
			//query
			mysql_query("UPDATE m_beasiswa SET dari = '$e_dari', ".
					"jenis = '$e_jenis', ".
					"tanggal_awal = '$tgl_awal', ".
					"tanggal_akhir = '$tgl_akhir' ".
					"WHERE kd_tapel= '$tapelkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($ke);
			exit();
			}
		}
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_beasiswa ".
				"WHERE kd_tapel = '$tapelkd' ".
				"AND kd_smt = '$smtkd' ".
				"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//focus....focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="page" type="hidden" value="'.$page.'">
<br>';


//nek drg
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
	}


else if (empty($smtkd))
	{
	echo '<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>';
	}


else
	{
	echo '<p>
	Jenis Beasiswa :
	<br>
	<input name="e_jenis" type="text" value="'.$e_jenis.'" size="30">
	</p>

	<p>
	Dari :
	<br>
	<input name="e_dari" type="text" value="'.$e_dari.'" size="30">
	</p>


	<p>
	Tanggal Berlaku :
	<br>
	Mulai
	<select name="awal_tgl">
	<option value="'.$e_awal_tgl.'" selected>'.$e_awal_tgl.'</option>';
	for ($i=1;$i<=31;$i++)
		{
		echo '<option value="'.$i.'">'.$i.'</option>';
		}

	echo '</select>
	<select name="awal_bln">
	<option value="'.$e_awal_bln.'" selected>'.$arrbln1[$e_awal_bln].'</option>';
	for ($j=1;$j<=12;$j++)
		{
		echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
		}

	echo '</select>
	<select name="awal_thn">
	<option value="'.$e_awal_thn.'" selected>'.$e_awal_thn.'</option>';
	for ($k=$tpx_thn1;$k<=$tpx_thn2;$k++)
		{
		echo '<option value="'.$k.'">'.$k.'</option>';
		}
	echo '</select>,



	Sampai

	<select name="akhir_tgl">
	<option value="'.$e_akhir_tgl.'" selected>'.$e_akhir_tgl.'</option>';
	for ($i=1;$i<=31;$i++)
		{
		echo '<option value="'.$i.'">'.$i.'</option>';
		}

	echo '</select>
	<select name="akhir_bln">
	<option value="'.$e_akhir_bln.'" selected>'.$arrbln1[$e_akhir_bln].'</option>';
	for ($j=1;$j<=12;$j++)
		{
		echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
		}

	echo '</select>
	<select name="akhir_thn">
	<option value="'.$e_akhir_thn.'" selected>'.$e_akhir_thn.'</option>';
	for ($k=$tpx_thn1;$k<=$tpx_thn2;$k++)
		{
		echo '<option value="'.$k.'">'.$k.'</option>';
		}
	echo '</select>
	</p>

	<p>
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';


	//query
	$q = mysql_query("SELECT m_beasiswa.*, ".
				"DATE_FORMAT(tanggal_awal, '%d') AS awal_tgl, ".
				"DATE_FORMAT(tanggal_awal, '%m') AS awal_bln, ".
				"DATE_FORMAT(tanggal_awal, '%Y') AS awal_thn, ".
				"DATE_FORMAT(tanggal_akhir, '%d') AS akhir_tgl, ".
				"DATE_FORMAT(tanggal_akhir, '%m') AS akhir_bln, ".
				"DATE_FORMAT(tanggal_akhir, '%Y') AS akhir_thn ".
				"FROM m_beasiswa ".
				"WHERE kd_tapel = '$tapelkd' ".
				"AND kd_smt = '$smtkd' ".
				"ORDER BY jenis ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	if ($total != 0)
		{
		echo '<p>
		<table width="800" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="10"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Jenis</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Dari</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Tanggal Berlaku</font></strong></td>
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

			$nomer = $nomer + 1;
			$i_kd = nosql($row['kd']);
			$i_jenis = balikin2($row['jenis']);
			$i_dari = balikin2($row['dari']);
			$i_awal_tgl = nosql($row['awal_tgl']);
			$i_awal_bln = nosql($row['awal_bln']);
			$i_awal_thn = nosql($row['awal_thn']);
			$i_akhir_tgl = nosql($row['akhir_tgl']);
			$i_akhir_bln = nosql($row['akhir_bln']);
			$i_akhir_thn = nosql($row['akhir_thn']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>
			<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&kd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$nomer.'</td>
			<td>'.$i_jenis.'</td>
			<td>'.$i_dari.'</td>
			<td>Mulai <strong>'.$i_awal_tgl.' '.$arrbln1[$i_awal_bln].' '.$i_awal_thn.'</strong>, sampai <strong>'.$i_akhir_tgl.' '.$arrbln1[$i_akhir_bln].' '.$i_akhir_thn.'</strong></td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="800" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$total.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
		</tr>
		</table>
		</p>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
		</font>
		</p>';
		}
	}


echo '<br>
<br>
<br>
</form>';


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
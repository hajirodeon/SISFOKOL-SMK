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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbkk.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "lowongan.php";
$judul = "Data Lowongan";
$judulku = "[$bkk_session : $nip15_session. $nm15_session] ==> $judul";
$diload = "document.formx.tapel.focus();";
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$m = nosql($_REQUEST['m']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$tapelkd  = nosql($_REQUEST['tapelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}






//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$jml = nosql($_POST['jml']);


	for ($k=1;$k<=$jml;$k++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$k";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM bkk_lowongan ".
				"WHERE kd = '$kd'");
		}



	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$e_nama = cegah2($_POST['e_nama']);
	$e_isi = cegah2($_POST['editor']);

	//nek null
	if (empty($e_nama))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ($s =="baru")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM bkk_lowongan ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND nama = '$e_nama'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Nama Lowongan : $e_nama, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?tapelkd=$tapelkd&s=baru";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO bkk_lowongan(kd, kd_tapel, nama, isi, postdate) VALUES ".
						"('$x', '$tapelkd', '$e_nama', '$e_isi', '$today')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?tapelkd=$tapelkd";
				xloc($ke);
				exit();
				}
			}

		//jika update
		else if ($s == "edit")
			{
			//query
			mysql_query("UPDATE bkk_lowongan SET nama = '$e_nama', ".
					"isi = '$e_isi', ".
					"postdate = '$today' ".
					"WHERE kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?tapelkd=$tapelkd";
			xloc($ke);
			exit();
			}
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();

//menu
require("../../inc/menu/admbkk.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();


//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");
require("../../inc/js/editor2.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" bgcolor="'.$warnaover.'" cellspacing="0" cellpadding="3">
<tr valign="top">
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



//cek
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warna01.'">
	<td width="500">
	[<a href="'.$filenya.'?tapelkd='.$tapelkd.'&s=baru&kd='.$x.'" title="Entry Data Baru">Entry Data Baru</a>]
	</td>
	<td align="right">';
	echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
	echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
	<option value="'.$filenya.'?crkd=cr01&crtipe=NAMA&kunci='.$kunci.'">NAMA</option>
	<option value="'.$filenya.'?crkd=cr02&crtipe=ISI&kunci='.$kunci.'">ISI</option>
	</select>
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="kunci" type="text" value="'.$kunci.'" size="20">
	<input name="crkd" type="hidden" value="'.$crkd.'">
	<input name="crtipe" type="hidden" value="'.$crtipe.'">
	<input name="btnCARI" type="submit" value="CARI >>">
	<input name="btnRST" type="submit" value="RESET">
	</td>
	</tr>
	</table>';


	//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (empty($s))
		{
		//nama
		if ($crkd == "cr01")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT * FROM bkk_lowongan ".
					"WHERE nama LIKE '%$kunci%' ".
					"AND kd_tapel = '$tapelkd' ".
					"ORDER BY nama ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		//isi
		else if ($crkd == "cr02")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT * FROM bkk_lowongan ".
					"WHERE isi LIKE '%$kunci%' ".
					"AND kd_tapel = '$tapelkd' ".
					"ORDER BY isi ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}


		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT * FROM bkk_lowongan ".
					"WHERE kd_tapel = '$tapelkd' ".
					"ORDER BY nama ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}


		if ($count != 0)
			{
			//view data
			echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="1">&nbsp;</td>
			<td width="200"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
			<td><strong><font color="'.$warnatext.'">ISI</font></strong></td>
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
				$nomer = $nomer + 1;
				$i_kd = nosql($data['kd']);
				$i_nama = balikin($data['nama']);
				$i_isi = balikin2($data['isi']);
				$i_postdate = $data['postdate'];



				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$i_kd.'">
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
				</td>
				<td>
				<a href="'.$filenya.'?tapelkd='.$tapelkd.'&s=edit&kd='.$i_kd.'" title="EDIT..."><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
				</td>
				<td>'.$i_nama.'</td>
				<td>
				'.$i_isi.'
				<br>
				[<i>Postdate : '.$i_postdate.'</i>]
				</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="300">
			<input name="jml" type="hidden" value="'.$limit.'">
			<input name="s" type="hidden" value="'.nosql($_REQUEST['s']).'">
			<input name="kd" type="hidden" value="'.nosql($_REQUEST['kd']).'">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPS" type="submit" value="HAPUS">
			</td>
			<td align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
			</tr>
			</table>';
			}
		else
			{
			echo '<p>
			<font color="red">
			<strong>TIDAK ADA DATA.</strong>
			</font>
			</p>';
			}
		}




	//jika add / edit ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if (($s == "baru") OR ($s == "edit"))
		{
		//nilai
		$kd = nosql($_REQUEST['kd']);


		//data query
		$qnil = mysql_query("SELECT * FROM bkk_lowongan ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd = '$kd'");
		$rnil = mysql_fetch_assoc($qnil);
		$e_nama = balikin($rnil['nama']);
		$e_isi = balikin($rnil['isi']);


		echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Nama Lowongan
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_nama" type="text" value="'.$e_nama.'" size="50">
		</td>
		</tr>
		<tr valign="top">
		<td width="150">
		Isi Lowongan
		</td>
		<td width="5">:</td>
		<td>
		<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$e_isi.'</textarea>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		&nbsp;
		</td>
		<td width="5">&nbsp;</td>
		<td>
		<INPUT type="hidden" name="s" value="'.$s.'">
		<INPUT type="hidden" name="kd" value="'.$kd.'">
		<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
		<INPUT type="submit" name="btnBTL" value="BATAL">
		<INPUT type="submit" name="btnSMP" value="SIMPAN >>">
		</td>
		</tr>
		</table>';
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
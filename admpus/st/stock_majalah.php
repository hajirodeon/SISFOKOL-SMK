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
require("../../inc/cek/admpus.php");
require("../../inc/class/paging.php");
require("../../inc/class/thumbnail_images.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "stock_majalah.php";
$judul = "Stock Majalah";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$diload = "document.formx.jml_bagus.focus();";
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}





//nek batal
if ($_POST['btnRST'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}





//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}





//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$page = nosql($_POST['page']);
	$kd = nosql($_POST['kd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);
	$jml_bagus = nosql($_POST['jml_bagus']);
	$jml_rusak = nosql($_POST['jml_rusak']);
	$jml_hilang = nosql($_POST['jml_hilang']);
	$jml_total = nosql($_POST['jml_total']);
	$status = nosql($_POST['status']);


	//cek
	$qcc = mysql_query("SELECT * FROM perpus_stock ".
				"WHERE kd_item = '$kd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//jika ada
	if ($tcc != 0)
		{
		//update
		mysql_query("UPDATE perpus_stock SET jml_bagus = '$jml_bagus', ".
				"jml_rusak = '$jml_rusak', ".
				"jml_hilang = '$jml_hilang', ".
				"jml_total = '$jml_total' ".
				"WHERE kd_item = '$kd'");

		//update2
		mysql_query("UPDATE perpus_item2 SET tersedia = '$jml_bagus' ".
				"WHERE kd = '$kd'");

		//re-direct
		$ke = "$filenya?page=$page&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	else
		{
		//insert
		mysql_query("INSERT INTO perpus_stock(kd, kd_item, jml_bagus, jml_rusak, jml_hilang, jml_total) VALUES ".
				"('$x', '$kd', '$jml_bagus', '$jml_rusak', '$jml_hilang', '$jml_total')");

		//re-direct
		$ke = "$filenya?page=$page&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//menu
require("../../inc/menu/admpus.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();




//js
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
xheadline($judul);
echo ' [<a href="'.$sumber.'/adm/m/item.php?s=baru&kd='.$x.'" title="Entry Baru">Entry Baru</a>]</td>
<td align="right">';
echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$crkd.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?crkd=cr01&crtipe=BarCode">BarCode</option>
<option value="'.$filenya.'?crkd=cr02&crtipe=Kode">Kode</option>
<option value="'.$filenya.'?crkd=cr03&crtipe=Nama">Nama</option>
<option value="'.$filenya.'?crkd=cr04&crtipe=Topik">Topik</option>
<option value="'.$filenya.'?crkd=cr05&crtipe=Volume">Volume</option>
<option value="'.$filenya.'?crkd=cr06&crtipe=Nomor">Nomor</option>
<option value="'.$filenya.'?crkd=cr07&crtipe=Tempat Rak">Tempat Rak</option>
</select>
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="btnCARI" type="submit" value="CARI">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>';


//barcode
if ($crkd == "cr01")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item2.*, perpus_item2.kd AS pitkd ".
			"FROM perpus_item2 ".
			"WHERE barkode LIKE '%$kunci%'".
			"ORDER BY round(barkode) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//kode
else if ($crkd == "cr02")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item2.*, perpus_item2.kd AS pitkd ".
			"FROM perpus_item2 ".
			"WHERE kode LIKE '%$kunci%' ".
			"ORDER BY round(kode) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//nama
else if ($crkd == "cr03")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item2.*, perpus_item2.kd AS pitkd ".
			"FROM perpus_item2, perpus_m_majalah2 ".
			"WHERE perpus_item2.kd_majalah = perpus_m_majalah2.kd ".
			"AND perpus_item2.topik LIKE '%$kunci%' ".
			"ORDER BY topik ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//topik
else if ($crkd == "cr04")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item2.*, perpus_item2.kd AS pitkd ".
			"FROM perpus_item2 ".
			"WHERE topik LIKE '%$kunci%' ".
			"ORDER BY topik ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//volume
else if ($crkd == "cr05")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item2.*, perpus_item2.kd AS pitkd ".
			"FROM perpus_item2 ".
			"WHERE volume LIKE '%$kunci%' ".
			"ORDER BY volume ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//nomor
else if ($crkd == "cr06")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item2.*, perpus_item2.kd AS pitkd ".
			"FROM perpus_item2 ".
			"WHERE nomor LIKE '%$kunci%' ".
			"ORDER BY nomor ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//tempat rak
else if ($crkd == "cr07")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item2.*, perpus_item2.kd AS pitkd ".
			"FROM perpus_item2 ".
			"WHERE rak LIKE '%$kunci%' ".
			"ORDER BY rak ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item2.*, perpus_item2.kd AS pitkd ".
			"FROM perpus_item2 ".
			"ORDER BY tglmasuk DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}





//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT DATE_FORMAT(tglmasuk, '%d') AS masuk_tgl, ".
				"DATE_FORMAT(tglmasuk, '%m') AS masuk_bln, ".
				"DATE_FORMAT(tglmasuk, '%Y') AS masuk_thn, ".
				"perpus_item2.* ".
				"FROM perpus_item2 ".
				"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_kode = balikin2($rowx['kode']);
	$e_barkode = nosql($rowx['barkode']);
	$e_judul = balikin2($rowx['topik']);
	$e_status = nosql($rowx['status']);
	$e_img_cover = balikin2($rowx['img_cover']);



	//status
	if ($e_status == "false")
		{
		$e_status_ket = "Belum Bisa Dipinjam";
		}
	else
		{
		$e_status_ket = "BISA DIPINJAM";
		}


	//stock
	$qsoki = mysql_query("SELECT * FROM perpus_stock ".
				"WHERE kd_item = '$kdx'");
	$rsoki = mysql_fetch_assoc($qsoki);
	$tsoki = mysql_num_rows($qsoki);
	$soki_bagus = round(nosql($rsoki['jml_bagus']));
	$soki_rusak = round(nosql($rsoki['jml_rusak']));
	$soki_hilang = round(nosql($rsoki['jml_hilang']));
	$soki_dipinjam = round(nosql($rsoki['jml_dipinjam']));
	$soki_total = round($soki_bagus + $soki_rusak + $soki_hilang + $soki_dipinjam);



	echo '<hr>
	Kode : <strong>'.$e_kode.'</strong>
	<br>
	Barcode : <strong>'.$e_barkode.'</strong>
	<br>
	Nama Item : <strong>'.$e_judul.'</strong>
	<br>
	<br>
	Jml. Bagus :
	<br>
	<input name="jml_bagus" type="text" value="'.$soki_bagus.'" size="5" onKeyPress="return numbersonly(this, event)" onKeyUp="document.formx.jml_total.value=eval(document.formx.jml_bagus.value) + eval(document.formx.jml_hilang.value) + eval(document.formx.jml_rusak.value) + eval(document.formx.jml_dipinjam.value);">
	<br>
	<br>

	Jml. Rusak :
	<br>
	<input name="jml_rusak" type="text" value="'.$soki_rusak.'" size="5" onKeyPress="return numbersonly(this, event)" onKeyUp="document.formx.jml_total.value=eval(document.formx.jml_bagus.value) + eval(document.formx.jml_hilang.value) + eval(document.formx.jml_rusak.value) + eval(document.formx.jml_dipinjam.value);">
	<br>
	<br>

	Jml. Hilang :
	<br>
	<input name="jml_hilang" type="text" value="'.$soki_hilang.'" size="5" onKeyPress="return numbersonly(this, event)" onKeyUp="document.formx.jml_total.value=eval(document.formx.jml_bagus.value) + eval(document.formx.jml_hilang.value) + eval(document.formx.jml_rusak.value) + eval(document.formx.jml_dipinjam.value);">
	<br>
	<br>

	Jml. Dipinjam :
	<br>
	<input name="jml_dipinjam" type="text" value="'.$soki_dipinjam.'" size="5" class="input" readonly>
	<br>
	<br>

	Jml. Total :
	<br>
	<input name="jml_total" type="text" value="'.$soki_total.'" size="5" class="input" readonly>
	<br>
	<br>

	Status Pinjam :
	<br>
	<select name="status">
	<option value="'.$e_status.'" selected>'.$e_status_ket.'</option>
	<option value="false">Belum Bisa Dipinjam</option>
	<option value="true">BISA DIPINJAM</option>
	</select>
	<br>
	<br>

	<input name="page" type="hidden" value="'.$page.'">
	<input name="crkd" type="hidden" value="'.$crkd.'">
	<input name="crtipe" type="hidden" value="'.$crtipe.'">
	<input name="kunci" type="hidden" value="'.$kunci.'">
	<input name="kd" type="hidden" value="'.$kd.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="DAFTAR STOCK >>">';
	}
else
	{
	//jika ada
	if ($count != 0)
		{
		echo '<table width="980" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="75"><strong><font color="'.$warnatext.'">Cover</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Keterangan</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml. Bagus</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml. Rusak</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml. Hilang</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml. Dipinjam</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Total</font></strong></td>
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
			$i_kd = nosql($data['pitkd']);
			$i_kode = balikin2($data['kode']);
			$i_barkode = balikin2($data['barkode']);
			$i_judul = balikin2($data['topik']);
			$i_status = nosql($data['status']);
			$i_img_cover = balikin2($data['img_cover']);
			$i_kd_majalah = nosql($data['kd_majalah']);
			$i_volume = balikin2($data['volume']);
			$i_nomor = balikin2($data['nomor']);
			$i_kd_perolehan = nosql($data['kd_perolehan']);
			$i_rak = balikin2($data['rak']);
			$i_tgl_terbit = $data['tglterbit'];
			$i_tgl_entri = $data['tglentri'];
			$i_tgl_masuk = $data['tglmasuk'];



			//cek tgl
			if ((empty($i_tgl_masuk)) OR ($i_tgl_masuk == "0000-00-00 00:00:00"))
				{
				mysql_query("UPDATE perpus_item2 SET tglmasuk = '$i_tgl_entri' ".
						"WHERE kd = '$i_kd'");
				}




			//perolehan
			$qoleh = mysql_query("SELECT * FROM perpus_m_perolehan ".
						"WHERE kode = '$i_kd_perolehan'");
			$roleh = mysql_fetch_assoc($qoleh);
			$i_perolehan_kode = nosql($roleh['kode']);
			$i_perolehan = balikin2($roleh['nama']);


			//stock
			$qsoki = mysql_query("SELECT * FROM perpus_stock ".
						"WHERE kd_item = '$i_kd'");
			$rsoki = mysql_fetch_assoc($qsoki);
			$tsoki = mysql_num_rows($qsoki);
			$soki_bagus = nosql($rsoki['jml_bagus']);
			$soki_rusak = nosql($rsoki['jml_rusak']);
			$soki_hilang = nosql($rsoki['jml_hilang']);
			$soki_dipinjam = nosql($rsoki['jml_dipinjam']);
			$soki_total = round($soki_bagus + $soki_rusak + $soki_hilang + $jml_dipinjam);



			//status
			if ($i_status == "false")
				{
				$i_status_ket = "<font color=\"brown\">Belum Bisa Dipinjam</font>";
				}
			else
				{
				$i_status_ket = "<font color=\"blue\">BISA DIPINJAM</font>";
				}


			//jika null
			if (empty($i_img_cover))
				{
				$i_foto = "<img src=\"$sumber/img/foto_blank.jpg\" alt=\"$e_judul\" width=\"75\" height=\"100\" border=\"1\">";
				}
			else
				{
				$i_foto = "<img src=\"$sumber/filebox/perpus/$i_kd/thumb2_$i_img_cover\" alt=\"$e_judul\" width=\"75\" height=\"100\" border=\"1\">";
				}



			//jika null, berikan satu ya....
			if (empty($soki_bagus))
				{
				$qcc = mysql_query("SELECT * FROM perpus_stock ".
								"WHERE kd_item = '$i_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);


				//jika ada
				if ($tcc != 0)
					{
					mysql_query("UPDATE perpus_stock SET jml_bagus = '1' ".
							"WHERE kd_item = '$i_kd'");
					}
				else
					{
					mysql_query("INSERT INTO perpus_stock(kd, kd_item, jml_bagus) VALUES ".
								"('$x', '$i_kd', '1')");
					}
				}




			//majalah
			$qoleh = mysql_query("SELECT * FROM perpus_m_majalah ".
						"WHERE kode = '$i_kd_majalah'");
			$roleh = mysql_fetch_assoc($qoleh);
			$i_majalah = balikin2($roleh['nama']);




			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			'.$i_foto.'
			</td>
			<td>
			<big>
			<font color="red">
			<strong>'.$i_judul.'</strong>
			</font>
			</big>
			<br>
			Barcode :
			<strong><em>'.$i_barkode.'</em></strong>
			<br>
			Nama Majalah :
			<strong><em>'.$i_majalah.'</em></strong>
			<br>
			Volume :
			<strong><em>'.$i_volume.'</em></strong>
			<br>
			Nomor :
			<strong><em>'.$i_nomor.'</em></strong>
			<br>
			Tanggal Terbit :
			<strong><em>'.$i_tgl_terbit.'</em></strong>
			<br>
			Call Number :
			<strong><em>'.$i_kode.'</em></strong>
			<br>
			Berada di Rak :
			<strong><em>'.$i_rak.'</em></strong>
			<br>
			<br>


			Tanggal Entri :
			<strong><em>'.$i_tgl_entri.'</em></strong>
			<br>

			Tanggal Masuk :
			<strong><em>'.$i_tgl_masuk.'</em></strong>
			<br>
			<br>

			[<strong>'.$i_status_ket.'</strong>].
			[<a href="'.$filenya.'?s=edit&kd='.$i_kd.'&page='.$page.'&crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" title="Edit Stock"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>]
			</td>
			<td>'.$soki_bagus.'</td>
			<td>'.$soki_rusak.'</td>
			<td>'.$soki_hilang.'</td>
			<td>'.$soki_dipinjam.'</td>
			<td>'.$soki_total.'</td>
	        	</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="980" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
		</tr>
		</table>';
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

echo '</form>';
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
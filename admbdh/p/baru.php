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
require("../../inc/cek/admbdh.php");
require("../../inc/class/paging.php");
require("../../inc/class/thumbnail_images.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "baru.php";
$judul = "Koleksi Item Terbaru";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
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





//jika detail
if ($s == "detail")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT DATE_FORMAT(tgl_masuk, '%d') AS masuk_tgl, ".
							"DATE_FORMAT(tgl_masuk, '%m') AS masuk_bln, ".
							"DATE_FORMAT(tgl_masuk, '%Y') AS masuk_thn, ".
							"perpus_item.* ".
							"FROM perpus_item ".
							"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_katkd = nosql($rowx['kd_kategori']);
	$e_bitkd = nosql($rowx['kd_penerbit']);
	$e_rakkd = nosql($rowx['kd_rak']);
	$e_kode = nosql($rowx['kode']);
	$e_barkode = nosql($rowx['barkode']);
	$e_judul = balikin2($rowx['judul']);
	$e_penulis1 = balikin2($rowx['penulis1']);
	$e_penulis2 = balikin2($rowx['penulis2']);
	$e_penulis3 = balikin2($rowx['penulis3']);
	$e_tahun_terbit = nosql($rowx['tahun_terbit']);
	$e_issn_isbn = nosql($rowx['issn_isbn']);
	$e_percetakan = balikin2($rowx['percetakan']);
	$e_editor = balikin2($rowx['editor']);
	$e_ukuran = balikin2($rowx['ukuran']);
	$e_jml_halaman = balikin2($rowx['jml_halaman']);
	$e_tebal = balikin2($rowx['tebal']);
	$e_cetakan_ke = balikin2($rowx['cetakan_ke']);
	$e_harga = nosql($rowx['harga']);
	$e_bahasa = balikin2($rowx['bahasa']);
	$e_rangkuman = balikin2($rowx['rangkuman']);
	$e_masuk_tgl = nosql($rowx['masuk_tgl']);
	$e_masuk_bln = nosql($rowx['masuk_bln']);
	$e_masuk_thn = nosql($rowx['masuk_thn']);
	$e_status = nosql($rowx['status']);
	$e_img_cover = balikin2($rowx['img_cover']);
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
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="900" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
xheadline($judul);
echo '</td>
<td align="right">';
echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$crkd.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?crkd=cr01&crtipe=BarCode">BarCode</option>
<option value="'.$filenya.'?crkd=cr02&crtipe=Kode">Kode</option>
<option value="'.$filenya.'?crkd=cr03&crtipe=Judul">Judul</option>
<option value="'.$filenya.'?crkd=cr04&crtipe=Kategori">Kategori</option>
<option value="'.$filenya.'?crkd=cr05&crtipe=Penerbit">Penerbit</option>
<option value="'.$filenya.'?crkd=cr06&crtipe=Penulis">Penulis</option>
<option value="'.$filenya.'?crkd=cr07&crtipe=Tempat Rak">Tempat Rak</option>
<option value="'.$filenya.'?crkd=cr08&crtipe=ISSN/ISBN">ISSN/ISBN</option>
</select>
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="btnCARI" type="submit" value="CARI">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>';

//jika detail
if ($s == "detail")
	{
	//kategori
	$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
							"WHERE kd = '$e_katkd'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_kategori_kode = nosql($rkatx['kode']);
	$e_kategori = balikin2($rkatx['kategori']);


	//rak
	$qrakx = mysql_query("SELECT * FROM perpus_rak ".
							"WHERE kd = '$e_rakkd'");
	$rrakx = mysql_fetch_assoc($qrakx);
	$e_rak = balikin2($rrakx['rak']);



	//penerbit
	$qbitx = mysql_query("SELECT * FROM perpus_penerbit ".
							"WHERE kd = '$e_bitkd'");
	$rbitx = mysql_fetch_assoc($qbitx);
	$e_bit = balikin2($rbitx['nama']);


	//status
	if ($e_status == "false")
		{
		$e_status_ket = "Belum Bisa Dipinjam";
		}
	else
		{
		$e_status_ket = "BISA DIPINJAM";
		}

	echo '<hr>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="600">
	<p>
	BarCode :
	<br>
	<strong>'.$e_barkode.'</strong>
	<br>
	<br>
	Kategori :
	<br>
	<strong>'.$e_kategori_kode.'. '.$e_kategori.'</strong>
	<br>
	<br>
	Tempat Rak :
	<br>
	<br>
	<br>
	Kode Item :
	<br>
	<strong>'.$e_kode.'</strong>
	<br>
	<br>
	Judul :
	<br>
	<strong>'.$e_judul.'</strong>
	<br>
	<br>
	Penulis :
	<br>
	<strong>'.$e_penulis1.'</strong>,
	<strong>'.$e_penulis2.'</strong>,
	<strong>'.$e_penulis3.'</strong>
	<br>
	<br>
	Editor :
	<br>
	<strong>'.$e_editor.'</strong>
	<br>
	<br>
	Penerbit :
	<br>
	<strong>'.$e_bit.'</strong>
	<br>
	<br>
	Percetakan :
	<br>
	<strong>'.$e_percetakan.'</strong>
	<br>
	<br>
	Tahun Terbit :
	<br>
	<strong>'.$e_tahun_terbit.'</strong>
	<br>
	<br>
	ISSN/ISBN :
	<br>
	<strong>'.$e_issn_isbn.'</strong>
	<br>
	<br>
	Ukuran :
	<br>
	<strong>'.$e_ukuran.'</strong>
	<br>
	<br>
	Jumlah Halaman :
	<br>
	<strong>'.$e_jml_halaman.'</strong>
	<br>
	<br>
	Tebal :
	<br>
	<strong>'.$e_tebal.'</strong>
	<br>
	<br>
	Cetakan Ke-:
	<br>
	<strong>'.$e_cetakan_ke.'</strong>
	<br>
	<br>
	Bahasa :
	<br>
	<strong>'.$e_bahasa.'</strong>
	<br>
	<br>
	Harga :
	<br>
	<strong>'.xduit2($e_harga).'</strong>
	<br>
	<br>
	Rangkuman :
	<br>
	<strong>'.$e_rangkuman.'</strong>
	<br>
	<br>
	Tgl. Masuk :
	<br>
	<strong>'.$e_masuk_tgl.' '.$arrbln1[$e_masuk_bln].' '.$e_masuk_thn.'</strong>
	<br>
	<br>
	Status Pinjam :
	<br>
	<strong>'.$e_status_ket.'</strong>
	<br>
	<br>
	<input name="btnBTL" type="submit" value="DAFTAR ITEM >>">
	</p>
	</td>
	<td>';
	//nek null foto
	if (empty($e_img_cover))
		{
		$nil_foto = "$sumber/img/foto_blank.jpg";
		}
	else
		{
		//gawe thumnail #1
		$obj_img2 = new thumbnail_images();
		$obj_img2->PathImgOld = "$sumber/filebox/perpus/$kd/$e_img_cover";
		$obj_img2->PathImgNew = "../../filebox/perpus/$kd/thumb_$e_img_cover";
		$obj_img2->NewHeight = 300;
		$obj_img2->NewWidth = 195;
		if (!$obj_img2->create_thumbnail_images())
			{
			echo '<font color="red"><strong>Gagal Membuat Thumbnail...!</strong></font>';
			}
		else
			{
			$nil_foto = $obj_img2->PathImgNew;
			}


		//gawe thumnail #2
		$obj_img3 = new thumbnail_images();
		$obj_img3->PathImgOld = "$sumber/filebox/perpus/$kd/thumb_$e_img_cover";
		$obj_img3->PathImgNew = "../../filebox/perpus/$kd/thumb2_$e_img_cover";
		$obj_img3->NewHeight = 100;
		$obj_img3->NewWidth = 75;
		if (!$obj_img3->create_thumbnail_images())
			{
			echo '<font color="red"><strong>Gagal Membuat Thumbnail...!</strong></font>';
			}
		else
			{
			$nil_foto2 = $obj_img3->PathImgNew;
			}
		}

	echo '<img src="'.$nil_foto.'" alt="'.$e_judul.'" width="195" height="300" border="5">
	</td>
	</tr>
	</table>';
	}

else
	{
	//barcode
	if ($crkd == "cr01")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
						"FROM perpus_item ".
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

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
						"FROM perpus_item ".
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

	//judul
	else if ($crkd == "cr03")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
						"FROM perpus_item ".
						"WHERE judul LIKE '%$kunci%' ".
						"ORDER BY round(judul) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//kategori
	else if ($crkd == "cr04")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_kategori.* ".
						"FROM perpus_item, perpus_kategori ".
						"WHERE perpus_item.kd_kategori = perpus_kategori.kd ".
						"AND perpus_kategori.kategori LIKE '%$kunci%' ".
						"ORDER BY round(perpus_kategori.kategori) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//penerbit
	else if ($crkd == "cr05")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_penerbit.* ".
						"FROM perpus_item, perpus_penerbit ".
						"WHERE perpus_item.kd_penerbit = perpus_penerbit.kd ".
						"AND perpus_penerbit.nama LIKE '%$kunci%' ".
						"ORDER BY round(perpus_penerbit.nama) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//penulis
	else if ($crkd == "cr06")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
				"FROM perpus_item ".
				"WHERE perpus_item.penulis1 LIKE '%$kunci%' ".
				"ORDER BY perpus_item.penulis1 ASC";
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

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_rak.* ".
						"FROM perpus_item, perpus_rak ".
						"WHERE perpus_item.kd_rak = perpus_rak.kd ".
						"AND perpus_rak.rak LIKE '%$kunci%' ".
						"ORDER BY round(perpus_rak.rak) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//issn/isbn
	else if ($crkd == "cr08")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
						"FROM perpus_item ".
						"WHERE issn_isbn LIKE '%$kunci%' ".
						"ORDER BY round(issn_isbn) ASC";
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

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
						"FROM perpus_item ".
						"ORDER BY tgl_masuk DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}


	if ($count != 0)
		{
		echo '<table width="900" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="75"><strong><font color="'.$warnatext.'">Cover</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Keterangan</font></strong></td>
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
			$i_kode = nosql($data['kode']);
			$i_barkode = nosql($data['barkode']);
			$i_judul = balikin2($data['judul']);
			$i_katkd = nosql($data['kd_kategori']);
			$i_editor = balikin2($data['editor']);
			$i_penulis1 = balikin2($data['penulis1']);
			$i_penulis2 = balikin2($data['penulis2']);
			$i_penulis3 = balikin2($data['penulis3']);
			$i_bitkd = nosql($data['kd_penerbit']);
			$i_percetakan = balikin2($data['percetakan']);
			$i_tahun_terbit = balikin2($data['tahun_terbit']);
			$i_issn_isbn = balikin2($data['issn_isbn']);
			$i_status = nosql($data['status']);
			$i_rangkuman = balikin2($data['rangkuman']);
			$i_img_cover = balikin2($data['img_cover']);


			//kategori
			$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
									"WHERE kd = '$i_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$i_kategori_kode = nosql($rkatx['kode']);
			$i_kategori = balikin2($rkatx['kategori']);





			//penerbit
			$qbitx = mysql_query("SELECT * FROM perpus_penerbit ".
									"WHERE kd = '$i_bitkd'");
			$rbitx = mysql_fetch_assoc($qbitx);
			$i_penerbit = balikin2($rbitx['nama']);


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

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<a href="'.$filenya.'?s=detail&kd='.$i_kd.'" title="'.$i_judul.'">'.$i_foto.'</a>
			</td>
			<td>
			<big>
			<font color="red">
			<strong>'.$i_judul.'</strong>
			</font>
			</big>
			<br>
			Kode :
			<strong><em>'.$i_kode.'</em></strong>
			<br>
			BarCode :
			<strong><em>'.$i_barkode.'</em></strong>
			<br>
			Kategori :
			<strong><em>'.$i_kategori_kode.'. '.$i_kategori.'</em></strong>
			<br>
			Penulis :
			<strong><em>'.$i_penulis1.'</em></strong>,
			<strong><em>'.$i_penulis2.'</em></strong>,
			<strong><em>'.$i_penulis3.'</em></strong>
			<br>
			Editor :
			<strong><em>'.$i_editor.'</em></strong>
			<br>
			Penerbit :
			<strong><em>'.$i_penerbit.'</em></strong>
			<br>
			Percetakan :
			<strong><em>'.$i_percetakan.'</em></strong>
			<br>
			Tahun Terbit :
			<strong><em>'.$i_tahun_terbit.'</em></strong>
			<br>
			ISSN/ISBN :
			<strong><em>'.$i_issn_isbn.'</em></strong>
			<br>
			<br>
			<em>'.$i_rangkuman.'</em>
			<br>
			<br>
			[...<a href="'.$filenya.'?s=detail&kd='.$i_kd.'" title="'.$i_judul.'">SELENGKAPNYA</a>].
			[<strong>'.$i_status_ket.'</strong>].
			</td>
	        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="900" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right">
		<input name="jml" type="hidden" value="'.$count.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'"> '.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
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
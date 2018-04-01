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
$filenya = "item_buku_paket.php";
$judul = "Item Buku Paket";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
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



//focus
if ($s == "baru")
	{
	$diload = "document.formx.barkode.focus();";
	}
else
	{
	$diload = "document.formx.jenis.focus();";
	}


//nek enter
$x_enter = 'onkeydown="return handleEnter(this, event)"';
$x_enter2 = 'onkeydown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	document.formx.btnSMP.submit();
	}"';



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





//jika edit
if ($s == "edit")
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
	$e_penulis1 = balikin2($rowx['penulis1']);
	$e_penulis2 = balikin2($rowx['penulis2']);
	$e_penulis3 = balikin2($rowx['penulis3']);
	$e_bitkd = nosql($rowx['kd_penerbit']);
	$e_rakkd = nosql($rowx['kd_rak']);
	$e_kode = nosql($rowx['kode']);
	$e_barkode = nosql($rowx['barkode']);
	$e_no_inven = balikin($rowx['no_inventaris']);
	$e_judul = balikin2($rowx['judul']);
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



//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$jenis = nosql($_POST['kategori']);
	$penulis1 = cegah2($_POST['penulis1']);
	$penulis2 = cegah2($_POST['penulis2']);
	$penulis3 = cegah2($_POST['penulis3']);
	$penerbit = nosql($_POST['penerbit']);
	$rak = nosql($_POST['rak']);
	$kode = nosql($_POST['kode']);
	$barkode = nosql($_POST['barkode']);
	$no_inven = cegah($_POST['no_inven']);
	$judul = cegah2($_POST['judul']);
	$tahun_terbit = nosql($_POST['tahun_terbit']);
	$issn_isbn = nosql($_POST['issn_isbn']);
	$percetakan = balikin2($_POST['percetakan']);
	$editor = balikin2($_POST['editor']);
	$ukuran = balikin2($_POST['ukuran']);
	$jml_halaman = balikin2($_POST['jml_halaman']);
	$tebal = balikin2($_POST['tebal']);
	$cetakan_ke = balikin2($_POST['cetakan_ke']);
	$harga = nosql($_POST['harga']);
	$bahasa = balikin2($_POST['bahasa']);
	$rangkuman = balikin2($_POST['rangkuman']);
	$masuk_tgl = nosql($_POST['masuk_tgl']);
	$masuk_bln = nosql($_POST['masuk_bln']);
	$masuk_thn = nosql($_POST['masuk_thn']);
	$tgl_masuk = "$masuk_thn:$masuk_bln:$masuk_tgl";
	$status = nosql($_POST['status']);
	$jml_brg = nosql($_POST['jml_brg']);


	//jika baru
	if ($s == "baru")
		{
		//cek barkode, ok.
		if (!empty($barkode))
			{
			///cek
			$qcc = mysql_query("SELECT * FROM perpus_item ".
						"WHERE barkode = '$barkode'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "BarKode Item : $barkode, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=baru&kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO perpus_item(kd, barkode) VALUES ".
						"('$kd', '$barkode')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&kd=$kd";
				xloc($ke);
				exit();
				}
			}


		//null barkode...
		else
			{
			//nek null
			if ((empty($kode)) OR (empty($judul)))
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
				$ke = "$filenya?s=baru&kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				///cek
				$qcc = mysql_query("SELECT * FROM perpus_item ".
							"WHERE kode = '$kode'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//diskonek
					xfree($qbw);
					xclose($koneksi);

					//re-direct
					$pesan = "Call Number : $kode, Sudah Ada. Silahkan Ganti Yang Lain...!!";
					$ke = "$filenya?s=baru&kd=$kd";
					pekem($pesan,$ke);
					exit();
					}
				else
					{
					//query
					mysql_query("INSERT INTO perpus_item(kd, kd_kategori, penulis1, penulis2, penulis2, ".
							"kd_penerbit, kd_rak, kode, barkode, no_inventaris, judul, ".
							"tahun_terbit, issn_isbn, percetakan, editor, ukuran, jml_halaman, tebal, ".
							"cetakan_ke, harga, bahasa, rangkuman, tgl_masuk, status, postdate) VALUES ".
							"('$kd', '$jenis', '$penulis1', '$penulis2', '$penulis3', ".
							"'$penerbit', '$rak', '$kode', '$barkode', '$no_inven', '$judul', ".
							"'$tahun_terbit', '$issn_isbn', '$percetakan', '$editor', '$ukuran', '$jml_halaman', '$tebal', ".
							"'$cetakan_ke', '$harga', '$bahasa', '$rangkuman', '$tgl_masuk', '$status', '$today')");



					//insert
					mysql_query("INSERT INTO perpus_stock(kd, kd_item, jml_bagus, jml_total) VALUES ".
							"('$x', '$kd', '$jml_brg', '$jml_brg')");


					//diskonek
					xfree($qbw);
					xclose($koneksi);

					//re-direct
					$ke = "$filenya?s=edit&kd=$kd";
					xloc($ke);
					exit();
					}
				}
			}
		}



	//jika update
	else if ($s == "edit")
		{
		//cek
		$qcc = mysql_query("SELECT * FROM perpus_item ".
					"WHERE barkode = '$barkode'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_kd = nosql($rcc['kd']);

		//jika ada duplikasi
		if (($tcc != 0) AND ($cc_kd != $kd))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "BarCode : $barkode, Sudah Ada. Harap Diperhatikan...!!";
			$ke = "$filenya?s=edit&kd=$kd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			mysql_query("UPDATE perpus_item SET kd_kategori = '$jenis', ".
					"penulis1 = '$penulis1', ".
					"penulis2 = '$penulis2', ".
					"penulis3 = '$penulis3', ".
					"kd_penerbit = '$penerbit', ".
					"kd_rak = '$rak', ".
					"kode = '$kode', ".
					"barkode = '$barkode', ".
					"no_inventaris = '$no_inven', ".
					"judul = '$judul', ".
					"tahun_terbit = '$tahun_terbit', ".
					"issn_isbn = '$issn_isbn', ".
					"percetakan = '$percetakan', ".
					"editor = '$editor', ".
					"ukuran = '$ukuran', ".
					"jml_halaman = '$jml_halaman', ".
					"tebal = '$tebal', ".
					"cetakan_ke = '$cetakan_ke', ".
					"harga = '$harga', ".
					"bahasa = '$bahasa', ".
					"rangkuman = '$rangkuman', ".
					"tgl_masuk = '$tgl_masuk', ".
					"postdate = '$today', ".
					"tgl_entri = '$today', ".
					"status = '$status' ".
					"WHERE kd = '$kd'");




			//update
			mysql_query("UPDATE perpus_stock SET jml_bagus = '$jml_brg' ".
					"WHERE kd_item = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&kd=$kd";
			xloc($ke);
			exit();
			}
		}
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//hapus file yang ada dulu
		//query
		$qcc = mysql_query("SELECT * FROM perpus_item ".
					"WHERE kd = '$kd'");
		$rcc = mysql_fetch_assoc($qcc);

		//hapus file
		$cc_filex = $rcc['img_cover'];
		$path1 = "../../filebox/perpus/$kd/$cc_filex";
		chmod($path1,0777);
		unlink ($path1);


		//del
		mysql_query("DELETE FROM perpus_item ".
				"WHERE kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}





//ganti foto profil
if ($_POST['btnGNT'])
	{
	//nilai
	$kd = nosql($_POST['kd']);
	$s = nosql($_POST['s']);
	$filex_namex = strip(strtolower($_FILES['filex_foto']['name']));


	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".jpg")
			{
			//nilai
			$path1 = "../../filebox/perpus/$kd";
			chmod($path1,0777);

			//cek, sudah ada belum
			if (!file_exists($path1))
				{
				//bikin folder kd_user
				mkdir("$path1", $chmod);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/perpus/$kd/$filex_namex");

				//query
				mysql_query("UPDATE perpus_item SET img_cover = '$filex_namex' ".
						"WHERE kd = '$kd'");

				//null-kan
				xclose($koneksi);

				chmod($path1,0755);

				//re-direct
				$ke = "$filenya?s=$s&kd=$kd";
				xloc($ke);
				exit();
				}
			else
				{
				//hapus file yang ada dulu
				//query
				$qcc = mysql_query("SELECT * FROM perpus_item ".
							"WHERE kd = '$kd'");
				$rcc = mysql_fetch_assoc($qcc);

				//hapus file
				$cc_filex = $rcc['img_cover'];
				$path1 = "../../filebox/perpus/$kd/$cc_filex";
				chmod($path1,0777);
				unlink ($path1);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/perpus/$kd/$filex_namex");

				//query
				mysql_query("UPDATE perpus_item SET img_cover = '$filex_namex' ".
								"WHERE kd = '$kd'");

				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=$s&kd=$kd";
				xloc($ke);
				exit();
				}
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			$ke = "$filenya?s=$s&kd=$kd";
			pekem($pesan,$ke);
			exit();
			}
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
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" bgcolor="'.$warna02.'" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
xheadline($judul);
echo ' [<a href="'.$filenya.'?s=baru&kd='.$x.'" title="Entry Baru">Entry Baru</a>]
</td>
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

//jika baru/edit
if (($s == "baru") OR ($s == "edit"))
	{
	//jenis
	$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
							"WHERE kd = '$e_katkd'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_jenis_kode = nosql($rkatx['kode']);
	$e_jenis = balikin2($rkatx['kategori']);


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
	else if ($e_status == "true")
		{
		$e_status_ket = "Bisa Dipinjam";
		}
	else if ($e_status == "1")
		{
		$e_status_ket = "Item Referensi";
		}
	else if ($e_status == "2")
		{
		$e_status_ket = "Buku Paket";
		}


	echo '<hr>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="600">
	<p>
	BarCode / No.Inventaris :
	<br>
	<input name="barkode" type="text" value="'.$e_barkode.'" size="30" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>
	<br>
	<br>
	Jenis :
	<br>
	<select name="kategori">
	<option value="'.$e_katkd.'" selected>'.$e_jenis_kode.'. '.$e_jenis.'</option>';

	//list jenis
	$qkat = mysql_query("SELECT * FROM perpus_kategori ".
				"WHERE kd <> '$e_katkd' ".
				"ORDER BY kategori ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_jenis_kode = nosql($rkat['kode']);
		$kat_jenis = balikin($rkat['kategori']);

		echo '<option value="'.$kat_kd.'">'.$kat_jenis_kode.'. '.$kat_jenis.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	<br>
	<br>
	Tempat Rak :
	<br>
	<select name="rak">
	<option value="'.$e_rakkd.'" selected>'.$e_rak.'</option>';

	//list rak
	$qrak = mysql_query("SELECT * FROM perpus_rak ".
							"WHERE kd <> '$e_rakkd' ".
							"ORDER BY rak ASC");
	$rrak = mysql_fetch_assoc($qrak);

	do
		{
		//nilai
		$rak_kd = nosql($rrak['kd']);
		$rak_rak = balikin($rrak['rak']);

		echo '<option value="'.$rak_kd.'">'.$rak_rak.'</option>';
		}
	while ($rrak = mysql_fetch_assoc($qrak));

	echo '</select>
	<br>
	<br>
	Call Number :
	<br>
	<input name="kode" type="text" value="'.$e_kode.'" size="10"  '.$x_enter2.'>
	<br>
	<br>

	No.Inventaris :
	<br>
	<input name="no_inven" type="text" value="'.$e_no_inven.'" size="20"  '.$x_enter2.'>
	<br>
	<br>

	Judul :
	<br>
	<input name="judul" type="text" value="'.$e_judul.'" size="50"  '.$x_enter2.'>
	<br>
	<br>
	Penulis 1 :
	<br>
	<input name="penulis1" type="text" value="'.$e_penulis1.'" size="30"  '.$x_enter2.'>
	<br>
	Penulis 2 :
	<br>
	<input name="penulis2" type="text" value="'.$e_penulis2.'" size="30"  '.$x_enter2.'>
	<br>
	Penulis 3 :
	<br>
	<input name="penulis3" type="text" value="'.$e_penulis3.'" size="30"  '.$x_enter2.'>
	<br>
	<br>
	Editor :
	<br>
	<input name="editor" type="text" value="'.$e_editor.'" size="30"  '.$x_enter2.'>
	<br>
	<br>
	Penerbit :
	<br>
	<select name="penerbit">
	<option value="'.$e_bitkd.'" selected>'.$e_bit.'</option>';

	//list penerbit
	$qbit = mysql_query("SELECT * FROM perpus_penerbit ".
							"WHERE kd <> '$e_bitkd' ".
							"ORDER BY nama ASC");
	$rbit = mysql_fetch_assoc($qbit);

	do
		{
		//nilai
		$bit_kd = nosql($rbit['kd']);
		$bit_nama = balikin($rbit['nama']);

		echo '<option value="'.$bit_kd.'">'.$bit_nama.'</option>';
		}
	while ($rbit = mysql_fetch_assoc($qbit));

	echo '</select>
	<br>
	<br>
	Percetakan :
	<br>
	<input name="percetakan" type="text" value="'.$e_percetakan.'" size="50"  '.$x_enter2.'>
	<br>
	<br>
	Tahun Terbit :
	<br>
	<input name="tahun_terbit" type="text" value="'.$e_tahun_terbit.'" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)"  '.$x_enter2.'>
	<br>
	<br>
	ISSN/ISBN :
	<br>
	<input name="issn_isbn" type="text" value="'.$e_issn_isbn.'" size="20" onKeyPress="return numbersonly(this, event)"  '.$x_enter2.'>
	<br>
	<br>
	Ukuran :
	<br>
	<input name="ukuran" type="text" value="'.$e_ukuran.'" size="20" '.$x_enter2.'>
	<br>
	<br>
	Jumlah Halaman :
	<br>
	<input name="jml_halaman" type="text" value="'.$e_jml_halaman.'" size="20" '.$x_enter2.'>
	<br>
	<br>
	Tebal :
	<br>
	<input name="tebal" type="text" value="'.$e_tebal.'" size="10" '.$x_enter2.'>
	<br>
	<br>
	Cetakan Ke-:
	<br>
	<input name="cetakan_ke" type="text" value="'.$e_cetakan_ke.'" size="5" maxlength="5" '.$x_enter2.'>
	<br>
	<br>
	Bahasa :
	<br>
	<input name="bahasa" type="text" value="'.$e_bahasa.'" size="20" '.$x_enter2.'>
	<br>
	<br>
	Harga :
	<br>
	Rp. <input name="harga" type="text" value="'.$e_harga.'" size="10" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>,00
	<br>
	<br>
	Rangkuman :
	<br>
	<textarea name="rangkuman" cols="50" rows="5" wrap="virtual">'.$e_rangkuman.'</textarea>
	<br>
	<br>
	Tgl. Masuk :
	<br>
	<select name="masuk_tgl">
	<option value="'.$e_masuk_tgl.'" selected>'.$e_masuk_tgl.'</option>';
	for ($i=1;$i<=31;$i++)
		{
		echo '<option value="'.$i.'">'.$i.'</option>';
		}

	echo '</select>
	<select name="masuk_bln">
	<option value="'.$e_masuk_bln.'" selected>'.$arrbln1[$e_masuk_bln].'</option>';
	for ($j=1;$j<=12;$j++)
		{
		echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
		}

	echo '</select>
	<select name="masuk_thn">
	<option value="'.$e_masuk_thn.'" selected>'.$e_masuk_thn.'</option>';
	for ($k=$masuk01;$k<=$masuk02;$k++)
		{
		echo '<option value="'.$k.'">'.$k.'</option>';
		}
	echo '</select>
	<br>
	<br>
	Status :
	<br>
	<select name="status">
	<option value="'.$e_status.'" selected>--'.$e_status_ket.'--</option>
	<option value="false">Belum Bisa Dipinjam</option>
	<option value="true">Bisa Dipinjam</option>
	<option value="1">Item Referensi</option>
	<option value="2">Buku Paket</option>
	<br>
	<br>


	Jumlah :
	<br>
	<input name="jml_brg" type="text" value="'.$e_jml_brg.'" size="10" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>
	<br>
	<br>
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="DAFTAR ITEM >>">
	</p>
	</td>

	<td>
	<p>
	Tampilan Barcode :
	<table border="1">
	<tr>
	<td align="center"><font face="Free 3 of 9" size="20">'.$e_barkode.'</font><br />'.$e_barkode.'</td>
	</tr>
	</table>
	</p>
	<hr>

	<p>';
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

	echo 'Cover Item :
	<br>
	<img src="'.$nil_foto.'" alt="'.$e_judul.'" width="195" height="300" border="5">
	<br><br>
	<input name="filex_foto" type="file" size="15">
	<br>
	<input name="btnGNT" type="submit" value="GANTI">
	</p>
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
				"AND status = '2' ".
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
				"AND status = '2' ".
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
				"AND status = '2' ".
				"ORDER BY round(judul) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//jenis
	else if ($crkd == "cr04")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_kategori.* ".
				"FROM perpus_item, perpus_kategori ".
				"WHERE perpus_item.kd_kategori = perpus_kategori.kd ".
				"AND perpus_kategori.jenis LIKE '%$kunci%' ".
				"AND perpus_item.status = '2' ".
				"ORDER BY round(perpus_kategori.jenis) ASC";
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
				"AND perpus_item.status = '2' ".
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
				"AND perpus_item.status = '2' ".
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
				"AND perpus_item.status = '2' ".
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
				"AND perpus_item.status = '2' ".
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
				"WHERE status = '2' ".
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
		//ketahui, jumlah item referensi
		$qcc1 = mysql_query("SELECT perpus_item.kd ".
					"FROM perpus_item ".
					"WHERE status = '1'");
		$rcc1 = mysql_fetch_assoc($qcc1);
		$tcc1 = mysql_num_rows($qcc1);


		//ketahui, jumlah item yang boleh dipinjam
		$qcc2 = mysql_query("SELECT perpus_item.kd ".
					"FROM perpus_item ".
					"WHERE status = 'true'");
		$rcc2 = mysql_fetch_assoc($qcc2);
		$tcc2 = mysql_num_rows($qcc2);



		//ketahui, jumlah item yang belum boleh dipinjam
		$qcc3 = mysql_query("SELECT perpus_item.kd ".
					"FROM perpus_item ".
					"WHERE status = 'false'");
		$rcc3 = mysql_fetch_assoc($qcc3);
		$tcc3 = mysql_num_rows($qcc3);


		//ketahui, jumlah item buku paket
		$qcc4 = mysql_query("SELECT perpus_item.kd ".
					"FROM perpus_item ".
					"WHERE status = '2'");
		$rcc4 = mysql_fetch_assoc($qcc4);
		$tcc4 = mysql_num_rows($qcc4);




		//ketahui, jumlah item belum jelas
		$qcc5 = mysql_query("SELECT perpus_item.kd ".
					"FROM perpus_item ".
					"WHERE status = ''");
		$rcc5 = mysql_fetch_assoc($qcc5);
		$tcc5 = mysql_num_rows($qcc5);



		echo 'Jumlah Item Boleh Dipinjam : <strong>'.$tcc2.'</strong>.
		Jumlah Item Belum Bisa Dipinjam : <strong>'.$tcc3.'</strong>.
		Jumlah Item Referensi : <strong>'.$tcc1.'</strong>.
		<br>
		Jumlah Item Buku Paket : <strong>'.$tcc4.'</strong>.
		Jumlah Status Item Belum Jelas : <strong>'.$tcc5.'</strong>.

		<table width="980" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
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
			$i_rangkuman = balikin2($data['rangkuman']);
			$i_img_cover = balikin2($data['img_cover']);


			//jenis
			$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
						"WHERE kd = '$i_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$i_jenis_kode = nosql($rkatx['kode']);
			$i_jenis = balikin2($rkatx['kategori']);




			//penerbit
			$qbitx = mysql_query("SELECT * FROM perpus_penerbit ".
									"WHERE kd = '$i_bitkd'");
			$rbitx = mysql_fetch_assoc($qbitx);
			$i_penerbit = balikin2($rbitx['nama']);





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
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        	</td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'" title="'.$i_judul.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'" title="'.$i_judul.'">'.$i_foto.'</a>
			</td>
			<td>
			<big>
			<font color="red">
			<strong>'.$i_judul.'</strong>
			</font>
			</big>
			<br>
			Call Number :
			<strong><em>'.$i_kode.'</em></strong>
			<br>
			Jenis :
			<strong><em>'.$i_jenis_kode.'. '.$i_jenis.'</em></strong>
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
			<table border="1">
			<tr>
			<td align="center"><font face="Free 3 of 9" size="20">'.$i_barkode.'</font><br />'.$i_barkode.'</td>
			</tr>
			</table>
			<br>
			<br>
			[...<a href="'.$filenya.'?s=edit&kd='.$i_kd.'" title="'.$i_judul.'">SELENGKAPNYA</a>].
			[<strong>'.$i_status_ket.'</strong>].
			</td>
	        	</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="980" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$count.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
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
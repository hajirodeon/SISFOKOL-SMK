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
$filenya = "item.php";
$judul = "Item";
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

$sekarang = $today;



//focus
if ($s == "baru")
	{
	$diload = "document.formx.barkode.focus();";
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








//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$kategori = nosql($_POST['kategori']);
	$jenis = nosql($_POST['jenis']);
	$pengarang = cegah2($_POST['pengarang']);
	$penerbit = nosql($_POST['penerbit']);
	$rak = nosql($_POST['rak']);
	$kode = nosql($_POST['kode']);
	$barkode = nosql($_POST['barkode']);
	$judul = cegah2($_POST['judul']);
	$subyek = cegah2($_POST['subyekjudul']);
	$tahun_terbit = nosql($_POST['tahun_terbit']);
	$issn_isbn = nosql($_POST['issn_isbn']);
	$perolehan = nosql($_POST['perolehan']);
	$tebal = balikin2($_POST['tebal']);
	$panjang = balikin2($_POST['panjang']);
	$cetakan_ke = balikin2($_POST['cetakan_ke']);
	$jilid = balikin2($_POST['jilid']);
	$edisi = balikin2($_POST['edisi']);
	$bahasa = balikin2($_POST['bahasa']);
	$kota = balikin2($_POST['kota']);

	$abstraksi = balikin2($_POST['abstraksi']);
	$masuk_tgl = nosql($_POST['e_masuk_tgl']);
	$masuk_bln = nosql($_POST['e_masuk_bln']);
	$masuk_thn = nosql($_POST['e_masuk_thn']);
	$tgl_masuk = "$masuk_thn:$masuk_bln:$masuk_tgl";
	$status = nosql($_POST['status']);



	//jika baru
	if ($s == "baru")
		{
		///cek
		$qcc = mysql_query("SELECT * FROM perpus_item ".
					"WHERE kd = '$barkode'");
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


			//cek
			$qcc = mysql_query("SELECT * FROM perpus_stock ".
						"WHERE kd_item = '$kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//jika ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE perpus_stock SET jml_bagus = '1' ".
						"WHERE kd_item = '$kd'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO perpus_stock(kd, kd_item, jml_bagus, jml_rusak, jml_hilang) VALUES ".
						"('$x', '$kd', '1', '', ''");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&kd=$kd";
			xloc($ke);
			exit();
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
			mysql_query("UPDATE perpus_item SET kd_kategori = '$kategori', ".
					"kd_jenis = '$jenis', ".
					"pengarang = '$pengarang', ".
					"kd_penerbit = '$penerbit', ".
					"kd_perolehan = '$perolehan', ".
					"rak = '$rak', ".
					"kode = '$kode', ".
					"barkode = '$barkode', ".
					"judul = '$judul', ".
					"subyekjudul = '$subyekjudul', ".
					"thterbit = '$tahun_terbit', ".
					"isbn = '$issn_isbn', ".
					"tebal = '$tebal', ".
					"panjang = '$panjang', ".
					"cetakan = '$cetakan_ke', ".
					"jilid = '$jilid', ".
					"edisi = '$edisi', ".
					"kd_bahasa = '$bahasa', ".
					"kd_kota = '$kota', ".
					"abstraksi = '$abstraksi', ".
					"tglmasuk = '$tgl_masuk', ".
					"postdate = '$today', ".
					"tglentri = '$today', ".
					"status = '$status' ".
					"WHERE kd = '$kd'");


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
	//query
	$qx = mysql_query("SELECT DATE_FORMAT(tglmasuk, '%d') AS masuk_tgl, ".
				"DATE_FORMAT(tglmasuk, '%m') AS masuk_bln, ".
				"DATE_FORMAT(tglmasuk, '%Y') AS masuk_thn, ".
				"perpus_item.* ".
				"FROM perpus_item ".
				"WHERE kd = '$kd'");
	$rowx = mysql_fetch_assoc($qx);
	$e_katkd = nosql($rowx['kd_kategori']);
	$e_jnskd = nosql($rowx['kd_jenis']);
	$e_bitkd = nosql($rowx['kd_penerbit']);
	$e_kd_bahasa = nosql($rowx['kd_bahasa']);
	$e_kd_kota = nosql($rowx['kd_kota']);
	$e_pengarang = balikin2($rowx['pengarang']);
	$e_rakkd = balikin($rowx['rak']);
	$e_kd_perolehan = nosql($rowx['kd_perolehan']);
	$e_kode = balikin($rowx['kode']);
	$e_barkode = nosql($rowx['barkode']);
	$e_judul = balikin2($rowx['judul']);
	$e_tahun_terbit = nosql($rowx['thterbit']);
	$e_issn_isbn = balikin($rowx['isbn']);
	$e_tebal = balikin2($rowx['tebal']);
	$e_panjang = balikin2($rowx['panjang']);
	$e_cetakan_ke = balikin2($rowx['cetakan']);
	$e_jilid = balikin2($rowx['jilid']);
	$e_edisi = balikin2($rowx['edisi']);
	$e_rak = balikin2($rowx['rak']);

	$e_abstraksi = balikin2($rowx['abstraksi']);
	$e_masuk_tgl = nosql($rowx['masuk_tgl']);
	$e_masuk_bln = nosql($rowx['masuk_bln']);
	$e_masuk_thn = nosql($rowx['masuk_thn']);
	$e_status = nosql($rowx['status']);
	$e_img_cover = balikin2($rowx['img_cover']);



	//jenis
	$qjnsx = mysql_query("SELECT * FROM m_jenis ".
				"WHERE kode = '$e_jnskd'");
	$rjnsx = mysql_fetch_assoc($qjnsx);
	$e_jns_kode = nosql($rjnsx['kode']);
	$e_jns = balikin2($rjnsx['nama']);



	//penerbit
	$qbitx = mysql_query("SELECT * FROM perpus_penerbit ".
				"WHERE kd = '$e_bitkd'");
	$rbitx = mysql_fetch_assoc($qbitx);
	$e_bit = balikin2($rbitx['nama']);




	//kategori
	$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
				"WHERE kode = '$e_katkd'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_kat_kode = nosql($rkatx['kode']);
	$e_kat = balikin2($rkatx['kategori']);



	//kota
	$qkta = mysql_query("SELECT * FROM m_kota ".
				"WHERE kode = '$e_kd_kota'");
	$rkta = mysql_fetch_assoc($qkta);
	$e_kota_kode = nosql($rkta['kode']);
	$e_kota = balikin2($rkta['nama']);



	//perolehan
	$qoleh = mysql_query("SELECT * FROM m_perolehan ".
				"WHERE kode = '$e_kd_perolehan'");
	$roleh = mysql_fetch_assoc($qoleh);
	$e_perolehan_kode = nosql($roleh['kode']);
	$e_perolehan = balikin2($roleh['nama']);



	//bahasa
	$qbhs = mysql_query("SELECT * FROM m_bahasa ".
				"WHERE kode = '$e_kd_bahasa'");
	$rbhs = mysql_fetch_assoc($qbhs);
	$e_bhs_kode = nosql($rbhs['kode']);
	$e_bhs = balikin2($rbhs['nama']);




	//status
	if ($e_status == "false")
		{
		$e_status_ket = "Belum Bisa Dipinjam";
		}
	else if ($e_status == "true")
		{
		$e_status_ket = "Bisa Dipinjam";
		}



	echo '<hr>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="600">
	<p>
	BarCode :
	<br>
	<input name="barkode" type="text" value="'.$e_barkode.'" size="30" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>
	</p>
	<hr>



	<p>
	Perolehan dari :
	<br>
	<select name="perolehan">
	<option value="'.$e_kd_perolehan.'" selected>'.$e_perolehan.'</option>';

	//list
	$qkat = mysql_query("SELECT * FROM m_perolehan ".
				"WHERE kode <> '$e_kd_perolehan' ".
				"ORDER BY nama ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_jenis_kode = nosql($rkat['kode']);
		$kat_jenis = balikin($rkat['nama']);

		echo '<option value="'.$kat_jenis_kode.'">'.$kat_jenis_kode.'. '.$kat_jenis.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	</p>

	<p>
	Kategori :
	<br>
	<select name="kategori">
	<option value="'.$e_katkd.'" selected>'.$e_kat_kode.'. '.$e_kat.'</option>';

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

		echo '<option value="'.$kat_jenis_kode.'">'.$kat_jenis_kode.'. '.$kat_jenis.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	</p>


	<p>
	Jenis :
	<br>
	<select name="jenis">
	<option value="'.$e_jnskd.'" selected>'.$e_jnskd.'. '.$e_jns.'</option>';

	//list jenis
	$qkat = mysql_query("SELECT * FROM m_jenis ".
				"WHERE kd <> '$e_jnskd' ".
				"ORDER BY nama ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_jenis_kode = nosql($rkat['kode']);
		$kat_jenis = balikin($rkat['nama']);

		echo '<option value="'.$kat_jenis_kode.'">'.$kat_jenis_kode.'. '.$kat_jenis.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	</p>


	<p>
	Tempat Rak :
	<br>
	<select name="rak">
	<option value="'.$e_rak.'" selected>'.$e_rak.'</option>';

	//list rak
	$qrak = mysql_query("SELECT * FROM perpus_rak ".
				"ORDER BY rak ASC");
	$rrak = mysql_fetch_assoc($qrak);

	do
		{
		//nilai
		$rak_kd = nosql($rrak['kd']);
		$rak_rak = balikin($rrak['rak']);

		echo '<option value="'.$rak_rak.'">'.$rak_rak.'</option>';
		}
	while ($rrak = mysql_fetch_assoc($qrak));

	echo '</select>
	</p>


	<p>
	Call Number :
	<br>
	<input name="kode" type="text" value="'.$e_kode.'" size="10"  '.$x_enter2.'>
	</p>


	<p>
	Judul :
	<br>
	<input name="judul" type="text" value="'.$e_judul.'" size="50"  '.$x_enter2.'>
	</p>


	<p>
	Penulis/Pengarang :
	<br>
	<input name="pengarang" type="text" value="'.$e_pengarang.'" size="30"  '.$x_enter2.'>
	</p>


	<p>
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
	</p>


	<p>
	Kota Terbit :
	<br>
	<select name="kota">
	<option value="'.$e_kd_kota.'" selected>'.$e_kota.'</option>';

	//list
	$qbit = mysql_query("SELECT * FROM m_kota ".
				"WHERE kd <> '$e_kd_kota' ".
				"ORDER BY nama ASC");
	$rbit = mysql_fetch_assoc($qbit);

	do
		{
		//nilai
		$bit_kd = nosql($rbit['kd']);
		$bit_kode = nosql($rbit['kode']);
		$bit_nama = balikin($rbit['nama']);

		echo '<option value="'.$bit_kode.'">'.$bit_nama.'</option>';
		}
	while ($rbit = mysql_fetch_assoc($qbit));

	echo '</select>
	</p>


	<p>
	Tahun Terbit :
	<br>
	<input name="tahun_terbit" type="text" value="'.$e_tahun_terbit.'" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)"  '.$x_enter2.'>
	</p>


	<p>
	ISSN/ISBN :
	<br>
	<input name="issn_isbn" type="text" value="'.$e_issn_isbn.'" size="20" onKeyPress="return numbersonly(this, event)"  '.$x_enter2.'>
	</p>


	<p>
	Tebal :
	<br>
	<input name="tebal" type="text" value="'.$e_tebal.'" size="20" '.$x_enter2.'> Halaman.
	</p>


	<p>
	Panjang :
	<br>
	<input name="panjang" type="text" value="'.$e_panjang.'" size="20" '.$x_enter2.'> Halaman.
	</p>


	<p>
	Cetakan Ke-:
	<br>
	<input name="cetakan_ke" type="text" value="'.$e_cetakan_ke.'" size="5" maxlength="5" '.$x_enter2.'>
	</p>


	<p>
	Jilid :
	<br>
	<input name="jilid" type="text" value="'.$e_jilid.'" size="10" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>
	</p>


	<p>
	Edisi :
	<br>
	<input name="edisi" type="text" value="'.$e_edisi.'" size="10" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>
	</p>


	<p>
	Abstraksi :
	<br>
	<textarea name="abstraksi" cols="50" rows="5" wrap="virtual">'.$e_abstraksi.'</textarea>
	</p>


	<p>
	Tgl. Masuk :
	<br>
	<input name="e_masuk_tgl" type="text" value="'.$e_masuk_tgl.'" size="2">
	<input name="e_masuk_bln" type="text" value="'.$e_masuk_bln.'" size="2">
	<input name="e_masuk_thn" type="text" value="'.$e_masuk_thn.'" size="4">
	</p>


	<p>
	Status :
	<br>
	<select name="status">
	<option value="'.$e_status.'" selected>--'.$e_status_ket.'--</option>
	<option value="false">Belum Bisa Dipinjam</option>
	<option value="true">Bisa Dipinjam</option>
	</select>
	</p>



	<p>
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
				"ORDER BY tglentri DESC";
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
				"ORDER BY tglentri DESC";
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
				"ORDER BY tglentri DESC";
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

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, m_jenis.* ".
				"FROM perpus_item, m_jenis ".
				"WHERE perpus_item.kd_jenis = m_jenis.kode ".
				"AND m_jenis.nama LIKE '%$kunci%' ".
				"ORDER BY round(m_jenis.nama) ASC, ".
				"tglentri DESC";
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
				"ORDER BY round(perpus_penerbit.nama) ASC, ".
				"tglentri DESC";
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
				"WHERE perpus_item.pengarang LIKE '%$kunci%' ".
				"ORDER BY perpus_item.pengarang ASC, ".
				"tglentri DESC";
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

		$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
				"FROM perpus_item ".
				"WHERE perpus_item.rak LIKE '%$kunci%' ".
				"ORDER BY round(perpus_item.rak) ASC, ".
				"tglentri DESC";
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
				"WHERE isbn LIKE '%$kunci%' ".
				"ORDER BY round(isbn) ASC, ".
				"tglentri DESC";
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
				"ORDER BY tglentri DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}


	if ($count != 0)
		{
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



		echo 'Jumlah Item Boleh Dipinjam : <strong>'.$tcc2.'</strong>.
		Jumlah Item Belum Bisa Dipinjam : <strong>'.$tcc3.'</strong>.

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
			$i_kode = balikin($data['kode']);
			$i_barkode = nosql($data['barkode']);
			$i_judul = balikin2($data['judul']);
			$i_subyekjudul = balikin2($data['subyekjudul']);
			$i_abstraksi = balikin2($data['abstraksi']);
			$i_jnskd = nosql($data['kd_jenis']);
			$i_katkd = nosql($data['kd_kategori']);
			$i_penulis = balikin2($data['pengarang']);
			$i_jilid = balikin2($data['jilid']);
			$i_edisi = balikin2($data['edisi']);
			$i_kd_bahasa = nosql($data['kd_bahasa']);
			$i_bitkd = nosql($data['kd_penerbit']);
			$i_cetak_ke = nosql($data['cetakan']);
			$i_kd_perolehan = nosql($data['kd_perolehan']);
			$i_tebal = nosql($data['tebal']);
			$i_panjang = nosql($data['panjang']);
			$i_tahun_terbit = balikin2($data['thterbit']);
			$i_isbn = balikin2($data['isbn']);
			$i_kd_kota = balikin2($data['kd_kota']);
			$i_rak = balikin2($data['rak']);
			$i_tgl_entri = $data['tglentri'];
			$i_tgl_masuk = $data['tglmasuk'];

			$i_status = nosql($data['status']);
//			$i_img_cover = balikin2($data['img_cover']);



			//cek tgl
			if ((empty($i_tgl_masuk)) OR ($i_tgl_masuk == "0000-00-00 00:00:00"))
				{
				mysql_query("UPDATE perpus_item SET tglmasuk = '$i_tgl_entri' ".
						"WHERE kd = '$i_kd'");
				}




			//jenis
			$qjns = mysql_query("SELECT * FROM m_jenis ".
						"WHERE kode = '$i_jnskd'");
			$rjns = mysql_fetch_assoc($qjns);
			$i_jenis_kode = nosql($rjns['kode']);
			$i_jenis = balikin2($rjns['nama']);


			//kategori
			$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
						"WHERE kode = '$i_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$i_kat_kode = nosql($rkatx['kode']);
			$i_kat = balikin2($rkatx['kategori']);



			//kota
			$qkta = mysql_query("SELECT * FROM m_kota ".
						"WHERE kode = '$i_kd_kota'");
			$rkta = mysql_fetch_assoc($qkta);
			$i_kota_kode = nosql($rkta['kode']);
			$i_kota = balikin2($rkta['nama']);



			//perolehan
			$qoleh = mysql_query("SELECT * FROM m_perolehan ".
						"WHERE kode = '$i_kd_perolehan'");
			$roleh = mysql_fetch_assoc($qoleh);
			$i_perolehan_kode = nosql($roleh['kode']);
			$i_perolehan = balikin2($roleh['nama']);



			//bahasa
			$qbhs = mysql_query("SELECT * FROM m_bahasa ".
						"WHERE kode = '$i_kd_bahasa'");
			$rbhs = mysql_fetch_assoc($qbhs);
			$i_bhs_kode = nosql($rbhs['kode']);
			$i_bhs = balikin2($rbhs['nama']);



			//penerbit
			$qbitx = mysql_query("SELECT * FROM perpus_penerbit ".
						"WHERE kd = '$i_bitkd'");
			$rbitx = mysql_fetch_assoc($qbitx);
			$i_penerbit = balikin2($rbitx['nama']);


			//status
			if (($i_status == "false") OR (empty($i_status)))
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



			//jika barkode kosong
			if (empty($i_barkode))
				{
				$i_barkode = nosql($data['kd']);

				//update
				mysql_query("UPDATE perpus_item SET barkode = '$i_barkode' ".
						"WHERE kd = '$i_kd'");
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
			SubyekJudul :
			<strong><em>'.$i_subyekjudul.'</em></strong>
			<br>
			Abstraksi :
			<br>
			<strong><em>'.$i_abstraksi.'</em></strong>
			<br>
			<br>
			Call Number :
			<strong><em>'.$i_kode.'</em></strong>
			<br>
			Jenis :
			<strong><em>'.$i_jenis_kode.'. '.$i_jenis.'</em></strong>
			<br>
			Kategori :
			<strong><em>'.$i_kat_kode.'. '.$i_kat.'</em></strong>
			<br>
			Penulis/Pengarang :
			<strong><em>'.$i_penulis.'</em></strong>
			<br>
			Bahasa :
			<strong><em>'.$i_bhs.'</em></strong>
			<br>
			Penerbit :
			<strong><em>'.$i_penerbit.'</em></strong>
			<br>
			Kota Terbit :
			<strong><em>'.$i_kota.'</em></strong>
			<br>
			Tahun Terbit :
			<strong><em>'.$i_tahun_terbit.'</em></strong>
			<br>
			Cetakan ke-:
			<strong><em>'.$i_cetak_ke.'</em></strong>
			<br>
			Jilid :
			<strong><em>'.$i_jilid.'</em></strong>
			<br>
			Edisi :
			<strong><em>'.$i_edisi.'</em></strong>
			<br>
			Tebal :
			<strong><em>'.$i_tebal.' Halaman.</em></strong>
			<br>
			Panjang :
			<strong><em>'.$i_panjang.' Cm.</em></strong>
			<br>
			ISSN/ISBN :
			<strong><em>'.$i_isbn.'</em></strong>
			<br>
			<br>
			Berada di Rak :
			<strong><em>'.$i_rak.'</em></strong>
			<br>
			<br>

			Perolehan dari :
			<strong><em>'.$i_perolehan.'</em></strong>
			<br>
			<br>


			Tanggal Entri :
			<strong><em>'.$i_tgl_entri.'</em></strong>
			<br>

			Tanggal Masuk :
			<strong><em>'.$i_tgl_masuk.'</em></strong>
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
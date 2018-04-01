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
$filenya = "cd.php";
$judul = "Data CD";
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
else
	{
	$diload = "document.formx.perolehan.focus();";
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
	$rak = nosql($_POST['rak']);
	$kode = nosql($_POST['kode']);
	$barkode = nosql($_POST['barkode']);
	$judul = cegah2($_POST['judul']);
	$perolehan = nosql($_POST['perolehan']);
	$masuk_tgl = nosql($_POST['e_masuk_tgl']);
	$masuk_bln = nosql($_POST['e_masuk_bln']);
	$masuk_thn = nosql($_POST['e_masuk_thn']);
	$tgl_masuk = "$masuk_thn:$masuk_bln:$masuk_tgl";
	$status = nosql($_POST['status']);



	//jika baru
	if ($s == "baru")
		{
		///cek
		$qcc = mysql_query("SELECT * FROM perpus_item3 ".
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
			mysql_query("INSERT INTO perpus_item3(kd, barkode) VALUES ".
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
		$qcc = mysql_query("SELECT * FROM perpus_item3 ".
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
			mysql_query("UPDATE perpus_item3 SET kd_perolehan = '$perolehan', ".
					"rak = '$rak', ".
					"kode = '$kode', ".
					"barkode = '$barkode', ".
					"judul = '$judul', ".
					"tglmasuk = '$tgl_masuk', ".
					"tglentri = '$today', ".
					"status = '$status' ".
					"WHERE kd = '$kd'");


			//diskonek
			xfree($qbw);
			xclose($koneksi);
;
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
		$qcc = mysql_query("SELECT * FROM perpus_item3 ".
					"WHERE kd = '$kd'");
		$rcc = mysql_fetch_assoc($qcc);

		//hapus file
		$cc_filex = $rcc['img_cover'];
		$path1 = "../../filebox/perpus/$kd/$cc_filex";
		chmod($path1,0777);
		unlink ($path1);


		//del
		mysql_query("DELETE FROM perpus_item3 ".
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
				mysql_query("UPDATE perpus_item3 SET img_cover = '$filex_namex' ".
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
				$qcc = mysql_query("SELECT * FROM perpus_item3 ".
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
				mysql_query("UPDATE perpus_item3 SET img_cover = '$filex_namex' ".
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
require("../../inc/js/down_enter.js");
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
<option value="'.$filenya.'?crkd=cr07&crtipe=Tempat Rak">Tempat Rak</option>
<option value="'.$filenya.'?crkd=cr09&crtipe=Perolehan">Perolehan</option>
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
				"perpus_item3.* ".
				"FROM perpus_item3 ".
				"WHERE kd = '$kd'");
	$rowx = mysql_fetch_assoc($qx);
	$e_rakkd = balikin($rowx['rak']);
	$e_kd_perolehan = nosql($rowx['kd_perolehan']);
	$e_kode = balikin($rowx['kode']);
	$e_barkode = nosql($rowx['barkode']);
	$e_judul = balikin2($rowx['judul']);
	$e_rak = balikin2($rowx['rak']);
	$e_masuk_tgl = nosql($rowx['masuk_tgl']);
	$e_masuk_bln = nosql($rowx['masuk_bln']);
	$e_masuk_thn = nosql($rowx['masuk_thn']);
	$e_status = nosql($rowx['status']);
	$e_img_cover = balikin2($rowx['img_cover']);





	//perolehan
	$qoleh = mysql_query("SELECT * FROM perpus_m_perolehan ".
				"WHERE kode = '$e_kd_perolehan'");
	$roleh = mysql_fetch_assoc($qoleh);
	$e_perolehan_kode = nosql($roleh['kode']);
	$e_perolehan = balikin2($roleh['nama']);




	//status
	if ($e_status == "false")
		{
		$e_status_ket = "Belum Bisa Dipinjam";
		}
	else if ($e_status == "true")
		{
		$e_status_ket = "Bisa Dipinjam";
		}






	//jika baru
	if ($s == "baru")
		{
		//ciptakan barcode baru, dari nilai tertinggi + 1
		//query
		$qku = mysql_query("SELECT MAX(barkode) AS kodeku ".
					"FROM perpus_item3 ".
					"WHERE left(barkode,1) = '3'");
		$rku = mysql_fetch_assoc($qku);
		$ku_max = nosql($rku['kodeku']);
		$e_barkode = $ku_max + 1;
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
	<select name="perolehan" '.$x_enter.'>
	<option value="'.$e_kd_perolehan.'" selected>'.$e_perolehan.'</option>';

	//list
	$qkat = mysql_query("SELECT * FROM perpus_m_perolehan ".
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
	Call Number :
	<br>
	<input name="kode" type="text" value="'.$e_kode.'" size="10"  '.$x_enter.'>
	</p>


	<p>
	Judul :
	<br>
	<input name="judul" type="text" value="'.$e_judul.'" size="50"  '.$x_enter.'>
	</p>



	<p>
	Tempat Rak :
	<br>
	<select name="rak" '.$x_enter.'>
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
	Tgl. Masuk :
	<br>
	<input name="e_masuk_tgl" type="text" value="'.$e_masuk_tgl.'" size="2" '.$x_enter.'>
	<input name="e_masuk_bln" type="text" value="'.$e_masuk_bln.'" size="2" '.$x_enter.'>
	<input name="e_masuk_thn" type="text" value="'.$e_masuk_thn.'" size="4" '.$x_enter.'>
	</p>


	<p>
	Status :
	<br>
	<select name="status" '.$x_enter2.'>
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

		$sqlcount = "SELECT perpus_item3.*, perpus_item3.kd AS pitkd ".
				"FROM perpus_item3 ".
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

		$sqlcount = "SELECT perpus_item3.*, perpus_item3.kd AS pitkd ".
				"FROM perpus_item3 ".
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

		$sqlcount = "SELECT perpus_item3.*, perpus_item3.kd AS pitkd ".
				"FROM perpus_item3 ".
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


	//tempat rak
	else if ($crkd == "cr07")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item3.*, perpus_item3.kd AS pitkd ".
				"FROM perpus_item3 ".
				"WHERE perpus_item3.rak LIKE '%$kunci%' ".
				"ORDER BY round(perpus_item3.rak) ASC, ".
				"tglentri DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}




	//perolehan
	else if ($crkd == "cr09")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT perpus_item3.*, perpus_item3.kd AS pitkd ".
				"FROM perpus_item3, perpus_m_perolehan ".
				"WHERE perpus_item3.kd_perolehan = perpus_m_perolehan.kode ".
				"AND perpus_m_perolehan.nama LIKE '%$kunci%' ".
				"ORDER BY tglentri DESC";
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

		$sqlcount = "SELECT perpus_item3.*, perpus_item3.kd AS pitkd ".
				"FROM perpus_item3 ".
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
		$qcc2 = mysql_query("SELECT perpus_item3.kd ".
					"FROM perpus_item3 ".
					"WHERE status = 'true'");
		$rcc2 = mysql_fetch_assoc($qcc2);
		$tcc2 = mysql_num_rows($qcc2);



		//ketahui, jumlah item yang belum boleh dipinjam
		$qcc3 = mysql_query("SELECT perpus_item3.kd ".
					"FROM perpus_item3 ".
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
			$i_kd_perolehan = nosql($data['kd_perolehan']);
			$i_rak = balikin2($data['rak']);
			$i_tgl_entri = $data['tglentri'];
			$i_tgl_masuk = $data['tglmasuk'];

			$i_status = nosql($data['status']);



			//cek tgl
			if ((empty($i_tgl_masuk)) OR ($i_tgl_masuk == "0000-00-00 00:00:00"))
				{
				mysql_query("UPDATE perpus_item3 SET tglmasuk = '$i_tgl_entri' ".
						"WHERE kd = '$i_kd'");
				}




			//perolehan
			$qoleh = mysql_query("SELECT * FROM perpus_m_perolehan ".
						"WHERE kode = '$i_kd_perolehan'");
			$roleh = mysql_fetch_assoc($qoleh);
			$i_perolehan_kode = nosql($roleh['kode']);
			$i_perolehan = balikin2($roleh['nama']);



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
				mysql_query("UPDATE perpus_item3 SET barkode = '$i_barkode' ".
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
			Call Number :
			<strong><em>'.$i_kode.'</em></strong>
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
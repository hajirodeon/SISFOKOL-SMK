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
$filenya = "buku_klasifikasi.php";
$judul = "Data Buku per Klasifikasi";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kode = nosql($_REQUEST['kode']);
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
	$kode = nosql($_POST['kode']);
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
		$ke = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
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
xheadline($judul);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" bgcolor="'.$warna02.'" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
echo "<select name=\"klasifikasi\" onChange=\"MM_jumpMenu('self',this,0)\">";

$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
			"WHERE kode = '$kode'");
$rkatx = mysql_fetch_assoc($qkatx);
$katx_nama = balikin2($rkatx['kategori']);

echo '<option value="'.$kode.'" selected>'.$kode.'.'.$katx_nama.'</option>';

//list
$qkat = mysql_query("SELECT * FROM perpus_kategori ".
			"WHERE kode <> '297' ".
			"AND kode <> '813' ".
			"ORDER BY kode ASC");
$rkat = mysql_fetch_assoc($qkat);

do
	{
	//nilai
	$kat_kd = nosql($rkat['kd']);
	$kat_jenis_kode = nosql($rkat['kode']);
	$kat_jenis = balikin($rkat['kategori']);

	echo '<option value="'.$filenya.'?kode='.$kat_jenis_kode.'">'.$kat_jenis_kode.'. '.$kat_jenis.'</option>';
	}
while ($rkat = mysql_fetch_assoc($qkat));

echo '</select>';

echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$crkd.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr01&crtipe=BarCode">BarCode</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr02&crtipe=Kode">Kode</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr03&crtipe=Judul">Judul</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr04&crtipe=Kategori">Kategori</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr05&crtipe=Penerbit">Penerbit</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr06&crtipe=Penulis">Penulis</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr07&crtipe=Tempat Rak">Tempat Rak</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr08&crtipe=ISSN/ISBN">ISSN/ISBN</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr09&crtipe=Perolehan">Perolehan</option>
<option value="'.$filenya.'?kode='.$kode.'&crkd=cr10&crtipe=Klasifikasi">Klasifikasi</option>
</select>
<input name="kode" type="hidden" value="'.$kode.'">
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

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item ".
			"WHERE barkode LIKE '%$kunci%'".
			"AND kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//kode
else if ($crkd == "cr02")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item ".
			"WHERE kode LIKE '%$kunci%' ".
			"AND kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//judul
else if ($crkd == "cr03")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item ".
			"WHERE judul LIKE '%$kunci%' ".
			"AND kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//jenis
else if ($crkd == "cr04")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_m_jenis.* ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item, perpus_m_jenis ".
			"WHERE perpus_item.kd_jenis = perpus_m_jenis.kode ".
			"AND perpus_m_jenis.nama LIKE '%$kunci%' ".
			"AND perpus_item.kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//penerbit
else if ($crkd == "cr05")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_penerbit.* ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item, perpus_penerbit ".
			"WHERE perpus_item.kd_penerbit = perpus_penerbit.kd ".
			"AND perpus_penerbit.nama LIKE '%$kunci%' ".
			"AND perpus_item.kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//penulis
else if ($crkd == "cr06")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item ".
			"WHERE perpus_item.pengarang LIKE '%$kunci%' ".
			"AND perpus_item.kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//tempat rak
else if ($crkd == "cr07")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item ".
			"WHERE perpus_item.rak LIKE '%$kunci%' ".
			"AND perpus_item.kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//issn/isbn
else if ($crkd == "cr08")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item ".
			"WHERE isbn LIKE '%$kunci%' ".
			"AND perpus_item.kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}


//perolehan
else if ($crkd == "cr09")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item, perpus_m_perolehan ".
			"WHERE perpus_item.kd_perolehan = perpus_m_perolehan.kode ".
			"AND perpus_m_perolehan.nama LIKE '%$kunci%' ".
			"AND perpus_item.kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//klasifikasi
else if ($crkd == "cr10")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item, perpus_kategori ".
			"WHERE perpus_item.kd_kategori = perpus_kategori.kode ".
			"AND perpus_kategori.kategori LIKE '%$kunci%' ".
			"AND perpus_item.kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}
else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

//	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
	$sqlcount = "SELECT DISTINCT(perpus_item.judul) AS pitkd ".
			"FROM perpus_item ".
			"WHERE kd_kategori = '$kode' ".
			"AND (perpus_item.kode NOT LIKE '%c.%' ".
			"OR perpus_item.kode LIKE '%c.1%') ".
			"ORDER BY perpus_item.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kode=$kode&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}


if ($count != 0)
	{
	//ketahui, jumlah item yang boleh dipinjam
	$qcc2 = mysql_query("SELECT perpus_item.kd ".
				"FROM perpus_item ".
				"WHERE status = 'true' ".
				"AND kd_kategori = '$kode'");
	$rcc2 = mysql_fetch_assoc($qcc2);
	$tcc2 = mysql_num_rows($qcc2);


	//ketahui, jumlah judul
	$qcc21 = mysql_query("SELECT DISTINCT(judul) ".
				"FROM perpus_item ".
				"WHERE kd_kategori = '$kode' ".
				"AND (kode NOT LIKE '%c.%' ".
				"OR kode LIKE '%c.1%')");
	$rcc21 = mysql_fetch_assoc($qcc21);
	$tcc21 = mysql_num_rows($qcc21);


	//ketahui, jumlah item yang belum boleh dipinjam
	$qcc3 = mysql_query("SELECT perpus_item.kd ".
				"FROM perpus_item ".
				"WHERE status = 'false' ".
				"AND kd_kategori = '$kode'");
	$rcc3 = mysql_fetch_assoc($qcc3);
	$tcc3 = mysql_num_rows($qcc3);



	//ketahui, jumlah barang
	$qcc31 = mysql_query("SELECT kd FROM perpus_item ".
				"WHERE kd_kategori = '$kode'");
	$rcc31 = mysql_fetch_assoc($qcc31);
	$tcc31 = mysql_num_rows($qcc31);



	echo 'Jumlah Item Boleh Dipinjam : <strong>'.$tcc2.'</strong>.
	Jumlah Item Belum Bisa Dipinjam : <strong>'.$tcc3.'</strong>.
	Jumlah Judul : <strong>'.$tcc21.'</strong>.
	Jumlah Buku : <strong>'.$tcc31.'</strong>.
	<table width="980" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="10"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td width="200"><strong><font color="'.$warnatext.'">Judul Buku</font></strong></td>
	<td width="200"><strong><font color="'.$warnatext.'">Penulis/Pengarang</font></strong></td>
	<td width="200"><strong><font color="'.$warnatext.'">Penerbut</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Tahun Terbit</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Jml. Eksemplar</font></strong></td>
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
		$i_judul = balikin2($data['pitkd']);
		$i_judul2 = cegah($data['pitkd']);

		//nomer urut
$nomerx = ($nomer + (($page - 1) * $limit));



		//detail e
		$qku = mysql_query("SELECT * FROM perpus_item ".
					"WHERE judul = '$i_kd' ".
					"ORDER BY tglentri DESC");
		$rku = mysql_fetch_assoc($qku);

		$i_kode = balikin($rku['kode']);
		$i_barkode = nosql($rku['barkode']);
		$i_subyekjudul = balikin2($rku['subyekjudul']);
		$i_abstraksi = balikin2($rku['abstraksi']);
		$i_jnskd = nosql($rku['kd_jenis']);
		$i_katkd = nosql($rku['kd_kategori']);
		$i_penulis = balikin2($rku['pengarang']);
		$i_jilid = balikin2($rku['jilid']);
		$i_edisi = balikin2($rku['edisi']);
		$i_kd_bahasa = nosql($rku['kd_bahasa']);
		$i_bitkd = nosql($rku['kd_penerbit']);
		$i_cetak_ke = nosql($rku['cetakan']);
		$i_kd_perolehan = nosql($rku['kd_perolehan']);
		$i_tebal = nosql($rku['tebal']);
		$i_panjang = nosql($rku['panjang']);
		$i_tahun_terbit = balikin2($rku['thterbit']);
		$i_isbn = balikin2($rku['isbn']);
		$i_kd_kota = balikin2($rku['kd_kota']);
		$i_rak = balikin2($rku['rak']);
		$i_tgl_entri = $rku['tglentri'];
		$i_tgl_masuk = $rku['tglmasuk'];

		$i_status = nosql($rku['status']);





		//jenis
		$qjns = mysql_query("SELECT * FROM perpus_m_jenis ".
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
		$qkta = mysql_query("SELECT * FROM perpus_m_kota ".
					"WHERE kode = '$i_kd_kota'");
		$rkta = mysql_fetch_assoc($qkta);
		$i_kota_kode = nosql($rkta['kode']);
		$i_kota = balikin2($rkta['nama']);



		//perolehan
		$qoleh = mysql_query("SELECT * FROM perpus_m_perolehan ".
					"WHERE kode = '$i_kd_perolehan'");
		$roleh = mysql_fetch_assoc($qoleh);
		$i_perolehan_kode = nosql($roleh['kode']);
		$i_perolehan = balikin2($roleh['nama']);



		//bahasa
		$qbhs = mysql_query("SELECT * FROM perpus_m_bahasa ".
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





		//ketahui, jumlah barang
		$qcc31 = mysql_query("SELECT kd FROM perpus_item ".
					"WHERE kd_kategori = '$kode' ".
//					"AND judul = '$i_judul2'  ".
					"AND judul = '$i_kd'  ".
					"AND (kode NOT LIKE '%c.%' ".
					"OR kode LIKE '%c.1%')");
		$rcc31 = mysql_fetch_assoc($qcc31);
		$tcc31 = mysql_num_rows($qcc31);


		//jika nol, jadikan satu
		if (empty($tcc31))
			{
			$tcc31 = "1";
			}


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$nomerx.'</td>
		<td>
		<font color="red">
		<strong>'.$i_judul.'</strong>
		</font>
		</td>
		<td>
		'.$i_penulis.'
		</td>
		<td>
		'.$i_penerbit.'
		</td>
		<td>
		'.$i_tahun_terbit.'
		</td>
		<td>
		'.$tcc31.'
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>
	<table width="980" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input name="jml" type="hidden" value="'.$count.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.
	</td>
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

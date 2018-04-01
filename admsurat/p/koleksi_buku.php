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
require("../../inc/cek/admsurat.php");
require("../../inc/class/paging.php");
require("../../inc/class/thumbnail_images.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "koleksi_buku.php";
$judul = "Koleksi Buku";
$judulku = "[$surat_session : $nip11_session. $nm11_session] ==> $judul";
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();

//menu
require("../../inc/menu/admsurat.php");

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
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" bgcolor="'.$warna02.'" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
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

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_m_jenis.* ".
			"FROM perpus_item, perpus_m_jenis ".
			"WHERE perpus_item.kd_jenis = perpus_m_jenis.kode ".
			"AND perpus_m_jenis.nama LIKE '%$kunci%' ".
			"ORDER BY round(perpus_m_jenis.nama) ASC, ".
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


//perolehan
else if ($crkd == "cr09")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
			"FROM perpus_item, perpus_m_perolehan ".
			"WHERE perpus_item.kd_perolehan = perpus_m_perolehan.kode ".
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
	<td width="75"><strong><font color="'.$warnatext.'">Cover</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Keterangan</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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



		//cek tgl
		if ((empty($i_tgl_masuk)) OR ($i_tgl_masuk == "0000-00-00 00:00:00"))
			{
			mysql_query("UPDATE perpus_item SET tglmasuk = '$i_tgl_entri' ".
					"WHERE kd = '$i_kd'");
			}




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



		//jika barkode kosong
		if (empty($i_barkode))
			{
			$i_barkode = nosql($data['kd']);

			//update
			mysql_query("UPDATE perpus_item SET barkode = '$i_barkode' ".
					"WHERE kd = '$i_kd'");
			}




		//cek status
		$qku = mysql_query("SELECT * FROM perpus_pinjam ".
					"WHERE kd_item = '$i_kd' ".
					"AND iskembali = '0'");
		$rku = mysql_fetch_assoc($qku);
		$tku = mysql_num_rows($qku);
		$ku_tgl_kembali = $rku['tgl_kembali'];

		//jika ada
		if (!empty($tku))
			{
			$i_statusku = "<strong>Sedang Dipinjam</strong>. <br>
					Perkiraan Tanggal Kembali : $ku_tgl_kembali";
			$warna = "yellow";
			}
		else
			{
			$i_statusku = "Ada. Silahkan Dipinjam";
			}


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_foto.'</td>
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
		</td>
		<td>'.$i_statusku.'</td>
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
	<strong>TIDAK ADA DATA.</strong>
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
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
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "buku_print_katalog.php";
$judul = "Data Buku : Print Kartu Katalog";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$limit = "3";
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}










//jika reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}






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
xheadline($judul);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx2">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
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
<option value="'.$filenya.'?crkd=cr10&crtipe=Klasifikasi">Klasifikasi</option>
</select>
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="btnCARI" type="submit" value="CARI">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>
</form>';

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


//klasifikasi
else if ($crkd == "cr10")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
			"FROM perpus_item, perpus_kategori ".
			"WHERE perpus_item.kd_kategori = perpus_kategori.kode ".
			"AND perpus_kategori.kategori LIKE '%$kunci%' ".
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
	echo '<form action="buku_print_katalog_prt.php" method="post" name="formx">
	<table width="980" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">Label</font></strong></td>
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


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
		</td>
		<td>';



		//pengambilan kata terakhir, dari seorang penulis
		// memecah pesan berdasarkan karakter null
		$pecah = explode(" ", $i_penulis);
		$j_1 = $pecah[0];
		$j_2 = $pecah[1];
		$j_3 = $pecah[2];
		$j_4 = $pecah[3];
		$j_5 = $pecah[4];
		$j_6 = $pecah[5];




		//jika satu kata
		if (empty($j_2))
			{
			$kataku = $j_1;
			$kataku2 = $j_1;
			}



		//jika dua kata
		else if (empty($j_3))
			{
			$kataku = $j_2;
			$kataku2 = $j_1;
			}


		//jika tiga kata
		else if (empty($j_4))
			{
			$kataku = $j_3;
			$kataku2 = "$j_1 $j_2";
			}


		//jika empat kata
		else if (empty($j_5))
			{
			$kataku = $j_4;
			$kataku2 = "$j_1 $j_2 $j_3";
			}


		//jika lima kata
		else if (empty($j_6))
			{
			$kataku = $j_5;
			$kataku2 = "$j_1 $j_2 $j_3 $j_4";
			}








		echo '<table border="0">
		<tr valign="top">
		<td width="200" align="left">
		'.$i_kode.'
		<br>
		'.substr($kataku,0,3).'
		<br>
		'.strtolower(substr($i_judul,0,1)).'
		</td>
		<td width="400" align="left">

		<table>
		<tr>
		<td>
		'.strtoupper($kataku).', '.$kataku2.'
		<br>
		<table>
		<tr>
		<td width="30">
		</td>
		<td>
		'.$i_judul.'
		</td>
		</tr>
		</table>
		<table>
		<tr>
		<td width="15">
		</td>
		<td>
		'.$i_penulis.'. --Ed.'.$i_edisi.', --'.$i_kota.':
		</td>
		</tr>
		</table>

		<table>
		<tr>
		<td width="15">
		</td>
		<td>
		'.$i_penerbit.', '.$i_tahun_terbit.'.
		</td>
		</tr>
		</table>

		<table>
		<tr>
		<td width="30">
		</td>
		<td>
		'.$i_tebal.'hlm;'.$i_panjang.'cm.
		</td>
		</tr>
		</table>

		</td>
		</tr>
		</table>


		</td>
		</tr>
		</table>


		<table border="0">
		<tr valign="top">
		<td width="130" align="left">
		</td>
		<td width="400" align="left">


		<table>
		<tr valign="top">
		<td width="100" align="left">
		Bibliograf
		</td>
		<td>
		:
		</td>
		</tr>
		<tr valign="top">
		<td width="100" align="left">
		ISBN
		</td>
		<td>
		: '.$i_isbn.'
		</td>
		</tr>
		</table>

		<table width="300">
		<tr valign="top">
		<td width="200" align="left">
		1. '.strtoupper($i_judul).'
		</td>
		<td align="right">
		i.Judul
		</td>
		</tr>
		</table>


		</td>
		</tr>
		</table>
		</td>

		<td>
		<big>
		<font color="red">
		<strong>'.$i_judul.'</strong>
		</font>
		</big>
		<br>
		Barkode :
		<strong><em>'.$i_barkode.'</em></strong>
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
		[...<a href="buku.php?s=edit&kd='.$i_kd.'" title="'.$i_judul.'">SELENGKAPNYA</a>].
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
	<input name="btnPRT" type="submit" value="PRINT">
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

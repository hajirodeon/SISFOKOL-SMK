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
$filenya = "print_label.php";
$judul = "Print Label Buku";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$limit = "60";
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
			"ORDER BY postdate DESC";
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
			"ORDER BY postdate DESC";
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
			"ORDER BY postdate DESC";
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
			"AND perpus_kategori.kategori LIKE '%$kunci%' ".
			"ORDER BY postdate DESC";
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
			"ORDER BY postdate DESC";
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
			"ORDER BY postdate DESC";
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
			"ORDER BY postdate DESC";
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
			"ORDER BY postdate DESC";
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
			"ORDER BY postdate DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}


if ($count != 0)
	{
	echo '<form action="print_label_prt.php" method="post" name="formx">
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
		$i_tmp_terbit = balikin2($data['tmp_terbit']);
		$i_kopi_ke = nosql($data['kopi_ke']);

		$i_tahun_terbit = balikin2($data['tahun_terbit']);
		$i_issn_isbn = balikin2($data['issn_isbn']);
		$i_status = nosql($data['status']);
		$i_rangkuman = balikin2($data['rangkuman']);
		$i_img_cover = balikin2($data['img_cover']);
		$i_tgl_masuk = $data['tgl_masuk'];
		$i_postdate = $data['postdate'];



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


		//status
		if ($i_status == "false")
			{
			$i_status_ket = "<font color=\"brown\">Belum Bisa Dipinjam</font>";
			}
		else if ($i_status == "true")
			{
			$i_status_ket = "<font color=\"blue\">Boleh Dipinjam</font>";
			}
		else if ($i_status == "1")
			{
			$i_status_ket = "<font color=\"red\">Item Referensi</font>";
			$i_statusku = "R";
			}
		else if ($i_status == "2")
			{
			$i_status_ket = "<font color=\"green\">Buku Paket</font>";
			}
		else
			{
			$i_status_ket = "<font color=\"orange\">Status Item Tidak Jelas</font>";
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
		<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
		</td>
		<td>

		<table border="1">
		<tr>
		<td width="200" align="center">';



//pengambilan kata terakhir, dari seorang penulis
// memecah pesan berdasarkan karakter null
$pecah = explode(" ", $i_penulis1);
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
	}



//jika dua kata
else if (empty($j_3))
	{
	$kataku = $j_2;
	}


//jika tiga kata
else if (empty($j_4))
	{
	$kataku = $j_3;
	}


//jika empat kata
else if (empty($j_5))
	{
	$kataku = $j_4;
	}


//jika lima kata
else if (empty($j_6))
	{
	$kataku = $j_5;
	}








		echo '<font size="1">
<b>
PERPUSTAKAAN
<BR>
'.strtoupper($sek_nama).'
</b>
<BR>
'.$i_kode.'
<br>
'.substr($kataku,0,3).'
<br>
'.strtolower(substr($i_judul,0,1)).'
<br>
c.'.$i_kopi_ke.' '.$i_statusku.'';


		echo '</font>
		</td>
		</tr>
		</table>

		<td>
		<big>
		<font color="red">
		<strong>'.$i_judul.'</strong>
		</font>
		</big>
		<br>
		Tanggal Masuk :
		<strong>'.$i_tgl_masuk.'</strong>.
		[Tanggal Entri : '.$i_postdate.'].

		<br>
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
		Tempat Terbit :
		<strong><em>'.$i_tmp_terbit.'</em></strong>
		<br>
		Tahun Terbit :
		<strong><em>'.$i_tahun_terbit.'</em></strong>
		<br>
		ISSN/ISBN :
		<strong><em>'.$i_issn_isbn.'</em></strong>
		<br>
		Status :
		<strong><em>'.$i_status_ket.'</em></strong>
		<br>
		<br>
		<em>'.$i_rangkuman.'</em>
		<br>
		<br>

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
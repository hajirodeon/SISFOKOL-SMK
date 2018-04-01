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
$filenya = "cd_print_barcode.php";
$judul = "Data CD : Print BarCode";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$limit = "36";
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



//print barcode
if ($_POST['btnPRT'])
	{
	//ambil class barcode
	require('../../inc/class/ean13.php');

	$pdf=new PDF_EAN13();
	$pdf->AddPage();


	//jumlah datanya, dalam satu halaman
	$jml_baris = "9";
	$jml_kolom = "4";


	for ($i=1;$i<=$jml_baris;$i++)
		{
		for ($k=1;$k<=$jml_kolom;$k++)
			{
			//urutan
			$ongko = $ongko + 1;

			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$ongko";
			$kdx = nosql($_POST["$yuhu"]);


			//jika gak null
			if (!empty($kdx))
				{
				//query
				$qx = mysql_query("SELECT * FROM perpus_item3 ".
							"WHERE kd = '$kdx'");
				$rowx = mysql_fetch_assoc($qx);
				$e_barkode = nosql($rowx['barkode']);


				$pdf->EAN13(40*$k,30*$i,$e_barkode);
				}
			}
		}


	$pdf->Output();
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







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
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
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



//barcode
if ($crkd == "cr01")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item3.*, perpus_item3.kd AS pitkd ".
			"FROM perpus_item3 ".
			"WHERE barkode LIKE '%$kunci%' ".
			"AND perpus_item3.status = 'true' ".
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
			"AND perpus_item3.status = 'true' ".
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
			"AND perpus_item3.status = 'true' ".
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
			"AND perpus_item3.status = 'true' ".
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
			"AND perpus_item3.status = 'true' ".
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
			"WHERE perpus_item3.status = 'true' ".
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
	echo '<table width="980" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="75"><strong><font color="'.$warnatext.'">BarCode</font></strong></td>
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
		<td align="center">
		'.$i_barkode.'
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
		Tanggal Entri :
		<strong><em>'.$i_tgl_entri.'</em></strong>
		<br>

		Tanggal Masuk :
		<strong><em>'.$i_tgl_masuk.'</em></strong>
		<br>
		<br>
		[...<a href="cd.php?s=edit&kd='.$i_kd.'" title="'.$i_judul.'">SELENGKAPNYA</a>].
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
	<input name="btnPRT" type="submit" value="PRINT PDF">
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
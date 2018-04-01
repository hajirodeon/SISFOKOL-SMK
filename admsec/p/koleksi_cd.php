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
require("../../inc/cek/admsec.php");
require("../../inc/class/paging.php");
require("../../inc/class/thumbnail_images.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "koleksi_cd.php";
$judul = "Koleksi CD";
$judulku = "[$security_session : $nip30_session. $nm30_session] ==> $judul";
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
require("../../inc/menu/admsec.php");

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
	<strong>TIDAK ADA DATA. </strong>
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
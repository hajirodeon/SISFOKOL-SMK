<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL JANISSARI                          ///////
/////// (customization)                             ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh :                               ///////
/////// Agus Muhajir, S.Kom                         ///////
/////// URL     :                                   ///////
///////     *http://sisfokol.wordpress.com          ///////
//////      *http://hajirodeon.wordpress.com        ///////
/////// E-Mail  :                                   ///////
///////     * hajirodeon@yahoo.com                  ///////
///////     * hajirodeon@gmail.com                  ///////
/////// HP/SMS  : 081-829-88-54                     ///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////



session_start();

//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/class/paging2.php");
require("../../../inc/class/pagingx.php");
$tpl = LoadTpl("../../../template/janissari.html");


nocache;

//nilai
$filenya = "album.php";
$judul = "Album Foto";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$alkd = nosql($_REQUEST['alkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus...
$diload = "document.formx.y_judul.focus();";


//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}


//nek edit
if ($s == "edit")
	{
	//nilai
	$alkd = nosql($_REQUEST['alkd']);

	//query
	$qnil = mysql_query("SELECT * FROM user_blog_album ".
							"WHERE kd_user = '$kd1_session' ".
							"AND kd = '$alkd'");
	$rnil = mysql_fetch_assoc($qnil);
	$y_judul = balikin($rnil['judul']);
	}



//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$page = nosql($_POST['page']);

	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM user_blog_album ".
					"WHERE kd_user = '$kd1_session' ".
					"ORDER BY judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del data
		mysql_query("DELETE FROM user_blog_album ".
						"WHERE kd_user = '$kd1_session' ".
						"AND kd = '$kd'");

		//query
		$qcc = mysql_query("SELECT * FROM user_blog_album_filebox ".
								"WHERE kd_album = '$kd'");
		$rcc = mysql_fetch_assoc($qcc);

		do
			{
			//hapus file
			$cc_filex = $rcc['filex'];
			$path1 = "../../../filebox/album/$kd/$cc_filex";
			chmod($path1,0777);
			unlink ($path1);
			}
		while ($rcc = mysql_fetch_assoc($qcc));

		//hapus query
		mysql_query("DELETE FROM user_blog_album_filebox ".
						"WHERE kd_album = '$kd'");

		//nek $kd gak null
		if (!empty($kd))
			{
			//hapus folder
			$path2 = "../../../filebox/album/$kd";
			$path2 = "../../filebox/excel";
			chmod($path2,0777);
			delete ($path2);
			}

		}
	while ($data = mysql_fetch_assoc($result));

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}


//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$alkd = nosql($_POST['alkd']);
	$y_judul = cegah($_POST['y_judul']);


	//nek null
	if (empty($y_judul))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM user_blog_album ".
									"WHERE kd_user = '$kd1_session' ".
									"AND judul = '$y_judul'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek lebih dari 1
			if ($tcc > 1)
				{
				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Ditemukan Duplikasi Judul Album Foto. Silahkan Diganti...!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//update
				mysql_query("UPDATE user_blog_album SET judul = '$y_judul', ".
								"postdate = '$today' ".
								"WHERE kd_user = '$kd1_session' ".
								"AND kd = '$alkd'");

				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}





		//nek baru
		if (empty($s))
			{
			//cek
			$qcc = mysql_query("SELECT * FROM user_blog_album ".
									"WHERE kd_user = '$kd1_session' ".
									"AND judul = '$y_judul'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Album Foto Sudah Ada. Silahkan Diganti...!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//bikin folder album
				//nilai
				$path1 = "../../../filebox/album/$x";
				$path2 = "../../../filebox/album";
				chmod($path1,0777);
				chmod($path2,0777);


				//cek, sudah ada belum
				if (!file_exists($path1))
					{
					mkdir("$path1", $chmod);
					}


				//insert data
				mysql_query("INSERT INTO user_blog_album(kd, kd_user, judul, postdate) VALUES ".
								"('$x', '$kd1_session', '$y_judul', '$today')");

				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();


//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/js/checkall.js");
require("../../../inc/menu/janissari.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="100%" height="300" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FDF0DE" valign="top">
<td>';
//judul
xheadline($judul);

echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<input name="y_judul" type="text" value="'.$y_judul.'" size="30" '.$x_enter.'>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</td>
</tr>
</table>
<br>';

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM user_blog_album ".
				"WHERE kd_user = '$kd1_session' ".
				"ORDER BY judul ASC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//nek ada
if ($count != 0)
	{
	echo '<table width="600" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td valign="top"><strong>Judul Album</strong></td>
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

		$kd = nosql($data['kd']);
		$y_judul = balikin($data['judul']);

		//jumlah foto tiap album
		$qjfo = mysql_query("SELECT * FROM user_blog_album_filebox ".
								"WHERE kd_album = '$kd'");
		$rjfo = mysql_fetch_assoc($qjfo);
		$tjfo = mysql_num_rows($qjfo);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td width="1">
		<input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
		<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
		</td>
		<td width="1">
		<a href="'.$filenya.'?s=edit&alkd='.$kd.'" title="Edit : '.$y_judul.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
		</td>
		<td width="1">
		<a href="album_detail.php?alkd='.$kd.'" title="Lihat Album : '.$y_judul.'"><img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
		</td>
		<td valign="top">
		'.$y_judul.' [<font color="red"><strong>'.$tjfo.'</strong></font> Foto].
		</td>
		</tr>';
  		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>
	<table width="600" border="0" cellspacing="0" cellpadding="3">
    	<tr>
	<td width="250">
	<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="alkd" type="hidden" value="'.$alkd.'">
	</td>
	<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
    	</tr>
	</table>';
	}
else
	{
	echo '<font color="red"><strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong></font>';
	}


echo '</td>
<td width="1%">
</td>

<td width="1%">';

//ambil sisi
require("../../../inc/menu/k_sisi.php");

echo '<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
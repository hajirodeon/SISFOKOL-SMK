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
$filenya = "peminjam_rangking.php";
$judul = "Rekap Rangking Peminjam";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



/*
//kumpulkan data dulu
$qku = mysql_query("SELECT DISTINCT(kd_user) AS itemkd ".
			"FROM perpus_pinjam ".
			"ORDER BY tgl_pinjam DESC");
$rku = mysql_fetch_assoc($qku);

do
	{
	$nomer = $nomer + 1;
	$xyz = md5("$nomer$x");
	$ku_itemkd = nosql($rku['itemkd']);

	//cek
	$qcc = mysql_query("SELECT * FROM perpus_peminjam_rangking ".
				"WHERE kd_user = '$ku_itemkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//jika ada
	if ($tcc != 0)
		{
		//cuekin aja...
		}
	else
		{
		//insert
		mysql_query("INSERT INTO perpus_peminjam_rangking(kd, kd_user) VALUES ".
				"('$xyz', '$ku_itemkd')");
		}
	}
while ($rku = mysql_fetch_assoc($qku));
*/




/*
//berikan nilainya
$qku = mysql_query("SELECT * FROM perpus_peminjam_rangking ".
			"ORDER BY kd_user ASC");
$rku = mysql_fetch_assoc($qku);

do
	{
	$nomer = $nomer + 1;
	$xyz = md5("$nomer$x");
	$ku_itemkd = nosql($rku['kd_user']);

	//jumlahnya
	$qcc = mysql_query("SELECT * FROM perpus_pinjam ".
				"WHERE kd_user = '$ku_itemkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);


	//update
	mysql_query("UPDATE perpus_peminjam_rangking SET jml = '$tcc' ".
			"WHERE kd_user = '$ku_itemkd'");
	}
while ($rku = mysql_fetch_assoc($qku));
*/







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
require("../../inc/js/swap.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//daftar item sedang dipinjam
$p = new Pager();
$start = $p->findStart($limit);


$sqlcount = "SELECT * FROM perpus_peminjam_rangking ".
		"ORDER BY round(jml) DESC";
$sqlresult = $sqlcount;


$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//jika ada
if ($count != 0)
	{
	echo '<table width="500" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama </font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Jumlah Dipinjam</font></strong></td>
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


		//urutkan nomor rangking
		//nilai
		$nox = round($nox + 1);

		//page awal
		if ((empty($page)) OR ($page == "1"))
			{
			$nox2 = $nox;
			}
		else
			{
			$nox2 = round((($limit * $page) + $nox) - $limit);
			}


		$d_itemkd = nosql($data['kd_user']);
		$d_jml = nosql($data['jml']);


		//detail
		$qdt = mysql_query("SELECT * FROM m_user ".
					"WHERE nomor = '$d_itemkd'");
		$rdt = mysql_fetch_assoc($qdt);
		$dt_no = nosql($rdt['nomor']);
		$dt_nama = balikin2($rdt['nama']);





		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$nox2.'.</td>
		<td>['.$dt_no.']. '.$dt_nama.'</td>
		<td align="right"><strong>'.$d_jml.'</strong> kali.</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</tr>
	</table>

	<table width="500" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
	</tr>
	</table>';
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>Tidak Ada Item Yang Dipinjam. . .</strong>
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
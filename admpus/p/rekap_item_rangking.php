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
$filenya = "rekap_item_rangking.php";
$judul = "Rekap Rangking Item";
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
$qku = mysql_query("SELECT DISTINCT(kd_item) AS itemkd ".
			"FROM perpus_pinjam ".
			"ORDER BY tgl_pinjam DESC");
$rku = mysql_fetch_assoc($qku);

do
	{
	$nomer = $nomer + 1;
	$xyz = md5("$nomer$x");
	$ku_itemkd = nosql($rku['itemkd']);

	//cek
	$qcc = mysql_query("SELECT * FROM perpus_item_rangking ".
				"WHERE kd_item = '$ku_itemkd'");
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
		mysql_query("INSERT INTO perpus_item_rangking(kd, kd_item) VALUES ".
				"('$xyz', '$ku_itemkd')");
		}
	}
while ($rku = mysql_fetch_assoc($qku));
*/




/*
//berikan nilainya
$qku = mysql_query("SELECT * FROM perpus_item_rangking ".
			"ORDER BY kd_item ASC");
$rku = mysql_fetch_assoc($qku);

do
	{
	$nomer = $nomer + 1;
	$xyz = md5("$nomer$x");
	$ku_itemkd = nosql($rku['kd_item']);

	//jumlahnya
	$qcc = mysql_query("SELECT * FROM perpus_pinjam ".
				"WHERE kd_item = '$ku_itemkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);


	//update
	mysql_query("UPDATE perpus_item_rangking SET jml = '$tcc' ".
			"WHERE kd_item = '$ku_itemkd'");
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


$sqlcount = "SELECT * FROM perpus_item_rangking ".
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
	<td><strong><font color="'.$warnatext.'">Nama Item</font></strong></td>
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


		$d_itemkd = nosql($data['kd_item']);
		$d_jml = nosql($data['jml']);


/*
		//detail item
		$qdt = mysql_query("SELECT * FROM perpus_item ".
					"WHERE kd = '$d_itemkd'");
		$rdt = mysql_fetch_assoc($qdt);
		$dt_kode = nosql($rdt['kode']);
		$dt_judul = balikin2($rdt['judul']);
*/


		//brg item
		$qtemx = mysql_query("SELECT * FROM perpus_item ".
					"WHERE kd = '$d_itemkd'");
		$rtemx = mysql_fetch_assoc($qtemx);
		$ttemx = mysql_num_rows($qtemx);

		//brg item
		$qtemx2 = mysql_query("SELECT * FROM perpus_item2 ".
					"WHERE kd = '$d_itemkd'");
		$rtemx2 = mysql_fetch_assoc($qtemx2);
		$ttemx2 = mysql_num_rows($qtemx2);

		//brg item
		$qtemx3 = mysql_query("SELECT * FROM perpus_item3 ".
					"WHERE kd = '$d_itemkd'");
		$rtemx3 = mysql_fetch_assoc($qtemx3);
		$ttemx3 = mysql_num_rows($qtemx3);

		//brg item
		$qtemx4 = mysql_query("SELECT * FROM perpus_item4 ".
					"WHERE kd = '$d_itemkd'");
		$rtemx4 = mysql_fetch_assoc($qtemx4);
		$ttemx4 = mysql_num_rows($qtemx4);

		//jika ada
		if ($ttemx != 0)
			{
			$temx_kode = balikin2($rtemx['kode']);
			$temx_barkode = nosql($rtemx['barkode']);
			$temx_nama = balikin2($rtemx['judul']);
			$temx_pustaka = "Buku";
			$temx_pustakakd = "1";
			}
		else if ($ttemx2 != 0)
			{
			$temx_kode = balikin2($rtemx2['kode']);
			$temx_barkode = nosql($rtemx2['barkode']);
			$temx_nama = balikin2($rtemx2['topik']);
			$temx_pustaka = "Majalah";
			$temx_pustakakd = "2";
			}
		else if ($ttemx3 != 0)
			{
			$temx_kode = balikin2($rtemx3['kode']);
			$temx_barkode = nosql($rtemx3['barkode']);
			$temx_nama = balikin2($rtemx3['judul']);
			$temx_pustaka = "CD";
			$temx_pustakakd = "3";
			}
		else if ($ttemx4 != 0)
			{
			$temx_kode = balikin2($rtemx4['kode']);
			$temx_barkode = nosql($rtemx4['barkode']);
			$temx_nama = balikin2($rtemx4['judul']);
			$temx_pustaka = "Referensi";
			$temx_pustakakd = "4";
			}




		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$nox2.'.</td>
		<td>['.$temx_pustaka.']. ['.$temx_kode.']. '.$temx_nama.'</td>
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
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
$filenya = "item_sedang.php";
$judul = "Rekap Sedang Dipinjam";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
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
require("../../inc/js/swap.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//daftar item sedang dipinjam
$p = new Pager();
$start = $p->findStart($limit);

/*
$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
		"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
		"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
		"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
		"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
		"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
		"perpus_pinjam.*, perpus_item.* ".
		"FROM perpus_pinjam, perpus_item ".
		"WHERE perpus_pinjam.kd_item = perpus_item.kd ".
		"AND perpus_pinjam.status = 'true' ".
		"ORDER BY round(perpus_item.kode) ASC";
$sqlresult = $sqlcount;
*/

$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
		"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
		"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
		"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
		"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
		"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
		"perpus_pinjam.* ".
		"FROM perpus_pinjam ".
		"WHERE perpus_pinjam.iskembali = '1' ".
		"ORDER BY tgl_kembali2 DESC";
$sqlresult = $sqlcount;


$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//jika ada
if ($count != 0)
	{
	echo '<table width="900" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td><strong><font color="'.$warnatext.'">Nama Item</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Peminjam</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">Tgl. Kembali</font></strong></td>
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


		//nilai
		$nox = $nox + 1;
		$d_itemkd = nosql($data['kd_item']);
		$d_userkd = nosql($data['kd_user']);
		$d_p_tgl = nosql($data['p_tgl']);
		$d_p_bln = nosql($data['p_bln']);
		$d_p_thn = nosql($data['p_thn']);
		$d_k_tgl = nosql($data['k_tgl']);
		$d_k_bln = nosql($data['k_bln']);
		$d_k_thn = nosql($data['k_thn']);




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




		//user...
		$qsuk = mysql_query("SELECT * FROM m_user ".
					"WHERE nomor = '$d_userkd'");
		$rsuk = mysql_fetch_assoc($qsuk);
		$tsuk = mysql_num_rows($qsuk);
		$suk_nip = nosql($rsuk['nomor']);
		$suk_nama = balikin2($rsuk['nama']);
		$suk_status = balikin2($rsuk['status']);
		$suk_detail = "[$suk_status]. $suk_nip. $suk_nama";


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>['.$temx_pustaka.']. ['.$temx_kode.']. '.$temx_nama.'</td>
		<td>'.$suk_detail.'</td>
		<td>'.$d_p_tgl.' '.$arrbln1[$d_p_bln].' '.$d_p_thn.'</td>
		<td>'.$d_k_tgl.' '.$arrbln1[$d_k_bln].' '.$d_k_thn.'</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</tr>
	</table>

	<table width="900" border="0" cellspacing="0" cellpadding="3">
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
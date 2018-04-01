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
$filenya = "pinjam_item_sedang.php";
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
	<td width="50"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
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
		$d_jml = nosql($data['jml']);
		$d_kode = nosql($data['kode']);
		$d_judul = balikin2($data['judul']);



		//user...
		$qsuk = mysql_query("SELECT * FROM m_user ".
					"WHERE kd = '$d_userkd'");
		$rsuk = mysql_fetch_assoc($qsuk);
		$tsuk = mysql_num_rows($qsuk);
		$suk_nip = nosql($rsuk['nomor']);
		$suk_nama = balikin2($rsuk['nama']);
		$suk_status = balikin2($rsuk['status']);
		$suk_detail = "[$suk_status]. $suk_nip. $suk_nama";


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$d_kode.'. '.$d_judul.'</td>
		<td>'.$d_jml.'</td>
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
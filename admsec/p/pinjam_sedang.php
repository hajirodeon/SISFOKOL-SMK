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
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pinjam_sedang.php";
$judul = "Sedang Pinjam";
$judulku = "[$security_session : $nip30_session. $nm30_session] ==> $judul";
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
require("../../inc/menu/admsec.php");

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
		"DATE_FORMAT(perpus_pinjam.tgl_kembali2, '%d') AS k_tgl2, ".
		"DATE_FORMAT(perpus_pinjam.tgl_kembali2, '%m') AS k_bln2, ".
		"DATE_FORMAT(perpus_pinjam.tgl_kembali2, '%Y') AS k_thn2, ".
		"perpus_pinjam.* ".
		"FROM perpus_pinjam ".
		"WHERE perpus_pinjam.iskembali = '0' ".
		"AND perpus_pinjam.kd_user = '$nip30_session' ".
		"ORDER BY tgl_pinjam DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//jika ada
if ($count != 0)
	{
	echo '<table width="800" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Pustaka</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">Tgl. Seharusnya Kembali</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pengembalian</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Terlambat</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Denda</font></strong></td>
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
		$d_p_tgl = nosql($data['p_tgl']);
		$d_p_bln = nosql($data['p_bln']);
		$d_p_thn = nosql($data['p_thn']);
		$d_k_tgl = nosql($data['k_tgl']);
		$d_k_bln = nosql($data['k_bln']);
		$d_k_thn = nosql($data['k_thn']);
		$buk_ktgl2 = nosql($data['k_tgl2']);
		$buk_kbln2 = nosql($data['k_bln2']);
		$buk_kthn2 = nosql($data['k_thn2']);



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


		$buk_jml_telat = nosql($data['jml_hari_telat']);
		$buk_denda = nosql($data['denda']);


		//jika ada telat
		if (!empty($buk_jml_telat))
			{
			$buk_jml_telat2 = "$buk_jml_telat Hari";
			$warna = "red";
			}
		else
			{
			$buk_jml_telat2 = "-";
			}


		//jika gak null
		if (!empty($buk_denda))
			{
			$buk_denda2 = "Rp. $buk_denda";
			}
		else
			{
			$buk_dend2 = $buk_denda;
			}




		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$d_p_tgl.' '.$arrbln1[$d_p_bln].' '.$d_p_thn.'</td>
		<td>'.$temx_kode.'. <strong>'.$temx_nama.'</strong></td>
		<td>'.$temx_pustaka.'</td>
		<td>'.$buk_ktgl2.' '.$arrbln1[$buk_kbln2].' '.$buk_kthn2.'</td>
		<td>'.$d_k_tgl.' '.$arrbln1[$d_k_bln].' '.$d_k_thn.'</td>
		<td>'.$buk_jml_telat2.'</td>
		<td>'.$buk_denda2.'</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</tr>
	</table>

	<table width="800" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
	</tr>
	</table>';
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>Tidak Ada Item Yang Sedang Dipinjam. . .</strong>
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
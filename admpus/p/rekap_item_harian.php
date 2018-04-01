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
$filenya = "rekap_item_harian.php";
$judul = "Rekap Item Kembali Hari ini";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$itemkd = nosql($_REQUEST['itemkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus
$diload = "document.formx.barkode.focus();";





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika detail
if ($_POST['btnDTI'])
	{
	//nilai
	$item_kd = nosql($_POST['item_kd']);
	$barkode = nosql($_POST['barkode']);



	//cek
	if (empty($barkode))
		{
		//re-direct
		$pesan = "Silahkan Tentukan Dahulu Item Barangnya...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//ketahui itemnya
		$qcc = mysql_query("SELECT kd FROM perpus_item ".
					"WHERE barkode = '$barkode'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_kd = nosql($rcc['kd']);


		//re-direct
		$ke = "$filenya?itemkd=$cc_kd";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>';

$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT DISTINCT(perpus_pinjam.tgl_kembali2) AS tglku ".
		"FROM perpus_pinjam, perpus_item ".
		"WHERE perpus_pinjam.kd_item = perpus_item.kd ".
		"AND perpus_pinjam.tgl_kembali2 <> '0000-00-00' ".
		"AND perpus_pinjam.iskembali = '1' ".
		"ORDER BY perpus_pinjam.tgl_kembali2 DESC";
$sqlresult = $sqlcount;


$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//jika ada
if ($count != 0)
	{
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
		$tglku = $data['tglku'];


		echo '<strong>'.$tglku.'</strong>';


/*
		//datanya
		$qdt = mysql_query("SELECT perpus_pinjam.*, perpus_item.*, perpus_item.kd AS itemkd ".
					"FROM perpus_pinjam, perpus_item ".
					"WHERE perpus_pinjam.kd_item = perpus_item.kd ".
					"AND perpus_pinjam.tgl_kembali2 = '$tglku' ".
					"ORDER BY perpus_item.kode ASC");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);
*/

		//datanya
		$qdt = mysql_query("SELECT * FROM perpus_pinjam ".
					"WHERE perpus_pinjam.tgl_kembali2 = '$tglku'");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);


		echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">Pustaka</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td width="350"><strong><font color="'.$warnatext.'">Judul</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Peminjam</font></strong></td>
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

			$nox = $nox + 1;

			//nilainya
			$dt_itemkd = nosql($rdt['kd_item']);
			$dt_userkd = nosql($rdt['kd_user']);



			//brg item
			$qtemx = mysql_query("SELECT * FROM perpus_item ".
						"WHERE kd = '$dt_itemkd'");
			$rtemx = mysql_fetch_assoc($qtemx);
			$ttemx = mysql_num_rows($qtemx);

			//brg item
			$qtemx2 = mysql_query("SELECT * FROM perpus_item2 ".
						"WHERE kd = '$dt_itemkd'");
			$rtemx2 = mysql_fetch_assoc($qtemx2);
			$ttemx2 = mysql_num_rows($qtemx2);

			//brg item
			$qtemx3 = mysql_query("SELECT * FROM perpus_item3 ".
						"WHERE kd = '$dt_itemkd'");
			$rtemx3 = mysql_fetch_assoc($qtemx3);
			$ttemx3 = mysql_num_rows($qtemx3);

			//brg item
			$qtemx4 = mysql_query("SELECT * FROM perpus_item4 ".
						"WHERE kd = '$dt_itemkd'");
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






			//peminjam
			$qdt2 = mysql_query("SELECT * FROM m_user ".
						"WHERE nomor = '$dt_userkd'");
			$rdt2 = mysql_fetch_assoc($qdt2);
			$tdt2 = mysql_num_rows($qdt2);
			$dt2_noinduk = balikin($rdt2['nomor']);
			$dt2_nama = balikin($rdt2['nama']);
			$dt_peminjam = "$dt2_noinduk. $dt2_nama";



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$temx_pustaka.'</td>
			<td>'.$temx_kode.'</td>
			<td>'.$temx_nama.'</td>
			<td>'.$dt_peminjam.'</td>
			</tr>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));



		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
		</tr>
		</table>';
		}
	while ($data = mysql_fetch_assoc($result));
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>BELUM ADA DATA PENGEMBALIAN.</strong>
	</font>
	</p>';
	}




echo '</p>
</form>';
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
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
$filenya = "item.php";
$judul = "Rekap per Item";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$pustaka = nosql($_REQUEST['pustaka']);
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
		//cek input
		$qcr = mysql_query("SELECT kd, kode FROM perpus_item ".
					"WHERE barkode = '$barkode' ".
					"OR kd = '$barkode'");
		$rcr = mysql_fetch_assoc($qcr);
		$tcr = mysql_num_rows($qcr);

		//cek input
		$qcr2 = mysql_query("SELECT kd, kode FROM perpus_item2 ".
					"WHERE barkode = '$barkode' ".
					"OR kd = '$barkode'");
		$rcr2 = mysql_fetch_assoc($qcr2);
		$tcr2 = mysql_num_rows($qcr2);

		//cek input
		$qcr3 = mysql_query("SELECT kd, kode FROM perpus_item3 ".
					"WHERE barkode = '$barkode' ".
					"OR kd = '$barkode'");
		$rcr3 = mysql_fetch_assoc($qcr3);
		$tcr3 = mysql_num_rows($qcr3);

		//cek input
		$qcr4 = mysql_query("SELECT kd, kode FROM perpus_item4 ".
					"WHERE barkode = '$barkode' ".
					"OR kd = '$barkode'");
		$rcr4 = mysql_fetch_assoc($qcr4);
		$tcr4 = mysql_num_rows($qcr4);

		//jika ada
		if ($tcr != 0)
			{
			$kodex = nosql($rcr['kode']);
			$brgkd = nosql($rcr['kd']);
			$pustaka_kode = "1";
			$ceku = "$tcr";
			}
		else if ($tcr2 != 0)
			{
			$kodex = nosql($rcr2['kode']);
			$brgkd = nosql($rcr2['kd']);
			$pustaka_kode = "2";
			$ceku = "$tcr2";
			}
		else if ($tcr3 != 0)
			{
			$kodex = nosql($rcr3['kode']);
			$brgkd = nosql($rcr3['kd']);
			$pustaka_kode = "3";
			$ceku = "$tcr3";
			}
		else if ($tcr4 != 0)
			{
			$kodex = nosql($rcr4['kode']);
			$brgkd = nosql($rcr4['kd']);
			$pustaka_kode = "4";
			$ceku = "$tcr4";
			}


		//re-direct
		$ke = "$filenya?pustaka=$pustaka_kode&itemkd=$brgkd";
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
echo '<form action="'.$filenya.'" method="post" name="formx">';

//jika pustaka 1
if ($pustaka == "1")
	{
	$tblku = "perpus_item";
	}
else if ($pustaka == "2")
	{
	$tblku = "perpus_item2";
	}
else if ($pustaka == "3")
	{
	$tblku = "perpus_item3";
	}
else if ($pustaka == "4")
	{
	$tblku = "perpus_item4";
	}
else
	{
	$tblku = "perpus_item";
	}
	

//terpilih
$qedt = mysql_query("SELECT * FROM $tblku ".
						"WHERE kd = '$itemkd'");
$redt = mysql_fetch_assoc($qedt);
$edt_kd = nosql($redt['kd']);
$edt_nama = balikin2($redt['judul']);
$edt_kode = balikin2($redt['kode']);
$edt_barkode = nosql($redt['barkode']);


echo '<p>
Item Barkode :
<input name="barkode" type="text" value="'.$edt_barkode.'" size="20">
<input name="item_kd" type="hidden" value="'.$edt_kd.'">
<input name="btnDTI" type="submit" value="DETAIL >>">
</p>';


//detail item
if (!empty($itemkd))
	{
	echo '<p>
	Kode Item : <strong>'.$edt_kode.'</strong>
	Judul Item : <strong>'.$edt_nama.'</strong>
	</p>';


	//cek
	$qcc = mysql_query("SELECT * FROM perpus_item ".
				"WHERE kd = '$itemkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//ada...?
	if ($tcc != 0)
		{
		//daftar perminjam
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
				"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
				"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
				"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
				"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
				"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
				"perpus_pinjam.* ".
				"FROM perpus_pinjam ".
				"WHERE kd_item = '$itemkd' ".
				"ORDER BY tgl_pinjam DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?itemkd=$itemkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);


		//jika ada
		if ($count != 0)
			{
			echo '<table width="900" border="1" cellspacing="0" cellpadding="3">
			<tr bgcolor="'.$warnaheader.'">
			<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
			<td width="150"><strong><font color="'.$warnatext.'">Tgl. Kembali</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Peminjam</font></strong></td>
			<td width="200"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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
				$d_userkd = nosql($data['kd_user']);
				$d_p_tgl = nosql($data['p_tgl']);
				$d_p_bln = nosql($data['p_bln']);
				$d_p_thn = nosql($data['p_thn']);
				$d_k_tgl = nosql($data['k_tgl']);
				$d_k_bln = nosql($data['k_bln']);
				$d_k_thn = nosql($data['k_thn']);
				$d_jml = nosql($data['jml']);
				$d_status = nosql($data['status']);
				$d_iskembali = nosql($data['iskembali']);


				//user
				$qsuk = mysql_query("SELECT * FROM m_user ".
										"WHERE nomor = '$d_userkd'");
				$rsuk = mysql_fetch_assoc($qsuk);
				$tsuk = mysql_num_rows($qsuk);
				$suk_nip = nosql($rsuk['nomor']);
				$suk_nama = balikin2($rsuk['nama']);
				$suk_status = balikin2($rsuk['status']);
				$suk_posisi = balikin2($rsuk['posisi']);
				$suk_detail = "$suk_nip. $suk_nama <br> [$suk_status]. [$suk_posisi].";




				//status
				if ($d_iskembali == "0")
					{
					$d_status_ket = "<font color=\"orange\"><strong>Sedang Pinjam...</strong></font>";
					$warna = "yellow";
					}
				else
					{
					$d_status_ket = "<font color=\"red\"><strong>Pernah Pinjam.</strong></font>";
					}


				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$d_p_tgl.' '.$arrbln1[$d_p_bln].' '.$d_p_thn.'</td>
				<td>'.$d_k_tgl.' '.$arrbln1[$d_k_bln].' '.$d_k_thn.'</td>
				<td>'.$suk_detail.'</td>
				<td>'.$d_status_ket.'</td>
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
			<strong>Tidak Ada Peminjam Item Ini. . .</strong>
			</font>
			</p>';
			}
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>Item Tersebut Tidak Ada. Harap Diperhatikan...!!</strong>
		</font>
		</p>';
		}
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>Tentukan Dahulu Item Barangnya. . .</strong>
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

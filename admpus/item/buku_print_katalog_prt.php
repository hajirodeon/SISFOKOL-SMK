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
$tpl = LoadTpl("../../template/print2.html");

nocache;

//nilai
$filenya = "buku_print_katalog.php";
$judul = "Print Kartu Katalog";
$judulku = $judul;
$judulx = $judul;
$limit = "3";



//isi *START
ob_start();




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//print
if ($_POST['btnPRT'])
	{
	for ($k=1;$k<=$limit;$k++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$k";
		$kdx = nosql($_POST["$yuhu"]);


		//jika gak null
		if (!empty($kdx))
			{
			//query
			$qx = mysql_query("SELECT * FROM perpus_item ".
						"WHERE kd = '$kdx'");
			$rowx = mysql_fetch_assoc($qx);
			$e_barkode = nosql($rowx['barkode']);
			$i_kode = balikin2($rowx['kode']);
			$i_judul = balikin2($rowx['judul']);
			$e_katkd = nosql($rowx['kd_kategori']);
			$i_penulis1 = balikin2($rowx['pengarang']);
			$i_isbn = balikin2($rowx['isbn']);
			$i_edisi = balikin2($rowx['edisi']);
			$i_kd_kota = balikin2($rowx['kd_kota']);
			$i_bitkd = nosql($rowx['kd_penerbit']);
			$i_tahun_terbit = balikin2($rowx['thterbit']);
			$i_tebal = nosql($rowx['tebal']);
			$i_panjang = nosql($rowx['panjang']);


			//jenis
			$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
						"WHERE kd = '$e_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$i_jenis_kode = nosql($rkatx['kode']);
			$i_jenis = balikin2($rkatx['kategori']);


		//kota
		$qkta = mysql_query("SELECT * FROM perpus_m_kota ".
					"WHERE kode = '$i_kd_kota'");
		$rkta = mysql_fetch_assoc($qkta);
		$i_kota_kode = nosql($rkta['kode']);
		$i_kota = balikin2($rkta['nama']);



		//penerbit
		$qbitx = mysql_query("SELECT * FROM perpus_penerbit ".
					"WHERE kd = '$i_bitkd'");
		$rbitx = mysql_fetch_assoc($qbitx);
		$i_penerbit = balikin2($rbitx['nama']);



			//pengambilan kata terakhir, dari seorang penulis
			// memecah pesan berdasarkan karakter null
			$pecah = explode(" ", $i_penulis1);
			$j_1 = $pecah[0];
			$j_2 = $pecah[1];
			$j_3 = $pecah[2];
			$j_4 = $pecah[3];
			$j_5 = $pecah[4];
			$j_6 = $pecah[5];




			//jika satu kata
			if (empty($j_2))
				{
				$kataku = $j_1;
				$kataku2 = $j_1;
				}



			//jika dua kata
			else if (empty($j_3))
				{
				$kataku = $j_2;
				$kataku2 = $j_1;
				}


			//jika tiga kata
			else if (empty($j_4))
				{
				$kataku = $j_3;
				$kataku2 = "$j_1 $j_2";
				}


			//jika empat kata
			else if (empty($j_5))
				{
				$kataku = $j_4;
				$kataku2 = "$j_1 $j_2 $j_3";
				}


			//jika lima kata
			else if (empty($j_6))
				{
				$kataku = $j_5;
				$kataku2 = "$j_1 $j_2 $j_3 $j_4";
				}





			echo '<table border="1">
			<tr valign="top">
			<td align="left" height="320" width="550">

			<table border="0">
			<tr valign="top">
			<td width="200" align="left">
			'.$i_kode.'
			<br>
			'.substr($kataku,0,3).'
			<br>
			'.strtolower(substr($i_judul,0,1)).'
			</td>
			<td width="400" align="left">

			<table>
			<tr>
			<td>
			'.strtoupper($kataku).', '.$kataku2.'
			<br>
			<table>
			<tr>
			<td width="30">
			</td>
			<td>
			'.$i_judul.'
			</td>
			</tr>
			</table>
			<table>
			<tr>
			<td width="15">
			</td>
			<td>
			'.$i_penulis1.'. --Ed.'.$i_edisi.', --'.$i_kota.':
			</td>
			</tr>
			</table>

			<table>
			<tr>
			<td width="15">
			</td>
			<td>
			'.$i_penerbit.', '.$i_tahun_terbit.'.
			</td>
			</tr>
			</table>

			<table>
			<tr>
			<td width="30">
			</td>
			<td>
			'.$i_tebal.'hlm;'.$i_panjang.'cm.
			</td>
			</tr>
			</table>

			</td>
			</tr>
			</table>


			</td>
			</tr>
			</table>


			<table border="0">
			<tr valign="top">
			<td width="130" align="left">
			</td>
			<td width="400" align="left">


			<table>
			<tr valign="top">
			<td width="100" align="left">
			Bibliograf
			</td>
			<td>
			:
			</td>
			</tr>
			<tr valign="top">
			<td width="100" align="left">
			ISBN
			</td>
			<td>
			: '.$i_isbn.'
			</td>
			</tr>
			</table>

			<table width="300">
			<tr valign="top">
			<td width="200" align="left">
			1. '.strtoupper($i_judul).'
			</td>
			<td align="right">
			i.Judul
			</td>
			</tr>
			</table>


			</td>
			</tr>
			</table>


			</td>
			</tr>
			</table>';
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$diload = "window.print();location.href='$filenya'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>

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
$filenya = "buku_print_label.php";
$judul = "Print Label Buku";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$limit = "21";



//isi *START
ob_start();




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//print barcode
if ($_POST['btnPRT'])
	{
	//setting banyaknya kolom
	$kolom = 3;

	// membuat tabel berisi label barcode
	echo "<table border='5' cellspacing='10' cellpadding='10'>";
	$counter = 1;

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


			//jenis
			$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
						"WHERE kd = '$e_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$i_jenis_kode = nosql($rkatx['kode']);
			$i_jenis = balikin2($rkatx['kategori']);




			if (($counter-1) % $kolom == 0) echo "<tr>";
			echo "<td width='350' align='center' style='padding: 5px'>";



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
			}



		//jika dua kata
		else if (empty($j_3))
			{
			$kataku = $j_2;
			}


		//jika tiga kata
		else if (empty($j_4))
			{
			$kataku = $j_3;
			}


		//jika empat kata
		else if (empty($j_5))
			{
			$kataku = $j_4;
			}


		//jika lima kata
		else if (empty($j_6))
			{
			$kataku = $j_5;
			}




		echo '<font size="2">
		<b>
		PERPUSTAKAAN
		<BR>
		'.strtoupper($sek_nama).'
		</b>

		<br>
		<br>
		<table>
		<tr>
		<td>
		<b>
		<font size="2" font-family="Arial Narrow">
		&nbsp;&nbsp; &nbsp;&nbsp;
		'.$i_kode.'
		<br>
		&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
		'.substr($kataku,0,3).'
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
		'.strtolower(substr($i_judul,0,1)).'
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
		c.'.$i_kopi_ke.' '.$i_statusku.'
		</font>
		</b>
		</td>
		<td>
		</td>
		</tr>
		</table>';


		echo "</font></td>";



			if ($counter % $kolom == 0) echo "</tr>";
			$counter++;
			}
		}

	echo "</table>";
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
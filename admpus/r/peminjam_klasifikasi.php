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
$filenya = "peminjam_klasifikasi.php";
$judul = "Laporan Peminjam Menurut Klasifikasi";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);

//ketahui tapel
if ($bulan >= "07")
	{
	$tapel1 = $tahun;
	$tapel2 = $tahun + 1;
	}
else if ($bulan <= "06")
	{
	$tapel1 = $tahun - 1;
	$tapel2 = $tahun;
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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//terpilih
$qedt = mysql_query("SELECT * FROM perpus_kategori ".
			"ORDER BY kode ASC");
$redt = mysql_fetch_assoc($qedt);


echo '<p>
<table border="1" width="990" cellspacing="0" cellpadding="3">
<TR align="center" bgcolor="'.$warnaheader.'">
	<TD ROWSPAN=2>
		<strong>GOLONGAN</strong>
	</TD>
	<TD COLSPAN=12>
		<strong>BULAN</strong>
	</TD>
</TR>
<TR align="center" bgcolor="'.$warnaheader.'">';


for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;
		}

	if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;
		}



	echo '<TD rowspan="1" width="50">
		<strong>'.$arrbln2[$ibln].'</strong>
	</TD>';
	}

echo '</TR>';





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
	$d_kode = nosql($redt['kode']);
	$d_kategori = balikin($redt['kategori']);




	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$d_kode.'. '.$d_kategori.'</td>';

	//looping bulan
	for ($i=1;$i<=12;$i++)
		{
		//nilainya
		if ($i<=6) //bulan juli sampai desember
			{
			$ibln = $i + 6;
			$ithn = $tapel1;
			}

		if ($i>6) //bulan januari sampai juni
			{
			$ibln = $i - 6;
			$ithn = $tapel2;
			}


		//jumlah buku
		$qku = mysql_query("SELECT perpus_item.kd ".
					"FROM perpus_item, perpus_pinjam ".
					"WHERE perpus_pinjam.kd_item = perpus_item.kd ".
					"AND perpus_item.kd_kategori = '$d_kode' ".
					"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$ibln' ".
					"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$ithn'");
		$rku = mysql_fetch_assoc($qku);
		$tku = mysql_num_rows($qku);


		//jika null
		if (empty($tku))
			{
			$tkux = "-";
			}
		else
			{
			$tkux = $tku;
			}




		echo '<TD align="center">'.$tkux.'</TD>';
		}

	echo '</tr>';
	}
while ($redt = mysql_fetch_assoc($qedt));

echo '</tr>
<tr>
<td>Majalah</td>';

//looping bulan
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;
		$ithn = $tapel1;
		}

	if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;
		$ithn = $tapel2;
		}


	//jumlah majalah
	$qku = mysql_query("SELECT perpus_item2.kd ".
				"FROM perpus_item2, perpus_pinjam ".
				"WHERE perpus_pinjam.kd_item = perpus_item2.kd ".
				"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$ibln' ".
				"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$ithn'");
	$rku = mysql_fetch_assoc($qku);
	$tku = mysql_num_rows($qku);


	//jika null
	if (empty($tku))
		{
		$tkux = "-";
		}
	else
		{
		$tkux = $tku;
		}




	echo '<TD align="center">'.$tkux.'</TD>';
	}

echo '</tr>
<tr>
<td>Jumlah Peminjam</td>';

//looping bulan
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;
		$ithn = $tapel1;
		}

	if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;
		$ithn = $tapel2;
		}


	//jumlah peminjam
	$qku = mysql_query("SELECT kd_user ".
				"FROM perpus_pinjam ".
				"WHERE round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$ibln' ".
				"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$ithn'");
	$rku = mysql_fetch_assoc($qku);
	$tku = mysql_num_rows($qku);


	//jika null
	if (empty($tku))
		{
		$tkux = "-";
		}
	else
		{
		$tkux = $tku;
		}




	echo '<TD align="center">'.$tkux.'</TD>';
	}

echo '</tr>
<tr>
<td>Jumlah Pengunjung</td>';

//looping bulan
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;
		$ithn = $tapel1;
		}

	if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;
		$ithn = $tapel2;
		}


	//jumlah
	$qku = mysql_query("SELECT kd_user ".
						"FROM perpus_absensi ".
						"WHERE round(DATE_FORMAT(tgl, '%m')) = '$ibln' ".
						"AND round(DATE_FORMAT(tgl, '%Y')) = '$ithn'");
	$rku = mysql_fetch_assoc($qku);
	$tku = mysql_num_rows($qku);


	//jika null
	if (empty($tku))
		{
		$tkux = "-";
		}
	else
		{
		$tkux = $tku;
		}




	echo '<TD align="center">'.$tkux.'</TD>';
	}

echo '</tr>
</table>
</p>
<br>
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
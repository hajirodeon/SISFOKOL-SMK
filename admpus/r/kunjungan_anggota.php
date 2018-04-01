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
$filenya = "kunjungan_anggota.php";
$s = nosql($_REQUEST['s']);
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$judul = "Laporan Kunjungan Anggota per Bulan : $arrbln[$xbln1] $xthn1";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;









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

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warna02.'">
<td>
Bulan : ';
echo "<select name=\"xbln1\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$xbln1.'" selected>'.$arrbln[$xbln1].'</option>';

for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$filenya.'?xbln1='.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>';

echo "<select name=\"xthn1\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$xthn1.'" selected>'.$xthn1.'</option>';

for ($i=$pinjam01;$i<=$pinjam02;$i++)
	{
	echo '<option value="'.$filenya.'?xbln1='.$xbln1.'&xthn1='.$i.'">'.$i.'</option>';
	}

echo '</select>
</td>
</tr>
</table>
<br>';


//nek masih do null
if (empty($xbln1))
	{
	echo "<p>
	<font color='red'>
	<strong>Bulan Belum Dipilih...!!</strong>
	</font>
	</p>";
	}
else if (empty($xthn1))
	{
	echo "<p>
	<font color='red'>
	<strong>Tahun Belum Dipilih...!!</strong>
	</font>
	</p>";
	}
else
	{
	echo '<table border="1" width="250" cellspacing="0" cellpadding="3">
	<TR align="center" bgcolor="'.$warnaheader.'">
		<TD width="50">
			<strong>TGL</strong>
		</TD>
		<TD>
			<strong>JUMLAH</strong>
		</TD>
	</TR>';

	for ($k=1;$k<=31;$k++)
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
//			$nox = $nox + 1;
		$d_tglku = $redt['tglku'];



		$qedt = mysql_query("SELECT DISTINCT(tgl) AS tglku ".
					"FROM perpus_absensi ".
					"WHERE round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
					"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1' ".
					"ORDER BY tgl ASC");
		$redt = mysql_fetch_assoc($qedt);


		//jumlahnya
		$qedt2 = mysql_query("SELECT tgl FROM perpus_absensi ".
					"WHERE round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
					"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1' ".
					"AND round(DATE_FORMAT(tgl, '%d')) = '$k'");
		$redt2 = mysql_fetch_assoc($qedt2);
		$tedt2 = mysql_num_rows($qedt2);



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$k.'</td>';
		echo '<td>'.$tedt2.'</td>';
		echo '</tr>';
		}




	echo '</tr>
	</table>
	</p>
	<br>';
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

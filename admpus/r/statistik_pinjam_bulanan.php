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
$filenya = "statistik_pinjam_bulanan.php";
$s = nosql($_REQUEST['s']);
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$judul = "Statistik Peminjaman per Bulan : $arrbln[$xbln1] $xthn1";
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
		<TD COLSPAN=31>
			<strong>TANGGAL</strong>
		</TD>
	</TR>
	<TR align="center" bgcolor="'.$warnaheader.'">';


	for ($i=1;$i<=31;$i++)
		{
		echo '<TD rowspan="1" width="50">
			<strong>'.$i.'</strong>
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

		//looping
		for ($i=1;$i<=31;$i++)
			{
			//jumlah
			$qku = mysql_query("SELECT perpus_item.kd ".
						"FROM perpus_item, perpus_pinjam ".
						"WHERE perpus_pinjam.kd_item = perpus_item.kd ".
						"AND perpus_item.kd_kategori = '$d_kode' ".
						"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d')) = '$i' ".
						"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$xbln1' ".
						"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$xthn1'");
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

	//looping
	for ($i=1;$i<=31;$i++)
		{
		//jumlah majalah
		$qku = mysql_query("SELECT perpus_item2.kd ".
					"FROM perpus_item2, perpus_pinjam ".
					"WHERE perpus_pinjam.kd_item = perpus_item2.kd ".
					"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$i' ".
					"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$xbln1' ".
					"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$xthn1'");
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

	//looping
	for ($i=1;$i<=31;$i++)
		{
		//jumlah peminjam
		$qku = mysql_query("SELECT kd_user ".
					"FROM perpus_pinjam ".
					"WHERE round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d')) = '$i' ".
					"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$xbln1' ".
					"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$xthn1'");
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

	//looping
	for ($i=1;$i<=31;$i++)
		{
		//jumlah
		$qku = mysql_query("SELECT kd_user ".
					"FROM perpus_absensi ".
					"WHERE round(DATE_FORMAT(tgl, '%d')) = '$i' ".
					"AND round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
					"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1'");
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
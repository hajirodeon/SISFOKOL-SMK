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
$filenya = "keadaan_buku.php";
$judul = "Rekap Keadaan Buku dan Bahan Lain";
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
	<TD ROWSPAN=3 WIDTH=25%>
		<strong>GOLONGAN</strong>
	</TD>
	<TD COLSPAN=5 WIDTH=25%>
		<strong>BUKU PERPUSTAKAAN</strong>
	</TD>
	<TD COLSPAN=5 WIDTH=25%>
		<strong>BUKU INVENTARIS PAKET</strong>
	</TD>
	<TD COLSPAN=2 WIDTH=25%>
		<strong>Jumlah Seharusnya</strong>
	</TD>
</TR>
<TR align="center" bgcolor="'.$warnaheader.'">
	<TD COLSPAN=3 WIDTH=12%>
		<strong>Jumlah</strong>
	</TD>
	<TD COLSPAN=2 WIDTH=13%>
		<strong>Jumlah Yang Baik</strong>
	</TD>
	<TD COLSPAN=3 WIDTH=12%>
		<strong>Jumlah</strong>
	</TD>
	<TD COLSPAN=2 WIDTH=13%>
		<strong>Jumlah Yang Baik</strong>
	</TD>
	<TD ROWSPAN=2 WIDTH=12%>
		<strong>Judul</strong>
	</TD>
	<TD ROWSPAN=2 WIDTH=13%>
		<strong>Eks</strong>
	</TD>
</TR>
<TR align="center" bgcolor="'.$warnaheader.'">
	<TD WIDTH=4%>
		<strong>Judul</strong>
	</TD>
	<TD WIDTH=4%>
		<strong>Eks</strong>
	</TD>
	<TD WIDTH=4%>
		<strong>Hilang/Rusak</strong>
	</TD>
	<TD WIDTH=6%>
		<strong>Judul</strong>
	</TD>
	<TD WIDTH=6%>
		<strong>Eks</strong>
	</TD>
	<TD WIDTH=4%>
		<strong>Judul</strong>
	</TD>
	<TD WIDTH=4%>
		<strong>Eks</strong>
	</TD>
	<TD WIDTH=4%>
		<strong>Hilang/Rusak</strong>
	</TD>
	<TD WIDTH=6%>
		<strong>Judul</strong>
	</TD>
	<TD WIDTH=6%>
		<strong>Eks</strong>
	</TD>
</TR>';

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


	//jumlah buku
	$qku = mysql_query("SELECT DISTINCT(judul) FROM perpus_item ".
				"WHERE kd_kategori = '$d_kode'");
	$rku = mysql_fetch_assoc($qku);
	$tku = mysql_num_rows($qku);

	//jumlah eks
	$qku2 = mysql_query("SELECT kd FROM perpus_item ".
				"WHERE kd_kategori = '$d_kode'");
	$rku2 = mysql_fetch_assoc($qku2);
	$tku2 = mysql_num_rows($qku2);


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$d_kode.'. '.$d_kategori.'</td>
	<td>'.$tku.'</td>
	<td>'.$tku2.'</td>
	<td></td>
	<td>'.$tku.'</td>
	<td>'.$tku2.'</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	</tr>';
	}
while ($redt = mysql_fetch_assoc($qedt));

echo '</tr>
<tr>
<td align="center">Fiksi</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td align="center">Majalah</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td align="center">Kliping</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td align="center">Jumlah</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>


</table>

</p>

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
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
$tpl = LoadTpl("../../template/print.html");

nocache;

//nilai
$filenya = "pinjam_item_harian_prt.php";
$judul = "Item Kembali Hari ini";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$itemkd = nosql($_REQUEST['itemkd']);
$tglku = $_REQUEST['tglku'];
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





//datanya
$qdt = mysql_query("SELECT perpus_pinjam.*, perpus_item.* ".
			"FROM perpus_pinjam, perpus_item ".
			"WHERE perpus_pinjam.kd_item = perpus_item.kd ".
			"AND perpus_pinjam.tgl_kembali2 = '$tglku' ".
			"AND perpus_item.kd = '$itemkd' ".
			"ORDER BY perpus_item.kode ASC");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);


echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
<td width="350"><strong><font color="'.$warnatext.'">Judul</font></strong></td>
<td width="150"><strong><font color="'.$warnatext.'">Peminjam</font></strong></td>
<td width="1">&nbsp;</td>
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
	$dt_kode = nosql($rdt['kode']);
	$dt_judul = balikin($rdt['judul']);
	$dt_userkd = nosql($rdt['kd_user']);


	//peminjam
	$qdt2 = mysql_query("SELECT * FROM m_user ".
				"WHERE kd = '$dt_userkd'");
	$rdt2 = mysql_fetch_assoc($qdt2);
	$tdt2 = mysql_num_rows($qdt2);
	$dt2_noinduk = balikin($rdt2['nomor']);
	$dt2_nama = balikin($rdt2['nama']);
	$dt_peminjam = "$dt2_noinduk. $dt2_nama";



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$dt_kode.'</td>
	<td>'.$dt_judul.'</td>
	<td>'.$dt_peminjam.'</td>
	</tr>';
	}
while ($rdt = mysql_fetch_assoc($qdt));



echo '</table>

</p>
</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>
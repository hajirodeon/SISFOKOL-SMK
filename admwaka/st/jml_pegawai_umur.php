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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "jml_pegawai_umur.php";
$judul = "Jumlah Pegawai Menurut Umur";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;







//isi *START
ob_start();

//menu
require("../../inc/menu/admwaka.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table border="1" cellpadding="3" cellspacing="0">
<tr bgcolor="'.$warnaheader.'">
<td width="50"><strong>20-30</strong></td>
<td width="50"><strong>31-40</strong></td>
<td width="50"><strong>41-50</strong></td>
<td width="50"><strong>51-60</strong></td>
<td width="50"><strong>61<</strong></td>
</tr>';


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";

	//20-30 //////////////////////////////////////////////////////////////////////////
	$jarak_mur01 = ($tahun - 20);
	$jarak_mur011 = ($tahun - 30);
	$q_mur01 = mysql_query("SELECT m_pegawai.* ".
					"FROM m_pegawai ".
					"WHERE DATE_FORMAT(tgl_lahir, '%Y') >= '$jarak_mur011' ".
					"AND DATE_FORMAT(tgl_lahir, '%Y') <= '$tahun'");
	$row_mur01 = mysql_fetch_assoc($q_mur01);
	$totalRows_mur01 = mysql_num_rows($q_mur01);



	//31-40 //////////////////////////////////////////////////////////////////////////
	$jarak_mur02 = ($tahun - 31);
	$jarak_mur021 = ($tahun - 40);
	$q_mur02 = mysql_query("SELECT m_pegawai.* ".
					"FROM m_pegawai ".
					"WHERE DATE_FORMAT(tgl_lahir, '%Y') >= '$jarak_mur021' ".
					"AND DATE_FORMAT(tgl_lahir, '%Y') <= '$jarak_mur02'");
	$row_mur02 = mysql_fetch_assoc($q_mur02);
	$totalRows_mur02 = mysql_num_rows($q_mur02);



	//41-50 //////////////////////////////////////////////////////////////////////////
	$jarak_mur03 = ($tahun - 41);
	$jarak_mur031 = ($tahun - 50);
	$q_mur03 = mysql_query("SELECT m_pegawai.* ".
					"FROM m_pegawai ".
					"WHERE DATE_FORMAT(tgl_lahir, '%Y') >= '$jarak_mur031' ".
					"AND DATE_FORMAT(tgl_lahir, '%Y') <= '$jarak_mur03'");
	$row_mur03 = mysql_fetch_assoc($q_mur03);
	$totalRows_mur03 = mysql_num_rows($q_mur03);



	//41-50 //////////////////////////////////////////////////////////////////////////
	$jarak_mur03 = ($tahun - 41);
	$jarak_mur031 = ($tahun - 50);
	$q_mur03 = mysql_query("SELECT m_pegawai.* ".
					"FROM m_pegawai ".
					"WHERE DATE_FORMAT(tgl_lahir, '%Y') >= '$jarak_mur031' ".
					"AND DATE_FORMAT(tgl_lahir, '%Y') <= '$jarak_mur03'");
	$row_mur03 = mysql_fetch_assoc($q_mur03);
	$totalRows_mur03 = mysql_num_rows($q_mur03);



	//51-60 //////////////////////////////////////////////////////////////////////////
	$jarak_mur04 = ($tahun - 51);
	$jarak_mur041 = ($tahun - 60);
	$q_mur04 = mysql_query("SELECT m_pegawai.* ".
					"FROM m_pegawai ".
					"WHERE DATE_FORMAT(tgl_lahir, '%Y') >= '$jarak_mur041' ".
					"AND DATE_FORMAT(tgl_lahir, '%Y') <= '$jarak_mur04'");
	$row_mur04 = mysql_fetch_assoc($q_mur04);
	$totalRows_mur04 = mysql_num_rows($q_mur04);



	//61< //////////////////////////////////////////////////////////////////////////
	$jarak_mur05 = ($tahun - 61);
	$q_mur05 = mysql_query("SELECT m_pegawai.* ".
					"FROM m_pegawai ".
					"WHERE DATE_FORMAT(tgl_lahir, '%Y') <= '$jarak_mur05'");
	$row_mur05 = mysql_fetch_assoc($q_mur05);
	$totalRows_mur05 = mysql_num_rows($q_mur05);

	echo '<td>'.$totalRows_mur01.'</td>
	<td>'.$totalRows_mur02.'</td>
	<td>'.$totalRows_mur03.'</td>
	<td>'.$totalRows_mur04.'</td>
	<td>'.$totalRows_mur05.'</td>
	</tr>';

echo '</table>

</form>
<br>
<br>
<br>';
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
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
require("../../inc/cek/admkesw.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "jml_siswa_umur.php";
$judul = "Jumlah Siswa Menurut Umur";
$judulku = "[$kesw_session : $nip12_session. $nm12_session] ==> $judul";
$judulx = $judul;






//isi *START
ob_start();

//menu
require("../../inc/menu/admkesw.php");

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
<td width="100"><strong>Tahun Pelajaran</strong></td>
<td width="50"><strong><=17</strong></td>
<td width="50"><strong>18</strong></td>
<td width="50"><strong>19</strong></td>
<td width="50"><strong>20=></strong></td>
</tr>';



//tapel
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"ORDER BY tahun1 ASC");
$rowtpx = mysql_fetch_assoc($qtpx);

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

	$nomer = $nomer + 1;
	$tpx_kd = nosql($rowtpx['kd']);
	$tpx_thn1 = nosql($rowtpx['tahun1']);
	$tpx_thn2 = nosql($rowtpx['tahun2']);



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td valign="top">
	'.$tpx_thn1.'/'.$tpx_thn2.'
	</td>';

	//kurang dari 17 //////////////////////////////////////////////////////////////////////////
	$jarak_mur01 = ($tahun - 17);
	$q_mur01 = mysql_query("SELECT m_siswa.*, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tpx_kd' ".
					"AND DATE_FORMAT(m_siswa.tgl_lahir, '%Y') >= '$jarak_mur01' ".
					"AND DATE_FORMAT(m_siswa.tgl_lahir, '%Y') <= '$tahun'");
	$row_mur01 = mysql_fetch_assoc($q_mur01);
	$totalRows_mur01 = mysql_num_rows($q_mur01);


	//18 //////////////////////////////////////////////////////////////////////////
	$jarak_mur02 = ($tahun - 18);
	$q_mur02 = mysql_query("SELECT m_siswa.*, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tpx_kd' ".
					"AND DATE_FORMAT(m_siswa.tgl_lahir, '%Y') = '$jarak_mur02'");
	$row_mur02 = mysql_fetch_assoc($q_mur02);
	$totalRows_mur02 = mysql_num_rows($q_mur02);


	//19 //////////////////////////////////////////////////////////////////////////
	$jarak_mur03 = ($tahun - 19);
	$q_mur03 = mysql_query("SELECT m_siswa.*, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tpx_kd' ".
					"AND DATE_FORMAT(m_siswa.tgl_lahir, '%Y') = '$jarak_mur03'");
	$row_mur03 = mysql_fetch_assoc($q_mur03);
	$totalRows_mur03 = mysql_num_rows($q_mur03);



	//lebih dari 20 //////////////////////////////////////////////////////////////////////////
	$jarak_mur04 = ($tahun - 20);
	$q_mur04 = mysql_query("SELECT m_siswa.*, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tpx_kd' ".
					"AND DATE_FORMAT(m_siswa.tgl_lahir, '%Y') >= '$jarak_mur04' ".
					"AND DATE_FORMAT(m_siswa.tgl_lahir, '%Y') >= '$tahun'");
	$row_mur04 = mysql_fetch_assoc($q_mur04);
	$totalRows_mur04 = mysql_num_rows($q_mur04);

	echo '<td>'.$totalRows_mur01.'</td>
	<td>'.$totalRows_mur02.'</td>
	<td>'.$totalRows_mur03.'</td>
	<td>'.$totalRows_mur04.'</td>
	</tr>';
	}
while ($rowtpx = mysql_fetch_assoc($qtpx));

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
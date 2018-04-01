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
$filenya = "rata_nilai_kelas.php";
$judul = "Rata - Rata Nilai per Kelas";
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
<td width="100"><strong>Tahun Pelajaran</strong></td>
<td width="30"><strong>X</strong></td>
<td width="30"><strong>XI</strong></td>
<td width="30"><strong>XII</strong></td>
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

	//kelas
	for ($k=1;$k<=3;$k++)
		{
		//rata - rata nilai
		$qjlx = mysql_query("SELECT AVG(total) AS rata ".
					"FROM m_kelas, siswa_rangking ".
					"WHERE siswa_rangking.kd_kelas = m_kelas.kd ".
					"AND siswa_rangking.kd_tapel = '$tpx_kd' ".
					"AND m_kelas.no = '$k'");
		$rjlx = mysql_fetch_assoc($qjlx);
		$tjlx = mysql_num_rows($qjlx);
		$jlx_rata = round(nosql($rjlx['rata']),2);


		echo '<td valign="top">
		'.$jlx_rata.'
		</td>';
		}

	echo '</tr>';
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
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

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/admlab.php");
$tpl = LoadTpl("../template/index.html");

nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang....";
$judulku = "$judul  [$lab_session : $nip14_session. $nm14_session]";


//isi *START
ob_start();

//menu
require("../inc/menu/admlab.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();





//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="500">
<p>
Anda Sebagai Pengelola Kompetensi Keahlian :
</p>';



echo '<p>
<table border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="1"><strong>No.</strong></td>
<td width="200"><strong>Keahlian</strong></td>
<td width="10"><strong>Siswa</strong></td>
<td width="10"><strong>Mata Pelajaran</strong></td>
<td width="10"><strong>Mata Pelajaran per Kelas</strong></td>
<td width="10"><strong>Inventaris</strong></td>
<td width="10"><strong>Rekap Nilai Siswa</strong></td>
</tr>';


//kompetensi keahlian yang dimiliki
$qdt = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_pegawai = '$kd14_session'");
$rdt = mysql_fetch_assoc($qdt);

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
	$i_nomer = $i_nomer + 1;
	$dt_kd = nosql($rdt['kd']);
	$dt_keahkd = nosql($rdt['kd_keahlian']);
	$dt_komp = balikin($rdt['kompetensi']);


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$i_nomer.'.
	</td>
	<td>
	'.$dt_komp.'
	</td>
	<td>
	<a href="d/siswa.php?keahkd='.$dt_keahkd.'&kompkd='.$dt_kd.'" title="'.$dt_komp.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
	</td>
	<td>
	<a href="d/prog_pddkn.php?keahkd='.$dt_keahkd.'&kompkd='.$dt_kd.'" title="'.$dt_komp.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
	</td>
	<td>
	<a href="d/prog_pddkn_kelas.php?keahkd='.$dt_keahkd.'&kompkd='.$dt_kd.'" title="'.$dt_komp.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
	</td>
	<td>
	<a href="d/inv.php?keahkd='.$dt_keahkd.'&kompkd='.$dt_kd.'" title="'.$dt_komp.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
	</td>
	<td>
	<a href="d/nilai.php?keahkd='.$dt_keahkd.'&kompkd='.$dt_kd.'" title="'.$dt_komp.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
	</td>
	</tr>';
	}
while ($rdt = mysql_fetch_assoc($qdt));


echo '</table>
</p>
</td>

<td valign="middle" align="center">
<p>
Anda Berada di <font color="blue"><strong>Pengelola Keahlian</strong></font>
</p>
<p>&nbsp;</p>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
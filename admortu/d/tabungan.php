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
require("../../inc/cek/admortu.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "tabungan.php";
$judul = "Data Tabungan";
$judulku = "[$siswa_session : $nis2_session.$nm2_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?page=$page";












//isi *START
ob_start();

//menu
require("../../inc/menu/admortu.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">';

//data tabungan
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM siswa_tabungan ".
				"WHERE kd_siswa = '$kd21_session' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);



echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="200" align="center"><strong><font color="'.$warnatext.'">Tanggal</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">Debet</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">Kredit</font></strong></td>
<td width="200" align="center"><strong><font color="'.$warnatext.'">Saldo</font></strong></td>
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

	//nilai
	$d_tgl = $data['tgl'];
	$d_debet = nosql($data['debet']);
	$d_nilai = nosql($data['nilai']);
	$d_saldo = nosql($data['saldo']);
	$d_postdate = $data['postdate'];


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$d_postdate.'</td>';

	//jika debet
	if ($d_debet == "true")
		{
		echo '<td align="right">'.xduit2($d_nilai).'</td>
		<td>-</td>';
		}

	//kredit
	else
		{
		echo '<td>-</td>
		<td align="right">'.xduit2($d_nilai).'</td>';
		}

	echo '<td align="right">'.xduit2($d_saldo).'</td>
	</tr>';
	}
while ($data = mysql_fetch_assoc($result));

echo '</table>


<table width="600" cellspacing="0" cellpadding="3">
<tr valign="top">
<td align="right">
<font color="red"><strong>'.$count.'</strong></font> Transaksi. '.$pagelist.'
</td>
</tr>
</table>



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
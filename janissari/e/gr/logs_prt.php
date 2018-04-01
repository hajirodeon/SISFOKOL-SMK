<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL JANISSARI                          ///////
/////// (customization)                             ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh :                               ///////
/////// Agus Muhajir, S.Kom                         ///////
/////// URL     :                                   ///////
///////     *http://sisfokol.wordpress.com          ///////
//////      *http://hajirodeon.wordpress.com        ///////
/////// E-Mail  :                                   ///////
///////     * hajirodeon@yahoo.com                  ///////
///////     * hajirodeon@gmail.com                  ///////
/////// HP/SMS  : 081-829-88-54                     ///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////



session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
$tpl = LoadTpl("../../../template/print.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$swkd = nosql($_REQUEST['swkd']);
$gmkd = nosql($_REQUEST['gmkd']);


//print /////////////////////////////////////////////////////////
$ke = "logs.php?gmkd=$gmkd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//detail siswa
$qdtx = mysql_query("SELECT * FROM m_user ".
			"WHERE kd = '$swkd'");
$rdtx = mysql_fetch_assoc($qdtx);
$dtx_nomor = nosql($rdtx['nomor']);
$dtx_nama = balikin($rdtx['nama']);


echo '<p>
<big>
Daftar Logs dari : <strong>'.$dtx_nomor.'.'.$dtx_nama.'</strong>.
</big>
</p>
<hr>';


//logs-nya
$qdt = mysql_query("SELECT * FROM user_learning ".
			"WHERE kd_user = '$swkd' ".
			"AND kd_guru_mapel = '$gmkd' ".
			"ORDER BY postdate DESC");
$rdt = mysql_fetch_assoc($qdt);

do
	{
	$ku_postdate = $rdt['postdate'];
	$ku_ket = balikin($rdt['ket']);

	echo '<p>
	['.$ku_postdate.'].
	<br>
	<em>'.$ku_ket.'.</em>
	</p>';
	}
while ($rdt = mysql_fetch_assoc($qdt));



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>
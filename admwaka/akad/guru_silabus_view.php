<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
$tpl = LoadTpl("../../template/print.html");


nocache;

//nilai
$filenya = "guru_silabus.php";
$judul = "Data Silabus";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$progkd = nosql($_REQUEST['progkd']);
$mmkd = nosql($_REQUEST['mmkd']);
$gkd = nosql($_REQUEST['gkd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&keahkd=$keahkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";

$limit = "50";











//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">';

//detail
$qx = mysql_query("SELECT * FROM guru_silabus ".
						"WHERE kd_guru_prog_pddkn = '$gkd' ".
						"AND kd_smt = '$smtkd'");
$rowx = mysql_fetch_assoc($qx);
$e_isi = balikin2($rowx['isi']);
$e_postdate = $rowx['postdate'];

//pecah titik - titik
$e_isi2 = pathasli2($e_isi);



$e_isi22 = $e_isi2;


echo ''.$e_isi22.'



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
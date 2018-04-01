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
require("../../inc/cek/admbdh.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "set.php";
$judul = "Set Debet/Kredit/Saldo";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$ke = $filenya;






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$min_debet = nosql($_POST['min_debet']);
	$max_kredit = nosql($_POST['max_kredit']);
	$min_saldo = nosql($_POST['min_saldo']);


	//cek
	$qcc = mysql_query("SELECT * FROm m_tabungan");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//jika ada
	if ($tcc != 0)
		{
		//update
		mysql_query("UPDATE m_tabungan SET min_debet = '$min_debet', ".
						"max_kredit = '$max_kredit', ".
						"min_saldo = '$min_saldo'");
		}
	else
		{
		//insert
		mysql_query("INSERT INTO m_tabungan(kd, min_debet, max_kredit, min_saldo) VALUES ".
						"('$x', '$min_debet', '$max_kredit', '$min_saldo')");
		}


	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/admbdh.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();

//js
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//data...
$qdt = mysql_query("SELECT * FROM m_tabungan");
$rdt = mysql_fetch_assoc($qdt);
$dt_min_debet = nosql($rdt['min_debet']);
$dt_max_kredit = nosql($rdt['max_kredit']);
$dt_min_saldo = nosql($rdt['min_saldo']);




echo '<form name="formx" method="post" action="'.$filenya.'">
<UL>
<LI>
Minimal Debet (Menabung) :
<br>
Rp.	<input name="min_debet" type="text" size="10" value="'.$dt_min_debet.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
</LI>
<br>

<LI>
Maksimal Kredit (Pengambilan) :
<br>
Rp.	<input name="max_kredit" type="text" size="10" value="'.$dt_max_kredit.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
</LI>
<br>

<LI>
Minimal Saldo :
<br>
Rp.	<input name="min_saldo" type="text" size="10" value="'.$dt_min_saldo.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
</LI>
<br>


<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">

</UL>
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
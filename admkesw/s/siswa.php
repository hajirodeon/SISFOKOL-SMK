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
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admkesw.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "siswa.php";
$judul = "Edit Data Siswa";
$judulku = "[$kesw_session : $nip12_session. $nm12_session] ==> $judul";
$juduli = $judul;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$status = nosql($_POST['status']);

	//cek
	$qcc = mysql_query("SELECT * FROM set_siswa_edit");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//nek sudah ada, update
	if ($tcc != 0)
		{
		mysql_query("UPDATE set_siswa_edit SET status = '$status', ".
						"postdate = '$today'");
		}
	else
		{
		mysql_query("INSERT INTO set_siswa_edit(kd, status, postdate) VALUES ".
						"('$x', '$status', '$today')");
		}

	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//status
$qtsu = mysql_query("SELECT * FROM set_siswa_edit");
$rtsu = mysql_fetch_assoc($qtsu);
$tsu_status = nosql($rtsu['status']);
$tsu_postdate = $rtsu['postdate'];

//true false
if ($tsu_status == "true")
	{
	$tsu_status = "DIIJINKAN";
	}
else
	{
	$tsu_status = "TIDAK BOLEH";
	}

//null postdate
if (empty($tsu_postdate))
	{
	$tsu_postdate = "-";
	}

echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Status Edit Data, untuk Tiap Siswa :
<br>
<select name="status">
<option value="'.$tsu_status.'" selected>--'.$tsu_status.'--</option>
<option value="true">Diijinkan</option>
<option value="false">Tidak Boleh</option>
</select>
</p>

<p>Terhitung Sejak : <br>
<strong>'.$tsu_postdate.'</strong>
</p>


<p>
<input name="btnSMP" type="submit" value="SIMPAN">
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
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
require("../../inc/cek/admsms.php");
$tpl = LoadTpl("../../template/sms.html");

nocache;

//nilai
$filenya = "siswa_kirim_info.php";
$judul = "Siswa : Kirim Info";
$judulku = "[$sms_session : $nip32_session. $nm32_session] ==> $judul";
$judulx = $judul;

$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);


$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}





//kirim sms massal ////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnKRM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);



	//total
	$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
				"FROM m_siswa, siswa_kelas ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kelkd' ".
				"ORDER BY round(m_siswa.nis) ASC");
	$rdata = mysql_fetch_assoc($qdata);
	$tdata = mysql_num_rows($qdata);

	do
		{
		$nomer = $nomer + 1;
		$xyz = md5("$x$nomer");
		$data_swkd = nosql($rdata['mskd']);
		$data_swnis = nosql($rdata['msnis']);


		//cek punya no.hp
		$qcc = mysql_query("SELECT * FROM sms_nohp_siswa ".
					"WHERE kd_siswa = '$data_swkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_nohp = nosql($rcc['nohp']);


		//data info
		$qcc2 = mysql_query("SELECT * FROM sms_siswa_info");
		$rcc2 = mysql_fetch_assoc($qcc2);
		$tcc2 = mysql_num_rows($qcc2);
		$cc2_info = balikin($rcc2['info']);


		//simpan ke database ///////////////////////////////////////////////////////
		mysql_query("INSERT INTO sms_siswa_sent (kd, kd_siswa, info, postdate) VALUES ".
				"('$xyz', '$data_swkd', '$cc2_info', '$today')");


		//kirim sms-nya
		//kirim sms, melalui service mysql khusus gammu
		mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
						"VALUES ('$cc_nohp', '$cc2_info', 'Gammu', 'biasawae', '0')");
		}
	while ($rdata = mysql_fetch_assoc($qdata));


	//re-direct
	$pesan = "SMS Dalam Proses Pengiriman. Silahkan cek status pada Outbox.";
	pekem($pesan,$filenya);
	exit();
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/admsms.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,



Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd <> '$kelkd' ".
			"ORDER BY kelas ASC, no ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	//total
	$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd'");
	$rdata = mysql_fetch_assoc($qdata);
	$tdata = mysql_num_rows($qdata);



	//query
	$qx = mysql_query("SELECT * FROM sms_siswa_info");
	$rowx = mysql_fetch_assoc($qx);
	$x_info = balikin2($rowx['info']);


	echo '<p>
	[Total Siswa : <strong>'.$tdata.'</strong>].
	<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
	<INPUT type="hidden" name="kelkd" value="'.$kelkd.'">
	</p>
	<p>
	<strong>Info Saat ini :</strong>
	<br>
	<em>'.$x_info.'</em>. [<a href="siswa_info.php">EDIT</a>]
	</p>

	<p>
	<INPUT type="submit" name="btnKRM" value="Kirim SMS Sekarang >>">
	</p>';
	}


echo '</form>
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
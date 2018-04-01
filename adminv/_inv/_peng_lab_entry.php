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
require("../../inc/cek/adminv.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "peng_lab_entry.php";
$judul = "Entry Penggunaan Lab.";
$judulku = "[$inv_session : $nip13_session. $nm13_session] ==> $judul";
$judulx = $judul;


//focus
$diload = "document.formx.lab.focus();";









//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "peng_lab.php";
	xloc($ke);
	exit();
	}





//nek simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$lab = nosql($_POST['lab']);
	$jam = nosql($_POST['jam']);
	$kelas = nosql($_POST['kelas']);
	$ruang = nosql($_POST['ruang']);


	//tgl. penggunaan
	$p_tgl = nosql($_POST['p_tgl']);
	$p_bln = nosql($_POST['p_bln']);
	$p_thn = nosql($_POST['p_thn']);
	$tgl_p = "$p_thn:$p_bln:$p_tgl";


	//nek null
	if ((empty($lab)) OR (empty($p_tgl)) OR (empty($p_bln)) OR (empty($p_thn)) OR (empty($jam))
	OR (empty($kelas)) OR (empty($ruang)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM inv_peng_lab ".
								"WHERE kd_lab = '$lab' ".
								"AND tgl = '$tgl_p' ".
								"AND kd_jam = '$jam' ".
								"AND kd_kelas = '$kelas' ".
								"AND kd_ruang = '$ruang'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "LAB. Telah Digunakan. Harap Diganti Yang Lain...!!";
			pekem($pesan,$filenya);
			exit();
			}
		else
			{
			//insert baru
			mysql_query("INSERT INTO inv_peng_lab(kd, kd_lab, tgl, kd_jam, kd_kelas, kd_ruang) VALUES ".
							"('$x', '$lab', '$tgl_p', '$jam', '$kelas', '$ruang')");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "peng_lab.php";
			xloc($ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/menu/adminv.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';
xheadline($judul);
echo ' [<a href="peng_lab.php" title="Daftar Penggunaan Lab.">Daftar Penggunaan</a>]';

//nilai - nilai tgl
$qnilp = mysql_query("SELECT DATE_FORMAT(inv_peng_lab.tgl, '%d') AS p_tgl, ".
						"DATE_FORMAT(inv_peng_lab.tgl, '%m') AS p_bln, ".
						"DATE_FORMAT(inv_peng_lab.tgl, '%Y') AS p_thn, ".
						"inv_peng_lab.* ".
						"FROM inv_peng_lab ".
						"WHERE inv_peng_lab.kd = '$pjkd'");
$rnilp = mysql_fetch_assoc($qnilp);
$nilp_ptgl = nosql($rnilp['p_tgl']);
$nilp_pbln = nosql($rnilp['p_bln']);
$nilp_pthn = nosql($rnilp['p_thn']);



//penggunaan lab
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Lab. :
<br>
<select name="lab">
<option value="" selected></option>';

//lab
$qlab = mysql_query("SELECT * FROM inv_lab ".
						"ORDER BY lab ASC");
$rlab = mysql_fetch_assoc($qlab);

do
	{
	$lab_kd = nosql($rlab['kd']);
	$lab_nm = balikin($rlab['lab']);

	echo '<option value="'.$lab_kd.'">'.$lab_nm.'</option>';
	}
while ($rlab = mysql_fetch_assoc($qlab));

echo '</select>
<br>
<br>
Tgl. Penggunaan :
<br>
<select name="p_tgl">
<option value="'.$nilp_ptgl.'" selected>'.$nilp_ptgl.'</option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}

echo '</select>
<select name="p_bln">
<option value="'.$nilp_pbln.'" selected>'.$arrbln1[$nilp_pbln].'</option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>
<select name="p_thn">
<option value="'.$nilp_pthn.'" selected>'.$nilp_pthn.'</option>';
for ($k=$pinjam01;$k<=$pinjam02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>,

<br>
<br>
Jam Ke- :
<br>
<select name="jam">
<option value="" selected></option>';

//jam
$qjam = mysql_query("SELECT * FROM m_jam ".
						"ORDER BY round(jam) ASC");
$rjam = mysql_fetch_assoc($qjam);

do
	{
	$jam_kd = nosql($rjam['kd']);
	$jam_nm = nosql($rjam['jam']);

	echo '<option value="'.$jam_kd.'">'.$jam_nm.'</option>';
	}
while ($rjam = mysql_fetch_assoc($qjam));

echo '</select>
<br>
<br>
Kelas :
<br>
<select name="kelas">
<option value="" selected></option>';

//kelas
$qkel = mysql_query("SELECT * FROM m_kelas ".
						"ORDER BY kelas ASC");
$rkel = mysql_fetch_assoc($qkel);

do
	{
	$kel_kd = nosql($rkel['kd']);
	$kel_nm = nosql($rkel['kelas']);

	echo '<option value="'.$kel_kd.'">'.$kel_nm.'</option>';
	}
while ($rkel = mysql_fetch_assoc($qkel));

echo '</select>



<br>
<br>
Ruang :
<br>
<select name="ruang">
<option value="" selected></option>';

//ruang
$qru = mysql_query("SELECT * FROM m_ruang ".
						"ORDER BY ruang ASC");
$rru = mysql_fetch_assoc($qru);

do
	{
	$ru_kd = nosql($rru['kd']);
	$ru_nm = balikin($rru['ruang']);

	echo '<option value="'.$ru_kd.'">'.$ru_nm.'</option>';
	}
while ($rru = mysql_fetch_assoc($qru));

echo '</select>
<br>
<br>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
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
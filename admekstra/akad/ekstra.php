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
require("../../inc/cek/admekstra.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "ekstra.php";
$diload = "document.formx.ekstra.focus();";
$judul = "Ekstra";
$judulku = "[$ekstra_session : $nip35_session. $nm35_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/admekstra.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();




//query
$q = mysql_query("SELECT * FROM m_ekstra ".
					"WHERE kd_pegawai = '$kd35_session' ".
					"ORDER BY ekstra ASC");
$row = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);






//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';


if ($total != 0)
	{
	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td><strong><font color="'.$warnatext.'">Nama Ekstra</font></strong></td>
	</tr>';

	do {
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
		$kd = nosql($row['kd']);
		$pegkdd = nosql($row['kd_pegawai']);
		$ekstra = balikin2($row['ekstra']);



		//pegawai
		$qku = mysql_query("SELECT * FROM m_pegawai ".
								"WHERE kd = '$pegkdd'");
		$rku = mysql_fetch_assoc($qku);
		$ku_nip = nosql($rku['nip']);
		$ku_nama = balikin($rku['nama']);



		//jumlah siswa yang ikut
		$qdt = mysql_query("SELECT DISTINCT(siswa_ekstra.kd_siswa_kelas) AS total ".
								"FROM m_siswa, siswa_kelas, siswa_ekstra ".
								"WHERE siswa_ekstra.kd_siswa_kelas = siswa_kelas.kd ".
								"AND siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_ekstra.kd_ekstra = '$kd'");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);



		$i_wow = "[<a href=\"ekstra_siswa.php?ekskd=$kd\"><strong>$tdt</strong> Siswa</a>].";


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$ekstra.' '.$i_wow.'
		</td>
    	</tr>';
		}
	while ($row = mysql_fetch_assoc($q));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>TIDAK ADA DATA. </strong>
	</font>
	</p>';
	}

echo '</form>';
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
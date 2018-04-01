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
require("../inc/cek/admwk.php");
$tpl = LoadTpl("../template/index.html");

nocache;

//nilai
$filenya = "index.php";
$judul = "Detail Wali Kelas : $nip3_session.$nm3_session";
$judulku = "[$wk_session : $nip3_session.$nm3_session] ==> $judul";
$juduli = $judul;





//isi *START
ob_start();

//menu
require("../inc/menu/admwk.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();

//js
require("../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top">';


//data ne
$qdty = mysql_query("SELECT m_pegawai.*, m_walikelas.*, m_tapel.* ".
			"FROM m_pegawai, m_walikelas, m_tapel ".
			"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd3_session' ".
			"AND m_walikelas.kd_tapel = m_tapel.kd ".
			"ORDER BY m_tapel.tahun1 DESC");
$rdty = mysql_fetch_assoc($qdty);
$tdty = mysql_num_rows($qdty);

echo '<table border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="150"><strong>Tahun Pelajaran</strong></td>
<td width="50"><strong>Kelas</strong></td>
<td width="100"><strong>Program Keahlian</strong></td>
<td width="100"><strong>Kompetensi Keahlian</strong></td>
<td width="50"><strong>Siswa</strong></td>
<td width="50"><strong>Ledger Nilai</strong></td>
<td width="50"><strong>Jadwal</strong></td>
</tr>';

//nek gak null
if ($tdty != 0)
	{
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
		$dty_tapelkd = nosql($rdty['kd_tapel']);
		$dty_kelkd = nosql($rdty['kd_kelas']);
		$dty_keahkd = nosql($rdty['kd_keahlian']);
		$dty_kompkd = nosql($rdty['kd_keahlian_kompetensi']);

		//tapel
		$qytapel = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$dty_tapelkd'");
		$rytapel = mysql_fetch_assoc($qytapel);
		$ytapel_thn1 = nosql($rytapel['tahun1']);
		$ytapel_thn2 = nosql($rytapel['tahun2']);

		//kelas
		$qykel = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$dty_kelkd'");
		$rykel = mysql_fetch_assoc($qykel);
		$ykel_kelas = balikin($rykel['kelas']);

		//keahlian
		$qyprog = mysql_query("SELECT * FROM m_keahlian ".
						"WHERE kd = '$dty_keahkd'");
		$ryprog = mysql_fetch_assoc($qyprog);
		$yprog_prog = balikin($ryprog['program']);
		$yprog_keah = "$yprog_prog";




		//keahlian kompetensi
		$qyprog2 = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
						"WHERE kd = '$dty_kompkd'");
		$ryprog2 = mysql_fetch_assoc($qyprog2);
		$yprog_prog2 = balikin($ryprog2['kompetensi']);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$ytapel_thn1.'/'.$ytapel_thn2.'</td>
		<td>'.$ykel_kelas.'</td>
		<td>'.$yprog_keah.'</td>
		<td>'.$yprog_prog2.'</td>
		<td>
		<a href="d/detail.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&keahkd='.$dty_keahkd.'&kompkd='.$dty_kompkd.'"
		title="DAFTAR SISWA. Tahun Pelajaran = '.$ytapel_thn1.'/'.$ytapel_thn2.', Kelas = '.$ykel_kelas.', Keahlian = '.$yprog_keah.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
		</td>
		<td>
		<a href="d/ledger_nilai.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&keahkd='.$dty_keahkd.'&kompkd='.$dty_kompkd.'"
		title="LEDGER NILAI. Tahun Pelajaran = '.$ytapel_thn1.'/'.$ytapel_thn2.', Kelas = '.$ykel_kelas.', Keahlian = '.$yprog_keah.'">
		<img src="'.$sumber.'/img/xls.gif" width="16" height="16" border="0"></a>
		</td>
		<td>
		<a href="d/jadwal.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&keahkd='.$dty_keahkd.'&kompkd='.$dty_kompkd.'"
		title="JADWAL PELAJARAN. Tahun Pelajaran = '.$ytapel_thn1.'/'.$ytapel_thn2.', Kelas = '.$ykel_kelas.', Keahlian = '.$yprog_keah.'">
		<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
		</td>
		</tr>';
		}
	while ($rdty = mysql_fetch_assoc($qdty));
	}

echo '</table>
<br>
<br>
<br>

<td valign="middle" align="center">
<p>
Anda Berada di <font color="blue"><strong>WALI KELAS AREA</strong></font>
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
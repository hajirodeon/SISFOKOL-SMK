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
require("../../inc/cek/admwk.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "detail.php";
$judul = "Daftar Siswa";
$judulku = "[$wk_session : $nip3_session.$nm3_session] ==> $judul";
$juduli = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd";







//isi *START
ob_start();

//menu
require("../../inc/menu/admwk.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();

//js
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table>
<tr>
<td>';
xheadline($judul);
echo '</td>
<td>[<a href="../index.php" title="Daftar Kelas">Daftar Kelas</a>]</td>
</table>';



//tapel
$qpel = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rpel = mysql_fetch_assoc($qpel);
$pel_thn1 = nosql($rpel['tahun1']);
$pel_thn2 = nosql($rpel['tahun2']);

//kelas
$qkel = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = balikin($rkel['kelas']);

//keahlian
$qpro = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);




//kompetensi
$qprgx2 = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd = '$kompkd'");
$rowprgx2 = mysql_fetch_assoc($qprgx2);
$prgx2_prog = balikin($rowprgx2['kompetensi']);




//query data siswa
$p = new Pager();
$start = $p->findStart($limit);
$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
		"siswa_kelas.*, siswa_kelas.kd AS skkd ".
		"FROM m_siswa, siswa_kelas ".
		"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
		"AND siswa_kelas.kd_tapel = '$tapelkd' ".
		"AND siswa_kelas.kd_kelas = '$kelkd' ".
		"AND siswa_kelas.kd_keahlian = '$keahkd' ".
		"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
		"ORDER BY round(siswa_kelas.no_absen) ASC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = $ke;
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);



echo '<table bgcolor="'.$warnaover.'" width="100%" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<strong>Tahun Pelajaran :</strong> '.$pel_thn1.'/'.$pel_thn2.',
<strong>Kelas :</strong> '.$kel_kelas.',
<strong>Program Keahlian :</strong> '.$pro_program.',
<strong>Kompetensi Keahlian :</strong> '.$prgx2_prog.'
</td>
</tr>
</table>
<br>';

//nek gak null
if ($count != 0)
	{
	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="20" align="center"><strong>No.</strong></td>
	<td width="50" align="center"><strong>NIS</strong></td>
	<td align="center"><strong>Nama Siswa</strong></td>
	<td width="50" align="center"><strong>Absensi</strong></td>
	<td width="50" align="center"><strong>Keuangan</strong></td>
	<td width="50" align="center"><strong>Raport</strong></td>
	<td width="50" align="center"><strong>Buku Induk</strong></td>
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
		$y_mskd = nosql($data['mskd']);
		$y_skkd = nosql($data['skkd']);
		$y_no = nosql($data['no_absen']);
		$y_nis = nosql($data['nis']);
		$y_nama = balikin($data['nama']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$y_no.'</td>
		<td>'.$y_nis.'</td>
		<td>'.$y_nama.'</td>
		<td>
		<a href="absensi.php?page='.$page.'&nis='.$y_nis.'&swkd='.$y_mskd.'&skkd='.$y_skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'"
		title="Tahun Pelajaran = '.$pel_thn1.'/'.$pel_thn2.', Kelas = '.$kel_kelas.', Keahlian = '.$pro_bidang.' - '.$pro_program.'">
		<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
		</td>
		<td>
		<a href="keuangan.php?page='.$page.'&nis='.$y_nis.'&swkd='.$y_mskd.'&skkd='.$y_skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'"
		title="Tahun Pelajaran = '.$pel_thn1.'/'.$pel_thn2.', Kelas = '.$kel_kelas.', Keahlian = '.$pro_bidang.' - '.$pro_program.'">
		<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
		</td>
		<td>
		<a href="raport.php?page='.$page.'&nis='.$y_nis.'&swkd='.$y_mskd.'&skkd='.$y_skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'"
		title="Tahun Pelajaran = '.$pel_thn1.'/'.$pel_thn2.', Kelas = '.$kel_kelas.', Keahlian = '.$pro_bidang.' - '.$pro_program.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
		</td>
		<td>
		<a href="buku_induk.php?page='.$page.'&nis='.$y_nis.'&swkd='.$y_mskd.'&skkd='.$y_skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'"
		title="Tahun Pelajaran = '.$pel_thn1.'/'.$pel_thn2.', Kelas = '.$kel_kelas.', Keahlian = '.$pro_bidang.' - '.$pro_program.'">
		<img src="'.$sumber.'/img/xls.gif" width="16" height="16" border="0"></a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>
	<font color="red">
	<strong>'.$count.'</strong>
	</font> Data. '.$pagelist.'';
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>TIDAK ADA DATA.</strong>
	</font>
	</p>';
	}


echo '<br><br><br>';
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
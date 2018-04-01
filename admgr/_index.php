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
require("../inc/cek/admgr.php");
$tpl = LoadTpl("../template/index.html");

nocache;

//nilai
$filenya = "index.php";
$judul = "Daftar Standar Kompetensi";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduli = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);




//isi *START
ob_start();

//js
require("../inc/js/swap.js");
require("../inc/js/jumpmenu.js");
require("../inc/menu/admgr.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);

echo '<option value="'.nosql($rowtpx['kd']).'">'.nosql($rowtpx['tahun1']).'/'.nosql($rowtpx['tahun2']).'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd <> '$tapelkd' ".
			"ORDER BY tahun1 DESC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';


//nek null
if (empty($tapelkd))
	{
	echo '<p>
	<font color="red">
	<strong>TAHUN PELAJARAN Belum Ditentukan...!!</strong>
	</font>
	</p>


	<br><br><br>

	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<td valign="middle" align="center">
	<p>
	Anda Berada di <font color="blue"><strong>GURU AREA</strong></font>
	</p>
	<p><em>{Harap Dikelola Dengan Baik.)</em></p>
	<p>&nbsp;</p>
	</td>
	</tr>
	</table>';
	}

else
	{
	//data ne
	$qdty = mysql_query("SELECT m_pegawai.*, m_guru.*, m_guru_prog_pddkn.*, m_guru_prog_pddkn.kd AS mgkd, ".
				"m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, m_tapel.* ".
				"FROM m_pegawai, m_guru, m_guru_prog_pddkn, m_prog_pddkn, m_tapel ".
				"WHERE m_guru_prog_pddkn.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_guru_prog_pddkn.kd_guru = m_guru.kd ".
				"AND m_guru.kd_pegawai = m_pegawai.kd ".
				"AND m_pegawai.kd = '$kd1_session' ".
				"AND m_guru.kd_tapel = m_tapel.kd ".
				"AND m_tapel.kd = '$tapelkd'");
	$rdty = mysql_fetch_assoc($qdty);
	$tdty = mysql_num_rows($qdty);


	echo '<p>
	<table width="800" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>Kelas</strong></td>
	<td width="100"><strong>Program Keahlian</strong></td>
	<td><strong>Standar Kompetensi</strong></td>
	<td width="50"><strong>Absensi</strong></td>
	<td width="50"><strong>Daftar Kompetensi Dasar</strong></td>
	<td width="50"><strong>Nilai Kompetensi Dasar</strong></td>
	<td width="50"><strong>Nilai Raport</strong></td>
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
			$dty_gurkd = nosql($rdty['mgkd']);
			$dty_kelkd = nosql($rdty['kd_kelas']);
			$dty_tapelkd = nosql($rdty['kd_tapel']);
			$dty_keahkd = nosql($rdty['kd_keahlian']);
			$dty_kompkd = nosql($rdty['kd_keahlian_kompetensi']);
			$dty_pelkd = nosql($rdty['kd_prog_pddkn']);
			$dty_pel = balikin($rdty['prog_pddkn']);

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





			//program pendidikan-terpilih
			$qpelx2 = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$dty_keahkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$dty_kompkd' ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$dty_kelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$dty_pelkd' ".
							"ORDER BY round(m_prog_pddkn.no, m_prog_pddkn.no_sub) ASC");
			$rpelx2 = mysql_fetch_assoc($qpelx2);
			$pelx_mpkd = nosql($rpelx2['mpkd']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$ykel_kelas.'</td>
			<td>'.$yprog_keah.'</td>
			<td>'.$dty_pel.'</td>
			<td>
			<a href="ajar/nil_absensi.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&keahkd='.$dty_keahkd.'&progkd='.$dty_pelkd.'"
			title="Kelas = '.$ykel_kelas.', Keahlian = '.$yprog_keah.', Pelajaran = '.$dty_pel.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="ajar/daftar_kompetensi.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&keahkd='.$dty_keahkd.'&progkd='.$dty_pelkd.'&mpkd='.$pelx_mpkd.'&kompkd='.$dty_kompkd.'"
			title="Kelas = '.$ykel_kelas.', Keahlian = '.$yprog_keah.', Pelajaran = '.$dty_pel.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="ajar/nil_kompetensi.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&keahkd='.$dty_keahkd.'&progkd='.$dty_pelkd.'&mpkd='.$pelx_mpkd.'&kompkd='.$dty_kompkd.'"
			title="Kelas = '.$ykel_kelas.', Keahlian = '.$yprog_keah.', Pelajaran = '.$dty_pel.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="ajar/nil_prog_pddkn.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&keahkd='.$dty_keahkd.'&progkd='.$dty_pelkd.'"
			title="Kelas = '.$ykel_kelas.', Keahlian = '.$yprog_keah.', Pelajaran = '.$dty_pel.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			</tr>';
			}
		while ($rdty = mysql_fetch_assoc($qdty));
		}

	echo '</table>
	</p>';
	}
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
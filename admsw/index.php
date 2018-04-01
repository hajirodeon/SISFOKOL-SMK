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
require("../inc/cek/admsw.php");
$tpl = LoadTpl("../template/index.html");

nocache;

//nilai
$filenya = "index.php";
$judul = "Detail Siswa";
$judulku = "[$siswa_session : $nis2_session.$nm2_session] ==> $judul";
$juduli = $judul;





//isi *START
ob_start();

//menu
require("../inc/menu/admsw.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();

//js
require("../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//cek aktif kurikulum
$qku = mysql_query("SELECT * FROM m_kurikulum ".
						"WHERE aktif = 'true'");
$rku = mysql_fetch_assoc($qku);
$ku_no = nosql($rku['no']);		


//jika kurikulum KTSP
if ($ku_no == "1")
	{
	//data ne
	$qdty = mysql_query("SELECT siswa_kelas.*, siswa_kelas.kd AS skkd, ".
							"m_siswa.*, m_siswa.kd AS mskd ".
							"FROM siswa_kelas, m_siswa ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_siswa = '$kd2_session'");
	$rdty = mysql_fetch_assoc($qdty);
	$tdty = mysql_num_rows($qdty);
	
	
	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr align="center" bgcolor="'.$warnaheader.'">
	<td width="50"><strong>Tahun Pelajaran</strong></td>
	<td width="50"><strong>Kelas</strong></td>
	<td width="10"><strong>Keuangan</strong></td>
	<td width="10"><strong>Absensi</strong></td>
	<td width="10"><strong>Sikap Diri Sendiri</strong></td>
	<td width="10"><strong>Sikap Antar Teman</strong></td>
	<td width="10"><strong>Nilai</strong></td>
	<td width="10"><strong>Raport</strong></td>
	<td width="10"><strong>Jadwal</strong></td>
	<td width="10"><strong>E-Learning</strong></td>
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
			$dty_swkd = nosql($rdty['mskd']);
			$dty_tapelkd = nosql($rdty['kd_tapel']);
			$dty_kelkd = nosql($rdty['kd_kelas']);
	
			//tapel
			$qypel = mysql_query("SELECT * FROM m_tapel ".
									"WHERE kd = '$dty_tapelkd'");
			$rypel = mysql_fetch_assoc($qypel);
			$ypel_thn1 = nosql($rypel['tahun1']);
			$ypel_thn2 = nosql($rypel['tahun2']);
	
			//kelas
			$qykel = mysql_query("SELECT * FROM m_kelas ".
									"WHERE kd = '$dty_kelkd'");
			$rykel = mysql_fetch_assoc($qykel);
			$ykel_kelas = balikin($rykel['kelas']);
	
	
	
	
	
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$ypel_thn1.'/'.$ypel_thn2.'</td>
			<td>'.$ykel_kelas.'</td>
			<td>
			<a href="d/keu.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="KEUANGAN. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0">
			</td>
			<td>
			<a href="d/abs.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="ABSENSI. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="sikap/dirisendiri.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="Sikap Diri Sendiri. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="sikap/antarteman.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="Sikap Antar Teman. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			
			<td>
			<a href="d/nilai.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="Detail Nilai. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			
			<td>
			<a href="d/raport.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="RAPORT. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="d/jadwal.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="JADWAL PELAJARAN. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="d/elearning.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="E-LEARNING. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			</tr>';
			}
		while ($rdty = mysql_fetch_assoc($qdty));
		}
	
	echo '</table>
	<br><br><br>';
	}
	
	
//jika kurikulum 2013
else if ($ku_no == "2")
	{
	//data ne
	$qdty = mysql_query("SELECT siswa_kelas.*, siswa_kelas.kd AS skkd, ".
							"m_siswa.*, m_siswa.kd AS mskd ".
							"FROM siswa_kelas, m_siswa ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_siswa = '$kd2_session'");
	$rdty = mysql_fetch_assoc($qdty);
	$tdty = mysql_num_rows($qdty);
	
	
	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr align="center" bgcolor="'.$warnaheader.'">
	<td width="50"><strong>Tahun Pelajaran</strong></td>
	<td width="50"><strong>Kelas</strong></td>
	<td width="10"><strong>Keuangan</strong></td>
	<td width="10"><strong>Absensi</strong></td>
	<td width="10"><strong>Sikap Diri Sendiri</strong></td>
	<td width="10"><strong>Sikap Antar Teman</strong></td>
	<td width="10"><strong>Nilai</strong></td>
	<td width="10"><strong>Raport</strong></td>
	<td width="10"><strong>Jadwal</strong></td>
	<td width="10"><strong>E-Learning</strong></td>
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
			$dty_swkd = nosql($rdty['mskd']);
			$dty_tapelkd = nosql($rdty['kd_tapel']);
			$dty_kelkd = nosql($rdty['kd_kelas']);
	
	
			//tapel
			$qypel = mysql_query("SELECT * FROM m_tapel ".
									"WHERE kd = '$dty_tapelkd'");
			$rypel = mysql_fetch_assoc($qypel);
			$ypel_thn1 = nosql($rypel['tahun1']);
			$ypel_thn2 = nosql($rypel['tahun2']);
	
			//kelas
			$qykel = mysql_query("SELECT * FROM m_kelas ".
									"WHERE kd = '$dty_kelkd'");
			$rykel = mysql_fetch_assoc($qykel);
			$ykel_kelas = balikin($rykel['kelas']);
	
	
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$ypel_thn1.'/'.$ypel_thn2.'</td>
			<td>'.$ykel_kelas.'</td>
			<td>
			<a href="d/keu.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="KEUANGAN. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0">
			</td>
			<td>
			<a href="d/abs.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="ABSENSI. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="sikap/dirisendiri.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="Sikap Diri Sendiri. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="sikap/antarteman.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="Sikap Antar Teman. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			
			<td>
			<a href="d2/nilai.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="Detail Nilai. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			
			<td>
			<a href="d2/raport.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="RAPORT. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="d/jadwal.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="JADWAL PELAJARAN. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="d/elearning.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'"
			title="E-LEARNING. Tahun Pelajaran = '.$ypel_thn1.'/'.$ypel_thn2.', Kelas = '.$ykel_kelas.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			</tr>';
			}
		while ($rdty = mysql_fetch_assoc($qdty));
		}
	
	echo '</table>
	<br><br><br>';	
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
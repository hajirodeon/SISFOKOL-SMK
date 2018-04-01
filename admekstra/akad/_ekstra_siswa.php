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
require("../../inc/class/paging.php");
require("../../inc/cek/admekstra.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "ekstra_siswa.php";
$judulku = "[$ekstra_session : $nip23_session. $nm23_session] ==> $judul";
$judulx = $judul;
$ekskd = nosql($_REQUEST['ekskd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


//detail ekstra
$qku = mysql_query("SELECT * FROM m_ekstra ".
					"WHERE kd = '$ekskd'");
$rku = mysql_fetch_assoc($qku);
$ku_ekstra = balikin($rku['ekstra']);


$judul = "Siswa Yang Ikut Ekstra : $ku_ekstra";







//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$siswa = nosql($_POST['siswa']);
	$ekskd = nosql($_POST['ekskd']);

	//nek null
	if (empty($siswa))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?ekskd=$ekskd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT siswa_kelas.kd AS skkd ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND m_siswa.nis = '$siswa'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_skkd = nosql($rcc['skkd']);

		//nek ada
		if ($tcc != 0)
			{
			//insert
			mysql_query("INSERT INTO siswa_ekstra(kd, kd_siswa_kelas, kd_ekstra) VALUES ".
							"('$x', '$cc_skkd', '$ekskd')");
							
			//re-direct
			$ke = "$filenya?ekskd=$ekskd";
			xloc($ke);
			exit();
			}
		else
			{					
			//re-direct
			$pesan = "Tidak Ada Siswa dengan NIS : $siswa. Silahkan Ganti Yang Lain...!!";
			$ke = "$filenya?ekskd=$ekskd";	
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admekstra.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">';


//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT DISTINCT(siswa_ekstra.kd_siswa_kelas) AS swkd ".
				"FROM siswa_ekstra, siswa_kelas, m_siswa ".
				"WHERE siswa_ekstra.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_ekstra.kd_ekstra = '$ekskd' ".
				"ORDER BY m_siswa.nis ASC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?ekskd=$ekskd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);





echo '<br>
[<a href="ekstra.php">DAFTAR EKSTRA LAINNYA</a>].
<br>
<p>
NIS : 
<br>
<input name="siswa" type="text" value="" size="10">
</p>
<p>
<input name="ekskd" type="hidden" value="'.$ekskd.'">
<input name="btnSMP" type="submit" value="TAMBAH >>">
</p>

<table width="100%" border="1" cellpadding="3" cellspacing="0">
<tr bgcolor="'.$warnaheader.'">
<td width="50"><strong>NIS</strong></td>
<td width="150"><strong>Nama</strong></td>
<td width="5"><strong>L/P</strong></td>
<td width="150"><strong>TTL.</strong></td>
<td width="150"><strong>Nama Orang Tua</strong></td>
<td><strong>Alamat Rumah</strong></td>
<td width="100"><strong>Asal Sekolah</strong></td>
<td width="100"><strong>Telp.</strong></td>
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

	$nomer = $nomer + 1;
	$i_kd = nosql($data['swkd']);



	//detail e
	$qdtx = mysql_query("SELECT m_siswa.*, siswa_kelas.* ".
				"FROM m_siswa, siswa_kelas ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd = '$i_kd'");
	$rdtx = mysql_fetch_assoc($qdtx);
	$nis = nosql($rdtx['nis']);
	$nama = balikin($rdtx['nama']);
	$kd_kelamin = nosql($rdtx['kd_kelamin']);
	$tmp_lahir = balikin2($rdtx['tmp_lahir']);
	$tgl_lahir = nosql($rdtx['tgl']);
	$bln_lahir = nosql($rdtx['bln']);
	$thn_lahir = nosql($rdtx['thn']);


	//kelamin
	$qmin = mysql_query("SELECT * FROM m_kelamin ".
							"WHERE kd = '$kd_kelamin'");
	$rmin = mysql_fetch_assoc($qmin);
	$min_kelamin = balikin2($rmin['kelamin']);


	//orang tua - ayah
	$qtun = mysql_query("SELECT * FROM m_siswa_ayah ".
							"WHERE kd_siswa = '$kd'");
	$rtun = mysql_fetch_assoc($qtun);
	$tun_nama = balikin2($rtun['nama']);
	$tun_alamat = balikin2($rtun['alamat']);
	$tun_telp = balikin2($rtun['telp']);


	//lulusan dari
	$qpend = mysql_query("SELECT * FROM m_siswa_pendidikan ".
							"WHERE kd_siswa = '$kd'");
	$rpend = mysql_fetch_assoc($qpend);
	$pend_lulusan = balikin2($rpend['lulusan']);


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td valign="top">
	'.$nis.' '.$kd.'
	</td>
	<td valign="top">
	'.$nama.'
	</td>
	<td valign="top">
	'.$min_kelamin.'
	</td>
	<td valign="top">
	'.$tmp_lahir.', '.$tgl_lahir.' '.$arrbln1[$bln_lahir].' '.$thn_lahir.'
	</td>
	<td valign="top">
	'.$tun_nama.'
	</td>
	<td valign="top">
	'.$tun_alamat.'
	</td>
	<td valign="top">
	'.$pend_lulusan.'
	</td>
	<td valign="top">
	'.$tun_telp.'
	</td>
	</tr>';
	}
while ($data = mysql_fetch_assoc($result));

echo '</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
</tr>
</table>';



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
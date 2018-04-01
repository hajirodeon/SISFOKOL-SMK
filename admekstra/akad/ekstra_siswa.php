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
$judulku = "[$ekstra_session : $nip35_session. $nm35_session] ==> $judul";
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






//jika simpan ekstra
if ($_POST['btnSMP3'])
	{
	//ambil nilai
	$ekskd = nosql($_POST['ekskd']);


	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$xkdt = "skkd";
		$xkdt1 = "$xkdt$i";
		$xkdtxx = nosql($_POST["$xkdt1"]);

		$xkst = "predikat_ekstra";
		$xkst1 = "$xkst$i";
		$xkstxx = nosql($_POST["$xkst1"]);

		$xket = "ket_ekstra";
		$xket1 = "$xket$i";
		$xketxx = cegah($_POST["$xket1"]);

		//update
		mysql_query("UPDATE siswa_ekstra SET predikat = '$xkstxx', ".
						"ket = '$xketxx' ".
						"WHERE kd_siswa_kelas = '$xkdtxx' ".
						"AND kd_ekstra = '$ekskd'");
		}


	//diskonek
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?ekskd=$ekskd";
	xloc($ke);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$ekskd = nosql($_POST['ekskd']);	
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM siswa_ekstra ".
						"WHERE kd_siswa_kelas = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?ekskd=$ekskd";
	xloc($ke);
	exit();
	}






//isi *START
ob_start();

//menu
require("../../inc/menu/admekstra.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();


//js
require("../../inc/js/checkall.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
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

<table width="600" border="1" cellpadding="3" cellspacing="0">
<tr bgcolor="'.$warnaheader.'">
<td width="1">&nbsp;</td>
<td width="50"><strong>NIS</strong></td>
<td width="150"><strong>Nama</strong></td>
<td width="50"><strong>Predikat</strong></td>
<td width="50"><strong>Keterangan</strong></td>
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

	$nomx = $nomx + 1;
	$i_kd = nosql($data['swkd']);



	//detail e
	$qdtx = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd = '$i_kd'");
	$rdtx = mysql_fetch_assoc($qdtx);
	$skkd = nosql($rdtx['skkd']);
	$nis = nosql($rdtx['nis']);
	$nama = balikin($rdtx['nama']);


	//ekstra
	$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
							"FROM siswa_ekstra, m_ekstra ".
							"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
							"AND siswa_ekstra.kd_siswa_kelas = '$skkd' ".
							"AND siswa_ekstra.kd_ekstra = '$ekskd'");
	$rkuti = mysql_fetch_assoc($qkuti);
	$tkuti = mysql_num_rows($qkuti);
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);




	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '
	<td valign="top">
	<input type="checkbox" name="item'.$nomx.'" value="'.$skkd.'">
	</td>
	<td valign="top">
	'.$nis.' '.$kd.'
	</td>
	<td valign="top">
	'.$nama.'
	</td>
	<td>
	<input name="skkd'.$nomx.'" type="hidden" value="'.$skkd.'">
	<select name="predikat_ekstra'.$nomx.'">
	<option value="'.$kuti_predikat.'" selected>'.$kuti_predikat.'</option>
	<option value="A">A</option>
	<option value="B">B</option>
	<option value="C">C</option>
	<option value="K">K</option>
	</select>
	</td>
	<td>
	<input name="ket_ekstra'.$nomx.'" type="text" size="30" value="'.$kuti_ket.'">
	</td>
	</tr>';
	}
while ($data = mysql_fetch_assoc($result));

echo '</table>
<table width="800" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<input name="jml" type="hidden" value="'.$count.'">
<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')">
<input name="btnBTL" type="reset" value="BATAL">
<input name="btnHPS" type="submit" value="HAPUS">
<input name="btnSMP3" type="submit" value="SIMPAN">
<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
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
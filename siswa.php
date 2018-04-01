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



//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require("inc/class/paging.php");
$tpl = LoadTpl("template/cp_depan.html");


nocache;

//nilai
$filenya = "siswa.php";
$filenya_ke = $filenya;

//judul
$judul = "Data Siswa";
$judulku = $judul;


$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek simpan polling
if ($_POST['btnPOL'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$v_opsi = nosql($_POST['v_opsi']);
	$ke = "$filenya?kd=$kd";

	//cek null
	if (empty($v_opsi))
		{
		//re-direct
		$pesan = "Opsi Polling Belum Ditentukan. Harap Diperhatikan...!!";
		pekem($pesan,$ke);
		exit();
		}

	//jika blm isi polling...
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM cp_polling");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//if...
		if ($v_opsi == "nopsi1")
			{
			$nil_opsi1x = 1;
			}
		else if ($v_opsi == "nopsi2")
			{
			$nil_opsi2x = 1;
			}
		else if ($v_opsi == "nopsi3")
			{
			$nil_opsi3x = 1;
			}
		else if ($v_opsi == "nopsi4")
			{
			$nil_opsi4x = 1;
			}
		else if ($v_opsi == "nopsi5")
			{
			$nil_opsi5x = 1;
			}


		//nilai
		$nil_opsi1 = (nosql($rcc['nil_opsi1']))+$nil_opsi1x;
		$nil_opsi2 = (nosql($rcc['nil_opsi2']))+$nil_opsi2x;
		$nil_opsi3 = (nosql($rcc['nil_opsi3']))+$nil_opsi3x;
		$nil_opsi4 = (nosql($rcc['nil_opsi4']))+$nil_opsi4x;
		$nil_opsi5 = (nosql($rcc['nil_opsi5']))+$nil_opsi5x;


		//update
		mysql_query("UPDATE cp_polling SET nil_opsi1 = '$nil_opsi1', ".
						"nil_opsi2 = '$nil_opsi2', ".
						"nil_opsi3 = '$nil_opsi3', ".
						"nil_opsi4 = '$nil_opsi4', ".
						"nil_opsi5 = '$nil_opsi5'");
		}

	//re-direct
	xloc($ke);
	exit();
	}






//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("inc/menu/cp_menu.php");

//isi
$isi_banner = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();


require("inc/js/jumpmenu.js");
require("inc/js/swap.js");
require("inc/js/checkall.js");
require("inc/js/number.js");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx"><table border="0" width="1290" cellspacing="0" cellpadding="5">
<tr valign="top">
<td bgcolor="white">
<a href="'.$sumber.'"><img src="'.$sumber.'/img/home-link.png" height="16"></a> > '.$judulku.'
<hr>
</td>
</tr>
</table> 
<table border="0" width="1290" cellspacing="0" cellpadding="5">
<tr valign="top">
<td width="1">
</td>

<td bgcolor="white">
<h1>
Data Siswa
</h1>


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
$btxkelas = balikin($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd <> '$kelkd' ".
						"ORDER BY no ASC, ".
						"kelas ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
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
	//query DATA
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$kelkd = nosql($_REQUEST['kelkd']);



	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
					"m_siswa.kd AS mskd, ".
					"siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"ORDER BY m_siswa.nis ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	//nek ada
	if ($count != 0)
		{
		echo '<table width="100%" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td width="150"><strong>Nama</strong></td>
		<td width="5"><strong>L/P</strong></td>
		<td width="150"><strong>Nama Orang Tua</strong></td>
		<td width="100"><strong>Asal Sekolah</strong></td>
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

			$kd = nosql($data['mskd']);
			$nis = nosql($data['nis']);
			$i_userx = nosql($data['usernamex']);
			$i_passx = nosql($data['passwordx']);
			$nama = balikin($data['nama']);
			$kd_kelamin = nosql($data['kd_kelamin']);
			$tmp_lahir = balikin2($data['tmp_lahir']);
			$tgl_lahir = nosql($data['tgl']);
			$bln_lahir = nosql($data['bln']);
			$thn_lahir = nosql($data['thn']);


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
			$tun_telp = balikin2($rtun['telp']);


			//alamat
			$qtun2 = mysql_query("SELECT * FROM m_siswa_tmp_tinggal ".
						"WHERE kd_siswa = '$kd'");
			$rtun2 = mysql_fetch_assoc($qtun2);
			$tun2_alamat = balikin2($rtun2['alamat']);


			//lulusan dari
			$qpend = mysql_query("SELECT * FROM m_siswa_pendidikan ".
									"WHERE kd_siswa = '$kd'");
			$rpend = mysql_fetch_assoc($qpend);
			$pend_lulusan = balikin2($rpend['lulusan']);




			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">
			'.$nis.'
			</td>
			<td valign="top">
			'.$nama.'
			</td>
			<td valign="top">
			'.$min_kelamin.'
			</td>
			<td valign="top">
			'.$tun_nama.'
			</td>
			<td valign="top">
			'.$pend_lulusan.'
			</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="total" type="hidden" value="'.$count.'">
		</td>
		<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
		</tr>
		</table>';
		}
	}


echo '</td>

<td width="208">


<p>
<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="208" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::BERITA</b>
</font>
</td>
</tr>
</table>';


//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '1' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="100%" border="0" cellspacing="3" cellpadding="3">';


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
		$nomer = $nomer + 1;
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];

		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	&nbsp;
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>

</table>
<br>

<p>
<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::GALERI FOTO</b>
</font>
</td>
</tr>
</table>';


//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '7' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$nomer = $nomer + 1;
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>
</table>
</p>
<br>





<p>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::AGENDA</b>
</font>
</td>
</tr>
</table>';


//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '2' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$nomer = $nomer + 1;
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>

</table>
</p>
<br>


<p>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::MAKALAH</b>
</font>
</td>
</tr>
</table>';



//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '3' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$nomer = $nomer + 1;
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>
</table>
</p>
<br>





<p>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::MATERI AJAR</b>
</font>
</td>
</tr>
</table>';


//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '5' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$nomer = $nomer + 1;
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	&nbsp;
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '
</td>
</tr>
</table>
</p>
<br>





<p>
<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::INFO SEKOLAH</b>
</font>
</td>
</tr>
</table>';



//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '6' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$nomer = $nomer + 1;
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	&nbsp;
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>

</table>
</p>
<br>





<p>
<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::JEJAK PENDAPAT</b>
</font>
</td>
</tr>
</table>';



//polling ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qcc = mysql_query("SELECT * FROM cp_polling");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);
$cc_topik = balikin($rcc['topik']);
$cc_opsi1 = balikin($rcc['opsi1']);
$cc_opsi2 = balikin($rcc['opsi2']);
$cc_opsi3 = balikin($rcc['opsi3']);
$cc_opsi4 = balikin($rcc['opsi4']);
$cc_opsi5 = balikin($rcc['opsi5']);
$cc_nil_opsi1 = nosql($rcc['nil_opsi1']);
$cc_nil_opsi2 = nosql($rcc['nil_opsi2']);
$cc_nil_opsi3 = nosql($rcc['nil_opsi3']);
$cc_nil_opsi4 = nosql($rcc['nil_opsi4']);
$cc_nil_opsi5 = nosql($rcc['nil_opsi5']);
$cc_total = round($cc_nil_opsi1 + $cc_nil_opsi2 + $cc_nil_opsi3 + $cc_nil_opsi4 + $cc_nil_opsi5);

//jika nol
if ((empty($cc_nil_opsi1)) AND (empty($cc_nil_opsi2)) AND (empty($cc_nil_opsi3)) AND (empty($cc_nil_opsi4))
	AND (empty($cc_nil_opsi5)))
	{
	$cc_nil_opsi1 = 1;
	$cc_nil_opsi2 = 1;
	$cc_nil_opsi3 = 1;
	$cc_nil_opsi4 = 1;
	$cc_nil_opsi5 = 1;
	}



//jika ada
if ($tcc != 0)
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="200">
	<strong>'.$cc_topik.'</strong>
	<br>
	<br>

	<ul>

	<input name="v_opsi" type="radio" value="nopsi1">
	<strong>'.$cc_opsi1.'</strong>
	<br>
	<br>


	<input name="v_opsi" type="radio" value="nopsi2">
	<strong>'.$cc_opsi2.'</strong>
	<br>
	<br>


	<input name="v_opsi" type="radio" value="nopsi3">
	<strong>'.$cc_opsi3.'</strong>
	<br>
	<br>


	<input name="v_opsi" type="radio" value="nopsi4">
	<strong>'.$cc_opsi4.'</strong>
	<br>
	<br>


	<input name="v_opsi" type="radio" value="nopsi5">
	<strong>'.$cc_opsi5.'</strong>
	<br>
	<br>

	</ul>

	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kd.'">
	<input name="btnPOL" type="submit" value="Vote">
	[Total : <strong>'.$cc_total.'</strong> vote].
	</td>
	</tr>
	</table>';
	}

//tidak ada
else
	{
	echo '<font color="blue">
	<strong>
	Belum Ada Data Polling.
	</strong>
	</font>';
	}
//polling ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



echo '</td>
</tr>
</table>
</p>
<br>






</td>

</tr>
</table>




</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>

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
$filenya = "halaman.php";
$kd = nosql($_REQUEST['kd']);
$kdx = $kd;
$filenya_ke = "$sumber?kd=$kd";



//detail
$qku = mysql_query("SELECT cp_artikel.*, cp_m_kategori.nama AS katnama ".
					"FROM cp_artikel, cp_m_kategori ".
					"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
					"AND cp_artikel.kd = '$kd'");
$rku = mysql_fetch_assoc($qku);
$ku_katkd = nosql($rku['kd_kategori']);
$ku_katnama = balikin($rku['katnama']);
$ku_judul2 = balikin($rku['judul']);
$ku_isi = balikin($rku['isi']);
$ku_postdate = $rku['postdate'];

//pecah titik - titik
$ku_isi2 = pathasli1($ku_isi);



//judul
$judul = "Halaman : $ku_judul2";
$judulku = $judul;




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





//nek simpan komentar
if ($_POST['btnKRM'])
	{
	//nilai
	$kd = nosql($_POST['kd']);
	$e_nama = cegah($_POST['e_nama']);
	$e_alamat = cegah($_POST['e_alamat']);
	$e_email = cegah($_POST['e_email']);
	$e_isi = cegah($_POST['e_isi']);

	//cek null
	if (empty($e_nama))
		{
		//re-direct
		$pesan = "Entri Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?kd=$kd";
		pekem($pesan,$ke);
		exit();
		}

	else
		{
		//insert
		mysql_query("INSERT INTO cp_artikel_komentar (kd, kd_artikel, nama, alamat, email, isi, postdate) VALUES ".
						"('$x', '$kd', '$e_nama', '$e_alamat', '$e_email', '$e_isi', '$today')");
		
		//re-direct
		$pesan = "Terima Kasih. ";
		$ke = "$filenya?kd=$kd";
		pekem($pesan,$ke);
		exit();
		
		}
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


require("inc/js/wz_jsgraphics.js");
require("inc/js/pie.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table border="0" width="1290" cellspacing="0" cellpadding="5">
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
<p>
<h1>
'.$ku_judul2.'
</h1>
<i>
Dikirim : <b>'.$ku_postdate.'</b>
</i>
<br>

<p>
'.$ku_isi2.'
</p>

<br>
<br>

[<a href="halaman_print.php?kd='.$kdx.'" target="_blank"><img src="'.$sumber.'/img/print.gif" width="16" height="16" alt="Print"></a>]. 

[<a href="halaman_pdf.php?kd='.$kdx.'" target="_blank"><img src="'.$sumber.'/img/pdf.gif" width="16" height="16" alt="Print"></a>].


<hr>
<div id="share-buttons">
 
<!-- Facebook -->
<a href="http://www.facebook.com/sharer.php?u='.$sumber.'" target="_blank"><img src="'.$sumber.'/img/socialmedia/facebook.png" width="32" height="32" alt="Facebook" /></a>
 
<!-- Twitter -->
<a href="http://twitter.com/share?url='.$sumber.'&text='.$sumber.'" target="_blank"><img src="'.$sumber.'/img/socialmedia/twitter.png" width="32" height="32" alt="Twitter" /></a>
 
<!-- Google+ -->
<a href="https://plus.google.com/share?url='.$sumber.'" target="_blank"><img src="'.$sumber.'/img/socialmedia/google.png" width="32" height="32" alt="Google" /></a>
</div>
<hr>


<br>
<br>
<br>

<hr>


<p>
<big>
<b>
Komentar Anda :
</b>
</big>
</p>

<p>
Nama :
<br>
<input name="e_nama" id="e_nama" type="text" value="" size="30">
</p>
<p>
ALamat :
<br>
<input name="e_alamat" id="e_alamat" type="text" value="" size="50">
</p>
<p>
E-Mail :
<br>
<input name="e_email" id="e_email" type="text" value="" size="30">
</p>
<p>
Isi Komentar  :
<br>
<textarea id="e_komentar" name="e_komentar" rows="10" cols="70"></textarea>
</p>

<p>
<input name="kd" id="kd" type="hidden" value="'.$kd.'">
<button name="btnKRM" id="btnKRM" type="submit" value="KIRIM" class="search_btn"><img src="'.$sumber.'/img/save.png" alt="kirim">KIRIM</button>
</p>
<hr>';


//query
$qku2 = mysql_query("SELECT cp_artikel_komentar.* ".
						"FROM cp_artikel_komentar ".
						"WHERE cp_artikel_komentar.kd_artikel = '$kd'");
$rku2 = mysql_fetch_assoc($qku2);
$tku2 = mysql_num_rows($qku2);

if ($qku2 != 0)
	{
	//view data
	echo '<table width="100%" border="0" cellspacing="3" cellpadding="3">';


	do
		{
		//nilai
		$nomer = $nomer + 1;
		$i_kd = nosql($rku2['kd']);
		$i_nama = balikin($rku2['nama']);
		$i_alamat = balikin($rku2['alamat']);
		$i_email = balikin($rku2['email']);
		$i_isi = balikin($rku2['isi']);
		$i_postdate = $rku2['postdate'];


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$i_isi.'
		<br>
		<i>
		['.$i_nama.']. ['.$i_alamat.']. ['.$i_email.']. ['.$i_postdate.'].
		</i>
		</td>
		</tr>';
		}
	while ($rku2 = mysql_fetch_assoc($qku2));

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

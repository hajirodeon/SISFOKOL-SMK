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
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "guru.php";
$judul = "Guru";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&keakd=$keakd&kompkd=$kompkd&page=$page";





//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($keakd))
	{
	$diload = "document.formx.keahlian.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.kompetensi.focus();";
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($ke);
	exit();
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	$tapelkd = nosql($_POST['tapelkd']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$singk = nosql($_POST['singk']);
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kdix = nosql($_POST["$yuhu"]);



		//del
		mysql_query("DELETE FROM m_guru ".
				"WHERE kd_tapel = '$tapelkd' ".
				"AND kd_keahlian = '$keakd' ".
				"AND kd_keahlian_kompetensi = '$kompkd' ".
				"AND kd_pegawai = '$kdix'");
		}

	//re-direct
	xloc($ke);
	exit();
	}



//jika tambah
if ($_POST['btnTBH'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$singk = nosql($_POST['singk']);
	$pegawai = nosql($_POST['pegawai']);


	//nek nul
	if (empty($pegawai))
		{
		//re-direct
		$pesan = "Pegawai untuk dijadikan Guru, Belum Dipilih. Harap Diperhatikan...!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//daftar kelas
		$qbt = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kelas LIKE '%$singk%' ".
					"ORDER BY round(no) ASC, ".
					"kelas ASC");
		$rowbt = mysql_fetch_assoc($qbt);
	
		do
			{
			$btkd = nosql($rowbt['kd']);
			$btkelas = balikin($rowbt['kelas']);
			$xyz = md5("$x$btkd");


			//deteksi
			$qcc = mysqL_query("SELECT m_guru.*, m_pegawai.* ".
						"FROM m_guru, m_pegawai ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_guru.kd_pegawai = '$pegawai' ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"AND m_guru.kd_keahlian = '$keakd' ".
						"AND m_guru.kd_keahlian_kompetensi = '$kompkd' ".
						"AND m_guru.kd_kelas = '$btkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);


			//nek iya
			if ($tcc != 0)
				{
				//cuekin aja...

				}
			else
				{
				//query
				mysql_query("INSERT INTO m_guru(kd, kd_tapel, kd_keahlian, kd_keahlian_kompetensi, ".
						"kd_kelas, kd_pegawai) VALUES ".
						"('$xyz', '$tapelkd', '$keakd', '$kompkd', ".
						"'$btkd', '$pegawai')");
				}
			}
		while ($rowbt = mysql_fetch_assoc($qbt));



		//re-direct
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//menu
require("../../inc/menu/admwaka.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
xheadline($judul);

echo '<form name="formx" method="post" action="'.$filenya.'">
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

Program Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
						"WHERE kd = '$keakd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['program']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keakd' ".
			"ORDER BY program ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>,



Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd = '$kompkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['kompetensi']);
$keax_singk = nosql($rowkeax['singkatan']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['kompetensi']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>
</td>
</tr>
</table>
<br>';


//nek blm
if (empty($tapelkd))
	{
	echo '<h4>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</h4>';
	}
else if (empty($keakd))
	{
	echo '<h4>
	<strong><font color="#FF0000">PROGRAM KEAHLIAN Belum Dipilih...!</font></strong>
	</h4>';
	}
else if (empty($kompkd))
	{
	echo '<h4>
	<strong><font color="#FF0000">KOMPETENSI KEAHLIAN Belum Dipilih...!</font></strong>
	</h4>';
	}
else
	{
	//penambahan
	echo '<select name="pegawai">
	<option value="" selected>-Pegawai-</option>';

	//data pegawai
	$qpeg = mysql_query("SELECT * FROM m_pegawai ".
				"ORDER BY nama ASC");
	$rpeg = mysql_fetch_assoc($qpeg);

	do
		{
		$peg_kd = nosql($rpeg['kd']);
		$peg_nip = nosql($rpeg['nip']);
		$peg_nm = balikin($rpeg['nama']);

		echo '<option value="'.$peg_kd.'">'.$peg_nip.'. '.$peg_nm.'</option>';
		}
	while ($rpeg = mysql_fetch_assoc($qpeg));


	echo '</select>
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="keakd" type="hidden" value="'.$keakd.'">
	<input name="kompkd" type="hidden" value="'.$kompkd.'">
	<input name="singk" type="hidden" value="'.$keax_singk.'">
	<input name="btnTBH" type="submit" value="Tambah >>">';


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT DISTINCT(m_pegawai.kd) AS mpkd  ".
			"FROM m_guru, m_pegawai ".
			"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
			"AND m_guru.kd_tapel = '$tapelkd' ".
			"AND m_guru.kd_keahlian = '$keakd' ".
			"AND m_guru.kd_keahlian_kompetensi = '$kompkd' ".
			"ORDER BY round(m_pegawai.nip) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = $ke;
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	if ($count != 0)
		{
		//detail
		echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="100"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
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
			$nomer = $nomer + 1;
			$mpkd = nosql($data['mpkd']);


			//detail e
			$qku = mysql_query("SELECT nip, nama FROM m_pegawai ".
						"WHERE kd = '$mpkd'");
			$rku = mysql_fetch_assoc($qku);
			$nip = nosql($rku['nip']);
			$nama = balikin($rku['nama']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$mpkd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$mpkd.'">
	        	</td>
			<td>'.$nip.'</td>
			<td>'.$nama.'</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="600" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="250">
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">
		<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
		</td>
		</tr>
		</table>';
		}
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");
?>
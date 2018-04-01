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
require("../../inc/cek/admlab.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "prog_pddkn_kelas.php";
$judul = "Mata Pelajaran Per Kelas";
$judulku = "[$lab_session : $nip14_session. $nm14_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$tkd = nosql($_REQUEST['tkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$singkatan = nosql($_REQUEST['singkatan']);
$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&singkatan=$singkatan&tkd=$tkd&jnskd=$jnskd";



//focus...
if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}
else if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($tkd))
	{
	$diload = "document.formx.kelas.focus();";
	}







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$tkd = nosql($_POST['tkd']);
	$jnskd = nosql($_POST['jnskd']);
	$singkatan = nosql($_POST['singkatan']);
	$progdik = nosql($_POST['progdik']);
	$kkm = nosql($_POST['kkm']);

	//jika null
	if (empty($progdik))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&singkatan=$singkatan&keahkd=$keahkd&kompkd=$kompkd&tkd=$tkd&jnskd=$jnskd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//looping kelas
		$qdt = mysql_query("SELECT * FROM m_kelas ".
					"WHERE no = '$tkd' ".
					"AND kelas LIKE '%$singkatan%' ".
					"ORDER BY kelas ASC");
		$rdt = mysql_fetch_assoc($qdt);

		do
			{
			//kelas e
			$i_nomer = $i_nomer + 1;
			$xyz = md5("$x$i_nomer");
			$dt_kd = nosql($rdt['kd']);


			//cek
			$qcc = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn.* ".
						"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$dt_kd' ".
						"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$progdik'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$pel = balikin2($rcc['prog_pddkn']);

			//not null
			if ($tcc != 0)
				{
				//cuekin aja...
				}
			else
				{
				//query
				mysql_query("INSERT INTO m_prog_pddkn_kelas(kd, kd_tapel, kd_keahlian, kd_keahlian_kompetensi, ".
						"kd_kelas, kd_prog_pddkn, kkm) VALUES ".
						"('$xyz', '$tapelkd', '$keahkd', '$kompkd', ".
						"'$dt_kd', '$progdik', '$kkm')");
				}
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}






//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$tapelkd = nosql($_POST['tapelkd']);
	$singkatan = nosql($_POST['singkatan']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$tkd = nosql($_POST['tkd']);
	$jnskd = nosql($_POST['jnskd']);



	//looping kelas
	$qdt = mysql_query("SELECT * FROM m_kelas ".
				"WHERE no = '$tkd' ".
				"AND kelas LIKE '%$singkatan%' ".
				"ORDER BY kelas ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//kelas e
		$dt_kd = nosql($rdt['kd']);


		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kd = nosql($_POST["$yuhu"]);

			//del
			mysql_query("DELETE FROM m_prog_pddkn_kelas ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_keahlian = '$keahkd' ".
					"AND kd_keahlian_kompetensi = '$kompkd' ".
					"AND kd_kelas = '$dt_kd' ".
					"AND kd_prog_pddkn = '$kd'");
			}
		}
	while ($rdt = mysql_fetch_assoc($qdt));



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}






//jika simpan kkm
if ($_POST['btnSMP2'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$tapelkd = nosql($_POST['tapelkd']);
	$singkatan = nosql($_POST['singkatan']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$tkd = nosql($_POST['tkd']);
	$jnskd = nosql($_POST['jnskd']);



	//looping kelas
	$qdt = mysql_query("SELECT * FROM m_kelas ".
				"WHERE no = '$tkd' ".
				"AND kelas LIKE '%$singkatan%' ".
				"ORDER BY kelas ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//kelas e
		$dt_kd = nosql($rdt['kd']);


		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "i_kd";
			$yuhu = "$yuk$i";
			$kdku = nosql($_POST["$yuhu"]);

			$yuk2 = "i_kkm";
			$yuhu2 = "$yuk2$i";
			$kkmku = nosql($_POST["$yuhu2"]);

			//update
			mysql_query("UPDATE m_prog_pddkn_kelas SET kkm = '$kkmku' ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_keahlian = '$keahkd' ".
					"AND kd_keahlian_kompetensi = '$kompkd' ".
					"AND kd_kelas = '$dt_kd' ".
					"AND kd_prog_pddkn = '$kdku'");
			}
		}
	while ($rdt = mysql_fetch_assoc($qdt));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//menu
require("../../inc/menu/admlab.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Kompetensi Keahlian : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keahkd' ".
			"AND kd = '$kompkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkomp = balikin($rowbtx['kompetensi']);

echo '<strong>'.$btxkomp.'</strong>
</td>
</tr>
</table>

<table bgcolor="'.$warna01.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Jenis : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"WHERE kd = '$jnskd'");
$rowjnx = mysql_fetch_assoc($qjnx);

$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['jenis']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"WHERE kd <> '$jnskd' ".
			"ORDER BY jenis ASC");
$rowjn = mysql_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['jenis']);

	echo '<option value="'.$filenya.'?keahkd='.$keahkd.'&kompkd='.$kompkd.'&singkatan='.$singkatan.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>,



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

	echo '<option value="'.$filenya.'?keahkd='.$keahkd.'&kompkd='.$kompkd.'&singkatan='.$singkatan.'&jnskd='.$jnskd.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,




Tingkat : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$tkd.'">-'.$arrrkelas[$tkd].'-</option>';

for ($k=1;$k<=3;$k++)
	{
	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&singkatan='.$singkatan.'&jnskd='.$jnskd.'&tkd='.$k.'">'.$arrrkelas[$k].'</option>';
	}
while ($rowkel = mysql_fetch_assoc($qkel));

echo '</select>



<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="keahkd" type="hidden" value="'.$keahkd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
<input name="tkd" type="hidden" value="'.$tkd.'">
<input name="jnskd" type="hidden" value="'.$jnskd.'">
<input name="singkatan" type="hidden" value="'.$singkatan.'">
</td>
</tr>
</table>
<br>';


//nek blm
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($tkd))
	{
	echo '<p>
	<strong><font color="#FF0000">KELAS Belum Dipilih...!</font></strong>
	</p>';
	}

else if (empty($jnskd))
	{
	echo '<p>
	<strong><font color="#FF0000">JENIS STANDAR KOMPETENSI Belum Dipilih...!</font></strong>
	</p>';
	}

else
	{
	//query
	$q = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS mpkd ".
				"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
				"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_prog_pddkn.kd_jenis= '$jnskd' ".
				"AND m_kelas.no = '$tkd' ".
				"ORDER BY round(m_prog_pddkn.no) ASC, ".
				"round(m_prog_pddkn.no_sub) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	echo '<select name="progdik">
	<option value="" selected>-TAMBAH STANDAR KOMPETENSI-</option>';

	//prog_pddkn
	$qsp = mysql_query("SELECT * FROM m_prog_pddkn ".
				"WHERE kd_jenis = '$jnskd' ".
				"AND kd_keahlian = '$keahkd' ".
				"AND kd_keahlian_kompetensi = '$kompkd' ".
				"ORDER BY prog_pddkn ASC");
	$rowsp = mysql_fetch_assoc($qsp);

	do
		{
		$spkd = nosql($rowsp['kd']);
		$spaspek = balikin2($rowsp['prog_pddkn']);

		echo '<option value="'.$spkd.'">'.$spaspek.'</option>';
	        }
	while ($rowsp = mysql_fetch_assoc($qsp));

	echo '</select>,

	KKM : <INPUT type="text" name="kkm" size="5">
	<input name="btnSMP" type="submit" value="&gt;&gt;&gt;">
	<table width="500" border="1" cellpadding="3" cellspacing="0">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td>&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">Nama Standar Kompetensi</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
    	</tr>';

	if ($total != 0)
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

			$nomer = $nomer + 1;
			$mpkd = nosql($row['mpkd']);


			//detail e
			$qdti = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS pkd, ".
						"m_prog_pddkn.* ".
						"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND m_prog_pddkn.kd_jenis = '$jnskd' ".
						"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$mpkd'");
			$rdti = mysql_fetch_assoc($qdti);
			$dti_pel = balikin($rdti['prog_pddkn']);
			$dti_kkm = nosql($rdti['kkm']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td width="20">
			<INPUT type="hidden" name="i_kd'.$nomer.'" value="'.$mpkd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$mpkd.'">
			</td>
			<td>'.$dti_pel.'</td>
			<td>
			<INPUT type="text" name="i_kkm'.$nomer.'" value="'.$dti_kkm.'" size="5">
			</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));
		}

	echo '</table>
	<table width="500" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="326">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	<input name="btnSMP2" type="submit" value="SIMPAN">
	<input name="jml" type="hidden" value="'.$total.'">
	</td>
	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
	</tr>
	</table>';
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


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>

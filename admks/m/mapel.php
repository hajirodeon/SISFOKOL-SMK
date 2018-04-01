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
require("../../inc/cek/admks.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "mapel.php";
$judul = "Mata Pelajaran";
$judulku = "[$ks_session : $nip4_session.$nm4_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$progkd = nosql($_REQUEST['progkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$jnskd = nosql($_REQUEST['jnskd']);



//focus
if (empty($progkd))
	{
	$diload = "document.formx.program.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.kompetensi.focus();";
	}
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}
else
	{
	$diload = "document.formx.no.focus();";
	}







//isi *START
ob_start();

//menu
require("../../inc/menu/admks.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();



//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Program Keahlian : ';
echo "<select name=\"program\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$progkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_program = balikin($rowtpx['program']);

echo '<option value="'.$tpx_kd.'">--'.$tpx_program.'--</option>';

$qtp = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$progkd' ".
			"ORDER BY program ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tp_kd = nosql($rowtp['kd']);
	$tp_program = balikin($rowtp['program']);

	echo '<option value="'.$filenya.'?progkd='.$tp_kd.'">'.$tp_program.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,


Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd = '$kompkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_kompetensi = balikin($rowtpx['kompetensi']);

echo '<option value="'.$tpx_kd.'">--'.$tpx_kompetensi.'--</option>';

$qtp = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$progkd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tp_kd = nosql($rowtp['kd']);
	$tp_kompetensi = balikin($rowtp['kompetensi']);

	echo '<option value="'.$filenya.'?progkd='.$progkd.'&kompkd='.$tp_kd.'">'.$tp_kompetensi.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Jenis Mata Pelajaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
				"WHERE kd = '$jnskd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_jenis = balikin($rowtpx['jenis']);

echo '<option value="'.$tpx_kd.'">'.$tpx_jenis.'</option>';

$qtp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"WHERE kd <> '$jnskd' ".
			"ORDER BY jenis ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tp_kd = nosql($rowtp['kd']);
	$tp_jns = balikin($rowtp['jenis']);

	echo '<option value="'.$filenya.'?progkd='.$progkd.'&kompkd='.$kompkd.'&jnskd='.$tp_kd.'">'.$tp_jns.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';


//nek blm
if (empty($progkd))
	{
	echo '<p>
	<strong><font color="#FF0000">PROGRAM KEAHLIAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($kompkd))
	{
	echo '<p>
	<strong><font color="#FF0000">KOMPETENSI KEAHLIAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($jnskd))
	{
	echo '<p>
	<strong><font color="#FF0000">JENIS MATA PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	//query
	$q = mysql_query("SELECT * FROM m_prog_pddkn ".
				"WHERE kd_keahlian = '$progkd' ".
				"AND kd_keahlian_kompetensi = '$kompkd' ".
				"AND kd_jenis = '$jnskd' ".
				"ORDER BY round(no) ASC, ".
				"round(no_sub) ASC, ".
				"round(no_sub2) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	echo '<p>
	<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="10"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Singkatan</font></strong></td>
	</tr>';

	if ($total != 0)
		{
		do {
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
			$kd = nosql($row['kd']);
			$no = nosql($row['no']);
			$no_sub = nosql($row['no_sub']);
			$no_sub2 = nosql($row['no_sub2']);
			$pel = balikin($row['prog_pddkn']);
			$xpel = balikin($row['xpel']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$nomer.'</td>
			<td>'.$pel.'</td>
			<td>'.$xpel.'</td>
	        	</tr>';
			}
		while ($row = mysql_fetch_assoc($q));
		}

	echo '</table>
	<table width="600" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
	</tr>
	</table>
	</p>';
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
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
require("../../inc/cek/admqmr.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "mapel_kelas.php";
$judul = "Mata Pelajaran Per Kelas";
$judulku = "[$qmr_session : $nip19_session.$nm19_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$tkd = nosql($_REQUEST['tkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$singkatan = nosql($_REQUEST['singkatan']);
$ke = "$filenya?tapelkd=$tapelkd&keakd=$keakd&kompkd=$kompkd&singkatan=$singkatan&tkd=$tkd&jnskd=$jnskd";



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
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}
else if (empty($tkd))
	{
	$diload = "document.formx.kelas.focus();";
	}






//isi *START
ob_start();

//menu
require("../../inc/menu/admqmr.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
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
$qbtx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keakd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxpro = balikin($rowbtx['program']);

echo '<option value="'.$btxkd.'">'.$btxpro.'</option>';

//keahlian
$qbt = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keakd' ".
			"ORDER BY program ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btpro = balikin($rowbt['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$btkd.'">'.$btpro.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,



Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd = '$kompkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkomp = balikin($rowbtx['kompetensi']);

echo '<option value="'.$btxkd.'">'.$btxkomp.'</option>';

//keahlian
$qbt = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd <> '$keakd' ".
			"ORDER BY kompetensi ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btpro = balikin($rowbt['kompetensi']);
	$btsingk = balikin($rowbt['singkatan']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$btkd.'&singkatan='.$btsingk.'">'.$btpro.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kompkd.'&singkatan='.$singkatan.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>,


Tingkat : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$tkd.'">-'.$arrrkelas[$tkd].'-</option>';

for ($k=1;$k<=3;$k++)
	{
	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kompkd.'&singkatan='.$singkatan.'&jnskd='.$jnskd.'&tkd='.$k.'">'.$arrrkelas[$k].'</option>';
	}
while ($rowkel = mysql_fetch_assoc($qkel));

echo '</select>



<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="keakd" type="hidden" value="'.$keakd.'">
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

else if (empty($keakd))
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
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keakd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_kelas.no = '$tkd' ".
				"ORDER BY round(m_prog_pddkn.no) ASC, ".
				"round(m_prog_pddkn.no_sub) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	echo '<table width="500" border="1" cellpadding="3" cellspacing="0">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="10"><strong><font color="'.$warnatext.'">No.</font></strong></td>
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
			$qdti = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn.* ".
						"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keakd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$mpkd'");
			$rdti = mysql_fetch_assoc($qdti);
			$dti_pel = balikin($rdti['prog_pddkn']);
			$dti_kkm = nosql($rdti['kkm']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			'.$nomer.'
			</td>
			<td>'.$dti_pel.'</td>
			<td>
			'.$dti_kkm.'
			</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));
		}

	echo '</table>
	<table width="500" border="0" cellspacing="0" cellpadding="3">
	<tr>
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
<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pel.php";
$judul = "Jadwal Pelajaran per Kelas";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$s = nosql($_REQUEST['s']);






//focus
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek baru
if ($_POST['btnBR'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "pel_entry.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}




//nek null-kan
if ($_POST['btnNUL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);

	//query
	mysql_query("DELETE FROM jadwal ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_kelas = '$kelkd'");

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}





//nek hapus
if ($s == "hapus")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$smtkd = nosql($_REQUEST['smtkd']);
	$kelkd = nosql($_REQUEST['kelkd']);
	$kd = nosql($_REQUEST['kd']);

	//query
	mysql_query("DELETE FROM jadwal ".
					"WHERE kd = '$kd'");

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd";
	xloc($ke);
	exit();
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
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" bgcolor="'.$warnaover.'" cellspacing="0" cellpadding="3">
<tr valign="top">
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

Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qsmtx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowsmtx = mysql_fetch_assoc($qsmtx);
$smtx_kd = nosql($rowsmtx['kd']);
$smtx_smt = nosql($rowsmtx['smt']);

echo '<option value="'.$smtx_kd.'">'.$smtx_smt.'</option>';

$qsmt = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowsmt = mysql_fetch_assoc($qsmt);

do
	{
	$smt_kd = nosql($rowsmt['kd']);
	$smt_smt = nosql($rowsmt['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$smt_kd.'">'.$smt_smt.'</option>';
	}
while ($rowsmt = mysql_fetch_assoc($qsmt));

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
						"ORDER BY no ASC, ".
						"kelas ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
</td>
</tr>
</table>
<br>';

//cek
if (empty($tapelkd))
	{
	echo '<h4>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</h4>';
	}
else if (empty($smtkd))
	{
	echo '<h4>
	<strong><font color="#FF0000">SEMESTER Belum Dipilih...!</font></strong>
	</h4>';
	}
else if (empty($kelkd))
	{
	echo '<h4>
	<strong><font color="#FF0000">KELAS Belum Dipilih...!</font></strong>
	</h4>';
	}
else
	{
	echo '<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="smtkd" type="hidden" value="'.$smtkd.'">
	<input name="kelkd" type="hidden" value="'.$kelkd.'">
	<input name="btnBR" type="submit" value="BARU">
	<input name="btnNUL" type="submit" value="KOSONGKAN">

	[<a href="pel_xls.php?tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&kelkd='.$kelkd.'" title="Print . . ."><img src="'.$sumber.'/img/xls.gif" width="16" height="16" border="0"></a>].

	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="10">
	<b>No. Urut</b>
	</td>';

	//hari
	$qhri = mysql_query("SELECT * FROM m_hari ".
							"ORDER BY round(no) ASC");
	$rhri = mysql_fetch_assoc($qhri);

	do
		{
		$hri_kd = nosql($rhri['kd']);
		$hri_hr = balikin($rhri['hari']);

		echo '<td><strong>'.$hri_hr.'</strong></td>';
		}
	while ($rhri = mysql_fetch_assoc($qhri));

	echo '</tr>';



	for ($k=1;$k<=12;$k++)
		{
		//nilai
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


		//hari
		$qhri = mysql_query("SELECT * FROM m_hari ".
								"ORDER BY round(no) ASC");
		$rhri = mysql_fetch_assoc($qhri);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td><strong>'.$k.'.</strong></td>';

		do
			{
			$hri_kd = nosql($rhri['kd']);
			$hri_hr = balikin($rhri['hari']);




			//datane waktu
			$qdte = mysql_query("SELECT * FROM m_waktu ".
									"WHERE no_urut = '$k' ".
									"AND kd_hari = '$hri_kd'");
			$rdte = mysql_fetch_assoc($qdte);
			$tdte = mysql_num_rows($qdte);
			$dte_jkd = balikin($rdte['kd_jam']);
			$dte_waktu = balikin($rdte['waktu']);
			$dte_ket = balikin($rdte['ket']);



			
			//jika ada, ket
			if (!empty($dte_ket))
				{
				echo '<td bgcolor="red">
				<b>'.$dte_waktu.'</b>
				<br>
				'.$dte_ket.'
				</td>';
				}
			else
				{
				//munculkan mapel gurunya...
				//datane...
				$qdte2 = mysql_query("SELECT jadwal.*, jadwal.kd AS jdkd, jadwal.kd_guru_prog_pddkn AS gpkd ".
										"FROM jadwal ".
										"WHERE jadwal.kd_tapel = '$tapelkd' ".
										"AND jadwal.kd_smt = '$smtkd' ".
										"AND jadwal.kd_kelas = '$kelkd' ".
										"AND jadwal.kd_jam = '$dte_jkd' ".
										"AND jadwal.kd_hari = '$hri_kd'");
				$rdte2 = mysql_fetch_assoc($qdte2);
				$tdte2 = mysql_num_rows($qdte2);
				$dte_kd = nosql($rdte2['jdkd']);
				$dte_gpkd = nosql($rdte2['gpkd']);
				$dte_rukd1 = nosql($rdte2['kd_ruang1']);
				$dte_rukd2 = nosql($rdte2['kd_ruang2']);


				//ruang1
				$qru1 = mysql_query("SELECT * FROM m_ruang ".
										"WHERE kd = '$dte_rukd1'");
				$rru1 = mysql_fetch_assoc($qru1);
				$ru1_ruang = balikin($rru1['ruang']);
				

				//ruang2
				$qru2 = mysql_query("SELECT * FROM m_ruang ".
										"WHERE kd = '$dte_rukd2'");
				$rru2 = mysql_fetch_assoc($qru2);
				$ru2_ruang = balikin($rru2['ruang']);
				
				
				//guru ne
				$qku1 = mysql_query("SELECT * FROM m_guru_prog_pddkn ".
										"WHERE kd = '$dte_gpkd'");
				$rku1 = mysql_fetch_assoc($qku1);
				$ku1_gurkd = nosql($rku1['kd_guru']);
				$ku1_progkd = nosql($rku1['kd_prog_pddkn']);


				//guru ne
				$qku2 = mysql_query("SELECT m_pegawai.* ".
										"FROM m_guru, m_pegawai ".
										"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
										"AND m_guru.kd_tapel = '$tapelkd' ".
										"AND m_guru.kd_kelas = '$kelkd' ".
										"AND m_guru.kd = '$ku1_gurkd'");
				$rku2 = mysql_fetch_assoc($qku2);
				$ku2_kode = nosql($rku2['kode']);
				$ku2_nip = balikin($rku2['nip']);
				$ku2_nama = balikin($rku2['nama']);
				


				//jam ke-
				$qcc3 = mysql_query("SELECT * FROM m_jam ".
										"WHERE kd = '$dte_jkd'");
				$rcc3 = mysql_fetch_assoc($qcc3);
				$dte3_jam = nosql($rcc3['jam']);

			
			
			

				//pddkn
				$qcc2 = mysql_query("SELECT * FROM m_prog_pddkn ".
										"WHERE kd = '$ku1_progkd'");
				$rcc2 = mysql_fetch_assoc($qcc2);
				$dte_pel = balikin($rcc2['prog_pddkn']);

				
				//jika null
				if (empty($dte_pel))
					{
					$warna = "yellow";
					}
				else
					{
					$warna = "";
					}
				
				
				echo '<td bgcolor="'.$warna.'">
				<b>Jam ke-'.$dte3_jam.' ['.$dte_waktu.'].</b>
				<hr>
				
				<strong>'.$dte_pel.'</strong>
				<br>
				[<em>'.$ku2_nama.'</em>]
				<hr>
				['.$ru1_ruang.']. ['.$ru2_ruang.'].
				[<a href="pel_entry.php?s=edit&kd='.$dte_kd.'&tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&kelkd='.$kelkd.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>]. 
				[<a href="'.$filenya.'?s=hapus&kd='.$dte_kd.'&tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&kelkd='.$kelkd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
				<hr>
				</td>';
				}

			}
		while ($rhri = mysql_fetch_assoc($qhri));

		echo '</tr>';
		}

	echo '</table>';
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
<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "guru.php";
$judul = "Jadwal Guru Mengajar";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$gurkd = nosql($_REQUEST['gurkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
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
else if (empty($gurkd))
	{
	$diload = "document.formx.guru.focus();";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek baru
if ($_POST['btnBR'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$gurkd = nosql($_POST['gurkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "guru_entry.php?tapelkd=$tapelkd&smtkd=$smtkd&gurkd=$gurkd";
	xloc($ke);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$gurkd = nosql($_POST['gurkd']);


	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM jadwal ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&gurkd=$gurkd";
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
require("../../inc/js/checkall.js");
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

echo '</select>
</td>
</tr>
</table>

<table width="100%" bgcolor="'.$warna01.'" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
Guru : ';
echo "<select name=\"guru\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qpwx = mysql_query("SELECT m_pegawai.* ".
						"FROM m_guru, m_pegawai ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"AND m_pegawai.kd = '$gurkd'");
$rowpwx = mysql_fetch_assoc($qpwx);
$pwx_nip = nosql($rowpwx['nip']);
$pwx_nm = balikin($rowpwx['nama']);


echo '<option value="'.$pwx_kd.'">'.$pwx_nip.'. '.$pwx_nm.'</option>';

$qgr = mysql_query("SELECT DISTINCT(m_pegawai.kd) AS pegkd ".
						"FROM m_guru, m_pegawai ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"ORDER BY m_pegawai.nama ASC");
$rowgr = mysql_fetch_assoc($qgr);

do
	{
	$gr_pegkd = nosql($rowgr['pegkd']);
	
	
	//detail
	$qku = mysql_query("SELECT * FROM m_pegawai ".
							"WHERE kd = '$gr_pegkd'");
	$rku = mysql_fetch_assoc($qku);
	$ppw_nip = nosql($rku['nip']);
	$ppw_nm = balikin($rku['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&gurkd='.$gr_pegkd.'">'.$ppw_nip.'. '.$ppw_nm.'</option>';
	}
while ($rowgr = mysql_fetch_assoc($qgr));

echo '</select>
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="gurkd" type="hidden" value="'.$gurkd.'">
<input name="btnBR" type="submit" value="BARU >>">
</td>
</tr>
</table>
<br>';

//cek
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($smtkd))
	{
	echo '<p>
	<strong><font color="#FF0000">SEMESTER Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($gurkd))
	{
	echo '<p>
	<strong><font color="#FF0000">GURU Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	//query
	$qjw = mysql_query("SELECT jadwal.kd AS jkd, m_guru_prog_pddkn.kd AS gpkd, ".
							"m_guru.kd AS gkd, m_prog_pddkn.kd AS progkd, ".
							"m_kelas.kd AS kelkd, m_hari.*, m_hari.kd AS harikd, ".
							"m_jam.*, m_jam.kd AS jamkd ".
							"FROM jadwal, m_guru_prog_pddkn, m_guru, m_prog_pddkn, ".
							"m_kelas, m_hari, m_jam ".
							"WHERE jadwal.kd_kelas = m_kelas.kd ".
							"AND jadwal.kd_hari = m_hari.kd ".
							"AND jadwal.kd_jam = m_jam.kd ".
							"AND jadwal.kd_guru_prog_pddkn = m_guru_prog_pddkn.kd ".
							"AND m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_guru.kd_pegawai = '$gurkd' ".
							"AND jadwal.kd_tapel = '$tapelkd' ".
							"AND jadwal.kd_smt = '$smtkd' ".
							"ORDER BY m_kelas.no ASC, ".
							"m_prog_pddkn.prog_pddkn ASC, ".
							"m_hari.no ASC, ".
							"m_jam.jam ASC");
	$rjw = mysql_fetch_assoc($qjw);
	$tjw = mysql_num_rows($qjw);



	//nek tidak ada
	if ($tjw == 0)
		{
		echo '<p>
		<strong><font color="#FF0000">TIDAK ADA JADWAL MENGAJAR...!</font></strong>
		</p>';
		}
	else
		{
		echo '[<a href="guru_xls.php?tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&gurkd='.$gurkd.'"><img src="'.$sumber.'/img/xls.gif" width="16" height="16" border="0"></a>].
		<table width="900" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">Mata Pelajaran</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Kelas</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Hari</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jam</font></strong></td>
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
			$jw_kd = nosql($rjw['jkd']);
			$jw_kelkd = nosql($rjw['kelkd']);
			$jw_progkd = nosql($rjw['progkd']);
			$jw_hari = balikin($rjw['hari']);
			$jw_jam = nosql($rjw['jam']);
			$jw_harikd = nosql($rjw['harikd']);
			$jw_jamkd = nosql($rjw['jamkd']);



			//kelas
			$qbtx = mysql_query("SELECT * FROM m_kelas ".
									"WHERE kd = '$jw_kelkd'");
			$rowbtx = mysql_fetch_assoc($qbtx);
			$btxkelas = balikin($rowbtx['kelas']);




			//pddkn
			$qcc2 = mysql_query("SELECT * FROM m_prog_pddkn ".
									"WHERE kd = '$jw_progkd'");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$dte_pel = balikin($rcc2['prog_pddkn']);



			//datane waktu
			$qdtee = mysql_query("SELECT * FROM m_waktu ".
									"WHERE kd_jam = '$jw_jamkd' ".
									"AND kd_hari = '$jw_harikd'");
			$rdtee = mysql_fetch_assoc($qdtee);
			$dtee_waktu = balikin($rdtee['waktu']);





			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$jw_kd.'">
        	</td>
			<td>'.$dte_pel.'</td>
			<td>'.$btxkelas.'</td>
			<td>'.$jw_hari.'</td>
			<td>Ke-'.$jw_jam.' ['.$dtee_waktu.']</td>
			</tr>';
			}
		while ($rjw = mysql_fetch_assoc($qjw));

		echo '</table>

		<table width="900" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$tjw.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tjw.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$tjw.'</font></strong> Data.</td>
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


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
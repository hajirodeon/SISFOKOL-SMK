<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "daftar_kompetensi.php";
$judul = "Daftar Kompetensi Dasar";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$progkd = nosql($_REQUEST['progkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$mpkd = nosql($_REQUEST['mpkd']);
$mmkd= nosql($_REQUEST['mmkd']);
$s = nosql($_REQUEST['s']);
$kdx = nosql($_REQUEST['kdx']);
$limit = "50";
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"keahkd=$keahkd&progkd=$progkd&page=$page";











//focus....focus...
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/menu/admgr.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php?tapelkd='.$tapelkd.'" title="Daftar Mata Pelajaran">Daftar Mata Pelajaran</a>]</td>
</tr>
</table>

<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>,

Kelas : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>,

Program Keahlian : ';
//terpilih
$qprgx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['program']);

echo '<strong>'.$prgx_prog.'</strong>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mata Pelajaran : ';

/*
//program pendidikan-terpilih
$qpelx = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mkkd, ".
			"m_guru.*, m_guru_prog_pddkn.*, m_guru_prog_pddkn.kd AS mmkd, ".
			"m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, m_pegawai.* ".
			"FROM m_prog_pddkn_kelas, m_guru, m_guru_prog_pddkn, m_prog_pddkn, m_pegawai ".
			"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
			"AND m_guru_prog_pddkn.kd_prog_pddkn = m_prog_pddkn.kd ".
			"AND m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
			"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
			"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
			"AND m_guru.kd_tapel = '$tapelkd' ".
			"AND m_guru.kd_keahlian = '$keahkd' ".
			"AND m_guru.kd_kelas = '$kelkd' ".
			"AND m_guru.kd_pegawai = m_pegawai.kd ".
			"AND m_guru_prog_pddkn.kd = '$mmkd'");
$rpelx = mysql_fetch_assoc($qpelx);
$pelx_kd = nosql($rpelx['mmkd']);
$pelx_mpkd = nosql($rpelx['mpkd']);
$pelx_mkkd = nosql($rpelx['mkkd']);
$pelx_pel = balikin($rpelx['prog_pddkn']);
$pelx_nip = nosql($rpelx['nip']);
$pelx_nm = balikin($rpelx['nama']);
*/


//program pendidikan-terpilih
$qpelx = mysql_query("SELECT * FROM m_prog_pddkn ".
			"WHERE kd = '$progkd'");
$rpelx = mysql_fetch_assoc($qpelx);
$pelx_pel = balikin($rpelx['prog_pddkn']);




echo '<strong>'.$pelx_pel.'</strong>,

Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?progkd='.$progkd.'&mmkd='.$mmkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&mpkd='.$mpkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>

<br>';


//nek drg
if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	//mapel
	$qx1 = mysql_query("SELECT * FROM m_prog_pddkn ".
				"WHERE kd = '$mpkd'");
	$rowx1 = mysql_fetch_assoc($qx1);
	$totalx1 = mysql_num_rows($qx1);
	$x1_pel = balikin($rowx1['prog_pddkn']);


	//edit
	$qdt = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
				"WHERE kd_prog_pddkn_kelas = '$mpkd' ".
				"AND kd = '$kdx'");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);
	$dt_kode = nosql($rdt['kode']);
	$dt_nama = balikin($rdt['nama']);



	//query
	$q = mysql_query("SELECT m_prog_pddkn_kompetensi.*, m_prog_pddkn_kompetensi.kd AS pkd, m_smt.* ".
							"FROM m_prog_pddkn_kompetensi, m_smt ".
							"WHERE m_prog_pddkn_kompetensi.kd_smt = m_smt.kd ".
							"AND m_prog_pddkn_kompetensi.kd_prog_pddkn_kelas = '$mpkd' ".
							"AND m_smt.kd = '$smtkd' ".
							"ORDER BY m_prog_pddkn_kompetensi.kode ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);




	if ($total != 0)
		{
		echo '<table width="500" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama Kompetensi Dasar</font></strong></td>
		</tr>';

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
			$i_kd = nosql($row['pkd']);
			$i_kode = nosql($row['kode']);
			$i_nama = balikin($row['nama']);




			//jika ada 'nol'. kategori standar kompetensi
			$i_sk = substr($i_kode,-1);
			if ($i_sk == "0")
				{
				echo "<tr valign=\"top\" bgcolor=\"red\">";
				echo '<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				</tr>';
				}
			else
				{
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				</tr>';
				}
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="jml" type="hidden" value="'.$total.'">
		Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.
		</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan Hubungi Bagian Kurikulum.</strong>
		</font>
		</p>';
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
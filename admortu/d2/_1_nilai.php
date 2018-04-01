<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsw.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nilai.php";
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$progkd = nosql($_REQUEST['progkd']);
$s = nosql($_REQUEST['s']);


$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"keahkd=$keahkd&kompkd=$kompkd&progkd=$progkd";



//siswa ne
$qsiw = mysql_query("SELECT siswa_kelas.*, siswa_kelas.kd AS skkd, m_siswa.* ".
			"FROM siswa_kelas, m_siswa ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_keahlian = '$keahkd' ".
			"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND m_siswa.kd = '$kd2_session'");
$rsiw = mysql_fetch_assoc($qsiw);
$siw_nis = nosql($rsiw['nis']);
$siw_nama = balikin($rsiw['nama']);
$skkd = nosql($rsiw['skkd']);


//judul
$judul = "Nilai";
$judulku = "[$siswa_session : $nis2_session.$nm2_session] ==> $judul";
$juduly = $judul;


//focus
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}
else if (empty($progkd))
	{
	$diload = "document.formx.mapel.focus();";
	}



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admsw.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">';
xheadline($judul);
echo ' [<a href="../index.php" title="Daftar Detail">DAFTAR DETAIL</a>]';

//tapel
$qpel = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rpel = mysql_fetch_assoc($qpel);
$pel_thn1 = nosql($rpel['tahun1']);
$pel_thn2 = nosql($rpel['tahun2']);

//kelas
$qkel = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = balikin($rkel['kelas']);

//keahlian
$qpro = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);
$pro_keah = "$pro_program";


//kompetensi
$qprgx2 = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd = '$kompkd'");
$rowprgx2 = mysql_fetch_assoc($qprgx2);
$prgx2_prog = balikin($rowprgx2['kompetensi']);





echo '<table bgcolor="'.$warnaover.'" width="100%" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<strong>Tahun Pelajaran :</strong> '.$pel_thn1.'/'.$pel_thn2.',
<strong>Kelas :</strong> '.$kel_kelas.',
<strong>Program Keahlian :</strong> '.$pro_keah.',
<strong>Kompetensi Keahlian :</strong> '.$prgx2_prog.'
</td>
</tr>
</table>


<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_smt = nosql($rowstx['smt']);


echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst["kd"]);
	$st_smt = nosql($rowst["smt"]);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>,


Standar Kompetensi : ';
echo "<select name=\"mapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstdx = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, m_prog_pddkn_jns.* ".
			"FROM m_prog_pddkn, m_prog_pddkn_jns ".
			"WHERE m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
			"AND m_prog_pddkn.kd = '$progkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['mpkd']);
$stdx_pel = balikin($rowstdx['prog_pddkn']);
$stdx_jns = nosql($rowstdx['jenis']);

echo '<option value="'.$stdx_kd.'">'.$stdx_jns.' --> '.$stdx_pel.'</option>';

/*
//daftar
$qstd = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, ".
			"m_prog_pddkn_kelas.*, m_prog_pddkn_jns.* ".
			"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns ".
			"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
			"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
			"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
			"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
			"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
			"AND m_prog_pddkn_kelas.kd <> '$progkd' ".
			"ORDER BY round(m_prog_pddkn_jns.no) ASC, ".
			"round(m_prog_pddkn.no) ASC, ".
			"round(m_prog_pddkn.no_sub) ASC");
$rowstd = mysql_fetch_assoc($qstd);
*/

//daftar
$qstd = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, ".
			"m_prog_pddkn_kelas.*, m_prog_pddkn_jns.* ".
			"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns ".
			"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
			"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
			"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
			"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
			"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
			"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
			"AND m_prog_pddkn_kelas.kd <> '$progkd' ".
			"ORDER BY round(m_prog_pddkn_jns.no) ASC, ".
			"round(m_prog_pddkn.no) ASC, ".
			"round(m_prog_pddkn.no_sub) ASC");
$rowstd = mysql_fetch_assoc($qstd);


do
	{
	$std_kd = nosql($rowstd['mpkd']);
	$std_pel = balikin2($rowstd['prog_pddkn']);
	$std_jenis = balikin2($rowstd['jenis']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&smtkd='.$smtkd.'&progkd='.$std_kd.'">'.$std_jenis.' --> '.$std_pel.'</option>';
	}
while ($rowstd = mysql_fetch_assoc($qstd));

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

else if (empty($progkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>STANDAR KOMPETENSI Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
// 	//kelas program pendidikan
	$qhi = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd, ".
				"m_prog_pddkn.*, m_prog_pddkn.kd AS mkkd ".
				"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$progkd'");
	$rowhi = mysql_fetch_assoc($qhi);
	$totalhi = mysql_num_rows($qhi);
	$hi_mpkd = nosql($rowhi['mpkd']);


	//jumlah kompetensi
	$qku4xu = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
				"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
				"AND right(kode,2) <> '.0'");
	$rowku4xu = mysql_fetch_assoc($qku4xu);
	$totalku4xu = mysql_num_rows($qku4xu);


	//kelas program pendidikan
	$qhi = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd, ".
				"m_prog_pddkn.*, m_prog_pddkn.kd AS mkkd ".
				"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$progkd'");
	$rowhi = mysql_fetch_assoc($qhi);
	$totalhi = mysql_num_rows($qhi);
	$hi_mpkd = nosql($rowhi['mpkd']);


	echo '<table border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="'.$warnaheader.'">';

	//query-kategori
	$qku = mysql_query("SELECT DISTINCT(left(kode,1)) AS katkd ".
				"FROM m_prog_pddkn_kompetensi ".
				"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
				"AND right(kode,2) <> '.0' ".
				"ORDER BY kode ASC");
	$rowku = mysql_fetch_assoc($qku);
	$totalku = mysql_num_rows($qku);


	do
		{
		//nilai
		$ku_katkd= nosql($rowku['katkd']);


		//sub
		$qku2 = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND right(kode,2) <> '.0' ".
					"AND left(kode,1) = '$ku_katkd' ".
					"ORDER BY kode ASC");
		$rowku2 = mysql_fetch_assoc($qku2);
		$totalku2 = mysql_num_rows($qku2);
		$jml_kolom = $totalku2 + 2;


		echo '<td width="50" COLSPAN="'.$jml_kolom.'" align="center"><strong>Standar Kompetensi '.$ku_katkd.'</strong></td>';
		}
	while ($rowku = mysql_fetch_assoc($qku));

	echo '<td width="10" align="center" ROWSPAN="2"><strong>NR</strong></td>
	</tr>
	<tr bgcolor="'.$warnaheader.'">';


	//query-kategori
	$qku = mysql_query("SELECT DISTINCT(left(kode,1)) AS katkd ".
				"FROM m_prog_pddkn_kompetensi ".
				"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
				"AND right(kode,2) <> '.0' ".
				"ORDER BY kode ASC");
	$rowku = mysql_fetch_assoc($qku);
	$totalku = mysql_num_rows($qku);


	do
		{
		//nilai
		$ku_katkd= nosql($rowku['katkd']);


		//sub
		$qku2 = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND right(kode,2) <> '.0' ".
					"AND left(kode,1) = '$ku_katkd' ".
					"ORDER BY kode ASC");
		$rowku2 = mysql_fetch_assoc($qku2);
		$totalku2 = mysql_num_rows($qku2);


		do
			{
			//nilai
			$ku2_kode = nosql($rowku2['kode']);

			echo '<td align="center"><strong>NKD <br> '.$ku2_kode.'</strong></td>';
			}
		while ($rowku2 = mysql_fetch_assoc($qku2));

		echo '<td width="10" align="center"><strong>NS'.$ku_katkd.'</strong></td>
		<td width="10" align="center"><strong>NK'.$ku_katkd.'</strong></td>';
		}
	while ($rowku = mysql_fetch_assoc($qku));


	echo '</tr>';
	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";


	//query-kategori
	$qku = mysql_query("SELECT DISTINCT(left(kode,1)) AS katkd ".
				"FROM m_prog_pddkn_kompetensi ".
				"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
				"AND right(kode,2) <> '.0' ".
				"ORDER BY kode ASC");
	$rowku = mysql_fetch_assoc($qku);
	$totalku = mysql_num_rows($qku);


	do
		{
		//nilai
		$nomerku = $nomerku + 2;
		$ku_katkd = nosql($rowku['katkd']);


		//sub
		$qku2 = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND right(kode,2) <> '.0' ".
					"AND left(kode,1) = '$ku_katkd' ".
					"ORDER BY kode ASC");
		$rowku2 = mysql_fetch_assoc($qku2);
		$totalku2 = mysql_num_rows($qku2);


		do
			{
			//nilai
			$ku2_kd = nosql($rowku2['kd']);
			$ku2_kode = nosql($rowku2['kode']);


			//nilainya
			$qdtu = mysql_query("SELECT * FROM siswa_nilai_kompetensi ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn_kompetensi = '$ku2_kd'");
			$rdtu = mysql_fetch_assoc($qdtu);
			$tdtu = mysql_num_rows($qdtu);
			$dtu_nkd = nosql($rdtu['nil_nkd']);

			echo '<td>
			<input name="'.$i_skkd.'nkd'.$ku2_kd.'" type="text" value="'.$dtu_nkd.'" size="3" maxlength="5" class="input" readonly>
			</td>';
			}
		while ($rowku2 = mysql_fetch_assoc($qku2));



		//nilainya
		$qdtu2 = mysql_query("SELECT * FROM siswa_nilai_kompetensi2 ".
					"WHERE kd_siswa_kelas = '$skkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_prog_pddkn = '$progkd' ".
					"AND sk = '$ku_katkd'");
		$rdtu2 = mysql_fetch_assoc($qdtu2);
		$tdtu2 = mysql_num_rows($qdtu2);
		$dtu2_ns = nosql($rdtu2['nil_ns']);
		$dtu2_nk = nosql($rdtu2['rata_nk']);


		echo '<td>
		<input name="'.$i_skkd.'ns'.$ku_katkd.'" type="text" value="'.$dtu2_ns.'" size="3" maxlength="5" class="input" readonly>
		</td>
		<td>
		<input name="'.$i_skkd.'nk'.$ku_katkd.'" type="text" value="'.$dtu2_nk.'" size="3" maxlength="5" class="input" readonly>
		</td>';
		}
	while ($rowku = mysql_fetch_assoc($qku));


	//nilainya
	$qdtu21 = mysql_query("SELECT * FROM siswa_nilai_raport ".
				"WHERE kd_siswa_kelas = '$skkd' ".
				"AND kd_prog_pddkn = '$progkd' ".
				"AND kd_smt = '$smtkd'");
	$rdtu21 = mysql_fetch_assoc($qdtu21);
	$tdtu21 = mysql_num_rows($qdtu21);
	$dtu21_raport = nosql($rdtu21['nil_raport']);

	echo '<td width="10">
	<input name="'.$i_skkd.'raport" type="text" value="'.$dtu21_raport.'" size="2" maxlength="2" class="input" readonly>
	</td>
	</tr>
	</table>';
	}


echo '</form>';
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
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
$progkd = nosql($_REQUEST['progkd']);
$s = nosql($_REQUEST['s']);


$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&progkd=$progkd";



//siswa ne
$qsiw = mysql_query("SELECT siswa_kelas.*, siswa_kelas.kd AS skkd, m_siswa.* ".
			"FROM siswa_kelas, m_siswa ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
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

//menu
require("../../inc/menu/admsw.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");



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




echo '<table bgcolor="'.$warnaover.'" width="100%" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<strong>Tahun Pelajaran :</strong> '.$pel_thn1.'/'.$pel_thn2.',
<strong>Kelas :</strong> '.$kel_kelas.'
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>,


Mata Pelajaran : ';
echo "<select name=\"mapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstdx = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd ".
						"FROM m_prog_pddkn ".
						"WHERE kd = '$progkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['mpkd']);
$stdx_pel = balikin($rowstdx['prog_pddkn']);

echo '<option value="'.$stdx_kd.'">'.$stdx_pel.'</option>';



//daftar
$qstd = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, ".
						"m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn.kd <> '$progkd' ".
						"ORDER BY m_prog_pddkn.prog_pddkn ASC");
$rowstd = mysql_fetch_assoc($qstd);


do
	{
	$std_kd = nosql($rowstd['mpkd']);
	$std_pel = balikin2($rowstd['prog_pddkn']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&smtkd='.$smtkd.'&progkd='.$std_kd.'">'.$std_pel.'</option>';
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
	<font color="#FF0000"><strong>MATA PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	echo '<p>
	<b>
	Nilai Pengetahuan
	</b>
	<table border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>UH1</strong></td>
	<td width="50"><strong>UH2</strong></td>
	<td width="50"><strong>UH3</strong></td>
	<td width="50"><strong>UH4</strong></td>
	<td width="50"><strong>RATA UH</strong></td>
	<td width="50"><strong>TUGAS1</strong></td>
	<td width="50"><strong>TUGAS2</strong></td>
	<td width="50"><strong>TUGAS3</strong></td>
	<td width="50"><strong>TUGAS4</strong></td>
	<td width="50"><strong>RATA TUGAS</strong></td>
	<td width="50"><strong>RATA NH</strong></td>
	<td width="50"><strong>N.UTS</strong></td>
	<td width="50"><strong>N.UAS</strong></td>
	<td width="50"><strong>N.A.P</strong></td>
	<td width="50"><strong>ANGKA</strong></td>
	<td width="50"><strong>HURUF</strong></td>
	</tr>';



	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_nil_nh1 = nosql($rxpel['nil_nh1']);
	$xpel_nil_nh2 = nosql($rxpel['nil_nh2']);
	$xpel_nil_nh3 = nosql($rxpel['nil_nh3']);
	$xpel_nil_nh4 = nosql($rxpel['nil_nh4']);
	
	$xpel_nil_rata_uh = nosql($rxpel['nil_nh']);
	
	$xpel_nil_tugas1 = nosql($rxpel['nil_tugas1']);
	$xpel_nil_tugas2 = nosql($rxpel['nil_tugas2']);
	$xpel_nil_tugas3 = nosql($rxpel['nil_tugas3']);
	$xpel_nil_tugas4 = nosql($rxpel['nil_tugas4']);
	$xpel_nil_rata_tugas = nosql($rxpel['rata_tugas']);
	
	$xpel_nil_rata_nh = nosql($rxpel['rata_nh']);
	$xpel_nil_nuts = nosql($rxpel['nil_uts']);
	$xpel_nil_nuas = nosql($rxpel['nil_uas']);
	
	$xpel_nil_nr = nosql($rxpel['nil_raport_pengetahuan']);
	$xpel_nil_nr_a = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_nil_nr_p = balikin($rxpel['nil_raport_pengetahuan_p']);



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>
	<input name="nil_nh1'.$i_nomer.'" type="text" value="'.$xpel_nil_nh1.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_nh2'.$i_nomer.'" type="text" value="'.$xpel_nil_nh2.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_nh3'.$i_nomer.'" type="text" value="'.$xpel_nil_nh3.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_nh4'.$i_nomer.'" type="text" value="'.$xpel_nil_nh4.'" size="3" style="text-align:right" class="input" readonly>
	</td>



	<td>
	<input name="nil_rata_uh'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_uh.'" size="3" style="text-align:right" class="input" readonly>
	</td>


	<td>
	<input name="nil_tugas1'.$i_nomer.'" type="text" value="'.$xpel_nil_tugas1.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_tugas2'.$i_nomer.'" type="text" value="'.$xpel_nil_tugas2.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_tugas3'.$i_nomer.'" type="text" value="'.$xpel_nil_tugas3.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_tugas4'.$i_nomer.'" type="text" value="'.$xpel_nil_tugas4.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	

	<td>
	<input name="nil_rata_tugas'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_tugas.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_rata_nh'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_nh.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_nuts'.$i_nomer.'" type="text" value="'.$xpel_nil_nuts.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_nuas'.$i_nomer.'" type="text" value="'.$xpel_nil_nuas.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport'.$i_nomer.'" type="text" value="'.$xpel_nil_nr.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport_a'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_a.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport_p'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_p.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	</tr>
	</table>
	</p>
	<hr>
	
	
	<p>
	<b>
	Nilai Keterampilan
	</b>
	<table width="1200" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>PRAKTEK 1</strong></td>
	<td width="50"><strong>PRAKTEK 2</strong></td>
	<td width="50"><strong>PRAKTEK 3</strong></td>
	<td width="50"><strong>PRAKTEK 4</strong></td>
	<td width="50"><strong>RATA</strong></td>
	<td width="50"><strong>PROYEK 1</strong></td>
	<td width="50"><strong>PROYEK 2</strong></td>
	<td width="50"><strong>PROYEK 3</strong></td>
	<td width="50"><strong>PROYEK 4</strong></td>
	<td width="50"><strong>RATA</strong></td>
	<td width="50"><strong>FOLIO 1</strong></td>
	<td width="50"><strong>FOLIO 2</strong></td>
	<td width="50"><strong>FOLIO 3</strong></td>
	<td width="50"><strong>FOLIO 4</strong></td>
	<td width="50"><strong>RATA</strong></td>
	<td width="50"><strong>ULANGAN</strong></td>
	<td width="50"><strong>N.A.K</strong></td>
	<td width="50"><strong>ANGKA</strong></td>
	<td width="50"><strong>HURUF</strong></td>
	</tr>';




	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	
	$xpel_praktek1 = nosql($rxpel['nil_praktek1']);
	$xpel_praktek2 = nosql($rxpel['nil_praktek2']);
	$xpel_praktek3 = nosql($rxpel['nil_praktek3']);
	$xpel_praktek4 = nosql($rxpel['nil_praktek4']);			
	$xpel_praktek_rata = nosql($rxpel['rata_praktek']);
	
	
	$xpel_folio1 = nosql($rxpel['nil_folio1']);
	$xpel_folio2 = nosql($rxpel['nil_folio2']);
	$xpel_folio3 = nosql($rxpel['nil_folio3']);
	$xpel_folio4 = nosql($rxpel['nil_folio4']);
	$xpel_folio_rata = nosql($rxpel['rata_folio']);
	
	
	$xpel_proyek1 = nosql($rxpel['nil_proyek1']);
	$xpel_proyek2 = nosql($rxpel['nil_proyek2']);
	$xpel_proyek3 = nosql($rxpel['nil_proyek3']);
	$xpel_proyek4 = nosql($rxpel['nil_proyek4']);
	$xpel_proyek_rata = nosql($rxpel['rata_proyek']);

	
	$xpel_ulangan = nosql($rxpel['nil_praktek']);
	
	$xpel_nil_nr = nosql($rxpel['nil_raport_ketrampilan']);
	$xpel_nil_nr_a = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_nil_nr_p = balikin($rxpel['nil_raport_ketrampilan_p']);



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>
	<input name="nil_praktek1'.$i_nomer.'" type="text" value="'.$xpel_praktek1.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_praktek2'.$i_nomer.'" type="text" value="'.$xpel_praktek2.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_praktek3'.$i_nomer.'" type="text" value="'.$xpel_praktek3.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_praktek4'.$i_nomer.'" type="text" value="'.$xpel_praktek4.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_praktek_rata'.$i_nomer.'" type="text" value="'.$xpel_praktek_rata.'" size="3" style="text-align:right" class="input" readonly>
	</td>


	<td>
	<input name="nil_proyek1'.$i_nomer.'" type="text" value="'.$xpel_proyek1.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_proyek2'.$i_nomer.'" type="text" value="'.$xpel_proyek2.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_proyek3'.$i_nomer.'" type="text" value="'.$xpel_proyek3.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_proyek4'.$i_nomer.'" type="text" value="'.$xpel_proyek4.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_proyek_rata'.$i_nomer.'" type="text" value="'.$xpel_proyek_rata.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	
	<td>
	<input name="nil_folio1'.$i_nomer.'" type="text" value="'.$xpel_folio1.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_folio2'.$i_nomer.'" type="text" value="'.$xpel_folio2.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_folio3'.$i_nomer.'" type="text" value="'.$xpel_folio3.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_folio4'.$i_nomer.'" type="text" value="'.$xpel_folio4.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_folio_rata'.$i_nomer.'" type="text" value="'.$xpel_folio_rata.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_ulangan'.$i_nomer.'" type="text" value="'.$xpel_ulangan.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport'.$i_nomer.'" type="text" value="'.$xpel_nil_nr.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport_a'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_a.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport_p'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_p.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	</tr>
	</table>
	</p>
	<hr>
	
	
	<p>
	<table border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>OBSERVASI 1</strong></td>
	<td width="50"><strong>OBSERVASI 2</strong></td>
	<td width="50"><strong>OBSERVASI 3</strong></td>
	<td width="50"><strong>OBSERVASI 4</strong></td>
	<td width="50"><strong>RATA</strong></td>
	<td width="50"><strong>PENILAIAN DIRI</strong></td>
	<td width="50"><strong>PENILAIAN SEJAWAT</strong></td>
	<td width="50"><strong>N.A.S</strong></td>
	<td width="50"><strong>ANGKA</strong></td>
	<td width="50"><strong>HURUF</strong></td>
	</tr>';



	//last update
	$qku2 = mysql_query("SELECT AVG(nilai) AS rataku ".
							"FROM siswa_sikap_dirisendiri ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_mapel = '$progkd' ".
							"AND kd_siswa = '$kd2_session'");
	$rku2 = mysql_fetch_assoc($qku2);
	$ku2_rataku = nosql($rku2['rataku']);






	//last update
	$qku3 = mysql_query("SELECT AVG(nilai) AS rataku ".
							"FROM siswa_sikap_antarteman ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_mapel = '$progkd' ".
							"AND kd_siswa = '$kd2_session'");
	$rku3 = mysql_fetch_assoc($qku3);
	$ku3_rataku = nosql($rku3['rataku']);





	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	
	$xpel_obs1 = nosql($rxpel['nil_sikap_observasi1']);
	$xpel_obs2 = nosql($rxpel['nil_sikap_observasi2']);
	$xpel_obs3 = nosql($rxpel['nil_sikap_observasi3']);
	$xpel_obs4 = nosql($rxpel['nil_sikap_observasi4']);
	$xpel_obs = nosql($rxpel['nil_sikap_observasi']);

	
	$xpel_diri = nosql($rxpel['nil_sikap_dirisendiri']);
	$xpel_sejawat = nosql($rxpel['nil_sikap_antarteman']);
	

	
	$xpel_nil_nr = nosql($rxpel['rata_sikap']);
	$xpel_nil_nr_a = nosql($rxpel['rata_sikap_a']);
	$xpel_nil_nr_p = balikin($rxpel['rata_sikap_p']);





	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>
	<input name="nil_obs1'.$i_nomer.'" type="text" value="'.$xpel_obs1.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_obs2'.$i_nomer.'" type="text" value="'.$xpel_obs2.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_obs3'.$i_nomer.'" type="text" value="'.$xpel_obs3.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_obs4'.$i_nomer.'" type="text" value="'.$xpel_obs4.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	
	<td>
	<input name="nil_obss'.$i_nomer.'" type="text" value="'.$xpel_obs.'" size="3" style="text-align:right" class="input" readonly>
	</td>


	<td>
	<input name="nil_diri'.$i_nomer.'" type="text" value="'.$xpel_diri.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_sejawat'.$i_nomer.'" type="text" value="'.$xpel_sejawat.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_raport'.$i_nomer.'" type="text" value="'.$xpel_nil_nr.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport_a'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_a.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport_p'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_p.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	</tr>';

	echo '</table>
	
	</p>';
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
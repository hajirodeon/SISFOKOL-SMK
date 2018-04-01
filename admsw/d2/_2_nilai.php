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


Mata Pelajaran : ';
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
	<font color="#FF0000"><strong>MATA PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	echo '<p>
	Pengetahuan :
	<table border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="10"><strong>RATA UH</strong></td>
	<td width="10"><strong>RATA PN</strong></td>
	<td width="10"><strong>NH</strong></td>
	<td width="10"><strong>NUTS</strong></td>
	<td width="10"><strong>NUAS</strong></td>
	<td width="10"><strong>NR</strong></td>
	<td width="10"><strong>RAPORT A</strong></td>
	<td width="10"><strong>RAPORT P</strong></td>
	<td width="10"><strong>CATATAN</strong></td>
	</tr>';
	

	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_nil_rata_uh = nosql($rxpel['rata_nh']);
	$xpel_nil_rata_pn = nosql($rxpel['rata_tugas']);
	$xpel_nil_nh = nosql($rxpel['nil_nh']);
	$xpel_nil_nuts = nosql($rxpel['nil_uts']);
	$xpel_nil_nuas = nosql($rxpel['nil_uas']);
	$xpel_nil_nr = nosql($rxpel['nil_raport_pengetahuan']);
	$xpel_nil_nr_a = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_nil_nr_p = nosql($rxpel['nil_raport_pengetahuan_p']);
	$xpel_nil_k = balikin($rxpel['nil_k_pengetahuan']);


	//nilai akhir
	$xpel_nil_nr = (3*$xpel_nil_nuas) + (2*$xpel_nil_nuts) + $xpel_nil_nh;


	//predikat
	if ($xpel_nil_nr_a == "4.00")
		{
		$xpel_nil_nr_p = "A";
		}
	else if (($xpel_nil_nr_a < "4.00") AND ($xpel_nil_nr_a >= "3.67"))
		{
		$xpel_nil_nr_p = "A-";
		}
	else if (($xpel_nil_nr_a < "3.67") AND ($xpel_nil_nr_a >= "3.33"))
		{
		$xpel_nil_nr_p = "B+";
		}
	else if (($xpel_nil_nr_a < "3.33") AND ($xpel_nil_nr_a >= "3.00"))
		{
		$xpel_nil_nr_p = "B";
		}
	else if (($xpel_nil_nr_a < "3.00") AND ($xpel_nil_nr_a >= "2.67"))
		{
		$xpel_nil_nr_p = "B-";
		}
	else if (($xpel_nil_nr_a < "2.67") AND ($xpel_nil_nr_a >= "2.33"))
		{
		$xpel_nil_nr_p = "C+";
		}
	else if (($xpel_nil_nr_a < "2.33") AND ($xpel_nil_nr_a >= "2.00"))
		{
		$xpel_nil_nr_p = "C";
		}
	else if (($xpel_nil_nr_a < "2.00") AND ($xpel_nil_nr_a >= "1.67"))
		{
		$xpel_nil_nr_p = "C-";
		}
	else if (($xpel_nil_nr_a < "1.67") AND ($xpel_nil_nr_a >= "1.33"))
		{
		$xpel_nil_nr_p = "D+";
		}
	else if (($xpel_nil_nr_a < "1.33") AND ($xpel_nil_nr_a >= "1.00"))
		{
		$xpel_nil_nr_p = "D";
		}





	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>
	<input name="nil_rata_uh'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_uh.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_rata_pn'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_pn.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_nh'.$i_nomer.'" type="text" value="'.$xpel_nil_nh.'" size="3" style="text-align:right" class="input" readonly>
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
	<td>
	<input name="nil_catatan'.$i_nomer.'" type="text" value="'.$xpel_nil_k.'" size="30" style="text-align:right" class="input" readonly>
	</td>
	
	</tr>

	</table>
	</p>
	<br>
	
	
	<p>
	Ketrampilan :
	<table border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>RATA NP</strong></td>
	<td width="50"><strong>RATA NF</strong></td>
	<td width="50"><strong>RATA NY</strong></td>
	<td width="50"><strong>NR</strong></td>
	<td width="50"><strong>RAPORT A</strong></td>
	<td width="50"><strong>RAPORT P</strong></td>
	</tr>';



	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_rata_np = nosql($rxpel['rata_praktek']);
	$xpel_rata_nf = nosql($rxpel['rata_folio']);
	$xpel_rata_ny = nosql($rxpel['rata_proyek']);

	$xpel_nil_nr = nosql($rxpel['nil_raport_ketrampilan']);
	$xpel_nil_nr_a = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_nil_nr_p = nosql($rxpel['nil_raport_ketrampilan_p']);





	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>
	<input name="nil_rata_np'.$i_nomer.'" type="text" value="'.$xpel_rata_np.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_rata_nf'.$i_nomer.'" type="text" value="'.$xpel_rata_nf.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_rata_ny'.$i_nomer.'" type="text" value="'.$xpel_rata_ny.'" size="3" style="text-align:right" class="input" readonly>
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
	<br>
	
	<p>
	Sikap :
	<table border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>OBSERVASI PENGAMATAN</strong></td>
	<td width="50"><strong>PENILAIAN DIRI SENDIRI</strong></td>
	<td width="50"><strong>PENILAIAN ANTAR TEMAN</strong></td>
	<td width="50"><strong>JURNAL CATATAN GURU</strong></td>
	<td width="50"><strong>RAPORT A</strong></td>
	<td width="50"><strong>RAPORT P</strong></td>
	</tr>';



	//ambil nilai observasi
	$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
							"FROM siswa_sikap_observasi ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_mapel = '$progkd' ". 
							"AND kd_siswa = '$kd2_session'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_rata_amatt = nosql($rxpel['total']);
	$nilku = ($xpel_rata_amatt / 20) * 100;

	if ($nilku <= '54')
		{
		$nilkux = '1.00';
		}
	else if (($nilku <= '59') AND ($nilku >= '55'))
		{
		$nilkux = '1.33';
		}
		
	else if (($nilku <= '64') AND ($nilku >= '60'))
		{
		$nilkux = '1.67';
		}
	
	else if (($nilku <= '69') AND ($nilku >= '65'))
		{
		$nilkux = '2.00';
		}
	
	else if (($nilku <= '74') AND ($nilku >= '70'))
		{
		$nilkux = '2.33';
		}
		
	else if (($nilku <= '80') AND ($nilku >= '75'))
		{
		$nilkux = '2,67';
		}
	
	else if (($nilku <= '85') AND ($nilku >= '81'))
		{
		$nilkux = '3,00';
		}
	
	else if (($nilku <= '90') AND ($nilku >= '86'))
		{
		$nilkux = '3,33';
		}
	
	else if (($nilku <= '95') AND ($nilku >= '91'))
		{
		$nilkux = '3.67';
		}
	
	else if (($nilku <= '100') AND ($nilku >= '96'))
		{
		$nilkux = '4.00';
		}
	
	$xpel_rata_amat = $nilkux;
	


	//ambil nilai diri sendiri
	$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
							"FROM siswa_sikap_dirisendiri ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_mapel = '$progkd' ". 
							"AND kd_siswa = '$kd2_session'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_nil_dirisendirii = nosql($rxpel['total']);
	$nilku = ($xpel_nil_dirisendirii / 20) * 100;

	if ($nilku <= '54')
		{
		$nilkux = '1.00';
		}
	else if (($nilku <= '59') AND ($nilku >= '55'))
		{
		$nilkux = '1.33';
		}
		
	else if (($nilku <= '64') AND ($nilku >= '60'))
		{
		$nilkux = '1.67';
		}
	
	else if (($nilku <= '69') AND ($nilku >= '65'))
		{
		$nilkux = '2.00';
		}
	
	else if (($nilku <= '74') AND ($nilku >= '70'))
		{
		$nilkux = '2.33';
		}
		
	else if (($nilku <= '80') AND ($nilku >= '75'))
		{
		$nilkux = '2,67';
		}
	
	else if (($nilku <= '85') AND ($nilku >= '81'))
		{
		$nilkux = '3,00';
		}
	
	else if (($nilku <= '90') AND ($nilku >= '86'))
		{
		$nilkux = '3,33';
		}
	
	else if (($nilku <= '95') AND ($nilku >= '91'))
		{
		$nilkux = '3.67';
		}
	
	else if (($nilku <= '100') AND ($nilku >= '96'))
		{
		$nilkux = '4.00';
		}
	$xpel_nil_dirisendiri = $nilkux;



	//ambil nilai antar teman
	$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
							"FROM siswa_sikap_antarteman ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_mapel = '$progkd' ". 
							"AND kd_siswa2 = '$kd2_session'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_nil_antartemann = nosql($rxpel['total']);
	$nilku = ($xpel_nil_antartemann / 20) * 100;
	
	if ($nilku <= '54')
		{
		$nilkux = '1.00';
		}
	else if (($nilku <= '59') AND ($nilku >= '55'))
		{
		$nilkux = '1.33';
		}
		
	else if (($nilku <= '64') AND ($nilku >= '60'))
		{
		$nilkux = '1.67';
		}
	
	else if (($nilku <= '69') AND ($nilku >= '65'))
		{
		$nilkux = '2.00';
		}
	
	else if (($nilku <= '74') AND ($nilku >= '70'))
		{
		$nilkux = '2.33';
		}
		
	else if (($nilku <= '80') AND ($nilku >= '75'))
		{
		$nilkux = '2,67';
		}
	
	else if (($nilku <= '85') AND ($nilku >= '81'))
		{
		$nilkux = '3,00';
		}
	
	else if (($nilku <= '90') AND ($nilku >= '86'))
		{
		$nilkux = '3,33';
		}
	
	else if (($nilku <= '95') AND ($nilku >= '91'))
		{
		$nilkux = '3.67';
		}
	
	else if (($nilku <= '100') AND ($nilku >= '96'))
		{
		$nilkux = '4.00';
		}
	$xpel_nil_antarteman = $nilkux;


	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_nil_amat = nosql($rxpel['rata_sikap_amat']);
	$xpel_nil_dirisendiri = nosql($rxpel['nil_sikap_dirisendiri']);
	$xpel_nil_antarteman = nosql($rxpel['nil_sikap_antarteman']);
	$xpel_nil_catatanguru = nosql($rxpel['nil_sikap_catatanguru']);
	$xpel_rata_sikap = nosql($rxpel['rata_sikap']);
	$xpel_raport_a = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_raport_p = nosql($rxpel['nil_raport_sikap_p']);




	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>
	<input name="nil_rata_amat'.$i_nomer.'" type="text" value="'.$xpel_nil_amat.'" size="3" style="text-align:right" class="input" readonly>
	</td>

	<td>
	<input name="nil_nil_dirisendiri'.$i_nomer.'" type="text" value="'.$xpel_nil_dirisendiri.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_nil_antarteman'.$i_nomer.'" type="text" value="'.$xpel_nil_antarteman.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_nil_catatanguru'.$i_nomer.'" type="text" value="'.$xpel_nil_catatanguru.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport_a'.$i_nomer.'" type="text" value="'.$xpel_raport_a.'" size="3" style="text-align:right" class="input" readonly>
	</td>
	<td>
	<input name="nil_raport_p'.$i_nomer.'" type="text" value="'.$xpel_raport_p.'" size="3" style="text-align:right" class="input" readonly>
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
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
require("../../inc/cek/admortu.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nilai.php";
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$s = nosql($_REQUEST['s']);
$jnil = nosql($_REQUEST['jnil']);


$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&progkd=$progkd";



//siswa ne
$qsiw = mysql_query("SELECT siswa_kelas.*, siswa_kelas.kd AS skkd, m_siswa.* ".
						"FROM siswa_kelas, m_siswa ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND m_siswa.kd = '$kd21_session'");
$rsiw = mysql_fetch_assoc($qsiw);
$siw_nis = nosql($rsiw['nis']);
$siw_nama = balikin($rsiw['nama']);
$skkd = nosql($rsiw['skkd']);


//judul
$judul = "Detail Nilai";
$judulku = "[$ortu_session : $nis21_session.$nm21_session] ==> $judul";
$juduly = $judul;


//focus
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}




//isi *START
ob_start();

//menu
require("../../inc/menu/admortu.php");

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


Jenis Nilai : ';
echo "<select name=\"jnil\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$jnil.'" selected>'.$jnil.'</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&smtkd='.$smtkd.'&jnil=Pengetahuan">Pengetahuan</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&smtkd='.$smtkd.'&jnil=Keterampilan">Keterampilan</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&smtkd='.$smtkd.'&jnil=Sikap">Sikap</option>
</select>

</td>
</tr>
</table>
<br>';


//nek drg
if (empty($smtkd))
	{
	echo '<h4>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</h4>';
	}


else if (empty($jnil))
	{
	echo '<h4>
	<font color="#FF0000"><strong>JENIS NILAI Belum Dipilih...!</strong></font>
	</h4>';
	}


else 
	{
	//query
	$q = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS mpkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	//jika pengetahuan
	if ($jnil == "Pengetahuan")
		{
		echo '<table width="1100" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="5">&nbsp;</td>
		<td width="250"><strong><font color="'.$warnatext.'">Nama Mata Pelajaran</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
		<td width="50"><strong>RATA UH</strong></td>
		<td width="50"><strong>RATA PN</strong></td>
		<td width="50"><strong>NH</strong></td>
		<td width="50"><strong>NUTS</strong></td>
		<td width="50"><strong>NUAS</strong></td>
		<td width="50"><strong>NR</strong></td>
		<td width="50"><strong>NILAI</strong></td>
		<td width="50"><strong>PREDIKAT</strong></td>
		<td width="250"><strong>CATATAN</strong></td>
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
										"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$mpkd'");
				$rdti = mysql_fetch_assoc($qdti);
				$dti_pel = balikin($rdti['prog_pddkn']);
				$dti_kkm = nosql($rdti['kkm']);
	
	
	
				//nil mapel
				$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
										"WHERE kd_siswa_kelas = '$skkd' ".
										"AND kd_smt = '$smtkd' ".
										"AND kd_prog_pddkn = '$mpkd'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_nil_rata_uh = nosql($rxpel['rata_nh']);
				$xpel_nil_rata_pn = nosql($rxpel['rata_tugas']);
				$xpel_nil_nh = nosql($rxpel['nil_nh']);
				$xpel_nil_nuts = nosql($rxpel['nil_uts']);
				$xpel_nil_nuas = nosql($rxpel['nil_uas']);
				$xpel_nil_nr = nosql($rxpel['nil_raport_pengetahuan']);
				$xpel_nil_nr_a = balikin($rxpel['nil_raport_pengetahuan_a']);
				$xpel_nil_nr_p = balikin($rxpel['nil_raport_pengetahuan_p']);
				$xpel_nil_k = balikin($rxpel['nil_k_pengetahuan']);
	
	
				//nilai akhir
				$xpel_nil_nr = round(((3*$xpel_nil_nuas) + (2*$xpel_nil_nuts) + $xpel_nil_nh) / 6,2);
	
	
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
				echo '<td>'.$nomer.'.</td>
				<td>'.$dti_pel.'</td>
				<td>'.$dti_kkm.'</td>
				<td>
				'.$xpel_nil_rata_uh.'
				</td>
	
				<td>
				'.$xpel_nil_rata_pn.'
				</td>
				<td>
				'.$xpel_nil_nh.'
				</td>
				<td>
				'.$xpel_nil_nuts.'
				</td>
				<td>
				'.$xpel_nil_nuas.'
				</td>
				<td>
				'.$xpel_nil_nr.'
				</td>
				<td>
				'.$xpel_nil_nr_a.'
				</td>
				<td>
				'.$xpel_nil_nr_p.'
				</td>
				<td>
				'.$xpel_nil_k.'
				</td>
	
				</tr>';
				}
			while ($row = mysql_fetch_assoc($q));
			}
	
		echo '</table>';
		}




	//jika keterampilan
	else if ($jnil == "Keterampilan")
		{
		echo '<table width="800" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="5">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">Nama Mata Pelajaran</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
		<td width="50"><strong>RATA NP</strong></td>
		<td width="50"><strong>RATA NF</strong></td>
		<td width="50"><strong>RATA NY</strong></td>
		<td width="50"><strong>NR</strong></td>
		<td width="50"><strong>RAPORT A</strong></td>
		<td width="50"><strong>RAPORT P</strong></td>
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
										"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$mpkd'");
				$rdti = mysql_fetch_assoc($qdti);
				$dti_pel = balikin($rdti['prog_pddkn']);
				$dti_kkm = nosql($rdti['kkm']);
	
	
	
				//nil mapel
				$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
										"WHERE kd_siswa_kelas = '$skkd' ".
										"AND kd_smt = '$smtkd' ".
										"AND kd_prog_pddkn = '$mpkd'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_rata_np = nosql($rxpel['rata_praktek']);
				$xpel_rata_nf = nosql($rxpel['rata_folio']);
				$xpel_rata_ny = nosql($rxpel['rata_proyek']);
	
				$xpel_nil_nr = nosql($rxpel['nil_raport_ketrampilan']);
				$xpel_nil_nr_a = balikin($rxpel['nil_raport_ketrampilan_a']);
				$xpel_nil_nr_p = balikin($rxpel['nil_raport_ketrampilan_p']);
	
	
	
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$nomer.'.</td>
				<td>'.$dti_pel.'</td>
				<td>'.$dti_kkm.'</td>
				<td>
				'.$xpel_rata_np.'
				</td>
				<td>
				'.$xpel_rata_nf.'
				</td>
				<td>
				'.$xpel_rata_ny.'
				</td>
				<td>
				'.$xpel_nil_nr.'
				</td>
				<td>
				'.$xpel_nil_nr_a.'
				</td>
				<td>
				'.$xpel_nil_nr_p.'
				</td>

				</tr>';
				}
			while ($row = mysql_fetch_assoc($q));
			}
	
		echo '</table>';
		}




	//jika sikap
	else if ($jnil == "Sikap")
		{
		echo '<table width="800" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="5">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">Nama Mata Pelajaran</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
		<td width="50"><strong>OBSERVASI PENGAMATAN</strong></td>
		<td width="50"><strong>PENILAIAN DIRI SENDIRI</strong></td>
		<td width="50"><strong>PENILAIAN ANTAR TEMAN</strong></td>
		<td width="50"><strong>JURNAL CATATAN GURU</strong></td>
		<td width="50"><strong>NR</strong></td>
		<td width="50"><strong>RAPORT A</strong></td>
		<td width="50"><strong>RAPORT P</strong></td>
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
										"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$mpkd'");
				$rdti = mysql_fetch_assoc($qdti);
				$dti_pel = balikin($rdti['prog_pddkn']);
				$dti_kkm = nosql($rdti['kkm']);
	
	
	

	
				//ambil nilai observasi
				$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
										"FROM siswa_sikap_observasi ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$kelkd' ".
										"AND kd_mapel = '$mpkd' ". 
										"AND kd_siswa = '$kd21_session'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_rata_amatt = nosql($rxpel['total']);
				$nilku = ($xpel_rata_amatt / 20) * 100;
				$xpel_rata_amat = $nilku;
				
	
	
				//ambil nilai diri sendiri
				$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
										"FROM siswa_sikap_dirisendiri ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$kelkd' ".
										"AND kd_mapel = '$mpkd' ". 
										"AND kd_siswa = '$kd21_session'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_nil_dirisendirii = nosql($rxpel['total']);
				$nilku = ($xpel_nil_dirisendirii / 20) * 100;
				$xpel_nil_dirisendiri = $nilku;
	


				//ambil nilai antar teman
				$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
										"FROM siswa_sikap_antarteman ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$kelkd' ".
										"AND kd_mapel = '$mpkd' ". 
										"AND kd_siswa2 = '$kd21_session'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_nil_antartemann = nosql($rxpel['total']);
				$nilku = ($xpel_nil_antartemann / 20) * 100;
				$xpel_nil_antarteman = $nilku;
	
	
				//nil mapel
				$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
										"WHERE kd_siswa_kelas = '$skkd' ".
										"AND kd_smt = '$smtkd' ".
										"AND kd_prog_pddkn = '$mpkd'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_nil_catatanguru = nosql($rxpel['nil_sikap_catatanguru']);
				$xpel_rata_sikap = nosql($rxpel['rata_sikap']);
				$xpel_raport_a = balikin($rxpel['nil_raport_sikap_a']);
				$xpel_raport_p = balikin($rxpel['nil_raport_sikap_p']);
	

	
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$nomer.'.</td>
				<td>'.$dti_pel.'</td>
				<td>'.$dti_kkm.'</td>
				<td>
				'.$xpel_rata_amat.'
				</td>
				<td>
				'.$xpel_nil_dirisendiri.'
				</td>
				<td>
				'.$xpel_nil_antarteman.'
				</td>
				<td>
				'.$xpel_nil_catatanguru.'
				</td>
				<td>
				'.$xpel_rata_sikap.'
				</td>
				<td>
				'.$xpel_raport_a.'
				</td>
				<td>
				'.$xpel_raport_p.'
				</td>
				</tr>';
				}
			while ($row = mysql_fetch_assoc($q));
			}
	
		echo '</table>';
		}



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
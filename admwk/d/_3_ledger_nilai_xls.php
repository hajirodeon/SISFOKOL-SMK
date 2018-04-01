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

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");


nocache;

//nilai
$filenya = "legger_nilai_xls.php";
$i_filename = "Legger_nilai.xls";
$judul = "Legger Nilai";
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$rukd = nosql($_REQUEST['rukd']);
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&rukd=$rukd&smtkd=$smtkd";




//kasi rangking dahulu semuanya..
//looping semester
$qjnsp3 = mysql_query("SELECT * FROM m_smt ".
						"ORDER BY round(no) ASC");
$rjnsp3 = mysql_fetch_assoc($qjnsp3);
$tjnsp3 = mysql_num_rows($qjnsp3);

do
	{
	$jnsp3_smtkd = nosql($rjnsp3['kd']);
	$jnsp3_smtno = nosql($rjnsp3['no']);
	$jnsp3_smt = nosql($rjnsp3['smt']); 


	
	//query data siswa
	$qdata = mysql_query("SELECT siswa_kelas.kd AS skkd, ".
							"siswa_nilai_raport.nil_raport_pengetahuan AS total1, ".
							"siswa_nilai_raport.nil_raport_ketrampilan AS total2 ".
							"FROM m_siswa, siswa_kelas, siswa_nilai_raport ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_nilai_raport.kd_siswa_kelas = siswa_kelas.kd ".
							"AND siswa_nilai_raport.kd_smt = '$jnsp3_smtkd' ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"ORDER BY round(siswa_nilai_raport.nil_raport_pengetahuan) DESC, ".
							"round(siswa_nilai_raport.nil_raport_ketrampilan) DESC");
	$rdata = mysql_fetch_assoc($qdata);
	
	
	do
		{
		//nilai
		$y_nomerr = $y_nomerr + 1;
		$xyz = md5("$x$y_nomerr");
		$y_skkd = nosql($rdata['skkd']);
		$y_total1 = nosql($rdata['total1']);
		$y_total2 = nosql($rdata['total2']);
	
		
	
		//totalnya
		$y_totalnya = round($y_total1 + $y_total2,2);
	
		
		//cek 
		$qcc = mysql_query("SELECT * FROM siswa_rangking ".
								"WHERE kd_siswa_kelas = '$y_skkd' ".
								"AND kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_smt = '$jnsp3_smtkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$nilx_rangking = nosql($rcc['rangking']);
		
		//jika null
		if (!empty($tcc))
			{
			//update
			mysql_query("UPDATE siswa_rangking SET rata_kognitif = '$y_total1', ".
							"rata_psikomotorik = '$y_total2', ".
							"total = '$y_totalnya', ".
							"rangking = '$y_nomer' ".
							"WHERE kd_siswa_kelas = '$y_skkd' ".
							"AND kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_smt = '$jnsp3_smtkd'");
			}
		else
			{
			//insert
			mysql_query("INSERT INTO siswa_rangking(kd, kd_siswa_kelas, kd_tapel, ".
							"kd_kelas, kd_smt, ".
							"rata_kognitif, rata_psikomotorik, total, rangking) VALUES ".
							"('$xyz', '$y_skkd', '$tapelkd', ".
							"'$kelkd', '$jnsp3_smtkd', ".
							"'$y_total1', '$y_total2', '$y_totalnya', '$y_nomer')");
	
			}
		}
	while ($rjnsp3 = mysql_fetch_assoc($qjnsp3));
	}
while ($rdata = mysql_fetch_assoc($qdata));






// Function penanda awal file (Begin Of File) Excel
function xlsBOF()
	{
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	return;
	}

// Function penanda akhir file (End Of File) Excel
function xlsEOF()
	{
	echo pack("ss", 0x0A, 0x00);
	return;
	}



echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';




header("Content-Type: application/x-msexcel");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$i_filename");
header("Expires: 0");
header("Pragma: no-cache");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// memanggil function penanda awal file excel
xlsBOF();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query data siswa
$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
						"siswa_kelas.*, siswa_kelas.kd AS skkd ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"ORDER BY m_siswa.nama ASC");
$rdata = mysql_fetch_assoc($qdata);

echo '<table border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="1" align="center" rowspan="4"><strong>No</strong></td>
<td width="150" align="center" rowspan="4"><strong>NIS</strong></td>
<td width="250" align="center" rowspan="4"><strong>Nama Siswa</strong></td>
<td width="50" align="center" rowspan="4"><strong>Semester</strong></td>';



//query
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"ORDER BY round(no) ASC");
$rjnsp = mysql_fetch_assoc($qjnsp);
$tjnsp = mysql_num_rows($qjnsp);




do
	{
	$i_nomer = $i_nomer + 1;
	$jnsp_kd = nosql($rjnsp['kd']);
	$jnsp_no = nosql($rjnsp['no']);
	$jnsp_jenis = strtoupper(balikin($rjnsp['jenis']));


	//query
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
							"ORDER BY m_prog_pddkn.prog_pddkn ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$tpelx = $tpel * 6; //p k s


	echo '<td colspan="'.$tpelx.'" align="center"><strong>'.$jnsp_jenis.'</strong></td>';
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));








//daftar ekstra
$qkuti = mysql_query("SELECT m_ekstra.* ".
						"FROM m_ekstra ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);


echo '<td width="150" rowspan="4" align="center"><strong>Jumlah Nilai</strong></td>
<td width="150" rowspan="4" align="center"><strong>IPK</strong></td>
<td width="150" rowspan="4" align="center"><strong>Rangking Kelas</strong></td>
<td width="150" align="center" rowspan="3" colspan="3"><strong>TIDAK MASUK KARENA</strong></td>
<td width="150" align="center" rowspan="3" colspan="'.$tkuti.'"><strong>Pengembangan Diri / Ekstra Kurikuler</strong></td>
<td width="250" rowspan="4" align="center"><strong>Deskripsi Antar Mapel</strong></td>
<td width="250" rowspan="4" align="center"><strong>Saran Wali Kelas</strong></td>
</tr>';





//query
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"ORDER BY round(no) ASC");
$rjnsp = mysql_fetch_assoc($qjnsp);
$tjnsp = mysql_num_rows($qjnsp);


echo '<tr bgcolor="'.$warnaheader.'">';


do
	{
	$i_nomer = $i_nomer + 1;
	$jnsp_kd = nosql($rjnsp['kd']);
	$jnsp_no = nosql($rjnsp['no']);
	$jnsp_jenis = strtoupper(balikin($rjnsp['jenis']));


	//query
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
							"ORDER BY m_prog_pddkn.prog_pddkn ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);


	//jika ada 
	if (!empty($tpel))
		{
		do
			{
			//nilai
			$pelkd = nosql($rpel['pelkd']);
			$pel = substr(balikin2($rpel['xpel']),0,35);
			$pel_kkm = nosql($rpel['kkm']);
	

			//guru
			$quru = mysql_query("SELECT m_pegawai.* ".
									"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
									"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
									"AND m_guru.kd_pegawai = m_pegawai.kd ".
									"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd' ".
									"AND m_guru.kd_tapel = '$tapelkd' ".
									"AND m_guru.kd_kelas = '$kelkd' ".
									"AND m_guru.kd_keahlian = '$keahkd'");
			$ruru = mysql_fetch_assoc($quru);
			$nama_guru = balikin($ruru['nama']);
	
	
	
			echo '<td colspan="6" align="center">
			'.$pel.'
			<br>
			['.$nama_guru.']
			</td>';
			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));


echo '</tr>';








//query
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"ORDER BY round(no) ASC");
$rjnsp = mysql_fetch_assoc($qjnsp);
$tjnsp = mysql_num_rows($qjnsp);


echo '<tr bgcolor="'.$warnaheader.'">';


do
	{
	$i_nomer = $i_nomer + 1;
	$jnsp_kd = nosql($rjnsp['kd']);
	$jnsp_no = nosql($rjnsp['no']);
	$jnsp_jenis = strtoupper(balikin($rjnsp['jenis']));


	//query
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
							"ORDER BY m_prog_pddkn.prog_pddkn ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);


	//jika ada
	if (!empty($tpel))
		{
	
		do
			{
			//nilai
			$pelkd = nosql($rpel['pelkd']);
			$pel = substr(balikin2($rpel['xpel']),0,35);
			$pel_kkm = nosql($rpel['kkm']);
	
	
	
			echo '<td colspan="2" align="center">P</td>
			<td colspan="2" align="center">K</td>
			<td colspan="2" align="center">S</td>';
			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));





//query
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"ORDER BY round(no) ASC");
$rjnsp = mysql_fetch_assoc($qjnsp);
$tjnsp = mysql_num_rows($qjnsp);


echo '<tr bgcolor="'.$warnaheader.'">';


do
	{
	$i_nomer = $i_nomer + 1;
	$jnsp_kd = nosql($rjnsp['kd']);
	$jnsp_no = nosql($rjnsp['no']);
	$jnsp_jenis = strtoupper(balikin($rjnsp['jenis']));


	//query
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
							"ORDER BY m_prog_pddkn.prog_pddkn ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);


	//jika ada
	if (!empty($tpel))
		{
		$tpelx = $tpel * 3;

		for ($k=1;$k<=$tpelx;$k++)
			{
			echo '<td align="center">Nilai</td>
			<td align="center">Predikat</td>';
			}

		}
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));







//daftar absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
			"ORDER BY absensi DESC");
$rabs = mysql_fetch_assoc($qabs);

do
	{
	//nilai
	$abs_nil = nosql($rabs['absensi']);

	echo '<td width="10">'.$abs_nil.'</td>';
	}
while ($rabs = mysql_fetch_assoc($qabs));






//daftar ekstra
$qkuti = mysql_query("SELECT m_ekstra.* ".
						"FROM m_ekstra ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);

do
	{
	$kuti_ekstra = balikin($rkuti['ekstra']);

	echo '<td width="10">'.$kuti_ekstra.'</td>';
	}
while ($rkuti = mysql_fetch_assoc($qkuti));


echo '</tr>';




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

	//nilai
	$y_nomer = $y_nomer + 1;
	$y_mskd = nosql($rdata['mskd']);
	$y_skkd = nosql($rdata['skkd']);
	$y_nis = nosql($rdata['nis']);
	$y_nama = balikin($rdata['nama']);




	//query
	$qjnsp3 = mysql_query("SELECT * FROM m_smt ".
							"ORDER BY round(no) ASC");
	$rjnsp3 = mysql_fetch_assoc($qjnsp3);
	$tjnsp3 = mysql_num_rows($qjnsp3);

	do
		{
		$jnsp3_smtkd = nosql($rjnsp3['kd']);
		$jnsp3_smtno = nosql($rjnsp3['no']);
		$jnsp3_smt = nosql($rjnsp3['smt']); 
	
	
		//jika ganjil
		if ($jnsp3_smtno == "1")
			{
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$y_nomer.'</td>
			<td>'.$y_nis.'</td>
			<td>'.$y_nama.'</td>';
			}
		else
			{
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>';
			}
		
		
		echo '<td>'.$jnsp3_smt.'</td>';
		
		//////////////////////////////////////////////////////////////////////////////////////////
	
		//query
		$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
								"ORDER BY round(no) ASC");
		$rjnsp = mysql_fetch_assoc($qjnsp);
		$tjnsp = mysql_num_rows($qjnsp);
		
		
		do
			{
			$jnsp_kd = nosql($rjnsp['kd']);
			$jnsp_no = nosql($rjnsp['no']);
			$jnsp_jenis = strtoupper(balikin($rjnsp['jenis']));
		
		
			//query
			$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
									"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
									"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
									"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
									"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
									"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
									"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
									"ORDER BY m_prog_pddkn.prog_pddkn ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);
	
			//jika ada
			if (!empty($tpel))
				{
			
				do
					{
					//nilai
					$pelkd = nosql($rpel['pelkd']);
					$pel = substr(balikin2($rpel['xpel']),0,35);
					$pel_kkm = nosql($rpel['kkm']);
			
			
					//nilainya...
					$qxnil2 = mysql_query("SELECT * FROM siswa_nilai_raport ".
											"WHERE kd_siswa_kelas = '$y_skkd' ".
											"AND kd_smt = '$smtkd' ".
											"AND kd_prog_pddkn = '$pelkd'");
					$rxnil2 = mysql_fetch_assoc($qxnil2);
					$txnil2 = mysql_num_rows($qxnil2);		
					$xpel_pengetahuan = nosql($rxnil2['nil_raport_pengetahuan']);
					$xpel_ketrampilan = nosql($rxnil2['nil_raport_ketrampilan']);
					$xpel_sikap = nosql($rxnil2['rata_sikap']);
			
			
			
					//predikat
					if ($xpel_pengetahuan == "4.00")
						{
						$xpel_pengetahuan_ket = "A";
						}
					else if (($xpel_pengetahuan < "4.00") AND ($xpel_pengetahuan >= "3.67"))
						{
						$xpel_pengetahuan_ket = "A-";
						}
					else if (($xpel_pengetahuan < "3.67") AND ($xpel_pengetahuan >= "3.33"))
						{
						$xpel_pengetahuan_ket = "B+";
						}
					else if (($xpel_pengetahuan < "3.33") AND ($xpel_pengetahuan >= "3.00"))
						{
						$xpel_pengetahuan_ket = "B";
						}
					else if (($xpel_pengetahuan < "3.00") AND ($xpel_pengetahuan >= "2.67"))
						{
						$xpel_pengetahuan_ket = "B-";
						}
					else if (($xpel_pengetahuan < "2.67") AND ($xpel_pengetahuan >= "2.33"))
						{
						$xpel_pengetahuan_ket = "C+";
						}
					else if (($xpel_pengetahuan < "2.33") AND ($xpel_pengetahuan >= "2.00"))
						{
						$xpel_pengetahuan_ket = "C";
						}
					else if (($xpel_pengetahuan < "2.00") AND ($xpel_pengetahuan >= "1.67"))
						{
						$xpel_pengetahuan_ket = "C-";
						}
					else if (($xpel_pengetahuan < "1.67") AND ($xpel_pengetahuan >= "1.33"))
						{
						$xpel_pengetahuan_ket = "D+";
						}
					else if (($xpel_pengetahuan < "1.33") AND ($xpel_pengetahuan >= "1.00"))
						{
						$xpel_pengetahuan_ket = "D";
						}
			
			
					if ($xpel_ketrampilan == "4.00")
						{
						$xpel_ketrampilan_ket = "A";
						}
					else if (($xpel_ketrampilan < "4.00") AND ($xpel_ketrampilan >= "3.67"))
						{
						$xpel_ketrampilan_ket = "A-";
						}
					else if (($xpel_ketrampilan < "3.67") AND ($xpel_ketrampilan >= "3.33"))
						{
						$xpel_ketrampilan_ket = "B+";
						}
					else if (($xpel_ketrampilan < "3.33") AND ($xpel_ketrampilan >= "3.00"))
						{
						$xpel_ketrampilan_ket = "B";
						}
					else if (($xpel_ketrampilan < "3.00") AND ($xpel_ketrampilan >= "2.67"))
						{
						$xpel_ketrampilan_ket = "B-";
						}
					else if (($xpel_ketrampilan < "2.67") AND ($xpel_ketrampilan >= "2.33"))
						{
						$xpel_ketrampilan_ket = "C+";
						}
					else if (($xpel_ketrampilan < "2.33") AND ($xpel_ketrampilan >= "2.00"))
						{
						$xpel_ketrampilan_ket = "C";
						}
					else if (($xpel_ketrampilan < "2.00") AND ($xpel_ketrampilan >= "1.67"))
						{
						$xpel_ketrampilan_ket = "C-";
						}
					else if (($xpel_ketrampilan < "1.67") AND ($xpel_ketrampilan >= "1.33"))
						{
						$xpel_ketrampilan_ket = "D+";
						}
					else if (($xpel_ketrampilan < "1.33") AND ($xpel_ketrampilan >= "1.00"))
						{
						$xpel_ketrampilan_ket = "D";
						}
			
			
			
					if (($xpel_sikap <= "4.00") AND ($xpel_sikap >= "3.66"))
						{
						$xpel_sikap_ket = "SB";
						}
					else if (($xpel_sikap < "3.66") AND ($xpel_sikap >= "2.66"))
						{
						$xpel_sikap_ket = "B";
						}
					else if (($xpel_sikap < "2.66") AND ($xpel_sikap >= "1.66"))
						{
						$xpel_sikap_ket = "C";
						}
					else if ($xpel_sikap < "1.66")
						{
						$xpel_sikap_ket = "K";
						}
					
		
					echo '<td align="center">'.$xpel_pengetahuan.'</td>
					<td align="center">'.$xpel_pengetahuan_ket.'</td>
					<td align="center">'.$xpel_ketrampilan.'</td>
					<td align="center">'.$xpel_ketrampilan_ket.'</td>
					<td align="center">'.$xpel_sikap.'</td>
					<td align="center">'.$xpel_sikap_ket.'</td>';
	
					}
				while ($rpel = mysql_fetch_assoc($qpel));
				}
			}
		while ($rjnsp = mysql_fetch_assoc($qjnsp));
		
					
		
		
	
		//jumlah total
		//nil mapel
		$qxpel = mysql_query("SELECT SUM(nil_raport_pengetahuan) AS totalku, ".
								"SUM(nil_raport_ketrampilan) AS totalku2 ".
								"FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$y_skkd' ".
								"AND kd_smt = '$smtkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$totalku = nosql($rxpel['totalku']);
		$totalku2 = nosql($rxpel['totalku2']);
		$totalnyax = $totalku + $totalku2;
		
	
	
	
		//jml mapel
		$qpel = mysql_query("SELECT m_prog_pddkn.* ".
								"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
								"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
								"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
								"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'".
								"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'");
		$rpel = mysql_fetch_assoc($qpel);
		$tpel = mysql_num_rows($qpel);
		
		
		
		//nil mapel
		$qxpel = mysql_query("SELECT SUM(nil_raport_pengetahuan) AS totalku, ".
								"SUM(nil_raport_ketrampilan) AS totalku2 ".
								"FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$y_skkd' ".
								"AND kd_smt = '$smtkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$totalku = nosql($rxpel['totalku']);
		$totalku2 = nosql($rxpel['totalku2']);
		$ipk = round(($totalku + $totalku2) / (($tpel * 2) - 2),2);
	
	
		//query
		$qkunilx2 = mysql_query("SELECT * FROM siswa_rangking ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_keahlian ='$keahkd' ".
									"AND kd_kelas ='$kelkd' ".
									"AND kd_siswa_kelas = '$y_skkd' ".
									"AND kd_smt = '$smtkd'");
		$rkunilx2 = mysql_fetch_assoc($qkunilx2);
		$tkunilx2 = mysql_num_rows($qkunilx2);
		$kunilx2_rangking = nosql($rkunilx2['rangking']);
	
	
		echo '<td align="center"><strong>'.$totalnyax.'</strong></td>
		<td align="center"><strong>'.$ipk.'</strong></td>
		<td align="center"><strong>'.$kunilx2_rangking.'</strong></td>';
	
	
	
	
		//daftar absensi
		$qabs = mysql_query("SELECT * FROM m_absensi ".
					"ORDER BY absensi DESC");
		$rabs = mysql_fetch_assoc($qabs);
	
		do
			{
			//nilai
			$abs_kd = nosql($rabs['kd']);
			$abs_nil = nosql($rabs['absensi']);
	
	
			//jml. absensi...
			$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
									"WHERE kd_siswa_kelas = '$y_skkd' ".
									"AND kd_absensi = '$abs_kd'");
			$rbsi = mysql_fetch_assoc($qbsi);
			$tbsi = mysql_num_rows($qbsi);
	
	
			echo '<td width="10">'.$tbsi.'</td>';
			}
		while ($rabs = mysql_fetch_assoc($qabs));
	
	
	
	
	
		//daftar ekstra
		$qkuti = mysql_query("SELECT m_ekstra.* ".
					"FROM m_ekstra ".
					"ORDER BY m_ekstra.ekstra ASC");
		$rkuti = mysql_fetch_assoc($qkuti);
		$tkuti = mysql_num_rows($qkuti);
	
		do
			{
			$kuti_kd = nosql($rkuti['kd']);
			$kuti_ekstra = balikin($rkuti['ekstra']);
	
	
			//daftar ekstra yang diikuti
			$qkuti2 = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd ".
									"FROM siswa_ekstra ".
									"WHERE siswa_ekstra.kd_ekstra = '$kuti_kd' ".
									"AND siswa_ekstra.kd_siswa_kelas = '$y_skkd' ".
									"AND siswa_ekstra.kd_smt = '$smtkd'");
			$rkuti2 = mysql_fetch_assoc($qkuti2);
			$tkuti2 = mysql_num_rows($qkuti2);
	
			do
				{
				$kuti2_kd = nosql($rkuti2['sekd']);
				$kuti2_predikat = nosql($rkuti2['predikat']);
	
	
				echo '<td width="10">'.$kuti2_predikat.'</td>';
				}
			while ($rkuti2 = mysql_fetch_assoc($qkuti2));
			}
		while ($rkuti = mysql_fetch_assoc($qkuti));
	
	
	
		//catatan
		$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
								"WHERE kd_siswa_kelas = '$y_skkd' ".
								"AND kd_smt = '$smtkd'");
		$rcatx = mysql_fetch_assoc($qcatx);
		$tcatx = mysql_num_rows($qcatx);
		$catx_catatan = balikin($rcatx['catatan']);
	
	
		echo '<td>'.$catx_catatan.'</td>';
		
		//saran
		$qbsi = mysql_query("SELECT * FROM siswa_saran ".
							"WHERE kd_siswa_kelas = '$y_skkd' ".
							"AND kd_smt = '$smtkd'");
		$rbsi = mysql_fetch_assoc($qbsi);
		$bsi_saran = balikin($rbsi['saran']);
	
		echo '<td>'.$bsi_saran.'</td>';	
		
		echo '</tr>';
		}
	while ($rjnsp3 = mysql_fetch_assoc($qjnsp3));
				
	}
while ($rdata = mysql_fetch_assoc($qdata));


echo '</table>
<br><br><br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// memanggil function penanda akhir file excel
xlsEOF();
exit();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//diskonek
xclose($koneksi);
exit();
?>
<?php
//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/nilai.php");

nocache;

//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$skkd = nosql($_REQUEST['skkd']);
$judul = "RAPORT AKHIR SEMESTER";



//start class
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);

//data diri
$qd = mysql_query("SELECT m_siswa.*, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd = '$skkd'");
$rd = mysql_fetch_assoc($qd);
$nama = balikin2($rd['nama']);
$nis = nosql($rd['nis']);


//kelas
$qk = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd = '$kelkd'");
$rk = mysql_fetch_assoc($qk);
$rkel = nosql($rk['kelas']);


//program
$qpro = mysql_query("SELECT * FROM m_program ".
					"WHERE kd = '$keahkd'");
$rpro = mysql_fetch_assoc($qpro);
$program = balikin($rpro['program']);



//ruang
$qu = mysql_query("SELECT * FROM m_ruang ".
					"WHERE kd = '$kompkd'");
$ru = mysql_fetch_assoc($qu);
$rru = balikin($ru['ruang']);
$kelas = "$rkel-$rru";


//smt
$qmt = mysql_query("SELECT * FROM m_smt ".
					"WHERE kd = '$smtkd'");
$rmt = mysql_fetch_assoc($qmt);
$smt = balikin($rmt['smt']);

//tapel
$qtp = mysql_query("SELECT * FROM m_tapel ".
					"WHERE kd = '$tapelkd'");
$rtp = mysql_fetch_assoc($qtp);
$thn1 = nosql($rtp['tahun1']);
$thn2 = nosql($rtp['tahun2']);
$tapel = "$thn1/$thn2";

//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$tapelkd' ".
						"AND m_walikelas.kd_kelas = '$kelkd' ".
						"AND m_walikelas.kd_keahlian = '$keahkd' ".
						"AND m_walikelas.kd_keahlian_kompetensi = '$kompkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin2($rwk['nama']);



///////////////////////////////////////////////////////// HALAMAN I //////////////////////////////////////////////////////////////////////

//header page ///////////////////////////////////////////
$pdf->SetY(10);
$pdf->SetX(10);
$pdf->Headerku();


//header table //////////////////////////////////////////
$htg = 15; //tinggi
$hkr = 5; //dari kiri
$pdf->SetFont('Times','B',7);

//posisi
$pdf->SetY(55);
$pdf->SetFillColor(233,233,233);

//no
$pdf->SetX(10);
$pdf->Cell(172,12,'',0,0,'C',1);


//no
$pdf->SetY(55);
$pdf->SetX(10);
$pdf->Cell(10,12,'NO.',1,0,'C',1);

//mapel
$pdf->SetX(20);
$pdf->Cell(90,12,'MATA PELAJARAN',1,0,'C',1);

//kognitif
$pdf->SetY(55);
$pdf->SetX(110);
$pdf->MultiCell(24, 3, 'PENGETAHUAN (KOGNITIF)', 1, 'C');

//angka
$pdf->SetY(61);
$pdf->SetX(110);
$pdf->Cell(12,6,'Angka',1,0,'C',1);

//huruf
$pdf->SetY(61);
$pdf->SetX(122);
$pdf->Cell(12,6,'Huruf',1,0,'C',1);

//psikomotorik
$pdf->SetY(55);
$pdf->SetX(134);
$pdf->MultiCell(24, 3, 'KETRAMPILAN (PSIKOMOTOR)', 1, 'C');


//angka
$pdf->SetY(61);
$pdf->SetX(134);
$pdf->Cell(12,6,'Angka',1,0,'C',1);

//huruf
$pdf->SetY(61);
$pdf->SetX(146);
$pdf->Cell(12,6,'Huruf',1,0,'C',1);




//sikap
$pdf->SetY(55);
$pdf->SetX(158);
$pdf->MultiCell(24, 3, 'SIKAP SOSIAL DAN SPIRITUAL', 1, 'C');


//angka
$pdf->SetY(61);
$pdf->SetX(158);
$pdf->MultiCell(12, 3, 'DALAM MAPEL', 1, 'C');

//huruf
$pdf->SetY(61);
$pdf->SetX(170);
$pdf->MultiCell(12, 3, 'ANTAR MAPEL', 1, 'C');

/////////////////////////////////////////////////////////



//mapel /////////////////////////////////////////////////
$pdf->SetY(67);
$pdf->SetX(10);



//looping kelompok
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no_sub = '' ".
						"AND no = '1' ".
						"OR no = '2' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Times','B',7);
	$pdf->Cell(160,5,$ku_jenis,1,0,'L',1);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Times','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	
	
	//jika nol
	if (empty($tpel))
		{
		$tpel = 1;
		}
	
	
	$total_1 = $tpel;
	
	
	do
		{
		$pelkd = nosql($rpel['pelkd']);
		$pel = balikin2($rpel['prog_pddkn']);
		$pel_kkm = nosql($rpel['kkm']);
		$j = $j + 1;
	
		//mapel /////////////////////////////////////////////
		//posisi
		$pdf->SetX(10);
		$nilY = 5;
		$pdf->Cell(10,$nilY,"$j.",1,0,'C');
		$pdf->Cell(90,$nilY,$pel,1,0,'L');
	
	
		//nil mapel
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$pelkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan']);
		$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan']);
		$xpel_sikap = nosql($rxpel['rata_sikap']);



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



		if ($xpel_sikap == "4.00")
			{
			$xpel_sikap_ket = "A";
			}
		else if (($xpel_sikap < "4.00") AND ($xpel_sikap >= "3.67"))
			{
			$xpel_sikap_ket = "A-";
			}
		else if (($xpel_sikap < "3.67") AND ($xpel_sikap >= "3.33"))
			{
			$xpel_sikap_ket = "B+";
			}
		else if (($xpel_sikap < "3.33") AND ($xpel_sikap >= "3.00"))
			{
			$xpel_sikap_ket = "B";
			}
		else if (($xpel_sikap < "3.00") AND ($xpel_sikap >= "2.67"))
			{
			$xpel_sikap_ket = "B-";
			}
		else if (($xpel_sikap < "2.67") AND ($xpel_sikap >= "2.33"))
			{
			$xpel_sikap_ket = "C+";
			}
		else if (($xpel_sikap < "2.33") AND ($xpel_sikap >= "2.00"))
			{
			$xpel_sikap_ket = "C";
			}
		else if (($xpel_sikap < "2.00") AND ($xpel_sikap >= "1.67"))
			{
			$xpel_sikap_ket = "C-";
			}
		else if (($xpel_sikap < "1.67") AND ($xpel_sikap >= "1.33"))
			{
			$xpel_sikap_ket = "D+";
			}
		else if (($xpel_sikap < "1.33") AND ($xpel_sikap >= "1.00"))
			{
			$xpel_sikap_ket = "D";
			}


		

		$pdf->Cell(12,$nilY,$xpel_pengetahuan,1,0,'L');
		$pdf->Cell(12,$nilY,$xpel_pengetahuan_ket,1,0,'L');
		$pdf->Cell(12,$nilY,$xpel_ketrampilan,1,0,'L');
		$pdf->Cell(12,$nilY,$xpel_ketrampilan_ket,1,0,'L');
		$pdf->Cell(12,$nilY,$xpel_sikap,1,0,'L');
		$pdf->Ln();
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rku = mysql_fetch_assoc($qku));








//looping kelompok 3 atau c
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '3' ".
						"AND no_sub = '' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Times','B',7);
	$pdf->Cell(160,5,$ku_jenis,1,0,'L',1);

	}
while ($rku = mysql_fetch_assoc($qku));

$pdf->Ln();



//looping kelompok 3 atau c
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '3' ".
						"AND no_sub <> '' ".
						"ORDER BY no_sub ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no_sub']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Times','B',7);
	$pdf->Cell(10,5,$ku_no,1,0,'C',1);
	$pdf->Cell(150,5,$ku_jenis,1,0,'L',1);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Times','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	
	
	//jika nol
	if (empty($tpel))
		{
		$tpel = 1;
		}
	
	
	$total_1 = $tpel;
	
	
	do
		{
		$pelkd = nosql($rpel['pelkd']);
		$pel = balikin2($rpel['prog_pddkn']);
		$pel_kkm = nosql($rpel['kkm']);
		$j = $j + 1;
	
		//mapel /////////////////////////////////////////////
		//posisi
		$pdf->SetX(10);
		$nilY = 5;
		$pdf->Cell(10,$nilY,"$j.",1,0,'C');
		$pdf->Cell(90,$nilY,$pel,1,0,'L');
	
	
		//nil mapel
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$pelkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan']);
		$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan']);
		$xpel_sikap = nosql($rxpel['rata_sikap']);



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



		if ($xpel_sikap == "4.00")
			{
			$xpel_sikap_ket = "A";
			}
		else if (($xpel_sikap < "4.00") AND ($xpel_sikap >= "3.67"))
			{
			$xpel_sikap_ket = "A-";
			}
		else if (($xpel_sikap < "3.67") AND ($xpel_sikap >= "3.33"))
			{
			$xpel_sikap_ket = "B+";
			}
		else if (($xpel_sikap < "3.33") AND ($xpel_sikap >= "3.00"))
			{
			$xpel_sikap_ket = "B";
			}
		else if (($xpel_sikap < "3.00") AND ($xpel_sikap >= "2.67"))
			{
			$xpel_sikap_ket = "B-";
			}
		else if (($xpel_sikap < "2.67") AND ($xpel_sikap >= "2.33"))
			{
			$xpel_sikap_ket = "C+";
			}
		else if (($xpel_sikap < "2.33") AND ($xpel_sikap >= "2.00"))
			{
			$xpel_sikap_ket = "C";
			}
		else if (($xpel_sikap < "2.00") AND ($xpel_sikap >= "1.67"))
			{
			$xpel_sikap_ket = "C-";
			}
		else if (($xpel_sikap < "1.67") AND ($xpel_sikap >= "1.33"))
			{
			$xpel_sikap_ket = "D+";
			}
		else if (($xpel_sikap < "1.33") AND ($xpel_sikap >= "1.00"))
			{
			$xpel_sikap_ket = "D";
			}


		

		$pdf->Cell(12,$nilY,$xpel_pengetahuan,1,0,'L');
		$pdf->Cell(12,$nilY,$xpel_pengetahuan_ket,1,0,'L');
		$pdf->Cell(12,$nilY,$xpel_ketrampilan,1,0,'L');
		$pdf->Cell(12,$nilY,$xpel_ketrampilan_ket,1,0,'L');
		$pdf->Cell(12,$nilY,$xpel_sikap,1,0,'L');
		$pdf->Ln();
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rku = mysql_fetch_assoc($qku));










//jumlah nilai //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nilaine...
$qnilx = mysql_query("SELECT * FROM siswa_rangking ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_keahlian = '$keahkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_keahlian_kompetensi = '$kompkd' ".
						"AND kd_smt = '$smtkd'");
$rnilx = mysql_fetch_assoc($qnilx);
$tnilx = mysql_num_rows($qnilx);
$nilx_total_kognitif = nosql($rnilx['total_kognitif']);
$nilx_rata_kognitif = nosql($rnilx['rata_kognitif']);
$nilx_total_psikomotorik = nosql($rnilx['total_psikomotorik']);
$nilx_rata_psikomotorik = nosql($rnilx['rata_psikomotorik']);
$nilx_rangking = nosql($rnilx['rangking']);


//jumlah siswa sekelas
$qjks = mysql_query("SELECT * FROM siswa_kelas ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_keahlian = '$keahkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_keahlian_kompetensi = '$kompkd'");
$rjks = mysql_fetch_assoc($qjks);
$tjks = mysql_num_rows($qjks);


//peringkat ke...
$jks_nilx_rangking = xongkof($nilx_rangking);
$jks_tjks = xongkof($tjks);
$jks_rangking = "$nilx_rangking ( $jks_nilx_rangking) dari $tjks ( $jks_tjks) siswa";



$pdf->SetX(10);
$pdf->SetFont('Times','',5);
$pdf->Cell(45,5,'Peringkat Ke : '.$jks_rangking.'',0,0,'L');

$pdf->Ln();


//ketahui posisi Y
$nily_Y = $pdf->GetY();



//ekstra /////////////////////////////////////////////////
//font & color
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Times','B',7);

//no
$pdf->SetX(10);
$pdf->Cell(5,5,'No.',1,0,'C',1);

$pdf->SetX(15);
$pdf->Cell(30,5,'Kegiatan Ekstrakurikuler ',1,0,'L',1);

$pdf->SetX(45);
$pdf->Cell(10,5,'Nilai',1,0,'C',1);

$pdf->SetX(55);
$pdf->Cell(30,5,'Keterangan',1,0,'C',1);


$pdf->Ln();
$pdf->SetFillColor(255,255,255);

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$skkd' ".
						"AND siswa_ekstra.kd_smt = '$smtkd' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);

do
	{
	$pdf->SetX(10);

	$nomx = $nomx + 1;
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);

	$pdf->Cell(5,5,$nomx,1,0,'C',1);
	$pdf->Cell(30,5,$kuti_ekstrax,1,0,'L',1);
	$pdf->Cell(10,5,$kuti_predikat,1,0,'C',1);
	$pdf->Cell(30,5,$kuti_ket,1,0,'L',1);
	$pdf->Ln();
	}
while ($rkuti = mysql_fetch_assoc($qkuti));





//pribadi ///////////////////////////////////////////////
//posisi
$pdf->Ln();
$pdf->SetY($nily_Y);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Times','B',7);

//no
$pdf->SetX(90);
$pdf->Cell(5,5,'No.',1,0,'C',1);

$pdf->SetX(95);
$pdf->Cell(35,5,'Kepribadian',1,0,'L',1);

$pdf->SetX(130);
$pdf->Cell(15,5,'Predikat',1,0,'C',1);

$pdf->SetX(145);
$pdf->Cell(20,5,'Keterangan',1,0,'C',1);


$pdf->Ln();
$pdf->SetFillColor(255,255,255);

//daftar pribadi
$qpri = mysql_query("SELECT * FROM m_pribadi ".
						"ORDER BY pribadi ASC");
$rpri = mysql_fetch_assoc($qpri);
$tpri = mysql_num_rows($qpri);

do
	{
	$pdf->SetX(90);

	$nomuz = $nomuz + 1;
	$pri_kd = nosql($rpri['kd']);
	$pri_pribadi = balikin($rpri['pribadi']);
	$pri_pribadix = "$nomuz. $pri_pribadi";

	//pribadinya...
	$qprix = mysql_query("SELECT * FROM siswa_pribadi ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_pribadi = '$pri_kd'");
	$rprix = mysql_fetch_assoc($qprix);
	$tprix = mysql_num_rows($qprix);
	$prix_predikat = nosql($rprix['predikat']);
	$prix_ket = balikin($rprix['ket']);


	$pdf->Cell(5,5,''.$nomuz.'.',1,0,'C',1);
	$pdf->Cell(35,5,$pri_pribadix,1,0,'L',1);
	$pdf->Cell(15,5,$prix_predikat,1,0,'C',1);
	$pdf->Cell(20,5,$prix_ket,1,0,'L',1);
	$pdf->Ln();
	}
while ($rpri = mysql_fetch_assoc($qpri));




//absensi ///////////////////////////////////////////////
//posisi
$pdf->Ln();
$pdf->Ln();
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Times','B',7);

//no
$pdf->SetX(10);
$pdf->Cell(5,5,'No',1,0,'C',1);

$pdf->SetX(15);
$pdf->Cell(30,5,'Ketidakhadiran',1,0,'L',1);

$pdf->SetX(45);
$pdf->Cell(20,5,'Jumlah Hari',1,0,'L',1);
$pdf->Ln();
$pdf->SetFillColor(255,255,255);

//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

do
	{
	$pdf->SetX(10);

	$nomxz = $nomxz + 1;
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);
	$abs_absensix = "$nomxz. $abs_absensi";

	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_absensi = '$abs_kd'");
	$rbsi = mysql_fetch_assoc($qbsi);
	$tbsi = mysql_num_rows($qbsi);

	//nek null
	if (empty($tbsi))
		{
		$tbsix = "- hari";
		}
	else
		{
		$tbsix = "$tbsi hari";
		}



	$pdf->Cell(5,5,''.$nomxz.'.',1,0,'C',1);
	$pdf->Cell(30,5,$abs_absensix,1,0,'L',1);
	$pdf->Cell(20,5,$tbsix,1,0,'L',1);
	$pdf->Ln();
	}
while ($rabs = mysql_fetch_assoc($qabs));







//naik ato lulus, ///////////////////////////////////////////////
//posisi
$pdf->Ln();
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Times','B',7);


//tapel
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);



//kelas
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);

//smt
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

//jika kenaikan kelas (X, XI)
if ((($btxno == "1") OR ($btxno == "2")) AND ($stx_no  == "2"))
	{
	//terjemahkan tapel
	$tpy_thn1 = $tpx_thn1 + 1;
	$tpy_thn2 = $tpx_thn2 + 1;

	$qtpf = mysql_query("SELECT * FROM m_tapel ".
							"WHERE tahun1 = '$tpy_thn1' ".
							"AND tahun2 = '$tpy_thn2'");
	$rtpf = mysql_fetch_assoc($qtpf);
	$tpf_kd = nosql($rtpf['kd']);


	//naik...?
	$qnuk = mysql_query("SELECT * FROM siswa_naik ".
							"WHERE kd_siswa_kelas = '$skkd'");
	$rnuk = mysql_fetch_assoc($qnuk);
	$nuk_naik = nosql($rnuk['naik']);


	if ($nuk_naik == "true")
		{
		//posisi
		$pdf->Ln();
		$pdf->SetX(10);
		$pdf->Cell(170,5,'Keterangan Kenaikan Kelas : NAIK',1,0,'L',1);
		}
	else if ($nuk_naik == "false")
		{
		//posisi
		$pdf->Ln();
		$pdf->SetX(10);
		$pdf->Cell(170,5,'Keterangan Kenaikan Kelas : TIDAK NAIK',1,0,'L',1);
		}
	}




//jika kelulusan
else if (($btxno == "3") AND ($stx_no  == "2"))
	{
	//terjemahkan tapel
	$tpy_thn1 = $tpx_thn1 + 1;
	$tpy_thn2 = $tpx_thn2 + 1;

	//tapel baru
	$qtpf = mysql_query("SELECT * FROM m_tapel ".
							"WHERE tahun1 = '$tpy_thn1' ".
							"AND tahun2 = '$tpy_thn2'");
	$rtpf = mysql_fetch_assoc($qtpf);
	$tpf_kd = nosql($rtpf['kd']);


	//status kelulusan
	$qlus = mysql_query("SELECT * FROM siswa_lulus ".
							"WHERE kd_tapel = '$tpf_kd' ".
							"AND kd_siswa_kelas = '$skkd'");
	$rlus = mysql_fetch_assoc($qlus);
	$lus_nilai = nosql($rlus['lulus']);

	//lulus ato tidal
	if ($lus_nilai == "true")
		{
		//posisi
		$pdf->Ln();
		$pdf->SetX(10);
		$pdf->Cell(170,5,'Telah menyelesaikan seluruh Program Pembelajaran di $sek_nama, sampai kelas XII',1,0,'L',1);
		}
	else if ($lus_nilai == "false")
		{
		//posisi
		$pdf->Ln();
		$pdf->SetX(10);
		$pdf->Cell(170,5,'TIDAK LULUS',1,0,'L',1);
		}
	}












//Tanda tangan dan tgl ////////////////////////////////////////
$pdf->SetFont('Times','B',10);

$pdf->SetY($pdf->GetY());
$pdf->SetX(130);
$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
$pdf->Cell(50,5,$nil_tgl,0,0,'R');

$pdf->SetY($pdf->GetY()+5);
$pdf->SetX(75);
$pdf->Cell(50,5,'Mengetahui',0,0,'C');

$pdf->SetY($pdf->GetY()+5);
$pdf->SetX(10);
$pdf->Cell(50,5,'Orang Tua / Wali Peserta Didik',0,0,'C');

$pdf->SetX(75);
$pdf->Cell(50,5,'Kepala Sekolah',0,0,'C');

$pdf->SetX(130);
$pdf->Cell(50,5,'Wali Kelas',0,0,'C');

$pdf->SetY($pdf->GetY()+20);
$pdf->SetX(10);

//ortu
$pdf->SetX(11);
$pdf->Cell(50,2,'(....................................)',0,0,'C');


//kepala sekolah
$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
						"FROM admin_ks, m_pegawai ".
						"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
$rks = mysql_fetch_assoc($qks);
$tks = mysql_num_rows($qks);
$ks_nip = nosql($rks['nip']);
$ks_nama = balikin($rks['nama']);

//posisi
$pdf->SetX(75);
$pdf->Cell(50,2,'(...'.$ks_nama.'...)',0,0,'C');


//wali kelas
if (empty($nwk))
	{
	$pdf->SetX(130);
	$pdf->Cell(50,2,'(....................................)',0,0,'C');
	}
else
	{
	$pdf->SetX(130);
	$pdf->Cell(50,2,'(...'.$nwk.'...)',0,0,'C');
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//catatan ///////////////////////////////////////////////
//posisi
$pdf->Ln();
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Times','B',7);

//catatan
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);


//data mapel
$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'".
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);


//antar mapel atau catatan walikelas
$pdf->SetY(67);
$pdf->SetX(170);
$pdf->SetFont('Times','',7);
$total_y = ($tpel * 5) + 30 + 20; 
//$pdf->Cell(12,$total_y,$catx_catatan,1,0,'L',1);
$pdf->Cell(12,$total_y,'',1,0,'L',1);
$pdf->SetX(170);
$pdf->MultiCell(10, 3, $catx_catatan, 0, 'L');











////////////////////////////////////////////////////////// HALAMAN II //////////////////////////////////////////////////////////////////
$pdf->AddPage();

//header page/////////////////////////////////////////////
$pdf->SetY(10);
$pdf->SetX(10);
$pdf->Headerku();


//header page ///////////////////////////////////////////
$pdf->SetY(10);
$pdf->SetX(10);
$pdf->Headerku();


//header table //////////////////////////////////////////
$htg = 15; //tinggi
$hkr = 5; //dari kiri
$pdf->SetFont('Times','B',7);

//posisi
$pdf->SetY(55);
$pdf->SetFillColor(233,233,233);

//mapel
$pdf->SetX(10);
$pdf->Cell(60,7,'MATA PELAJARAN',1,0,'C',1);

//kompetensi
$pdf->SetX(70);
$pdf->Cell(40,7,'KOMPETENSI',1,0,'C',1);

//catatan
$pdf->SetX(110);
$pdf->Cell(90,7,'CATATAN',1,0,'C',1);





//mapel /////////////////////////////////////////////////
$pdf->SetY(62);
$pdf->SetX(10);



//looping kelompok
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no_sub = '' ".
						"AND no = '1' ".
						"OR no = '2' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Times','B',7);
	$pdf->Cell(190,5,$ku_jenis,1,0,'L',1);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Times','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	
	
	//jika nol
	if (empty($tpel))
		{
		$tpel = 1;
		}
	
	
	$total_1 = $tpel;
	
	
	do
		{
		$pelkd = nosql($rpel['pelkd']);
		$pel = balikin2($rpel['prog_pddkn']);
		$pel_kkm = nosql($rpel['kkm']);
		$jk = $jk + 1;
	
		//mapel /////////////////////////////////////////////
		//posisi
		$pdf->SetX(10);
		$nilY = 5;
		//$pdf->Cell(10,$nilY,"$jk.",1,0,'C');
		$pdf->MultiCell(5, 15, "$jk.", 1, 'L');
		$posisi_y = $pdf->GetY();
		
		$pdf->SetY($posisi_y-15);
		$pdf->SetX(15);
		//$pdf->Cell(50,$nilY,$pel,1,0,'L');
		$pdf->MultiCell(55, 15, $pel, 1, 'L');	
	
		//nil mapel
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$pelkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_pengetahuan = nosql($rxpel['nil_k_pengetahuan']);
		$xpel_ketrampilan = nosql($rxpel['nil_k_ketrampilan']);
		$xpel_sikap = nosql($rxpel['nil_k_sikap']);




		$posisi_y = $pdf->GetY();
		
		$pdf->SetY($posisi_y-15);
		//posisi
		$pdf->SetX(70);
		$pdf->Cell(40,$nilY,"Pengetahuan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,$nilY,"Ketrampilan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,$nilY,"Sikap Spiritual dan Sosial",1,0,'L');
		
		$posisi_y1 = $pdf->GetY();
		
		$pdf->SetY($posisi_y-15);
		$pdf->SetX(110);
		$pdf->Cell(90,$nilY,$xpel_pengetahuan,1,0,'L');
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,$nilY,$xpel_ketrampilan,1,0,'L');
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,$nilY,$xpel_sikap,1,0,'L');
		$pdf->Ln();
		
		
		$pdf->SetY($posisi_y);
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rku = mysql_fetch_assoc($qku));








//looping kelompok 3 atau c
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '3' ".
						"AND no_sub = '' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Times','B',7);
	$pdf->Cell(190,5,$ku_jenis,1,0,'L',1);

	}
while ($rku = mysql_fetch_assoc($qku));

$pdf->Ln();



//looping kelompok 3 atau c
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '3' ".
						"AND no_sub <> '' ".
						"ORDER BY no_sub ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no_sub']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Times','B',7);
	$pdf->Cell(5,5,$ku_no,1,0,'C',1);
	$pdf->Cell(195,5,$ku_jenis,1,0,'L',1);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Times','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	
	
	//jika nol
	if (empty($tpel))
		{
		$tpel = 1;
		}
	
	
	$total_1 = $tpel;
	
	
	do
		{
		$pelkd = nosql($rpel['pelkd']);
		$pel = balikin2($rpel['prog_pddkn']);
		$pel_kkm = nosql($rpel['kkm']);
		$jk = $jk + 1;
	
		//mapel /////////////////////////////////////////////
		//posisi
		$pdf->SetX(10);
		$nilY = 5;
		//$pdf->Cell(10,$nilY,"$jk.",1,0,'C');
		$pdf->MultiCell(5, 15, "$jk.", 1, 'L');
		$posisi_y = $pdf->GetY();
		
		$pdf->SetY($posisi_y-15);
		$pdf->SetX(15);
		//$pdf->Cell(50,$nilY,$pel,1,0,'L');
		$pdf->MultiCell(55, 15, $pel, 1, 'L');	
	
		//nil mapel
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$pelkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_pengetahuan = nosql($rxpel['nil_k_pengetahuan']);
		$xpel_ketrampilan = nosql($rxpel['nil_k_ketrampilan']);
		$xpel_sikap = nosql($rxpel['nil_k_sikap']);




		$posisi_y = $pdf->GetY();
		
		$pdf->SetY($posisi_y-15);
		//posisi
		$pdf->SetX(70);
		$pdf->Cell(40,$nilY,"Pengetahuan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,$nilY,"Ketrampilan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,$nilY,"Sikap Spiritual dan Sosial",1,0,'L');
		
		$posisi_y1 = $pdf->GetY();
		
		$pdf->SetY($posisi_y-15);
		$pdf->SetX(110);
		$pdf->Cell(90,$nilY,$xpel_pengetahuan,1,0,'L');
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,$nilY,$xpel_ketrampilan,1,0,'L');
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,$nilY,$xpel_sikap,1,0,'L');
		$pdf->Ln();
		
		
		$pdf->SetY($posisi_y);

		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rku = mysql_fetch_assoc($qku));













//Tanda tangan dan tgl ////////////////////////////////////////
$pdf->SetFont('Times','B',10);

$pdf->SetY($pdf->GetY());
$pdf->SetX(130);
$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
$pdf->Cell(50,5,$nil_tgl,0,0,'R');

$pdf->SetY($pdf->GetY()+5);
$pdf->SetX(75);
$pdf->Cell(50,5,'Mengetahui',0,0,'C');

$pdf->SetY($pdf->GetY()+5);
$pdf->SetX(10);
$pdf->Cell(50,5,'Orang Tua / Wali Peserta Didik',0,0,'C');

$pdf->SetX(75);
$pdf->Cell(50,5,'Kepala Sekolah',0,0,'C');

$pdf->SetX(130);
$pdf->Cell(50,5,'Wali Kelas',0,0,'C');

$pdf->SetY($pdf->GetY()+20);
$pdf->SetX(10);

//ortu
$pdf->SetX(11);
$pdf->Cell(50,2,'(....................................)',0,0,'C');


//kepala sekolah
$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
						"FROM admin_ks, m_pegawai ".
						"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
$rks = mysql_fetch_assoc($qks);
$tks = mysql_num_rows($qks);
$ks_nip = nosql($rks['nip']);
$ks_nama = balikin($rks['nama']);

//posisi
$pdf->SetX(75);
$pdf->Cell(50,2,'(...'.$ks_nama.'...)',0,0,'C');


//wali kelas
if (empty($nwk))
	{
	$pdf->SetX(130);
	$pdf->Cell(50,2,'(....................................)',0,0,'C');
	}
else
	{
	$pdf->SetX(130);
	$pdf->Cell(50,2,'(...'.$nwk.'...)',0,0,'C');
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////











//output-kan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->Output("raport_semester_$nis.pdf",I);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
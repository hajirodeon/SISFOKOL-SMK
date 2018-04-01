<?php
//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/raport.php");

nocache;

//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$skkd = nosql($_REQUEST['skkd']);



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
$smtno = nosql($rmt['no']);

//jika awal smt
if ($smtno == "1")
	{
	$judul = "RAPORT MID SEMESTER";
	}
else
	{
	$judul = "RAPORT AKHIR SEMESTER";
	}



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
						"AND m_walikelas.kd_kelas = '$kelkd'");
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
$pdf->SetFont('Arial','B',7);

//posisi
$pdf->SetY(45);
$pdf->SetFillColor(233,233,233);

//no
$pdf->SetX(10);
$pdf->Cell(182,12,'',0,0,'C',1);


//no
$pdf->SetY(45);
$pdf->SetX(10);
$pdf->Cell(7,12,'NO.',1,0,'L',1);

//mapel
$pdf->SetX(17);
$pdf->Cell(83,12,'MATA PELAJARAN',1,0,'C',1);
$pdf->Cell(10,12,'KKM',1,0,'C',1);

//kognitif
$pdf->SetY(45);
$pdf->SetX(110);
$pdf->MultiCell(24, 6, 'PENGETAHUAN', 1, 'C');

//angka
$pdf->SetY(51);
$pdf->SetX(110);
//$pdf->Cell(12,6,'Nilai',1,0,'C',1);
$pdf->MultiCell(12, 3, 'Nilai (1-4)', 1, 'C');

//huruf
$pdf->SetY(51);
$pdf->SetX(122);
$pdf->Cell(12,6,'Predikat',1,0,'C',1);

//psikomotorik
$pdf->SetY(45);
$pdf->SetX(134);
$pdf->MultiCell(24, 6, 'KETERAMPILAN', 1, 'C');


//angka
$pdf->SetY(51);
$pdf->SetX(134);
//$pdf->Cell(12,6,'Nilai',1,0,'C',1);
$pdf->MultiCell(12, 3, 'Nilai (1-4)', 1, 'C');

//huruf
$pdf->SetY(51);
$pdf->SetX(146);
$pdf->Cell(12,6,'Predikat',1,0,'C',1);




//sikap
$pdf->SetY(45);
$pdf->SetX(158);
$pdf->MultiCell(34, 3, 'SIKAP SOSIAL DAN SPIRITUAL', 1, 'C');


//angka
$pdf->SetY(51);
$pdf->SetX(158);
$pdf->MultiCell(14, 3, 'Mapel  SB,B,C,K', 1, 'C');

//huruf
$pdf->SetY(51);
$pdf->SetX(172);
$pdf->MultiCell(20, 3, 'Antar Mapel (Deskripsi)', 1, 'C');

/////////////////////////////////////////////////////////








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
$qpel = mysql_query("SELECT m_prog_pddkn.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
						"AND m_prog_pddkn_jns.no > '4' ".
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);

//data jenis
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);







//jika lebih, ketahui sisanya
if ($tpel >= 18)
	{
	$nil_page1 = 18;
	$nil_page2 = $tpel - 18;
	}
else
	{
	$nil_page2 = $tpel - 18;
	}



	$pdf->SetY(57);
	$pdf->SetX(172);
	$pdf->SetFont('Times','',7);

	$jml_pel = $nil_page1;
	
		
	//jika lebih dari ikutin jumlah mapel
	$total_y = ($jml_pel * 10) + (30);
	
	
	//$pdf->Cell(12,$total_y,$catx_catatan,1,0,'L',1);
//	$pdf->Cell(20,$total_y,$tpel,1,0,'L',1);
	$pdf->MultiCell(18, 3, $catx_catatan, 0, 'L');















//mapel /////////////////////////////////////////////////
$pdf->SetY(57);
$pdf->SetX(10);



//looping kelompok
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '5' ".
						"OR no = '6' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);

/*	
	//jika 1
	if ($ku_no == 1)
		{
		$ku_nox = "I";
		}
	else if ($ku_no == 2)
		{
		$ku_nox = "II";
		}
	*/
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Arial','B',7);
//	$pdf->Cell(162,5,"$ku_nox. $ku_jenis",1,0,'L',1);
	$pdf->Cell(162,5,$ku_jenis,1,0,'L',1);
//	$pdf->Cell(20,5,"",0,0,'L',1);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	
	
	//gak boleh null
	if (!empty($tpel))
		{
		//jika nol
		if (empty($tpel))
			{
			$tpel = 1;
			}
		
		
		$total_1 = $tpel;
		
		
		do
			{
			$pelkd = nosql($rpel['pelkd']);
			$pel = substr(balikin2($rpel['prog_pddkn']),0,40);
			$pel_kkm = nosql($rpel['kkm']);
			$j = $j + 1;
		
	
	
			//guru
			$quru = mysql_query("SELECT m_pegawai.* ".
									"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
									"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
									"AND m_guru.kd_pegawai = m_pegawai.kd ".
									"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd' ".
									"AND m_guru.kd_tapel = '$tapelkd' ".
									"AND m_guru.kd_kelas = '$kelkd'");
			$ruru = mysql_fetch_assoc($quru);
			$nama_guru = substr(balikin($ruru['nama']),0,35);
	
			
			
			//mapel /////////////////////////////////////////////
			//posisi
			$pdf->SetX(10);
			$nilY = 5;
			$pdf->MultiCell(7, 10, "$j.", 1, 'L');
			$posisi_y = $pdf->GetY();
					
			$pdf->SetY($posisi_y-10);
			//posisi
			$pdf->SetX(17);
			$pdf->Cell(83,$nilY,$pel,1,0,'L');
			$pdf->Ln();
			$pdf->SetX(17);
			$pdf->Cell(83,$nilY,"Nama Guru : $nama_guru",1,0,'L');
			$pdf->Ln();
	
			
			//posisi
			$pdf->SetY($posisi_y-10);
			$pdf->SetX(100);		
			$pdf->Cell(10,10,$pel_kkm,1,0,'C');
		
		
			//nil mapel
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$pelkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
			$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
			$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
			$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
			$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
			$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);
	
	
	
			
	
			$pdf->Cell(12,10,$xpel_pengetahuan,1,0,'C');
			$pdf->Cell(12,10,$xpel_pengetahuan_ket,1,0,'C');
			$pdf->Cell(12,10,$xpel_ketrampilan,1,0,'C');
			$pdf->Cell(12,10,$xpel_ketrampilan_ket,1,0,'C');
			$pdf->Cell(14,10,$xpel_sikap_ket,1,0,'C');

			$pdf->SetFillColor(233,233,233);
//			$pdf->Cell(20,10,"",0,0,'L',1);
			
			$pdf->Ln();
			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
	}
while ($rku = mysql_fetch_assoc($qku));






/*

//looping kelompok 3 atau c
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '7' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);

	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(162,5,$ku_jenis,1,0,'L',1);
$pdf->Ln();
	}
while ($rku = mysql_fetch_assoc($qku));

$pdf->Ln();

*/


//looping kelompok 3 atau c
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '7' ".
						"ORDER BY no_sub ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no_sub']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Arial','B',7);
//	$pdf->Cell(7,5,$ku_no,1,0,'C',1);
//	$pdf->Cell(155,5,$ku_jenis,1,0,'L',1);
	$pdf->Cell(162,5,"$ku_no. $ku_jenis",1,0,'L',1);
	$pdf->SetFillColor(233,233,233);
//	$pdf->Cell(20,5,"",0,0,'L',1);

	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_guru_prog_pddkn, m_guru  ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_guru.kd_tapel = '$tapelkd' ".
							"AND m_guru.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	
	
	//jika gak null
	if (!empty($tpel))
		{
		//jika nol
		if (empty($tpel))
			{
			$tpel = 1;
			}
		
		
		$total_1 = $tpel;
		
		
		do
			{
			$pelkd = nosql($rpel['pelkd']);
			$pel = substr(balikin2($rpel['prog_pddkn']),0,60);
			$pel_kkm = nosql($rpel['kkm']);
			$j = $j + 1;
		
	
	
			//guru
			$quru = mysql_query("SELECT m_pegawai.* ".
									"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
									"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
									"AND m_guru.kd_pegawai = m_pegawai.kd ".
									"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd' ".
									"AND m_guru.kd_tapel = '$tapelkd' ".
									"AND m_guru.kd_kelas = '$kelkd'");
			$ruru = mysql_fetch_assoc($quru);
			$nama_guru = substr(balikin($ruru['nama']),0,35);
	
			
			
			//mapel /////////////////////////////////////////////
			//posisi
			$pdf->SetX(10);
			$nilY = 5;
			$pdf->MultiCell(7, 10, "$j.", 1, 'L');
			$posisi_y = $pdf->GetY();
					
			$pdf->SetY($posisi_y-10);
			//posisi
			$pdf->SetX(17);
			$pdf->Cell(83,$nilY,$pel,1,0,'L');
			$pdf->Ln();
			$pdf->SetX(17);
			$pdf->Cell(83,$nilY,"Nama Guru : $nama_guru",1,0,'L');
			$pdf->Ln();
	
			
			//posisi
			$pdf->SetY($posisi_y-10);
			$pdf->SetX(100);		
			$pdf->Cell(10,10,$pel_kkm,1,0,'C');
		
		
	
			//nil mapel
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$pelkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
			$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
			$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
			$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
			$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
			$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);
	
	
	
			
	
			$pdf->Cell(12,10,$xpel_pengetahuan,1,0,'C');
			$pdf->Cell(12,10,$xpel_pengetahuan_ket,1,0,'C');
			$pdf->Cell(12,10,$xpel_ketrampilan,1,0,'C');
			$pdf->Cell(12,10,$xpel_ketrampilan_ket,1,0,'C');
			$pdf->Cell(14,10,$xpel_sikap_ket,1,0,'C');
			
			$pdf->SetFillColor(233,233,233);
//			$pdf->Cell(20,10,"",0,0,'L',1);
			
			$pdf->Ln();
			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
	}
while ($rku = mysql_fetch_assoc($qku));












//mapel mulok /////////////////////////////////////////////////
//looping kelompok
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '4' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);


	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(162,5,$ku_jenis,1,0,'L',1);

	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	
	
	//gak boleh null
	if (!empty($tpel))
		{
		//jika nol
		if (empty($tpel))
			{
			$tpel = 1;
			}
		
		
		$total_1 = $tpel;
		
		
		do
			{
			$pelkd = nosql($rpel['pelkd']);
			$pel = substr(balikin2($rpel['prog_pddkn']),0,40);
			$pel_kkm = nosql($rpel['kkm']);
			$j = $j + 1;
		
	
	
			//guru
			$quru = mysql_query("SELECT m_pegawai.* ".
									"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
									"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
									"AND m_guru.kd_pegawai = m_pegawai.kd ".
									"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd' ".
									"AND m_guru.kd_tapel = '$tapelkd' ".
									"AND m_guru.kd_kelas = '$kelkd'");
			$ruru = mysql_fetch_assoc($quru);
			$nama_guru = substr(balikin($ruru['nama']),0,35);
	
			
			
			//mapel /////////////////////////////////////////////
			//posisi
			$pdf->SetX(10);
			$nilY = 5;
			$pdf->MultiCell(7, 10, "$j.", 1, 'L');
			$posisi_y = $pdf->GetY();
					
			$pdf->SetY($posisi_y-10);
			//posisi
			$pdf->SetX(17);
			$pdf->Cell(83,$nilY,$pel,1,0,'L');
			$pdf->Ln();
			$pdf->SetX(17);
			$pdf->Cell(83,$nilY,"Nama Guru : $nama_guru",1,0,'L');
			$pdf->Ln();
	
			
			//posisi
			$pdf->SetY($posisi_y-10);
			$pdf->SetX(100);		
			$pdf->Cell(10,10,$pel_kkm,1,0,'C');
		
		
			//nil mapel
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$pelkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
			$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
			$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
			$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
			$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
			$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);
	
	
	
			
	
			$pdf->Cell(12,10,$xpel_pengetahuan,1,0,'C');
			$pdf->Cell(12,10,$xpel_pengetahuan_ket,1,0,'C');
			$pdf->Cell(12,10,$xpel_ketrampilan,1,0,'C');
			$pdf->Cell(12,10,$xpel_ketrampilan_ket,1,0,'C');
			$pdf->Cell(14,10,$xpel_sikap_ket,1,0,'C');

			$pdf->SetFillColor(233,233,233);
			
			$pdf->Ln();
			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
	}
while ($rku = mysql_fetch_assoc($qku));










//jumlah nilai //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->SetX(10);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(100,5,'Jumlah Nilai',1,0,'L',1);



//nil mapel
$qxpel = mysql_query("SELECT SUM(nil_raport_pengetahuan_a) AS totalku, ".
						"SUM(nil_raport_ketrampilan_a) AS totalku2 ".
						"FROM siswa_nilai_raport ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
$rxpel = mysql_fetch_assoc($qxpel);
$txpel = mysql_num_rows($qxpel);
$totalku = nosql($rxpel['totalku']);
$totalku2 = nosql($rxpel['totalku2']);


$pdf->SetFont('Arial','B',7);
$pdf->Cell(12,5,$totalku,1,0,'C',1);
$pdf->Cell(12,5,'',1,0,'C',1);
$pdf->Cell(12,5,$totalku2,1,0,'C',1);
$pdf->Cell(46,5,'',1,0,'C',1);
$pdf->Ln();







$pdf->SetX(10);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(100,5,'Indeks Prestasi Komulatif',1,0,'L',1);


//jml mapel
$qpel = mysql_query("SELECT m_prog_pddkn.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);



//nil mapel
$qxpel = mysql_query("SELECT AVG(nil_raport_pengetahuan_a) AS totalku, ".
						"AVG(nil_raport_ketrampilan_a) AS totalku2 ".
						"FROM siswa_nilai_raport ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
$rxpel = mysql_fetch_assoc($qxpel);
$txpel = mysql_num_rows($qxpel);
$totalku = nosql($rxpel['totalku']);
$totalku2 = nosql($rxpel['totalku2']);
//$ipk = round(($totalku + $totalku2) / (($tpel * 2) - 2),2);
$ipk = round(($totalku + $totalku2) / 2,2);


$pdf->SetFont('Arial','B',7);
$pdf->Cell(12,5,$ipk,1,0,'C',1);
$pdf->Cell(70,5,'',1,0,'C',1);
$pdf->Ln();




//jumlah siswa sekelas
$qjks = mysql_query("SELECT * FROM siswa_kelas ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$kelkd'");
$rjks = mysql_fetch_assoc($qjks);
$tjks = mysql_num_rows($qjks);


//nilaine...
$qnilx = mysql_query("SELECT * FROM siswa_rangking ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_smt = '$smtkd'");
$rnilx = mysql_fetch_assoc($qnilx);
$tnilx = mysql_num_rows($qnilx);
$nilx_rangking = nosql($rnilx['rangking']);


//peringkat ke...
$jks_nilx_rangking = xongkof($nilx_rangking);
$jks_tjks = xongkof($tjks);
$jks_rangking = "$nilx_rangking ( $jks_nilx_rangking) dari $tjks ( $jks_tjks) siswa";



$pdf->SetX(10);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(100,5,'Peringkat Kelas',1,0,'L',1);
$pdf->Cell(82,5,"$nilx_rangking ( $jks_nilx_rangking) dari $tjks ( $jks_tjks) siswa",1,0,'L',1);
$pdf->Ln();
$pdf->Ln();












////////////////////////////////////////////////////////// HALAMAN II //////////////////////////////////////////////////////////////////
$pdf->AddPage();

//header page/////////////////////////////////////////////
$pdf->SetY(10);
$pdf->SetX(10);
$pdf->Headerku2();



//header table //////////////////////////////////////////
$htg = 15; //tinggi
$hkr = 5; //dari kiri
$pdf->SetFont('Arial','B',7);

//posisi
$pdf->SetY(45);
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
$pdf->SetY(52);
$pdf->SetX(10);



//looping kelompok
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '5' ".
						"OR no = '6' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(190,5,$ku_jenis,1,0,'L',1);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
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
		$pel = substr(balikin2($rpel['prog_pddkn']),0,60);
		$pel_kkm = nosql($rpel['kkm']);
		$jk = $jk + 1;
	
		//mapel /////////////////////////////////////////////
		//posisi
		$pdf->Cell(7,45,'',1,0,'L');
		$pdf->Ln();
		$posisi_y = $pdf->GetY();
		$pdf->SetY($posisi_y-45);
		$pdf->MultiCell(53, 3, "$jk.", 0, 'L');


		
		$pdf->SetY($posisi_y-45);
		$pdf->SetX(17);
		$pdf->Cell(53,45,'',1,0,'L');


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(17);
		$pdf->MultiCell(53, 3, $pel, 0, 'L');	


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(70);
		$pdf->Cell(40,45,'',1,0,'L');	



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


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(70);

		//posisi
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Pengetahuan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Ketrampilan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Sikap Spiritual dan Sosial",1,0,'L');



		$pdf->SetY($posisi_y-45);
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y1 = $pdf->GetY();
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y2 = $pdf->GetY();
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y3 = $pdf->GetY();
		$pdf->Ln();


		$pdf->SetY($posisi_y1);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_pengetahuan.", 0, 'L');		
		$pdf->Ln();
		$pdf->SetY($posisi_y2);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_ketrampilan.", 0, 'L');
		$pdf->Ln();
		$pdf->SetY($posisi_y3);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_sikap.", 0, 'L');
		$pdf->Ln();




		$pdf->SetY($posisi_y);
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rku = mysql_fetch_assoc($qku));






//looping kelompok 3 atau c
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '7' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);


do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(190,5,$ku_jenis,1,0,'L',1);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_guru_prog_pddkn, m_guru  ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_guru.kd_tapel = '$tapelkd' ".
							"AND m_guru.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
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
		$pel = substr(balikin2($rpel['prog_pddkn']),0,60);
		$pel_kkm = nosql($rpel['kkm']);
		$jk = $jk + 1;
	
		//mapel /////////////////////////////////////////////
		//posisi
		$pdf->Cell(7,45,'',1,0,'L');
		$pdf->Ln();
		$posisi_y = $pdf->GetY();
		$pdf->SetY($posisi_y-45);
		$pdf->MultiCell(53, 3, "$jk.", 0, 'L');


		
		$pdf->SetY($posisi_y-45);
		$pdf->SetX(17);
		$pdf->Cell(53,45,'',1,0,'L');


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(17);
		$pdf->MultiCell(53, 3, $pel, 0, 'L');	


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(70);
		$pdf->Cell(40,45,'',1,0,'L');	



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


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(70);

		//posisi
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Pengetahuan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Ketrampilan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Sikap Spiritual dan Sosial",1,0,'L');



		$pdf->SetY($posisi_y-45);
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y1 = $pdf->GetY();
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y2 = $pdf->GetY();
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y3 = $pdf->GetY();
		$pdf->Ln();


		$pdf->SetY($posisi_y1);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_pengetahuan.", 0, 'L');		
		$pdf->Ln();
		$pdf->SetY($posisi_y2);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_ketrampilan.", 0, 'L');
		$pdf->Ln();
		$pdf->SetY($posisi_y3);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_sikap.", 0, 'L');
		$pdf->Ln();




		$pdf->SetY($posisi_y);
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rku = mysql_fetch_assoc($qku));







//mapel mulok /////////////////////////////////////////////////
//looping kelompok
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '4' ".
						"ORDER BY no ASC");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);

do
	{
	$ku_kd = nosql($rku['kd']);
	$ku_no = nosql($rku['no']);
	$ku_jenis = balikin($rku['jenis']);
	
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(190,5,$ku_jenis,1,0,'L',1);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	
	//data mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
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
		$pel = substr(balikin2($rpel['prog_pddkn']),0,60);
		$pel_kkm = nosql($rpel['kkm']);
		$jk = $jk + 1;
	
		//mapel /////////////////////////////////////////////
		//posisi
		$pdf->Cell(7,45,'',1,0,'L');
		$pdf->Ln();
		$posisi_y = $pdf->GetY();
		$pdf->SetY($posisi_y-45);
		$pdf->MultiCell(53, 3, "$jk.", 0, 'L');


		
		$pdf->SetY($posisi_y-45);
		$pdf->SetX(17);
		$pdf->Cell(53,45,'',1,0,'L');


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(17);
		$pdf->MultiCell(53, 3, $pel, 0, 'L');	


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(70);
		$pdf->Cell(40,45,'',1,0,'L');	



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


		$pdf->SetY($posisi_y-45);		
		$pdf->SetX(70);

		//posisi
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Pengetahuan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Ketrampilan",1,0,'L');
		$pdf->Ln();
		$pdf->SetX(70);
		$pdf->Cell(40,15,"Sikap Spiritual dan Sosial",1,0,'L');



		$pdf->SetY($posisi_y-45);
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y1 = $pdf->GetY();
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y2 = $pdf->GetY();
		$pdf->Ln();
		$pdf->SetX(110);
		$pdf->Cell(90,15,'',1,0,'L');
		$posisi_y3 = $pdf->GetY();
		$pdf->Ln();


		$pdf->SetY($posisi_y1);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_pengetahuan.", 0, 'L');		
		$pdf->Ln();
		$pdf->SetY($posisi_y2);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_ketrampilan.", 0, 'L');
		$pdf->Ln();
		$pdf->SetY($posisi_y3);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 3, "$xpel_sikap.", 0, 'L');
		$pdf->Ln();




		$pdf->SetY($posisi_y);
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rku = mysql_fetch_assoc($qku));






$pdf->Ln();

$nilkuYY = $pdf->GetY();









//ekstra /////////////////////////////////////////////////
$pdf->SetX(10);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(100,5,'Pengembangan Diri',1,0,'L',1);
$pdf->Cell(12,5,'Nilai',1,0,'L',1);
$pdf->Cell(78,5,'Keterangan',1,0,'L',1);
$pdf->Ln();


$pdf->SetFont('Arial','',7);

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

	$pdf->Cell(5,5,$nomx,1,0,'C');
	$pdf->Cell(95,5,$kuti_ekstrax,1,0,'L');
	$pdf->Cell(12,5,$kuti_predikat,1,0,'C');
	$pdf->Cell(78,5,$kuti_ket,1,0,'L');
	$pdf->Ln();
	}
while ($rkuti = mysql_fetch_assoc($qkuti));


$pdf->Ln();






//absensi ///////////////////////////////////////////////
$pdf->SetX(10);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(190,5,'Ketidakhadiran',1,0,'L',1);
$pdf->Ln();


$pdf->Cell(190,15,'',1,0,'L');



$pdf->SetFont('Arial','',7);

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



	$pdf->Cell(5,5,''.$nomxz.'.',0,0,'C');
	$pdf->Cell(30,5,$abs_absensi,0,0,'L');
	$pdf->Cell(20,5,": $tbsix",0,0,'L');
	$pdf->Ln();
	}
while ($rabs = mysql_fetch_assoc($qabs));

$pdf->Ln();




//saran ///////////////////////////////////////////////
$pdf->SetX(10);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(190,5,'Catatan Wali Kelas',1,0,'L',1);
$pdf->Ln();


$pdf->Cell(190,15,'',1,0,'L');


$pdf->SetFont('Arial','',7);

//jml. absensi...
$qbsi = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
$rbsi = mysql_fetch_assoc($qbsi);
$bsi_saran = balikin($rbsi['catatan']);

$nilku = $pdf->GetY();
$pdf->SetY($nilku);
$pdf->MultiCell(150, 3, $bsi_saran, 0, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$nilkuYY = $pdf->GetY();















//naik ato lulus, ///////////////////////////////////////////////
//posisi
$pdf->Ln();
$pdf->SetY($nilkuYY+5);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',7);


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
		//naik kelas
		$btxnox = $arrrkelas[$btxno + 1];
		
		$ket_naik = "Naik di Kelas : $btxnox";					
		}
	else 
		{
		$btxnox = $arrrkelas[$btxno];
		
		$ket_naik = "Tinggal di Kelas : $btxnox";
		}


	//Tanda tangan dan tgl ////////////////////////////////////////
	$pdf->SetFont('Arial','',7);
	$nil_Y = $pdf->GetY();
		
	$pdf->SetY($nil_Y+5);
	$pdf->SetX(25);
	$pdf->Cell(50,5,'Mengetahui',0,0,'C');
	
	$pdf->SetY($nil_Y+10);
	$pdf->SetX(25);
	$pdf->Cell(50,5,'Wali Kelas',0,0,'C');
	$pdf->SetY($nil_Y+25);
	$pdf->SetX(25);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,2,''.$nwk.'',0,0,'C');


	$pdf->SetY($nil_Y+30);
	$pdf->SetX(25);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(50,5,'Orang Tua/Wali',0,0,'C');
	$pdf->SetY($nil_Y+50);
	$pdf->SetX(25);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,2,'',0,0,'C');
	
		
	//kotak
	$pdf->SetY($nil_Y+5);
	$pdf->SetX(130);
	$pdf->Cell(62,45,'',1,0,'L');
	
	//posisi
	$pdf->SetY($nil_Y+5);
	$pdf->SetX(130);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(50,5,'Keputusan :',0,0,'L');
	$pdf->Ln();
	$pdf->SetX(130);
	$pdf->Cell(50,5,'Berdasarkan hasil yang dicapai pada',0,0,'L');
	$pdf->Ln();
	$pdf->SetX(130);
	$pdf->Cell(50,5,'Semester 1 dan 2, peserta didik ditetapkan',0,0,'L');
	$pdf->Ln();
	$pdf->SetX(130);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,5,$ket_naik,0,0,'L');
	
	$pdf->SetY($nil_Y+25);
	$pdf->SetX(130);
	$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(50,5,$nil_tgl,0,0,'C');
	

	//kepala sekolah
	$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
							"FROM admin_ks, m_pegawai ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rks = mysql_fetch_assoc($qks);
	$tks = mysql_num_rows($qks);
	$ks_nip = nosql($rks['nip']);
	$ks_nama = balikin($rks['nama']);
	
	$pdf->SetY($nil_Y+30);
	$pdf->SetX(130);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(50,5,'Kepala Sekolah',0,0,'C');
	$pdf->SetY($nil_Y+45);
	$pdf->SetX(130);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,2,$ks_nama,0,0,'C');
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

	//lulus ato tidak
	if ($lus_nilai == "true")
		{
		$ket_lulus = "LULUS.";
		}
	else if ($lus_nilai == "false")
		{
		$ket_lulus = "TIDAK LULUS.";
		}
	

	//Tanda tangan dan tgl ////////////////////////////////////////
	$pdf->SetFont('Arial','',7);
	$nil_Y = $pdf->GetY();
		
	$pdf->SetY($nil_Y+5);
	$pdf->SetX(25);
	$pdf->Cell(50,5,'Mengetahui',0,0,'C');
	
	$pdf->SetY($nil_Y+10);
	$pdf->SetX(25);
	$pdf->Cell(50,5,'Wali Kelas',0,0,'C');
	$pdf->SetY($nil_Y+25);
	$pdf->SetX(25);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,2,''.$nwk.'',0,0,'C');


	$pdf->SetY($nil_Y+30);
	$pdf->SetX(25);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(50,5,'Orang Tua/Wali',0,0,'C');
	$pdf->SetY($nil_Y+50);
	$pdf->SetX(25);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,2,'',0,0,'C');
	
		
	//kotak
	$pdf->SetY($nil_Y+5);
	$pdf->SetX(130);
	$pdf->Cell(62,45,'',1,0,'L');
	
	//posisi
	$pdf->SetY($nil_Y+5);
	$pdf->SetX(130);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(50,5,'Keputusan :',0,0,'L');
	$pdf->Ln();
	$pdf->SetX(130);
	$pdf->Cell(50,5,'Berdasarkan hasil yang dicapai pada',0,0,'L');
	$pdf->Ln();
	$pdf->SetX(130);
	$pdf->Cell(50,5,'masa pendidikan, peserta didik ditetapkan',0,0,'L');
	$pdf->Ln();
	$pdf->SetX(130);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,5,$ket_lulus,0,0,'L');
	
	$pdf->SetY($nil_Y+25);
	$pdf->SetX(130);
	$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(50,5,$nil_tgl,0,0,'C');
	

	//kepala sekolah
	$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
							"FROM admin_ks, m_pegawai ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rks = mysql_fetch_assoc($qks);
	$tks = mysql_num_rows($qks);
	$ks_nip = nosql($rks['nip']);
	$ks_nama = balikin($rks['nama']);
	
	$pdf->SetY($nil_Y+30);
	$pdf->SetX(130);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(50,5,'Kepala Sekolah',0,0,'C');
	$pdf->SetY($nil_Y+45);
	$pdf->SetX(130);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,2,$ks_nama,0,0,'C');
	}


else 
	{
	//semester ganjil
	//Tanda tangan dan tgl ////////////////////////////////////////
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	
	$pdf->SetY($pdf->GetY());
	$pdf->SetX(130);
	$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
	$pdf->Cell(50,5,$nil_tgl,0,0,'R');
	
	$pdf->SetY($pdf->GetY()+5);
	$pdf->SetX(25);
	$pdf->Cell(50,5,'Mengetahui',0,0,'C');
	
	$pdf->SetY($pdf->GetY()+5);
	$pdf->SetX(25);
	$pdf->Cell(50,5,'Kepala Sekolah',0,0,'C');
	
	$pdf->SetX(130);
	$pdf->Cell(50,5,'Wali Kelas',0,0,'C');
	
	$pdf->SetY($pdf->GetY()+20);
	$pdf->SetX(10);
	
	
	
	
	//kepala sekolah
	$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
							"FROM admin_ks, m_pegawai ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rks = mysql_fetch_assoc($qks);
	$tks = mysql_num_rows($qks);
	$ks_nip = nosql($rks['nip']);
	$ks_nama = balikin($rks['nama']);
	
	//posisi
	$pdf->SetX(25);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,2,''.$ks_nama.'',0,0,'C');
	
	
	//wali kelas
	$pdf->SetX(130);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(50,2,''.$nwk.'',0,0,'C');
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//output-kan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->Output("raport_semester_$nis.pdf",I);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
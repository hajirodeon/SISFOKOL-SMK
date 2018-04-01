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



//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/ledger_nilai.php");

nocache;

//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$judul = "LEDGER NILAI";



//start class
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//kelas
$qk = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd = '$kelkd'");
$rk = mysql_fetch_assoc($qk);
$rkel = balikin($rk['kelas']);


//keahlian
$qpro = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);
$pro_keah = "$pro_program";


$kelas = "$rkel";


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



//header page ///////////////////////////////////////////
$pdf->SetY(10);
$pdf->SetX(10);
$pdf->Headerku();

$pdf->SetFont('Times','B',18);
$pdf->Cell(190,5,'LEGGER NILAI',0,0,'C');

//kolom data
$pdf->SetY(50);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Times','B',10);
$pdf->Cell(20,35,'NIS',1,0,'C',1);
$pdf->Cell(50,35,'NAMA',1,0,'C',1);

//jenis mapel
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"ORDER BY round(no) ASC");
$rjnsp = mysql_fetch_assoc($qjnsp);
$tjnsp = mysql_num_rows($qjnsp);


do
	{
	//nilai jenis...
	$jnsp_kd = nosql($rjnsp['kd']);
	$jnsp_no = nosql($rjnsp['no']);
	$jnsp_jenis = balikin($rjnsp['jenis']);

	//query
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
				"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
				"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
				"ORDER BY m_prog_pddkn.prog_pddkn ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);

	do
		{
		//nilai
		$pelkd = nosql($rpel['pelkd']);
		$pel = substr(balikin2($rpel['xpel']),0,25);

		$pdf->SetFont('Times','',7);
		$i_po = $i_po + 5;
		$pdf->Cell(5,35,'',1,0,'L',1);
		$pdf->TextWithDirection(78+$i_po,83,$pel,'U');
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));


$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
			"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
			"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
			"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
			"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);

$pdf->Cell(10,35,'',1,0,'L',1);
$pdf->TextWithDirection(78+(5*$tpel)+7,83,'Jumlah','U');
$pdf->Cell(5,35,'',1,0,'L',1);
$pdf->TextWithDirection(78+(5*$tpel)+15,83,'Rangking','U');



$pdf->Ln();


$pdf->SetFont('Times','',7);

//query
$qjnspx = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
			"siswa_kelas.*, siswa_kelas.kd AS skkd ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_keahlian = '$keahkd' ".
			"ORDER BY round(m_siswa.nis) ASC");
$rjnspx = mysql_fetch_assoc($qjnspx);
$tjnspx = mysql_num_rows($qjnspx);


do
	{
	//nilai
	$jnspx_skkd = nosql($rjnspx['skkd']);
	$jnspx_nis = nosql($rjnspx['nis']);
	$jnspx_nama = balikin($rjnspx['nama']);
	$pdf->Cell(20,5,$jnspx_nis,1,0,'L');
	$pdf->Cell(50,5,$jnspx_nama,1,0,'L');

	//nilai/////////////////////////////////////////////////////////////////////////
	//jenis mapel
	$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
				"ORDER BY round(no) ASC");
	$rjnsp = mysql_fetch_assoc($qjnsp);
	$tjnsp = mysql_num_rows($qjnsp);

	do
		{
		//nilai jenis...
		$jnsp_kd = nosql($rjnsp['kd']);
		$jnsp_no = nosql($rjnsp['no']);
		$jnsp_jenis = balikin($rjnsp['jenis']);

		//query
		$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
					"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
					"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
					"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
					"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
					"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
					"ORDER BY m_prog_pddkn.prog_pddkn ASC");
		$rpel = mysql_fetch_assoc($qpel);
		$tpel = mysql_num_rows($qpel);

		do
			{
			//nilai
			$pelkd = nosql($rpel['pelkd']);
			$pel = substr(balikin2($rpel['xpel']),0,25);
			$pdf->SetFont('Times','',7);



			//nilai mapel..
			$qkunil = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
			$rkunil = mysql_fetch_assoc($qkunil);
			$tkunil = mysql_num_rows($qkunil);
			$kunil_nilai = nosql($rkunil['nil_raport']);

			//nek null
			if (empty($tkunil))
				{
				$kunil_nilai = "-";
				}

			$pdf->Cell(5,5,$kunil_nilai,1,0,'L');
			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
	while ($rjnsp = mysql_fetch_assoc($qjnsp));



	//rangking
	$qkunilx2 = mysql_query("SELECT * FROM siswa_rangking ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_keahlian ='$keahkd' ".
					"AND kd_kelas ='$kelkd' ".
					"AND kd_siswa_kelas = '$jnspx_skkd' ".
					"AND kd_smt = '$smtkd'");
	$rkunilx2 = mysql_fetch_assoc($qkunilx2);
	$tkunilx2 = mysql_num_rows($qkunilx2);
	$kunilx2_total = nosql($rkunilx2['total']);
	$kunilx2_rangking = nosql($rkunilx2['rangking']);

	$pdf->Cell(10,5,$kunilx2_total,1,0,'C');
	$pdf->Cell(5,5,$kunilx2_rangking,1,0,'L');

	$pdf->Ln();
	}
while ($rjnspx = mysql_fetch_assoc($qjnspx));
















//output-kan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->Output("legger_nilai.pdf",I);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
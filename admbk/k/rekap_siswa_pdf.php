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



//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/rekap_pelanggaran_siswa.php");

nocache;


//start class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//nilai
$judul = "Rekap Data Pelanggaran Siswa";
$judulz = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$swkd = nosql($_REQUEST['swkd']);



//isi *START
ob_start();



$pdf->SetFont('Times','',8);
$pdf->SetFillColor(233,233,233);


//header
$pdf->AddPage();
$pdf->Cell(10,10,'No',1,0,'C',1);
$pdf->Cell(50,10,'Jenis Pelanggaran',1,0,'C',1);
$pdf->Cell(15,10,'Point Skor',1,0,'C',1);
$pdf->Cell(50,10,'Sanksi',1,0,'C',1);
$pdf->Cell(15,10,'Jumlah Skor',1,0,'C',1);
$pdf->Cell(45,5,'Tanda Tangan',1,0,'C',1);
$pdf->Ln();


$pdf->SetY(35);
$pdf->SetX(150);
$pdf->Cell(15,5,'Siswa',1,0,'C',1);
$pdf->Cell(15,5,'Petugas',1,0,'C',1);
$pdf->Cell(15,5,'Ortu.',1,0,'C',1);
$pdf->Ln();

//looping
$qkel = mysql_query("SELECT m_bk_point.*, m_bk_point_jenis.*, siswa_pelanggaran.*, ".
			"DATE_FORMAT(siswa_pelanggaran.tgl, '%d') AS utgl, ".
			"DATE_FORMAT(siswa_pelanggaran.tgl, '%m') AS ubln,  ".
			"DATE_FORMAT(siswa_pelanggaran.tgl, '%Y') AS uthn ".
			"FROM m_bk_point, m_bk_point_jenis, siswa_pelanggaran ".
			"WHERE siswa_pelanggaran.kd_point = m_bk_point.kd ".
			"AND m_bk_point.kd_jenis = m_bk_point_jenis.kd ".
			"AND siswa_pelanggaran.kd_siswa = '$swkd' ".
			"AND siswa_pelanggaran.kd_tapel = '$tapelkd'");
$rkel = mysql_fetch_assoc($qkel);

do
	{
	//nilai
	$nomer = $nomer + 1;
	$dt_utgl = nosql($rkel['utgl']);
	$dt_ubln = nosql($rkel['ubln']);
	$dt_uthn = nosql($rkel['uthn']);
	$dt_jenis = substr(balikin($rkel['jenis']),0,25);
	$dt_point = nosql($rkel['point']);
	$dt_sanksi = substr(balikin($rkel['sanksi']),0,25);

	$nilkux = $nilkux + $dt_point;


	$pdf->Cell(10,5,$nomer,1,0,'C');
	$pdf->Cell(50,5,$dt_jenis,1,0,'L');
	$pdf->Cell(15,5,$dt_point,1,0,'C');
	$pdf->Cell(50,5,$dt_sanksi,1,0,'L');
	$pdf->Cell(15,5,$nilkux,1,0,'C');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Ln();
	}
while ($rkel = mysql_fetch_assoc($qkel));



$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetX(50);
$pdf->Cell(100,10,'',1,0,'C');

$pdf->SetY($pdf->GetY()+1);
$pdf->SetX(50);
$pdf->SetFont('Times','B',10);
$pdf->Cell(100,5,'PERHATIAN',0,0,'C');

$pdf->SetY($pdf->GetY()+4);
$pdf->SetX(50);
$pdf->SetFont('Times','',8);
$pdf->Cell(100,5,'Jika Total Point sudah mencapai 100, siswa dikeluarkan.',0,0,'C');



//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("rekap_pelanggaran_siswa.pdf",I);
?>
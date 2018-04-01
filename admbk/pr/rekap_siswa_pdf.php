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
require("../../inc/class/rekap_prestasi_siswa.php");

nocache;


//start class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//nilai
$judul = "Rekap Data Prestasi Siswa";
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
$pdf->Cell(50,10,'Prestasi',1,0,'C',1);
$pdf->Cell(15,10,'Tgl.',1,0,'C',1);
$pdf->Cell(15,10,'Point',1,0,'C',1);
$pdf->Cell(45,5,'Tanda Tangan',1,0,'C',1);
$pdf->Ln();


$pdf->SetY(35);
$pdf->SetX(100);
$pdf->Cell(15,5,'Siswa',1,0,'C',1);
$pdf->Cell(15,5,'Petugas',1,0,'C',1);
$pdf->Cell(15,5,'Ortu',1,0,'C',1);
$pdf->Ln();

//looping
$qkel = mysql_query("SELECT m_bk_prestasi.*, siswa_prestasi.*, ".
			"DATE_FORMAT(siswa_prestasi.tgl, '%d') AS utgl, ".
			"DATE_FORMAT(siswa_prestasi.tgl, '%m') AS ubln,  ".
			"DATE_FORMAT(siswa_prestasi.tgl, '%Y') AS uthn ".
			"FROM m_bk_prestasi, siswa_prestasi ".
			"WHERE siswa_prestasi.kd_prestasi = m_bk_prestasi.kd ".
			"AND siswa_prestasi.kd_siswa = '$swkd' ".
			"AND siswa_prestasi.kd_tapel = '$tapelkd'");
$rkel = mysql_fetch_assoc($qkel);

do
	{
	//nilai
	$nomer = $nomer + 1;
	$dt_utgl = nosql($rkel['utgl']);
	$dt_ubln = nosql($rkel['ubln']);
	$dt_uthn = nosql($rkel['uthn']);
	$dt_tgl = "$dt_utgl/$dt_ubln/$dt_uthn";
	$dt_point = nosql($rkel['point']);
	$dt_nama = balikin($rkel['nama']);


	$pdf->Cell(10,5,"$nomer.",1,0,'C');
	$pdf->Cell(50,5,$dt_nama,1,0,'L');
	$pdf->Cell(15,5,$dt_tgl,1,0,'L');
	$pdf->Cell(15,5,$dt_point,1,0,'C');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Ln();
	}
while ($rkel = mysql_fetch_assoc($qkel));



$pdf->Ln();
$pdf->Ln();
$pdf->Ln();



//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("rekap_prestasi_siswa.pdf",I);
?>
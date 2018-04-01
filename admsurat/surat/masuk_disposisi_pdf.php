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
require("../../inc/class/disposisi_masuk.php");

nocache;


//start class
$pdf=new PDF("P","mm","F7");
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);
$pdf->SetAutoPageBreak(true,1);


//nilai
$judul = "Disposisi Surat Masuk";
$judulz = $judul;
$sukd = nosql($_REQUEST['sukd']);



//query
$qx = mysql_query("SELECT surat_masuk.*, ".
			"DATE_FORMAT(tgl_surat, '%d') AS surat_tgl, ".
			"DATE_FORMAT(tgl_surat, '%m') AS surat_bln, ".
			"DATE_FORMAT(tgl_surat, '%Y') AS surat_thn, ".
			"DATE_FORMAT(tgl_terima, '%d') AS terima_tgl, ".
			"DATE_FORMAT(tgl_terima, '%m') AS terima_bln, ".
			"DATE_FORMAT(tgl_terima, '%Y') AS terima_thn ".
			"FROM surat_masuk ".
			"WHERE kd = '$sukd'");
$rowx = mysql_fetch_assoc($qx);
$x_no_urut = nosql($rowx['no_urut']);
$x_no_surat = balikin2($rowx['no_surat']);
$x_asal = balikin2($rowx['asal']);
$x_tujuan = balikin2($rowx['tujuan']);
$x_kd_sifat = nosql($rowx['kd_sifat']);
$x_kd_klasifikasi = nosql($rowx['kd_klasifikasi']);
$x_surat_tgl = nosql($rowx['surat_tgl']);
$x_surat_bln = nosql($rowx['surat_bln']);
$x_surat_thn = nosql($rowx['surat_thn']);
$x_perihal = balikin2($rowx['perihal']);
$x_terima_tgl = nosql($rowx['terima_tgl']);
$x_terima_bln = nosql($rowx['terima_bln']);
$x_terima_thn = nosql($rowx['terima_thn']);


//detail disposisi
$qx2 = mysql_query("SELECT surat_masuk_disposisi.*, ".
			"DATE_FORMAT(tgl_selesai, '%d') AS selesai_tgl, ".
			"DATE_FORMAT(tgl_selesai, '%m') AS selesai_bln, ".
			"DATE_FORMAT(tgl_selesai, '%Y') AS selesai_thn, ".
			"DATE_FORMAT(tgl_kembali, '%d') AS kembali_tgl, ".
			"DATE_FORMAT(tgl_kembali, '%m') AS kembali_bln, ".
			"DATE_FORMAT(tgl_kembali, '%Y') AS kembali_thn ".
			"FROM surat_masuk_disposisi ".
			"WHERE kd_surat = '$sukd'");
$rowx2 = mysql_fetch_assoc($qx2);
$x2_inxkd = nosql($rowx2['kd_indeks']);
$x2_selesai_tgl = nosql($rowx2['selesai_tgl']);
$x2_selesai_bln = nosql($rowx2['selesai_bln']);
$x2_selesai_thn = nosql($rowx2['selesai_thn']);
$x2_kembali_tgl = nosql($rowx2['kembali_tgl']);
$x2_kembali_bln = nosql($rowx2['kembali_bln']);
$x2_kembali_thn = nosql($rowx2['kembali_thn']);
$x2_isi = balikin($rowx2['isi']);
$x2_diteruskan = balikin($rowx2['diteruskan']);
$x2_kepada = balikin($rowx2['kepada']);
$x2_harap = balikin($rowx2['harap']);
$x2_catatan = balikin($rowx2['catatan']);


//terpilih
$qblsx = mysql_query("SELECT * FROM surat_m_indeks ".
			"WHERE kd = '$x2_inxkd'");
$rblsx = mysql_fetch_assoc($qblsx);
$blsx_indeks = balikin($rblsx['indeks']);



$qdtx = mysql_query("SELECT * FROM surat_m_klasifikasi ".
			"WHERE kd = '$x_kd_klasifikasi'");
$rdtx = mysql_fetch_assoc($qdtx);
$dtx_klasifikasi = balikin($rdtx['klasifikasi']);





//terpilih
$qdtx = mysql_query("SELECT * FROM surat_m_sifat ".
			"WHERE kd = '$x_kd_sifat'");
$rdtx = mysql_fetch_assoc($qdtx);
$dtx_sifat = balikin($rdtx['sifat']);



//jika null
if (($x2_selesai_tgl == "00") OR ($x2_selesai_bln == "00") OR ($x2_selesai_thn == "0000"))
	{
	$x2_selesai = "";
	}
else
	{
	$x2_selesai = "$x2_selesai_tgl $arrbln1[$x2_selesai_bln] $x2_selesai_thn";
	}



//isi *START
ob_start();



$pdf->SetFont('Times','',8);


//header
$pdf->AddPage();

//$pdf->Image('../../img/logo.png',73,8,13);

$pdf->SetY(10);
$pdf->SetX(10);
$pdf->SetFont('Arial','',10);
$pdf->Cell(135,4,"PEMERINTAH KABUPATEN BERAU",0,0,'C');
$pdf->Ln();
$pdf->Cell(135,4,"DINAS PENDIDIKAN DAN KEBUDAYAAN",0,0,'C');
$pdf->Ln();
$pdf->SetFont('Times','B',14);
$pdf->Cell(135,4,"SMK 3 BERAU",0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->Cell(135,3,"Jalan. . .",0,0,'C');
$pdf->Ln();
$pdf->Cell(135,3,"Website. . . E-Mail. . .",0,0,'C');
$pdf->Ln();

$pdf->Cell(135,1,"",1,1,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();




$pdf->SetFont('Times','B',10);
$pdf->Cell(135,7,'LEMBAR DISPOSISI',1,0,'C');
$pdf->Ln();



$pdf->Cell(67.5,31,'',1,0,'L');
$pdf->Cell(67.5,31,'',1,0,'L');
$pdf->Ln();


$pdf->SetY(40);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  Surat dari ',0,0,'L');

$pdf->SetX(30);
$pdf->Cell(97,5,'  :',0,0,'L');



$pdf->SetY(47);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  '.$x_asal.'',0,0,'L');





$pdf->SetY(60);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  No.Surat ',0,0,'L');

$pdf->SetX(30);
$pdf->Cell(97,5,'  : '.$x_no_surat.'',0,0,'L');
$pdf->Ln();

$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  Tgl.Surat ',0,0,'L');

$pdf->SetX(30);
$pdf->Cell(97,5,'  : '.$x_surat_tgl.' '.$arrbln1[$x_surat_bln].' '.$x_surat_thn.' ',0,0,'L');
$pdf->Ln();




$pdf->SetY(40);
$pdf->SetX(77);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  Diterima Tanggal ',0,0,'L');

$pdf->SetX(110);
$pdf->Cell(20,5,'  : '.$x_terima_tgl.' '.$arrbln1[$x_terima_bln].' '.$x_terima_thn.'',0,0,'L');


$pdf->SetY(45);
$pdf->SetX(77);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  No.Agenda ',0,0,'L');

$pdf->SetX(110);
$pdf->Cell(20,5,'  : '.$x_no_urut.'',0,0,'L');




$pdf->SetY(50);
$pdf->SetX(77);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  Sifat ',0,0,'L');

$pdf->SetX(110);
$pdf->Cell(20,5,'  : '.$dtx_sifat.'',0,0,'L');





$pdf->SetY(70);
$pdf->SetFont('Times','B',10);
$pdf->Cell(135,20,'',1,0,'C');


$pdf->SetY(72);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  Perihal    : ',0,0,'L');

$pdf->SetY(77);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  '.$x_perihal.'',0,0,'L');




$pdf->SetY(90);
$pdf->SetFont('Times','B',10);
$pdf->Cell(40,20,'',1,0,'C');
$pdf->Cell(95,20,'',1,0,'C');





$pdf->SetY(92);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  Diteruskan kepada Sdr. ',0,0,'L');


$pdf->SetY(97);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  '.$x2_diteruskan.'',0,0,'L');




$pdf->SetY(92);
$pdf->SetX(52);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'Dengan hormat harap : ',0,0,'L');

$pdf->SetY(97);
$pdf->SetX(50);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'  '.$x2_harap.'',0,0,'L');





$pdf->SetY(110);
$pdf->Cell(67.5,10,'',1,0,'L');
$pdf->Cell(67.5,10,'',1,0,'L');


$pdf->SetY(110);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(67.5,5,'  Tanggal & Paraf : ',0,0,'L');
$pdf->Cell(67.5,5,'Tanggal Penyelesaian : ',0,0,'L');


$pdf->SetY(115);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(67.5,5,'  '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'',0,0,'L');
$pdf->Cell(67.5,5,''.$x2_selesai_tgl.' '.$arrbln1[$x2_selesai_bln].' '.$x2_selesai_thn.'',0,0,'L');
$pdf->Ln();



$pdf->SetFont('Times','B',10);
$pdf->Cell(135,30,'',1,0,'C');
$pdf->Ln();


$pdf->SetY(120);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(67.5,5,'  Catatan : ',0,0,'L');
$pdf->Cell(67.5,5,'',$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'',0,0,'L');


$pdf->SetY(125);
$pdf->SetX(10);
$pdf->SetFont('Times','',10);
$pdf->Cell(67.5,5,'',0,0,'L');
$pdf->Cell(67.5,5,'Kepala Sekolah, ',0,0,'L');



//kepala sekolah
$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_ks.* ".
			"FROM m_pegawai, admin_ks ".
			"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
$rpgdx = mysql_fetch_assoc($qpgdx);
$pgdx_nip = nosql($rpgdx['nip']);
$pgdx_nama = balikin2($rpgdx['nama']);




$pdf->SetY(140);
$pdf->SetX(10);
$pdf->SetFont('Times','BU',10);
$pdf->Cell(67.5,5,'',0,0,'L');
$pdf->Cell(67.5,5,''.$pgdx_nama.'',0,0,'L');
$pdf->Ln();
$pdf->SetFont('Times','B',10);
$pdf->Cell(67.5,5,'',0,0,'L');
$pdf->Cell(67.5,5,'NIP.'.$pgdx_nip.'',0,0,'L');











//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("disposisi_surat_masuk.pdf",I);
?>
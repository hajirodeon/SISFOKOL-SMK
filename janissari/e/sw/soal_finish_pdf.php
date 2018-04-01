<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL JANISSARI                          ///////
/////// (customization)                             ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh :                               ///////
/////// Agus Muhajir, S.Kom                         ///////
/////// URL     :                                   ///////
///////     *http://sisfokol.wordpress.com          ///////
//////      *http://hajirodeon.wordpress.com        ///////
/////// E-Mail  :                                   ///////
///////     * hajirodeon@yahoo.com                  ///////
///////     * hajirodeon@gmail.com                  ///////
/////// HP/SMS  : 081-829-88-54                     ///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////



//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/class/rekap.php");

nocache;


//nilai
$judul = "Rekap Jawaban";
$judulz = $judul;
$swkd = nosql($_REQUEST['swkd']);
$gmkd = nosql($_REQUEST['gmkd']);
$katkd = nosql($_REQUEST['katkd']);


//start class
$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//isi *START
ob_start();


$pdf->SetFont('Times','B',10);
$pdf->SetFillColor(233,233,233);



//query data
$qdt = mysql_query("SELECT m_user.*, user_blog.* ".
			"FROM m_user, user_blog ".
			"WHERE user_blog.kd_user = m_user.kd ".
			"AND user_blog.kd_user = '$swkd'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_no = nosql($rdt['nomor']);
$dt_nama = balikin($rdt['nama']);
$dt_foto_path = $rdt['foto_path'];

//nek null foto
if (empty($dt_foto_path))
	{
	$nil_foto = "$sumber/img/foto_blank.jpg";
	}
else
	{
	//gawe thumnail
	$nil_foto = "$sumber/filebox/profil/$swkd/$dt_foto_path";
	}



//posisi foto
$pdf->SetX(145);
$pdf->WriteHTML('<img src="'.$nil_foto.'" width="70%" height="70%" border="1">');

$pdf->SetY(45);
$pdf->SetX(140);
$pdf->WriteHTML(''.$dt_no.'. '.$dt_nama.'');









//posisi detail dan data.
$pdf->SetX(10);
$pdf->SetY(20);


//topik/bab
$qmpx = mysql_query("SELECT * FROM guru_mapel_soal ".
			"WHERE kd_guru_mapel = '$gmkd'");
$rowmpx = mysql_fetch_assoc($qmpx);
$mpx_kd = nosql($rowmpx['kd']);
$mpx_judul = balikin($rowmpx['judul']);
$mpx_bobot = nosql($rowmpx['bobot']);
$mpx_menit = nosql($rowmpx['waktu']);


//soal
$qsol = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
			"WHERE kd_guru_mapel_soal = '$katkd'");
$rsol = mysql_fetch_assoc($qsol);
$tsol = mysql_num_rows($qsol);


//soal yang dikerjakan
$qsyd = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
			"WHERE kd_user = '$swkd' ".
			"AND kd_guru_mapel = '$gmkd' ".
			"AND kd_guru_mapel_soal = '$katkd'");
$rsyd = mysql_fetch_assoc($qsyd);
$tsyd = mysql_num_rows($qsyd);


//jml. jawaban BENAR
$qju = mysql_query("SELECT siswa_mapel_soal_detail.*, guru_mapel_soal_detail.* ".
			"FROM siswa_mapel_soal_detail, guru_mapel_soal_detail ".
			"WHERE siswa_mapel_soal_detail.kd_guru_mapel_soal_detail = guru_mapel_soal_detail.kd ".
			"AND siswa_mapel_soal_detail.kd_user = '$swkd' ".
			"AND siswa_mapel_soal_detail.kd_guru_mapel = '$gmkd' ".
			"AND siswa_mapel_soal_detail.kd_guru_mapel_soal = '$katkd' ".
			"AND siswa_mapel_soal_detail.jawab = guru_mapel_soal_detail.kunci");
$rju = mysql_fetch_assoc($qju);
$tju = mysql_num_rows($qju);


//jml. jawaban SALAH
$tsalah = round($tsyd - $tju);

//waktu mulai dan akhir
$qjux = mysql_query("SELECT * FROM siswa_mapel_soal ".
			"WHERE kd_user = '$swkd' ".
			"AND kd_guru_mapel = '$gmkd' ".
			"AND kd_guru_mapel_soal = '$katkd'");
$rjux = mysql_fetch_assoc($qjux);
$wk_mulai = $rjux['waktu_mulai'];
$wk_akhir = $rjux['waktu_akhir'];


//skor
$total_skor = round($tju*$mpx_bobot);



$pdf->Cell(100,5,'Judul/Topik/Bab : '.$mpx_judul.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Bobot Soal : '.$mpx_bobot.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Batas Waktu Pengerjaan : '.$mpx_menit.' Menit.',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Jumlah Soal : '.$tsol.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Waktu Mulai Pengerjaan : '.$wk_mulai.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Waktu Selesai Pengerjaan : '.$wk_akhir.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Jumlah Soal yang Dikerjakan : '.$tsyd.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Jumlah Jawaban Benar : '.$tju.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Jumlah Jawaban Salah : '.$tsalah.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,5,'Total Skor : '.$total_skor.'',0,0,'L');
$pdf->Ln();
$pdf->Ln();



//header
$pdf->Cell(10,5,'No.',1,0,'C',1);
$pdf->Cell(15,5,'Jawab',1,0,'C',1);
$pdf->Cell(20,5,'Status',1,0,'C',1);
$pdf->Ln();



//yang dijawab
$qjbu2 = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
			"WHERE kd_user = '$swkd' ".
			"AND kd_guru_mapel = '$gmkd' ".
			"AND kd_guru_mapel_soal = '$katkd' ".
			"ORDER BY round(no) ASC");
$rjbu2 = mysql_fetch_assoc($qjbu2);
$tjbu2 = mysql_num_rows($qjbu2);

do
	{
	//nilai
	$jbu_gmsd = nosql($rjbu2['kd_guru_mapel_soal_detail']);
	$jbu_no = nosql($rjbu2['no']);
	$jbu_jawab = nosql($rjbu2['jawab']);


	//kunci
	$qdku = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
				"WHERE kd = '$jbu_gmsd'");
	$rdku = mysql_fetch_assoc($qdku);
	$dku_kunci = nosql($rdku['kunci']);


	//deteksi kebenaran
	if ($jbu_jawab == $dku_kunci)
		{
		$d_status = "Benar.";
		}
	else
		{
		$d_status = "SALAH";
		}


	$pdf->Cell(10,5,$jbu_no,1,0,'C');
	$pdf->Cell(15,5,$jbu_jawab,1,0,'C');
	$pdf->Cell(20,5,$d_status,1,0,'C');
	$pdf->Ln();
	}
while ($rjbu2 = mysql_fetch_assoc($qjbu2));



//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("rekap_jawaban.pdf",I);
?>
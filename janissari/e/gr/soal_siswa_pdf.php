<?php
//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/class/rekap_kelas.php");

nocache;

//nilai
$gmkd = nosql($_REQUEST['gmkd']);
$katkd = nosql($_REQUEST['katkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$judul = "Daftar Siswa Yang Ikut Test Online";



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
$rkel = nosql($rk['kelas']);






//page ///////////////////////////////////////////
$pdf->SetY(10);
$pdf->SetX(10);

$pdf->SetFont('Times','B',14);
$pdf->Cell(190,5,':::Daftar Siswa Yang Ikut Test Online...',0,0,'C');
$pdf->Ln();
$pdf->Cell(190,0.1,'',1,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

//query
$qdt = mysql_query("SELECT * FROM guru_mapel_soal ".
			"WHERE kd_guru_mapel = '$gmkd' ".
			"AND kd = '$katkd'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_kd = nosql($rdt['kd']);
$dt_judul = balikin($rdt['judul']);
$dt_bobot = nosql($rdt['bobot']);
$dt_waktu = nosql($rdt['waktu']);
$dt_status = nosql($rdt['status']);

//jika true
if ($dt_status == "true")
	{
	$dt_statusx = "AKTIF";
	}
//false
else if ($dt_status == "false")
	{
	$dt_statusx = "Tidak Aktif";
	}




$pdf->SetFont('Times','B',10);
$pdf->Cell(190,5,'Judul/Topik/Bab : '.$dt_judul.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(190,5,'Bobot : '.$dt_bobot.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(190,5,'Waktu Maksimal Mengerjakan : '.$dt_waktu.'',0,0,'L');
$pdf->Ln();
$pdf->Cell(190,5,'Status : '.$dt_statusx.'',0,0,'L');
$pdf->Ln();
$pdf->Ln();



//query siswa yang ikut test online
//jika ada query kelas
if (!empty($kelkd))
	{
	$qdata = mysql_query("SELECT siswa_mapel_soal.*, siswa_mapel_soal.kd AS mskd, ".
				"m_user.*, m_user.kd AS mukd, m_kelas.* ".
				"FROM siswa_mapel_soal, m_user, m_kelas ".
				"WHERE siswa_mapel_soal.kd_user = m_user.kd ".
				"AND m_user.kd_kelas = m_kelas.kd ".
				"AND m_kelas.kd = '$kelkd' ".
				"AND siswa_mapel_soal.kd_guru_mapel = '$gmkd' ".
				"AND siswa_mapel_soal.kd_guru_mapel_soal = '$katkd' ".
				"ORDER BY round(m_user.nomor) ASC");
	}
else
	{
	$qdata = mysql_query("SELECT siswa_mapel_soal.*, siswa_mapel_soal.kd AS mskd, ".
				"m_user.*, m_user.kd AS mukd ".
				"FROM siswa_mapel_soal, m_user ".
				"WHERE siswa_mapel_soal.kd_user = m_user.kd ".
				"AND siswa_mapel_soal.kd_guru_mapel = '$gmkd' ".
				"AND siswa_mapel_soal.kd_guru_mapel_soal = '$katkd' ".
				"ORDER BY round(m_user.nomor) ASC");
	}

$rdata = mysql_fetch_assoc($qdata);



$pdf->SetFillColor(233,233,233);
$pdf->Cell(45,5,'Siswa',1,0,'L',1);
$pdf->Cell(10,5,'Kelas',1,0,'L',1);
$pdf->Cell(10,5,'Soal',1,0,'L',1);
$pdf->Cell(20,5,'Dikerjakan',1,0,'L',1);
$pdf->Cell(12,5,'Benar',1,0,'L',1);
$pdf->Cell(10,5,'Salah',1,0,'L',1);
$pdf->Cell(30,5,'Mulai',1,0,'L',1);
$pdf->Cell(30,5,'Selesai',1,0,'L',1);
$pdf->Cell(20,5,'skor',1,0,'L',1);
$pdf->Ln();



do
	{
	//nilai
	$d_mskd = nosql($rdata['mskd']);
	$d_kelkd = nosql($rdata['kd_kelas']);
	$d_mukd = nosql($rdata['mukd']);
	$d_no = nosql($rdata['nomor']);
	$d_nama = balikin($rdata['nama']);


	//jumlah soal
	$qsol = mysql_query("SELECT guru_mapel_soal.*, guru_mapel_soal_detail.* ".
				"FROM guru_mapel_soal, guru_mapel_soal_detail ".
				"WHERE guru_mapel_soal_detail.kd_guru_mapel_soal = guru_mapel_soal.kd ".
				"AND guru_mapel_soal.kd_guru_mapel = '$gmkd' ".
				"AND guru_mapel_soal.kd = '$katkd'");
	$rsol = mysql_fetch_assoc($qsol);
	$tsol = mysql_num_rows($qsol);


	//soal yang dikerjakan
	$qsyd = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
				"WHERE kd_user = '$d_mukd' ".
				"AND kd_guru_mapel = '$gmkd' ".
				"AND kd_guru_mapel_soal = '$katkd'");
	$rsyd = mysql_fetch_assoc($qsyd);
	$tsyd = mysql_num_rows($qsyd);


	//jml. jawaban BENAR
	$qju = mysql_query("SELECT siswa_mapel_soal_detail.*, guru_mapel_soal_detail.* ".
				"FROM siswa_mapel_soal_detail, guru_mapel_soal_detail ".
				"WHERE siswa_mapel_soal_detail.kd_guru_mapel_soal_detail = guru_mapel_soal_detail.kd ".
				"AND siswa_mapel_soal_detail.kd_user = '$d_mukd' ".
				"AND siswa_mapel_soal_detail.kd_guru_mapel = '$gmkd' ".
				"AND siswa_mapel_soal_detail.kd_guru_mapel_soal = '$katkd' ".
				"AND siswa_mapel_soal_detail.jawab = guru_mapel_soal_detail.kunci");
	$rju = mysql_fetch_assoc($qju);
	$tju = mysql_num_rows($qju);


	//jml. jawaban SALAH
	$tsalah = round($tsyd - $tju);

	//waktu mulai dan akhir
	$qjux = mysql_query("SELECT * FROM siswa_mapel_soal ".
				"WHERE kd_user = '$d_mukd' ".
				"AND kd_guru_mapel = '$gmkd' ".
				"AND kd_guru_mapel_soal = '$katkd'");
	$rjux = mysql_fetch_assoc($qjux);
	$wk_mulai = $rjux['waktu_mulai'];
	$wk_akhir = $rjux['waktu_akhir'];

	//skor
	$t_skor = round($tju * $dt_bobot);





	//kelas e
	$qkel = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$d_kelkd'");
	$rkel = mysql_fetch_assoc($qkel);
	$i_kelas = balikin($rkel['kelas']);


	//jika null
	if (empty($i_kelas))
		{
		$i_kelas = "-";
		}


	$pdf->SetFont('Times','',7);
	$pdf->Cell(45,5,''.$d_no.'. '.$d_nama.'',1,0,'L');
	$pdf->Cell(10,5,''.$i_kelas.'',1,0,'L');
	$pdf->Cell(10,5,''.$tsol.'',1,0,'L');
	$pdf->Cell(20,5,''.$tsyd.'',1,0,'L');
	$pdf->Cell(12,5,''.$tju.'',1,0,'L');
	$pdf->Cell(10,5,''.$tsalah.'',1,0,'L');
	$pdf->Cell(30,5,''.$wk_mulai.'',1,0,'L');
	$pdf->Cell(30,5,''.$wk_akhir.'',1,0,'L');
	$pdf->Cell(20,5,''.$t_skor.'',1,0,'L');
	$pdf->Ln();
	}
while ($rdata = mysql_fetch_assoc($qdata));






//output-kan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->Output("siswa_yang_ikut_test_online.pdf",I);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
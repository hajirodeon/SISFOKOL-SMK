<?php
//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/PHPExcel.php");


nocache;

//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$skkd = nosql($_REQUEST['skkd']);



//data diri
$qd = mysql_query("SELECT m_siswa.* ".
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
$kelas = $rkel;


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
$qwk = mysql_query("SELECT m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$tapelkd' ".
						"AND m_walikelas.kd_kelas = '$kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin2($rwk['nama']);





//nama file
$f_nis = strip($nis);
$f_nama = strip($nama);
$f_kelas = strip($kelas);
$f_tapel = strip($tapel);
$f_smt = strip($smt);
$i_filename = "raport_$f_nis-$f_nama-$f_kelas-$f_tapel-$f_smt.xls";






date_default_timezone_set("Asia/Jakarta");

$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("$sek_nama")->setLastModifiedBy("$sek_nama");





//Mengeset Syle nya
$headerStylenya = new PHPExcel_Style();
$bodyStylenya = new PHPExcel_Style();

$headerStylenya->applyFromArray(
array('fill' => array(
'type' => PHPExcel_Style_Fill::FILL_SOLID,
'color' => array('argb' => 'FFEEEEEE')),
'borders' => array('bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
)
));

$bodyStylenya->applyFromArray(
array('fill' => array(
'type' => PHPExcel_Style_Fill::FILL_SOLID,
'color' => array('argb' => 'FFFFFFFF')),
'borders' => array(
'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
)
));




$default_border = array(
    'style' => PHPExcel_Style_Border::BORDER_THIN,
    'color' => array('rgb'=>'000000')
);
$style_header = array(
    'borders' => array(
        'bottom' => $default_border,
        'left' => $default_border,
        'top' => $default_border,
        'right' => $default_border,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'c9c9c9'),
    ),
    'font' => array(
        'bold' => true,
    )
);

$style_data = array(
    'borders' => array(
        'bottom' => $default_border,
        'left' => $default_border,
        'top' => $default_border,
        'right' => $default_border,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'fffff1'),
    ),
    'font' => array(
        'bold' => false,
    )
);


$sheet = $objPHPExcel->setActiveSheetIndex(0)->setTitle('Raport');

$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
//$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_POTRAIT);




///////////////////////////////////////////////////////// HALAMAN I //////////////////////////////////////////////////////////////////////







 
 

//atur lebar kolom
$sheet->getColumnDimension('A')->setWidth(4);
$sheet->getColumnDimension('B')->setWidth(13);
$sheet->getColumnDimension('E')->setWidth(5);
$sheet->getColumnDimension('F')->setWidth(7);
$sheet->getColumnDimension('G')->setWidth(20);
$sheet->getColumnDimension('H')->setWidth(7);
$sheet->getColumnDimension('I')->setWidth(7);
$sheet->getColumnDimension('K')->setWidth(5);


//atur lebar baris
$sheet->getRowDimension('1')->setRowHeight(20);
$sheet->getRowDimension('9')->setRowHeight(25);
 
 
 
//header
$sheet->setCellValue('A1', 'LAPORAN HASIL BELAJAR');
$sheet->mergeCells('A1:K1');
$sheet->getStyle("A1:K1")->getFont()->setSize(16)->setBold(true)->setName('Arial Narrow');
$sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




$sheet->setCellValue('A2', 'Nama Sekolah');
$sheet->setCellValue('C2', ': '.$sek_nama.'');
$sheet->setCellValue('A3', 'Alamat');
$sheet->setCellValue('C3', ': '.$sek_alamat.'');
$sheet->setCellValue('A4', 'Nama');
$sheet->setCellValue('C4', ': '.$nama.'');
$sheet->setCellValue('A5', 'Nomor Induk Siswa');
$sheet->setCellValue('C5', ': '.$nis.'');


$sheet->setCellValue('H2', 'Kelas');
$sheet->setCellValue('J2', ': '.$kelas.'');
$sheet->setCellValue('H3', 'Semester');
$sheet->setCellValue('J3', ': '.$smt.'');
$sheet->setCellValue('H4', 'Tahun Pelajaran');
$sheet->setCellValue('J4', ': '.$tapel.'');






//header raport
$sheet->setCellValue('A8', 'No.');
$sheet->setCellValue('A9', '');
$sheet->mergeCells('A8:A9');
$sheet->getStyle('A8:A9')->applyFromArray( $style_header );
$sheet->getStyle('A8:A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet->setCellValue('B8', 'Mata Pelajaran');
$sheet->mergeCells('B8:D9');
$sheet->getStyle('B8:D9')->applyFromArray( $style_header );
$sheet->getStyle('B8:D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet->setCellValue('E8', 'KKM');
$sheet->mergeCells('E8:E9');
$sheet->getStyle('E8:E9')->applyFromArray( $style_header );
$sheet->getStyle('E8:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



$sheet->setCellValue('F8', 'Nilai Hasil Belajar');
$sheet->mergeCells('F8:K8');
$sheet->getStyle('F8:K8')->applyFromArray( $style_header );
$sheet->getStyle('F8:K8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




$sheet->setCellValue('F9', 'Angka');
$sheet->getStyle('F9')->applyFromArray( $style_header );
$sheet->getStyle('F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('G9', 'Huruf');
$sheet->mergeCells('G9:I9');
$sheet->getStyle('G9:I9')->applyFromArray( $style_header );
$sheet->getStyle('G9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('J9', 'Predikat');
$sheet->mergeCells('J9:K9');
$sheet->getStyle('J9:K9')->applyFromArray( $style_header );
$sheet->getStyle('J9:K9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);











//datanya
//kelompok 1 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "1";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".						
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);


//baris ke
$kkx = $ku_nomer + 9;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':K'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->applyFromArray( $style_data );




//netralkan dahulu
$jk = 0;


do
	{
	$pelkd = nosql($rpel['pelkd']);
			
			
			
	//detail e
	$qkuu = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$kkm = nosql($rkuu['kkm']);
	$jk = $jk + 1;
	$kkx2 = $jk + 10;

	$xyz = md5("$x$jk");

	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':D'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->applyFromArray( $style_data );
	



	$sheet->setCellValue('E'.$kkx2.'', ''.$kkm.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);


	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );


	$xpel_pengetahuan_h = xongkof($xpel_pengetahuan);
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_pengetahuan_h.'');
	$sheet->mergeCells('G'.$kkx2.':I'.$kkx2.'');
	$sheet->getStyle('G'.$kkx2.':I'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.':I'.$kkx2.'')->applyFromArray( $style_data );



	if ($xpel_pengetahuan < 60)
		{
		$xpel_pengetahuan_p = "Kurang";	
		}
	else if (($xpel_pengetahuan >= 60) AND ($xpel_pengetahuan < 75))  
		{
		$xpel_pengetahuan_p = "Cukup";			
		}
	else if (($xpel_pengetahuan >= 76) AND ($xpel_pengetahuan < 90))  
		{
		$xpel_pengetahuan_p = "Baik";			
		}
	else   
		{
		$xpel_pengetahuan_p = "Amat Baik";			
		}
		
		
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan_p.'');
	$sheet->mergeCells('J'.$kkx2.':K'.$kkx2.'');
	$sheet->getStyle('J'.$kkx2.':K'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('J'.$kkx2.':K'.$kkx2.'')->applyFromArray( $style_data );


	}
while ($rpel = mysql_fetch_assoc($qpel));







//kelompok 2 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "2";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel2 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".						
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel2 = mysql_fetch_assoc($qpel2);
$tpel2 = mysql_num_rows($qpel2);


//baris ke
$kkx = 11 + $tpel;
$kkxx = $kkx;

$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':K'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->applyFromArray( $style_data );





do
	{
	$pelkd = nosql($rpel2['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$kkm = nosql($rkuu['kkm']);
	$jk = $jk + 1;
	$kkx2 = $jk + 11;



	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':D'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->applyFromArray( $style_data );
	



	$sheet->setCellValue('E'.$kkx2.'', ''.$kkm.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);


	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );


	$xpel_pengetahuan_h = xongkof($xpel_pengetahuan);
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_pengetahuan_h.'');
	$sheet->mergeCells('G'.$kkx2.':I'.$kkx2.'');
	$sheet->getStyle('G'.$kkx2.':I'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.':I'.$kkx2.'')->applyFromArray( $style_data );



	if ($xpel_pengetahuan < 60)
		{
		$xpel_pengetahuan_p = "Kurang";	
		}
	else if (($xpel_pengetahuan >= 60) AND ($xpel_pengetahuan < 75))  
		{
		$xpel_pengetahuan_p = "Cukup";			
		}
	else if (($xpel_pengetahuan >= 76) AND ($xpel_pengetahuan < 90))  
		{
		$xpel_pengetahuan_p = "Baik";			
		}
	else   
		{
		$xpel_pengetahuan_p = "Amat Baik";			
		}
		
		
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan_p.'');
	$sheet->mergeCells('J'.$kkx2.':K'.$kkx2.'');
	$sheet->getStyle('J'.$kkx2.':K'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('J'.$kkx2.':K'.$kkx2.'')->applyFromArray( $style_data );


	}
while ($rpel2 = mysql_fetch_assoc($qpel2));











//kelompok 3 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel3 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".						
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel3 = mysql_fetch_assoc($qpel3);
$tpel3 = mysql_num_rows($qpel3);


//baris ke
$kkx = 12 + $tpel + $tpel2;
$kkxx = $kkx;



$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':K'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->applyFromArray( $style_data );





do
	{
	$pelkd = nosql($rpel3['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$kkm = nosql($rkuu['kkm']);
	$jk = $jk + 1;
	$kkx2 = $jk + 12;



	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':D'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->applyFromArray( $style_data );
	



	$sheet->setCellValue('E'.$kkx2.'', ''.$kkm.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);


	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );


	$xpel_pengetahuan_h = xongkof($xpel_pengetahuan);
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_pengetahuan_h.'');
	$sheet->mergeCells('G'.$kkx2.':I'.$kkx2.'');
	$sheet->getStyle('G'.$kkx2.':I'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.':I'.$kkx2.'')->applyFromArray( $style_data );




	if ($xpel_pengetahuan > 69)
		{
		$xpel_pengetahuan_p = "Kompeten";	
		}
	else   
		{
		$xpel_pengetahuan_p = "Belum Kompeten";			
		}
		
		
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan_p.'');
	$sheet->mergeCells('J'.$kkx2.':K'.$kkx2.'');
	$sheet->getStyle('J'.$kkx2.':K'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('J'.$kkx2.':K'.$kkx2.'')->applyFromArray( $style_data );

	}
while ($rpel3 = mysql_fetch_assoc($qpel3));












//kelompok 4 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "4";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel4 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".						
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel4 = mysql_fetch_assoc($qpel4);
$tpel4 = mysql_num_rows($qpel4);


//baris ke
$kkx = 13 + $tpel + $tpel2 + $tpel3;
$kkxx = $kkx;




$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':K'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->applyFromArray( $style_data );



do
	{
	$pelkd = nosql($rpel4['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$kkm = nosql($rkuu['kkm']);
	$jk = $jk + 1;
	$kkx2 = $jk + 13;


	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':D'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':D'.$kkx2.'')->applyFromArray( $style_data );
	



	$sheet->setCellValue('E'.$kkx2.'', ''.$kkm.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);


	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );


	$xpel_pengetahuan_h = xongkof($xpel_pengetahuan);
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_pengetahuan_h.'');
	$sheet->mergeCells('G'.$kkx2.':I'.$kkx2.'');
	$sheet->getStyle('G'.$kkx2.':I'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.':I'.$kkx2.'')->applyFromArray( $style_data );



	if ($xpel_pengetahuan < 60)
		{
		$xpel_pengetahuan_p = "Kurang";	
		}
	else if (($xpel_pengetahuan >= 60) AND ($xpel_pengetahuan < 75))  
		{
		$xpel_pengetahuan_p = "Cukup";			
		}
	else if (($xpel_pengetahuan >= 76) AND ($xpel_pengetahuan < 90))  
		{
		$xpel_pengetahuan_p = "Baik";			
		}
	else   
		{
		$xpel_pengetahuan_p = "Amat Baik";			
		}
		
		
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan_p.'');
	$sheet->mergeCells('J'.$kkx2.':K'.$kkx2.'');
	$sheet->getStyle('J'.$kkx2.':K'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('J'.$kkx2.':K'.$kkx2.'')->applyFromArray( $style_data );
	}
while ($rpel4 = mysql_fetch_assoc($qpel4));











//antar mapel ////////////////////////////////////////////////////////////////////////////////////////////////
//ketahui jumlah mapel
$qpel44 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'");						
$rpel44 = mysql_fetch_assoc($qpel44);
$tpel44 = mysql_num_rows($qpel44);


//jml baris
$jmlbarisnya = $tpel44 + 4 + 6;


//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);



/*
$sheet->setCellValue('I11', ''.$catx_catatan.'');
$sheet->setCellValue('I'.$jmlbarisnya.'', '');
$sheet->mergeCells('I11:I'.$jmlbarisnya.'');
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->applyFromArray( $style_data );

*/








//jumlah nilai /////////////////////////////////////////////////////////////////////////////////////////////
//nil mapel
$qxpel = mysql_query("SELECT SUM(nil_raport_pengetahuan_a) AS totalku ".
						"FROM siswa_nilai_raport ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
$rxpel = mysql_fetch_assoc($qxpel);
$txpel = mysql_num_rows($qxpel);
$totalku = nosql($rxpel['totalku']);


$jmlbarisnya = $tpel44 + 4 + 10;
$sheet->setCellValue('A'.$jmlbarisnya.'', 'Jumlah Nilai');
$sheet->mergeCells('A'.$jmlbarisnya.':E'.$jmlbarisnya.'');

$sheet->getStyle('A'.$jmlbarisnya.':E'.$jmlbarisnya.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A'.$jmlbarisnya.':E'.$jmlbarisnya.'')->applyFromArray( $style_header );


$sheet->setCellValue('F'.$jmlbarisnya.'', ''.$totalku.'');
$sheet->getStyle('F'.$jmlbarisnya.'')->applyFromArray( $style_header );

$sheet->setCellValue('G'.$jmlbarisnya.'', '');
$sheet->mergeCells('G'.$jmlbarisnya.':K'.$jmlbarisnya.'');
$sheet->getStyle('G'.$jmlbarisnya.':K'.$jmlbarisnya.'')->applyFromArray( $style_header );





//ipk /////////////////////////////////////////////////////////////////////////////////////////////
//jml mapel
$qpel = mysql_query("SELECT m_prog_pddkn.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);



//nil mapel
$qxpel = mysql_query("SELECT AVG(nil_raport_pengetahuan_a) AS totalku ".
						"FROM siswa_nilai_raport ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
$rxpel = mysql_fetch_assoc($qxpel);
$txpel = mysql_num_rows($qxpel);
$totalku = nosql($rxpel['totalku']);
$ipk = round(($totalku) / 2,2);


$jmlbarisnya = $tpel44 + 4 + 11;
$sheet->setCellValue('A'.$jmlbarisnya.'', 'Nilai Rata - Rata');
$sheet->mergeCells('A'.$jmlbarisnya.':E'.$jmlbarisnya.'');

$sheet->getStyle('A'.$jmlbarisnya.':E'.$jmlbarisnya.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A'.$jmlbarisnya.':E'.$jmlbarisnya.'')->applyFromArray( $style_header );


$sheet->setCellValue('F'.$jmlbarisnya.'', ''.$ipk.'');
$sheet->getStyle('F'.$jmlbarisnya.'')->applyFromArray( $style_header );

$sheet->setCellValue('G'.$jmlbarisnya.'', '');
$sheet->mergeCells('G'.$jmlbarisnya.':K'.$jmlbarisnya.'');
$sheet->getStyle('G'.$jmlbarisnya.':K'.$jmlbarisnya.'')->applyFromArray( $style_header );









//peringkat kelas /////////////////////////////////////////////////////////////////////////////////////////////
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




$jmlbarisnya = $tpel44 + 4 + 12;
$sheet->setCellValue('A'.$jmlbarisnya.'', 'Peringkat Kelas');
$sheet->mergeCells('A'.$jmlbarisnya.':E'.$jmlbarisnya.'');
$sheet->getStyle('A'.$jmlbarisnya.':E'.$jmlbarisnya.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A'.$jmlbarisnya.':E'.$jmlbarisnya.'')->applyFromArray( $style_header );


//peringkat ke...
$jks_nilx_rangking = xongkof($nilx_rangking);
$jks_tjks = xongkof($tjks);
$jks_rangking = "$nilx_rangking";


$sheet->setCellValue('F'.$jmlbarisnya.'', ''.$jks_rangking.'');
$sheet->getStyle('F'.$jmlbarisnya.'')->applyFromArray( $style_header );

$sheet->setCellValue('G'.$jmlbarisnya.'', '');
$sheet->mergeCells('G'.$jmlbarisnya.':K'.$jmlbarisnya.'');
$sheet->getStyle('G'.$jmlbarisnya.':K'.$jmlbarisnya.'')->applyFromArray( $style_header );














//ekstra /////////////////////////////////////////////////////////////////////////////////////////////////////////
//$posisi1 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + 20;
$posisi1 = ($tpel + $tpel2 + $tpel3 + $tpel4) + 18;
$sheet->setCellValue('A'.$posisi1.'', 'Pengembangan Diri');
$sheet->mergeCells('A'.$posisi1.':E'.$posisi1.'');
$sheet->getStyle('A'.$posisi1.':E'.$posisi1.'')->applyFromArray( $style_header );
$sheet->setCellValue('F'.$posisi1.'', 'Nilai');
$sheet->getStyle('F'.$posisi1.'')->applyFromArray( $style_header );
$sheet->setCellValue('G'.$posisi1.'', 'Keterangan');
$sheet->mergeCells('G'.$posisi1.':K'.$posisi1.'');
$sheet->getStyle('G'.$posisi1.':K'.$posisi1.'')->applyFromArray( $style_header );


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
	$nomx = $nomx + 1;
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);

//	$posisi11 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + 20 + $nomx;
	$posisi11 = ($tpel + $tpel2 + $tpel3 + $tpel4) + 18 + $nomx;
	$sheet->setCellValue('A'.$posisi11.'', ''.$nomx.'.');
	$sheet->getStyle('A'.$posisi11.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$posisi11.'')->applyFromArray( $style_data );
	$sheet->setCellValue('B'.$posisi11.'', ''.$kuti_ekstra.'');
	$sheet->mergeCells('B'.$posisi11.':E'.$posisi11.'');
	$sheet->getStyle('B'.$posisi11.':E'.$posisi11.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$posisi11.'', ''.$kuti_predikat.'');
	$sheet->getStyle('F'.$posisi11.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$posisi11.'', ''.$kuti_ket.'');
	$sheet->mergeCells('G'.$posisi11.':K'.$posisi11.'');
	$sheet->getStyle('G'.$posisi11.':K'.$posisi11.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));













//ketidakhadiran /////////////////////////////////////////////////////////////////////////////////////////////////////////
//$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 23;
$posisi2 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 13;
$sheet->setCellValue('A'.$posisi2.'', 'Ketidakhadiran');
$sheet->mergeCells('A'.$posisi2.':K'.$posisi2.'');
$sheet->getStyle('A'.$posisi2.':K'.$posisi2.'')->applyFromArray( $style_header );

//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);




do
	{
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

//	$posisi21 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 23 + $nomxz;
	$posisi21 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 13 + $nomxz;
	$sheet->setCellValue('A'.$posisi21.'', ''.$nomxz.'');
	$sheet->getStyle('A'.$posisi21.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->setCellValue('B'.$posisi21.'', ''.$abs_absensi.'');
	$sheet->setCellValue('D'.$posisi21.'', ': '.$tbsix.'');
	}
while ($rabs = mysql_fetch_assoc($qabs));


//bikin kotak
//$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 23 + 1;
$posisi2 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 13 + 1;
//$posisi22 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 23 + $tabs;
$posisi22 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 13 + $tabs;
$sheet->getStyle('A'.$posisi2.':K'.$posisi22.'')->applyFromArray( $style_data );








//catatan wali kelas /////////////////////////////////////////////////////////////////////////////////////////////////////////
//$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 22 + $tabs + 3;
$posisi2 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 15 + $tabs + 3;
$sheet->setCellValue('A'.$posisi2.'', 'Catatan Wali Kelas');
$sheet->mergeCells('A'.$posisi2.':K'.$posisi2.'');
$sheet->getStyle('A'.$posisi2.':K'.$posisi2.'')->applyFromArray( $style_header );


//bikin kotak
//$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 22 + $tabs + 4;
$posisi2 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 15 + $tabs + 4;
//$posisi22 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 22 + $tabs + 8;
$posisi22 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 15 + $tabs + 8;

$sheet->setCellValue('A'.$posisi2.'', ''.$catx_catatan.'');
$sheet->mergeCells('A'.$posisi2.':K'.$posisi22.'');
$sheet->getStyle('A'.$posisi2.':K'.$posisi22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A'.$posisi2.':K'.$posisi22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('A'.$posisi2.':K'.$posisi22.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('A'.$posisi2.':K'.$posisi22.'')->applyFromArray( $style_data );











//naik ato lulus, ///////////////////////////////////////////////
//posisi
//$posisi33 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs;
$posisi33 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 25 + $tabs;


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
	$posisi331 = $posisi33 + 1;
	$sheet->setCellValue('C'.$posisi331.'', 'Mengetahui');

	$posisi331 = $posisi33 + 2;
	$sheet->setCellValue('C'.$posisi331.'', 'Wali Kelas');

	$posisi331 = $posisi33 + 6;
	$sheet->setCellValue('C'.$posisi331.'', ''.$nwk.'');

	$posisi331 = $posisi33 + 9;
	$sheet->setCellValue('C'.$posisi331.'', 'Orang Tua/Wali');
	
	$posisi331 = $posisi33 + 13;
	$sheet->setCellValue('C'.$posisi331.'', '..........................');

		

	
	//posisi
	$posisi331 = $posisi33 + 1;
	$posawal331 = $posisi331;
	$sheet->setCellValue('F'.$posisi331.'', 'Keputusan');
	$posisi331 = $posisi33 + 2;
	$sheet->setCellValue('F'.$posisi331.'', 'Berdasarkan hasil yang dicapai pada');
	$posisi331 = $posisi33 + 3;
	$sheet->setCellValue('F'.$posisi331.'', 'Semester 1 dan 2, peserta didik ditetapkan');
	$posisi331 = $posisi33 + 5;
	$sheet->setCellValue('F'.$posisi331.'', ''.$ket_naik.'');


	$posisi331 = $posisi33 + 8;
	$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
	$sheet->setCellValue('F'.$posisi331.'', ''.$nil_tgl.'');
	


	$posisi331 = $posisi33 + 9;
	$sheet->setCellValue('F'.$posisi331.'', 'Kepala Sekolah');
	
	//kepala sekolah
	$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
							"FROM admin_ks, m_pegawai ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rks = mysql_fetch_assoc($qks);
	$tks = mysql_num_rows($qks);
	$ks_nip = nosql($rks['nip']);
	$ks_nama = balikin($rks['nama']);
	
	$posisi331 = $posisi33 + 13;
	$posakhir331 = $posisi331;
	$sheet->setCellValue('F'.$posisi331.'', ''.$ks_nama.'');
	
	
	$sheet->getStyle('F'.$posawal331.':J'.$posakhir331.'')->applyFromArray( $style_data );
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
	$posisi331 = $posisi33 + 1;
	$sheet->setCellValue('C'.$posisi331.'', 'Mengetahui');

	$posisi331 = $posisi33 + 2;
	$sheet->setCellValue('C'.$posisi331.'', 'Wali Kelas');

	$posisi331 = $posisi33 + 6;
	$sheet->setCellValue('C'.$posisi331.'', ''.$nwk.'');

	$posisi331 = $posisi33 + 9;
	$sheet->setCellValue('C'.$posisi331.'', 'Orang Tua/Wali');
	
	$posisi331 = $posisi33 + 13;
	$sheet->setCellValue('C'.$posisi331.'', '..........................');

		

	
	//posisi
	$posisi331 = $posisi33 + 1;
	$posawal331 = $posisi331;
	$sheet->setCellValue('F'.$posisi331.'', 'Keputusan');
	$posisi331 = $posisi33 + 2;
	$sheet->setCellValue('F'.$posisi331.'', 'Berdasarkan hasil yang dicapai pada');
	$posisi331 = $posisi33 + 3;
	$sheet->setCellValue('F'.$posisi331.'', 'masa pendidikan, peserta didik ditetapkan');
	$posisi331 = $posisi33 + 5;
	$sheet->setCellValue('F'.$posisi331.'', ''.$ket_lulus.'');

	$posisi331 = $posisi33 + 8;
	$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
	$sheet->setCellValue('F'.$posisi331.'', ''.$nil_tgl.'');
	


	$posisi331 = $posisi33 + 9;
	$sheet->setCellValue('F'.$posisi331.'', 'Kepala Sekolah');
	
	//kepala sekolah
	$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
							"FROM admin_ks, m_pegawai ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rks = mysql_fetch_assoc($qks);
	$tks = mysql_num_rows($qks);
	$ks_nip = nosql($rks['nip']);
	$ks_nama = balikin($rks['nama']);
	
	$posisi331 = $posisi33 + 13;
	$posakhir331 = $posisi331;
	$sheet->setCellValue('F'.$posisi331.'', ''.$ks_nama.'');
	
	
	$sheet->getStyle('F'.$posawal331.':J'.$posakhir331.'')->applyFromArray( $style_data );
	}


else 
	{
	//semester ganjil
	//Tanda tangan dan tgl ////////////////////////////////////////
//	$posisi33 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs;
	$posisi33 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 25 + $tabs;
	$sheet->setCellValue('H'.$posisi33.'', "$sek_kota, $tanggal $arrbln1[$bulan] $tahun");
	
	
//	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 1;
	$posisi34 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 25 + $tabs + 1;
	$sheet->setCellValue('C'.$posisi34.'', 'Mengetahui');
	
//	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 2;
	$posisi34 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 25 + $tabs + 2;
	$sheet->setCellValue('C'.$posisi34.'', 'Kepala Sekolah');
	
	//kepala sekolah
	$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
							"FROM admin_ks, m_pegawai ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rks = mysql_fetch_assoc($qks);
	$tks = mysql_num_rows($qks);
	$ks_nip = nosql($rks['nip']);
	$ks_nama = balikin($rks['nama']);
	
//	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 6;
	$posisi34 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 25 + $tabs + 6;
	$sheet->setCellValue('C'.$posisi34.'', ''.$ks_nama.'');
	
	
	
//	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 2;
	$posisi34 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 25 + $tabs + 2;
	$sheet->setCellValue('H'.$posisi34.'', 'Wali Kelas');
	
	
	
	
//	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 6;
	$posisi34 = ($tpel + $tpel2 + $tpel3 + $tpel4) + $tkuti + 25 + $tabs + 6;
	$sheet->setCellValue('H'.$posisi34.'', ''.$nwk.'');
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









/////////////////////////////////////// SHEET KEDUA ////////////////////////////////////////////////////////////////////////
$objPHPExcel->createSheet();
$sheet = $objPHPExcel->setActiveSheetIndex(1)->setTitle('Deskripsi');





//atur lebar kolom
$sheet->getColumnDimension('A')->setWidth(4);
$sheet->getColumnDimension('B')->setWidth(13);
$sheet->getColumnDimension('E')->setWidth(5);
$sheet->getColumnDimension('F')->setWidth(7);
$sheet->getColumnDimension('G')->setWidth(20);
$sheet->getColumnDimension('H')->setWidth(7);
$sheet->getColumnDimension('I')->setWidth(7);
$sheet->getColumnDimension('K')->setWidth(5);



//atur lebar baris
$sheet->getRowDimension('1')->setRowHeight(20);


 
 
//header
$sheet->setCellValue('A1', 'DESKRIPSI KEMAJUAN BELAJAR SISWA');
$sheet->mergeCells('A1:K1');
$sheet->getStyle("A1:K1")->getFont()->setSize(16)->setBold(true)->setName('Arial Narrow');
$sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




$sheet->setCellValue('A2', 'Nama Sekolah');
$sheet->setCellValue('C2', ': '.$sek_nama.'');
$sheet->setCellValue('A3', 'Alamat');
$sheet->setCellValue('C3', ': '.$sek_alamat.'');
$sheet->setCellValue('A4', 'Nama');
$sheet->setCellValue('C4', ': '.$nama.'');
$sheet->setCellValue('A5', 'Nomor Induk Siswa');
$sheet->setCellValue('C5', ': '.$nis.'');


$sheet->setCellValue('H2', 'Kelas');
$sheet->setCellValue('J2', ': '.$kelas.'');
$sheet->setCellValue('H3', 'Semester');
$sheet->setCellValue('J3', ': '.$smt.'');
$sheet->setCellValue('H4', 'Tahun Pelajaran');
$sheet->setCellValue('J4', ': '.$tapel.'');






//header raport
$sheet->setCellValue('A8', 'No.');
$sheet->getStyle('A8')->applyFromArray( $style_header );
$sheet->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet->setCellValue('B8', 'MATA PELAJARAN');
$sheet->mergeCells('B8:E8');
$sheet->getStyle('B8:E8')->applyFromArray( $style_header );
$sheet->getStyle('B8:E8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



$sheet->setCellValue('F8', 'DESKRIPSI');
$sheet->mergeCells('F8:K8');
$sheet->getStyle('F8:K8')->applyFromArray( $style_header );
$sheet->getStyle('F8:K8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);







//datanya
//kelompok 1 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "1";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".						
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);


//baris ke
$kkx = $ku_nomer + 8;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':K'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->applyFromArray( $style_data );




//netralkan dahulu
$jk = 0;


do
	{
	$pelkd = nosql($rpel['pelkd']);
			
			
			
	//detail e
	$qkuu = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$kkm = nosql($rkuu['kkm']);
	$jk = $jk + 1;
	$kkx2 = $jk + 9;

	$xyz = md5("$x$jk");

	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':E'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->applyFromArray( $style_data );
	


	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_k_pengetahuan']);




		
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->mergeCells('F'.$kkx2.':K'.$kkx2.'');
	$sheet->getStyle('F'.$kkx2.':K'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.':K'.$kkx2.'')->applyFromArray( $style_data );


	}
while ($rpel = mysql_fetch_assoc($qpel));







//kelompok 2 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "2";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel2 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".						
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel2 = mysql_fetch_assoc($qpel2);
$tpel2 = mysql_num_rows($qpel2);


//baris ke
$kkx = 10 + $tpel;
$kkxx = $kkx;

$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':K'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->applyFromArray( $style_data );





do
	{
	$pelkd = nosql($rpel2['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$kkm = nosql($rkuu['kkm']);
	$jk = $jk + 1;
	$kkx2 = $jk + 10;


	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':E'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->applyFromArray( $style_data );
	


	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_k_pengetahuan']);




		
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->mergeCells('F'.$kkx2.':K'.$kkx2.'');
	$sheet->getStyle('F'.$kkx2.':K'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.':K'.$kkx2.'')->applyFromArray( $style_data );



	}
while ($rpel2 = mysql_fetch_assoc($qpel2));











//kelompok 3 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel3 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".						
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel3 = mysql_fetch_assoc($qpel3);
$tpel3 = mysql_num_rows($qpel3);


//baris ke
$kkx = 11 + $tpel + $tpel2;
$kkxx = $kkx;



$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':K'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->applyFromArray( $style_data );





do
	{
	$pelkd = nosql($rpel3['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$kkm = nosql($rkuu['kkm']);
	$jk = $jk + 1;
	$kkx2 = $jk + 11;



	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':E'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->applyFromArray( $style_data );
	


	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_k_pengetahuan']);




		
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->mergeCells('F'.$kkx2.':K'.$kkx2.'');
	$sheet->getStyle('F'.$kkx2.':K'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.':K'.$kkx2.'')->applyFromArray( $style_data );

	}
while ($rpel3 = mysql_fetch_assoc($qpel3));












//kelompok 4 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "4";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel4 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".						
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel4 = mysql_fetch_assoc($qpel4);
$tpel4 = mysql_num_rows($qpel4);


//baris ke
$kkx = 12 + $tpel + $tpel2 + $tpel3;
$kkxx = $kkx;




$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':K'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':K'.$kkxx.'')->applyFromArray( $style_data );



do
	{
	$pelkd = nosql($rpel4['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$kkm = nosql($rkuu['kkm']);
	$jk = $jk + 1;
	$kkx2 = $jk + 12;


	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':E'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':E'.$kkx2.'')->applyFromArray( $style_data );
	


	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_k_pengetahuan']);




		
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->mergeCells('F'.$kkx2.':K'.$kkx2.'');
	$sheet->getStyle('F'.$kkx2.':K'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.':K'.$kkx2.'')->applyFromArray( $style_data );

	}
while ($rpel4 = mysql_fetch_assoc($qpel4));

















 

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$i_filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0





$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;









//diskonek
xclose($koneksi);
exit();
?>
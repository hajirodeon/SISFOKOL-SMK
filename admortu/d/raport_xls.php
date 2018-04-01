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


$sheet->getProtection()->setSheet(true);
$sheet->getProtection()->setPassword($x);



///////////////////////////////////////////////////////// HALAMAN I //////////////////////////////////////////////////////////////////////







 
 

//atur lebar kolom
$sheet->getColumnDimension('A')->setWidth(4);
$sheet->getColumnDimension('B')->setWidth(17);
$sheet->getColumnDimension('I')->setWidth(13);


//atur lebar baris
$sheet->getRowDimension('1')->setRowHeight(20);
$sheet->getRowDimension('9')->setRowHeight(25);
 
 
 
//header
$sheet->setCellValue('A1', 'LAPORAN HASIL BELAJAR');
$sheet->mergeCells('A1:J1');
$sheet->getStyle("A1:J1")->getFont()->setSize(16)->setBold(true)->setName('Arial Narrow');
$sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




$sheet->setCellValue('A2', 'Nama Sekolah');
$sheet->setCellValue('C2', ': '.$sek_nama.'');
$sheet->setCellValue('A3', 'Alamat');
$sheet->setCellValue('C3', ': '.$sek_alamat.'');
$sheet->setCellValue('A4', 'Nama');
$sheet->setCellValue('C4', ': '.$nama.'');
$sheet->setCellValue('A5', 'Nomor Induk NIS/NISN');
$sheet->setCellValue('C5', ': '.$nis.'');


$sheet->setCellValue('G2', 'Kelas');
$sheet->setCellValue('I2', ': '.$kelas.'');
$sheet->setCellValue('G3', 'Semester');
$sheet->setCellValue('I3', ': '.$smt.'');
$sheet->setCellValue('G4', 'Tahun Pelajaran');
$sheet->setCellValue('I4', ': '.$tapel.'');






//header raport
$sheet->setCellValue('A8', 'No.');
$sheet->setCellValue('A9', '');
$sheet->setCellValue('A10', '');
$sheet->mergeCells('A8:A10');
$sheet->getStyle('A8:A10')->applyFromArray( $style_header );


$sheet->setCellValue('B8', 'Mata Pelajaran');
$sheet->setCellValue('C8', '');
$sheet->setCellValue('B9', '');
$sheet->setCellValue('C9', '');
$sheet->setCellValue('C10', '');
$sheet->mergeCells('B8:C10');
$sheet->getStyle('B8:C10')->applyFromArray( $style_header );


$sheet->setCellValue('D8', 'Pengetahuan');
$sheet->setCellValue('E8', '');
$sheet->mergeCells('D8:E8');
$sheet->getStyle('D8:E8')->applyFromArray( $style_header );
$sheet->setCellValue('D9', 'Angka');
$sheet->getStyle('D9')->applyFromArray( $style_header );
$sheet->setCellValue('E9', 'Predikat');
$sheet->getStyle('D9')->applyFromArray( $style_header );
$sheet->setCellValue('D10', '1 - 4');
$sheet->getStyle('D10')->applyFromArray( $style_header );
$sheet->setCellValue('E10', 'A - D');
$sheet->getStyle('E10')->applyFromArray( $style_header );

$sheet->setCellValue('F8', 'Keterampilan');
$sheet->setCellValue('G8', '');
$sheet->mergeCells('F8:G8');
$sheet->getStyle('F8:G8')->applyFromArray( $style_header );
$sheet->setCellValue('F9', 'Angka');
$sheet->getStyle('F9')->applyFromArray( $style_header );
$sheet->setCellValue('G9', 'Predikat');
$sheet->getStyle('G9')->applyFromArray( $style_header );
$sheet->setCellValue('F10', '1 - 4');
$sheet->getStyle('F10')->applyFromArray( $style_header );
$sheet->setCellValue('G10', 'A - D');
$sheet->getStyle('F10')->applyFromArray( $style_header );

$sheet->setCellValue('H8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('I8', '');
$sheet->mergeCells('H8:I8');
$sheet->getStyle('H8:I8')->applyFromArray( $style_header );
$sheet->setCellValue('H9', 'Dalam Mapel');
$sheet->getStyle('H9')->getAlignment()->setWrapText(true);
$sheet->setCellValue('I9', 'Antar Mata Pelajaran');
$sheet->setCellValue('I10', '');
$sheet->mergeCells('I9:I10');
$sheet->getStyle('I9:I10')->applyFromArray( $style_header );
$sheet->getStyle('I9:I10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('H10', 'SB/B/C/K');
$sheet->getStyle('H10')->applyFromArray( $style_header );


$sheet->getStyle('A8:H10')->applyFromArray( $style_header );










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
$kkx = $ku_nomer + 10;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':H'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->applyFromArray( $style_data );




//netralkan dahulu
$jk = 0;


do
	{
	$pelkd = nosql($rpel['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = $jk + 11;

	$xyz = md5("$x$jk");

	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->applyFromArray( $style_data );
	


	//catatan	
	$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd'");
	$rcatx = mysql_fetch_assoc($qcatx);
	$tcatx = mysql_num_rows($qcatx);
	$catx_catatan = balikin($rcatx['catatan']);
	
		
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


	$sheet->setCellValue('D'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );


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
$kkx = 12 + $tpel;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':H'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->applyFromArray( $style_data );





do
	{
	$pelkd = nosql($rpel2['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = $jk + 12;



	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);

	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->applyFromArray( $style_data );
	


		
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



	$sheet->setCellValue('D'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );
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
$kkx = 13 + $tpel + $tpel2;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':H'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->applyFromArray( $style_data );




do
	{
	$pelkd = nosql($rpel3['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = $jk + 13;


	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);


	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->applyFromArray( $style_data );
	



		
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

	
	$sheet->setCellValue('D'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );

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
$kkx = 15 + $tpel + $tpel2 + $tpel3;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':H'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->applyFromArray( $style_data );




do
	{
	$pelkd = nosql($rpel4['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = $jk + 15;



	//atur lebar baris
	$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(30);

	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx2.'');
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->applyFromArray( $style_data );
	


		
		
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

		
	$sheet->setCellValue('D'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );


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



$sheet->setCellValue('I11', ''.$catx_catatan.'');
$sheet->setCellValue('I'.$jmlbarisnya.'', '');
$sheet->mergeCells('I11:I'.$jmlbarisnya.'');
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->applyFromArray( $style_data );










//jumlah nilai /////////////////////////////////////////////////////////////////////////////////////////////
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


$jmlbarisnya = $tpel44 + 4 + 7;
$sheet->setCellValue('A'.$jmlbarisnya.'', 'Jumlah Nilai');
$sheet->mergeCells('A'.$jmlbarisnya.':C'.$jmlbarisnya.'');

$sheet->getStyle('A'.$jmlbarisnya.':C'.$jmlbarisnya.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A'.$jmlbarisnya.':C'.$jmlbarisnya.'')->applyFromArray( $style_header );


$sheet->setCellValue('D'.$jmlbarisnya.'', ''.$totalku.'');
$sheet->getStyle('D'.$jmlbarisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('E'.$jmlbarisnya.'', '');
$sheet->getStyle('E'.$jmlbarisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('F'.$jmlbarisnya.'', ''.$totalku2.'');
$sheet->getStyle('F'.$jmlbarisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('G'.$jmlbarisnya.'', '');
$sheet->getStyle('G'.$jmlbarisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('H'.$jmlbarisnya.'', '');
$sheet->mergeCells('H'.$jmlbarisnya.':I'.$jmlbarisnya.'');
$sheet->getStyle('H'.$jmlbarisnya.':I'.$jmlbarisnya.'')->applyFromArray( $style_header );








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
$qxpel = mysql_query("SELECT AVG(nil_raport_pengetahuan_a) AS totalku, ".
						"AVG(nil_raport_ketrampilan_a) AS totalku2 ".
						"FROM siswa_nilai_raport ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
$rxpel = mysql_fetch_assoc($qxpel);
$txpel = mysql_num_rows($qxpel);
$totalku = nosql($rxpel['totalku']);
$totalku2 = nosql($rxpel['totalku2']);
$ipk = round(($totalku + $totalku2) / 2,2);


$jmlbarisnya = $tpel44 + 4 + 8;
$sheet->setCellValue('A'.$jmlbarisnya.'', 'Indeks Prestasi Komulatif');
$sheet->mergeCells('A'.$jmlbarisnya.':C'.$jmlbarisnya.'');

$sheet->getStyle('A'.$jmlbarisnya.':C'.$jmlbarisnya.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A'.$jmlbarisnya.':C'.$jmlbarisnya.'')->applyFromArray( $style_header );


$sheet->setCellValue('D'.$jmlbarisnya.'', ''.$ipk.'');
$sheet->getStyle('D'.$jmlbarisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('E'.$jmlbarisnya.'', '');
$sheet->getStyle('E'.$jmlbarisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('F'.$jmlbarisnya.'', '');
$sheet->getStyle('F'.$jmlbarisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('G'.$jmlbarisnya.'', '');
$sheet->getStyle('G'.$jmlbarisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('H'.$jmlbarisnya.'', '');
$sheet->mergeCells('H'.$jmlbarisnya.':I'.$jmlbarisnya.'');
$sheet->getStyle('H'.$jmlbarisnya.':I'.$jmlbarisnya.'')->applyFromArray( $style_header );







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




$jmlbarisnya = $tpel44 + 4 + 9;
$sheet->setCellValue('A'.$jmlbarisnya.'', 'Peringkat Kelas');
$sheet->mergeCells('A'.$jmlbarisnya.':C'.$jmlbarisnya.'');

$sheet->getStyle('A'.$jmlbarisnya.':C'.$jmlbarisnya.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A'.$jmlbarisnya.':C'.$jmlbarisnya.'')->applyFromArray( $style_header );


//peringkat ke...
$jks_nilx_rangking = xongkof($nilx_rangking);
$jks_tjks = xongkof($tjks);
$jks_rangking = "$nilx_rangking ( $jks_nilx_rangking) dari $tjks ( $jks_tjks) siswa";


$sheet->setCellValue('D'.$jmlbarisnya.'', ''.$jks_rangking.'');
$sheet->mergeCells('D'.$jmlbarisnya.':I'.$jmlbarisnya.'');
$sheet->getStyle('D'.$jmlbarisnya.':I'.$jmlbarisnya.'')->applyFromArray( $style_header );



















/////////////////////////////////////// SHEET KEDUA ////////////////////////////////////////////////////////////////////////
$objPHPExcel->createSheet();
$sheet = $objPHPExcel->setActiveSheetIndex(1)->setTitle('Deskripsi');

$sheet->getProtection()->setSheet(true);
$sheet->getProtection()->setPassword($x);



//atur lebar kolom
$sheet->getColumnDimension('A')->setWidth(4);
$sheet->getColumnDimension('B')->setWidth(17);
$sheet->getColumnDimension('E')->setWidth(15);


//atur lebar baris
$sheet->getRowDimension('1')->setRowHeight(20);
 
 
 
//header
$sheet->setCellValue('A1', 'DESKRIPSI/CATATAN HASIL BELAJAR');
$sheet->mergeCells('A1:J1');
$sheet->getStyle("A1:J1")->getFont()->setSize(16)->setBold(true)->setName('Arial Narrow');
$sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




$sheet->setCellValue('A2', 'Nama Sekolah');
$sheet->setCellValue('C2', ': '.$sek_nama.'');
$sheet->setCellValue('A3', 'Alamat');
$sheet->setCellValue('C3', ': '.$sek_alamat.'');
$sheet->setCellValue('A4', 'Nama');
$sheet->setCellValue('C4', ': '.$nama.'');
$sheet->setCellValue('A5', 'Nomor Induk NIS/NISN');
$sheet->setCellValue('C5', ': '.$nis.'');


$sheet->setCellValue('G2', 'Kelas');
$sheet->setCellValue('I2', ': '.$kelas.'');
$sheet->setCellValue('G3', 'Semester');
$sheet->setCellValue('I3', ': '.$smt.'');
$sheet->setCellValue('G4', 'Tahun Pelajaran');
$sheet->setCellValue('I4', ': '.$tapel.'');












//header raport
$sheet->setCellValue('A8', 'MATA PELAJARAN');
$sheet->mergeCells('A8:C8');
$sheet->getStyle('A8:C8')->applyFromArray( $style_header );
$sheet->setCellValue('D8', 'KOMPETENSI');
$sheet->mergeCells('D8:E8');
$sheet->getStyle('D8:E8')->applyFromArray( $style_header );
$sheet->setCellValue('F8', 'CATATAN');
$sheet->mergeCells('F8:J8');
$sheet->getStyle('F8:J8')->applyFromArray( $style_header );




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
$sheet->mergeCells('A'.$kkxx.':J'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->applyFromArray( $style_header );




//netralkan dahulu
$jk = 0;


do
	{
	$pelkd = nosql($rpel['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
//	$kkx2 = $jk + 9;
	$kkx2 = ($jk * 3) + 7;
	$kkx22 = ($jk * 3) + 9;

	$xyz = md5("$x$jk");

	
	
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



	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'.');
	$sheet->mergeCells('A'.$kkx2.':A'.$kkx22.'');
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->applyFromArray( $style_data );
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx22.'');
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->applyFromArray( $style_data );
	



	$jkk = $jk * 3;
	$kkxx2 = $jkk + 7;

	//baris kesatu
	$sheet->setCellValue('D'.$kkxx2.'', 'Pengetahuan');
	$sheet->mergeCells('D'.$kkxx2.':E'.$kkxx2.'');
	$sheet->getStyle('D'.$kkxx2.':E'.$kkxx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkxx2.':E'.$kkxx2.'')->applyFromArray( $style_data );
	
	$sheet->setCellValue('F'.$kkxx2.'', ''.$xpel_pengetahuan.'');
	$sheet->mergeCells('F'.$kkxx2.':J'.$kkxx2.'');
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->applyFromArray( $style_data );
	
	

	//baris kedua
	$kkx22 = $kkxx2 + 1;
	$sheet->setCellValue('D'.$kkx22.'', 'Keterampilan');
	$sheet->mergeCells('D'.$kkx22.':E'.$kkx22.'');
	$sheet->getStyle('D'.$kkx22.':E'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx22.':E'.$kkx22.'')->applyFromArray( $style_data );

	$sheet->setCellValue('F'.$kkx22.'', ''.$xpel_ketrampilan.'');
	$sheet->mergeCells('F'.$kkx22.':J'.$kkx22.'');
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->applyFromArray( $style_data );



	//baris ketiga
	$kkx23 = $kkxx2 + 2;
	$sheet->setCellValue('D'.$kkx23.'', 'Sikap Spiritual dan Sosial');
	$sheet->mergeCells('D'.$kkx23.':E'.$kkx23.'');
	$sheet->getStyle('D'.$kkxx23.':E'.$kkxx23.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx23.':E'.$kkx23.'')->applyFromArray( $style_data );
	
	$sheet->setCellValue('F'.$kkx23.'', ''.$xpel_sikap.'');
	$sheet->mergeCells('F'.$kkx23.':J'.$kkx23.'');
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->applyFromArray( $style_data );

	}
while ($rpel = mysql_fetch_assoc($qpel));















//datanya
//kelompok 2 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "2";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	



//baris ke
$kkx = 8 + (3 * $tpel) + 2;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':J'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->applyFromArray( $style_header );




$kkuux2 = $kkxx + 1;


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




do
	{
	$pelkd = nosql($rpel2['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = ($jk * 3) + $tpel + 2;
	$kkx22 = ($jk * 3) + $tpel + 4;

	$xyz = md5("$x$jk");

	
	
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



	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'.');
	$sheet->mergeCells('A'.$kkx2.':A'.$kkx22.'');
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->applyFromArray( $style_data );
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx22.'');
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->applyFromArray( $style_data );




	$jkk = $jk * 3;
	$kkxx2 = $jkk + $tpel + 2;

	//baris kesatu
	$sheet->setCellValue('D'.$kkxx2.'', 'Pengetahuan');
	$sheet->mergeCells('D'.$kkxx2.':E'.$kkxx2.'');
	$sheet->getStyle('D'.$kkxx2.':E'.$kkxx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkxx2.':E'.$kkxx2.'')->applyFromArray( $style_data );
	
	$sheet->setCellValue('F'.$kkxx2.'', ''.$xpel_pengetahuan.'');
	$sheet->mergeCells('F'.$kkxx2.':J'.$kkxx2.'');
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->applyFromArray( $style_data );
	
	

	//baris kedua
	$kkx22 = $kkxx2 + 1;
	$sheet->setCellValue('D'.$kkx22.'', 'Keterampilan');
	$sheet->mergeCells('D'.$kkx22.':E'.$kkx22.'');
	$sheet->getStyle('D'.$kkx22.':E'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx22.':E'.$kkx22.'')->applyFromArray( $style_data );

	$sheet->setCellValue('F'.$kkx22.'', ''.$xpel_ketrampilan.'');
	$sheet->mergeCells('F'.$kkx22.':J'.$kkx22.'');
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->applyFromArray( $style_data );



	//baris ketiga
	$kkx23 = $kkxx2 + 2;
	$sheet->setCellValue('D'.$kkx23.'', 'Sikap Spiritual dan Sosial');
	$sheet->mergeCells('D'.$kkx23.':E'.$kkx23.'');
	$sheet->getStyle('D'.$kkxx23.':E'.$kkxx23.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx23.':E'.$kkx23.'')->applyFromArray( $style_data );
	
	$sheet->setCellValue('F'.$kkx23.'', ''.$xpel_sikap.'');
	$sheet->mergeCells('F'.$kkx23.':J'.$kkx23.'');
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->applyFromArray( $style_data );

	}
while ($rpel2 = mysql_fetch_assoc($qpel2));














//datanya
//kelompok 3 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	



//baris ke
$kkx = 8 + (3 * ($tpel + $tpel2)) + 3;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':J'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->applyFromArray( $style_header );




$kkuux2 = $kkxx + 1;


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




do
	{
	$pelkd = nosql($rpel3['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = ($jk * 3) + $tpel + $tpel2;
	$kkx22 = ($jk * 3) + $tpel + $tpel2 + 2;

	$xyz = md5("$x$jk");

	
	
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



	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'.');
	$sheet->mergeCells('A'.$kkx2.':A'.$kkx22.'');
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->applyFromArray( $style_data );
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx22.'');
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->applyFromArray( $style_data );




	$jkk = $jk * 3;
	$kkxx2 = $jkk + $tpel + $tpel2;

	//baris kesatu
	$sheet->setCellValue('D'.$kkxx2.'', 'Pengetahuan');
	$sheet->mergeCells('D'.$kkxx2.':E'.$kkxx2.'');
	$sheet->getStyle('D'.$kkxx2.':E'.$kkxx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkxx2.':E'.$kkxx2.'')->applyFromArray( $style_data );
	
	$sheet->setCellValue('F'.$kkxx2.'', ''.$xpel_pengetahuan.'');
	$sheet->mergeCells('F'.$kkxx2.':J'.$kkxx2.'');
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->applyFromArray( $style_data );
	
	

	//baris kedua
	$kkx22 = $kkxx2 + 1;
	$sheet->setCellValue('D'.$kkx22.'', 'Keterampilan');
	$sheet->mergeCells('D'.$kkx22.':E'.$kkx22.'');
	$sheet->getStyle('D'.$kkx22.':E'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx22.':E'.$kkx22.'')->applyFromArray( $style_data );

	$sheet->setCellValue('F'.$kkx22.'', ''.$xpel_ketrampilan.'');
	$sheet->mergeCells('F'.$kkx22.':J'.$kkx22.'');
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->applyFromArray( $style_data );



	//baris ketiga
	$kkx23 = $kkxx2 + 2;
	$sheet->setCellValue('D'.$kkx23.'', 'Sikap Spiritual dan Sosial');
	$sheet->mergeCells('D'.$kkx23.':E'.$kkx23.'');
	$sheet->getStyle('D'.$kkxx23.':E'.$kkxx23.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx23.':E'.$kkx23.'')->applyFromArray( $style_data );
	
	$sheet->setCellValue('F'.$kkx23.'', ''.$xpel_sikap.'');
	$sheet->mergeCells('F'.$kkx23.':J'.$kkx23.'');
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->applyFromArray( $style_data );

	}
while ($rpel3 = mysql_fetch_assoc($qpel3));












//datanya
//kelompok 4 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "4";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	



//baris ke
$kkx = 8 + (3 * ($tpel + $tpel2 + $tpel3)) + 4;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':J'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->applyFromArray( $style_header );




$kkuux2 = $kkxx + 1;


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




do
	{
	$pelkd = nosql($rpel4['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = ($jk * 3) + ($tpel + $tpel2 + $tpel3) - 1;
	$kkx22 = ($jk * 3) + ($tpel + $tpel2 + $tpel3 + 2) - 1;

	$xyz = md5("$x$jk");

	
	
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



	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'.');
	$sheet->mergeCells('A'.$kkx2.':A'.$kkx22.'');
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->applyFromArray( $style_data );
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.':A'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx22.'');
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('B'.$kkx2.':C'.$kkx22.'')->applyFromArray( $style_data );




	$jkk = $jk * 3;
	$kkxx2 = ($jkk + $tpel + $tpel2 + $tpel3) - 1;

	//baris kesatu
	$sheet->setCellValue('D'.$kkxx2.'', 'Pengetahuan');
	$sheet->mergeCells('D'.$kkxx2.':E'.$kkxx2.'');
	$sheet->getStyle('D'.$kkxx2.':E'.$kkxx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkxx2.':E'.$kkxx2.'')->applyFromArray( $style_data );
	
	$sheet->setCellValue('F'.$kkxx2.'', ''.$xpel_pengetahuan.'');
	$sheet->mergeCells('F'.$kkxx2.':J'.$kkxx2.'');
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkxx2.':J'.$kkxx2.'')->applyFromArray( $style_data );
	
	

	//baris kedua
	$kkx22 = $kkxx2 + 1;
	$sheet->setCellValue('D'.$kkx22.'', 'Keterampilan');
	$sheet->mergeCells('D'.$kkx22.':E'.$kkx22.'');
	$sheet->getStyle('D'.$kkx22.':E'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx22.':E'.$kkx22.'')->applyFromArray( $style_data );

	$sheet->setCellValue('F'.$kkx22.'', ''.$xpel_ketrampilan.'');
	$sheet->mergeCells('F'.$kkx22.':J'.$kkx22.'');
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx22.':J'.$kkx22.'')->applyFromArray( $style_data );



	//baris ketiga
	$kkx23 = $kkxx2 + 2;
	$sheet->setCellValue('D'.$kkx23.'', 'Sikap Spiritual dan Sosial');
	$sheet->mergeCells('D'.$kkx23.':E'.$kkx23.'');
	$sheet->getStyle('D'.$kkxx23.':E'.$kkxx23.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('D'.$kkx23.':E'.$kkx23.'')->applyFromArray( $style_data );
	
	$sheet->setCellValue('F'.$kkx23.'', ''.$xpel_sikap.'');
	$sheet->mergeCells('F'.$kkx23.':J'.$kkx23.'');
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->getAlignment()->setWrapText(true);
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx23.':J'.$kkx23.'')->applyFromArray( $style_data );

	}
while ($rpel4 = mysql_fetch_assoc($qpel4));









//ekstra /////////////////////////////////////////////////////////////////////////////////////////////////////////
$posisi1 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + 20;
$sheet->setCellValue('A'.$posisi1.'', 'Pengembangan Diri');
$sheet->mergeCells('A'.$posisi1.':E'.$posisi1.'');
$sheet->getStyle('A'.$posisi1.':E'.$posisi1.'')->applyFromArray( $style_header );
$sheet->setCellValue('F'.$posisi1.'', 'Nilai');
$sheet->getStyle('F'.$posisi1.'')->applyFromArray( $style_header );
$sheet->setCellValue('G'.$posisi1.'', 'Keterangan');
$sheet->mergeCells('G'.$posisi1.':J'.$posisi1.'');
$sheet->getStyle('G'.$posisi1.':J'.$posisi1.'')->applyFromArray( $style_header );


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

	$posisi11 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + 20 + $nomx;
	$sheet->setCellValue('A'.$posisi11.'', ''.$nomx.'.');
	$sheet->getStyle('A'.$posisi11.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$posisi11.'')->applyFromArray( $style_data );
	$sheet->setCellValue('B'.$posisi11.'', ''.$kuti_ekstra.'');
	$sheet->mergeCells('B'.$posisi11.':E'.$posisi11.'');
	$sheet->getStyle('B'.$posisi11.':E'.$posisi11.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$posisi11.'', ''.$kuti_predikat.'');
	$sheet->getStyle('F'.$posisi11.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$posisi11.'', ''.$kuti_ket.'');
	$sheet->mergeCells('G'.$posisi11.':J'.$posisi11.'');
	$sheet->getStyle('G'.$posisi11.':J'.$posisi11.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));













//ketidakhadiran /////////////////////////////////////////////////////////////////////////////////////////////////////////
$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 23;
$sheet->setCellValue('A'.$posisi2.'', 'Ketidakhadiran');
$sheet->mergeCells('A'.$posisi2.':J'.$posisi2.'');
$sheet->getStyle('A'.$posisi2.':J'.$posisi2.'')->applyFromArray( $style_header );

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

	$posisi21 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 23 + $nomxz;
	$sheet->setCellValue('A'.$posisi21.'', ''.$nomxz.'');
	$sheet->getStyle('A'.$posisi21.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->setCellValue('B'.$posisi21.'', ''.$abs_absensi.'');
	$sheet->setCellValue('D'.$posisi21.'', ': '.$tbsix.'');
	}
while ($rabs = mysql_fetch_assoc($qabs));


//bikin kotak
$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 23 + 1;
$posisi22 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 23 + $tabs;
$sheet->getStyle('A'.$posisi2.':J'.$posisi22.'')->applyFromArray( $style_data );








//saran wali kelas /////////////////////////////////////////////////////////////////////////////////////////////////////////
$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 22 + $tabs + 3;
$sheet->setCellValue('A'.$posisi2.'', 'Saran Wali Kelas');
$sheet->mergeCells('A'.$posisi2.':J'.$posisi2.'');
$sheet->getStyle('A'.$posisi2.':J'.$posisi2.'')->applyFromArray( $style_header );


//bikin kotak
$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 22 + $tabs + 4;
$posisi22 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 22 + $tabs + 8;
$sheet->mergeCells('A'.$posisi2.':J'.$posisi22.'');
$sheet->getStyle('A'.$posisi2.':J'.$posisi22.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('A'.$posisi2.':J'.$posisi22.'')->applyFromArray( $style_data );











//naik ato lulus, ///////////////////////////////////////////////
//posisi
$posisi33 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs;


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
	$posisi33 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs;
	$sheet->setCellValue('H'.$posisi33.'', "$sek_kota, $tanggal $arrbln1[$bulan] $tahun");
	
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 1;
	$sheet->setCellValue('C'.$posisi34.'', 'Mengetahui');
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 2;
	$sheet->setCellValue('C'.$posisi34.'', 'Kepala Sekolah');
	
	//kepala sekolah
	$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
							"FROM admin_ks, m_pegawai ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rks = mysql_fetch_assoc($qks);
	$tks = mysql_num_rows($qks);
	$ks_nip = nosql($rks['nip']);
	$ks_nama = balikin($rks['nama']);
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 6;
	$sheet->setCellValue('C'.$posisi34.'', ''.$ks_nama.'');
	
	
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 2;
	$sheet->setCellValue('H'.$posisi34.'', 'Wali Kelas');
	
	
	
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel4)) + $tkuti + 32 + $tabs + 6;
	$sheet->setCellValue('H'.$posisi34.'', ''.$nwk.'');
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





 

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
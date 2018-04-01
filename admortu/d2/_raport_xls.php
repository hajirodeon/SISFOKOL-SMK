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
$nwk_nip = nosql($rwk['nip']);
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


$sheet->getProtection()->setPassword($x);
$sheet->getProtection()->setSheet(true);
$sheet->getProtection()->setSort(true);
$sheet->getProtection()->setInsertRows(true);
$sheet->getProtection()->setFormatCells(true);




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
$sheet->setCellValue('A8', 'NO');
$sheet->setCellValue('A9', '');
$sheet->setCellValue('A10', '');
$sheet->mergeCells('A8:A10');
$sheet->getStyle('A8:A10')->applyFromArray( $style_header );
$sheet->getStyle('A8:A10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet->setCellValue('B8', 'MATA PELAJARAN');
$sheet->setCellValue('C8', '');
$sheet->setCellValue('B9', '');
$sheet->setCellValue('C9', '');
$sheet->setCellValue('C10', '');
$sheet->mergeCells('B8:C10');
$sheet->getStyle('B8:C10')->applyFromArray( $style_header );
$sheet->getStyle('B8:C10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet->setCellValue('D8', 'Pengetahuan');
$sheet->setCellValue('E8', '');
$sheet->mergeCells('D8:E8');
$sheet->getStyle('D8:E8')->applyFromArray( $style_header );
$sheet->getStyle('D8:E10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('D9', 'Angka');
$sheet->getStyle('D9')->applyFromArray( $style_header );
$sheet->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('E9', 'Predikat');
$sheet->getStyle('D9')->applyFromArray( $style_header );
$sheet->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('D10', '1 - 4');
$sheet->getStyle('D10')->applyFromArray( $style_header );
$sheet->getStyle('D10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('E10', 'A - D');
$sheet->getStyle('E10')->applyFromArray( $style_header );
$sheet->getStyle('E10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('F8', 'Keterampilan');
$sheet->setCellValue('G8', '');
$sheet->mergeCells('F8:G8');
$sheet->getStyle('F8:G8')->applyFromArray( $style_header );
$sheet->getStyle('F8:G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('F9', 'Angka');
$sheet->getStyle('F9')->applyFromArray( $style_header );
$sheet->getStyle('F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('G9', 'Predikat');
$sheet->getStyle('G9')->applyFromArray( $style_header );
$sheet->getStyle('G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('F10', '1 - 4');
$sheet->getStyle('F10')->applyFromArray( $style_header );
$sheet->getStyle('F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('G10', 'A - D');
$sheet->getStyle('G10')->applyFromArray( $style_header );
$sheet->getStyle('G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('H8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('I8', '');
$sheet->mergeCells('H8:I8');
$sheet->getStyle('H8:I8')->applyFromArray( $style_header );
$sheet->getStyle('H8:I10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('H9', 'Dalam Mapel');
$sheet->getStyle('H9')->getAlignment()->setWrapText(true);
$sheet->getStyle('H9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('I9', 'Antar Mata Pelajaran');
$sheet->setCellValue('I10', '');
$sheet->mergeCells('I9:I10');
$sheet->getStyle('I9:I10')->applyFromArray( $style_header );
$sheet->getStyle('I9:I10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('I9:I10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('H10', 'SB/B/C/K');
$sheet->getStyle('H10')->applyFromArray( $style_header );
$sheet->getStyle('H10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


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
	


/*
//data mapel
$qpel = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".						
						"AND m_prog_pddkn_kelas.kd_kelas = '' ".
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);
*/


//data mapel
$qpel = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
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
	
	//nama guru
	$quru = mysql_query("SELECT m_pegawai.* ".
							"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru.kd_pegawai = m_pegawai.kd ".
							"AND m_guru.kd_tapel = '$tapelkd' ".
							"AND m_guru.kd_kelas = '$kelkd' ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd'");
	$ruru = mysql_fetch_assoc($quru);
	$uru_nip = nosql($ruru['nip']);
	$uru_nama = balikin($ruru['nama']);
	
		
	$pel2 = "$pel\nNama Guru : $uru_nama";
	

	$sheet->getStyle("$kkx2")->getFont()->setSize(10)->setName('Arial Narrow');
	
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($pel) <= 70)
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(50);
		}
	else if ((strlen($pel) > 70) AND (strlen($pel) <= 140))
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(70);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(90);
		}
	
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
//	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->setCellValue('B'.$kkx2.'', "$pel2");
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
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
$qpel2 = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
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


	
	//nama guru
	$quru = mysql_query("SELECT m_pegawai.* ".
							"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru.kd_pegawai = m_pegawai.kd ".
							"AND m_guru.kd_tapel = '$tapelkd' ".
							"AND m_guru.kd_kelas = '$kelkd' ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd'");
	$ruru = mysql_fetch_assoc($quru);
	$uru_nip = nosql($ruru['nip']);
	$uru_nama = balikin($ruru['nama']);
	
	
	$pel2 = "$pel\nNama Guru : $uru_nama";
	

	$sheet->getStyle("$kkx2")->getFont()->setSize(10)->setName('Arial Narrow');
	
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($pel) <= 70)
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(50);
		}
	else if ((strlen($pel) > 70) AND (strlen($pel) <= 140))
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(70);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(90);
		}
		
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
//	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->setCellValue('B'.$kkx2.'', "$pel2");
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
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
	

$tpel3 = 1;


//baris ke
$kkx = 13 + $tpel + $tpel2;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':H'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':H'.$kkxx.'')->applyFromArray( $style_data );








//kelompok 3 - c1 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$ku_nomer2 = "C1";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer' ".
						"AND no_sub = '$ku_nomer2'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel31 = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
$rpel31 = mysql_fetch_assoc($qpel31);
$tpel31 = mysql_num_rows($qpel31);


if (empty($tpel31))
	{
	$tpel31 = 1;
	}




//baris ke
$kkx = 13 + $tpel + $tpel2 + $tpel3;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_nomer2.'');
$sheet->getStyle('A'.$kkxx.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

$sheet->setCellValue('B'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('B'.$kkxx.':H'.$kkxx.'');
$sheet->getStyle('B'.$kkxx.':H'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('B'.$kkxx.':H'.$kkxx.'')->applyFromArray( $style_data );


do
	{
	$pelkd = nosql($rpel31['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = $jk + 14;
//	$kkx2 = $jk + $kkxx + 1;


	//nama guru
	$quru = mysql_query("SELECT m_pegawai.* ".
							"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru.kd_pegawai = m_pegawai.kd ".
							"AND m_guru.kd_tapel = '$tapelkd' ".
							"AND m_guru.kd_kelas = '$kelkd' ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd'");
	$ruru = mysql_fetch_assoc($quru);
	$uru_nip = nosql($ruru['nip']);
	$uru_nama = balikin($ruru['nama']);
	
	
	$pel2 = "$pel\nNama Guru : $uru_nama";
	

	$sheet->getStyle("$kkx2")->getFont()->setSize(10)->setName('Arial Narrow');
	
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($pel) <= 70)
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(50);
		}
	else if ((strlen($pel) > 70) AND (strlen($pel) <= 140))
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(70);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(90);
		}
		
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', "$pel2");	
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
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );

	}
while ($rpel31 = mysql_fetch_assoc($qpel31));





//kelompok 3 - c2 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$ku_nomer2 = "C2";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer' ".
						"AND no_sub = '$ku_nomer2'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel32 = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
$rpel32 = mysql_fetch_assoc($qpel32);
$tpel32 = mysql_num_rows($qpel32);


if (empty($tpel32))
	{
	$tpel32 = 1;
	}


//baris ke
$kkx = 14 + $tpel + $tpel2 + $tpel3 + $tpel31;
//$kkx = 14 + $tpel + $tpel2 + $tpel3 + $tpel31 + 1;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_nomer2.'');
$sheet->getStyle('A'.$kkxx.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

$sheet->setCellValue('B'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('B'.$kkxx.':H'.$kkxx.'');
$sheet->getStyle('B'.$kkxx.':H'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('B'.$kkxx.':H'.$kkxx.'')->applyFromArray( $style_data );


do
	{
	$pelkd = nosql($rpel32['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = $jk + 15;

//	$kkx2 = $jk + $kkxx;



	//nama guru
	$quru = mysql_query("SELECT m_pegawai.* ".
							"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru.kd_pegawai = m_pegawai.kd ".
							"AND m_guru.kd_tapel = '$tapelkd' ".
							"AND m_guru.kd_kelas = '$kelkd' ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd'");
	$ruru = mysql_fetch_assoc($quru);
	$uru_nip = nosql($ruru['nip']);
	$uru_nama = balikin($ruru['nama']);
	
	
	$pel2 = "$pel\nNama Guru : $uru_nama";
	

	$sheet->getStyle("$kkx2")->getFont()->setSize(10)->setName('Arial Narrow');
	
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($pel) <= 70)
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(50);
		}
	else if ((strlen($pel) > 70) AND (strlen($pel) <= 140))
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(70);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(90);
		}
		
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', "$pel2");	
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
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );

	}
while ($rpel32 = mysql_fetch_assoc($qpel32));







//kelompok 3 - c3 /////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$ku_nomer2 = "C3";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer' ".
						"AND no_sub = '$ku_nomer2'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	


//data mapel
$qpel33 = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
$rpel33 = mysql_fetch_assoc($qpel33);
$tpel33 = mysql_num_rows($qpel33);


if (empty($tpel33))
	{
	$tpel33 = 1;
	}


//baris ke
$kkx = 15 + $tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_nomer2.'');
$sheet->getStyle('A'.$kkxx.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

$sheet->setCellValue('B'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('B'.$kkxx.':H'.$kkxx.'');
$sheet->getStyle('B'.$kkxx.':H'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('B'.$kkxx.':H'.$kkxx.'')->applyFromArray( $style_data );


do
	{
	$pelkd = nosql($rpel33['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
	$kkx2 = $jk + 16;



	//nama guru
	$quru = mysql_query("SELECT m_pegawai.* ".
							"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru.kd_pegawai = m_pegawai.kd ".
							"AND m_guru.kd_tapel = '$tapelkd' ".
							"AND m_guru.kd_kelas = '$kelkd' ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd'");
	$ruru = mysql_fetch_assoc($quru);
	$uru_nip = nosql($ruru['nip']);
	$uru_nama = balikin($ruru['nama']);
	
	
	$pel2 = "$pel\nNama Guru : $uru_nama";
	

	$sheet->getStyle("$kkx2")->getFont()->setSize(10)->setName('Arial Narrow');
	
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($pel) <= 70)
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(50);
		}
	else if ((strlen($pel) > 70) AND (strlen($pel) <= 140))
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(70);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx2.'')->setRowHeight(90);
		}
		
	
	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->getStyle('A'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->setCellValue('B'.$kkx2.'', "$pel2");	
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
	$sheet->getStyle('D'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('E'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('F'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('G'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$sheet->getStyle('H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );

	}
while ($rpel33 = mysql_fetch_assoc($qpel33));












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
//$jmlbarisnya = $tpel44 + 4 + 6;
$jmlbarisnya = $tpel44 + 4 + 12;


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








//ekstra /////////////////////////////////////////////////////////////////////////////////////////////////////////
//$posisi1 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 5;
//$posisi1 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33)) + 10;

$posisi1 = $jmlbarisnya + 3;
$sheet->setCellValue('A'.$posisi1.'', 'NO');
$sheet->getStyle('A'.$posisi1.'')->applyFromArray( $style_header );
$sheet->setCellValue('B'.$posisi1.'', 'Kegiatan Ekstra Kurikuler');
$sheet->mergeCells('B'.$posisi1.':C'.$posisi1.'');
$sheet->getStyle('B'.$posisi1.'')->applyFromArray( $style_header );
$sheet->setCellValue('D'.$posisi1.'', 'Deskripsi');
$sheet->mergeCells('D'.$posisi1.':I'.$posisi1.'');
$sheet->getStyle('D'.$posisi1.':I'.$posisi1.'')->applyFromArray( $style_header );



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

//	$posisi11 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 0 + $nomx;
	$posisi11 = $posisi1 + $nomx;
	
	$sheet->setCellValue('A'.$posisi11.'', ''.$nomx.'.');
	$sheet->getStyle('A'.$posisi11.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$posisi11.'')->applyFromArray( $style_data );
	$sheet->setCellValue('B'.$posisi11.'', ''.$kuti_ekstra.'');
	$sheet->mergeCells('B'.$posisi11.':C'.$posisi11.'');
	$sheet->getStyle('B'.$posisi11.'')->applyFromArray( $style_data );
	$sheet->setCellValue('D'.$posisi11.'', ''.$kuti_ket.'');
	$sheet->mergeCells('D'.$posisi11.':I'.$posisi11.'');
	$sheet->getStyle('D'.$posisi11.':I'.$posisi11.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));





//ketidakhadiran /////////////////////////////////////////////////////////////////////////////////////////////////////////
//$posisi2 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3;

$posisi2 = $posisi11 + $tkuti + 3;
$sheet->setCellValue('A'.$posisi2.'', 'No');
$sheet->getStyle('A'.$posisi2.'')->applyFromArray( $style_header );
$sheet->setCellValue('B'.$posisi2.'', 'Ketidakhadiran');
$sheet->mergeCells('B'.$posisi2.':I'.$posisi2.'');
$sheet->getStyle('B'.$posisi2.':I'.$posisi2.'')->applyFromArray( $style_header );

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

//	$posisi21 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $nomxz;
	$posisi21 = $posisi2 + $nomxz;
	
	$sheet->setCellValue('A'.$posisi21.'', ''.$nomxz.'');
	$sheet->getStyle('A'.$posisi21.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$posisi21.'')->applyFromArray( $style_data );
	$sheet->setCellValue('B'.$posisi21.'', ''.$abs_absensi.'');
	$sheet->getStyle('B'.$posisi21.':C'.$posisi21.'')->applyFromArray( $style_data );
	$sheet->setCellValue('D'.$posisi21.'', ': '.$tbsix.' ');
	$sheet->getStyle('D'.$posisi21.':I'.$posisi21.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));



//jumlah tidak masuk
$qbsi2 = mysql_query("SELECT * FROM siswa_absensi ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_absensi <> ''");
$rbsi2 = mysql_fetch_assoc($qbsi2);
$tbsi2 = mysql_num_rows($qbsi2);


//$posisi2 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $tabs;

$posisi22 = $posisi2 + $tabs + 1;
$sheet->setCellValue('A'.$posisi22.'', 'JUMLAH TANPA KETERANGAN');
$sheet->mergeCells('A'.$posisi22.':C'.$posisi22.'');
$sheet->getStyle('A'.$posisi22.':C'.$posisi22.'')->applyFromArray( $style_header );
$sheet->setCellValue('D'.$posisi22.'', ''.$tbsi2.' Hari');
$sheet->mergeCells('D'.$posisi22.':I'.$posisi22.'');
$sheet->getStyle('D'.$posisi22.':I'.$posisi22.'')->applyFromArray( $style_header );





//jumlah hadir
$qbsi21 = mysql_query("SELECT * FROM siswa_absensi ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_absensi = ''");
$rbsi21 = mysql_fetch_assoc($qbsi21);
$tbsi21 = mysql_num_rows($qbsi21);


//persen
$hadirnya_jml = $tbsi21 + $tbsi2;

$hadirnya_persen = round(($tbsi21 / $hadirnya_jml) * 100,2);


//$posisi2 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $tabs + 1;
$posisi2 = $posisi22 + 1;
$sheet->setCellValue('A'.$posisi2.'', 'PROSENTASE KEHADIRAN');
$sheet->mergeCells('A'.$posisi2.':C'.$posisi2.'');
$sheet->getStyle('A'.$posisi2.':C'.$posisi2.'')->applyFromArray( $style_header );
$sheet->setCellValue('D'.$posisi2.'', ''.$hadirnya_persen.' %');
$sheet->mergeCells('D'.$posisi2.':I'.$posisi2.'');
$sheet->getStyle('D'.$posisi2.':I'.$posisi2.'')->applyFromArray( $style_header );





//Tanda tangan dan tgl ////////////////////////////////////////
//$posisi33 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $tabs + 3;
$posisi33 = $posisi2 + 3;
$sheet->setCellValue('H'.$posisi33.'', "$sek_kota, $tanggal $arrbln1[$bulan] $tahun");
$sheet->mergeCells('H'.$posisi33.':I'.$posisi33.'');



$posisi33 = $posisi2 + 3;
//$posisi33 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $tabs + 3;
$sheet->setCellValue('B'.$posisi33.'', 'Mengetahui');

$posisi33 = $posisi2 + 3;
//$posisi33 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $tabs + 3 + 1;
$sheet->setCellValue('B'.$posisi33.'', 'Orang Tua / Wali');

$posisi33 = $posisi2 + 6;
//$posisi33 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $tabs + 3 + 5;
$sheet->setCellValue('B'.$posisi33.'', '.................................');


$posisi33 = $posisi2 + 3;
//$posisi33 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $tabs + 3 + 1;
$sheet->setCellValue('H'.$posisi33.'', 'Wali Kelas');
$sheet->mergeCells('H'.$posisi33.':I'.$posisi33.'');


$posisi33 = $posisi2 + 6;
//$posisi33 = (2 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 3 + $tabs + 3 + 5;
$sheet->setCellValue('H'.$posisi33.'', ''.$nwk.'');
$sheet->mergeCells('H'.$posisi33.':I'.$posisi33.'');




/////////////////////////////////////// SHEET KEDUA ////////////////////////////////////////////////////////////////////////
$objPHPExcel->createSheet();
$sheet = $objPHPExcel->setActiveSheetIndex(1)->setTitle('Deskripsi');




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
$qpel = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
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


	
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_pengetahuan) <= 50)
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_pengetahuan) > 50) AND (strlen($xpel_pengetahuan) <= 100))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_pengetahuan) > 100) AND (strlen($xpel_pengetahuan) <= 200))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(90);
		}
		

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
	

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_ketrampilan) <= 50)
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_ketrampilan) > 50) AND (strlen($xpel_ketrampilan) <= 100))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_ketrampilan) > 100) AND (strlen($xpel_ketrampilan) <= 200))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(90);
		}
		
	
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
	


	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_sikap) <= 50)
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_sikap) > 50) AND (strlen($xpel_sikap) <= 100))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_sikap) > 100) AND (strlen($xpel_sikap) <= 200))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(90);
		}
		
	
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
$qpel2 = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
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
//	$kkx2 = ($jk * 3) + $tpel + 2;
	$kkx2 = ($jk * 3) + $tpel + 3;
	$kkx22 = ($jk * 3) + $tpel + 5;

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
//	$kkxx2 = $jkk + $tpel + 2;
	$kkxx2 = $jkk + $tpel + 3;

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_pengetahuan) <= 50)
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_pengetahuan) > 50) AND (strlen($xpel_pengetahuan) <= 100))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_pengetahuan) > 100) AND (strlen($xpel_pengetahuan) <= 200))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(90);
		}

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
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_ketrampilan) <= 50)
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_ketrampilan) > 50) AND (strlen($xpel_ketrampilan) <= 100))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_ketrampilan) > 100) AND (strlen($xpel_ketrampilan) <= 200))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(90);
		}
	
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
	

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_sikap) <= 50)
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_sikap) > 50) AND (strlen($xpel_sikap) <= 100))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_sikap) > 100) AND (strlen($xpel_sikap) <= 200))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(90);
		}
	
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
	

$tpel3 = 1;

//baris ke
$kkx = 8 + (3 * ($tpel + $tpel2)) + 3;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':J'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->applyFromArray( $style_header );










//datanya
//kelompok 3 - c1/////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$ku_nomer2 = "C1";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer' ".
						"AND no_sub = '$ku_nomer2'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	



//baris ke
//$kkx = 8 + (3 * ($tpel + $tpel2 + $tpel3)) + 3;
$kkx = 8 + (3 * ($tpel + $tpel2 + $tpel3)) + 1;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':J'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->applyFromArray( $style_header );



$kkuux2 = $kkxx + 1;


//data mapel
$qpel31 = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
$rpel31 = mysql_fetch_assoc($qpel31);
$tpel31 = mysql_num_rows($qpel31);


if (empty($tpel31))
	{
	$tpel31 = 1;
	}


do
	{
	$pelkd = nosql($rpel31['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
//	$kkx2 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 1;
//	$kkx2 = (($jk * 3) + $tpel + $tpel2 + $tpel3) - 1;
	$kkx2 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 2;

//	$kkx22 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 2 + 1;
//	$kkx22 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 1;

	$kkx22 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 4;

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
//	$kkxx2 = $jkk + $tpel + $tpel2 + $tpel3;
//	$kkxx2 = ($jkk + $tpel + $tpel2 + $tpel3) - 1;
//	$kkxx2 = $jkk + $tpel + 3;
//	$kkxx2 = $jkk + 1;
	$kkxx2 = ($jkk + $tpel + $tpel2 + $tpel3 + $tpel31);

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_pengetahuan) <= 50)
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_pengetahuan) > 50) AND (strlen($xpel_pengetahuan) <= 100))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_pengetahuan) > 100) AND (strlen($xpel_pengetahuan) <= 200))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(90);
		}

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
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_ketrampilan) <= 50)
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_ketrampilan) > 50) AND (strlen($xpel_ketrampilan) <= 100))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_ketrampilan) > 100) AND (strlen($xpel_ketrampilan) <= 200))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(90);
		}
	
	
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
	

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_sikap) <= 50)
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_sikap) > 50) AND (strlen($xpel_sikap) <= 100))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_sikap) > 100) AND (strlen($xpel_sikap) <= 200))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(90);
		}
		
	
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
while ($rpel31 = mysql_fetch_assoc($qpel31));







//datanya
//kelompok 3 - c2/////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$ku_nomer2 = "C2";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer' ".
						"AND no_sub = '$ku_nomer2'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	



//baris ke
//$kkx = 8 + (3 * ($tpel + $tpel2 + $tpel3 + $tpel31)) + 2;
$kkx = 8 + (3 * ($tpel + $tpel2 + $tpel3 + $tpel31)) + 2;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':J'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->applyFromArray( $style_header );



$kkuux2 = $kkxx + 1;



//data mapel
$qpel32 = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
$rpel32 = mysql_fetch_assoc($qpel32);
$tpel32 = mysql_num_rows($qpel32);



if (empty($tpel32))
	{
	$tpel32 = 1;
	}


do
	{
	$pelkd = nosql($rpel32['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
//	$kkx2 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 1;
//	$kkx2 = (($jk * 3) + $tpel + $tpel2 + $tpel3 + $tpel31);

	$kkx2 = (($jk * 3) + $tpel + $tpel2 + $tpel3 + $tpel31 + 1);
	
//	$kkx22 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 2 + 1;
//	$kkx22 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + $tpel31 + 2;
	$kkx22 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + $tpel31 + 3;

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
//	$kkxx2 = $jkk + $tpel + $tpel2 + $tpel3;
	$kkxx2 = ($jkk + $tpel + $tpel2 + $tpel3 + $tpel31) + 1;
//	$kkxx2 = $kkuux2 + $jkk + 2;




	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_pengetahuan) <= 50)
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_pengetahuan) > 50) AND (strlen($xpel_pengetahuan) <= 100))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_pengetahuan) > 100) AND (strlen($xpel_pengetahuan) <= 200))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(90);
		}

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
	
	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_ketrampilan) <= 50)
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_ketrampilan) > 50) AND (strlen($xpel_ketrampilan) <= 100))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_ketrampilan) > 100) AND (strlen($xpel_ketrampilan) <= 200))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(90);
		}

	
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
	

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_sikap) <= 50)
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_sikap) > 50) AND (strlen($xpel_sikap) <= 100))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_sikap) > 100) AND (strlen($xpel_sikap) <= 200))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(90);
		}
		
	
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
while ($rpel32 = mysql_fetch_assoc($qpel32));




//datanya
//kelompok 3 - c3/////////////////////////////////////////////////////////////////////////////////////////////////
$ku_nomer = "3";
$ku_nomer2 = "C3";
$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE no = '$ku_nomer' ".
						"AND no_sub = '$ku_nomer2'");
$rku = mysql_fetch_assoc($qku);
$tku = mysql_num_rows($qku);
$ku_kd = nosql($rku['kd']);
$ku_no = nosql($rku['no']);
$ku_jenis = balikin($rku['jenis']);
	



//baris ke
$kkx = 8 + (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32)) + 3;
//$kkx = 8 + (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32)) + 1;
$kkxx = $kkx;


$sheet->setCellValue('A'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('A'.$kkxx.':J'.$kkxx.'');
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('A'.$kkxx.':J'.$kkxx.'')->applyFromArray( $style_header );





$kkuux2 = $kkxx + 1;


//data mapel
$qpel33 = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS pelkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn, m_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = m_kelas.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$ku_kd' ".
							"AND m_kelas.kd = '$kelkd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
$rpel33 = mysql_fetch_assoc($qpel33);
$tpel33 = mysql_num_rows($qpel33);


if (empty($tpel33))
	{
	$tpel33 = 1;
	}


do
	{
	$pelkd = nosql($rpel33['pelkd']);
			
	//detail e
	$qkuu = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$pelkd'");
	$rkuu = mysql_fetch_assoc($qkuu);
	$pel = balikin2($rkuu['prog_pddkn']);
	$jk = $jk + 1;
//	$kkx2 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 1;
	$kkx2 = (($jk * 3) + $tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32);
//	$kkx22 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + 2 + 1;
	$kkx22 = ($jk * 3) + $tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + 2;

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
//	$kkxx2 = $jkk + $tpel + $tpel2 + $tpel3;
	$kkxx2 = ($jkk + $tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32);

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_pengetahuan) <= 50)
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_pengetahuan) > 50) AND (strlen($xpel_pengetahuan) <= 100))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_pengetahuan) > 100) AND (strlen($xpel_pengetahuan) <= 200))
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkxx2.'')->setRowHeight(90);
		}

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
	

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_ketrampilan) <= 50)
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_ketrampilan) > 50) AND (strlen($xpel_ketrampilan) <= 100))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_ketrampilan) > 100) AND (strlen($xpel_ketrampilan) <= 200))
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx22.'')->setRowHeight(90);
		}
	
	
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
	

	//atur lebar baris
	//jika kurang dari
	if (strlen($xpel_sikap) <= 50)
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(50);
		}
	else if ((strlen($xpel_sikap) > 50) AND (strlen($xpel_sikap) <= 100))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(70);
		}
	else if ((strlen($xpel_sikap) > 100) AND (strlen($xpel_sikap) <= 200))
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(100);
		}
	else
		{
		$sheet->getRowDimension(''.$kkx23.'')->setRowHeight(90);
		}
		
	
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
while ($rpel33 = mysql_fetch_assoc($qpel33));





/*

//saran wali kelas /////////////////////////////////////////////////////////////////////////////////////////////////////////
$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 22 + $tabs + 3;
$sheet->setCellValue('A'.$posisi2.'', 'Saran Wali Kelas');
$sheet->mergeCells('A'.$posisi2.':J'.$posisi2.'');
$sheet->getStyle('A'.$posisi2.':J'.$posisi2.'')->applyFromArray( $style_header );


//bikin kotak
$posisi2 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 22 + $tabs + 4;
$posisi22 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 22 + $tabs + 8;
$sheet->mergeCells('A'.$posisi2.':J'.$posisi22.'');
$sheet->getStyle('A'.$posisi2.':J'.$posisi22.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('A'.$posisi2.':J'.$posisi22.'')->applyFromArray( $style_data );

*/








//naik ato lulus, ///////////////////////////////////////////////
//posisi
//$posisi33 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + $tkuti + 5 + $tabs;
$posisi33 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 16;


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
	$sheet->setCellValue('C'.$posisi331.'', 'Orang Tua/Wali');

	$posisi331 = $posisi33 + 6;
	$sheet->setCellValue('C'.$posisi331.'', '..........................');

	$posisi331 = $posisi33 + 9;
	$sheet->setCellValue('C'.$posisi331.'', 'Wali Kelas');
	
	$posisi331 = $posisi33 + 13;
	$sheet->setCellValue('C'.$posisi331.'', ''.$nwk.'');
	
	$posisi331 = $posisi33 + 14;
	$sheet->setCellValue('C'.$posisi331.'', ''.$nwk_nip.'');

		

	
	//posisi
	$posisi331 = $posisi33 + 1;
	$posawal331 = $posisi331;
	$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
	$sheet->setCellValue('F'.$posawal331.'', ''.$nil_tgl.'');
	
	$posawal331 = $posisi331 + 1;
	$sheet->setCellValue('F'.$posawal331.'', 'Keputusan');
	$posisi331 = $posawal331 + 2;
	$sheet->setCellValue('F'.$posisi331.'', 'Berdasarkan hasil yang dicapai pada');
	$posisi331 = $posawal331 + 3;
	$sheet->setCellValue('F'.$posisi331.'', 'Semester 1 dan 2, peserta didik ditetapkan');
	$posisi331 = $posawal331 + 5;
	$sheet->setCellValue('F'.$posisi331.'', ''.$ket_naik.'');

/*
	$posisi331 = $posisi33 + 8;
	$nil_tgl = "$sek_kota, $tanggal $arrbln1[$bulan] $tahun";
	$sheet->setCellValue('F'.$posisi331.'', ''.$nil_tgl.'');
	*/


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
	$posisi332 = $posisi33 + 14;
	$sheet->setCellValue('F'.$posisi331.'', ''.$ks_nama.'');
	$sheet->setCellValue('F'.$posisi332.'', ''.$ks_nip.'');
	
	
	$sheet->getStyle('F'.$posisi33.':J'.$posisi332.'')->applyFromArray( $style_data );
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
	$posisi33 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 10 + 5;
	$sheet->setCellValue('H'.$posisi33.'', "$sek_kota, $tanggal $arrbln1[$bulan] $tahun");
	
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 10 + 6;
	$sheet->setCellValue('C'.$posisi34.'', 'Mengetahui');
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 10 + 7;
	$sheet->setCellValue('C'.$posisi34.'', 'Kepala Sekolah');
	
	//kepala sekolah
	$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
							"FROM admin_ks, m_pegawai ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rks = mysql_fetch_assoc($qks);
	$tks = mysql_num_rows($qks);
	$ks_nip = nosql($rks['nip']);
	$ks_nama = balikin($rks['nama']);
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 10 + 12;
	$sheet->setCellValue('C'.$posisi34.'', ''.$ks_nama.'');
	
	
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 10 + 7;
	$sheet->setCellValue('H'.$posisi34.'', 'Wali Kelas');
	
	
	
	
	$posisi34 = (3 * ($tpel + $tpel2 + $tpel3 + $tpel31 + $tpel32 + $tpel33 + $tpel4)) + 10 + 12;
	$sheet->setCellValue('H'.$posisi34.'', ''.$nwk.'');
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





$sheet = $objPHPExcel->setActiveSheetIndex(0);



 

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
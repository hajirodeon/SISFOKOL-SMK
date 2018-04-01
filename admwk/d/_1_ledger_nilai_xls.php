<?php
//session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/PHPExcel.php");




nocache;

//nilai
$filenya = "legger_nilai_xls.php";
$judul = "Legger Nilai";
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&smtkd=$smtkd";




//kelas
$qk = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd = '$kelkd'");
$rk = mysql_fetch_assoc($qk);
$rkel = nosql($rk['kelas']);
$kelas = $rkel;




//tapel
$qtp = mysql_query("SELECT * FROM m_tapel ".
					"WHERE kd = '$tapelkd'");
$rtp = mysql_fetch_assoc($qtp);
$thn1 = nosql($rtp['tahun1']);
$thn2 = nosql($rtp['tahun2']);
$tapel = "$thn1/$thn2";


//smt
$qsmt = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rsmt = mysql_fetch_assoc($qsmt);
$smt_no = nosql($rsmt['no']); 
$smt_smt = nosql($rsmt['smt']);

	
	


//nama file
$f_kelas = strip($kelas);
$f_tapel = strip($tapel);
$i_filename = "ledger_nilai_$f_kelas-$f_tapel-$smt_smt.xls";




//kasi rangking dahulu semuanya..
//query data siswa
$qdata = mysql_query("SELECT siswa_kelas.kd AS skkd, ".
						"AVG(siswa_nilai_raport.nil_raport_pengetahuan_a) AS total1 ".
						"FROM siswa_kelas, siswa_nilai_raport ".
						"WHERE siswa_nilai_raport.kd_siswa_kelas = siswa_kelas.kd ".
						"AND siswa_nilai_raport.kd_smt = '$smtkd' ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"ORDER BY round(siswa_nilai_raport.nil_raport_pengetahuan_a) DESC");
$rdata = mysql_fetch_assoc($qdata);


do
	{
	//nilai
	$y_nomerr = $y_nomerr + 1;
	$xyz = md5("$x$y_nomerr");
	$y_skkd = nosql($rdata['skkd']);
	$y_total1 = nosql($rdata['total1']);

	

	//totalnya
	$y_totalnya = round($y_total1);
	


	
	//cek 
	$qcc = mysql_query("SELECT * FROM siswa_rangking ".
							"WHERE kd_siswa_kelas = '$y_skkd' ".
							"AND kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_smt = '$smtkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);
	$nilx_rangking = nosql($rcc['rangking']);
	
	//jika null
	if (!empty($tcc))
		{
		//update
		mysql_query("UPDATE siswa_rangking SET rata_kognitif = '$y_total1', ".
						"rata_psikomotorik = '$y_total2', ".
						"total = '$y_totalnya', ".
						"rangking = '$y_nomerr' ".
						"WHERE kd_siswa_kelas = '$y_skkd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_smt = '$smtkd'");
		}
	else
		{
		//insert
		mysql_query("INSERT INTO siswa_rangking(kd, kd_siswa_kelas, kd_tapel, ".
						"kd_kelas, kd_smt, ".
						"rata_kognitif, rata_psikomotorik, total, rangking) VALUES ".
						"('$xyz', '$y_skkd', '$tapelkd', ".
						"'$kelkd', '$smtkd', ".
						"'$y_total1', '$y_total2', '$y_totalnya', '$y_nomerr')");

		}
	}
while ($rdata = mysql_fetch_assoc($qdata));












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


$sheet = $objPHPExcel->setActiveSheetIndex(0)->setTitle('LedgerNilai');




$sheet->setCellValue('A1', 'LEDGER NILAI');
$sheet->setCellValue('A2', 'KELAS : '.$kelas.'. Tahun Pelajaran : '.$tapel.'. Semester : '.$smt_smt.'');




$sheet->setCellValue('A6', 'NO');
$sheet->setCellValue('B6', 'NIS');
$sheet->setCellValue('C6', 'NAMA');



















//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sheet->getRowDimension('5')->setRowHeight(50);




//query
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"ORDER BY round(no) ASC");
$rjnsp = mysql_fetch_assoc($qjnsp);
$tjnsp = mysql_num_rows($qjnsp);

do
	{
	$i_nomer = $i_nomer + 1;
	$jnsp_kd = nosql($rjnsp['kd']);
	$jnsp_no = nosql($rjnsp['no']);
	$jnsp_jenis = strtoupper(balikin($rjnsp['jenis']));
	


	//query
	$qpell = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
							"AND m_prog_pddkn.kd_jenis = '$jnsp_kd'");
	$rpell = mysql_fetch_assoc($qpell);
	$tpell = mysql_num_rows($qpell);


	//jika null
	if (empty($tpell))
		{
		$tpell = 1;
		}


	
	$i_nomere2 = $i_nomere2 + ($tpell * 1);
	

	//jika tpel null
	if (empty($tpell))
		{
		$kolnome = 3 + $i_nomere2 - 1;
		$kolnome2 = $kolnome + 1;

		}
	else 
		{
		$kolnome = 3 + $i_nomere2 - $tpell + 1;
		$kolnome2 = $kolnome + $tpell;
		}


	$kolnomx = $arrrkolom[$kolnome];
	$kolnomx2 = $arrrkolom[$kolnome2];
	
	$sheet->setCellValue(''.$kolnomx.'4', ''.$jnsp_jenis.'');
//	$sheet->mergeCells(''.$kolnomx.'4:'.$kolnomx2.'4');
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));




	
	
	
//query
$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
						"ORDER BY round(m_prog_pddkn_jns.no) ASC, ".
						"round(m_prog_pddkn.no) ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);



//jika ada 
if (!empty($tpel))
	{
	do
		{
		//nilai
		$pelkd = nosql($rpel['pelkd']);
		$pel = substr(balikin2($rpel['xpel']),0,35);
		$pel_kkm = nosql($rpel['kkm']);

		$i_nomer2 = $i_nomer2 + 1;
		

		$kolnom = $i_nomer2 + 3;
		$kolnom2 = $kolnom + 8;
		$kolnomx = $arrrkolom[$kolnom];
		
		$sheet->getColumnDimension(''.$kolnomx.'')->setWidth(3);

		$sheet->setCellValue(''.$kolnomx.'5', ''.$pel.'');
		$sheet->getStyle(''.$kolnomx.'5')->getAlignment()->setTextRotation(90);
		
		$sheet->setCellValue(''.$kolnomx.'6', ''.$pel_kkm.'');
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}








//jumlah nilai
//query
$qpell2 = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd");
$rpell2 = mysql_fetch_assoc($qpell2);
$tpell2 = mysql_num_rows($qpell2);

//kolom ke
$kolomke = 3 + $tjnsp + $tpel;
$kolnomx = $arrrkolom[$kolomke];
$sheet->mergeCells(''.$kolnomx.'5:'.$kolnomx.'6');
$sheet->setCellValue(''.$kolnomx.'5', 'JUMLAH');





$kolnomx2 = $kolomke + 1;
$kolnomx = $arrrkolom[$kolnomx2];

$sheet->setCellValue(''.$kolnomx.'4', 'KEPRIBADIAN');




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







 

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
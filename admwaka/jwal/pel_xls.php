<?php
//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/PHPExcel.php");


nocache;





//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$smtkd = nosql($_REQUEST['smtkd']);



//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);
$tapelnya = "$tpx_thn1/$tpx_thn2";


//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = balikin($rowbtx['kelas']);
$btxruang = balikin($rowbtx['ruang']);
$kelasnya = "$btxkelas-$btxruang";




//terpilih
$qbtx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxsmt = balikin($rowbtx['smt']);
$smtnya = $btxsmt;





//nama file
$i_filename = "guru_mapel_kelas-$tapelnya-$kelasnya-$smtnya.xls";





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


$sheet = $objPHPExcel->setActiveSheetIndex(0)->setTitle('JADWAL');



///////////////////////////////////////////////////////// HALAMAN I //////////////////////////////////////////////////////////////////////
//atur lebar kolom
$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(13);
$sheet->getColumnDimension('C')->setWidth(13);
$sheet->getColumnDimension('D')->setWidth(13);
$sheet->getColumnDimension('E')->setWidth(13);
$sheet->getColumnDimension('F')->setWidth(13);
$sheet->getColumnDimension('G')->setWidth(13);

 
 //atur lebar baris
$sheet->getRowDimension('1')->setRowHeight(20);
$sheet->getRowDimension('2')->setRowHeight(20);

$sheet->getRowDimension('5')->setRowHeight(40);
$sheet->getRowDimension('6')->setRowHeight(40);
$sheet->getRowDimension('7')->setRowHeight(40);
$sheet->getRowDimension('8')->setRowHeight(40);
$sheet->getRowDimension('9')->setRowHeight(40);
$sheet->getRowDimension('10')->setRowHeight(40);
$sheet->getRowDimension('11')->setRowHeight(40);
$sheet->getRowDimension('12')->setRowHeight(40);
$sheet->getRowDimension('13')->setRowHeight(40);
$sheet->getRowDimension('14')->setRowHeight(40);
$sheet->getRowDimension('15')->setRowHeight(40);
$sheet->getRowDimension('16')->setRowHeight(40);
$sheet->getRowDimension('17')->setRowHeight(40);


 
 
 

//header
$sheet->setCellValue('A1', 'JADWAL MATA PELAJARAN PER KELAS');
$sheet->setCellValue('A2', ''.$sek_nama.'');
$sheet->mergeCells('A1:G1');
$sheet->getStyle("A1:G1")->getFont()->setSize(16)->setBold(true)->setName('Arial Narrow');
$sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->mergeCells('A2:G2');
$sheet->getStyle("A2:G2")->getFont()->setSize(16)->setBold(true)->setName('Arial Narrow');
$sheet->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



//header 
$sheet->setCellValue('A5', 'NO');
$sheet->getStyle('A5')->applyFromArray( $style_header );



//hari
$qhri = mysql_query("SELECT * FROM m_hari ".
						"ORDER BY round(no) ASC");
$rhri = mysql_fetch_assoc($qhri);

do
	{
	//nilai
	$hri_no = $hri_no + 1;
	$hri_kd = nosql($rhri['kd']);
	$hri_hr = balikin($rhri['hari']);
	
	$hri_nox = $hri_no + 1;
	$hri_nox2 = $arrrkoloma[$hri_nox];

	$sheet->setCellValue(''.$hri_nox2.'5', ''.$hri_hr.'');
	$sheet->getStyle(''.$hri_nox2.'5')->applyFromArray( $style_header );
	}
while ($rhri = mysql_fetch_assoc($qhri));







//datanya /////////////////////////////////////////////////////////////////////////////////////////////////
for ($k=1;$k<=12;$k++)
	{
	$nilk = 5 + $k;
	$sheet->setCellValue('A'.$nilk.'', ''.$k.'');
	$sheet->getStyle('A'.$nilk.'')->applyFromArray( $style_data );
	}



//hari
$qhri = mysql_query("SELECT * FROM m_hari ".
						"ORDER BY round(no) ASC");
$rhri = mysql_fetch_assoc($qhri);
$thri = mysql_num_rows($qhri);

do
	{
	//nilai
	$hri_no = $hri_no + 1;
	$hri_kd = nosql($rhri['kd']);
	$hri_hr = balikin($rhri['hari']);
	
//	$hri_nox = $hri_no + 1;
	$hri_nox = ($hri_no - $thri) + 1;
	$hri_nox2 = $arrrkoloma[$hri_nox];
	
	for ($k=1;$k<=12;$k++)
		{
		$barisku = 5 + $k;
	
//		$sheet->setCellValue(''.$hri_nox2.''.$barisku.'', ''.$hri_hr.'');
//		$sheet->getStyle(''.$hri_nox2.''.$barisku.'')->applyFromArray( $style_header );
		
		
		//datane waktu
		$qdte = mysql_query("SELECT * FROM m_waktu ".
								"WHERE no_urut = '$k' ".
								"AND kd_hari = '$hri_kd'");
		$rdte = mysql_fetch_assoc($qdte);
		$tdte = mysql_num_rows($qdte);
		$dte_jkd = balikin($rdte['kd_jam']);
		$dte_waktu = balikin($rdte['waktu']);
		$dte_ket = balikin($rdte['ket']);



		
		//jika ada, ket
		if (!empty($dte_ket))
			{
			$sheet->setCellValue(''.$hri_nox2.''.$barisku.'', ''.$dte_waktu.' '.$dte_ket.'');
			$sheet->getStyle(''.$hri_nox2.''.$barisku.'')->getAlignment()->setWrapText(true);
			$sheet->getStyle(''.$hri_nox2.''.$barisku.'')->applyFromArray( $style_header );
			$sheet->getStyle(''.$hri_nox2.''.$barisku.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			}
		else
			{
			//munculkan mapel gurunya...
			//datane...
			$qdte2 = mysql_query("SELECT jadwal.kd AS jdkd, jadwal.kd_guru_prog_pddkn AS gpkd ".
									"FROM jadwal ".
									"WHERE jadwal.kd_tapel = '$tapelkd' ".
									"AND jadwal.kd_smt = '$smtkd' ".
									"AND jadwal.kd_kelas = '$kelkd' ".
									"AND jadwal.kd_jam = '$dte_jkd' ".
									"AND jadwal.kd_hari = '$hri_kd'");
			$rdte2 = mysql_fetch_assoc($qdte2);
			$tdte2 = mysql_num_rows($qdte2);
			$dte_kd = nosql($rdte2['jdkd']);
			$dte_gpkd = nosql($rdte2['gpkd']);



			//guru ne
			$qku1 = mysql_query("SELECT * FROM m_guru_prog_pddkn ".
									"WHERE kd = '$dte_gpkd'");
			$rku1 = mysql_fetch_assoc($qku1);
			$ku1_gurkd = nosql($rku1['kd_guru']);
			$ku1_progkd = nosql($rku1['kd_prog_pddkn']);


			//guru ne
			$qku2 = mysql_query("SELECT m_pegawai.* ".
									"FROM m_pegawai, m_guru ".
									"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
									"AND m_guru.kd = '$ku1_gurkd'");
			$rku2 = mysql_fetch_assoc($qku2);
			$ku2_kode = nosql($rku2['kode']);
			$ku2_nip = balikin($rku2['nip']);
			$ku2_nama = balikin($rku2['nama']);
			


			//jam ke-
			$qcc3 = mysql_query("SELECT * FROM m_jam ".
									"WHERE kd = '$dte_jkd'");
			$rcc3 = mysql_fetch_assoc($qcc3);
			$dte3_jam = nosql($rcc3['jam']);

		
		
		

			//pddkn
			$qcc2 = mysql_query("SELECT * FROM m_prog_pddkn ".
									"WHERE kd = '$ku1_progkd'");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$dte_kode = nosql($rcc2['xpel']);
			$dte_pel = balikin($rcc2['prog_pddkn']);

			
			
			//jika gak null
			if (!empty($dte3_jam))
				{
				$nilho = "Jam ke-$dte3_jam [$dte_waktu]. $dte_kode [$ku2_nama]";				
				$sheet->setCellValue(''.$hri_nox2.''.$barisku.'', ''.$nilho.'');
				$sheet->getStyle(''.$hri_nox2.''.$barisku.'')->getAlignment()->setWrapText(true);
				$sheet->getStyle(''.$hri_nox2.''.$barisku.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$sheet->getStyle(''.$hri_nox2.''.$barisku.'')->applyFromArray( $style_data );
				}
			}
	
		}
	}
while ($rhri = mysql_fetch_assoc($qhri));
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
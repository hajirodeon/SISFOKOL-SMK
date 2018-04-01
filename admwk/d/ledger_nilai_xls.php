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




$sheet->getColumnDimension('A')->setWidth(4);
$sheet->getColumnDimension('B')->setWidth(10);
$sheet->getColumnDimension('C')->setWidth(20);
	

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

$kolnomx22 = $kolomke + 3;
$kolnomxx = $arrrkolom[$kolnomx22];
$sheet->mergeCells(''.$kolnomx.'4:'.$kolnomxx.'4');



$kolnomx2 = $kolomke + 1;
$kolnomx = $arrrkolom[$kolnomx2];

//looping daftar pribadi
$qdt = mysql_query("SELECT * FROM m_pribadi ".
			"ORDER BY pribadi ASC");
$rdt = mysql_fetch_assoc($qdt);

do
	{
	//nilai
	$dt_no = $dt_no + 1;
	$dt_kd = nosql($rdt['kd']);
	$dt_pribadi = balikin($rdt['pribadi']);

	$kolnomx3 = ($kolnomx2 + $dt_no) - 1;
	$kolnomx = $arrrkolom[$kolnomx3];

	$sheet->getColumnDimension(''.$kolnomx.'')->setWidth(4);
	$sheet->setCellValue(''.$kolnomx.'5', ''.$dt_pribadi.'');
	$sheet->getStyle(''.$kolnomx.'5')->getAlignment()->setTextRotation(90);
	$sheet->mergeCells(''.$kolnomx.'5:'.$kolnomx.'6');
	}
while ($rdt = mysql_fetch_assoc($qdt));





$kolnomx2 = $kolomke + 4;
$kolnomx = $arrrkolom[$kolnomx2];

$sheet->setCellValue(''.$kolnomx.'4', 'ABSENSI');

$kolnomx22 = $kolomke + 6;
$kolnomxx = $arrrkolom[$kolnomx22];
$sheet->mergeCells(''.$kolnomx.'4:'.$kolnomxx.'4');



$kolnomx2 = $kolomke + 4;
$kolnomx = $arrrkolom[$kolnomx2];


//looping daftar pribadi
$qdt = mysql_query("SELECT * FROM m_absensi ".
					"ORDER BY absensi ASC");
$rdt = mysql_fetch_assoc($qdt);

do
	{
	//nilai
	$dt_noo = $dt_noo + 1;
	$dt_kd = nosql($rdt['kd']);
	$dt_absensi = balikin($rdt['absensi']);

	$kolnomx3 = ($kolnomx2 + $dt_noo) - 1;
	$kolnomx = $arrrkolom[$kolnomx3];

	$sheet->getColumnDimension(''.$kolnomx.'')->setWidth(4);
	$sheet->setCellValue(''.$kolnomx.'5', ''.$dt_absensi.'');
	$sheet->getStyle(''.$kolnomx.'5')->getAlignment()->setTextRotation(90);
	$sheet->mergeCells(''.$kolnomx.'5:'.$kolnomx.'6');
	}
while ($rdt = mysql_fetch_assoc($qdt));




$kolnomx22 = $kolomke + 7;
$kolnomxx = $arrrkolom[$kolnomx22];
$sheet->setCellValue(''.$kolnomxx.'4', 'RANGKING');
$sheet->getColumnDimension(''.$kolnomxx.'')->setWidth(4);
$sheet->getStyle(''.$kolnomxx.'4')->getAlignment()->setTextRotation(90);
$sheet->mergeCells(''.$kolnomxx.'4:'.$kolnomxx.'6');




$kolnomx22 = $kolomke + 8;
$kolnomxx = $arrrkolom[$kolnomx22];
$sheet->getColumnDimension(''.$kolnomxx.'')->setWidth(20);
$sheet->setCellValue(''.$kolnomxx.'4', 'CATATAN WALIKELAS');
$sheet->mergeCells(''.$kolnomxx.'4:'.$kolnomxx.'6');



//looping daftar ekstra
$qdt = mysql_query("SELECT * FROM m_ekstra ".
					"ORDER BY ekstra ASC");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);


$kolnomx22 = $kolomke + 9;
$kolnomxx = $arrrkolom[$kolnomx22];
$sheet->getColumnDimension(''.$kolnomxx.'')->setWidth(20);
$sheet->setCellValue(''.$kolnomxx.'4', 'ESKTRAKURIKULER');


$kolnomx221 = ($kolomke + 9 + $tdt) - 1;
$kolnomxx1 = $arrrkolom[$kolnomx221];
$sheet->mergeCells(''.$kolnomxx.'4:'.$kolnomxx1.'4');


$kolnomx22 = $kolomke + 9;
$kolnomxx = $arrrkolom[$kolnomx22];


do
	{
	//nilai
	$dt_noo2 = $dt_noo2 + 1;
	$dt_kd = nosql($rdt['kd']);
	$dt_ekstra = balikin($rdt['ekstra']);

	$kolnomx3 = ($kolnomx22 + $dt_noo2) - 1;
	$kolnomx = $arrrkolom[$kolnomx3];

	$sheet->getColumnDimension(''.$kolnomx.'')->setWidth(4);
	$sheet->setCellValue(''.$kolnomx.'5', ''.$dt_ekstra.'');
	$sheet->getStyle(''.$kolnomx.'5')->getAlignment()->setTextRotation(90);
	$sheet->mergeCells(''.$kolnomx.'5:'.$kolnomx.'6');
	}
while ($rdt = mysql_fetch_assoc($qdt));



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









//query data siswa ///////////////////////////////////////////////////////////////////////////////////////////////
$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
						"siswa_kelas.*, siswa_kelas.kd AS skkd ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"ORDER BY m_siswa.nama ASC");
$rdata = mysql_fetch_assoc($qdata);





//looping siswa
do
	{
	//nilai
	$j = $j + 1;
	$y_mskd = nosql($rdata['mskd']);
	$y_skkd = nosql($rdata['skkd']);
	$y_nis = nosql($rdata['nis']);
	$y_nama = balikin($rdata['nama']);


	$kk = $j + 6;
	$kk2 = $j;

	
	$kk3 = $kk + 1;
	
	//kolom nilai							
	$sheet->setCellValue('A'.$kk.'', ''.$kk2.'');
	$sheet->setCellValue('B'.$kk.'', ''.$y_nis.'');
	$sheet->setCellValue('C'.$kk.'', ''.$y_nama.'');
	}	
while ($rdata = mysql_fetch_assoc($qdata));
		
	



//query data siswa
$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
						"siswa_kelas.*, siswa_kelas.kd AS skkd ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"ORDER BY m_siswa.nama ASC");
$rdata = mysql_fetch_assoc($qdata);





//looping siswa
do
	{
	//nilai
	$kz = $kz + 1;
	$y_mskd = nosql($rdata['mskd']);
	$y_skkd = nosql($rdata['skkd']);
	$y_nis = nosql($rdata['nis']);
	$y_nama = balikin($rdata['nama']);


	$kkz = $kz - 1;
//	$kk2z = $kkz - 6;
	$kk2z = $kkz - 7;

	





	//query
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
							"ORDER BY round(m_prog_pddkn_jns.no) ASC, ".
							"m_prog_pddkn.prog_pddkn ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);


	//jika ada 
	if (!empty($tpel))
		{
		do
			{
			$pelkd = nosql($rpel['pelkd']);
			$pel = substr(balikin2($rpel['xpel']),0,35);
			$pel_kkm = nosql($rpel['kkm']);



			//nil mapel
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$y_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$pelkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_pengetahuan_a = nosql($rxpel['nil_raport_pengetahuan_a']);
			
			
			$klm = $klm + 1;
			
			
			$bariske = 5 + $kz + 1;
			$kolomke = (($klm) - ($kz - 1) * $tpel) + 3;

			
			$kolomnya = $arrrkolom[$kolomke];
			$sheet->setCellValue(''.$kolomnya.''.$bariske.'', ''.$xpel_pengetahuan_a.'');

			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
				





	//jumlah total
	//nil mapel
	$qxpel = mysql_query("SELECT AVG(nil_raport_pengetahuan_a) AS total1 ".
							"FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$y_skkd' ".
							"AND kd_smt = '$smtkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$totalku = nosql($rxpel['total1']);
	$totalnyax = $totalku;
	



	//jml mapel
	$qpel = mysql_query("SELECT m_prog_pddkn.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas  ".
							"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd'".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	
	
	
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_rangking ".
							"WHERE kd_siswa_kelas = '$y_skkd' ".
							"AND kd_smt = '$smtkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$totalku = nosql($rxpel['rata_kognitif']);
	$totalku2 = nosql($rxpel['rata_psikomotorik']);
	$ipk = nosql($rxpel['total']);


	//query
	$qkunilx2 = mysql_query("SELECT * FROM siswa_rangking ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_keahlian ='$keahkd' ".
								"AND kd_kelas ='$kelkd' ".
								"AND kd_siswa_kelas = '$y_skkd' ".
								"AND kd_smt = '$smtkd'");
	$rkunilx2 = mysql_fetch_assoc($qkunilx2);
	$tkunilx2 = mysql_num_rows($qkunilx2);
	$kunilx2_rangking = nosql($rkunilx2['rangking']);





	$kol_akhir = 3 + $tjnsp + $tpel;
	$bariske = $kz + 6;
	$kol_akhir11 = $arrrkolom[$kol_akhir];
	
	$sheet->setCellValue(''.$kol_akhir11.''.$bariske.'', ''.$totalnyax.'');




	$bariske = $kz + 6;
	$kol_akhir = 4 + $tjnsp + $tpel;


	//looping daftar pribadi
	$qdt = mysql_query("SELECT * FROM m_pribadi ".
							"ORDER BY pribadi ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);
	
	do
		{
		//nilai
		$dt_no = $dt_no + 1;
		$dt_kd = nosql($rdt['kd']);
		$dt_pribadi = balikin($rdt['pribadi']);

		$kol_akhir4x = ($kol_akhir + $dt_no) - ($tdt * $kz) - 1;
		$kol_akhir14x = $arrrkolom[$kol_akhir4x];
		

		//pribadinya...
		$qprix = mysql_query("SELECT * FROM siswa_pribadi ".
								"WHERE kd_siswa_kelas = '$y_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_pribadi = '$dt_kd'");
		$rprix = mysql_fetch_assoc($qprix);
		$tprix = mysql_num_rows($qprix);
		$prix_predikat = nosql($rprix['predikat']);
		$prix_ket = balikin($rprix['ket']);

	
		$sheet->setCellValue(''.$kol_akhir14x.''.$bariske.'', ''.$prix_predikat.'');
		}
	while ($rdt = mysql_fetch_assoc($qdt));
	







	$bariske = $kz + 6;
	$kol_akhir = 10 + $tjnsp + $tpel;


	//looping daftar absensi
	$qdt = mysql_query("SELECT * FROM m_absensi ".
							"ORDER BY absensi ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);
	
	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_kd = nosql($rdt['kd']);
		$dt_absensi = balikin($rdt['absensi']);

		$kol_akhir4x = ($kol_akhir + $dt_nox) - ($tdt * $kz) - 1;
		$kol_akhir14x = $arrrkolom[$kol_akhir4x];
		

		//jika semester ganjil
		if ($smt_no == "1")
			{
			//jml. absensi...
			$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
									"WHERE kd_siswa_kelas = '$y_skkd' ".
									"AND kd_absensi = '$abs_kd' ".
									"AND round(DATE_FORMAT(tgl, '%m')) >= '7' ".
									"AND round(DATE_FORMAT(tgl, '%m')) <= '12'");
			$rbsi = mysql_fetch_assoc($qbsi);
			$tbsi = mysql_num_rows($qbsi);
			}
		//jika semester genap
		if ($smt_no == "2")
			{
			//jml. absensi...
			$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
									"WHERE kd_siswa_kelas = '$y_skkd' ".
									"AND kd_absensi = '$abs_kd' ".
									"AND round(DATE_FORMAT(tgl, '%m')) >= '1' ".
									"AND round(DATE_FORMAT(tgl, '%m')) <= '6'");
			$rbsi = mysql_fetch_assoc($qbsi);
			$tbsi = mysql_num_rows($qbsi);
			}
		

	
		$sheet->setCellValue(''.$kol_akhir14x.''.$bariske.'', ''.$tbsi.'');
		}
	while ($rdt = mysql_fetch_assoc($qdt));

	





	//query
	$qkunilx2 = mysql_query("SELECT * FROM siswa_rangking ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_keahlian ='$keahkd' ".
								"AND kd_kelas ='$kelkd' ".
								"AND kd_siswa_kelas = '$y_skkd' ".
								"AND kd_smt = '$smtkd'");
	$rkunilx2 = mysql_fetch_assoc($qkunilx2);
	$tkunilx2 = mysql_num_rows($qkunilx2);
	$kunilx2_rangking = nosql($rkunilx2['rangking']);


	$kol_akhir = 10 + $tjnsp + $tpel;
	$bariske = $kz + 6;
	$kol_akhir11 = $arrrkolom[$kol_akhir];
	
	$sheet->setCellValue(''.$kol_akhir11.''.$bariske.'', ''.$kunilx2_rangking.'');





	//catatan...
	$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd'");
	$rcatx = mysql_fetch_assoc($qcatx);
	$tcatx = mysql_num_rows($qcatx);
	$catx_catatan = balikin($rcatx['catatan']);


	$kol_akhir = 11 + $tjnsp + $tpel;
	$bariske = $kz + 6;
	$kol_akhir11 = $arrrkolom[$kol_akhir];
	
	$sheet->setCellValue(''.$kol_akhir11.''.$bariske.'', ''.$catx_catatan.'');





	$kol_akhir = 12 + $tjnsp + $tpel;
	$bariske = $kz + 6;
	$kol_akhir11 = $arrrkolom[$kol_akhir];



	//daftar ekstra
	$qkuti = mysql_query("SELECT * FROM m_ekstra ".
							"ORDER BY ekstra ASC");
	$rkuti = mysql_fetch_assoc($qkuti);
	$tkuti = mysql_num_rows($qkuti);

	
	do
		{
		$kuti_no = $kuti_no + 1;
		$kuti_kd = nosql($rkuti['kd']);
		$kuti_ekstra = balikin($rkuti['ekstra']);

		$kol_akhir4x = (13 + $kol_akhir + $kuti_no) - ($tkuti * $kz) - 1;
		$kol_akhir14x = $arrrkolom[$kol_akhir4x];

		//ekstra yang diikuti
		$qkuti2 = mysql_query("SELECT siswa_ekstra.* ".
								"FROM siswa_ekstra ".
								"WHERE siswa_ekstra.kd_ekstra = '$kuti_kd' ".
								"AND siswa_ekstra.kd_siswa_kelas = '$y_skkd' ".
								"AND siswa_ekstra.kd_smt = '$smtkd'");
		$rkuti2 = mysql_fetch_assoc($qkuti2);
		$tkuti2 = mysql_num_rows($qkuti2);
		$kuti2_predikat = nosql($rkuti2['predikat']);
	
		$sheet->setCellValue(''.$kol_akhir14x.''.$bariske.'', ''.$kuti2_predikat.'');
		}
	while ($rkuti = mysql_fetch_assoc($qkuti));
	
	

	}	
while ($rdata = mysql_fetch_assoc($qdata));













 

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
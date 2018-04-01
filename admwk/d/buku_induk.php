<?php
session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/PHPExcel.php");







nocache;

//nilai
$filenya = "buku_induk.php";
$judul = "Buku Induk";
$swkd = nosql($_REQUEST['swkd']);
$ke = "$filenya?swkd=$swkd";






//detail
$qdata = mysql_query("SELECT * FROM m_siswa ".
						"WHERE kd = '$swkd'");
$rdata = mysql_fetch_assoc($qdata);
$e_nis = nosql($rdata['nis']);
$e_nisx = strip($e_nis);
$e_nama = balikin($rdata['nama']);
$e_namax = strip($e_nama);



$e_nisn = balikin($rdata['nisn']);
$e_kelamin = balikin($rdata['kd_kelamin']);
$e_agama = balikin($rdata['kd_agama']);
$e_tmp_lahir = balikin($rdata['tmp_lahir']);
$e_tgl_lahir = balikin($rdata['tgl_lahir']);
$e_alamat = balikin($rdata['alamat']);
$e_sekolah_asal = balikin($rdata['sekolah_asal']);
$e_sekolah_alamat = balikin($rdata['sekolah_alamat']);
$e_ijazah_tahun = balikin($rdata['ijazah_tahun']);
$e_ijazah_nomor = balikin($rdata['ijazah_nomor']);
$e_skhun_tahun = balikin($rdata['skhun_tahun']);
$e_skhun_nomor = balikin($rdata['skhun_nomor']);
$e_diterima_tingkat = balikin($rdata['diterima_tingkat']);
$e_diterima_tgl = balikin($rdata['diterima_tgl']);
$e_diterima_program = balikin($rdata['diterima_program']);
$e_diterima_paket = balikin($rdata['diterima_paket']);
$e_ortu_ayah_nama = balikin($rdata['ortu_ayah_nama']);
$e_ortu_ibu_nama = balikin($rdata['ortu_ibu_nama']);
$e_ortu_alamat = balikin($rdata['ortu_alamat']);
$e_ortu_ayah_kerja = balikin($rdata['ortu_ayah_kerja']);
$e_ortu_ibu_kerja = balikin($rdata['ortu_ibu_kerja']);
$e_wali_nama = balikin($rdata['wali_nama']);
$e_wali_alamat = balikin($rdata['wali_alamat']);
$e_wali_kerja = balikin($rdata['wali_kerja']);
$e_keluar_tgl = balikin($rdata['keluar_tgl']);
$e_keluar_nomor = balikin($rdata['keluar_nomor']);
$e_lulus_tgl = balikin($rdata['lulus_tgl']);
$e_lulus_ijazah_nomor = balikin($rdata['lulus_ijazah_nomor']);
$e_lulus_skhun_nomor = balikin($rdata['lulus_skhun_nomor']);
$e_filex = $rdata['filex'];





$i_filename = "buku_induk_$e_nisx-$e_namax.xls";






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

//Menggunakan HeaderStylenya
//$objPHPExcel->getActiveSheet()->setSharedStyle($headerStylenya, "A3 : A10");
//$objPHPExcel->getActiveSheet()->setSharedStyle($headerStylenya, "A3 : D6");
//$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->getRGB();
//$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FF1E1E')));


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


//$sheet->getStyle('A3:BF6')->applyFromArray( $style_header );







//$sheet->getStyle('A1:A2')->getAlignment()->setWrapText(true);








//$sheet = $objPHPExcel->getActiveSheet();
$sheet = $objPHPExcel->setActiveSheetIndex(0)->setTitle('Hal 1');


//atur lebar kolom
$sheet->getColumnDimension('A')->setWidth(3);
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(1);
$sheet->getColumnDimension('D')->setWidth(30);
$sheet->getColumnDimension('E')->setWidth(3);
$sheet->getColumnDimension('F')->setWidth(4);
$sheet->getColumnDimension('N')->setWidth(15);
$sheet->getColumnDimension('T')->setWidth(15);
$sheet->getColumnDimension('Z')->setWidth(15);
$sheet->getColumnDimension('AF')->setWidth(15);

//atur lebar baris
$sheet->getRowDimension('1')->setRowHeight(30);
$sheet->getRowDimension('6')->setRowHeight(20);
$sheet->getRowDimension('9')->setRowHeight(30);


//set font
$sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true)->setName('Verdana');
$sheet->getStyle("F6")->getFont()->setSize(14)->setBold(true)->setName('Arial Narrow');
$sheet->getStyle("I3:AF6")->getFont()->setSize(10)->setBold(true)->setName('Verdana');


//header
$sheet->setCellValue('A1', 'BUKU INDUK PESERTA DIDIK');
$sheet->setCellValue('AE1', '');
$sheet->mergeCells('A1:AE1');
$sheet->getStyle('A1:AE1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('AF1', 'TI/BM/PAR/KES');
$sheet->getStyle('AF1')->getAlignment()->setWrapText(true);



$sheet->setCellValue('A3', 'KETERANGAN TENTANG DIRI PESERTA DIDIK');

$sheet->setCellValue('A4', '1.');
$sheet->setCellValue('B4', 'Nama Peserta Didik');
$sheet->setCellValue('C4', ':');
$sheet->setCellValue('D4', ''.$e_nama.'');
$sheet->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$sheet->setCellValue('A5', '2.');
$sheet->setCellValue('B5', 'Nomor Induk');
$sheet->setCellValue('C5', ':');
$sheet->setCellValue('D5', ''.$e_nis.'');
$sheet->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$sheet->setCellValue('A6', '3.');
$sheet->setCellValue('B6', 'Nomor Induk Siswa Nasional');
$sheet->setCellValue('C6', ':');
$sheet->setCellValue('D6', ''.$e_nisn.'');
$sheet->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


//terpilih
$qjkelx = mysql_query("SELECT * FROM m_kelamin ".
							"WHERE kd = '$e_kelamin'");
$rjkelx = mysql_fetch_assoc($qjkelx);
$jkelx_kelamin = balikin($rjkelx['kelamin']);

$sheet->setCellValue('A7', '4.');
$sheet->setCellValue('B7', 'Jenis Kelamin');
$sheet->setCellValue('C7', ':');
$sheet->setCellValue('D7', ''.$jkelx_kelamin.'');


//terpilih
$qagmx = mysql_query("SELECT * FROM m_agama ".
						"WHERE kd = '$e_agama'");
$ragmx = mysql_fetch_assoc($qagmx);
$agmx_agama = balikin($ragmx['agama']);



$sheet->setCellValue('A8', '5.');
$sheet->setCellValue('B8', 'Agama');
$sheet->setCellValue('C8', ':');
$sheet->setCellValue('D8', ''.$agmx_agama.'');

$sheet->setCellValue('A9', '6.');
$sheet->setCellValue('B9', 'Tempat dan Tanggal Lahir');
$sheet->setCellValue('C9', ':');
$sheet->setCellValue('D9', ''.$e_tmp_lahir.', '.$e_tgl_lahir.'');



//query
$qnil = mysql_query("SELECT m_siswa_tmp_tinggal.*, siswa_kelas.* ".
						"FROM m_siswa_tmp_tinggal, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_tmp_tinggal.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_alamat = balikin2($rnil['alamat']);



$sheet->setCellValue('A10', '7.');
$sheet->setCellValue('B10', 'Alamat Peserta Didik');
$sheet->setCellValue('C10', ':');
$sheet->setCellValue('D10', ''.$y_alamat.'');
$sheet->mergeCells('D10:D12');
$sheet->getStyle('D10:D12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);



//sekolah asal
$qnil = mysql_query("SELECT m_siswa_pendidikan.*, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%Y') AS thn, ".
						"DATE_FORMAT(m_siswa_pendidikan.skhun_tgl, '%d') AS tgl2, ".
						"DATE_FORMAT(m_siswa_pendidikan.skhun_tgl, '%m') AS bln2, ".
						"DATE_FORMAT(m_siswa_pendidikan.skhun_tgl, '%Y') AS thn2 ".
						"FROM m_siswa_pendidikan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_pendidikan.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_lulusan = balikin2($rnil['lulusan']);
$y_alamat_sek = balikin2($rnil['alamat_sekolah']);
$y_no_sttb = balikin2($rnil['no_sttb']);
$y_tgl_sttb = nosql($rnil['tgl']);
$y_bln_sttb = nosql($rnil['bln']);
$y_thn_sttb = nosql($rnil['thn']);
$y_tgl_skhun = nosql($rnil['tgl2']);
$y_bln_skhun = nosql($rnil['bln2']);
$y_thn_skhun = nosql($rnil['thn2']);
$y_lama = balikin2($rnil['lama']);
$y_skhun_tahun = $y_thn_skhun;
$y_skhun_nomor = balikin2($rnil['skhun_nomor']);





$sheet->setCellValue('A13', '8.');
$sheet->setCellValue('B13', 'Sekolah Asal');
$sheet->setCellValue('C13', ':');

$sheet->setCellValue('B14', 'A. Nama Sekolah');
$sheet->setCellValue('C14', ':');
$sheet->setCellValue('D14', ''.$y_lulusan.'');
$sheet->setCellValue('B15', 'B. Alamat');
$sheet->setCellValue('C15', ':');
$sheet->setCellValue('D15', ''.$y_alamat_sek.'');


$sheet->setCellValue('A16', '9.');
$sheet->setCellValue('B16', 'Ijazah SMP/MTS/Paket B');
$sheet->setCellValue('C16', ':');

$sheet->setCellValue('B17', 'A. Tahun');
$sheet->setCellValue('C17', ':');
$sheet->setCellValue('D17', ''.$y_thn_sttb.'');
$sheet->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->setCellValue('B18', 'B. Nomor');
$sheet->setCellValue('C18', ':');
$sheet->setCellValue('D18', ''.$y_no_sttb.'');
$sheet->getStyle('D18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);






$sheet->setCellValue('A19', '10.');
$sheet->setCellValue('B19', 'SKHUN SMP/MTS/Paket B');
$sheet->setCellValue('C19', ':');

$sheet->setCellValue('B20', 'A. Tahun');
$sheet->setCellValue('C20', ':');
$sheet->setCellValue('D20', ''.$y_skhun_tahun.'');
$sheet->getStyle('D20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->setCellValue('B21', 'B. Nomor');
$sheet->setCellValue('C21', ':');
$sheet->setCellValue('D21', ''.$y_skhun_nomor.'');
$sheet->getStyle('D21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);






//diterima
$qnil3 = mysql_query("SELECT m_siswa_diterima.*, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_diterima, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_diterima.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil3 = mysql_fetch_assoc($qnil3);
$y_kelas = balikin2($rnil3['kelas']);
$y_keahlian = balikin2($rnil3['keahlian']);
$y_tgl_terima = nosql($rnil3['tgl']);
$y_bln_terima = nosql($rnil3['bln']);
$y_thn_terima = nosql($rnil3['thn']);
$y_tgl_diterima = "$y_tgl_terima-$y_bln_terima-$y_thn_terima";



$sheet->setCellValue('A22', '11.');
$sheet->setCellValue('B22', 'Diterima di sekolah ini');
$sheet->setCellValue('C22', ':');
$sheet->setCellValue('B23', 'A, Ditingkat');
$sheet->setCellValue('C23', ':');
$sheet->setCellValue('D23', ''.$y_kelas.'');
$sheet->getStyle('D23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$sheet->setCellValue('B24', 'B. Pada tgl-bln-thn');
$sheet->setCellValue('C24', ':');
$sheet->setCellValue('D24', ''.$y_tgl_diterima.'');
$sheet->setCellValue('B25', 'C. Program Keahlian');
$sheet->setCellValue('C25', ':');
$sheet->setCellValue('D25', ''.$y_keahlian.'');




$sheet->setCellValue('A27', '12.');
$sheet->setCellValue('B27', 'Nama Orang Tua');
$sheet->setCellValue('C27', ':');


//query
$qnil = mysql_query("SELECT m_siswa_ayah.* ".
						"FROM m_siswa_ayah, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_ayah.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_nama = balikin2($rnil['nama']);
$y_pekkd = nosql($rnil['kd_pekerjaan']);
$y_alamat = balikin2($rnil['alamat']);

//terpilih
$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
						"WHERE kd = '$y_pekkd'");
$rpekx = mysql_fetch_assoc($qpekx);
$pekx_pekerjaan = balikin($rpekx['pekerjaan']);


$sheet->setCellValue('B28', 'A. Ayah');
$sheet->setCellValue('C28', ':');
$sheet->setCellValue('D28', ''.$y_nama.'');

$sheet->setCellValue('B34', 'A. Ayah');
$sheet->setCellValue('C34', ':');
$sheet->setCellValue('D34', ''.$pekx_pekerjaan.'');


//query
$qnil = mysql_query("SELECT m_siswa_ibu.* ".
						"FROM m_siswa_ibu, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_ibu.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_nama = balikin2($rnil['nama']);
$y_pekkd = nosql($rnil['kd_pekerjaan']);

//terpilih
$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
						"WHERE kd = '$y_pekkd'");
$rpekx = mysql_fetch_assoc($qpekx);
$pekx_pekerjaan = balikin($rpekx['pekerjaan']);


$sheet->setCellValue('B29', 'B. Ibu');
$sheet->setCellValue('C29', ':');
$sheet->setCellValue('D29', ''.$y_nama.'');

$sheet->setCellValue('B35', 'B. Ibu');
$sheet->setCellValue('C35', ':');
$sheet->setCellValue('D35', ''.$pekx_pekerjaan.'');



$sheet->setCellValue('A30', '13.');
$sheet->setCellValue('B30', 'Alamat Orang Tua');
$sheet->setCellValue('C30', ':');
$sheet->setCellValue('D30', ''.$y_alamat.'');
$sheet->mergeCells('D30:D32');
$sheet->getStyle('D30:D32')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

$sheet->setCellValue('A33', '14.');
$sheet->setCellValue('B33', 'Pekerjaan Orang Tua');
$sheet->setCellValue('C33', ':');





//wali
$qnil = mysql_query("SELECT m_siswa_wali.* ".
						"FROM m_siswa_wali, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_wali.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_nama = balikin2($rnil['nama']);
$y_pekkd = nosql($rnil['kd_pekerjaan']);
$y_alamat = balikin2($rnil['alamat']);

//terpilih
$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
						"WHERE kd = '$y_pekkd'");
$rpekx = mysql_fetch_assoc($qpekx);
$pekx_pekerjaan = balikin($rpekx['pekerjaan']);

			
$sheet->setCellValue('A36', '15.');
$sheet->setCellValue('B36', 'Nama Wali');
$sheet->setCellValue('C36', ':');
$sheet->setCellValue('D36', ''.$y_nama.'');

$sheet->setCellValue('A37', '16.');
$sheet->setCellValue('B37', 'Alamat Wali');
$sheet->setCellValue('C37', ':');
$sheet->setCellValue('D37', ''.$y_alamat.'');
$sheet->mergeCells('D37:D39');

$sheet->setCellValue('A40', '17.');
$sheet->setCellValue('B40', 'Pekerjaan Wali');
$sheet->setCellValue('C40', ':');
$sheet->setCellValue('D40', ''.$pekx_pekerjaan.'');






//keluar dan lulus
$qnil = mysql_query("SELECT m_siswa_perkembangan.*, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl, '%Y') AS thn, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl_terima_ijazah, '%d') AS tgl_terima, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl_terima_ijazah, '%m') AS bln_terima, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl_terima_ijazah, '%Y') AS thn_terima, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl_ijazah, '%d') AS tgl_ijazah, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl_ijazah, '%m') AS bln_ijazah, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl_ijazah, '%Y') AS thn_ijazah, ".
						"siswa_kelas.* ".
						"FROM m_siswa_perkembangan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_perkembangan.kd_siswa ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_tgl_tinggal = nosql($rnil['tgl']);
$y_bln_tinggal = nosql($rnil['bln']);
$y_thn_tinggal = nosql($rnil['thn']);
$y_keluar_tgl = "$y_tgl_tinggal-$y_bln_tinggal-$y_thn_tinggal";
$y_no_sttb = balikin2($rnil['no_sttb']);
$y_no_skhun = balikin2($rnil['no_skhun']);
$y_no_surat = balikin($rnil['no_surat']);
$y_tgl_ijazah = nosql($rnil['tgl_ijazah']);
$y_bln_ijazah = nosql($rnil['bln_ijazah']);
$y_thn_ijazah = nosql($rnil['thn_ijazah']);
$y_lulus_tgl = "$y_tgl_ijazah-$y_bln_ijazah-$y_thn_ijazah";

$sheet->setCellValue('A41', '18.');
$sheet->setCellValue('B41', 'Keluar SMK Tgl-Bln-Thn');
$sheet->setCellValue('C41', ':');
$sheet->setCellValue('D41', ''.$y_keluar_tgl.'');

$sheet->setCellValue('B42', 'Nomor Surat Keluar');
$sheet->setCellValue('C42', ':');
$sheet->setCellValue('D42', ''.$y_no_surat.'');

$sheet->setCellValue('A43', '19.');
$sheet->setCellValue('B43', 'Lulus SMK Tgl-Bln-Thn');
$sheet->setCellValue('C43', ':');
$sheet->setCellValue('D43', ''.$y_lulus_tgl.'');

$sheet->setCellValue('B44', 'Nomor Ijazah');
$sheet->setCellValue('C44', ':');
$sheet->setCellValue('D44', ''.$y_no_sttb.'');


$sheet->setCellValue('B45', 'Nomor SKHUN');
$sheet->setCellValue('C45', ':');
$sheet->setCellValue('D45', ''.$y_no_skhun.'');





$sheet->setCellValue('F6', 'CAPAIAN KOMPETENSI');
$sheet->setCellValue('H6', '');
$sheet->mergeCells('F6:H6');


//semester satu
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);



$sheet->setCellValue('I3', 'Kelas');
$sheet->setCellValue('K3', ': '.$dt_kelku.'');
$sheet->setCellValue('L3', '');
$sheet->setCellValue('M3', '');
$sheet->setCellValue('N3', '');
$sheet->mergeCells('K3:N3');

$sheet->setCellValue('I4', 'Semester');
$sheet->setCellValue('K4', ': 1');
$sheet->setCellValue('L4', '');
$sheet->setCellValue('M4', '');
$sheet->setCellValue('N4', '');
$sheet->mergeCells('K4:N4');

$sheet->setCellValue('I5', 'Tahun Pelajaran');
$sheet->setCellValue('K5', ': '.$dt_tahun1.'/'.$dt_tahun2.'');
$sheet->setCellValue('L5', '');
$sheet->setCellValue('M5', '');
$sheet->setCellValue('N5', '');
$sheet->mergeCells('K5:N5');

$sheet->setCellValue('I6', 'Wali Kelas');
$sheet->setCellValue('K6', ': '.$nwk.'');
$sheet->setCellValue('L6', '');
$sheet->setCellValue('M6', '');
$sheet->setCellValue('N6', '');
$sheet->mergeCells('K6:N6');





//semester dua
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);


$sheet->setCellValue('O3', 'Kelas');
$sheet->setCellValue('P3', '');
$sheet->setCellValue('Q3', ': '.$dt_kelku.'');
$sheet->setCellValue('R3', '');
$sheet->setCellValue('S3', '');
$sheet->setCellValue('T3', '');
$sheet->mergeCells('Q3:T3');

$sheet->setCellValue('O4', 'Semester');
$sheet->setCellValue('P4', '');
$sheet->setCellValue('Q4', ': 2');
$sheet->setCellValue('R4', '');
$sheet->setCellValue('S4', '');
$sheet->setCellValue('T4', '');
$sheet->mergeCells('Q4:T4');

$sheet->setCellValue('O5', 'Tahun Pelajaran');
$sheet->setCellValue('P5', '');
$sheet->setCellValue('Q5', ': '.$dt_tahun1.'/'.$dt_tahun2.'');
$sheet->setCellValue('R5', '');
$sheet->setCellValue('S5', '');
$sheet->setCellValue('T5', '');
$sheet->mergeCells('Q5:T5');

$sheet->setCellValue('O6', 'Wali Kelas');
$sheet->setCellValue('Q6', ': '.$nwk.'');
$sheet->setCellValue('R6', '');
$sheet->setCellValue('S6', '');
$sheet->setCellValue('T6', '');
$sheet->mergeCells('Q6:T6');





//semester tiga
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);


$sheet->setCellValue('U3', 'Kelas');
$sheet->setCellValue('W3', ': '.$dt_kelku.'');
$sheet->setCellValue('X3', '');
$sheet->setCellValue('Y3', '');
$sheet->setCellValue('Z3', '');
$sheet->mergeCells('W3:Z3');

$sheet->setCellValue('U4', 'Semester');
$sheet->setCellValue('W4', ': 1');
$sheet->setCellValue('X4', '');
$sheet->setCellValue('Y4', '');
$sheet->setCellValue('Z4', '');
$sheet->mergeCells('W4:Z4');

$sheet->setCellValue('U5', 'Tahun Pelajaran');
$sheet->setCellValue('W5', ': '.$dt_tahun1.'/'.$dt_tahun2.'');
$sheet->setCellValue('X5', '');
$sheet->setCellValue('Y5', '');
$sheet->setCellValue('Z5', '');
$sheet->mergeCells('W5:Z5');

$sheet->setCellValue('U6', 'Wali Kelas');
$sheet->setCellValue('W6', ': '.$nwk.'');
$sheet->setCellValue('X6', '');
$sheet->setCellValue('Y6', '');
$sheet->setCellValue('Z6', '');
$sheet->mergeCells('W6:Z6');





//semester empat
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);



$sheet->setCellValue('AA3', 'Kelas');
$sheet->setCellValue('AC3', ': '.$dt_kelku.'');
$sheet->setCellValue('AD3', '');
$sheet->setCellValue('AE3', '');
$sheet->setCellValue('AF3', '');
$sheet->mergeCells('AC3:AF3');

$sheet->setCellValue('AA4', 'Semester');
$sheet->setCellValue('AC4', ': 2');
$sheet->setCellValue('AD4', '');
$sheet->setCellValue('AE4', '');
$sheet->setCellValue('AF4', '');
$sheet->mergeCells('AC4:AF4');

$sheet->setCellValue('AA5', 'Tahun Pelajaran');
$sheet->setCellValue('AC5', ': '.$dt_tahun1.'/'.$dt_tahun2.'');
$sheet->setCellValue('AD5', '');
$sheet->setCellValue('AE5', '');
$sheet->setCellValue('AF5', '');
$sheet->mergeCells('AC5:AF5');

$sheet->setCellValue('AA6', 'Wali Kelas');
$sheet->setCellValue('AC6', ': '.$nwk.'');
$sheet->setCellValue('AD6', '');
$sheet->setCellValue('AE6', '');
$sheet->setCellValue('AF6', '');
$sheet->mergeCells('AC6:AF6');







//header raport semester satu
$sheet->setCellValue('F8', 'No.');
$sheet->setCellValue('F9', '');
$sheet->setCellValue('F10', '');
$sheet->mergeCells('F8:F10');
$sheet->getStyle('F8:F10')->applyFromArray( $style_header );


$sheet->setCellValue('G8', 'Mata Pelajaran');
$sheet->setCellValue('H8', '');
$sheet->setCellValue('G9', '');
$sheet->setCellValue('H9', '');
$sheet->setCellValue('H10', '');
$sheet->mergeCells('G8:H10');
$sheet->getStyle('G8:H10')->applyFromArray( $style_header );


$sheet->setCellValue('I8', 'Pengetahuan');
$sheet->setCellValue('J8', '');
$sheet->mergeCells('I8:J8');
$sheet->getStyle('I8:J8')->applyFromArray( $style_header );
$sheet->setCellValue('I9', 'Angka');
$sheet->getStyle('I9')->applyFromArray( $style_header );
$sheet->setCellValue('J9', 'Predikat');
$sheet->getStyle('J9')->applyFromArray( $style_header );
$sheet->setCellValue('I10', '1 - 4');
$sheet->getStyle('I10')->applyFromArray( $style_header );
$sheet->setCellValue('J10', 'A - D');
$sheet->getStyle('J10')->applyFromArray( $style_header );

$sheet->setCellValue('K8', 'Keterampilan');
$sheet->setCellValue('L8', '');
$sheet->mergeCells('K8:L8');
$sheet->getStyle('K8:L8')->applyFromArray( $style_header );
$sheet->setCellValue('K9', 'Angka');
$sheet->getStyle('K9')->applyFromArray( $style_header );
$sheet->setCellValue('L9', 'Predikat');
$sheet->getStyle('L9')->applyFromArray( $style_header );
$sheet->setCellValue('K10', '1 - 4');
$sheet->getStyle('K10')->applyFromArray( $style_header );
$sheet->setCellValue('L10', 'A - D');
$sheet->getStyle('L10')->applyFromArray( $style_header );

$sheet->setCellValue('M8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('N8', '');
$sheet->mergeCells('M8:N8');
$sheet->getStyle('M8:N8')->applyFromArray( $style_header );
$sheet->setCellValue('M9', 'Dalam Mapel');
$sheet->getStyle('M9')->getAlignment()->setWrapText(true);
$sheet->setCellValue('N9', 'Antar Mata Pelajaran');
$sheet->setCellValue('N10', '');
$sheet->mergeCells('N9:N10');
$sheet->getStyle('N9:N10')->applyFromArray( $style_header );
$sheet->getStyle('N9:N10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('M10', 'SB/B/C/K');
$sheet->getStyle('M10')->applyFromArray( $style_header );


$sheet->getStyle('F8:N10')->applyFromArray( $style_header );






//header raport semester dua
$sheet->setCellValue('O8', 'Pengetahuan');
$sheet->setCellValue('P8', '');
$sheet->mergeCells('O8:P8');
$sheet->getStyle('O8:P8')->applyFromArray( $style_header );
$sheet->setCellValue('O9', 'Angka');
$sheet->getStyle('O9')->applyFromArray( $style_header );
$sheet->setCellValue('P9', 'Predikat');
$sheet->getStyle('P9')->applyFromArray( $style_header );
$sheet->setCellValue('O10', '1 - 4');
$sheet->getStyle('O10')->applyFromArray( $style_header );
$sheet->setCellValue('P10', 'A - D');
$sheet->getStyle('P10')->applyFromArray( $style_header );

$sheet->setCellValue('Q8', 'Keterampilan');
$sheet->setCellValue('R8', '');
$sheet->mergeCells('Q8:R8');
$sheet->getStyle('Q8:R8')->applyFromArray( $style_header );
$sheet->setCellValue('Q9', 'Angka');
$sheet->getStyle('Q9')->applyFromArray( $style_header );
$sheet->setCellValue('R9', 'Predikat');
$sheet->getStyle('R9')->applyFromArray( $style_header );
$sheet->setCellValue('Q10', '1 - 4');
$sheet->getStyle('Q10')->applyFromArray( $style_header );
$sheet->setCellValue('R10', 'A - D');
$sheet->getStyle('R10')->applyFromArray( $style_header );

$sheet->setCellValue('S8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('T8', '');
$sheet->mergeCells('S8:T8');
$sheet->getStyle('S8:T8')->applyFromArray( $style_header );
$sheet->setCellValue('S9', 'Dalam Mapel');
$sheet->getStyle('S9')->getAlignment()->setWrapText(true);
$sheet->setCellValue('T9', 'Antar Mata Pelajaran');
$sheet->setCellValue('T10', '');
$sheet->mergeCells('T9:T10');
$sheet->getStyle('S9:T10')->applyFromArray( $style_header );
$sheet->getStyle('S9:T10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('S10', 'SB/B/C/K');
$sheet->getStyle('S9')->applyFromArray( $style_header );
$sheet->getStyle('S10')->applyFromArray( $style_header );

$sheet->getStyle('O8:T10')->applyFromArray( $style_header );






//header raport semester tiga
$sheet->setCellValue('U8', 'Pengetahuan');
$sheet->setCellValue('V8', '');
$sheet->mergeCells('U8:V8');
$sheet->getStyle('U8:V8')->applyFromArray( $style_header );
$sheet->setCellValue('U9', 'Angka');
$sheet->getStyle('U9')->applyFromArray( $style_header );
$sheet->setCellValue('V9', 'Predikat');
$sheet->getStyle('V9')->applyFromArray( $style_header );
$sheet->setCellValue('U10', '1 - 4');
$sheet->getStyle('V10')->applyFromArray( $style_header );
$sheet->setCellValue('V10', 'A - D');
$sheet->getStyle('V10')->applyFromArray( $style_header );

$sheet->setCellValue('W8', 'Keterampilan');
$sheet->setCellValue('X8', '');
$sheet->mergeCells('W8:X8');
$sheet->getStyle('W8:X8')->applyFromArray( $style_header );
$sheet->setCellValue('W9', 'Angka');
$sheet->getStyle('W9')->applyFromArray( $style_header );
$sheet->setCellValue('X9', 'Predikat');
$sheet->getStyle('X9')->applyFromArray( $style_header );
$sheet->setCellValue('W10', '1 - 4');
$sheet->getStyle('W10')->applyFromArray( $style_header );
$sheet->setCellValue('X10', 'A - D');
$sheet->getStyle('X10')->applyFromArray( $style_header );

$sheet->setCellValue('Y8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('Z8', '');
$sheet->mergeCells('Y8:Z8');
$sheet->getStyle('Y8:Z8')->applyFromArray( $style_header );
$sheet->setCellValue('Y9', 'Dalam Mapel');
$sheet->getStyle('Y9')->getAlignment()->setWrapText(true);
$sheet->setCellValue('Z9', 'Antar Mata Pelajaran');
$sheet->setCellValue('Z10', '');
$sheet->mergeCells('Z9:Z10');
$sheet->getStyle('Y9:Z10')->applyFromArray( $style_header );
$sheet->getStyle('Y9:Z10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('Y10', 'SB/B/C/K');
$sheet->getStyle('Y9')->applyFromArray( $style_header );
$sheet->getStyle('Y10')->applyFromArray( $style_header );

$sheet->getStyle('U8:Z10')->applyFromArray( $style_header );




//header raport semester empat
$sheet->setCellValue('AA8', 'Pengetahuan');
$sheet->setCellValue('AB8', '');
$sheet->mergeCells('AA8:AB8');
$sheet->getStyle('AA8:AB8')->applyFromArray( $style_header );
$sheet->setCellValue('AA9', 'Angka');
$sheet->getStyle('AA9')->applyFromArray( $style_header );
$sheet->setCellValue('AB9', 'Predikat');
$sheet->getStyle('AB9')->applyFromArray( $style_header );
$sheet->setCellValue('AA10', '1 - 4');
$sheet->getStyle('AB10')->applyFromArray( $style_header );
$sheet->setCellValue('AB10', 'A - D');
$sheet->getStyle('AB10')->applyFromArray( $style_header );

$sheet->setCellValue('AC8', 'Keterampilan');
$sheet->setCellValue('AD8', '');
$sheet->mergeCells('AC8:AD8');
$sheet->getStyle('AC8:AD8')->applyFromArray( $style_header );
$sheet->setCellValue('AC9', 'Angka');
$sheet->getStyle('AC9')->applyFromArray( $style_header );
$sheet->setCellValue('AD9', 'Predikat');
$sheet->getStyle('AD9')->applyFromArray( $style_header );
$sheet->setCellValue('AC10', '1 - 4');
$sheet->getStyle('AC10')->applyFromArray( $style_header );
$sheet->setCellValue('AD10', 'A - D');
$sheet->getStyle('AD10')->applyFromArray( $style_header );

$sheet->setCellValue('AE8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('AF8', '');
$sheet->mergeCells('AE8:AF8');
$sheet->getStyle('AE8:AF8')->applyFromArray( $style_header );
$sheet->setCellValue('AE9', 'Dalam Mapel');
$sheet->getStyle('AE9')->getAlignment()->setWrapText(true);
$sheet->setCellValue('AF9', 'Antar Mata Pelajaran');
$sheet->setCellValue('AF10', '');
$sheet->mergeCells('AF9:AF10');
$sheet->getStyle('AE9:AF10')->applyFromArray( $style_header );
$sheet->getStyle('AE9:AF10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('AE10', 'SB/B/C/K');
$sheet->getStyle('AE9')->applyFromArray( $style_header );
$sheet->getStyle('AE10')->applyFromArray( $style_header );

$sheet->getStyle('AA8:AF10')->applyFromArray( $style_header );







//datanya

/*
//looping baris
for ($kk=1;$kk<=10;$kk++)
	{
	$kkx = $kk + 10;
	
	

	//data
	$sheet->setCellValue('F'.$kkx.'', ''.$kk.'');
	$sheet->setCellValue('G'.$kkx.'', ''.$kk.'');
	$sheet->setCellValue('H'.$kkx.'', '');
	$sheet->mergeCells('G'.$kkx.':H'.$kkx.'');


	$sheet->getStyle('G'.$kkx.':H'.$kkx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	



/*
	//looping kolom
	for ($mm=1;$mm<=10;$mm++)
		{
		$mmx = $mm + 5;
		$kolnomx = $arrrkolom[$mmx];
		
		$sheet->setCellValue(''.$kolnomx.''.$kkx.'', ''.$kk.'');
		}

	}

*/





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
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);


//baris ke
$kkx = $ku_nomer + 10;
$kkxx = $kkx;


$sheet->setCellValue('F'.$kkxx.'', ''.$ku_jenis.'');
$sheet->mergeCells('F'.$kkxx.':M'.$kkxx.'');
$sheet->getStyle('F'.$kkxx.':M'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('F'.$kkxx.':M'.$kkxx.'')->applyFromArray( $style_data );




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



	$sheet->setCellValue('F'.$kkx2.'', ''.$jk.'');
	$sheet->setCellValue('G'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('G'.$kkx2.':H'.$kkx2.'');

	$sheet->getStyle('G'.$kkx2.':H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('G'.$kkx2.':H'.$kkx2.'')->applyFromArray( $style_data );
	
	
	//tingkat satu, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

	//catatan	
	$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd'");
	$rcatx = mysql_fetch_assoc($qcatx);
	$tcatx = mysql_num_rows($qcatx);
	$catx_catatan = balikin($rcatx['catatan']);
	
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);


	$sheet->setCellValue('I'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('I'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('J'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('K'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('L'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('L'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('M'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('M'.$kkx2.'')->applyFromArray( $style_data );





	//tingkat satu, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('O'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('O'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('P'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('P'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('Q'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('R'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('S'.$kkx2.'')->applyFromArray( $style_data );







	//tingkat dua, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('U'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('U'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('V'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('V'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('W'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('X'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('X'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('Y'.$kkx2.'')->applyFromArray( $style_data );





	//tingkat dua, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('AA'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('AA'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AB'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('AB'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AC'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('AC'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AD'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('AD'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AE'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('AE'.$kkx2.'')->applyFromArray( $style_data );

	
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
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel2 = mysql_fetch_assoc($qpel2);
$tpel2 = mysql_num_rows($qpel2);


//baris ke
$kkx = 12 + $tpel;
$kkxx = $kkx;


$sheet->setCellValue('F'.$kkxx.'', ''.$ku_jenis.'');
$sheet->getStyle('F'.$kkxx.':M'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('F'.$kkxx.':M'.$kkxx.'')->applyFromArray( $style_data );




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



	$sheet->setCellValue('F'.$kkx2.'', ''.$jk.'');
	$sheet->setCellValue('G'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('G'.$kkx2.':H'.$kkx2.'');

	$sheet->getStyle('G'.$kkx2.':H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('G'.$kkx2.':H'.$kkx2.'')->applyFromArray( $style_data );
	

	//tingkat satu, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

		
	$sheet->setCellValue('I'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('I'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('J'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('K'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('L'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('L'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('M'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('M'.$kkx2.'')->applyFromArray( $style_data );





	//tingkat satu, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);


	$sheet->setCellValue('O'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('O'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('P'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('P'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('Q'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('R'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('S'.$kkx2.'')->applyFromArray( $style_data );




	//tingkat dua, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);


	$sheet->setCellValue('U'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('U'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('V'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('V'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('W'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('X'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('X'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('Y'.$kkx2.'')->applyFromArray( $style_data );



	//tingkat dua, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('AA'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('AA'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AB'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('AB'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AC'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('AC'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AD'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('AD'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AE'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('AE'.$kkx2.'')->applyFromArray( $style_data );

	
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
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel3 = mysql_fetch_assoc($qpel3);
$tpel3 = mysql_num_rows($qpel3);


//baris ke
$kkx = 13 + $tpel + $tpel2;
$kkxx = $kkx;


$sheet->setCellValue('F'.$kkxx.'', ''.$ku_jenis.'');
$sheet->getStyle('F'.$kkxx.':M'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('F'.$kkxx.':M'.$kkxx.'')->applyFromArray( $style_data );




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



	$sheet->setCellValue('F'.$kkx2.'', ''.$jk.'');
	$sheet->setCellValue('G'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('G'.$kkx2.':H'.$kkx2.'');

	$sheet->getStyle('G'.$kkx2.':H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('G'.$kkx2.':H'.$kkx2.'')->applyFromArray( $style_data );
	

	//tingkat satu, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

		
	$sheet->setCellValue('I'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('I'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('J'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('K'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('L'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('L'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('M'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('M'.$kkx2.'')->applyFromArray( $style_data );






	//tingkat satu, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('O'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('O'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('P'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('P'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('Q'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('R'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('S'.$kkx2.'')->applyFromArray( $style_data );




	//tingkat dua, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('U'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('U'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('V'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('V'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('W'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('X'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('X'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('Y'.$kkx2.'')->applyFromArray( $style_data );


	//tingkat dua, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('AA'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('AA'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AB'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('AB'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AC'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('AC'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AD'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('AD'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AE'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('AE'.$kkx2.'')->applyFromArray( $style_data );

	
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
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
$rpel4 = mysql_fetch_assoc($qpel4);
$tpel4 = mysql_num_rows($qpel4);


//baris ke
$kkx = 15 + $tpel + $tpel2 + $tpel3;
$kkxx = $kkx;


$sheet->setCellValue('F'.$kkxx.'', ''.$ku_jenis.'');
$sheet->getStyle('F'.$kkxx.':M'.$kkxx.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$sheet->getStyle('F'.$kkxx.':M'.$kkxx.'')->applyFromArray( $style_data );




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



	$sheet->setCellValue('F'.$kkx2.'', ''.$jk.'');
	$sheet->setCellValue('G'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('G'.$kkx2.':H'.$kkx2.'');

	$sheet->getStyle('G'.$kkx2.':H'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('G'.$kkx2.':H'.$kkx2.'')->applyFromArray( $style_data );
	

	//tingkat satu, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

		
	$sheet->setCellValue('I'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('I'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('J'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('K'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('L'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('L'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('M'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('M'.$kkx2.'')->applyFromArray( $style_data );



	//tingkat satu, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('O'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('O'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('P'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('P'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('Q'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('R'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('S'.$kkx2.'')->applyFromArray( $style_data );



	//tingkat dua, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('U'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('U'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('V'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('V'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('W'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('X'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('X'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('Y'.$kkx2.'')->applyFromArray( $style_data );




	//tingkat dua, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('AA'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('AA'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AB'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('AB'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AC'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('AC'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AD'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('AD'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AE'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('AE'.$kkx2.'')->applyFromArray( $style_data );

	
	}
while ($rpel4 = mysql_fetch_assoc($qpel4));


	
	




//antar mapel ////////////////////////////////////////////////////////////////////////////////////////////////
//ketahui jumlah mapel
$qpel44 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd");
$rpel44 = mysql_fetch_assoc($qpel44);
$tpel44 = mysql_num_rows($qpel44);


//jml baris
$jmlbarisnya = $tpel44 + 4 + 11;

//tingkat satu, semester satu //////////////////////////////////////////////////////
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '1'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);

//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$stx_kd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);



$sheet->setCellValue('N11', ''.$catx_catatan.'');
$sheet->setCellValue('N'.$jmlbarisnya.'', '');
$sheet->mergeCells('N11:N'.$jmlbarisnya.'');
$sheet->getStyle('N11:N'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('N11:N'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('N11:N'.$jmlbarisnya.'')->applyFromArray( $style_data );




//tingkat satu, semester dua //////////////////////////////////////////////////////
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '2'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);

//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$stx_kd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);


$sheet->setCellValue('T11', ''.$catx_catatan.'');
$sheet->setCellValue('T'.$jmlbarisnya.'', '');
$sheet->mergeCells('T11:T'.$jmlbarisnya.'');
$sheet->getStyle('T11:T'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('T11:T'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('T11:T'.$jmlbarisnya.'')->applyFromArray( $style_data );




//tingkat dua, semester satu //////////////////////////////////////////////////////
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '1'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);

//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$stx_kd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);


$sheet->setCellValue('Z11', ''.$catx_catatan.'');
$sheet->setCellValue('Z'.$jmlbarisnya.'', '');
$sheet->mergeCells('Z11:Z'.$jmlbarisnya.'');
$sheet->getStyle('Z11:Z'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('Z11:Z'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('Z11:Z'.$jmlbarisnya.'')->applyFromArray( $style_data );





//tingkat dua, semester dua //////////////////////////////////////////////////////
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '2'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);

//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$stx_kd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);


$sheet->setCellValue('AF11', ''.$catx_catatan.'');
$sheet->setCellValue('AF'.$jmlbarisnya.'', '');
$sheet->mergeCells('AF11:AF'.$jmlbarisnya.'');
$sheet->getStyle('AF11:AF'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('AF11:AF'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('AF11:AF'.$jmlbarisnya.'')->applyFromArray( $style_data );











//ekstrakurikuler ///////////////////////////////////////////////////////////////////////////////////////////
//ketahui jumlah mapel
$qpel44 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd");
$rpel44 = mysql_fetch_assoc($qpel44);
$tpel44 = mysql_num_rows($qpel44);


//baris ke n
$barisnya = $tpel44 + 4 + 15;


//tingkat satu, semester satu
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);



$sheet->setCellValue('F'.$barisnya.'', 'No.');
$sheet->getStyle('F'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('G'.$barisnya.'', 'Kegiatan Ekstrakurikuler');
$sheet->mergeCells('G'.$barisnya.':H'.$barisnya.'');
$sheet->getStyle('G'.$barisnya.':H'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('I'.$barisnya.'', 'Nilai');
$sheet->getStyle('I'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('J'.$barisnya.'', 'Deskripsi');
$sheet->mergeCells('J'.$barisnya.':N'.$barisnya.'');
$sheet->getStyle('J'.$barisnya.':N'.$barisnya.'')->applyFromArray( $style_header );


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra, m_smt ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$dt_skkd' ".
						"AND siswa_ekstra.kd_smt = m_smt.kd ".
						"AND m_smt.no = '1' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);

do
	{	
	$uu = $uu + 1;
	$barisnyax = ($barisnya + $uu) - 1;
	
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);

	$sheet->setCellValue('F'.$barisnyax.'', ''.$uu.'');
	$sheet->getStyle('F'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$barisnyax.'', ''.$kuti_ekstra.'');
	$sheet->mergeCells('G'.$barisnyax.':H'.$barisnyax.'');
	$sheet->getStyle('G'.$barisnyax.':H'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('I'.$barisnyax.'', ''.$kuti_predikat.'');
	$sheet->getStyle('I'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('J'.$barisnyax.'', ''.$kuti_ket.'');
	$sheet->mergeCells('J'.$barisnyax.':N'.$barisnyax.'');
	$sheet->getStyle('J'.$barisnyax.':N'.$barisnyax.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));







//tingkat satu, semester dua
//baris ke n
$barisnya = $tpel44 + 4 + 15;


$sheet->setCellValue('O'.$barisnya.'', 'No.');
$sheet->getStyle('O'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('P'.$barisnya.'', 'Kegiatan Ekstrakurikuler');
$sheet->mergeCells('P'.$barisnya.':Q'.$barisnya.'');
$sheet->getStyle('P'.$barisnya.':Q'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('R'.$barisnya.'', 'Nilai');
$sheet->getStyle('R'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('S'.$barisnya.'', 'Deskripsi');
$sheet->mergeCells('S'.$barisnya.':T'.$barisnya.'');
$sheet->getStyle('S'.$barisnya.':T'.$barisnya.'')->applyFromArray( $style_header );

//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra, m_smt ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$dt_skkd' ".
						"AND siswa_ekstra.kd_smt = m_smt.kd ".
						"AND m_smt.no = '2' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);

do
	{	
	$uu2 = $uu2 + 1;
	$barisnyax = ($barisnya + $uu2) - 1;
	
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);
	
	$sheet->setCellValue('O'.$barisnyax.'', ''.$uu2.'');
	$sheet->getStyle('O'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('P'.$barisnyax.'', ''.$kuti_ekstra.'');
	$sheet->mergeCells('P'.$barisnyax.':Q'.$barisnyax.'');
	$sheet->getStyle('P'.$barisnyax.':Q'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$barisnyax.'', ''.$kuti_predikat.'');
	$sheet->getStyle('R'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$barisnyax.'', ''.$kuti_ket.'');
	$sheet->mergeCells('S'.$barisnyax.':T'.$barisnyax.'');
	$sheet->getStyle('S'.$barisnyax.':T'.$barisnyax.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));





//tingkat dua, semester satu
//baris ke n
$barisnya = $tpel44 + 4 + 15;

$sheet->setCellValue('U'.$barisnya.'', 'No.');
$sheet->getStyle('U'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('V'.$barisnya.'', 'Kegiatan Ekstrakurikuler');
$sheet->mergeCells('V'.$barisnya.':W'.$barisnya.'');
$sheet->getStyle('V'.$barisnya.':W'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('X'.$barisnya.'', 'Nilai');
$sheet->getStyle('X'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('Y'.$barisnya.'', 'Deskripsi');
$sheet->mergeCells('Y'.$barisnya.':Z'.$barisnya.'');
$sheet->getStyle('Y'.$barisnya.':Z'.$barisnya.'')->applyFromArray( $style_header );


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra, m_smt ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$dt_skkd' ".
						"AND siswa_ekstra.kd_smt = m_smt.kd ".
						"AND m_smt.no = '1' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);

do
	{	
	$uu3 = $uu3 + 1;
	$barisnyax = ($barisnya + $uu3) - 1;
	
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);
	
	
	$sheet->setCellValue('U'.$barisnyax.'', ''.$uu3.'');
	$sheet->getStyle('U'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('V'.$barisnyax.'', ''.$kuti_ekstra.'');
	$sheet->mergeCells('V'.$barisnyax.':W'.$barisnyax.'');
	$sheet->getStyle('V'.$barisnyax.':W'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('X'.$barisnyax.'', ''.$kuti_predikat.'');
	$sheet->getStyle('X'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$barisnyax.'', ''.$kuti_ket.'');
	$sheet->mergeCells('Y'.$barisnyax.':Z'.$barisnyax.'');
	$sheet->getStyle('Y'.$barisnyax.':Z'.$barisnyax.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));




//tingkat dua, semester dua
//baris ke n
$barisnya = $tpel44 + 4 + 15;


$sheet->setCellValue('AA'.$barisnya.'', 'No.');
$sheet->getStyle('AA'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('AB'.$barisnya.'', 'Kegiatan Ekstrakurikuler');
$sheet->mergeCells('AB'.$barisnya.':AC'.$barisnya.'');
$sheet->getStyle('AB'.$barisnya.':AC'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('AD'.$barisnya.'', 'Nilai');
$sheet->getStyle('AD'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('AE'.$barisnya.'', 'Deskripsi');
$sheet->mergeCells('AE'.$barisnya.':AF'.$barisnya.'');
$sheet->getStyle('AE'.$barisnya.':AF'.$barisnya.'')->applyFromArray( $style_header );

//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//datanya

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra, m_smt ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$dt_skkd' ".
						"AND siswa_ekstra.kd_smt = m_smt.kd ".
						"AND m_smt.no = '2' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);

do
	{	
	$uu4 = $uu4 + 1;
	$barisnyax = ($barisnya + $uu4) - 1;
	
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);
	
	$sheet->setCellValue('AA'.$barisnyax.'', ''.$uu4.'');
	$sheet->getStyle('AA'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AB'.$barisnyax.'', ''.$kuti_ekstra.'');
	$sheet->mergeCells('AB'.$barisnyax.':AC'.$barisnyax.'');
	$sheet->getStyle('AB'.$barisnyax.':AC'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AD'.$barisnyax.'', ''.$kuti_predikat.'');
	$sheet->getStyle('AD'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AE'.$barisnyax.'', ''.$kuti_ket.'');
	$sheet->mergeCells('AE'.$barisnyax.':AF'.$barisnyax.'');
	$sheet->getStyle('AE'.$barisnyax.':AF'.$barisnyax.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));












//pas foto
$barisnyax = $tpel44 + 4 + 30;
$barisnyax2 = $tpel44 + 4 + 30 + 4;
$sheet->setCellValue('G'.$barisnyax.'', '');
$sheet->setCellValue('G'.$barisnyax2.'', '');
$sheet->getStyle('G'.$barisnyax.':G'.$barisnyax2.'')->applyFromArray( $style_data );








$barisnyaxx = $tpel44 + 4 + 30 + 1;


//absensi semester satu
$sheet->setCellValue('I'.$barisnyax.'', 'No.');
$sheet->setCellValue('J'.$barisnyax.'', 'Ketidakhadiran');
$sheet->mergeCells('J'.$barisnyax.':N'.$barisnyax.'');
$sheet->getStyle('I'.$barisnyax.'')->applyFromArray( $style_header );
$sheet->getStyle('J'.$barisnyax.':N'.$barisnyax.'')->applyFromArray( $style_header );

//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

do
	{
	$mm = $mm + 1;
	$barisnyaxx1 = ($barisnyaxx + $mm) - 1;
	
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);


	//jika semester ganjil
	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_absensi = '$abs_kd' ".
							"AND round(DATE_FORMAT(tgl, '%m')) >= '7' ".
							"AND round(DATE_FORMAT(tgl, '%m')) <= '12'");
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


	$sheet->setCellValue('I'.$barisnyaxx1.'', ''.$mm.'.');
	$sheet->setCellValue('J'.$barisnyaxx1.'', ''.$abs_absensi.'');
	$sheet->setCellValue('M'.$barisnyaxx1.'', ''.$tbsix.'');
	$sheet->mergeCells('J'.$barisnyaxx1.':L'.$barisnyaxx1.'');
	$sheet->getStyle('I'.$barisnyaxx1.'')->applyFromArray( $style_data );
	$sheet->getStyle('J'.$barisnyaxx1.':N'.$barisnyaxx1.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));




//absensi semester dua
$sheet->setCellValue('O'.$barisnyax.'', 'No.');
$sheet->setCellValue('P'.$barisnyax.'', 'Ketidakhadiran');
$sheet->mergeCells('P'.$barisnyax.':T'.$barisnyax.'');
$sheet->getStyle('O'.$barisnyax.'')->applyFromArray( $style_header );
$sheet->getStyle('P'.$barisnyax.':T'.$barisnyax.'')->applyFromArray( $style_header );



//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

do
	{
	$mm2 = $mm2 + 1;
	$barisnyaxx1 = ($barisnyaxx + $mm2) - 1;
	
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);


	//jika semester genap
	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_absensi = '$abs_kd' ".
							"AND round(DATE_FORMAT(tgl, '%m')) >= '1' ".
							"AND round(DATE_FORMAT(tgl, '%m')) <= '6'");
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


	$sheet->setCellValue('O'.$barisnyaxx1.'', ''.$mm2.'.');
	$sheet->setCellValue('P'.$barisnyaxx1.'', ''.$abs_absensi.'');
	$sheet->setCellValue('S'.$barisnyaxx1.'', ''.$tbsix.'');
	$sheet->mergeCells('P'.$barisnyaxx1.':Q'.$barisnyaxx1.'');
	$sheet->getStyle('O'.$barisnyaxx1.'')->applyFromArray( $style_data );
	$sheet->getStyle('P'.$barisnyaxx1.':T'.$barisnyaxx1.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));






//absensi semester tiga
$sheet->setCellValue('U'.$barisnyax.'', 'No.');
$sheet->setCellValue('V'.$barisnyax.'', 'Ketidakhadiran');
$sheet->mergeCells('V'.$barisnyax.':Z'.$barisnyax.'');
$sheet->getStyle('U'.$barisnyax.'')->applyFromArray( $style_header );
$sheet->getStyle('V'.$barisnyax.':Z'.$barisnyax.'')->applyFromArray( $style_header );



//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

do
	{
	$mm3 = $mm3 + 1;
	$barisnyaxx1 = ($barisnyaxx + $mm3) - 1;
	
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);


	//jika semester ganjil
	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_absensi = '$abs_kd' ".
							"AND round(DATE_FORMAT(tgl, '%m')) >= '7' ".
							"AND round(DATE_FORMAT(tgl, '%m')) <= '12'");
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


	$sheet->setCellValue('U'.$barisnyaxx1.'', ''.$mm3.'.');
	$sheet->setCellValue('V'.$barisnyaxx1.'', ''.$abs_absensi.'');
	$sheet->setCellValue('Y'.$barisnyaxx1.'', ''.$tbsix.'');
	$sheet->mergeCells('Y'.$barisnyaxx1.':Z'.$barisnyaxx1.'');
	$sheet->getStyle('U'.$barisnyaxx1.'')->applyFromArray( $style_data );
	$sheet->getStyle('V'.$barisnyaxx1.':Z'.$barisnyaxx1.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));





//absensi semester empat
$sheet->setCellValue('AA'.$barisnyax.'', 'No.');
$sheet->setCellValue('AB'.$barisnyax.'', 'Ketidakhadiran');
$sheet->mergeCells('AB'.$barisnyax.':AF'.$barisnyax.'');
$sheet->getStyle('AA'.$barisnyax.'')->applyFromArray( $style_header );
$sheet->getStyle('AB'.$barisnyax.':AF'.$barisnyax.'')->applyFromArray( $style_header );


//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

do
	{
	$mm4 = $mm4 + 1;
	$barisnyaxx1 = ($barisnyaxx + $mm4) - 1;
	
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);


	//jika semester genap
	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_absensi = '$abs_kd' ".
							"AND round(DATE_FORMAT(tgl, '%m')) >= '1' ".
							"AND round(DATE_FORMAT(tgl, '%m')) <= '6'");
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


	$sheet->setCellValue('AA'.$barisnyaxx1.'', ''.$mm4.'.');
	$sheet->setCellValue('AB'.$barisnyaxx1.'', ''.$abs_absensi.'');
	$sheet->setCellValue('AE'.$barisnyaxx1.'', ''.$tbsix.'');
	$sheet->mergeCells('AE'.$barisnyaxx1.':AF'.$barisnyaxx1.'');
	$sheet->getStyle('AA'.$barisnyaxx1.'')->applyFromArray( $style_data );
	$sheet->getStyle('AB'.$barisnyaxx1.':AF'.$barisnyaxx1.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));







//kenaikan/kelulusan semester dua
$barisnyaxx1 = $tpel44 + 4 + 35 + 1;
$sheet->setCellValue('O'.$barisnyaxx1.'', 'Keputusan : ');
$sheet->mergeCells('O'.$barisnyaxx1.':T'.$barisnyaxx1.'');
$barisnyaxx2 = $tpel44 + 4 + 35 + 2;
$sheet->setCellValue('O'.$barisnyaxx2.'', 'Berdasarkan hasil yang dicapai pada  semester 1 dan 2');
$sheet->mergeCells('O'.$barisnyaxx2.':T'.$barisnyaxx2.'');


//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//kelas
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$dt_kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);



//naik...?
$qnuk = mysql_query("SELECT * FROM siswa_naik ".
						"WHERE kd_siswa_kelas = '$dt_skkd'");
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


$barisnyaxx3 = $tpel44 + 4 + 35 + 3;
$sheet->setCellValue('O'.$barisnyaxx3.'', 'peserta didik ditetapkan : '.$ket_naik.'');
$sheet->mergeCells('O'.$barisnyaxx3.':T'.$barisnyaxx3.'');

$sheet->getStyle('O'.$barisnyaxx1.':T'.$barisnyaxx3.'')->applyFromArray( $style_data );






//kenaikan/kelulusan semester empat
$barisnyaxx1 = $tpel44 + 4 + 35 + 1;
$sheet->setCellValue('AA'.$barisnyaxx1.'', 'Keputusan : ');
$sheet->mergeCells('AA'.$barisnyaxx1.':AF'.$barisnyaxx1.'');
$barisnyaxx2 = $tpel44 + 4 + 35 + 2;
$sheet->setCellValue('AA'.$barisnyaxx2.'', 'Berdasarkan hasil yang dicapai pada  semester 1 dan 2');
$sheet->mergeCells('AA'.$barisnyaxx2.':AF'.$barisnyaxx2.'');


//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//kelas
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$dt_kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);



//naik...?
$qnuk = mysql_query("SELECT * FROM siswa_naik ".
						"WHERE kd_siswa_kelas = '$dt_skkd'");
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


$barisnyaxx3 = $tpel44 + 4 + 35 + 3;
$sheet->setCellValue('AA'.$barisnyaxx3.'', 'peserta didik ditetapkan : '.$ket_naik.'');
$sheet->mergeCells('AA'.$barisnyaxx3.':AF'.$barisnyaxx3.'');

$sheet->getStyle('AA'.$barisnyaxx1.':AF'.$barisnyaxx3.'')->applyFromArray( $style_data );









//kepala sekolah
$qks = mysql_query("SELECT m_pegawai.* ".
						"FROM admin_ks, m_pegawai ".
						"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
$rks = mysql_fetch_assoc($qks);
$tks = mysql_num_rows($qks);
$ks_nip = nosql($rks['nip']);
$ks_nama = balikin($rks['nama']);



//tanda tangan kepala sekolah
$barisnyaxx1 = $tpel44 + 4 + 35 + 1;
$sheet->setCellValue('D'.$barisnyaxx1.'', ''.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'');
$barisnyaxx2 = $tpel44 + 4 + 35 + 2;
$sheet->setCellValue('D'.$barisnyaxx2.'', 'Kepala Sekolah');
$barisnyaxx3 = $tpel44 + 4 + 35 + 7;
$sheet->setCellValue('D'.$barisnyaxx3.'', ''.$ks_nama.'');
$barisnyaxx3 = $tpel44 + 4 + 35 + 8;
$sheet->setCellValue('D'.$barisnyaxx3.'', 'NIP.'.$ks_nip.'');





if (empty($e_filex))
	{
	$nil_foto = "../../img/foto_blank.jpg";
	}
else
	{
	$nil_foto = "../../filebox/siswa/$swkd/$e_filex";
	}
	

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('FOTO');
$objDrawing->setDescription('FOTO SISWA');
//$objDrawing->setPath('./images/phpexcel_logo.gif');       // filesystem reference for the image file
$objDrawing->setPath(''.$nil_foto.'');       // filesystem reference for the image file
//$objDrawing->setHeight(100);                 // sets the image height to 36px (overriding the actual image height); 
$objDrawing->setWidth(100);                 // sets the image height to 36px (overriding the actual image height);
$objDrawing->setCoordinates('G43');    // pins the top-left corner of the image to cell D24
$objDrawing->setOffsetX(0);                // pins the top left corner of the image at an offset of 10 points horizontally to the right of the top-left corner of the cell
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());














///////////////////////////////// SHEET KEDUA ///////////////////////////////////////////////////////////////
$objPHPExcel->createSheet();
$sheet = $objPHPExcel->setActiveSheetIndex(1)->setTitle('Hal 2');






//atur lebar kolom
$sheet->getColumnDimension('A')->setWidth(5);


//atur lebar baris
$sheet->getRowDimension('1')->setRowHeight(30);
$sheet->getRowDimension('6')->setRowHeight(20);





//header
$sheet->setCellValue('A1', 'BUKU INDUK PESERTA DIDIK');
$sheet->mergeCells('A1:AG1');
$sheet->getStyle("A1:AG1")->getFont()->setSize(24)->setBold(true)->setName('Arial Narrow');
$sheet->getStyle('A1:AG1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('AH1', 'TI/BM/PAR/KES');
$sheet->getStyle('AH1')->getAlignment()->setWrapText(true);






$sheet->setCellValue('A6', 'CAPAIAN KOMPETENSI');
$sheet->setCellValue('C6', '');
$sheet->mergeCells('A6:C6');
$sheet->getStyle("A6:C6")->getFont()->setSize(14)->setBold(true)->setName('Arial Narrow');


//semester satu
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);



$sheet->setCellValue('D3', 'Kelas');
$sheet->setCellValue('F3', ': '.$dt_kelku.'');
$sheet->setCellValue('G3', '');
$sheet->setCellValue('H3', '');
$sheet->setCellValue('I3', '');
$sheet->mergeCells('F3:I3');

$sheet->setCellValue('D4', 'Semester');
$sheet->setCellValue('F4', ': 1');
$sheet->setCellValue('G4', '');
$sheet->setCellValue('H4', '');
$sheet->setCellValue('I4', '');
$sheet->mergeCells('F4:I4');

$sheet->setCellValue('D5', 'Tahun Pelajaran');
$sheet->setCellValue('F5', ': '.$dt_tahun1.'/'.$dt_tahun2.'');
$sheet->setCellValue('G5', '');
$sheet->setCellValue('H5', '');
$sheet->setCellValue('I5', '');
$sheet->mergeCells('F5:I5');

$sheet->setCellValue('D6', 'Wali Kelas');
$sheet->setCellValue('F6', ': '.$nwk.'');
$sheet->setCellValue('G6', '');
$sheet->setCellValue('H6', '');
$sheet->setCellValue('I6', '');
$sheet->mergeCells('F6:I6');





//semester dua
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);


$sheet->setCellValue('J3', 'Kelas');
$sheet->setCellValue('K3', '');
$sheet->setCellValue('L3', ': '.$dt_kelku.'');
$sheet->setCellValue('M3', '');
$sheet->setCellValue('N3', '');
$sheet->setCellValue('O3', '');
$sheet->mergeCells('L3:O3');

$sheet->setCellValue('J4', 'Semester');
$sheet->setCellValue('K4', '');
$sheet->setCellValue('L4', ': 2');
$sheet->setCellValue('M4', '');
$sheet->setCellValue('N4', '');
$sheet->setCellValue('O4', '');
$sheet->mergeCells('L4:O4');

$sheet->setCellValue('J5', 'Tahun Pelajaran');
$sheet->setCellValue('K5', '');
$sheet->setCellValue('L5', ': '.$dt_tahun1.'/'.$dt_tahun2.'');
$sheet->setCellValue('M5', '');
$sheet->setCellValue('N5', '');
$sheet->setCellValue('O5', '');
$sheet->mergeCells('L5:O5');

$sheet->setCellValue('J6', 'Wali Kelas');
$sheet->setCellValue('K6', '');
$sheet->setCellValue('L6', ': '.$nwk.'');
$sheet->setCellValue('M6', '');
$sheet->setCellValue('N6', '');
$sheet->mergeCells('L6:O6');






//semester tiga
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);


$sheet->setCellValue('P3', 'Kelas');
$sheet->setCellValue('R3', ': '.$dt_kelku.'');
$sheet->setCellValue('S3', '');
$sheet->setCellValue('T3', '');
$sheet->setCellValue('U3', '');
$sheet->mergeCells('R3:U3');

$sheet->setCellValue('P4', 'Semester');
$sheet->setCellValue('R4', ': 1');
$sheet->setCellValue('S4', '');
$sheet->setCellValue('T4', '');
$sheet->setCellValue('U4', '');
$sheet->mergeCells('R4:U4');

$sheet->setCellValue('P5', 'Tahun Pelajaran');
$sheet->setCellValue('R5', ': '.$dt_tahun1.'/'.$dt_tahun2.'');
$sheet->setCellValue('S5', '');
$sheet->setCellValue('T5', '');
$sheet->setCellValue('U5', '');
$sheet->mergeCells('R5:U5');

$sheet->setCellValue('P6', 'Wali Kelas');
$sheet->setCellValue('R6', ': '.$nwk.'');
$sheet->setCellValue('S6', '');
$sheet->setCellValue('T6', '');
$sheet->setCellValue('U6', '');
$sheet->mergeCells('R6:U6');




//semester empat
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);



$sheet->setCellValue('V3', 'Kelas');
$sheet->setCellValue('X3', ': '.$dt_kelku.'');
$sheet->setCellValue('Y3', '');
$sheet->setCellValue('Z3', '');
$sheet->setCellValue('AA3', '');
$sheet->mergeCells('X3:AA3');

$sheet->setCellValue('V4', 'Semester');
$sheet->setCellValue('X4', ': 2');
$sheet->setCellValue('Y4', '');
$sheet->setCellValue('Z4', '');
$sheet->setCellValue('AA4', '');
$sheet->mergeCells('X4:AA4');

$sheet->setCellValue('V5', 'Tahun Pelajaran');
$sheet->setCellValue('X5', ': '.$dt_tahun1.'/'.$dt_tahun2.'');
$sheet->setCellValue('Y5', '');
$sheet->setCellValue('Z5', '');
$sheet->setCellValue('AA5', '');
$sheet->mergeCells('X5:AA5');

$sheet->setCellValue('V6', 'Wali Kelas');
$sheet->setCellValue('X6', ': '.$nwk.'');
$sheet->setCellValue('Y6', '');
$sheet->setCellValue('Z6', '');
$sheet->setCellValue('AA6', '');
$sheet->mergeCells('X6:AA6');








//smk............
//data diri
$qdt = mysql_query("SELECT siswa_kelas.*, ".
					"m_kelas.kelas AS kelku, ".
					"m_tapel.tahun1 AS tahun1, ".
					"m_tapel.tahun2 AS tahun2 ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_tapelkd = nosql($rdt['kd_tapel']);
$dt_kelkd = nosql($rdt['kd_kelas']);
$dt_kelku = balikin($rdt['kelku']);
$dt_tahun1 = balikin($rdt['tahun1']);
$dt_tahun2 = balikin($rdt['tahun2']);


//walikelas
$qwk = mysql_query("SELECT m_walikelas.*, m_pegawai.* ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_walikelas.kd_tapel = '$dt_tapelkd' ".
						"AND m_walikelas.kd_kelas = '$dt_kelkd'");
$rwk = mysql_fetch_assoc($qwk);
$nwk = balikin($rwk['nama']);



$sheet->setCellValue('AB3', 'SMK');
$sheet->setCellValue('AE3', ': '.$sek_nama.'');
$sheet->mergeCells('AE3:AH3');

$sheet->setCellValue('AB4', 'Keahlian');
$sheet->setCellValue('AE4', ': '.$keahlian.'');
$sheet->mergeCells('AE4:AH4');








//header raport semester satu
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






//header raport semester dua
$sheet->setCellValue('J8', 'Pengetahuan');
$sheet->setCellValue('K8', '');
$sheet->mergeCells('J8:K8');
$sheet->getStyle('J8:K8')->applyFromArray( $style_header );
$sheet->setCellValue('J9', 'Angka');
$sheet->getStyle('J9')->applyFromArray( $style_header );
$sheet->setCellValue('K9', 'Predikat');
$sheet->getStyle('K9')->applyFromArray( $style_header );
$sheet->setCellValue('J10', '1 - 4');
$sheet->getStyle('J10')->applyFromArray( $style_header );
$sheet->setCellValue('K10', 'A - D');
$sheet->getStyle('K10')->applyFromArray( $style_header );

$sheet->setCellValue('L8', 'Keterampilan');
$sheet->setCellValue('M8', '');
$sheet->mergeCells('L8:M8');
$sheet->getStyle('L8:M8')->applyFromArray( $style_header );
$sheet->setCellValue('L9', 'Angka');
$sheet->getStyle('L9')->applyFromArray( $style_header );
$sheet->setCellValue('M9', 'Predikat');
$sheet->getStyle('M9')->applyFromArray( $style_header );
$sheet->setCellValue('L10', '1 - 4');
$sheet->getStyle('L10')->applyFromArray( $style_header );
$sheet->setCellValue('M10', 'A - D');
$sheet->getStyle('M10')->applyFromArray( $style_header );

$sheet->setCellValue('N8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('O8', '');
$sheet->mergeCells('N8:O8');
$sheet->getStyle('N8:O8')->applyFromArray( $style_header );
$sheet->setCellValue('N9', 'Dalam Mapel');
$sheet->getStyle('N9')->getAlignment()->setWrapText(true);
$sheet->setCellValue('O9', 'Antar Mata Pelajaran');
$sheet->setCellValue('O10', '');
$sheet->mergeCells('O9:O10');
$sheet->getStyle('N9:O10')->applyFromArray( $style_header );
$sheet->getStyle('N9:O10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('N10', 'SB/B/C/K');
$sheet->getStyle('N9')->applyFromArray( $style_header );
$sheet->getStyle('N10')->applyFromArray( $style_header );

$sheet->getStyle('L8:N10')->applyFromArray( $style_header );




//header raport semester tiga
$sheet->setCellValue('P8', 'Pengetahuan');
$sheet->setCellValue('Q8', '');
$sheet->mergeCells('P8:Q8');
$sheet->getStyle('P8:Q8')->applyFromArray( $style_header );
$sheet->setCellValue('P9', 'Angka');
$sheet->getStyle('P9')->applyFromArray( $style_header );
$sheet->setCellValue('Q9', 'Predikat');
$sheet->getStyle('Q9')->applyFromArray( $style_header );
$sheet->setCellValue('P10', '1 - 4');
$sheet->getStyle('Q10')->applyFromArray( $style_header );
$sheet->setCellValue('Q10', 'A - D');
$sheet->getStyle('Q10')->applyFromArray( $style_header );

$sheet->setCellValue('R8', 'Keterampilan');
$sheet->setCellValue('S8', '');
$sheet->mergeCells('R8:S8');
$sheet->getStyle('R8:S8')->applyFromArray( $style_header );
$sheet->setCellValue('R9', 'Angka');
$sheet->getStyle('R9')->applyFromArray( $style_header );
$sheet->setCellValue('S9', 'Predikat');
$sheet->getStyle('S9')->applyFromArray( $style_header );
$sheet->setCellValue('R10', '1 - 4');
$sheet->getStyle('R10')->applyFromArray( $style_header );
$sheet->setCellValue('S10', 'A - D');
$sheet->getStyle('S10')->applyFromArray( $style_header );

$sheet->setCellValue('T8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('U8', '');
$sheet->mergeCells('T8:U8');
$sheet->getStyle('T8:U8')->applyFromArray( $style_header );
$sheet->setCellValue('T9', 'Dalam Mapel');
$sheet->getStyle('T9')->getAlignment()->setWrapText(true);
$sheet->setCellValue('U9', 'Antar Mata Pelajaran');
$sheet->setCellValue('U10', '');
$sheet->mergeCells('U9:U10');
$sheet->getStyle('T9:U10')->applyFromArray( $style_header );
$sheet->getStyle('T9:U10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('T10', 'SB/B/C/K');
$sheet->getStyle('U9')->applyFromArray( $style_header );
$sheet->getStyle('U10')->applyFromArray( $style_header );

$sheet->getStyle('A8:U10')->applyFromArray( $style_header );





//header raport semester empat
$sheet->setCellValue('V8', 'Pengetahuan');
$sheet->setCellValue('W8', '');
$sheet->mergeCells('V8:W8');
$sheet->getStyle('V8:W8')->applyFromArray( $style_header );
$sheet->setCellValue('V9', 'Angka');
$sheet->getStyle('V9')->applyFromArray( $style_header );
$sheet->setCellValue('W9', 'Predikat');
$sheet->getStyle('W9')->applyFromArray( $style_header );
$sheet->setCellValue('V10', '1 - 4');
$sheet->getStyle('V10')->applyFromArray( $style_header );
$sheet->setCellValue('W10', 'A - D');
$sheet->getStyle('W10')->applyFromArray( $style_header );

$sheet->setCellValue('X8', 'Keterampilan');
$sheet->setCellValue('Y8', '');
$sheet->mergeCells('X8:Y8');
$sheet->getStyle('X8:Y8')->applyFromArray( $style_header );
$sheet->setCellValue('X9', 'Angka');
$sheet->getStyle('X9')->applyFromArray( $style_header );
$sheet->setCellValue('Y9', 'Predikat');
$sheet->getStyle('Y9')->applyFromArray( $style_header );
$sheet->setCellValue('X10', '1 - 4');
$sheet->getStyle('X10')->applyFromArray( $style_header );
$sheet->setCellValue('Y10', 'A - D');
$sheet->getStyle('Y10')->applyFromArray( $style_header );

$sheet->setCellValue('Z8', 'Sikap Spiritual & Sosial');
$sheet->setCellValue('AA8', '');
$sheet->mergeCells('Z8:AA8');
$sheet->getStyle('Z8:AA8')->applyFromArray( $style_header );
$sheet->setCellValue('Z9', 'Dalam Mapel');
$sheet->getStyle('Z9')->getAlignment()->setWrapText(true);
$sheet->setCellValue('AA9', 'Antar Mata Pelajaran');
$sheet->setCellValue('AA10', '');
$sheet->mergeCells('AA9:AA10');
$sheet->getStyle('AA9:AA10')->applyFromArray( $style_header );
$sheet->getStyle('AA9:AA10')->getAlignment()->setWrapText(true);
$sheet->setCellValue('Z10', 'SB/B/C/K');
$sheet->getStyle('AA9')->applyFromArray( $style_header );
$sheet->getStyle('AA10')->applyFromArray( $style_header );

$sheet->getStyle('Z8:AA10')->applyFromArray( $style_header );








//smk.....
$sheet->setCellValue('AB8', 'Rata2 Nilai Raport');
$sheet->mergeCells('AB8:AC8');
$sheet->getStyle('AB8:AC8')->applyFromArray( $style_header );
$sheet->setCellValue('AB9', 'Angka');
$sheet->getStyle('AB9')->applyFromArray( $style_header );
$sheet->setCellValue('AC9', 'Predikat');
$sheet->getStyle('AC9')->applyFromArray( $style_header );
$sheet->setCellValue('AB10', '1 - 4');
$sheet->getStyle('AB10')->applyFromArray( $style_header );
$sheet->setCellValue('AC10', 'A - D');
$sheet->getStyle('AC10')->applyFromArray( $style_header );

$sheet->setCellValue('AD8', 'Ujian Sekolah');
$sheet->setCellValue('AE8', '');
$sheet->mergeCells('AD8:AE8');
$sheet->getStyle('AD8:AE8')->applyFromArray( $style_header );
$sheet->setCellValue('AD9', 'Angka');
$sheet->getStyle('AD9')->applyFromArray( $style_header );
$sheet->setCellValue('AE9', 'Predikat');
$sheet->getStyle('AE9')->applyFromArray( $style_header );
$sheet->setCellValue('AD10', '1 - 4');
$sheet->getStyle('AD10')->applyFromArray( $style_header );
$sheet->setCellValue('AE10', 'A - D');
$sheet->getStyle('AE10')->applyFromArray( $style_header );

$sheet->setCellValue('AF8', 'Nilai Sekolah');
$sheet->setCellValue('AG8', '');
$sheet->mergeCells('AF8:AG8');
$sheet->getStyle('AF8:AG8')->applyFromArray( $style_header );
$sheet->setCellValue('AF9', 'Angka');
$sheet->getStyle('AF9')->applyFromArray( $style_header );
$sheet->setCellValue('AG9', 'Predikat');
$sheet->getStyle('AG9')->applyFromArray( $style_header );
$sheet->setCellValue('AF10', '1 - 4');
$sheet->getStyle('AF10')->applyFromArray( $style_header );
$sheet->setCellValue('AG10', 'A - D');
$sheet->getStyle('AG10')->applyFromArray( $style_header );
$sheet->setCellValue('AH8', 'Ket.');
$sheet->mergeCells('AH8:AH10');
$sheet->getStyle('AH8:AH10')->applyFromArray( $style_header );











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

	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx2.'');

	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->applyFromArray( $style_data );
	


	//tingkat satu, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

	//catatan	
	$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd'");
	$rcatx = mysql_fetch_assoc($qcatx);
	$tcatx = mysql_num_rows($qcatx);
	$catx_catatan = balikin($rcatx['catatan']);
	
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
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
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );






	//tingkat satu, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('J'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('K'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('L'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('L'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('M'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('M'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('N'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('N'.$kkx2.'')->applyFromArray( $style_data );







	//tingkat dua, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('P'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('P'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('Q'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('R'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('S'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('T'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('T'.$kkx2.'')->applyFromArray( $style_data );






	//tingkat dua, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('V'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('V'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('W'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('X'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('Y'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Z'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('Z'.$kkx2.'')->applyFromArray( $style_data );





	//smk //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);


		

		
	//nil mapel
	$qxpel = mysql_query("SELECT AVG(siswa_nilai_raport.nil_raport_pengetahuan_a) AS rata1, ".
							"AVG(siswa_nilai_raport.nil_raport_ketrampilan_a) AS rata2 ".
							"FROM siswa_kelas, siswa_nilai_raport ".
							"WHERE siswa_nilai_raport.kd_siswa_kelas = siswa_kelas.kd ".
							"AND siswa_kelas.kd_siswa = '$swkd' ".
							"AND siswa_nilai_raport.kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['rata1']);
	$xpel_ketrampilan = nosql($rxpel['rata2']);
	$xpel_rata = round(($xpel_pengetahuan + $xpel_ketrampilan) / 2,2);


	$xpel_sikap = $xpel_rata;
	
	if ($xpel_sikap == "4.00")
		{
		$xpel_sikap_ket = "A";
		}
	else if (($xpel_sikap < "4.00") AND ($xpel_sikap >= "3.67"))
		{
		$xpel_sikap_ket = "A-";
		}
	else if (($xpel_sikap < "3.67") AND ($xpel_sikap >= "3.33"))
		{
		$xpel_sikap_ket = "B+";
		}
	else if (($xpel_sikap < "3.33") AND ($xpel_sikap >= "3.00"))
		{
		$xpel_sikap_ket = "B";
		}
	else if (($xpel_sikap < "3.00") AND ($xpel_sikap >= "2.67"))
		{
		$xpel_sikap_ket = "B-";
		}
	else if (($xpel_sikap < "2.67") AND ($xpel_sikap >= "2.33"))
		{
		$xpel_sikap_ket = "C+";
		}
	else if (($xpel_sikap < "2.33") AND ($xpel_sikap >= "2.00"))
		{
		$xpel_sikap_ket = "C";
		}
	else if (($xpel_sikap < "2.00") AND ($xpel_sikap >= "1.67"))
		{
		$xpel_sikap_ket = "C-";
		}
	else if (($xpel_sikap < "1.67") AND ($xpel_sikap >= "1.33"))
		{
		$xpel_sikap_ket = "D+";
		}
	else if (($xpel_sikap < "1.33") AND ($xpel_sikap >= "1.00"))
		{
		$xpel_sikap_ket = "D";
		}
	else 
		{
		$xpel_sikap_ket = "";
		}


	
	//rata nilai raport
	$sheet->setCellValue('AB'.$kkx2.'', ''.$xpel_rata.'');
	$sheet->getStyle('AB'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AC'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('AC'.$kkx2.'')->applyFromArray( $style_data );
	
	
	//update ke database
	$qxpel2 = mysql_query("SELECT * FROM siswa_nilai_rata ".
							"WHERE kd_siswa = '$swkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel2 = mysql_fetch_assoc($qxpel2);
	$txpel2 = mysql_num_rows($qxpel2);
	
	//jika null
	if (empty($txpel2))
		{
		mysql_query("INSERT INTO siswa_nilai_rata(kd, kd_siswa, kd_prog_pddkn, nilai, predikat, postdate) VALUES ".
						"('$xyz', '$swkd', '$pelkd', '$xpel_rata', '$xpel_sikap_ket', '$today')");	
		}
	else 
		{
		mysql_query("UPDATE siswa_nilai_rata SET nilai = '$xpel_rata', ".
						"predikat = '$xpel_sikap_ket', ".
						"postdate = '$today' ".
						"WHERE kd_siswa = '$swkd' ".
						"AND kd_prog_pddkn = '$pelkd'");
		}
	
	
	


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




	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx2.'');

	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->applyFromArray( $style_data );
	

	//tingkat satu, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
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
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );





	//tingkat satu, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);



	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('J'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('K'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('L'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('L'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('M'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('M'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('N'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('N'.$kkx2.'')->applyFromArray( $style_data );





	//tingkat dua, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);


	$sheet->setCellValue('P'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('P'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('Q'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('R'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('S'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('T'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('T'.$kkx2.'')->applyFromArray( $style_data );





	//tingkat dua, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	

	
		
	$sheet->setCellValue('V'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('V'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('W'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('X'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('Y'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Z'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('Z'.$kkx2.'')->applyFromArray( $style_data );





	//smk //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);


		
	//nil mapel
	$qxpel = mysql_query("SELECT AVG(siswa_nilai_raport.nil_raport_pengetahuan_a) AS rata1, ".
							"AVG(siswa_nilai_raport.nil_raport_ketrampilan_a) AS rata2 ".
							"FROM siswa_kelas, siswa_nilai_raport ".
							"WHERE siswa_nilai_raport.kd_siswa_kelas = siswa_kelas.kd ".
							"AND siswa_kelas.kd_siswa = '$swkd' ".
							"AND siswa_nilai_raport.kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['rata1']);
	$xpel_ketrampilan = nosql($rxpel['rata2']);
	$xpel_rata = round(($xpel_pengetahuan + $xpel_ketrampilan) / 2,2);


	$xpel_sikap = $xpel_rata;
	
	if ($xpel_sikap == "4.00")
		{
		$xpel_sikap_ket = "A";
		}
	else if (($xpel_sikap < "4.00") AND ($xpel_sikap >= "3.67"))
		{
		$xpel_sikap_ket = "A-";
		}
	else if (($xpel_sikap < "3.67") AND ($xpel_sikap >= "3.33"))
		{
		$xpel_sikap_ket = "B+";
		}
	else if (($xpel_sikap < "3.33") AND ($xpel_sikap >= "3.00"))
		{
		$xpel_sikap_ket = "B";
		}
	else if (($xpel_sikap < "3.00") AND ($xpel_sikap >= "2.67"))
		{
		$xpel_sikap_ket = "B-";
		}
	else if (($xpel_sikap < "2.67") AND ($xpel_sikap >= "2.33"))
		{
		$xpel_sikap_ket = "C+";
		}
	else if (($xpel_sikap < "2.33") AND ($xpel_sikap >= "2.00"))
		{
		$xpel_sikap_ket = "C";
		}
	else if (($xpel_sikap < "2.00") AND ($xpel_sikap >= "1.67"))
		{
		$xpel_sikap_ket = "C-";
		}
	else if (($xpel_sikap < "1.67") AND ($xpel_sikap >= "1.33"))
		{
		$xpel_sikap_ket = "D+";
		}
	else if (($xpel_sikap < "1.33") AND ($xpel_sikap >= "1.00"))
		{
		$xpel_sikap_ket = "D";
		}
	else 
		{
		$xpel_sikap_ket = "";
		}


	
	//rata nilai raport
	$sheet->setCellValue('AB'.$kkx2.'', ''.$xpel_rata.'');
	$sheet->getStyle('AB'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AC'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('AC'.$kkx2.'')->applyFromArray( $style_data );





	
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




	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx2.'');

	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->applyFromArray( $style_data );
	



	//tingkat satu, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
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
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );






	//tingkat satu, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('J'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('K'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('L'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('L'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('M'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('M'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('N'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('N'.$kkx2.'')->applyFromArray( $style_data );







	//tingkat dua, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('P'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('P'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('Q'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('R'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('S'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('T'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('T'.$kkx2.'')->applyFromArray( $style_data );



	//tingkat dua, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('V'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('V'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('W'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('X'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('Y'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Z'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('Z'.$kkx2.'')->applyFromArray( $style_data );





	//smk //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT AVG(siswa_nilai_raport.nil_raport_pengetahuan_a) AS rata1, ".
							"AVG(siswa_nilai_raport.nil_raport_ketrampilan_a) AS rata2 ".
							"FROM siswa_kelas, siswa_nilai_raport ".
							"WHERE siswa_nilai_raport.kd_siswa_kelas = siswa_kelas.kd ".
							"AND siswa_kelas.kd_siswa = '$swkd' ".
							"AND siswa_nilai_raport.kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['rata1']);
	$xpel_ketrampilan = nosql($rxpel['rata2']);
	$xpel_rata = round(($xpel_pengetahuan + $xpel_ketrampilan) / 2,2);


	$xpel_sikap = $xpel_rata;
	
	if ($xpel_sikap == "4.00")
		{
		$xpel_sikap_ket = "A";
		}
	else if (($xpel_sikap < "4.00") AND ($xpel_sikap >= "3.67"))
		{
		$xpel_sikap_ket = "A-";
		}
	else if (($xpel_sikap < "3.67") AND ($xpel_sikap >= "3.33"))
		{
		$xpel_sikap_ket = "B+";
		}
	else if (($xpel_sikap < "3.33") AND ($xpel_sikap >= "3.00"))
		{
		$xpel_sikap_ket = "B";
		}
	else if (($xpel_sikap < "3.00") AND ($xpel_sikap >= "2.67"))
		{
		$xpel_sikap_ket = "B-";
		}
	else if (($xpel_sikap < "2.67") AND ($xpel_sikap >= "2.33"))
		{
		$xpel_sikap_ket = "C+";
		}
	else if (($xpel_sikap < "2.33") AND ($xpel_sikap >= "2.00"))
		{
		$xpel_sikap_ket = "C";
		}
	else if (($xpel_sikap < "2.00") AND ($xpel_sikap >= "1.67"))
		{
		$xpel_sikap_ket = "C-";
		}
	else if (($xpel_sikap < "1.67") AND ($xpel_sikap >= "1.33"))
		{
		$xpel_sikap_ket = "D+";
		}
	else if (($xpel_sikap < "1.33") AND ($xpel_sikap >= "1.00"))
		{
		$xpel_sikap_ket = "D";
		}
	else 
		{
		$xpel_sikap_ket = "";
		}


	
	//rata nilai raport
	$sheet->setCellValue('AB'.$kkx2.'', ''.$xpel_rata.'');
	$sheet->getStyle('AB'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AC'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('AC'.$kkx2.'')->applyFromArray( $style_data );
	
	


	
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




	$sheet->setCellValue('A'.$kkx2.'', ''.$jk.'');
	$sheet->setCellValue('B'.$kkx2.'', ''.$pel.'');
	$sheet->mergeCells('B'.$kkx2.':C'.$kkx2.'');

	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('A'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->getStyle('B'.$kkx2.':C'.$kkx2.'')->applyFromArray( $style_data );
	


	//tingkat satu, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
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
	$sheet->getStyle('D'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('E'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('F'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('F'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('G'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('G'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('H'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('H'.$kkx2.'')->applyFromArray( $style_data );




	//tingkat satu, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '1'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	

	
	$sheet->setCellValue('J'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('J'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('K'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('L'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('L'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('M'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('M'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('N'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('N'.$kkx2.'')->applyFromArray( $style_data );







	//tingkat dua, semester satu //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '1'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	

	
	$sheet->setCellValue('P'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('P'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('Q'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('R'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('R'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('S'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('S'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('T'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('T'.$kkx2.'')->applyFromArray( $style_data );







	//tingkat dua, semester dua //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);

	//terpilih
	$qstx = mysql_query("SELECT * FROM m_smt ".
							"WHERE no = '2'");
	$rowstx = mysql_fetch_assoc($qstx);
	$stx_kd = nosql($rowstx['kd']);

		
		
	//nil mapel
	$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$stx_kd' ".
							"AND kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan_a']);
	$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan_a']);
	$xpel_pengetahuan_ket = balikin($rxpel['nil_raport_pengetahuan_p']);
	$xpel_ketrampilan_ket = balikin($rxpel['nil_raport_ketrampilan_p']);
	$xpel_sikap = nosql($rxpel['nil_raport_sikap_a']);
	$xpel_sikap_ket = balikin($rxpel['nil_raport_sikap_p']);

	
	$sheet->setCellValue('V'.$kkx2.'', ''.$xpel_pengetahuan.'');
	$sheet->getStyle('V'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_pengetahuan_ket.'');
	$sheet->getStyle('W'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$kkx2.'', ''.$xpel_ketrampilan.'');
	$sheet->getStyle('X'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Y'.$kkx2.'', ''.$xpel_ketrampilan_ket.'');
	$sheet->getStyle('Y'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Z'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('Z'.$kkx2.'')->applyFromArray( $style_data );





	//smk //////////////////////////////////////////////////////
	//data diri
	$qdt = mysql_query("SELECT siswa_kelas.* ".
						"FROM siswa_kelas, m_kelas, m_tapel ".
						"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
						"AND siswa_kelas.kd_tapel = m_tapel.kd ".
						"AND siswa_kelas.kd_siswa = '$swkd' ".
						"AND m_kelas.no = '2'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_skkd = nosql($rdt['kd']);


		
	//nil mapel
	$qxpel = mysql_query("SELECT AVG(siswa_nilai_raport.nil_raport_pengetahuan_a) AS rata1, ".
							"AVG(siswa_nilai_raport.nil_raport_ketrampilan_a) AS rata2 ".
							"FROM siswa_kelas, siswa_nilai_raport ".
							"WHERE siswa_nilai_raport.kd_siswa_kelas = siswa_kelas.kd ".
							"AND siswa_kelas.kd_siswa = '$swkd' ".
							"AND siswa_nilai_raport.kd_prog_pddkn = '$pelkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$xpel_pengetahuan = nosql($rxpel['rata1']);
	$xpel_ketrampilan = nosql($rxpel['rata2']);
	$xpel_rata = round(($xpel_pengetahuan + $xpel_ketrampilan) / 2,2);


	$xpel_sikap = $xpel_rata;
	
	if ($xpel_sikap == "4.00")
		{
		$xpel_sikap_ket = "A";
		}
	else if (($xpel_sikap < "4.00") AND ($xpel_sikap >= "3.67"))
		{
		$xpel_sikap_ket = "A-";
		}
	else if (($xpel_sikap < "3.67") AND ($xpel_sikap >= "3.33"))
		{
		$xpel_sikap_ket = "B+";
		}
	else if (($xpel_sikap < "3.33") AND ($xpel_sikap >= "3.00"))
		{
		$xpel_sikap_ket = "B";
		}
	else if (($xpel_sikap < "3.00") AND ($xpel_sikap >= "2.67"))
		{
		$xpel_sikap_ket = "B-";
		}
	else if (($xpel_sikap < "2.67") AND ($xpel_sikap >= "2.33"))
		{
		$xpel_sikap_ket = "C+";
		}
	else if (($xpel_sikap < "2.33") AND ($xpel_sikap >= "2.00"))
		{
		$xpel_sikap_ket = "C";
		}
	else if (($xpel_sikap < "2.00") AND ($xpel_sikap >= "1.67"))
		{
		$xpel_sikap_ket = "C-";
		}
	else if (($xpel_sikap < "1.67") AND ($xpel_sikap >= "1.33"))
		{
		$xpel_sikap_ket = "D+";
		}
	else if (($xpel_sikap < "1.33") AND ($xpel_sikap >= "1.00"))
		{
		$xpel_sikap_ket = "D";
		}
	else 
		{
		$xpel_sikap_ket = "";
		}



	
	//rata nilai raport
	$sheet->setCellValue('AB'.$kkx2.'', ''.$xpel_rata.'');
	$sheet->getStyle('AB'.$kkx2.'')->applyFromArray( $style_data );
	$sheet->setCellValue('AC'.$kkx2.'', ''.$xpel_sikap_ket.'');
	$sheet->getStyle('AC'.$kkx2.'')->applyFromArray( $style_data );
	


	}
while ($rpel4 = mysql_fetch_assoc($qpel4));


	
	



//antar mapel ////////////////////////////////////////////////////////////////////////////////////////////////
//ketahui jumlah mapel
$qpel44 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd");
$rpel44 = mysql_fetch_assoc($qpel44);
$tpel44 = mysql_num_rows($qpel44);


//jml baris
$jmlbarisnya = $tpel44 + 4 + 11;

//tingkat satu, semester satu //////////////////////////////////////////////////////
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '1'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);

//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$stx_kd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);



$sheet->setCellValue('I11', ''.$catx_catatan.'');
$sheet->setCellValue('I'.$jmlbarisnya.'', '');
$sheet->mergeCells('I11:I'.$jmlbarisnya.'');
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('I11:I'.$jmlbarisnya.'')->applyFromArray( $style_data );




//tingkat satu, semester dua //////////////////////////////////////////////////////
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '2'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);

//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$stx_kd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);


$sheet->setCellValue('O11', ''.$catx_catatan.'');
$sheet->setCellValue('O'.$jmlbarisnya.'', '');
$sheet->mergeCells('O11:O'.$jmlbarisnya.'');
$sheet->getStyle('O11:O'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('O11:O'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('O11:O'.$jmlbarisnya.'')->applyFromArray( $style_data );




//tingkat dua, semester satu //////////////////////////////////////////////////////
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '1'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);

//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$stx_kd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);


$sheet->setCellValue('U11', ''.$catx_catatan.'');
$sheet->setCellValue('U'.$jmlbarisnya.'', '');
$sheet->mergeCells('U11:U'.$jmlbarisnya.'');
$sheet->getStyle('U11:U'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('U11:U'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('U11:U'.$jmlbarisnya.'')->applyFromArray( $style_data );





//tingkat dua, semester dua //////////////////////////////////////////////////////
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '2'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);

//catatan	
$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$stx_kd'");
$rcatx = mysql_fetch_assoc($qcatx);
$tcatx = mysql_num_rows($qcatx);
$catx_catatan = balikin($rcatx['catatan']);


$sheet->setCellValue('AA11', ''.$catx_catatan.'');
$sheet->setCellValue('AA'.$jmlbarisnya.'', '');
$sheet->mergeCells('AA11:AA'.$jmlbarisnya.'');
$sheet->getStyle('AA11:AA'.$jmlbarisnya.'')->getAlignment()->setWrapText(true);
$sheet->getStyle('AA11:AA'.$jmlbarisnya.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$sheet->getStyle('AA11:AA'.$jmlbarisnya.'')->applyFromArray( $style_data );










//ekstrakurikuler ///////////////////////////////////////////////////////////////////////////////////////////
//ketahui jumlah mapel
$qpel44 = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS pelkd ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns  ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd");
$rpel44 = mysql_fetch_assoc($qpel44);
$tpel44 = mysql_num_rows($qpel44);


//baris ke n
$barisnya = $tpel44 + 4 + 15;


//tingkat satu, semester satu
//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);



$sheet->setCellValue('A'.$barisnya.'', 'No.');
$sheet->getStyle('A'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('B'.$barisnya.'', 'Kegiatan Ekstrakurikuler');
$sheet->mergeCells('B'.$barisnya.':C'.$barisnya.'');
$sheet->getStyle('B'.$barisnya.':C'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('D'.$barisnya.'', 'Nilai');
$sheet->getStyle('D'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('E'.$barisnya.'', 'Deskripsi');
$sheet->mergeCells('E'.$barisnya.':I'.$barisnya.'');
$sheet->getStyle('E'.$barisnya.':I'.$barisnya.'')->applyFromArray( $style_header );


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra, m_smt ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$dt_skkd' ".
						"AND siswa_ekstra.kd_smt = m_smt.kd ".
						"AND m_smt.no = '1' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);


//netralkan dahulu
$uu = 0;

do
	{	
	$uu = $uu + 1;
	$barisnyax = ($barisnya + $uu) - 1;
	
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);

	$sheet->setCellValue('A'.$barisnyax.'', ''.$uu.'');
	$sheet->getStyle('A'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('B'.$barisnyax.'', ''.$kuti_ekstra.'');
	$sheet->mergeCells('B'.$barisnyax.':C'.$barisnyax.'');
	$sheet->getStyle('B'.$barisnyax.':C'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('D'.$barisnyax.'', ''.$kuti_predikat.'');
	$sheet->getStyle('D'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$barisnyax.'', ''.$kuti_ket.'');
	$sheet->mergeCells('E'.$barisnyax.':I'.$barisnyax.'');
	$sheet->getStyle('E'.$barisnyax.':I'.$barisnyax.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));







//tingkat satu, semester dua
//baris ke n
$barisnya = $tpel44 + 4 + 15;


$sheet->setCellValue('J'.$barisnya.'', 'Nilai');
$sheet->getStyle('J'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('K'.$barisnya.'', 'Deskripsi');
$sheet->mergeCells('K'.$barisnya.':O'.$barisnya.'');
$sheet->getStyle('K'.$barisnya.':O'.$barisnya.'')->applyFromArray( $style_header );

//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra, m_smt ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$dt_skkd' ".
						"AND siswa_ekstra.kd_smt = m_smt.kd ".
						"AND m_smt.no = '2' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);


//netralkan dulu
$uu2 = 0;

do
	{	
	$uu2 = $uu2 + 1;
	$barisnyax = ($barisnya + $uu2) - 1;
	
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);
	
	$sheet->setCellValue('J'.$barisnyax.'', ''.$kuti_predikat.'');
	$sheet->getStyle('J'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('K'.$barisnyax.'', ''.$kuti_ket.'');
	$sheet->mergeCells('K'.$barisnyax.':O'.$barisnyax.'');
	$sheet->getStyle('K'.$barisnyax.':O'.$barisnyax.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));






//tingkat dua, semester satu
//baris ke n
$barisnya = $tpel44 + 4 + 15;


$sheet->setCellValue('P'.$barisnya.'', 'Nilai');
$sheet->getStyle('P'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('Q'.$barisnya.'', 'Deskripsi');
$sheet->mergeCells('Q'.$barisnya.':U'.$barisnya.'');
$sheet->getStyle('Q'.$barisnya.':U'.$barisnya.'')->applyFromArray( $style_header );


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra, m_smt ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$dt_skkd' ".
						"AND siswa_ekstra.kd_smt = m_smt.kd ".
						"AND m_smt.no = '1' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);


//netralkan
$uu3 = 0;

do
	{	
	$uu3 = $uu3 + 1;
	$barisnyax = ($barisnya + $uu3) - 1;
	
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);
	
	

	$sheet->setCellValue('P'.$barisnyax.'', ''.$kuti_predikat.'');
	$sheet->getStyle('P'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('Q'.$barisnyax.'', ''.$kuti_ket.'');
	$sheet->mergeCells('Q'.$barisnyax.':U'.$barisnyax.'');
	$sheet->getStyle('Q'.$barisnyax.':U'.$barisnyax.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));







//tingkat dua, semester dua
//baris ke n
$barisnya = $tpel44 + 4 + 15;


$sheet->setCellValue('V'.$barisnya.'', 'Nilai');
$sheet->getStyle('V'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('W'.$barisnya.'', 'Deskripsi');
$sheet->mergeCells('W'.$barisnya.':AA'.$barisnya.'');
$sheet->getStyle('W'.$barisnya.':AA'.$barisnya.'')->applyFromArray( $style_header );

//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//baris ke n
$barisnya = $tpel44 + 4 + 16;

//datanya

//daftar ekstra yang diikuti
$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra, m_smt ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$dt_skkd' ".
						"AND siswa_ekstra.kd_smt = m_smt.kd ".
						"AND m_smt.no = '2' ".
						"ORDER BY m_ekstra.ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);


//netralkan
$uu4 = 0;

do
	{	
	$uu4 = $uu4 + 1;
	$barisnyax = ($barisnya + $uu4) - 1;
	
	$kuti_kd = nosql($rkuti['sekd']);
	$kuti_ekstra = balikin($rkuti['ekstra']);
	$kuti_ekstrax = $kuti_ekstra;
	$kuti_predikat = nosql($rkuti['predikat']);
	$kuti_ket = balikin($rkuti['ket']);
	

	$sheet->setCellValue('V'.$barisnyax.'', ''.$kuti_predikat.'');
	$sheet->getStyle('V'.$barisnyax.'')->applyFromArray( $style_data );
	$sheet->setCellValue('W'.$barisnyax.'', ''.$kuti_ket.'');
	$sheet->mergeCells('W'.$barisnyax.':AA'.$barisnyax.'');
	$sheet->getStyle('W'.$barisnyax.':AA'.$barisnyax.'')->applyFromArray( $style_data );
	}
while ($rkuti = mysql_fetch_assoc($qkuti));





//nilai ujian nasional
//baris ke n
$barisnya = $tpel44 + 4 + 14;

$sheet->setCellValue('AB'.$barisnya.'', 'NILAI UJIAN NASIONAL');
$sheet->mergeCells('AB'.$barisnya.':AH'.$barisnya.'');
$sheet->getStyle('AB'.$barisnya.':AH'.$barisnya.'')->applyFromArray( $style_header );



//baris ke n
$barisnya = $tpel44 + 4 + 15;


$sheet->setCellValue('AB'.$barisnya.'', 'No.');
$sheet->getStyle('AB'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('AC'.$barisnya.'', 'Mata Pelajaran');
$sheet->mergeCells('AC'.$barisnya.':AE'.$barisnya.'');
$sheet->getStyle('AC'.$barisnya.':AE'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('AF'.$barisnya.'', 'Angka');
$sheet->getStyle('AF'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('AG'.$barisnya.'', 'Predikat');
$sheet->getStyle('AG'.$barisnya.'')->applyFromArray( $style_header );
$sheet->setCellValue('AH'.$barisnya.'', 'Ket');
$sheet->getStyle('AH'.$barisnya.'')->applyFromArray( $style_header );


//baris ke n
$barisnya = $tpel44 + 4 + 16;



//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = '$swkd'");
$rdt = mysql_fetch_assoc($qdt);
$dt_keahkd = nosql($rdt['kd_keahlian']);
$dt_kompkd = nosql($rdt['kd_keahlian_kompetensi']);












//pas foto
$barisnyax = $tpel44 + 4 + 17 + $tkuti;
$barisnyax2 = $tpel44 + 4 + 21 + $tkuti;
$sheet->setCellValue('B'.$barisnyax.'', '');
$sheet->setCellValue('B'.$barisnyax2.'', '');
$sheet->getStyle('B'.$barisnyax.':B'.$barisnyax2.'')->applyFromArray( $style_data );




$nil_foto = "../../filebox/siswa/$swkd/$e_filex";

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Foto Siswa');
$objDrawing->setDescription('Foto Siswa');
$objDrawing->setPath(''.$nil_foto.'');       
$objDrawing->setWidth(75);                 // sets the image height to 36px (overriding the actual image height);
$objDrawing->setCoordinates('B'.$barisnyax.'');    // pins the top-left corner of the image to cell D24
$objDrawing->setOffsetX(0);                // pins the top left corner of the image at an offset of 10 points horizontally to the right of the top-left corner of the cell
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());






$barisnyax2 = $tpel44 + 4 + 21 + $tkuti;


//absensi semester satu
$sheet->setCellValue('D'.$barisnyax.'', 'No.');
$sheet->setCellValue('E'.$barisnyax.'', 'Ketidakhadiran');
$sheet->mergeCells('E'.$barisnyax.':I'.$barisnyax.'');
$sheet->getStyle('D'.$barisnyax.'')->applyFromArray( $style_header );
$sheet->getStyle('E'.$barisnyax.':I'.$barisnyax.'')->applyFromArray( $style_header );

//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);


//netralkan
$mm = 0;

do
	{
	$mm = $mm + 1;
	$barisnyaxx1 = ($barisnyax2 + $mm) - 4;
	
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);


	//jika semester ganjil
	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_absensi = '$abs_kd' ".
							"AND round(DATE_FORMAT(tgl, '%m')) >= '7' ".
							"AND round(DATE_FORMAT(tgl, '%m')) <= '12'");
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


	$sheet->setCellValue('D'.$barisnyaxx1.'', ''.$mm.'.');
	$sheet->getStyle('D'.$barisnyaxx1.'')->applyFromArray( $style_data );
	$sheet->setCellValue('E'.$barisnyaxx1.'', ''.$abs_absensi.'');	
	$sheet->setCellValue('G'.$barisnyaxx1.'', ''.$tbsix.'');
	$sheet->mergeCells('G'.$barisnyaxx1.':I'.$barisnyaxx1.'');
	$sheet->getStyle('E'.$barisnyaxx1.':I'.$barisnyaxx1.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));




//absensi semester dua
$sheet->setCellValue('J'.$barisnyax.'', 'No.');
$sheet->setCellValue('K'.$barisnyax.'', 'Ketidakhadiran');
$sheet->mergeCells('K'.$barisnyax.':O'.$barisnyax.'');
$sheet->getStyle('J'.$barisnyax.'')->applyFromArray( $style_header );
$sheet->getStyle('K'.$barisnyax.':O'.$barisnyax.'')->applyFromArray( $style_header );



//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

//netralkan
$mm2 = 0;

do
	{
	$mm2 = $mm2 + 1;
	$barisnyaxx1 = ($barisnyax2 + $mm2) - 4;
	
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);


	//jika semester genap
	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_absensi = '$abs_kd' ".
							"AND round(DATE_FORMAT(tgl, '%m')) >= '1' ".
							"AND round(DATE_FORMAT(tgl, '%m')) <= '6'");
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


	$sheet->setCellValue('J'.$barisnyaxx1.'', ''.$mm2.'.');
	$sheet->setCellValue('K'.$barisnyaxx1.'', ''.$abs_absensi.'');
	$sheet->setCellValue('L'.$barisnyaxx1.'', ''.$tbsix.'');
	$sheet->mergeCells('K'.$barisnyaxx1.':O'.$barisnyaxx1.'');
	$sheet->getStyle('J'.$barisnyaxx1.'')->applyFromArray( $style_data );
	$sheet->getStyle('K'.$barisnyaxx1.':O'.$barisnyaxx1.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));








//absensi semester tiga
$sheet->setCellValue('P'.$barisnyax.'', 'No.');
$sheet->setCellValue('Q'.$barisnyax.'', 'Ketidakhadiran');
$sheet->mergeCells('Q'.$barisnyax.':U'.$barisnyax.'');
$sheet->getStyle('P'.$barisnyax.'')->applyFromArray( $style_header );
$sheet->getStyle('Q'.$barisnyax.':U'.$barisnyax.'')->applyFromArray( $style_header );



//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);


//netralkan
$mm3 = 0;

do
	{
	$mm3 = $mm3 + 1;
	$barisnyaxx1 = ($barisnyax2 + $mm3) - 4;
	
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);


	//jika semester ganjil
	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_absensi = '$abs_kd' ".
							"AND round(DATE_FORMAT(tgl, '%m')) >= '7' ".
							"AND round(DATE_FORMAT(tgl, '%m')) <= '12'");
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


	$sheet->setCellValue('P'.$barisnyaxx1.'', ''.$mm3.'.');
	$sheet->setCellValue('Q'.$barisnyaxx1.'', ''.$abs_absensi.'');
	$sheet->setCellValue('R'.$barisnyaxx1.'', ''.$tbsix.'');
	$sheet->mergeCells('Q'.$barisnyaxx1.':U'.$barisnyaxx1.'');
	$sheet->getStyle('P'.$barisnyaxx1.'')->applyFromArray( $style_data );
	$sheet->getStyle('Q'.$barisnyaxx1.':U'.$barisnyaxx1.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));





//absensi semester empat
$sheet->setCellValue('V'.$barisnyax.'', 'No.');
$sheet->setCellValue('W'.$barisnyax.'', 'Ketidakhadiran');
$sheet->mergeCells('W'.$barisnyax.':AA'.$barisnyax.'');
$sheet->getStyle('V'.$barisnyax.'')->applyFromArray( $style_header );
$sheet->getStyle('W'.$barisnyax.':AA'.$barisnyax.'')->applyFromArray( $style_header );


//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);


//netralkan
$mm4 = 0;

do
	{
	$mm4 = $mm4 + 1;
	$barisnyaxx1 = ($barisnyax2 + $mm4) - 4;
	
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);


	//jika semester genap
	//jml. absensi...
	$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_absensi = '$abs_kd' ".
							"AND round(DATE_FORMAT(tgl, '%m')) >= '1' ".
							"AND round(DATE_FORMAT(tgl, '%m')) <= '6'");
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


	$sheet->setCellValue('V'.$barisnyaxx1.'', ''.$mm4.'.');
	$sheet->setCellValue('W'.$barisnyaxx1.'', ''.$abs_absensi.'');
	$sheet->setCellValue('X'.$barisnyaxx1.'', ''.$tbsix.'');
	$sheet->mergeCells('W'.$barisnyaxx1.':AA'.$barisnyaxx1.'');
	$sheet->getStyle('V'.$barisnyaxx1.'')->applyFromArray( $style_data );
	$sheet->getStyle('W'.$barisnyaxx1.':AA'.$barisnyaxx1.'')->applyFromArray( $style_data );
	}
while ($rabs = mysql_fetch_assoc($qabs));








//kenaikan/kelulusan semester dua
$barisnyaxx1 = $tpel44 + 4 + 27 + $tkuti;
//$barisnyaxx1 = $tpel44 + 4 + 35 + 1;
$sheet->setCellValue('J'.$barisnyaxx1.'', 'Keputusan : ');
$sheet->mergeCells('J'.$barisnyaxx1.':O'.$barisnyaxx1.'');
$barisnyaxx2 = $tpel44 + 4 + 27 + $tkuti + 1;
//$barisnyaxx2 = $tpel44 + 4 + 35 + 2;
$sheet->setCellValue('J'.$barisnyaxx2.'', 'Berdasarkan hasil yang dicapai pada  semester 1 dan 2');
$sheet->mergeCells('j'.$barisnyaxx2.':O'.$barisnyaxx2.'');


//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '1'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//kelas
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$dt_kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);



//naik...?
$qnuk = mysql_query("SELECT * FROM siswa_naik ".
						"WHERE kd_siswa_kelas = '$dt_skkd'");
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



$barisnyaxx3 = $tpel44 + 4 + 27 + $tkuti + 2;
//$barisnyaxx3 = $tpel44 + 4 + 35 + 3;
$sheet->setCellValue('J'.$barisnyaxx3.'', 'peserta didik ditetapkan : '.$ket_naik.'');
$sheet->mergeCells('J'.$barisnyaxx3.':O'.$barisnyaxx3.'');

$sheet->getStyle('J'.$barisnyaxx1.':O'.$barisnyaxx3.'')->applyFromArray( $style_data );










//kenaikan/kelulusan semester empat
$barisnyaxx1 = $tpel44 + 4 + 27 + $tkuti;
//$barisnyaxx1 = $tpel44 + 4 + 35 + 1;
$sheet->setCellValue('V'.$barisnyaxx1.'', 'Keputusan : ');
$sheet->mergeCells('V'.$barisnyaxx1.':AA'.$barisnyaxx1.'');
$barisnyaxx2 = $tpel44 + 4 + 27 + $tkuti + 1;
$sheet->setCellValue('V'.$barisnyaxx2.'', 'Berdasarkan hasil yang dicapai pada  semester 1 dan 2');
$sheet->mergeCells('V'.$barisnyaxx2.':AA'.$barisnyaxx2.'');


//data diri
$qdt = mysql_query("SELECT siswa_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"AND m_kelas.no = '2'");
$rdt = mysql_fetch_assoc($qdt);
$dt_skkd = nosql($rdt['kd']);
$dt_kelkd = nosql($rdt['kd_kelas']);


//kelas
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$dt_kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);



//naik...?
$qnuk = mysql_query("SELECT * FROM siswa_naik ".
						"WHERE kd_siswa_kelas = '$dt_skkd'");
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


$barisnyaxx3 = $tpel44 + 4 + 27 + $tkuti + 2;
$sheet->setCellValue('V'.$barisnyaxx3.'', 'peserta didik ditetapkan : '.$ket_naik.'');
$sheet->mergeCells('V'.$barisnyaxx3.':AA'.$barisnyaxx3.'');

$sheet->getStyle('V'.$barisnyaxx1.':AA'.$barisnyaxx3.'')->applyFromArray( $style_data );

















//keterangan ijazah
$barisnyaxx1 = $tpel44 + 4 + 27 + $tkuti;
$sheet->setCellValue('AB'.$barisnyaxx1.'', 'KETERANGAN');
$sheet->mergeCells('AB'.$barisnyaxx1.':AD'.$barisnyaxx1.'');
$sheet->getStyle('AB'.$barisnyaxx1.':AD'.$barisnyaxx1.'')->applyFromArray( $style_header );
$sheet->setCellValue('AE'.$barisnyaxx1.'', 'IJAZAH');
$sheet->mergeCells('AE'.$barisnyaxx1.':AF'.$barisnyaxx1.'');
$sheet->getStyle('AE'.$barisnyaxx1.':AF'.$barisnyaxx1.'')->applyFromArray( $style_header );
$sheet->setCellValue('AG'.$barisnyaxx1.'', 'SKHUN');
$sheet->mergeCells('AG'.$barisnyaxx1.':AH'.$barisnyaxx1.'');
$sheet->getStyle('AG'.$barisnyaxx1.':AH'.$barisnyaxx1.'')->applyFromArray( $style_header );


//query
$qnil = mysql_query("SELECT m_siswa_perkembangan.*, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl, '%d') AS tgl, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl, '%m') AS bln, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl, '%Y') AS thn, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl_terima_ijazah, '%d') AS tgl_terima, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl_terima_ijazah, '%m') AS bln_terima, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl_terima_ijazah, '%Y') AS thn_terima, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl_ijazah, '%d') AS tgl_ijazah, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl_ijazah, '%m') AS bln_ijazah, ".
			"DATE_FORMAT(m_siswa_perkembangan.tgl_ijazah, '%Y') AS thn_ijazah, ".
			"siswa_kelas.* ".
			"FROM m_siswa_perkembangan, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa_perkembangan.kd_siswa ".
			"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_tgl_tinggal = nosql($rnil['tgl']);
$y_bln_tinggal = nosql($rnil['bln']);
$y_thn_tinggal = nosql($rnil['thn']);
$y_tgl_terima_ijazah = nosql($rnil['tgl_terima']);
$y_bln_terima_ijazah = nosql($rnil['bln_terima']);
$y_thn_terima_ijazah = nosql($rnil['thn_terima']);
$y_terima_tgl = "$y_tgl_terima_ijazah-$y_bln_terima_ijazah-$y_thn_terima_ijazah"; 
$y_tgl_ijazah = nosql($rnil['tgl_ijazah']);
$y_bln_ijazah = nosql($rnil['bln_ijazah']);
$y_thn_ijazah = nosql($rnil['thn_ijazah']);
$y_ijazah_tgl = "$y_tgl_ijazah-$y_bln_ijazah-$y_thn_ijazah"; 
$y_no_sttb = balikin2($rnil['no_sttb']);
$y_no_skhun = balikin2($rnil['no_skhun']);



$barisnyaxx1 = $tpel44 + 4 + 27 + $tkuti + 1;
$sheet->setCellValue('AB'.$barisnyaxx1.'', 'Nomor');
$sheet->setCellValue('AD'.$barisnyaxx1.'', ':');
$sheet->mergeCells('AB'.$barisnyaxx1.':AD'.$barisnyaxx1.'');
$sheet->getStyle('AB'.$barisnyaxx1.':AD'.$barisnyaxx1.'')->applyFromArray( $style_data );
$sheet->setCellValue('AE'.$barisnyaxx1.'', ''.$y_no_sttb.'');
$sheet->mergeCells('AE'.$barisnyaxx1.':AF'.$barisnyaxx1.'');
$sheet->getStyle('AE'.$barisnyaxx1.':AF'.$barisnyaxx1.'')->applyFromArray( $style_data );
$sheet->setCellValue('AG'.$barisnyaxx1.'', ''.$y_no_skhun.'');
$sheet->mergeCells('AG'.$barisnyaxx1.':AH'.$barisnyaxx1.'');
$sheet->getStyle('AG'.$barisnyaxx1.':AH'.$barisnyaxx1.'')->applyFromArray( $style_data );

$barisnyaxx1 = $tpel44 + 4 + 27 + $tkuti + 2;
$sheet->setCellValue('AB'.$barisnyaxx1.'', 'Tanggal');
$sheet->setCellValue('AD'.$barisnyaxx1.'', ':');
$sheet->mergeCells('AB'.$barisnyaxx1.':AD'.$barisnyaxx1.'');
$sheet->getStyle('AB'.$barisnyaxx1.':AD'.$barisnyaxx1.'')->applyFromArray( $style_data );
$sheet->setCellValue('AE'.$barisnyaxx1.'', ''.$y_ijazah_tgl.'');
$sheet->mergeCells('AE'.$barisnyaxx1.':AF'.$barisnyaxx1.'');
$sheet->getStyle('AE'.$barisnyaxx1.':AF'.$barisnyaxx1.'')->applyFromArray( $style_data );
$sheet->setCellValue('AG'.$barisnyaxx1.'', ''.$y_terima_tgl.'');
$sheet->mergeCells('AG'.$barisnyaxx1.':AH'.$barisnyaxx1.'');
$sheet->getStyle('AG'.$barisnyaxx1.':AH'.$barisnyaxx1.'')->applyFromArray( $style_data );





















//munculkan sheet pertama
$objPHPExcel->setActiveSheetIndex(0);









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
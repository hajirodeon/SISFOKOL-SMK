<?php
//session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");




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
						"AVG(siswa_nilai_raport.nil_raport_pengetahuan_a) AS total1, ".
						"AVG(siswa_nilai_raport.nil_raport_ketrampilan_a) AS total2 ".
						"FROM siswa_kelas, siswa_nilai_raport ".
						"WHERE siswa_nilai_raport.kd_siswa_kelas = siswa_kelas.kd ".
						"AND siswa_nilai_raport.kd_smt = '$smtkd' ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"ORDER BY round(siswa_nilai_raport.nil_raport_pengetahuan_a) DESC, ".
						"round(siswa_nilai_raport.nil_raport_ketrampilan_a) DESC");
$rdata = mysql_fetch_assoc($qdata);


do
	{
	//nilai
	$y_nomerr = $y_nomerr + 1;
	$xyz = md5("$x$y_nomerr");
	$y_skkd = nosql($rdata['skkd']);
	$y_total1 = nosql($rdata['total1']);
	$y_total2 = nosql($rdata['total2']);

	

	//totalnya
	$y_totalnya = round(($y_total1 + $y_total2) / 2,2);
	


	
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









//require
require('../../inc/class/excel/OLEwriter.php');
require('../../inc/class/excel/BIFFwriter.php');
require('../../inc/class/excel/worksheet.php');
require('../../inc/class/excel/workbook.php');




//header file
function HeaderingExcel($i_filename)
	{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$i_filename" );
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
	header("Pragma: public");
	}


//bikin...
HeaderingExcel($i_filename);
$workbook = new Workbook("-");
$worksheet1 =& $workbook->add_worksheet($i_judul);

$worksheet1->write_string(0,0,"LEDGER NILAI");
$worksheet1->write_string(1,0,"KELAS : $kelas. Tahun Pelajaran : $tapel. Semester : $smt_smt");



$worksheet1->set_column(0,0,5);
$worksheet1->set_column(0,1,15);
$worksheet1->set_column(0,2,35);


$worksheet1->write_string(6,0,"NO");
$worksheet1->merge_cells(6,0,10,0);

$worksheet1->write_string(6,1,"NIS");
$worksheet1->merge_cells(6,1,10,1);

$worksheet1->write_string(6,2,"NAMA");
$worksheet1->merge_cells(6,2,10,2);


/*
$worksheet1->write_string(1,3,"NIS");
$worksheet1->merge_cells(3,1,3,7);

$worksheet1->write_string(2,3,"NAMA");
$worksheet1->merge_cells(3,2,3,7);
*/


















//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
//						"WHERE no >= '5' ".
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
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas, m_prog_pddkn_jns ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = m_prog_pddkn_jns.kd ".
							"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
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
//			$pel = substr(balikin2($rpel['xpel']),0,35);
			$pel = balikin2($rpel['prog_pddkn']);
			$pel_kkm = nosql($rpel['kkm']);
	



			//guru
			$quru = mysql_query("SELECT m_pegawai.* ".
									"FROM m_guru_prog_pddkn, m_guru, m_pegawai ".
									"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
									"AND m_guru.kd_pegawai = m_pegawai.kd ".
									"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd' ".
									"AND m_guru.kd_tapel = '$tapelkd' ".
									"AND m_guru.kd_kelas = '$kelkd'");
			$ruru = mysql_fetch_assoc($quru);
			$nama_guru = balikin($ruru['nama']);

	
//			$i_nomer2 = $i_nomer2 + 6;
			$i_nomer2 = $i_nomer2 + 9;
			
			
//			$kolnom = $i_nomer2 - 2;
			$kolnom = ($i_nomer2 - 3) - 3;
//			$kolnom = $i_nomer2 - 3;
			$kolnom2 = $kolnom + 8;
			
			
			

			$worksheet1->write_string(7,$kolnom,"$pel");
			$worksheet1->merge_cells(7,$kolnom,7,$kolnom2);
			
			$worksheet1->write_string(8,$kolnom,"$nama_guru");
			$worksheet1->merge_cells(8,$kolnom,8,$kolnom2);
	




			//p-k-s
			$i_nomer22 = $i_nomer22 + 9;
			
			/*
			$kolnom = $i_nomer22 - 4;
			$kolnomm = $i_nomer22 - 2;
			$kolnom2 = $kolnomm + 1;
			$kolnom22 = $kolnom2 + 2;
			$kolnom3 = $kolnom22 + 1;
			$kolnom33 = $kolnom3 + 2;
*/

			$kolnom = ($i_nomer22 - 4) - 2;
			$kolnomm = ($i_nomer22 - 2) - 2;
			$kolnom2 = $kolnomm + 1;
			$kolnom22 = $kolnom2 + 2;
			$kolnom3 = $kolnom22 + 1;
			$kolnom33 = $kolnom3 + 2;
			
	


 			$worksheet1->write_string(9,$kolnom,"Pengetahuan");
			$worksheet1->merge_cells(9,$kolnom,9,$kolnomm);
			
			$worksheet1->write_string(9,$kolnom2,"Keterampilan");
			$worksheet1->merge_cells(9,$kolnom2,9,$kolnom22);
			
			$worksheet1->write_string(9,$kolnom3,"Sikap Spiritual dan Sosial");
			$worksheet1->merge_cells(9,$kolnom3,9,$kolnom33);
			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}


/*
	$i_nomere2 = $i_nomere2 + ($tpel * 6);
	

	//jika tpel null
	if (empty($tpel))
		{
		$kolnome = $i_nomere2 - ((1 * 6) - 3);
		$kolnome2 = $kolnome + (1 * 5) + (1 - 1);
		}
	else 
		{
		$kolnome = $i_nomere2 - (($tpel-1) * 6) - 3;
		$kolnome2 = $kolnome + ($tpel * 5) + ($tpel - 1);
		}

	*/

	
	$i_nomere2 = $i_nomere2 + ($tpel * 9);
	

	//jika tpel null
	if (empty($tpel))
		{
//		$kolnome = $i_nomere2 - ((1 * 9) - 3);
//		$kolnome2 = $kolnome + (1 * 8) + (1 - 1);
		$kolnome = $i_nomere2 - ((1 * 9) - 3) - 3;
		$kolnome2 = $kolnome + (1 * 8) + (1 - 1) - 3;

		}
	else 
		{
//		$kolnome = $i_nomere2 - (($tpel-1) * 9) - 3;
//		$kolnome2 = $kolnome + ($tpel * 8) + ($tpel - 1);
		$kolnome = $i_nomere2 - (($tpel-1) * 9) - 6;
		$kolnome2 = $kolnome + ($tpel * 8) + ($tpel - 1);
		}

		

	$worksheet1->write_string(6,$kolnome,"$jnsp_jenis $kolnomx");
//	$worksheet1->merge_cells(3,$kolnome,3,$kolnome2);

	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));







//angka - predikat
//query
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
//						"WHERE no >= '5' ".
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
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
							"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
							"ORDER BY m_prog_pddkn.prog_pddkn ASC");
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
	

	
	
			$i_nomer33 = $i_nomer33 + 9;
			
			
			
			
			//tiap kolom
			for ($k=1;$k<=9;$k++)
				{
				$kolnom = $i_nomer33 - 6;
				$kolnom2 = $kolnom + 1;
				$kolnom3 = $kolnom2 + 1;
				
				$kolnomm = ($i_nomer33 - 6) + 3;
				$kolnom22 = $kolnomm + 1;
				$kolnom23 = $kolnom22 + 1;
				
				$kolnommm = ($i_nomer33 - 6) + 6;
				$kolnom33 = $kolnommm + 1;
				$kolnom34 = $kolnom33 + 1;
				
				
				
				$worksheet1->write_string(10,$kolnom,"Angka");
				$worksheet1->write_string(10,$kolnom2,"Konv");
				$worksheet1->write_string(10,$kolnom3,"Pred");

				$worksheet1->write_string(10,$kolnomm,"Angka");
				$worksheet1->write_string(10,$kolnom22,"Konv");
				$worksheet1->write_string(10,$kolnom23,"Pred");

				$worksheet1->write_string(10,$kolnommm,"Angka");
				$worksheet1->write_string(10,$kolnom33,"Konv");
				$worksheet1->write_string(10,$kolnom34,"Pred");

				
				}


			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));






//ketahui kolom terakhir
$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"AND m_prog_pddkn.kd_jenis <> '' ".
						"ORDER BY m_prog_pddkn.prog_pddkn ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);


$kol_akhir = ($tpel * 9) + 3;
$kol_akhir2 = $kol_akhir + 1;
$kol_akhir3 = $kol_akhir + 2;
$kol_akhir4 = $kol_akhir + 3;
$kol_akhir4x = $kol_akhir4 + 2;

/*
$kol_akhir11 = $arrrkolom[$kol_akhir];
$kol_akhir12 = $arrrkolom[$kol_akhir2];
$kol_akhir13 = $arrrkolom[$kol_akhir3];
$kol_akhir14 = $arrrkolom[$kol_akhir4];
$kol_akhir14x = $arrrkolom[$kol_akhir4x];
*/


$worksheet1->write_string(7,$kol_akhir,"Jumlah Nilai");
$worksheet1->merge_cells(7,$kol_akhir,10,$kol_akhir);

$worksheet1->write_string(7,$kol_akhir2,"IPK");
$worksheet1->merge_cells(7,$kol_akhir2,10,$kol_akhir2);

$worksheet1->write_string(7,$kol_akhir3,"Rangking Kelas");
$worksheet1->merge_cells(7,$kol_akhir3,10,$kol_akhir3);





$worksheet1->write_string(7,$kol_akhir4,"Absensi");
//$sheet->setCellValue(''.$kol_akhir14.'3', 'Absensi');
//$sheet->mergeCells(''.$kol_akhir14.'3:'.$kol_akhir14x.'6');
$worksheet1->merge_cells(7,$kol_akhir4,9,$kol_akhir4x);
//$sheet->getStyle(''.$kol_akhir14.'3:'.$kol_akhir14x.'6')->applyFromArray( $style_header );


//daftar absensi
$qabs = mysql_query("SELECT * FROM m_absensi ".
					"ORDER BY absensi DESC");
$rabs = mysql_fetch_assoc($qabs);

do
	{
	//nilai
	$abs_no = $abs_no + 1;
	$abs_nil = nosql($rabs['absensi']);
	$kol_akhir4x = ($kol_akhir4 + $abs_no) - 1;
//	$kol_akhir14x = $arrrkolom[$kol_akhir4x];

//	$sheet->setCellValue(''.$kol_akhir14x.'7', ''.$abs_nil.'');
//	$sheet->getStyle(''.$kol_akhir14x.'7')->applyFromArray( $style_header );
	$worksheet1->write_string(10,$kol_akhir4x,"$abs_nil");
	}
while ($rabs = mysql_fetch_assoc($qabs));






//daftar ekstra
$qkuti = mysql_query("SELECT * FROM m_ekstra ".
						"ORDER BY ekstra ASC");
$rkuti = mysql_fetch_assoc($qkuti);
$tkuti = mysql_num_rows($qkuti);


//posisi
$kol_akhir5 = $kol_akhir + 4 + 2;
$kol_akhir15 = $arrrkolom[$kol_akhir5];
$kol_akhir5x = ($kol_akhir5 + $tkuti) - 1;
$kol_akhir15x = $arrrkolom[$kol_akhir5x];


//$sheet->setCellValue(''.$kol_akhir4.'3', 'Pengembangan Diri');
$worksheet1->write_string(7,$kol_akhir5,"Pengembangan Diri");
//$sheet->mergeCells(''.$kol_akhir15.'3:'.$kol_akhir15x.'6');
$worksheet1->merge_cells(7,$kol_akhir5,9,$kol_akhir5x);
//$sheet->getStyle(''.$kol_akhir15.'3:'.$kol_akhir15x.'6')->applyFromArray( $style_header );


do
	{
	$kuti_no = $kuti_no + 1;
	$kuti_ekstra = balikin($rkuti['ekstra']);
	
	$kol_akhir5x = ($kol_akhir5 + $kuti_no) - 1;
	$kol_akhir15x = $arrrkolom[$kol_akhir5x];

//	$sheet->setCellValue(''.$kol_akhir15x.'7', ''.$kuti_ekstra.'');
//	$sheet->getStyle(''.$kol_akhir15x.'7')->applyFromArray( $style_header );
	$worksheet1->write_string(10,$kol_akhir5x,"$kuti_ekstra");
	}
while ($rkuti = mysql_fetch_assoc($qkuti));





$kol_akhir16 = $kol_akhir5x + 1;
$worksheet1->write_string(7,$kol_akhir16,"Deskripsi Antar Mapel");
$worksheet1->merge_cells(7,$kol_akhir16,10,$kol_akhir16);




/*
$kol_akhir17 = $kol_akhir16 + 1;
$kol_akhir17x = $arrrkolom[$kol_akhir17];
//$sheet->setCellValue(''.$kol_akhir17x.'3', 'Saran Wali Kelas');
$worksheet1->write_string(7,$kol_akhir17,"Saran Wali Kelas");
//$sheet->mergeCells(''.$kol_akhir17x.'3:'.$kol_akhir17x.'7');
$worksheet1->merge_cells(7,$kol_akhir17,10,$kol_akhir17);
//$sheet->getStyle(''.$kol_akhir17x.'3:'.$kol_akhir17x.'7')->getAlignment()->setWrapText(true);
//$sheet->getStyle(''.$kol_akhir17x.'3:'.$kol_akhir17x.'7')->applyFromArray( $style_header );


*/






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


	$kk = $j + 10;
//	$kk2 = $j - 7;
	$kk2 = $j;

	
	$kk3 = $kk + 1;
	
	//kolom nilai							
//	$sheet->setCellValue('A'.$kk.'', ''.$kk2.'');
	$worksheet1->write_string($kk,0,"$kk2");
//	$sheet->setCellValue('B'.$kk.'', ''.$y_nis.'');
	$worksheet1->write_string($kk,1,"$y_nis");
//	$sheet->setCellValue('C'.$kk.'', ''.$y_nama.'');
	$worksheet1->write_string($kk,2,"$y_nama");
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
			$xpel_pengetahuan = nosql($rxpel['nil_raport_pengetahuan']);
			$xpel_pengetahuan_a = nosql($rxpel['nil_raport_pengetahuan_a']);
			$xpel_pengetahuan_p = balikin($rxpel['nil_raport_pengetahuan_p']);
			$xpel_ketrampilan = nosql($rxpel['nil_raport_ketrampilan']);
			$xpel_ketrampilan_a = nosql($rxpel['nil_raport_ketrampilan_a']);
			$xpel_ketrampilan_p = balikin($rxpel['nil_raport_ketrampilan_p']);
			$xpel_sikap = nosql($rxpel['nil_raport_sikap']);
			$xpel_sikap_a = nosql($rxpel['nil_raport_sikap_a']);
			$xpel_sikap_p = balikin($rxpel['nil_raport_sikap_p']);

			
			
			$klm = $klm + 1;
			
			
			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 9;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_pengetahuan");
			
			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 8;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_pengetahuan_a");
			
			
			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 7;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_pengetahuan_p");


			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 6;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_ketrampilan");
			
			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 5;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_ketrampilan_a");
			
			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 4;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_ketrampilan_p");
			


			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 3;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_sikap");

			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 2;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_sikap_a");			
			
			$bariske = 9 + $kz + 1;
			$kolomke = 3 + ($klm * 9) - (9 * ($kz - 1) * $tpel) - 1;
			$worksheet1->write_string($bariske,$kolomke,"$xpel_sikap_p");			
			
			

			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
				



	//jumlah total
	//nil mapel
	$qxpel = mysql_query("SELECT AVG(nil_raport_pengetahuan_a) AS total1, ".
							"AVG(nil_raport_ketrampilan_a) AS total2 ".
							"FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$y_skkd' ".
							"AND kd_smt = '$smtkd'");
	$rxpel = mysql_fetch_assoc($qxpel);
	$txpel = mysql_num_rows($qxpel);
	$totalku = nosql($rxpel['total1']);
	$totalku2 = nosql($rxpel['total2']);
	$totalnyax = $totalku + $totalku2;
	



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





	$kol_akhir = ($tpel * 9) + 3;
	$bariske = 9 + $kz + 1;
	$kol_akhir11 = $arrrkolom[$kol_akhir];
	
	$worksheet1->write_string($bariske,$kol_akhir,"$totalnyax");



	$kol_akhir = ($tpel * 9) + 4;
	$bariske = 9 + $kz + 1;
	$kol_akhir11 = $arrrkolom[$kol_akhir];
	
	$worksheet1->write_string($bariske,$kol_akhir,"$ipk");
	

	

	$kol_akhir = ($tpel * 9) + 5;
	$bariske = 9 + $kz + 1;
	$kol_akhir11 = $arrrkolom[$kol_akhir];
	
	$worksheet1->write_string($bariske,$kol_akhir,"$kunilx2_rangking");




	$kol_akhir = ($tpel * 9) + 6;
	$bariske = 9 + $kz + 1;
	$kol_akhir11 = $arrrkolom[$kol_akhir];

	//daftar absensi
	$qabs = mysql_query("SELECT * FROM m_absensi ".
							"ORDER BY absensi DESC");
	$rabs = mysql_fetch_assoc($qabs);
	$tabs = mysql_num_rows($qabs);
	
	do
		{
		//nilai
		$abs_no = $abs_no + 1;
		$abs_kd = nosql($rabs['kd']);
		$abs_nil = nosql($rabs['absensi']);
		$kol_akhir4x = ($kol_akhir + $abs_no) - ($tabs * $kz) - 1;
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
			
		
	
//		$sheet->setCellValue(''.$kol_akhir14x.''.$bariske.'', ''.$tbsi.'');
		$worksheet1->write_string($bariske,$kol_akhir4x,"$tbsi");
		}
	while ($rabs = mysql_fetch_assoc($qabs));







	$kol_akhir = ($tpel * 9) + 6 + $tabs;
	$bariske = 9 + $kz + 1;
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

		$kol_akhir4x = ($kol_akhir + $kuti_no) - ($tkuti * $kz) - 1;
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
	
//		$sheet->setCellValue(''.$kol_akhir14x.''.$bariske.'', ''.$kuti2_predikat.'');
		$worksheet1->write_string($bariske,$kol_akhir4x,"$kuti2_predikat");
		}
	while ($rkuti = mysql_fetch_assoc($qkuti));
	
	

	


	$kol_akhir = ($tpel * 9) + 6 + $tabs + $tkuti;
	$bariske = 9 + $kz + 1;
	$kol_akhir11 = $arrrkolom[$kol_akhir];
	
	//catatan
	$qcatx = mysql_query("SELECT * FROM siswa_catatan ".
							"WHERE kd_siswa_kelas = '$y_skkd' ".
							"AND kd_smt = '$smtkd'");
	$rcatx = mysql_fetch_assoc($qcatx);
	$tcatx = mysql_num_rows($qcatx);
	$catx_catatan = balikin($rcatx['catatan']);
	
	$worksheet1->write_string($bariske,$kol_akhir,"$catx_catatan");	



	}	
while ($rdata = mysql_fetch_assoc($qdata));






/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//close
$workbook->close();



//diskonek
xclose($koneksi);
exit();
?>
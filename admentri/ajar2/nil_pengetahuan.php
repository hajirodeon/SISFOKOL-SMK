<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admentri.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nil_pengetahuan.php";
$judul = "Penilaian Pengetahuan";
$judulku = "[$entri_session : $nip37_session.$nm37_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"skkd=$skkd&jnskd=$jnskd&progkd=$progkd&page=$page";

$limit = "50";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);


		//nilai
		$xnilruh = "nil_nh1";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_nh1 = $xnilruhxx;
		
		$xnilruh = "nil_nh2";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_nh2 = $xnilruhxx;
		
		$xnilruh = "nil_nh3";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_nh3 = $xnilruhxx;
		
		$xnilruh = "nil_nh4";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_nh4 = $xnilruhxx;

		
		
		$xnilruh = "nil_tugas1";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_tugas1 = $xnilruhxx;
		
		$xnilruh = "nil_tugas2";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_tugas2 = $xnilruhxx;
		
		$xnilruh = "nil_tugas3";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_tugas3 = $xnilruhxx;
		
		$xnilruh = "nil_tugas4";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_tugas4 = $xnilruhxx;
		

		

		$xnilnuts = "nil_nuts";
		$xnilnuts1 = "$xnilnuts$k";
		$xnilnutsxx = nosql($_POST["$xnilnuts1"]);

		$xnilnuas = "nil_nuas";
		$xnilnuas1 = "$xnilnuas$k";
		$xnilnuasxx = nosql($_POST["$xnilnuas1"]);



	
	



		//kumpulkan dulu ya.... nilai harian...
		//netralkan dulu
		mysql_query("DELETE FROM siswa_nh ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");

		mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'nh1', '$inil_nh1', '$today')");

		mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'nh2', '$inil_nh2', '$today')");
			
		mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'nh3', '$inil_nh3', '$today')");
			
		mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'nh4', '$inil_nh4', '$today')");
			

			
			
		//kumpulkan dulu ya.... nilai tugas...
		//netralkan dulu
		mysql_query("DELETE FROM siswa_tugas ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");

		mysql_query("INSERT INTO siswa_tugas(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'tugas1', '$inil_tugas1', '$today')");
						
		mysql_query("INSERT INTO siswa_tugas(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'tugas2', '$inil_tugas2', '$today')");
						
		mysql_query("INSERT INTO siswa_tugas(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'tugas3', '$inil_tugas3', '$today')");
						
		mysql_query("INSERT INTO siswa_tugas(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'tugas4', '$inil_tugas4', '$today')");
						
									
		

		



		//ke mysql
		$qcc = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_kelas.kd_tapel = '$tapelkd' ".
								"AND siswa_kelas.kd = '$xskkdxx'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//jika ada
		if ($tcc != 0)
			{
			//entry...
			$qcc1 = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$tcc1 = mysql_num_rows($qcc1);


			//jika ada, update
			if ($tcc1 != 0)
				{
				mysql_query("UPDATE siswa_nilai_raport SET rata_nh = '$rata_nh', ".
								"rata_tugas = '$rata_tugas', ".
								"nil_nh1 = '$inil_nh1', ".
								"nil_nh2 = '$inil_nh2', ".
								"nil_nh3 = '$inil_nh3', ".
								"nil_nh4 = '$inil_nh4', ".
								"nil_nh = '$rata_nh', ".
								"nil_tugas1 = '$inil_tugas1', ".
								"nil_tugas2 = '$inil_tugas2', ".
								"nil_tugas3 = '$inil_tugas3', ".
								"nil_tugas4 = '$inil_tugas4', ".
								"nil_tugas = '$rata_tugas', ".
								"nil_uts = '$xnilnutsxx', ".
								"nil_uas = '$xnilnuasxx', ".
								"nil_raport_pengetahuan = '$xpel_nil_nr', ".
								"nil_raport_pengetahuan_a = '$xnilraxx', ".
								"nil_k_pengetahuan = '$xnilctxx', ".
								"nil_raport_pengetahuan_p = '$xnilrpxx' ".
								"WHERE kd_siswa_kelas = '$xskkdxx' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
				}

			//jika blm ada, insert
			else
				{
				mysql_query("INSERT INTO siswa_nilai_raport(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nil_nh1, nil_nh2, nil_nh3, nil_nh4, ".
								"nil_tugas1, nil_tugas2, nil_tugas3, nil_tugas4, ".
								"nil_uts, nil_uas, nil_raport_pengetahuan, ".
								"nil_raport_pengetahuan_a, nil_raport_pengetahuan_p, nil_k_pengetahuan, postdate) VALUES ".
								"('$xyzb', '$xskkdxx', '$smtkd', '$progkd', ".
								"'$inil_nh1', '$inil_nh2', '$inil_nh3', '$inil_nh4', ".
								"'$inil_tugas1', '$inil_tugas2', '$inil_tugas3', '$inil_tugas4', ".
								"'$xnilnutsxx', '$xnilnuasxx', '$xpel_nil_nr', ".
								"'$xnilraxx', '$xnilrpxx', '$xnilctxx', '$today')");
				
				}



			//rata2 nh
			$qcc2 = mysql_query("SELECT AVG(nilai) AS rata_nh FROM siswa_nh ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd' ".
									"AND nilai <> '0' ".
									"AND nilai <> ''");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$cc2_nil_nh = nosql($rcc2['rata_nh']);
			
			//update lg...					
			mysql_query("UPDATE siswa_nilai_raport SET nil_nh = '$cc2_nil_nh' ".
							"WHERE kd_siswa_kelas = '$xskkdxx' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
								




			//rata2 nh
			$qcc2 = mysql_query("SELECT AVG(nilai) AS rata_tugas ".
									"FROM siswa_tugas ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd' ".
									"AND nilai <> '0' ".
									"AND nilai <> ''");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$cc2_rata_tugas = nosql($rcc2['rata_tugas']);
			
			
			$rata_nh = round(($cc2_nil_nh + $cc2_rata_tugas) / 2,2);





			//nilai akhir
			$xpel_nil1 = 2 * $cc2_nil_nh;
			$xpel_nil2 = $cc2_rata_tugas;
			$xpel_nil3 = (3 * $xnilnuasxx) + $xnilnutsxx;
			$xpel_nil_nr = round(($xpel_nil1 + $xpel_nil2 + $xpel_nil3) / 7,2);
		

	
	
			$xpel_nil_nr_a = round(($xpel_nil_nr / 100) * 4,2);
			
			
			//jika A
			if ($xpel_nil_nr_a >= "3.85")
				{
				$xpel_nil_nr_p = "A";
				} 
			
			//jika A-
			else if (($xpel_nil_nr_a >= "3.51") AND ($xpel_nil_nr_a <= "3.84"))
				{
				$xpel_nil_nr_p = "A-";
				} 
			
			//jika B+
			else if (($xpel_nil_nr_a >= "3.18") AND ($xpel_nil_nr_a <= "3.5"))
				{
				$xpel_nil_nr_p = "B+";
				}   
			
			//jika B
			else if (($xpel_nil_nr_a >= "2.85") AND ($xpel_nil_nr_a <= "3.17"))
				{
				$xpel_nil_nr_p = "B";
				}  
			
			//jika B-
			else if (($xpel_nil_nr_a >= "2.51") AND ($xpel_nil_nr_a <= "2.84"))
				{
				$xpel_nil_nr_p = "B-";
				}  
			
			//jika C+
			else if (($xpel_nil_nr_a >= "2.18") AND ($xpel_nil_nr_a <= "2.5"))
				{
				$xpel_nil_nr_p = "C+";
				}  
			
			//jika C
			else if (($xpel_nil_nr_a >= "1.85") AND ($xpel_nil_nr_a <= "2.17"))
				{
				$xpel_nil_nr_p = "C";
				}  
			
			//jika C-
			else if (($xpel_nil_nr_a >= "1.51") AND ($xpel_nil_nr_a <= "1.84"))
				{
				$xpel_nil_nr_p = "C-";
				}  
			
			//jika D+
			else if (($xpel_nil_nr_a >= "1.18") AND ($xpel_nil_nr_a <= "1.5"))
				{
				$xpel_nil_nr_p = "D+";
				} 
			
			//jika D
			else 
				{
				$xpel_nil_nr_p = "D";
				}  
			

			
			
			

			//update lg...					
			mysql_query("UPDATE siswa_nilai_raport SET rata_tugas = '$cc2_rata_tugas', ".
							"nil_tugas = '$cc2_rata_tugas', ".
							"rata_nh = '$rata_nh', ".
							"nil_raport_pengetahuan = '$xpel_nil_nr', ".
							"nil_raport_pengetahuan_a = '$xpel_nil_nr_a', ".
							"nil_raport_pengetahuan_p = '$xpel_nil_nr_p' ".
							"WHERE kd_siswa_kelas = '$xskkdxx' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");



			}



		}




	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";
	xloc($ke);
	exit();
	}










//reset
if ($_POST['btnRST'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);


		//nilai
		$xnilruh = "nil_nh1";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_nh1 = $xnilruhxx;
		
		$xnilruh = "nil_nh2";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_nh2 = $xnilruhxx;
		
		$xnilruh = "nil_nh3";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_nh3 = $xnilruhxx;
		
		$xnilruh = "nil_nh4";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_nh4 = $xnilruhxx;

		
		
		$xnilruh = "nil_tugas1";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_tugas1 = $xnilruhxx;
		
		$xnilruh = "nil_tugas2";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_tugas2 = $xnilruhxx;
		
		$xnilruh = "nil_tugas3";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_tugas3 = $xnilruhxx;
		
		$xnilruh = "nil_tugas4";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_tugas4 = $xnilruhxx;
		

		

		$xnilnuts = "nil_nuts";
		$xnilnuts1 = "$xnilnuts$k";
		$xnilnutsxx = nosql($_POST["$xnilnuts1"]);

		$xnilnuas = "nil_nuas";
		$xnilnuas1 = "$xnilnuas$k";
		$xnilnuasxx = nosql($_POST["$xnilnuas1"]);



	
	



		//kumpulkan dulu ya.... nilai harian...
		//netralkan dulu
		mysql_query("DELETE FROM siswa_nh ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");


			
			
		//kumpulkan dulu ya.... nilai tugas...
		//netralkan dulu
		mysql_query("DELETE FROM siswa_tugas ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");

		



		//ke mysql
		mysql_query("DELETE FROM siswa_nilai_raport ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");


		}




	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";
	xloc($ke);
	exit();
	}








//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jndks = nosql($_POST['jnskd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
	xloc($ke);
	exit();
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
		pekem($pesan,$ke);
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "file_importnya$kd.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);


			//re-direct
			$ke = "nil_pengetahuan_import.php?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&filex_namex2=$filex_namex2";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);



	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');



	//mapel e...
	$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$progkd'");
	$rowstdx = mysql_fetch_assoc($qstdx);
	$stdx_kd = nosql($rowstdx['kd']);
	$stdx_jnskd = nosql($rowstdx['kd_jenis']);
	$stdx_pel = strip(balikin($rowstdx['xpel']));


	//nama file e...
	$i_filename = "Nilai_Pengetahuan_$stdx_pel.xls";
	$i_judul = "Pengetahuan";





	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}

	
	
	
	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->write_string(0,0,"NO.");
	$worksheet1->write_string(0,1,"NIS");
	$worksheet1->write_string(0,2,"NAMA");
	$worksheet1->write_string(0,3,"UH_1");
	$worksheet1->write_string(0,4,"UH_2");
	$worksheet1->write_string(0,5,"UH_3");
	$worksheet1->write_string(0,6,"UH_4");
	$worksheet1->write_string(0,7,"RATA_UH");
	$worksheet1->write_string(0,8,"TUGAS_1");
	$worksheet1->write_string(0,9,"TUGAS_2");
	$worksheet1->write_string(0,10,"TUGAS_3");
	$worksheet1->write_string(0,11,"TUGAS_4");
	$worksheet1->write_string(0,12,"RATA_TUGAS");
	$worksheet1->write_string(0,13,"NH");
	$worksheet1->write_string(0,14,"NUTS");
	$worksheet1->write_string(0,15,"NUAS");
	$worksheet1->write_string(0,16,"NR");
	$worksheet1->write_string(0,17,"RAPORT_A");
	$worksheet1->write_string(0,18,"RAPORT_P");




	//data
	$qdt = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"ORDER BY m_siswa.nama ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_skkd = nosql($rdt['skkd']);
		$dt_no = nosql($rdt['no_absen']);
		$dt_nis = nosql($rdt['nis']);
		$dt_nama = balikin($rdt['nama']);

		//nil prog_pddkn
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$dt_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_nil_nh1 = nosql($rxpel['nil_nh1']);
		$xpel_nil_nh2 = nosql($rxpel['nil_nh2']);
		$xpel_nil_nh3 = nosql($rxpel['nil_nh3']);
		$xpel_nil_nh4 = nosql($rxpel['nil_nh4']);
		$xpel_rata_nh = nosql($rxpel['rata_nh']);
		$xpel_nil_tugas1 = nosql($rxpel['nil_tugas1']);
		$xpel_nil_tugas2 = nosql($rxpel['nil_tugas2']);
		$xpel_nil_tugas3 = nosql($rxpel['nil_tugas3']);
		$xpel_nil_tugas4 = nosql($rxpel['nil_tugas4']);
		$xpel_rata_tugas = nosql($rxpel['rata_tugas']);
		$xpel_nil_nh = nosql($rxpel['nil_nh']);
		$xpel_nil_uts = nosql($rxpel['nil_uts']);
		$xpel_nil_uas = nosql($rxpel['nil_uas']);
		$xpel_nil_raport = nosql($rxpel['nil_raport_pengetahuan']);
		$xpel_nil_raport_a = nosql($rxpel['nil_raport_pengetahuan_a']);
		$xpel_nil_raport_p = nosql($rxpel['nil_raport_pengetahuan_p']);


		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_nis);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$xpel_nil_nh1);
		$worksheet1->write_string($dt_nox,4,$xpel_nil_nh2);
		$worksheet1->write_string($dt_nox,5,$xpel_nil_nh3);
		$worksheet1->write_string($dt_nox,6,$xpel_nil_nh4);
		$worksheet1->write_string($dt_nox,7,$xpel_rata_nh);
		$worksheet1->write_string($dt_nox,8,$xpel_nil_tugas1);
		$worksheet1->write_string($dt_nox,9,$xpel_nil_tugas2);
		$worksheet1->write_string($dt_nox,10,$xpel_nil_tugas3);
		$worksheet1->write_string($dt_nox,11,$xpel_nil_tugas4);
		$worksheet1->write_string($dt_nox,12,$xpel_rata_tugas);
		$worksheet1->write_string($dt_nox,13,$xpel_nil_nh);
		$worksheet1->write_string($dt_nox,14,$xpel_nil_uts);
		$worksheet1->write_string($dt_nox,15,$xpel_nil_uas);
		$worksheet1->write_string($dt_nox,16,$xpel_nil_raport);
		$worksheet1->write_string($dt_nox,17,$xpel_nil_raport_a);
		$worksheet1->write_string($dt_nox,18,$xpel_nil_raport_p);
		
		}
	while ($rdt = mysql_fetch_assoc($qdt));



	//close
	$workbook->close();
	

	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd";	
	xloc($ke);
	exit();
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//focus....focus...
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}







//isi *START
ob_start();

//menu
require("../../inc/menu/admentri.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php?tapelkd='.$tapelkd.'" title="Daftar Mata Pelajaran">Daftar Mata Pelajaran</a>]</td>
</tr>
</table>


<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>,

Kelas : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>

</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mata Pelajaran : ';
//terpilih
$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd = '$progkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_jnskd = nosql($rowstdx['kd_jenis']);
$stdx_pel = balikin($rowstdx['prog_pddkn']);

//jenis
$qjnsx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"WHERE kd = '$stdx_jnskd'");
$rjnsx = mysql_fetch_assoc($qjnsx);
$tjnsx = mysql_num_rows($qjnsx);
$jnsx_jenis = balikin($rjnsx['jenis']);

echo '<strong>'.$jnsx_jenis.' --> '.$stdx_pel.'</strong>,

Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>,


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="jnskd" type="hidden" value="'.$stdx_jnskd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
</td>
</tr>
</table>
<br>';


//nek drg
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($progkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>MATA PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	//jika import
	if ($s == "import")
		{
		echo '<p>
		Silahkan Masukkan File yang akan Di-Import :
		<br>
		<input name="filex_xls" type="file" size="30">
		<br>
		<input name="s" type="hidden" value="'.$s.'">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnIM2" type="submit" value="IMPORT >>">
		</p>';
		}
	else
		{
		//daftar siswa
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"ORDER BY m_siswa.nama ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&jnskd=$jnskd&progkd=$progkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);



		echo '<input name="btnIM" type="submit" value="IMPORT">
		<input name="btnEX" type="submit" value="EXPORT">
		<table width="1200" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td><strong>NAMA</strong></td>
		<td width="50"><strong>UH1</strong></td>
		<td width="50"><strong>UH2</strong></td>
		<td width="50"><strong>UH3</strong></td>
		<td width="50"><strong>UH4</strong></td>
		<td width="50"><strong>RATA UH</strong></td>
		<td width="50"><strong>TUGAS1</strong></td>
		<td width="50"><strong>TUGAS2</strong></td>
		<td width="50"><strong>TUGAS3</strong></td>
		<td width="50"><strong>TUGAS4</strong></td>
		<td width="50"><strong>RATA TUGAS</strong></td>
		<td width="50"><strong>RATA NH</strong></td>
		<td width="50"><strong>N.UTS</strong></td>
		<td width="50"><strong>N.UAS</strong></td>
		<td width="50"><strong>N.A.P</strong></td>
		<td width="50"><strong>ANGKA</strong></td>
		<td width="50"><strong>HURUF</strong></td>
		</tr>';


		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			//nilainya
			$i_nomer = $i_nomer + 1;
			$i_skkd = nosql($data['skkd']);
			$i_nis = nosql($data['nis']);
			$i_nama = balikin($data['nama']);





			//nil mapel
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$i_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_nil_nh1 = nosql($rxpel['nil_nh1']);
			$xpel_nil_nh2 = nosql($rxpel['nil_nh2']);
			$xpel_nil_nh3 = nosql($rxpel['nil_nh3']);
			$xpel_nil_nh4 = nosql($rxpel['nil_nh4']);
			
			$xpel_nil_rata_uh = nosql($rxpel['nil_nh']);
			
			$xpel_nil_tugas1 = nosql($rxpel['nil_tugas1']);
			$xpel_nil_tugas2 = nosql($rxpel['nil_tugas2']);
			$xpel_nil_tugas3 = nosql($rxpel['nil_tugas3']);
			$xpel_nil_tugas4 = nosql($rxpel['nil_tugas4']);
			$xpel_nil_rata_tugas = nosql($rxpel['rata_tugas']);
			
			$xpel_nil_rata_nh = nosql($rxpel['rata_nh']);
			$xpel_nil_nuts = nosql($rxpel['nil_uts']);
			$xpel_nil_nuas = nosql($rxpel['nil_uas']);
			
			$xpel_nil_nr = nosql($rxpel['nil_raport_pengetahuan']);
			$xpel_nil_nr_a = nosql($rxpel['nil_raport_pengetahuan_a']);
			$xpel_nil_nr_p = balikin($rxpel['nil_raport_pengetahuan_p']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input name="skkd'.$i_nomer.'" type="hidden" value="'.$i_skkd.'">
			'.$i_nis.'
			</td>
			<td>
			'.$i_nama.'
			</td>


			<td>
			<input name="nil_nh1'.$i_nomer.'" type="text" value="'.$xpel_nil_nh1.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_nh2'.$i_nomer.'" type="text" value="'.$xpel_nil_nh2.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_nh3'.$i_nomer.'" type="text" value="'.$xpel_nil_nh3.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_nh4'.$i_nomer.'" type="text" value="'.$xpel_nil_nh4.'" size="3" style="text-align:right">
			</td>



			<td>
			<input name="nil_rata_uh'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_uh.'" size="3" style="text-align:right" class="input" readonly>
			</td>


			<td>
			<input name="nil_tugas1'.$i_nomer.'" type="text" value="'.$xpel_nil_tugas1.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_tugas2'.$i_nomer.'" type="text" value="'.$xpel_nil_tugas2.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_tugas3'.$i_nomer.'" type="text" value="'.$xpel_nil_tugas3.'" size="3" style="text-align:right">
			</td>
			
			<td>
			<input name="nil_tugas4'.$i_nomer.'" type="text" value="'.$xpel_nil_tugas4.'" size="3" style="text-align:right">
			</td>
			

			<td>
			<input name="nil_rata_tugas'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_tugas.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			
			<td>
			<input name="nil_rata_nh'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_nh.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_nuts'.$i_nomer.'" type="text" value="'.$xpel_nil_nuts.'" size="3" style="text-align:right">
			</td>
			<td>
			<input name="nil_nuas'.$i_nomer.'" type="text" value="'.$xpel_nil_nuas.'" size="3" style="text-align:right">
			</td>
			<td>
			<input name="nil_raport'.$i_nomer.'" type="text" value="'.$xpel_nil_nr.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport_a'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_a.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport_p'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_p.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));


		echo '</table>
		<table width="800" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="page" type="hidden" value="'.$page.'">
		'.$pagelist.'
		
		
		<input name="btnRST" type="submit" value="HAPUS SEMUA">
		</td>
		</tr>
		</table>';
		}
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>

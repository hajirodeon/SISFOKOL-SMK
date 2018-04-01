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
$filenya = "nil_ketrampilan.php";
$judul = "Penilaian Ketrampilan";
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
		$xnilnp = "nil_praktek1";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_praktek1 = $xnilnpxx;
		
		$xnilnp = "nil_praktek2";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_praktek2 = $xnilnpxx;
		
		$xnilnp = "nil_praktek3";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_praktek3 = $xnilnpxx;
		
		$xnilnp = "nil_praktek4";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_praktek4 = $xnilnpxx;


		
		$xnilnp = "nil_proyek1";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_proyek1 = $xnilnpxx;
		
		$xnilnp = "nil_proyek2";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_proyek2 = $xnilnpxx;
		
		$xnilnp = "nil_proyek3";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_proyek3 = $xnilnpxx;
		
		$xnilnp = "nil_proyek4";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_proyek4 = $xnilnpxx;
		

		
		$xnilnp = "nil_folio1";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_folio1 = $xnilnpxx;
		
		$xnilnp = "nil_folio2";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_folio2 = $xnilnpxx;
		
		$xnilnp = "nil_folio3";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_folio3 = $xnilnpxx;
		
		$xnilnp = "nil_folio4";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_folio4 = $xnilnpxx;

		
		
		
		$xnilnp = "nil_ulangan";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_ulangan = $xnilnpxx;
		
	
	
	
	
	


		//kumpulkan dulu ya.... nilai praktek...
		//netralkan dulu
		mysql_query("DELETE FROM siswa_praktek ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");

		mysql_query("INSERT INTO siswa_praktek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'praktek1', '$inil_praktek1', '$today')");

		mysql_query("INSERT INTO siswa_praktek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'praktek2', '$inil_praktek2', '$today')");

		mysql_query("INSERT INTO siswa_praktek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'praktek3', '$inil_praktek3', '$today')");
						
		mysql_query("INSERT INTO siswa_praktek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'praktek4', '$inil_praktek4', '$today')");
						
	



		//kumpulkan dulu ya.... nilai proyek...
		//netralkan dulu
		mysql_query("DELETE FROM siswa_proyek ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");

		mysql_query("INSERT INTO siswa_proyek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'proyek1', '$inil_proyek1', '$today')");

		mysql_query("INSERT INTO siswa_proyek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'proyek2', '$inil_proyek2', '$today')");

		mysql_query("INSERT INTO siswa_proyek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'proyek3', '$inil_proyek3', '$today')");

		mysql_query("INSERT INTO siswa_proyek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'proyek4', '$inil_proyek4', '$today')");

	

	
	
	
		//kumpulkan dulu ya.... nilai folio...
		//netralkan dulu
		mysql_query("DELETE FROM siswa_folio ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");

		mysql_query("INSERT INTO siswa_folio(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'folio1', '$inil_folio1', '$today')");

		mysql_query("INSERT INTO siswa_folio(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'folio2', '$inil_folio2', '$today')");

		mysql_query("INSERT INTO siswa_folio(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'folio3', '$inil_folio3', '$today')");

		mysql_query("INSERT INTO siswa_folio(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'folio4', '$inil_folio4', '$today')");
						
	
	
		
	
	
	
	
		

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
				mysql_query("UPDATE siswa_nilai_raport SET nil_praktek1 = '$inil_praktek1', ".
								"nil_praktek2 = '$inil_praktek2', ".
								"nil_praktek3 = '$inil_praktek3', ".
								"nil_praktek4 = '$inil_praktek4', ".
								"rata_praktek = '$xnilnpxx', ".
								"nil_folio1 = '$inil_folio1', ".
								"nil_folio2 = '$inil_folio2', ".
								"nil_folio3 = '$inil_folio3', ".
								"nil_folio4 = '$inil_folio4', ".
								"rata_folio = '$inil_folio_rata', ".
								"nil_proyek1 = '$inil_proyek1', ".
								"nil_proyek2 = '$inil_proyek2', ".
								"nil_proyek3 = '$inil_proyek3', ".
								"nil_proyek4 = '$inil_proyek4', ".
								"rata_proyek = '$inil_proyek_rata', ".
								"nil_praktek = '$inil_ulangan', ".
								"nil_raport_ketrampilan = '$xnilnrxx', ".
								"nil_raport_ketrampilan_a = '$xnilnraxx', ".
								"nil_raport_ketrampilan_p = '$xnilnrpxx' ".
								"WHERE kd_siswa_kelas = '$xskkdxx' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
				}

			//jika blm ada, insert
			else
				{
				mysql_query("INSERT INTO siswa_nilai_raport(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nil_praktek1, nil_praktek2, nil_praktek3, nil_praktek4, rata_praktek, ".
								"nil_folio1, nil_folio2, nil_folio3, nil_folio4, rata_folio, ".
								"nil_proyek1, nil_proyek2, nil_proyek3, nil_proyek4, rata_proyek, ".
								"nil_praktek, nil_raport_ketrampilan, nil_raport_ketrampilan_a, nil_raport_ketrampilan_p, postdate) VALUES ".
								"('$xyzb', '$xskkdxx', '$smtkd', '$progkd', ".
								"'$inil_praktek1', '$inil_praktek2', '$inil_praktek3', '$inil_praktek4', '$inil_praktek_rata', ".
								"'$inil_folio1', '$inil_folio2', '$inil_folio3', '$inil_folio4', '$inil_folio_rata', ".
								"'$inil_proyek1', '$inil_proyek2', '$inil_proyek3', '$inil_proyek3', '$inil_proyek_rata', ".
								"'$inil_ulangan', '$xnilnrxx', '$xnilnraxx', '$xnilnrpxx', '$today')");
				}
				
				
				
				
				

			//rata2 praktek
			$qcc2 = mysql_query("SELECT AVG(nilai) AS rataku FROM siswa_praktek ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd' ".
									"AND nilai <> '0' ".
									"AND nilai <> ''");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$cc2_praktek = nosql($rcc2['rataku']);
			
			//update lg...					
			mysql_query("UPDATE siswa_nilai_raport SET rata_praktek = '$cc2_praktek' ".
							"WHERE kd_siswa_kelas = '$xskkdxx' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");




			//rata2 proyek
			$qcc2 = mysql_query("SELECT AVG(nilai) AS rataku FROM siswa_proyek ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd' ".
									"AND nilai <> '0' ".
									"AND nilai <> ''");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$cc2_proyek = nosql($rcc2['rataku']);
			
			//update lg...					
			mysql_query("UPDATE siswa_nilai_raport SET rata_proyek = '$cc2_proyek' ".
							"WHERE kd_siswa_kelas = '$xskkdxx' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");




			//rata2 folio
			$qcc2 = mysql_query("SELECT AVG(nilai) AS rataku FROM siswa_folio ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd' ".
									"AND nilai <> '0' ".
									"AND nilai <> ''");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$cc2_folio = nosql($rcc2['rataku']);
			
			//update lg...					
			mysql_query("UPDATE siswa_nilai_raport SET rata_folio = '$cc2_folio' ".
							"WHERE kd_siswa_kelas = '$xskkdxx' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");

							
				
				
				
				
				
					
			//nilai akhir
			$xpel_nil_nr = round(((2 * $cc2_praktek) + (3 * $cc2_proyek) + $cc2_folio + (2 * $inil_ulangan)) / 8,2);
	
		
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
			mysql_query("UPDATE siswa_nilai_raport SET nil_raport_ketrampilan = '$xpel_nil_nr', ".
							"nil_raport_ketrampilan_a = '$xpel_nil_nr_a', ".
							"nil_raport_ketrampilan_p = '$xpel_nil_nr_p' ".
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



		


		mysql_query("UPDATE siswa_nilai_raport SET nil_praktek1 = '$inil_praktek1', ".
						"nil_praktek2 = '$inil_praktek2', ".
						"nil_praktek3 = '$inil_praktek3', ".
						"nil_praktek4 = '$inil_praktek4', ".
						"rata_praktek = '$xnilnpxx', ".
						"nil_folio1 = '$inil_folio1', ".
						"nil_folio2 = '$inil_folio2', ".
						"nil_folio3 = '$inil_folio3', ".
						"nil_folio4 = '$inil_folio4', ".
						"rata_folio = '$inil_folio_rata', ".
						"nil_proyek1 = '$inil_proyek1', ".
						"nil_proyek2 = '$inil_proyek2', ".
						"nil_proyek3 = '$inil_proyek3', ".
						"nil_proyek4 = '$inil_proyek4', ".
						"rata_proyek = '$inil_proyek_rata', ".
						"nil_praktek = '$inil_ulangan', ".
						"nil_raport_ketrampilan = '$xnilnrxx', ".
						"nil_raport_ketrampilan_a = '$xnilnraxx', ".
						"nil_raport_ketrampilan_p = '$xnilnrpxx' ".
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
			$filex_namex2 = "file_importnya.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);


			//re-direct
			$ke = "nil_ketrampilan_import.php?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&filex_namex2=$filex_namex2";
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
	$i_filename = "Nilai_Ketrampilan_$stdx_pel.xls";
	$i_judul = "Ketrampilan";
	



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
	$worksheet1->write_string(0,3,"PRAKTEK_1");
	$worksheet1->write_string(0,4,"PRAKTEK_2");
	$worksheet1->write_string(0,5,"PRAKTEK_3");
	$worksheet1->write_string(0,6,"PRAKTEK_4");
	$worksheet1->write_string(0,7,"PRAKTEK_RATA");
	$worksheet1->write_string(0,8,"FOLIO_1");
	$worksheet1->write_string(0,9,"FOLIO_2");
	$worksheet1->write_string(0,10,"FOLIO_3");
	$worksheet1->write_string(0,11,"FOLIO_4");
	$worksheet1->write_string(0,12,"FOLIO_RATA");
	$worksheet1->write_string(0,13,"PROYEK_1");
	$worksheet1->write_string(0,14,"PROYEK_2");
	$worksheet1->write_string(0,15,"PROYEK_3");
	$worksheet1->write_string(0,16,"PROYEK_4");
	$worksheet1->write_string(0,17,"PROYEK_RATA");
	$worksheet1->write_string(0,18,"ULANGAN");
	$worksheet1->write_string(0,19,"NR");
	$worksheet1->write_string(0,20,"RAPORT_A");
	$worksheet1->write_string(0,21,"RAPORT_P");



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
		$xpel_nil_np1 = nosql($rxpel['nil_praktek1']);
		$xpel_nil_np2 = nosql($rxpel['nil_praktek2']);
		$xpel_nil_np3 = nosql($rxpel['nil_praktek3']);
		$xpel_nil_np4 = nosql($rxpel['nil_praktek4']);
		$xpel_rata_np = nosql($rxpel['rata_praktek']);
		$xpel_nil_folio1 = nosql($rxpel['nil_folio1']);
		$xpel_nil_folio2 = nosql($rxpel['nil_folio2']);
		$xpel_nil_folio3 = nosql($rxpel['nil_folio3']);
		$xpel_nil_folio4 = nosql($rxpel['nil_folio4']);
		$xpel_rata_nf = nosql($rxpel['rata_folio']);
		$xpel_nil_proyek1 = nosql($rxpel['nil_proyek1']);
		$xpel_nil_proyek2 = nosql($rxpel['nil_proyek2']);
		$xpel_nil_proyek3 = nosql($rxpel['nil_proyek3']);
		$xpel_nil_proyek4 = nosql($rxpel['nil_proyek4']);
		$xpel_rata_ny = nosql($rxpel['rata_proyek']);


		$xpel_ulangan = nosql($rxpel['nil_praktek']);
		$xpel_nil_nr = nosql($rxpel['nil_raport_ketrampilan']);
		$xpel_nil_nr_a = nosql($rxpel['nil_raport_ketrampilan_a']);
		$xpel_nil_nr_p = nosql($rxpel['nil_raport_ketrampilan_p']);






		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_nis);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$xpel_nil_np1);
		$worksheet1->write_string($dt_nox,4,$xpel_nil_np2);
		$worksheet1->write_string($dt_nox,5,$xpel_nil_np3);
		$worksheet1->write_string($dt_nox,6,$xpel_nil_np4);
		$worksheet1->write_string($dt_nox,7,$xpel_rata_np);
		$worksheet1->write_string($dt_nox,8,$xpel_nil_folio1);
		$worksheet1->write_string($dt_nox,9,$xpel_nil_folio2);
		$worksheet1->write_string($dt_nox,10,$xpel_nil_folio3);
		$worksheet1->write_string($dt_nox,11,$xpel_nil_folio4);
		$worksheet1->write_string($dt_nox,12,$xpel_rata_nf);
		$worksheet1->write_string($dt_nox,13,$xpel_nil_proyek1);
		$worksheet1->write_string($dt_nox,14,$xpel_nil_proyek2);
		$worksheet1->write_string($dt_nox,15,$xpel_nil_proyek3);
		$worksheet1->write_string($dt_nox,16,$xpel_nil_proyek4);
		$worksheet1->write_string($dt_nox,17,$xpel_rata_ny);
		$worksheet1->write_string($dt_nox,18,$xpel_ulangan);
		$worksheet1->write_string($dt_nox,19,$xpel_nil_nr);
		$worksheet1->write_string($dt_nox,20,$xpel_nil_nr_a);
		$worksheet1->write_string($dt_nox,21,$xpel_nil_nr_p);

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
		<td width="50"><strong>PRAKTEK 1</strong></td>
		<td width="50"><strong>PRAKTEK 2</strong></td>
		<td width="50"><strong>PRAKTEK 3</strong></td>
		<td width="50"><strong>PRAKTEK 4</strong></td>
		<td width="50"><strong>RATA</strong></td>
		<td width="50"><strong>PROYEK 1</strong></td>
		<td width="50"><strong>PROYEK 2</strong></td>
		<td width="50"><strong>PROYEK 3</strong></td>
		<td width="50"><strong>PROYEK 4</strong></td>
		<td width="50"><strong>RATA</strong></td>
		<td width="50"><strong>FOLIO 1</strong></td>
		<td width="50"><strong>FOLIO 2</strong></td>
		<td width="50"><strong>FOLIO 3</strong></td>
		<td width="50"><strong>FOLIO 4</strong></td>
		<td width="50"><strong>RATA</strong></td>
		<td width="50"><strong>ULANGAN</strong></td>
		<td width="50"><strong>N.A.K</strong></td>
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
			
			$xpel_praktek1 = nosql($rxpel['nil_praktek1']);
			$xpel_praktek2 = nosql($rxpel['nil_praktek2']);
			$xpel_praktek3 = nosql($rxpel['nil_praktek3']);
			$xpel_praktek4 = nosql($rxpel['nil_praktek4']);			
			$xpel_praktek_rata = nosql($rxpel['rata_praktek']);
			
			
			$xpel_folio1 = nosql($rxpel['nil_folio1']);
			$xpel_folio2 = nosql($rxpel['nil_folio2']);
			$xpel_folio3 = nosql($rxpel['nil_folio3']);
			$xpel_folio4 = nosql($rxpel['nil_folio4']);
			$xpel_folio_rata = nosql($rxpel['rata_folio']);
			
			
			$xpel_proyek1 = nosql($rxpel['nil_proyek1']);
			$xpel_proyek2 = nosql($rxpel['nil_proyek2']);
			$xpel_proyek3 = nosql($rxpel['nil_proyek3']);
			$xpel_proyek4 = nosql($rxpel['nil_proyek4']);
			$xpel_proyek_rata = nosql($rxpel['rata_proyek']);

			
			$xpel_ulangan = nosql($rxpel['nil_praktek']);
			
			$xpel_nil_nr = nosql($rxpel['nil_raport_ketrampilan']);
			$xpel_nil_nr_a = nosql($rxpel['nil_raport_ketrampilan_a']);
			$xpel_nil_nr_p = balikin($rxpel['nil_raport_ketrampilan_p']);





			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input name="skkd'.$i_nomer.'" type="hidden" value="'.$i_skkd.'">
			'.$i_nis.'
			</td>
			<td>
			'.$i_nama.'
			</td>

			<td>
			<input name="nil_praktek1'.$i_nomer.'" type="text" value="'.$xpel_praktek1.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_praktek2'.$i_nomer.'" type="text" value="'.$xpel_praktek2.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_praktek3'.$i_nomer.'" type="text" value="'.$xpel_praktek3.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_praktek4'.$i_nomer.'" type="text" value="'.$xpel_praktek4.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_praktek_rata'.$i_nomer.'" type="text" value="'.$xpel_praktek_rata.'" size="3" style="text-align:right" class="input" readonly>
			</td>


			<td>
			<input name="nil_proyek1'.$i_nomer.'" type="text" value="'.$xpel_proyek1.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_proyek2'.$i_nomer.'" type="text" value="'.$xpel_proyek2.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_proyek3'.$i_nomer.'" type="text" value="'.$xpel_proyek3.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_proyek4'.$i_nomer.'" type="text" value="'.$xpel_proyek4.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_proyek_rata'.$i_nomer.'" type="text" value="'.$xpel_proyek_rata.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			
			
			<td>
			<input name="nil_folio1'.$i_nomer.'" type="text" value="'.$xpel_folio1.'" size="3" style="text-align:right">
			</td>
			
			<td>
			<input name="nil_folio2'.$i_nomer.'" type="text" value="'.$xpel_folio2.'" size="3" style="text-align:right">
			</td>
			
			<td>
			<input name="nil_folio3'.$i_nomer.'" type="text" value="'.$xpel_folio3.'" size="3" style="text-align:right">
			</td>
			
			<td>
			<input name="nil_folio4'.$i_nomer.'" type="text" value="'.$xpel_folio4.'" size="3" style="text-align:right">
			</td>
			
			<td>
			<input name="nil_folio_rata'.$i_nomer.'" type="text" value="'.$xpel_folio_rata.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			
			<td>
			<input name="nil_ulangan'.$i_nomer.'" type="text" value="'.$xpel_ulangan.'" size="3" style="text-align:right">
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
		<table width="1200" border="0" cellspacing="0" cellpadding="3">
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

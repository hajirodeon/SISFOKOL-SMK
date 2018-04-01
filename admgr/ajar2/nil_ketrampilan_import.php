<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nil_ketrampilan_import.php";
$judul = "Import Nilai Mata Pelajaran";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$jnskd = nosql($_REQUEST['jnskd']);




//PROSES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$filex_namex2 = $_POST['filex_namex2'];


	//hapus file
	$path3 = "../../filebox/excel/$filex_namex2";
	chmod($path3,0777);
	unlink ($path3);

	//re-direct
	$ke = "nil_ketrampilan.php?tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&jnskd=$jnskd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}





//import sekarang
if ($_POST['btnIMx'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$filex_namex2 = $_POST['filex_namex2'];

	//nek null
	if (empty($filex_namex2))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "nil_ketrampilan.php?tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&smtkd=$smtkd&jnskd=$jnskd&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex2, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox/excel";
			chmod($path1,0777);


			//file-nya...
			$uploadfile = "$path1/$filex_namex2";


			//require
			require_once '../../inc/class/excel/excel_reader2.php';




			// membaca file excel yang diupload
			$data = new Spreadsheet_Excel_Reader($uploadfile);

			// membaca jumlah baris dari data excel
			$baris = $data->rowcount($sheet_index=0);
			$jml_kolom = $data->colcount($sheet=0);



			// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
			for ($i=2; $i<=$baris+5; $i++)
				{
				$i_xyz = md5("$x$i");
				$i_no = nosql($data->val($i, 1));
				$i_nis = nosql($data->val($i, 2));
				$i_nama = balikin($data->val($i, 3));
				$i_nil_praktek1 = nosql($data->val($i, 4));
				$i_nil_praktek2 = nosql($data->val($i, 5));
				$i_nil_praktek3 = nosql($data->val($i, 6));
				$i_nil_praktek4 = nosql($data->val($i, 7));
				$i_rata_praktek = nosql($data->val($i, 8));
				$i_nil_folio1 = nosql($data->val($i, 9));
				$i_nil_folio2 = nosql($data->val($i, 10));
				$i_nil_folio3 = nosql($data->val($i, 11));
				$i_nil_folio4 = nosql($data->val($i, 12));
				$i_rata_folio = nosql($data->val($i, 13));
				$i_nil_proyek1 = nosql($data->val($i, 14));
				$i_nil_proyek2 = nosql($data->val($i, 15));
				$i_nil_proyek3 = nosql($data->val($i, 16));
				$i_nil_proyek4 = nosql($data->val($i, 17));
				$i_rata_proyek = nosql($data->val($i, 18));
				$i_ulangan = nosql($data->val($i, 19));
				$i_nr = nosql($data->val($i, 20));
				$i_nr_a = nosql($data->val($i, 21));
				$i_nr_p = nosql($data->val($i, 22));




			
			



				//ke mysql
				$qcc = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
										"FROM m_siswa, siswa_kelas ".
										"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
										"AND siswa_kelas.kd_tapel = '$tapelkd' ".
										"AND m_siswa.nis = '$i_nis'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_skkd = nosql($rcc['skkd']);



				//kumpulkan dulu ya.... nilai praktek...
				//netralkan dulu
				mysql_query("DELETE FROM siswa_praktek ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		
				mysql_query("INSERT INTO siswa_praktek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'praktek1', '$i_nil_praktek1', '$today')");
		
				mysql_query("INSERT INTO siswa_praktek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'praktek2', '$i_nil_praktek2', '$today')");
		
				mysql_query("INSERT INTO siswa_praktek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'praktek3', '$i_nil_praktek3', '$today')");
								
				mysql_query("INSERT INTO siswa_praktek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'praktek4', '$i_nil_praktek4', '$today')");
								
			
		
		
		
				//kumpulkan dulu ya.... nilai proyek...
				//netralkan dulu
				mysql_query("DELETE FROM siswa_proyek ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		
				mysql_query("INSERT INTO siswa_proyek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'proyek1', '$i_nil_proyek1', '$today')");
		
				mysql_query("INSERT INTO siswa_proyek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'proyek2', '$i_nil_proyek2', '$today')");
		
				mysql_query("INSERT INTO siswa_proyek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'proyek3', '$i_nil_proyek3', '$today')");
		
				mysql_query("INSERT INTO siswa_proyek(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'proyek4', '$i_nil_proyek4', '$today')");
		
			
		
			
			
			
				//kumpulkan dulu ya.... nilai folio...
				//netralkan dulu
				mysql_query("DELETE FROM siswa_folio ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		
				mysql_query("INSERT INTO siswa_folio(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'folio1', '$i_nil_folio1', '$today')");
		
				mysql_query("INSERT INTO siswa_folio(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'folio2', '$i_nil_folio2', '$today')");
		
				mysql_query("INSERT INTO siswa_folio(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'folio3', '$i_nil_folio3', '$today')");
		
				mysql_query("INSERT INTO siswa_folio(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nilkd, nilai, postdate) VALUES ".
								"('$x', '$cc_skkd', '$smtkd', '$progkd', ".
								"'folio4', '$i_nil_folio4', '$today')");
								

								
								
				//jika ada
				if ($tcc != 0)
					{
					//entry...
					$qcc1 = mysql_query("SELECT * FROM siswa_nilai_raport ".
											"WHERE kd_siswa_kelas = '$cc_skkd' ".
											"AND kd_smt = '$smtkd' ".
											"AND kd_prog_pddkn = '$progkd'");
					$rcc1 = mysql_fetch_assoc($qcc1);
					$tcc1 = mysql_num_rows($qcc1);


					//jika ada, update
					if ($tcc1 != 0)
						{
						mysql_query("UPDATE siswa_nilai_raport SET nil_praktek1 = '$i_nil_praktek1', ".
										"nil_praktek2 = '$i_nil_praktek2', ".
										"nil_praktek3 = '$i_nil_praktek3', ".
										"nil_praktek4 = '$i_nil_praktek4', ".
										"rata_praktek = '$i_rata_praktek', ".
										"nil_folio1 = '$i_nil_folio1', ".
										"nil_folio2 = '$i_nil_folio2', ".
										"nil_folio3 = '$i_nil_folio3', ".
										"nil_folio4 = '$i_nil_folio4', ".
										"rata_folio = '$i_rata_folio', ".
										"nil_proyek1 = '$i_nil_proyek1', ".
										"nil_proyek2 = '$i_nil_proyek2', ".
										"nil_proyek3 = '$i_nil_proyek3', ".
										"nil_proyek4 = '$i_nil_proyek4', ".
										"rata_proyek = '$i_rata_proyek', ".
										"nil_praktek = '$i_ulangan', ".
										"nil_raport_ketrampilan = '$i_nr', ".
										"nil_raport_ketrampilan_a = '$i_nr_a', ".
										"nil_raport_ketrampilan_p = '$i_nr_p' ".
										"WHERE kd_siswa_kelas = '$cc_skkd' ".
										"AND kd_smt = '$smtkd' ".
										"AND kd_prog_pddkn = '$progkd'");
						}

					//jika blm ada, insert
					else
						{
						mysql_query("INSERT INTO siswa_nilai_raport(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
										"nil_praktek1, nil_praktek2, nil_praktek3, nil_praktek4, ".
										"rata_praktek, nil_folio1, nil_folio2, nil_folio3, nil_folio4, ".
										"rata_folio, nil_proyek1, ".
										"nil_proyek2, nil_proyek3, nil_proyek4, rata_proyek, ".
										"nil_praktek, nil_raport_ketrampilan, nil_raport_ketrampilan_a, nil_raport_ketrampilan_p, postdate) VALUES ".
										"('$i_xyz', '$cc_skkd', '$smtkd', '$progkd', ".
										"'$i_nil_praktek1', '$i_nil_praktek2', '$i_nil_praktek3', '$i_nil_praktek4', ".
										"'$i_rata_praktek', '$i_nil_folio1', '$i_nil_folio2', '$i_nil_folio3', '$i_nil_folio4', ".
										"'$i_rata_folio', '$i_nil_proyek1', ".
										"'$i_nil_proyek2', '$i_nil_proyek3', '$i_nil_proyek4', '$i_rata_proyek', ".
										"'$i_ulangan', '$i_nr', '$i_nr_a', '$i_nr_p', '$today')");
						}
						
						
						
						
						
								
				
				
		
					//rata2 praktek
					$qcc2 = mysql_query("SELECT AVG(nilai) AS rataku FROM siswa_praktek ".
											"WHERE kd_siswa_kelas = '$cc_skkd' ".
											"AND kd_smt = '$smtkd' ".
											"AND kd_prog_pddkn = '$progkd' ".
											"AND nilai <> '0' ".
											"AND nilai <> ''");
					$rcc2 = mysql_fetch_assoc($qcc2);
					$cc2_praktek = nosql($rcc2['rataku']);
					
					//update lg...					
					mysql_query("UPDATE siswa_nilai_raport SET rata_praktek = '$cc2_praktek' ".
									"WHERE kd_siswa_kelas = '$cc_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
		
		
		
		
					//rata2 proyek
					$qcc2 = mysql_query("SELECT AVG(nilai) AS rataku FROM siswa_proyek ".
											"WHERE kd_siswa_kelas = '$cc_skkd' ".
											"AND kd_smt = '$smtkd' ".
											"AND kd_prog_pddkn = '$progkd' ".
											"AND nilai <> '0' ".
											"AND nilai <> ''");
					$rcc2 = mysql_fetch_assoc($qcc2);
					$cc2_proyek = nosql($rcc2['rataku']);
					
					//update lg...					
					mysql_query("UPDATE siswa_nilai_raport SET rata_proyek = '$cc2_proyek' ".
									"WHERE kd_siswa_kelas = '$cc_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
		
		
		
		
					//rata2 folio
					$qcc2 = mysql_query("SELECT AVG(nilai) AS rataku FROM siswa_folio ".
											"WHERE kd_siswa_kelas = '$cc_skkd' ".
											"AND kd_smt = '$smtkd' ".
											"AND kd_prog_pddkn = '$progkd' ".
											"AND nilai <> '0' ".
											"AND nilai <> ''");
					$rcc2 = mysql_fetch_assoc($qcc2);
					$cc2_folio = nosql($rcc2['rataku']);
					
					//update lg...					
					mysql_query("UPDATE siswa_nilai_raport SET rata_folio = '$cc2_folio' ".
									"WHERE kd_siswa_kelas = '$cc_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
		
									
						
						
						
						
						
							
					//nilai akhir
					$xpel_nil_nr = round(((2 * $cc2_praktek) + (3 * $cc2_proyek) + $cc2_folio + (2 * $i_ulangan)) / 8,2);
			
				
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
									"WHERE kd_siswa_kelas = '$cc_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
							
					
					}
				}




			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "nil_ketrampilan.php?tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&jnskd=$jnskd&smtkd=$smtkd";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "nil_ketrampilan.php?tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//menu
require("../../inc/menu/admgr.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();








//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
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
$btxkelas = nosql($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>,



Semester : ';
//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
			"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<strong>'.$stx_smt.'</strong>
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
$stdx_pel = balikin($rowstdx['prog_pddkn']);


echo '<strong>'.$stdx_pel.'</strong>
</td>
</tr>
</table>';

$filex_namex2 = $_REQUEST['filex_namex2'];

//nilai
$path1 = "../../filebox/excel/$filex_namex2";

//file-nya...
$uploadfile = $path1;


echo '<p>
Yakin Akan Import . . .?.
<br>
<input name="filex_namex2" type="hidden" value="'.$filex_namex2.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="jnskd" type="hidden" value="'.$jnskd.'">
<input name="btnBTL" type="submit" value="<< BATAL">
<input name="btnIMx" type="submit" value="IMPORT Sekarang>>">
</p>
</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>

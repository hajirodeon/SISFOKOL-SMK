<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v5.0_(PernahJaya)                          ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://omahbiasawae.com/                          ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



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
$keahkd = nosql($_REQUEST['keahkd']);
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
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$filex_namex2 = $_POST['filex_namex2'];


	//hapus file
	$path3 = "../../filebox/excel/$filex_namex2";
	chmod($path3,0777);
	unlink ($path3);

	//re-direct
	$ke = "nil_ketrampilan.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&progkd=$progkd&jnskd=$jnskd&smtkd=$smtkd";
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
	$keahkd = nosql($_POST['keahkd']);
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
		$ke = "nil_ketrampilan.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&progkd=$progkd&smtkd=$smtkd&jnskd=$jnskd&s=import";
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
			for ($i=2; $i<=$baris; $i++)
				{
				$i_xyz = md5("$x$i");
				$i_no = nosql($data->val($i, 1));
				$i_nis = nosql($data->val($i, 2));
				$i_nama = balikin($data->val($i, 3));
				$i_nil_praktek1 = nosql($data->val($i, 4));
				$i_nil_praktek2 = nosql($data->val($i, 5));
				$i_nil_praktek3 = nosql($data->val($i, 6));
				$i_nil_praktek4 = nosql($data->val($i, 7));
				$i_nil_praktek5 = nosql($data->val($i, 8));
				$i_nil_praktek6 = nosql($data->val($i, 9));
				$i_nil_praktek7 = nosql($data->val($i, 10));
				$i_nil_praktek8 = nosql($data->val($i, 11));
				$i_nil_praktek9 = nosql($data->val($i, 12));
				$i_rata_praktek = nosql($data->val($i, 13));
				$i_nil_folio1 = nosql($data->val($i, 14));
				$i_nil_folio2 = nosql($data->val($i, 15));
				$i_nil_folio3 = nosql($data->val($i, 16));
				$i_nil_folio4 = nosql($data->val($i, 17));
				$i_nil_folio5 = nosql($data->val($i, 18));
				$i_nil_folio6 = nosql($data->val($i, 19));
				$i_nil_folio7 = nosql($data->val($i, 20));
				$i_nil_folio8 = nosql($data->val($i, 21));
				$i_nil_folio9 = nosql($data->val($i, 22));
				$i_rata_folio = nosql($data->val($i, 23));
				$i_nil_proyek1 = nosql($data->val($i, 24));
				$i_nil_proyek2 = nosql($data->val($i, 25));
				$i_nil_proyek3 = nosql($data->val($i, 26));
				$i_nil_proyek4 = nosql($data->val($i, 27));
				$i_nil_proyek5 = nosql($data->val($i, 28));
				$i_nil_proyek6 = nosql($data->val($i, 29));
				$i_nil_proyek7 = nosql($data->val($i, 30));
				$i_nil_proyek8 = nosql($data->val($i, 31));
				$i_nil_proyek9 = nosql($data->val($i, 32));
				$i_rata_proyek = nosql($data->val($i, 33));
				$i_nr = nosql($data->val($i, 34));
				$i_nr_a = nosql($data->val($i, 35));
				$i_nr_p = nosql($data->val($i, 36));





				//ke mysql
				$qcc = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
										"FROM m_siswa, siswa_kelas ".
										"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
										"AND siswa_kelas.kd_tapel = '$tapelkd' ".
										"AND siswa_kelas.kd_keahlian = '$keahkd' ".
										"AND m_siswa.nis = '$i_nis'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_skkd = nosql($rcc['skkd']);

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
										"nil_praktek5 = '$i_nil_praktek5', ".
										"nil_praktek6 = '$i_nil_praktek6', ".
										"nil_praktek7 = '$i_nil_praktek7', ".
										"nil_praktek8 = '$i_nil_praktek8', ".
										"nil_praktek9 = '$i_nil_praktek9', ".
										"rata_praktek = '$i_rata_praktek', ".
										"nil_folio1 = '$i_nil_folio1', ".
										"nil_folio2 = '$i_nil_folio2', ".
										"nil_folio3 = '$i_nil_folio3', ".
										"nil_folio4 = '$i_nil_folio4', ".
										"nil_folio5 = '$i_nil_folio5', ".
										"nil_folio6 = '$i_nil_folio6', ".
										"nil_folio7 = '$i_nil_folio7', ".
										"nil_folio8 = '$i_nil_folio8', ".
										"nil_folio9 = '$i_nil_folio9', ".
										"rata_folio = '$i_rata_folio', ".
										"nil_proyek1 = '$i_nil_proyek1', ".
										"nil_proyek2 = '$i_nil_proyek2', ".
										"nil_proyek3 = '$i_nil_proyek3', ".
										"nil_proyek4 = '$i_nil_proyek4', ".
										"nil_proyek5 = '$i_nil_proyek5', ".
										"nil_proyek6 = '$i_nil_proyek6', ".
										"nil_proyek7 = '$i_nil_proyek7', ".
										"nil_proyek8 = '$i_nil_proyek8', ".
										"nil_proyek9 = '$i_nil_proyek9', ".
										"rata_proyek = '$i_rata_proyek', ".
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
										"nil_praktek1, nil_praktek2, nil_praktek3, ".
										"nil_praktek4, nil_praktek5, nil_praktek6, ".
										"nil_praktek7, nil_praktek8, nil_praktek9, ".
										"rata_praktek, nil_folio1, nil_folio2, ".
										"nil_folio3, nil_folio4, nil_folio5, ".
										"nil_folio6, nil_folio7, nil_folio8, ".
										"nil_folio9, rata_folio, nil_proyek1, ".
										"nil_proyek2, nil_proyek3, nil_proyek4, ".
										"nil_proyek5, nil_proyek6, nil_proyek7, ".
										"nil_proyek8, nil_proyek9, rata_proyek, ".
										"nil_raport_ketrampilan, nil_raport_ketrampilan_a, nil_raport_ketrampilan_p, postdate) VALUES ".
										"('$i_xyz', '$cc_skkd', '$smtkd', '$progkd', ".
										"'$i_nil_praktek1', '$i_nil_praktek2', '$i_nil_praktek3', ".
										"'$i_nil_praktek4', '$i_nil_praktek5', '$i_nil_praktek6', ".
										"'$i_nil_praktek7', '$i_nil_praktek8', '$i_nil_praktek9', ".
										"'$i_rata_praktek', '$i_nil_folio1', '$i_nil_folio2', ".
										"'$i_nil_folio3', '$i_nil_folio4', '$i_nil_folio5', ".
										"'$i_nil_folio6', '$i_nil_folio7', '$i_nil_folio8', ".
										"'$i_nil_folio9', '$i_rata_folio', '$i_nil_proyek1', ".
										"'$i_nil_proyek2', '$i_nil_proyek3', '$i_nil_proyek4', ".
										"'$i_nil_proyek5', '$i_nil_proyek6', '$i_nil_proyek7', ".
										"'$i_nil_proyek8', '$i_nil_proyek9', '$i_rata_proyek', ".
										"'$i_nr', '$i_nr_a', '$i_nr_p', '$today')");
						}
					}
				}




			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "nil_ketrampilan.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&progkd=$progkd&jnskd=$jnskd&smtkd=$smtkd";
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


Program Keahlian : ';
//terpilih
$qprgx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['program']);

echo '<b>'.$prgx_prog.'</b>,



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
<input name="keahkd" type="hidden" value="'.$keahkd.'">
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

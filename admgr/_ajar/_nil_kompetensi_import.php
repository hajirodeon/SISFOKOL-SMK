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



///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v4.0_(NyurungBAN)                          ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS	: 081-829-88-54                                 ///////
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
$filenya = "nil_kompetensi_import.php";
$judul = "Import Nilai";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$progkd = nosql($_REQUEST['progkd']);
$mmkd= nosql($_REQUEST['mmkd']);




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
	$mmkd = nosql($_POST['mmkd']);
	$filex_namex = $_POST['filex_namex'];


	//hapus file
	$path3 = "../../filebox/excel/$filex_namex";
	chmod($path3,0777);
	unlink ($path3);

	//re-direct
	$ke = "nil_kompetensi.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
		"keahkd=$keahkd&progkd=$progkd&mmkd=$mmkd";
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
	$mmkd = nosql($_POST['mmkd']);
	$filex_namex2 = $_POST['filex_namex2'];

	//nek null
	if (empty($filex_namex2))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "nil_kompetensi.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
				"keahkd=$keahkd&progkd=$progkd&mmkd=$mmkd&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex2, -4);

		if ($ext_filex == ".xls")
			{
			//kelas program pendidikan
			$qhi = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd, ".
						"m_prog_pddkn.*, m_prog_pddkn.kd AS mkkd ".
						"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$progkd'");
			$rowhi = mysql_fetch_assoc($qhi);
			$totalhi = mysql_num_rows($qhi);
			$hi_mpkd = nosql($rowhi['mpkd']);


			//nilai
			$path1 = "../../filebox/excel";

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
				$i_nis = nosql($data->val($i, 2));
				$i_nama = nosql($data->val($i, 3));


				//ke mysql
				$qcc = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND siswa_kelas.kd_keahlian = '$keahkd' ".
							"AND m_siswa.nis = '$i_nis'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_skkd = nosql($rcc['skkd']);


				//masukkan data
				for ($k=4;$k<=$jml_kolom;$k++)
					{
					$i_xyza = md5("$x$i$k");

					//kode / nama kolom
					$i_kode1 = nosql($data->val(1, $k));
					$i_kode2 = nosql($data->val($i, $k));



					//jumlah KD...
					$qku27 = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
								"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
								"AND kd_smt = '$smtkd'");
					$rowku27 = mysql_fetch_assoc($qku27);
					$totalku27 = mysql_num_rows($qku27);



					//cari tahu, kd-nya...
					$qku2 = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
								"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kode = '$i_kode1'");
					$rowku2 = mysql_fetch_assoc($qku2);
					$totalku2 = mysql_num_rows($qku2);
					$ku2_kd = nosql($rowku2['kd']);


					//cek
					$qcc = mysql_query("SELECT * FROM siswa_nilai_kompetensi ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn_kompetensi = '$ku2_kd'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);

					//jika ada, update
					if ($tcc != 0)
						{
						//update
						mysql_query("UPDATE siswa_nilai_kompetensi SET nil_nkd = '$i_kode2' ".
								"WHERE kd_siswa_kelas = '$i_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn_kompetensi = '$ku2_kd'");
						}
					else
						{
						mysql_query("INSERT INTO siswa_nilai_kompetensi (kd, kd_siswa_kelas, kd_smt, ".
								"kd_prog_pddkn_kompetensi, nil_nkd) VALUES ".
								"('$i_xyza', '$cc_skkd', '$smtkd', ".
								"'$ku2_kd', '$i_kode2')");
						}









					//rata NK /////////////////////////////////////////////////////////////////////////
					$qcc5x = mysql_query("SELECT AVG(siswa_nilai_kompetensi.nil_nkd) AS nkd ".
								"FROM m_prog_pddkn_kompetensi, siswa_nilai_kompetensi ".
								"WHERE m_prog_pddkn_kompetensi.kd = siswa_nilai_kompetensi.kd_prog_pddkn_kompetensi ".
								"AND m_prog_pddkn_kompetensi.kd_prog_pddkn_kelas = '$hi_mpkd' ".
								"AND siswa_nilai_kompetensi.kd_siswa_kelas = '$cc_skkd' ".
								"AND siswa_nilai_kompetensi.kd_smt = '$smtkd'");
					$rcc5x = mysql_fetch_assoc($qcc5x);
					$tcc5x = mysql_num_rows($qcc5x);
					$cc5x_nkd = nosql($rcc5x['nkd']);




					//ketahui NS dan NK //////////////////////////////////////////////////////////////////////////////////
					//posisi NS
					$pos_ns = 4 + $totalku27;
					$i_kode3 = nosql($data->val($i, $pos_ns));


					//cek
					$qcc = mysql_query("SELECT * FROM siswa_nilai_kompetensi2 ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);
			
					//jika ada, update
					if ($tcc != 0)
						{
						//update
						mysql_query("UPDATE siswa_nilai_kompetensi2 SET nil_ns = '$i_kode3', ".
								"nil_nk = '$cc5x_nkd' ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
						}
					else
						{
						//insert
						mysql_query("INSERT INTO siswa_nilai_kompetensi2(kd, kd_siswa_kelas, kd_smt, ".
								"kd_prog_pddkn, nil_ns, nil_nk) VALUES ".
								"('$i_xyza', '$cc_skkd', '$smtkd', ".
								"'$progkd', '$$i_kode3', '$cc5x_nkd')");
						}



					//cek
					$qcc1 = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_prog_pddkn = '$progkd' ".
								"AND kd_smt = '$smtkd'");
					$rcc1 = mysql_fetch_assoc($qcc1);
					$tcc1 = mysql_num_rows($qcc1);
			
					//jika ada, update
					if($tcc1 != 0)
						{
						mysql_query("UPDATE siswa_nilai_raport SET nil_raport = '$cc5x_nkd' ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_prog_pddkn = '$progkd' ".
								"AND kd_smt = '$smtkd'");
						}
					else
						{
						mysql_query("INSERT INTO siswa_nilai_raport (kd, kd_siswa_kelas, ".
								"kd_smt, kd_prog_pddkn, nil_raport) VALUES ".
								"('$i_xyza', '$cc_skkd', '$smtkd', '$progkd', '$cc5x_nkd')");
						}



					//rangking //////////////////////////////////////////////////////////////////////////////////////////////////////
					//total_kognitif
					$qjum = mysql_query("SELECT SUM(nil_raport) AS total_kognitif ".
								"FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd'");
					$rjum = mysql_fetch_assoc($qjum);
					$tjum = mysql_num_rows($qjum);
					$total_kognitif = round(nosql($rjum['total_kognitif']));


					//rata_kognitif
					$qjum2 = mysql_query("SELECT AVG(nil_raport) AS rata_kognitif ".
								"FROM siswa_nilai_prog_pddkn ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd'");
					$rjum2 = mysql_fetch_assoc($qjum2);
					$tjum2 = mysql_num_rows($qjum2);
					$rata_kognitif = round(nosql($rjum2['rata_kognitif']));


					//total
					$total_nilai = round($total_kognitif);


					//cek
					$qgk = mysql_query("SELECT * FROM siswa_rangking ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_keahlian = '$keahkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd'");
					$rgk = mysql_fetch_assoc($qgk);
					$tgk = mysql_num_rows($qgk);

					//jika ada
					if ($tgk != 0)
						{
						//update
						mysql_query("UPDATE siswa_rangking SET total_kognitif = '$total_kognitif', ".
								"rata_kognitif = '$rata_kognitif', ".
								"total = '$total_nilai' ".
								"WHERE kd_siswa_kelas = '$cc_skkd' ".
								"AND kd_smt = '$smtkd'");
						}
					else
						{
						//insert
						mysql_query("INSERT INTO siswa_rangking(kd, kd_tapel, kd_keahlian, kd_kelas, ".
								"kd_siswa_kelas, kd_smt, total_kognitif, rata_kognitif, ".
								"total) VALUES ".
								"('$i_xyza', '$tapelkd', '$keahkd', '$kelkd', ".
								"'$cc_skkd', '$smtkd', '$total_kognitif', '$rata_kognitif', ".
								"'$total_nilai')");
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
			$ke = "nil_kompetensi.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
					"keahkd=$keahkd&progkd=$progkd&mmkd=$mmkd";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "nil_kompetensi.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
					"keahkd=$keahkd&progkd=$progkd&mmkd=$mmkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admgr.php");
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


Keahlian : ';
//terpilih
$qprgx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_bid = balikin($rowprgx['bidang']);


echo '<b>'.$prgx_bid.'</b>,

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
Program Pendidikan : ';
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
$path1 = "../../filebox/excel/$filex_namex";

//file-nya...
$uploadfile = $path1;


echo '<p>
Yakin Akan Melakukan Import File. . .?.
<br>
<input name="filex_namex2" type="hidden" value="'.$filex_namex2.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="keahkd" type="hidden" value="'.$keahkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="mmkd" type="hidden" value="'.$mmkd.'">
<input name="btnBTL" type="submit" value="<< BATAL">
<input name="btnIMx" type="submit" value="Ya. IMPORT Sekarang>>">
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
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
$filenya = "nil_kompetensi.php";
$judul = "Penilaian Kompetensi";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$progkd = nosql($_REQUEST['progkd']);
$mpkd = nosql($_REQUEST['mpkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$mmkd= nosql($_REQUEST['mmkd']);
$s = nosql($_REQUEST['s']);
$limit = "50";
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"keahkd=$keahkd&progkd=$progkd&kompkd=$kompkd&mpkd=$mpkd&page=$page";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$mmkd = nosql($_POST['mmkd']);
	$kompkd = nosql($_POST['kompkd']);
	$mpkd = nosql($_POST['mpkd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
		"keahkd=$keahkd&mmkd=$mmkd&kompkd=$kompkd&mpkd=$mpkd&page=$page";
	xloc($ke);
	exit();
	}





//jika reset
if ($_POST['btnRST'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$mmkd = nosql($_POST['mmkd']);
	$kompkd = nosql($_POST['kompkd']);
	$mpkd = nosql($_POST['mpkd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}





/*
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
*/
	$hi_mpkd = $mpkd;




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");


		//mskd
		$xmskd = "mskd";
		$xmskd1 = "$xmskd$k";
		$xmskdxx = nosql($_POST["$xmskd1"]);


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);



		//query-kategori
		$qku = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND kd_smt = '$smtkd' ".
					"ORDER BY kode ASC");
		$rowku = mysql_fetch_assoc($qku);
		$totalku = mysql_num_rows($qku);

		do
			{
			//nilai
			$nomera = $nomera + 1;
			$xyza = md5("$x$nomera");
			$ku_kd = nosql($rowku['kd']);
			$ku_kode = nosql($rowku['kode']);


			//DELETE
			mysql_query("DELETE FROM siswa_nilai_kompetensi ".
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_prog_pddkn_kompetensi = '$ku_kd'");
			}
		while ($rowku = mysql_fetch_assoc($qku));


		mysql_query("DELETE FROM siswa_nilai_kompetensi2 ".
				"WHERE kd_siswa_kelas = '$xskkdxx' ".
				"AND kd_smt = '$smtkd' ".
				"AND kd_prog_pddkn = '$progkd'");
		}



	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
		"keahkd=$keahkd&mmkd=$mmkd&kompkd=$kompkd&mpkd=$mpkd&page=$page";
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
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$kompkd = nosql($_POST['kompkd']);
	$mpkd = nosql($_POST['mpkd']);
	$mmkd = nosql($_POST['mmkd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
		"keahkd=$keahkd&progkd=$progkd&mmkd=$mmkd&kompkd=$kompkd&mpkd=$mpkd&s=import";
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
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$kompkd = nosql($_POST['kompkd']);
	$mpkd = nosql($_POST['mpkd']);
	$mmkd = nosql($_POST['mmkd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
				"keahkd=$keahkd&progkd=$progkd&mmkd=$mmkd&kompkd=$kompkd&mpkd=$mpkd&s=import";
		pekem($pesan,$ke);
		}
	else
		{
		//deteksi .jpg
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
			$ke = "nil_kompetensi_import.php?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
					"keahkd=$keahkd&progkd=$progkd&kompkd=$kompkd&mpkd=$mpkd&mmkd=$mmkd&filex_namex2=$filex_namex2";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
					"keahkd=$keahkd&progkd=$progkd&mmkd=$mmkd&kompkd=$kompkd&mpkd=$mpkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}






//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$mmkd = nosql($_POST['mmkd']);
	$kompkd = nosql($_POST['kompkd']);
	$mpkd = nosql($_POST['mpkd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}





/*
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
*/
	$hi_mpkd = $mpkd;




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");

		//mskd
		$xmskd = "mskd";
		$xmskd1 = "$xmskd$k";
		$xmskdxx = nosql($_POST["$xmskd1"]);


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);


		//ns
		$xnilns = "ns";
		$xnilns1 = "$xnilns$k";
		$xnilnsxx = nosql($_POST["$xnilns1"]);

		//nk
		$xnilnk = "nk";
		$xnilnk1 = "$xnilnk$k";
		$xnilnkxx = nosql($_POST["$xnilnk1"]);



		//query-kategori
		$qku = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND kd_smt = '$smtkd' ".
					"ORDER BY kode ASC");
		$rowku = mysql_fetch_assoc($qku);
		$totalku = mysql_num_rows($qku);

		do
			{
			//nilai
			$nomera = $nomera + 1;
			$xyza = md5("$x$nomera");
			$ku_kd = nosql($rowku['kd']);
			$ku_kode = nosql($rowku['kode']);



			//ambil nilai
			$xnh = "nkd";
			$xnh1 = "$k$xnh$nomera";
			$xnhxx = nosql($_POST["$xnh1"]);


			//cek
			$qcc = mysql_query("SELECT * FROM siswa_nilai_kompetensi ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn_kompetensi = '$ku_kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//jika ada, update
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE siswa_nilai_kompetensi SET nil_nkd = '$xnhxx' ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn_kompetensi = '$ku_kd'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO siswa_nilai_kompetensi(kd, kd_siswa_kelas, kd_smt, ".
						"kd_prog_pddkn_kompetensi, nil_nkd) VALUES ".
						"('$xyza', '$xskkdxx', '$smtkd', ".
						"'$ku_kd', '$xnhxx')");
				}
			}
		while ($rowku = mysql_fetch_assoc($qku));









		//rata NK /////////////////////////////////////////////////////////////////////////
		$qcc5x = mysql_query("SELECT AVG(siswa_nilai_kompetensi.nil_nkd) AS nkd ".
					"FROM m_prog_pddkn_kompetensi, siswa_nilai_kompetensi ".
					"WHERE m_prog_pddkn_kompetensi.kd = siswa_nilai_kompetensi.kd_prog_pddkn_kompetensi ".
					"AND m_prog_pddkn_kompetensi.kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND siswa_nilai_kompetensi.kd_siswa_kelas = '$xskkdxx' ".
					"AND siswa_nilai_kompetensi.kd_smt = '$smtkd'");
		$rcc5x = mysql_fetch_assoc($qcc5x);
		$tcc5x = mysql_num_rows($qcc5x);
		$cc5x_nkd = nosql($rcc5x['nkd']);





		//ketahui NS dan NK //////////////////////////////////////////////////////////////////////////////////
		//cek
		$qcc = mysql_query("SELECT * FROM siswa_nilai_kompetensi2 ".
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_prog_pddkn = '$progkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//jika ada, update
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE siswa_nilai_kompetensi2 SET nil_ns = '$xnilnsxx', ".
					"nil_nk = '$cc5x_nkd' ".
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_prog_pddkn = '$progkd'");
			}
		else
			{
			//insert
			mysql_query("INSERT INTO siswa_nilai_kompetensi2(kd, kd_siswa_kelas, kd_smt, ".
					"kd_prog_pddkn, nil_ns, nil_nk) VALUES ".
					"('$xyza', '$xskkdxx', '$smtkd', ".
					"'$progkd', '$xnilnsxx', '$cc5x_nkd')");
			}



		//cek
		$qcc1 = mysql_query("SELECT * FROM siswa_nilai_raport ".
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
					"AND kd_prog_pddkn = '$progkd' ".
					"AND kd_smt = '$smtkd'");
		$rcc1 = mysql_fetch_assoc($qcc1);
		$tcc1 = mysql_num_rows($qcc1);

		//jika ada, update
		if($tcc1 != 0)
			{
			mysql_query("UPDATE siswa_nilai_raport SET nil_raport = '$cc5x_nkd' ".
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
					"AND kd_prog_pddkn = '$progkd' ".
					"AND kd_smt = '$smtkd'");
			}
		else
			{
			mysql_query("INSERT INTO siswa_nilai_raport (kd, kd_siswa_kelas, ".
					"kd_smt, kd_prog_pddkn, nil_raport) VALUES ".
					"('$xyzb', '$xskkdxx', '$smtkd', '$progkd', '$cc5x_nkd')");
			}



		//rangking //////////////////////////////////////////////////////////////////////////////////////////////////////
		//total_kognitif
		$qjum = mysql_query("SELECT SUM(nil_raport) AS total_kognitif ".
					"FROM siswa_nilai_raport ".
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
					"AND kd_smt = '$smtkd'");
		$rjum = mysql_fetch_assoc($qjum);
		$tjum = mysql_num_rows($qjum);
		$total_kognitif = round(nosql($rjum['total_kognitif']));


/*
		//rata_kognitif
		$qjum2 = mysql_query("SELECT AVG(nil_raport) AS rata_kognitif ".
					"FROM siswa_nilai_prog_pddkn ".
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
					"AND kd_smt = '$smtkd'");
		$rjum2 = mysql_fetch_assoc($qjum2);
		$tjum2 = mysql_num_rows($qjum2);
		$rata_kognitif = round(nosql($rjum2['rata_kognitif']));
*/
		//rata_kognitif
		$qjum2 = mysql_query("SELECT AVG(nil_raport) AS rata_kognitif ".
					"FROM siswa_nilai_raport ".
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
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
					"AND kd_siswa_kelas = '$xskkdxx' ".
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
					"WHERE kd_siswa_kelas = '$xskkdxx' ".
					"AND kd_smt = '$smtkd'");
			}
		else
			{
			//insert
			mysql_query("INSERT INTO siswa_rangking(kd, kd_tapel, kd_keahlian, kd_kelas, ".
					"kd_siswa_kelas, kd_smt, total_kognitif, rata_kognitif, ".
					"total) VALUES ".
					"('$xyz', '$tapelkd', '$keahkd', '$kelkd', ".
					"'$xskkdxx', '$smtkd', '$total_kognitif', '$rata_kognitif', ".
					"'$total_nilai')");
			}
		}






	//pemberian rangking............................................................................................
	$qgki = mysql_query("SELECT * FROM siswa_rangking ".
				"WHERE kd_tapel = '$tapelkd' ".
				"AND kd_keahlian = '$keahkd' ".
				"AND kd_kelas = '$kelkd' ".
				"AND kd_smt = '$smtkd' ".
				"ORDER BY round(total) DESC");
	$rgki = mysql_fetch_assoc($qgki);
	$tgki = mysql_num_rows($qgki);

	//nek ada
	if ($tgki != 0)
		{
		do
			{
			//nilai
			$nox = $nox + 1;
			$gki_kd = nosql($rgki['kd']);

			mysql_query("UPDATE siswa_rangking SET rangking = '$nox' ".
					"WHERE kd = '$gki_kd'");
			}
		while ($rgki = mysql_fetch_assoc($qgki));
		}
	//rangking //////////////////////////////////////////////////////////////////////////////////////////////////////





	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
		"progkd=$progkd&keahkd=$keahkd&mmkd=$mmkd&mpkd=$mpkd&kompkd=$kompkd&page=$page";
	xloc($ke);
	exit();
	}







//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$kompkd = nosql($_POST['kompkd']);
	$mpkd = nosql($_POST['mpkd']);



	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');




/*
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
*/
	$hi_mpkd = $mpkd;


	//mapel e...
	$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
				"WHERE kd = '$mpkd'");
	$rowstdx = mysql_fetch_assoc($qstdx);
	$stdx_kd = nosql($rowstdx['kd']);
	$stdx_jnskd = nosql($rowstdx['kd_jenis']);
	$stdx_pel = strip(balikin($rowstdx['prog_pddkn']));



	//nama file e...
	$i_filename = "Nilai_$stdx_pel.xls";
	$i_judul = "Nilai";


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
	$worksheet1->set_column(0,0,5);
	$worksheet1->set_column(0,1,10);
	$worksheet1->set_column(0,2,30);
	$worksheet1->set_column(0,3,10);
	$worksheet1->set_column(0,4,10);
	$worksheet1->write_string(0,0,"NO");
	$worksheet1->write_string(0,1,"NIS");
	$worksheet1->write_string(0,2,"NAMA");


	//query-kategori
	$qku = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
				"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
				"AND kd_smt = '$smtkd' ".
				"ORDER BY kode ASC");
	$rowku = mysql_fetch_assoc($qku);
	$totalku = mysql_num_rows($qku);

	do
		{
		//nilai
		$ku_nomer = $ku_nomer + 1;
		$ku_kd = nosql($rowku['kd']);
		$ku_kode = nosql($rowku['kode']);

		$worksheet1->write_string(0,2+$ku_nomer,$ku_kode);
		}
	while ($rowku = mysql_fetch_assoc($qku));


	$worksheet1->write_string(0,$totalku+2+1,"NS");
	$worksheet1->write_string(0,$totalku+2+2,"NK");




	//data
	$qdt = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
				"FROM m_siswa, siswa_kelas ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kelkd' ".
				"AND siswa_kelas.kd_keahlian = '$keahkd' ".
				"ORDER BY m_siswa.nis ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_skkd = nosql($rdt['skkd']);
		$dt_no = nosql($rdt['no_absen']);
		$dt_nis = nosql($rdt['nis']);
		$dt_nama = balikin($rdt['nama']);


		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_nis);
		$worksheet1->write_string($dt_nox,2,$dt_nama);


		//query-kategori
		$qku = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND kd_smt = '$smtkd' ".
					"ORDER BY kode ASC");
		$rowku = mysql_fetch_assoc($qku);
		$totalku = mysql_num_rows($qku);

		do
			{
			//nilai
			$nomerku = $nomerku + 1;
			$ku_kd = nosql($rowku['kd']);

			//nilainya
			$qdtu = mysql_query("SELECT * FROM siswa_nilai_kompetensi ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn_kompetensi = '$ku_kd'");
			$rdtu = mysql_fetch_assoc($qdtu);
			$tdtu = mysql_num_rows($qdtu);
			$dtu_nkd = nosql($rdtu['nil_nkd']);

//			$worksheet1->write_string($dt_nox,3+((2+$nomerku)-($dt_nox*3)),$dtu_nkd);
			$worksheet1->write_string($dt_nox,3+((($totalku-1)+$nomerku)-($dt_nox*$totalku)),$dtu_nkd);
			}
		while ($rowku = mysql_fetch_assoc($qku));

		//nilainya
		$qdtu2 = mysql_query("SELECT * FROM siswa_nilai_kompetensi2 ".
					"WHERE kd_siswa_kelas = '$dt_skkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_prog_pddkn = '$progkd'");
		$rdtu2 = mysql_fetch_assoc($qdtu2);
		$tdtu2 = mysql_num_rows($qdtu2);
		$dtu2_ns = nosql($rdtu2['nil_ns']);
		$dtu2_nk = nosql($rdtu2['nil_nk']);

		$worksheet1->write_string($dt_nox,3+$totalku,$dtu2_ns);
		$worksheet1->write_string($dt_nox,3+$totalku+1,$dtu2_nk);
		}
	while ($rdt = mysql_fetch_assoc($qdt));


	//close
	$workbook->close();


	//diskonek
	xclose($koneksi);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&smtkd=$smtkd&progkd=$progkd&mpkd=$mpkd&kompkd=$kompkd";
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

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/menu/admgr.php");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php?tapelkd='.$tapelkd.'" title="Daftar Standar Kompetensi">Daftar Standar Kompetensi</a>]</td>
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

echo '<strong>'.$btxkelas.'</strong>,

Keahlian : ';
//terpilih
$qprgx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['program']);

echo '<strong>'.$prgx_prog.'</strong>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Standar Kompetensi : ';

//program pendidikan-terpilih
$qpelx = mysql_query("SELECT m_guru.*, m_guru_prog_pddkn.*, m_guru_prog_pddkn.kd AS mmkd, ".
			"m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, m_pegawai.* ".
			"FROM m_guru, m_guru_prog_pddkn, m_prog_pddkn, m_pegawai ".
			"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
			"AND m_guru_prog_pddkn.kd_prog_pddkn = m_prog_pddkn.kd ".
			"AND m_guru.kd_tapel = '$tapelkd' ".
			"AND m_guru.kd_keahlian = '$keahkd' ".
			"AND m_guru.kd_kelas = '$kelkd' ".
			"AND m_guru.kd_pegawai = m_pegawai.kd ".
			"AND m_guru_prog_pddkn.kd = '$mmkd'");
$rpelx = mysql_fetch_assoc($qpelx);
$pelx_kd = nosql($rpelx['mmkd']);
$pelx_mpkd = nosql($rpelx['mpkd']);
$pelx_pel = balikin($rpelx['prog_pddkn']);
$pelx_nip = nosql($rpelx['nip']);
$pelx_nm = balikin($rpelx['nama']);

echo '<strong>'.$pelx_pel.'</strong>,

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

	echo '<option value="'.$filenya.'?progkd='.$progkd.'&mmkd='.$mmkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&mpkd='.$mpkd.'&kompkd='.$kompkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="keahkd" type="hidden" value="'.$keahkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="mpkd" type="hidden" value="'.$mpkd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
<input name="mmkd" type="hidden" value="'.$mmkd.'">
<input name="s" type="hidden" value="'.$s.'">
<br>';


//nek drg
if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
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
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnIM2" type="submit" value="IMPORT >>">
		</p>';
		}
	else
		{
		echo '<input name="btnIM" type="submit" value="IMPORT">
		<input name="btnEX" type="submit" value="EXPORT">';



		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
				"siswa_kelas.*, siswa_kelas.kd AS skkd ".
				"FROM m_siswa, siswa_kelas ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kelkd' ".
				"AND siswa_kelas.kd_keahlian = '$keahkd' ".
				"ORDER BY m_siswa.nis ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kelkd=$kelkd&smtkd=$smtkd&mmkd=$mmkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);


/*
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
*/
		$hi_mpkd = $mpkd;


		//jumlah kompetensi
		$qku4xu = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
		//			"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"WHERE kd_prog_pddkn_kelas = '$mpkd' ".
					"AND kd_smt = '$smtkd'");
		$rowku4xu = mysql_fetch_assoc($qku4xu);
		$totalku4xu = mysql_num_rows($qku4xu);


		//nek ada
		if ($count != 0)
			{
			//kelas program pendidikan
			$qhi = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd, ".
						"m_prog_pddkn.*, m_prog_pddkn.kd AS mkkd ".
						"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$pelx_mpkd'");
			$rowhi = mysql_fetch_assoc($qhi);
			$totalhi = mysql_num_rows($qhi);
//			$hi_mpkd = nosql($rowhi['mpkd']);
			$hi_mpkd = $mpkd;


			echo '<table border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warnaheader.'">
			<td width="50"><strong>NIS</strong></td>
			<td width="150"><strong>Nama</strong></td>';

			//query-kategori
			$qku = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
//						"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
						"WHERE kd_prog_pddkn_kelas = '$mpkd' ".
						"AND kd_smt = '$smtkd' ".
						"ORDER BY kode ASC");
			$rowku = mysql_fetch_assoc($qku);
			$totalku = mysql_num_rows($qku);


			do
				{
				//nilai
				$ku_kd = nosql($rowku['kd']);
				$ku_kode = nosql($rowku['kode']);

				echo '<td align="center"><strong>'.$ku_kode.'</strong></td>';
				}
			while ($rowku = mysql_fetch_assoc($qku));

			echo '<td width="10" align="center"><strong>NK</strong></td>
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

				$i_nomer = $i_nomer + 1;
				$i_mskd = nosql($data['mskd']);
				$i_skkd = nosql($data['skkd']);
				$i_nis = nosql($data['nis']);
				$i_nama = balikin($data['nama']);


				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td valign="top">
				<input name="skkd'.$i_nomer.'" type="hidden" value="'.$i_skkd.'">
				<input name="mskd'.$i_nomer.'" type="hidden" value="'.$i_mskd.'">
				'.$i_nis.'
				</td>
				<td valign="top">
				'.$i_nama.'
				</td>';


				//query-kategori
				$qku = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
							"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
							"AND kd_smt = '$smtkd' ".
							"ORDER BY kode ASC");
				$rowku = mysql_fetch_assoc($qku);
				$totalku = mysql_num_rows($qku);


				do
					{
					//nilai
					$nomerku = $nomerku + 1;
					$ku_kd = nosql($rowku['kd']);



					//nilainya
					$qdtu = mysql_query("SELECT * FROM siswa_nilai_kompetensi ".
								"WHERE kd_siswa_kelas = '$i_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn_kompetensi = '$ku_kd'");
					$rdtu = mysql_fetch_assoc($qdtu);
					$tdtu = mysql_num_rows($qdtu);
					$dtu_nkd = nosql($rdtu['nil_nkd']);

					echo '<td>
					<input name="'.$i_nomer.'nkd'.$nomerku.'" type="text" value="'.$dtu_nkd.'" size="3" maxlength="5">
					</td>';
					}
				while ($rowku = mysql_fetch_assoc($qku));

				//nilainya
				$qdtu2 = mysql_query("SELECT * FROM siswa_nilai_kompetensi2 ".
							"WHERE kd_siswa_kelas = '$i_skkd' ".
							"AND kd_smt = '$smtkd' ".
//							"AND kd_prog_pddkn = '$pelx_mpkd'");
							"AND kd_prog_pddkn = '$progkd'");
				$rdtu2 = mysql_fetch_assoc($qdtu2);
				$tdtu2 = mysql_num_rows($qdtu2);
				$dtu2_ns = nosql($rdtu2['nil_ns']);
				$dtu2_nk = nosql($rdtu2['nil_nk']);

				echo '<td>
				<input name="nk'.$i_nomer.'" type="text" value="'.$dtu2_nk.'" size="3" maxlength="5" class="input" readonly>
				</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="250">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnRST" type="submit" value="RESET">
			<input name="jml" type="hidden" value="'.$limit.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="total" type="hidden" value="'.$count.'">
			<font color="#FF0000"><strong>'.$count.'</strong></font> Data.
			</tr>
			</table>
			</form>';
			}
		else
			{
			echo '<p>
			<font color="red">
			<strong>TIDAK ADA DATA.</strong>
			</font>
			</p>';
			}
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
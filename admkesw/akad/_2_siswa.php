<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admkesw.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa.php";
$judul = "Data Siswa";
$judulku = "[$kesw_session : $nip12_session. $nm12_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$swkd = nosql($_REQUEST['swkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&page=$page";







//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($keahkd))
	{
	$diload = "document.formx.keahlian.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.kompetensi.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else
	{
	if ($a == "a")
		{
		$diload = "document.formx.nis.focus();";
		}

	else if ($a == "b")
		{
		$diload = "document.formx.alamat.focus();";
		}

	else if ($a == "c")
		{
		$diload = "document.formx.gol_darah.focus();";
		}

	else if ($a == "d")
		{
		$diload = "document.formx.lulusan.focus();";
		}

	else if ($a == "e")
		{
		$diload = "document.formx.nama.focus();";
		}

	else if ($a == "f")
		{
		$diload = "document.formx.nama.focus();";
		}

	else if ($a == "g")
		{
		$diload = "document.formx.nama.focus();";
		}

	else if ($a == "h")
		{
		$diload = "document.formx.kesenian.focus();";
		}

	else if ($a == "i")
		{
		$diload = "document.formx.bea_siswa.focus();";
		}

	else if ($a == "j")
		{
		$diload = "document.formx.melanjutkan_di.focus();";
		}

	else if ($a == "k")
		{
		$diload = "document.formx.nm_sakit.focus();";
		}
	}


//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}





//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);


	//cek mapel
	if ((empty($tapelkd)) OR (empty($kelkd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//require
		include("../../inc/class/excel/excelwriter.inc.php");
		
		
		//Buat nama file yang di inginkan
		$excelfile = 'siswa_'.date("Y-m-d-H-i-s").'.xls';
		//lokasi hasil konversi
		$lokasi	   = '../../filebox/excel/';
		$excel=new ExcelWriter($lokasi.$excelfile);
		
		
		
		//Buat header untuk tabel
		$myArr = array("NO_URUT","NIS","NISN","NAMA_LENGKAP","NAMA_PANGGILAN","KELAMIN","TMP_LAHIR", 
						"TGL_LAHIR","AGAMA","WARGA_NEGARA","ANAK_KE","JML_SDR_KANDUNG","JML_SDR_TIRI",  
						"JML_SDR_ANGKAT","BAHASA","ALAMAT","TELP","JARAK_TMP_TINGGAL","GOL_DARAH", 
						"PENYAKIT","KELAINAN","TB","BB","TAMAT_DARI","TGL_IJAZAH","NO_IJAZAH", 
						"LAMA_BELAJAR","DITERIMA_KELAS","TGL_DITERIMA","AYAH_NAMA","AYAH_TMP_NAMA",  
						"AYAH_TGL_LAHIR","AYAH_AGAMA","AYAH_WARGA_NEGARA","AYAH_PENDIDIKAN", 
						"AYAH_PEKERJAAN","AYAH_PENGHASILAN","AYAH_ALAMAT","AYAH_TELP","AYAH_HIDUP", 
						"IBU_NAMA","IBU_TMP_NAMA","IBU_TGL_LAHIR","IBU_AGAMA","IBU_WARGA_NEGARA", 
						"IBU_PENDIDIKAN","IBU_PEKERJAAN","IBU_PENGHASILAN","IBU_ALAMAT","IBU_TELP", 
						"IBU_HIDUP","WALI_NAMA","WALI_TMP_NAMA","WALI_TGL_LAHIR","WALI_AGAMA", 
						"WALI_WARGA_NEGARA","WALI_PENDIDIKAN","WALI_PEKERJAAN","WALI_PENGHASILAN", 
						"WALI_ALAMAT","WALI_TELP","GEMAR_SENI","GEMAR_OR","GEMAR_LAIN","BEA_SISWA");		
		$excel->writeLine($myArr);

		
		





		//data
		$qdt = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS lahir_tgl, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS lahir_bln, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS lahir_thn, ".
					"siswa_kelas.*, siswa_kelas.kd AS skkd ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_keahlian = '$keahkd' ".
					"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"ORDER BY round(m_siswa.nis) ASC");
		$rdt = mysql_fetch_assoc($qdt);

		do
		  	{
			//nilai
			$dt_nox = $dt_nox + 1;
			$dt_mskd = nosql($rdt['mskd']);
			$dt_skkd = nosql($rdt['skkd']);
			$dt_no = nosql($rdt['no_absen']);
			$dt_nis = nosql($rdt['nis']);
			$dt_nisn = nosql($rdt['nisn']);
			$dt_nama = balikin($rdt['nama']);
			$dt_panggilan = balikin($rdt['panggilan']);
			$dt_tmp_lahir = balikin($rdt['tmp_lahir']);

			$dt_lahir_tgl = nosql($rdt['lahir_tgl']);
			$dt_lahir_bln = nosql($rdt['lahir_bln']);
			$dt_lahir_thn = nosql($rdt['lahir_thn']);
			$dt_tgl_lahir = "$dt_lahir_tgl/$dt_lahir_bln/$dt_lahir_thn";

			$dt_kd_kelamin = nosql($rdt['kd_kelamin']);
			$qkela = mysql_query("SELECT * FROM m_kelamin ".
									"WHERE kd = '$dt_kd_kelamin'");
			$rkela = mysql_fetch_assoc($qkela);
			$dt_kelamin = nosql($rkela['kelamin']);

			$dt_kd_agama = nosql($rdt['kd_agama']);
			$qagm = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd = '$dt_kd_agama'");
			$ragm = mysql_fetch_assoc($qagm);
			$dt_agama = balikin($ragm['agama']);

			$dt_warga_negara = balikin($rdt['warga_negara']);
			$dt_anak_ke = balikin($rdt['anak_ke']);
			$dt_jml_sdr_kandung = nosql($rdt['jml_sdr_kandung']);
			$dt_jml_sdr_tiri = nosql($rdt['jml_sdr_tiri']);
			$dt_jml_sdr_angkat = nosql($rdt['jml_sdr_angkat']);
			$dt_bahasa = nosql($rdt['bhs_harian']);





			//tmp_tinggal
			$qtpg = mysql_query("SELECT * FROM m_siswa_tmp_tinggal ".
									"WHERE kd_siswa = '$dt_mskd'");
			$rtpg = mysql_fetch_assoc($qtpg);
			$dt_alamat = balikin($rtpg['alamat']);
			$dt_telp = balikin($rtpg['telp']);
			$dt_jarak = balikin($rtpg['jarak']);





			//kesehatan
			$qsht = mysql_query("SELECT * FROM m_siswa_kesehatan ".
									"WHERE kd_siswa = '$dt_mskd'");
			$rsht = mysql_fetch_assoc($qsht);
			$dt_gol_darah = balikin($rsht['gol_darah']);
			$dt_penyakit = balikin($rsht['penyakit']);
			$dt_kelainan = balikin($rsht['kelainan']);
			$dt_tb = balikin($rsht['tinggi']);
			$dt_bb = balikin($rsht['berat']);





			//pendidikan
			$qpddk = mysql_query("SELECT m_siswa_pendidikan.*, DATE_FORMAT(tgl_sttb, '%d') AS sttb_tgl, ".
									"DATE_FORMAT(tgl_sttb, '%m') AS sttb_bln, ".
									"DATE_FORMAT(tgl_sttb, '%Y') AS sttb_thn ".
									"FROM m_siswa_pendidikan ".
									"WHERE kd_siswa = '$dt_mskd'");
			$rpddk = mysql_fetch_assoc($qpddk);
			$dt_tamat_dari = balikin($rpddk['lulusan']);

			$dt_sttb_tgl = nosql($rpddk['sttb_tgl']);
			$dt_sttb_bln = nosql($rpddk['sttb_bln']);
			$dt_sttb_thn = nosql($rpddk['sttb_thn']);
			$dt_tgl_ijazah = "$dt_sttb_tgl/$dt_sttb_bln/$dt_sttb_thn";

			$dt_no_ijazah = balikin($rpddk['no_sttb']);

			$dt_lama_belajar = balikin($rpddk['lama']);





			//diterima
			$qdti = mysql_query("SELECT m_siswa_diterima.*, DATE_FORMAT(tgl, '%d') AS dtgl, ".
									"DATE_FORMAT(tgl, '%m') AS dbln, ".
									"DATE_FORMAT(tgl, '%Y') AS dthn ".
									"FROM m_siswa_diterima ".
									"WHERE kd_siswa = '$dt_mskd'");
			$rdti = mysql_fetch_assoc($qdti);
			$dt_kelas = balikin($rdti['kelas']);
			$dt_kelas = balikin($rdti['kelas']);

			$dt_dtgl = nosql($rdti['dtgl']);
			$dt_dbln = nosql($rdti['dbln']);
			$dt_dthn = nosql($rdti['dthn']);
			$dt_tgl_diterima = "$dt_dtgl/$dt_dbln/$dt_dthn";





			//ayah
			$qayah = mysql_query("SELECT m_siswa_ayah.*, DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
									"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
									"DATE_FORMAT(tgl_lahir, '%Y') AS lthn ".
									"FROM m_siswa_ayah ".
									"WHERE kd_siswa = '$dt_mskd'");
			$rayah = mysql_fetch_assoc($qayah);
			$dt_ayah_nama = balikin($rayah['nama']);
			$dt_ayah_tmp_lahir = balikin($rayah['tmp_lahir']);

			$dt_ayah_tgl = nosql($rayah['ltgl']);
			$dt_ayah_bln = nosql($rayah['lbln']);
			$dt_ayah_thn = nosql($rayah['lthn']);
			$dt_ayah_tgl_lahir = "$dt_ayah_tgl/$dt_ayah_bln/$dt_ayah_thn";

			$dt_ayah_agama = balikin($rayah['kd_agama']);
			$qayah_agm = mysql_query("SELECT * FROM m_agama ".
										"WHERE kd = '$dt_ayah_agama'");
			$rayah_agm = mysql_fetch_assoc($qayah_agm);
			$dt_ayah_agama = balikin($rayah_agm['agama']);

			$dt_ayah_warga_negara = balikin($rayah['warga_negara']);
			$dt_ayah_pendidikan = balikin($rayah['pendidikan']);

			$dt_ayah_pekerjaan = balikin($rayah['kd_pekerjaan']);
			$qayah_pek = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE kd = '$dt_ayah_pekerjaan'");
			$rayah_pek = mysql_fetch_assoc($qayah_pek);
			$dt_ayah_pekerjaan = balikin($rayah_pek['pekerjaan']);

			$dt_ayah_penghasilan = balikin($rayah['penghasilan']);
			$dt_ayah_alamat = balikin($rayah['alamat']);
			$dt_ayah_telp = balikin($rayah['telp']);
			$dt_ayah_hidup = balikin($rayah['hidup']);





			//ibu
			$qibu = mysql_query("SELECT m_siswa_ibu.*, DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
									"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
									"DATE_FORMAT(tgl_lahir, '%Y') AS lthn ".
									"FROM m_siswa_ibu ".
									"WHERE kd_siswa = '$dt_mskd'");
			$ribu = mysql_fetch_assoc($qibu);
			$dt_ibu_nama = balikin($ribu['nama']);
			$dt_ibu_tmp_lahir = balikin($ribu['tmp_lahir']);

			$dt_ibu_tgl = nosql($ribu['ltgl']);
			$dt_ibu_bln = nosql($ribu['lbln']);
			$dt_ibu_thn = nosql($ribu['lthn']);
			$dt_ibu_tgl_lahir = "$dt_ibu_tgl/$dt_ibu_bln/$dt_ibu_thn";

			$dt_ibu_agama = balikin($ribu['kd_agama']);
			$qibu_agm = mysql_query("SELECT * FROM m_agama ".
										"WHERE kd = '$dt_ibu_agama'");
			$ribu_agm = mysql_fetch_assoc($qibu_agm);
			$dt_ibu_agama = balikin($ribu_agm['agama']);

			$dt_ibu_warga_negara = balikin($ribu['warga_negara']);
			$dt_ibu_pendidikan = balikin($ribu['pendidikan']);

			$dt_ibu_pekerjaan = balikin($ribu['kd_pekerjaan']);
			$qibu_pek = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE kd = '$dt_ibu_pekerjaan'");
			$ribu_pek = mysql_fetch_assoc($qibu_pek);
			$dt_ibu_pekerjaan = balikin($ribu_pek['pekerjaan']);

			$dt_ibu_penghasilan = balikin($ribu['penghasilan']);
			$dt_ibu_alamat = balikin($ribu['alamat']);
			$dt_ibu_telp = balikin($ribu['telp']);
			$dt_ibu_hidup = balikin($ribu['hidup']);





			///wali
			$qwali = mysql_query("SELECT m_siswa_wali.*, DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
									"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
									"DATE_FORMAT(tgl_lahir, '%Y') AS lthn ".
									"FROM m_siswa_wali ".
									"WHERE kd_siswa = '$dt_mskd'");
			$rwali = mysql_fetch_assoc($qwali);
			$dt_wali_nama = balikin($rwali['nama']);
			$dt_wali_tmp_lahir = balikin($rwali['tmp_lahir']);

			$dt_wali_tgl = nosql($rwali['ltgl']);
			$dt_wali_bln = nosql($rwali['lbln']);
			$dt_wali_thn = nosql($rwali['lthn']);
			$dt_wali_tgl_lahir = "$dt_wali_tgl/$dt_wali_bln/$dt_wali_thn";

			$dt_wali_agama = balikin($rwali['kd_agama']);
			$qwali_agm = mysql_query("SELECT * FROM m_agama ".
										"WHERE kd = '$dt_wali_agama'");
			$rwali_agm = mysql_fetch_assoc($qwali_agm);
			$dt_wali_agama = balikin($rwali_agm['agama']);

			$dt_wali_warga_negara = balikin($rwali['warga_negara']);
			$dt_wali_pendidikan = balikin($rwali['pendidikan']);

			$dt_wali_pekerjaan = balikin($rwali['kd_pekerjaan']);
			$qwali_pek = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE kd = '$dt_wali_pekerjaan'");
			$rwali_pek = mysql_fetch_assoc($qwali_pek);
			$dt_wali_pekerjaan = balikin($rwali_pek['pekerjaan']);

			$dt_wali_penghasilan = balikin($rwali['penghasilan']);
			$dt_wali_alamat = balikin($rwali['alamat']);
			$dt_wali_telp = balikin($rwali['telp']);






			//gemar/hobi
			$qgma = mysql_query("SELECT * FROM m_siswa_hobi ".
									"WHERE kd_siswa = '$dt_mskd'");
			$rgma = mysql_fetch_assoc($qgma);
			$dt_gemar_seni = balikin($rgma['kesenian']);
			$dt_gemar_or = balikin($rgma['olah_raga']);
			$dt_gemar_lain = balikin($rgma['lain_lain']);





			//perkembangan
			$qkbi = mysql_query("SELECT * FROM m_siswa_perkembangan ".
									"WHERE kd_siswa = '$dt_mskd'");
			$rkbi = mysql_fetch_assoc($qkbi);
			$dt_bea_siswa = balikin($rkbi['bea_siswa']);




			//ciptakan						
			$arr = array($i_nomer,$dt_nis,$dt_nisn,$dt_nama,$dt_panggilan,$dt_kelamin,$dt_tmp_lahir, 
							$dt_tgl_lahir,$dt_agama,$dt_warga_negara,$dt_anak_ke,$dt_jml_sdr_kandung, 
							$dt_jml_sdr_tiri,$dt_jml_sdr_angkat,$dt_bahasa,$dt_alamat,$dt_telp, 
							$dt_jarak,$dt_gol_darah,$dt_penyakit,$dt_kelainan,$dt_tb,$dt_bb, 
							$dt_tamat_dari,$dt_tgl_ijazah,$dt_no_ijazah,$dt_lama_belajar,$dt_kelas,
							$dt_tgl_diterima,$dt_ayah_nama,$dt_ayah_tmp_lahir,$dt_ayah_tgl_lahir,
							$dt_ayah_agama,$dt_ayah_warga_negara,$dt_ayah_pendidikan, 
							$dt_ayah_pekerjaan,$dt_ayah_penghasilan,$dt_ayah_alamat,$dt_ayah_telp, 
							$dt_ayah_hidup,$dt_ibu_nama,$dt_ibu_tmp_lahir,$dt_ibu_tgl_lahir, 
							$dt_ibu_agama,$dt_ibu_warga_negara,$dt_ibu_pendidikan,$dt_ibu_pekerjaan, 
							$dt_ibu_penghasilan,$dt_ibu_alamat,$dt_ibu_telp,$dt_ibu_hidup, 
							$dt_wali_nama,$dt_wali_tmp_lahir,$dt_wali_tgl_lahir,$dt_wali_agama, 
							$dt_wali_warga_negara,$dt_wali_pendidikan,$dt_wali_pekerjaan, 
							$dt_wali_penghasilan,$dt_wali_alamat,$dt_wali_telp,$dt_gemar_seni, 
							$dt_gemar_or,$dt_gemar_lain,$dt_bea_siswa);
							
	
			$excel->writeLine($arr);

			}
		while ($rdt = mysql_fetch_assoc($qdt));


		$excel -> close();


		//diskonek
		xclose($koneksi);


		//re-direct
//		$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd";
		$ke = "$lokasi$excelfile";
		xloc($ke);
		exit();
		}
	}





//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);


	//cek
	if ((empty($kelkd)) OR (empty($keahkd)) OR (empty($tapelkd)))
		{
		//re-direct
		$pesan = "Tahun Pelajaran atau Kelas, Belum Dipilih. Harap Diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&s=import";
		xloc($ke);
		exit();
		}
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&s=import";
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


			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex");

			//chmod
                        $path3 = "../../filebox/excel/$filex_namex";
			chmod($path1,0755);
			chmod($path2,0755);
			chmod($path3,0755);


			//re-direct
			$ke = "siswa_import.php?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&filex_namex=$filex_namex";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//jika print
if ($_POST['btnPRT'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);
	$swkd = nosql($_POST['swkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "siswa_pdf.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd";
	xloc($ke);
	exit();
	}





//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&page=$page";
	xloc($ke);
	exit();
	}



//jika daftar siswa
if ($_POST['btnDS'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&page=$page";
	xloc($ke);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$jml = nosql($_POST['jml']);
	$page = nosql($_POST['page']);


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM m_siswa ".
			"ORDER BY round(nis) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del data
		mysql_query("DELETE FROM m_siswa ".
				"WHERE kd = '$kd'");

		//nek $kd gak null
		if (!empty($kd))
			{
			//hapus file
			$cc_filex = $data['filex'];
			$path1 = "../../filebox/siswa/$kd/$cc_filex";
			unlink ($path1);
			}


		//del kelas
		mysql_query("DELETE FROM siswa_kelas ".
				"WHERE kd_siswa = '$kd'");
		}
	while ($data = mysql_fetch_assoc($result));

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}





//jika ganti foto profil
if ($_POST['btnGNT'])
	{
	//nilai
	$filex_namex = strip(strtolower($_FILES['filex_foto']['name']));
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_REQUEST['keahkd']);
	$kompkd = nosql($_REQUEST['kompkd']);
	$swkd = nosql($_POST['swkd']);
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);


	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=edit&swkd=$swkd&a=a#a";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".jpg")
			{
			//nilai
			$path1 = "../../filebox/siswa/$swkd";

			//cek, sudah ada belum
			if (!file_exists($path1))
				{
				//bikin folder kd_user
				mkdir("$path1", $chmod);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/siswa/$swkd/$filex_namex");

				//cek
				$qcc = mysql_query("SELECT * FROM m_siswa ".
										"WHERE kd = '$swkd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//query
					mysql_query("UPDATE m_siswa SET filex = '$filex_namex' ".
									"WHERE kd = '$swkd'");
					}
				else
					{
					mysql_query("INSERT INTO m_siswa(kd, filex) VALUES ".
									"('$swkd', '$filex_namex')");
					}

				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=edit&swkd=$swkd&a=a#a";
				xloc($ke);
				exit();
				}
			else
				{
				//hapus file yang ada dulu
				//query
				$qcc = mysql_query("SELECT * FROM m_siswa ".
										"WHERE kd = '$swkd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//hapus file
				$cc_filex = $rcc['filex'];
				$path1 = "../../filebox/siswa/$swkd/$cc_filex";
				unlink ($path1);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/siswa/$swkd/$filex_namex");

				//nek ada
				if ($tcc != 0)
					{
					//query
					mysql_query("UPDATE m_siswa SET filex = '$filex_namex', ".
									"postdate = '$today' ".
									"WHERE kd = '$swkd'");
					}
				else
					{
					mysql_query("INSERT INTO m_siswa(kd, filex) VALUES ".
									"('$swkd', '$filex_namex')");
					}


				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=edit&swkd=$swkd&a=a#a";
				xloc($ke);
				exit();
				}
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File Image .jpg . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=edit&swkd=$swkd&a=a#a";
			pekem($pesan,$ke);
			exit();
			}
		}
	}




//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_REQUEST['keahkd']);
	$kompkd = nosql($_REQUEST['kompkd']);
	$swkd = nosql($_POST['swkd']);


	//A. KETERANGAN TENTANG DIRI SISWA /////////////////////////////////////////////////////////////////////////////////////////////////
	if ($a == "a")
		{
		$nis = nosql($_POST['nis']);
		$nisn = nosql($_POST['nisn']);
		$nama = cegah($_POST['nama']);
		$panggilan = cegah($_POST['panggilan']);
		$kelamin = nosql($_POST['kelamin']);

		$tmp_lahir = cegah($_POST['tmp_lahir']);
		$lahir_tgl = nosql($_POST['lahir_tgl']);
		$lahir_bln = nosql($_POST['lahir_bln']);
		$lahir_thn = nosql($_POST['lahir_thn']);
		$tgl_lahir = "$lahir_thn:$lahir_bln:$lahir_tgl";

		$agama = nosql($_POST['agama']);
		$warga_negara = cegah($_POST['warga_negara']);
		$anak_ke = cegah($_POST['anak_ke']);
		$jml_sdr_kandung = nosql($_POST['jml_sdr_kandung']);
		$jml_sdr_tiri = nosql($_POST['jml_sdr_tiri']);
		$jml_sdr_angkat = nosql($_POST['jml_sdr_angkat']);
		$yatim_piatu = cegah($_POST['yatim_piatu']);
		$bahasa = cegah($_POST['bahasa']);


		//nek edit
		if ($s == "edit")
			{
			//nilai
			$s_userx = $nis;
			$s_passx = md5($nis);

			//update
			mysql_query("UPDATE m_siswa SET usernamex = '$s_userx', ".
					"passwordx = '$s_passx', ".
					"passwordx_ortu = '$s_passx', ".
					"nis = '$nis', ".
					"nisn = '$nisn', ".
					"nama = '$nama', ".
					"panggilan = '$panggilan', ".
					"tmp_lahir = '$tmp_lahir', ".
					"tgl_lahir = '$tgl_lahir', ".
					"kd_kelamin = '$kelamin', ".
					"kd_agama = '$agama', ".
					"warga_negara = '$warga_negara', ".
					"anak_ke = '$anak_ke', ".
					"jml_sdr_kandung = '$jml_sdr_kandung', ".
					"jml_sdr_tiri = '$jml_sdr_tiri', ".
					"jml_sdr_angkat = '$jml_sdr_angkat', ".
					"yatim_piatu = '$yatim_piatu', ".
					"bhs_harian = '$bahasa' ".
					"WHERE kd = '$swkd'");



			//update ke janissari
			mysql_query("UPDATE m_user SET usernamex = '$s_userx', ".
					"passwordx = '$s_passx', ".
					"nomor = '$nis', ".
					"nama = '$nama' ".
					"WHERE kd = '$swkd'");



			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=a#a";
			xloc($ke);
			exit();
			}



		//nek baru
		if ($s == "baru")
			{
			//nek null
			if ((empty($nis)) OR (empty($nama)))
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=baru&swkd=$swkd&a=$a#a";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//cek
				$qcc = mysql_query("SELECT * FROM m_siswa ".
							"WHERE nis = '$nis'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//re-direct
					$pesan = "NIS Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
					$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=baru&swkd=$x&a=$a#a";
					pekem($pesan,$ke);
					exit();
					}
				else
					{
					//insert ke biodata
					$s_userx = $nis;
					$s_passx = md5($nis);
					$xx = md5($today3);


					//insert data siswa
					mysql_query("INSERT INTO m_siswa(kd, usernamex, passwordx, passwordx_ortu, nis, nisn, nama, ".
							"panggilan, tmp_lahir, tgl_lahir, kd_kelamin, kd_agama, ".
							"warga_negara, anak_ke, jml_sdr_kandung, jml_sdr_tiri, ".
							"jml_sdr_angkat, yatim_piatu, bhs_harian) VALUES ".
							"('$swkd', '$s_userx', '$s_passx', '$s_passx', '$nis', '$nisn', '$nama', ".
							"'$panggilan', '$tmp_lahir', '$tgl_lahir', '$kelamin', '$agama', ".
							"'$warga_negara', '$anak_ke', '$jml_sdr_kandung', '$jml_sdr_tiri', ".
							"'$jml_sdr_angkat', '$yatim_piatu', '$bahasa')");



					//masukkan ke janissari
					mysql_query("INSERT INTO m_user(kd, usernamex, passwordx, nomor, nama, tipe, postdate) VALUES ".
							"('$swkd', '$s_userx', '$s_passx', '$nis', '$nama', 'SISWA', '$today')");



					//insert ke kelas
					mysql_query("INSERT INTO siswa_kelas(kd, kd_tapel, kd_kelas, kd_keahlian, ".
							"kd_keahlian_kompetensi, kd_siswa) VALUES ".
							"('$xx', '$tapelkd', '$kelkd', '$keahkd', ".
							"'$kompkd', '$swkd')");

					//diskonek
					xfree($qbw);
					xclose($koneksi);

					//re-direct
					$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=edit&swkd=$swkd&a=$a#a";
					xloc($ke);
					exit();
					}
				}
			}
		}




	//B. KETERANGAN TEMPAT TINGGAL /////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "b")
		{
		$alamat = cegah($_POST['alamat']);
		$telp = cegah($_POST['telp']);
		$tinggal_dgn = cegah($_POST['tinggal_dgn']);
		$jarak = cegah($_POST['jarak']);


		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa_tmp_tinggal ".
									"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_tmp_tinggal SET alamat = '$alamat', ".
								"telp = '$telp', ".
								"tinggal_dgn = '$tinggal_dgn', ".
								"jarak = '$jarak' ".
								"WHERE kd_siswa = '$swkd'");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=b#b";
				xloc($ke);
				exit();
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_tmp_tinggal(kd, kd_siswa, alamat, telp, tinggal_dgn, jarak) VALUES ".
								"('$x', '$swkd', '$alamat', '$telp', '$tinggal_dgn', '$jarak')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=edit&swkd=$swkd&a=b#b";
				xloc($ke);
				exit();
				}
			}
		}




	//C. KETERANGAN KESEHATAN //////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "c")
		{
		$gol_darah = cegah($_POST['gol_darah']);
		$penyakit = cegah($_POST['penyakit']);
		$kelainan = cegah($_POST['kelainan']);
		$berat = nosql($_POST['berat']);
		$tinggi = nosql($_POST['tinggi']);



		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa_kesehatan ".
									"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_kesehatan SET gol_darah = '$gol_darah', ".
								"penyakit = '$penyakit', ".
								"kelainan = '$kelainan', ".
								"berat = '$berat', ".
								"tinggi = '$tinggi' ".
								"WHERE kd_siswa = '$swkd'");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=c#c";
				xloc($ke);
				exit();
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_kesehatan(kd, kd_siswa, gol_darah, penyakit, kelainan, berat, tinggi) VALUES ".
								"('$x', '$swkd', '$gol_darah', '$penyakit', '$kelainan', '$berat', '$tinggi')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=edit&swkd=$swkd&a=c#c";
				xloc($ke);
				exit();
				}
			}
		}




	//D. KETERANGAN PENDIDIKAN /////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "d")
		{
		//lulusan
		$lulusan = cegah($_POST['lulusan']);
		$no_sttb = nosql($_POST['no_sttb']);
		$lama = nosql($_POST['lama']);

		$sttb_tgl = nosql($_POST['sttb_tgl']);
		$sttb_bln = nosql($_POST['sttb_bln']);
		$sttb_thn = nosql($_POST['sttb_thn']);
		$tgl_sttb = ("$sttb_thn:$sttb_bln:$sttb_tgl");


		//pindahan
		$dari = cegah($_POST['dari']);
		$alasan = cegah($_POST['alasan']);


		//diterima
		$kelas = cegah($_POST['kelas']);
		$keahlian = cegah($_POST['keahlian']);
		$terima_tgl = nosql($_POST['terima_tgl']);
		$terima_bln = nosql($_POST['terima_bln']);
		$terima_thn = nosql($_POST['terima_thn']);
		$tgl_diterima = ("$terima_thn:$terima_bln:$terima_tgl");



		//nek edit
		if ($s == "edit")
			{
			//cek lulusan //////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$qcc = mysql_query("SELECT * FROM m_siswa_pendidikan ".
									"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_pendidikan SET lulusan = '$lulusan', ".
								"tgl_sttb = '$tgl_sttb', ".
								"no_sttb = '$no_sttb', ".
								"lama = '$lama' ".
								"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_pendidikan(kd, kd_siswa, lulusan, tgl_sttb, no_sttb, lama) VALUES ".
								"('$x', '$swkd', '$lulusan', '$tgl_sttb', '$no_sttb', '$lama')");
				}



			//cek pindahan /////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$qcc1 = mysql_query("SELECT * FROM m_siswa_pindahan ".
									"WHERE kd_siswa = '$swkd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$tcc1 = mysql_num_rows($qcc1);

			//nek ada
			if ($tcc1 != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_pindahan SET dari = '$dari', ".
								"alasan = '$alasan' ".
								"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_pindahan(kd, kd_siswa, dari, alasan) VALUES ".
								"('$x', '$swkd', '$dari', '$alasan')");
				}



			//cek diterima /////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$qcc2 = mysql_query("SELECT * FROM m_siswa_diterima ".
									"WHERE kd_siswa = '$swkd'");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$tcc2 = mysql_num_rows($qcc2);

			//nek ada
			if ($tcc2 != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_diterima SET kelas = '$kelas', ".
								"keahlian = '$keahlian', ".
								"tgl = '$tgl_diterima' ".
								"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_diterima(kd, kd_siswa, kelas, keahlian, tgl) VALUES ".
								"('$x', '$swkd', '$kelas', '$keahlian', '$tgl_diterima')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=d#d";
			xloc($ke);
			exit();
			}
		}




	//E. KETERANGAN TENTANG AYAH KANDUNG ///////////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "e")
		{
		//nilai
		$nama = cegah($_POST['nama']);
		$tmp_lahir = cegah($_POST['tmp_lahir']);

		$lahir_tgl = nosql($_POST['lahir_tgl']);
		$lahir_bln = nosql($_POST['lahir_bln']);
		$lahir_thn = nosql($_POST['lahir_thn']);
		$tgl_lahir = ("$lahir_thn:$lahir_bln:$lahir_tgl");

		$agama = cegah($_POST['agama']);
		$warga_negara = cegah($_POST['warga_negara']);
		$pendidikan = cegah($_POST['pendidikan']);
		$pekerjaan = cegah($_POST['pekerjaan']);
		$pendapatan = cegah($_POST['pendapatan']);
		$alamat = cegah($_POST['alamat']);
		$telepon = cegah($_POST['telepon']);
		$hidup = cegah($_POST['hidup']);


		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa_ayah ".
									"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_ayah SET nama = '$nama', ".
								"tmp_lahir = '$tmp_lahir', ".
								"tgl_lahir = '$tgl_lahir', ".
								"kd_agama = '$agama', ".
								"warga_negara = '$warga_negara', ".
								"pendidikan = '$pendidikan', ".
								"kd_pekerjaan = '$pekerjaan', ".
								"penghasilan = '$pendapatan', ".
								"alamat = '$alamat', ".
								"telp = '$telepon', ".
								"hidup = '$hidup' ".
								"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_ayah(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
								"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp, hidup) VALUES ".
								"('$x', '$swkd', '$nama', '$tmp_lahir', '$tgl_lahir', '$agama', ".
								"'$warga_negara', '$pendidikan', '$pekerjaan', '$pendapatan', '$alamat', '$telepon', '$hidup')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=e#e";
			xloc($ke);
			exit();
			}
		}




	//F. KETERANGAN TENTANG IBU KANDUNG ////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "f")
		{
		//nilai
		$nama = cegah($_POST['nama']);
		$tmp_lahir = cegah($_POST['tmp_lahir']);

		$lahir_tgl = nosql($_POST['lahir_tgl']);
		$lahir_bln = nosql($_POST['lahir_bln']);
		$lahir_thn = nosql($_POST['lahir_thn']);
		$tgl_lahir = ("$lahir_thn:$lahir_bln:$lahir_tgl");

		$agama = cegah($_POST['agama']);
		$warga_negara = cegah($_POST['warga_negara']);
		$pendidikan = cegah($_POST['pendidikan']);
		$pekerjaan = cegah($_POST['pekerjaan']);
		$pendapatan = cegah($_POST['pendapatan']);
		$alamat = cegah($_POST['alamat']);
		$telepon = cegah($_POST['telepon']);
		$hidup = cegah($_POST['hidup']);


		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa_ibu ".
									"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_ibu SET nama = '$nama', ".
								"tmp_lahir = '$tmp_lahir', ".
								"tgl_lahir = '$tgl_lahir', ".
								"kd_agama = '$agama', ".
								"warga_negara = '$warga_negara', ".
								"pendidikan = '$pendidikan', ".
								"kd_pekerjaan = '$pekerjaan', ".
								"penghasilan = '$pendapatan', ".
								"alamat = '$alamat', ".
								"telp = '$telepon', ".
								"hidup = '$hidup' ".
								"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_ibu(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
								"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp, hidup) VALUES ".
								"('$x', '$swkd', '$nama', '$tmp_lahir', '$tgl_lahir', '$agama', ".
								"'$warga_negara', '$pendidikan', '$pekerjaan', '$pendapatan', '$alamat', '$telepon', '$hidup')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=f#f";
			xloc($ke);
			exit();
			}
		}




	//G. KETERANGAN TENTANG WALI ///////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "g")
		{
		//nilai
		$nama = cegah($_POST['nama']);
		$tmp_lahir = cegah($_POST['tmp_lahir']);

		$lahir_tgl = nosql($_POST['lahir_tgl']);
		$lahir_bln = nosql($_POST['lahir_bln']);
		$lahir_thn = nosql($_POST['lahir_thn']);
		$tgl_lahir = ("$lahir_thn:$lahir_bln:$lahir_tgl");

		$agama = cegah($_POST['agama']);
		$warga_negara = cegah($_POST['warga_negara']);
		$pendidikan = cegah($_POST['pendidikan']);
		$pekerjaan = cegah($_POST['pekerjaan']);
		$pendapatan = cegah($_POST['pendapatan']);
		$alamat = cegah($_POST['alamat']);
		$telepon = cegah($_POST['telepon']);


		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa_wali ".
									"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_wali SET nama = '$nama', ".
								"tmp_lahir = '$tmp_lahir', ".
								"tgl_lahir = '$tgl_lahir', ".
								"kd_agama = '$agama', ".
								"warga_negara = '$warga_negara', ".
								"pendidikan = '$pendidikan', ".
								"kd_pekerjaan = '$pekerjaan', ".
								"penghasilan = '$pendapatan', ".
								"alamat = '$alamat', ".
								"telp = '$telepon' ".
								"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_wali(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
								"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp) VALUES ".
								"('$x', '$swkd', '$nama', '$tmp_lahir', '$tgl_lahir', '$agama', ".
								"'$warga_negara', '$pendidikan', '$pekerjaan', '$pendapatan', '$alamat', '$telepon')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=g#g";
			xloc($ke);
			exit();
			}
		}




	//H. KEGEMARAN SISWA ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "h")
		{
		//nilai
		$kesenian = cegah($_POST['kesenian']);
		$olah_raga = cegah($_POST['olah_raga']);
		$organisasi = cegah($_POST['organisasi']);
		$lain_lain = cegah($_POST['lain_lain']);


		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa_hobi ".
									"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_hobi SET kesenian = '$kesenian', ".
								"olah_raga = '$olah_raga', ".
								"organisasi = '$organisasi', ".
								"lain_lain = '$lain_lain' ".
								"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_hobi(kd, kd_siswa, kesenian, olah_raga, organisasi, lain_lain) VALUES ".
								"('$x', '$swkd', '$kesenian', '$olah_raga', '$organisasi', '$lain_lain')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=h#h";
			xloc($ke);
			exit();
			}
		}




	//I. KETERANGAN PERKEMBANGAN SISWA /////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "i")
		{
		//nilai
		$bea_siswa = cegah($_POST['bea_siswa']);

		$tinggal_tgl = nosql($_POST['tinggal_tgl']);
		$tinggal_bln = nosql($_POST['tinggal_bln']);
		$tinggal_thn = nosql($_POST['tinggal_thn']);
		$tgl_tinggal = ("$tinggal_thn:$tinggal_bln:$tinggal_tgl");

		$ijazah_terima_tgl = nosql($_POST['ijazah_terima_tgl']);
		$ijazah_terima_bln = nosql($_POST['ijazah_terima_bln']);
		$ijazah_terima_thn = nosql($_POST['ijazah_terima_thn']);
		$tgl_terima_ijazah = ("$ijazah_terima_thn:$ijazah_terima_bln:$ijazah_terima_tgl");

		$ijazah_tgl = nosql($_POST['ijazah_tgl']);
		$ijazah_bln = nosql($_POST['ijazah_bln']);
		$ijazah_thn = nosql($_POST['ijazah_thn']);
		$tgl_ijazah = ("$ijazah_thn:$ijazah_bln:$ijazah_tgl");

		$tulis_tgl = nosql($_POST['tulis_tgl']);
		$tulis_bln = nosql($_POST['tulis_bln']);
		$tulis_thn = nosql($_POST['tulis_thn']);
		$tgl_tulis = ("$tulis_thn:$tulis_bln:$tulis_tgl");



		$alasan = cegah($_POST['alasan']);
		$tamat = cegah($_POST['tamat']);
		$no_sttb = cegah($_POST['no_sttb']);

		$pindah_kelas = cegah($_POST['pindah_kelas']);
		$no_surat = cegah($_POST['no_surat']);
		$ket = cegah($_POST['ket']);



		//dinyatakan jadi alumni, jika telah tertulis tanggal ijazah dan tanggal terima ijazah.
		if (($tgl_terima_ijazah != "0000:00:00") AND ($tgl_ijazah != "0000:00:00"))
			{
			$st_alumni = "true";
			}
		else
			{
			$st_alumni = "false";
			}



		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa_perkembangan ".
						"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_perkembangan SET bea_siswa = '$bea_siswa', ".
						"tgl = '$tgl_tinggal', ".
						"tgl_terima_ijazah = '$tgl_terima_ijazah', ".
						"tgl_ijazah = '$tgl_ijazah', ".
						"tgl_tulis = '$today', ".
						"alasan = '$alasan', ".
						"tamat = '$tamat', ".
						"no_sttb = '$no_sttb', ".
						"pindah_kelas = '$pindah_kelas', ".
						"no_surat = '$no_surat', ".
						"ket = '$ket', ".
						"alumni = '$st_alumni' ".
						"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_perkembangan(kd, kd_siswa, bea_siswa, ".
						"tgl, tgl_terima_ijazah, tgl_ijazah, tgl_tulis, alasan, ".
						"tamat, no_sttb, pindah_kelas, no_surat, ket, alumni) VALUES ".
						"('$x', '$swkd', '$bea_siswa', ".
						"'$tgl_tinggal', '$tgl_terima_ijazah', '$tgl_ijazah', '$today', '$alasan', ".
						"'$tamat', '$no_sttb', '$pindah', '$no_surat', '$ket', '$st_alumni')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&tapelkd=$tapelkd&keahkd=$keahkd&kelkd=$kelkd&kompkd=$kompkd&swkd=$swkd&a=i#i";
			xloc($ke);
			exit();
			}
		}




	//J. KETERANGAN SETELAH SELESAI PENDIDIKAN /////////////////////////////////////////////////////////////////////////////////////////
	else if ($a == "j")
		{
		//nilai
		$melanjutkan_di = cegah($_POST['melanjutkan_di']);
		$bekerja = cegah($_POST['bekerja']);

		$kerja_tgl = nosql($_POST['kerja_tgl']);
		$kerja_bln = nosql($_POST['kerja_bln']);
		$kerja_thn = nosql($_POST['kerja_thn']);
		$tgl_kerja = ("$kerja_thn:$kerja_bln:$kerja_tgl");

		$instansi = cegah($_POST['instansi']);
		$penghasilan = cegah($_POST['penghasilan']);




		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa_selesai ".
									"WHERE kd_siswa = '$swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_siswa_selesai SET melanjutkan_di = '$melanjutkan_di', ".
								"bekerja = '$bekerja', ".
								"tgl = '$tgl_kerja', ".
								"instansi = '$instansi', ".
								"penghasilan = '$penghasilan' ".
								"WHERE kd_siswa = '$swkd'");
				}

			//nek blm ada
			else
				{
				//insert
				mysql_query("INSERT INTO m_siswa_selesai(kd, kd_siswa, melanjutkan_di, bekerja, tgl, instansi, penghasilan) VALUES ".
								"('$x', '$swkd', '$melanjutkan_di', '$bekerja', '$tgl_kerja', '$instansi', '$penghasilan')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&swkd=$swkd&a=j#j";
			xloc($ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//menu
require("../../inc/menu/admkesw.php");

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
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,


Program Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['bidang']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keahkd' ".
			"ORDER BY bidang ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['bidang']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keahkd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>,




Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keahkd' ".
			"AND kd = '$kompkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['kompetensi']);
$keax_singk = nosql($rowkeax['singkatan']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keahkd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['kompetensi']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&kompkd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna01.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Kelas : ';

echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd <> '$kelkd' ".
			"AND kelas LIKE '%$keax_singk%' ".
			"ORDER BY kelas ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&kompkd='.$kompkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="keahkd" type="hidden" value="'.$keahkd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
<input name="swkd" type="hidden" value="'.$swkd.'">

<input name="btnIM" type="submit" value="IMPORT">
<input name="btnEX" type="submit" value="EXPORT">
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}
else if (empty($keahkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>PROGRAM KEAHLIAN Belum Dipilih...!</strong></font>
	</p>';
	}
else if (empty($kompkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KOMPETENSI KEAHLIAN Belum Dipilih...!</strong></font>
	</p>';
	}
else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	//entry baru / edit
	if (($s == "baru") OR ($s == "edit"))
		{
		//nilai
		$swkd = nosql($_REQUEST['swkd']);
		$tapelkd = nosql($_REQUEST['tapelkd']);
		$kelkd = nosql($_REQUEST['kelkd']);
		$keahkd = nosql($_REQUEST['keahkd']);
		$kompkd = nosql($_REQUEST['kompkd']);


		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="a"></a>
		<strong>A. KETERANGAN TENTANG DIRI SISWA</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=a#a" title="A. KETERANGAN TENTANG DIRI SISWA">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "a")
			{
			//query
			$qnil = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS lahir_tgl, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS lahir_bln, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS lahir_thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_nis = nosql($rnil['nis']);
			$y_nisn = nosql($rnil['nisn']);
			$y_nama = balikin($rnil['nama']);
			$y_panggilan = balikin($rnil['panggilan']);
			$y_jkelkd = nosql($rnil['kd_kelamin']);

			$y_tmp_lahir = balikin($rnil['tmp_lahir']);
			$y_lahir_tgl = nosql($rnil['lahir_tgl']);
			$y_lahir_bln = nosql($rnil['lahir_bln']);
			$y_lahir_thn = nosql($rnil['lahir_thn']);

			$y_agmkd = nosql($rnil['kd_agama']);
			$y_warga_negara = balikin2($rnil['warga_negara']);
			$y_anak_ke = nosql($rnil['anak_ke']);
			$y_jml_sdr_kandung = nosql($rnil['jml_sdr_kandung']);
			$y_jml_sdr_tiri = nosql($rnil['jml_sdr_tiri']);
			$y_jml_sdr_angkat = nosql($rnil['jml_sdr_angkat']);
			$y_yatim_piatu = balikin2($rnil['yatim_piatu']);
			$y_bahasa = balikin2($rnil['bhs_harian']);
			$y_filex = $rnil['filex'];

			//view
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr valign="top">
			<td width="80%">

			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			NIS
			</td>
			<td width="10">: </td>
			<td>
			<input name="nis" type="text" value="'.$y_nis.'" size="30" onKeyPress="return numbersonly(this, event)">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			NISN
			</td>
			<td width="10">: </td>
			<td>
			<input name="nisn" type="text" value="'.$y_nisn.'" size="30" onKeyPress="return numbersonly(this, event)">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			1. Nama Siswa
			</td>
			<td width="10"></td>
			<td></td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			a. Nama Lengkap
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="nama" type="text" value="'.$y_nama.'" size="20">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			b. Panggilan
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="panggilan" type="text" value="'.$y_panggilan.'" size="20">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			2. Jenis Kelamin
			</td>
			<td width="10">: </td>
			<td>
			<select name="kelamin">';

			//terpilih
			$qjkelx = mysql_query("SELECT * FROM m_kelamin ".
									"WHERE kd = '$y_jkelkd'");
			$rjkelx = mysql_fetch_assoc($qjkelx);
			$jkelx_kd = nosql($rjkelx['kd']);
			$jkelx_kelamin = balikin($rjkelx['kelamin']);

			echo '<option value="'.$jkelx_kd.'">'.$jkelx_kelamin.'</option>';

			$qjkel = mysql_query("SELECT * FROM m_kelamin ".
									"WHERE kd <> '$y_jkelkd' ".
									"ORDER BY kelamin ASC");
			$rjkel = mysql_fetch_assoc($qjkel);

			do
				{
				$jkel_kd = nosql($rjkel['kd']);
				$jkel_kelamin = balikin($rjkel['kelamin']);

				echo '<option value="'.$jkel_kd.'">'.$jkel_kelamin.'</option>';
				}
			while ($rjkel = mysql_fetch_assoc($qjkel));

			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			3. TTL
			</td>
			<td width="10">: </td>
			<td>
			<input name="tmp_lahir" type="text" value="'.$y_tmp_lahir.'" size="30">,
			<select name="lahir_tgl">
			<option value="'.$y_lahir_tgl.'" selected>'.$y_lahir_tgl.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="lahir_bln">
			<option value="'.$y_lahir_bln.'" selected>'.$arrbln1[$y_lahir_bln].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="lahir_thn">
			<option value="'.$y_lahir_thn.'" selected>'.$y_lahir_thn.'</option>';
			for ($k=$lahir01;$k<=$lahir02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			4. Agama
			</td>
			<td width="10">: </td>
			<td>

			<select name="agama">';

			//terpilih
			$qagmx = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd = '$y_agmkd'");
			$ragmx = mysql_fetch_assoc($qagmx);
			$agmx_kd = nosql($ragmx['kd']);
			$agmx_agama = balikin($ragmx['agama']);

			echo '<option value="'.$agmx_kd.'">'.$agmx_agama.'</option>';

			$qagm = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd <> '$y_agmkd' ".
									"ORDER BY agama ASC");
			$ragm = mysql_fetch_assoc($qagm);

			do
				{
				$agm_kd = nosql($ragm['kd']);
				$agm_agama = balikin($ragm['agama']);

				echo '<option value="'.$agm_kd.'">'.$agm_agama.'</option>';
				}
			while ($ragm = mysql_fetch_assoc($qagm));

			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			5. Kewarganegaraan
			</td>
			<td width="10">: </td>
			<td>
			<input name="warga_negara" type="text" value="'.$y_warga_negara.'" size="20">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			6. Anak Keberapa
			</td>
			<td width="10">: </td>
			<td>
			<input name="anak_ke" type="text" value="'.$y_anak_ke.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			7. Jumlah Saudara Kandung
			</td>
			<td width="10">: </td>
			<td>
			<input name="jml_sdr_kandung" type="text" value="'.$y_jml_sdr_kandung.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			8. Jumlah Saudara Tiri
			</td>
			<td width="10">: </td>
			<td>
			<input name="jml_sdr_tiri" type="text" value="'.$y_jml_sdr_tiri.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			9. Jumlah Saudara Angkat
			</td>
			<td width="10">: </td>
			<td>
			<input name="jml_sdr_angkat" type="text" value="'.$y_jml_sdr_angkat.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			10. Anak Yatim / Anak Piatu / Yatim Piatu
			</td>
			<td width="10">: </td>
			<td>
			<select name="yatim_piatu">
			<option value="'.$y_yatim_piatu.'" selected>'.$y_yatim_piatu.'</option>
			<option value="Anak Yatim">Anak Yatim</option>
			<option value="Anak Piatu">Anak Piatu</option>
			<option value="Yatim Piatu">Yatim Piatu</option>
			<option value="-">-</option>
			</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			11. Bahasa Sehari - hari di Rumah
			</td>
			<td width="10">: </td>
			<td>
			<input name="bahasa" type="text" value="'.$y_bahasa.'" size="20">
			</td>
			</tr>
			</table>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="a">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">


			</td>
			<td>';

			//nek null foto
			if (empty($y_filex))
				{
				$nil_foto = "$sumber/img/foto_blank.jpg";
				}
			else
				{
				$nil_foto = "$sumber/filebox/siswa/$swkd/$y_filex";
				}

			echo '<img src="'.$nil_foto.'" alt="'.$y_nama.'" width="150" height="200" border="5">
			<br>
			<br>
			<input name="filex_foto" type="file" size="15">
			<br>
			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="a">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnGNT" type="submit" value="GANTI">
			</td>
			</tr>
			</table>
			<br>
			<br>';
			}

		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="b"></a>
		<strong>B. KETERANGAN TEMPAT TINGGAL</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=b#b" title="B. KETERANGAN TEMPAT TINGGAL">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "b")
			{
			//query
			$qnil = mysql_query("SELECT m_siswa_tmp_tinggal.*, siswa_kelas.* ".
						"FROM m_siswa_tmp_tinggal, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_tmp_tinggal.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_alamat = balikin2($rnil['alamat']);
			$y_telp = balikin2($rnil['telp']);
			$y_tinggal_dgn = balikin2($rnil['tinggal_dgn']);
			$y_jarak = balikin2($rnil['jarak']);



			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			12. Alamat
			</td>
			<td width="10">: </td>
			<td>
			<input name="alamat" type="text" value="'.$y_alamat.'" size="50">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			13. Telp.
			</td>
			<td width="10">: </td>
			<td>
			<input name="telp" type="text" value="'.$y_telp.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			14. Tinggal dengan Orang Tua / Saudara / di Asrama / Kos.
			</td>
			<td width="10">: </td>
			<td>
			<select name="tinggal_dgn">
			<option value="'.$y_tinggal_dgn.'" selected>'.$y_tinggal_dgn.'</option>
			<option value="Orang Tua">Orang Tua</option>
			<option value="Saudara">Saudara</option>
			<option value="di Asrama">di Asrama</option>
			<option value="Kos">Kos</option>
			</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			15. Jarak tempat tinggal ke sekolah
			</td>
			<td width="10">: </td>
			<td>
			<input name="jarak" type="text" value="'.$y_jarak.'" size="10">
			</td>
			</tr>
			</table>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="b">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}

		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="c"></a>
		<strong>C. KETERANGAN KESEHATAN</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=c#c" title="C. KETERANGAN KESEHATAN">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "c")
			{
			//query
			$qnil = mysql_query("SELECT m_siswa_kesehatan.*, siswa_kelas.* ".
						"FROM m_siswa_kesehatan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_kesehatan.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_gol_darah = balikin2($rnil['gol_darah']);
			$y_penyakit = balikin2($rnil['penyakit']);
			$y_kelainan = balikin2($rnil['kelainan']);
			$y_berat = balikin2($rnil['berat']);
			$y_tinggi = balikin2($rnil['tinggi']);


			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			16. Golongan Darah
			</td>
			<td width="10">: </td>
			<td>
			<input name="gol_darah" type="text" value="'.$y_gol_darah.'" size="50">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			17. Penyakit yang pernah diderita TBC/Cacar/Malaria/dan lain - lain
			</td>
			<td width="10">: </td>
			<td>
			<input name="penyakit" type="text" value="'.$y_penyakit.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			18. Kelainan Jasmani
			</td>
			<td width="10">: </td>
			<td>
			<input name="kelainan" type="text" value="'.$y_kelainan.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			19. Tinggi / Berat Badan
			</td>
			<td width="10">: </td>
			<td>
			<input name="tinggi" type="text" value="'.$y_tinggi.'" size="3" maxlength="3" onKeyPress="return numbersonly(this, event)"> Cm /
			<input name="berat" type="text" value="'.$y_berat.'" size="3" maxlength="3" onKeyPress="return numbersonly(this, event)"> Kg.
			</td>
			</tr>
			</table>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="c">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}

		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="d"></a>
		<strong>D. KETERANGAN PENDIDIKAN</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=d#d" title="D. KETERANGAN PENDIDIKAN">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "d")
			{
			//query pendidikan /////////////////////////////////////////////////////////////////////////////////////////////////////////
			$qnil = mysql_query("SELECT m_siswa_pendidikan.*, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_pendidikan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_pendidikan.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_lulusan = balikin2($rnil['lulusan']);
			$y_no_sttb = balikin2($rnil['no_sttb']);
			$y_tgl_sttb = nosql($rnil['tgl']);
			$y_bln_sttb = nosql($rnil['bln']);
			$y_thn_sttb = nosql($rnil['thn']);
			$y_lama = balikin2($rnil['lama']);


			//query pindahan ///////////////////////////////////////////////////////////////////////////////////////////////////////////
			$qnil2 = mysql_query("SELECT m_siswa_pindahan.*, siswa_kelas.* ".
						"FROM m_siswa_pindahan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_pindahan.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil2 = mysql_fetch_assoc($qnil2);
			$y_dari = balikin2($rnil2['dari']);
			$y_alasan = balikin2($rnil2['alasan']);


			//query diterima ///////////////////////////////////////////////////////////////////////////////////////////////////////////
			$qnil3 = mysql_query("SELECT m_siswa_diterima.*, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_diterima, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_diterima.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil3 = mysql_fetch_assoc($qnil3);
			$y_kelas = balikin2($rnil3['kelas']);
			$y_keahlian = balikin2($rnil3['keahlian']);
			$y_tgl_terima = nosql($rnil3['tgl']);
			$y_bln_terima = nosql($rnil3['bln']);
			$y_thn_terima = nosql($rnil3['thn']);




			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			20. Pendidikan Sebelumnya
			</td>
			<td width="10"></td>
			<td></td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			a. Lulusan dari
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="lulusan" type="text" value="'.$y_lulusan.'" size="50">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			b. Tanggal dan No. STTB
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<select name="sttb_tgl">
			<option value="'.$y_tgl_sttb.'" selected>'.$y_tgl_sttb.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="sttb_bln">
			<option value="'.$y_bln_sttb.'" selected>'.$arrbln1[$y_bln_sttb].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="sttb_thn">
			<option value="'.$y_thn_sttb.'" selected>'.$y_thn_sttb.'</option>';
			for ($k=$sttb01;$k<=$sttb02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			 /
			<input name="no_sttb" type="text" value="'.$y_no_sttb.'" size="10">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			c. Lama Belajar
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="lama" type="text" value="'.$y_lama.'" size="1" maxlength="1" onKeyPress="return numbersonly(this, event)"> Tahun.
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			21. Pindahan
			</td>
			<td width="10"></td>
			<td></td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			a. Dari Sekolah
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="dari" type="text" value="'.$y_dari.'" size="50">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			b. Alasan
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="alasan" type="text" value="'.$y_alasan.'" size="50">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			22. Diterima di Sekolah ini
			</td>
			<td width="10"></td>
			<td></td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			a. Di Kelas
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="kelas" type="text" value="'.$y_kelas.'" size="10">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			b. Keahlian
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="keahlian" type="text" value="'.$y_keahlian.'" size="50">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			c. Tanggal
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<select name="terima_tgl">
			<option value="'.$y_tgl_terima.'" selected>'.$y_tgl_terima.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="terima_bln">
			<option value="'.$y_bln_terima.'" selected>'.$arrbln1[$y_bln_terima].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="terima_thn">
			<option value="'.$y_thn_terima.'" selected>'.$y_thn_terima.'</option>';
			for ($k=$sttb01;$k<=$sttb02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>
			</table>


			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="d">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}

		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="e"></a>
		<strong>E. KETERANGAN TENTANG AYAH KANDUNG</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=e#e" title="E. KETERANGAN TENTANG AYAH KANDUNG">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "e")
			{
			//query
			$qnil = mysql_query("SELECT m_siswa_ayah.*, ".
						"DATE_FORMAT(m_siswa_ayah.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_ayah.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_ayah.tgl_lahir, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_ayah, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_ayah.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_nama = balikin2($rnil['nama']);
			$y_tmp_lahir = balikin2($rnil['tmp_lahir']);
			$y_tgl_lahir = nosql($rnil['tgl']);
			$y_bln_lahir = nosql($rnil['bln']);
			$y_thn_lahir = nosql($rnil['thn']);
			$y_agmkd = nosql($rnil['kd_agama']);
			$y_warga_negara = balikin2($rnil['warga_negara']);
			$y_pendidikan = balikin2($rnil['pendidikan']);
			$y_pekkd = nosql($rnil['kd_pekerjaan']);
			$y_penghasilan = balikin2($rnil['penghasilan']);
			$y_alamat = balikin2($rnil['alamat']);
			$y_telp = balikin2($rnil['telp']);
			$y_hidup = balikin2($rnil['hidup']);


			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			23. Nama
			</td>
			<td width="10">: </td>
			<td>
			<input name="nama" type="text" value="'.$y_nama.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			24. Tempat dan Tanggal Lahir
			</td>
			<td width="10">: </td>
			<td>
			<input name="tmp_lahir" type="text" value="'.$y_tmp_lahir.'" size="30">,
			<select name="lahir_tgl">
			<option value="'.$y_tgl_lahir.'" selected>'.$y_tgl_lahir.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="lahir_bln">
			<option value="'.$y_bln_lahir.'" selected>'.$arrbln1[$y_bln_lahir].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="lahir_thn">
			<option value="'.$y_thn_lahir.'" selected>'.$y_thn_lahir.'</option>';
			for ($k=$lahir01;$k<=$lahir02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			25. Agama
			</td>
			<td width="10">: </td>
			<td>
			<select name="agama">';

			//terpilih
			$qagmx = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd = '$y_agmkd'");
			$ragmx = mysql_fetch_assoc($qagmx);
			$agmx_kd = nosql($ragmx['kd']);
			$agmx_agama = balikin($ragmx['agama']);

			echo '<option value="'.$agmx_kd.'">'.$agmx_agama.'</option>';

			$qagm = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd <> '$y_agmkd' ".
									"ORDER BY agama ASC");
			$ragm = mysql_fetch_assoc($qagm);

			do
				{
				$agm_kd = nosql($ragm['kd']);
				$agm_agama = balikin($ragm['agama']);

				echo '<option value="'.$agm_kd.'">'.$agm_agama.'</option>';
				}
			while ($ragm = mysql_fetch_assoc($qagm));

			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			26. Kewarganegaraan
			</td>
			<td width="10">: </td>
			<td>
			<input name="warga_negara" type="text" value="'.$y_warga_negara.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			27. Pendidikan
			</td>
			<td width="10">: </td>
			<td>
			<input name="pendidikan" type="text" value="'.$y_pendidikan.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			28. Pekerjaan
			</td>
			<td width="10">: </td>
			<td>
			<select name="pekerjaan">';

			//terpilih
			$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
									"WHERE kd = '$y_pekkd'");
			$rpekx = mysql_fetch_assoc($qpekx);
			$pekx_kd = nosql($rpekx['kd']);
			$pekx_pekerjaan = balikin($rpekx['pekerjaan']);

			echo '<option value="'.$pekx_kd.'">'.$pekx_pekerjaan.'</option>';

			$qpek = mysql_query("SELECT * FROM m_pekerjaan ".
									"WHERE kd <> '$y_pekkd' ".
									"ORDER BY pekerjaan ASC");
			$rpek = mysql_fetch_assoc($qpek);

			do
				{
				$pek_kd = nosql($rpek['kd']);
				$pek_pekerjaan = balikin($rpek['pekerjaan']);

				echo '<option value="'.$pek_kd.'">'.$pek_pekerjaan.'</option>';
				}
			while ($rpek = mysql_fetch_assoc($qpek));

			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			29. Penghasilan per Bulan
			</td>
			<td width="10">: </td>
			<td>
			Rp. <input name="pendapatan" type="text" value="'.$y_penghasilan.'" size="10" onKeyPress="return numbersonly(this, event)">,00
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			30. Alamat Rumah / Telepon
			</td>
			<td width="10">: </td>
			<td>
			<input name="alamat" type="text" value="'.$y_alamat.'" size="30"> /
			<input name="telepon" type="text" value="'.$y_telp.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			31. Masih Hidup/Meninggal Dunia, Tahun
			</td>
			<td width="10">: </td>
			<td>
			<input name="hidup" type="text" value="'.$y_hidup.'" size="30">
			</td>
			</tr>
			</table>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="e">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}

		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="f"></a>
		<strong>F. KETERANGAN TENTANG IBU KANDUNG</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=f#f" title="F. KETERANGAN TENTANG IBU KANDUNG">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "f")
			{
			//query
			$qnil = mysql_query("SELECT m_siswa_ibu.*, ".
						"DATE_FORMAT(m_siswa_ibu.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_ibu.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_ibu.tgl_lahir, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_ibu, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_ibu.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_nama = balikin2($rnil['nama']);
			$y_tmp_lahir = balikin2($rnil['tmp_lahir']);
			$y_tgl_lahir = nosql($rnil['tgl']);
			$y_bln_lahir = nosql($rnil['bln']);
			$y_thn_lahir = nosql($rnil['thn']);
			$y_agmkd = nosql($rnil['kd_agama']);
			$y_warga_negara = balikin2($rnil['warga_negara']);
			$y_pendidikan = balikin2($rnil['pendidikan']);
			$y_pekkd = nosql($rnil['kd_pekerjaan']);
			$y_penghasilan = balikin2($rnil['penghasilan']);
			$y_alamat = balikin2($rnil['alamat']);
			$y_telp = balikin2($rnil['telp']);
			$y_hidup = balikin2($rnil['hidup']);


			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			32. Nama
			</td>
			<td width="10">: </td>
			<td>
			<input name="nama" type="text" value="'.$y_nama.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			33. Tempat dan Tanggal Lahir
			</td>
			<td width="10">: </td>
			<td>
			<input name="tmp_lahir" type="text" value="'.$y_tmp_lahir.'" size="30">,
			<select name="lahir_tgl">
			<option value="'.$y_tgl_lahir.'" selected>'.$y_tgl_lahir.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="lahir_bln">
			<option value="'.$y_bln_lahir.'" selected>'.$arrbln1[$y_bln_lahir].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="lahir_thn">
			<option value="'.$y_thn_lahir.'" selected>'.$y_thn_lahir.'</option>';
			for ($k=$lahir01;$k<=$lahir02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			34. Agama
			</td>
			<td width="10">: </td>
			<td>
			<select name="agama">';

			//terpilih
			$qagmx = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd = '$y_agmkd'");
			$ragmx = mysql_fetch_assoc($qagmx);
			$agmx_kd = nosql($ragmx['kd']);
			$agmx_agama = balikin($ragmx['agama']);

			echo '<option value="'.$agmx_kd.'">'.$agmx_agama.'</option>';

			$qagm = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd <> '$y_agmkd' ".
									"ORDER BY agama ASC");
			$ragm = mysql_fetch_assoc($qagm);

			do
				{
				$agm_kd = nosql($ragm['kd']);
				$agm_agama = balikin($ragm['agama']);

				echo '<option value="'.$agm_kd.'">'.$agm_agama.'</option>';
				}
			while ($ragm = mysql_fetch_assoc($qagm));

			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			35. Kewarganegaraan
			</td>
			<td width="10">: </td>
			<td>
			<input name="warga_negara" type="text" value="'.$y_warga_negara.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			36. Pendidikan
			</td>
			<td width="10">: </td>
			<td>
			<input name="pendidikan" type="text" value="'.$y_pendidikan.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			37. Pekerjaan
			</td>
			<td width="10">: </td>
			<td>
			<select name="pekerjaan">';

			//terpilih
			$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
									"WHERE kd = '$y_pekkd'");
			$rpekx = mysql_fetch_assoc($qpekx);
			$pekx_kd = nosql($rpekx['kd']);
			$pekx_pekerjaan = balikin($rpekx['pekerjaan']);

			echo '<option value="'.$pekx_kd.'">'.$pekx_pekerjaan.'</option>';

			$qpek = mysql_query("SELECT * FROM m_pekerjaan ".
									"WHERE kd <> '$y_pekkd' ".
									"ORDER BY pekerjaan ASC");
			$rpek = mysql_fetch_assoc($qpek);

			do
				{
				$pek_kd = nosql($rpek['kd']);
				$pek_pekerjaan = balikin($rpek['pekerjaan']);

				echo '<option value="'.$pek_kd.'">'.$pek_pekerjaan.'</option>';
				}
			while ($rpek = mysql_fetch_assoc($qpek));

			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			38. Penghasilan per Bulan
			</td>
			<td width="10">: </td>
			<td>
			Rp. <input name="pendapatan" type="text" value="'.$y_penghasilan.'" size="10" onKeyPress="return numbersonly(this, event)">,00
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			39. Alamat Rumah / Telepon
			</td>
			<td width="10">: </td>
			<td>
			<input name="alamat" type="text" value="'.$y_alamat.'" size="30"> /
			<input name="telepon" type="text" value="'.$y_telp.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			40. Masih Hidup/Meninggal Dunia, Tahun
			</td>
			<td width="10">: </td>
			<td>
			<input name="hidup" type="text" value="'.$y_hidup.'" size="30">
			</td>
			</tr>
			</table>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="f">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}
		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="g"></a>
		<strong>G. KETERANGAN TENTANG WALI</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=g#g" title="G. KETERANGAN TENTANG WALI">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "g")
			{
			//query
			$qnil = mysql_query("SELECT m_siswa_wali.*, ".
						"DATE_FORMAT(m_siswa_wali.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_wali.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_wali.tgl_lahir, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_wali, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_wali.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_nama = balikin2($rnil['nama']);
			$y_tmp_lahir = balikin2($rnil['tmp_lahir']);
			$y_tgl_lahir = nosql($rnil['tgl']);
			$y_bln_lahir = nosql($rnil['bln']);
			$y_thn_lahir = nosql($rnil['thn']);
			$y_agmkd = nosql($rnil['kd_agama']);
			$y_warga_negara = balikin2($rnil['warga_negara']);
			$y_pendidikan = balikin2($rnil['pendidikan']);
			$y_pekkd = nosql($rnil['kd_pekerjaan']);
			$y_penghasilan = balikin2($rnil['penghasilan']);
			$y_alamat = balikin2($rnil['alamat']);
			$y_telp = balikin2($rnil['telp']);


			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			41. Nama
			</td>
			<td width="10">: </td>
			<td>
			<input name="nama" type="text" value="'.$y_nama.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			42. Tempat dan Tanggal Lahir
			</td>
			<td width="10">: </td>
			<td>
			<input name="tmp_lahir" type="text" value="'.$y_tmp_lahir.'" size="30">,
			<select name="lahir_tgl">
			<option value="'.$y_tgl_lahir.'" selected>'.$y_tgl_lahir.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="lahir_bln">
			<option value="'.$y_bln_lahir.'" selected>'.$arrbln1[$y_bln_lahir].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="lahir_thn">
			<option value="'.$y_thn_lahir.'" selected>'.$y_thn_lahir.'</option>';
			for ($k=$lahir01;$k<=$lahir02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			43. Agama
			</td>
			<td width="10">: </td>
			<td>
			<select name="agama">';

			//terpilih
			$qagmx = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd = '$y_agmkd'");
			$ragmx = mysql_fetch_assoc($qagmx);
			$agmx_kd = nosql($ragmx['kd']);
			$agmx_agama = balikin($ragmx['agama']);

			echo '<option value="'.$agmx_kd.'">'.$agmx_agama.'</option>';

			$qagm = mysql_query("SELECT * FROM m_agama ".
									"WHERE kd <> '$y_agmkd' ".
									"ORDER BY agama ASC");
			$ragm = mysql_fetch_assoc($qagm);

			do
				{
				$agm_kd = nosql($ragm['kd']);
				$agm_agama = balikin($ragm['agama']);

				echo '<option value="'.$agm_kd.'">'.$agm_agama.'</option>';
				}
			while ($ragm = mysql_fetch_assoc($qagm));

			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			44. Kewarganegaraan
			</td>
			<td width="10">: </td>
			<td>
			<input name="warga_negara" type="text" value="'.$y_warga_negara.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			45. Pendidikan
			</td>
			<td width="10">: </td>
			<td>
			<input name="pendidikan" type="text" value="'.$y_pendidikan.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			46. Pekerjaan
			</td>
			<td width="10">: </td>
			<td>
			<select name="pekerjaan">';

			//terpilih
			$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
									"WHERE kd = '$y_pekkd'");
			$rpekx = mysql_fetch_assoc($qpekx);
			$pekx_kd = nosql($rpekx['kd']);
			$pekx_pekerjaan = balikin($rpekx['pekerjaan']);

			echo '<option value="'.$pekx_kd.'">'.$pekx_pekerjaan.'</option>';

			$qpek = mysql_query("SELECT * FROM m_pekerjaan ".
									"WHERE kd <> '$y_pekkd' ".
									"ORDER BY pekerjaan ASC");
			$rpek = mysql_fetch_assoc($qpek);

			do
				{
				$pek_kd = nosql($rpek['kd']);
				$pek_pekerjaan = balikin($rpek['pekerjaan']);

				echo '<option value="'.$pek_kd.'">'.$pek_pekerjaan.'</option>';
				}
			while ($rpek = mysql_fetch_assoc($qpek));

			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			47. Penghasilan per Bulan
			</td>
			<td width="10">: </td>
			<td>
			Rp. <input name="pendapatan" type="text" value="'.$y_penghasilan.'" size="10" onKeyPress="return numbersonly(this, event)">,00
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			48. Alamat Rumah / Telepon
			</td>
			<td width="10">: </td>
			<td>
			<input name="alamat" type="text" value="'.$y_alamat.'" size="30"> /
			<input name="telepon" type="text" value="'.$y_telp.'" size="30">
			</td>
			</tr>
			</table>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="g">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}

		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="h"></a>
		<strong>H. KEGEMARAN SISWA</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=h#h" title="H. KEGEMARAN SISWA">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "h")
			{
			//query
			$qnil = mysql_query("SELECT m_siswa_hobi.*, siswa_kelas.* ".
						"FROM m_siswa_hobi, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_hobi.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_kesenian = balikin2($rnil['kesenian']);
			$y_olah_raga = balikin2($rnil['olah_raga']);
			$y_organisasi = balikin2($rnil['organisasi']);
			$y_lain = balikin2($rnil['lain_lain']);



			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			49. Kesenian
			</td>
			<td width="10">: </td>
			<td>
			<input name="kesenian" type="text" value="'.$y_kesenian.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			50. Olah Raga
			</td>
			<td width="10">: </td>
			<td>
			<input name="olah_raga" type="text" value="'.$y_olah_raga.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			51. Kemasyarakatan / Organisasi
			</td>
			<td width="10">: </td>
			<td>
			<input name="organisasi" type="text" value="'.$y_organisasi.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			52. Lain - Lain
			</td>
			<td width="10">: </td>
			<td>
			<input name="lain_lain" type="text" value="'.$y_lain.'" size="30">
			</td>
			</tr>
			</table>


			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="h">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}

		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="i"></a>
		<strong>I. KETERANGAN PERKEMBANGAN SISWA</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=i#i" title="I. KETERANGAN PERKEMBANGAN SISWA">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "i")
			{
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
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_bea_siswa = balikin2($rnil['bea_siswa']);
			$y_tgl_tinggal = nosql($rnil['tgl']);
			$y_bln_tinggal = nosql($rnil['bln']);
			$y_thn_tinggal = nosql($rnil['thn']);
			$y_tgl_terima_ijazah = nosql($rnil['tgl_terima']);
			$y_bln_terima_ijazah = nosql($rnil['bln_terima']);
			$y_thn_terima_ijazah = nosql($rnil['thn_terima']);
			$y_tgl_ijazah = nosql($rnil['tgl_ijazah']);
			$y_bln_ijazah = nosql($rnil['bln_ijazah']);
			$y_thn_ijazah = nosql($rnil['thn_ijazah']);
			$y_alasan = balikin2($rnil['alasan']);
			$y_tamat = balikin2($rnil['tamat']);
			$y_no_sttb = balikin2($rnil['no_sttb']);
			$y_pindah_kelas = nosql($rnil['pindah_kelas']);
			$y_no_surat = balikin($rnil['no_surat']);
			$y_ket = balikin($rnil['ket']);





			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			53. Menerima Bea Siswa
			</td>
			<td width="10">: </td>
			<td>
			<input name="bea_siswa" type="text" value="'.$y_bea_siswa.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			54. Meninggalkan Sekolah
			</td>
			<td width="10"></td>
			<td></td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			a. Tanggal Meninggalkan Sekolah
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<select name="tinggal_tgl">
			<option value="'.$y_tgl_tinggal.'" selected>'.$y_tgl_tinggal.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="tinggal_bln">
			<option value="'.$y_bln_tinggal.'" selected>'.$arrbln1[$y_bln_tinggal].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="tinggal_thn">
			<option value="'.$y_thn_tinggal.'" selected>'.$y_thn_tinggal.'</option>';
			for ($k=$tinggal01;$k<=$tinggal02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			b. Alasan
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="alasan" type="text" value="'.$y_alasan.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			c. Kelas Berapa
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<select name="pindah_kelas">
			<option value="'.$y_pindah_kelas.'" selected>'.$y_pindah_kelas.'</option>
			<option value="X">X</option>
			<option value="XI">XI</option>
			<option value="XII">XII</option>
			</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			d. No.Surat
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="no_surat" type="text" value="'.$y_no_surat.'" size="20">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			e. Ket.
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<select name="ket">
			<option value="'.$y_ket.'" selected>'.$y_ket.'</option>
			<option value="DO">DO</option>
			<option value="Pindah">Pindah</option>
			</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			55. Akhir Pendidikan
			</td>
			<td width="10"></td>
			<td></td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			a. Tamat Belajar
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="tamat" type="text" value="'.$y_tamat.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			b. STTB Nomor
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="no_sttb" type="text" value="'.$y_no_sttb.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			c. Tanggal Ijazah
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<select name="ijazah_tgl">
			<option value="'.$y_tgl_ijazah.'" selected>'.$y_tgl_ijazah.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="ijazah_bln">
			<option value="'.$y_bln_ijazah.'" selected>'.$arrbln1[$y_bln_ijazah].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="ijazah_thn">
			<option value="'.$y_thn_ijazah.'" selected>'.$y_thn_ijazah.'</option>';
			for ($k=$tinggal01;$k<=$tinggal02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			d. Tanggal Terima Ijazah
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<select name="ijazah_terima_tgl">
			<option value="'.$y_tgl_terima_ijazah.'" selected>'.$y_tgl_terima_ijazah.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="ijazah_terima_bln">
			<option value="'.$y_bln_terima_ijazah.'" selected>'.$arrbln1[$y_bln_terima_ijazah].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="ijazah_terima_thn">
			<option value="'.$y_thn_terima_ijazah.'" selected>'.$y_thn_terima_ijazah.'</option>';
			for ($k=$tinggal01;$k<=$tinggal02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>

			</table>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="i">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btxno" type="hidden" value="'.$btxno.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}

		echo '<br>
		<br>';




		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<a name="j"></a>
		<strong>J. KETERANGAN SETELAH SELESAI PENDIDIKAN</strong>
		(<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$swkd.'&a=j#j" title="J. KETERANGAN SETELAH SELESAI PENDIDIKAN">EDIT</a>)
		</td>
		</tr>
		</table>
		<br>';

		if ($a == "j")
			{
			//query
			$qnil = mysql_query("SELECT m_siswa_selesai.*, ".
						"DATE_FORMAT(m_siswa_selesai.tgl, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_selesai.tgl, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_selesai.tgl, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_selesai, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_selesai.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$y_melanjutkan_di = balikin2($rnil['melanjutkan_di']);
			$y_bekerja = balikin2($rnil['bekerja']);
			$y_tgl_kerja = nosql($rnil['tgl']);
			$y_bln_kerja = nosql($rnil['bln']);
			$y_thn_kerja = nosql($rnil['thn']);
			$y_instansi = balikin2($rnil['instansi']);
			$y_penghasilan = balikin2($rnil['penghasilan']);


			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="200">
			56. Melanjutkan di
			</td>
			<td width="10">: </td>
			<td>
			<input name="melanjutkan_di" type="text" value="'.$y_melanjutkan_di.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			57. Bekerja
			</td>
			<td width="10">: </td>
			<td>
			<input name="bekerja" type="text" value="'.$y_bekerja.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			a. Tanggal Mulai Bekerja
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<select name="kerja_tgl">
			<option value="'.$y_tgl_kerja.'" selected>'.$y_tgl_kerja.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="kerja_bln">
			<option value="'.$y_bln_kerja.'" selected>'.$arrbln1[$y_bln_kerja].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="kerja_thn">
			<option value="'.$y_thn_kerja.'" selected>'.$y_thn_kerja.'</option>';
			for ($k=$kerja01;$k<=$kerja02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			b. Nama Perusahaan / Lembaga / Lain-lain
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			<input name="instansi" type="text" value="'.$y_instansi.'" size="30">
			</td>
			</tr>

			<tr valign="top">
			<td width="200">
			<dd>
			c. Penghasilan
			</dd>
			</td>
			<td width="10">: </td>
			<td>
			Rp. <input name="penghasilan" type="text" value="'.$y_penghasilan.'" size="10" onKeyPress="return numbersonly(this, event)">,00
			</td>
			</tr>
			</table>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="j">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnDS" type="submit" value="DAFTAR SISWA >>">';
			}
		echo '<br>
		<br>';
		}
	else
		{
		//query DATA
		$tapelkd = nosql($_REQUEST['tapelkd']);
		$kelkd = nosql($_REQUEST['kelkd']);
		$keahkd = nosql($_REQUEST['keahkd']);
		$kompkd = nosql($_REQUEST['kompkd']);


		//jika import
		if ($s == "import")
			{
			echo '<p>
			Silahkan Masukkan File yang akan Di-Import :
			<br>
			<input name="filex_xls" type="file" size="30">
			<br>
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		    	<input name="keahkd" type="hidden" value="'.$keahkd.'">
		    	<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="btnBTL" type="submit" value="BATAL">
			<input name="btnIM2" type="submit" value="IMPORT >>">
			</p>
			<p>
			<strong><em>NB. Pastikan Semua Kolom Data yang akan di-import, Telah Sesuai dengan Data Master.</em></strong>
			</p>';
			}
		else
			{


			//nis
			if ($crkd == "cr01")
				{
				//query
				$p = new Pager();
				$start = $p->findStart($limit);

				$sqlcount = "SELECT m_siswa.*, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
								"m_siswa.kd AS mskd, ".
								"siswa_kelas.* ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_kelas.kd_tapel = '$tapelkd' ".
								"AND siswa_kelas.kd_kelas = '$kelkd' ".
								"AND siswa_kelas.kd_keahlian = '$keahkd' ".
								"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
								"AND m_siswa.nis LIKE '%$kunci%' ".
								"ORDER BY m_siswa.nis ASC";
				$sqlresult = $sqlcount;

				$count = mysql_num_rows(mysql_query($sqlcount));
				$pages = $p->findPages($count, $limit);
				$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
				$target = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
				$pagelist = $p->pageList($_GET['page'], $pages, $target);
				$data = mysql_fetch_array($result);
				}

			//nama
			else if ($crkd == "cr02")
				{
				//query
				$p = new Pager();
				$start = $p->findStart($limit);

				$sqlcount = "SELECT m_siswa.*, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
								"m_siswa.kd AS mskd, ".
								"siswa_kelas.* ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_kelas.kd_tapel = '$tapelkd' ".
								"AND siswa_kelas.kd_kelas = '$kelkd' ".
								"AND siswa_kelas.kd_keahlian = '$keahkd' ".
								"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
								"AND m_siswa.nama LIKE '%$kunci%' ".
								"ORDER BY m_siswa.nama ASC";
				$sqlresult = $sqlcount;

				$count = mysql_num_rows(mysql_query($sqlcount));
				$pages = $p->findPages($count, $limit);
				$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
				$target = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
				$pagelist = $p->pageList($_GET['page'], $pages, $target);
				$data = mysql_fetch_array($result);
				}

			else
				{
				//query
				$p = new Pager();
				$start = $p->findStart($limit);

				$sqlcount = "SELECT m_siswa.*, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
								"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
								"m_siswa.kd AS mskd, ".
								"siswa_kelas.* ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_kelas.kd_tapel = '$tapelkd' ".
								"AND siswa_kelas.kd_kelas = '$kelkd' ".
								"AND siswa_kelas.kd_keahlian = '$keahkd' ".
								"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
								"ORDER BY m_siswa.nis ASC";
				$sqlresult = $sqlcount;

				$count = mysql_num_rows(mysql_query($sqlcount));
				$pages = $p->findPages($count, $limit);
				$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
				$target = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
				$pagelist = $p->pageList($_GET['page'], $pages, $target);
				$data = mysql_fetch_array($result);
				}



			echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warna02.'">
			<td>
			[<a href="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&s=baru&swkd='.$x.'&a=a#a" title="Entry Data">Entry Data</a>]
			</td>
			<td align="right">';
			echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
			echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
			<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&crkd=cr01&crtipe=NIS&kunci='.$kunci.'">NIS</option>
			<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&crkd=cr02&crtipe=Nama&kunci='.$kunci.'">Nama</option>
			</select>
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="keahkd" type="hidden" value="'.$keahkd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="kunci" type="text" value="'.$kunci.'" size="30">
			<input name="crkd" type="hidden" value="'.$crkd.'">
			<input name="crtipe" type="hidden" value="'.$crtipe.'">
			<input name="btnCARI" type="submit" value="CARI >>">
			<input name="btnRST" type="submit" value="RESET">
			</td>
			</tr>
			</table>';

			//nek ada
			if ($count != 0)
				{
				echo '<table width="100%" border="1" cellpadding="3" cellspacing="0">
				<tr bgcolor="'.$warnaheader.'">
				<td width="1">&nbsp;</td>
				<td width="1">&nbsp;</td>
				<td width="1">&nbsp;</td>
				<td width="50"><strong>NIS</strong></td>
				<td width="150"><strong>Nama</strong></td>
				<td width="5"><strong>L/P</strong></td>
				<td width="150"><strong>TTL.</strong></td>
				<td width="150"><strong>Nama Orang Tua</strong></td>
				<td><strong>Alamat Rumah</strong></td>
				<td width="100"><strong>Asal Sekolah</strong></td>
				<td width="100"><strong>Telp.</strong></td>
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

					$nomer = $nomer + 1;

					$kd = nosql($data['mskd']);
					$nis = nosql($data['nis']);
					$i_userx = nosql($data['usernamex']);
					$i_passx = nosql($data['passwordx']);
					$i_passx_ortu = nosql($data['passwordx_ortu']);
					$nama = balikin($data['nama']);
					$kd_kelamin = nosql($data['kd_kelamin']);
					$tmp_lahir = balikin2($data['tmp_lahir']);
					$tgl_lahir = nosql($data['tgl']);
					$bln_lahir = nosql($data['bln']);
					$thn_lahir = nosql($data['thn']);
					$tun_telp = balikin2($data['telp']);


					//kelamin
					$qmin = mysql_query("SELECT * FROM m_kelamin ".
											"WHERE kd = '$kd_kelamin'");
					$rmin = mysql_fetch_assoc($qmin);
					$min_kelamin = balikin2($rmin['kelamin']);


					//orang tua - ayah
					$qtun = mysql_query("SELECT * FROM m_siswa_ayah ".
								"WHERE kd_siswa = '$kd'");
					$rtun = mysql_fetch_assoc($qtun);
					$tun_nama = balikin2($rtun['nama']);


					//alamat
					$qtun2 = mysql_query("SELECT * FROM m_siswa_tmp_tinggal ".
								"WHERE kd_siswa = '$kd'");
					$rtun2 = mysql_fetch_assoc($qtun2);
					$tun2_alamat = balikin2($rtun2['alamat']);


					//lulusan dari
					$qpend = mysql_query("SELECT * FROM m_siswa_pendidikan ".
											"WHERE kd_siswa = '$kd'");
					$rpend = mysql_fetch_assoc($qpend);
					$pend_lulusan = balikin2($rpend['lulusan']);




					//cek password orang tua
					if (empty($i_passx_ortu))
						{
						//update
						mysql_query("UPDATE m_siswa SET passwordx_ortu = '$i_passx' ".
										"WHERE kd = '$kd'");
						}



						
						


					//cek janissari
					$qcc1 = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$kd'");
					$rcc1 = mysql_fetch_assoc($qcc1);
					$tcc1 = mysql_num_rows($qcc1);

					//jika ada, update
					if ($tcc1 != 0)
						{
						//update ke janissari
						mysql_query("UPDATE m_user SET usernamex = '$i_userx', ".
								"passwordx = '$i_passx', ".
								"nomor = '$nis', ".
								"nama = '$nama' ".
								"WHERE kd = '$kd'");
						}
					else
						{
						//masukkan ke janissari
						mysql_query("INSERT INTO m_user(kd, usernamex, passwordx, nomor, nama, tipe, postdate) VALUES ".
								"('$kd', '$i_userx', '$i_passx', '$nis', '$nama', 'SISWA', '$today')");
						}



					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
					<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
					</td>
					<td>
					<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$kd.'&a=a#a"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
					</td>
					<td>
					<a href="siswa_pdf.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&swkd='.$kd.'" target="_blank" title="PRINT..."><img src="'.$sumber.'/img/pdf.gif" width="16" height="16" border="0"></a>
					</td>
					<td valign="top">
					'.$nis.'
					</td>
					<td valign="top">
					'.$nama.'
					</td>
					<td valign="top">
					'.$min_kelamin.'
					</td>
					<td valign="top">
					'.$tmp_lahir.', '.$tgl_lahir.' '.$arrbln1[$bln_lahir].' '.$thn_lahir.'
					</td>
					<td valign="top">
					'.$tun_nama.'
					</td>
					<td valign="top">
					'.$tun2_alamat.'
					</td>
					<td valign="top">
					'.$pend_lulusan.'
					</td>
					<td valign="top">
					'.$tun_telp.'
					</td>
					</tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td width="250">
				<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
				<input name="btnBTL" type="reset" value="BATAL">
				<input name="btnHPS" type="submit" value="HAPUS">
				<input name="jml" type="hidden" value="'.$limit.'">
				<input name="s" type="hidden" value="'.$s.'">
				<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
				<input name="kelkd" type="hidden" value="'.$kelkd.'">
				<input name="keahkd" type="hidden" value="'.$keahkd.'">
				<input name="kompkd" type="hidden" value="'.$kompkd.'">
				<input name="swkd" type="hidden" value="'.$swkd.'">
				<input name="total" type="hidden" value="'.$count.'">
				</td>
				<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
				</tr>
				</table>';
				}
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
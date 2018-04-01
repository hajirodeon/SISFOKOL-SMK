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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pegawai.php";
$judul = "Pegawai";
$judulku = "$judul  [$adm_session]";
$diload = "document.formx.nip.focus();";
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$m = nosql($_REQUEST['m']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$dkkd = nosql($_REQUEST['dkkd']);
$pddkkd = nosql($_REQUEST['pddkkd']);
$pktkd = nosql($_REQUEST['pktkd']);
$gjkd = nosql($_REQUEST['gjkd']);
$mutkd = nosql($_REQUEST['mutkd']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//ke import
if ($_POST['btnIM'])
	{
	//re-direct
	$ke = "$filenya?s=import";
	xloc($ke);
	exit();
	}




//import
if ($_POST['btnIM2'])
	{
	//nilai
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=import";
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

			//re-direct
			$ke = "pegawai_import.php?filex_namex=$filex_namex";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//export
if ($_POST['btnEX'])
	{

	//require
	include("../../inc/class/excel/excelwriter.inc.php");

	
	
	//nama file e...
	$excelfile = "Daftar_Pegawai.xls";
	$i_judul = "Daftar_Pegawai";
	

	//lokasi hasil konversi
	$lokasi	   = '../../filebox/excel/';
	$excel=new ExcelWriter($lokasi.$excelfile);
	
	

	$myArr = array("NO_URUT","NAMA","KELAMIN","TMP_LAHIR","TGL_LAHIR","AGAMA","STATUS",
					"PASANGAN_NAMA","PASANGAN_TGL_LAHIR","PASANGAN_TGL_NIKAH","ANAK_NAMA",
					"ANAK_TMP_LAHIR","ANAK_TGL_LAHIR","RUMAH_ALAMAT","RUMAH_TELP","GOL_DARAH",
					"PDDKN_IJAZAH","PDDKN_AKTA","PDDKN_THN_LULUS","PDDKN_JURUSAN","PDDKN_NAMA_PT", 
					"KURSUS_NAMA","KURSUS_PENYELENGGARA","KURSUS_TEMPAT","KURSUS_TAHUN","KURSUS_LAMA",
					"PEGAWAI_STATUS","PEGAWAI_NIP","PEGAWAI_KARPEG","KERJA_PANGKAT","KERJA_JABATAN",
					"KERJA_TMT_AWAL","KERJA_TMT_AKHIR","SERTIFIKASI","SERTIFIKASI_TAHUN","EMAIL");
	$excel->writeLine($myArr);





	//data
	$qdt = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS pkd, ".
							"DATE_FORMAT(m_pegawai.tgl_lahir, '%d') AS lahir_tgl, ".
							"DATE_FORMAT(m_pegawai.tgl_lahir, '%m') AS lahir_bln, ".
							"DATE_FORMAT(m_pegawai.tgl_lahir, '%Y') AS lahir_thn ".
							"FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
	  	{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_pkd = nosql($rdt['pkd']);


		//m_pegawai ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$dt_nip = nosql($rdt['nip']);
		$dt_nuptk = nosql($rdt['nuptk']);
		$dt_nama = balikin($rdt['nama']);
		$dt_no_karpeg = balikin($rdt['no_karpeg']);
		$dt_tmp_lahir = balikin($rdt['tmp_lahir']);

		$dt_lahir_tgl = nosql($rdt['lahir_tgl']);
		$dt_lahir_bln = nosql($rdt['lahir_bln']);
		$dt_lahir_thn = nosql($rdt['lahir_thn']);
		$dt_tgl_lahir = "$dt_lahir_tgl/$dt_lahir_bln/$dt_lahir_thn";

		$dt_sertifikasi = nosql($rdt['sertifikasi']);
		$dt_sertifikasi_tahun = nosql($rdt['sertifikasi_tahun']);
		$dt_email = balikin($rdt['email']);

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
		$dt_alamat = balikin($rdt['alamat']);
		$dt_telp = balikin($rdt['telp']);
		$dt_gol_darah = balikin($rdt['gol_darah']);


		$cc_pegawai_nip = $dt_nip;
		$cc_pegawai_karpeg = $dt_no_karpeg;
		$cc_rumah_alamat = $dt_alamat;
		$cc_rumah_status = $dt_rumah_status;
		$cc_rumah_telp = $dt_telp;


		//m_pegawai_keluarga ///////////////////////////////////////////////////////////////////////////////////////////////////////////
		$qcc = mysql_query("SELECT m_pegawai_keluarga.*, ".
								"DATE_FORMAT(tgl_nikah, '%d') AS nikah_tgl, ".
								"DATE_FORMAT(tgl_nikah, '%m') AS nikah_bln, ".
								"DATE_FORMAT(tgl_nikah, '%Y') AS nikah_thn, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%d') AS ptgl, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%m') AS pbln, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%Y') AS pthn, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%d') AS atgl, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%m') AS abln, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%Y') AS athn ".
								"FROM m_pegawai_keluarga ".
								"WHERE kd_pegawai = '$dt_pkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_status = nosql($rcc['status_kawin']);

		//jika true, kawin
		if ($cc_status == "true")
			{
			$cc_status = "KAWIN";
			}
		else
			{
			$cc_status = "BELUM KAWIN";
			}



		$cc_nikah_tgl = nosql($rcc['nikah_tgl']);
		$cc_nikah_bln = nosql($rcc['nikah_bln']);
		$cc_nikah_thn = nosql($rcc['nikah_thn']);
		$cc_pasangan_tgl_nikah = "$cc_nikah_tgl/$cc_nikah_bln/$cc_nikah_thn";

		$cc_pasangan_nama = balikin($rcc['nama_pasangan']);

		$cc_ptgl = nosql($rcc['ptgl']);
		$cc_pbln = nosql($rcc['pbln']);
		$cc_pthn = nosql($rcc['pthn']);
		$cc_pasangan_tgl_lahir = "$cc_ptgl/$cc_pbln/$cc_pthn";

		$cc_pasangan_ket = balikin($rcc['ket_pasangan']);
		$cc_anak_nama = balikin($rcc['anak1_nama']);
		$cc_anak_status = balikin($rcc['anak1_status']);
		$cc_anak_tmp_lahir = balikin($rcc['anak1_tmp_lahir']);

		$cc_atgl = nosql($rcc['atgl']);
		$cc_abln = nosql($rcc['abln']);
		$cc_athn = nosql($rcc['athn']);
		$cc_anak_tgl_lahir = "$cc_atgl/$cc_abln/$cc_athn";








		//m_pegawai_pendidikan /////////////////////////////////////////////////////////////////////////////////////////////////////////
		$qcc = mysql_query("SELECT * FROM m_pegawai_pendidikan ".
								"WHERE kd_pegawai = '$dt_pkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		$cc_pddkn_ijazah = nosql($rcc['kd_ijazah']);
		$qijzx = mysql_query("SELECT * FROM m_ijazah ".
								"WHERE kd = '$cc_pddkn_ijazah'");
		$rijzx = mysql_fetch_assoc($qijzx);
		$cc_pddkn_ijazah = balikin($rijzx['ijazah']);

		$cc_pddkn_akta = nosql($rcc['kd_akta']);
		$qaktx = mysql_query("SELECT * FROM m_akta ".
								"WHERE kd = '$cc_pddkn_akta'");
		$raktx = mysql_fetch_assoc($qaktx);
		$cc_pddkn_akta = balikin($raktx['akta']);
		$cc_pddkn_thn_lulus = nosql($rcc['thn_lulus']);
		$cc_pddkn_jurusan = balikin($rcc['jurusan']);
		$cc_pddkn_nama_pt = nosql($rcc['nama_pt']);








		//m_pegawai_diklat/kursus //////////////////////////////////////////////////////////////////////////////////////////////////////
		$qcc = mysql_query("SELECT * FROM m_pegawai_diklat ".
								"WHERE kd_pegawai = '$dt_pkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_kursus_nama = balikin($rcc['nama']);
		$cc_kursus_penyelenggara = balikin($rcc['penyelenggara']);
		$cc_kursus_tempat = balikin($rcc['tempat']);
		$cc_kursus_tahun = balikin($rcc['tahun']);
		$cc_kursus_lama = balikin($rcc['lama']);





		//m_pegawai_pekerjaan //////////////////////////////////////////////////////////////////////////////////////////////////////////
		$qcc = mysql_query("SELECT m_pegawai_pekerjaan.*, ".
								"DATE_FORMAT(tmt_awal, '%d') AS tmt_tgl, ".
								"DATE_FORMAT(tmt_awal, '%m') AS tmt_bln, ".
								"DATE_FORMAT(tmt_awal, '%Y') AS tmt_thn, ".
								"DATE_FORMAT(tmt_akhir, '%d') AS tmt2_tgl, ".
								"DATE_FORMAT(tmt_akhir, '%m') AS tmt2_bln, ".
								"DATE_FORMAT(tmt_akhir, '%Y') AS tmt2_thn ".
								"FROM m_pegawai_pekerjaan ".
								"WHERE kd_pegawai = '$dt_pkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		$cc_pegawai_status = nosql($rcc['kd_status']);
		$qtup = mysql_query("SELECT * FROM m_status ".
								"WHERE kd = '$cc_pegawai_status'");
		$rtup = mysql_fetch_assoc($qtup);
		$tup_status = nosql($rtup['status']);
		$cc_pegawai_status = $tup_status;

		$cc_kerja_pangkat = nosql($rcc['kd_golongan']);
		$qgol = mysql_query("SELECT * FROM m_golongan ".
								"WHERE kd = '$cc_kerja_pangkat'");
		$rgol = mysql_fetch_assoc($qgol);
		$gol_golongan = nosql($rgol['golongan']);
		$cc_kerja_pangkat = $gol_golongan;


		$cc_kerja_jabatan = nosql($rcc['kd_jabatan']);
		$qjbtx = mysql_query("SELECT * FROM m_jabatan ".
								"WHERE kd = '$cc_kerja_jabatan'");
		$rjbtx = mysql_fetch_assoc($qjbtx);
		$cc_kerja_jabatan = balikin($rjbtx['jabatan']);

		$cc_tmt_tgl = nosql($rcc['tmt_tgl']);
		$cc_tmt_bln = nosql($rcc['tmt_bln']);
		$cc_tmt_thn = nosql($rcc['tmt_thn']);
		$cc_kerja_tmt = "$cc_tmt_tgl/$cc_tmt_bln/$cc_tmt_thn";

		$cc_tmt2_tgl = nosql($rcc['tmt2_tgl']);
		$cc_tmt2_bln = nosql($rcc['tmt2_bln']);
		$cc_tmt2_thn = nosql($rcc['tmt2_thn']);
		$cc_kerja_tmt2 = "$cc_tmt2_tgl/$cc_tmt2_bln/$cc_tmt2_thn";





		//jika sudah sertifikasi
		if ($dt_sertifikasi == "true")
			{
			$dt_sertifikasi_ket = "SUDAH";
			}
		else
			{
			$dt_sertifikasi_ket = "BELUM";
			}



		
		//ciptakan
		$myArr = array($dt_nox,$dt_nama,$dt_kelamin,$dt_tmp_lahir,$dt_tgl_lahir,$dt_agama,$cc_status,
						$cc_pasangan_nama,$cc_pasangan_tgl_lahir,$cc_pasangan_tgl_nikah,$cc_anak_nama,
						$cc_anak_tmp_lahir,$cc_anak_tgl_lahir,$cc_rumah_alamat,$cc_rumah_telp,
						$dt_gol_darah,$cc_pddkn_ijazah,$cc_pddkn_akta,$cc_pddkn_thn_lulus,
						$cc_pddkn_jurusan,$cc_pddkn_nama_pt,$cc_kursus_nama,$cc_kursus_penyelenggara,
						$cc_kursus_tempat,$cc_kursus_tahun,$cc_kursus_lama,$cc_pegawai_status,
						$cc_pegawai_nip,$cc_pegawai_karpeg,$cc_kerja_pangkat,$cc_kerja_jabatan,
						$cc_kerja_tmt,$cc_kerja_tmt2,$dt_sertifikasi_ket,$dt_sertifikasi_tahun,$dt_email);
		$excel->writeLine($myArr);
		
		
		}
	while ($rdt = mysql_fetch_assoc($qdt));



	$excel -> close();
	
	//re-direct
	$ke = "$lokasi$excelfile";
	xloc($ke);
	exit();

	}






//re-direct, data diri
if ($_POST['btnRE1'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=datadiri&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, keluarga
else if ($_POST['btnRE2'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=keluarga&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, diklat
else if ($_POST['btnRE3'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=diklat&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, mengajar
else if ($_POST['btnRE4'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=mengajar&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, masa kerja
else if ($_POST['btnRE5'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=mk&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, pekerjaan
else if ($_POST['btnRE6'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=pekerjaan&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, pendidikan
else if ($_POST['btnRE7'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=pendidikan&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, kenaikan pangkat
else if ($_POST['btnRE8'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=naikpangkat&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, kenaikan gaji
else if ($_POST['btnRE9'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=naikgaji&kd=$kd";
	xloc($ke);
	exit();
	}
//re-direct, mutasi
else if ($_POST['btnRE10'])
	{
	//nilai
	$kd = nosql($_POST['kd']);

	//re-direct
	$ke = "$filenya?s=edit&m=mutasi&kd=$kd";
	xloc($ke);
	exit();
	}





//ke daftar pegawai
if ($_POST['btnDF'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}



//jika hapus, diklat
if ($_POST['btnHPSDK'])
	{
	//ambil nilai
	$kd = nosql($_POST['kd']);
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//query
	$qdk = mysql_query("SELECT * FROM m_pegawai_diklat ".
							"ORDER BY nama ASC");
	$rdk = mysql_fetch_assoc($qdk);
	$tdk = mysql_num_rows($qdk);


	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$yuhux = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_pegawai_diklat ".
						"WHERE kd_pegawai = '$kd' ".
						"AND kd = '$yuhux'");
		}
	while ($rdk = mysql_fetch_assoc($qdk));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?s=edit&m=diklat&kd=$kd";
	xloc($ke);
	exit();
	}





//jika hapus, pendidikan
if ($_POST['btnHPSPDDK'])
	{
	//ambil nilai
	$kd = nosql($_POST['kd']);
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//query
	$qdk = mysql_query("SELECT * FROM m_pegawai_pendidikan");
	$rdk = mysql_fetch_assoc($qdk);
	$tdk = mysql_num_rows($qdk);


	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$yuhux = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_pegawai_pendidikan ".
						"WHERE kd_pegawai = '$kd' ".
						"AND kd = '$yuhux'");
		}
	while ($rdk = mysql_fetch_assoc($qdk));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?s=edit&m=pendidikan&kd=$kd";
	xloc($ke);
	exit();
	}





//jika hapus, kepangkatan
if ($_POST['btnHPSPKT'])
	{
	//ambil nilai
	$kd = nosql($_POST['kd']);
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//query
	$qdk = mysql_query("SELECT * FROM m_pegawai_pangkat");
	$rdk = mysql_fetch_assoc($qdk);
	$tdk = mysql_num_rows($qdk);


	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$yuhux = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_pegawai_pangkat ".
						"WHERE kd_pegawai = '$kd' ".
						"AND kd = '$yuhux'");
		}
	while ($rdk = mysql_fetch_assoc($qdk));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?s=edit&m=naikpangkat&kd=$kd";
	xloc($ke);
	exit();
	}






//jika hapus, gaji
if ($_POST['btnHPSGJI'])
	{
	//ambil nilai
	$kd = nosql($_POST['kd']);
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//query
	$qdk = mysql_query("SELECT * FROM m_pegawai_gaji_berkala");
	$rdk = mysql_fetch_assoc($qdk);
	$tdk = mysql_num_rows($qdk);


	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$yuhux = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_pegawai_gaji_berkala ".
				"WHERE kd_pegawai = '$kd' ".
				"AND kd = '$yuhux'");
		}
	while ($rdk = mysql_fetch_assoc($qdk));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?s=edit&m=naikgaji&kd=$kd";
	xloc($ke);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM m_pegawai ".
					"ORDER BY nip ASC";
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

		//nek $kd gak null
		if (!empty($kd))
			{
			//hapus file
			$cc_filex = $data['filex'];
			$path1 = "../../filebox/pegawai/$kd/$cc_filex";
			unlink ($path1);
			}

		//del
		mysql_query("DELETE FROM m_pegawai ".
						"WHERE kd = '$kd'");
		}
	while ($data = mysql_fetch_assoc($result));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?page=$page";
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP1'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$m = nosql($_POST['m']);
	$kd = nosql($_POST['kd']);




	//jika baru ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($s == "add")
		{
		//nilai
		$nip = nosql($_POST['nip']);
		$nuptk = nosql($_POST['nuptk']);
		$nama1 = cegah($_POST['nama1']);
		$no_karpeg = nosql($_POST['no_karpeg']);
		$kode = nosql($_POST['kode']);
		$tmp_lahir = cegah($_POST['tmp_lahir']);

		$lahir_tgl = nosql($_POST['lahir_tgl']);
		$lahir_bln = nosql($_POST['lahir_bln']);
		$lahir_thn = nosql($_POST['lahir_thn']);
		$tgl_lahir = "$lahir_thn:$lahir_bln:$lahir_tgl";

		$kelamin = nosql($_POST['kelamin']);
		$agama = nosql($_POST['agama']);
		$alamat = cegah($_POST['alamat']);
		$telp = cegah($_POST['telp']);
		$gol_darah = cegah($_POST['gol_darah']);


		//nek null
		if ((empty($nip)) OR (empty($nama1)))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
			$ke = "$filenya?s=add&m=datadiri&kd=$x";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai ".
									"WHERE nip = '$nip'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "NIP Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=add&m=datadiri&kd=$x";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//set akses
				$x_userx = $nip;
				$x_passx = md5($nip);

				//insert
				mysql_query("INSERT INTO m_pegawai(kd, usernamex, passwordx, nip, nuptk, nama, ".
								"no_karpeg, kode, tmp_lahir, tgl_lahir, kd_kelamin, kd_agama, ".
								"alamat, telp, gol_darah) VALUES ".
								"('$kd', '$x_userx', '$x_passx', '$nip', '$nuptk', '$nama1', ".
								"'$no_karpeg', '$kode', '$tmp_lahir', '$tgl_lahir', '$kelamin', '$agama', ".
								"'$alamat', '$telp', '$gol_darah')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=datadiri&kd=$kd";
				xloc($ke);
				exit();
				}
			}
		}


	//jika edit ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($s == "edit")
		{
		//jika data diri ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($m == "datadiri")
			{
			//nilai
			$nip = nosql($_POST['nip']);
			$nuptk = nosql($_POST['nuptk']);
			$nama1 = cegah($_POST['nama1']);
			$no_karpeg = nosql($_POST['no_karpeg']);
			$kode = nosql($_POST['kode']);
			$tmp_lahir = cegah($_POST['tmp_lahir']);

			$lahir_tgl = nosql($_POST['lahir_tgl']);
			$lahir_bln = nosql($_POST['lahir_bln']);
			$lahir_thn = nosql($_POST['lahir_thn']);
			$tgl_lahir = "$lahir_thn:$lahir_bln:$lahir_tgl";

			$kelamin = nosql($_POST['kelamin']);
			$agama = nosql($_POST['agama']);
			$alamat = cegah($_POST['alamat']);
			$telp = cegah($_POST['telp']);
			$gol_darah = cegah($_POST['gol_darah']);


			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai ".
									"WHERE nip = '$nip'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek lebih dari 1
			if ($tcc > 1)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Ditemukan Duplikasi NIP : $nip. Silahkan Diganti...!";
				$ke = "$filenya?s=edit&m=datadiri&kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//set akses
				$x_userx = $nip;
				$x_passx = md5($nip);

				//update
				mysql_query("UPDATE m_pegawai SET usernamex = '$x_userx', ".
								"passwordx = '$x_passx', ".
								"nip = '$nip', ".
								"nuptk = '$nuptk', ".
								"nama = '$nama1', ".
								"no_karpeg = '$no_karpeg', ".
								"kode = '$kode', ".
								"tmp_lahir = '$tmp_lahir', ".
								"tgl_lahir = '$tgl_lahir', ".
								"kd_kelamin = '$kelamin', ".
								"kd_agama = '$agama', ".
								"alamat = '$alamat', ".
								"telp = '$telp', ".
								"gol_darah = '$gol_darah' ".
								"WHERE kd = '$kd'");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=datadiri&kd=$kd";
				xloc($ke);
				exit();
				}
			}


		//jika keluarga ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "keluarga")
			{
			//nilai
			$nama_ayah = cegah($_POST['nama_ayah']);
			$nama_ibu = cegah($_POST['nama_ibu']);
			$kawin = cegah($_POST['kawin']);
			$nikah_tgl = nosql($_POST['nikah_tgl']);
			$nikah_bln = nosql($_POST['nikah_bln']);
			$nikah_thn = nosql($_POST['nikah_thn']);
			$tgl_nikah = "$nikah_thn:$nikah_bln:$nikah_tgl";
			$pasangan_nama = cegah($_POST['pasangan_nama']);
			$pasangan_t = cegah($_POST['pasangan_tmp_lahir']);
			$pasangan_tgl = nosql($_POST['pasangan_tgl']);
			$pasangan_bln = nosql($_POST['pasangan_bln']);
			$pasangan_thn = nosql($_POST['pasangan_thn']);
			$pasangan_tl = "$pasangan_thn:$pasangan_bln:$pasangan_tgl";
			$pasangan_kerja = cegah($_POST['pasangan_kerja']);
			$pasangan_nip = cegah($_POST['pasangan_nip']);
			$pasangan_gaji = nosql($_POST['pasangan_gaji']);
			$anak1_nama = cegah($_POST['anak1_nama']);
			$anak1_t = cegah($_POST['anak1_tmp_lahir']);
			$anak1_tgl = nosql($_POST['anak1_tgl']);
			$anak1_bln = nosql($_POST['anak1_bln']);
			$anak1_thn = nosql($_POST['anak1_thn']);
			$anak1_tl = "$anak1_thn:$anak1_bln:$anak1_tgl";
			$anak1_kelamin = nosql($_POST['anak1_kelamin']);
			$anak1_sekolah = cegah($_POST['anak1_sekolah']);
			$anak1_tunjangan = cegah($_POST['anak1_tunjangan']);
			$anak2_nama = cegah($_POST['anak2_nama']);
			$anak2_t = cegah($_POST['anak2_tmp_lahir']);
			$anak2_tgl = nosql($_POST['anak2_tgl']);
			$anak2_bln = nosql($_POST['anak2_bln']);
			$anak2_thn = nosql($_POST['anak2_thn']);
			$anak2_tl = "$anak2_thn:$anak2_bln:$anak2_tgl";
			$anak2_kelamin = nosql($_POST['anak2_kelamin']);
			$anak2_sekolah = cegah($_POST['anak2_sekolah']);
			$anak2_tunjangan = cegah($_POST['anak2_tunjangan']);
			$anak3_nama = cegah($_POST['anak3_nama']);
			$anak3_t = cegah($_POST['anak3_tmp_lahir']);
			$anak3_tgl = nosql($_POST['anak3_tgl']);
			$anak3_bln = nosql($_POST['anak3_bln']);
			$anak3_thn = nosql($_POST['anak3_thn']);
			$anak3_tl = "$anak3_thn:$anak3_bln:$anak3_tgl";
			$anak3_kelamin = nosql($_POST['anak3_kelamin']);
			$anak3_sekolah = cegah($_POST['anak3_sekolah']);
			$anak3_tunjangan = cegah($_POST['anak3_tunjangan']);


			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai_keluarga ".
									"WHERE kd_pegawai = '$kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_pegawai_keluarga SET nama_ayah = '$nama_ayah', ".
								"nama_ibu = '$nama_ibu', ".
								"status_kawin = '$kawin', ".
								"tgl_nikah = '$tgl_nikah', ".
								"nama_pasangan = '$pasangan_nama', ".
								"tmp_lahir_pasangan = '$pasangan_t', ".
								"tgl_lahir_pasangan = '$pasangan_tl', ".
								"pekerjaan_pasangan = '$pasangan_kerja', ".
								"nip_pasangan = '$pasangan_nip', ".
								"gaji_pasangan = '$pasangan_gaji', ".
								"anak1_nama = '$anak1_nama', ".
								"anak1_tmp_lahir = '$anak1_t', ".
								"anak1_tgl_lahir = '$anak1_tl', ".
								"anak1_kelamin = '$anak1_kelamin', ".
								"anak1_sekolah = '$anak1_sekolah', ".
								"anak1_tunjangan = '$anak1_tunjangan', ".
								"anak2_nama = '$anak2_nama', ".
								"anak2_tmp_lahir = '$anak2_t', ".
								"anak2_tgl_lahir = '$anak2_tl', ".
								"anak2_kelamin = '$anak2_kelamin', ".
								"anak2_sekolah = '$anak2_sekolah', ".
								"anak2_tunjangan = '$anak2_tunjangan', ".
								"anak3_nama = '$anak3_nama', ".
								"anak3_tmp_lahir = '$anak3_t', ".
								"anak3_tgl_lahir = '$anak3_tl', ".
								"anak3_kelamin = '$anak3_kelamin', ".
								"anak3_sekolah = '$anak3_sekolah', ".
								"anak3_tunjangan = '$anak3_tunjangan' ".
								"WHERE kd_pegawai = '$kd'");



				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=keluarga&kd=$kd";
				xloc($ke);
				exit();
				}

			else
				{
				//insert
				mysql_query("INSERT INTO m_pegawai_keluarga (kd, kd_pegawai, nama_ayah, nama_ibu, status_kawin, tgl_nikah, ".
								"nama_pasangan, tmp_lahir_pasangan, tgl_lahir_pasangan, pekerjaan_pasangan, ".
								"nip_pasangan, gaji_pasangan, ".
								"anak1_nama, anak1_tmp_lahir, anak1_tgl_lahir, ".
								"anak1_kelamin, anak1_sekolah, anak1_tunjangan, ".
								"anak2_nama, anak2_tmp_lahir, anak2_tgl_lahir, ".
								"anak2_kelamin, anak2_sekolah, anak2_tunjangan, ".
								"anak3_nama, anak3_tmp_lahir, anak3_tgl_lahir, ".
								"anak3_kelamin, anak3_sekolah, anak3_tunjangan) VALUES ".
								"('$x', '$kd', '$nama_ayah', '$nama_ibu', '$kawin', '$tgl_nikah', ".
								"'$pasangan_nama', '$pasangan_t', '$pasangan_tl', '$pasangan_kerja', ".
								"'$pasangan_nip', '$pasangan_gaji', ".
								"'$anak1_nama', '$anak1_tmp_lahir', '$anak1_tgl_lahir', ".
								"'$anak1_kelamin', '$anak1_sekolah', '$anak1_tunjangan', ".
								"'$anak2_nama', '$anak2_tmp_lahir', '$anak2_tgl_lahir', ".
								"'$anak2_kelamin', '$anak2_sekolah', '$anak2_tunjangan', ".
								"'$anak3_nama', '$anak3_tmp_lahir', '$anak3_tgl_lahir', ".
								"'$anak3_kelamin', '$anak3_sekolah', '$anak3_tunjangan')");


				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=keluarga&kd=$kd";
				xloc($ke);
				exit();
				}
			}



		//jika diklat //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "diklat")
			{
			//nilai
			$dkkd = nosql($_POST['dkkd']);
			$nama_diklat = cegah($_POST['nama_diklat']);
			$penyelenggara = cegah($_POST['penyelenggara']);
			$tmp_diklat = cegah($_POST['tmp_diklat']);
			$tahun_diklat = nosql($_POST['tahun_diklat']);
			$lama_diklat = cegah($_POST['lama_diklat']);


			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai_diklat ".
									"WHERE kd_pegawai = '$kd' ".
									"AND kd = '$dkkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_pegawai_diklat SET nama = '$nama_diklat', ".
								"penyelenggara = '$penyelenggara', ".
								"tempat = '$tmp_diklat', ".
								"tahun = '$tahun_diklat', ".
								"lama = '$lama_diklat' ".
								"WHERE kd_pegawai = '$kd' ".
								"AND kd = '$dkkd'");



				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=diklat&kd=$kd";
				xloc($ke);
				exit();
				}

			else
				{
				//insert
				mysql_query("INSERT INTO m_pegawai_diklat (kd, kd_pegawai, nama, penyelenggara, tempat, tahun, lama) VALUES ".
								"('$x', '$kd', '$nama_diklat', '$penyelenggara', '$tmp_diklat', '$tahun_diklat', '$lama_diklat')");


				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=diklat&kd=$kd";
				xloc($ke);
				exit();
				}
			}




		//jika mengajar ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "mengajar")
			{
			//nilai
			$ajar1_pddkn = cegah($_POST['ajar1_pddkn']);
			$ajar1_jam = nosql($_POST['ajar1_jam']);
			$ajar2_pddkn = cegah($_POST['ajar2_pddkn']);
			$ajar2_jam = nosql($_POST['ajar2_jam']);


			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai_mengajar ".
									"WHERE kd_pegawai = '$kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_pegawai_mengajar SET mengajar1 = '$ajar1_pddkn', ".
								"jml_jam1 = '$ajar1_jam', ".
								"mengajar2 = '$ajar2_pddkn', ".
								"jml_jam2 = '$ajar2_jam' ".
								"WHERE kd_pegawai = '$kd'");



				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=mengajar&kd=$kd";
				xloc($ke);
				exit();
				}

			else
				{
				//insert
				mysql_query("INSERT INTO m_pegawai_mengajar (kd, kd_pegawai, mengajar1, jml_jam1, mengajar2, jml_jam2) VALUES ".
								"('$x', '$kd', '$ajar1_pddkn', '$ajar1_jam', '$ajar2_pddkn', '$ajar2_jam')");


				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=mengajar&kd=$kd";
				xloc($ke);
				exit();
				}
			}





		//jika mk //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "mk")
			{
			//nilai
			$mk1_thn = nosql($_POST['mk1_thn']);
			$mk1_bln = nosql($_POST['mk1_bln']);
			$mk2_thn = nosql($_POST['mk2_thn']);
			$mk2_bln = nosql($_POST['mk2_bln']);


			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai_mk ".
									"WHERE kd_pegawai = '$kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_pegawai_mk SET sk_thn = '$mk1_thn', ".
								"sk_bln = '$mk1_bln', ".
								"s_thn = '$mk2_thn', ".
								"s_bln = '$mk2_bln' ".
								"WHERE kd_pegawai = '$kd'");



				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=mk&kd=$kd";
				xloc($ke);
				exit();
				}

			else
				{
				//insert
				mysql_query("INSERT INTO m_pegawai_mk (kd, kd_pegawai, sk_thn, sk_bln, s_thn, s_bln) VALUES ".
								"('$x', '$kd', '$mk1_thn', '$mk1_bln', '$mk2_thn', '$mk2_bln')");


				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=mk&kd=$kd";
				xloc($ke);
				exit();
				}
			}




		//jika pekerjaan ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "pekerjaan")
			{
			//nilai
			$status = nosql($_POST['status']);
			$pangkat = nosql($_POST['pangkat']);
			$golongan = nosql($_POST['golongan']);
			$jabatan = nosql($_POST['jabatan']);
			$awal_tgl = nosql($_POST['awal_tgl']);
			$awal_bln = nosql($_POST['awal_bln']);
			$awal_thn = nosql($_POST['awal_thn']);
			$tmt_awal = "$awal_thn:$awal_bln:$awal_tgl";
			$akhir_tgl = nosql($_POST['akhir_tgl']);
			$akhir_bln = nosql($_POST['akhir_bln']);
			$akhir_thn = nosql($_POST['akhir_thn']);
			$tmt_akhir = "$akhir_thn:$akhir_bln:$akhir_tgl";


			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai_pekerjaan ".
									"WHERE kd_pegawai = '$kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_pegawai_pekerjaan SET kd_status = '$status', ".
								"kd_pangkat = '$pangkat', ".
								"kd_golongan = '$golongan', ".
								"kd_jabatan = '$jabatan', ".
								"tmt_awal = '$tmt_awal', ".
								"tmt_akhir = '$tmt_akhir' ".
								"WHERE kd_pegawai = '$kd'");



				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=pekerjaan&kd=$kd";
				xloc($ke);
				exit();
				}

			else
				{
				//insert
				mysql_query("INSERT INTO m_pegawai_pekerjaan (kd, kd_pegawai, kd_status, kd_pangkat, ".
								"kd_golongan, kd_jabatan, tmt_awal, tmt_akhir) VALUES ".
								"('$x', '$kd', '$status', '$pangkat', ".
								"'$golongan', '$jabatan', '$tmt_awal', '$tmt_akhir')");


				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=pekerjaan&kd=$kd";
				xloc($ke);
				exit();
				}
			}




		//jika pendidikan //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "pendidikan")
			{
			//nilai
			$pddkkd = nosql($_POST['pddkkd']);
			$ijazah = nosql($_POST['ijazah']);
			$akta = nosql($_POST['akta']);
			$thn_lulus = nosql($_POST['lulus']);
			$jurusan = cegah($_POST['jurusan']);
			$nama_pt = cegah($_POST['nama_pt']);



			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai_pendidikan ".
									"WHERE kd_pegawai = '$kd' ".
									"AND kd = '$pddkkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE m_pegawai_pendidikan SET kd_ijazah = '$ijazah', ".
								"kd_akta = '$akta', ".
								"thn_lulus = '$thn_lulus', ".
								"jurusan = '$jurusan', ".
								"nama_pt = '$nama_pt' ".
								"WHERE kd_pegawai = '$kd' ".
								"AND kd = '$pddkkd'");



				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=pendidikan&kd=$kd";
				xloc($ke);
				exit();
				}

			else
				{
				//insert
				mysql_query("INSERT INTO m_pegawai_pendidikan (kd, kd_pegawai, kd_ijazah, kd_akta, ".
								"thn_lulus, jurusan, nama_pt) VALUES ".
								"('$x', '$kd', '$ijazah', '$akta', ".
								"'$thn_lulus', '$jurusan', '$nama_pt')");


				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=pendidikan&kd=$kd";
				xloc($ke);
				exit();
				}
			}




		//jika kenaikan pangkat //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "naikpangkat")
			{
			//nilai
			$pktkd = nosql($_POST['pktkd']);
			$golru = nosql($_POST['golru']);
			$nosk = cegah($_POST['nosk']);
			$xtgl1 = nosql($_POST['xtgl1']);
			$xbln1 = nosql($_POST['xbln1']);
			$xthn1 = nosql($_POST['xthn1']);
			$tgl_sk = "$xthn1:$xbln1:$xtgl1";
			$xtgl2 = nosql($_POST['xtgl2']);
			$xbln2 = nosql($_POST['xbln2']);
			$xthn2 = nosql($_POST['xthn2']);
			$tgl_pangkat = "$xthn2:$xbln2:$xtgl2";
			$mk_thn = nosql($_POST['mk_thn']);
			$mk_bln = nosql($_POST['mk_bln']);


			mysql_query("INSERT INTO m_pegawai_pangkat(kd, kd_pegawai, kd_pangkat, ".
					"no_sk, tgl_sk, tmt_pangkat, mk_thn, mk_bln) ".
					"VALUES('$x', '$kd', '$golru', '$nosk', ".
					"'$tgl_sk', '$tgl_pangkat', '$mk_thn', '$mk_bln')");



			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&m=naikpangkat&kd=$kd";
			xloc($ke);
			exit();
			}





		//jika kenaikan gaji //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "naikgaji")
			{
			//nilai
			$gjkd = nosql($_POST['gjkd']);
			$xtgl1 = nosql($_POST['xtgl1']);
			$xbln1 = nosql($_POST['xbln1']);
			$xthn1 = nosql($_POST['xthn1']);
			$tgl_gaji = "$xthn1:$xbln1:$xtgl1";
			$mk_thn = nosql($_POST['mk_thn']);
			$mk_bln = nosql($_POST['mk_bln']);
			$gapok = nosql($_POST['gapok']);


			mysql_query("INSERT INTO m_pegawai_gaji_berkala(kd, kd_pegawai, tmt_gaji, ".
					"mk_thn, mk_bln, kd_gapok) ".
					"VALUES('$x', '$kd', '$tgl_gaji', ".
					"'$mk_thn', '$mk_bln', '$gapok')");



			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&m=naikgaji&kd=$kd";
			xloc($ke);
			exit();
			}





		//jika mutasi //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($m == "mutasi")
			{
			//nilai
			$jns_mutasi = nosql($_POST['jns_mutasi']);
			$lama_unit = cegah($_POST['lama_unit']);
			$lama_jabatan = cegah($_POST['lama_jabatan']);
			$baru_unit = cegah($_POST['baru_unit']);
			$baru_jabatan = cegah($_POST['baru_jabatan']);
			$no_sk = cegah($_POST['no_sk']);
			$xtgl1 = nosql($_POST['xtgl1']);
			$xbln1 = nosql($_POST['xbln1']);
			$xthn1 = nosql($_POST['xthn1']);
			$tmt_lama = "$xthn1:$xbln1:$xtgl1";
			$xtgl2 = nosql($_POST['xtgl2']);
			$xbln2 = nosql($_POST['xbln2']);
			$xthn2 = nosql($_POST['xthn2']);
			$tmt_baru = "$xthn2:$xbln2:$xtgl2";
			$xtgl3 = nosql($_POST['xtgl3']);
			$xbln3 = nosql($_POST['xbln3']);
			$xthn3 = nosql($_POST['xthn3']);
			$tgl_sk = "$xthn3:$xbln3:$xtgl3";



			//cek
			$qcc = mysql_query("SELECT * FROM m_pegawai_mutasi ".
						"WHERE no_sk = '$no_sk'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//jika ada
			if ($tcc != 0)
				{
				mysql_query("UPDATE m_pegawai_mutasi SET lama_unit = '$lama_unit', ".
						"lama_jabatan = '$lama_jabatan', ".
						"lama_tmt = '$tmt_lama', ".
						"baru_unit = '$baru_unit', ".
						"baru_jabatan = '$baru_jabatan', ".
						"baru_tmt = '$tmt_baru', ".
						"no_sk = '$no_sk', ".
						"tgl_sk = '$tgl_sk', ".
						"kd_mutasi = '$jns_mutasi' ".
						"WHERE kd_pegawai = '$kd'");
				}
			else
				{
				mysql_query("INSERT INTO m_pegawai_mutasi(kd, kd_pegawai, lama_unit, ".
						"lama_jabatan, lama_tmt, baru_unit, baru_jabatan, ".
						"baru_tmt, no_sk, tgl_sk, kd_mutasi) ".
						"VALUES('$x', '$kd', '$lama_unit', ".
						"'$lama_jabatan', '$tmt_lama', '$baru_unit', '$baru_jabatan', ".
						"'$tmt_baru', '$no_sk', '$tgl_sk', '$jns_mutasi')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&m=mutasi&kd=$kd";
			xloc($ke);
			exit();
			}
		}
	}





//jika ganti foto profil ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnGNT'])
	{
	//nilai
	$filex_namex = strip(strtolower($_FILES['filex_foto']['name']));
	$kd = nosql($_POST['kd']);

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=edit&m=datadiri&kd=$kd";
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
			$path1 = "../../filebox/pegawai/$kd";

			//cek, sudah ada belum
			if (!file_exists($path1))
				{
				//bikin folder kd_user
				mkdir("$path1", $chmod);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/pegawai/$kd/$filex_namex");

				//cek
				$qcc = mysql_query("SELECT * FROM m_pegawai ".
										"WHERE kd = '$kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//query
					mysql_query("UPDATE m_pegawai SET filex = '$filex_namex' ".
									"WHERE kd = '$kd'");
					}
				else
					{
					mysql_query("INSERT INTO m_pegawai(kd, filex) VALUES ".
									"('$kd', '$filex_namex')");
					}


				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=datadiri&kd=$kd";
				xloc($ke);
				exit();
				}
			else
				{
				//hapus file yang ada dulu
				//query
				$qcc = mysql_query("SELECT * FROM m_pegawai ".
										"WHERE kd = '$kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//hapus file
				$cc_filex = $rcc['filex'];
				$path1 = "../../filebox/pegawai/$kd/$cc_filex";
				unlink ($path1);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/pegawai/$kd/$filex_namex");

				//nek ada
				if ($tcc != 0)
					{
					//query
					mysql_query("UPDATE m_pegawai SET filex = '$filex_namex', ".
									"postdate = '$today' ".
									"WHERE kd = '$kd'");
					}
				else
					{
					mysql_query("INSERT INTO m_pegawai(kd, filex) VALUES ".
									"('$kd', '$filex_namex')");
					}

				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&m=datadiri&kd=$kd";
				xloc($ke);
				exit();
				}
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			$ke = "$filenya?s=edit&kd=$kd";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//menu
require("../../inc/menu/adm.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="500">';
xheadline($judul);
echo ' [<a href="'.$filenya.'?s=add&m=datadiri&kd='.$x.'" title="Entry Data Baru">Entry Data Baru</a>]
<input name="btnIM" type="submit" value="IMPORT">
<input name="btnEX" type="submit" value="EXPORT">
</td>
<td align="right">';
echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?crkd=cr01&crtipe=NIP&kunci='.$kunci.'">NIP</option>
<option value="'.$filenya.'?crkd=cr02&crtipe=NUPTK&kunci='.$kunci.'">NUPTK</option>
<option value="'.$filenya.'?crkd=cr03&crtipe=Kode&kunci='.$kunci.'">Kode</option>
<option value="'.$filenya.'?crkd=cr04&crtipe=No.Karpeg&kunci='.$kunci.'">No.Karpeg</option>
<option value="'.$filenya.'?crkd=cr05&crtipe=Nama&kunci='.$kunci.'">Nama</option>
</select>
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="btnCARI" type="submit" value="CARI >>">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>';


//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (empty($s))
	{
	//nip
	if ($crkd == "cr01")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE nip LIKE '%$kunci%' ".
						"ORDER BY round(nip) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//nuptk
	else if ($crkd == "cr02")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE nuptk LIKE '%$kunci%' ".
						"ORDER BY round(nuptk) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//kode
	else if ($crkd == "cr03")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE kode LIKE '%$kunci%' ".
						"ORDER BY round(kode) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//no_karpeg
	else if ($crkd == "cr04")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE no_karpeg LIKE '%$kunci%' ".
						"ORDER BY round(no_karpeg) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//nama
	else if ($crkd == "cr05")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE nama LIKE '%$kunci%' ".
						"ORDER BY nama ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"ORDER BY round(nip) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	if ($count != 0)
		{
		//view data
		echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="200"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
		<td width="200"><strong><font color="'.$warnatext.'">NUPTK</font></strong></td>
		<td width="75"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td width="75"><strong><font color="'.$warnatext.'">No. Karpeg</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
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

			//nilai
			$nomer = $nomer + 1;
			$kd = nosql($data['kd']);
			$usernamex = nosql($data['usernamex']);
			$passwordx = nosql($data['passwordx']);
			$nip = balikin2($data['nip']);
			$nuptk = balikin2($data['nuptk']);
			$kode = balikin2($data['kode']);
			$no_karpeg = balikin2($data['no_karpeg']);
			$nama = balikin($data['nama']);


			//set akses
			if ((empty($usernamex)) OR (empty($passwordx)))
				{
				$x_userx = $nip;
				$x_passx = md5($nip);

				mysql_query("UPDATE m_pegawai SET usernamex = '$x_userx', ".
								"passwordx = '$x_passx' ".
								"WHERE kd = '$kd'");
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
	    		</td>
			<td>
			<a href="'.$filenya.'?s=edit&m=datadiri&kd='.$kd.'" title="EDIT..."><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="pegawai_pdf.php?pkd='.$kd.'" title="PDF..." target="_blank"><img src="'.$sumber.'/img/pdf.gif" width="16" height="16" border="0"></a>
			</td>
			<td>'.$nip.'</td>
			<td>'.$nuptk.'</td>
			<td>'.$kode.'</td>
			<td>'.$no_karpeg.'</td>
			<td>'.$nama.'</td>
	    		</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="300">
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="s" type="hidden" value="'.nosql($_REQUEST['s']).'">
		<input name="m" type="hidden" value="'.nosql($_REQUEST['m']).'">
		<input name="kd" type="hidden" value="'.nosql($_REQUEST['kd']).'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>';
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



//jika import //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($s == "import")
	{
	echo '<p>
	Silahkan Masukkan File yang akan Di-Import :
	<br>
	<input name="filex_xls" type="file" size="30">
	<br>
	<input name="s" type="hidden" value="'.$s.'">
	<input name="btnBTL" type="submit" value="BATAL">
	<input name="btnIM2" type="submit" value="IMPORT >>">
	</p>
	<p>
	<strong><em>NB. Pastikan Semua Kolom Data yang akan di-import, Telah Sesuai dengan Data Master.</em></strong>
	</p>';
	}



//jika add / edit ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else
	{
	//nilai
	$kd = nosql($_REQUEST['kd']);


	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr valign="top">
	<td width="80%">';


	//data query -> datadiri
	$qnil = mysql_query("SELECT m_pegawai.*, DATE_FORMAT(m_pegawai.tgl_lahir, '%d') AS lahir_tgl, ".
							"DATE_FORMAT(m_pegawai.tgl_lahir, '%m') AS lahir_bln, ".
							"DATE_FORMAT(m_pegawai.tgl_lahir, '%Y') AS lahir_thn ".
							"FROM m_pegawai ".
							"WHERE kd = '$kd'");
	$rnil = mysql_fetch_assoc($qnil);
	$y_nip = nosql($rnil['nip']);
	$y_nuptk = nosql($rnil['nuptk']);
	$y_nama = balikin($rnil['nama']);
	$y_no_karpeg = nosql($rnil['no_karpeg']);
	$y_kode = nosql($rnil['kode']);

	$tmp_lahir = balikin($rnil['tmp_lahir']);

	$lahir_tgl = nosql($rnil['lahir_tgl']);
	$lahir_bln = nosql($rnil['lahir_bln']);
	$lahir_thn = nosql($rnil['lahir_thn']);

	$jkelkd = nosql($rnil['kd_kelamin']);
	$agmkd = nosql($rnil['kd_agama']);

	$y_alamat = balikin($rnil['alamat']);
	$y_telp = balikin($rnil['telp']);
	$y_gol_darah = balikin($rnil['gol_darah']);
	$y_filex = $rnil['filex'];



	//jika data diri
	if ($m == "datadiri")
		{
		echo '***<big><strong>DATA DIRI</strong></big>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		NIP
		</td>
		<td>: </td>
		<td>
		<input name="nip" type="text" value="'.$y_nip.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		NUPTK
		</td>
		<td>: </td>
		<td>
		<input name="nuptk" type="text" value="'.$y_nuptk.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Kode
		</td>
		<td>: </td>
		<td>
		<input name="kode" type="text" value="'.$y_kode.'" size="10">,

		No. KarPeg :
		<input name="no_karpeg" type="text" value="'.$y_no_karpeg.'" size="10">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Nama
		</td>
		<td>: </td>
		<td>
		<input name="nama1" type="text" value="'.$y_nama.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		TTL
		</td>
		<td>: </td>
		<td>
		<input name="tmp_lahir" type="text" value="'.$tmp_lahir.'" size="30">,
		<select name="lahir_tgl">
		<option value="'.$lahir_tgl.'" selected>'.$lahir_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="lahir_bln">
		<option value="'.$lahir_bln.'" selected>'.$arrbln1[$lahir_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="lahir_thn">
		<option value="'.$lahir_thn.'" selected>'.$lahir_thn.'</option>';
		for ($k=$lahir01;$k<=$lahir02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Jenis Kelamin
		</td>
		<td>: </td>
		<td>
		<select name="kelamin">';

		//terpilih
		$qjkelx = mysql_query("SELECT * FROM m_kelamin ".
								"WHERE kd = '$jkelkd'");
		$rjkelx = mysql_fetch_assoc($qjkelx);
		$jkelx_kd = nosql($rjkelx['kd']);
		$jkelx_kelamin = balikin($rjkelx['kelamin']);

		echo '<option value="'.$jkelx_kd.'">'.$jkelx_kelamin.'</option>';

		$qjkel = mysql_query("SELECT * FROM m_kelamin ".
								"WHERE kd <> '$jkelkd' ".
								"ORDER BY kelamin ASC");
		$rjkel = mysql_fetch_assoc($qjkel);

		do
			{
			$jkel_kd = nosql($rjkel['kd']);
			$jkel_kelamin = balikin($rjkel['kelamin']);

			echo '<option value="'.$jkel_kd.'">'.$jkel_kelamin.'</option>';
			}
		while ($rjkel = mysql_fetch_assoc($qjkel));

		echo '</select>,

		Agama :
		<select name="agama">';

		//terpilih
		$qagmx = mysql_query("SELECT * FROM m_agama ".
								"WHERE kd = '$agmkd'");
		$ragmx = mysql_fetch_assoc($qagmx);
		$agmx_kd = nosql($ragmx['kd']);
		$agmx_agama = balikin($ragmx['agama']);

		echo '<option value="'.$agmx_kd.'">'.$agmx_agama.'</option>';

		$qagm = mysql_query("SELECT * FROM m_agama ".
								"WHERE kd <> '$agmkd' ".
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
		<td width="150">
		Alamat
		</td>
		<td>: </td>
		<td>
		<input name="alamat" type="text" value="'.$y_alamat.'" size="50">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Telp.
		</td>
		<td>: </td>
		<td>
		<input name="telp" type="text" value="'.$y_telp.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Golongan Darah
		</td>
		<td>: </td>
		<td>
		<input name="gol_darah" type="text" value="'.$y_gol_darah.'" size="10" maxlength="10">
		</td>
		</tr>

		</table>

		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">';
		}




	//jika keluarga
	else if ($m == "keluarga")
		{
		//data query -> keluarga
		$qnil2 = mysql_query("SELECT m_pegawai_keluarga.*, ".
								"DATE_FORMAT(tgl_nikah, '%d') AS nikah_tgl, ".
								"DATE_FORMAT(tgl_nikah, '%m') AS nikah_bln, ".
								"DATE_FORMAT(tgl_nikah, '%Y') AS nikah_thn, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%d') AS pasangan_tgl, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%m') AS pasangan_bln, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%Y') AS pasangan_thn, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%d') AS anak1_tgl, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%m') AS anak1_bln, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%Y') AS anak1_thn, ".
								"DATE_FORMAT(anak2_tgl_lahir, '%d') AS anak2_tgl, ".
								"DATE_FORMAT(anak2_tgl_lahir, '%m') AS anak2_bln, ".
								"DATE_FORMAT(anak2_tgl_lahir, '%Y') AS anak2_thn, ".
								"DATE_FORMAT(anak3_tgl_lahir, '%d') AS anak3_tgl, ".
								"DATE_FORMAT(anak3_tgl_lahir, '%m') AS anak3_bln, ".
								"DATE_FORMAT(anak3_tgl_lahir, '%Y') AS anak3_thn ".
								"FROM m_pegawai_keluarga ".
								"WHERE kd_pegawai = '$kd'");
		$rnil2 = mysql_fetch_assoc($qnil2);
		$y2_nama_ayah = balikin2($rnil2['nama_ayah']);
		$y2_nama_ibu = balikin2($rnil2['nama_ibu']);
		$y2_nikah_tgl = nosql($rnil2['nikah_tgl']);
		$y2_nikah_bln = nosql($rnil2['nikah_bln']);
		$y2_nikah_thn = nosql($rnil2['nikah_thn']);
		$y2_pasangan_nama = balikin2($rnil2['nama_pasangan']);
		$y2_pasangan_tmp_lahir = balikin2($rnil2['tmp_lahir_pasangan']);
		$y2_pasangan_tgl = nosql($rnil2['pasangan_tgl']);
		$y2_pasangan_bln = nosql($rnil2['pasangan_bln']);
		$y2_pasangan_thn = nosql($rnil2['pasangan_thn']);
		$y2_pasangan_kerja = balikin2($rnil2['pekerjaan_pasangan']);
		$y2_pasangan_nip = nosql($rnil2['nip_pasangan']);
		$y2_pasangan_gaji = nosql($rnil2['gaji_pasangan']);

		//kawin
		$y2_kawin_nil = nosql($rnil2['status_kawin']);

		if ($y2_kawin_nil == "true")
			{
			$y2_kawin = "Kawin";
			}
		else
			{
			$y2_kawin = "Belum Kawin";
			}




		//anak1
		$y2_anak1_nama = balikin2($rnil2['anak1_nama']);
		$y2_anak1_tmp_lahir = balikin2($rnil2['anak1_tmp_lahir']);
		$y2_anak1_tgl = nosql($rnil2['anak1_tgl']);
		$y2_anak1_bln = nosql($rnil2['anak1_bln']);
		$y2_anak1_thn = nosql($rnil2['anak1_thn']);
		$y2_anak1_kelamin = nosql($rnil2['anak1_kelamin']);
		$y2_anak1_sekolah = balikin2($rnil2['anak1_sekolah']);
		$y2_anak1_tunjangan = balikin2($rnil2['anak1_tunjangan']);

		//anak2
		$y2_anak2_nama = balikin2($rnil2['anak2_nama']);
		$y2_anak2_tmp_lahir = balikin2($rnil2['anak2_tmp_lahir']);
		$y2_anak2_tgl = nosql($rnil2['anak2_tgl']);
		$y2_anak2_bln = nosql($rnil2['anak2_bln']);
		$y2_anak2_thn = nosql($rnil2['anak2_thn']);
		$y2_anak2_kelamin = nosql($rnil2['anak2_kelamin']);
		$y2_anak2_sekolah = balikin2($rnil2['anak2_sekolah']);
		$y2_anak2_tunjangan = balikin2($rnil2['anak2_tunjangan']);

		//anak3
		$y2_anak3_nama = balikin2($rnil2['anak3_nama']);
		$y2_anak3_tmp_lahir = balikin2($rnil2['anak3_tmp_lahir']);
		$y2_anak3_tgl = nosql($rnil2['anak3_tgl']);
		$y2_anak3_bln = nosql($rnil2['anak3_bln']);
		$y2_anak3_thn = nosql($rnil2['anak3_thn']);
		$y2_anak3_kelamin = nosql($rnil2['anak3_kelamin']);
		$y2_anak3_sekolah = balikin2($rnil2['anak3_sekolah']);
		$y2_anak3_tunjangan = balikin2($rnil2['anak3_tunjangan']);

		echo '***<big><strong>KELUARGA</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Nama Ayah
		</td>
		<td>: </td>
		<td>
		<input name="nama_ayah" type="text" value="'.$y2_nama_ayah.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Nama Ibu
		</td>
		<td>: </td>
		<td>
		<input name="nama_ibu" type="text" value="'.$y2_nama_ibu.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Kawin / Belum Kawin
		</td>
		<td>: </td>
		<td>
		<select name="kawin">
		<option value="'.$y2_kawin_nil.'" selected>'.$y2_kawin.'</option>
		<option value="true">Kawin</option>
		<option value="false">Belum Kawin</option>
		</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Tgl. Nikah
		</td>
		<td>: </td>
		<td>
		<select name="nikah_tgl">
		<option value="'.$y2_nikah_tgl.'" selected>'.$y2_nikah_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="nikah_bln">
		<option value="'.$y2_nikah_bln.'" selected>'.$arrbln1[$y2_nikah_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="nikah_thn">
		<option value="'.$y2_nikah_thn.'" selected>'.$y2_nikah_thn.'</option>';
		for ($k=$lahir01;$k<=$lahir02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Nama Istri / Suami
		</td>
		<td>: </td>
		<td>
		<input name="pasangan_nama" type="text" value="'.$y2_pasangan_nama.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		TTL. Istri / Suami
		</td>
		<td>: </td>
		<td>
		<input name="pasangan_tmp_lahir" type="text" value="'.$y2_pasangan_tmp_lahir.'" size="30">,
		<select name="pasangan_tgl">
		<option value="'.$y2_pasangan_tgl.'" selected>'.$y2_pasangan_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="pasangan_bln">
		<option value="'.$y2_pasangan_bln.'" selected>'.$arrbln1[$y2_pasangan_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="pasangan_thn">
		<option value="'.$y2_pasangan_thn.'" selected>'.$y2_pasangan_thn.'</option>';
		for ($k=$lahir01;$k<=$lahir02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Pekerjaan Istri / Suami
		</td>
		<td>: </td>
		<td>
		<input name="pasangan_kerja" type="text" value="'.$y2_pasangan_kerja.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		NIP. Istri / Suami
		</td>
		<td>: </td>
		<td>
		<input name="pasangan_nip" type="text" value="'.$y2_pasangan_nip.'" size="20">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Gaji Istri / Suami
		</td>
		<td>: </td>
		<td>
		Rp. <input name="pasangan_gaji" type="text" value="'.$y2_pasangan_gaji.'" size="15">,00
		</td>
		</tr>

		<tr valign="top">
		<td width="150">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Anak I
		</td>
		<td></td>
		<td></td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Nama</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak1_nama" type="text" value="'.$y2_anak1_nama.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>TTL</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak1_tmp_lahir" type="text" value="'.$y2_anak1_tmp_lahir.'" size="30">,
		<select name="anak1_tgl">
		<option value="'.$y2_anak1_tgl.'" selected>'.$y2_anak1_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="anak1_bln">
		<option value="'.$y2_anak1_bln.'" selected>'.$arrbln1[$y2_anak1_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="anak1_thn">
		<option value="'.$y2_anak1_thn.'" selected>'.$y2_anak1_thn.'</option>';
		for ($k=$lahir01;$k<=$lahir02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		<dd>Jenis Kelamin</dd>
		</td>
		<td>: </td>
		<td>
		<select name="anak1_kelamin">
		<option value="'.$y2_anak1_kelamin.'" selected>'.$y2_anak1_kelamin.'</option>
		<option value="L">L</option>
		<option value="P">P</option>
		</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Sekolah</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak1_sekolah" type="text" value="'.$y2_anak1_sekolah.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Tunjangan</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak1_tunjangan" type="text" value="'.$y2_anak1_tunjangan.'" size="10">
		</td>
		</tr>


		<tr valign="top">
		<td width="150">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Anak II
		</td>
		<td></td>
		<td></td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Nama</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak2_nama" type="text" value="'.$y2_anak2_nama.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>TTL</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak2_tmp_lahir" type="text" value="'.$y2_anak2_tmp_lahir.'" size="30">,
		<select name="anak2_tgl">
		<option value="'.$y2_anak2_tgl.'" selected>'.$y2_anak2_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="anak2_bln">
		<option value="'.$y2_anak2_bln.'" selected>'.$arrbln1[$y2_anak2_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="anak2_thn">
		<option value="'.$y2_anak2_thn.'" selected>'.$y2_anak2_thn.'</option>';
		for ($k=$lahir01;$k<=$lahir02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		<dd>Jenis Kelamin</dd>
		</td>
		<td>: </td>
		<td>
		<select name="anak2_kelamin">
		<option value="'.$y2_anak2_kelamin.'" selected>'.$y2_anak2_kelamin.'</option>
		<option value="L">L</option>
		<option value="P">P</option>
		</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Sekolah</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak2_sekolah" type="text" value="'.$y2_anak2_sekolah.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Tunjangan</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak2_tunjangan" type="text" value="'.$y2_anak2_tunjangan.'" size="10">
		</td>
		</tr>


		<tr valign="top">
		<td width="150">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Anak III
		</td>
		<td></td>
		<td></td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Nama</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak3_nama" type="text" value="'.$y2_anak3_nama.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>TTL</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak3_tmp_lahir" type="text" value="'.$y2_anak3_tmp_lahir.'" size="30">,
		<select name="anak3_tgl">
		<option value="'.$y2_anak3_tgl.'" selected>'.$y2_anak3_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="anak3_bln">
		<option value="'.$y2_anak3_bln.'" selected>'.$arrbln1[$y2_anak3_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="anak3_thn">
		<option value="'.$y2_anak3_thn.'" selected>'.$y2_anak3_thn.'</option>';
		for ($k=$lahir01;$k<=$lahir02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		<dd>Jenis Kelamin</dd>
		</td>
		<td>: </td>
		<td>
		<select name="anak3_kelamin">
		<option value="'.$y2_anak3_kelamin.'" selected>'.$y2_anak3_kelamin.'</option>
		<option value="L">L</option>
		<option value="P">P</option>
		</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Sekolah</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak3_sekolah" type="text" value="'.$y2_anak3_sekolah.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Tunjangan</dd>
		</td>
		<td>: </td>
		<td>
		<input name="anak3_tunjangan" type="text" value="'.$y2_anak3_tunjangan.'" size="10">
		</td>
		</tr>

		</table>

		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">';
		}





	//jika diklat
	else if ($m == "diklat")
		{
		//data query -> diklat
		$qnil3 = mysql_query("SELECT * FROM m_pegawai_diklat ".
								"WHERE kd_pegawai = '$kd' ".
								"AND kd = '$dkkd'");
		$rnil3 = mysql_fetch_assoc($qnil3);
		$y3_nama_diklat = balikin2($rnil3['nama']);
		$y3_penyelenggara = balikin2($rnil3['penyelenggara']);
		$y3_tmp_diklat = balikin2($rnil3['tempat']);
		$y3_tahun_diklat = nosql($rnil3['tahun']);
		$y3_lama_diklat = nosql($rnil3['lama']);


		echo '***<big><strong>DIKLAT</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Nama
		</td>
		<td width="1">: </td>
		<td>
		<input name="nama_diklat" type="text" value="'.$y3_nama_diklat.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Penyelenggara
		</td>
		<td width="1">: </td>
		<td>
		<input name="penyelenggara" type="text" value="'.$y3_penyelenggara.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Tempat
		</td>
		<td width="1">: </td>
		<td>
		<input name="tmp_diklat" type="text" value="'.$y3_tmp_diklat.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Tahun
		</td>
		<td width="1">: </td>
		<td>
		<input name="tahun_diklat" type="text" value="'.$y3_tahun_diklat.'" size="4" onKeyPress="return numbersonly(this, event)">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Lama
		</td width="1">
		<td>: </td>
		<td>
		<input name="lama_diklat" type="text" value="'.$y3_lama_diklat.'" size="30">
		</td>
		</tr>


		</table>

		<input name="dkkd" type="hidden" value="'.$dkkd.'">
		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">
		<br>
		<br>';

		//query
		$qdk = mysql_query("SELECT * FROM m_pegawai_diklat ".
								"WHERE kd_pegawai = '$kd' ".
								"ORDER BY nama ASC");
		$rdk = mysql_fetch_assoc($qdk);
		$tdk = mysql_num_rows($qdk);

		if ($tdk != 0)
			{
			echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="1%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td><strong><font color="'.$warnatext.'">Nama Diklat</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Penyelenggara</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Tempat</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Tahun</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Lama</font></strong></td>
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
				$dk_kd = nosql($rdk['kd']);
				$dk_nama = balikin2($rdk['nama']);
				$dk_penyelenggara = balikin2($rdk['penyelenggara']);
				$dk_tempat = balikin2($rdk['tempat']);
				$dk_tahun = balikin2($rdk['tahun']);
				$dk_lama = balikin2($rdk['lama']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$dk_kd.'">
		        	</td>
				<td>
				<a href="'.$filenya.'?s=edit&m=diklat&kd='.$kd.'&dkkd='.$dk_kd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>'.$dk_nama.'</td>
				<td>'.$dk_penyelenggara.'</td>
				<td>'.$dk_tempat.'</td>
				<td>'.$dk_tahun.'</td>
				<td>'.$dk_lama.'</td>
		        	</tr>';
				}
			while ($rdk = mysql_fetch_assoc($qdk));

			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="263">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tdk.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPSDK" type="submit" value="HAPUS">
			</td>
			<td align="right">Total : <strong><font color="#FF0000">'.$tdk.'</font></strong> Data.</td>
			</tr>
			</table>';
			}

		else
			{
			echo '<font color="red"><strong>BELUM ADA DATA Diklat. Silahkan Entry. . .!!</strong></font>';
			}
		}




	//jika mengajar
	else if ($m == "mengajar")
		{
		//data query -> mengajar
		$qnil4 = mysql_query("SELECT * FROM m_pegawai_mengajar ".
								"WHERE kd_pegawai = '$kd'");
		$rnil4 = mysql_fetch_assoc($qnil4);
		$y4_ajar1_pddkn = balikin2($rnil4['mengajar1']);
		$y4_ajar1_jam = nosql($rnil4['jml_jam1']);
		$y4_ajar2_pddkn = balikin2($rnil4['mengajar2']);
		$y4_ajar2_jam = nosql($rnil4['jml_jam2']);


		echo '***<big><strong>MENGAJAR</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Mengajar I
		</td>
		<td width="1"></td>
		<td>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Program Pendidikan</dd>
		</td>
		<td width="1">: </td>
		<td>
		<input name="ajar1_pddkn" type="text" value="'.$y4_ajar1_pddkn.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jumlah Jam</dd>
		</td>
		<td width="1">: </td>
		<td>
		<input name="ajar1_jam" type="text" value="'.$y4_ajar1_jam.'" size="5" maxlength="3" onKeyPress="return numbersonly(this, event)">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Mengajar II
		</td>
		<td width="1"></td>
		<td>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Program Pendidikan</dd>
		</td>
		<td width="1">: </td>
		<td>
		<input name="ajar2_pddkn" type="text" value="'.$y4_ajar2_pddkn.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jumlah Jam</dd>
		</td>
		<td width="1">: </td>
		<td>
		<input name="ajar2_jam" type="text" value="'.$y4_ajar2_jam.'" size="5" maxlength="3" onKeyPress="return numbersonly(this, event)">
		</td>
		</tr>

		</table>

		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">';
		}




	//jika mk
	else if ($m == "mk")
		{
		//data query -> mk
		$qnil5 = mysql_query("SELECT * FROM m_pegawai_mk ".
								"WHERE kd_pegawai = '$kd'");
		$rnil5 = mysql_fetch_assoc($qnil5);
		$y5_mk1_bln = nosql($rnil5['sk_bln']);
		$y5_mk1_thn = nosql($rnil5['sk_thn']);
		$y5_mk2_bln = nosql($rnil5['s_bln']);
		$y5_mk2_thn = nosql($rnil5['s_thn']);


		echo '***<big><strong>MASA KERJA</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		SESUAI SK
		</td>
		<td width="1"></td>
		<td>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jml.Tahun</dd>
		</td>
		<td width="1">: </td>
		<td>
		<input name="mk1_thn" type="text" value="'.$y5_mk1_thn.'" size="2" onKeyPress="return numbersonly(this, event)">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jml.Bulan</dd>
		</td>
		<td width="1">: </td>
		<td>
		<input name="mk1_bln" type="text" value="'.$y5_mk1_bln.'" size="2" onKeyPress="return numbersonly(this, event)">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		KESELURUHAN
		</td>
		<td width="1"></td>
		<td>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jml.Tahun</dd>
		</td>
		<td width="1">: </td>
		<td>
		<input name="mk2_thn" type="text" value="'.$y5_mk2_thn.'" size="2" onKeyPress="return numbersonly(this, event)">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jml.Bulan</dd>
		</td>
		<td width="1">: </td>
		<td>
		<input name="mk2_bln" type="text" value="'.$y5_mk2_bln.'" size="2" onKeyPress="return numbersonly(this, event)">
		</td>
		</tr>

		</table>

		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">';
		}





	//jika pekerjaan
	else if ($m == "pekerjaan")
		{
		//data query -> pekerjaan
		$qnil6 = mysql_query("SELECT m_pegawai_pekerjaan.*, ".
								"DATE_FORMAT(tmt_awal, '%d') AS awal_tgl, ".
								"DATE_FORMAT(tmt_awal, '%m') AS awal_bln, ".
								"DATE_FORMAT(tmt_awal, '%Y') AS awal_thn, ".
								"DATE_FORMAT(tmt_akhir, '%d') AS akhir_tgl, ".
								"DATE_FORMAT(tmt_akhir, '%m') AS akhir_bln, ".
								"DATE_FORMAT(tmt_akhir, '%Y') AS akhir_thn ".
								"FROM m_pegawai_pekerjaan ".
								"WHERE kd_pegawai = '$kd'");
		$rnil6 = mysql_fetch_assoc($qnil6);
		$y6_status = nosql($rnil6['kd_status']);
		$y6_pangkat = nosql($rnil6['kd_pangkat']);
		$y6_golongan = nosql($rnil6['kd_golongan']);
		$y6_jabatan = nosql($rnil6['kd_jabatan']);
		$y6_awal_tgl = nosql($rnil6['awal_tgl']);
		$y6_awal_bln = nosql($rnil6['awal_bln']);
		$y6_awal_thn = nosql($rnil6['awal_thn']);
		$y6_akhir_tgl = nosql($rnil6['akhir_tgl']);
		$y6_akhir_bln = nosql($rnil6['akhir_bln']);
		$y6_akhir_thn = nosql($rnil6['akhir_thn']);


		echo '***<big><strong>PEKERJAAN</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Status
		</td>
		<td width="1">: </td>
		<td>
		<select name="status">';

		//terpilih
		$qstx = mysql_query("SELECT * FROM m_status ".
								"WHERE kd = '$y6_status'");
		$rstx = mysql_fetch_assoc($qstx);
		$stx_kd = nosql($rstx['kd']);
		$stx_status = balikin($rstx['status']);

		echo '<option value="'.$stx_kd.'">'.$stx_status.'</option>';

		$qst = mysql_query("SELECT * FROM m_status ".
								"WHERE kd <> '$y6_status' ".
								"ORDER BY status ASC");
		$rst = mysql_fetch_assoc($qst);

		do
			{
			$st_kd = nosql($rst['kd']);
			$st_status = balikin($rst['status']);

			echo '<option value="'.$st_kd.'">'.$st_status.'</option>';
			}
		while ($rst = mysql_fetch_assoc($qst));

		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Pangkat
		</td>
		<td width="1">: </td>
		<td>
		<select name="pangkat">';

		//terpilih
		$qpkx = mysql_query("SELECT * FROM m_pangkat ".
								"WHERE kd = '$y6_pangkat'");
		$rpkx = mysql_fetch_assoc($qpkx);
		$pkx_kd = nosql($rpkx['kd']);
		$pkx_pangkat = balikin($rpkx['pangkat']);

		echo '<option value="'.$pkx_kd.'">'.$pkx_pangkat.'</option>';

		$qpk = mysql_query("SELECT * FROM m_pangkat ".
								"WHERE kd <> '$y6_pangkat' ".
								"ORDER BY pangkat ASC");
		$rpk = mysql_fetch_assoc($qpk);

		do
			{
			$pk_kd = nosql($rpk['kd']);
			$pk_pangkat = balikin($rpk['pangkat']);

			echo '<option value="'.$pk_kd.'">'.$pk_pangkat.'</option>';
			}
		while ($rpk = mysql_fetch_assoc($qpk));

		echo '</select>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Golongan
		</td>
		<td width="1">: </td>
		<td>
		<select name="golongan">';

		//terpilih
		$qgolx = mysql_query("SELECT * FROM m_golongan ".
								"WHERE kd = '$y6_golongan'");
		$rgolx = mysql_fetch_assoc($qgolx);
		$golx_kd = nosql($rgolx['kd']);
		$golx_golongan = balikin($rgolx['golongan']);

		echo '<option value="'.$golx_kd.'">'.$golx_golongan.'</option>';

		$qgol = mysql_query("SELECT * FROM m_golongan ".
								"WHERE kd <> '$y6_golongan' ".
								"ORDER BY golongan ASC");
		$rgol = mysql_fetch_assoc($qgol);

		do
			{
			$gol_kd = nosql($rgol['kd']);
			$gol_golongan = balikin($rgol['golongan']);

			echo '<option value="'.$gol_kd.'">'.$gol_golongan.'</option>';
			}
		while ($rgol = mysql_fetch_assoc($qgol));

		echo '</select>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Jabatan
		</td>
		<td width="1">: </td>
		<td>
		<select name="jabatan">';

		//terpilih
		$qjbtx = mysql_query("SELECT * FROM m_jabatan ".
								"WHERE kd = '$y6_jabatan'");
		$rjbtx = mysql_fetch_assoc($qjbtx);
		$jbtx_kd = nosql($rjbtx['kd']);
		$jbtx_jabatan = balikin($rjbtx['jabatan']);

		echo '<option value="'.$jbtx_kd.'">'.$jbtx_jabatan.'</option>';

		$qjbt = mysql_query("SELECT * FROM m_jabatan ".
								"WHERE kd <> '$y6_jabatan' ".
								"ORDER BY jabatan ASC");
		$rjbt = mysql_fetch_assoc($qjbt);

		do
			{
			$jbt_kd = nosql($rjbt['kd']);
			$jbt_jabatan = balikin($rjbt['jabatan']);

			echo '<option value="'.$jbt_kd.'">'.$jbt_jabatan.'</option>';
			}
		while ($rjbt = mysql_fetch_assoc($qjbt));

		echo '</select>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		TMT. Awal
		</td>
		<td width="1">: </td>
		<td>
		<select name="awal_tgl">
		<option value="'.$y6_awal_tgl.'" selected>'.$y6_awal_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="awal_bln">
		<option value="'.$y6_awal_bln.'" selected>'.$arrbln1[$y6_awal_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="awal_thn">
		<option value="'.$y6_awal_thn.'" selected>'.$y6_awal_thn.'</option>';
		for ($k=$tmt01;$k<=$tmt02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		TMT. Akhir
		</td>
		<td width="1">: </td>
		<td>
		<select name="akhir_tgl">
		<option value="'.$y6_akhir_tgl.'" selected>'.$y6_akhir_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="akhir_bln">
		<option value="'.$y6_akhir_bln.'" selected>'.$arrbln1[$y6_akhir_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="akhir_thn">
		<option value="'.$y6_akhir_thn.'" selected>'.$y6_akhir_thn.'</option>';
		for ($k=$tmt01;$k<=$tmt02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		</table>

		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">';
		}




	//jika pendidikan
	else if ($m == "pendidikan")
		{
		//data query -> pendidikan
		$qnil7 = mysql_query("SELECT * FROM m_pegawai_pendidikan ".
								"WHERE kd_pegawai = '$kd' ".
								"AND kd = '$pddkkd'");
		$rnil7 = mysql_fetch_assoc($qnil7);
		$y7_ijazah = nosql($rnil7['kd_ijazah']);
		$y7_akta = nosql($rnil7['kd_akta']);
		$y7_lulus = nosql($rnil7['thn_lulus']);
		$y7_jurusan = balikin2($rnil7['jurusan']);
		$y7_nama_pt = balikin2($rnil7['nama_pt']);


		echo '***<big><strong>PENDIDIKAN</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Ijazah
		</td>
		<td width="1">: </td>
		<td>
		<select name="ijazah">';

		//terpilih
		$qijzx = mysql_query("SELECT * FROM m_ijazah ".
								"WHERE kd = '$y7_ijazah'");
		$rijzx = mysql_fetch_assoc($qijzx);
		$ijzx_kd = nosql($rijzx['kd']);
		$ijzx_ijazah = balikin($rijzx['ijazah']);

		echo '<option value="'.$ijzx_kd.'">'.$ijzx_ijazah.'</option>';

		$qijz = mysql_query("SELECT * FROM m_ijazah ".
								"WHERE kd <> '$y7_ijazah' ".
								"ORDER BY ijazah ASC");
		$rijz = mysql_fetch_assoc($qijz);

		do
			{
			$ijz_kd = nosql($rijz['kd']);
			$ijz_ijazah = balikin($rijz['ijazah']);

			echo '<option value="'.$ijz_kd.'">'.$ijz_ijazah.'</option>';
			}
		while ($rijz = mysql_fetch_assoc($qijz));

		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Akta
		</td>
		<td width="1">: </td>
		<td>
		<select name="akta">';

		//terpilih
		$qaktx = mysql_query("SELECT * FROM m_akta ".
								"WHERE kd = '$y7_akta'");
		$raktx = mysql_fetch_assoc($qaktx);
		$aktx_kd = nosql($raktx['kd']);
		$aktx_akta = balikin($raktx['akta']);

		echo '<option value="'.$aktx_kd.'">'.$aktx_akta.'</option>';

		$qakt = mysql_query("SELECT * FROM m_akta ".
								"WHERE kd <> '$y7_akta' ".
								"ORDER BY akta ASC");
		$rakt = mysql_fetch_assoc($qakt);

		do
			{
			$akt_kd = nosql($rakt['kd']);
			$akt_akta = balikin($rakt['akta']);

			echo '<option value="'.$akt_kd.'">'.$akt_akta.'</option>';
			}
		while ($rakt = mysql_fetch_assoc($qakt));

		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Tahun Lulus
		</td>
		<td width="1">: </td>
		<td>
		<input name="lulus" type="text" value="'.$y7_lulus.'" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Jurusan
		</td>
		<td width="1">: </td>
		<td>
		<input name="jurusan" type="text" value="'.$y7_jurusan.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Nama Perguruan Tinggi
		</td>
		<td width="1">: </td>
		<td>
		<input name="nama_pt" type="text" value="'.$y7_nama_pt.'" size="50">
		</td>
		</tr>

		</table>

		<input name="pddkkd" type="hidden" value="'.$pddkkd.'">
		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">

		<p>';


		//query
		$qdk = mysql_query("SELECT * FROM m_pegawai_pendidikan ".
								"WHERE kd_pegawai = '$kd'");
		$rdk = mysql_fetch_assoc($qdk);
		$tdk = mysql_num_rows($qdk);

		if ($tdk != 0)
			{
			echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="1%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td width="100"><strong><font color="'.$warnatext.'">Ijazah</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Akta</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Tahun Lulus</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Jurusan</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Nama PT</font></strong></td>
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
				$dk_kd = nosql($rdk['kd']);
				$dk_kd_ijazah = nosql($rdk['kd_ijazah']);
				$dk_kd_akta = nosql($rdk['kd_akta']);
				$dk_lulus = nosql($rdk['thn_lulus']);
				$dk_jurusan = balikin2($rdk['jurusan']);
				$dk_nama_pt = balikin2($rdk['nama_pt']);


				//terpilih
				$qijz = mysql_query("SELECT * FROM m_ijazah ".
										"WHERE kd = '$dk_kd_ijazah'");
				$rijz = mysql_fetch_assoc($qijz);
				$ijz_kd = nosql($rijz['kd']);
				$ijz_ijazah = balikin($rijz['ijazah']);


				//akta
				$qakt = mysql_query("SELECT * FROM m_akta ".
										"WHERE kd = '$dk_kd_akta'");
				$rakt = mysql_fetch_assoc($qakt);
				$akt_kd = nosql($rakt['kd']);
				$akt_akta = balikin($rakt['akta']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$dk_kd.'">
		        	</td>
				<td>
				<a href="'.$filenya.'?s=edit&m=pendidikan&kd='.$kd.'&pddkkd='.$dk_kd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>'.$ijz_ijazah.'</td>
				<td>'.$akt_akta.'</td>
				<td>'.$dk_lulus.'</td>
				<td>'.$dk_jurusan.'</td>
				<td>'.$dk_nama_pt.'</td>
		        	</tr>';
				}
			while ($rdk = mysql_fetch_assoc($qdk));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="263">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tdk.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPSPDDK" type="submit" value="HAPUS">
			</td>
			<td align="right">Total : <strong><font color="#FF0000">'.$tdk.'</font></strong> Data.</td>
			</tr>
			</table>';
			}

		else
			{
			echo '<font color="red"><strong>BELUM ADA DATA Diklat. Silahkan Entry. . .!!</strong></font>';
			}

		echo '</p>';
		}




	//jika kenaikan pangkat
	else if ($m == "naikpangkat")
		{
		echo '***<big><strong>KENAIKAN PANGKAT</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Pangkat / Gol.Ruang
		</td>
		<td width="1">: </td>
		<td>
		<select name="golru">
		<option value="" selected></option>';
		//pangkat
		$qki = mysql_query("SELECT * FROM m_pangkat ".
					"ORDER BY pangkat ASC");
		$row_qki = mysql_fetch_assoc($qki);
		$totalRows_qki = mysql_num_rows($qki);

		do
			{
			//nilai
			$ki_kd = nosql($row_qki['kd']);
			$ki_pangkat = balikin($row_qki['pangkat']);
			$ki_ket = balikin($row_qki['ket']);

			echo '<option value="'.$ki_kd.'">'.$ki_pangkat.' ['.$ki_ket.']</option>';
			}
		while ($row_qki = mysql_fetch_assoc($qki));

		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		No.SK
		</td>
		<td width="1">: </td>
		<td>
		<input name="nosk" type="text" size="20">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Tgl.SK / TMT.Pangkat
		</td>
		<td width="1">: </td>
		<td>
		<select name="xtgl1">
		<option value="" selected></option>';
		for ($i=1; $i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo '</select>
		<select name="xbln1">
          	<option value="" selected></option>';
		for ($i=1; $i<=12;$i++)
			{
          	echo '<option value="'.$i.'">'.$arrbln[$i].'</option>';
			}
		echo '</select>
		<select name="xthn1">
		<option value="" selected></option>';
		for ($i=$thn01; $i<=$thn02;$i++)
			{
          		echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo '</select>
		<br>
		<select name="xtgl2">
		<option value="" selected></option>';
		for ($i=1; $i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo '</select>
		<select name="xbln2">
		<option value="" selected></option>';
		for ($i=1; $i<=12;$i++)
			{
			echo '<option value="'.$i.'">'.$arrbln[$i].'</option>';
			}
		echo '</select>
		<select name="xthn2">
		<option value="" selected></option>';
		for ($i=$thn01; $i<=$thn02;$i++)
			{
          		echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Masa Kerja
		</td>
		<td width="1">: </td>
		<td>
		<input name="mk_thn" type="text" size="2" maxlength="2">THN,
		<input name="mk_bln" type="text" size="2" maxlength="2">BLN
		</td>
		</tr>
		</table>

		<input name="pktkd" type="hidden" value="'.$pktkd.'">
		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">

		<p>';
		//query
		$qkp = mysql_query("SELECT DATE_FORMAT(m_pegawai_pangkat.tgl_sk, '%d') AS xtgl1, ".
					"DATE_FORMAT(m_pegawai_pangkat.tgl_sk, '%m') AS xbln1, ".
					"DATE_FORMAT(m_pegawai_pangkat.tgl_sk, '%Y') AS xthn1, ".
					"DATE_FORMAT(m_pegawai_pangkat.tmt_pangkat, '%d') AS xtgl2, ".
					"DATE_FORMAT(m_pegawai_pangkat.tmt_pangkat, '%m') AS xbln2, ".
					"DATE_FORMAT(m_pegawai_pangkat.tmt_pangkat, '%Y') AS xthn2, ".
					"m_pegawai_pangkat.* ".
					"FROM m_pegawai_pangkat ".
					"WHERE kd_pegawai = '$kd' ".
					"ORDER BY tmt_pangkat ASC");
		$nilaikp = mysql_fetch_array($qkp);
		$totalRows_nilaikp = mysql_num_rows($qkp);


		echo '<table width="100%" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="217"><strong>Pangkat/Gol. Ruang</strong></td>
		<td><strong>NO.SK</strong><strong></strong></td>
		<td width="232"><strong>Tgl.SK / TMT.Pangkat</strong></td>
		<td width="100"><strong>Masa Kerja</strong></td>
		</tr>';

		if ($totalRows_nilaikp != 0)
			{
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

				//rs
				$kdx = nosql($nilaikp['kd']);

				$xtgl1 = nosql($nilaikp['xtgl1']);
				$xbln1 = nosql($nilaikp['xbln1']);
				$xthn1 = nosql($nilaikp['xthn1']);

				$xtgl2 = nosql($nilaikp['xtgl2']);
				$xbln2 = nosql($nilaikp['xbln2']);
				$xthn2 = nosql($nilaikp['xthn2']);

				if (($xtgl1 == "00") OR ($xthn1 == "0000") OR ($xtgl1 == "00") OR ($xthn2 == "0000"))
					{
					$xtgl1 = "";
					$xthn1 = "";
					$xtgl2 = "";
					$xthn2 = "";
					}

				$kd_pangkat = nosql($nilaikp['kd_pangkat']);
				$nosk = balikin2($nilaikp['no_sk']);
				$mk_thn = balikin2($nilaikp['mk_thn']);
				$mk_bln = balikin2($nilaikp['mk_bln']);

				//pangkat terpilih
				$qk = mysql_query("SELECT * FROM m_pangkat ".
										"WHERE kd = '$kd_pangkat'");
				$row_qk = mysql_fetch_assoc($qk);
				$totalRows_qk = mysql_num_rows($qk);

				$golru = balikin2($row_qk['pangkat']);
				$ket = balikin2($row_qk['ket']);


				echo '<tr valign="top"><td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$kdx.'">
		        	</td>
				<td>'.$golru.' ['.$ket.']</td>
				<td>'.$nosk.'</td>
				<td>'.$xtgl1.' '.$arrbln1[$xbln1].' '.$xthn1.'
				'.$xtgl2.' '.$arrbln1[$xbln2].' '.$xthn2.'
				</td>
				<td>'.$mk_thn.' THN, '.$mk_bln.' BLN</td>
				</tr>';
				}
			while ($nilaikp = mysql_fetch_assoc($qkp));
			}

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$totalRows_nilaikp.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPSPKT" type="submit" value="HAPUS">
		</td>
		</tr>
		</table>';
		}







	//jika kenaikan gaji
	else if ($m == "naikgaji")
		{
		echo '***<big><strong>KENAIKAN GAJI</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		TMT.Gaji Berkala
		</td>
		<td width="1">: </td>
		<td>
		<select name="xtgl1">
          	<option selected></option>';
		for ($i=1; $i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
        	echo '</select>
		<select name="xbln1">
		<option selected></option>';
		for ($i=1; $i<=12;$i++)
			{
			echo '<option value="'.$i.'">'.$arrbln[$i].'</option>';
			}
		echo '</select>
		<select name="xthn1">
		<option selected></option>';
		for ($i=$thn01; $i<=$thn02;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Masa Kerja Gaji
		</td>
		<td width="1">: </td>
		<td>
		<input name="mk_thn" type="text" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">THN,
        	<input name="mk_bln" type="text" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">BLN
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Gaji Pokok
		</td>
		<td width="1">: </td>
		<td>
		Rp.<select name="gapok">';
		//gaji
		$qgoli = mysql_query("SELECT * FROM m_gapok ".
					"ORDER BY gaji ASC");
		$row_goli = mysql_fetch_assoc($qgoli);
		$totalRows_goli = mysql_num_rows($qgoli);

		echo '<option value="" selected></option>';

		do
			{
			//nilai
			$goli_kd = nosql($row_goli['kd']);
			$goli_gaji = nosql($row_goli['gaji']);

			echo '<option value="'.$goli_kd.'">'.$goli_gaji.'</option>';
			}
		while ($row_goli = mysql_fetch_assoc($qgoli));

		echo '</select>,00
		</td>
		</tr>
		</table>

		<input name="gjkd" type="hidden" value="'.$gjkd.'">
		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">

		<p>';
		//peg_gaji_berkala
		$qx = mysql_query("SELECT DATE_FORMAT(tmt_gaji, '%d') AS xtgl1, ".
					"DATE_FORMAT(tmt_gaji, '%m') AS xbln1, ".
					"DATE_FORMAT(tmt_gaji, '%Y') AS xthn1, ".
					"m_pegawai_gaji_berkala.* ".
					"FROM m_pegawai_gaji_berkala ".
					"ORDER BY tmt_gaji DESC");
		$nilaix = mysql_fetch_assoc($qx);
		$totalRows_nilaix = mysql_num_rows($qx);


		echo '<table width="100%" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
 		<td width="290"><strong>TMT.Gaji Berkala</strong></td>
      		<td width="257"><strong>Masa Kerja Gaji</strong></td>
      		<td width="241"><strong>Gaji Pokok</strong></td>
		</tr>';

		if ($totalRows_nilaix != 0)
			{
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

				//rs
				$kdx = nosql($nilaix['kd']);
				$xtgl1 = nosql($nilaix['xtgl1']);
				$xbln1 = nosql($nilaix['xbln1']);
				$xthn1 = nosql($nilaix['xthn1']);

				$mk_thn = nosql($nilaix['mk_thn']);
				$mk_bln = nosql($nilaix['mk_bln']);

				$gapokkd = nosql($nilaix['kd_gapok']);

				echo '<tr valign="top"><td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$kdx.'">
		        	</td>
				<td>
				'.$xtgl1.' '.$arrbln1[$xbln1].' '.$xthn1.'
				</td>
				<td>
				'.$mk_thn.' THN, '.$mk_bln.' BLN
				</td>
				<td>';

				//terpilih
				$qgol = mysql_query("SELECT m_pegawai_gaji_berkala.*, m_gapok.* ".
							"FROM m_pegawai_gaji_berkala, m_gapok ".
							"WHERE m_pegawai_gaji_berkala.kd_gapok = m_gapok.kd ".
							"AND m_gapok.kd = '$gapokkd' ".
							"AND m_pegawai_gaji_berkala.kd_pegawai = '$kd'");
				$ngol = mysql_fetch_assoc($qgol);

				echo ''.xduit(balikin2($ngol['gaji'])).'</td>
				</tr>';
				}
			while ($nilaix = mysql_fetch_assoc($qx));
			}

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$totalRows_nilaix.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPSGJI" type="submit" value="HAPUS">
		</td>
		</tr>
		</table>';
		}







	//jika mutasi
	else if ($m == "mutasi")
		{
		//detail mutasi
		$qdmut = mysql_query("SELECT DATE_FORMAT(m_pegawai_mutasi.lama_tmt, '%d') AS xtgl1, ".
					"DATE_FORMAT(m_pegawai_mutasi.lama_tmt, '%m') AS xbln1, ".
					"DATE_FORMAT(m_pegawai_mutasi.lama_tmt, '%Y') AS xthn1, ".
					"DATE_FORMAT(m_pegawai_mutasi.baru_tmt, '%d') AS xtgl2, ".
					"DATE_FORMAT(m_pegawai_mutasi.baru_tmt, '%m') AS xbln2, ".
					"DATE_FORMAT(m_pegawai_mutasi.baru_tmt, '%Y') AS xthn2, ".
					"DATE_FORMAT(m_pegawai_mutasi.tgl_sk, '%d') AS xtgl3, ".
					"DATE_FORMAT(m_pegawai_mutasi.tgl_sk, '%m') AS xbln3, ".
					"DATE_FORMAT(m_pegawai_mutasi.tgl_sk, '%Y') AS xthn3, ".
					"m_pegawai_mutasi.*, m_mutasi.*, m_mutasi.kd AS mukd ".
					"FROM m_pegawai_mutasi, m_mutasi ".
					"WHERE m_pegawai_mutasi.kd_mutasi = m_mutasi.kd ".
					"AND m_pegawai_mutasi.kd_pegawai = '$kd'");
		$rdmut = mysql_fetch_assoc($qdmut);
		$dmut_lama_unit = balikin($rdmut['lama_unit']);
		$dmut_lama_jabatan = balikin($rdmut['lama_jabatan']);
		$dmut_lama_xtgl1 = nosql($rdmut['xtgl1']);
		$dmut_lama_xbln1 = nosql($rdmut['xbln1']);
		$dmut_lama_xthn1 = nosql($rdmut['xthn1']);
		$dmut_baru_unit = balikin($rdmut['baru_unit']);
		$dmut_baru_jabatan = balikin($rdmut['baru_jabatan']);
		$dmut_baru_xtgl2 = nosql($rdmut['xtgl2']);
		$dmut_baru_xbln2 = nosql($rdmut['xbln2']);
		$dmut_baru_xthn2 = nosql($rdmut['xthn2']);
		$dmut_mukd = nosql($rdmut['mukd']);
		$dmut_mutasi = nosql($rdmut['mutasi']);
		$dmut_no_sk = nosql($rdmut['no_sk']);
		$dmut_xtgl3 = nosql($rdmut['xtgl3']);
		$dmut_xbln3 = nosql($rdmut['xbln3']);
		$dmut_xthn3 = nosql($rdmut['xthn3']);




		echo '***<big><strong>MUTASI</strong></big> : <strong>'.$y_nip.'. '.$y_nama.'</strong>
		<hr>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Unit Lama
		</td>
		<td width="1">: </td>
		<td>
		<input name="lama_unit" type="text" value="'.$dmut_lama_unit.'" size="30">
		</td>
		</tr>
		<tr valign="top">
		<td width="150">
		Jabatan Lama
		</td>
		<td width="1">: </td>
		<td>
		<input name="lama_jabatan" type="text" value="'.$dmut_lama_jabatan.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		TMT.Lama
		</td>
		<td width="1">: </td>
		<td>
		<select name="xtgl1">
          	<option value="'.$dmut_lama_xtgl1.'" selected>'.$dmut_lama_xtgl1.'</option>';
		for ($i=1; $i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
        	echo '</select>
		<select name="xbln1">
		<option value="'.$dmut_lama_xbln1.'" selected>'.$dmut_lama_xbln1.'</option>';
		for ($i=1; $i<=12;$i++)
			{
			echo '<option value="'.$i.'">'.$arrbln[$i].'</option>';
			}
		echo '</select>
		<select name="xthn1">
		<option value="'.$dmut_lama_xthn1.'" selected>'.$dmut_lama_xthn1.'</option>';
		for ($i=$thn01; $i<=$thn02;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Jenis Mutasi
		</td>
		<td width="1">: </td>
		<td>
		<select name="jns_mutasi">
		<option value="'.$dmut_mukd.'" selected>'.$dmut_mutasi.'</option>';
		//daftar mutasi
		$query_rsmut = mysql_query("SELECT * FROM m_mutasi ".
						"ORDER BY kd ASC");
		$row_rsmut = mysql_fetch_assoc($query_rsmut);
		$totalRows_rsmut = mysql_num_rows($query_rsmut);

		do
			{
			echo '<option value="'.nosql($row_rsmut['kd']).'">'.balikin($row_rsmut['mutasi']).'</option>';
			}
		while ($row_rsmut = mysql_fetch_assoc($query_rsmut));
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Unit Baru
		</td>
		<td width="1">: </td>
		<td>
		<input name="baru_unit" type="text" value="'.$dmut_baru_unit.'" size="30">
		</td>
		</tr>
		<tr valign="top">
		<td width="150">
		Jabatan Baru
		</td>
		<td width="1">: </td>
		<td>
		<input name="baru_jabatan" type="text" value="'.$dmut_baru_jabatan.'" size="30">
		</td>
		</tr>
		<tr valign="top">
		<td width="150">
		TMT.Baru
		</td>
		<td width="1">: </td>
		<td>
		<select name="xtgl2">
          	<option value="'.$dmut_baru_xtgl2.'" selected>'.$dmut_baru_xtgl2.'</option>';
		for ($i=1; $i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
        	echo '</select>
		<select name="xbln2">
		<option value="'.$dmut_baru_xbln2.'"selected>'.$dmut_baru_xbln2.'</option>';
		for ($i=1; $i<=12;$i++)
			{
			echo '<option value="'.$i.'">'.$arrbln[$i].'</option>';
			}
		echo '</select>
		<select name="xthn2">
		<option value="'.$dmut_baru_xthn2.'" selected>'.$dmut_baru_xthn2.'</option>';
		for ($i=$thn01; $i<=$thn02;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		No.SK
		</td>
		<td width="1">: </td>
		<td>
		<input name="no_sk" type="text" value="'.$dmut_no_sk.'" size="30">
		</td>
		</tr>
		<tr valign="top">
		<td width="150">
		Tgl.SK
		</td>
		<td width="1">: </td>
		<td>
		<select name="xtgl3">
          	<option value="'.$dmut_xtgl3.'" selected>'.$dmut_xtgl3.'</option>';
		for ($i=1; $i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
        	echo '</select>
		<select name="xbln3">
		<option value="'.$dmut_xbln3.'" selected>'.$dmut_xbln3.'</option>';
		for ($i=1; $i<=12;$i++)
			{
			echo '<option value="'.$i.'">'.$arrbln[$i].'</option>';
			}
		echo '</select>
		<select name="xthn3">
		<option value="'.$dmut_xthn3.'" selected>'.$dmut_xthn3.'</option>';
		for ($i=$thn01; $i<=$thn02;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo '</select>
		</td>
		</tr>

		</table>

		<input name="gjkd" type="hidden" value="'.$gjkd.'">
		<input name="btnSMP1" type="submit" value="SIMPAN">
		<input name="btnDF" type="submit" value="DAFTAR PEGAWAI >>">';
		}


	echo '<br>
	<br>
	<br>

	<hr>
	<input name="s" type="hidden" value="'.nosql($_REQUEST['s']).'">
	<input name="m" type="hidden" value="'.nosql($_REQUEST['m']).'">
	<input name="kd" type="hidden" value="'.nosql($_REQUEST['kd']).'">
	<input name="btnRE1" type="submit" value="DATA DIRI">
	<input name="btnRE2" type="submit" value="KELUARGA">
	<input name="btnRE3" type="submit" value="DIKLAT">
	<input name="btnRE4" type="submit" value="MENGAJAR">
	<input name="btnRE5" type="submit" value="MASA KERJA">
	<input name="btnRE6" type="submit" value="PEKERJAAN">
	<input name="btnRE7" type="submit" value="PENDIDIKAN">
	<hr>
	<input name="btnRE8" type="submit" value="KENAIKAN PANGKAT">
	<input name="btnRE9" type="submit" value="KENAIKAN GAJI">
	<input name="btnRE10" type="submit" value="MUTASI">
	<hr>

	</td>
	<td width="1%">
	</td>
	<td>';

	//nek null foto
	if (empty($y_filex))
		{
		$nil_foto = "$sumber/img/foto_blank.jpg";
		}
	else
		{
		$nil_foto = "$sumber/filebox/pegawai/$kd/$y_filex";
		}

	echo '<img src="'.$nil_foto.'" alt="'.$y_nama.'" width="150" height="200" border="5">
	<br>
	<br>
	<input name="filex_foto" type="file" size="15">
	<br>
	<input name="btnGNT" type="submit" value="GANTI">
	</td>
	</tr>
	</table>';
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
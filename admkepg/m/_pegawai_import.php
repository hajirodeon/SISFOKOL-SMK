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
require("../../inc/cek/admkepg.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "pegawai_import.php";
$judul = "Import Pegawai";
$judulku = "[$kepg_session : $nip16_session.$nm16_session] ==> $judul";
$juduly = $judul;




//PROSES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//fungsi baca file excel
function parseExcel($excel_file_name_with_path)
	{
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);

	$colname=array('NO_URUT', 'NAMA', 'KELAMIN', 'TMP_LAHIR', 'TGL_LAHIR', 'AGAMA', 'STATUS', 'PASANGAN_NAMA', 'PASANGAN_TGL_LAHIR',
					'PASANGAN_TGL_NIKAH', 'ANAK_NAMA', 'ANAK_TMP_LAHIR', 'ANAK_TGL_LAHIR', 'RUMAH_ALAMAT', 'RUMAH_TELP', 'GOL_DARAH',
					'PDDKN_IJAZAH', 'PDDKN_AKTA', 'PDDKN_THN_LULUS', 'PDDKN_JURUSAN', 'PDDKN_NAMA_PT', 'KURSUS_NAMA',
					'KURSUS_PENYELENGGARA', 'KURSUS_TEMPAT', 'KURSUS_TAHUN', 'KURSUS_LAMA', 'PEGAWAI_STATUS', 'PEGAWAI_NIP',
					'PEGAWAI_KARPEG', 'KERJA_PANGKAT', 'KERJA_JABATAN', 'KERJA_TMT_AWAL', 'KERJA_TMT_AKHIR', 'SERTIFIKASI', 'SERTIFIKASI_TAHUN', 'EMAIL', );

	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++)
		{
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++)
			{
			$product[$i-1][$j-1]=$data->sheets[0]['cells'][$i][$j];
			$product[$i-1][$colname[$j-1]]=$data->sheets[0]['cells'][$i][$j];
			}
		}

	return $product;
	}





//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$filex_namex = $_POST['filex_namex'];


	//hapus file
	$path1 = "../../filebox/excel/$filex_namex";
	unlink ($path1);

	//re-direct
	$ke = "pegawai.php";
	xloc($ke);
	exit();
	}





//import sekarang
if ($_POST['btnIMx'])
	{
	//nilai
	$filex_namex = $_POST['filex_namex'];

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "pegawai.php?s=import";
		pekem($pesan,$ke);
		exit();
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

			//file-nya...
			$uploadfile = "$path2/$filex_namex";

			//require
			require_once '../../inc/class/excel/excel.php';

			$prod=parseExcel($uploadfile);
			$cprod = count($prod);
			for($i=1;$i<$cprod;$i++)
				{
				$i_xyz = md5("$x$i");
				$i_no_urut = addslashes($prod[$i][0]);
				$i_nama = addslashes($prod[$i][1]);

				$i_kelamin = addslashes($prod[$i][2]);
				$qkela = mysql_query("SELECT * FROM m_kelamin ".
										"WHERE kelamin = '$i_kelamin'");
				$rkela = mysql_fetch_assoc($qkela);
				$kela_kd = nosql($rkela['kd']);
				$i_kelamin = $kela_kd;

				$i_tmp_lahir = addslashes($prod[$i][3]);

				$i_tgl_lahir = addslashes($prod[$i][4]);
				$i_lahir_tgl = substr($i_tgl_lahir,0,2);
				$i_lahir_bln = substr($i_tgl_lahir,3,2);
				$i_lahir_thn = substr($i_tgl_lahir,-4);
				$i_tgl_lahir = "$i_lahir_thn:$i_lahir_bln:$i_lahir_tgl";

				$i_agama = addslashes($prod[$i][5]);
				$qagm = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_agama'");
				$ragm = mysql_fetch_assoc($qagm);
				$agm_kd = nosql($ragm['kd']);
				$i_agama = $agm_kd;

				$i_status = addslashes($prod[$i][6]);

				//jika kawin
				if ($i_status == "KAWIN")
					{
					$i_status = "true";
					}
				else
					{
					$i_status = "false";
					}


				$i_pasangan_nama = addslashes($prod[$i][7]);

				$i_pasangan_tgl_lahir = addslashes($prod[$i][8]);
				$i_pasangan_tgl = substr($i_pasangan_tgl_lahir,0,2);
				$i_pasangan_bln = substr($i_pasangan_tgl_lahir,3,2);
				$i_pasangan_thn = substr($i_pasangan_tgl_lahir,-4);
				$i_pasangan_tgl_lahir = "$i_pasangan_thn:$i_pasangan_bln:$i_pasangan_tgl";

				$i_pasangan_tgl_nikah = addslashes($prod[$i][9]);
				$i_pasangan_tgl = substr($i_pasangan_tgl_nikah,0,2);
				$i_pasangan_bln = substr($i_pasangan_tgl_nikah,3,2);
				$i_pasangan_thn = substr($i_pasangan_tgl_nikah,-4);
				$i_pasangan_tgl_nikah = "$i_pasangan_thn:$i_pasangan_bln:$i_pasangan_tgl";

				$i_anak_nama = addslashes($prod[$i][10]);
				$i_anak_tmp_lahir = addslashes($prod[$i][11]);

				$i_anak_tgl_lahir = addslashes($prod[$i][12]);
				$i_anak_tgl = substr($i_anak_tgl_lahir,0,2);
				$i_anak_bln = substr($i_anak_tgl_lahir,3,2);
				$i_anak_thn = substr($i_anak_tgl_lahir,-4);
				$i_anak_tgl_lahir = "$i_anak_thn:$i_anak_bln:$i_anak_tgl";

				$i_rumah_alamat = addslashes($prod[$i][13]);
				$i_rumah_telp = addslashes($prod[$i][14]);
				$i_gol_darah = addslashes($prod[$i][15]);

				$i_pddkn_ijazah = addslashes($prod[$i][16]);
				$qijzx = mysql_query("SELECT * FROM m_ijazah ".
										"WHERE ijazah = '$i_pddkn_ijazah'");
				$rijzx = mysql_fetch_assoc($qijzx);
				$i_pddkn_ijazah = balikin($rijzx['kd']);

				$i_pddkn_akta = addslashes($prod[$i][17]);
				$qaktx = mysql_query("SELECT * FROM m_akta ".
										"WHERE akta = '$i_pddkn_akta'");
				$raktx = mysql_fetch_assoc($qaktx);
				$i_pddkn_akta = balikin($raktx['kd']);

				$i_pddkn_thn_lulus = addslashes($prod[$i][18]);
				$i_pddkn_jurusan = addslashes($prod[$i][19]);
				$i_pddkn_nama_pt = addslashes($prod[$i][20]);
				$i_kursus_nama = addslashes($prod[$i][21]);
				$i_kursus_penyelenggara = addslashes($prod[$i][22]);
				$i_kursus_tempat = addslashes($prod[$i][23]);
				$i_kursus_tahun = addslashes($prod[$i][24]);
				$i_kursus_lama = addslashes($prod[$i][25]);

				$i_pegawai_status = addslashes($prod[$i][26]);
				$qtup = mysql_query("SELECT * FROM m_status ".
										"WHERE status = '$i_pegawai_status'");
				$rtup = mysql_fetch_assoc($qtup);
				$tup_kd = nosql($rtup['kd']);
				$i_pegawai_status = $tup_kd;

				$i_pegawai_nip = addslashes($prod[$i][27]);
				$i_pegawai_karpeg = addslashes($prod[$i][28]);

				$i_kerja_pangkat = addslashes($prod[$i][29]);
				$qgol = mysql_query("SELECT * FROM m_golongan ".
										"WHERE golongan = '$i_kerja_pangkat'");
				$rgol = mysql_fetch_assoc($qgol);
				$gol_kd = nosql($rgol['kd']);
				$i_kerja_pangkat = $gol_kd;


				$i_kerja_jabatan = addslashes($prod[$i][30]);
				$qjbtx = mysql_query("SELECT * FROM m_jabatan ".
										"WHERE jabatan = '$i_kerja_jabatan'");
				$rjbtx = mysql_fetch_assoc($qjbtx);
				$i_kerja_jabatan = balikin($rjbtx['kd']);

				$i_kerja_tmt = addslashes($prod[$i][31]);
				$i_kerja_tmt_tgl = substr($i_kerja_tmt,0,2);
				$i_kerja_tmt_bln = substr($i_kerja_tmt,3,2);
				$i_kerja_tmt_thn = substr($i_kerja_tmt,-4);
				$i_kerja_tmt = "$i_kerja_tmt_thn:$i_kerja_tmt_bln:$i_kerja_tmt_tgl";


				$i_kerja_tmt2 = addslashes($prod[$i][32]);
				$i_kerja_tmt2_tgl = substr($i_kerja_tmt2,0,2);
				$i_kerja_tmt2_bln = substr($i_kerja_tmt2,3,2);
				$i_kerja_tmt2_thn = substr($i_kerja_tmt2,-4);
				$i_kerja_tmt2 = "$i_kerja_tmt2_thn:$i_kerja_tmt2_bln:$i_kerja_tmt2_tgl";




				$i_sertifikasi = addslashes($prod[$i][33]);
				$i_sertifikasi_tahun = addslashes($prod[$i][34]);
				$i_email = addslashes($prod[$i][35]);


				//password...
				$i_pass = md5($i_pegawai_nip);


				//m_pegawai /////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_pegawai ".
										"WHERE nip = '$i_pegawai_nip'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_kd = nosql($rcc['kd']);


				//jika ada, update
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai SET usernamex = '$i_pegawai_nip', ".
									"passwordx = '$i_pass', ".
									"nip = '$i_pegawai_nip', ".
									"nuptk = '$i_nuptk', ".
									"nama = '$i_nama', ".
									"no_karpeg = '$i_pegawai_karpeg', ".
									"tmp_lahir = '$i_tmp_lahir', ".
									"tgl_lahir = '$i_tgl_lahir', ".
									"kd_kelamin = '$i_kelamin', ".
									"kd_agama = '$i_agama', ".
									"alamat = '$i_rumah_alamat', ".
									"telp = '$i_rumah_telp', ".
									"gol_darah = '$i_gol_darah', ".
									"sertifikasi = '$i_sertifikasi', ".
									"sertifikasi_tahun = '$i_sertifikasi_tahun', ".						"email = '$i_email' ".
									"WHERE kd = '$cc_kd'");



					//update ke janissari
					mysql_query("UPDATE m_user SET usernamex = '$i_pegawai_nip', ".
							"passwordx = '$i_pass', ".
							"nomor = '$i_pegawai_nip', ".
							"nama = '$i_nama' ".
							"WHERE kd = '$cc_kd'");
					}

				//jika blm ada, insert
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai(kd, usernamex, passwordx, nip, nuptk, nama, ".
									"no_karpeg, tmp_lahir, tgl_lahir, kd_kelamin, kd_agama, ".
									"alamat, telp, gol_darah, sertifikasi, sertifikas_tahun, email, postdate) VALUES ".
									"('$i_xyz', '$i_pegawai_nip', '$i_pass', '$i_pegawai_nip', '$i_nuptk', '$i_nama', ".
									"'$i_pegawai_karpeg', '$i_tmp_lahir', '$i_tgl_lahir', '$i_kelamin', '$i_agama', ".
									"'$i_rumah_alamat', '$i_rumah_telp', '$i_gol_darah', '$i_sertifikasi', '$i_sertifikasi_tahun', '$i_email', '$today')");



					//masukkan ke janissari
					mysql_query("INSERT INTO m_user(kd, usernamex, passwordx, nomor, nama, tipe, postdate) VALUES ".
							"('$i_xyz', '$i_pegawai_nip', '$i_pass', '$i_pegawai_nip', '$i_nama', 'GURU', '$today')");
					}


				//m_pegawai_keluarga ////////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_pegawai_keluarga ".
										"WHERE kd_pegawai = '$cc_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai_keluarga SET status_kawin = '$i_status', ".
									"tgl_nikah = '$i_pasangan_tgl_nikah', ".
									"nama_pasangan = '$i_pasangan_nama', ".
									"tgl_lahir_pasangan = '$i_pasangan_tgl_lahir', ".
									"anak1_nama = '$i_anak_nama', ".
									"anak1_tmp_lahir = '$i_anak_tmp_lahir', ".
									"anak1_tgl_lahir = '$i_anak_tgl_lahir' ".
									"WHERE kd_pegawai = '$cc_kd'");
					}
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai_keluarga (kd, kd_pegawai, status_kawin, tgl_nikah, ".
									"nama_pasangan, tgl_lahir_pasangan, ".
									"anak1_nama, anak1_tmp_lahir, anak1_tgl_lahir) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_status', '$i_pasangan_tgl_nikah', ".
									"'$i_pasangan_nama', '$i_pasangan_tgl_lahir', ".
									"'$i_anak_nama', '$i_anak_tmp_lahir', '$i_anak_tgl_lahir')");
					}








				//m_pegawai_pendidikan //////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_pegawai_pendidikan ".
										"WHERE kd_pegawai = '$cc_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai_pendidikan SET kd_ijazah = '$i_pddkn_ijazah', ".
									"kd_akta = '$i_pddkn_akta', ".
									"thn_lulus = '$i_pddkn_thn_lulus', ".
									"jurusan = '$i_pddkn_jurusan', ".
									"nama_pt = '$i_pddkn_nama_pt' ".
									"WHERE kd_pegawai = '$cc_kd'");
					}
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai_pendidikan (kd, kd_pegawai, kd_ijazah, kd_akta, thn_lulus, ".
									"jurusan, nama_pt) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_pddkn_ijazah', '$i_pddkn_akta', '$i_pddkn_thn_lulus', ".
									"'$i_pddkn_jurusan', '$i_pddkn_nama_pt')");
					}




				//m_pegawai_diklat/kursus ///////////////////////////////////////////////////////////////////////////////////////////////
				//cek
				$qcc = mysql_query("SELECT * FROM m_pegawai_diklat ".
										"WHERE kd_pegawai = '$cc_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai_diklat SET nama = '$i_kursus_nama', ".
									"penyelenggara = '$i_kursus_penyelenggara', ".
									"tempat = '$i_kursus_penyelenggara', ".
									"tahun = '$i_kursus_tahun', ".
									"lama = '$i_kursus_lama' ".
									"WHERE kd_pegawai = '$cc_kd'");
					}
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai_diklat (kd, kd_pegawai, nama, penyelenggara, tempat, ".
									"tahun, lama) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_kursus_nama', '$i_kursus_penyelenggara', '$i_kursus_tempat', ".
									"'$i_kursus_tahun', '$i_kursus_lama')");
					}





				//m_pegawai_pekerjaan ///////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_pegawai_pekerjaan ".
										"WHERE kd_pegawai = '$cc_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai_pekerjaan SET kd_status = '$i_pegawai_status', ".
									"kd_golongan = '$i_kerja_pangkat', ".
									"kd_jabatan = '$i_kerja_jabatan', ".
									"tmt_awal = '$i_kerja_tmt', ".
									"tmt_akhir = '$i_kerja_tmt2' ".
									"WHERE kd_pegawai = '$cc_kd'");
					}
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai_pekerjaan (kd, kd_pegawai, kd_status, kd_golongan, ".
									"kd_jabatan, tmt_awal, tmt_akhir) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_pegawai_status', '$i_kerja_pangkat', ".
									"'$i_kerja_jabatan', '$i_kerja_tmt', '$i_kerja_tmt2')");
					}
				}


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex";
			chmod($path1,0777);
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "pegawai.php";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "pegawai.php?s=import";
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
require("../../inc/menu/admkepg.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">';

//nama file...
$filex_namex = $_REQUEST['filex_namex'];

//nilai
$path1 = "../../filebox/excel/$filex_namex";

//file-nya...
$uploadfile = $path1;


echo '<p>
Nama File Yang di-Import : <strong>'.$filex_namex.'</strong>
<br>
<input name="filex_namex" type="hidden" value="'.$filex_namex.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
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

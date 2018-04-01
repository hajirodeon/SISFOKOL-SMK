<?php
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
require("../../inc/cek/admkesw.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_import.php";
$judul = "Import Siswa";
$judulku = "[$kesw_session : $nip12_session. $nm12_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);



//PROSES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd  = nosql($_POST['kompkd']);
	$filex_namex = $_POST['filex_namex'];


	//hapus file
	$path1 = "../../filebox/excel/$filex_namex";
	chmod($path1,0777);
	unlink ($path1);

	//re-direct
	$ke = "siswa.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd";
	xloc($ke);
	exit();
	}





//import sekarang
if ($_POST['btnIMx'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$filex_namex = $_POST['filex_namex'];

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "siswa.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox/excel";

			//file-nya...
			$uploadfile = "$path1/$filex_namex";



			//require
			require_once '../../inc/class/excel/excel_reader2.php';
			$data = new Spreadsheet_Excel_Reader($uploadfile);


			// membaca jumlah baris dari data excel
			$baris = $data->rowcount(0);
//			$baris = $data->rowcount($sheet_index=0);
			$jml_kolom = $data->colcount($sheet=0);
			$sheet_ke = 0;



			// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
			for ($i=2; $i<=$baris; $i++)
				{
				$i_xyz = md5("$x$i");
				$i_nis = $data->val($i, 2,$sheet_ke);
				$i_nisn = $data->val($i, 3,$sheet_ke);
				$i_nama = $data->val($i, 4,$sheet_ke);
				$i_panggilan = $data->val($i, 5,$sheet_ke);

				//kelamin
				$i_kelamin = $data->val($i, 6,$sheet_ke);
				$qkela = mysql_query("SELECT * FROM m_kelamin ".
										"WHERE kelamin = '$i_kelamin'");
				$rkela = mysql_fetch_assoc($qkela);
				$kela_kd = nosql($rkela['kd']);
				$i_kelamin = $kela_kd;


				$i_tmp_lahir = $data->val($i, 7,$sheet_ke);
				$i_tgl_lahir = titikdua($data->val($i, 8,$sheet_ke));
				$i_lahir_tgl = substr($i_tgl_lahir,0,2);
				$i_lahir_bln = substr($i_tgl_lahir,3,2);
				$i_lahir_thn = substr($i_tgl_lahir,-4);
				$i_tgl_lahir = "$i_lahir_thn:$i_lahir_bln:$i_lahir_tgl";

				//agama
				$i_agama = $data->val($i, 9,$sheet_ke);
				$qagm = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_agama'");
				$ragm = mysql_fetch_assoc($qagm);
				$agm_kd = nosql($ragm['kd']);
				$i_agama = $agm_kd;


				$i_warga_negara = $data->val($i, 10,$sheet_ke);
				$i_anak_ke = $data->val($i, 11,$sheet_ke);
				$i_jml_sdr_kandung = $data->val($i, 12,$sheet_ke);
				$i_jml_sdr_tiri = $data->val($i, 13,$sheet_ke);
				$i_jml_sdr_angkat = $data->val($i, 14,$sheet_ke);
				$i_bahasa = $data->val($i, 15,$sheet_ke);



				$i_alamat = $data->val($i, 16,$sheet_ke);
				$i_telp = $data->val($i, 17,$sheet_ke);
				$i_jarak = $data->val($i, 18,$sheet_ke);



				$i_gol_darah = $data->val($i, 19,$sheet_ke);
				$i_penyakit = $data->val($i, 20,$sheet_ke);
				$i_kelainan = $data->val($i, 21,$sheet_ke);
				$i_tb = $data->val($i, 22,$sheet_ke);
				$i_bb = $data->val($i, 23,$sheet_ke);



				$i_tamat_dari = $data->val($i, 24,$sheet_ke);

				$i_tgl_ijazah = titikdua($data->val($i, 25,$sheet_ke));
				$i_ijazah_tgl = substr($i_tgl_ijazah,0,2);
				$i_ijazah_bln = substr($i_tgl_ijazah,3,2);
				$i_ijazah_thn = substr($i_tgl_ijazah,-4);
				$i_tgl_ijazah = "$i_ijazah_thn:$i_ijazah_bln:$i_ijazah_tgl";

				$i_no_ijazah = $data->val($i, 26,$sheet_ke);

				$i_lama_belajar = $data->val($i, 27,$sheet_ke);



				$i_diterima_kelas = $data->val($i, 28,$sheet_ke);

				$i_tgl_diterima = titikdua($data->val($i, 29,$sheet_ke));
				$i_diterima_tgl = substr($i_tgl_diterima,0,2);
				$i_diterima_bln = substr($i_tgl_diterima,3,2);
				$i_diterima_thn = substr($i_tgl_diterima,-4);
				$i_tgl_diterima = "$i_diterima_thn:$i_diterima_bln:$i_diterima_tgl";



				$i_ayah_nama = $data->val($i, 30,$sheet_ke);
				$i_ayah_tmp_lahir = $data->val($i, 31,$sheet_ke);

				$i_ayah_tgl_lahir = titikdua($data->val($i, 32,$sheet_ke));
				$i_ayah_lahir_tgl = substr($i_ayah_tgl_lahir,0,2);
				$i_ayah_lahir_bln = substr($i_ayah_tgl_lahir,3,2);
				$i_ayah_lahir_thn = substr($i_ayah_tgl_lahir,-4);
				$i_ayah_tgl_lahir = "$i_ayah_lahir_thn:$i_ayah_lahir_bln:$i_ayah_lahir_tgl";

				//agama
				$i_ayah_agama = $data->val($i, 33,$sheet_ke);
				$qagmx = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_ayah_agama'");
				$ragmx = mysql_fetch_assoc($qagmx);
				$agmx_kd = nosql($ragmx['kd']);
				$i_ayah_agama = $agmx_kd;


				$i_ayah_warga_negara = $data->val($i, 34,$sheet_ke);
				$i_ayah_pendidikan = $data->val($i, 35,$sheet_ke);

				//pekerjaan
				$i_ayah_pekerjaan = $data->val($i, 36,$sheet_ke);
				$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE pekerjaan = '$i_ayah_pekerjaan'");
				$rpekx = mysql_fetch_assoc($qpekx);
				$pekx_kd = nosql($rpekx['kd']);
				$i_ayah_pekerjaan = $pekx_kd;

				$i_ayah_penghasilan = $data->val($i, 37,$sheet_ke);
				$i_ayah_alamat = $data->val($i, 38,$sheet_ke);
				$i_ayah_telp = $data->val($i, 39,$sheet_ke);
				$i_ayah_hidup = $data->val($i, 40,$sheet_ke);



				//ibu
				$i_ibu_nama = $data->val($i, 41,$sheet_ke);
				$i_ibu_tmp_lahir = $data->val($i, 42,$sheet_ke);

				$i_ibu_tgl_lahir = titikdua($data->val($i,43,$sheet_ke));
				$i_ibu_lahir_tgl = substr($i_ibu_tgl_lahir,0,2);
				$i_ibu_lahir_bln = substr($i_ibu_tgl_lahir,3,2);
				$i_ibu_lahir_thn = substr($i_ibu_tgl_lahir,-4);
				$i_ibu_tgl_lahir = "$i_ibu_lahir_thn:$i_ibu_lahir_bln:$i_ibu_lahir_tgl";

				//agama
				$i_ibu_agama = $data->val($i, 44,$sheet_ke);
				$qagmx = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_ibu_agama'");
				$ragmx = mysql_fetch_assoc($qagmx);
				$agmx_kd = nosql($ragmx['kd']);
				$i_ibu_agama = $agmx_kd;


				$i_ibu_warga_negara = $data->val($i, 45,$sheet_ke);
				$i_ibu_pendidikan = $data->val($i, 46,$sheet_ke);

				//pekerjaan
				$i_ibu_pekerjaan = $data->val($i, 57,$sheet_ke);
				$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE pekerjaan = '$i_ibu_pekerjaan'");
				$rpekx = mysql_fetch_assoc($qpekx);
				$pekx_kd = nosql($rpekx['kd']);
				$i_ibu_pekerjaan = $pekx_kd;

				$i_ibu_penghasilan = $data->val($i, 48,$sheet_ke);
				$i_ibu_alamat = $data->val($i, 49,$sheet_ke);
				$i_ibu_telp = $data->val($i, 50,$sheet_ke);
				$i_ibu_hidup = $data->val($i, 51,$sheet_ke);



				//wali
				$i_wali_nama = $data->val($i, 52,$sheet_ke);
				$i_wali_tmp_lahir = $data->val($i, 53,$sheet_ke);

				$i_wali_tgl_lahir = titikdua($data->val($i, 54,$sheet_ke));
				$i_wali_lahir_tgl = substr($i_wali_tgl_lahir,0,2);
				$i_wali_lahir_bln = substr($i_wali_tgl_lahir,3,2);
				$i_wali_lahir_thn = substr($i_wali_tgl_lahir,-4);
				$i_wali_tgl_lahir = "$i_wali_lahir_thn:$i_wali_lahir_bln:$i_wali_lahir_tgl";

				//agama
				$i_wali_agama = $data->val($i, 55,$sheet_ke);
				$qagmx = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_wali_agama'");
				$ragmx = mysql_fetch_assoc($qagmx);
				$agmx_kd = nosql($ragmx['kd']);
				$i_wali_agama = $agmx_kd;


				$i_wali_warga_negara = $data->val($i, 56,$sheet_ke);
				$i_wali_pendidikan = $data->val($i, 57,$sheet_ke);

				//pekerjaan
				$i_wali_pekerjaan = $data->val($i, 58,$sheet_ke);
				$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE pekerjaan = '$i_wali_pekerjaan'");
				$rpekx = mysql_fetch_assoc($qpekx);
				$pekx_kd = nosql($rpekx['kd']);
				$i_wali_pekerjaan = $pekx_kd;

				$i_wali_penghasilan = $data->val($i, 59,$sheet_ke);
				$i_wali_alamat = $data->val($i, 60,$sheet_ke);
				$i_wali_telp = $data->val($i, 61,$sheet_ke);





				$i_gemar_seni = $data->val($i, 62,$sheet_ke);
				$i_gemar_or = $data->val($i, 63,$sheet_ke);
				$i_gemar_lain = $data->val($i, 64,$sheet_ke);



				$i_bea_siswa = $data->val($i, 65,$sheet_ke);






				//password...
				$i_pass = md5($i_nis);

				//ke mysql
				$qcc = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
							"siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND siswa_kelas.kd_keahlian = '$keahkd' ".
							"AND m_siswa.nis = '$i_nis'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_mskd = nosql($rcc['mskd']);
				$cc_skkd = nosql($rcc['skkd']);


				//jika ada, update
				if ($tcc != 0)
					{
					//m_siswa
					mysql_query("UPDATE m_siswa SET usernamex = '$i_nis', ".
							"passwordx = '$i_pass', ".
							"nisn = '$i_nisn', ".
							"nama = '$i_nama', ".
							"panggilan = '$i_panggilan', ".
							"tmp_lahir = '$i_tmp_lahir', ".
							"tgl_lahir = '$i_tgl_lahir', ".
							"kd_kelamin = '$i_kelamin', ".
							"kd_agama = '$i_agama', ".
							"warga_negara = '$i_warga_negara', ".
							"anak_ke = '$i_anak_ke', ".
							"jml_sdr_kandung = '$i_jml_sdr_kandung', ".
							"jml_sdr_tiri = '$i_jml_sdr_tiri', ".
							"jml_sdr_angkat = '$i_jml_sdr_angkat', ".
							"bhs_harian = '$i_bahasa' ".
							"WHERE nis = '$i_nis'");



					//update ke janissari
					mysql_query("UPDATE m_user SET usernamex = '$i_nis', ".
							"passwordx = '$i_pass', ".
							"nomor = '$i_nis', ".
							"nama = '$i_nama' ".
							"WHERE kd = '$cc_mskd'");


					//m_siswa_tmp_tinggal
					mysql_query("UPDATE m_siswa_tmp_tinggal SET alamat = '$i_alamat', ".
									"telp = '$i_telp', ".
									"jarak = '$i_jarak' ".
									"WHERE kd_siswa = '$cc_mskd'");


					//m_siswa_kesehatan
					mysql_query("UPDATE m_siswa_kesehatan SET gol_darah = '$i_gol_darah', ".
									"penyakit = '$i_penyakit', ".
									"kelainan = '$i_kelainan', ".
									"tinggi = '$i_tb', ".
									"berat = '$i_bb' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_pendidikan
					mysql_query("UPDATE m_siswa_pendidikan SET lulusan = '$i_tamat_dari', ".
									"tgl_sttb = '$i_tgl_ijazah', ".
									"no_sttb = '$i_no_ijazah', ".
									"lama = '$i_lama_belajar', ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_diterima
					mysql_query("UPDATE m_siswa_diterima SET kelas = '$i_diterima_kelas', ".
									"tgl = '$i_tgl_diterima' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_ayah
					mysql_query("UPDATE m_siswa_ayah SET nama = '$i_ayah_nama', ".
									"tmp_lahir = '$i_ayah_tmp_lahir', ".
									"tgl_lahir = '$i_ayah_tgl_lahir', ".
									"kd_agama = '$i_ayah_agama', ".
									"warga_negara = '$i_ayah_warga_negara', ".
									"pendidikan = '$i_ayah_pendidikan', ".
									"kd_pekerjaan = '$i_ayah_pekerjaan', ".
									"penghasilan = '$i_ayah_penghasilan', ".
									"alamat = '$i_ayah_alamat', ".
									"telp = '$i_ayah_telp', ".
									"hidup = '$i_ayah_hidup' ".
									"WHERE kd_siswa = '$cc_mskd'");


					//m_siswa_ibu
					mysql_query("UPDATE m_siswa_ibu SET nama = '$i_ibu_nama', ".
									"tmp_lahir = '$i_ibu_tmp_lahir', ".
									"tgl_lahir = '$i_ibu_tgl_lahir', ".
									"kd_agama = '$i_ibu_agama', ".
									"warga_negara = '$i_ibu_warga_negara', ".
									"pendidikan = '$i_ibu_pendidikan', ".
									"kd_pekerjaan = '$i_ibu_pekerjaan', ".
									"penghasilan = '$i_ibu_penghasilan', ".
									"alamat = '$i_ibu_alamat', ".
									"telp = '$i_ibu_telp', ".
									"hidup = '$i_ibu_hidup' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_wali
					mysql_query("UPDATE m_siswa_wali SET nama = '$i_wali_nama', ".
									"tmp_lahir = '$i_wali_tmp_lahir', ".
									"tgl_lahir = '$i_wali_tgl_lahir', ".
									"kd_agama = '$i_wali_agama', ".
									"warga_negara = '$i_wali_warga_negara', ".
									"pendidikan = '$i_wali_pendidikan', ".
									"kd_pekerjaan = '$i_wali_pekerjaan', ".
									"penghasilan = '$i_wali_penghasilan', ".
									"alamat = '$i_wali_alamat', ".
									"telp = '$i_wali_telp' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_hobi
					mysql_query("UPDATE m_siswa_wali SET kesenian = '$i_gemar_seni', ".
									"olah_raga = '$i_gemar_or', ".
									"lain_lain = '$i_gemar_lain' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_perkembangan
					mysql_query("UPDATE m_siswa_perkembangan SET bea_siswa = '$i_bea_siswa' ".
									"WHERE kd_siswa = '$cc_mskd'");
					}

				//jika blm ada, insert
				else
					{
					//m_siswa
					mysql_query("INSERT INTO m_siswa(kd, usernamex, passwordx, nis, nisn, nama, panggilan, ".
							"tmp_lahir, tgl_lahir, kd_kelamin, kd_agama, warga_negara, ".
							"anak_ke, jml_sdr_kandung, jml_sdr_tiri, jml_sdr_angkat, bhs_harian) VALUES ".
							"('$i_xyz', '$i_nis', '$i_pass', '$i_nis', '$i_nisn', '$i_nama', '$i_panggilan', ".
							"'$i_tmp_lahir', '$i_tgl_lahir', '$i_kelamin', '$i_agama', '$i_warga_negara', ".
							"'$i_anak_ke', '$i_jml_sdr_kandung', '$i_jml_sdr_tiri', '$i_jml_sdr_angkat', '$i_bahasa')");


					//masukkan ke janissari
					mysql_query("INSERT INTO m_user(kd, usernamex, passwordx, nomor, nama, tipe, postdate) VALUES ".
							"('$i_xyz', '$i_nis', '$i_pass', '$i_nis', '$i_nama', 'SISWA', '$today')");


					//siswa_kelas
					mysql_query("INSERT INTO siswa_kelas(kd, kd_tapel, kd_kelas, kd_keahlian, kd_keahlian_kompetensi, kd_siswa) VALUES ".
									"('$i_xyz', '$tapelkd', '$kelkd', '$keahkd', '$kompkd', '$i_xyz')");

					//m_siswa_tmp_tinggal
					mysql_query("INSERT INTO m_siswa_tmp_tinggal(kd, kd_siswa, alamat, telp, jarak) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_alamat', '$i_telp', '$i_jarak')");

					//m_siswa_kesehatan
					mysql_query("INSERT INTO m_siswa_kesehatan(kd, kd_siswa, gol_darah, penyakit, kelainan, tinggi, berat) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_gol_darah', '$i_penyakit', '$i_kelainan', '$i_tb', '$i_bb')");

					//m_siswa_pendidikan
					mysql_query("INSERT INTO m_siswa_pendidikan(kd, kd_siswa, lulusan, tgl_sttb, no_sttb, lama) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_tamat_dari', '$i_tgl_ijazah', '$i_no_ijazah', '$i_lama_belajar')");

					//m_siswa_diterima
					mysql_query("INSERT INTO m_siswa_diterima(kd, kd_siswa, kelas, tgl) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_diterima_kelas', '$i_tgl_diterima')");

					//m_siswa_ayah
					mysql_query("INSERT INTO m_siswa_ayah(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
									"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp, hidup) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_ayah_nama', '$i_ayah_tmp_lahir', '$i_ayah_tgl_lahir', ".
									"'$i_ayah_agama', '$i_ayah_warga_negara', '$i_ayah_pendidikan', '$i_ayah_pekerjaan', ".
									"'$i_ayah_penghasilan', '$i_ayah_alamat', '$i_ayah_telp', '$i_ayah_hidup')");

					//m_siswa_ibu
					mysql_query("INSERT INTO m_siswa_ibu(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
									"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp, hidup) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_ibu_nama', '$i_ibu_tmp_lahir', '$i_ibu_tgl_lahir', ".
									"'$i_ibu_agama', '$i_ibu_warga_negara', '$i_ibu_pendidikan', '$i_ibu_pekerjaan', ".
									"'$i_ibu_penghasilan', '$i_ibu_alamat', '$i_ibu_telp', '$i_ibu_hidup')");

					//m_siswa_wali
					mysql_query("INSERT INTO m_siswa_wali(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
									"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_wali_nama', '$i_wali_tmp_lahir', '$i_wali_tgl_lahir', ".
									"'$i_wali_agama', '$i_wali_warga_negara', '$i_wali_pendidikan', '$i_wali_pekerjaan', ".
									"'$i_wali_penghasilan', '$i_wali_alamat', '$i_wali_telp')");

					//m_siswa_hobi
					mysql_query("INSERT INTO m_siswa_hobi(kd, kd_siswa, kesenian, olah_raga, lain_lain) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_gemar_seni', '$i_gemar_or', '$i_gemar_lain')");

					//m_siswa_prestasi
					mysql_query("INSERT INTO m_siswa_perkembangan(kd, kd_siswa, bea_siswa) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_bea_siswa')");
					}
				}


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex";
			chmod($path1,0777);
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "siswa.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "siswa.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&kompkd=$kompkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



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

Keahlian : ';
//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['program']);

echo '<strong>'.$keax_pro.'</strong>,


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
</table>';


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
<input name="keahkd" type="hidden" value="'.$keahkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
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
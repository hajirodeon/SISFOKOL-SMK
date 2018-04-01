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


//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require("inc/class/paging.php");
$tpl = LoadTpl("template/cp_depan.html");



nocache;

//nilai
$filenya = "index.php";
$filenya_ke = $sumber;
$judul = "Selamat Datang di $sek_nama";
$judulku = $judul;






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek simpan polling
if ($_POST['btnPOL'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$v_opsi = nosql($_POST['v_opsi']);

	//cek null
	if (empty($v_opsi))
		{
		//re-direct
		$pesan = "Opsi Polling Belum Ditentukan. Harap Diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}

	//jika blm isi polling...
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM cp_polling");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//if...
		if ($v_opsi == "nopsi1")
			{
			$nil_opsi1x = 1;
			}
		else if ($v_opsi == "nopsi2")
			{
			$nil_opsi2x = 1;
			}
		else if ($v_opsi == "nopsi3")
			{
			$nil_opsi3x = 1;
			}
		else if ($v_opsi == "nopsi4")
			{
			$nil_opsi4x = 1;
			}
		else if ($v_opsi == "nopsi5")
			{
			$nil_opsi5x = 1;
			}


		//nilai
		$nil_opsi1 = (nosql($rcc['nil_opsi1']))+$nil_opsi1x;
		$nil_opsi2 = (nosql($rcc['nil_opsi2']))+$nil_opsi2x;
		$nil_opsi3 = (nosql($rcc['nil_opsi3']))+$nil_opsi3x;
		$nil_opsi4 = (nosql($rcc['nil_opsi4']))+$nil_opsi4x;
		$nil_opsi5 = (nosql($rcc['nil_opsi5']))+$nil_opsi5x;


		//update
		mysql_query("UPDATE cp_polling SET nil_opsi1 = '$nil_opsi1', ".
						"nil_opsi2 = '$nil_opsi2', ".
						"nil_opsi3 = '$nil_opsi3', ".
						"nil_opsi4 = '$nil_opsi4', ".
						"nil_opsi5 = '$nil_opsi5'");
		}

	//re-direct
	xloc($filenya);
	exit();
	}




//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





if ($_POST['btnOK'])
	{
	//ambil nilai
	$tipe = nosql($_POST["tipe"]);
	$username = nosql($_POST["usernamex"]);
	$password = md5(nosql($_POST["passwordx"]));

	//cek null
	if ((empty($tipe)) OR (empty($username)) OR (empty($password)))
		{
		//diskonek
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//jika tp01 --> GURU ................................................................................
		if ($tipe == "tp01")
			{
			//query
			$q = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, m_guru.* ".
						"FROM m_pegawai, m_guru ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd1_session'] = nosql($row['mpkd']);
				$_SESSION['tipe_session'] = "GURU";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				$_SESSION['username1_session'] = $username;
				$_SESSION['pass1_session'] = $password;
				$_SESSION['guru_session'] = "GURU";
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admgr";


				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admgr/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................




		//jika tp02 --> SISWA ...............................................................................
		if ($tipe == "tp02")
			{
			//query
			$q = mysql_query("SELECT m_siswa.kd AS nkd, m_siswa.nis AS nnis, m_siswa.nama AS nnama ".
									"FROM m_siswa, siswa_kelas, m_keahlian, m_tapel ".
									"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
									"AND siswa_kelas.kd_keahlian = m_keahlian.kd ".
									"AND siswa_kelas.kd_tapel = m_tapel.kd ".
									"AND m_siswa.usernamex = '$username' ".
									"AND m_siswa.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);


			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd2_session'] = nosql($row['nkd']);
				$_SESSION['nis2_session'] = nosql($row['nnis']);
				$_SESSION['username2_session'] = $username;
				$_SESSION['pass2_session'] = $password;
				$_SESSION['siswa_session'] = "SISWA";
				$_SESSION['nm2_session'] = balikin($row['nnama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['kd1_session'] = nosql($row['nkd']);
				$_SESSION['tipe_session'] = "SISWA";
				$_SESSION['no1_session'] = nosql($row['nnis']);
				$_SESSION['nis1_session'] = nosql($row['nnis']);
				$_SESSION['nm1_session'] = balikin($row['nnama']);
				$_SESSION['username1_session'] = $username;
				$_SESSION['pass1_session'] = $password;
				$_SESSION['janiskd'] = "admsw";


				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admsw/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................






		//jika tp021 --> ortu ...............................................................................
		if ($tipe == "tp021")
			{
			//query
			$q = mysql_query("SELECT m_siswa.kd AS nkd, m_siswa.nis AS nnis, m_siswa.nama AS nnama ".
									"FROM m_siswa, siswa_kelas, m_keahlian, m_tapel ".
									"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
									"AND siswa_kelas.kd_keahlian = m_keahlian.kd ".
									"AND siswa_kelas.kd_tapel = m_tapel.kd ".
									"AND m_siswa.usernamex = '$username' ".
									"AND m_siswa.passwordx_ortu = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);


			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd21_session'] = nosql($row['nkd']);
				$_SESSION['nis21_session'] = nosql($row['nnis']);
				$_SESSION['username21_session'] = $username;
				$_SESSION['pass21_session'] = $password;
				$_SESSION['ortu_session'] = "ORANG TUA SISWA";
				$_SESSION['nm21_session'] = balikin($row['nnama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['kd1_session'] = nosql($row['nkd']);
				$_SESSION['tipe_session'] = "ORANG TUA SISWA";
				$_SESSION['no1_session'] = nosql($row['nnis']);
				$_SESSION['nis1_session'] = nosql($row['nnis']);
				$_SESSION['nm1_session'] = balikin($row['nnama']);
				$_SESSION['username1_session'] = $username;
				$_SESSION['pass1_session'] = $password;
				$_SESSION['janiskd'] = "admortu";


				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admortu/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................

		
		



		//jika tp03 --> WALI KELAS ..........................................................................
		if ($tipe == "tp03")
			{
			//query
			$q = mysql_query("SELECT m_walikelas.*, m_pegawai.*, m_pegawai.kd AS mpkd ".
						"FROM m_walikelas, m_pegawai ".
						"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd1_session'] = nosql($row['mpkd']);
				$_SESSION['tipe_session'] = "WALI KELAS";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
								
				$_SESSION['kd3_session'] = nosql($row['mpkd']);
				$_SESSION['nip3_session'] = nosql($row['nip']);
				$_SESSION['username3_session'] = $username;
				$_SESSION['pass3_session'] = $password;
				$_SESSION['wk_session'] = "WALI KELAS";
				$_SESSION['nm3_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admwk";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admwk/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp04 --> Kepala Sekolah ......................................................................
		if ($tipe == "tp04")
			{
			//query
			$q = mysql_query("SELECT admin_ks.*, m_pegawai.*, m_pegawai.kd AS akkd ".
						"FROM admin_ks, m_pegawai ".
						"WHERE admin_ks.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Kepala Sekolah";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd4_session'] = nosql($row['akkd']);
				$_SESSION['nip4_session'] = nosql($row['nip']);
				$_SESSION['username4_session'] = $username;
				$_SESSION['pass4_session'] = $password;
				$_SESSION['ks_session'] = "Kepala Sekolah";
				$_SESSION['nm4_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admks";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admks/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................







		//jika tp06 --> Administrator .......................................................................
		if ($tipe == "tp06")
			{
			//query
			$q = mysql_query("SELECT * FROM adminx ".
						"WHERE usernamex = '$username' ".
						"AND passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd6_session'] = nosql($row['kd']);
				$_SESSION['username6_session'] = $username;
				$_SESSION['pass6_session'] = $password;
				$_SESSION['adm_session'] = "Administrator";
				$_SESSION['hajirobe_session'] = $hajirobe;


				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "adm/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................






		//jika tp08 --> BENDAHARA ...........................................................................
		if ($tipe == "tp08")
			{
			//query
			$q = mysql_query("SELECT admin_bdh.*, m_pegawai.*, m_pegawai.kd AS apkd ".
						"FROM admin_bdh, m_pegawai ".
						"WHERE admin_bdh.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd1_session'] = nosql($row['apkd']);
				$_SESSION['tipe_session'] = "BENDAHARA";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd8_session'] = nosql($row['apkd']);
				$_SESSION['nip8_session'] = nosql($row['nip']);
				$_SESSION['username8_session'] = $username;
				$_SESSION['pass8_session'] = $password;
				$_SESSION['bdh_session'] = "BENDAHARA";
				$_SESSION['nm8_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admbdh";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admbdh/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp09 --> Perpustakaan ..........................................................................
		if ($tipe == "tp09")
			{
			//query
			$q = mysql_query("SELECT admin_pus.*, m_pegawai.*, m_pegawai.kd AS atkd ".
						"FROM admin_pus, m_pegawai ".
						"WHERE admin_pus.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['atkd']);
				$_SESSION['tipe_session'] = "Pustakawan";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd9_session'] = nosql($row['atkd']);
				$_SESSION['nip9_session'] = nosql($row['nip']);
				$_SESSION['username9_session'] = $username;
				$_SESSION['pass9_session'] = $password;
				$_SESSION['pus_session'] = "Pustakawan";
				$_SESSION['nm9_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admpus";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admpus/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp091 --> BK ..........................................................................
		if ($tipe == "tp091")
			{
			//query
			$q = mysql_query("SELECT admin_bk.*, m_pegawai.*, m_pegawai.kd AS atkd ".
						"FROM admin_bk, m_pegawai ".
						"WHERE admin_bk.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['atkd']);
				$_SESSION['tipe_session'] = "BK";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd91_session'] = nosql($row['atkd']);
				$_SESSION['nip91_session'] = nosql($row['nip']);
				$_SESSION['username91_session'] = $username;
				$_SESSION['pass91_session'] = $password;
				$_SESSION['bk_session'] = "BK";
				$_SESSION['nm91_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admbk";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admbk/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp010 --> waka ..........................................................................
		if ($tipe == "tp010")
			{
			//query
			$q = mysql_query("SELECT admin_waka.*, m_pegawai.*, m_pegawai.kd AS akkd ".
						"FROM admin_waka, m_pegawai ".
						"WHERE admin_waka.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Kurikulum";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd10_session'] = nosql($row['akkd']);
				$_SESSION['nip10_session'] = nosql($row['nip']);
				$_SESSION['username10_session'] = $username;
				$_SESSION['pass10_session'] = $password;
				$_SESSION['waka_session'] = "Kurikulum";
				$_SESSION['nm10_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admwaka";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admwaka/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................






		//jika tp011 --> pengarsip surat ..........................................................................
		if ($tipe == "tp011")
			{
			//query
			$q = mysql_query("SELECT admin_surat.*, m_pegawai.*, m_pegawai.kd AS akkd ".
						"FROM admin_surat, m_pegawai ".
						"WHERE admin_surat.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Pengarsip Surat";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd11_session'] = nosql($row['akkd']);
				$_SESSION['nip11_session'] = nosql($row['nip']);
				$_SESSION['username11_session'] = $username;
				$_SESSION['pass11_session'] = $password;
				$_SESSION['surat_session'] = "Pengarsip Surat";
				$_SESSION['nm11_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admsurat";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admsurat/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................






		//jika tp012 --> kesiswaan ..........................................................................
		if ($tipe == "tp012")
			{
			//query
			$q = mysql_query("SELECT admin_kesw.*, m_pegawai.*, m_pegawai.kd AS akkd ".
						"FROM admin_kesw, m_pegawai ".
						"WHERE admin_kesw.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Kesiswaan";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd12_session'] = nosql($row['akkd']);
				$_SESSION['nip12_session'] = nosql($row['nip']);
				$_SESSION['username12_session'] = $username;
				$_SESSION['pass12_session'] = $password;
				$_SESSION['kesw_session'] = "Kesiswaan";
				$_SESSION['nm12_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admkesw";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admkesw/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................






		//jika tp013 --> inventaris ..........................................................................
		if ($tipe == "tp013")
			{
			//query
			$q = mysql_query("SELECT admin_inv.*, m_pegawai.*, m_pegawai.kd AS akkd ".
						"FROM admin_inv, m_pegawai ".
						"WHERE admin_inv.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Inventaris";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd13_session'] = nosql($row['akkd']);
				$_SESSION['nip13_session'] = nosql($row['nip']);
				$_SESSION['username13_session'] = $username;
				$_SESSION['pass13_session'] = $password;
				$_SESSION['inv_session'] = "Inventaris";
				$_SESSION['nm13_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "adminv";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "adminv/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................






		//jika tp014 --> koordinator keahlian  ..........................................................................
		if ($tipe == "tp014")
			{
			//query
			$q = mysql_query("SELECT m_keahlian_kompetensi.*, m_pegawai.*, ".
						"m_pegawai.kd AS akkd ".
						"FROM m_keahlian_kompetensi, m_pegawai ".
						"WHERE m_keahlian_kompetensi.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Keahlian";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd14_session'] = nosql($row['akkd']);
				$_SESSION['nip14_session'] = nosql($row['nip']);
				$_SESSION['username14_session'] = $username;
				$_SESSION['pass14_session'] = $password;
				$_SESSION['lab_session'] = "Keahlian";
				$_SESSION['nm14_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admlab";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admlab/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp015 --> bkk ..........................................................................
		if ($tipe == "tp015")
			{
			//query
			$q = mysql_query("SELECT admin_bkk.*, m_pegawai.*, m_pegawai.kd AS akkd ".
						"FROM admin_bkk, m_pegawai ".
						"WHERE admin_bkk.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "BKK";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd15_session'] = nosql($row['akkd']);
				$_SESSION['nip15_session'] = nosql($row['nip']);
				$_SESSION['username15_session'] = $username;
				$_SESSION['pass15_session'] = $password;
				$_SESSION['bkk_session'] = "BKK";
				$_SESSION['nm15_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admbkk";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admbkk/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................






		//jika tp016 --> kepegawaian ..........................................................................
		if ($tipe == "tp016")
			{
			//query
			$q = mysql_query("SELECT admin_kepg.*, m_pegawai.*, m_pegawai.kd AS akkd ".
						"FROM admin_kepg, m_pegawai ".
						"WHERE admin_kepg.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Kepegawaian";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd16_session'] = nosql($row['akkd']);
				$_SESSION['nip16_session'] = nosql($row['nip']);
				$_SESSION['username16_session'] = $username;
				$_SESSION['pass16_session'] = $password;
				$_SESSION['kepg_session'] = "Kepegawaian";
				$_SESSION['nm16_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admkepg";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admkepg/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................






		//jika tp019 --> Q.M.R ..........................................................................
		if ($tipe == "tp019")
			{
			//query
			$q = mysql_query("SELECT admin_qmr.*, m_pegawai.*, m_pegawai.kd AS akkd ".
						"FROM admin_qmr, m_pegawai ".
						"WHERE admin_qmr.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.usernamex = '$username' ".
						"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Q.M.R";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd19_session'] = nosql($row['akkd']);
				$_SESSION['nip19_session'] = nosql($row['nip']);
				$_SESSION['username19_session'] = $username;
				$_SESSION['pass19_session'] = $password;
				$_SESSION['qmr_session'] = "Q.M.R";
				$_SESSION['nm19_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admqmr";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admqmr/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................

		
		
		
		//jika tp036 --> hubin ..........................................................................
		if ($tipe == "tp036")
			{
			//query
			$q = mysql_query("SELECT admin_hubin.*, m_pegawai.*, m_pegawai.kd AS akkd ".
									"FROM admin_hubin, m_pegawai ".
									"WHERE admin_hubin.kd_pegawai = m_pegawai.kd ".
									"AND m_pegawai.usernamex = '$username' ".
									"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Petugas HubIn";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd36_session'] = nosql($row['akkd']);
				$_SESSION['nip36_session'] = nosql($row['nip']);
				$_SESSION['username36_session'] = $username;
				$_SESSION['pass36_session'] = $password;
				$_SESSION['hubin_session'] = "Petugas HubIn";
				$_SESSION['nm36_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admhubin";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admhubin/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................

		
		
		
		//jika tp035 --> ekstra ..........................................................................
		if ($tipe == "tp035")
			{
			//query
			$q = mysql_query("SELECT m_ekstra.*, m_pegawai.*, m_pegawai.kd AS akkd ".
									"FROM m_ekstra, m_pegawai ".
									"WHERE m_ekstra.kd_pegawai = m_pegawai.kd ".
									"AND m_pegawai.usernamex = '$username' ".
									"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Pembina Ekstra";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd35_session'] = nosql($row['akkd']);
				$_SESSION['nip35_session'] = nosql($row['nip']);
				$_SESSION['username35_session'] = $username;
				$_SESSION['pass35_session'] = $password;
				$_SESSION['ekstra_session'] = "Pembina Ekstra";
				$_SESSION['nm35_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admekstra";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admekstra/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................

		
		
		
		
		//jika tp033 --> piket ..........................................................................
		if ($tipe == "tp033")
			{
			//query
			$q = mysql_query("SELECT admin_piket.*, m_pegawai.*, m_pegawai.kd AS akkd ".
									"FROM admin_piket, m_pegawai ".
									"WHERE admin_piket.kd_pegawai = m_pegawai.kd ".
									"AND m_pegawai.usernamex = '$username' ".
									"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Petugas Piket";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd33_session'] = nosql($row['akkd']);
				$_SESSION['nip33_session'] = nosql($row['nip']);
				$_SESSION['username33_session'] = $username;
				$_SESSION['pass33_session'] = $password;
				$_SESSION['piket_session'] = "Petugas Piket";
				$_SESSION['nm33_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admpiket";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admpiket/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................
				

				
				
						
		//jika tp030 --> keamanan ..........................................................................
		if ($tipe == "tp030")
			{
			//query
			$q = mysql_query("SELECT admin_security.*, m_pegawai.*, m_pegawai.kd AS akkd ".
									"FROM admin_security, m_pegawai ".
									"WHERE admin_security.kd_pegawai = m_pegawai.kd ".
									"AND m_pegawai.usernamex = '$username' ".
									"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Petugas Keamanan";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd30_session'] = nosql($row['akkd']);
				$_SESSION['nip30_session'] = nosql($row['nip']);
				$_SESSION['username30_session'] = $username;
				$_SESSION['pass30_session'] = $password;
				$_SESSION['security_session'] = "Petugas Keamanan";
				$_SESSION['nm30_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admsec";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admsec/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................

		
		
		
		
		
					
		//jika tp031 --> kebersihan ..........................................................................
		if ($tipe == "tp031")
			{
			//query
			$q = mysql_query("SELECT admin_kebersihan.*, m_pegawai.*, m_pegawai.kd AS akkd ".
									"FROM admin_kebersihan, m_pegawai ".
									"WHERE admin_kebersihan.kd_pegawai = m_pegawai.kd ".
									"AND m_pegawai.usernamex = '$username' ".
									"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Petugas Kebersihan";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd31_session'] = nosql($row['akkd']);
				$_SESSION['nip31_session'] = nosql($row['nip']);
				$_SESSION['username31_session'] = $username;
				$_SESSION['pass31_session'] = $password;
				$_SESSION['bersih_session'] = "Petugas Kebersihan";
				$_SESSION['nm31_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admbersih";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admbersih/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................
		

		
		
		
		
					
		//jika tp032 --> sms ..........................................................................
		if ($tipe == "tp032")
			{
			//query
			$q = mysql_query("SELECT admin_sms.*, m_pegawai.*, m_pegawai.kd AS akkd ".
									"FROM admin_sms, m_pegawai ".
									"WHERE admin_sms.kd_pegawai = m_pegawai.kd ".
									"AND m_pegawai.usernamex = '$username' ".
									"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Petugas SMS Akademik";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd32_session'] = nosql($row['akkd']);
				$_SESSION['nip32_session'] = nosql($row['nip']);
				$_SESSION['username32_session'] = $username;
				$_SESSION['pass32_session'] = $password;
				$_SESSION['sms_session'] = "Petugas SMS Akademik";
				$_SESSION['nm32_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admsms";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admsms/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................

		
		
					
												
		//jika tp037 --> entri nilai ..........................................................................
		if ($tipe == "tp037")
			{
			//query
			$q = mysql_query("SELECT admin_entri.*, m_pegawai.*, m_pegawai.kd AS akkd ".
									"FROM admin_entri, m_pegawai ".
									"WHERE admin_entri.kd_pegawai = m_pegawai.kd ".
									"AND m_pegawai.usernamex = '$username' ".
									"AND m_pegawai.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Petugas Entri Nilai";
				$_SESSION['no1_session'] = nosql($row['nip']);
				$_SESSION['nip1_session'] = nosql($row['nip']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd37_session'] = nosql($row['akkd']);
				$_SESSION['nip37_session'] = nosql($row['nip']);
				$_SESSION['username37_session'] = $username;
				$_SESSION['pass37_session'] = $password;
				$_SESSION['entri_session'] = "Petugas Entri Nilai";
				$_SESSION['nm37_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admentri";

				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admentri/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}

												
		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

require("inc/menu/cp_menu.php");

//isi
$isi_banner = ob_get_contents();
ob_end_clean();





echo '<form action="'.$filenya.'" method="post" name="formx">
<table border="0" width="1300" border="0" cellspacing="5" cellpadding="0">
<tr valign="top">
<td width="208">



<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>

<p>
<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::INFO SEKOLAH</b>
</font>
</td>
</tr>
</table>';



//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '6' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	&nbsp;
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>

</table>
</p>
<br>



<p>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::AGENDA</b>
</font>
</td>
</tr>
</table>';


//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '2' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>

</table>
</p>
<br>


<p>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::MAKALAH</b>
</font>
</td>
</tr>
</table>';



//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '3' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>
</table>
</p>
<br>





<p>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::MATERI AJAR</b>
</font>
</td>
</tr>
</table>';


//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '5' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	&nbsp;
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '
</td>
</tr>
</table>
</p>
<br>






<p>
<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::JEJAK PENDAPAT</b>
</font>
</td>
</tr>
</table>';



//polling ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qcc = mysql_query("SELECT * FROM cp_polling");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);
$cc_topik = balikin($rcc['topik']);
$cc_opsi1 = balikin($rcc['opsi1']);
$cc_opsi2 = balikin($rcc['opsi2']);
$cc_opsi3 = balikin($rcc['opsi3']);
$cc_opsi4 = balikin($rcc['opsi4']);
$cc_opsi5 = balikin($rcc['opsi5']);
$cc_nil_opsi1 = nosql($rcc['nil_opsi1']);
$cc_nil_opsi2 = nosql($rcc['nil_opsi2']);
$cc_nil_opsi3 = nosql($rcc['nil_opsi3']);
$cc_nil_opsi4 = nosql($rcc['nil_opsi4']);
$cc_nil_opsi5 = nosql($rcc['nil_opsi5']);
$cc_total = round($cc_nil_opsi1 + $cc_nil_opsi2 + $cc_nil_opsi3 + $cc_nil_opsi4 + $cc_nil_opsi5);

//jika nol
if ((empty($cc_nil_opsi1)) AND (empty($cc_nil_opsi2)) AND (empty($cc_nil_opsi3)) AND (empty($cc_nil_opsi4))
	AND (empty($cc_nil_opsi5)))
	{
	$cc_nil_opsi1 = 1;
	$cc_nil_opsi2 = 1;
	$cc_nil_opsi3 = 1;
	$cc_nil_opsi4 = 1;
	$cc_nil_opsi5 = 1;
	}



//jika ada
if ($tcc != 0)
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="200">
	<strong>'.$cc_topik.'</strong>
	<br>
	<br>

	<ul>

	<input name="v_opsi" type="radio" value="nopsi1">
	<strong>'.$cc_opsi1.'</strong>
	<br>
	<br>


	<input name="v_opsi" type="radio" value="nopsi2">
	<strong>'.$cc_opsi2.'</strong>
	<br>
	<br>


	<input name="v_opsi" type="radio" value="nopsi3">
	<strong>'.$cc_opsi3.'</strong>
	<br>
	<br>


	<input name="v_opsi" type="radio" value="nopsi4">
	<strong>'.$cc_opsi4.'</strong>
	<br>
	<br>


	<input name="v_opsi" type="radio" value="nopsi5">
	<strong>'.$cc_opsi5.'</strong>
	<br>
	<br>

	</ul>

	<input name="s" type="hidden" value="'.$s.'">
	<input name="gmkd" type="hidden" value="'.$gmkd.'">
	<input name="btnPOL" type="submit" value="Vote">
	[Total : <strong>'.$cc_total.'</strong> vote].
	</td>
	</tr>
	</table>';
	}

//tidak ada
else
	{
	echo '<font color="blue">
	<strong>
	Belum Ada Data Polling.
	</strong>
	</font>';
	}
//polling ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



echo '</td>
</tr>
</table>
</p>
<br>





<p>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::SISFOKOL</b>
</font>
</td>
</tr>
</table>

<p>
<img src="'.$sumber.'/img/support.png" width="24" height="24" border="0">
<br>
<select name="tipe">
<option value="" selected></option>
<option value="tp02">Siswa</option>
<option value="tp021">Orang Tua</option>
<option value="tp01">Guru</option>
<option value="tp035">Pembina Ekstra</option>
<option value="tp036">Petugas HubIn</option>
<option value="tp08">Bendahara</option>
<option value="tp09">Perpustakaan</option>
<option value="tp091">BP/BK</option>
<option value="tp03">Wali Kelas</option>
<option value="tp010">Kurikulum</option>
<option value="tp011">Pengarsip Surat</option>
<option value="tp012">Kesiswaan</option>
<option value="tp013">Inventaris</option>
<option value="tp014">Keahlian</option>
<option value="tp015">BKK</option>
<option value="tp016">Kepegawaian</option>
<option value="tp019">Q.M.R</option>
<option value="tp037">Petugas Entri Nilai</option>
<option value="tp030">Petugas Keamanan</option>
<option value="tp031">Petugas Kebersihan</option>
<option value="tp033">Petugas Piket</option>
<option value="tp032">Petugas SMS Akademik</option>
<option value="tp04">Kepala Sekolah</option>
<option value="tp06">Administrator</option>
</select>
<br>



Username :
<br>
<input name="usernamex" type="text" size="15" onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnOK.focus();
	document.formx.btnOK.submit();
	}">
<br>


Password :
<br>
<input name="passwordx" type="password" size="15" onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnOK.focus();
	document.formx.btnOK.submit();
	}">
<br>


<input name="btnBTL" type="submit" value="BATAL">
<input name="btnOK" type="submit" value="OK &gt;&gt;&gt;">
</p>




<p>
<a href="http://www.omahbiasawae.com/" target="_blank">OmahBIASAWAE.COM</a>
<br>
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FOmahbiasawae%2F570684559728799&amp;width&amp;layout=button&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=80&amp;appId=312487135596733" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px;" allowTransparency="true"></iframe>
</p>



</td>
</tr>
</table>
</p>
<br>



</td>

<td bgcolor="white" width="1000">

<table bgcolor="white" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td>
<p>';

//headline2
$qhea1 = mysql_query("SELECT cp_artikel.* ".
						"FROM cp_artikel, cp_m_posisi ".
						"WHERE cp_artikel.kd_posisi = cp_m_posisi.kd ".
						"AND cp_m_posisi.no = '1'");
$rhea1 = mysql_fetch_assoc($qhea1);
$rhea1_kd = nosql($rhea1['kd']);
$rhea1_judul = balikin($rhea1['judul']);
$rhea1_isi = balikin($rhea1['isi']);
$rhea1_postdate = $rhea1['postdate'];

//pecah titik - titik
$rhea1_isi2 = pathasli1($rhea1_isi);

//pecah
$rhea1_isi3 = substr($rhea1_isi2,0,300);


echo '<h1>
'.$rhea1_judul.'
</h1>
'.$rhea1_isi3.'. . .
<i>

[<a class="selengkapnya" href="halaman.php?kd='.$rhea1_kd.'">SELENGKAPNYA...</a>]
</i>
<hr>



</td>


<td width="206" valign="top">
<p>
<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="3">
<tr>
<td>

<table bgcolor="white" width="100%" border="1" cellspacing="0" cellpadding="5">
<tr bgcolor="blue" width="206" background="'.$sumber.'/img/bg_hijau.png">
<td>
<font color="white">
<b>.::GALERI FOTO</b>
</font>
</td>
</tr>
</table>';


//query
$limit = 5;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT cp_artikel.* ".
				"FROM cp_artikel, cp_m_kategori ".
				"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
				"AND cp_m_kategori.no = '7' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


if ($count != 0)
	{
	//view data
	echo '<table width="200" border="0" cellspacing="3" cellpadding="3">';


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
		$i_kd = nosql($data['kd']);
		$i_judul = balikin($data['judul']);
		$i_isi = balikin($data['isi']);
		$i_postdate = $data['postdate'];


		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='';\">";
		echo '<td>
		<a href="halaman.php?kd='.$i_kd.'">'.$i_judul.'</a>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}

echo '</td>
</tr>
</table>
</p>
<br>



</td>
</tr>
</table>



<hr>

<table width="100%" border="0" cellspacing="5" cellpadding="5">
<tr valign="top">
<td width="50%">
<p>';

//headline2
$qhea1 = mysql_query("SELECT cp_artikel.* ".
						"FROM cp_artikel, cp_m_posisi ".
						"WHERE cp_artikel.kd_posisi = cp_m_posisi.kd ".
						"AND cp_m_posisi.no = '2'");
$rhea1 = mysql_fetch_assoc($qhea1);
$rhea1_kd = nosql($rhea1['kd']);
$rhea1_judul = balikin($rhea1['judul']);
$rhea1_isi = balikin($rhea1['isi']);
$rhea1_postdate = $rhea1['postdate'];

//pecah titik - titik
$rhea1_isi2 = pathasli1($rhea1_isi);

//pecah
$rhea1_isi3 = substr($rhea1_isi2,0,300);


echo '<h1>
'.$rhea1_judul.'
</h1>
'.$rhea1_isi3.'. . .
<i>

[<a class="selengkapnya" href="halaman.php?kd='.$rhea1_kd.'">SELENGKAPNYA...</a>]
</i>
<hr>

</p>

<p>';

//headline3
$qhea1 = mysql_query("SELECT cp_artikel.* ".
						"FROM cp_artikel, cp_m_posisi ".
						"WHERE cp_artikel.kd_posisi = cp_m_posisi.kd ".
						"AND cp_m_posisi.no = '3'");
$rhea1 = mysql_fetch_assoc($qhea1);
$rhea1_kd = nosql($rhea1['kd']);
$rhea1_judul = balikin($rhea1['judul']);
$rhea1_isi = balikin($rhea1['isi']);
$rhea1_postdate = $rhea1['postdate'];

//pecah titik - titik
$rhea1_isi2 = pathasli1($rhea1_isi);

//pecah
$rhea1_isi3 = substr($rhea1_isi2,0,300);


echo '<h1>
'.$rhea1_judul.'
</h1>
'.$rhea1_isi3.'. . .

<i>

[<a class="selengkapnya" href="halaman.php?kd='.$rhea1_kd.'">SELENGKAPNYA...</a>]
</i>
<hr>

<hr>
</p>

<p>';

//headline4
$qhea1 = mysql_query("SELECT cp_artikel.* ".
						"FROM cp_artikel, cp_m_posisi ".
						"WHERE cp_artikel.kd_posisi = cp_m_posisi.kd ".
						"AND cp_m_posisi.no = '4'");
$rhea1 = mysql_fetch_assoc($qhea1);
$rhea1_kd = nosql($rhea1['kd']);
$rhea1_judul = balikin($rhea1['judul']);
$rhea1_isi = balikin($rhea1['isi']);
$rhea1_postdate = $rhea1['postdate'];

//pecah titik - titik
$rhea1_isi2 = pathasli1($rhea1_isi);

//pecah
$rhea1_isi3 = substr($rhea1_isi2,0,300);


echo '<h1>
'.$rhea1_judul.'
</h1>
'.$rhea1_isi3.'. . .

<i>
[<a class="selengkapnya" href="halaman.php?kd='.$rhea1_kd.'">SELENGKAPNYA...</a>]
</i>
<hr>

</p>

</td>
<td width="50%">
<p>';

//headline3
$qhea1 = mysql_query("SELECT cp_artikel.* ".
						"FROM cp_artikel, cp_m_posisi ".
						"WHERE cp_artikel.kd_posisi = cp_m_posisi.kd ".
						"AND cp_m_posisi.no = '5'");
$rhea1 = mysql_fetch_assoc($qhea1);
$rhea1_kd = nosql($rhea1['kd']);
$rhea1_judul = balikin($rhea1['judul']);
$rhea1_isi = balikin($rhea1['isi']);
$rhea1_postdate = $rhea1['postdate'];

//pecah titik - titik
$rhea1_isi2 = pathasli1($rhea1_isi);

//pecah
$rhea1_isi3 = substr($rhea1_isi2,0,300);


echo '<h1>
'.$rhea1_judul.'
</h1>
'.$rhea1_isi3.'. . .

<i>
[<a class="selengkapnya" href="halaman.php?kd='.$rhea1_kd.'">SELENGKAPNYA...</a>]
</i>
<hr>

<hr>
</p>


<p>';

//headline2
$qhea1 = mysql_query("SELECT cp_artikel.* ".
						"FROM cp_artikel, cp_m_posisi ".
						"WHERE cp_artikel.kd_posisi = cp_m_posisi.kd ".
						"AND cp_m_posisi.no = '6'");
$rhea1 = mysql_fetch_assoc($qhea1);
$rhea1_kd = nosql($rhea1['kd']);
$rhea1_judul = balikin($rhea1['judul']);
$rhea1_isi = balikin($rhea1['isi']);
$rhea1_postdate = $rhea1['postdate'];

//pecah titik - titik
$rhea1_isi2 = pathasli1($rhea1_isi);

//pecah
$rhea1_isi3 = substr($rhea1_isi2,0,300);


echo '<h1>
'.$rhea1_judul.'
</h1>
'.$rhea1_isi3.'. . .

<i>
[<a class="selengkapnya" href="halaman.php?kd='.$rhea1_kd.'">SELENGKAPNYA...</a>]
</i>
<hr>

</p>

<p>';

//headline3
$qhea1 = mysql_query("SELECT cp_artikel.* ".
						"FROM cp_artikel, cp_m_posisi ".
						"WHERE cp_artikel.kd_posisi = cp_m_posisi.kd ".
						"AND cp_m_posisi.no = '7'");
$rhea1 = mysql_fetch_assoc($qhea1);
$rhea1_kd = nosql($rhea1['kd']);
$rhea1_judul = balikin($rhea1['judul']);
$rhea1_isi = balikin($rhea1['isi']);
$rhea1_postdate = $rhea1['postdate'];

//pecah titik - titik
$rhea1_isi2 = pathasli1($rhea1_isi);

//pecah
$rhea1_isi3 = substr($rhea1_isi2,0,300);


echo '<h1>
'.$rhea1_judul.'
</h1>
'.$rhea1_isi3.'. . .

<i>
[<a class="selengkapnya" href="halaman.php?kd='.$rhea1_kd.'">SELENGKAPNYA...</a>]
</i>
<hr>

<hr>
</p>

</td>
</tr>

</table>



</td>

</tr>
</table>



</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>

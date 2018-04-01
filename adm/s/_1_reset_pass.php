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
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "reset_pass.php";
$diload = "document.formx.akses.focus();";
$judul = "Reset Password";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;
$tpkd = nosql($_REQUEST['tpkd']);
$tipe = cegah($_REQUEST['tipe']);







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnRST'])
	{
	$tpkd = nosql($_POST['tpkd']);
	$tipe = cegah($_POST['tipe']);
	$page = nosql($_POST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//nek siswa .........................................................................................................................
	if ($tpkd == "tp01")
		{
		$tapelkd = nosql($_POST['tapelkd']);
		$kelkd = nosql($_POST['kelkd']);
		$item = nosql($_POST['item']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&tapelkd=$tapelkd&kelkd=$kelkd&page=$page";

		//cek
		//nek blm dipilih
		if (empty($item))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Reset Password Gagal. Anda Belum Memilih Siswa.";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM m_siswa ".
									"WHERE kd = '$item'");
			$rsuk = mysql_fetch_assoc($qsuk);
			$suk_nis = nosql($rsuk['nis']);
			$suk_nm = balikin($rsuk['nama']);


			$passbaru1 = $passbaru;
			$passbarux = md5($passbaru1);
			$pesan = "NIS : $suk_nis, Nama : $suk_nm. Password Baru : $passbaru1";

			//reset password
			mysql_query("UPDATE m_siswa SET passwordx = '$passbarux', ".
							"postdate = '$today' ".
							"WHERE kd = '$item'");

			//re-direct
			pekem($pesan,$ke);
			exit();
			}
		}
	//...................................................................................................................................





	//nek pegawai .......................................................................................................................
	else if ($tpkd == "tp02")
		{
		$item = nosql($_POST['item']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($item))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Reset Password Gagal. Anda Belum Memilih Guru.";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM m_pegawai ".
									"WHERE kd = '$item'");
			$rsuk = mysql_fetch_assoc($qsuk);
			$suk_nip = nosql($rsuk['nip']);
			$suk_nm = balikin($rsuk['nama']);


			$passbaru1 = $passbaru;
			$passbarux = md5($passbaru1);
			$pesan = "NIP : $suk_nip, Nama : $suk_nm. Password Baru : $passbaru1";

			//reset password
			mysql_query("UPDATE m_pegawai SET passwordx = '$passbarux', ".
							"postdate = '$today' ".
							"WHERE kd = '$item'");

			//re-direct
			pekem($pesan,$ke);
			exit();
			}
		}





	//nek kepala sekolah ................................................................................................................
	else if ($tpkd == "tp03")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Kepala Sekolah...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_ks");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_ks SET kd = '$x', ".
								"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_ks (kd, kd_pegawai) VALUES ".
								"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}







	//nek bendahara .....................................................................................................................
	else if ($tpkd == "tp06")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas Bendahara...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_bdh");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_bdh SET kd = '$x', ".
								"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_bdh (kd, kd_pegawai) VALUES ".
								"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}





	//nek perpustakaan .....................................................................................................................
	else if ($tpkd == "tp09")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas Perpustakaan...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_pus");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_pus SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_pus (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}





	//nek BK .....................................................................................................................
	else if ($tpkd == "tp091")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas BK...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_bk");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_bk SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_bk (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}





	//nek wakil kurikulum .....................................................................................................................
	else if ($tpkd == "tp010")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Waka Kurikulum...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_waka");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_waka SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_waka (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}





	//nek pengarsip surat .....................................................................................................................
	else if ($tpkd == "tp011")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas Pengarsip Surat...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_surat");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_surat SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_surat (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}





	//nek kesiswaan .....................................................................................................................
	else if ($tpkd == "tp012")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Kesiswaan...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_kesw");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_kesw SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_kesw (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}




	//nek inventaris .....................................................................................................................
	else if ($tpkd == "tp013")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas Inventaris...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_inv");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_inv SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_inv (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}




	//nek pengelola lab. .....................................................................................................................
	else if ($tpkd == "tp014")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas Pengelola Lab...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_lab");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_lab SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_lab (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}





	//nek BKK .....................................................................................................................
	else if ($tpkd == "tp015")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas BKK...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_bkk");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_bkk SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_bkk (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}





	//nek kepegawaian .....................................................................................................................
	else if ($tpkd == "tp016")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas Kepegawaian...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_kepg");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_kepg SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_kepg (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}





	//nek q.m.r .....................................................................................................................
	else if ($tpkd == "tp017")
		{
		$pegawai = nosql($_POST['pegawai']);
		$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";

		//cek
		//nek null
		if (empty($pegawai))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Silahkan tentukan dahulu yang menjadi Petugas Q.M.R...";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			$qsuk = mysql_query("SELECT * FROM admin_qmr");
			$rsuk = mysql_fetch_assoc($qsuk);
			$tsuk = mysql_num_rows($qsuk);

			//jika ada
			if ($tsuk != 0)
				{
				//update
				mysql_query("UPDATE admin_qmr SET kd = '$x', ".
						"kd_pegawai = '$pegawai'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO admin_qmr (kd, kd_pegawai) VALUES ".
						"('$x', '$pegawai')");
				}

			//re-direct
			xloc($ke);
			exit();
			}
		}
	}
	//...................................................................................................................................
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//menu
require("../../inc/menu/adm.php");

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
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Akses : ';
echo "<select name=\"akses\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$filenya.'?tpkd='.$tpkd.'" selected>'.$tipe.'</option>
<option value="'.$filenya.'?tpkd=tp01&tipe=Siswa">Siswa</option>
<option value="'.$filenya.'?tpkd=tp027&tipe=Orang Tua">Orang Tua</option>
<option value="'.$filenya.'?tpkd=tp02&tipe=Pegawai">Pegawai</option>
<option value="'.$filenya.'?tpkd=tp03&tipe=Kepala Sekolah">Kepala Sekolah</option>
<option value="'.$filenya.'?tpkd=tp06&tipe=Bendahara">Bendahara</option>
<option value="'.$filenya.'?tpkd=tp09&tipe=Perpustakaan">Perpustakaan</option>
<option value="'.$filenya.'?tpkd=tp091&tipe=BK">BK</option>
<option value="'.$filenya.'?tpkd=tp010&tipe=Waka Kurikulum">Waka Kurikulum</option>
<option value="'.$filenya.'?tpkd=tp011&tipe=Pengarsip Surat">Pengarsip Surat</option>
<option value="'.$filenya.'?tpkd=tp012&tipe=Kesiswaan">Kesiswaan</option>
<option value="'.$filenya.'?tpkd=tp013&tipe=Inventaris">Inventaris</option>
<option value="'.$filenya.'?tpkd=tp015&tipe=BKK">BKK</option>
<option value="'.$filenya.'?tpkd=tp016&tipe=Kepegawaian">Kepegawaian</option>
<option value="'.$filenya.'?tpkd=tp017&tipe=Q.M.R">Q.M.R</option>
<option value="'.$filenya.'?tpkd=tp021&tipe=Petugas Keamanan">Petugas Keamanan</option>
<option value="'.$filenya.'?tpkd=tp022&tipe=Petugas HubIn">Petugas HubIn</option>
<option value="'.$filenya.'?tpkd=tp023&tipe=Petugas Kebersihan">Petugas Kebersihan</option>
<option value="'.$filenya.'?tpkd=tp024&tipe=Petugas Piket">Petugas Piket</option>
<option value="'.$filenya.'?tpkd=tp025&tipe=Pembina Ekstra">Pembina Ekstra</option>
<option value="'.$filenya.'?tpkd=tp026&tipe=Petugas SMS Akademik">Petugas SMS Akademik</option>
</select>
</td>
</tr>
</table>';

//nek siswa /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($tpkd == "tp01")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$kelkd = nosql($_REQUEST['kelkd']);
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}

	$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&tapelkd=$tapelkd&kelkd=$kelkd&page=$page";



	//focus...
	if (empty($tapelkd))
		{
		$diload = "document.formx.tapel.focus();";
		}
	else if (empty($kelkd))
		{
		$diload = "document.formx.kelas.focus();";
		}



	//view
	echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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
		$tp_kd = nosql($rowtp['kd']);
		$tp_thn1 = nosql($rowtp['tahun1']);
		$tp_thn2 = nosql($rowtp['tahun2']);

		echo '<option value="'.$filenya.'?tpkd='.$tpkd.'&tipe='.$tipe.'&tapelkd='.$tp_kd.'">'.$tp_thn1.'/'.$tp_thn2.'</option>';
		}
	while ($rowtp = mysql_fetch_assoc($qtp));

	echo '</select>,

	Kelas : ';
	echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

	//terpilih
	$qbtx = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$kelkd'");
	$rowbtx = mysql_fetch_assoc($qbtx);
	$btx_kd = nosql($rowbtx['kd']);
	$btx_kelas = nosql($rowbtx['kelas']);


	echo '<option value="'.$btx_kd.'">'.$btx_kelas.'</option>';

	$qbt = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd <> '$kelkd' ".
						"ORDER BY no ASC");
	$rowbt = mysql_fetch_assoc($qbt);

	do
		{
		$bt_kd = nosql($rowbt['kd']);
		$bt_kelas = nosql($rowbt['kelas']);

		echo '<option value="'.$filenya.'?tpkd='.$tpkd.'&tipe='.$tipe.'&tapelkd='.$tapelkd.'&kelkd='.$bt_kd.'">'.$bt_kelas.'</option>';
		}
	while ($rowbt = mysql_fetch_assoc($qbt));

	echo '</select>
	</td>
	</tr>
	</table>
	<br>';


	//nek blm dipilih
	if (empty($tapelkd))
		{
		echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
		}
	else if (empty($kelkd))
		{
		echo '<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>';
		}
	else
		{
		//data ne....
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"ORDER BY round(m_siswa.nis) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = $ke;
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);

		echo '<table width="500" border="1" cellpadding="3" cellspacing="0">
	    <tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="50" valign="top"><strong>NIS</strong></td>
		<td valign="top"><strong>Nama</strong></td>
		<td width="150" valign="top"><strong>Postdate</strong></td>
	    </tr>';

		if ($count != 0)
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

				$kd = nosql($data['mskd']);
				$kd_kelas = nosql($data['kd_kelas']);
				$nis = nosql($data['nis']);
				$nama = balikin($data['nama']);
				$postdate = $data['postdate'];

				//nek null
				if ($postdate == "0000-00-00 00:00:00")
					{
					$postdate = "-";
					}

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
				<input type="radio" name="item" value="'.$kd.'">
				</td>
				<td valign="top">
				'.$nis.'
				</td>
				<td valign="top">
				'.$nama.'
				</td>
				<td valign="top">
				'.$postdate.'
				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));
			}

		echo '</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
	    <tr>
		<td width="100">
		<input name="btnRST" type="submit" value="RESET">
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="tpkd" type="hidden" value="'.$tpkd.'">
		<input name="tipe" type="hidden" value="'.$tipe.'">
		<input name="page" type="hidden" value="'.$page.'">
		<input name="total" type="hidden" value="'.$count.'">
		</td>
		<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
	    </tr>
		</table>
		<br>
		<br>';
		}
	}





//nek pegawai ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp02")
	{
	//nilai
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}

	$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";


	//data ne....
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT *  FROM m_pegawai ".
					"ORDER BY round(nip) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = $ke;
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	echo '<br>
	<table width="500" border="1" cellpadding="3" cellspacing="0">
    <tr bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="100" valign="top"><strong>NIP</strong></td>
	<td valign="top"><strong>Nama</strong></td>
	<td width="150" valign="top"><strong>Postdate</strong></td>
    </tr>';

	if ($count != 0)
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

			//nilai
			$dt_kd = nosql($data['kd']);
			$dt_nip = nosql($data['nip']);
			$dt_nama = balikin($data['nama']);
			$dt_postdate = $data['postdate'];

			//nek null
			if ($dt_postdate == "0000-00-00 00:00:00")
				{
				$dt_postdate = "-";
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$dt_kd.'">
			<input type="radio" name="item" value="'.$dt_kd.'">
			</td>
			<td valign="top">
			'.$dt_nip.'
			</td>
			<td valign="top">
			'.$dt_nama.'
			</td>
			<td valign="top">
			'.$dt_postdate.'
			</td>
			</tr>';
	  		}
		while ($data = mysql_fetch_assoc($result));
		}

	echo '</table>
	<table width="500" border="0" cellspacing="0" cellpadding="3">
    <tr>
	<td width="100">
	<input name="btnRST" type="submit" value="RESET">
	<input name="jml" type="hidden" value="'.$limit.'">
	<input name="kd" type="hidden" value="'.$dt_kd.'">
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="total" type="hidden" value="'.$count.'">
	</td>
	<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
    </tr>
	</table>
	<br>
	<br>';
	}




//nek kepala sekolah ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp03")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_ks.* ".
							"FROM m_pegawai, admin_ks ".
							"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}








//nek bendahara /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp06")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_bdh.* ".
				"FROM m_pegawai, admin_bdh ".
				"WHERE admin_bdh.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}



//nek perpustakaan /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp09")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_pus.* ".
				"FROM m_pegawai, admin_pus ".
				"WHERE admin_pus.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}





//nek BK /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp091")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_bk.* ".
				"FROM m_pegawai, admin_bk ".
				"WHERE admin_bk.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}



//nek wakil kurikulum /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp010")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_waka.* ".
				"FROM m_pegawai, admin_waka ".
				"WHERE admin_waka.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}







//nek pengarsip surat /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp011")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_surat.* ".
				"FROM m_pegawai, admin_surat ".
				"WHERE admin_surat.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}





//nek kesiswaan /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp012")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_kesw.* ".
				"FROM m_pegawai, admin_kesw ".
				"WHERE admin_kesw.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}





//nek inventaris /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp013")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_inv.* ".
				"FROM m_pegawai, admin_inv ".
				"WHERE admin_inv.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}




//nek pengelola lab. /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp014")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_lab.* ".
				"FROM m_pegawai, admin_lab ".
				"WHERE admin_lab.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}






//nek bkk /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp015")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_bkk.* ".
				"FROM m_pegawai, admin_bkk ".
				"WHERE admin_bkk.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
							"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}





//nek kepegawaian /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp016")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_kepg.* ".
				"FROM m_pegawai, admin_kepg ".
				"WHERE admin_kepg.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
				"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}






//nek q.m.r /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($tpkd == "tp017")
	{
	//terpilih
	$qpgdx = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, admin_qmr.* ".
				"FROM m_pegawai, admin_qmr ".
				"WHERE admin_qmr.kd_pegawai = m_pegawai.kd");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$pgdx_kd = nosql($rpgdx['mpkd']);
	$pgdx_nip = nosql($rpgdx['nip']);
	$pgdx_nama = balikin2($rpgdx['nama']);


	//view
	echo '<p>
	Pegawai :
	<select name="pegawai">
	<option value="'.$pgdx_kd.'" selected>'.$pgdx_nip.'. '.$pgdx_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
				"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	<br>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="SIMPAN">
	</p>
	<br><br>';
	}





echo '</form>';
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

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
require("../../inc/cek/admsms.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "sms.php";
$judul = "SMS : Inbox/Outbox/SentItem";
$judulku = "[$sms_session : $nip32_session. $nm32_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$nohp = nosql($_REQUEST['nohp']);





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika kirim sms
if ($_POST['btnKRM'])
	{
	$s = nosql($_POST['s']);


	//jika kirim baru, sms tunggal
	if ($s == "baru")
		{
		$nohp = $_POST['nohp'];
		$nohpx = "+62$nohp";
		$isi_sms = $_POST['isi_sms'];

		//nek null
		if ((empty($nohp)) OR (empty($isi_sms)))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			$ke = "$filenya?s=baru";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//kirim sms, melalui service mysql khusus gammu
			mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
							"VALUES ('$nohpx', '$isi_sms', 'Gammu', 'biasawae', '0')");
	


			//re-direct
			$pesan = "Sekitar 5-15detik, SMS akan diterima oleh : $nohpx.";
			$ke = "$filenya?s=inbox";
			pekem($pesan,$ke);
			exit();
			}
		}


	//jika balas
	if ($s == "balas")
		{
		$nohp = $_POST['nohp'];
		$nohpx = "+$nohp";
		$isi_sms = $_POST['isi_sms'];

		//nek null
		if ((empty($nohp)) OR (empty($isi_sms)))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			$ke = "$filenya?s=balas&nohp=$nohp";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//kirim sms, melalui service mysql khusus gammu
			mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
							"VALUES ('$nohpx', '$isi_sms', 'Gammu', 'biasawae', '0')");


			//re-direct
			$pesan = "Sekitar 5-15detik, SMS akan diterima oleh : $nohpx.";
			$ke = "$filenya?s=inbox";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//jika hapus
if ($a == "hapus")
	{
	//nilai
	$kd = nosql($_REQUEST['kd']);

	//jika hapus inbox
	if ($s == "inbox")
		{
		mysql_query("DELETE FROM inbox WHERE ID = '$kd'");
		}


	//jika hapus outbox
	if ($s == "outbox")
		{
		mysql_query("DELETE FROM outbox WHERE ID = '$kd'");
		}


	//jika hapus sentitem
	if ($s == "sentitem")
		{
		mysql_query("DELETE FROM sentitems WHERE ID = '$kd'");
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//isi *START
ob_start();

//menu
require("../../inc/menu/admsms.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>

<a href="'.$filenya.'?s=baru">Tulis Baru SMS Tunggal</a>.
<br>';


//jika tulis sms baru
if ($s == "baru")
	{
	echo '<big>
	<strong>Silahkan isi Form Berikut, untuk Kirim SMS :</strong>
	</big>
	<br>

	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	No.HP Tujuan :
	<br>
	+62<INPUT type="text" name="nohp" value="" size="20">
	</p>
	<p>
	Isi SMS :
	<br>
	<textarea name="isi_sms" cols="50" rows="2" wrap="virtual"></textarea>
	</p>

	<p>
	<input name="s" type="hidden" value="baru">
	<input name="btnKRM" type="submit" value="KIRIM">
	<input name="btnBTL" type="reset" value="BATAL">
	</p>
	</form>';
	}




//jika balas
if ($s == "balas")
	{
	echo '<big>
	<strong>Silahkan isi Form Berikut, untuk Membalas SMS ke NoHP : </strong>
	</big>
	<br>

	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	No.HP Tujuan :
	<br>
	+'.$nohp.'
	</p>
	<p>
	Isi SMS :
	<br>
	<textarea name="isi_sms" cols="50" rows="2" wrap="virtual"></textarea>
	</p>

	<p>
	<INPUT type="hidden" name="nohp" value="'.$nohp.'">
	<INPUT type="hidden" name="s" value="balas">
	<input name="btnKRM" type="submit" value="KIRIM">
	<input name="btnBTL" type="reset" value="BATAL">
	</p>
	</form>';
	}


//jika daftar sms/inbox
if ($s == "inbox")
	{
	//daftar inbox
	$qc1 = mysql_query("SELECT * FROM inbox ".
				"ORDER BY ReceivingDateTime DESC");
	$rc1 = mysql_fetch_assoc($qc1);
	$tc1 = mysql_num_rows($qc1);


	echo '<big>
	<strong>Inbox/Daftar SMS yang masuk :</strong>
	</big>
	<br>

	<script>setTimeout("location.href=\'sms.php?s=inbox\'", 10000);</script>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Waktu</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Dari</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Isi SMS</font></strong></td>
	<td width="100">&nbsp;</td>
	</tr>';

	if ($tc1 != 0)
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

			$i_kd = $rc1['ID'];
			$i_waktu = $rc1['ReceivingDateTime'];
			$i_pengirim = $rc1['SenderNumber'];
			$i_sms = $rc1['TextDecoded'];
			$i_Processed = $rc1['Processed'];
			$i_nohpx = substr($i_pengirim,3,20);





			//jika masih false, berarti perlu reply
			if ($i_Processed == "false")
				{
				// membaca pesan SMS dan mengubahnya menjadi kapital
				$i_msg = strtoupper($i_sms);

				// proses parsing
				// memecah pesan berdasarkan karakter #
				$pecah = explode("#", $i_msg);



				//registrasi nohp.[admin]/////////////////////////////////////////////////////////////////////////////
				//format SMS : REG#ADMIN#USER#PASSWORD
				//ambil deretan sms
				$j_reg = $pecah[0];
				$j_admin = $pecah[1];
				$j_user = $pecah[2];
				$j_pass = $pecah[3];


				//jika adminyang kirim sms
				if (($j_reg == "REG") AND ($j_admin == "ADMIN"))
					{
					//cek
					$qcc = mysql_query("SELECT * FROM adminx ".
								"WHERE usernamex = '$j_user' ".
								"AND passwordx = '$j_pass'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);


					//jika ada, update nohp.
					if ($tcc != 0)
						{
						mysql_query("UPDATE adminx SET nohp = '$i_nohpx'");

						//isi sms
						$isi_sms = "Selamat, Anda Telah Berhasil Registrasi Sebagai ADMIN.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					else
						{
						//isi sms
						$isi_sms = "Maaf, Registrasi Terjadi Kegagalan. Harap Diperhatikan...!!.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					}






				//registrasi nohp.[siswa]/////////////////////////////////////////////////////////////////////////////
				//format SMS : REG#SISWA#NIS#NAMA
				//ambil deretan sms
				$j_reg = $pecah[0];
				$j_siswa = $pecah[1];
				$j_nis = $pecah[2];
				$j_nama = $pecah[3];


				//jika siswa yang kirim sms
				if (($j_reg == "REG") AND ($j_siswa == "SISWA"))
					{
					//cek
					$qcc = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, sms_nohp_siswa.* ".
								"FROM m_siswa, sms_nohp_siswa ".
								"WHERE sms_nohp_siswa.kd_siswa = m_siswa.kd ".
								"AND m_siswa.nis = '$j_nis' ".
								"AND m_siswa.nama = '$j_nama'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);
					$cc_swkd = nosql($rcc['mskd']);


					//jika ada, update nohp.
					if ($tcc != 0)
						{
						mysql_query("UPDATE sms_nohp_siswa SET nohp = '$i_nohpx' ".
								"WHERE kd_siswa = '$cc_swkd'");

						//isi sms
						$isi_sms = "Selamat, Anda Telah Berhasil Registrasi.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					else
						{
						//isi sms
						$isi_sms = "Maaf, Registrasi Terjadi Kegagalan. Harap Diperhatikan...!!.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					}




				//registrasi nohp.[ortu]/////////////////////////////////////////////////////////////////////////////
				//format SMS : REG#ORTU#NIS#NAMA
				//ambil deretan sms
				$j_reg = $pecah[0];
				$j_ortu = $pecah[1];
				$j_nis = $pecah[2];
				$j_nama = $pecah[3];


				//jika ortu yang kirim sms
				if (($j_reg == "REG") AND ($j_ortu == "ORTU"))
					{
					//cek
					$qcc = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, sms_nohp_siswa.* ".
								"FROM m_siswa, sms_nohp_siswa ".
								"WHERE sms_nohp_siswa.kd_siswa = m_siswa.kd ".
								"AND m_siswa.nis = '$j_nis' ".
								"AND m_siswa.nama = '$j_nama'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);
					$cc_swkd = nosql($rcc['mskd']);


					//jika ada, update nohp.
					if ($tcc != 0)
						{
						mysql_query("UPDATE sms_nohp_siswa SET nohp2 = '$i_nohpx' ".
								"WHERE kd_siswa = '$cc_swkd'");

						//isi sms
						$isi_sms = "Selamat, Anda Telah Berhasil Registrasi.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					else
						{
						//isi sms
						$isi_sms = "Maaf, Registrasi Terjadi Kegagalan. Harap Diperhatikan...!!.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");

						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					}




				//registrasi nohp.[pegawai]/////////////////////////////////////////////////////////////////////////////
				//format SMS : REG#PEGAWAI#NIP#NAMA
				//ambil deretan sms
				$j_reg = $pecah[0];
				$j_pegawai = $pecah[1];
				$j_nip = $pecah[2];
				$j_nama = $pecah[3];


				//jika pegawai yang kirim sms
				if (($j_reg == "REG") AND ($j_pegawai == "PEGAWAI"))
					{
					//cek
					$qcc = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, sms_nohp_pegawai.* ".
								"FROM m_pegawai, sms_nohp_pegawai ".
								"WHERE sms_nohp_pegawai.kd_pegawai = m_pegawai.kd ".
								"AND m_pegawai.nip = '$j_nip' ".
								"AND m_pegawai.nama = '$j_nama'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);
					$cc_swkd = nosql($rcc['mpkd']);


					//jika ada, update nohp.
					if ($tcc != 0)
						{
						mysql_query("UPDATE sms_nohp_pegawai SET nohp = '$i_nohpx' ".
								"WHERE kd_pegawai = '$cc_swkd'");

						//isi sms
						$isi_sms = "Selamat, Anda Telah Berhasil Registrasi.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					else
						{
						//isi sms
						$isi_sms = "Maaf, Registrasi Terjadi Kegagalan. Harap Diperhatikan...!!.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");

						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					}





				//siswa cari tahu spp-nya /////////////////////////////////////////////////////////////////////////////
				//format SMS : SPP#SISWA#NIS#BULAN#TAHUN
					//dimana BULAN : 01, 02, . . . 12

				//ambil deretan sms
				$j_spp = $pecah[0];
				$j_siswa = $pecah[1];
				$j_nis = $pecah[2];
				$j_bulan = $pecah[3];
				$j_tahun = $pecah[4];


				//jika siswa yang kirim sms
				if (($j_spp == "SPP") AND ($j_siswa == "SISWA"))
					{
					//cek
					$qcc = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, sms_nohp_siswa.* ".
								"FROM m_siswa, sms_nohp_siswa ".
								"WHERE sms_nohp_siswa.kd_siswa = m_siswa.kd ".
								"AND m_siswa.nis = '$j_nis'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);
					$cc_swkd = nosql($rcc['mskd']);


					//ketahui uang spp-nya
					$qdtu = mysql_query("SELECT * FROM siswa_uang_spp ".
								"WHERE kd_siswa = '$cc_swkd' ".
								"AND bln = '$j_bulan' ".
								"AND thn = '$j_tahun'");
					$rdtu = mysql_fetch_assoc($qdtu);
					$dtu_status = nosql($rdtu['lunas']);

					//jika lunas
					if ($dtu_status == "true")
						{
						$dtu_statusx = "SPP Bulan $j_bulan/$j_tahun, Sudah Lunas.";
						}
					else
						{
						$dtu_statusx = "SPP Bulan $j_bulan/$j_tahun, BELUM LUNAS/BELUM DIBAYAR.";
						}



					// membuat SMS balasan
					mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}





				//siswa cari nilai-nya /////////////////////////////////////////////////////////////////////////////
				//format SMS :
					//NILAI#NIS#SEMESTER#TAPEL
					//dimana SEMESTER : 1, 2.

				//ambil deretan sms
				$j_nilai = $pecah[0];
				$j_nilnya = $pecah[1];
				$j_nis = $pecah[2];
				$j_smt = $pecah[3];
				$j_tapel = $pecah[4];


				//jika siswa yang kirim sms
				if ($j_nilai == "NILAI")
					{
					//tapel
					// proses parsing
					// memecah /
					$j_pecah = explode("/", $j_tapel);
					$j_tahun1 = $j_pecah[0];
					$j_tahun2 = $j_pecah[1];
					$qtpx = mysql_query("SELECT * FROM m_tapel ".
								"WHERE tahun1 = '$j_tahun1' ".
								"AND tahun2 = '$j_tahun2'");
					$rowtpx = mysql_fetch_assoc($qtpx);
					$j_tapelkd = nosql($rowtpx['kd']);


					//ketahui siswanya
					$qdd = mysql_query("SELECT m_siswa.kd, m_siswa.nis, siswa_kelas.kd_siswa, ".
								"siswa_kelas.kd_tapel, siswa_kelas.kd AS skkd ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND m_siswa.nis = '$j_nis' ".
								"AND siswa_kelas.kd_tapel = '$j_tapelkd'");
					$rdd = mysql_fetch_assoc($qdd);
					$dd_skkd = nosql($rdd['skkd']);


					//smt
					$qsmtx = mysql_query("SELECT * FROM m_smt ".
								"WHERE smt = '$j_smt'");
					$rowsmtx = mysql_fetch_assoc($qsmtx);
					$j_smtkd = nosql($rowsmtx['kd']);



					//ketahui nilainya
					$qxpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, siswa_nilai_prog_pddkn.* ".
								"FROM m_prog_pddkn, siswa_nilai_prog_pddkn ".
								"WHERE siswa_nilai_prog_pddkn.kd_siswa_kelas = '$dd_skkd' ".
								"AND siswa_nilai_prog_pddkn.kd_smt = '$j_smtkd' ".
								"AND siswa_nilai_prog_pddkn.kd_prog_pddkn = m_prog_pddkn.kd");
					$rxpel = mysql_fetch_assoc($qxpel);
					$txpel = mysql_num_rows($qxpel);


					do
						{
						$xpel_mpkd = nosql($rxpel['mpkd']);
						$xpel_xpel = nosql($rxpel['xpel']);
						$xpel_nh = nosql($rxpel['nh']);
						$xpel_uas = nosql($rxpel['uas']);
						$xpel_praktek = nosql($rxpel['praktek']);
						$xpel_sikap = nosql($rxpel['sikap']);

						//rata - rata NH
						$qsni = mysql_query("SELECT AVG(nilai) AS rata ".
									"FROM siswa_nh_rata ".
									"WHERE kd_siswa_kelas = '$dd_skkd' ".
									"AND kd_smt = '$j_smtkd' ".
									"AND kd_prog_pddkn = '$xpel_mpkd'");
						$rsni = mysql_fetch_assoc($qsni);
						$tsni = mysql_num_rows($qsni);
						$sni_rata = round(nosql($rsni['rata']));

						//jika null
						if (empty($sni_rata))
							{
							$sni_rata = $xpel_nh;
							}


						//total
						$xpel_total = round($sni_rata + $xpel_uas);

						//require rumus
						require("../../inc/rumus_kognitif.php");


						$isi_sms = "[$xpel_xpel]. Rata2 NH : $sni_rata, UAS : $xpel_uas, ".
								"Total Nilai : $xpel_total, Total Rata2 : $xpel_rata, ".
								"Nilai Praktek : $xpel_praktek, Nilai Sikap : $xpel_sikap";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");
						}
					while ($rxpel = mysql_fetch_assoc($qxpel));



					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}





				//siswa cari tahu absensi-nya /////////////////////////////////////////////////////////////////////////////
				//format SMS : ABSENSI#SISWA#NIS#BULAN#TAHUN
					//dimana BULAN : 01, 02, . . . 12

				//ambil deretan sms
				$j_abs = $pecah[0];
				$j_siswa = $pecah[1];
				$j_nis = $pecah[2];
				$j_bulan = $pecah[3];
				$j_tahun = $pecah[4];


				//jika siswa yang kirim sms
				if (($j_abs == "ABSENSI") AND ($j_siswa == "SISWA"))
					{
					//cek
					$qcc = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, sms_nohp_siswa.* ".
								"FROM m_siswa, sms_nohp_siswa ".
								"WHERE sms_nohp_siswa.kd_siswa = m_siswa.kd ".
								"AND m_siswa.nis = '$j_nis'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);
					$cc_swkd = nosql($rcc['mskd']);


					//siswa kelas
					$qsike = mysql_query("SELECT * FROM siswa_kelas ".
								"WHERE kd_siswa = '$cc_swkd'");
					$rsike = mysql_fetch_assoc($qsike);
					$sike_kd = nosql($rsike['kd']);


					//nilai data, sakit
					$qdtf = mysql_query("SELECT siswa_absensi.*, m_absensi.* ".
								"FROM siswa_absensi, m_absensi ".
								"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
								"AND siswa_absensi.kd_siswa_kelas = '$sike_kd' ".
								"AND m_absensi.absensi2 = 'S' ".
								"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$j_bulan' ".
								"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$j_tahun'");
					$rdtf = mysql_fetch_assoc($qdtf);
					$tdtf = mysql_num_rows($qdtf);

					//nilai data, alpha
					$qdtf2 = mysql_query("SELECT siswa_absensi.*, m_absensi.* ".
								"FROM siswa_absensi, m_absensi ".
								"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
								"AND siswa_absensi.kd_siswa_kelas = '$sike_kd' ".
								"AND m_absensi.absensi2 = 'A' ".
								"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$j_bulan' ".
								"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$j_tahun'");
					$rdtf2 = mysql_fetch_assoc($qdtf2);
					$tdtf2 = mysql_num_rows($qdtf2);

					//nilai data, ijin
					$qdtf3 = mysql_query("SELECT siswa_absensi.*, m_absensi.* ".
								"FROM siswa_absensi, m_absensi ".
								"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
								"AND siswa_absensi.kd_siswa_kelas = '$sike_kd' ".
								"AND m_absensi.absensi2 = 'I' ".
								"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$j_bulan' ".
								"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$j_tahun'");
					$rdtf3 = mysql_fetch_assoc($qdtf3);
					$tdtf3 = mysql_num_rows($qdtf3);

					$isi_sms = "Jumlah Absensi, S:$tdtf, I:$tdtf3, A:$tdtf2 .";

					// membuat SMS balasan
					mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}



				//admin yang mau reset password /////////////////////////////////////////////////////////////////////////////
				//format SMS : RESET#ADMIN#USER#PASSWORD
				//ambil deretan sms
				$j_reset = $pecah[0];
				$j_admin = $pecah[1];
				$j_user = $pecah[2];
				$j_pass = $pecah[3];


				//jika adminyang kirim sms
				if (($j_reset == "RESET") AND ($j_admin == "ADMIN"))
					{
					//cek
					$qcc = mysql_query("SELECT * FROM adminx ".
								"WHERE usernamex = '$j_user' ".
								"AND passwordx = '$j_pass'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);


					//jika ada,
					if ($tcc != 0)
						{
						//berikan password baru
						$pass_barux = md5($pass_baru);

						//update
						mysql_query("UPDATE adminx SET passwordx = '$pass_barux'");

						//isi sms
						$isi_sms = "Anda Telah Berhasil Melakukan Reset Password ADMIN. Dengan Password Baru : $pass_baru";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					else
						{
						//isi sms
						$isi_sms = "Maaf, Registrasi Terjadi Kegagalan. Harap Diperhatikan...!!.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					}



				//saatnya menagih SPP, yang belum bayar /////////////////////////////////
				//jika tanggal 10, tiap bulan.
				if ($tanggal == "10")
					{
					//ketahui kondisi keuangan siswa, bulan ini, tahun ini
					$qswp = mysql_query("SELECT m_siswa.kd AS swkd, siswa_uang_spp.kd_siswa, ".
								"siswa_uang_spp.tgl_bayar, siswa_uang_spp.lunas ".
								"FROM m_siswa, siswa_uang_spp ".
								"WHERE siswa_uang_spp.kd_siswa = m_siswa.kd ".
								"AND lunas = 'false' ".
								"AND DATE_FORMAT(tgl_bayar, '%m') = '$bulan' ".
								"AND DATE_FORMAT(tgl_bayar, '%Y') = '$tahun'");
					$rswp = mysql_fetch_assoc($qswp);
					$tswp = mysql_num_rows($qswp);

					do
						{
						//nilai
						$swp_swkd = nosql($rswp['swkd']);

						//cek punya no.hp
						$qcc = mysql_query("SELECT * FROM sms_nohp_siswa ".
									"WHERE kd_siswa = '$swp_swkd'");
						$rcc = mysql_fetch_assoc($qcc);
						$tcc = mysql_num_rows($qcc);
						$cc_nohp = nosql($rcc['nohp']);
						$cc_nohp2 = nosql($rcc['nohp2']);



						//isi sms
						$isi_sms = "Untuk Bulan ini, SPP Belum Lunas. Harap Dipehatikan. Terima Kasih.";

						// membuat SMS massal
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$cc_nohp', '$isi_sms', 'Gammu', 'biasawae', '0')");

						// membuat SMS massal
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
								"VALUES ('$cc_nohp2', '$isi_sms', 'Gammu', 'biasawae', '0')");

						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					while ($rswp = mysql_fetch_assoc($qswp));
					}






				//jika ada siswa, bolos alpha kemarin, saatnya kirim sms sekarang  /////////////////////////////////
				$tanggalx = $tanggal - 1;

				//nilai data
				$qdtf = mysql_query("SELECT m_siswa.kd, siswa_kelas.kd, siswa_kelas.kd_siswa AS swkd, ".
							"siswa_absensi.kd, siswa_absensi.tgl, m_absensi.kd, ".
							"m_absensi.absensi2 AS absensi, ".
							"FROM siswa_kelas, siswa_absensi, m_absensi ".
							"WHERE siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
							"AND siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_absensi.kd_absensi = m_absensi.kd ".
							"AND round(DATE_FORMAT(siswa_absensi.tgl, '%d')) = '$tanggalx' ".
							"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$bulan' ".
							"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$tahun'");
				$rdtf = mysql_fetch_assoc($qdtf);


				//jika alpha
				if ($dtf_abs == "A")
					{
					do
						{
						//nilai
						$dtf_swkd = nosql($rdtf['swkd']);
						$dtf_abs = nosql($rdtf['absensi']);

						//cek punya no.hp
						$qcc = mysql_query("SELECT * FROM sms_nohp_siswa ".
									"WHERE kd_siswa = '$dtf_swkd'");
						$rcc = mysql_fetch_assoc($qcc);
						$tcc = mysql_num_rows($qcc);
						$cc_nohp = nosql($rcc['nohp']);
						$cc_nohp2 = nosql($rcc['nohp2']);



						//isi sms
						$isi_sms = "Maaf, Anak Anda Kemarin Tidak Masuk Sekolah atau Alpa. Harap Dipehatikan. Terima Kasih.";

						// membuat SMS massal
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$cc_nohp', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					while ($rswp = mysql_fetch_assoc($qswp));
					}





				//saran dan kritik/////////////////////////////////////////////////////////////////////////////
				//format SMS : SARAN#NAMA#ALAMAT
				//ambil deretan sms
				$j_saran = $pecah[0];
				$j_nama = $pecah[1];
				$j_alamat = $pecah[2];


				//jika ada saran
				if ($j_saran == "SARAN")
					{
					//isi sms
					$isi_sms = "Terima Kasih atas Saran dan Kritiknya.";

					// membuat SMS balasan
					mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
								"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}







				//cari tahu jadwal/////////////////////////////////////////////////////////////////////////////
				//format SMS : JADWAL#TAPEL#SMT#KELAS#RUANG#HARI#JAM
				//ambil deretan sms
				$j_jadwal = $pecah[0];
				$j_tapel = $pecah[1];
				$j_smt = $pecah[2];
				$j_kelas = $pecah[3];
				$j_ruang = $pecah[5];
				$j_hari = $pecah[6];
				$j_jam = $pecah[7];


				//jika ada request jadwal
				if ($j_jadwal == "JADWAL")
					{
					//tapel
					// proses parsing
					// memecah /
					$j_pecah = explode("/", $j_tapel);
					$j_tahun1 = $j_pecah[0];
					$j_tahun2 = $j_pecah[1];
					$qtpx = mysql_query("SELECT * FROM m_tapel ".
								"WHERE tahun1 = '$j_tahun1' ".
								"AND tahun2 = '$j_tahun2'");
					$rowtpx = mysql_fetch_assoc($qtpx);
					$j_tapelkd = nosql($rowtpx['kd']);


					//smt
					$qsmtx = mysql_query("SELECT * FROM m_smt ".
								"WHERE smt = '$j_smt'");
					$rowsmtx = mysql_fetch_assoc($qsmtx);
					$j_smtkd = nosql($rowsmtx['kd']);



					//kelas
					$qbtx = mysql_query("SELECT * FROM m_kelas ".
								"WHERE kelas = '$j_kelas'");
					$rowbtx = mysql_fetch_assoc($qbtx);
					$j_kelkd = nosql($rowbtx['kd']);


					//hari
					$qhri = mysql_query("SELECT * FROM m_hari ".
								"WHERE hari = '$j_hari'");
					$rhri = mysql_fetch_assoc($qhri);
					$j_hrikd = nosql($rhri['kd']);


					//jam
					$qjm = mysql_query("SELECT * FROM m_jam ".
								"WHERE jam = '$j_jam'");
					$rjm = mysql_fetch_assoc($qjm);
					$j_jmkd = nosql($rjm['kd']);



					//datane...
					$qdte = mysql_query("SELECT jadwal.*, jadwal.kd AS jdkd, m_guru.*, ".
								"m_pegawai.*, m_prog_pddkn.*, m_guru_prog_pddkn.* ".
								"FROM jadwal, m_guru, m_pegawai, m_prog_pddkn, m_guru_prog_pddkn ".
								"WHERE jadwal.kd_guru_prog_pddkn = m_guru_prog_pddkn.kd ".
								"AND m_guru_prog_pddkn.kd_prog_pddkn = m_prog_pddkn.kd ".
								"AND m_guru_prog_pddkn.kd_guru = m_guru.kd ".
								"AND m_guru.kd_pegawai = m_pegawai.kd ".
								"AND jadwal.kd_tapel = '$j_tapelkd' ".
								"AND jadwal.kd_smt = '$j_smtkd' ".
								"AND jadwal.kd_kelas = '$j_kelkd' ".
								"AND jadwal.kd_jam = '$j_jmkd' ".
								"AND jadwal.kd_hari = '$j_hrikd'");
					$rdte = mysql_fetch_assoc($qdte);
					$tdte = mysql_num_rows($qdte);
					$dte_nip = nosql($rdte['nip']);
					$dte_nm = balikin($rdte['nama']);
					$dte_pel = balikin($rdte['prog_pddkn']);


					//isi sms
					$isi_sms = "Pada Jadwal ini, Mata Pelajaran : $dte_pel, dengan Guru : $dte_nip.$dte_nama .";

					// membuat SMS balasan
					mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
								"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}





				//yang ultah/////////////////////////////////////////////////////////////////////////////
				//format SMS :
						//ULTAH#SISWA#BULAN .
						//ULTAH#PEGAWAI#BULAN .
						//dimana BULAN : 01, 02, . . . 12.
				//ambil deretan sms
				$j_ultah = $pecah[0];
				$j_nama = $pecah[1];
				$j_bulan = $pecah[2];


				//jika ultah
				if (($j_ultah == "ULTAH") AND ($j_nama == "SISWA"))
					{
					// Some data
					$nilaiku=array();

					//data siswa
					$qdt = mysql_query("SELECT nis, nama, tgl_lahir FROM m_siswa ".
								"WHERE DATE_FORMAT(tgl_lahir, '%m') = '$j_bulan' ".
								"ORDER BY round(nis) ASC");
					$rdt = mysql_fetch_assoc($qdt);

					do
						{
						$dt_nis = nosql($rdt['nis']);
						$dt_nama = balikin($rdt['nama']);
						$dt_ku = "$dt_nis.$dt_nama";

						//penanda
						array_unshift($nilaiku, $dt_ku);
						}
					while ($rdt = mysql_fetch_assoc($qdt));


					//isi sms
					$isi_sms = "Siswa Yang Ulang Tahun Pada Bulan : $j_bulan, adalah : $nilaiku. ";

					// membuat SMS balasan
					mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
								"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}


				//jika ultah pegawai
				if (($j_ultah == "ULTAH") AND ($j_nama == "PEGAWAI"))
					{
					// Some data
					$nilaiku=array();

					//data siswa
					$qdt = mysql_query("SELECT nip, nama, tgl_lahir FROM m_pegawai ".
								"WHERE DATE_FORMAT(tgl_lahir, '%m') = '$j_bulan' ".
								"ORDER BY round(nip) ASC");
					$rdt = mysql_fetch_assoc($qdt);

					do
						{
						$dt_nip = nosql($rdt['nip']);
						$dt_nama = balikin($rdt['nama']);
						$dt_ku = "$dt_nip.$dt_nama";

						//penanda
						array_unshift($nilaiku, $dt_ku);
						}
					while ($rdt = mysql_fetch_assoc($qdt));


					//isi sms
					$isi_sms = "Pegawai Yang Ulang Tahun Pada Bulan : $j_bulan, adalah : $nilaiku. ";

					// membuat SMS balasan
					mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
								"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}





				//jika admin kendali sms massal /////////////////////////////////////////////////////////////////////////////
				//format SMS :
					//*sms#massal#guru#besok gajian
					//*sms#massal#siswa#besok libur

				//ambil deretan sms
				$j_sms = $pecah[0];
				$j_massal = $pecah[1];
				$j_user = $pecah[2];
				$j_info = $pecah[3];


				//jika kirim sms massal guru/pegawai
				if (($j_sms == "SMS") AND ($j_massal == "MASSAL") AND ($j_user == "GURU"))
					{
					//cek
					$qccx = mysql_query("SELECT * FROM adminx ".
								"WHERE nohp = '$i_nohpx'");
					$rccx = mysql_fetch_assoc($qccx);
					$tccx = mysql_num_rows($qccx);

					//jika iya, berarti admin
					if ($tccx != 0)
						{
						//total
						$qdata = mysql_query("SELECT m_pegawai.* ".
									"FROM m_pegawai ".
									"ORDER BY round(nip) ASC");
						$rdata = mysql_fetch_assoc($qdata);
						$tdata = mysql_num_rows($qdata);

						do
							{
							$nomer = $nomer + 1;
							$xyz = md5("$x$nomer");
							$data_swkd = nosql($rdata['kd']);
							$data_swnis = nosql($rdata['nip']);


							//cek punya no.hp
							$qcc = mysql_query("SELECT * FROM sms_nohp_pegawai ".
										"WHERE kd_pegawai = '$data_swkd'");
							$rcc = mysql_fetch_assoc($qcc);
							$tcc = mysql_num_rows($qcc);
							$cc_nohp = nosql($rcc['nohp']);



							//isi sms
							$isi_sms = $j_info;

							// membuat SMS massal
							mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$cc_nohp', '$isi_sms', 'Gammu', 'biasawae', '0')");


							// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
							mysql_query("UPDATE inbox SET Processed = 'true' ".
									"WHERE ID = '$i_kd'");
							}
						while ($rdata = mysql_fetch_assoc($qdata));


						//laporan reply
						$isi_sms = "SMS Massal untuk para GURU/Pegawai, Telah Berhasil Dikirimkan.";

						// reply
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");

						}
					else
						{
						//isi sms
						$isi_sms = "Maaf, Anda Bukanlah Seorang ADMIN.";

						// membuat SMS massal
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					}



				//polling sms/////////////////////////////////////////////////////////////////////////////
				//format SMS : POLLING#KODE#NAMA#ALAMAT
				//ambil deretan sms
				$j_pol = $pecah[0];
				$j_kode = $pecah[1];
				$j_nama = $pecah[2];
				$j_alamat = $pecah[3];


				//jika orang yang kirim sms
				if ($j_pol == "POLLING")
					{
						/*
					//cek
					$qcc = mysql_query("SELECT sms_poll.*, sms_poll.kd AS pkd, ".
								"sms_poll_opsi.*, sms_poll_opsi.kd AS okd, ".
								"sms_poll_opsi.nilai AS nilai ".
								"FROM sms_poll.*, sms_poll_opsi ".
								"WHERE sms_poll_opsi.kd_poll = sms_poll.kd ".
								"AND sms_poll_opsi.kode = '$j_kode' ".
								"ORDER BY sms_poll.postdate DESC");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);
					$cc_pkd = nosql($rcc['pkd']);
					$cc_okd = nosql($rcc['okd']);
					$cc_nilai = nosql($rcc['nilai']);
					$cc_nilaix = $cc_nilai + 1;
*/

					//cek
					$qcc = mysql_query("SELECT sms_poll_opsi.*, sms_poll_opsi.kd AS okd, ".
											"sms_poll_opsi.nilai AS nilai ".
											"FROM sms_poll_opsi ".
											"WHERE kode = '$j_kode'");
					$rcc = mysql_fetch_assoc($qcc);
					$tcc = mysql_num_rows($qcc);
//					$cc_pkd = nosql($rcc['pkd']);
					$cc_okd = nosql($rcc['okd']);
					$cc_nilai = nosql($rcc['nilai']);
					$cc_nilaix = $cc_nilai + 1;


					//jika ada
					if ($tcc != 0)
						{
						mysql_query("UPDATE sms_poll_opsi SET nilai = '$cc_nilaix' ".
								"WHERE kd = '$cc_okd'");

						//isi sms
						$isi_sms = "Terima Kasih, Anda Telah Turut Berpartisipasi.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					else
						{
						//isi sms
						$isi_sms = "Maaf, Terjadi Kesalahan dalam Memberikan Polling.Harap Diperhatikan...!!.";


						// membuat SMS balasan
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");

						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					}



				//jika kirim sms massal siswa
				if (($j_sms == "SMS") AND ($j_massal == "MASSAL") AND ($j_user == "GURU"))
					{
					//cek
					$qccx = mysql_query("SELECT * FROM adminx ".
								"WHERE nohp = '$i_nohpx'");
					$rccx = mysql_fetch_assoc($qccx);
					$tccx = mysql_num_rows($qccx);

					//jika iya, berarti admin
					if ($tccx != 0)
						{
						//total
						$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
									"FROM m_siswa, siswa_kelas ".
									"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
									"ORDER BY round(m_siswa.nis) ASC");
						$rdata = mysql_fetch_assoc($qdata);
						$tdata = mysql_num_rows($qdata);

						do
							{
							$nomer = $nomer + 1;
							$xyz = md5("$x$nomer");
							$data_swkd = nosql($rdata['mskd']);
							$data_swnis = nosql($rdata['msnis']);


							//cek punya no.hp
							$qcc = mysql_query("SELECT * FROM sms_nohp_siswa ".
										"WHERE kd_siswa = '$data_swkd'");
							$rcc = mysql_fetch_assoc($qcc);
							$tcc = mysql_num_rows($qcc);
							$cc_nohp = nosql($rcc['nohp']);



							//isi sms
							$isi_sms = $j_info;

							// membuat SMS massal
							mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
										"VALUES ('$cc_nohp', '$isi_sms', 'Gammu', 'biasawae', '0')");


							// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
							mysql_query("UPDATE inbox SET Processed = 'true' ".
									"WHERE ID = '$i_kd'");
							}
						while ($rdata = mysql_fetch_assoc($qdata));



						//laporan reply
						$isi_sms = "SMS Massal untuk para GURU/Pegawai, Telah Berhasil Dikirimkan.";

						// reply
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");

						}
					else
						{
						//isi sms
						$isi_sms = "Maaf, Anda Bukanlah Seorang ADMIN.";

						// membuat SMS massal
						mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID, SenderID, Class) ".
									"VALUES ('$i_pengirim', '$isi_sms', 'Gammu', 'biasawae', '0')");


						// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
						mysql_query("UPDATE inbox SET Processed = 'true' ".
								"WHERE ID = '$i_kd'");
						}
					}

				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_waktu.'</td>
			<td>
			'.$i_pengirim.'
			<br>
			['.$dtx_nis.'. '.$dtx_nama.']
			</td>
			<td>'.$i_sms.'</td>
			<td>
			[<a href="'.$filenya.'?s=balas&nohp='.$i_pengirim.'">BALAS</a>].
			[<a href="'.$filenya.'?s=inbox&a=hapus&kd='.$i_kd.'">HAPUS</a>].
			</td>
			</tr>';
			}
		while ($rc1 = mysql_fetch_assoc($qc1));
		}


	echo '</table>';
	}





//jika outbox
if ($s == "outbox")
	{
	//daftar outbox
	$qc1 = mysql_query("SELECT * FROM outbox ".
				"ORDER BY SendingDateTime DESC");
	$rc1 = mysql_fetch_assoc($qc1);
	$tc1 = mysql_num_rows($qc1);


	echo '<big>
	<strong>Outbox/Daftar SMS yang sedang proses pengiriman :</strong>
	</big>
	<br>

	<script>setTimeout("location.href=\'sms.php?s=outbox\'", 10000);</script>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Waktu</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Kepada</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Isi SMS</font></strong></td>
	<td width="100">&nbsp;</td>
	</tr>';

	if ($tc1 != 0)
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

			$i_kd = $rc1['ID'];
			$i_waktu = $rc1['SendingDateTime'];
			$i_kepada = $rc1['DestinationNumber'];
			$i_sms = $rc1['TextDecoded'];
//			$i_nohpx = substr($i_kepada,3,20);
			$i_nohpx = $i_kepada;



			//ketahui nohp siswa
			$qdtx = mysql_query("SELECT m_siswa.*, sms_nohp_siswa.* ".
						"FROM m_siswa, sms_nohp_siswa ".
						"WHERE sms_nohp_siswa.kd_siswa = m_siswa.kd ".
						"AND sms_nohp_siswa.nohp = '$i_nohpx'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$tdtx = mysql_num_rows($qdtx);
			$dtx_nis = nosql($rdtx['nis']);
			$dtx_nama = balikin($rdtx['nama']);


			//ketahui nohp pegawai
			$qdtx2 = mysql_query("SELECT m_pegawai.*, sms_nohp_pegawai.* ".
						"FROM m_pegawai, sms_nohp_pegawai ".
						"WHERE sms_nohp_pegawai.kd_pegawai = m_pegawai.kd ".
						"AND sms_nohp_pegawai.nohp = '$i_nohpx'");
			$rdtx2 = mysql_fetch_assoc($qdtx2);
			$tdtx2 = mysql_num_rows($qdtx2);
			$dtx2_nip = nosql($rdtx2['nip']);
			$dtx2_nama = balikin($rdtx2['nama']);



			//cek
			//jika siswa
			if (!empty($tdtx))
				{
				$dt_ku = "SISWA:$dtx_nis.$dtx_nama";
				}
			//pegawai
			else if (!empty($tdtx2))
				{
				$dt_ku = "PEGAWAI:$dtx2_nip.$dtx2_nama";
				}



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_waktu.'</td>
			<td>
			'.$i_kepada.'
			<br>
			['.$dt_ku.'].
			</td>
			<td>'.$i_sms.'</td>
			<td>
			[<a href="'.$filenya.'?s=outbox&a=hapus&kd='.$i_kd.'">HAPUS</a>].
			</td>
			</tr>';
			}
		while ($rc1 = mysql_fetch_assoc($qc1));
		}


	echo '</table>';
	}




//jika sentitem
if ($s == "sentitem")
	{
	//daftar
	$qc1 = mysql_query("SELECT * FROM sentitems ".
				"ORDER BY SendingDateTime DESC");
	$rc1 = mysql_fetch_assoc($qc1);
	$tc1 = mysql_num_rows($qc1);


	echo '<big>
	<strong>SentItem/Daftar SMS yang telah terkirim :</strong>
	</big>
	<br>

	<script>setTimeout("location.href=\'sms.php?s=sentitem\'", 10000);</script>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Waktu</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Kepada</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Isi SMS</font></strong></td>
	<td width="100">&nbsp;</td>
	</tr>';

	if ($tc1 != 0)
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

			$i_kd = $rc1['ID'];
			$i_waktu = $rc1['SendingDateTime'];
			$i_kepada = $rc1['DestinationNumber'];
			$i_sms = $rc1['TextDecoded'];
//			$i_nohpx = substr($i_kepada,3,20);
			$i_nohpx = $i_kepada;



			//ketahui nohp siswa
			$qdtx = mysql_query("SELECT m_siswa.*, sms_nohp_siswa.* ".
						"FROM m_siswa, sms_nohp_siswa ".
						"WHERE sms_nohp_siswa.kd_siswa = m_siswa.kd ".
						"AND sms_nohp_siswa.nohp = '$i_nohpx'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$tdtx = mysql_num_rows($qdtx);
			$dtx_nis = nosql($rdtx['nis']);
			$dtx_nama = balikin($rdtx['nama']);


			//ketahui nohp pegawai
			$qdtx2 = mysql_query("SELECT m_pegawai.*, sms_nohp_pegawai.* ".
						"FROM m_pegawai, sms_nohp_pegawai ".
						"WHERE sms_nohp_pegawai.kd_pegawai = m_pegawai.kd ".
						"AND sms_nohp_pegawai.nohp = '$i_nohpx'");
			$rdtx2 = mysql_fetch_assoc($qdtx2);
			$tdtx2 = mysql_num_rows($qdtx2);
			$dtx2_nip = nosql($rdtx2['nip']);
			$dtx2_nama = balikin($rdtx2['nama']);



			//cek
			//jika siswa
			if (!empty($tdtx))
				{
				$dt_ku = "SISWA:$dtx_nis.$dtx_nama";
				}
			//pegawai
			else if (!empty($tdtx2))
				{
				$dt_ku = "PEGAWAI:$dtx2_nip.$dtx2_nama";
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_waktu.'</td>
			<td>
			'.$i_kepada.'
			<br>
			['.$dt_ku.'].
			</td>
			<td>'.$i_sms.'</td>
			<td>
			[<a href="'.$filenya.'?s=sentitem&a=hapus&kd='.$i_kd.'">HAPUS</a>].
			</td>
			</tr>';
			}
		while ($rc1 = mysql_fetch_assoc($qc1));
		}


	echo '</table>';
	}

echo '</p>
</form>';
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
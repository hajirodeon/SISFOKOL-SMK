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



///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd31_session = nosql($_SESSION['kd31_session']);
$nip31_session = nosql($_SESSION['nip31_session']);
$username31_session = nosql($_SESSION['username31_session']);
$bersih_session = nosql($_SESSION['bersih_session']);
$nm31_session = balikin2($_SESSION['nm31_session']);
$pass31_session = nosql($_SESSION['pass31_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_kebersihan.kd ".
						"FROM admin_kebersihan, m_pegawai ".
						"WHERE admin_kebersihan.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.kd = '$kd31_session' ".
						"AND m_pegawai.usernamex = '$username31_session' ".
						"AND m_pegawai.passwordx = '$pass31_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd31_session))
	OR (empty($username31_session))
	OR (empty($pass31_session))
	OR (empty($bersih_session))
	OR (empty($nip31_session))
	OR (empty($nm31_session))
	OR (empty($hajirobe_session)))
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan, $sumber);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
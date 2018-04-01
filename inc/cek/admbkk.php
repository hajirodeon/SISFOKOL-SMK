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
$kd15_session = nosql($_SESSION['kd15_session']);
$nip15_session = nosql($_SESSION['nip15_session']);
$nm15_session = balikin2($_SESSION['nm15_session']);
$username15_session = nosql($_SESSION['username15_session']);
$bkk_session = nosql($_SESSION['bkk_session']);
$pass15_session = nosql($_SESSION['pass15_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admbkk";



$qbw = mysql_query("SELECT admin_bkk.kd ".
			"FROM admin_bkk, m_pegawai ".
			"WHERE admin_bkk.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd15_session' ".
			"AND m_pegawai.usernamex = '$username15_session' ".
			"AND m_pegawai.passwordx = '$pass15_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd15_session))
	OR (empty($username15_session))
	OR (empty($pass15_session))
	OR (empty($bkk_session))
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
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
$kd10_session = nosql($_SESSION['kd10_session']);
$nip10_session = nosql($_SESSION['nip10_session']);
$nm10_session = balikin2($_SESSION['nm10_session']);
$username10_session = nosql($_SESSION['username10_session']);
$waka_session = nosql($_SESSION['waka_session']);
$pass10_session = nosql($_SESSION['pass10_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admwaka";


$qbw = mysql_query("SELECT admin_waka.kd ".
			"FROM admin_waka, m_pegawai ".
			"WHERE admin_waka.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd10_session' ".
			"AND m_pegawai.usernamex = '$username10_session' ".
			"AND m_pegawai.passwordx = '$pass10_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd10_session))
	OR (empty($username10_session))
	OR (empty($pass10_session))
	OR (empty($waka_session))
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
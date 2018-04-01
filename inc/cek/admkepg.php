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
$kd16_session = nosql($_SESSION['kd16_session']);
$nip16_session = nosql($_SESSION['nip16_session']);
$nm16_session = balikin2($_SESSION['nm16_session']);
$username16_session = nosql($_SESSION['username16_session']);
$kepg_session = nosql($_SESSION['kepg_session']);
$pass16_session = nosql($_SESSION['pass16_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admkepg";



$qbw = mysql_query("SELECT admin_kepg.kd ".
			"FROM admin_kepg, m_pegawai ".
			"WHERE admin_kepg.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd16_session' ".
			"AND m_pegawai.usernamex = '$username16_session' ".
			"AND m_pegawai.passwordx = '$pass16_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd16_session))
	OR (empty($username16_session))
	OR (empty($pass16_session))
	OR (empty($kepg_session))
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
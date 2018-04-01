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
$kd12_session = nosql($_SESSION['kd12_session']);
$nip12_session = nosql($_SESSION['nip12_session']);
$nm12_session = balikin2($_SESSION['nm12_session']);
$username12_session = nosql($_SESSION['username12_session']);
$kesw_session = nosql($_SESSION['kesw_session']);
$pass12_session = nosql($_SESSION['pass12_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admkesw";



$qbw = mysql_query("SELECT admin_kesw.kd ".
			"FROM admin_kesw, m_pegawai ".
			"WHERE admin_kesw.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd12_session' ".
			"AND m_pegawai.usernamex = '$username12_session' ".
			"AND m_pegawai.passwordx = '$pass12_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd12_session))
	OR (empty($username12_session))
	OR (empty($pass12_session))
	OR (empty($kesw_session))
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
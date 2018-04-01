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
$kd36_session = nosql($_SESSION['kd36_session']);
$nip36_session = nosql($_SESSION['nip36_session']);
$username36_session = nosql($_SESSION['username36_session']);
$hubin_session = nosql($_SESSION['hubin_session']);
$nm36_session = balikin2($_SESSION['nm36_session']);
$pass36_session = nosql($_SESSION['pass36_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_hubin.kd ".
						"FROM admin_hubin, m_pegawai ".
						"WHERE admin_hubin.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.kd = '$kd36_session' ".
						"AND m_pegawai.usernamex = '$username36_session' ".
						"AND m_pegawai.passwordx = '$pass36_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd36_session))
	OR (empty($username36_session))
	OR (empty($pass36_session))
	OR (empty($hubin_session))
	OR (empty($nip36_session))
	OR (empty($nm36_session))
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
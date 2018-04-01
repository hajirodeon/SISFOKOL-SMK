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
$kd30_session = nosql($_SESSION['kd30_session']);
$nip30_session = nosql($_SESSION['nip30_session']);
$username30_session = nosql($_SESSION['username30_session']);
$security_session = nosql($_SESSION['security_session']);
$nm30_session = balikin2($_SESSION['nm30_session']);
$pass30_session = nosql($_SESSION['pass30_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_security.kd ".
						"FROM admin_security, m_pegawai ".
						"WHERE admin_security.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.kd = '$kd30_session' ".
						"AND m_pegawai.usernamex = '$username30_session' ".
						"AND m_pegawai.passwordx = '$pass30_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd30_session))
	OR (empty($username30_session))
	OR (empty($pass30_session))
	OR (empty($security_session))
	OR (empty($nip30_session))
	OR (empty($nm30_session))
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
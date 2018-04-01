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
$kd4_session = nosql($_SESSION['kd4_session']);
$nip4_session = nosql($_SESSION['nip4_session']);
$username4_session = nosql($_SESSION['username4_session']);
$ks_session = nosql($_SESSION['ks_session']);
$nm4_session = balikin2($_SESSION['nm4_session']);
$pass4_session = nosql($_SESSION['pass4_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admks";


$qbw = mysql_query("SELECT admin_ks.kd ".
			"FROM admin_ks, m_pegawai ".
			"WHERE admin_ks.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd4_session' ".
			"AND m_pegawai.usernamex = '$username4_session' ".
			"AND m_pegawai.passwordx = '$pass4_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd4_session))
	OR (empty($username4_session))
	OR (empty($pass4_session))
	OR (empty($ks_session))
	OR (empty($nip4_session))
	OR (empty($nm4_session))
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
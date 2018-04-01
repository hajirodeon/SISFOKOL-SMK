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
$kd20_session = nosql($_SESSION['kd20_session']);
$nip20_session = nosql($_SESSION['nip20_session']);
$username20_session = nosql($_SESSION['username20_session']);
$bersih_session = nosql($_SESSION['bersih_session']);
$nm20_session = balikin2($_SESSION['nm20_session']);
$pass20_session = nosql($_SESSION['pass20_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_kebersihan.kd ".
			"FROM admin_kebersihan, m_pegawai ".
			"WHERE admin_kebersihan.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd20_session' ".
			"AND m_pegawai.usernamex = '$username20_session' ".
			"AND m_pegawai.passwordx = '$pass20_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd20_session))
	OR (empty($username20_session))
	OR (empty($pass20_session))
	OR (empty($bersih_session))
	OR (empty($nip20_session))
	OR (empty($nm20_session))
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
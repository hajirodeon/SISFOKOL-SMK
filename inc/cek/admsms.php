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
$kd32_session = nosql($_SESSION['kd32_session']);
$nip32_session = nosql($_SESSION['nip32_session']);
$username32_session = nosql($_SESSION['username32_session']);
$sms_session = nosql($_SESSION['sms_session']);
$nm32_session = balikin2($_SESSION['nm32_session']);
$pass32_session = nosql($_SESSION['pass32_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_sms.kd ".
						"FROM admin_sms, m_pegawai ".
						"WHERE admin_sms.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.kd = '$kd32_session' ".
						"AND m_pegawai.usernamex = '$username32_session' ".
						"AND m_pegawai.passwordx = '$pass32_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd32_session))
	OR (empty($username32_session))
	OR (empty($pass32_session))
	OR (empty($sms_session))
	OR (empty($nip32_session))
	OR (empty($nm32_session))
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
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
$kd8_session = nosql($_SESSION['kd8_session']);
$xkd8_session = nosql($_SESSION['xkd8_session']);
$nip8_session = nosql($_SESSION['nip8_session']);
$nm8_session = balikin2($_SESSION['nm8_session']);
$username8_session = nosql($_SESSION['username8_session']);
$bdh_session = nosql($_SESSION['bdh_session']);
$pass8_session = nosql($_SESSION['pass8_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admbdh";


$qbw = mysql_query("SELECT admin_bdh.kd ".
			"FROM admin_bdh, m_pegawai ".
			"WHERE admin_bdh.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd8_session' ".
			"AND m_pegawai.usernamex = '$username8_session' ".
			"AND m_pegawai.passwordx = '$pass8_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd8_session))
	OR (empty($username8_session))
	OR (empty($pass8_session))
	OR (empty($bdh_session))
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
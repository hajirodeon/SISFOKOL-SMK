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
$kd91_session = nosql($_SESSION['kd91_session']);
$nip91_session = nosql($_SESSION['nip91_session']);
$nm91_session = balikin2($_SESSION['nm91_session']);
$username91_session = nosql($_SESSION['username91_session']);
$bk_session = nosql($_SESSION['bk_session']);
$pass91_session = nosql($_SESSION['pass91_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admbk";


$qbw = mysql_query("SELECT admin_bk.kd ".
			"FROM admin_bk, m_pegawai ".
			"WHERE admin_bk.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd91_session' ".
			"AND m_pegawai.usernamex = '$username91_session' ".
			"AND m_pegawai.passwordx = '$pass91_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd91_session))
	OR (empty($username91_session))
	OR (empty($pass91_session))
	OR (empty($bk_session))
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
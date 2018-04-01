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
$kd13_session = nosql($_SESSION['kd13_session']);
$nip13_session = nosql($_SESSION['nip13_session']);
$nm13_session = balikin2($_SESSION['nm13_session']);
$username13_session = nosql($_SESSION['username13_session']);
$inv_session = nosql($_SESSION['inv_session']);
$pass13_session = nosql($_SESSION['pass13_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "adminv";



$qbw = mysql_query("SELECT admin_inv.kd ".
			"FROM admin_inv, m_pegawai ".
			"WHERE admin_inv.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd13_session' ".
			"AND m_pegawai.usernamex = '$username13_session' ".
			"AND m_pegawai.passwordx = '$pass13_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd13_session))
	OR (empty($username13_session))
	OR (empty($pass13_session))
	OR (empty($inv_session))
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
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
$kd19_session = nosql($_SESSION['kd19_session']);
$nip19_session = nosql($_SESSION['nip19_session']);
$username19_session = nosql($_SESSION['username19_session']);
$qmr_session = nosql($_SESSION['qmr_session']);
$nm19_session = balikin2($_SESSION['nm19_session']);
$pass19_session = nosql($_SESSION['pass19_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admqmr";


$qbw = mysql_query("SELECT admin_qmr.kd ".
			"FROM admin_qmr, m_pegawai ".
			"WHERE admin_qmr.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd19_session' ".
			"AND m_pegawai.usernamex = '$username19_session' ".
			"AND m_pegawai.passwordx = '$pass19_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd19_session))
	OR (empty($username19_session))
	OR (empty($pass19_session))
	OR (empty($qmr_session))
	OR (empty($nip19_session))
	OR (empty($nm19_session))
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
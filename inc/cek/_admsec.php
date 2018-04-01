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
$kd17_session = nosql($_SESSION['kd17_session']);
$nip17_session = nosql($_SESSION['nip17_session']);
$username17_session = nosql($_SESSION['username17_session']);
$sec_session = nosql($_SESSION['sec_session']);
$nm17_session = balikin2($_SESSION['nm17_session']);
$pass17_session = nosql($_SESSION['pass17_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_penjaga.kd ".
			"FROM admin_penjaga, m_pegawai ".
			"WHERE admin_penjaga.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd17_session' ".
			"AND m_pegawai.usernamex = '$username17_session' ".
			"AND m_pegawai.passwordx = '$pass17_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd17_session))
	OR (empty($username17_session))
	OR (empty($pass17_session))
	OR (empty($sec_session))
	OR (empty($nip17_session))
	OR (empty($nm17_session))
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
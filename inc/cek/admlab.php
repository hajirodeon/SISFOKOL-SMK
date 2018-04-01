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
$kd14_session = nosql($_SESSION['kd14_session']);
$nip14_session = nosql($_SESSION['nip14_session']);
$nm14_session = balikin2($_SESSION['nm14_session']);
$username14_session = nosql($_SESSION['username14_session']);
$lab_session = nosql($_SESSION['lab_session']);
$pass14_session = nosql($_SESSION['pass14_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admlab";


$qbw = mysql_query("SELECT m_keahlian_kompetensi.kd ".
			"FROM m_keahlian_kompetensi, m_pegawai ".
			"WHERE m_keahlian_kompetensi.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd14_session' ".
			"AND m_pegawai.usernamex = '$username14_session' ".
			"AND m_pegawai.passwordx = '$pass14_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd14_session))
	OR (empty($username14_session))
	OR (empty($pass14_session))
	OR (empty($lab_session))
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
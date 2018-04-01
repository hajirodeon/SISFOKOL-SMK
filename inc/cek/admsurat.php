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
$kd11_session = nosql($_SESSION['kd11_session']);
$nip11_session = nosql($_SESSION['nip11_session']);
$nm11_session = balikin2($_SESSION['nm11_session']);
$username11_session = nosql($_SESSION['username11_session']);
$surat_session = nosql($_SESSION['surat_session']);
$pass11_session = nosql($_SESSION['pass11_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admsurat";


$qbw = mysql_query("SELECT admin_surat.kd ".
			"FROM admin_surat, m_pegawai ".
			"WHERE admin_surat.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd11_session' ".
			"AND m_pegawai.usernamex = '$username11_session' ".
			"AND m_pegawai.passwordx = '$pass11_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd11_session))
	OR (empty($username11_session))
	OR (empty($pass11_session))
	OR (empty($surat_session))
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
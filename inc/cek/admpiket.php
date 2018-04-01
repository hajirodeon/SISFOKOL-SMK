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
$kd33_session = nosql($_SESSION['kd33_session']);
$xkd33_session = nosql($_SESSION['xkd33_session']);
$nip33_session = nosql($_SESSION['nip33_session']);
$nm33_session = balikin2($_SESSION['nm33_session']);
$username33_session = nosql($_SESSION['username33_session']);
$piket_session = nosql($_SESSION['piket_session']);
$pass33_session = nosql($_SESSION['pass33_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admbdh";


$qbw = mysql_query("SELECT admin_piket.kd ".
					"FROM admin_piket, m_pegawai ".
					"WHERE admin_piket.kd_pegawai = m_pegawai.kd ".
					"AND m_pegawai.kd = '$kd33_session' ".
					"AND m_pegawai.usernamex = '$username33_session' ".
					"AND m_pegawai.passwordx = '$pass33_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd33_session))
	OR (empty($username33_session))
	OR (empty($pass33_session))
	OR (empty($piket_session))
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
<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd37_session = nosql($_SESSION['kd37_session']);
$nip37_session = nosql($_SESSION['nip37_session']);
$username37_session = nosql($_SESSION['username37_session']);
$entri_session = nosql($_SESSION['entri_session']);
$nm37_session = balikin2($_SESSION['nm37_session']);
$pass37_session = nosql($_SESSION['pass37_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_entri.kd ".
						"FROM admin_entri, m_pegawai ".
						"WHERE admin_entri.kd_pegawai = m_pegawai.kd ".
						"AND m_pegawai.kd = '$kd37_session' ".
						"AND m_pegawai.usernamex = '$username37_session' ".
						"AND m_pegawai.passwordx = '$pass37_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd37_session))
	OR (empty($username37_session))
	OR (empty($pass37_session))
	OR (empty($entri_session))
	OR (empty($nip37_session))
	OR (empty($nm37_session))
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
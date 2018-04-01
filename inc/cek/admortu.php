<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd21_session = nosql($_SESSION['kd21_session']);
$nis21_session = nosql($_SESSION['nis21_session']);
$username21_session = nosql($_SESSION['username21_session']);
$ortu_session = nosql($_SESSION['ortu_session']);
$nm21_session = balikin2($_SESSION['nm21_session']);
$pass21_session = nosql($_SESSION['pass21_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admsw";


$qbw = mysql_query("SELECT * FROM m_siswa ".
					"WHERE kd = '$kd21_session' ".
					"AND usernamex = '$username21_session' ".
					"AND passwordx_ortu = '$pass21_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd21_session))
	OR (empty($username21_session))
	OR (empty($nis21_session))
	OR (empty($pass21_session))
	OR (empty($ortu_session))
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
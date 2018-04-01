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






//cek user GURU /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qsur = mysql_query("SELECT guru_mapel.*, guru_mapel.kd AS gmkd, ".
			"m_user.* ".
			"FROM guru_mapel, m_user ".
			"WHERE guru_mapel.kd_user = m_user.kd ".
			"AND guru_mapel.kd_user = '$kd1_session' ".
			"AND m_user.tipe = 'GURU'");
$rsur = mysql_fetch_assoc($qsur);
$tsur = mysql_num_rows($qsur);

//jika iya
if ($tsur != 0)
	{
	echo ' (<a href="'.$sumber.'/janissari/e/gr/mapel.php" title="Daftar Lainnya">Daftar Lainnya</a>)
	<table width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td width="100">

	<table bgcolor="white" width="975" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	[<a href="'.$sumber.'/janissari/e/gr/mapel.php?s=detail&gmkd='.$gmkd.'" title="Home">Home</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/news.php?gmkd='.$gmkd.'" title="News">News</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/kategori.php?gmkd='.$gmkd.'" title="Kategori">Kategori</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/artikel.php?gmkd='.$gmkd.'" title="Artikel">Artikel</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/file_materi.php?gmkd='.$gmkd.'" title="File Materi">File Materi</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/link.php?gmkd='.$gmkd.'" title="Link">Link</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/kalender.php?gmkd='.$gmkd.'" title="Kalender">Kalender</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/forum.php?gmkd='.$gmkd.'" title="Forum">Forum</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/polling.php?gmkd='.$gmkd.'" title="Polling">Polling</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/soal.php?gmkd='.$gmkd.'" title="Soal">Soal</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/chatroom.php?gmkd='.$gmkd.'" title="ChatRoom">ChatRoom</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/msg.php?gmkd='.$gmkd.'" title="Message Massal">Message Massal</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/tanya.php?gmkd='.$gmkd.'" title="Tanya">Tanya</a>] -
	[<a href="'.$sumber.'/janissari/e/gr/logs.php?gmkd='.$gmkd.'" title="Logs">Logs</a>].
	</td>
	</tr>
	</table>

	</td>
	</tr>
	</table>';
	}



//jika siswa ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//cek user SISWA
$qswa = mysql_query("SELECT * FROM m_user ".
						"WHERE kd = '$kd1_session' ".
						"AND tipe = 'SISWA'");
$rswa = mysql_fetch_assoc($qswa);
$tswa = mysql_num_rows($qswa);

//jika iya
if ($tswa != 0)
	{
	echo ' (<a href="'.$sumber.'/janissari/e/sw/mapel.php" title="Daftar Lainnya">Daftar Lainnya</a>)
	<table width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td width="100">

	<table bgcolor="white" width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	[<a href="'.$sumber.'/janissari/e/sw/mapel.php?s=detail&gmkd='.$gmkd.'" title="Home">Home</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/news.php?gmkd='.$gmkd.'" title="News">News</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/artikel.php?gmkd='.$gmkd.'" title="Artikel">Artikel</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/file_materi.php?gmkd='.$gmkd.'" title="File Materi">File Materi</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/link.php?gmkd='.$gmkd.'" title="Link">Link</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/kalender.php?gmkd='.$gmkd.'" title="Kalender">Kalender</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/forum.php?gmkd='.$gmkd.'" title="Forum">Forum</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/soal.php?s=detail&gmkd='.$gmkd.'" title="Soal">Soal</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/chatroom.php?gmkd='.$gmkd.'" title="ChatRoom">ChatRoom</a>] -
	[<a href="'.$sumber.'/janissari/e/sw/tanya.php?gmkd='.$gmkd.'" title="Tanya">Tanya</a>].
	</td>
	</tr>
	</table>

	</td>
	</tr>
	</table>';
	}
?>
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
$qswa = mysql_query("SELECT guru_mapel.*, guru_mapel.kd AS gmkd, ".
			"m_user.* ".
			"FROM guru_mapel, m_user ".
			"WHERE guru_mapel.kd_user = m_user.kd ".
			"AND guru_mapel.kd_user = '$kd1_session' ".
			"AND m_user.tipe = 'GURU'");
$rswa = mysql_fetch_assoc($qswa);
$tswa = mysql_num_rows($qswa);

//jika iya
if ($tswa != 0)
	{
	echo ' (<a href="'.$sumber.'/janissari/e/grsw/mapel.php" title="Daftar Lainnya">Daftar Lainnya</a>)
	<table width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td width="100">

	<table bgcolor="white" width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	[<a href="'.$sumber.'/janissari/e/grsw/mapel.php?s=detail&gmkd='.$gmkd.'" title="Home">Home</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/news.php?gmkd='.$gmkd.'" title="News">News</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/artikel.php?gmkd='.$gmkd.'" title="Artikel">Artikel</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/file_materi.php?gmkd='.$gmkd.'" title="File Materi">File Materi</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/link.php?gmkd='.$gmkd.'" title="Link">Link</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/kalender.php?gmkd='.$gmkd.'" title="Kalender">Kalender</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/forum.php?gmkd='.$gmkd.'" title="Forum">Forum</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/soal.php?s=detail&gmkd='.$gmkd.'" title="Soal">Soal</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/chatroom.php?gmkd='.$gmkd.'" title="ChatRoom">ChatRoom</a>] -
	[<a href="'.$sumber.'/janissari/e/grsw/tanya.php?gmkd='.$gmkd.'" title="Tanya">Tanya</a>].
	</td>
	</tr>
	</table>

	</td>
	</tr>
	</table>';
	}
?>
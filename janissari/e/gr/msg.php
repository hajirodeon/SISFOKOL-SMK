<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL JANISSARI                          ///////
/////// (customization)                             ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh :                               ///////
/////// Agus Muhajir, S.Kom                         ///////
/////// URL     :                                   ///////
///////     *http://sisfokol.wordpress.com          ///////
//////      *http://hajirodeon.wordpress.com        ///////
/////// E-Mail  :                                   ///////
///////     * hajirodeon@yahoo.com                  ///////
///////     * hajirodeon@gmail.com                  ///////
/////// HP/SMS  : 081-829-88-54                     ///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////



session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_gr.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$gmkd = nosql($_REQUEST['gmkd']);
$katkd = nosql($_REQUEST['katkd']);
$filenya = "msg.php?gmkd=$gmkd";


//focus...
$diload = "document.formx.msg.focus();";


//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika kirim
if ($_POST['btnKRM'])
	{
	//nilai
	$mapelnya = cegah($_POST['mapelnya']);
	$t_msg = cegah($_POST['t_msg']);


	//nek null
	if (empty($t_msg))
		{
		//nilai
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//isi
		$isi_msg = "[$mapelnya]. $t_msg";

		//looping teman
		$qtku = mysql_query("SELECT m_user.*, m_user.kd AS uskd, user_blog_teman.* ".
					"FROM m_user, user_blog_teman ".
					"WHERE user_blog_teman.kd_user_teman = m_user.kd ".
					"AND m_user.tipe = 'SISWA' ".
					"AND user_blog_teman.kd_user = '$kd1_session' ".
					"ORDER BY m_user.nama ASC");
		$rtku = mysql_fetch_assoc($qtku);
		$ttku = mysql_num_rows($qtku);

		//jika ada
		if ($ttku != 0)
			{
			do
				{
				$tno = $tno + 1;
				$xyz = md5("$x$tno");
				$tk_uskd = nosql($rtku['uskd']);

				//query
				mysql_query("INSERT INTO user_blog_msg(kd, kd_user, untuk, msg, postdate) VALUES ".
						"('$xyz', '$kd1_session', '$tk_uskd', '$isi_msg', '$today')");
				}
			while ($rtku = mysql_fetch_assoc($qtku));
			}

		//re-direct
		$pesan = "Message Berhasil Dikirim.";
		pekem($pesan,$filenya);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
require("../../../inc/menu/janissari.php");


//view : guru ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika belum pilih mapel
if (empty($gmkd))
	{
	//re-direct
	$ke = "mapel.php";
	xloc($ke);
	exit();
	}

//nek mapel telah dipilih
else
	{
	//mapel-nya...
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.* ".
							"FROM guru_mapel, m_mapel ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);


	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "msg.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> Message Massal";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td width="100">
		<p>
		<big><strong>:::Message Massal...</strong></big>
		</p>
		</td>
  		</tr>
		</table>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<textarea name="t_msg" cols="50" rows="5" wrap="virtual"></textarea>
		<br>
		<INPUT type="hidden" name="mapelnya" value="'.$pel_nm.'">
		<input name="btnKRM" type="submit" value="KIRIM">
		<input name="btnBTL" type="submit" value="BATAL">
		<br><br><br>
		</td>
		</tr>
		</table>';
		}

	//jika tidak
	else
		{
		//re-direct
		$pesan = "Silahkan Lihat Daftar Mata Pelajaran.";
		$ke = "mapel.php";
		pekem($pesan,$ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
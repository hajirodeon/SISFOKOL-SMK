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
require("../../../inc/cek/e_sw.php");
$tpl = LoadTpl("../../../template/chat.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$gmkd = nosql($_REQUEST['gmkd']);
$filenya = "chatroom.php?gmkd=$gmkd";


//focus...
$diload = "document.formx.chat.focus();";





//isi *START
ob_start();

require("../../../inc/js/swap.js");
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
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.*, m_user.* ".
				"FROM guru_mapel, m_mapel, m_user ".
				"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
				"AND guru_mapel.kd_user = m_user.kd ".
				"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);
	$pel_usnm = balikin($rpel['nama']);


	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "chatroom.php?gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm] --> ChatRoom";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;


		//log
		$nilku = "Masuk ChatRoom";
		mysql_query("INSERT INTO user_learning(kd, kd_user, kd_guru_mapel, ket, postdate) VALUES ".
				"('$x', '$kd1_session', '$gmkd', '$nilku', '$today')");




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
		<big><strong>:::ChatRoom...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>

		<form action="chatroom_refresh.php" method="post" target="fchat" name="formx">
		Chat Msg :
		<input type="text" name="chat" size="50">
		<input name="gmkd" type="hidden" value="'.$gmkd.'">
		<input type="submit" name="btnSMP" value="KIRIM"
		onClick="document.formx.chat.focus();"
		onKeyDown="document.formx.chat.focus();">
		<br>
		<br>


		<iframe name="fchat" id="fchat" align="top" frameborder="0" height="500" width="950" scrolling="auto" src="chatroom_refresh.php?s=view&gmkd='.$gmkd.'"></iframe>
		</form>

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
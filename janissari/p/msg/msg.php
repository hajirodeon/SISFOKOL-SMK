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
require("../../../inc/class/paging.php");
require("../../../inc/class/pagingx.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$filenya = "msg.php";
$uskd = nosql($_REQUEST['uskd']);

//dia...
$qtem = mysql_query("SELECT * FROM m_user ".
						"WHERE kd = '$uskd'");
$rtem = mysql_fetch_assoc($qtem);
$ttem = mysql_num_rows($qtem);
$tem_no = nosql($rtem['nomor']);
$tem_nama = balikin($rtem['nama']);
$tem_tipe = nosql($rtem['tipe']);

//jika tidak ada, kembali ke aku sendiri
if ((empty($uskd)) OR ($ttem == 0))
	{
	//re-direct
	$ke = "$sumber/janissari/k/profil/profil.php";
	xloc($ke);
	exit();
	}


//judul
$judul = "...Tulis Message";
$judulku = "Halaman : $tem_no.$tem_nama [$tem_tipe] --> $judul";
$juduli = $judul;






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$uskd = nosql($_POST['uskd']);

	//re-direct
	$ke = "../index.php?uskd=$uskd";
	xloc($ke);
	exit();
	}






//jika kirim
if ($_POST['btnKRM'])
	{
	//nilai
	$uskd = nosql($_POST['uskd']);
	$p_msg = cegah($_POST['p_msg']);

	//nek null
	if (empty($p_msg))
		{
		//nilai
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "msg.php?uskd=$uskd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//query
		mysql_query("INSERT INTO user_blog_msg(kd, kd_user, untuk, msg, postdate) VALUES ".
						"('$x', '$kd1_session', '$uskd', '$p_msg', '$today')");

		//re-direct
		$pesan = "Message Berhasil Dikirim.";
		$ke = "$filenya?uskd=$uskd";
		pekem($pesan,$ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();




require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E9FFBB" width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td width="80%">';
xheadline($judul);




//tulis message /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//focus
$diload = "document.formx.p_msg.focus();";

//kepada
$qpda = mysql_query("SELECT * FROM m_user ".
						"WHERE kd = '$uskd'");
$rpda = mysql_fetch_assoc($qpda);
$pda_nisp = nosql($rpda['nomor']);
$pda_nama = balikin($rpda['nama']);

echo '<br>
Kepada :
<br>
<strong>'.$pda_nisp.'. '.$pda_nama.'</strong>
<br>
<textarea name="p_msg" cols="50" rows="5" wrap="virtual"></textarea>
<br>
<input name="uskd" type="hidden" value="'.$uskd.'">
<input name="btnKRM" type="submit" value="KIRIM">
<input name="btnBTL" type="submit" value="BATAL">
<br><br><br>

<big><strong>***SENT ITEMS :</strong></big>
<br>';

//query view
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT user_blog_msg.*, user_blog_msg.postdate AS mspd, m_user.* ".
				"FROM user_blog_msg, m_user ".
				"WHERE user_blog_msg.untuk = m_user.kd ".
				"AND user_blog_msg.kd_user = '$kd1_session' ".
				"AND user_blog_msg.untuk = '$uskd' ".
				"ORDER BY user_blog_msg.postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$target = "$filenya?uskd=$uskd";
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);

//nek ada
if ($count != 0)
	{
	echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$d_msg = balikin($data['msg']);
		$d_mspd = $data['mspd'];

		echo '<tr valign="top">
		<td valign="top">
		<em>'.$d_msg.'</em>
		<br>
		['.$d_mspd.']
		</td>
		</tr>';
  		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
    	<tr>
	<td align="right">
	<hr>
	<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
	<hr>
	</td>
    	</tr>
	</table>';
	}
else
	{
	echo '<font color="red"><strong>TIDAK ADA DATA Sent Items.</strong></font>';
	}


echo '</td>
<td width="1%">
</td>

<td>';

//ambil sisi
require("../../../inc/menu/p_sisi.php");


echo '</td>
</tr>
</table>';
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
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

//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/class/paging2.php");
require("../../../inc/class/pagingx.php");
require("../../../inc/class/thumbnail_images.php");
$tpl = LoadTpl("../../../template/janissari.html");


nocache;

//nilai
$filenya = "album_detail_view.php";
$s = nosql($_REQUEST['s']);
$msgkd = nosql($_REQUEST['msgkd']);
$alkd = nosql($_REQUEST['alkd']);
$fkd = nosql($_REQUEST['fkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//file-nya
$qfle = mysql_query("SELECT * FROM user_blog_album_filebox ".
						"WHERE kd_album = '$alkd' ".
						"AND kd = '$fkd'");
$rfle = mysql_fetch_assoc($qfle);
$fle_filex = $rfle['filex'];
$fle_ket = balikin($rfle['ket']);

//nek null
if (empty($fle_ket))
	{
	$fle_ket = "-";
	}


//judul
$judul = "Foto : $fle_filex";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$judulx = $judul;


//focus
$diload = "document.formx.bk_foto.focus();";




//isi *START
ob_start();


//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="#FDF0DE" width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td width="80%">

<table bgcolor="'.$warnaover.'" width="100%" height="100%" border="0" cellspacing="3" cellpadding="0">
<tr align="center">
<td>
<img src="'.$sumber.'/filebox/album/'.$alkd.'/'.$fle_filex.'" border="1">
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" height="100%" border="0" cellspacing="3" cellpadding="0">
<tr align="center">
<td valign="top">
<em>'.$fle_ket.'</em>
</td>
</tr>
</table>
<br>
<br>
<hr>';

//hapus komentar ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($s == "hapus")
	{
	//nilai
	$alkd = nosql($_REQUEST['alkd']);
	$fkd = nosql($_REQUEST['fkd']);
	$msgkd = nosql($_REQUEST['msgkd']);

	//hapus
	mysql_query("DELETE FROM user_blog_album_msg ".
					"WHERE kd = '$msgkd'");

	//re-direct
	$ke = "$filenya?alkd=$alkd&fkd=$fkd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//daftar komentar ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qdko = mysql_query("SELECT * FROM user_blog_album_msg ".
						"WHERE kd_user_blog_album = '$fkd' ".
						"ORDER BY postdate ASC");
$rdko = mysql_fetch_assoc($qdko);
$tdko = mysql_num_rows($qdko);

if ($tdko != 0)
	{
	do
		{
		//nilai
		$dko_kd = nosql($rdko['kd']);
		$dko_msg = balikin($rdko['msg']);
		$dko_dari = nosql($rdko['dari']);
		$dko_postdate = $rdko['postdate'];

		//user-nya
		$qtuse = mysql_query("SELECT m_user.*, m_user.kd AS uskd, ".
								"user_blog.* ".
								"FROM m_user, user_blog ".
								"WHERE user_blog.kd_user = m_user.kd ".
								"AND m_user.kd = '$dko_dari'");
		$rtuse = mysql_fetch_assoc($qtuse);
		$tuse_kd = nosql($rtuse['uskd']);
		$tuse_no = nosql($rtuse['nomor']);
		$tuse_nm = balikin($rtuse['nama']);
		$tuse_tipe = nosql($rtuse['tipe']);
		$tuse_foto_path = $rtuse['foto_path'];

		//nek null foto
		if (empty($tuse_foto_path))
			{
			$nilz_foto = "$sumber/img/foto_blank.jpg";
			}
		else
			{
			//gawe mini thumnail
			$nilz_foto = "$sumber/filebox/profil/$tuse_kd/thumb_$tuse_foto_path";
			}

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td width="50" valign="top">
		<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
		<img src="'.$nilz_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
		</a>
		</td>
		<td valign="top">
		<em>'.$dko_msg.'. <br>
		[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
		['.$dko_postdate.'].</em>
		[<a href="'.$filenya.'?alkd='.$alkd.'&fkd='.$fkd.'&msgkd='.$dko_kd.'&s=hapus" title="HAPUS"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>]
		<br><br>
		</td>
		</tr>
		</table>
		<br>';
		}
	while ($rdko = mysql_fetch_assoc($qdko));
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//simpan komentar ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnSMP'])
	{
	//nilai
	$uskd = nosql($_POST['uskd']);
	$fkd = nosql($_POST['fkd']);
	$bk_foto = cegah($_POST['bk_foto']);
	$page = nosql($_POST['page']);


	//insert
	mysql_query("INSERT INTO user_blog_album_msg(kd, kd_user_blog_album, dari, msg, postdate) VALUES ".
					"('$x', '$fkd', '$kd1_session', '$bk_foto', '$today')");

	//re-direct
	$ke = "$filenya?alkd=$alkd&fkd=$fkd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '</p>
<br>
<br>

<p>
Beri Komentar :
(<a href="album_detail.php?alkd='.$alkd.'" title="Lihat Foto Lainnya...">Lihat Foto Lainnya...</a>)
<br>
<textarea name="bk_foto" cols="50" rows="5" wrap="virtual"></textarea>
<br>
<input name="fkd" type="hidden" value="'.$fkd.'">
<input name="alkd" type="hidden" value="'.$alkd.'">
<input name="uskd" type="hidden" value="'.$uskd.'">
<input name="page" type="hidden" value="'.$page.'">
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="reset" value="BATAL">
</p>

<td width="1%">
</td>

<td>';

//ambil sisi
require("../../../inc/menu/k_sisi.php");

echo '<br>
<br>
<br>';
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
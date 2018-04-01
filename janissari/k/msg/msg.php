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
$judul = "Message";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$juduli = $judul;
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($s == "hapus")
	{
	//nilai
	$msgkd = nosql($_REQUEST['msgkd']);

	//query
	mysql_query("DELETE FROM user_blog_msg ".
					"WHERE untuk = '$kd1_session' ".
					"AND kd = '$msgkd'");

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();



require("../../../inc/js/swap.js");
require("../../../inc/js/checkall.js");
require("../../../inc/menu/janissari.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#FDF0DE" valign="top">
<td>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>';
xheadline($judul);

echo ' (<a href="msg_post.php" title="Tulis Message">Tulis Message</a>).
(<a href="msg_post.php?m=massal" title="Tulis Message Massal">Tulis Message Massal</a>).
</td>
</tr>
</table>';

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM user_blog_msg ".
				"WHERE untuk = '$kd1_session' ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);

//nek ada
if ($count != 0)
	{
	echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$nomer = $nomer + 1;

		$dt_kd = nosql($data['kd']);
		$dt_msg = balikin($data['msg']);
		$dt_userkd = nosql($data['kd_user']);
		$dt_postdate = $data['postdate'];

		//dari
		$qerk = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$dt_userkd'");
		$rerk= mysql_fetch_assoc($qerk);
		$erk_nisp = nosql($rerk['nomor']);
		$erk_nama = balikin($rerk['nama']);
		$erk_tipe = balikin($rerk['tipe']);

		//user_blog
		$qtuse = mysql_query("SELECT * FROM user_blog ".
									"WHERE kd_user = '$dt_userkd'");
		$rtuse = mysql_fetch_assoc($qtuse);
		$tuse_kd = nosql($rtuse['kd']);
		$tuse_foto_path = $rtuse['foto_path'];


		//nek null foto
		if (empty($tuse_foto_path))
			{
			$nilx_foto = "$sumber/img/foto_blank.jpg";
			}
		else
			{
			//gawe mini thumnail
			$nilx_foto = "$sumber/filebox/profil/$dt_userkd/thumb_$tuse_foto_path";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">

		<table width="100%" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td width="50" valign="top">
		<a href="'.$sumber.'/janissari/p/index.php?uskd='.$dt_userkd.'" title="('.$erk_tipe.'). '.$erk_nisp.'. '.$erk_nama.'">
		<img src="'.$nilx_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
		</a>
		</td>
		<td valign="top">

		<p>
		<em>'.$dt_msg.'</em>
		<br>
		[<em>Dari : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$dt_userkd.'" title="('.$erk_tipe.'). '.$erk_nisp.'. '.$erk_nama.'">'.$erk_nisp.'. '.$erk_nama.'</a></strong></em>].

		[<em>'.$dt_postdate.'</em>].
		[<em><a href="msg_post.php?s=tulis&userkd='.$dt_userkd.'" title="Reply ke : '.$erk_nama.'">REPLY</a></em>].
		[<em><a href="'.$filenya.'?s=hapus&msgkd='.$dt_kd.'" title="Hapus"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a></em>].
		</p>
		</td>
		</tr>
		</table>
		<br>

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
	echo '<font color="red"><strong>TIDAK ADA MESSAGE.</strong></font>';
	}


echo '<br>
<br>
<br>
</td>
<td width="1%">
</td>

<td width="1%">';

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
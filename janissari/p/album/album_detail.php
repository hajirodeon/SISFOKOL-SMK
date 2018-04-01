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
$tpl = LoadTpl("../../../template/janissari.html");


nocache;

//nilai
$filenya = "album_detail.php";
$limit = 10; //batas data per page
$uskd = nosql($_REQUEST['uskd']);
$alkd = nosql($_REQUEST['alkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

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


//judul album
$qbum = mysql_query("SELECT * FROM user_blog_album ".
						"WHERE kd_user = '$uskd' ".
						"AND kd = '$alkd'");
$rbum = mysql_fetch_assoc($qbum);
$bum_judul = balikin($rbum['judul']);


//judul
$judul = "Album Foto : $bum_judul";
$judulku = "Halaman : $tem_no.$tem_nama [$tem_tipe] --> $judul";
$judulx = $judul;





//isi *START
ob_start();


//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="#E9FFBB" width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td width="80%">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td>
<font color="green">';

xheadline($judul);
echo '</font>
</td>
</tr>
</table>
<br>';

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM user_blog_album_filebox ".
					"WHERE kd_album = '$alkd' ".
					"ORDER BY filex ASC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?uskd=$uskd&alkd=$alkd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//nek ada
if ($count != 0)
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
    	<tr bgcolor="'.$tk_warnaheader.'">
	<td align="right">
	<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
	</td>
    	</tr>
	</table>

	<table width="100%" border="1" cellpadding="3" cellspacing="0">';

	do
  		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}

		$nomer = $nomer + 1;
		$kd = nosql($data['kd']);
		$y_filex = balikin($data['filex']);
		$y_ket = balikin($data['ket']);

		//nek null
		if (empty($y_ket))
			{
			$y_ket = "-";
			}


		//jml komentar
		$qjko = mysql_query("SELECT * FROM user_blog_album_msg ".
								"WHERE kd_user_blog_album = '$kd'");
		$rjko = mysql_fetch_assoc($qjko);
		$tjko = mysql_num_rows($qjko);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$tk_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td align="center" width="100" valign="top">';

		//gawe thumnail
		$nilz_foto = "$sumber/filebox/album/$alkd/thumb_$y_filex";
		echo '<a href="album_detail_view.php?uskd='.$uskd.'&alkd='.$alkd.'&fkd='.$kd.'" title="Beri Komentar : '.$y_filex.'"><img src="'.$nilz_foto.'" title="'.$y_ket.'" width="200" border="1"></a>
		</td>
		<td valign="top">
		Nama File :
		<br>
		<strong>'.$y_filex.'</strong>
		<br>
		<br>

		Keterangan :
		<br>
		<em><strong>'.$y_ket.'</strong></em>
		<p>
		[<font color="red"><strong>'.$tjko.'</strong></font> Komentar].
		[<a href="album_detail_view.php?uskd='.$uskd.'&alkd='.$alkd.'&fkd='.$kd.'" title="Beri Komentar : '.$y_filex.'">Beri Komentar</a>].
		</p>
		</td>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
    	<tr bgcolor="'.$tk_warnaheader.'">
	<td align="right">
	<input name="page" type="hidden" value="'.$page.'">
	<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
	</td>
    	</tr>
	</table>';
	}
else
	{
	echo '<font color="red"><strong>TIDAK ADA FOTO.</strong></font>';
	}

echo '<br><br><br>
</td>


<td width="1%">
</td>

<td>';

//ambil sisi
require("../../../inc/menu/p_sisi.php");

echo '<br>
<br>
<br>
</td>
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
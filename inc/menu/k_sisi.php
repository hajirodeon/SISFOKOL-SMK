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





//aku
$qtem = mysql_query("SELECT * FROM m_user ".
			"WHERE kd = '$kd1_session'");
$rtem = mysql_fetch_assoc($qtem);
$tem_no = nosql($rtem['nomor']);
$tem_nama = balikin($rtem['nama']);
$tem_tipe = nosql($rtem['tipe']);


//query blog
$qdt = mysql_query("SELECT * FROM user_blog ".
			"WHERE kd_user = '$kd1_session'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_foto_path = $rdt['foto_path'];

echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaover.'" valign="top">
<td bgcolor="'.$warnaheader.'" width="200" align="center">';

//nek null foto
if (empty($dt_foto_path))
	{
	$nil_foto = "$sumber/img/foto_blank.jpg";
	}
else
	{
	$nil_foto = "$sumber/filebox/profil/$kd1_session/thumb_$dt_foto_path";
	}


echo '<img src="'.$nil_foto.'" alt="'.$tem_nama.'" width="195" height="300" border="5">
<br>
<strong>'.$tem_no.'. </strong>
<br>
<strong>'.$tem_nama.'</strong>
<br>
[<strong>'.$tem_tipe.'</strong>]

<br>
[<a href="'.$sumber.'/janissari/k/profil/profil.php" title="Edit Profil">Edit Profil</a>].
<br>
[<a href="'.$sumber.'/janissari/index.php" title="Kembali ke Home">Kermbali ke Home</a>].
</td>
</tr>
</table>
<br>


<hr size="1">
<big><strong>Temanku...</strong></big>
(<a href="../temanku/temanku.php" title="Lihat Daftar Teman">Semua</a>)
<br>';

//temanku //query ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$x_p = new x_Pager();
$x_limit = 10;
$x_start = $x_p->x_findStart($x_limit);

$x_sqlcount = "SELECT m_user.*, m_user.kd AS uskd, user_blog_teman.* ".
					"FROM m_user, user_blog_teman ".
					"WHERE user_blog_teman.kd_user_teman = m_user.kd ".
					"AND user_blog_teman.kd_user = '$kd1_session' ".
					"ORDER BY rand()";
$x_sqlresult = $x_sqlcount;

$x_count = mysql_num_rows(mysql_query($x_sqlcount));
$x_pages = $x_p->x_findPages($x_count, $x_limit);
$x_result = mysql_query("$x_sqlresult LIMIT ".$x_start.", ".$x_limit);
$x_pagelist = $x_p->x_pageList($_GET['x_page'], $x_pages, $x_target);
$x_data = mysql_fetch_array($x_result);


//nek ada
if ($x_count != 0)
	{
	echo '<table width="200" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$kd = nosql($x_data['uskd']);
		$nisp = nosql($x_data['nomor']);
		$nama = balikin($x_data['nama']);
		$tipe = balikin($x_data['tipe']);

		//user_blog
		$qtuse = mysql_query("SELECT * FROM user_blog ".
								"WHERE kd_user = '$kd'");
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
			$nilx_foto = "$sumber/filebox/profil/$kd/thumb_$tuse_foto_path";
			}

		echo '<tr>
		<td valign="top">

		<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td width="50" valign="top">
		<a href="'.$sumber.'/janissari/p/index.php?uskd='.$kd.'" title="'.$nisp.'. '.$nama.' ['.$tipe.']">
		<img src="'.$nilx_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
		</a>
		</td>
		<td valign="top">
		<a href="'.$sumber.'/janissari/p/index.php?uskd='.$kd.'" title="'.$nisp.'. '.$nama.' ['.$tipe.']"><strong>'.$nama.'</strong>
		<br>
		['.$tipe.': '.$nisp.']</a>
		</td>
		</tr>
		</table>

		</td>
		</tr>';
  		}
	while ($x_data = mysql_fetch_assoc($x_result));

	echo '</table>';
	}
else
	{
	echo '<font color="red"><strong>BELUM PUNYA TEMAN.</strong></font>';
	}

echo '<br>
[<a href="'.$sumber.'/janissari/k/temanku/temanku.php" title="EDIT Temanku">EDIT Temanku</a>]
<hr size="1">
<br>
<br>

<big><strong>Kategori...</strong></big>
<br>';

//kategori //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qkat = mysql_query("SELECT * FROM user_blog_kategori ".
						"WHERE kd_user = '$kd1_session' ".
						"ORDER BY kategori ASC");
$rkat = mysql_fetch_assoc($qkat);
$tkat = mysql_num_rows($qkat);

//nek gak null
if ($tkat != 0)
	{
	do
		{
		//nilai
		$kat = balikin($rkat['kategori']);

		echo "* $kat <br><br>";
		}
	while ($rkat = mysql_fetch_assoc($qkat));
	}
else
	{
	echo '<font color="red"><strong>BELUM ADA KATEGORI.</strong></font>';
	}

echo '<br>
[<a href="'.$sumber.'/janissari/k/kategori/kategori.php" title="EDIT Kategori">EDIT Kategori</a>]
<hr size="1">
<br>
<br>

<big><strong>Link Favorit...</strong></big>
<br>';

//link //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qlik = mysql_query("SELECT * FROM user_blog_link ".
						"WHERE kd_user = '$kd1_session' ".
						"ORDER BY judul ASC");
$rlik = mysql_fetch_assoc($qlik);
$tlik = mysql_num_rows($qlik);

//nek ada
if ($tlik != 0)
	{
	do
		{
		//nilai
		$lik_judul = balikin($rlik['judul']);
		$lik_url = balikin($rlik['url']);

		echo '* <a href="http://'.$lik_url.'" title="'.$lik_judul.'" target="_blank">'.$lik_judul.'</a>
		<br><br>';
		}
	while ($rlik = mysql_fetch_assoc($qlik));
	}
else
	{
	echo '<font color="red"><strong>BELUM ADA LINK.</strong></font>';
	}

echo '<br>
[<a href="'.$sumber.'/janissari/k/link/link.php" title="EDIT Link">EDIT Link</a>]
<hr size="1">
<br>
<br>

<big><strong>Album Foto...</strong></big>
<br>';

//album foto ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qbum = mysql_query("SELECT * FROM user_blog_album ".
						"WHERE kd_user = '$kd1_session' ".
						"ORDER BY judul ASC");
$rbum = mysql_fetch_assoc($qbum);
$tbum = mysql_num_rows($qbum);

//nek ada
if ($tbum != 0)
	{
	do
		{
		//nilai
		$bum_kd = nosql($rbum['kd']);
		$bum_judul = balikin($rbum['judul']);

		//jumlah foto tiap album
		$qjfo = mysql_query("SELECT * FROM user_blog_album_filebox ".
								"WHERE kd_album = '$bum_kd'");
		$rjfo = mysql_fetch_assoc($qjfo);
		$tjfo = mysql_num_rows($qjfo);

		echo '* <a href="'.$sumber.'/janissari/k/album/album_detail.php?alkd='.$bum_kd.'" title="'.$bum_judul.' ['.$tjfo.' Foto].">'.$bum_judul.' <br> [<font color="red"><strong>'.$tjfo.'</strong></font> Foto].</a>
		<br><br>';
		}
	while ($rbum = mysql_fetch_assoc($qbum));
	}
else
	{
	echo '<font color="red"><strong>BELUM ADA ALBUM FOTO.</strong></font>';
	}

echo '<br>
[<a href="'.$sumber.'/janissari/k/album/album.php" title="EDIT Album Foto">EDIT Album Foto</a>]
<hr size="1">';
?>
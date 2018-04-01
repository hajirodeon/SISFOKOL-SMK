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






//profil ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query blog
$qdt = mysql_query("SELECT * FROM user_blog ".
			"WHERE kd_user = '$uskd'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_foto_path = $rdt['foto_path'];

echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$tk_warnaover.'" valign="top">
<td bgcolor="'.$tk_warnaheader.'" width="200" align="center">';

//nek null foto
if (empty($dt_foto_path))
	{
	$nil_foto = "$sumber/img/foto_blank.jpg";
	}
else
	{
	$nil_foto = "$sumber/filebox/profil/$uskd/thumb_$dt_foto_path";
	}

echo '<img src="'.$nil_foto.'" alt="'.$tem_nama.'" width="195" height="300" border="5">
<br>
<strong>'.$tem_no.'. </strong>
<br>
<strong>'.$tem_nama.'</strong>
<br>
[<strong>'.$tem_tipe.'</strong>]

<br>';

//jika tdak sama dengan profil
if ($filenya != "profil.php")
	{
	echo '[<a href="'.$sumber.'/janissari/p/profil/profil.php?uskd='.$uskd.'" title="...SELENGKAPNYA">...SELENGKAPNYA</a>].';
	}

echo '<br>
<br>

[<a href="'.$sumber.'/janissari/p/status/status.php?uskd='.$uskd.'" title="...Statusnya">...Statusnya</a>].
<br>

[<a href="'.$sumber.'/janissari/p/note/note.php?uskd='.$uskd.'" title="...Note-nya">...Note-nya</a>].
<br>

[<a href="'.$sumber.'/janissari/p/msg/msg.php?uskd='.$uskd.'" title="...Kirim Message">...Kirim Message</a>].

<br>
<br>';

//cek sudah jadi temanku ato belum
$qctem = mysql_query("SELECT m_user.*, m_user.kd AS uskd, user_blog_teman.* ".
						"FROM m_user, user_blog_teman ".
						"WHERE user_blog_teman.kd_user_teman = m_user.kd ".
						"AND user_blog_teman.kd_user = '$kd1_session' ".
						"AND user_blog_teman.kd_user_teman = '$uskd'");
$rctem = mysql_fetch_assoc($qctem);
$tctem = mysql_num_rows($qctem);

//nek iya
if ($tctem != 0)
	{
	echo '[<strong>SUDAH JADI TEMANKU</strong>]';
	}
else
	{
	//jika bukan diri sendiri
	if ($kd1_session != $uskd)
		{
		echo '[<a href="'.$sumber.'/janissari/p/index.php?s=add&uskd='.$uskd.'" title="Jadikan Temanku...!">...Jadikan Temanku!</a>].';
		}
	}

echo '<br>
<br>
[<a href="'.$sumber.'/janissari/p/index.php?uskd='.$uskd.'" title="Kembali ke Home">...Kembali ke Home</a>]
</td>
</tr>
</table>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//temannya //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<hr size="1">
<big><strong>Temannya...</strong></big>
(<a href="'.$sumber.'/janissari/p/teman/teman.php?uskd='.$uskd.'" title="Lihat Semua Temannya">Semua</a>)
<br>';


//temannya query
$x_p = new x_Pager();
$x_limit = 10;
$x_start = $x_p->x_findStart($x_limit);

$x_sqlcount = "SELECT m_user.*, m_user.kd AS uskd, user_blog_teman.* ".
					"FROM m_user, user_blog_teman ".
					"WHERE user_blog_teman.kd_user_teman = m_user.kd ".
					"AND user_blog_teman.kd_user = '$uskd' ".
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
	echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$kd = nosql($x_data['uskd']);
		$nisp = nosql($x_data['nomor']);
		$nama = balikin($x_data['nama']);
		$tipe = balikin($x_data['tipe']);

		//user_blog
		$qtusex = mysql_query("SELECT * FROM user_blog ".
								"WHERE kd_user = '$kd'");
		$rtusex = mysql_fetch_assoc($qtusex);
		$tusex_kd = nosql($rtusex['kd']);
		$tusex_foto_path = $rtusex['foto_path'];


		//nek null foto
		if (empty($tusex_foto_path))
			{
			$nilxx_foto = "$sumber/img/foto_blank.jpg";
			}
		else
			{
			//gawe mini thumnail
			$nilxx_foto = "$sumber/filebox/profil/$kd/thumb_$tusex_foto_path";
			}


		echo '<tr>
		<td valign="top">

		<table bgcolor="#B4E7BA" width="100%" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td width="50" valign="top">
		<a href="'.$sumber.'/janissari/p/index.php?uskd='.$kd.'" title="'.$nisp.'. '.$nama.' ['.$tipe.']">
		<img src="'.$nilxx_foto.'" align="left" alt="'.$tusex_nm.'" width="50" height="75" border="1">
		</a>
		</td>
		<td valign="top">
		<a href="'.$sumber.'/janissari/p/index.php?uskd='.$kd.'" title="'.$nisp.'. '.$nama.' ['.$tipe.']"><strong>'.$nama.'</strong>
		<br>
		['.$tipe.': '.$nisp.']</a>
		</td>
		</tr>
		</table>';
  		}
	while ($x_data = mysql_fetch_assoc($x_result));

	echo '</table>';
	}
else
	{
	echo '<font color="blue"><strong>BELUM PUNYA TEMAN.</strong></font>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//artikel ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<hr size="1">
<br>
<br>

<big><strong>Artikelnya...</strong></big>
<br>';

//query
$qrti = mysql_query("SELECT * FROM user_blog_artikel ".
						"WHERE kd_user = '$uskd' ".
						"ORDER BY rand()");
$rrti = mysql_fetch_assoc($qrti);
$trti = mysql_num_rows($qrti);
$rti_kd = nosql($rrti['kd']);
$rti_judul = balikin($rrti['judul']);


//nek ada
if ($trti != 0)
	{
	echo '<a href="'.$sumber.'/janissari/p/artikel/artikel.php?uskd='.$uskd.'&artkd='.$rti_kd.'" title="'.$rti_judul.'"><em>'.$rti_judul.'</em></a>';
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA ARTIKEL.</strong></font>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//buletin ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<hr size="1">
<br>
<br>

<big><strong>Buletinnya...</strong></big>
<br>';

//query
$qbul = mysql_query("SELECT * FROM user_blog_buletin ".
						"WHERE kd_user = '$uskd' ".
						"ORDER BY rand()");
$rbul = mysql_fetch_assoc($qbul);
$tbul = mysql_num_rows($qbul);
$bul_kd = nosql($rbul['kd']);
$bul_judul = balikin($rbul['judul']);


//nek ada
if ($tbul != 0)
	{
	echo '<a href="'.$sumber.'/janissari/p/buletin/buletin.php?uskd='.$uskd.'&bulkd='.$bul_kd.'" title="'.$bul_judul.'"><em>'.$bul_judul.'</em></a>';
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA BULETIN.</strong></font>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//jurnal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<hr size="1">
<br>
<br>

<big><strong>Jurnalnya...</strong></big>
<br>';

//query
$qjur = mysql_query("SELECT * FROM user_blog_jurnal ".
						"WHERE kd_user = '$uskd' ".
						"ORDER BY rand()");
$rjur = mysql_fetch_assoc($qjur);
$tjur = mysql_num_rows($qjur);
$jur_kd = nosql($rjur['kd']);
$jur_judul = balikin($rjur['judul']);


//nek ada
if ($tjur != 0)
	{
	echo '<a href="'.$sumber.'/janissari/p/jurnal/jurnal.php?uskd='.$uskd.'&jurkd='.$jur_kd.'" title="'.$jur_judul.'"><em>'.$jur_judul.'</em></a>';
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA JURNAL.</strong></font>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//link //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<hr size="1">
<br>
<br>

<big><strong>Link Favoritnya...</strong></big>
<br>';

//link
$qlik = mysql_query("SELECT * FROM user_blog_link ".
						"WHERE kd_user = '$uskd' ".
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
	echo '<font color="blue"><strong>BELUM ADA LINK.</strong></font>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//album /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<hr size="1">
<br>
<br>

<big><strong>Album Fotonya...</strong></big>
<br>';

//album foto
$qbum = mysql_query("SELECT * FROM user_blog_album ".
						"WHERE kd_user = '$uskd' ".
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

		echo '* <a href="'.$sumber.'/janissari/p/album/album_detail.php?uskd='.$uskd.'&alkd='.$bum_kd.'" title="'.$bum_judul.' ['.$tjfo.' Foto].">'.$bum_judul.' <br> [<font color="red"><strong>'.$tjfo.'</strong></font> Foto].</a>
		<br><br>';
		}
	while ($rbum = mysql_fetch_assoc($qbum));
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA ALBUM FOTO.</strong></font>';
	}

echo '<hr size="1">';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
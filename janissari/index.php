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
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/janissari.php");
require("../inc/class/paging.php");
$tpl = LoadTpl("../template/janissari.html");


nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang....";
$judulku = "$judul  [$tipe_session : $no1_session.$nm1_session]";
$artkd = nosql($_REQUEST['artkd']);
$jurkd = nosql($_REQUEST['jurkd']);
$bulkd = nosql($_REQUEST['bulkd']);
$msgkd = nosql($_REQUEST['msgkd']);
$bk = nosql($_REQUEST['bk']);
$dk = nosql($_REQUEST['dk']);
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//deteksi, jika belum punya blog
$qcc = mysql_query("SELECT * FROM user_blog ".
			"WHERE kd_user = '$kd1_session'");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);

//nek iya
if ($tcc == 0)
	{
	mysql_query("INSERT INTO user_blog(kd, kd_user, postdate) VALUES ".
					"('$x', '$kd1_session', '$today')");
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();

//menu
require("../inc/menu/janissari.php");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FDF0DE" valign="top">
<td>';

//status ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaover.'" valign="top">
<td>';

//query
$qtus = mysql_query("SELECT * FROM user_blog_status ".
						"WHERE kd_user = '$kd1_session' ".
						"ORDER BY postdate DESC");
$rtus = mysql_fetch_assoc($qtus);
$ttus = mysql_num_rows($qtus);
$tus_kd = nosql($rtus['kd']);
$tus_status = balikin($rtus['status']);


//jumlah komentar
$qitusx = mysql_query("SELECT * FROM user_blog_status_msg ".
						"WHERE kd_user_blog_status = '$tus_kd' ".
						"ORDER BY postdate ASC");
$ritusx = mysql_fetch_assoc($qitusx);
$titusx = mysql_num_rows($qitusx);


//jika ada
if ($ttus != 0)
	{
	echo '<a name="status"></a>
	<font color="red"><em><big><strong>'.$tus_status.'</strong></big></em></font>
	<br>
	[<a href="'.$filenya.'?dk=status#status" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
	[<a href="index.php?bk=status#status" title="Beri Komentar">Beri Komentar</a>].
	[<a href="k/status/status.php" title="Edit Status">Edit Status</a>].
	<br>';

	//jika daftar komentar
	if ($dk == "status")
		{
		//jika hapus
		if ($s == "hapus")
			{
			//nilai
			$msgkd = nosql($_REQUEST['msgkd']);

			//hapus
			mysql_query("DELETE FROM user_blog_status_msg ".
							"WHERE kd = '$msgkd'");

			//re-direct
			$ke = "$filenya?dk=status#status";
			xloc($ke);
			exit();
			}

		//jika ada
		if ($titusx != 0)
			{
			echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr valign="top">
			<td width="50">&nbsp;</td>
			<td>';

			do
				{
				$itusx_kd = nosql($ritusx['kd']);
				$itusx_msg = balikin2($ritusx['msg']);
				$itusx_dari = nosql($ritusx['dari']);
				$itusx_postdate = $ritusx['postdate'];

				//user-nya
				$qtuse = mysql_query("SELECT m_user.*, m_user.kd AS uskd, ".
										"user_blog.* ".
										"FROM m_user, user_blog ".
										"WHERE user_blog.kd_user = m_user.kd ".
										"AND m_user.kd = '$itusx_dari'");
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

				echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr valign="top">
				<td width="50" valign="top">
				<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
				<img src="'.$nilz_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
				</a>
				</td>
				<td valign="top">
				<em>'.$itusx_msg.'. <br>
				[Oleh : <strong><a href="p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
				['.$itusx_postdate.'].</em>
				[<a href="'.$filenya.'?dk=status&s=hapus&msgkd='.$itusx_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
				<br><br>
				</td>
				</tr>
				</table>
				<br>';
				}
			while ($ritusx = mysql_fetch_assoc($qitusx));

			echo '</td>
			</tr>
			</table>';
			}

		//jika belum ada komentar
		else
			{
			echo '<font color="violet"><strong>BELUM ADA KOMENTAR.</strong></font>';
			}
		}



	//jika beri komentar
	else if ($bk == "status")
		{
		//jika batal
		if ($_POST['btnBTL'])
			{
			//re-direct
			$ke = "$filenya?dk=status#status";
			xloc($ke);
			exit();
			}


		//jika simpan
		if ($_POST['btnSMP'])
			{
			//nilai
			$kd_status = nosql($_POST['kd_status']);
			$bk_status = cegah($_POST['bk_status']);

			//query
			mysql_query("INSERT INTO user_blog_status_msg(kd, kd_user_blog_status, dari, msg, postdate) VALUES ".
							"('$x', '$kd_status', '$kd1_session', '$bk_status', '$today')");

			//re-direct
			$ke = "$filenya?dk=status#status";
			xloc($ke);
			exit();
			}


		//view
		echo '<br>
		<textarea name="bk_status" cols="50" rows="5" wrap="virtual"></textarea>
		<br>
		<input name="bk" type="hidden" value="'.$bk.'">
		<input name="kd_status" type="hidden" value="'.$tus_kd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">';
		}
	}
else
	{
	echo '<font color="red"><strong>BELUM ADA STATUS.</strong></font>
	<br>
	[<a href="k/status/status.php" title="Edit Status">Edit Status</a>].';
	}

echo '</td>
</tr>
</table>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warna02.'" valign="top">
<td>';

//note //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qnote = mysql_query("SELECT * FROM user_blog_note ".
						"WHERE kd_user = '$kd1_session' ".
						"ORDER BY postdate DESC");
$rnote = mysql_fetch_assoc($qnote);
$tnote = mysql_num_rows($qnote);
$note_kd = nosql($rnote['kd']);
$note_not = balikin($rnote['note']);

//jumlah komentar
$qinosx = mysql_query("SELECT * FROM user_blog_note_msg ".
						"WHERE kd_user_blog_note = '$note_kd' ".
						"ORDER BY postdate ASC");
$rinosx = mysql_fetch_assoc($qinosx);
$tinosx = mysql_num_rows($qinosx);


//jika ada
if ($tnote != 0)
	{
	echo '<a name="note"></a>
	<font color="red"><em><big><strong>'.$note_not.'</strong></big></em></font>
	<br>
	[<a href="'.$filenya.'?dk=note#note" title="('.$tinosx.') Komentar">(<strong>'.$tinosx.'</strong>) Komentar</a>].
	[<a href="index.php?bk=note#note" title="Beri Komentar">Beri Komentar</a>].
	[<a href="k/note/note.php" title="Edit Note">Edit Note</a>].
	<br>';

	//jika daftar komentar
	if ($dk == "note")
		{
		//jika hapus
		if ($s == "hapus")
			{
			//nilai
			$msgkd = nosql($_REQUEST['msgkd']);

			//hapus
			mysql_query("DELETE FROM user_blog_note_msg ".
							"WHERE kd = '$msgkd'");

			//re-direct
			$ke = "$filenya?dk=note#note";
			xloc($ke);
			exit();
			}

		//jika ada
		if ($tinosx != 0)
			{
			echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr valign="top">
			<td width="50">&nbsp;</td>
			<td>';

			do
				{
				$inosx_kd = nosql($rinosx['kd']);
				$inosx_msg = balikin2($rinosx['msg']);
				$inosx_dari = nosql($rinosx['dari']);
				$inosx_postdate = $rinosx['postdate'];


				//user-nya
				$qtuse = mysql_query("SELECT m_user.*, m_user.kd AS uskd, ".
										"user_blog.* ".
										"FROM m_user, user_blog ".
										"WHERE user_blog.kd_user = m_user.kd ".
										"AND m_user.kd = '$inosx_dari'");
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

				echo '<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr valign="top">
				<td width="50" valign="top">
				<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
				<img src="'.$nilz_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
				</a>
				</td>
				<td valign="top">
				<em>'.$inosx_msg.'. <br>
				[Oleh : <strong><a href="p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
				['.$inosx_postdate.'].</em>
				[<a href="'.$filenya.'?dk=note&s=hapus&msgkd='.$inosx_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
				<br><br>
				</td>
				</tr>
				</table>
				<br>';
				}
			while ($rinosx = mysql_fetch_assoc($qinosx));

			echo '</td>
			</tr>
			</table>';
			}

		//jika belum ada komentar
		else
			{
			echo '<font color="violet"><strong>BELUM ADA KOMENTAR.</strong></font>';
			}
		}



	//jika beri komentar
	else if ($bk == "note")
		{
		//jika batal
		if ($_POST['btnBTL'])
			{
			//re-direct
			$ke = "$filenya?dk=note#note";
			xloc($ke);
			exit();
			}


		//jika simpan
		if ($_POST['btnSMP'])
			{
			//nilai
			$kd_note = nosql($_POST['kd_note']);
			$bk_note = cegah($_POST['bk_note']);

			//query
			mysql_query("INSERT INTO user_blog_note_msg(kd, kd_user_blog_note, dari, msg, postdate) VALUES ".
							"('$x', '$kd_note', '$kd1_session', '$bk_note', '$today')");

			//re-direct
			$ke = "$filenya?dk=note#note";
			xloc($ke);
			exit();
			}


		//view
		echo '<br>
		<textarea name="bk_note" cols="50" rows="5" wrap="virtual"></textarea>
		<br>
		<input name="bk" type="hidden" value="'.$bk.'">
		<input name="kd_note" type="hidden" value="'.$note_kd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">';
		}
	}
else
	{
	echo '<font color="red"><strong>BELUM ADA NOTE.</strong></font>
	<br>
	[<a href="k/note/note.php" title="Edit Note">Edit Note</a>].';
	}


echo '</td>
</tr>
</table>
<br>';


//query data profil /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qdt = mysql_query("SELECT DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
						"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
						"DATE_FORMAT(tgl_lahir, '%Y') AS lthn, ".
						"user_blog.* ".
						"FROM user_blog ".
						"WHERE kd_user = '$kd1_session'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_tmp_lahir = balikin($rdt['tmp_lahir']);
$dt_tgl = nosql($rdt['ltgl']);
$dt_bln = nosql($rdt['lbln']);
$dt_thn = nosql($rdt['lthn']);
$dt_foto_path = $rdt['foto_path'];
$dt_alamat = balikin($rdt['alamat']);
$dt_email = balikin($rdt['email']);
$dt_situs = balikin($rdt['situs']);
$dt_telp = balikin($rdt['telp']);
$dt_agama = balikin($rdt['agama']);
$dt_hobi = balikin($rdt['hobi']);
$dt_aktivitas = balikin($rdt['aktivitas']);
$dt_tertarik = balikin($rdt['tertarik']);
$dt_makanan = balikin($rdt['makanan']);
$dt_minuman = balikin($rdt['minuman']);
$dt_musik = balikin($rdt['musik']);
$dt_film = balikin($rdt['film']);
$dt_buku = balikin($rdt['buku']);
$dt_idola = balikin($rdt['idola']);
$dt_pend_akhir = balikin($rdt['pend_akhir']);
$dt_pend_thnlulus = balikin($rdt['pend_thnlulus']);
$dt_moto = balikin($rdt['moto']);
$dt_kata_mutiara = balikin($rdt['kata_mutiara']);

//jika tgl lahir empty
if (($dt_tgl == "00") OR ($dt_bln == "00") OR ($dt_thn == "0000"))
	{
	$dt_tgl_lahir = "-";
	}
else
	{
	$dt_tgl_lahir = "$dt_tgl $arrbln1[$dt_bln] $dt_thn";
	}



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

echo '<img src="'.$nil_foto.'" alt="'.$nm1_session.'" width="195" height="300" border="5">
<br>
<p align="center">
[<a href="k/profil/profil.php" title="Edit Profil">EDIT Profil</a>]
</p>
</td>

<td>
<p>
<strong>TTL : </strong>
<br>
'.$dt_tmp_lahir.', '.$dt_tgl_lahir.'
</p>

<p>
<strong>Alamat :</strong>
<br>
'.$dt_alamat.'
</p>

<p>
<strong>E-Mail :</strong>
<br>
'.$dt_email.'
</p>

<p>
<strong>Situs/Blog :</strong>
<br>
http://'.$dt_situs.'
</p>

<p>
<strong>Telp/HP :</strong>
<br>
'.$dt_telp.'
</p>


<p>
<strong>Hobi :</strong>
<br>
'.$dt_hobi.'
</p>


<p>
<strong>TagLine/Moto :</strong>
<br>
'.$dt_moto.'
</p>

<p>
<strong>Kata Mutiara :</strong>
<br>
'.$dt_kata_mutiara.'
</p>
</td>
</tr>
</table>
<br>
<br>
<br>';

echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td width="80%">
<br>';

//message//query ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$m_p = new Pager();
$m_limit = 10;
$m_start = $m_p->findStart($m_limit);

$m_sqlcount = "SELECT * FROM user_blog_msg ".
					"WHERE untuk = '$kd1_session' ".
					"ORDER BY postdate DESC";
$m_sqlresult = $m_sqlcount;

$m_count = mysql_num_rows(mysql_query($m_sqlcount));
$m_pages = $m_p->findPages($m_count, $m_limit);
$m_result = mysql_query("$m_sqlresult LIMIT ".$m_start.", ".$m_limit);
$m_pagelist = $m_p->pageList($_GET['page'], $m_pages, $m_target);
$m_data = mysql_fetch_array($m_result);

//nek ada
if ($m_count != 0)
	{
	echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$dt_kd = nosql($m_data['kd']);
		$dt_msg = balikin($m_data['msg']);
		$dt_userkd = nosql($m_data['kd_user']);
		$dt_postdate = $m_data['postdate'];

		//dari
		$qerk = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$dt_userkd'");
		$rerk= mysql_fetch_assoc($qerk);
		$erk_nisp = nosql($rerk['nomor']);
		$erk_nama = balikin($rerk['nama']);
		$erk_tipe = balikin($rerk['tipe']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">
		<em>'.$dt_msg.'</em>
		<br>
		[<em>Dari :
		<a href="p/index.php?uskd='.$dt_userkd.'" title="('.$erk_tipe.'). '.$erk_nisp.'. '.$erk_nama.'"><strong>('.$erk_tipe.'). '.$erk_nisp.'. '.$erk_nama.'</strong></a>].
		[<em>'.$dt_postdate.'</em>].
		[<em><a href="k/msg/msg_post.php?s=tulis&userkd='.$dt_userkd.'" title="Reply ke : '.$erk_nama.'">REPLY</a></em>].
		</td>
		</tr>';
  		}
	while ($m_data = mysql_fetch_assoc($m_result));

	echo '</table>';
	}
else
	{
	echo '<font color="red"><strong>TIDAK ADA MESSAGE.</strong></font>';
	}

echo '<br>
[<a href="k/msg/msg.php" title="EDIT Message">EDIT Message</a>]
<hr>
<br>
<br>';


//query artikel /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$a_p = new Pager();
$a_limit = 10;
$a_start = $a_p->findStart($a_limit);

$a_sqlcount = "SELECT * FROM user_blog_artikel ".
					"WHERE kd_user = '$kd1_session' ".
					"ORDER BY postdate DESC";
$a_sqlresult = $a_sqlcount;

$a_count = mysql_num_rows(mysql_query($a_sqlcount));
$a_pages = $a_p->findPages($a_count, $a_limit);
$a_result = mysql_query("$a_sqlresult LIMIT ".$a_start.", ".$a_limit);
$a_pagelist = $a_p->pageList($_GET['page'], $a_pages, $a_target);
$a_data = mysql_fetch_array($a_result);

//nek ada
if ($a_count != 0)
	{
	echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$dt_kd = nosql($a_data['kd']);
		$dt_katkd = nosql($a_data['kd_kategori']);
		$dt_judul = balikin($a_data['judul']);
		$dt_rangkuman = balikin($a_data['rangkuman']);
		$dt_postdate = $a_data['postdate'];

		//kategori
		$qkat = mysql_query("SELECT * FROM user_blog_kategori ".
								"WHERE kd = '$dt_katkd'");
		$rkat = mysql_fetch_assoc($qkat);
		$kat_kategori = balikin($rkat['kategori']);

		//jml komentar
		$qjko = mysql_query("SELECT * FROM user_blog_artikel_msg ".
								"WHERE kd_user_blog_artikel = '$dt_kd' ".
								"ORDER BY postdate ASC");
		$rjko = mysql_fetch_assoc($qjko);
		$tjko = mysql_num_rows($qjko);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">
		<br>
		<a name="'.$dt_kd.'"></a>
		<big><strong>'.$dt_judul.'</strong></big>
		<br>
		<em>'.$dt_rangkuman.'</em>
		<br>
		[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
		[<em>'.$dt_postdate.'</em>].
		[<a href="'.$filenya.'?s=view&artkd='.$dt_kd.'#'.$dt_kd.'" title="('.$tjko.') Komentar">(<strong>'.$tjko.'</strong>) Komentar</a>].
		[<a href="'.$filenya.'?bk=artikel&artkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>].
		[<a href="k/artikel/artikel_view.php?artkd='.$dt_kd.'" title="'.$dt_judul.'">...SELENGKAPNYA</a>].
		<br>';

		//jika view
		if (($s == "view") AND ($artkd == $dt_kd))
			{
			//jika hapus
			if ($a == "hapus")
				{
				//hapus
				mysql_query("DELETE FROM user_blog_artikel_msg ".
									"WHERE kd_user_blog_artikel = '$artkd' ".
									"AND kd = '$msgkd'");

				//re-direct
				$ke = "$filenya?s=view&artkd=$dt_kd#$dt_kd";
				xloc($ke);
				exit();
				}



			//jika ada
			if ($tjko != 0)
				{
				echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr valign="top">
				<td width="50">&nbsp;</td>
				<td>';

				do
					{
					$itusx_kd = nosql($rjko['kd']);
					$itusx_msg = balikin2($rjko['msg']);
					$itusx_dari = nosql($rjko['dari']);
					$itusx_postdate = $rjko['postdate'];

					//user-nya
					$qtuse = mysql_query("SELECT m_user.*, m_user.kd AS uskd, ".
											"user_blog.* ".
											"FROM m_user, user_blog ".
											"WHERE user_blog.kd_user = m_user.kd ".
											"AND m_user.kd = '$itusx_dari'");
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

					echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="3" cellpadding="0">
					<tr valign="top">
					<td width="50" valign="top">
					<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
					<img src="'.$nilz_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
					</a>
					</td>
					<td valign="top">
					<em>'.$itusx_msg.'. <br>
					[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
					['.$itusx_postdate.'].</em>
					[<a href="'.$filenya.'?s=view&artkd='.$dt_kd.'&a=hapus&msgkd='.$itusx_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
					<br><br>
					</td>
					</tr>
					</table>
					<br>';
					}
				while ($rjko = mysql_fetch_assoc($qjko));

				echo '</td>
				</tr>
				</table>';
				}

			//jika tidak ada msg
			else
				{
				echo '<br>
				<font color="red"><strong>TIDAK ADA KOMENTAR</strong></font>';
				}
			}

		//jika beri komentar
		else if (($bk == "artikel") AND ($artkd == $dt_kd))
			{
			//jika batal
			if ($_POST['btnBTL'])
				{
				//nilai
				$artkd = nosql($_POST['artkd']);

				//re-direct
				$ke = "$filenya?s=view&artkd=$artkd#$artkd";
				xloc($ke);
				exit();
				}


			//jika simpan
			if ($_POST['btnSMP'])
				{
				//nilai
				$bk_artikel = cegah($_POST['bk_artikel']);
				$artkd = nosql($_POST['artkd']);

				//query
				mysql_query("INSERT INTO user_blog_artikel_msg(kd, kd_user_blog_artikel, dari, msg, postdate) VALUES ".
								"('$x', '$artkd', '$kd1_session', '$bk_artikel', '$today')");

				//re-direct
				$ke = "$filenya?s=view&artkd=$artkd#$artkd";
				xloc($ke);
				exit();
				}


			//view
			echo '<br>
			<textarea name="bk_artikel" cols="50" rows="5" wrap="virtual"></textarea>
			<br>
			<input name="artkd" type="hidden" value="'.$artkd.'">
			<input name="bk" type="hidden" value="'.$bk.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}

		echo '<br>
		</td>
		</tr>';
  		}
	while ($a_data = mysql_fetch_assoc($a_result));

	echo '</table>';
	}
else
	{
	echo '<font color="red"><strong>TIDAK ADA ARTIKEL.</strong></font>';
	}


echo '<br>
[<a href="k/artikel/artikel.php" title="EDIT Artikel">EDIT Artikel</a>]
<hr>
<br>
<br>';



//query jurnal //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$j_p = new Pager();
$j_limit = 10;
$j_start = $j_p->findStart($j_limit);

$j_sqlcount = "SELECT * FROM user_blog_jurnal ".
					"WHERE kd_user = '$kd1_session' ".
					"ORDER BY postdate DESC";
$j_sqlresult = $j_sqlcount;

$j_count = mysql_num_rows(mysql_query($j_sqlcount));
$j_pages = $j_p->findPages($j_count, $j_limit);
$j_result = mysql_query("$j_sqlresult LIMIT ".$j_start.", ".$j_limit);
$j_pagelist = $j_p->pageList($_GET['page'], $j_pages, $j_target);
$j_data = mysql_fetch_array($j_result);

//nek ada
if ($j_count != 0)
	{
	echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$dt_kd = nosql($j_data['kd']);
		$dt_katkd = nosql($j_data['kd_kategori']);
		$dt_judul = balikin($j_data['judul']);
		$dt_rangkuman = balikin($j_data['rangkuman']);
		$dt_postdate = $j_data['postdate'];

		//kategori
		$qkat = mysql_query("SELECT * FROM user_blog_kategori ".
								"WHERE kd = '$dt_katkd'");
		$rkat = mysql_fetch_assoc($qkat);
		$kat_kategori = balikin($rkat['kategori']);

		//jml komentar
		$qjko = mysql_query("SELECT * FROM user_blog_jurnal_msg ".
								"WHERE kd_user_blog_jurnal = '$dt_kd' ".
								"ORDER BY postdate ASC");
		$rjko = mysql_fetch_assoc($qjko);
		$tjko = mysql_num_rows($qjko);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">
		<a name="'.$dt_kd.'"></a>
		<big><strong>'.$dt_judul.'</strong></big>
		<br>
		<em>'.$dt_rangkuman.'</em>
		<br>
		[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
		[<em>'.$dt_postdate.'</em>].
		[<a href="'.$filenya.'?s=view&jurkd='.$dt_kd.'#'.$dt_kd.'" title="('.$tjko.') Komentar">(<strong>'.$tjko.'</strong>) Komentar</a>].
		[<a href="'.$filenya.'?bk=jurnal&jurkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>].
		[<a href="k/jurnal/jurnal_view.php?jurkd='.$dt_kd.'" title="'.$dt_judul.'">...SELENGKAPNYA</a>].
		<br>';

		//jika view
		if (($s == "view") AND ($jurkd == $dt_kd))
			{
			//jika hapus
			if ($a == "hapus")
				{
				//hapus
				mysql_query("DELETE FROM user_blog_jurnal_msg ".
									"WHERE kd_user_blog_jurnal = '$jurkd' ".
									"AND kd = '$msgkd'");

				//re-direct
				$ke = "$filenya?s=view&jurkd=$dt_kd#$dt_kd";
				xloc($ke);
				exit();
				}


			//jika ada
			if ($tjko != 0)
				{
				echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr valign="top">
				<td width="50">&nbsp;</td>
				<td>';

				do
					{
					$itusx_kd = nosql($rjko['kd']);
					$itusx_msg = balikin2($rjko['msg']);
					$itusx_dari = nosql($rjko['dari']);
					$itusx_postdate = $rjko['postdate'];

					//user-nya
					$qtuse = mysql_query("SELECT m_user.*, m_user.kd AS uskd, ".
											"user_blog.* ".
											"FROM m_user, user_blog ".
											"WHERE user_blog.kd_user = m_user.kd ".
											"AND m_user.kd = '$itusx_dari'");
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

					echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="3" cellpadding="0">
					<tr valign="top">
					<td width="50" valign="top">
					<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
					<img src="'.$nilz_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
					</a>
					</td>
					<td valign="top">
					<em>'.$itusx_msg.'. <br>
					[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
					['.$itusx_postdate.'].</em>
					[<a href="'.$filenya.'?s=view&jurkd='.$dt_kd.'&a=hapus&msgkd='.$itusx_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
					<br><br>
					</td>
					</tr>
					</table>
					<br>';
					}
				while ($rjko = mysql_fetch_assoc($qjko));

				echo '</td>
				</tr>
				</table>';
				}

			//jika tidak ada msg
			else
				{
				echo '<br>
				<font color="red"><strong>TIDAK ADA KOMENTAR</strong></font>';
				}
			}

		//jika beri komentar
		else if (($bk == "jurnal") AND ($jurkd == $dt_kd))
			{
			//jika batal
			if ($_POST['btnBTL'])
				{
				//nilai
				$jurkd = nosql($_POST['jurkd']);

				//re-direct
				$ke = "$filenya?s=view&jurkd=$jurkd#$jurkd";
				xloc($ke);
				exit();
				}


			//jika simpan
			if ($_POST['btnSMP'])
				{
				//nilai
				$bk_jurnal = cegah($_POST['bk_jurnal']);
				$jurkd = nosql($_POST['jurkd']);

				//query
				mysql_query("INSERT INTO user_blog_jurnal_msg(kd, kd_user_blog_jurnal, dari, msg, postdate) VALUES ".
								"('$x', '$jurkd', '$kd1_session', '$bk_jurnal', '$today')");

				//re-direct
				$ke = "$filenya?s=view&jurkd=$jurkd#$jurkd";
				xloc($ke);
				exit();
				}


			//view
			echo '<br>
			<textarea name="bk_jurnal" cols="50" rows="5" wrap="virtual"></textarea>
			<br>
			<input name="jurkd" type="hidden" value="'.$jurkd.'">
			<input name="bk" type="hidden" value="'.$bk.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}

		echo '<br>
		</td>
		</tr>';
  		}
	while ($j_data = mysql_fetch_assoc($j_result));

	echo '</table>';
	}
else
	{
	echo '<font color="red"><strong>TIDAK ADA JURNAL.</strong></font>';
	}


echo '<br>
[<a href="k/jurnal/jurnal.php" title="EDIT Jurnal">EDIT Jurnal</a>]
<hr>
<br>
<br>';


//query buletin /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$b_p = new Pager();
$b_limit = 10;
$b_start = $b_p->findStart($b_limit);

$b_sqlcount = "SELECT * FROM user_blog_buletin ".
					"WHERE kd_user = '$kd1_session' ".
					"ORDER BY postdate DESC";
$b_sqlresult = $b_sqlcount;

$b_count = mysql_num_rows(mysql_query($b_sqlcount));
$b_pages = $b_p->findPages($b_count, $b_limit);
$b_result = mysql_query("$b_sqlresult LIMIT ".$b_start.", ".$b_limit);
$b_pagelist = $b_p->pageList($_GET['page'], $b_pages, $b_target);
$b_data = mysql_fetch_array($b_result);

//nek ada
if ($b_count != 0)
	{
	echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$dt_kd = nosql($b_data['kd']);
		$dt_katkd = nosql($b_data['kd_kategori']);
		$dt_judul = balikin($b_data['judul']);
		$dt_rangkuman = balikin($b_data['rangkuman']);
		$dt_postdate = $b_data['postdate'];

		//kategori
		$qkat = mysql_query("SELECT * FROM user_blog_kategori ".
								"WHERE kd = '$dt_katkd'");
		$rkat = mysql_fetch_assoc($qkat);
		$kat_kategori = balikin($rkat['kategori']);

		//jml komentar
		$qjko = mysql_query("SELECT * FROM user_blog_buletin_msg ".
								"WHERE kd_user_blog_buletin = '$dt_kd' ".
								"ORDER BY postdate ASC");
		$rjko = mysql_fetch_assoc($qjko);
		$tjko = mysql_num_rows($qjko);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">
		<a name="'.$dt_kd.'"></a>
		<big><strong>'.$dt_judul.'</strong></big>
		<br>
		<em>'.$dt_rangkuman.'</em>
		<br>
		[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
		[<em>'.$dt_postdate.'</em>].
		[<a href="'.$filenya.'?s=view&bulkd='.$dt_kd.'#'.$dt_kd.'" title="('.$tjko.') Komentar">(<strong>'.$tjko.'</strong>) Komentar</a>].
		[<a href="'.$filenya.'?bk=buletin&bulkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>].
		[<a href="k/buletin/buletin_view.php?bulkd='.$dt_kd.'" title="'.$dt_judul.'">...SELENGKAPNYA</a>]
		<br>';

		//jika view
		if (($s == "view") AND ($bulkd == $dt_kd))
			{
			//jika hapus
			if ($a == "hapus")
				{
				//hapus
				mysql_query("DELETE FROM user_blog_buletin_msg ".
									"WHERE kd_user_blog_buletin = '$bulkd' ".
									"AND kd = '$msgkd'");

				//re-direct
				$ke = "$filenya?s=view&bulkd=$dt_kd#$dt_kd";
				xloc($ke);
				exit();
				}


			//jika ada
			if ($tjko != 0)
				{
				echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr valign="top">
				<td width="50">&nbsp;</td>
				<td>';

				do
					{
					$itusx_kd = nosql($rjko['kd']);
					$itusx_msg = balikin2($rjko['msg']);
					$itusx_dari = nosql($rjko['dari']);
					$itusx_postdate = $rjko['postdate'];


					//user-nya
					$qtuse = mysql_query("SELECT m_user.*, m_user.kd AS uskd, ".
											"user_blog.* ".
											"FROM m_user, user_blog ".
											"WHERE user_blog.kd_user = m_user.kd ".
											"AND m_user.kd = '$itusx_dari'");
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

					echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="3" cellpadding="0">
					<tr valign="top">
					<td width="50" valign="top">
					<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
					<img src="'.$nilz_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
					</a>
					</td>
					<td valign="top">
					<em>'.$itusx_msg.'. <br>
					[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
					['.$itusx_postdate.'].</em>
					[<a href="'.$filenya.'?s=view&bulkd='.$dt_kd.'&a=hapus&msgkd='.$itusx_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
					<br><br>
					</td>
					</tr>
					</table>
					<br>';
					}
				while ($rjko = mysql_fetch_assoc($qjko));

				echo '</td>
				</tr>
				</table>';
				}

			//jika tidak ada msg
			else
				{
				echo '<br>
				<font color="red"><strong>TIDAK ADA KOMENTAR</strong></font>';
				}
			}

		//jika beri komentar
		else if (($bk == "buletin") AND ($bulkd == $dt_kd))
			{
			//jika batal
			if ($_POST['btnBTL'])
				{
				//nilai
				$bulkd = nosql($_POST['bulkd']);

				//re-direct
				$ke = "$filenya?s=view&bulkd=$bulkd#$bulkd";
				xloc($ke);
				exit();
				}


			//jika simpan
			if ($_POST['btnSMP'])
				{
				//nilai
				$bk_buletin = cegah($_POST['bk_buletin']);
				$bulkd = nosql($_POST['bulkd']);

				//query
				mysql_query("INSERT INTO user_blog_buletin_msg(kd, kd_user_blog_buletin, dari, msg, postdate) VALUES ".
								"('$x', '$bulkd', '$kd1_session', '$bk_buletin', '$today')");

				//re-direct
				$ke = "$filenya?s=view&bulkd=$bulkd#$bulkd";
				xloc($ke);
				exit();
				}


			//view
			echo '<br>
			<textarea name="bk_buletin" cols="50" rows="5" wrap="virtual"></textarea>
			<br>
			<input name="bulkd" type="hidden" value="'.$bulkd.'">
			<input name="bk" type="hidden" value="'.$bk.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}

		echo '<br>
		</td>
		</tr>';
  		}
	while ($b_data = mysql_fetch_assoc($b_result));

	echo '</table>';
	}
else
	{
	echo '<font color="red"><strong>TIDAK ADA BULETIN.</strong></font>';
	}


echo '<br>
[<a href="k/buletin/buletin.php" title="EDIT Buletin">EDIT Buletin</a>]
<hr>
<br>
<br>


</td>


<td>
<hr>
<big><strong>Temanku...</strong></big>
(<a href="k/temanku/temanku.php" title="Lihat Daftar Teman">Semua</a>)
<br>';

//temanku //query ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$t_p = new Pager();
$t_limit = 10;
$t_start = $t_p->findStart($t_limit);

$t_sqlcount = "SELECT m_user.*, m_user.kd AS uskd, user_blog_teman.* ".
					"FROM m_user, user_blog_teman ".
					"WHERE user_blog_teman.kd_user_teman = m_user.kd ".
					"AND user_blog_teman.kd_user = '$kd1_session' ".
					"ORDER BY rand()";
$t_sqlresult = $t_sqlcount;

$t_count = mysql_num_rows(mysql_query($t_sqlcount));
$t_pages = $t_p->findPages($t_count, $t_limit);
$t_result = mysql_query("$t_sqlresult LIMIT ".$t_start.", ".$t_limit);
$t_pagelist = $t_p->pageList($_GET['page'], $t_pages, $t_target);
$t_data = mysql_fetch_array($t_result);


//nek ada
if ($t_count != 0)
	{
	echo '<table width="200" border="0" cellpadding="3" cellspacing="0">';

	do
  		{
		$kd = nosql($t_data['uskd']);
		$nisp = nosql($t_data['nomor']);
		$nama = balikin($t_data['nama']);
		$tipe = balikin($t_data['tipe']);

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
		</table>';
  		}
	while ($t_data = mysql_fetch_assoc($t_result));

	echo '</table>';
	}
else
	{
	echo '<font color="red"><strong>BELUM PUNYA TEMAN.</strong></font>';
	}

echo '<br>
[<a href="k/temanku/temanku.php" title="EDIT Temanku">EDIT Temanku</a>]
<hr>
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
[<a href="k/kategori/kategori.php" title="EDIT Kategori">EDIT Kategori</a>]
<hr>
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
[<a href="k/link/link.php" title="EDIT Link">EDIT Link</a>]
<hr>
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

		echo '* <a href="k/album/album_detail.php?alkd='.$bum_kd.'" title="'.$bum_judul.' ['.$tjfo.' Foto].">'.$bum_judul.' <br> [<font color="red"><strong>'.$tjfo.'</strong></font> Foto].</a>
		<br><br>';
		}
	while ($rbum = mysql_fetch_assoc($qbum));
	}
else
	{
	echo '<font color="red"><strong>BELUM ADA ALBUM FOTO.</strong></font>';
	}

echo '<br>
[<a href="k/album/album.php" title="EDIT Album Foto">EDIT Album Foto</a>]
<hr>

</td>
</tr>
</table>


<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
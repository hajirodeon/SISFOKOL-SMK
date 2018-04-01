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
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/janissari.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/janissari.html");


nocache;

//nilai
$filenya = "index.php";
$s = nosql($_REQUEST['s']);
$bk = nosql($_REQUEST['bk']);
$dk = nosql($_REQUEST['dk']);
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
$judul = "Halaman : $tem_no.$tem_nama [$tem_tipe]";
$judulku = $judul;




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jadikan teman
if ($s == "add")
	{
	//cek jadikan teman /////////////////////////////////////////////////////////////////////////////////
	$qtem = mysql_query("SELECT * FROM user_blog_teman ".
							"WHERE kd_user = '$kd1_session' ".
							"AND kd_user_teman = '$uskd'");
	$rtem = mysql_fetch_assoc($qtem);
	$ttem = mysql_num_rows($qtem);

	//nek blm ada
	if ($ttem == 0)
		{
		//query jadikan teman
		mysql_query("INSERT INTO user_blog_teman(kd, kd_user, kd_user_teman, postdate) VALUES ".
						"('$x', '$kd1_session', '$uskd', '$today')");
		}
	/////////////////////////////////////////////////////////////////////////////////////////////////////



	//query jadikan temanya /////////////////////////////////////////////////////////////////////////////
	$qtemx = mysql_query("SELECT * FROM user_blog_teman ".
							"WHERE kd_user = '$uskd' ".
							"AND kd_user_teman = '$kd1_session'");
	$rtemx = mysql_fetch_assoc($qtemx);
	$ttemx = mysql_num_rows($qtemx);

	//nek blm ada
	if ($ttemx == 0)
		{
		mysql_query("INSERT INTO user_blog_teman(kd, kd_user, kd_user_teman, postdate) VALUES ".
						"('$x', '$uskd', '$kd1_session', '$today')");
		}
	/////////////////////////////////////////////////////////////////////////////////////////////////////


	//re-direct
	$ke = "index.php?uskd=$uskd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/janissari.php");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E9FFBB" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td>';

//query data profil /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qdt = mysql_query("SELECT DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
						"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
						"DATE_FORMAT(tgl_lahir, '%Y') AS lthn, ".
						"user_blog.* ".
						"FROM user_blog ".
						"WHERE kd_user = '$uskd'");
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
<tr valign="top">
<td bgcolor="#D0E51F" width="200" align="center">';

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
[<a href="profil/profil.php?uskd='.$uskd.'" title="...SELENGKAPNYA">...SELENGKAPNYA</a>].
<br>
<br>

[<a href="'.$sumber.'/janissari/p/status/status.php?uskd='.$uskd.'" title="...Statusnya">...Statusnya</a>].
<br>

[<a href="'.$sumber.'/janissari/p/note/note.php?uskd='.$uskd.'" title="...Note-nya">...Note-nya</a>].
<br>

[<a href="'.$sumber.'/janissari/p/msg/msg.php?uskd='.$uskd.'" title="...Kirim Message">...Kirim Message</a>].
<br><br>';

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
		echo '[<a href="'.$filenya.'?s=add&uskd='.$uskd.'" title="Jadikan Temanku...!"><strong>Jadikan Temanku...!</strong></a>].';
		}
	}

echo '</td>

<td>
<p>
<font color="green">
<big><strong>'.$tem_no.'. '.$tem_nama.' ['.$tem_tipe.']</strong></big>
</font>
</p>

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
<br>';


//status ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#C2E4C5" valign="top">
<td>';


$qtus = mysql_query("SELECT * FROM user_blog_status ".
						"WHERE kd_user = '$uskd' ".
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
	<font color="white"><em><big><strong>'.$tus_status.'</strong></big></em></font>
	<br>
	[<a href="'.$filenya.'?uskd='.$uskd.'&dk=status#status" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
	[<a href="index.php?uskd='.$uskd.'&bk=status#status" title="Beri Komentar">Beri Komentar</a>].
	[<a href="status/status.php?uskd='.$uskd.'" title="...Status Lainnya">...Status Lainnya</a>].
	<br>';

	//jika daftar komentar
	if ($dk == "status")
		{
		//jika ada
		if ($titusx != 0)
			{
			echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr valign="top">
			<td width="50">&nbsp;</td>
			<td>';

			do
				{
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

				echo '<table bgcolor="#E9FFBB" width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr valign="top">
				<td width="50" valign="top">
				<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
				<img src="'.$nilz_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
				</a>
				</td>
				<td valign="top">
				<em>'.$itusx_msg.'. <br>
				[Oleh : <strong><a href="'.$filenya.'?uskd='.$tuse_kd.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
				['.$itusx_postdate.'].</em>
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
			echo '<font color="blue"><strong>BELUM ADA KOMENTAR.</strong></font>';
			}
		}



	//jika beri komentar
	else if ($bk == "status")
		{
		//jika batal
		if ($_POST['btnBTL'])
			{
			//nilai
			$uskd = nosql($_POST['uskd']);

			//re-direct
			$ke = "$filenya?uskd=$uskd&dk=status#status";
			xloc($ke);
			exit();
			}


		//jika simpan
		if ($_POST['btnSMP'])
			{
			//nilai
			$kd_status = nosql($_POST['kd_status']);
			$bk_status = cegah($_POST['bk_status']);
			$uskd = nosql($_POST['uskd']);

			//query
			mysql_query("INSERT INTO user_blog_status_msg(kd, kd_user_blog_status, dari, msg, postdate) VALUES ".
							"('$x', '$kd_status', '$kd1_session', '$bk_status', '$today')");

			//re-direct
			$ke = "$filenya?uskd=$uskd&dk=status#status";
			xloc($ke);
			exit();
			}


		//view
		echo '<br>
		<textarea name="bk_status" cols="50" rows="5" wrap="virtual"></textarea>
		<br>
		<input name="bk" type="hidden" value="'.$bk.'">
		<input name="kd_status" type="hidden" value="'.$tus_kd.'">
		<input name="uskd" type="hidden" value="'.$uskd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">';
		}
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA STATUS.</strong></font>';
	}

echo '</td>
</tr>
</table>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#BFDFB7" valign="top">
<td>';

//note //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qnote = mysql_query("SELECT * FROM user_blog_note ".
						"WHERE kd_user = '$uskd' ".
						"ORDER BY postdate DESC");
$rnote = mysql_fetch_assoc($qnote);
$tnote = mysql_num_rows($qnote);
$note_kd = nosql($rnote['kd']);
$note_not = balikin($rnote['note']);


//jumlah komentar
$qinox = mysql_query("SELECT * FROM user_blog_note_msg ".
						"WHERE kd_user_blog_note = '$note_kd' ".
						"ORDER BY postdate ASC");
$rinox = mysql_fetch_assoc($qinox);
$tinox = mysql_num_rows($qinox);


//jika ada
if ($tnote != 0)
	{
	echo '<a name="note"></a>
	<font color="white"><em><big><strong>'.$note_not.'</strong></big></em></font>
	<br>
	[<a href="'.$filenya.'?uskd='.$uskd.'&dk=note#note" title="('.$tinox.') Komentar">(<strong>'.$tinox.'</strong>) Komentar</a>].
	[<a href="index.php?uskd='.$uskd.'&bk=note#note" title="Beri Komentar">Beri Komentar</a>].
	[<a href="note/note.php?uskd='.$uskd.'" title="...Note Lainnya">...Note Lainnya</a>].
	<br>';

	//jika daftar komentar
	if ($dk == "note")
		{
		//jika ada
		if ($tinox != 0)
			{
			echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr valign="top">
			<td width="50">&nbsp;</td>
			<td>';

			do
				{
				$inox_msg = balikin2($rinox['msg']);
				$inox_dari = nosql($rinox['dari']);
				$inox_postdate = $rinox['postdate'];

				//user-nya
				$qtuse = mysql_query("SELECT m_user.*, m_user.kd AS uskd, ".
										"user_blog.* ".
										"FROM m_user, user_blog ".
										"WHERE user_blog.kd_user = m_user.kd ".
										"AND m_user.kd = '$inox_dari'");
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

				echo '<table bgcolor="#E9FFBB" width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr valign="top">
				<td width="50" valign="top">
				<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
				<img src="'.$nilz_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
				</a>
				</td>
				<td valign="top">
				<em>'.$inox_msg.'. <br>
				[Oleh : <strong><a href="'.$filenya.'?uskd='.$tuse_kd.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
				['.$inox_postdate.'].</em>
				<br><br>
				</td>
				</tr>
				</table>
				<br>';
				}
			while ($rinox = mysql_fetch_assoc($qinox));

			echo '</td>
			</tr>
			</table>';
			}

		//jika belum ada komentar
		else
			{
			echo '<font color="blue"><strong>BELUM ADA KOMENTAR.</strong></font>';
			}
		}



	//jika beri komentar
	else if ($bk == "note")
		{
		//jika batal
		if ($_POST['btnBTL'])
			{
			//nilai
			$uskd = nosql($_POST['uskd']);

			//re-direct
			$ke = "$filenya?uskd=$uskd&dk=note#note";
			xloc($ke);
			exit();
			}


		//jika simpan
		if ($_POST['btnSMP'])
			{
			//nilai
			$kd_note = nosql($_POST['kd_note']);
			$bk_note = cegah($_POST['bk_note']);
			$uskd = nosql($_POST['uskd']);

			//query
			mysql_query("INSERT INTO user_blog_note_msg(kd, kd_user_blog_note, dari, msg, postdate) VALUES ".
							"('$x', '$kd_note', '$kd1_session', '$bk_note', '$today')");

			//re-direct
			$ke = "$filenya?uskd=$uskd&dk=note#note";
			xloc($ke);
			exit();
			}


		//view
		echo '<br>
		<textarea name="bk_note" cols="50" rows="5" wrap="virtual"></textarea>
		<br>
		<input name="bk" type="hidden" value="'.$bk.'">
		<input name="kd_note" type="hidden" value="'.$note_kd.'">
		<input name="uskd" type="hidden" value="'.$uskd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">';
		}
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA NOTE.</strong></font>';
	}

echo '</td>
</tr>
</table>
<br>';


echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td width="80%">';


//query artikel /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$a_p = new Pager();
$a_limit = 5;
$a_start = $a_p->findStart($a_limit);

$a_sqlcount = "SELECT * FROM user_blog_artikel ".
					"WHERE kd_user = '$uskd' ".
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
								"WHERE kd_user_blog_artikel = '$dt_kd'");
		$rjko = mysql_fetch_assoc($qjko);
		$tjko = mysql_num_rows($qjko);

		echo "<tr valign=\"top\" bgcolor=\"$tk_warna\" onmouseover=\"this.bgColor='$tk_warnaover';\" onmouseout=\"this.bgColor='$tk_warna';\">";
		echo '<td valign="top">
		<p>
		<big><font color="green"><strong>'.$dt_judul.'</strong></font></big>
		<br>
		<em>'.$dt_rangkuman.'</em>
		<br>
		[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
		[<em>'.$dt_postdate.'</em>].
		[(<strong>'.$tjko.'</strong>) Komentar].
		[<a href="artikel/artikel.php?uskd='.$uskd.'&artkd='.$dt_kd.'" title="'.$dt_judul.'">...SELENGKAPNYA</a>]
		</p>
		</td>
		</tr>';
  		}
	while ($a_data = mysql_fetch_assoc($a_result));

	echo '</table>';
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA ARTIKEL.</strong></font>';
	}


echo '<hr size="1">
<br>
<br>';



//query jurnal //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$j_p = new Pager();
$j_limit = 5;
$j_start = $j_p->findStart($j_limit);

$j_sqlcount = "SELECT * FROM user_blog_jurnal ".
					"WHERE kd_user = '$uskd' ".
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
								"WHERE kd_user_blog_jurnal = '$dt_kd'");
		$rjko = mysql_fetch_assoc($qjko);
		$tjko = mysql_num_rows($qjko);

		echo "<tr valign=\"top\" bgcolor=\"$tk_warna\" onmouseover=\"this.bgColor='$tk_warnaover';\" onmouseout=\"this.bgColor='$tk_warna';\">";
		echo '<td valign="top">
		<p>
		<big><font color="green"><strong>'.$dt_judul.'</strong></font></big>
		<br>
		<em>'.$dt_rangkuman.'</em>
		<br>
		[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
		[<em>'.$dt_postdate.'</em>].
		[(<strong>'.$tjko.'</strong>) Komentar].
		[<a href="jurnal/jurnal.php?uskd='.$uskd.'&jurkd='.$dt_kd.'" title="'.$dt_judul.'">...SELENGKAPNYA</a>]
		</p>
		</td>
		</tr>';
  		}
	while ($j_data = mysql_fetch_assoc($j_result));

	echo '</table>';
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA JURNAL.</strong></font>';
	}


echo '<hr size="1">
<br>
<br>';


//query buletin /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$b_p = new Pager();
$b_limit = 5;
$b_start = $b_p->findStart($b_limit);

$b_sqlcount = "SELECT * FROM user_blog_buletin ".
					"WHERE kd_user = '$uskd' ".
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
								"WHERE kd_user_blog_buletin = '$dt_kd'");
		$rjko = mysql_fetch_assoc($qjko);
		$tjko = mysql_num_rows($qjko);

		echo "<tr valign=\"top\" bgcolor=\"$tk_warna\" onmouseover=\"this.bgColor='$tk_warnaover';\" onmouseout=\"this.bgColor='$tk_warna';\">";
		echo '<td valign="top">
		<p>
		<big><font color="green"><strong>'.$dt_judul.'</strong></font></big>
		<br>
		<em>'.$dt_rangkuman.'</em>
		<br>
		[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
		[<em>'.$dt_postdate.'</em>].
		[(<strong>'.$tjko.'</strong>) Komentar].
		[<a href="buletin/buletin.php?uskd='.$uskd.'&bulkd='.$dt_kd.'" title="'.$dt_judul.'">...SELENGKAPNYA</a>]
		</p>
		</td>
		</tr>';
  		}
	while ($b_data = mysql_fetch_assoc($b_result));

	echo '</table>';
	}
else
	{
	echo '<font color="blue"><strong>BELUM ADA BULETIN.</strong></font>';
	}


echo '<hr size="1">
<br>
<br>


</td>


<td>
<hr>
<big><strong>Temannya...</strong></big>
(<a href="teman/teman.php?uskd='.$uskd.'" title="Lihat Semua Temannya">Semua</a>)
<br>';

//temannya //query //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$t_p = new Pager();
$t_limit = 10;
$t_start = $t_p->findStart($t_limit);

$t_sqlcount = "SELECT m_user.*, m_user.kd AS uskd, user_blog_teman.* ".
					"FROM m_user, user_blog_teman ".
					"WHERE user_blog_teman.kd_user_teman = m_user.kd ".
					"AND user_blog_teman.kd_user = '$uskd' ".
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

		<table bgcolor="#B4E7BA" width="100%" border="0" cellspacing="3" cellpadding="0">
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
	echo '<font color="blue"><strong>BELUM PUNYA TEMAN.</strong></font>';
	}

echo '<hr size="1">
<br>
<br>


<big><strong>Link Favorit...</strong></big>
<br>';

//link //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

echo '<hr size="1">
<br>
<br>

<big><strong>Album Foto...</strong></big>
<br>';

//album foto ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

echo '<hr size="1">

</td>

</tr>
</table>


<br>
<br>
<br>

</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
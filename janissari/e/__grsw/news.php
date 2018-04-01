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





session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/class/paging.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_gr.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$gmkd = nosql($_REQUEST['gmkd']);
$grsw = nosql($_REQUEST['grsw']);
$bk = nosql($_REQUEST['bk']);
$artkd = nosql($_REQUEST['artkd']);
$msgkd = nosql($_REQUEST['msgkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//isi *START
ob_start();

//js
require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");


//view : siswa //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		$filenya = "news.php?gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm] --> News";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e_grsw.php");

		//daftar news
		echo '<table width="950" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td width="100">
		<p>
		<big><strong>:::News...</strong></big>
		</p>';

		//jika lihat ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($s == "detail")
			{
			//nilai
			//query
			$qdt = mysql_query("SELECT guru_mapel.*, guru_mapel_news.*, guru_mapel_news.kd AS nkd ".
									"FROM guru_mapel, guru_mapel_news ".
									"WHERE guru_mapel_news.kd_guru_mapel = guru_mapel.kd ".
									"AND guru_mapel.kd = '$gmkd' ".
									"AND guru_mapel_news.kd = '$artkd'");
			$rdt = mysql_fetch_assoc($qdt);
			$dt_judul = balikin($rdt['judul']);
			$dt_rangkuman = balikin($rdt['rangkuman']);
			$dt_isi = balikin($rdt['isi']);
			$dt_katkd = nosql($rdt['kd_kategori']);


			//daftar kategori
			$qkat = mysql_query("SELECT * FROM user_blog_kategori ".
									"WHERE kd_user = '$kd1_session' ".
									"ORDER BY kategori ASC");
			$rkat = mysql_fetch_assoc($qkat);

			//kat terpilih
			$qkatx = mysql_query("SELECT * FROM user_blog_kategori ".
									"WHERE kd_user = '$kd1_session' ".
									"AND kd = '$dt_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$katx_kd = nosql($rkatx['kd']);
			$katx_kat = balikin($rkatx['kategori']);

			//view
			echo '<p>
			<big>
			<strong>'.$dt_judul.'</strong>
			</big>
			</p>

			<p>
			'.$dt_isi.'
			</p>

			<br><br>
			<p>
			<hr size="1">';



			//daftar komentar ////////////////////////////////////////////////////////
			$qdko = mysql_query("SELECT * FROM guru_mapel_news_msg ".
									"WHERE kd_guru_mapel_news = '$artkd' ".
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
					<br><br>
					</td>
					</tr>
					</table>
					<br>';
					}
				while ($rdko = mysql_fetch_assoc($qdko));
				}


			//simpan komentar ////////////////////////////////////////////////////////////////////
			if ($_POST['btnSMPy'])
				{
				//nilai
				$artkd = nosql($_POST['artkd']);
				$e = nosql($_POST['e']);
				$bk_news = cegah($_POST['bk_news']);
				$page = nosql($_POST['page']);

				//insert
				mysql_query("INSERT INTO guru_mapel_news_msg(kd, kd_guru_mapel_news, dari, msg, postdate) VALUES ".
								"('$x', '$artkd', '$kd1_session', '$bk_news', '$today')");

				//re-direct
				$ke = "$filenya&s=detail&artkd=$artkd&page=$page";
				xloc($ke);
				exit();
				}
			////////////////////////////////////////////////////////////////////////////////////////

			echo '</p>
			<br>
			<br>

			<p>
			Beri Komentar :
			<br>
			<textarea name="bk_news" cols="50" rows="5" wrap="virtual"></textarea>
			<br>
			<input name="artkd" type="hidden" value="'.$artkd.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="btnSMPy" type="submit" value="SIMPAN">
			<input name="btnBTL" type="reset" value="BATAL">
			</p>

			<br>
			<br>
			<br>
			<hr size="1">
			<big><strong>News Lainnya...</strong></big>
			<br>';

			//query
			$a_p = new Pager();
			$a_limit = 10;
			$a_start = $a_p->findStart($a_limit);

			$a_sqlcount = "SELECT * FROM guru_mapel_news ".
								"WHERE kd_guru_mapel = '$gmkd' ".
								"AND kd <> '$artkd' ".
								"ORDER BY postdate DESC";
			$a_sqlresult = $a_sqlcount;

			$a_count = mysql_num_rows(mysql_query($a_sqlcount));
			$a_pages = $a_p->findPages($a_count, $a_limit);
			$a_result = mysql_query("$a_sqlresult LIMIT ".$a_start.", ".$a_limit);
			$a_target = "$filenya&s=detail&artkd=$artkd";
			$a_pagelist = $a_p->pageList($_GET['page'], $a_pages, $a_target);
			$a_data = mysql_fetch_array($a_result);

			//jika ada
			if ($a_count != 0)
				{
				echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

				do
			  		{
					$dt_kd = nosql($a_data['kd']);
					$dt_katkd = nosql($a_data['kd_kategori']);
					$dt_judul = balikin($a_data['judul']);
					$dt_postdate = $a_data['postdate'];

					//kategori
					$qkat = mysql_query("SELECT * FROM guru_mapel_kategori ".
											"WHERE kd_guru_mapel = '$gmkd' ".
											"AND kd = '$dt_katkd'");
					$rkat = mysql_fetch_assoc($qkat);
					$kat_kategori = balikin($rkat['kategori']);

					//jml komentar
					$qjko = mysql_query("SELECT * FROM guru_mapel_news_msg ".
											"WHERE kd_guru_mapel_news = '$dt_kd'");
					$rjko = mysql_fetch_assoc($qjko);
					$tjko = mysql_num_rows($qjko);

					echo "<tr valign=\"top\" bgcolor=\"$tk_warna\" onmouseover=\"this.bgColor='$tk_warnaover';\" onmouseout=\"this.bgColor='$tk_warna';\">";
					echo '<td valign="top">
					<UL>
					<LI>
					<strong>'.$dt_judul.'</strong>
					<br>
					[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
					[<em>'.$dt_postdate.'</em>].
					[(<strong>'.$tjko.'</strong>) Komentar].
					[<a href="'.$filenya.'&s=detail&artkd='.$dt_kd.'&page='.$page.'" title="'.$dt_judul.'">...SELENGKAPNYA</a>]
					</LI>
					</UL>
					</td>
					</tr>';
			  		}
				while ($a_data = mysql_fetch_assoc($a_result));

				echo '</table>
				'.$a_pagelist.'';
				}
			else
				{
				echo '<font color="blue"><strong>BELUM ADA News LAINNYA.</strong></font>';
				}

			echo '<br>
			<br>
			<br>';
			}




		//jika lihat daftar ////////////////////////////////////////////////////////////////////////////////////////////////////////
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT guru_mapel.*, guru_mapel_news.*, guru_mapel_news.kd AS nkd ".
							"FROM guru_mapel, guru_mapel_news ".
							"WHERE guru_mapel_news.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd = '$gmkd' ".
							"ORDER BY guru_mapel_news.postdate DESC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = $filenya;
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);

			//nek ada
			if ($count != 0)
				{
				echo '<table width="950" border="0" cellpadding="3" cellspacing="0">';

				do
			  		{
					$nomer = $nomer + 1;

					$dt_kd = nosql($data['kd']);
					$dt_katkd = nosql($data['kd_kategori']);
					$dt_judul = balikin($data['judul']);
					$dt_rangkuman = balikin($data['rangkuman']);
					$dt_postdate = $data['postdate'];

					//kategori
					$qkat = mysql_query("SELECT * FROM user_blog_kategori ".
											"WHERE kd = '$dt_katkd'");
					$rkat = mysql_fetch_assoc($qkat);
					$kat_kategori = balikin($rkat['kategori']);

					//jumlah komentar
					$qitusx = mysql_query("SELECT * FROM guru_mapel_news_msg ".
												"WHERE kd_guru_mapel_news = '$dt_kd' ".
												"ORDER BY postdate ASC");
					$ritusx = mysql_fetch_assoc($qitusx);
					$titusx = mysql_num_rows($qitusx);

					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td valign="top">
					<br>
					<a name="'.$dt_kd.'"></a>
					<big><strong>'.$dt_judul.'</strong></big>
					<br>
					<em>'.$dt_rangkuman.'</em>
					<br>
					<br>
					[<a href="'.$filenya.'&s=detail&artkd='.$dt_kd.'" title="Selengkapnya..."><em>SELENGKAPNYA...</em></a>].
					[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
					[<em>'.$dt_postdate.'</em>].
					[<a href="'.$filenya.'&page='.$page.'&s=view&artkd='.$dt_kd.'#'.$dt_kd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
					[<a href="'.$filenya.'&page='.$page.'&bk=news&artkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>].';

					//jika view
					if (($s == "view") AND ($artkd == $dt_kd))
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

								echo '<table bgcolor="#EFF4FA" width="100%" border="0" cellspacing="3" cellpadding="0">
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

						//jika tidak ada msg
						else
							{
							echo '<br>
							<font color="blue"><strong>TIDAK ADA KOMENTAR</strong></font>';
							}
						}

					//jika beri komentar
					else if (($bk == "news") AND ($artkd == $dt_kd))
						{
						//jika batal
						if ($_POST['btnBTL'])
							{
							//nilai
							$artkd = nosql($_POST['artkd']);
							$page = nosql($_POST['page']);

							//re-direct
							$ke = "$filenya&page=$page&s=view&artkd=$artkd#$artkd";
							xloc($ke);
							exit();
							}


						//jika simpan
						if ($_POST['btnSMPx'])
							{
							//nilai
							$bk_news = cegah($_POST['bk_news']);
							$artkd = nosql($_POST['artkd']);
							$page = nosql($_POST['page']);

							//query
							mysql_query("INSERT INTO guru_mapel_news_msg(kd, kd_guru_mapel_news, dari, msg, postdate) VALUES ".
											"('$x', '$artkd', '$kd1_session', '$bk_news', '$today')");

							//re-direct
							$ke = "$filenya&page=$page&s=view&artkd=$artkd#$artkd";
							xloc($ke);
							exit();
							}


						//view
						echo '<br>
						<textarea name="bk_news" cols="50" rows="5" wrap="virtual"></textarea>
						<br>
						<input name="artkd" type="hidden" value="'.$artkd.'">
						<input name="bk" type="hidden" value="'.$bk.'">
						<input name="page" type="hidden" value="'.$page.'">
						<input name="btnSMPx" type="submit" value="SIMPAN">
						<input name="btnBTL" type="submit" value="BATAL">';
						}

					echo '</td>
					</tr>';
			  		}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="950" border="0" cellspacing="0" cellpadding="3">
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
				echo '<font color="blue"><strong>TIDAK ADA News. </strong></font>';
				}

			echo '<br><br><br>
			</td>
			</tr>
			</table>';
			}
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
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
require("../../../inc/cek/e_gr.php");
require("../../../inc/class/paging.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$gmkd = nosql($_REQUEST['gmkd']);
$bk = nosql($_REQUEST['bk']);
$artkd = nosql($_REQUEST['artkd']);
$msgkd = nosql($_REQUEST['msgkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

//focus
if (($s == "baru") OR ($s == "edit"))
	{
	$diload = "document.formx.kategorix.focus();";
	}

else if ($bk == "news")
	{
	$diload = "document.formx.bk_news.focus();";
	}




//proses : GURU /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//bikin folder
//jika baru
if ($s == "baru")
	{
	//nilai
	$path1 = "../../../filebox/e/news/$artkd";

	//cek, sudah ada belum
	if (!file_exists($path1))
		{
		mkdir("$path1", $chmod);
		}
	}



//jika hapus
if (($s == "hapus") AND (!empty($artkd)))
	{
	//nilai
	$page = nosql($_REQUEST['page']);

	//del data
	mysql_query("DELETE FROM guru_mapel_news ".
					"WHERE kd = '$artkd'");


	//query
	$qcc = mysql_query("SELECT * FROM guru_mapel_news_filebox ".
							"WHERE kd_guru_mapel_news = '$artkd'");
	$rcc = mysql_fetch_assoc($qcc);

	do
		{
		//hapus file
		$cc_filex = $rcc['filex'];
		$path1 = "../../../filebox/e/news/$artkd/$cc_filex";
		unlink ($path1);
		}
	while ($rcc = mysql_fetch_assoc($qcc));

	//hapus query
	mysql_query("DELETE FROM guru_mapel_news_filebox ".
					"WHERE kd_guru_mapel_news = '$artkd'");

	//nek $artkd gak null
	if (!empty($artkd))
		{
		//hapus folder
		$path2 = "../../../filebox/e/news/$artkd";
		delete ($path2);
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$filenya = "news.php?gmkd=$gmkd";
	xloc($filenya);
	exit();
	}



//batal
if ($_POST['btnBTLx'])
	{
	//re-direct
	$filenya = "news.php?gmkd=$gmkd";
	xloc($filenya);
	exit();
	}



//nek simpan
if ($_POST['btnSMPx'])
	{
	//nilai
	$filenya = "news.php?gmkd=$gmkd";
	$s = nosql($_POST['s']);
	$artkd = nosql($_POST['artkd']);
	$kategorix = nosql($_POST['kategorix']);
	$judulx = cegah($_POST['judulx']);
	$rangkumanx = cegah2($_POST['rangkumanx']);
	$isix = cegah2($_POST['editor']);

	//cek null
	if ((empty($kategorix)) OR (empty($judulx)) OR (empty($rangkumanx)) OR (empty($isix)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya&s=baru&artkd=$artkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//nek baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysql_query("SELECT guru_mapel.*, guru_mapel_news.*, guru_mapel_news.kd AS nkd ".
									"FROM guru_mapel, guru_mapel_news ".
									"WHERE guru_mapel_news.kd_guru_mapel = guru_mapel.kd ".
									"AND guru_mapel.kd_user = '$kd1_session' ".
									"AND guru_mapel.kd = '$gmkd' ".
									"AND guru_mapel_news.kd_kategori = '$kategorix' ".
									"AND guru_mapel_news.judul = '$judulx'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "News Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya&s=baru";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert
				mysql_query("INSERT INTO guru_mapel_news(kd, kd_guru_mapel, kd_kategori, judul, rangkuman, isi, postdate) VALUES ".
								"('$artkd', '$gmkd', '$kategorix', '$judulx', '$rangkumanx', '$isix', '$today')");

				//re-direct
				xloc($$filenya);
				exit();
				}
			}

		//nek edit
		if ($s == "edit")
			{
			//update
			mysql_query("UPDATE guru_mapel_news SET kd_kategori = '$kategorix', ".
							"judul = '$judulx', ".
							"rangkuman = '$rangkumanx', ".
							"isi = '$isix' ".
							"WHERE kd_guru_mapel = '$gmkd' ".
							"AND kd = '$artkd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}
//proses : GURU /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();


?>



<script type="text/javascript" src="<?php echo $sumber;?>/inc/class/ckeditor/ckeditor.js"></script>



<?php

//js
require("../../../inc/js/swap.js");
require("../../../inc/js/openwindow.js");
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
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.* ".
							"FROM guru_mapel, m_mapel ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);


	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "news.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> News";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e.php");

		//daftar news
		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td>
		<p>
		<big><strong>:::News...</strong></big>
		[<a href="'.$filenya.'&s=baru&artkd='.$x.'" title="Entry Baru">Entry Baru</a>]
		</p>';

		//jika baru atau edit //////////////////////////////////////////////////////////////////////////
		if (($s == "edit") OR ($s == "baru"))
			{
			//nilai
			//query
			$qdt = mysql_query("SELECT guru_mapel.*, guru_mapel_news.*, guru_mapel_news.kd AS nkd ".
									"FROM guru_mapel, guru_mapel_news ".
									"WHERE guru_mapel_news.kd_guru_mapel = guru_mapel.kd ".
									"AND guru_mapel.kd_user = '$kd1_session' ".
									"AND guru_mapel.kd = '$gmkd' ".
									"AND guru_mapel_news.kd = '$artkd'");
			$rdt = mysql_fetch_assoc($qdt);
			$dt_judul = balikin($rdt['judul']);
			$dt_rangkuman = pathasli2(balikin($rdt['rangkuman']));
			$dt_isi = pathasli2(balikin($rdt['isi']));
			$dt_katkd = nosql($rdt['kd_kategori']);

			//daftar kategori
			$qkat = mysql_query("SELECT * FROM guru_mapel_kategori ".
									"WHERE kd_guru_mapel = '$gmkd' ".
									"ORDER BY kategori ASC");
			$rkat = mysql_fetch_assoc($qkat);

			//kat terpilih
			$qkatx = mysql_query("SELECT * FROM guru_mapel_kategori ".
									"WHERE kd_guru_mapel = '$gmkd' ".
									"AND kd = '$dt_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$katx_kd = nosql($rkatx['kd']);
			$katx_kat = balikin($rkatx['kategori']);

			//view
			echo '<strong>Kategori :</strong>
			<br>
			<select name="kategorix">
			<option value="'.$katx_kd.'" selected>'.$katx_kat.'</option>';

			do
				{
				//nilai
				$kat_kd = nosql($rkat['kd']);
				$kat_kat = balikin($rkat['kategori']);

				echo '<option value="'.$kat_kd.'">'.$kat_kat.'</option>';
				}
			while ($rkat = mysql_fetch_assoc($qkat));

			echo '</select>
			</p>

			<p>
			<strong>Judul :</strong>
			<br>
			<input name="judulx" type="text" value="'.$dt_judul.'" size="50">
			</p>

			<p>
			<strong>Rangkuman : </strong>
			<br>
			<textarea name="rangkumanx" cols="50" rows="5" wrap="virtual">'.$dt_rangkuman.'</textarea>
			</p>

			<p>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td>
			<strong>Isi News : </strong>
			</td>
			<td align="right">
			<input name="btnUPL" type="button" value="FileBox Image >>"OnClick="javascript:MM_openBrWindow(\'news_filebox.php?artkd='.$artkd.'\',\'FileBOX Image (.jpg) :\',\'width=650,height=300,toolbar=no,menubar=no,location=no,scrollbars=yes,resize=no\')">
			</td>
			</tr>
			</table>

			<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$dt_isi.'</textarea>
			</p>

			<p>
			<input name="s" type="hidden" value="'.$s.'">
			<input name="artkd" type="hidden" value="'.$artkd.'">
			<input name="btnSMPx" type="submit" value="SIMPAN">
			<input name="btnBTLx" type="submit" value="BATAL">
			</p>';
			
			?>
			<script type="text/javascript">
			//<![CDATA[
			var roxyFileman = '<?php echo $sumber;?>/inc/class/ckeditor/plugins/fileman/index.html';
			 
			$(function(){
		    CKEDITOR.replace( 'editor',{filebrowserBrowseUrl:roxyFileman,
		                         filebrowserImageBrowseUrl:roxyFileman+'?type=image',
		                         removeDialogTabs: 'link:upload;image:upload'}); 
			});
		
		
			//]]>
			</script>
			
			<?php
			}

		//jika daftar //////////////////////////////////////////////////////////////////////////////////
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT guru_mapel.*, guru_mapel_news.*, guru_mapel_news.kd AS nkd ".
							"FROM guru_mapel, guru_mapel_news ".
							"WHERE guru_mapel_news.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
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
					$qkat = mysql_query("SELECT * FROM guru_mapel_kategori ".
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
					[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
					[<em>'.$dt_postdate.'</em>].
					[<a href="'.$filenya.'&page='.$page.'&s=view&artkd='.$dt_kd.'#'.$dt_kd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
					[<a href="'.$filenya.'&page='.$page.'&bk=news&artkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>].
					[<a href="'.$filenya.'&s=edit&artkd='.$dt_kd.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>].
					[<a href="'.$filenya.'&s=hapus&artkd='.$dt_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].';

					//jika view
					if (($s == "view") AND ($artkd == $dt_kd))
						{
						//jika hapus
						if ($a == "hapus")
							{
							//hapus
							mysql_query("DELETE FROM guru_mapel_news_msg ".
											"WHERE kd_guru_mapel_news = '$artkd' ".
											"AND kd = '$msgkd'");

							//re-direct
							$ke = "$filenya&page=$page&s=view&artkd=$dt_kd#$dt_kd";
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

								echo '<table bgcolor="'.$e_warna02.'" width="100%" border="0" cellspacing="3" cellpadding="0">
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
								[<a href="'.$filenya.'&page='.$page.'&s=view&artkd='.$dt_kd.'&a=hapus&msgkd='.$itusx_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
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
						if ($_POST['btnSMP'])
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
						<input name="btnSMP" type="submit" value="SIMPAN">
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
				<font color="blue"><strong>'.$count.'</strong></font> Data '.$pagelist.'
				<hr>
				</td>
			    </tr>
				</table>';
				}
			else
				{
				echo '<font color="blue"><strong>TIDAK ADA News. Silahkan Entry Dahulu...!!</strong></font>';
				}

			echo '</td>
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
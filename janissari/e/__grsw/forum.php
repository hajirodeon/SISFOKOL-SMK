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
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_gr.php");
require("../../../inc/class/paging.php");
require("../../../inc/class/pagingx.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$stkd = nosql($_REQUEST['stkd']);
$bk = nosql($_REQUEST['bk']);
$msgkd = nosql($_REQUEST['msgkd']);
$gmkd = nosql($_REQUEST['gmkd']);
$grsw = nosql($_REQUEST['grsw']);
$filenya = "forum.php?gmkd=$gmkd";
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

//focus...
if (empty($bk))
	{
	$diload = "document.formx.topik.focus();";
	}

//beri komentar...
else if ($bk == "topik")
	{
	$diload = "document.formx.bk_topik.focus();";
	}


//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';



//isi *START
ob_start();

require("../../../inc/js/swap.js");
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
		$filenya = "forum.php?gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm] --> Forum";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e_grsw.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td>
		<p>
		<big><strong>:::Forum...</strong></big>
		</p>
		</td>
  		</tr>
		</table>';

		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT guru_mapel.*, guru_mapel_forum.*, guru_mapel_forum.kd AS fkd ".
						"FROM guru_mapel, guru_mapel_forum ".
						"WHERE guru_mapel_forum.kd_guru_mapel = guru_mapel.kd ".
						"AND guru_mapel.kd = '$gmkd' ".
						"ORDER BY guru_mapel_forum.postdate DESC";
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

				$i_fkd = nosql($data['fkd']);
				$i_topik = balikin($data['topik']);
				$i_postdate = $data['postdate'];

				//jumlah komentar
				$qitusx = mysql_query("SELECT * FROM guru_mapel_forum_msg ".
											"WHERE kd_guru_mapel_forum = '$i_fkd' ".
											"ORDER BY postdate ASC");
				$ritusx = mysql_fetch_assoc($qitusx);
				$titusx = mysql_num_rows($qitusx);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td valign="top">
				<br>
				<a name="'.$i_fkd.'"></a>
				<big><strong>'.$i_topik.'</strong></big>
				<br>
				[<em>'.$i_postdate.'</em>].
				[<a href="'.$filenya.'&page='.$page.'&s=view&stkd='.$i_fkd.'#'.$i_fkd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
				[<a href="'.$filenya.'&page='.$page.'&bk=topik&stkd='.$i_fkd.'#'.$i_fkd.'" title="Beri Komentar">Beri Komentar</a>].';

				//jika view
				if (($s == "view") AND ($stkd == $i_fkd))
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
				else if (($bk == "topik") AND ($stkd == $i_fkd))
					{
					//jika batal
					if ($_POST['btnBTL'])
						{
						//nilai
						$stkd = nosql($_POST['stkd']);
						$page = nosql($_POST['page']);
						$gmkd = nosql($_POST['gmkd']);


						//re-direct
						$ke = "$filenya&page=$page&s=view&stkd=$stkd#$stkd";
						xloc($ke);
						exit();
						}


					//jika simpan
					if ($_POST['btnSMP1'])
						{
						//nilai
						$bk_topik = cegah($_POST['bk_topik']);
						$stkd = nosql($_POST['stkd']);
						$page = nosql($_POST['page']);
						$gmkd = nosql($_POST['gmkd']);

						//query
						mysql_query("INSERT INTO guru_mapel_forum_msg(kd, kd_guru_mapel_forum, dari, msg, postdate) VALUES ".
											"('$x', '$stkd', '$kd1_session', '$bk_topik', '$today')");

						//re-direct
						$ke = "$filenya&page=$page&s=view&stkd=$stkd#$stkd";
						xloc($ke);
						exit();
						}


					//view
					echo '<br>
					<textarea name="bk_topik" cols="50" rows="5" wrap="virtual"></textarea>
					<br>
					<input name="stkd" type="hidden" value="'.$stkd.'">
					<input name="bk" type="hidden" value="'.$bk.'">
					<input name="page" type="hidden" value="'.$page.'">
					<input name="gmkd" type="hidden" value="'.$gmkd.'">
					<input name="btnSMP1" type="submit" value="SIMPAN">
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
			<hr size="1">
			<font color="blue"><strong>'.$count.'</strong></font> Data '.$pagelist.'
			<hr size="1">
			</td>
		    </tr>
			</table>';
			}
		else
			{
			echo '<font color="blue"><strong>Belum Ada Topik Forum. Silahkan Entry Dahulu...!!</strong></font>';
			}

		echo '<br><br><br>
		</td>
		</tr>
		</table>';
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
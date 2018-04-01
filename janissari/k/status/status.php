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
$filenya = "status.php";
$judul = "Status";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$juduli = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$stkd = nosql($_REQUEST['stkd']);
$bk = nosql($_REQUEST['bk']);
$msgkd = nosql($_REQUEST['msgkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


//focus...
if (empty($bk))
	{
	$diload = "document.formx.d_status.focus();";
	}

else if ($bk == "status")
	{
	$diload = "document.formx.bk_status.focus();";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if (($s == "hapus") AND (!empty($stkd)))
	{
	//hapus status
	mysql_query("DELETE FROM user_blog_status ".
					"WHERE kd_user = '$kd1_session' ".
					"AND kd = '$stkd'");

	//hapus msg
	mysql_query("DELETE FROM user_blog_status_msg ".
					"WHERE kd_user_blog_status = '$stkd'");

	//re-direct
	xloc($filenya);
	exit();
	}





//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//nek simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$d_status = cegah2($_POST['d_status']);

	//cek
	if (empty($d_status))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		mysql_query("INSERT INTO user_blog_status(kd, kd_user, status, postdate) VALUES ".
						"('$x', '$kd1_session', '$d_status', '$today')");

		//re-direct
		xloc($filenya);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();




require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="#FDF0DE" valign="top">
<td>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td>';
xheadline($judul);

echo ' (<a href="'.$filenya.'?s=baru" title="Tulis Baru">Tulis Baru</a>)</td>
</tr>
</table>';


//nek baru //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($s == "baru")
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td>
	<textarea name="d_status" cols="50" rows="5" wrap="virtual"></textarea>
	<br>

	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</td>
	</tr>
	</table>
	<br>
	<br>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM user_blog_status ".
					"WHERE kd_user = '$kd1_session' ".
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

			$i_kd = nosql($data['kd']);
			$i_status = balikin($data['status']);
			$i_postdate = $data['postdate'];

			//jumlah komentar
			$qitusx = mysql_query("SELECT * FROM user_blog_status_msg ".
										"WHERE kd_user_blog_status = '$i_kd' ".
										"ORDER BY postdate ASC");
			$ritusx = mysql_fetch_assoc($qitusx);
			$titusx = mysql_num_rows($qitusx);

			echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='#FDF0DE';\">";
			echo '<td valign="top">
			<br>
			<a name="'.$i_kd.'"></a>
			<big><strong>'.$i_status.'</strong></big>
			<br>
			[<em>'.$i_postdate.'</em>].
			[<a href="'.$filenya.'?page='.$page.'&s=view&stkd='.$i_kd.'#'.$i_kd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
			[<a href="'.$filenya.'?page='.$page.'&bk=status&stkd='.$i_kd.'#'.$i_kd.'" title="Beri Komentar">Beri Komentar</a>].
			[<a href="'.$filenya.'?page='.$page.'&s=hapus&stkd='.$i_kd.'" title="HAPUS"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].';

			//jika view
			if (($s == "view") AND ($stkd == $i_kd))
				{
				//jika hapus
				if ($a == "hapus")
					{
					//hapus
					mysql_query("DELETE FROM user_blog_status_msg ".
										"WHERE kd_user_blog_status = '$stkd' ".
										"AND kd = '$msgkd'");

					//re-direct
					$ke = "$filenya?page=$page&s=view&stkd=$i_kd#$i_kd";
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
						[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
						['.$itusx_postdate.'].</em>
						[<a href="'.$filenya.'?page='.$page.'&s=view&stkd='.$i_kd.'&a=hapus&msgkd='.$itusx_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
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
					<font color="red"><strong>TIDAK ADA KOMENTAR</strong></font>';
					}
				}


			//jika beri komentar
			else if (($bk == "status") AND ($stkd == $i_kd))
				{
				//jika batal
				if ($_POST['btnBTL'])
					{
					//nilai
					$stkd = nosql($_POST['stkd']);
					$page = nosql($_POST['page']);

					//re-direct
					$ke = "$filenya?page=$page&s=view&stkd=$stkd#$stkd";
					xloc($ke);
					exit();
					}


				//jika simpan
				if ($_POST['btnSMP1'])
					{
					//nilai
					$bk_status = cegah($_POST['bk_status']);
					$stkd = nosql($_POST['stkd']);
					$page = nosql($_POST['page']);

					//query
					mysql_query("INSERT INTO user_blog_status_msg(kd, kd_user_blog_status, dari, msg, postdate) VALUES ".
									"('$x', '$stkd', '$kd1_session', '$bk_status', '$today')");

					//re-direct
					$ke = "$filenya?page=$page&s=view&stkd=$stkd#$stkd";
					xloc($ke);
					exit();
					}


				//view
				echo '<br>
				<textarea name="bk_status" cols="50" rows="5" wrap="virtual"></textarea>
				<br>
				<input name="stkd" type="hidden" value="'.$stkd.'">
				<input name="bk" type="hidden" value="'.$bk.'">
				<input name="page" type="hidden" value="'.$page.'">
				<input name="btnSMP1" type="submit" value="SIMPAN">
				<input name="btnBTL" type="submit" value="BATAL">';
				}

			echo '</td>
			</tr>';
	  		}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
	    	<tr>
		<td align="right">
		<hr size="1">
		<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
		<hr size="1">
		</td>
	    	</tr>
		</table>';
		}
	else
		{
		echo '<font color="red"><strong>BELUM ADA STATUS. Silahkan Entry Dahulu...!!</strong></font>';
		}
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
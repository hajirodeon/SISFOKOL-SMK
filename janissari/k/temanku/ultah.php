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
$filenya = "ultah.php";
$judul = "Ulang Tahun Temanku";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$juduli = $judul;
$blnx = nosql($_REQUEST['blnx']);
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$bk = nosql($_REQUEST['bk']);
$stkd = nosql($_REQUEST['stkd']);
$msgkd = nosql($_REQUEST['msgkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//focus
if (empty($blnx))
	{
	$diload = "document.formx.bln.focus();";
	}

else if ($bk == "status")
	{
	$diload = "document.formx.bk_status.focus();";
	}


//isi *START
ob_start();



require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FDF0DE" valign="top">
<td>

<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td width="80%">';
//judul
xheadline($judul);

echo '<br>
Bulan : ';
echo "<select name=\"bln\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$blnx.'">'.$arrbln1[$blnx].'</option>';

//looping bulan
for ($i=1;$i<=12;$i++)
	{
	//cek
	if (strlen($i) == 1)
		{
		$i = "0$i";
		}
	else
		{
		$i = $i;
		}

	echo '<option value="'.$filenya.'?blnx='.$i.'">'.$arrbln1[$i].'</option>';
	}

echo '</select>

<br>';



//jika belum pilih bulan
if (empty($blnx))
	{
	echo '<font color="red"><strong>Bulan BELUM DIPILIH...!!</strong></font>';
	}
else
	{
	//query view
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_user.*, m_user.kd AS uskd, user_blog.*, ".
					"DATE_FORMAT(user_blog.tgl_lahir, '%d') AS tgl, ".
					"user_blog_teman.* ".
					"FROM m_user, user_blog, user_blog_teman ".
					"WHERE user_blog.kd_user = m_user.kd ".
					"AND user_blog_teman.kd_user_teman = m_user.kd ".
					"AND user_blog_teman.kd_user = '$kd1_session' ".
					"AND DATE_FORMAT(user_blog.tgl_lahir, '%m') = '$blnx' ".
					"ORDER BY round(tgl) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?blnx=$blnx";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	//nek ada
	if ($count != 0)
		{
		echo '<br>
		<table width="100%" border="0" cellpadding="3" cellspacing="0">';

		do
	  		{
			$nomer = $nomer + 1;

			$dt_kd = nosql($data['uskd']);
			$dt_uskd = nosql($data['kd_user']);
			$dt_no = nosql($data['nomor']);
			$dt_tipe = nosql($data['tipe']);
			$dt_nm = balikin($data['nama']);
			$dt_tgl = nosql($data['tgl']);

			//status
			$qstx = mysql_query("SELECT * FROM user_blog_status ".
									"WHERE kd_user = '$dt_kd' ".
									"ORDER BY postdate DESC");
			$rstx = mysql_fetch_assoc($qstx);
			$tstx = mysql_num_rows($qstx);
			$stx_kd = nosql($rstx['kd']);
			$stx_status = balikin($rstx['status']);
			$stx_postdate = $rstx['postdate'];

			//nek null
			if ($tstx != 0)
				{
				$stx_status = balikin($rstx['status']);
				}
			else
				{
				$stx_status = "-";
				}


			//query foto path
			$qdtx = mysql_query("SELECT * FROM user_blog ".
									"WHERE kd_user = '$dt_kd'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$tdtx = mysql_num_rows($qdtx);
			$dtx_foto_path = $rdtx['foto_path'];


			//jumlah komentar
			$qitusx = mysql_query("SELECT * FROM user_blog_status_msg ".
										"WHERE kd_user_blog_status = '$stx_kd' ".
										"ORDER BY postdate ASC");
			$ritusx = mysql_fetch_assoc($qitusx);
			$titusx = mysql_num_rows($qitusx);


			echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='#FDF0DE';\">";
			echo '<td width="1" valign="top">
			<p>';

			//nek null foto
			if (empty($dtx_foto_path))
				{
				$nil_foto = "$sumber/img/foto_blank.jpg";
				}
			else
				{
				//gawe mini thumnail
				$nil_foto = "$sumber/filebox/profil/$dt_kd/thumb_$dtx_foto_path";
				}


			echo '<a href="'.$sumber.'/janissari/p/index.php?uskd='.$dt_kd.'" title="('.$dt_tipe.'). '.$dt_no.'. '.$dt_nm.'">
			<img src="'.$nil_foto.'" alt="'.$dt_nm.'" width="50" height="75" border="1">
			</a>
			</p>
			</td>
			<td valign="top">
			<p>
			Tanggal : <font color="red"><strong>'.$dt_tgl.'</strong></font>
			<br>
			<a name="'.$stx_kd.'"></a>
			<big><strong>'.$stx_status.'</strong></big>
			<br>
			[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$dt_kd.'" title="('.$dt_tipe.'). '.$dt_no.'. '.$dt_nm.'">('.$dt_tipe.'). '.$dt_no.'. '.$dt_nm.'</a></strong>].
			<br>';

			//jika belum ada status
			if ($stx_status == "-")
				{
				echo '<font color="red"><strong>BELUM ADA STATUS.</strong></font>';
				}
			else
				{
				echo '[<a href="'.$filenya.'?blnx='.$blnx.'&page='.$page.'&s=view&stkd='.$stx_kd.'#'.$stx_kd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
				[<a href="'.$filenya.'?blnx='.$blnx.'&page='.$page.'&bk=status&stkd='.$stx_kd.'#'.$stx_kd.'" title="Beri Komentar">Beri Komentar</a>]. ';

				//jika view
				if (($s == "view") AND ($stkd == $stx_kd))
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
								$nilx_foto = "$sumber/img/foto_blank.jpg";
								}
							else
								{
								//gawe mini thumnail
								$nilx_foto = "$sumber/filebox/profil/$tuse_kd/thumb_$tuse_foto_path";
								}

							echo '<table bgcolor="#FDF0DE" width="100%" border="0" cellspacing="3" cellpadding="0">
							<tr valign="top">
							<td width="50" valign="top">
							<a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">
							<img src="'.$nilx_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
							</a>
							</td>
							<td valign="top">
							<em>'.$itusx_msg.'. <br>
							[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
							<br>
							['.$itusx_postdate.'].</em>
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
				else if (($bk == "status") AND ($stkd == $stx_kd))
					{
					//jika batal
					if ($_POST['btnBTL'])
						{
						//nilai
						$stkd = nosql($_POST['stkd']);
						$page = nosql($_POST['page']);
						$blnx = nosql($_POST['blnx']);

						//re-direct
						$ke = "$filenya?blnx=$blnx&page=$page&s=view&stkd=$stkd#$stkd";
						xloc($ke);
						exit();
						}


					//jika simpan
					if ($_POST['btnSMP'])
						{
						//nilai
						$bk_status = cegah($_POST['bk_status']);
						$stkd = nosql($_POST['stkd']);
						$page = nosql($_POST['page']);
						$blnx = nosql($_POST['blnx']);

						//query
						mysql_query("INSERT INTO user_blog_status_msg(kd, kd_user_blog_status, dari, msg, postdate) VALUES ".
										"('$x', '$stkd', '$kd1_session', '$bk_status', '$today')");

						//re-direct
						$ke = "$filenya?blnx=$blnx&page=$page&s=view&stkd=$stkd#$stkd";
						xloc($ke);
						exit();
						}


					//view
					echo '<br>
					<textarea name="bk_status" cols="50" rows="5" wrap="virtual"></textarea>
					<br>
					<input name="stkd" type="hidden" value="'.$stkd.'">
					<input name="bk" type="hidden" value="'.$bk.'">
					<input name="blnx" type="hidden" value="'.$blnx.'">
					<input name="btnSMP" type="submit" value="SIMPAN">
					<input name="btnBTL" type="submit" value="BATAL">';
					}

				echo '</p>
				</td>
				</tr>';
				}
	  		}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
	    	<tr>
		<td align="right">
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="page" type="hidden" value="'.$page.'">
		<input name="total" type="hidden" value="'.$count.'">
		<hr>
		<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
		<hr>
		</td>
	    	</tr>
		</table>';
		}
	else
		{
		echo '<br>
		<font color="red"><strong>TIDAK ADA TEMAN YANG ULTAH PADA BULAN TERSEBUT.</strong></font>';
		}
	}

echo '</td>
<td width="1%">
</td>

<td>';

//ambil sisi
require("../../../inc/menu/k_sisi.php");

echo '</td>
</tr>
</table>

<br>
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
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
$filenya = "jurnal.php";
$judul = "Jurnal Temanku";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$juduli = $judul;
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


//focus...
if ($bk == "jurnal")
	{
	$diload = "document.formx.bk_jurnal.focus();";
	}





//isi *START
ob_start();



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

//query view
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT m_user.*, user_blog_teman.*, ".
				"user_blog_jurnal.*, user_blog_jurnal.kd AS stkd ".
				"FROM m_user, user_blog_teman, user_blog_jurnal ".
				"WHERE user_blog_jurnal.kd_user = m_user.kd ".
				"AND user_blog_teman.kd_user_teman = m_user.kd ".
				"AND user_blog_teman.kd_user = '$kd1_session' ".
				"ORDER BY user_blog_jurnal.postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
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

		$dt_kd = nosql($data['stkd']);
		$dt_uskd = nosql($data['kd_user']);
		$dt_no = nosql($data['nomor']);
		$dt_tipe = nosql($data['tipe']);
		$dt_nm = balikin($data['nama']);
		$dt_judul = balikin($data['judul']);
		$dt_postdate = $data['postdate'];


		//query foto path
		$qdtx = mysql_query("SELECT * FROM user_blog ".
								"WHERE kd_user = '$dt_uskd'");
		$rdtx = mysql_fetch_assoc($qdtx);
		$tdtx = mysql_num_rows($qdtx);
		$dtx_foto_path = $rdtx['foto_path'];


		//jumlah komentar
		$qitusx = mysql_query("SELECT * FROM user_blog_jurnal_msg ".
									"WHERE kd_user_blog_jurnal = '$dt_kd' ".
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
			$nil_foto = "$sumber/filebox/profil/$dt_uskd/thumb_$dtx_foto_path";
			}


		echo '<a href="'.$sumber.'/janissari/p/index.php?uskd='.$dt_uskd.'" title="('.$dt_tipe.'). '.$dt_no.'. '.$dt_nm.'">
		<img src="'.$nil_foto.'" alt="'.$dt_nm.'" width="50" height="75" border="1">
		</a>
		</p>
		</td>
		<td valign="top">
		<p>
		<a name="'.$dt_kd.'"></a>
		<big><strong>'.$dt_judul.'</strong></big>
		<br>
		[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$dt_uskd.'" title="('.$dt_tipe.'). '.$dt_no.'. '.$dt_nm.'">('.$dt_tipe.'). '.$dt_no.'. '.$dt_nm.'</a></strong>].
		[<em>'.$dt_postdate.'</em>].
		<br>
		[<a href="'.$sumber.'/janissari/p/jurnal/jurnal.php?uskd='.$dt_uskd.'&jurkd='.$dt_kd.'" title="'.$dt_judul.'">Selengkapnya...</a>].
		[<a href="'.$filenya.'?page='.$page.'&s=view&stkd='.$dt_kd.'#'.$dt_kd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
		[<a href="'.$filenya.'?page='.$page.'&bk=jurnal&stkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>]. ';


		//jika view
		if (($s == "view") AND ($stkd == $dt_kd))
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
		else if (($bk == "jurnal") AND ($stkd == $dt_kd))
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
			if ($_POST['btnSMP'])
				{
				//nilai
				$bk_jurnal = cegah($_POST['bk_jurnal']);
				$stkd = nosql($_POST['stkd']);
				$page = nosql($_POST['page']);

				//query
				mysql_query("INSERT INTO user_blog_jurnal_msg(kd, kd_user_blog_jurnal, dari, msg, postdate) VALUES ".
								"('$x', '$stkd', '$kd1_session', '$bk_jurnal', '$today')");

				//re-direct
				$ke = "$filenya?page=$page&s=view&stkd=$stkd#$stkd";
				xloc($ke);
				exit();
				}


			//view
			echo '<br>
			<textarea name="bk_jurnal" cols="50" rows="5" wrap="virtual"></textarea>
			<br>
			<input name="stkd" type="hidden" value="'.$stkd.'">
			<input name="bk" type="hidden" value="'.$bk.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}

		echo '</p>
		</td>
		</tr>';
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
	<font color="red"><strong>TIDAK ADA DAFTAR JURNAL TEMAN.</strong></font>';
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
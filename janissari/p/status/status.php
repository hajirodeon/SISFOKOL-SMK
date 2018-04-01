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
$uskd = nosql($_REQUEST['uskd']);
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
$judul = "...Statusnya";
$judulku = "Halaman : $tem_no.$tem_nama [$tem_tipe] --> $judul";
$juduli = $judul;




//isi *START
ob_start();



require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E9FFBB" width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td width="80%">';
//judul
xheadline($judul);

//query view
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT m_user.*, user_blog_status.*, user_blog_status.kd AS stkd ".
				"FROM m_user, user_blog_status ".
				"WHERE user_blog_status.kd_user = m_user.kd ".
				"AND user_blog_status.kd_user = '$uskd' ".
				"ORDER BY user_blog_status.postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$target = "$filenya?uskd=$uskd";
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
		$dt_status = balikin($data['status']);
		$dt_postdate = $data['postdate'];

		//jumlah komentar
		$qitusx = mysql_query("SELECT * FROM user_blog_status_msg ".
									"WHERE kd_user_blog_status = '$dt_kd' ".
									"ORDER BY postdate ASC");
		$ritusx = mysql_fetch_assoc($qitusx);
		$titusx = mysql_num_rows($qitusx);

		//user_blog
		$qtuse = mysql_query("SELECT * FROM user_blog ".
								"WHERE kd_user = '$dt_uskd'");
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
			$nilx_foto = "$sumber/filebox/profil/$dt_uskd/thumb_$tuse_foto_path";
			}

		echo "<tr valign=\"top\" onmouseover=\"this.bgColor='#D0E51F';\" onmouseout=\"this.bgColor='#E9FFBB';\">";
		echo '<td valign="top">
		<table width="100%" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td width="50" valign="top">
		<a href="'.$sumber.'/janissari/p/index.php?uskd='.$uskd.'" title="'.$nisp.'. '.$nama.' ['.$tipe.']">
		<img src="'.$nilx_foto.'" align="left" alt="'.$tuse_nm.'" width="50" height="75" border="1">
		</a>
		</td>
		<td valign="top">
		<a name="'.$dt_kd.'"></a>
		<big><strong>'.$dt_status.'</strong></big>
		<br>
		[<em>'.$dt_postdate.'</em>].
		[<a href="'.$filenya.'?uskd='.$uskd.'&page='.$page.'&s=view&stkd='.$dt_kd.'#'.$dt_kd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
		[<a href="'.$filenya.'?uskd='.$uskd.'&page='.$page.'&bk=status&stkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>].';


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
				<font color="red"><strong>TIDAK ADA KOMENTAR</strong></font>';
				}
			}

		//jika beri komentar
		else if (($bk == "status") AND ($stkd == $dt_kd))
			{
			//jika batal
			if ($_POST['btnBTL'])
				{
				//nilai
				$stkd = nosql($_POST['stkd']);
				$page = nosql($_POST['page']);
				$uskd = nosql($_POST['uskd']);

				//re-direct
				$ke = "$filenya?uskd=$uskd&page=$page&s=view&stkd=$stkd#$stkd";
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
				$uskd = nosql($_POST['uskd']);

				//query
				mysql_query("INSERT INTO user_blog_status_msg(kd, kd_user_blog_status, dari, msg, postdate) VALUES ".
								"('$x', '$stkd', '$kd1_session', '$bk_status', '$today')");

				//re-direct
				$ke = "$filenya?uskd=$uskd&page=$page&s=view&stkd=$stkd#$stkd";
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
			<input name="uskd" type="hidden" value="'.$uskd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}

		echo '</td>
		</tr>
		</table>

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
	<font color="red"><strong>TIDAK ADA DAFTAR STATUS.</strong></font>';
	}

echo '</td>
<td width="1%">
</td>

<td>';

//ambil sisi
require("../../../inc/menu/p_sisi.php");

echo '<br>
<br>
<br>
</td>
</tr>
</table>';
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
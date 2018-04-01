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
$gmkd = nosql($_REQUEST['gmkd']);
$tankd = nosql($_REQUEST['tankd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$filenya = "tanya.php?gmkd=$gmkd&page=$page";



//focus...
$diload = "document.formx.jawaban.focus();";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);
	$tankd = nosql($_POST['tankd']);
	$page = nosql($_POST['page']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = $filenya;
	xloc($ke);
	exit();
	}





//jika jawab
if ($_POST['btnSMP'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);
	$tankd = nosql($_POST['tankd']);
	$s = nosql($_POST['s']);
	$jawaban = cegah2($_POST['jawaban']);
	$page = nosql($_POST['page']);

	//cek
	if (empty($jawaban))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Jawaban Belum Diberikan. Harap Diperhatikan.";
		$ke = "$filenya&s=jawab&tankd=$tankd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//update
		mysql_query("UPDATE guru_mapel_tanya SET jawaban = '$jawaban', ".
						"postdate = '$today' ".
						"WHERE kd_guru_mapel = '$gmkd' ".
						"AND kd = '$tankd'");

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$ke = $filenya;
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
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
		$filenya = "tanya.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> Tanya";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td width="100">
		<p>
		<big><strong>:::Tanya...</strong></big>
		</p>
		</td>
  		</tr>
		</table>';


		//jika jawab
		if ($s == "jawab")
			{
			//query
			$qtya = mysql_query("SELECT * FROM guru_mapel_tanya ".
									"WHERE kd_guru_mapel = '$gmkd' ".
									"AND kd = '$tankd'");
			$rtya = mysql_fetch_assoc($qtya);
			$ttya = mysql_num_rows($qtya);
			$tya_tanya = balikin($rtya['tanya']);
			$tya_jawaban = balikin($rtya['jawaban']);
			$tya_postdate = $rtya['postdate'];

			//cek
			if (empty($tya_jawaban))
				{
				$tya_jwb = "-";
				}
			else
				{
				$tya_jwb = $tya_jawaban;
				}

			echo '<font color="blue"><strong><em>'.$tya_tanya.'</em></strong></font>
			<br>
			[<em>Postdate : '.$tya_postdate.'</em>].
			<br>
			<br>

			<strong>Jawaban Sebelumnya :</strong>
			<br>
			<em>'.$tya_jwb.'</em>
			<br>
			<br>

			<strong>Jawaban :</strong>
			<br>
			<textarea name="jawaban" cols="75" rows="10" wrap="virtual"></textarea>
			<br>
			<input name="gmkd" type="hidden" value="'.$gmkd.'">
			<input name="tankd" type="hidden" value="'.$tankd.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}

		//jika daftar tanya
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT guru_mapel.*, guru_mapel_tanya.* ".
							"FROM guru_mapel, guru_mapel_tanya ".
							"WHERE guru_mapel_tanya.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel.kd = '$gmkd' ".
							"ORDER BY guru_mapel_tanya.postdate DESC";
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

					$d_kd = nosql($data['kd']);
					$d_dari = nosql($data['dari']);
					$d_tanya = balikin($data['tanya']);
					$d_jawaban = balikin($data['jawaban']);
					$d_postdate = $data['postdate'];


					//user-nya
					$qtuse = mysql_query("SELECT m_user.*, m_user.kd AS uskd, ".
								"user_blog.* ".
								"FROM m_user, user_blog ".
								"WHERE user_blog.kd_user = m_user.kd ".
								"AND m_user.kd = '$d_dari'");
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


					//cek
					if (empty($d_jawaban))
						{
						$d_jwb = "<a href=\"$filenya&tankd=$d_kd&s=jawab\">Jawaban</a>";
						}
					else
						{
						$d_jwb = "<font color=\"blue\"><strong>TELAH DIJAWAB</strong></font>. <a href=\"$filenya&tankd=$d_kd&s=jawab\">Jawab Lagi</a>";
						}

					echo "<tr valign=\"top\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
					<em>'.$d_tanya.'</em>
					<br>
					[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
					[Postdate : '.$d_postdate.'].
					['.$d_jwb.'].
					</td>
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
				echo '<font color="blue"><strong>Tidak Ada Yang Bertanya. Mungkin Lain Waktu...</strong></font>';
				}
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
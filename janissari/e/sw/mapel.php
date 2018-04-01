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
require("../../../inc/class/paging.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_sw.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$pegkd = nosql($_REQUEST['pegkd']);
$gmkd = nosql($_REQUEST['gmkd']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek simpan polling
if ($_POST['btnPOL'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);
	$s = nosql($_POST['s']);
	$v_opsi = nosql($_POST['v_opsi']);

	//cek null
	if (empty($v_opsi))
		{
		//re-direct
		$pesan = "Opsi Polling Belum Ditentukan. Harap Diperhatikan...!!";
		$ke = "mapel.php?s=detail&gmkd=$gmkd";
		pekem($pesan,$ke);
		exit();
		}

	//jika blm isi polling...
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM guru_mapel_polling ".
								"WHERE kd_guru_mapel = '$gmkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//jika ada, update...
		if ($tcc != 0)
			{
			//if...
			if ($v_opsi == "nopsi1")
				{
				$nil_opsi1x = 1;
				}
			else if ($v_opsi == "nopsi2")
				{
				$nil_opsi2x = 1;
				}
			else if ($v_opsi == "nopsi3")
				{
				$nil_opsi3x = 1;
				}
			else if ($v_opsi == "nopsi4")
				{
				$nil_opsi4x = 1;
				}
			else if ($v_opsi == "nopsi5")
				{
				$nil_opsi5x = 1;
				}


			//nilai
			$nil_opsi1 = (nosql($rcc['nil_opsi1']))+$nil_opsi1x;
			$nil_opsi2 = (nosql($rcc['nil_opsi2']))+$nil_opsi2x;
			$nil_opsi3 = (nosql($rcc['nil_opsi3']))+$nil_opsi3x;
			$nil_opsi4 = (nosql($rcc['nil_opsi4']))+$nil_opsi4x;
			$nil_opsi5 = (nosql($rcc['nil_opsi5']))+$nil_opsi5x;


			//update
			mysql_query("UPDATE guru_mapel_polling SET nil_opsi1 = '$nil_opsi1', ".
							"nil_opsi2 = '$nil_opsi2', ".
							"nil_opsi3 = '$nil_opsi3', ".
							"nil_opsi4 = '$nil_opsi4', ".
							"nil_opsi5 = '$nil_opsi5' ".
							"WHERE kd_guru_mapel = '$gmkd'");
			}

		//entry baru..
		else
			{
			//nilai
			$nil_opsi1 = nosql($rcc['nil_opsi1']);
			$nil_opsi2 = nosql($rcc['nil_opsi2']);
			$nil_opsi3 = nosql($rcc['nil_opsi3']);
			$nil_opsi4 = nosql($rcc['nil_opsi4']);
			$nil_opsi5 = nosql($rcc['nil_opsi5']);


			//insert
			mysql_query("INSERT INTO guru_mapel_polling(kd, kd_guru_mapel, nil_opsi1, nil_opsi2, nil_opsi3, nil_opsi4, nil_opsi5) VALUES ".
							"('$x', '$gmkd', '$nil_opsi1', '$nil_opsi2', '$nil_opsi3', '$nil_opsi4', '$nil_opsi5')");
			}
		}

	//re-direct
	$ke = "mapel.php?s=detail&gmkd=$gmkd";
	xloc($ke);
	exit();
	}




//nek lihat kalender...
if ($_POST['btnKAL'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);

	//cek
	if ((empty($ubln)) OR (empty($uthn)))
		{
		//re-direct
		$pesan = "Kalender yang Ingin Dilihat, Untuk Bulan dan Tahun Berapa...?";
		$ke = "mapel.php?s=detail&gmkd=$gmkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "kalender.php?gmkd=$gmkd&ubln=$ubln&uthn=$uthn";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////











//isi *START
ob_start();

require("../../../inc/js/swap.js");
require("../../../inc/js/wz_jsgraphics.js");
require("../../../inc/js/pie.js");
require("../../../inc/menu/janissari.php");



//view : siswa //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika belum pilih mapel
if (empty($s))
	{
	//nilai
	$filenya = "mapel.php";
	$judul = "E-Learning";
	$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
	$juduli = $judul;


	echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
	<tr bgcolor="#FDF0DE" valign="top">
	<td>';
	//judul
	xheadline($judul);



	//data ne
	$p = new Pager();
	$start = $p->findStart($limit);


	$sqlcount = "SELECT guru_mapel.*, guru_mapel.kd AS gmkd, ".
			"m_mapel.*, m_user.*, m_user.kd AS uskd ".
			"FROM guru_mapel, m_mapel, m_user ".
			"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
			"AND guru_mapel.kd_user = m_user.kd ".
			"ORDER BY mapel ASC";
	$sqlresult = $sqlcount;


	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	//nek gak null
	if ($count != 0)
		{
		echo '<br>
		<table width="500" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td><strong>Mata Pelajaran - Guru</strong></td>
		<td width="1">&nbsp;</td>
		</tr>';

		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}


			//nilai
			$dty_pelkd = nosql($data['gmkd']);
			$dty_uskd = nosql($data['uskd']);
			$dty_pel = balikin($data['mapel']);
			$dty_nm = balikin($data['nama']);
			$dty_no = nosql($data['nomor']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<strong>'.$dty_pel.'</strong> [<a href="'.$sumber.'/janissari/p/index.php?uskd='.$dty_uskd.'" title="'.$dty_no.'. '.$dty_nm.'">'.$dty_no.'.'.$dty_nm.'</a>].
			</td>
			<td>
			<a href="'.$filenya.'?s=detail&gmkd='.$dty_pelkd.'" title="'.$dty_pel.' ['.$dty_no.'. '.$dty_nm.']"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td align="right"><font color="red"><strong>'.$count.'</strong></font> data '.$pagelist.'</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red"><strong>TIDAK ADA DATA Mata Pelajaran untuk E-Learning. <br>
		Silahkan Hubungi Administrator.</strong></font>
		</p>';
		}

	echo '<br><br><br>';
	}

//nek mapel telah dipilih
else
	{
		/*
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
*/

	//mapel-nya...
	$qpel = mysql_query("SELECT m_mapel.*, m_pegawai.* ".
							"FROM guru_mapel, m_mapel, m_pegawai ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = m_pegawai.kd ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);
	$pel_usnm = balikin($rpel['nama']);


	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "mapel.php?s=detail&gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm]";
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
    		<td>
		<p>
		'.$pollse.'';

		//polling ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$qcc = mysql_query("SELECT * FROM guru_mapel_polling ".
								"WHERE kd_guru_mapel = '$gmkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_topik = balikin($rcc['topik']);
		$cc_opsi1 = balikin($rcc['opsi1']);
		$cc_opsi2 = balikin($rcc['opsi2']);
		$cc_opsi3 = balikin($rcc['opsi3']);
		$cc_opsi4 = balikin($rcc['opsi4']);
		$cc_opsi5 = balikin($rcc['opsi5']);
		$cc_nil_opsi1 = nosql($rcc['nil_opsi1']);
		$cc_nil_opsi2 = nosql($rcc['nil_opsi2']);
		$cc_nil_opsi3 = nosql($rcc['nil_opsi3']);
		$cc_nil_opsi4 = nosql($rcc['nil_opsi4']);
		$cc_nil_opsi5 = nosql($rcc['nil_opsi5']);
		$cc_total = round($cc_nil_opsi1 + $cc_nil_opsi2 + $cc_nil_opsi3 + $cc_nil_opsi4 + $cc_nil_opsi5);

		//jika nol
		if ((empty($cc_nil_opsi1)) AND (empty($cc_nil_opsi2)) AND (empty($cc_nil_opsi3)) AND (empty($cc_nil_opsi4))
			AND (empty($cc_nil_opsi5)))
			{
			$cc_nil_opsi1 = 1;
			$cc_nil_opsi2 = 1;
			$cc_nil_opsi3 = 1;
			$cc_nil_opsi4 = 1;
			$cc_nil_opsi5 = 1;
			}



		//jika ada
		if ($tcc != 0)
			{
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="400">
			Topik :
			<br>
			<strong>'.$cc_topik.'</strong>
			<br>
			<br>

			<ul>

			<input name="v_opsi" type="radio" value="nopsi1">
			<strong>'.$cc_opsi1.'</strong>
			<br>
			<br>


			<input name="v_opsi" type="radio" value="nopsi2">
			<strong>'.$cc_opsi2.'</strong>
			<br>
			<br>


			<input name="v_opsi" type="radio" value="nopsi3">
			<strong>'.$cc_opsi3.'</strong>
			<br>
			<br>


			<input name="v_opsi" type="radio" value="nopsi4">
			<strong>'.$cc_opsi4.'</strong>
			<br>
			<br>


			<input name="v_opsi" type="radio" value="nopsi5">
			<strong>'.$cc_opsi5.'</strong>
			<br>
			<br>

			</ul>

			<input name="s" type="hidden" value="'.$s.'">
			<input name="gmkd" type="hidden" value="'.$gmkd.'">
			<input name="btnPOL" type="submit" value="Vote">
			[Total : <strong>'.$cc_total.'</strong> vote].
			</td>
			<td>
			<div id="pieCanvas" style="position:absolute; height:10px; width:10px; z-index:1; left: 300px; top: 100px;"></div>

			<script type="text/javascript">
			var p = new pie();
			p.add("'.$cc_opsi1.' <br> ",'.$cc_nil_opsi1.');
			p.add("'.$cc_opsi2.' <br> ",'.$cc_nil_opsi2.');
			p.add("'.$cc_opsi3.' <br> ",'.$cc_nil_opsi3.');
			p.add("'.$cc_opsi4.' <br> ",'.$cc_nil_opsi4.');
			p.add("'.$cc_opsi5.' <br> ",'.$cc_nil_opsi5.');
			p.render("pieCanvas", "Grafik Polling")
			</script>

			</td>
			</tr>
			</table>
			<br>
			<br>
			<br>

			<table width="100%" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td align="right">
			<hr>
			</td>
		    	</tr>
			</table>
			<br>';
			}

		//tidak ada
		else
			{
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td>

			<font color="blue">
			<strong>
			Belum Ada Data Polling.
			</strong>
			</font>

			</td>
			</tr>
			</table>
			<br>';
			}
		//polling ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





		//news //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT DISTINCT(guru_mapel_news.kd) AS nkd ".
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
			echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

			do
		  		{
				$nomer = $nomer + 1;

				$dt_kd = nosql($data['nkd']);


				//detail
				$qku = mysql_query("SELECT guru_mapel_news.* ".
							"FROM guru_mapel_news ".
							"WHERE guru_mapel_news.kd = '$dt_kd'");
				$rku = mysql_fetch_assoc($qku);
				$dt_katkd = nosql($rku['kd_kategori']);
				$dt_judul = balikin($rku['judul']);
				$dt_rangkuman = balikin($rku['rangkuman']);
				$dt_postdate = $rku['postdate'];

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
				[<em>Kategori : <strong>'.$kat_kategori.'</strong></em>].
				[<em>'.$dt_postdate.'</em>].
				[<a href="news.php?gmkd='.$gmkd.'&s=view&artkd='.$dt_kd.'#'.$dt_kd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
				[<a href="news.php?gmkd='.$gmkd.'&bk=news&artkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>].
				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td align="right">
			<hr>
			[<a href="news.php?gmkd='.$gmkd.'" title="News">NEWS</a>].
			<hr>
			</td>
		    	</tr>
			</table>';
			}
		else
			{
			echo '<p>
			<font color="blue">
			<strong>
			TIDAK ADA News.
			</strong>
			</font>
			</p>';
			}
		//news //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





		//artikel ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT DISTINCT(guru_mapel_artikel.kd) AS nkd ".
				"FROM guru_mapel, guru_mapel_artikel ".
				"WHERE guru_mapel_artikel.kd_guru_mapel = guru_mapel.kd ".
				"AND guru_mapel.kd = '$gmkd' ".
				"ORDER BY guru_mapel_artikel.postdate DESC";
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
			echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

			do
		  		{
				$nomer = $nomer + 1;

				$dt_kd = nosql($data['nkd']);


				//detail
				$qku = mysql_query("SELECT guru_mapel_artikel.* ".
							"FROM guru_mapel_artikel ".
							"WHERE guru_mapel_artikel.kd = '$dt_kd' ".
							"ORDER BY guru_mapel_artikel.postdate DESC");
				$rku = mysql_fetch_assoc($qku);
				$dt_katkd = nosql($rku['kd_kategori']);
				$dt_judul = balikin($rku['judul']);
				$dt_rangkuman = balikin($rku['rangkuman']);
				$dt_postdate = $rku['postdate'];

				//kategori
				$qkat = mysql_query("SELECT * FROM user_blog_kategori ".
										"WHERE kd = '$dt_katkd'");
				$rkat = mysql_fetch_assoc($qkat);
				$kat_kategori = balikin($rkat['kategori']);

				//jumlah komentar
				$qitusx = mysql_query("SELECT * FROM guru_mapel_artikel_msg ".
											"WHERE kd_guru_mapel_artikel = '$dt_kd' ".
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
				[<a href="artikel.php?gmkd='.$gmkd.'&s=view&artkd='.$dt_kd.'#'.$dt_kd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
				[<a href="artikel.php?gmkd-'.$gmkd.'&bk=artikel&artkd='.$dt_kd.'#'.$dt_kd.'" title="Beri Komentar">Beri Komentar</a>].
				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td align="right">
			<hr>
			[<a href="artikel.php?gmkd='.$gmkd.'" title="Artikel">ARTIKEL</a>].
			<hr>
			</td>
		   	</tr>
			</table>';
			}
		else
			{
			echo '<p>
			<font color="blue">
			<strong>
			TIDAK ADA Artikel.
			</strong>
			</font>
			</p>';
			}
		//artikel ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





		//forum /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT DISTINCT(guru_mapel_forum.kd) AS fkd ".
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
			echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

			do
		  		{
				$nomer = $nomer + 1;

				$i_fkd = nosql($data['fkd']);


				//detail
				$qku = mysql_query("SELECT guru_mapel_forum.* ".
							"FROM guru_mapel_forum ".
							"WHERE guru_mapel_forum.kd = '$i_fkd'");
				$rku = mysql_fetch_assoc($qku);
				$i_topik = balikin($rku['topik']);
				$i_postdate = $rku['postdate'];

				//jumlah komentar
				$qitusx = mysql_query("SELECT * FROM guru_mapel_forum_msg ".
											"WHERE kd_guru_mapel_forum = '$i_fkd'");
				$ritusx = mysql_fetch_assoc($qitusx);
				$titusx = mysql_num_rows($qitusx);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td valign="top">
				<br>
				<big><strong>'.$i_topik.'</strong></big>
				<br>
				[<em>'.$i_postdate.'</em>].
				[<a href="forum.php?gmkd='.$gmkd.'&s=view&stkd='.$i_fkd.'#'.$i_fkd.'" title="('.$titusx.') Komentar">(<strong>'.$titusx.'</strong>) Komentar</a>].
				[<a href="forum.php?gmkd='.$gmkd.'&bk=topik&stkd='.$i_fkd.'#'.$i_fkd.'" title="Beri Komentar">Beri Komentar</a>].
				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td align="right">
			<hr>
			[<a href="forum.php?gmkd='.$gmkd.'" title="Forum">FORUM</a>].
			<hr>
			</td>
		    	</tr>
			</table>';
			}
		else
			{
			echo '<p>
			<font color="blue">
			<strong>
			TIDAK ADA Topik Forum.
			</strong>
			</font>
			</p>';
			}
		//forum ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		echo '</p>

		</td>

		<td width="10">
		</td>

		<td width="200">
		<p>
		<hr>
		<big>
		<strong>File Materi...</strong>
		</big>
		(<a href="file_materi.php?gmkd='.$gmkd.'" title="Lihat Daftar File Materi">Lihat</a>).
		</p>';
		//file materi ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM guru_mapel_file_materi ".
						"WHERE kd_guru_mapel = '$gmkd' ".
						"ORDER BY rand()";
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
			echo '<UL>';

			do
		  		{
				$fle_kd = nosql($data['kd']);
				$fle_ket = balikin($data['ket']);
				$fle_filex = $data['filex'];
				$fle_postdate = $data['postdate'];
				$file_path = "../../../filebox/e/materi/$gmkd/$fle_kd/$fle_filex";

				echo '<LI>
				<p>
				<em>'.$fle_ket.'</em>
				<br>
				FileSize :
				<br>
				<strong>'.my_filesize($file_path).'</strong>
				<br>
				PostDate :
				<br>
				<strong>'.$fle_postdate.'</strong>
				<br>
				[<a href="'.$file_path.'" title="Download" target="_blank">Download</a>].
				</p>
				</LI>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</UL>';
			}
		else
			{
			echo '<font color="blue">
			<strong>
			TIDAK ADA File Materi.
			</strong>
			</font>';
			}
		//file materi ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////





		echo '<p>
		<hr>
		<big>
		<strong>Link...</strong>
		</big>
		(<a href="link.php?gmkd='.$gmkd.'" title="Lihat Daftar Link">Lihat</a>).
		</p>';
		//link //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT DISTINCT(guru_mapel_link.kd) AS nkd ".
				"FROM guru_mapel, guru_mapel_link ".
				"WHERE guru_mapel_link.kd_guru_mapel = guru_mapel.kd ".
				"AND guru_mapel.kd = '$gmkd' ".
				"ORDER BY rand()";
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
			echo '<UL>';

			do
		  		{
				$nomer = $nomer + 1;

				$dt_kd = nosql($data['nkd']);

				//detail
				$qku = mysql_query("SELECT guru_mapel_link.* ".
							"FROM guru_mapel_link ".
							"WHERE guru_mapel_link.kd = '$dt_kd'");
				$rku = mysql_fetch_assoc($qku);
				$dt_judul = balikin($rku['judul']);
				$dt_url = balikin($rku['url']);

				echo '<LI>
				<p>
				<a href="http://'.$dt_url.'" title="'.$dt_judul.'" target="_blank">'.$dt_judul.'</a>
				</p>
				</LI>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</UL>';
			}
		else
			{
			echo '<font color="blue">
			<strong>
			TIDAK ADA Link.
			</strong>
			</font>';
			}
		//link //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<br>

		<p>
		<hr>
		<big>
		<strong>Kalender...</strong>
		</big>
		</p>

		<select name="ubln">
		<option value="'.$ubln.'">'.$arrbln[$ubln].'</option>';
		for ($ibln=1;$ibln<=12;$ibln++)
			{
			echo '<option value="'.$ibln.'">'.$arrbln[$ibln].'</option>';
			}
		echo '</select>';

		//tahun
		echo '<select name="uthn">
		<option value="'.$uthn.'">'.$uthn.'</option>';
		for ($ithn=$tpel01;$ithn<=$tpel02;$ithn++)
			{
			echo '<option value="'.$ithn.'">'.$ithn.'</option>';
			}
		echo '</select>
		<br>
		<input name="gmkd" type="hidden" value="'.$gmkd.'">
		<input name="btnKAL" type="submit" value="Lihat">
		<br>

		<p>
		<hr>
		<big>
		<strong>Soal...</strong>
		</big>
		(<a href="soal.php?s=detail&gmkd='.$gmkd.'" title="Soal">Lihat</a>).
		</p>
		<br>
		<br>

		<p>
		<hr>
		<big>
		<strong>ChatRoom...</strong>
		</big>
		(<a href="chatroom.php?gmkd='.$gmkd.'" title="Chatting Bersama">CHAT</a>).
		</p>
		<br>
		<br>

		<p>
		<hr>
		<big>
		<strong>Tanya...</strong>
		</big>
		(<a href="tanya.php?gmkd='.$gmkd.'" title="Tanya">Lihat</a>).
		</p>';

		//tanya /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$qtya = mysql_query("SELECT guru_mapel.*, guru_mapel_tanya.*, guru_mapel_tanya.kd AS tkd ".
					"FROM guru_mapel, guru_mapel_tanya ".
					"WHERE guru_mapel_tanya.kd_guru_mapel = guru_mapel.kd ".
					"AND guru_mapel.kd = '$gmkd' ".
					"AND guru_mapel_tanya.dari = '$kd1_session' ".
					"ORDER BY guru_mapel_tanya.postdate DESC");
		$rtya = mysql_fetch_assoc($qtya);
		$ttya = mysql_num_rows($qtya);

		//nek ada
		if ($ttya != 0)
			{
			$dt_kd = nosql($rtya['tkd']);
			$dt_tanya = balikin($rtya['tanya']);

			echo '<em>'.$dt_tanya.'</em>
			<br>
			[<a href="tanya.php?gmkd='.$gmkd.'&tankd='.$dt_kd.'&s=lihat">Lihat</a>].';
			}
		else
			{
			echo '<font color="blue">
			<strong>
			Belum Pernah Bertanya.
			</strong>
			</font>';
			}
		//tanya /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		echo '<br>
		<br><br><br>';
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


	echo '</td>
	</tr>
	</table>';
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
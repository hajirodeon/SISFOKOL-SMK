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
$page = nosql($_REQUEST['page']);
/*
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}
*/


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct kalender
if ($_POST['btnKAL'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);

	//cek null
	if ((empty($ubln)) OR (empty($uthn)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
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




//view : guru ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika belum pilih mapel
if (empty($s))
	{
	//re-direct ke halaman sisfokol
	$ke = "$sumber/admgr/index.php";
	xloc($ke);
	exit();
		
	
	
	
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


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT guru_mapel.*, guru_mapel.kd AS gmkd, ".
			"m_mapel.*, m_user.*, m_user.kd AS uskd ".
			"FROM guru_mapel, m_mapel, m_user ".
			"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
			"AND guru_mapel.kd_user = m_user.kd ".
			"AND guru_mapel.kd_user = '$kd1_session' ".
			"ORDER BY mapel ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
//	$target = "mapel.php?page=$page";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	//nek gak null
	if ($count != 0)
		{
		echo '<br>
		<table width="400" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td><strong>Mata Pelajaran</strong></td>
		<td width="1"></td>
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
			$dty_nomor = nosql($data['nomor']);
			$dty_nama = balikin($data['nama']);








/*
			//mapel-nya sendiri
			if ($dty_uskd == $kd1_session)
				{
				echo "<tr valign=\"top\" bgcolor=\"yellow\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='yellow';\">";
				echo '<td><strong>'.$dty_pel.'</strong></td>
				<td>
				<a href="'.$filenya.'?s=detail&gmkd='.$dty_pelkd.'" title="'.$dty_pel.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
				</td>
				</tr>';
				}


			//jika seorang guru, melihat aktivitas guru lain...
			else
				{
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<a href="'.$sumber.'/janissari/e/grsw/mapel.php?s=detail&grsw=sw&gmkd='.$dty_pelkd.'" title="'.$dty_pel.' ['.$dty_nomor.'. '.$dty_nama.']">
				'.$dty_pel.' ['.$dty_nomor.'. '.$dty_nama.'].
				</a>
				</td>
				<td>
				-
				</td>
				</tr>';
				}
*/

/*

			echo "<tr valign=\"top\" bgcolor=\"yellow\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='yellow';\">";
			echo '<td><strong>'.$dty_pel.'</strong></td>
			<td>
			<a href="'.$filenya.'?s=detail&gmkd='.$dty_pelkd.'" title="'.$dty_pel.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			</tr>';
*/

			//mapel-nya sendiri
			if ($dty_uskd == $kd1_session)
				{
				echo "<tr valign=\"top\" bgcolor=\"yellow\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='yellow';\">";
				echo '<td><strong>'.$dty_pel.'</strong></td>
				<td>
				<a href="'.$filenya.'?s=detail&gmkd='.$dty_pelkd.'" title="'.$dty_pel.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
				</td>
				</tr>';
				}


			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="400" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td align="right">'.$pagelist.'</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red"><strong>Belum Punya Mata Pelajaran untuk E-Learning. <br>
		Silahkan Hubungi Administrator.</strong></font>
		</p>';
		}
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

	//jika null, insert dahulu
	if (empty($tpel))
		{
		//masukkan ke janissari
		mysql_query("INSERT INTO guru_mapel(kd, kd_user, kd_mapel) VALUES ".
						"('$gmkd', '$kd1_session', '$gmkd')");			
		}
		
		
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
		$filenya = "mapel.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;
		$limit = 5; //batas data maksimal preview


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
		<p>';

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
			<li>
			Opsi #01 : [<strong>'.$cc_nil_opsi1.'</strong> vote]
			<br>
			<strong>'.$cc_opsi1.'</strong>
			<br>
			<br>
			</li>

			<li>
			Opsi #02 : [<strong>'.$cc_nil_opsi2.'</strong> vote]
			<br>
			<strong>'.$cc_opsi2.'</strong>
			<br>
			<br>
			</li>

			<li>
			Opsi #03 : [<strong>'.$cc_nil_opsi3.'</strong> vote]
			<br>
			<strong>'.$cc_opsi3.'</strong>
			<br>
			<br>
			</li>

			<li>
			Opsi #04 : [<strong>'.$cc_nil_opsi4.'</strong> vote]
			<br>
			<strong>'.$cc_opsi4.'</strong>
			<br>
			<br>
			</li>

			<li>
			Opsi #05 : [<strong>'.$cc_nil_opsi5.'</strong> vote]
			<br>
			<strong>'.$cc_opsi5.'</strong>
			<br>
			<br>
			</li>

			</ul>

			[Total : <strong>'.$cc_total.'</strong> vote].
			</td>
			<td>
			<div id="pieCanvas" style="position:absolute; height:350px; width:380px; z-index:1; left: 300px; top: 150px;"></div>

			<script type="text/javascript">
			var p = new pie();
			p.add("Opsi #1 ",'.$cc_nil_opsi1.');
			p.add("Opsi #2 ",'.$cc_nil_opsi2.');
			p.add("Opsi #3 ",'.$cc_nil_opsi3.');
			p.add("Opsi #4 ",'.$cc_nil_opsi4.');
			p.add("Opsi #5 ",'.$cc_nil_opsi5.');
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
			[<a href="polling.php?gmkd='.$gmkd.'" title="EDIT Polling">EDIT POLLING</a>].
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
			<br>
			Silahkan Entry Baru...!!
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
			echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

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
										"WHERE kd_guru_mapel = '$gmkd' ".
										"AND kd = '$dt_katkd'");
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
				[<a href="news.php?gmkd='.$gmkd.'&s=edit&artkd='.$dt_kd.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>].
				[<a href="news.php?gmkd='.$gmkd.'&s=hapus&artkd='.$dt_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].

				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td align="right">
			<hr>
			[<a href="news.php?gmkd='.$gmkd.'" title="EDIT News">EDIT NEWS</a>].
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
			<br>
			Silahkan Entry Dahulu...!!
			</strong>
			</font>
			</p>';
			}
		//news //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





		//artikel ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT guru_mapel.*, guru_mapel_artikel.*, guru_mapel_artikel.kd AS nkd ".
						"FROM guru_mapel, guru_mapel_artikel ".
						"WHERE guru_mapel_artikel.kd_guru_mapel = guru_mapel.kd ".
						"AND guru_mapel.kd_user = '$kd1_session' ".
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

				$dt_kd = nosql($data['kd']);
				$dt_katkd = nosql($data['kd_kategori']);
				$dt_judul = balikin($data['judul']);
				$dt_rangkuman = balikin($data['rangkuman']);
				$dt_postdate = $data['postdate'];

				//kategori
				$qkat = mysql_query("SELECT * FROM guru_mapel_kategori ".
										"WHERE kd_guru_mapel = '$gmkd' ".
										"AND kd = '$dt_katkd'");
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
				[<a href="artikel.php?gmkd='.$gmkd.'&s=edit&artkd='.$dt_kd.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>].
				[<a href="artikel.php?gmkd='.$gmkd.'&s=hapus&artkd='.$dt_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].

				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td align="right">
			<hr>
			[<a href="artikel.php?gmkd='.$gmkd.'" title="EDIT Artikel">EDIT ARTIKEL</a>].
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
			<br>
			Silahkan Entry Dahulu...!!
			</strong>
			</font>
			</p>';
			}
		//artikel ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





		//forum /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT guru_mapel.*, guru_mapel_forum.*, guru_mapel_forum.kd AS fkd ".
						"FROM guru_mapel, guru_mapel_forum ".
						"WHERE guru_mapel_forum.kd_guru_mapel = guru_mapel.kd ".
						"AND guru_mapel.kd_user = '$kd1_session' ".
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
				$i_topik = balikin($data['topik']);
				$i_postdate = $data['postdate'];

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
				[<a href="forum.php?gmkd='.$gmkd.'&s=hapus&stkd='.$i_fkd.'" title="HAPUS"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>]
				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td align="right">
			<hr>
			[<a href="forum.php?gmkd='.$gmkd.'" title="EDIT Forum">EDIT FORUM</a>].
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
			<br>
			Silahkan Entry Dahulu...!!
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
		<strong>Kategori...</strong>
		</big>
		(<a href="kategori.php?gmkd='.$gmkd.'" title="EDIT Kategori">EDIT</a>).
		</p>';

		//kategori //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT guru_mapel.*, guru_mapel_kategori.* ".
						"FROM guru_mapel, guru_mapel_kategori ".
						"WHERE guru_mapel_kategori.kd_guru_mapel = guru_mapel.kd ".
						"AND guru_mapel.kd_user = '$kd1_session' ".
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

				$dt_kd = nosql($data['kd']);
				$dt_kategori = balikin($data['kategori']);

				echo '<LI>
				<p>'.$dt_kategori.'</p>
				</LI>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</UL>';
			}
		else
			{
			echo '<font color="blue">
			<strong>
			TIDAK ADA Kategori.
			<br>
			Silahkan Entry Dahulu...!!
			</strong>
			</font>';
			}
		//kategori //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		echo '<p>
		<hr>
		<big>
		<strong>File Materi...</strong>
		</big>
		(<a href="file_materi.php?gmkd='.$gmkd.'" title="EDIT File Materi">EDIT</a>).
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
				[<a href="'.$filenya.'&s=hapus&filekd='.$fle_kd.'" title="Hapus"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
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
			<br>
			Silahkan Entry Dahulu...!!
			</strong>
			</font>';
			}
		//file materi ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////





		echo '<p>
		<hr>
		<big>
		<strong>Link...</strong>
		</big>
		(<a href="link.php?gmkd='.$gmkd.'" title="EDIT Link">EDIT</a>).
		</p>';
		//link //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT guru_mapel.*, guru_mapel_link.* ".
						"FROM guru_mapel, guru_mapel_link ".
						"WHERE guru_mapel_link.kd_guru_mapel = guru_mapel.kd ".
						"AND guru_mapel.kd_user = '$kd1_session' ".
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

				$dt_kd = nosql($data['kd']);
				$dt_judul = balikin($data['judul']);
				$dt_url = balikin($data['url']);

				echo '<LI>
				<p>
				<a href="'.$dt_url.'" title="'.$dt_judul.'" target="_blank">'.$dt_judul.'</a>
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
			<br>
			Silahkan Entry Dahulu...!!
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
		<input name="btnKAL" type="submit" value="EDIT">
		<br>

		<p>
		<hr>
		<big>
		<strong>Soal...</strong>
		</big>
		(<a href="soal.php?gmkd='.$gmkd.'" title="EDIT Soal">EDIT</a>).
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
		(<a href="tanya.php?gmkd='.$gmkd.'" title="EDIT Tanya">EDIT</a>).
		</p>';

		//tanya /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$qtya = mysql_query("SELECT guru_mapel.*, guru_mapel_tanya.*, guru_mapel_tanya.kd AS tkd ".
								"FROM guru_mapel, guru_mapel_tanya ".
								"WHERE guru_mapel_tanya.kd_guru_mapel = guru_mapel.kd ".
								"AND guru_mapel.kd_user = '$kd1_session' ".
								"AND guru_mapel.kd = '$gmkd' ".
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
			[<a href="tanya.php?gmkd='.$gmkd.'&tankd='.$dt_kd.'&s=jawab">Jawab</a>].';
			}
		else
			{
			echo '<font color="blue">
			<strong>
			Tidak Ada Yang Bertanya.
			<br>
			Mungkin Lain Waktu...
			</strong>
			</font>';
			}
		//tanya /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
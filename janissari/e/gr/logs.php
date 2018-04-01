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
$swkd = nosql($_REQUEST['swkd']);
$gmkd = nosql($_REQUEST['gmkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$filenya = "logs.php?gmkd=$gmkd&page=$page";







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
		$filenya = "logs.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> Logs History";
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
		<big><strong>:::Logs History...</strong></big>
		</p>
		</td>
  		</tr>
		</table>';


		//detail logs siswa
		if ($a == "detail")
			{
			//detail siswa
			$qdtx = mysql_query("SELECT * FROM m_user ".
						"WHERE kd = '$swkd'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$dtx_nomor = nosql($rdtx['nomor']);
			$dtx_nama = balikin($rdtx['nama']);


			echo '<p>
			Daftar Logs dari : <strong>'.$dtx_nomor.'.'.$dtx_nama.'</strong>.
			[<a href="'.$filenya.'">Logs Lainnya</a>].
			</p>';


			//logs-nya
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT * FROM user_learning ".
						"WHERE kd_user = '$swkd' ".
						"AND kd_guru_mapel = '$gmkd' ".
						"ORDER BY postdate DESC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya&swkd=$swkd&a=detail";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			do
				{
				$ku_postdate = $data['postdate'];
				$ku_ket = balikin($data['ket']);

				echo '<p>
				<em>['.$ku_postdate.']. '.$ku_ket.'.</em>
				</p>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo $pagelist;

			}
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT DISTINCT(m_user.kd) AS swkd ".
					"FROM user_learning, m_user ".
					"WHERE user_learning.kd_user = m_user.kd ".
					"AND user_learning.kd_guru_mapel = '$gmkd' ".
					"ORDER BY user_learning.postdate DESC";
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
				echo 'Berikut Siswa yang ikut E-Learning :
				<table width="500" border="0" cellpadding="3" cellspacing="0">';

				do
					{
					if ($warna_set ==0)
						{
						$warna = $e_warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $e_warna02;
						$warna_set = 0;
						}


					$nomer = $nomer + 1;
					$dt_swkd = nosql($data['swkd']);


					//detail siswa
					$qdtx = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$dt_swkd'");
					$rdtx = mysql_fetch_assoc($qdtx);
					$dtx_nomor = nosql($rdtx['nomor']);
					$dtx_nama = balikin($rdtx['nama']);



					//logs-nya
					$qku = mysql_query("SELECT * FROM user_learning ".
								"WHERE kd_user = '$dt_swkd' ".
								"AND kd_guru_mapel = '$gmkd' ".
								"ORDER BY postdate DESC");
					$rku = mysql_fetch_assoc($qku);
					$tku = mysql_num_rows($qku);

					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
					*<a href="'.$filenya.'&swkd='.$dt_swkd.'&a=detail">'.$dtx_nomor.'.'.$dtx_nama.'</a> ['.$tku.'Logs].
					[<a href="logs_prt.php?gmkd='.$gmkd.'&swkd='.$dt_swkd.'" title="Print Logs"><img src="'.$sumber.'/img/print.gif" width="16" height="16" border="0"></a>].
					</td>
					</tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<font color="red"><strong>'.$count.'</strong></font> Siswa. '.$pagelist.'';
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
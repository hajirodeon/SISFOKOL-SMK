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
require("../../../inc/cek/e_sw.php");
require("../../../inc/class/paging.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$gmkd = nosql($_REQUEST['gmkd']);
$linkkd = nosql($_REQUEST['linkkd']);
$filenya = "link.php?gmkd=$gmkd";
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





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
		$filenya = "link.php?gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm] --> link";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;


		//log
		$nilku = "Lihat Daftar Link";
		mysql_query("INSERT INTO user_learning(kd, kd_user, kd_guru_mapel, ket, postdate) VALUES ".
				"('$x', '$kd1_session', '$gmkd', '$nilku', '$today')");




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
		<big><strong>:::Link...</strong></big>
		</p>
		</td>
  		</tr>
		</table>';

		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT DISTINCT(guru_mapel_link.kd) AS nkd ".
				"FROM guru_mapel_link ".
				"WHERE guru_mapel_link.kd_guru_mapel = '$gmkd' ".
				"ORDER BY guru_mapel_link.judul ASC";
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
			echo '<ul>
			<table width="950" border="0" cellpadding="3" cellspacing="0">';

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

				$kd = nosql($data['nkd']);

				//detail
				$qku = mysql_query("SELECT guru_mapel_link.* ".
							"FROM guru_mapel_link ".
							"WHERE guru_mapel_link.kd = '$kd'");
				$rku = mysql_fetch_assoc($qku);
				$judul = balikin($rku['judul']);
				$url = balikin($rku['url']);

				echo '<tr>
				<td valign="top">
				<LI>
				<big>
				<strong>'.$judul.'</strong>
				</big>
				<br>
				(<a href="http://'.$url.'" title="'.$judul.'" target="_blank">http://'.$url.'</a>)
				</li>
				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			</ul>
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
			echo '<p>
			<font color="blue"><strong>TIDAK ADA DATA.</strong></font>
			</p>';
			}

		echo '<br><br><br>';
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
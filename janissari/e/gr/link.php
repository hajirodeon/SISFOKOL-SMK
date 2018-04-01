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
$linkkd = nosql($_REQUEST['linkkd']);
$filenya = "link.php?gmkd=$gmkd";
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus...
$diload = "document.formx.judul.focus();";


//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}


//nek edit
if ($s == "edit")
	{
	//nilai
	$linkkd = nosql($_REQUEST['linkkd']);

	//query
	$qnil = mysql_query("SELECT guru_mapel.*, guru_mapel_link.* ".
							"FROM guru_mapel, guru_mapel_link ".
							"WHERE guru_mapel_link.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd = '$gmkd' ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel_link.kd = '$linkkd'");
	$rnil = mysql_fetch_assoc($qnil);
	$y_judul = balikin($rnil['judul']);
	$y_url = balikin($rnil['url']);
	}



//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$jml = nosql($_POST['jml']);
	$page = nosql($_POST['page']);

	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT guru_mapel.*, guru_mapel_link.* ".
					"FROM guru_mapel, guru_mapel_link ".
					"WHERE guru_mapel_link.kd_guru_mapel = guru_mapel.kd ".
					"AND guru_mapel.kd_user = '$kd1_session' ".
					"AND guru_mapel.kd = '$gmkd' ".
					"ORDER BY guru_mapel_link.judul ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = $filenya;
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del data
		mysql_query("DELETE FROM guru_mapel_link ".
						"WHERE kd_guru_mapel = '$gmkd' ".
						"AND kd = '$kd'");
		}
	while ($data = mysql_fetch_assoc($result));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}


//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$gmkd = nosql($_POST['gmkd']);
	$linkkd = nosql($_POST['linkkd']);
	$judul = cegah($_POST['judul']);
	$url = cegah($_POST['url']);


	//nek null
	if ((empty($judul)) OR (empty($url)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//nek edit
		if ($s == "edit")
			{
			//update
			mysql_query("UPDATE guru_mapel_link SET judul = '$judul', ".
							"url = '$url' ".
							"WHERE kd_guru_mapel = '$gmkd' ".
							"AND kd = '$linkkd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}





		//nek baru
		if (empty($s))
			{
			//cek
			$qcc = mysql_query("SELECT guru_mapel_link.*, guru_mapel.* ".
									"FROM guru_mapel_link, guru_mapel ".
									"WHERE guru_mapel_link.kd_guru_mapel = '$gmkd' ".
									"AND guru_mapel.kd_user = '$kd1_session' ".
									"AND guru_mapel_link.judul = '$judul'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Ditemukan Duplikasi Link Favorit. Silahkan Diganti...!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//insert data
				mysql_query("INSERT INTO guru_mapel_link(kd, kd_guru_mapel, judul, url) VALUES ".
								"('$x', '$gmkd', '$judul', '$url')");

				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/js/checkall.js");
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
		$filenya = "link.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> link";
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
		<big><strong>:::Link...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<strong>Judul :</strong>
		<br>
		<input name="judul" type="text" value="'.$y_judul.'" size="30">
		<br>

		<strong>URL :</strong>
		<br>
		http://<input name="url" type="text" value="'.$y_url.'" size="50" '.$x_enter.'>
		<br>

		<input name="gmkd" type="hidden" value="'.$gmkd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">
		</td>
		</tr>
		</table>
		<br>';

		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT guru_mapel.*, guru_mapel_link.* ".
						"FROM guru_mapel, guru_mapel_link ".
						"WHERE guru_mapel_link.kd_guru_mapel = guru_mapel.kd ".
						"AND guru_mapel.kd_user = '$kd1_session' ".
						"AND guru_mapel.kd = '$gmkd' ".
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
			echo '<table width="600" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$e_warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="1">&nbsp;</td>
			<td valign="top"><strong>Link</strong></td>
			</tr>';

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

				$kd = nosql($data['kd']);
				$judul = balikin($data['judul']);
				$url = balikin($data['url']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td width="1">
				<input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
				<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
				</td>
				<td width="1">
				<a href="'.$filenya.'&s=edit&linkkd='.$kd.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
				</td>
				<td valign="top">
				<a href="http://'.$url.'" title="'.$judul.'" target="_blank">'.$judul.'</a>
				</td>
				</tr>';
		  		}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="600" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td width="250">
			<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPS" type="submit" value="HAPUS">
			<input name="jml" type="hidden" value="'.$count.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="linkkd" type="hidden" value="'.$linkkd.'">
			</td>
			<td align="right"><font color="blue"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
		    	</tr>
			</table>';
			}
		else
			{
			echo '<font color="blue"><strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong></font>';
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
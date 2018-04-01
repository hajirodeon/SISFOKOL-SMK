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
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$gmkd = nosql($_REQUEST['gmkd']);
$katkd = nosql($_REQUEST['katkd']);
$filenya = "kategori.php?gmkd=$gmkd";


//focus...
$diload = "document.formx.kategori.focus();";


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
	$katkd = nosql($_REQUEST['katkd']);

	//query
	$qnil = mysql_query("SELECT guru_mapel.*, guru_mapel_kategori.* ".
							"FROM guru_mapel, guru_mapel_kategori ".
							"WHERE guru_mapel_kategori.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd = '$gmkd' ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel_kategori.kd = '$katkd'");
	$rnil = mysql_fetch_assoc($qnil);
	$y_kategori = balikin($rnil['kategori']);
	}



//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$jml = nosql($_POST['jml']);

	for ($i=1;$i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del data
		mysql_query("DELETE FROM guru_mapel_kategori ".
						"WHERE kd_guru_mapel = '$gmkd' ".
						"AND kd = '$kd'");
		}

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
	$katkd = nosql($_POST['katkd']);
	$kategori = cegah($_POST['kategori']);


	//nek null
	if (empty($kategori))
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
			mysql_query("UPDATE guru_mapel_kategori SET kategori = '$kategori' ".
							"WHERE kd_guru_mapel = '$gmkd' ".
							"AND kd = '$katkd'");

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
			$qcc = mysql_query("SELECT guru_mapel_kategori.*, guru_mapel.* ".
									"FROM guru_mapel_kategori, guru_mapel ".
									"WHERE guru_mapel_kategori.kd_guru_mapel = '$gmkd' ".
									"AND guru_mapel.kd_user = '$kd1_session' ".
									"AND guru_mapel_kategori.kategori = '$kategori'");
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
				$pesan = "Ditemukan Duplikasi Kategori. Silahkan Diganti...!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//insert data
				mysql_query("INSERT INTO guru_mapel_kategori(kd, kd_guru_mapel, kategori) VALUES ".
								"('$x', '$gmkd', '$kategori')");

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
		$filenya = "kategori.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> Kategori";
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
		<big><strong>:::Kategori...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<input name="kategori" type="text" value="'.$y_kategori.'" size="30" '.$x_enter.'>
		<input name="gmkd" type="hidden" value="'.$gmkd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">
		</td>
		</tr>
		</table>
		<br>';


		//query
		$qdt = mysql_query("SELECT guru_mapel.*, guru_mapel_kategori.* ".
								"FROM guru_mapel, guru_mapel_kategori ".
								"WHERE guru_mapel_kategori.kd_guru_mapel = guru_mapel.kd ".
								"AND guru_mapel.kd_user = '$kd1_session' ".
								"AND guru_mapel.kd = '$gmkd' ".
								"ORDER BY guru_mapel_kategori.kategori ASC");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);

		//nek ada
		if ($tdt != 0)
			{
			echo '<table width="400" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$e_warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="1">&nbsp;</td>
			<td valign="top"><strong>Kategori</strong></td>
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

				$kd = nosql($rdt['kd']);
				$kategori = balikin($rdt['kategori']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td width="1">
				<input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
				<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
				</td>
				<td width="1">
				<a href="'.$filenya.'&s=edit&katkd='.$kd.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
				</td>
				<td valign="top">
				'.$kategori.'
				</td>
				</tr>';
		  		}
			while ($rdt = mysql_fetch_assoc($qdt));

			echo '</table>
			<table width="400" border="0" cellspacing="0" cellpadding="3">
		    	<tr>
			<td width="250">
			<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPS" type="submit" value="HAPUS">
			<input name="jml" type="hidden" value="'.$tdt.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="katkd" type="hidden" value="'.$katkd.'">
			</td>
			<td align="right"><font color="blue"><strong>'.$tdt.'</strong></font> Data</td>
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
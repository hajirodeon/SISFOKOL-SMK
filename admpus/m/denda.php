<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v5.0_(PernahJaya)                          ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://omahbiasawae.com/                          ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admpus.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "denda.php";
$diload = "document.formx.kode.focus();";
$judul = "Data Denda";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$posisi = nosql($_POST['posisi']);
	$pustakax = nosql($_POST['takax']);
	$maksitem = nosql($_POST['maksitem']);
	$maksjkw = nosql($_POST['maksjkw']);
	$periode = nosql($_POST['periode']);
	$denda = nosql($_POST['denda']);



	//jika baru
	if ($s == "baru")
		{
		//nek null
		if ((empty($pustakax)) OR (empty($posisi)))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			$ke = "$filenya?s=baru";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			mysql_query("INSERT INTO perpus_m_denda(kd, kd_posisi, kd_pustaka, maksitem, maksjkw, periode, denda) VALUES ".
					"('$x', '$posisi', '$pustakax', '$maksitem', '$maksjkw', '$periode', '$denda')");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}
		}

	//jika update
	else if ($s == "edit")
		{
		//query
		mysql_query("UPDATE perpus_m_denda SET kd_posisi = '$posisi', ".
				"kd_pustaka = '$pustakax', ".
				"maksitem = '$maksitem', ".
				"maksjkw = '$maksjkw', ".
				"periode = '$periode', ".
				"denda = '$denda' ".
				"WHERE kd = '$kd'");

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		xloc($filenya);
		exit();
		}
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM perpus_m_denda ".
				"WHERE kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//menu
require("../../inc/menu/admpus.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();




//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
xheadline($judul);
echo ' [<a href="'.$filenya.'?s=baru" title="Entry Baru">Entry Baru</a>]
</td>
</tr>
</table>';

//jika baru/edit
if (($s == "baru") OR ($s == "edit"))
	{
	//query
	$qx = mysql_query("SELECT * FROM perpus_m_denda ".
				"WHERE kd = '$kd'");
	$rowx = mysql_fetch_assoc($qx);
	$e_poskd = nosql($rowx['kd_posisi']);
	$e_puskd = nosql($rowx['kd_pustaka']);
	$e_maksitem = balikin2($rowx['maksitem']);
	$e_maksjkw = balikin2($rowx['maksjkw']);
	$e_periode = balikin2($rowx['periode']);
	$e_denda = balikin2($rowx['denda']);


	//posisi
	$qbit = mysql_query("SELECT * FROM m_posisi ".
				"WHERE kd = '$e_poskd'");
	$rbit = mysql_fetch_assoc($qbit);
	$e_posisi = balikin($rbit['nama']);


	//pustaka
	$qbit = mysql_query("SELECT * FROM perpus_m_pustaka ".
				"WHERE kd = '$e_puskd'");
	$rbit = mysql_fetch_assoc($qbit);
	$e_pustaka = balikin($rbit['nama']);




	echo '<p>
	Posisi :
	<br>
	<select name="posisi">
	<option value="'.$e_poskd.'" selected>'.$e_posisi.'</option>';

	//list
	$qbit = mysql_query("SELECT * FROM m_posisi ".
				"WHERE kd <> '$e_poskd' ".
				"ORDER BY nama ASC");
	$rbit = mysql_fetch_assoc($qbit);

	do
		{
		//nilai
		$bit_kd = nosql($rbit['kd']);
		$bit_kode = nosql($rbit['kode']);
		$bit_nama = balikin($rbit['nama']);

		echo '<option value="'.$bit_kode.'">'.$bit_nama.'</option>';
		}
	while ($rbit = mysql_fetch_assoc($qbit));

	echo '</select>
	</p>

	<p>
	Pustaka :
	<br>
	<select name="takax">
	<option value="'.$e_puskd.'" selected>'.$e_pustaka.'</option>';

	//list
	$qbit = mysql_query("SELECT * FROM perpus_m_pustaka ".
				"WHERE kd <> '$e_puskd' ".
				"ORDER BY nama ASC");
	$rbit = mysql_fetch_assoc($qbit);

	do
		{
		//nilai
		$bit_kd = nosql($rbit['kd']);
		$bit_kode = nosql($rbit['kode']);
		$bit_nama = balikin($rbit['nama']);

		echo '<option value="'.$bit_kode.'">'.$bit_nama.'</option>';
		}
	while ($rbit = mysql_fetch_assoc($qbit));

	echo '</select>
	</p>

	<p>
	Maks.Item :
	<br>
	<input name="maksitem" type="text" value="'.$e_maksitem.'" size="5">
	</p>

	<p>
	Jangka Waktu :
	<br>
	<input name="maksjkw" type="text" value="'.$e_maksjkw.'" size="5">
	</p>

	<p>
	Periode :
	<br>
	<input name="periode" type="text" value="'.$e_periode.'" size="5">
	</p>

	<p>
	Denda :
	<br>
	<input name="denda" type="text" value="'.$e_denda.'" size="5">
	</p>

	<p>
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';
	}

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM perpus_m_denda ".
			"ORDER BY kd_posisi ASC, ".
			"kd_pustaka ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	if ($count != 0)
		{
		echo '<table width="400" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="100"><strong><font color="'.$warnatext.'">Pustaka</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Maksitem</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jangka Waktu</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Periode</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Denda</font></strong></td>
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

			$nomer = $nomer + 1;
			$i_kd = nosql($data['kd']);
			$i_kd_pustaka = nosql($data['kd_pustaka']);
			$i_maksitem = nosql($data['maksitem']);
			$i_maksjkw = nosql($data['maksjkw']);
			$i_periode = nosql($data['periode']);
			$i_denda = nosql($data['denda']);



			//pustaka
			$qbit = mysql_query("SELECT * FROM perpus_m_pustaka ".
						"WHERE kode = '$i_kd_pustaka'");
			$rbit = mysql_fetch_assoc($qbit);
			$e_pustaka = balikin($rbit['nama']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$e_pustaka.'</td>
			<td>'.$i_maksitem.'</td>
			<td>'.$i_maksjkw.'</td>
			<td>'.$i_periode.'</td>
			<td>'.$i_denda.'</td>
		        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="400" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="jml" type="hidden" value="'.$count.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		<br>
		'.$pagelist.'
		<strong><font color="#FF0000">'.$count.'</font></strong> Data.
		</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
		</font>
		</p>';
		}
	}

echo '</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
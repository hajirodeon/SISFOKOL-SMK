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
require("../../inc/cek/admbk.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pelanggaran.php";
$judul = "Data Master Pelanggaran";
$judulku = "[$bk_session : $nip91_session. $nm91_session] ==> $judul";
$judulx = $judul;
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);





//focus
if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}
else
	{
	$diload = "document.formx.e_no.focus();";
	}






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



//jika edit
if ($s == "edit")
	{
	//nilai
	$jnskd = nosql($_REQUEST['jnskd']);
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT * FROM m_bk_point ".
				"WHERE kd_jenis = '$jnskd' ".
				"AND kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_no = nosql($rowx['no']);
	$e_nama = balikin($rowx['nama']);
	$e_point = balikin($rowx['point']);
	$e_sanksi = balikin($rowx['sanksi']);
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$e_no = cegah2($_POST['e_no']);
	$e_nama = cegah2($_POST['e_nama']);
	$e_point = cegah2($_POST['e_point']);
	$e_sanksi = cegah2($_POST['e_sanksi']);



	//nek null
	if ((empty($e_nama)) OR (empty($e_point)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//jika baru
		if (empty($s))
			{
			///cek
			$qcc = mysql_query("SELECT * FROM m_bk_point ".
						"WHERE nama = '$nama'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Data Pelanggaran ini, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?jnskd=$jnskd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO m_bk_point(kd, kd_jenis, no, nama, point, sanksi) VALUES ".
						"('$x', '$jnskd', '$e_no', '$e_nama','$e_point', '$e_sanksi')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?jnskd=$jnskd";
				xloc($ke);
				exit();
				}
			}


		//jika update
		else if ($s == "edit")
			{
			//query
			mysql_query("UPDATE m_bk_point SET no = '$e_no', ".
					"nama = '$e_nama', ".
					"point = '$e_point', ".
					"sanksi = '$e_sanksi' ".
					"WHERE kd_jenis = '$jnskd' ".
					"AND kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?jnskd=$jnskd";
			xloc($ke);
			exit();
			}
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
		mysql_query("DELETE FROM m_bk_point ".
				"WHERE kd_jenis = '$jnskd' ".
				"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?jnskd=$jnskd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//menu
require("../../inc/menu/admbk.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Jenis Pelanggaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_bk_point_jenis ".
			"WHERE kd = '$jnskd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_no = balikin($rowtpx['no']);
$tpx_jenis = balikin($rowtpx['jenis']);


echo '<option value="'.$tpx_kd.'">'.$tpx_no.'.'.$tpx_jenis.'</option>';

$qtp = mysql_query("SELECT * FROM m_bk_point_jenis ".
			"WHERE kd <> '$jnskd' ".
			"ORDER BY round(no) ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpno = nosql($rowtp['no']);
	$tpjenis = balikin($rowtp['jenis']);

	echo '<option value="'.$filenya.'?jnskd='.$tpkd.'">'.$tpno.'.'.$tpjenis.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';


//jika null
if (empty($jnskd))
	{
	echo '<p>
	<font color="red">
	<strong>Jenis Pelanggaran Belum Dipilih.</strong>
	</font>
	</p>';
	}
else
	{
	echo '<p>
	No.:
	<input name="e_no" type="text" value="'.$e_no.'" size="5">,

	Nama :
	<input name="e_nama" type="text" value="'.$e_nama.'" size="50">,
	<br>

	Point :
	<input name="e_point" type="text" value="'.$e_point.'" size="5">,

	Sanksi :
	<input name="e_sanksi" type="text" value="'.$e_sanksi.'" size="50">
	<br>
	<INPUT type="hidden" name="jnskd" value="'.$jnskd.'">
	<INPUT type="hidden" name="s" value="'.$s.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';


	//query
	$q = mysql_query("SELECT * FROM m_bk_point ".
				"WHERE kd_jenis = '$jnskd' ".
				"ORDER BY round(no) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	if ($total != 0)
		{
		echo '<p>
		<table width="800" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="10"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Point</font></strong></td>
		<td width="300"><strong><font color="'.$warnatext.'">Sanksi</font></strong></td>
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
			$i_kd = nosql($row['kd']);
			$i_no = balikin2($row['no']);
			$i_nama = balikin2($row['nama']);
			$i_point = balikin2($row['point']);
			$i_sanksi = balikin2($row['sanksi']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>
			<a href="'.$filenya.'?s=edit&jnskd='.$jnskd.'&kd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_no.'</td>
			<td>'.$i_nama.'</td>
			<td>'.$i_point.'</td>
			<td>'.$i_sanksi.'</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="800" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$total.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="jnskd" type="hidden" value="'.$jnskd.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
		</tr>
		</table>
		</p>';
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
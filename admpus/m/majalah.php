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
$filenya = "majalah.php";
$diload = "document.formx.kode.focus();";
$judul = "Data Majalah";
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
	$kode = nosql($_POST['kode']);
	$e_nama = cegah2($_POST['e_nama']);
	$e_masa = cegah2($_POST['e_masa']);
	$e_jenis = cegah2($_POST['e_jenis']);
	$e_bahasa = cegah2($_POST['e_bahasa']);
	$e_kota = cegah2($_POST['e_kota']);
	$e_penerbit = cegah2($_POST['e_penerbit']);


	//jika baru
	if ($s == "baru")
		{
		//nek null
		if (empty($e_nama))
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
			///cek
			$qcc = mysql_query("SELECT * FROM perpus_m_majalah2 ".
						"WHERE nama = '$e_nama' ".
						"AND kd_masa = '$e_masa' ".
						"AND kd_majalah = '$e_jenis'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Majalah ini Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=baru";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO perpus_m_majalah2(kd, nama, kd_masa, kd_majalah, ".
						"kd_bahasa, kd_kota, kd_penerbit) VALUES ".
						"('$kd', '$e_nama', '$e_masa', '$e_jenis', ".
						"'$e_bahasa', '$e_kota', '$e_penerbit')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}
		}

	//jika update
	else if ($s == "edit")
		{
		//query
		mysql_query("UPDATE perpus_m_majalah2 SET nama = '$e_nama', ".
				"kd_masa = '$e_masa', ".
				"kd_majalah = '$e_jenis', ".
				"kd_bahasa = '$e_bahasa', ".
				"kd_kota = '$e_kota', ".
				"kd_penerbit = '$e_penerbit' ".
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
		mysql_query("DELETE FROM perpus_m_majalah2 ".
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
	$qx = mysql_query("SELECT * FROM perpus_m_majalah2 ".
				"WHERE kd = '$kd'");
	$rowx = mysql_fetch_assoc($qx);
	$e_kd_masa = nosql($rowx['kd_masa']);
	$e_kd_majalah = nosql($rowx['kd_majalah']);
	$e_kd_bahasa = nosql($rowx['kd_bahasa']);
	$e_kd_kota = nosql($rowx['kd_kota']);
	$e_kd_penerbit = nosql($rowx['kd_penerbit']);
	$e_nama = balikin2($rowx['nama']);


	//query
	$qkatx = mysql_query("SELECT * FROM perpus_m_masa ".
				"WHERE kode = '$e_kd_masa'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_masa = balikin2($rkatx['nama']);


	//query
	$qkatx = mysql_query("SELECT * FROM perpus_m_majalah ".
				"WHERE kode = '$e_kd_majalah'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_majalah = balikin2($rkatx['nama']);


	//query
	$qkatx = mysql_query("SELECT * FROM perpus_m_bahasa ".
				"WHERE kode = '$e_kd_bahasa'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_bahasa = balikin2($rkatx['nama']);


	//query
	$qkatx = mysql_query("SELECT * FROM perpus_m_kota ".
				"WHERE kode = '$e_kd_kota'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_kota = balikin2($rkatx['nama']);


	//query
	$qkatx = mysql_query("SELECT * FROM perpus_penerbit ".
				"WHERE kd = '$e_kd_penerbit'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_penerbit = balikin2($rkatx['nama']);


	echo '<p>
	Nama Majalah :
	<br>
	<input name="e_nama" type="text" value="'.$e_nama.'" size="30">
	</p>

	<p>
	Masa :
	<br>
	<select name="e_masa">
	<option value="'.$e_kd_masa.'" selected>'.$e_masa.'</option>';

	//list
	$qkat = mysql_query("SELECT * FROM perpus_m_masa ".
				"WHERE kd <> '$e_kd_masa' ".
				"ORDER BY nama ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_kode = nosql($rkat['kode']);
		$kat_nama = balikin($rkat['nama']);

		echo '<option value="'.$kat_kode.'">'.$kat_nama.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	</p>


	<p>
	Jenis :
	<br>
	<select name="e_jenis">
	<option value="'.$e_kd_majalah.'" selected>'.$e_majalah.'</option>';

	//list
	$qkat = mysql_query("SELECT * FROM perpus_m_majalah ".
				"WHERE kd <> '$e_kd_majalah' ".
				"ORDER BY nama ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_kode = nosql($rkat['kode']);
		$kat_nama = balikin($rkat['nama']);

		echo '<option value="'.$kat_kode.'">'.$kat_nama.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	</p>

	<p>
	Bahasa :
	<br>
	<select name="e_bahasa">
	<option value="'.$e_kd_bahasa.'" selected>'.$e_bahasa.'</option>';

	//list
	$qkat = mysql_query("SELECT * FROM perpus_m_bahasa ".
				"WHERE kd <> '$e_kd_bahasa' ".
				"ORDER BY nama ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_kode = nosql($rkat['kode']);
		$kat_nama = balikin($rkat['nama']);

		echo '<option value="'.$kat_kode.'">'.$kat_nama.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	</p>


	<p>
	Kota :
	<br>
	<select name="e_kota">
	<option value="'.$e_kd_kota.'" selected>'.$e_kota.'</option>';

	//list
	$qkat = mysql_query("SELECT * FROM perpus_m_kota ".
				"WHERE kd <> '$e_kd_kota' ".
				"ORDER BY nama ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_kode = nosql($rkat['kode']);
		$kat_nama = balikin($rkat['nama']);

		echo '<option value="'.$kat_kode.'">'.$kat_nama.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	</p>


	<p>
	Penerbit :
	<br>
	<select name="e_penerbit">
	<option value="'.$e_kd_penerbit.'" selected>'.$e_penerbit.'</option>';

	//list
	$qkat = mysql_query("SELECT * FROM perpus_penerbit ".
				"WHERE kd <> '$e_kd_penerbit' ".
				"ORDER BY nama ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_nama = balikin($rkat['nama']);

		echo '<option value="'.$kat_kd.'">'.$kat_nama.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
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

	$sqlcount = "SELECT * FROM perpus_m_majalah2 ".
			"ORDER BY nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	if ($count != 0)
		{
		echo '<table border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="200"><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Masa</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Jenis</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Bahasa</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Kota Terbit</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Penerbit</font></strong></td>
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
			$i_kd_masa = nosql($data['kd_masa']);
			$i_kd_majalah = nosql($data['kd_majalah']);
			$i_kd_bahasa = nosql($data['kd_bahasa']);
			$i_kd_kota = nosql($data['kd_kota']);
			$i_kd_penerbit = nosql($data['kd_penerbit']);
			$i_nama = balikin2($data['nama']);


			//query
			$qx = mysql_query("SELECT * FROM perpus_m_masa ".
						"WHERE kode = '$i_kd_masa'");
			$rowx = mysql_fetch_assoc($qx);
			$i_masa = balikin2($rowx['nama']);


			//query
			$qx = mysql_query("SELECT * FROM perpus_m_majalah ".
						"WHERE kode = '$i_kd_majalah'");
			$rowx = mysql_fetch_assoc($qx);
			$i_majalah = balikin2($rowx['nama']);


			//query
			$qx = mysql_query("SELECT * FROM perpus_m_bahasa ".
						"WHERE kode = '$i_kd_bahasa'");
			$rowx = mysql_fetch_assoc($qx);
			$i_bahasa = balikin2($rowx['nama']);


			//query
			$qx = mysql_query("SELECT * FROM perpus_m_kota ".
						"WHERE kode = '$i_kd_kota'");
			$rowx = mysql_fetch_assoc($qx);
			$i_kota = balikin2($rowx['nama']);


			//query
			$qx = mysql_query("SELECT * FROM perpus_penerbit ".
						"WHERE kd = '$i_kd_penerbit'");
			$rowx = mysql_fetch_assoc($qx);
			$i_penerbit = balikin2($rowx['nama']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_nama.'</td>
			<td>'.$i_masa.'</td>
			<td>'.$i_majalah.'</td>
			<td>'.$i_bahasa.'</td>
			<td>'.$i_kota.'</td>
			<td>'.$i_penerbit.'</td>
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
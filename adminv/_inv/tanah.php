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
require("../../inc/cek/adminv.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "tanah.php";
$judul = "Daftar Tanah";
$judulku = "[$inv_session : $nip13_session. $nm13_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$brgkd = nosql($_REQUEST['brgkd']);




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




//nek df
if ($_POST['btnDF'])
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
	$kdx = nosql($_REQUEST['brgkd']);

	//query
	$qx = mysql_query("SELECT DATE_FORMAT(status_tgl_sertifikat, '%d') AS sert_tgl, ".
				"DATE_FORMAT(status_tgl_sertifikat, '%m') AS sert_bln, ".
				"DATE_FORMAT(status_tgl_sertifikat, '%Y') AS sert_thn, ".
				"inv_tanah.* ".
				"FROM inv_tanah ".
				"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$x_kode = nosql($rowx['no_kode']);
	$x_nama = balikin2($rowx['nama']);
	$x_noreg = balikin2($rowx['no_reg']);
	$x_luas = nosql($rowx['luas']);
	$x_thn_ada = nosql($rowx['thn_pengadaan']);
	$x_alamat = balikin2($rowx['alamat']);
	$x_status_hak = balikin2($rowx['status_hak']);

	$y_sert_tgl = nosql($rowx['sert_tgl']);
	$y_sert_bln = nosql($rowx['sert_bln']);
	$y_sert_thn = nosql($rowx['sert_thn']);

	$x_status_no_sertifikat = balikin2($rowx['status_no_sertifikat']);
	$x_status_no_sertifikat = balikin2($rowx['status_no_sertifikat']);
	$x_penggunaan = balikin2($rowx['penggunaan']);
	$x_asal_usul = balikin2($rowx['asal_usul']);
	$x_ket = balikin2($rowx['ket']);
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$brgkd = nosql($_POST['brgkd']);
	$page = nosql($_POST['page']);
	$kode = nosql($_POST['kode']);
	$nama = cegah($_POST['nama']);
	$no_reg = cegah($_POST['no_reg']);
	$luas = cegah($_POST['luas']);
	$thn_ada = nosql($_POST['thn_ada']);
	$alamat = cegah($_POST['alamat']);
	$status_hak = cegah($_POST['status_hak']);
	$sert_tgl = nosql($_POST['sert_tgl']);
	$sert_bln = nosql($_POST['sert_bln']);
	$sert_thn = nosql($_POST['sert_thn']);
	$status_tgl_sertifikat = "$sert_thn:$sert_bln:$sert_tgl";
	$status_no_sertifikat = cegah($_POST['status_no_sertifikat']);
	$penggunaan = cegah($_POST['penggunaan']);
	$asal_usul = cegah($_POST['asal_usul']);
	$ket = cegah($_POST['ket']);


	//nek null
	if ((empty($kode)) OR (empty($nama)) OR (empty($no_reg)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=$s";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ($s == "baru")
			{
			///cek
			$qcc = mysql_query("SELECT * FROM inv_tanah ".
						"WHERE no_kode = '$kode'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Kode Tanah tersebut, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=$s";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO inv_tanah(kd, nama, no_kode, no_reg, luas, ".
						"thn_pengadaan, alamat, status_hak, status_tgl_sertifikat, ".
						"status_no_sertifikat, penggunaan, asal_usul, ket) VALUES ".
						"('$x', '$nama', '$kode', '$no_reg', '$luas', ".
						"'$thn_ada', '$alamat', '$status_hak', '$status_tgl_sertifikat', ".
						"'$status_no_sertifikat', '$penggunaan', '$asal_usul', '$ket')");

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
			mysql_query("UPDATE inv_tanah SET nama = '$nama', ".
					"no_kode = '$kode', ".
					"no_reg = '$no_reg', ".
					"luas = '$luas', ".
					"thn_pengadaan = '$thn_ada', ".
					"alamat = '$alamat', ".
					"status_hak = '$status_hak', ".
					"status_tgl_sertifikat = '$status_tgl_sertifikat', ".
					"status_no_sertifikat = '$status_no_sertifikat', ".
					"penggunaan = '$penggunaan', ".
					"asal_usul = '$asal_usul', ".
					"ket = '$ket' ".
					"WHERE kd = '$brgkd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}






//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$page = nosql($_POST['page']);


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM inv_tanah ".
			"ORDER BY nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	//ambil semua
	do
		{
		//nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM inv_tanah ".
				"WHERE kd = '$kd'");
		}
	while ($data = mysql_fetch_assoc($result));

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?page=$page";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/adminv.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();


//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//nke baru ato edit /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (($s == "baru") OR ($s == "edit"))
	{
	echo '<p>
	Nama :
	<br>
	<input name="nama" type="text" value="'.$x_nama.'" size="30">
	</p>

	<p>
	Kode :
	<br>
	<input name="kode" type="text" value="'.$x_kode.'" size="10">
	</p>

	<p>
	No.Reg :
	<br>
	<input name="no_reg" type="text" value="'.$x_noreg.'" size="10">
	</p>

	<p>
	Luas :
	<br>
	<input name="luas" type="text" value="'.$x_luas.'" size="10">M<sup>2</sup>
	</p>

	<p>
	Tahun Pengadaan :
	<br>
	<input name="thn_ada" type="text" value="'.$x_thn_ada.'" size="4">
	</p>

	<p>
	Alamat :
	<br>
	<input name="alamat" type="text" value="'.$x_alamat.'" size="30">
	</p>

	<p>
	Status Hak :
	<br>
	<input name="status_hak" type="text" value="'.$x_status_hak.'" size="10">
	</p>

	<p>
	Tanggal Sertifikat :
	<br>
	<select name="sert_tgl">
	<option value="'.$y_sert_tgl.'" selected>'.$y_sert_tgl.'</option>';
	for ($i=1;$i<=31;$i++)
		{
		echo '<option value="'.$i.'">'.$i.'</option>';
		}

	echo '</select>
	<select name="sert_bln">
	<option value="'.$y_sert_bln.'" selected>'.$arrbln1[$y_sert_bln].'</option>';
	for ($j=1;$j<=12;$j++)
		{
		echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
		}

	echo '</select>
	<select name="sert_thn">
	<option value="'.$y_sert_thn.'" selected>'.$y_sert_thn.'</option>';
	for ($k=$sert01;$k<=$sert02;$k++)
		{
		echo '<option value="'.$k.'">'.$k.'</option>';
		}
	echo '</select>
	</p>

	<p>
	Nomor Sertifikat :
	<br>
	<input name="status_no_sertifikat" type="text" value="'.$x_status_no_sertifikat.'" size="20">
	</p>

	<p>
	Penggunaan :
	<br>
	<input name="penggunaan" type="text" value="'.$x_penggunaan.'" size="20">
	</p>

	<p>
	Asal Usul :
	<br>
	<input name="asal_usul" type="text" value="'.$x_asal_usul.'" size="10">
	</p>

	<p>
	Keterangan :
	<br>
	<input name="ket" type="text" value="'.$x_ket.'" size="20">
	</p>

	<p>
	<INPUT type="hidden" name="s" value="'.$s.'">
	<INPUT type="hidden" name="brgkd" value="'.$brgkd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>
	<br>';
	}
else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM inv_tanah ".
			"ORDER BY nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	echo '[<a href="'.$filenya.'?s=baru">Entri Baru</a>]';

	if ($count != 0)
		{
		echo '<p>
		<table width="900" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">No.Reg</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Luas</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Thn. Pengadaan</font></strong></td>
		<td width="200"><strong><font color="'.$warnatext.'">Alamat</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Status Hak</font></strong></td>
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
			$i_nama = balikin2($data['nama']);
			$i_kode = balikin2($data['no_kode']);
			$i_noreg = balikin2($data['no_reg']);
			$i_luas = balikin2($data['luas']);
			$i_thn_ada = nosql($data['thn_pengadaan']);
			$i_alamat = balikin2($data['alamat']);
			$i_status_hak = balikin2($data['status_hak']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        	</td>
			<td>
			<a href="'.$filenya.'?page='.$page.'&s=edit&brgkd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_nama.'</td>
			<td>'.$i_kode.'</td>
			<td>'.$i_noreg.'</td>
			<td>'.$i_luas.' M<sup>2</sup></td>
			<td>'.$i_thn_ada.'</td>
			<td>'.$i_alamat.'</td>
			<td>'.$i_status_hak.'</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="900" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="300">
		<input name="page" type="hidden" value="'.$page.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="brgkd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>
		</p>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>BELUM ADA DATA</strong>.
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
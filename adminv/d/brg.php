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
$filenya = "brg.php";
$judul = "Daftar Barang";
$judulku = "$judul  [$inv_session : $nip10_session. $nm10_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$katkd = nosql($_REQUEST['katkd']);
$brgkd = nosql($_REQUEST['brgkd']);
$kd = nosql($_REQUEST['kd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

//focus
if (empty($katkd))
	{
	$diload = "document.formx.kategori.focus();";
	}
else
	{
	if ((empty($s)) OR ($s == "edit"))
		{
		$diload = "document.formx.kode.focus();";
		}

	else if ($s == "ada")
		{
		$diload = "document.formx.no_seri.focus();";
		}

	else if ($s == "stock")
		{
		$diload = "document.formx.jml_bagus.focus();";
		}
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?katkd=$katkd";
	xloc($ke);
	exit();
	}




//nek df
if ($_POST['btnDF'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?katkd=$katkd";
	xloc($ke);
	exit();
	}





//jika edit
if ($s == "edit")
	{
	//nilai
	$katkd = nosql($_REQUEST['katkd']);
	$kdx = nosql($_REQUEST['brgkd']);
	$page = nosql($_REQUEST['page']);

	//query
	$qx = mysql_query("SELECT * FROM inv_brg ".
				"WHERE kd_kategori = '$katkd' ".
				"AND kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$x_kode = nosql($rowx['kode']);
	$x_nama = balikin2($rowx['nama']);
	$x_harga = nosql($rowx['harga']);
	$x_satuankd = nosql($rowx['kd_satuan']);
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$katkd = nosql($_POST['katkd']);
	$brgkd = nosql($_POST['brgkd']);
	$page = nosql($_POST['page']);
	$kode = nosql($_POST['kode']);
	$nama = cegah($_POST['nama']);
	$harga = nosql($_POST['harga']);
	$satuan = nosql($_POST['satuan']);



	//nek null
	if ((empty($kode)) OR (empty($nama)) OR (empty($harga)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?katkd=$katkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if (empty($s))
			{
			///cek
			$qcc = mysql_query("SELECT * FROM inv_brg ".
						"WHERE kode = '$kode'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Kode Barang tersebut, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?katkd=$katkd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO inv_brg(kd, kd_kategori, kd_satuan, kode, nama, harga) VALUES ".
						"('$x', '$katkd', '$satuan', '$kode', '$nama', '$harga')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?katkd=$katkd";
				xloc($ke);
				exit();
				}
			}

		//jika update
		else if ($s == "edit")
			{
			//query
			mysql_query("UPDATE inv_brg SET kode = '$kode', ".
					"nama = '$nama', ".
					"harga = '$harga', ".
					"kd_satuan = '$satuan' ".
					"WHERE kd_kategori = '$katkd' ".
					"AND kd = '$brgkd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?katkd=$katkd&page=$page";
			xloc($ke);
			exit();
			}
		}
	}





//jika simpan- pengadaan
if ($_POST['btnSMP2'])
	{
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);
	$katkd = nosql($_POST['katkd']);
	$brgkd = nosql($_POST['brgkd']);
	$page = nosql($_POST['page']);
	$no_seri = nosql($_POST['no_seri']);
	$merk = cegah($_POST['merk']);
	$model = cegah($_POST['model']);
	$jenis_bahan = cegah($_POST['jenis_bahan']);
	$thn_buat = nosql($_POST['thn_buat']);
	$beli_tgl = nosql($_POST['beli_tgl']);
	$beli_bln = nosql($_POST['beli_bln']);
	$beli_thn = nosql($_POST['beli_thn']);
	$tgl_beli = "$beli_thn:$beli_bln:$beli_tgl";

	$sumber_dana = cegah($_POST['sumber_dana']);
	$jml = nosql($_POST['jml']);


	//nek null
	if ((empty($no_seri)) OR (empty($merk)) OR (empty($model)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?page=1&s=ada&katkd=$katkd&brgkd=$brgkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika edit
		if ($a == "edit")
			{
			//query
			mysql_query("UPDATE inv_brg_pengadaan SET no_seri = '$no_seri', ".
					"merk = '$merk', ".
					"model = '$model', ".
					"jenis_bahan = '$jenis_bahan', ".
					"tahun_buat = '$thn_buat', ".
					"tgl_beli = '$tgl_beli', ".
					"sumber_dana = '$sumber_dana', ".
					"jml = '$jml' ".
					"WHERE kd_brg = '$brgkd' ".
					"AND kd = '$kd'");

			}
		else
			{
			//query
			mysql_query("INSERT INTO inv_brg_pengadaan(kd, kd_brg, no_seri, merk, model, jenis_bahan, ".
					"tahun_buat, tgl_beli, sumber_dana, jml) VALUES ".
					"('$x', '$brgkd', '$no_seri', '$merk', '$model', '$jenis_bahan', ".
					"'$thn_buat', '$tgl_beli', '$sumber_dana', '$jml')");


			//masukkan ke persediaan
			mysql_query("INSERT INTO inv_brg_persediaan (kd, kd_brg, tgl_buku, kode_unit, ".
					"tgl_faktur, dari_kepada, jml_masuk, jml_sisa) VALUES ".
					"('$x', '$brgkd', '$today', '$no_seri', ".
					"'$tgl_beli', '$sumber_dana', '$jml', '$jml')");
			}

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$ke = "$filenya?page=1&s=ada&katkd=$katkd&brgkd=$brgkd";
		xloc($ke);
		exit();
		}
	}





//jika simpan- persediaan
if ($_POST['btnSMP3'])
	{
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);
	$katkd = nosql($_POST['katkd']);
	$kd = nosql($_POST['kd']);
	$brgkd = nosql($_POST['brgkd']);

	$buku_tgl = nosql($_POST['buku_tgl']);
	$buku_bln = nosql($_POST['buku_bln']);
	$buku_thn = nosql($_POST['buku_thn']);
	$tgl_buku = "$buku_thn:$buku_bln:$buku_tgl";

	$kode_unit = cegah($_POST['kode_unit']);
	$no_faktur = nosql($_POST['no_faktur']);
	$faktur_tgl = nosql($_POST['faktur_tgl']);
	$faktur_bln = nosql($_POST['faktur_bln']);
	$faktur_thn = nosql($_POST['faktur_thn']);
	$tgl_faktur = "$faktur_thn:$faktur_bln:$faktur_tgl";

	$dari_kepada = cegah($_POST['dari_kepada']);
	$jml_masuk = nosql($_POST['jml_masuk']);
	$jml_keluar = nosql($_POST['jml_keluar']);
	$jml_sisa = nosql($_POST['jml_sisa']);
	$ket = cegah($_POST['ket']);



	//nek null
	if (empty($buku_tgl))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?katkd=$katkd&page=1&s=sedia&brgkd=$brgkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if (empty($a))
			{
			//insert
			mysql_query("INSERT INTO inv_brg_persediaan (kd, kd_brg, tgl_buku, kode_unit, no_faktur, ".
					"tgl_faktur, dari_kepada, jml_masuk, jml_keluar, jml_sisa, ket) VALUES ".
					"('$x', '$brgkd', '$tgl_buku', '$kode_unit', '$no_faktur', ".
					"'$tgl_faktur', '$dari_kepada', '$jml_masuk', '$jml_keluar', '$jml_sisa', '$ket')");
			}
		else
			{
			//update
			mysql_query("UPDATE inv_brg_persediaan SET tgl_buku = '$tgl_buku', ".
					"kode_unit = '$kode_unit', ".
					"no_faktur = '$no_faktur', ".
					"tgl_faktur = '$tgl_faktur', ".
					"dari_kepada = '$dari_kepada', ".
					"jml_masuk = '$jml_masuk', ".
					"jml_keluar = '$jml_keluar', ".
					"jml_sisa = '$jml_sisa', ".
					"ket = '$ket' ".
					"WHERE kd_brg = '$brgkd' ".
					"AND kd = '$kd'");
			}



		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$ke = "$filenya?katkd=$katkd&page=1&s=sedia&brgkd=$brgkd";
		xloc($ke);
		exit();
		}
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$katkd = nosql($_POST['katkd']);
	$page = nosql($_POST['page']);



	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM inv_brg ".
			"WHERE kd_kategori = '$katkd' ".
			"AND ORDER BY kode ASC";
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

		//del brg
		mysql_query("DELETE FROM inv_brg ".
				"WHERE kd_kategori = '$katkd' ".
				"AND kd = '$kd'");

		//del brg pengadaan
		mysql_query("DELETE FROM inv_brg_pengadaan ".
				"WHERE kd_brg = '$kd'");
		}
	while ($data = mysql_fetch_assoc($result));

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?katkd=$katkd&page=$page";
	xloc($ke);
	exit();
	}





//jika hapus - pengadaan
if ($_POST['btnHPS2'])
	{
	//ambil nilai
	$s = nosql($_POST['s']);
	$katkd = nosql($_POST['katkd']);
	$brgkd = nosql($_POST['brgkd']);
	$page = nosql($_POST['page']);


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM inv_brg_pengadaan ".
			"WHERE kd_brg = '$brgkd' ".
			"ORDER BY round(no_seri) ASC";
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
		mysql_query("DELETE FROM inv_brg_pengadaan ".
				"WHERE kd = '$kd'");
		}
	while ($data = mysql_fetch_assoc($result));

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?s=ada&katkd=$katkd&brgkd=$brgkd&page=$page";
	xloc($ke);
	exit();
	}





//jika hapus - persediaan
if ($_POST['btnHPS3'])
	{
	//ambil nilai
	$s = nosql($_POST['s']);
	$katkd = nosql($_POST['katkd']);
	$brgkd = nosql($_POST['brgkd']);
	$page = nosql($_POST['page']);


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM inv_brg_persediaan ".
			"WHERE kd_brg = '$brgkd' ".
			"ORDER BY tgl_buku ASC";
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
		mysql_query("DELETE FROM inv_brg_persediaan ".
				"WHERE kd_brg = '$brgkd' ".
				"AND kd = '$kd'");
		}
	while ($data = mysql_fetch_assoc($result));

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?s=sedia&katkd=$katkd&brgkd=$brgkd&page=$page";
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
require("../../inc/js/jumpmenu.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';
echo "Kategori : <select name=\"kategori\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM inv_kategori ".
			"WHERE kd = '$katkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_kat = balikin($rowkeax['kategori']);

echo '<option value="'.$keax_kd.'">'.$keax_kat.'</option>';

$qkea = mysql_query("SELECT * FROM inv_kategori ".
			"WHERE kd <> '$katkd' ".
			"ORDER BY kategori ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_kat = balikin($rowkea['kategori']);

	echo '<option value="'.$filenya.'?katkd='.$kea_kd.'">'.$kea_kat.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>';



//pilih kategori
if (empty($katkd))
	{
	echo '<p>
	<font color="red"><strong>Kategori Belum Ditentukan...!!.</strong></font>
	</p>';
	}
else
	{
	//nke null ato edit /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ((empty($s)) OR ($s == "edit"))
		{
		echo '<p>
		Kode :
		<input name="kode" type="text" value="'.$x_kode.'" size="10">,

		Nama :
		<input name="nama" type="text" value="'.$x_nama.'" size="30">,
		<br>

		Harga Satuan :
		Rp.<input name="harga" type="text" size="10" value="'.$x_harga.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00 ,

		Satuan :
		<select name="satuan">';
		//terpilih
		$qkeax = mysql_query("SELECT * FROM inv_satuan ".
					"WHERE kd = '$x_satuankd'");
		$rowkeax = mysql_fetch_assoc($qkeax);
		$keax_kd = nosql($rowkeax['kd']);
		$keax_satuan = balikin($rowkeax['satuan']);

		echo '<option value="'.$keax_kd.'">'.$keax_satuan.'</option>';

		$qkea = mysql_query("SELECT * FROM inv_satuan ".
					"WHERE kd <> '$x_satuankd' ".
					"ORDER BY satuan ASC");
		$rowkea = mysql_fetch_assoc($qkea);

		do
			{
			$kea_kd = nosql($rowkea['kd']);
			$kea_satuan = balikin($rowkea['satuan']);

			echo '<option value="'.$kea_kd.'">'.$kea_satuan.'</option>';
			}
		while ($rowkea = mysql_fetch_assoc($qkea));

		echo '</select>

		<br>
		<INPUT type="hidden" name="katkd" value="'.$katkd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">
		</p>
		<br>';


		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM inv_brg ".
				"WHERE kd_kategori = '$katkd' ".
				"ORDER BY kode ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katkd=$katkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);


		if ($count != 0)
			{
			echo '<p>
			<table width="700" border="1" cellspacing="0" cellpadding="3">
			<tr align="center" bgcolor="'.$warnaheader.'">
			<td width="1%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
			<td width="150"><strong><font color="'.$warnatext.'">Harga</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Pengadaan</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Persediaan</font></strong></td>
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
				$i_kode = nosql($data['kode']);
				$i_nama = balikin2($data['nama']);
				$i_harga = nosql($data['harga']);
				$i_satuankd = nosql($data['kd_satuan']);

				//detail
				$qstu = mysql_query("SELECT * FROM inv_satuan ".
							"WHERE kd = '$i_satuankd'");
				$rstu = mysql_fetch_assoc($qstu);
				$stu_satuan = balikin($rstu['satuan']);


				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
				</td>
				<td>
				<a href="'.$filenya.'?page='.$page.'&s=edit&katkd='.$katkd.'&brgkd='.$i_kd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				<td align="right">'.xduit2($i_harga).'</td>
				<td>'.$stu_satuan.'</td>
				<td>
				<a href="'.$filenya.'?page='.$page.'&s=ada&katkd='.$katkd.'&brgkd='.$i_kd.'" title="Pengadaan Barang : '.$i_kode.'.'.$i_nama.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>
				<a href="'.$filenya.'?page='.$page.'&s=sedia&katkd='.$katkd.'&brgkd='.$i_kd.'" title="Persediaan Barang : '.$i_kode.'.'.$i_nama.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="700" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="300">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="a" type="hidden" value="'.$a.'">
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
		}



	//jika pengadaan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($s == "ada")
		{
		//nilai
		$a = nosql($_REQUEST['a']);
		$katkd = nosql($_REQUEST['katkd']);
		$brgkd = nosql($_REQUEST['brgkd']);


		//detail
		$qdt = mysql_query("SELECT * FROM inv_brg ".
					"WHERE kd_kategori = '$katkd' ".
					"AND kd = '$brgkd'");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);
		$dt_kode = nosql($rdt['kode']);
		$dt_nama = balikin2($rdt['nama']);



		//jika edit
		if ($a == "edit")
			{
			$qedi = mysql_query("SELECT DATE_FORMAT(tgl_beli, '%d') AS beli_tgl, ".
						"DATE_FORMAT(tgl_beli, '%m') AS beli_bln, ".
						"DATE_FORMAT(tgl_beli, '%Y') AS beli_thn, ".
						"inv_brg_pengadaan.* ".
						"FROM inv_brg_pengadaan ".
						"WHERE kd_brg = '$brgkd' ".
						"AND kd = '$kd'");
			$redi = mysql_fetch_assoc($qedi);
			$tedi = mysql_num_rows($qedi);

			$x_noseri = balikin($redi['no_seri']);
			$x_merk = balikin($redi['merk']);
			$x_model = balikin($redi['model']);
			$x_jns_bahan = balikin($redi['jenis_bahan']);
			$x_thn_buat = nosql($redi['tahun_buat']);
			$x_sumber_dana = balikin($redi['sumber_dana']);
			$x_jml = balikin($redi['jml']);
			$x_beli_tgl = nosql($redi['beli_tgl']);
			$x_beli_bln = nosql($redi['beli_bln']);
			$x_beli_thn = nosql($redi['beli_thn']);
			}


		echo '<p>
		<hr>
		Pengadaan Barang : <strong>['.$dt_kode.']. '.$dt_nama.'</strong>
		<hr>
		</p>
		<p>
		No. Seri :
		<input name="no_seri" type="text" value="'.$x_noseri.'" size="10">,

		Merk :
		<input name="merk" type="text" value="'.$x_merk.'" size="10">,

		Model :
		<input name="model" type="text" value="'.$x_model.'" size="10">,

		Jenis Bahan :
		<input name="jenis_bahan" type="text" value="'.$x_jns_bahan.'" size="10">,
		<br>

		Tahun Pembuatan :
		<input name="thn_buat" type="text" value="'.$x_thn_buat.'" size="4" onKeyPress="return numbersonly(this, event)">,

		Tanggal Pembelian :
		<select name="beli_tgl">
		<option value="'.$x_beli_tgl.'" selected>'.$x_beli_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="beli_bln">
		<option value="'.$x_beli_bln.'" selected>'.$arrbln1[$x_beli_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="beli_thn">
		<option value="'.$x_beli_thn.'" selected>'.$x_beli_thn.'</option>';
		for ($k=$terima01;$k<=$terima02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>,
		<br>

		Sumber Dana :
		<input name="sumber_dana" type="text" value="'.$x_sumber_dana.'" size="30">,

		Jumlah :
		<input name="jml" type="text" value="'.$x_jml.'" size="10" onKeyPress="return numbersonly(this, event)">
		<br>
		<input name="s" type="hidden" value="ada">
		<input name="a" type="hidden" value="'.$a.'">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="brgkd" type="hidden" value="'.$brgkd.'">
		<input name="kd" type="hidden" value="'.$kd.'">
		<input name="btnSMP2" type="submit" value="SIMPAN">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnDF" type="submit" value="DAFTAR BARANG LAIN >>">
		</p>
		<br>';


		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM inv_brg_pengadaan ".
				"WHERE kd_brg = '$brgkd' ".
				"ORDER BY no_seri ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?s=ada&katkd=$katkd&brgkd=$brgkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);

		if ($count != 0)
			{
			echo '<p>
			<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="1%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td width="150"><strong><font color="'.$warnatext.'">No. Seri</font></strong></td>
			<td width="150"><strong><font color="'.$warnatext.'">Merk</font></strong></td>
			<td width="150"><strong><font color="'.$warnatext.'">Model</font></strong></td>
			<td width="150"><strong><font color="'.$warnatext.'">Jenis Bahan</font></strong></td>
			<td><strong>&nbsp;</td>
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
				$i_noseri = nosql($data['no_seri']);
				$i_merk = balikin2($data['merk']);
				$i_model = balikin2($data['model']);
				$i_jnsbahan = balikin2($data['jenis_bahan']);
				$i_thn_buat = nosql($data['tahun_buat']);
				$i_tgl_beli = $data['tgl_beli'];
				$i_sumber_dana = balikin2($data['sumber_dana']);
				$i_jml = nosql($data['jml']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
				</td>
				<td>
				<a href="'.$filenya.'?katkd='.$katkd.'&brgkd='.$brgkd.'&s=ada&a=edit&kd='.$i_kd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>'.$i_noseri.'</td>
				<td>'.$i_merk.'</td>
				<td>'.$i_model.'</td>
				<td>'.$i_jnsbahan.'</td>
				<td>
				Tahun Pembuatan : <strong>'.$i_thn_buat.'</strong>
				<br>

				Tanggal Pembelian : <strong>'.$i_tgl_beli.'</strong>
				<br>

				Sumber Dana : <strong>'.$i_sumber_dana.'</strong>
				<br>

				Jumlah : <strong>'.$i_jml.'</strong>
				<br>
				</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="300">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPS2" type="submit" value="HAPUS">
			</td>
			<td align="right">Total : <strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
			</tr>
			</table>
			</p>';
			}
		}



	//jika persediaan////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$s = nosql($_REQUEST['s']);
	$a = nosql($_REQUEST['a']);



	if ($s == "sedia")
		{
		//nilai
		$katkd = nosql($_REQUEST['katkd']);
		$brgkd = nosql($_REQUEST['brgkd']);
		$kd = nosql($_REQUEST['kd']);



		//detail
		$qdt = mysql_query("SELECT * FROM inv_brg ".
					"WHERE kd_kategori = '$katkd' ".
					"AND kd = '$brgkd'");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);
		$dt_kode = nosql($rdt['kode']);
		$dt_nama = balikin2($rdt['nama']);


		//jika edit
		if ($a == "edit")
			{
			//data persediaan
			$qsto = mysql_query("SELECT DATE_FORMAT(tgl_buku, '%d') AS buku_tgl, ".
						"DATE_FORMAT(tgl_buku, '%m') AS buku_bln, ".
						"DATE_FORMAT(tgl_buku, '%Y') AS buku_thn, ".
						"DATE_FORMAT(tgl_faktur, '%d') AS faktur_tgl, ".
						"DATE_FORMAT(tgl_faktur, '%m') AS faktur_bln, ".
						"DATE_FORMAT(tgl_faktur, '%Y') AS faktur_thn, ".
						"inv_brg_persediaan.* FROM inv_brg_persediaan ".
						"WHERE kd_brg = '$brgkd' ".
						"AND kd = '$kd'");
			$rsto = mysql_fetch_assoc($qsto);
			$tsto = mysql_num_rows($qsto);
			$sto_buku_tgl = nosql($rsto['buku_tgl']);
			$sto_buku_bln = nosql($rsto['buku_bln']);
			$sto_buku_thn = nosql($rsto['buku_thn']);
			$sto_kode_unit = balikin($rsto['kode_unit']);
			$sto_no_faktur = nosql($rsto['no_faktur']);
			$sto_faktur_tgl = nosql($rsto['faktur_tgl']);
			$sto_faktur_bln = nosql($rsto['faktur_bln']);
			$sto_faktur_thn = nosql($rsto['faktur_thn']);
			$sto_dari_kepada = balikin($rsto['dari_kepada']);
			$sto_jml_masuk = nosql($rsto['jml_masuk']);
			$sto_jml_keluar = nosql($rsto['jml_keluar']);
			$sto_jml_sisa = nosql($rsto['jml_sisa']);
			$sto_ket = balikin($rsto['ket']);
			}


		echo '<p>
		<hr>
		Kartu Persedian Barang : <strong>['.$dt_kode.']. '.$dt_nama.'</strong>
		<hr>
		</p>
		<p>
		Tgl.Pembukuan :
		<select name="buku_tgl">
		<option value="'.$sto_buku_tgl.'" selected>'.$sto_buku_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="buku_bln">
		<option value="'.$sto_buku_bln.'" selected>'.$arrbln1[$sto_buku_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="buku_thn">
		<option value="'.$sto_buku_thn.'" selected>'.$sto_buku_thn.'</option>';
		for ($k=$buku01;$k<=$buku02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>,

		Kode Unit :
		<input name="kode_unit" type="text" value="'.$sto_kode_unit.'" size="30">,
		<br>

		No., Tgl.Faktur/Bon :
		<input name="no_faktur" type="text" value="'.$sto_no_faktur.'" size="10">,
		<select name="faktur_tgl">
		<option value="'.$sto_faktur_tgl.'" selected>'.$sto_faktur_tgl.'</option>';
		for ($i=1;$i<=31;$i++)
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}

		echo '</select>
		<select name="faktur_bln">
		<option value="'.$sto_faktur_bln.'" selected>'.$arrbln1[$sto_faktur_bln].'</option>';
		for ($j=1;$j<=12;$j++)
			{
			echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
			}

		echo '</select>
		<select name="faktur_thn">
		<option value="'.$sto_faktur_thn.'" selected>'.$sto_faktur_thn.'</option>';
		for ($k=$terima01;$k<=$terima02;$k++)
			{
			echo '<option value="'.$k.'">'.$k.'</option>';
			}
		echo '</select>,

		Diterima dari/dikeluarkan kepada :
		<input name="dari_kepada" type="text" value="'.$sto_dari_kepada.'" size="30">,
		<br>

		Jumlah Masuk :
		<input name="jml_masuk" type="text" value="'.$sto_jml_masuk.'" size="5" onKeyPress="return numbersonly(this, event)">,

		Jumlah Keluar :
		<input name="jml_keluar" type="text" value="'.$sto_jml_keluar.'" size="5" onKeyPress="return numbersonly(this, event)">,

		Jumlah Sisa :
		<input name="jml_sisa" type="text" value="'.$sto_jml_sisa.'" size="5" onKeyPress="return numbersonly(this, event)">,

		Keterangan :
		<input name="ket" type="text" value="'.$sto_ket.'" size="30">
		<br>


		<input name="s" type="hidden" value="sedia">
		<input name="a" type="hidden" value="'.$a.'">
		<input name="brgkd" type="hidden" value="'.$brgkd.'">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="kd" type="hidden" value="'.$kd.'">
		<input name="btnSMP3" type="submit" value="SIMPAN">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnDF" type="submit" value="DAFTAR BARANG LAIN >>">
		</p>
		<br>';



		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM inv_brg_persediaan ".
				"WHERE kd_brg = '$brgkd' ".
				"ORDER BY tgl_buku DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?s=sedia&katkd=$katkd&brgkd=$brgkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);

		if ($count != 0)
			{
			echo '<p>
			<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr bgcolor="'.$warnaheader.'">
			<td width="1%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td width="100"><strong><font color="'.$warnatext.'">Tgl. Pembukuan</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Kode Unit</font></strong></td>
			<td width="200"><strong><font color="'.$warnatext.'">No., Tgl. Faktur/Bon</font></strong></td>
			<td width="150"><strong><font color="'.$warnatext.'">Diterima dari / dikeluarkan kepada</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Jml. Masuk</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Jml. Keluar</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Jml. Sisa</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Ket.</font></strong></td>
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
				$i_tgl_buku = $data['tgl_buku'];
				$i_kode_unit = balikin($data['kode_unit']);
				$i_no_faktur = balikin($data['no_faktur']);
				$i_tgl_faktur = $data['tgl_faktur'];
				$i_dari_kepada = balikin($data['dari_kepada']);
				$i_jml_masuk = nosql($data['jml_masuk']);
				$i_jml_keluar = nosql($data['jml_keluar']);
				$i_jml_sisa = nosql($data['jml_sisa']);
				$i_ket = balikin($data['ket']);


				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
				</td>
				<td>
				<a href="'.$filenya.'?katkd='.$katkd.'&brgkd='.$brgkd.'&s=sedia&a=edit&kd='.$i_kd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>'.$i_tgl_buku.'</td>
				<td>'.$i_kode_unit.'</td>
				<td>
				'.$i_no_faktur.',
				<br>
				'.$i_tgl_faktur.'
				</td>
				<td>'.$i_dari_kepada.'</td>
				<td>'.$i_jml_masuk.'</td>
				<td>'.$i_jml_keluar.'</td>
				<td>'.$i_jml_sisa.'</td>
				<td>'.$i_ket.'</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="300">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="brgkd" type="hidden" value="'.$brgkd.'">
			<input name="katkd" type="hidden" value="'.$katkd.'">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPS3" type="submit" value="HAPUS">
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
			<strong>BELUM ADA DATA.</strong>
			</font>
			</p>';
			}



		echo '</p>';
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
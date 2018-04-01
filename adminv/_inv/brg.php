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
$judul = "Daftar Barang / Buku Inventaris";
$judulku = "[$inv_session : $nip13_session. $nm13_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$brgkd = nosql($_REQUEST['brgkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

//focus
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
	$page = nosql($_REQUEST['page']);

	//query
	$qx = mysql_query("SELECT * FROM inv_brg ".
						"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);

	$x_kode = nosql($rowx['kode']);
	$x_nama = balikin2($rowx['nama']);
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$brgkd = nosql($_POST['brgkd']);
	$page = nosql($_POST['page']);
	$kode = nosql($_POST['kode']);
	$nama = cegah($_POST['nama']);


	//nek null
	if ((empty($kode)) OR (empty($nama)))
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
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO inv_brg(kd, kode, nama) VALUES ".
								"('$x', '$kode', '$nama')");

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
			mysql_query("UPDATE inv_brg SET kode = '$kode', ".
							"nama = '$nama' ".
							"WHERE kd = '$brgkd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?page=$page";
			xloc($ke);
			exit();
			}
		}
	}





//jika simpan- pengadaan
if ($_POST['btnSMP2'])
	{
	$s = nosql($_POST['s']);
	$brgkd = nosql($_POST['brgkd']);
	$page = nosql($_POST['page']);
	$no_seri = nosql($_POST['no_seri']);
	$merk = cegah($_POST['merk']);
	$model = cegah($_POST['model']);
	$jenis_bahan = cegah($_POST['jenis_bahan']);
	$thn_buat = nosql($_POST['thn_buat']);
	$thn_beli = nosql($_POST['thn_beli']);
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
		$ke = "$filenya?page=1&s=ada&brgkd=$brgkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//query
		mysql_query("INSERT INTO inv_brg_pengadaan(kd, kd_brg, no_seri, merk, model, jenis_bahan, ".
							"tahun_buat, tahun_beli, sumber_dana, jml) VALUES ".
							"('$x', '$brgkd', '$no_seri', '$merk', '$model', '$jenis_bahan', ".
							"'$thn_buat', '$thn_beli', '$sumber_dana', '$jml')");

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$ke = "$filenya?page=1&s=ada&brgkd=$brgkd";
		xloc($ke);
		exit();
		}
	}





//jika simpan- stock
if ($_POST['btnSMP3'])
	{
	$s = nosql($_POST['s']);
	$brgkd = nosql($_POST['brgkd']);
	$jml = nosql($_POST['jml']);
	$jml_bagus = nosql($_POST['jml_bagus']);
	$jml_sedang = nosql($_POST['jml_sedang']);
	$jml_rusak = nosql($_POST['jml_rusak']);
	$jml_hilang = nosql($_POST['jml_hilang']);
	$jml_srh = round($jml_bagus + $jml_sedang + $jml_rusak + $jml_hilang);


	//nek null
	if (empty($jml_bagus))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?page=1&s=stock&brgkd=$brgkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek, jml cukup...?
		if ($jml != $jml_srh)
			{
			//re-direct
			$pesan = "Jumlah Stock Tidak Sesuai. Harap Diperhatikan...!!";
			$ke = "$filenya?page=1&s=stock&brgkd=$brgkd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//cek
			$qcc = mysql_query("SELECT * FROM inv_stock ".
									"WHERE kd_brg = '$brgkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//jika ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE inv_stock SET jml = '$jml', ".
								"jml_bagus = '$jml_bagus', ".
								"jml_sedang = '$jml_sedang', ".
								"jml_rusak = '$jml_rusak', ".
								"jml_hilang = '$jml_hilang ".
								"WHERE kd_brg = '$brgkd'");
				}

			else
				{
				//query
				mysql_query("INSERT INTO inv_stock(kd, kd_brg, jml, jml_bagus, jml_sedang, jml_rusak, jml_hilang) VALUES ".
								"('$x', '$brgkd', '$jml', '$jml_bagus', '$jml_sedang', '$jml_rusak', '$jml_hilang')");

				}

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?page=1&s=stock&brgkd=$brgkd";
			xloc($ke);
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

	$sqlcount = "SELECT * FROM inv_brg ".
					"ORDER BY kode ASC";
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
						"WHERE kd = '$kd'");

		//del brg_keahlian
		mysql_query("DELETE FROM inv_brg_keahlian ".
						"WHERE kd_brg = '$kd'");

		//del brg pengadaan
		mysql_query("DELETE FROM inv_brg_pengadaan ".
						"WHERE kd_brg = '$kd'");

		//del brg stock
		mysql_query("DELETE FROM inv_brg_stock ".
						"WHERE kd_brg = '$kd'");
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





//jika hapus - pengadaan
if ($_POST['btnHPS2'])
	{
	//ambil nilai
	$s = nosql($_POST['s']);
	$brgkd = nosql($_POST['brgkd']);
	$page = nosql($_POST['page']);


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
	$ke = "$filenya?s=ada&brgkd=$brgkd&page=$page";
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


//nke null ato edit /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ((empty($s)) OR ($s == "edit"))
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM inv_brg ".
					"ORDER BY kode ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	echo '<p>
	Kode :
	<input name="kode" type="text" value="'.$x_kode.'" size="10">,

	Nama :
	<input name="nama" type="text" value="'.$x_nama.'" size="30">
	<br>
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>
	<br>';


	if ($count != 0)
		{
		echo '<p>
		<INPUT type="submit" name="btnIM" value="IMPORT">
		<INPUT type="submit" name="btnEX" value="EXPORT">
		<table width="700" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Pengadaan</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Stock</font></strong></td>
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

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>
			<a href="'.$filenya.'?page='.$page.'&s=edit&brgkd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_kode.'</td>
			<td>'.$i_nama.'</td>
			<td>
			<a href="'.$filenya.'?page='.$page.'&s=ada&brgkd='.$i_kd.'" title="Pengadaan : '.$i_kode.'.'.$i_nama.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>
			<a href="'.$filenya.'?page='.$page.'&s=stock&brgkd='.$i_kd.'" title="Stock : '.$i_kode.'.'.$i_nama.'">
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
	$brgkd = nosql($_REQUEST['brgkd']);

	//detail
	$qdt = mysql_query("SELECT * FROM inv_brg ".
							"WHERE kd = '$brgkd'");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);
	$dt_kode = nosql($rdt['kode']);
	$dt_nama = balikin2($rdt['nama']);

	echo 'Pengadaan : <strong>['.$dt_kode.']. '.$dt_nama.'</strong>
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

	Tahun Pembelian :
	<input name="thn_beli" type="text" value="'.$x_thn_beli.'" size="4" onKeyPress="return numbersonly(this, event)">,

	Sumber Dana :
	<input name="sumber_dana" type="text" value="'.$x_sumber_dana.'" size="30">,

	Jumlah :
	<input name="jml" type="text" value="'.$x_jml.'" size="10" onKeyPress="return numbersonly(this, event)">
	<br>
	<input name="s" type="hidden" value="ada">
	<input name="brgkd" type="hidden" value="'.$brgkd.'">
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
	$target = "$filenya?s=ada&brgkd=$brgkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	if ($count != 0)
		{
		echo '<p>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
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
			$i_thn_beli = nosql($data['tahun_beli']);
			$i_sumber_dana = balikin2($data['sumber_dana']);
			$i_jml = nosql($data['jml']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>'.$i_noseri.'</td>
			<td>'.$i_merk.'</td>
			<td>'.$i_model.'</td>
			<td>'.$i_jnsbahan.'</td>
			<td>
			Tahun Pembuatan : <strong>'.$i_thn_buat.'</strong>
			<br>

			Tahun Pembelian : <strong>'.$i_thn_beli.'</strong>
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



//jika stock ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($s == "stock")
	{
	//nilai
	$brgkd = nosql($_REQUEST['brgkd']);

	//detail
	$qdt = mysql_query("SELECT * FROM inv_brg ".
							"WHERE kd = '$brgkd'");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);
	$dt_kode = nosql($rdt['kode']);
	$dt_nama = balikin2($rdt['nama']);

	//nilai dari pengadaan
	$qdaa = mysql_query("SELECT SUM(jml) AS total FROM inv_brg_pengadaan ".
							"WHERE kd_brg = '$brgkd'");
	$rdaa = mysql_fetch_assoc($qdaa);
	$tdaa = mysql_num_rows($qdaa);
	$daa_jml = nosql($rdaa['total']);


	//data stock
	$qsto = mysql_query("SELECT * FROM inv_stock ".
							"WHERE kd_brg = '$brgkd'");
	$rsto = mysql_fetch_assoc($qsto);
	$tsto = mysql_num_rows($qsto);
	$sto_jml_bagus = nosql($rsto['jml_bagus']);
	$sto_jml_sedang = nosql($rsto['jml_sedang']);
	$sto_jml_rusak = nosql($rsto['jml_rusak']);
	$sto_jml_hilang = nosql($rsto['jml_hilang']);


	echo 'Stock : <strong>['.$dt_kode.']. '.$dt_nama.'</strong>
	<p>
	Jumlah Total :
	<input name="jml" type="text" value="'.$daa_jml.'" size="10" class="input" readonly>,

	Jumlah Bagus :
	<input name="jml_bagus" type="text" value="'.$sto_jml_bagus.'" size="10" onKeyPress="return numbersonly(this, event)">,

	Jumlah Sedang :
	<input name="jml_sedang" type="text" value="'.$sto_jml_sedang.'" size="10" onKeyPress="return numbersonly(this, event)">,

	Jumlah Rusak :
	<input name="jml_rusak" type="text" value="'.$sto_jml_rusak.'" size="10" onKeyPress="return numbersonly(this, event)">,

	Jumlah Hilang :
	<input name="jml_hilang" type="text" value="'.$sto_jml_hilang.'" size="10" onKeyPress="return numbersonly(this, event)">
	<br>

	<input name="s" type="hidden" value="stock">
	<input name="brgkd" type="hidden" value="'.$brgkd.'">
	<input name="btnSMP3" type="submit" value="SIMPAN">
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnDF" type="submit" value="DAFTAR BARANG LAIN >>">
	</p>
	<br>';
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
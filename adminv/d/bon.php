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
$filenya = "bon.php";
$judul = "Kartu Bon Barang";
$judulku = "$judul  [$inv_session : $nip10_session. $nm10_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$bonkd = nosql($_REQUEST['bonkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


$ke = "$filenya?bonkd=$bonkd&tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln";





//focus...
if (empty($tapelkd))
{
$diload = "document.formx.tapel.focus();";
}
else if (empty($ubln))
{
$diload = "document.formx.ublnx.focus();";
}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//jika iya, simpan pemohon
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$bon_tgl = nosql($_POST['bon_tgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_bon = "$uthn:$ubln:$bon_tgl";

	$bonkd = nosql($_POST['bonkd']);
	$no_bon = cegah($_POST['no_bon']);
	$pemohon = cegah($_POST['pemohon']);
	$jabatan = cegah($_POST['jabatan']);
	$keperluan = cegah($_POST['keperluan']);
	$s = nosql($_POST['s']);


	//jika update
	if ($s == "edit")
		{
		mysql_query("UPDATE inv_brg_bon SET no_bon = '$no_bon', ".
				"pemohon = '$pemohon', ".
				"jabatan = '$jabatan', ".
				"keperluan = '$keperluan' ".
				"WHERE kd = '$bonkd'");
		}

	else
		{
		//insert
		mysql_query("INSERT INTO inv_brg_bon(kd, no_bon, pemohon, jabatan, keperluan, tgl_bon) VALUES ".
				"('$bonkd', '$no_bon', '$pemohon', '$jabatan', '$keperluan', '$tgl_bon')");
		}


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn&s=detail&bonkd=$bonkd";
	xloc($ke);
	exit();
	}






//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$page = nosql($_POST['page']);


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM inv_brg_bon ".
			"ORDER BY tgl_bon DESC";
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
		mysql_query("DELETE FROM inv_brg_bon ".
				"WHERE kd = '$kd'");
		}
	while ($data = mysql_fetch_assoc($result));

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn&page=$page";
	xloc($ke);
	exit();
	}





//tambah item
if ($_POST['btnTBH'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$s = nosql($_POST['s']);
	$bonkd = nosql($_POST['bonkd']);
	$brgku = nosql($_POST['brgku']);
	$jml = nosql($_POST['jml']);
	$ket = cegah($_POST['ket']);


	//cek
	if ((empty($brgku)) OR (empty($jml)))
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn&s=detail&bonkd=$bonkd";
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek lagi
		$qcc = mysql_query("SELECT * FROM inv_brg_bon_detail ".
					"WHERE kd_bon = '$bonkd' ".
					"AND kd_brg = '$brgku'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//jika ada
		if ($tcc != 0)
			{
			$pesan = "Barang Tersebut Sudah Ada, Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn&s=detail&bonkd=$bonkd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//tentang bon
			$qkunx = mysql_query("SELECT * FROM inv_brg_bon ".
						"WHERE kd = '$bonkd'");
			$rkunx = mysql_fetch_assoc($qkunx);
			$kunx_pemohon = balikin($rkunx['pemohon']);


			//ketahui jumlah terakhir, barangnya...
			$qsto = mysql_query("SELECT * FROM inv_brg_persediaan ".
						"ORDER BY tgl_buku DESC");
			$rsto = mysql_fetch_assoc($qsto);
			$sto_jml = nosql($rsto['jml']);

			//batasan...
			//jika sesuai
			if ($sto_jml > $jml)
				{
				//ketahui sisanya...
				$sisa_akhir = round($sto_jml-$jml);


				//update persediaan
				mysql_query("INSERT INTO inv_brg_persediaan (kd, kd_brg, tgl_buku, no_faktur, ".
						"tgl_faktur, dari_kepada, jml_keluar, jml_sisa) VALUES ".
						"('$x', '$brgku', '$today', '$no_bon', ".
						"'$today', '$kunx_pemohon', '$jml', '$sisa_akhir')");

				//insert
				mysql_query("INSERT INTO inv_brg_bon_detail(kd, kd_bon, kd_brg, jml, ket) VALUES ".
						"('$x', '$bonkd', '$brgku', '$jml', '$ket')");

				//re-direct
				$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn&s=detail&bonkd=$bonkd";
				xloc($ke);
				exit();
				}
			else if ($sto_jml < $jml)
				{
				//re-direct
				$pesan = "Jumlah Barang Yang Diajukan, Melebihi Persediaan Yang Ada. Harap Diperhatikan...!!";
				$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn&s=detail&bonkd=$bonkd";
				pekem($pesan,$ke);
				exit();
				}
			}
		}
	}





//jika hapus detail
if ($_POST['btnHPS2'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$bonkd = nosql($_POST['bonkd']);
	$s = nosql($_POST['s']);
	$total = nosql($_POST['total']);


	//ambil semua
	for ($i=1; $i<=$total;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM inv_brg_bon_detail ".
				"WHERE kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn&s=detail&bonkd=$bonkd";
	xloc($ke);
	exit();
	}





//ke daftar
if ($_POST['btnDFT'])
	{
	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn";
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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?bonkd='.$bonkd.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,

Bulan : ';
echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?bonkd='.$bonkd.'&tapelkd='.$tapelkd.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?bonkd='.$bonkd.'&tapelkd='.$tapelkd.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>
</td>
</tr>
</table>';


//jika baru
if (($s == "baru") OR ($s == "edit"))
	{
	//query
	$qdt = mysql_query("SELECT DATE_FORMAT(tgl_bon, '%d') AS tgl, ".
				"DATE_FORMAT(tgl_bon, '%m') AS bln, ".
				"DATE_FORMAT(tgl_bon, '%Y') AS thn, ".
				"inv_brg_bon.* ".
				"FROM inv_brg_bon ".
				"WHERE kd = '$bonkd'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_bon_tgl = nosql($rdt['tgl']);
	$dt_bon_bln = nosql($rdt['bln']);
	$dt_bon_thn = nosql($rdt['thn']);
	$dt_no_bon = balikin($rdt['no_bon']);
	$dt_pemohon = balikin($rdt['pemohon']);
	$dt_jabatan = balikin($rdt['jabatan']);
	$dt_keperluan = balikin($rdt['keperluan']);



	echo '<p>
	Tanggal Bon :
	<br>
	<select name="bon_tgl">
	<option value="'.$dt_bon_tgl.'" selected>'.$dt_bon_tgl.' '.$arrbln[$dt_bon_bln].' '.$dt_bon_thn.'</option>';
	for ($i=1;$i<=31;$i++)
		{
		echo '<option value="'.$i.'">'.$i.' '.$arrbln[$ubln].' '.$uthn.'</option>';
		}
	echo '</select>
	</p>

	<p>
	No.Bon :
	<br>
	<input name="no_bon" type="text" value="'.$dt_no_bon.'" size="10">
	<br>
	<br>
	Nama Pemohon :
	<br>
	<input name="pemohon" type="text" value="'.$dt_pemohon.'" size="30">
	<br>
	<br>
	Jabatan :
	<br>
	<input name="jabatan" type="text" value="'.$dt_jabatan.'" size="30">
	<br>
	<br>
	Keperluan :
	<br>
	<input name="keperluan" type="text" value="'.$dt_keperluan.'" size="30">
	<br>
	<br>
	<br>

	<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
	<INPUT type="hidden" name="ubln" value="'.$ubln.'">
	<INPUT type="hidden" name="uthn" value="'.$uthn.'">
	<INPUT type="hidden" name="s" value="'.$s.'">
	<INPUT type="hidden" name="bonkd" value="'.$bonkd.'">
	<INPUT type="hidden" name="page" value="'.$page.'">
	<input name="btnBTL" type="submit" value="BATAL">
	<input name="btnSMP" type="submit" value="SIMPAN >>">
	</p>';
	}

else if ($s == "detail")
	{
	//query
	$qdtx = mysql_query("SELECT * FROM inv_brg_bon ".
				"WHERE kd = '$bonkd'");
	$rdtx = mysql_fetch_assoc($qdtx);
	$dtx_no_bon = balikin($rdtx['no_bon']);
	$dtx_pemohon = balikin($rdtx['pemohon']);
	$dtx_jabatan = balikin($rdtx['jabatan']);
	$dtx_keperluan = balikin($rdtx['keperluan']);
	$dtx_serah = balikin($rdtx['serah']);

	$dtx_tgl_bon = $rdtx['tgl_bon'];


	echo '<p>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warna02.'">
	<td>
	Tgl. Bon : <strong>'.$dtx_tgl_bon.'</strong>.
	No.Bon :
	<strong>'.$dtx_no_bon.'</strong>.
	Pemohon :
	<strong>'.$dtx_pemohon.'</strong>.
	Jabatan :
	<strong>'.$dtx_jabatan.'</strong>.
	Keperluan :
	<strong>'.$dtx_keperluan.'</strong>
	<br>

	[<a href="'.$filenya.'?tapelkd='.$tapelkd.'&ubln='.$ubln.'&uthn='.$uthn.'&s=edit&bonkd='.$bonkd.'">EDIT</a>].
	[<a href="bon_prt.php?tapelkd='.$tapelkd.'&ubln='.$ubln.'&uthn='.$uthn.'&bonkd='.$bonkd.'"><img src="'.$sumber.'/img/print.gif" border="0" width="16" height="16"></a>].
	</td>
	</tr>
	</table>
	</p>
	<br>';


	//daftar barang
	$qbri = mysql_query("SELECT inv_brg.*, inv_brg.kd AS bkd ".
				"FROM inv_brg ".
				"ORDER BY round(kode) ASC");
	$rbri = mysql_fetch_assoc($qbri);


	echo '<select name="brgku">
	<option value="" selected>-DATA BARANG-</option>';

	do
		{
		//nilai
		$bri_kd = nosql($rbri['bkd']);
		$bri_kode = balikin($rbri['kode']);
		$bri_nama = balikin($rbri['nama']);

		echo '<option value="'.$bri_kd.'">'.$bri_kode.'. '.$bri_nama.'</option>';
		}
	while ($rbri = mysql_fetch_assoc($qbri));

	echo '</select>,

	Jumlah :
	<input name="jml" type="text" value="1" size="5" onKeyPress="return numbersonly(this, event)">,

	Keterangan :
	<input name="ket" type="text" value="-" size="20">

	<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
	<INPUT type="hidden" name="ubln" value="'.$ubln.'">
	<INPUT type="hidden" name="uthn" value="'.$uthn.'">
	<INPUT type="hidden" name="bonkd" value="'.$bonkd.'">
	<INPUT type="hidden" name="s" value="'.$s.'">
	<INPUT type="submit" name="btnTBH" value="TAMBAH >>">';


	//daftarnya...
	$qdft = mysql_query("SELECT inv_brg.*, inv_brg_bon_detail.*, inv_brg_bon_detail.kd AS bkd ".
				"FROM inv_brg, inv_brg_bon_detail ".
				"WHERE inv_brg_bon_detail.kd_brg = inv_brg.kd ".
				"AND inv_brg_bon_detail.kd_bon = '$bonkd'");
	$rdft = mysql_fetch_assoc($qdft);
	$tdft = mysql_num_rows($qdft);


	//jika ada
	if ($tdft != 0)
		{
		echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1%">&nbsp;</td>
		<td width="200"><strong><font color="'.$warnatext.'">Jenis Barang.</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jumlah.</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Keterangan</font></strong></td>
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



			//nilai
			$nomer = $nomer + 1;
			$dft_kd = nosql($rdft['bkd']);
			$dft_brg = balikin($rdft['nama']);
			$dft_jml = nosql($rdft['jml']);
			$dft_ket = balikin($rdft['ket']);
			$dft_stkd = nosql($rdft['kd_satuan']);

			//satuan
			$qsty = mysql_query("SELECT * FROM inv_satuan ".
						"WHERE kd = '$dft_stkd'");
			$rsty = mysql_fetch_assoc($qsty);
			$sty_satuan = balikin($rsty['satuan']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$dft_kd.'">
			</td>
			<td>
			'.$dft_brg.'
			</td>
			<td>
			'.$dft_jml.'
			</td>
			<td>
			'.$sty_satuan.'
			</td>

			<td>
			'.$dft_ket.'
			</td>
			</tr>';
			}
		while ($rdft = mysql_fetch_assoc($qdft));

		echo '</table>
		<table width="600" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
		<INPUT type="hidden" name="ubln" value="'.$ubln.'">
		<INPUT type="hidden" name="uthn" value="'.$uthn.'">
		<input name="total" type="hidden" value="'.$tdft.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tdft.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS2" type="submit" value="HAPUS">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$tdft.'</font></strong> Data.</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan entry...</strong>
		</font>
		</p>';
		}







	echo '<p>
	<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
	<INPUT type="hidden" name="ubln" value="'.$ubln.'">
	<INPUT type="hidden" name="uthn" value="'.$uthn.'">
	<INPUT type="submit" name="btnDFT" value="<< DAFTAR KARTU BON BARANG LAINNYA">
	</p>';
	}

else
	{
	//jika tapel
	if (empty($tapelkd))
		{
		echo '<p>
		<font color="red">
		<strong>TAHUN PELAJARAN Belum Dipilih...!!.</strong>
		</font>
		</p>';
		}
	//bulan
	else if ((empty($ubln)) OR (empty($uthn)))
		{
		echo '<p>
		<font color="red">
		<strong>BULAN Belum Dipilih...!!.</strong>
		</font>
		</p>';
		}
	else
		{
		echo '[<a href="'.$filenya.'?tapelkd='.$tapelkd.'&ubln='.$ubln.'&uthn='.$uthn.'&s=baru&bonkd='.$x.'">Tulis Baru</a>].';


		//daftar bon
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM inv_brg_bon ".
				"WHERE round(DATE_FORMAT(tgl_bon, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(tgl_bon, '%Y')) = '$uthn' ".
				"ORDER BY tgl_bon DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);


		if ($count != 0)
			{
			echo '<table width="400" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="1%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td width="100"><strong><font color="'.$warnatext.'">Tgl.Bon</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Nama Pemohon.</font></strong></td>
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
				$i_tgl = $data['tgl_bon'];
				$i_pemohon = balikin2($data['pemohon']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
				</td>
				<td>
				<a href="'.$filenya.'?s=edit&bonkd='.$i_kd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>'.$i_tgl.'</td>
				<td>'.$i_pemohon.'</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));


			echo '</table>
			<table width="400" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="263">
			<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
			<INPUT type="hidden" name="ubln" value="'.$ubln.'">
			<INPUT type="hidden" name="uthn" value="'.$uthn.'">
			<input name="jml" type="hidden" value="'.$count.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="kd" type="hidden" value="'.$kdx.'">
			<INPUT type="hidden" name="bonkd" value="'.$bonkd.'">
			<INPUT type="hidden" name="page" value="'.$page.'">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')">
			<input name="btnBTL" type="submit" value="BATAL">
			<input name="btnHPS" type="submit" value="HAPUS">
			</td>
			<td align="right">Total : <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
			</tr>
			</table>';
			}

		else
			{
			echo '<p>
			<font color="red">
			<strong>BELUM ADA DATA.</strong>
			</font>
			</p>';
			}
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
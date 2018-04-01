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
$filenya = "pengadaan.php";
$judul = "Pengadaan Item";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





//nek enter
$x_enter = 'onkeydown="return handleEnter(this, event)"';
$x_enter2 = 'onkeydown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.item_jml.focus();
	}"';





//jika baru
if ($s == "baru")
	{
	$diload = "document.formx.sup_nama.focus();";
	}
else
	{
	$diload = "document.formx.jml.focus();";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$sup_kd = nosql($_POST['sup_kd']);
	$masuk_tgl = nosql($_POST['masuk_tgl']);
	$masuk_bln = nosql($_POST['masuk_bln']);
	$masuk_thn = nosql($_POST['masuk_thn']);
	$tgl_masuk = "$masuk_thn:$masuk_bln:$masuk_tgl";


	//jika baru
	if ($s == "baru")
		{
		//cek
		$qcc = mysql_query("SELECT * FROM perpus_pengadaan ".
								"WHERE kd_supplier = '$sup_kd' ".
								"AND tgl_masuk = '$tgl_masuk'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//re-direct
			$pesan = "Pengadaan Sudah Ada. Harap Diperhatikan...!!";
			$ke = "$filenya?s=baru";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//insert
			mysql_query("INSERT INTO perpus_pengadaan(kd, kd_supplier, tgl_masuk) VALUES ".
							"('$x', '$sup_kd', '$tgl_masuk')");

			//re-direct
			$ke = "$filenya?s=edit&kd=$x";
			xloc($ke);
			exit();
			}
		}


	//jika edit
	else if ($s == "edit")
		{
		//update
		mysql_query("UPDATE perpus_pengadaan SET kd_supplier = '$sup_kd', ".
						"tgl_masuk = '$tgl_masuk' ".
						"WHERE kd = '$kd'");

		//re-direct
		$ke = "$filenya?s=edit&kd=$kd";
		xloc($ke);
		exit();
		}
	}




//simpan detail
if ($_POST['btnSMP2'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$item_kd = nosql($_POST['item_kd']);
	$item_jml = nosql($_POST['item_jml']);

	//cek
	if ((empty($item_kd)) OR (empty($item_jml)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?s=edit&kd=$kd";
		pekem($pesan,$ke);
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM perpus_pengadaan_detail ".
								"WHERE kd_pengadaan = '$kd' ".
								"AND kd_item = '$item_kd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//re-direct
			$pesan = "Item Tersebut Sudah Ada. Harap Diperhatikan...!!";
			$ke = "$filenya?s=edit&kd=$kd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//insert
			mysql_query("INSERT INTO perpus_pengadaan_detail(kd, kd_pengadaan, kd_item, jml) VALUES ".
							"('$x', '$kd', '$item_kd', '$item_jml')");

			//tambah stock, cek
			$qccx = mysql_query("SELECT * FROM perpus_stock ".
									"WHERE kd_item = '$item_kd'");
			$rccx = mysql_fetch_assoc($qccx);
			$tccx = mysql_num_rows($qccx);
			$ccx_bagus = nosql($rccx['jml_bagus']);
			$ccx_baru = round($ccx_bagus + $item_jml);

			//nek iya
			if ($tccx != 0)
				{
				//update
				mysql_query("UPDATE perpus_stock SET jml_bagus = '$ccx_baru' ".
								"WHERE kd_item = '$item_kd'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO perpus_stock(kd, kd_item, jml_bagus) VALUES ".
								"('$x', '$item_kd', '$ccx_baru')");
				}


			//re-direct
			$ke = "$filenya?s=edit&kd=$kd";
			xloc($ke);
			exit();
			}
		}
	}





//jika hapus pengadaan
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
		$ikd = nosql($_POST["$yuhu"]);



		//pengadaan
		$qcc = mysql_query("SELECT * FROM perpus_pengadaan ".
								"WHERE kd = '$ikd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);


		//jika ada
		if ($tcc != 0)
			{
			//detail
			$qccx = mysql_query("SELECT * FROM perpus_pengadaan_detail ".
									"WHERE kd_pengadaan = '$ikd'");
			$rccx = mysql_fetch_assoc($qccx);
			$tccx = mysql_num_rows($qccx);

			do
				{
				//nilai
				$ccx_kd = nosql($rccx['kd']);
				$ccx_itemkd = nosql($rccx['kd_item']);
				$ccx_jml = nosql($rccx['jml']);

				//stock
				$qccx2 = mysql_query("SELECT * FROM perpus_stock ".
										"WHERE kd_item = '$ccx_itemkd'");
				$rccx2 = mysql_fetch_assoc($qccx2);
				$tccx2 = mysql_num_rows($qccx2);
				$ccx2_bagus = nosql($rccx2['jml_bagus']);

				//kurangi stock
				$i_akhir = round($ccx2_bagus - $ccx_jml);

				//update
				mysql_query("UPDATE perpus_stock SET jml_bagus = '$i_akhir' ".
								"WHERE kd_item = '$ccx_itemkd'");
				}
			while ($rccx = mysql_fetch_assoc($qccx));


			//del detail
			mysql_query("DELETE FROM perpus_pengadaan_detail ".
							"WHERE kd_pengadaan = '$ikd'");

			//del pengadaan
			mysql_query("DELETE FROM perpus_pengadaan ".
							"WHERE kd = '$ikd'");
			}
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}





//jika hapus detail
if ($_POST['btnHPS2'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$kd = nosql($_POST['kd']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$ikd = nosql($_POST["$yuhu"]);


		//detail
		$qccx = mysql_query("SELECT * FROM perpus_pengadaan_detail ".
								"WHERE kd_pengadaan = '$kd' ".
								"AND kd = '$ikd'");
		$rccx = mysql_fetch_assoc($qccx);
		$tccx = mysql_num_rows($qccx);
		$ccx_itemkd = nosql($rccx['kd_item']);
		$ccx_jml = nosql($rccx['jml']);


		//stock
		$qccx2 = mysql_query("SELECT * FROM perpus_stock ".
								"WHERE kd_item = '$ccx_itemkd'");
		$rccx2 = mysql_fetch_assoc($qccx2);
		$tccx2 = mysql_num_rows($qccx2);
		$ccx2_bagus = nosql($rccx2['jml_bagus']);


		//kurangi stock
		$i_akhir = round($ccx2_bagus - $ccx_jml);


		//update
		mysql_query("UPDATE perpus_stock SET jml_bagus = '$i_akhir' ".
						"WHERE kd_item = '$ccx_itemkd'");


		//del
		mysql_query("DELETE FROM perpus_pengadaan_detail ".
						"WHERE kd_pengadaan = '$kd' ".
						"AND kd = '$ikd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?s=edit&kd=$kd";
	xloc($ke);
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
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<script type="text/javascript" src="'.$sumber.'/inc/js/dhtmlwindow_pus.js"></script>
<script type="text/javascript" src="'.$sumber.'/inc/js/modal.js"></script>
<script type="text/javascript">
function open_brg()
	{
	brg_window=dhtmlmodal.open(\'Daftar Item\',
	\'iframe\',
	\'popup_item.php\',
	\'Daftar Item\',
	\'width=550px,height=350px,center=1,resize=0,scrolling=0\')

	brg_window.onclose=function()
		{
		var item_kd=this.contentDoc.getElementById("item_kd");
		var item_nama=this.contentDoc.getElementById("item_nama");

		document.formx.item_kd.value=item_kd.value;
		document.formx.item_nama.value=item_nama.value;
		document.formx.item_jml.focus();
		return true
		}
	}

function open_sup()
	{
	sup_window=dhtmlmodal.open(\'Daftar Supplier\',
	\'iframe\',
	\'popup_supplier.php\',
	\'Daftar Supplier\',
	\'width=550px,height=350px,center=1,resize=0,scrolling=0\')

	sup_window.onclose=function()
		{
		var sup_kd=this.contentDoc.getElementById("sup_kd");
		var sup_nama=this.contentDoc.getElementById("sup_nama");

		document.formx.sup_kd.value=sup_kd.value;
		document.formx.sup_nama.value=sup_nama.value;
		document.formx.masuk_tgl.focus();
		return true
		}
	}
</script>';


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
	//edit
	$qdit = mysql_query("SELECT DATE_FORMAT(tgl_masuk, '%d') AS tgl, ".
							"DATE_FORMAT(tgl_masuk, '%m') AS bln, ".
							"DATE_FORMAT(tgl_masuk, '%Y') AS thn, ".
							"perpus_pengadaan.* ".
							"FROM perpus_pengadaan ".
							"WHERE kd = '$kd'");
	$rdit = mysql_fetch_assoc($qdit);
	$e_masuk_tgl = nosql($rdit['tgl']);
	$e_masuk_bln = nosql($rdit['bln']);
	$e_masuk_thn = nosql($rdit['thn']);
	$e_supkd = nosql($rdit['kd_supplier']);


	//supplier
	$qsup = mysql_query("SELECT * FROM perpus_supplier ".
							"WHERE kd = '$e_supkd'");
	$rsup = mysql_fetch_assoc($qsup);
	$sup_nama = balikin2($rsup['nama']);


	echo '<p>
	Supplier :
	<br>
	<input name="sup_nama" type="text" value="'.$sup_nama.'" size="30" class="input" readonly>
	<input name="btnSUP" type="button" value="..." onClick="open_sup(); return false">
	<input name="sup_kd" type="hidden" value="">
	<br>
	<br>
	Tgl. Masuk :
	<br>
	<select name="masuk_tgl">
	<option value="'.$e_masuk_tgl.'" selected>'.$e_masuk_tgl.'</option>';
	for ($i=1;$i<=31;$i++)
		{
		echo '<option value="'.$i.'">'.$i.'</option>';
		}

	echo '</select>
	<select name="masuk_bln">
	<option value="'.$e_masuk_bln.'" selected>'.$arrbln1[$e_masuk_bln].'</option>';
	for ($j=1;$j<=12;$j++)
		{
		echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
		}

	echo '</select>
	<select name="masuk_thn">
	<option value="'.$e_masuk_thn.'" selected>'.$e_masuk_thn.'</option>';
	for ($k=$masuk01;$k<=$masuk02;$k++)
		{
		echo '<option value="'.$k.'">'.$k.'</option>';
		}
	echo '</select>
	<br>
	<br>
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="DAFTAR PENGADAAN >>">
	</p>';


	//jika edit
	if ($s == "edit")
		{
		echo '<hr>
		<p>
		Item BarCode :
		<input name="item_kode" type="text" value="" size="30" '.$x_enter2.'>
		<input name="btnITEM" type="button" value="..." onClick="open_brg(); return false">
		<input name="item_kd" type="hidden" value="">
		Jumlah :
		<input name="item_jml" type="text" value="" size="5" onKeyPress="return numbersonly(this, event)">
		<input name="btnSMP2" type="submit" value="TAMBAH >>">
		</p>

		<p>';
		//detail item
		$qdt = mysql_query("SELECT perpus_pengadaan_detail.*, perpus_pengadaan_detail.kd AS dkd, ".
					"perpus_item.* ".
					"FROM perpus_pengadaan_detail, perpus_item ".
					"WHERE perpus_pengadaan_detail.kd_item = perpus_item.kd ".
					"AND perpus_pengadaan_detail.kd_pengadaan = '$kd' ".
					"ORDER BY round(perpus_item.kode) ASC");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);

		//nek ada
		if ($tdt != 0)
			{
			echo '<table width="500" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
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

				$nox = $nox + 1;
				$i_kd = nosql($rdt['dkd']);
				$i_itemkd = nosql($rdt['kd_item']);
				$i_jml = nosql($rdt['jml']);

				//brg item
				$qtemx = mysql_query("SELECT * FROM perpus_item ".
										"WHERE kd = '$i_itemkd'");
				$rtemx = mysql_fetch_assoc($qtemx);
				$temx_kode = nosql($rtemx['kode']);
				$temx_nama = balikin2($rtemx['judul']);


				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nox.'" value="'.$i_kd.'">
		        	</td>
				<td>'.$temx_kode.'. '.$temx_nama.'</td>
				<td>'.$i_jml.'</td>
		        	</tr>';
				}
			while ($rdt = mysql_fetch_assoc($qdt));

			echo '</tr>
			</td>
			</table>
			<table width="500" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td>
			<input name="jml" type="hidden" value="'.$tdt.'">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tdt.')">
			<input name="btnHPS2" type="submit" value="HAPUS">
			</td>
			</tr>
			</table>';
			}
		else
			{
			echo '<font color="red"><strong>Belum Ada Data Item.</strong></font>';
			}

		echo '</p>';
		}
	}

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT DATE_FORMAT(tgl_masuk, '%d') AS tgl, ".
					"DATE_FORMAT(tgl_masuk, '%m') AS bln, ".
					"DATE_FORMAT(tgl_masuk, '%Y') AS thn, ".
					"perpus_pengadaan.* ".
					"FROM perpus_pengadaan ".
					"ORDER BY tgl_masuk DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	if ($count != 0)
		{
		echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="150"><strong><font color="'.$warnatext.'">Tgl. Masuk</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Supplier</font></strong></td>
		<td width="75"><strong><font color="'.$warnatext.'">Jml. Jenis Item</font></strong></td>
		<td width="75"><strong><font color="'.$warnatext.'">Jml. Item Barang</font></strong></td>
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
			$i_tgl = nosql($data['tgl']);
			$i_bln = nosql($data['bln']);
			$i_thn = nosql($data['thn']);
			$i_supkd = nosql($data['kd_supplier']);


			//supplier
			$qsupi = mysql_query("SELECT * FROM perpus_supplier ".
									"WHERE kd = '$i_supkd'");
			$rsupi = mysql_fetch_assoc($qsupi);
			$supi_nama = balikin2($rsupi['nama']);


			//jumlah jenis item
			$qjum = mysql_query("SELECT * FROM perpus_pengadaan_detail ".
									"WHERE kd_pengadaan = '$i_kd'");
			$rjum = mysql_fetch_assoc($qjum);
			$tjum = mysql_num_rows($qjum);



			//jumlah item barang
			$qjum2 = mysql_query("SELECT SUM(jml) AS jml FROM perpus_pengadaan_detail ".
									"WHERE kd_pengadaan = '$i_kd'");
			$rjum2 = mysql_fetch_assoc($qjum2);
			$tjum2 = mysql_num_rows($qjum2);
			$jum2_jml = nosql($rjum2['jml']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_tgl.' '.$arrbln1[$i_bln].' '.$i_thn.'</td>
			<td>'.$supi_nama.'</td>
			<td>'.$tjum.'</td>
			<td>'.$jum2_jml.'</td>
	        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$count.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
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

echo '</form>
<br>
<br>
<br>';
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
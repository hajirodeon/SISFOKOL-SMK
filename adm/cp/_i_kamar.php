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



require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
nocache;


$filenyax = "i_kamar.php";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//tampilkan form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'input'))
	{
	echo '<form name="formx" id="formx">
	<p>
	Kode :
	<br> 
	<input name="e_kode" id="e_kode" type="text" value="'.$e_kode.'" size="10">
	</p>
	
	<p>
	Nama : 
	<br>
	<input name="e_nama" id="e_nama" type="text" value="'.$e_nama.'" size="30">
	</p>
	
	<p>
	Biaya : 
	<br>
	Rp.<input name="e_biaya" id="e_biaya" type="text" value="'.$e_biaya.'" size="10">,00
	</p>
	
	<p>
	<button name="btnSMP" id="btnSMP" type="submit" value="SIMPAN" class="search_btn"><img src="'.$sumber.'/img/save.png" alt="simpan">SIMPAN</button>
	<button name="btnBTL" id="btnBTL" type="reset" value="BATAL" class="search_btn"><img src="'.$sumber.'/img/reset.png" alt="batal">BATAL</button>
	</p>
	</form>';
	}




//tampilkan form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'edit'))
	{
	//nilai
	$kd = nosql($_GET['kd']);
	$s = "edit";

	//query
	$qx = mysql_query("SELECT * FROM m_kamar ".
						"WHERE kd = '$kd'");
	$rowx = mysql_fetch_assoc($qx);
	$e_kode = balikin($rowx['kode']);
	$e_nama = balikin($rowx['nama']);
	$e_biaya = balikin($rowx['biaya']);


	echo '<form name="formx2" id="formx2">
		<p>
	Kode :
	<br> 
	<input name="e_kode" id="e_kode" type="text" value="'.$e_kode.'" size="10">
	</p>
	
	<p>
	Nama : 
	<br>
	<input name="e_nama" id="e_nama" type="text" value="'.$e_nama.'" size="30">
	</p>
	
	<p>
	Biaya : 
	<br>
	Rp.<input name="e_biaya" id="e_biaya" type="text" value="'.$e_biaya.'" size="10">,00 / Malam
	</p>
	
	<p>
	<input name="s" id="s" type="hidden" value="'.$s.'">
	<input name="kd" id="kd" type="hidden" value="'.$kd.'">
	<button name="btnSMP2" id="btnSMP2" type="submit" value="SIMPAN" class="search_btn"><img src="'.$sumber.'/img/save.png" alt="simpan">SIMPAN</button>
	<button name="btnBTL2" id="btnBTL2" type="reset" value="BATAL" class="search_btn"><img src="'.$sumber.'/img/reset.png" alt="batal">BATAL</button>
	</p>
	</form>';
	
	xclose($koneksi);
	exit();
	}






//tampilkan data
if(isset($_GET['aksi']) && $_GET['aksi'] == 'daftar')
	{
	//query
	$q = mysql_query("SELECT * FROM m_kamar ".
						"ORDER BY round(kode) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	if ($total != 0)
		{
		echo '<form name="formx3" id="formx3">
		<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Biaya</font></strong></td>
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
			$kd = nosql($row['kd']);
			$e_kode = balikin($row['kode']);
			$e_kamar = balikin($row['nama']);
			$e_biaya = balikin($row['biaya']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" class="cb-element" name="item'.$nomer.'" id="item'.$nomer.'" value="'.$kd.'">
			</td>
			<td>
			<a href="#" onclick="$(\'#finput\').load(\''.$filenyax.'?aksi=edit&s=edit&kd='.$kd.'\');">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$e_kode.'</td>
			<td>'.$e_kamar.'</td>
			<td align="right">
			Rp.'.$e_biaya.',00
			</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '<tr valign="top" bgcolor="'.$warnaheader.'">
		<td><input type="checkbox" class="checkAll"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="jml" id="jml" type="hidden" value="'.$total.'">
		<button name="btnHPS" id="btnHPS" type="submit" value="HAPUS" class="search_btn"><img src="'.$sumber.'/img/trash.png" alt="delete">HAPUS</button>
		Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
		</tr>
		</table>
		</form>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
		</font>
		</p>';
		}

	//diskonek
	xclose($koneksi);
	exit();
	}







//jika simpan baru
if(isset($_GET['aksi']) && $_GET['aksi'] == 'simpan')
	{
	sleep(1);
	$s = nosql($_GET['s']);
	$kd = nosql($_GET['kd']);
	$kode = nosql($_GET['e_kode']);
	$kamar = cegah2($_GET['e_nama']);
	$biaya = cegah2($_GET['e_biaya']);

	//nek null
	if ((empty($kode)) OR (empty($kamar)))
		{
		echo '<p>
		<b>
		<font color="red">
		Input Tidak Lengkap. Harap Diulangi...!!
		</font>
		</b>
		</p>';
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM m_kamar ".
								"WHERE kode = '$kode'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		if (empty($tcc))
			{
			//query
			mysql_query("INSERT INTO m_kamar(kd, kode, nama, biaya) VALUES ".
							"('$x', '$kode', '$kamar', '$biaya')");


			echo '<p>
			<b>
			<font color="red">
			Input Berhasil.
			</font>
			</b>
			</p>';
			exit();
			}

		//nek ada
		else if (!empty($tcc))
			{
			echo '<p>
			<b>
			<font color="red">
			Sudah Ada. Silahkan Ganti Yang Lain...!!
			</font>
			</b>
			</p>';
			exit();
			}
		}



	//diskonek
	xclose($koneksi);
	exit();
	}







//jika simpan edit
if(isset($_GET['aksi']) && $_GET['aksi'] == 'simpan2')
	{
	sleep(1);
	$s = nosql($_GET['s']);
	$kd = nosql($_POST['kd']);
	$kode = cegah($_POST['e_kode']);
	$kamar = cegah($_POST['e_nama']);
	$biaya = cegah($_POST['e_biaya']);

	//nek null
	if ((empty($kode)) OR (empty($kamar)))
		{
		echo '<p>
		<b>
		<font color="red">
		Input Tidak Lengkap. Harap Diulangi...!!
		</font>
		</b>
		</p>';
		}
	else
		{
		//query
		mysql_query("UPDATE m_kamar SET kode = '$kode', ".
						"nama = '$kamar', ".
						"biaya = '$biaya' ".
						"WHERE kd = '$kd'");


		echo '<p>
		<b>
		<font color="red">
		Update Berhasil.
		</font>
		</b>
		</p>';
		}



	//diskonek
	xclose($koneksi);
	exit();
	}





//jika hapus
if(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus')
	{
	sleep(1);
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
		mysql_query("DELETE FROM m_kamar ".
					"WHERE kd = '$kd'");
		}



	echo '<p>
	<b>
	<font color="red">
	Berhasil Dihapus.
	</font>
	</b>
	</p>';


	//diskonek
	xclose($koneksi);
	exit();
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
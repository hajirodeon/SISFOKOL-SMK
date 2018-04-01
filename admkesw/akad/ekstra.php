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
require("../../inc/cek/admkesw.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "ekstra.php";
$diload = "document.formx.ekstra.focus();";
$judul = "Ekstra";
$judulku = "[$kesw_session : $nip12_session. $nm12_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);



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


//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT * FROM m_ekstra ".
						"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$ekstra = balikin2($rowx['ekstra']);
	$pegkd = nosql($rowx['kd_pegawai']);
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$kd = nosql($_POST['kd']);
	$pegawai = nosql($_POST['pegawai']);
	$ekstra = cegah2($_POST['ekstra']);

	//nek null
	if (empty($ekstra))
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
			//cek
			$qcc = mysql_query("SELECT * FROM m_ekstra ".
									"WHERE ekstra = '$ekstra'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
	
			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);
	
				//re-direct
				$pesan = "Ekstra : $ekstra, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO m_ekstra(kd, ekstra, kd_pegawai) VALUES ".
								"('$x', '$ekstra', '$pegawai')");
	
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
			mysql_query("UPDATE m_ekstra SET ekstra = '$ekstra', ".
							"kd_pegawai = '$pegawai' ".
							"WHERE kd = '$kd'");

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
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_ekstra ".
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
require("../../inc/menu/admkesw.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();




//query
$q = mysql_query("SELECT * FROM m_ekstra ".
					"ORDER BY ekstra ASC");
$row = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);






//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Nama Ekstrakurikuler :
<br>
<input name="ekstra" type="text" value="'.$ekstra.'" size="30">
</p>


<p>
Pembina :
<br>
<select name="pegawai">
<option value="" selected>-Pegawai-</option>';

//data pegawai
$qpeg = mysql_query("SELECT * FROM m_pegawai ".
						"ORDER BY nama ASC");
$rpeg = mysql_fetch_assoc($qpeg);

do
	{
	$peg_kd = nosql($rpeg['kd']);
	$peg_nip = nosql($rpeg['nip']);
	$peg_nm = balikin($rpeg['nama']);

	echo '<option value="'.$peg_kd.'">'.$peg_nip.'. '.$peg_nm.'</option>';
	}
while ($rpeg = mysql_fetch_assoc($qpeg));


echo '</select>
</p>

<p>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>';

if ($total != 0)
	{
	echo '<table width="500" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">Nama Ekstra</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">Pembina Ekstra</font></strong></td>
	</tr>';

	do {
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
		$ekstra = balikin2($row['ekstra']);
		$pegkd = nosql($row['kd_pegawai']);


		//pegawai
		$qdt2 = mysql_query("SELECT * FROM m_pegawai ".
								"WHERE kd = '$pegkd'");
		$rdt2 = mysql_fetch_assoc($qdt2);
		$nip_pegawai = nosql($rdt2['nip']);
		$nama_pegawai = balikin($rdt2['nama']);



		//jumlah siswa yang ikut
		$qdt = mysql_query("SELECT DISTINCT(siswa_ekstra.kd_siswa_kelas) AS total ".
								"FROM m_siswa, siswa_kelas, siswa_ekstra ".
								"WHERE siswa_ekstra.kd_siswa_kelas = siswa_kelas.kd ".
								"AND siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_ekstra.kd_ekstra = '$kd'");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);


		//jika gak null
		if ($tdt != 0)
			{
			$i_wow = "[<a href=\"ekstra_siswa.php?ekskd=$kd\"><strong>$tdt</strong> Siswa</a>].";
			}
		else
			{
			$i_wow = "[<strong>$tdt</strong> Siswa].";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
		</td>
		<td>
		<a href="'.$filenya.'?s=edit&kd='.$kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>
		'.$ekstra.' '.$i_wow.'
		</td>
		<td>
		'.$nip_pegawai.'. '.$nama_pegawai.' 
		</td>
	    </tr>';
		}
	while ($row = mysql_fetch_assoc($q));

	echo '</table>
	<table width="400" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="272">
	<input name="jml" type="hidden" value="'.$total.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	</td>
	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
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
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
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "keahlian_komp.php";
$diload = "document.formx.kompetensi.focus();";
$judul = "Kompetensi Keahlian";
$judulku = "[$waka_session : $nip10_session. $nm10_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$progkd = nosql($_REQUEST['progkd']);




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
	$progkd = nosql($_REQUEST['progkd']);
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
				"WHERE kd_keahlian = '$progkd' ".
				"AND kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_kompetensi = balikin($rowx['kompetensi']);
	$e_singkatan = balikin($rowx['singkatan']);
	$e_pegkd = nosql($rowx['kd_pegawai']);


	//orang e
	$qpgdx = mysql_query("SELECT * FROM m_pegawai ".
				"WHERE kd = '$e_pegkd'");
	$rpgdx = mysql_fetch_assoc($qpgdx);
	$e_peg_nip = nosql($rpgdx['nip']);
	$e_peg_nama = balikin2($rpgdx['nama']);
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$progkd = nosql($_POST['progkd']);
	$kompetensi = cegah($_POST['kompetensi']);
	$pegawai = nosql($_POST['pegawai']);
	$singkatan = cegah($_POST['singkatan']);
	$xxku = md5("$progkd$kompetensi");


	//jika baru
	if (empty($s))
		{
		//nek null
		if ((empty($kompetensi)) OR (empty($singkatan)))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			$ke = "$filenya?progkd=$progkd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
						"WHERE kd_keahlian = '$progkd' ".
						"AND kompetensi = '$kompetensi'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Kompetensi Keahlian : $kompetensi, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?progkd=$progkd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO m_keahlian_kompetensi(kd, kd_keahlian, kompetensi, singkatan, kd_pegawai) VALUES ".
						"('$xxku', '$progkd', '$kompetensi', '$singkatan', '$pegawai')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?progkd=$progkd";
				xloc($ke);
				exit();
				}
			}
		}


	//jika update
	else if ($s == "edit")
		{
		//query
		mysql_query("UPDATE m_keahlian_kompetensi SET kompetensi = '$kompetensi', ".
				"singkatan = '$singkatan', ".
				"kd_pegawai = '$pegawai' ".
				"WHERE kd_keahlian = '$progkd' ".
				"AND kd = '$kd'");

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$ke = "$filenya?progkd=$progkd";
		xloc($ke);
		exit();
		}
	}




//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$progkd = nosql($_POST['progkd']);
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_keahlian_kompetensi ".
				"WHERE kd_keahlian = '$progkd' ".
				"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?progkd=$progkd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//menu
require("../../inc/menu/admwaka.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Program Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$progkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['program']);

echo '<option value="'.$keax_kd.'">--'.$keax_pro.'--</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$progkd' ".
			"ORDER BY program ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['program']);

	echo '<option value="'.$filenya.'?progkd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>
</td>
</tr>
</table>';


//jika null
if (empty($progkd))
	{
	echo '<p>
	<font color="red">
	<strong>PROGRAM KEAHLIAN Belum Ditentukan...!!.</strong>
	</font>
	</p>';
	}
else
	{
	echo '<p>
	Nama Kompetensi Keahlian :
	<br>
	<input name="kompetensi" type="text" value="'.$e_kompetensi.'" size="30">
	</p>

	<p>
	Singkatan :
	<br>
	<input name="singkatan" type="text" value="'.$e_singkatan.'" size="10">
	</p>

	<p>
	Pegawai :
	<br>
	<select name="pegawai">
	<option value="'.$e_pegkd.'" selected>'.$e_peg_nip.'. '.$e_peg_nama.'</option>';

	$qpgd = mysql_query("SELECT * FROM m_pegawai ".
				"ORDER BY round(nip) ASC");
	$rpgd = mysql_fetch_assoc($qpgd);

	do
		{
		$pgd_kd = nosql($rpgd['kd']);
		$pgd_nip = nosql($rpgd['nip']);
		$pgd_nama = balikin2($rpgd['nama']);

		echo '<option value="'.$pgd_kd.'">'.$pgd_nip.'. '.$pgd_nama.'</option>';
		}
	while ($rpgd = mysql_fetch_assoc($qpgd));

	echo '</select>
	</p>

	<p>
	<INPUT type="hidden" name="progkd" value="'.$progkd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';




	//query
	$q = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
				"WHERE kd_keahlian = '$progkd' ".
				"ORDER BY kompetensi ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);



	if ($total != 0)
		{
		echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">Nama Kompetensi</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Singkatan</font></strong></td>
		<td width="200"><strong><font color="'.$warnatext.'">Pegawai</font></strong></td>
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
			$i_kompetensi = balikin2($row['kompetensi']);
			$i_singkatan = balikin2($row['singkatan']);
			$i_pegkd = nosql($row['kd_pegawai']);

			//orang e
			$qpgdx = mysql_query("SELECT * FROM m_pegawai ".
						"WHERE kd = '$i_pegkd'");
			$rpgdx = mysql_fetch_assoc($qpgdx);
			$i_peg_nip = nosql($rpgdx['nip']);
			$i_peg_nama = balikin2($rpgdx['nama']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>
			<a href="'.$filenya.'?progkd='.$progkd.'&s=edit&kd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_kompetensi.'</td>
			<td>'.$i_singkatan.'</td>
			<td>'.$i_peg_nip.'.'.$i_peg_nama.'</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="600" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$total.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="progkd" type="hidden" value="'.$progkd.'">
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

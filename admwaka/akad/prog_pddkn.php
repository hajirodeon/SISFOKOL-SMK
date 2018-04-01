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
$filenya = "prog_pddkn.php";
$judul = "Mata Pelajaran";
$judulku = "[$waka_session : $nip10_session. $nm10_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$progkd = nosql($_REQUEST['progkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$jnskd = nosql($_REQUEST['jnskd']);



//focus
if (empty($progkd))
	{
	$diload = "document.formx.program.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.kompetensi.focus();";
	}
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}
else
	{
	$diload = "document.formx.no.focus();";
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$progkd = nosql($_POST['progkd']);
	$kompkd = nosql($_POST['kompkd']);
	$jnskd = nosql($_POST['jnskd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?progkd=$progkd&kompkd=$kompkd&jnskd=$jnskd";
	xloc($ke);
	exit();
	}





//jika edit
if ($s == "edit")
	{
	//nilai
	$progkd = nosql($_REQUEST['progkd']);
	$kompkd = nosql($_REQUEST['kompkd']);
	$jnskd = nosql($_REQUEST['jnskd']);
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT * FROM m_prog_pddkn ".
				"WHERE kd_keahlian = '$progkd' ".
				"AND kd_keahlian_kompetensi = '$kompkd' ".
				"AND kd_jenis = '$jnskd' ".
				"AND kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$no = nosql($rowx['no']);
	$no_sub = nosql($rowx['no_sub']);
	$no_sub2 = nosql($rowx['no_sub2']);
	$prog_pddkn = balikin($rowx['prog_pddkn']);
	$xpel = balikin($rowx['xpel']);
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$progkd = nosql($_POST['progkd']);
	$kompkd = nosql($_POST['kompkd']);
	$jnskd = nosql($_POST['jnskd']);
	$kd = nosql($_POST['kd']);
	$no = nosql($_POST['no']);
	$no_sub = nosql($_POST['no_sub']);
	$no_sub2 = nosql($_POST['no_sub2']);
	$prog_pddkn = cegah($_POST['prog_pddkn']);
	$xpel = cegah($_POST['xpel']);


	//nek null
	if ((empty($no)) OR (empty($no_sub)) OR (empty($prog_pddkn)) OR (empty($xpel)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?progkd=$progkd&kompkd=$kompkd&jnskd=$jnskd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if (empty($s))
			{
			///cek
			$qcc = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd_keahlian = '$progkd' ".
						"AND kd_keahlian_kompetensi = '$kompkd' ".
						"AND kd_jenis = '$jnskd' ".
						"AND prog_pddkn = '$prog_pddkn'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);


			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Mata Pelajaran : $prog_pddkn, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?progkd=$progkd&kompkd=$kompkd&jnskd=$jnskd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert
				mysql_query("INSERT INTO m_prog_pddkn(kd, kd_keahlian, kd_keahlian_kompetensi, ".
						"kd_jenis, no, no_sub, no_sub2,  prog_pddkn, xpel) VALUES ".
						"('$x', '$progkd', '$kompkd', ".
						"'$jnskd', '$no', '$no_sub', '$no_sub2', '$prog_pddkn', '$xpel')");

				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?progkd=$progkd&kompkd=$kompkd&jnskd=$jnskd";
				xloc($ke);
				exit();
				}
			}


		//jika update
		else if ($s == "edit")
			{
			//update
			mysql_query("UPDATE m_prog_pddkn SET no = '$no', ".
					"no_sub = '$no_sub', ".
					"no_sub2 = '$no_sub2', ".
					"prog_pddkn = '$prog_pddkn', ".
					"xpel = '$xpel' ".
					"WHERE kd_keahlian = '$progkd' ".
					"AND kd_keahlian_kompetensi = '$kompkd' ".
					"AND kd_jenis = '$jnskd' ".
					"AND kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?progkd=$progkd&kompkd=$kompkd&jnskd=$jnskd";
			xloc($ke);
			exit();
			}
		}
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$progkd = nosql($_POST['progkd']);
	$kompkd = nosql($_POST['kompkd']);
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_prog_pddkn ".
				"WHERE kd_keahlian = '$progkd' ".
				"AND kd_keahlian_kompetensi = '$kompkd' ".
				"AND kd_jenis = '$jnskd' ".
				"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?progkd=$progkd&kompkd=$kompkd&jnskd=$jnskd";
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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Program Keahlian : ';
echo "<select name=\"program\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$progkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_program = balikin($rowtpx['program']);

echo '<option value="'.$tpx_kd.'">--'.$tpx_program.'--</option>';

$qtp = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$progkd' ".
			"ORDER BY program ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tp_kd = nosql($rowtp['kd']);
	$tp_program = balikin($rowtp['program']);

	echo '<option value="'.$filenya.'?progkd='.$tp_kd.'">'.$tp_program.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,


Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd = '$kompkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_kompetensi = balikin($rowtpx['kompetensi']);

echo '<option value="'.$tpx_kd.'">--'.$tpx_kompetensi.'--</option>';

$qtp = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$progkd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tp_kd = nosql($rowtp['kd']);
	$tp_kompetensi = balikin($rowtp['kompetensi']);

	echo '<option value="'.$filenya.'?progkd='.$progkd.'&kompkd='.$tp_kd.'">'.$tp_kompetensi.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna01.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Jenis Mata Pelajaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd = '$jnskd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_jenis = balikin($rowtpx['jenis']);

echo '<option value="'.$tpx_kd.'">'.$tpx_jenis.'</option>';

$qtp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY no ASC, ".
						"no_sub ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tp_kd = nosql($rowtp['kd']);
	$tp_jns = balikin($rowtp['jenis']);

	echo '<option value="'.$filenya.'?progkd='.$progkd.'&kompkd='.$kompkd.'&jnskd='.$tp_kd.'">'.$tp_jns.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';


//nek blm
if (empty($progkd))
	{
	echo '<p>
	<strong><font color="#FF0000">PROGRAM KEAHLIAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($kompkd))
	{
	echo '<p>
	<strong><font color="#FF0000">KOMPETENSI KEAHLIAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($jnskd))
	{
	echo '<p>
	<strong><font color="#FF0000">JENIS MATA PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	//query
	$q = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd_keahlian = '$progkd' ".
						"AND kd_keahlian_kompetensi = '$kompkd' ".
						"AND kd_jenis = '$jnskd' ".
						"ORDER BY round(no) ASC, ".
						"round(no_sub) ASC, ".
						"round(no_sub2) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	echo '<p>
	No. :
	<input name="no" type="text" value="'.$no.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
	No.Sub :
	<input name="no_sub" type="text" value="'.$no_sub.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
	No.Sub2 :
	<input name="no_sub2" type="text" value="'.$no_sub2.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
	<br>
	Nama :
	<input name="prog_pddkn" type="text" value="'.$prog_pddkn.'" size="50">,
	<br>
	Singkatan :
	<input name="xpel" type="text" value="'.$xpel.'" size="30">
	<br>
	<input name="progkd" type="hidden" value="'.$progkd.'">
	<input name="kompkd" type="hidden" value="'.$kompkd.'">
	<input name="jnskd" type="hidden" value="'.$jnskd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>
	<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td width="10"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td width="10"><strong><font color="'.$warnatext.'">No.Sub</font></strong></td>
	<td width="10"><strong><font color="'.$warnatext.'">No.Sub2</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Mata Pelajaran</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Singkatan</font></strong></td>
	</tr>';

	if ($total != 0)
		{
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
			$no = nosql($row['no']);
			$no_sub = nosql($row['no_sub']);
			$no_sub2 = nosql($row['no_sub2']);
			$pel = balikin($row['prog_pddkn']);
			$xpel = balikin($row['xpel']);




			//cek janissari
			$qcc1 = mysql_query("SELECT * FROM m_mapel ".
						"WHERE kd = '$kd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$tcc1 = mysql_num_rows($qcc1);

			//jika ada, update
			if ($tcc1 != 0)
				{
				//update ke janissari
				mysql_query("UPDATE m_mapel SET mapel = '$pel' ".
						"WHERE kd = '$kd'");
				}
			else
				{
				//masukkan ke janissari
				mysql_query("INSERT INTO m_mapel(kd, mapel) VALUES ".
						"('$kd', '$pel')");
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
	        	</td>
			<td>
			<a href="'.$filenya.'?progkd='.$progkd.'&kompkd='.$kompkd.'&s=edit&jnskd='.$jnskd.'&kd='.$kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$no.'</td>
			<td>'.$no_sub.'</td>
			<td>'.$no_sub2.'</td>
			<td>'.$pel.'</td>
			<td>'.$xpel.'</td>
	        	</tr>';
			}
		while ($row = mysql_fetch_assoc($q));
		}

	echo '</table>
	<table width="600" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="263">
	<input name="jml" type="hidden" value="'.$total.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
	<input name="btnBTL" type="submit" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	</td>
	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
	</tr>
	</table>';
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
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
$filenya = "prog_pddkn_kompetensi.php";
$judul = "Data Kompetensi Program Pendidikan";
$judulku = "[$waka_session : $nip10_session. $nm10_session] ==> $judul";
$judulx = $judul;
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$mpkd = nosql($_REQUEST['mpkd']);
$mkkd = nosql($_REQUEST['mkkd']);
$kdx = nosql($_REQUEST['kdx']);
$s = nosql($_REQUEST['s']);
$ke = "$filenya?keakd=$keakd&kompkd=$kompkd&kelkd=$kelkd&jnskd=$jnskd&mpkd=$mpkd&mkkd=$mkkd";



//focus...
if (empty($keakd))
	{
	$diload = "document.formx.keahlian.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.keahlian.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}
else
	{
	$diload = "document.formx.smt.focus();";
	}








//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$smt = nosql($_POST['smt']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);
	$jnskd = nosql($_POST['jnskd']);
	$mpkd = nosql($_POST['mpkd']);
	$mkkd = nosql($_POST['mkkd']);
	$kdx = nosql($_POST['kdx']);
	$k_kode = nosql($_POST['k_kode']);
	$k_nama = cegah($_POST['k_nama']);

	//jika null
	if ((empty($smt)) OR (empty($k_kode)) OR (empty($k_nama)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?keakd=$keakd&kompkd=$kompkd&kelkd=$kelkd&jnskd=$jnskd&mpkd=$mpkd&mkkd=$mkkd&s=detail";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_smt = '$smt' ".
					"AND kd_prog_pddkn_kelas = '$mpkd' ".
					"AND kd = '$kdx'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//not null
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE m_prog_pddkn_kompetensi ".
					"SET kd_smt = '$smt', ".
					"kode = '$k_kode', ".
					"nama = '$k_nama' ".
					"WHERE kd_prog_pddkn_kelas = '$mpkd' ".
					"AND kd = '$kdx'");

			//re-direct
			$ke = "$filenya?keakd=$keakd&kompkd=$kompkd&kelkd=$kelkd&jnskd=$jnskd&mpkd=$mpkd&mkkd=$mkkd&s=detail";
			xloc($ke);
			exit();
			}
		else
			{
			//query
			mysql_query("INSERT INTO m_prog_pddkn_kompetensi(kd, kd_smt, kd_prog_pddkn_kelas, kode, nama) VALUES ".
					"('$x', '$smt', '$mpkd', '$k_kode', '$k_nama')");

			//re-direct
			$ke = "$filenya?keakd=$keakd&kompkd=$kompkd&kelkd=$kelkd&jnskd=$jnskd&mpkd=$mpkd&mkkd=$mkkd&s=detail";
			xloc($ke);
			exit();
			}
		}
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);
	$jnskd = nosql($_POST['jnskd']);
	$mpkd = nosql($_POST['mpkd']);
	$mkkd = nosql($_POST['mkkd']);


	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_prog_pddkn_kompetensi ".
				"WHERE kd_prog_pddkn_kelas = '$mpkd' ".
				"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?keakd=$keakd&kompkd=$kompkd&kelkd=$kelkd&jnskd=$jnskd&mpkd=$mpkd&mkkd=$mkkd&s=detail";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admwaka.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Program Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keakd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxpro = balikin($rowbtx['program']);

echo '<option value="'.$btxkd.'">'.$btxpro.'</option>';

//keahlian
$qbt = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keakd' ".
			"ORDER BY program ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btpro = balikin($rowbt['program']);

	echo '<option value="'.$filenya.'?keakd='.$btkd.'">'.$btpro.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,




Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd = '$kompkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkomp = balikin($rowbtx['kompetensi']);
$btxsingk = nosql($rowbtx['singkatan']);

echo '<option value="'.$btxkd.'">'.$btxkomp.'</option>';

//keahlian
$qbt = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd <> '$keakd' ".
			"ORDER BY kompetensi ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btpro = balikin($rowbt['kompetensi']);

	echo '<option value="'.$filenya.'?keakd='.$keakd.'&kompkd='.$btkd.'">'.$btpro.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>
</td>
</tr>
</table>


<table bgcolor="'.$warna01.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkelx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowkelx = mysql_fetch_assoc($qkelx);
$kelx_kd = nosql($rowkelx['kd']);
$kelx_kelas = balikin($rowkelx['kelas']);

echo '<option value="'.$kelx_kd.'">'.$kelx_kelas.'</option>';

//kelas
$qkel = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd <> '$kelkd' ".
			"AND kelas LIKE '%$btxsingk%' ".
			"ORDER BY kelas ASC, round(no) ASC");
$rowkel = mysql_fetch_assoc($qkel);

do
	{
	$kel_kd = nosql($rowkel['kd']);
	$kel_kelas = balikin($rowkel['kelas']);

	echo '<option value="'.$filenya.'?keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kel_kd.'">'.$kel_kelas.'</option>';
	}
while ($rowkel = mysql_fetch_assoc($qkel));

echo '</select>,

Jenis : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd = '$jnskd'");
$rowjnx = mysql_fetch_assoc($qjnx);

$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['jenis']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY no ASC, ".
						"no_sub ASC");
$rowjn = mysql_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['jenis']);

	echo '<option value="'.$filenya.'?keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>
<input name="keakd" type="hidden" value="'.$keakd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="jnskd" type="hidden" value="'.$jnskd.'">
</td>
</tr>
</table>
<br>';


//nek blm
if (empty($keakd))
	{
	echo '<strong><font color="#FF0000">PROGRAM KEAHLIAN Belum Dipilih...!</font></strong>';
	}

else if (empty($kompkd))
	{
	echo '<strong><font color="#FF0000">KOMPETENSI KEAHLIAN Belum Dipilih...!</font></strong>';
	}

else if (empty($kelkd))
	{
	echo '<strong><font color="#FF0000">KELAS Belum Dipilih...!</font></strong>';
	}

else if (empty($jnskd))
	{
	echo '<strong><font color="#FF0000">JENIS PROGRAM PENDIDIKAN Belum Dipilih...!</font></strong>';
	}

else
	{
	//jika detail kompetensi
	if ($s == "detail")
		{
		//mapel
		$qx1 = mysql_query("SELECT * FROM m_prog_pddkn ".
					"WHERE kd = '$mkkd'");
		$rowx1 = mysql_fetch_assoc($qx1);
		$totalx1 = mysql_num_rows($qx1);
		$x1_pel = balikin($rowx1['prog_pddkn']);


		//edit
		$qdt = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$mpkd' ".
					"AND kd = '$kdx'");
		$rdt = mysql_fetch_assoc($qdt);
		$tdt = mysql_num_rows($qdt);
		$dt_kode = nosql($rdt['kode']);
		$dt_nama = balikin($rdt['nama']);


		echo '<p>
		[<a href="'.$filenya.'?keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&jnskd='.$jnskd.'">Daftar Program Pendidikan</a>]
		<br>
		Nama Kompetensi Dasar : <strong>'.$x1_pel.'</strong>.
		</p>

		<p>
		Semester :
		<br>
		<select name="smt">';

		//terpilih
		$qstx = mysql_query("SELECT * FROM m_smt ".
					"WHERE kd = '$smtkd'");
		$rowstx = mysql_fetch_assoc($qstx);
		$stx_kd = nosql($rowstx['kd']);
		$stx_no = nosql($rowstx['no']);
		$stx_smt = nosql($rowstx['smt']);

		echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

		$qst = mysql_query("SELECT * FROM m_smt ".
					"WHERE kd <> '$smtkd' ".
					"ORDER BY smt ASC");
		$rowst = mysql_fetch_assoc($qst);

		do
			{
			$st_kd = nosql($rowst['kd']);
			$st_smt = nosql($rowst['smt']);

			echo '<option value="'.$st_kd.'">'.$st_smt.'</option>';
			}
		while ($rowst = mysql_fetch_assoc($qst));

		echo '</select>
		</p>

		<p>
		Kode :
		<br>
		<input name="k_kode" type="text" value="'.$dt_kode.'" size="5">
		<br>
		Nama :
		<br>
		<input name="k_nama" type="text" value="'.$dt_nama.'" size="50">
		<br>

		<input name="keakd" type="hidden" value="'.$keakd.'">
		<input name="kompkd" type="hidden" value="'.$kompkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="jnskd" type="hidden" value="'.$jnskd.'">
		<input name="mpkd" type="hidden" value="'.$mpkd.'">
		<input name="mkkd" type="hidden" value="'.$mkkd.'">
		<input name="kdx" type="hidden" value="'.$kdx.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">
		</p>';



		//query
		$q = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$mpkd' ".
					"ORDER BY kode ASC");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);



		if ($total != 0)
			{
			echo '<table width="400" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="1">&nbsp;</td>
			<td width="50"><strong><font color="'.$warnatext.'">Semester</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Materi Pelajaran</font></strong></td>
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
				$i_kd = nosql($row['kd']);
				$i_smtkd = nosql($row['kd_smt']);
				$i_kode = nosql($row['kode']);
				$i_nama = balikin($row['nama']);


				//smt
				$qstxi = mysql_query("SELECT * FROM m_smt ".
							"WHERE kd = '$i_smtkd'");
				$rowstxi = mysql_fetch_assoc($qstxi);
				$stxi_kd = nosql($rowstxi['kd']);
				$stxi_no = nosql($rowstxi['no']);
				$stxi_smt = nosql($rowstxi['smt']);



				//jika ada 'nol'. kategori standar kompetensi
				$i_sk = substr($i_kode,-1);
				if ($i_sk == "0")
					{
					echo "<tr valign=\"top\" bgcolor=\"red\">";
					echo '<td>
					<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
					</td>
					<td>
					<a href="'.$filenya.'?keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&jnskd='.$jnskd.'&mkkd='.$mkkd.'&mpkd='.$mpkd.'&s=detail&kdx='.$i_kd.'">
					<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
					</a>
					</td>
					<td>'.$stxi_smt.'</td>
					<td>'.$i_kode.'</td>
					<td>'.$i_nama.'</td>
					</tr>';
					}
				else
					{
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
					<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
					</td>
					<td>
					<a href="'.$filenya.'?keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&jnskd='.$jnskd.'&mkkd='.$mkkd.'&mpkd='.$mpkd.'&s=detail&kdx='.$i_kd.'">
					<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
					</a>
					</td>
					<td>'.$stxi_smt.'</td>
					<td>'.$i_kode.'</td>
					<td>'.$i_nama.'</td>
					</tr>';
					}
				}
			while ($row = mysql_fetch_assoc($q));

			echo '</table>
			<table width="400" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="272">
			<input name="jml" type="hidden" value="'.$total.'">
			<input name="kdx" type="hidden" value="'.$kdx.'">
			<input name="keakd" type="hidden" value="'.$keakd.'">
			<input name="kompkd" type="hidden" value="'.$kompkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="mpkd" type="hidden" value="'.$mpkd.'">
			<input name="mkkd" type="hidden" value="'.$mkkd.'">
			<input name="s" type="hidden" value="'.$s.'">
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
	else
		{
/*
		//query
		$q = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd, ".
					"m_prog_pddkn.*, m_prog_pddkn.kd AS mkkd ".
					"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
					"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
					"AND m_prog_pddkn_kelas.kd_keahlian = '$keakd' ".
					"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
					"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
					"AND m_prog_pddkn.kd_jenis = '$jnskd' ".
					"ORDER BY round(m_prog_pddkn.no) ASC, ".
					"round(m_prog_pddkn.no_sub) ASC");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);
*/

		//query
		$q = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS mkkd ".
					"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
					"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
					"AND m_prog_pddkn_kelas.kd_keahlian = '$keakd' ".
					"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
					"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
					"AND m_prog_pddkn.kd_jenis = '$jnskd' ".
					"ORDER BY round(m_prog_pddkn.no) ASC, ".
					"round(m_prog_pddkn.no_sub) ASC");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);

		echo '<table width="500" border="1" cellpadding="3" cellspacing="0">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama Program Pendidikan</font></strong></td>
		</tr>';

		if ($total != 0)
			{
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
				$i_mkkd = nosql($row['mkkd']);



				//detail e
				$qku = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$i_mkkd'");
				$rku = mysql_fetch_assoc($qku);
				$i_pel = balikin2($rku['prog_pddkn']);


				//mpkd
				$q2 = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd, ".
							"m_prog_pddkn.*, m_prog_pddkn.kd AS mkkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_keahlian = '$keakd' ".
							"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
							"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$jnskd' ".
							"AND m_prog_pddkn.kd = '$i_mkkd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
				$row2 = mysql_fetch_assoc($q2);
				$i_mpkd = nosql($row2['mpkd']);



				//jumlah kompetensi dasar
				$qkdi = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
							"WHERE kd_prog_pddkn_kelas = '$i_mpkd' ".
							"AND right(kode,2) <> '.0'");
				$rkdi = mysql_fetch_assoc($qkdi);
				$tkdi = mysql_num_rows($qkdi);



				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$nomer.'.</td>
				<td>
				'.$i_pel.'
				<br>
				-> [<a href="'.$filenya.'?s=detail&keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&jnskd='.$jnskd.'&mpkd='.$i_mpkd.'&mkkd='.$i_mkkd.'"><strong>'.$tkdi.' Kompetensi Dasar</strong></a>].
				</td>
				</tr>';
				}
			while ($row = mysql_fetch_assoc($q));
			}

		echo '</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
		</tr>
		</table>';
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
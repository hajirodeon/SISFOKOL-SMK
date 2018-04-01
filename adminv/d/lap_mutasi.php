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
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "lap_mutasi.php";
$judul = "Laporan Mutasi Barang Persediaan";
$judulku = "$judul  [$inv_session : $nip10_session. $nm10_session]";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$s = nosql($_REQUEST['s']);



//focus...
if (empty($tapelkd))
{
$diload = "document.formx.tapel.focus();";
}
else if (empty($smtkd))
{
$diload = "document.formx.smt.focus();";
}







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
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
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

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'&smtkd='.$smtkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,

Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	echo '<p>
	[<a href="lap_mutasi_pdf.php?tapelkd='.$tapelkd.'&smtkd='.$smtkd.'"><img src="'.$sumber.'/img/pdf.gif" border="0" width="16" height="16"></a>]
	</p>';


	//query
	$q = mysql_query("SELECT * FROM inv_kategori ".
				"ORDER BY kategori ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	do
		{
		$i_kd = nosql($row['kd']);
		$i_kategori = balikin2($row['kategori']);

		echo '<p>
		<strong>'.$i_kategori.'</strong>
		<br>';

		echo '<TABLE WIDTH=100% BORDER=1 CELLPADDING=3 CELLSPACING=0>
			<tr bgcolor="'.$warnaheader.'">
				<TD ROWSPAN=2 width="50">
					<strong>Kode</strong>
				</TD>
				<TD ROWSPAN=2>
					Nama <strong>barang</strong>

				</TD>
				<TD COLSPAN=2 align="center">
					<strong>Nilai Awal Semester</strong>
				</TD>
				<TD COLSPAN=3 align="center">
					<strong>Mutasi</strong>
				</TD>
				<TD COLSPAN=2 align="center">
					<strong>Nilai Akhir Semester</strong>
				</TD>
			</TR>
			<tr bgcolor="'.$warnaheader.'">
				<TD align="center">
					<strong>Jumlah</strong>
				</TD>
				<TD align="center">
					<strong>Rupiah</strong>
				</TD>
				<TD align="center">
					<strong>Tambah</strong>
				</TD>
				<TD align="center">
					<strong>Kurang</strong>
				</TD>
				<TD align="center">
					<strong>Jumlah</strong>
				</TD>
				<TD align="center">
					<strong>Jumlah</strong>
				</TD>
				<TD align="center">
					<strong>Rupiah</strong>
				</TD>
			</TR>';


		//brg
		$qbgi = mysql_query("SELECT * FROM inv_brg ".
					"WHERE kd_kategori = '$i_kd' ".
					"ORDER BY kode ASC");
		$rbgi = mysql_fetch_assoc($qbgi);


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
			$dft_kd = nosql($rbgi['kd']);
			$dft_kode = nosql($rbgi['kode']);
			$dft_harga = nosql($rbgi['harga']);
			$dft_brg = balikin($rbgi['nama']);
			$dft_stkd = nosql($rbgi['kd_satuan']);


			//satuan
			$qstu = mysql_query("SELECT * FROM inv_satuan ".
						"WHERE kd = '$dft_stkd'");
			$rstu = mysql_fetch_assoc($qstu);
			$stu_satuan = balikin($rstu['satuan']);




			//semester [ganjil]
			if ($stx_no == "1")
				{
				//nilai awal semester
				$qkusi = mysql_query("SELECT * ".
							"FROM inv_brg_persediaan ".
							"WHERE kd_brg = '$dft_kd' ".
							"AND tgl_buku < '$tpx_thn1:06:30' ".
							"ORDER BY tgl_buku DESC");
				$rkusi = mysql_fetch_assoc($qkusi);
				$tkusi = mysql_num_rows($qkusi);
				$kusi_masuk = round(nosql($rkusi['jml_masuk']));
				$kusi_keluar = round(nosql($rkusi['jml_keluar']));
				$kusi_sisa = round(nosql($rkusi['jml_sisa']));
				$kusi_rupiah = round($kusi_sisa*$dft_harga);


				//nilai awal semester
				$qkusi2 = mysql_query("SELECT * ".
							"FROM inv_brg_persediaan ".
							"WHERE kd_brg = '$dft_kd' ".
							"AND tgl_buku < '$tpx_thn1:12:31' ".
							"ORDER BY tgl_buku DESC");
				$rkusi2 = mysql_fetch_assoc($qkusi2);
				$tkusi2 = mysql_num_rows($qkusi2);
				$kusi2_masuk = round(nosql($rkusi2['jml_masuk']));
				$kusi2_keluar = round(nosql($rkusi2['jml_keluar']));
				$kusi2_sisa = round(nosql($rkusi2['jml_sisa']));
				$kusi2_rupiah = round($kusi2_sisa*$dft_harga);



				//selisih masukdankeluar
				$jml_tambah = round($kusi2_masuk+$kusi_masuk);
				$jml_kurang = round($kusi2_keluar+$kusi_keluar);
				$jml_selisih = round($jml_tambah-$jml_kurang);
				}



			//semester [genap]
			if ($stx_no == "2")
				{
				//nilai awal semester
				$qkusi = mysql_query("SELECT * ".
							"FROM inv_brg_persediaan ".
							"WHERE kd_brg = '$dft_kd' ".
							"AND tgl_buku < '$tpx_thn2:01:01' ".
							"ORDER BY tgl_buku DESC");
				$rkusi = mysql_fetch_assoc($qkusi);
				$tkusi = mysql_num_rows($qkusi);
				$kusi_masuk = round(nosql($rkusi['jml_masuk']));
				$kusi_keluar = round(nosql($rkusi['jml_keluar']));
				$kusi_sisa = round(nosql($rkusi['jml_sisa']));
				$kusi_rupiah = round($kusi_sisa*$dft_harga);


				//nilai awal semester
				$qkusi2 = mysql_query("SELECT * ".
							"FROM inv_brg_persediaan ".
							"WHERE kd_brg = '$dft_kd' ".
							"AND tgl_buku < '$tpx_thn2:06:30' ".
							"ORDER BY tgl_buku DESC");
				$rkusi2 = mysql_fetch_assoc($qkusi2);
				$tkusi2 = mysql_num_rows($qkusi2);
				$kusi2_masuk = round(nosql($rkusi2['jml_masuk']));
				$kusi2_keluar = round(nosql($rkusi2['jml_keluar']));
				$kusi2_sisa = round(nosql($rkusi2['jml_sisa']));
				$kusi2_rupiah = round($kusi2_sisa*$dft_harga);



				//selisih masukdankeluar
				$jml_tambah = round($kusi2_masuk+$kusi_masuk);
				$jml_kurang = round($kusi2_keluar+$kusi_keluar);
				$jml_selisih = round($jml_tambah-$jml_kurang);
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			'.$dft_kode.'
			</td>
			<td>
			'.$dft_brg.'
			</td>
			<td align="right">
			'.$kusi_sisa.' '.$stu_satuan.'
			</td>
			<td align="right">
			'.xduit2($kusi_rupiah).'
			</td>
			<td align="right">
			'.$jml_tambah.' '.$stu_satuan.'
			</td>
			<td align="right">
			'.$jml_kurang.' '.$stu_satuan.'
			</td>
			<td align="right">
			'.$jml_selisih.' '.$stu_satuan.'
			</td>
			<td align="right">
			'.$kusi2_sisa.' '.$stu_satuan.'
			</td>
			<td align="right">
			'.xduit2($kusi2_rupiah).'
			</td>
			</tr>';
			}
		while ($rbgi = mysql_fetch_assoc($qbgi));

		echo '</table>
		<br>';

		echo '</p>';
		}
	while ($row = mysql_fetch_assoc($q));
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
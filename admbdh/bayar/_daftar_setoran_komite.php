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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbdh.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "daftar_setoran_komite.php";
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$rukd = nosql($_REQUEST['rukd']);


$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd";




//judul
$judul = "Daftar Setoran Uang KOMITE Bulanan";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;



//focus...
if (empty($tapelkd))
{
$diload = "document.formx.tapel.focus();";
}
else if (empty($kelkd))
{
$diload = "document.formx.kelas.focus();";
}
else if (empty($rukd))
{
$diload = "document.formx.ruang.focus();";
}





//isi *START
ob_start();

//menu
require("../../inc/menu/admbdh.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
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

	echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,


Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd <> '$kelkd' ".
						"ORDER BY round(no) ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,

Ruang : ';
echo "<select name=\"ruang\" onChange=\"MM_jumpMenu('self',this,0)\">";

//ruang
$qstx = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$rukd'");
$rowstx = mysql_fetch_assoc($qstx);

$ruang = nosql($rowstx['ruang']);

echo '<option value="'.$rukd.'" selected>'.$ruang.'</option>';

$qst = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd <> '$rukd'");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$stkd = nosql($rowst['kd']);
	$struang = balikin($rowst['ruang']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$stkd.'">'.$struang.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>

[<a href="daftar_setoran_komite_prt.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'"><img src="'.$sumber.'/img/print.gif" border="0" width="16" height="16"></a>]
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
else if (empty($kelkd))
{
echo '<p>
<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
</p>';
}
else if (empty($rukd))
{
echo '<p>
<font color="#FF0000"><strong>RUANG Belum Dipilih...!</strong></font>
</p>';
}
else
{
//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
		"FROM m_siswa, siswa_kelas ".
		"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
		"AND siswa_kelas.kd_tapel = '$tapelkd' ".
		"AND siswa_kelas.kd_kelas = '$kelkd' ".
		"AND siswa_kelas.kd_ruang = '$rukd' ".
		"ORDER BY round(siswa_kelas.no_absen) ASC";
$sqlresult = $sqlcount;


$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);




echo '<p>
<TABLE WIDTH=950 BORDER=1 CELLPADDING=4 CELLSPACING=0>
	<TR align="center" bgcolor="'.$warnaheader.'">
		<TD COLSPAN=2>
			<strong>Nomor</strong>
		</TD>
		<TD ROWSPAN=2>
			<strong>NAMA</strong>
		</TD>
		<TD ROWSPAN=2 width="10">
			<strong>L/P</strong>
		</TD>
		<TD COLSPAN=12>
			<strong>Tgl.Pembayaran</strong>
		</TD>
		<TD ROWSPAN=2 width="50">
			<strong>Ket.</strong>
		</TD>
	</TR>
	<TR align="center" bgcolor="'.$warnaheader.'">
		<TD WIDTH=14>
			<strong>No.</strong>
		</TD>
		<TD WIDTH=41>
			<strong>NIS</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Jul</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Agust</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Sept</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Okto</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Nop</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Des</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Jan</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Feb</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Mar</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Apr</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Mei</strong>
		</TD>
		<TD WIDTH=30>
			<strong>Jun</strong>
		</TD>
	</TR> ';



//nek ada
if ($count != 0)
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

		$i_kd = nosql($data['mskd']);
		$i_kd_kelamin = nosql($data['kd_kelamin']);
		$i_nis = nosql($data['nis']);
		$i_abs = nosql($data['no_absen']);
		$i_nama = balikin2($data['nama']);

		//nek null
		if (empty($abs))
			{
			$abs = "00";
			}
		else if (strlen($abs) == 1)
			{
			$abs = "0$abs";
			}



		//kelamin
		$qkmin = mysql_query("SELECT * FROM m_kelamin ".
					"WHERE kd = '$i_kd_kelamin'");
		$rkmin = mysql_fetch_assoc($qkmin);
		$kmin_kelamin = nosql($rkmin['kelamin']);



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">'.$i_abs.'</td>
		<td valign="top">'.$i_nis.'</td>
		<td valign="top">'.$i_nama.'</td>
		<td valign="top">'.$kmin_kelamin.'</td>';

		for ($i=1;$i<=12;$i++)
			{
			//nilainya
			if ($i<=6) //bulan juli sampai desember
				{
				$ibln = $i + 6;

				//cek
				$qccu = mysql_query("SELECT DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
							"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
							"DATE_FORMAT(tgl_bayar, '%Y') AS xthn, ".
							"siswa_uang_komite.* ".
							"FROM siswa_uang_komite ".
							"WHERE kd_siswa = '$i_kd' ".
							"AND kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND bln = '$ibln' ".
							"AND thn = '$tpx_thn1' ".
							"AND lunas = 'true'");
				$rccu = mysql_fetch_assoc($qccu);
				$tccu = mysql_num_rows($qccu);
				$ccu_tgl = nosql($rccu['xtgl']);
				$ccu_bln = nosql($rccu['xbln']);
				}

			if ($i>6) //bulan januari sampai juni
				{
				$ibln = $i - 6;

				//cek
				$qccu = mysql_query("SELECT DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
							"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
							"DATE_FORMAT(tgl_bayar, '%Y') AS xthn, ".
							"siswa_uang_komite.* ".
							"FROM siswa_uang_komite ".
							"WHERE kd_siswa = '$i_kd' ".
							"AND kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND bln = '$ibln' ".
							"AND thn = '$tpx_thn2' ".
							"AND lunas = 'true'");
				$rccu = mysql_fetch_assoc($qccu);
				$tccu = mysql_num_rows($qccu);
				$ccu_tgl = nosql($rccu['xtgl']);
				$ccu_bln = nosql($rccu['xbln']);
				}


			echo '<td valign="top">'.$ccu_tgl.'/'.$ccu_bln.'</td>';
			}

		echo '<td valign="top">'.$i_ket.'</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));
	}

echo '</table>
<table width="950" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="right">Total : <font color="#FF0000"><strong>'.$count.'</strong></font> Data. '.$pagelist.'</td>
</tr>
<tr>
<td align="right">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="rukd" type="hidden" value="'.$rukd.'">
<input name="page" type="hidden" value="'.$page.'">
<input name="total" type="hidden" value="'.$count.'">
</td>
</tr>
</table>


</p>';
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
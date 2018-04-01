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
$tpl = LoadTpl("../../template/window.html");

nocache;

//nilai
$filenya = "bon_prt.php";
$judul = "Kartu Bon Barang";
$judulku = $judul;
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$bonkd = nosql($_REQUEST['bonkd']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "bon.php?s=detail&bonkd=$bonkd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();


//js
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qdt = mysql_query("SELECT * FROM inv_brg_bon ".
			"WHERE kd = '$bonkd'");
$rdt = mysql_fetch_assoc($qdt);
$dt_no_bon = balikin($rdt['no_bon']);
$dt_pemohon = balikin($rdt['pemohon']);
$dt_jabatan = balikin($rdt['jabatan']);
$dt_keperluan = balikin($rdt['keperluan']);



//kepala sekolah
$qks = mysql_query("SELECT admin_ks.*, m_pegawai.* ".
			"FROM admin_ks, m_pegawai ".
			"WHERE admin_ks.kd_pegawai = m_pegawai.kd");
$rks = mysql_fetch_assoc($qks);
$tks = mysql_num_rows($qks);
$ks_nip = nosql($rks['nip']);
$ks_nama = balikin($rks['nama']);



//petugas
$qks2 = mysql_query("SELECT admin_tu.*, m_pegawai.* ".
			"FROM admin_tu, m_pegawai ".
			"WHERE admin_tu.kd_pegawai = m_pegawai.kd");
$rks2 = mysql_fetch_assoc($qks2);
$tks2 = mysql_num_rows($qks2);
$ks2_nip = nosql($rks2['nip']);
$ks2_nama = balikin($rks2['nama']);


echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="600" cellpadding="3">
<tr valign="top">
<td width="300" align="center">
<strong>KEMENTRIAN AGAMA</strong>
<BR>
<strong>MADRASAH TSANAWIYAH NEGERI PEMALANG</strong>
<br>
Jl. Tentara PelajarNo.6 Telp./Fax.(0284)321187
<hr>
</td>
<td width="300">

<table width="100%" cellpadding="1">
<tr valign="top">
<td width="100">
No.Bon
</td>
<td>: '.$dt_no_bon.'
</td>
</tr>

<tr valign="top">
<td width="100">
Nama Pemohon
</td>
<td>: '.$dt_pemohon.'
</td>
</tr>

<tr valign="top">
<td>
Jabatan
</td>
<td>: '.$dt_jabatan.'
</td>
</tr>

<tr valign="top">
<td>
Keperluan
</td>
<td>: '.$dt_keperluan.'
</td>
</tr>
</table>




</td>
</tr>
</table>
<br>


<table width="600" cellpadding="3">
<tr valign="top">
<td align="center">
<u>';
xheadline($judul);
echo '</u>
</td>
</tr>
</table>';



//daftarnya...
$qdft = mysql_query("SELECT inv_brg.*, inv_brg_bon_detail.*, inv_brg_bon_detail.kd AS bkd ".
			"FROM inv_brg, inv_brg_bon_detail ".
			"WHERE inv_brg_bon_detail.kd_brg = inv_brg.kd ".
			"AND inv_brg_bon_detail.kd_bon = '$bonkd'");
$rdft = mysql_fetch_assoc($qdft);
$tdft = mysql_num_rows($qdft);

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
	echo '<td>'.$nomer.'.</td>
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
<br>
<br>

<table width="600" cellpadding="1">
<tr valign="top">
<td width="150">
Mengetahui
</td>
<td width="50">
</td>
<td width="150">
</td>
<td width="50">
</td>
<td width="150">
Pemalang, '.$tanggal.' '.$arrbln[$bulan].' '.$tahun.'
</td>
</tr>

<tr valign="top">
<td width="150">
Kepala MTsN Pemalang
</td>
<td width="50">
</td>
<td width="150">
Yang Menyerahkan,
</td>
<td width="50">
</td>
<td width="150">
Pemohon,
</td>
</tr>

<tr valign="top">
<td width="150">
<br><br>
</td>
<td width="50">
<br><br>
</td>
<td width="150">
<br><br>
</td>
<td width="50">
<br><br>
</td>
<td width="150">
<br><br>
</td>
</tr>

<tr valign="top">
<td width="150">
<strong>'.$ks_nama.'</strong>
<br>
NIP.'.$ks_nip.'
</td>
<td width="50">
</td>
<td width="150">
<strong>'.$ks2_nama.'</strong>
<br>
NIP.'.$ks2_nip.'
</td>
<td width="50">
</td>
<td width="150">
<br>
NIP.
</td>
</tr>

</table>

</form>';
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
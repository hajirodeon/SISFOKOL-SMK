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
require("../../inc/class/paging.php");
require("../../inc/cek/admwk.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "keuangan.php";
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$rukd = nosql($_REQUEST['rukd']);
$swkd = nosql($_REQUEST['swkd']);
$skkd = nosql($_REQUEST['skkd']);
$nis = nosql($_REQUEST['nis']);
$jnskd = nosql($_REQUEST['jnskd']);
$jenis = nosql($_REQUEST['jenis']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?nis=$nis&swkd=$swkd&tapelkd=$tapelkd&kelkd=$kelkd&".
		"keahkd=$keahkd&kompkd=$kompkd&rukd=$rukd&page=$page";

/*
//siswa ne
$qsiw = mysql_query("SELECT * FROM m_siswa ".
			"WHERE kd = '$swkd'");
$rsiw = mysql_fetch_assoc($qsiw);
$siw_nis = nosql($rsiw['nis']);
$siw_nama = balikin($rsiw['nama']);
*/

//siswa ne
$qsiw = mysql_query("SELECT * FROM m_siswa ".
			"WHERE nis = '$nis'");
$rsiw = mysql_fetch_assoc($qsiw);
$siw_kd = nosql($rsiw['kd']);
$siw_nis = nosql($rsiw['nis']);
$siw_nama = balikin($rsiw['nama']);



//judul
$judul = "Keuangan Siswa : ($siw_nis).$siw_nama";
$judulku = "[$wk_session : $nip3_session.$nm3_session] ==> $judul";
$judulx = $judul;



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admwk.php");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">';
echo '<table>
<tr>
<td>';
xheadline($judul);
echo '</td>
<td>
[<a href="detail.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&rukd='.$rukd.'" title="Daftar Siswa">Daftar Siswa</a>]
</td>
</table>';


//tapel
$qpel = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rpel = mysql_fetch_assoc($qpel);
$pel_thn1 = nosql($rpel['tahun1']);
$pel_thn2 = nosql($rpel['tahun2']);

//kelas
$qkel = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = nosql($rkel['kelas']);

//keahlian
$qpro = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);
$pro_keah = "$pro_program";





//kompetensi
$qprgx2 = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd = '$kompkd'");
$rowprgx2 = mysql_fetch_assoc($qprgx2);
$prgx2_prog = balikin($rowprgx2['kompetensi']);



echo '<table bgcolor="'.$warnaover.'" width="100%" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<strong>Tahun Pelajaran :</strong> '.$pel_thn1.'/'.$pel_thn2.',
<strong>Kelas :</strong> '.$kel_kelas.',
<strong>Program Keahlian :</strong> '.$pro_keah.',
<strong>Kompetensi Keahlian :</strong> '.$prgx2_prog.'
</td>
</tr>
</table>';


echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<strong>Jenis Uang :</strong> ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$jnskd.'" selected>--'.$jenis.'--</option>
<option value="'.$filenya.'?nis='.$nis.'&swkd='.$siw_kd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&jnskd=komite&jenis=Uang Komite">Uang Komite</option>
<option value="'.$filenya.'?nis='.$nis.'&swkd='.$siw_kd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&jnskd=sip&jenis=Uang SIP">Uang SIP</option>
<option value="'.$filenya.'?nis='.$nis.'&swkd='.$siw_kd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&jnskd=osis&jenis=Uang OSIS">Uang OSIS</option>
<option value="'.$filenya.'?nis='.$nis.'&swkd='.$siw_kd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&jnskd=syukuran&jenis=Uang Syukuran">Uang Syukuran</option>
<option value="'.$filenya.'?nis='.$nis.'&swkd='.$siw_kd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&jnskd=praktek&jenis=Uang Praktek">Uang Praktek</option>
<option value="'.$filenya.'?nis='.$nis.'&swkd='.$siw_kd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&jnskd=perawatan&jenis=Uang Perawatan">Uang Perawatan</option>
<option value="'.$filenya.'?nis='.$nis.'&swkd='.$siw_kd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&keahkd='.$keahkd.'&kompkd='.$kompkd.'&jnskd=lab&jenis=Uang Lab.Bahasa">Uang Lab.Bahasa</option>
</select>
</td>
</tr>
</table>
<br>';



//uang komite
if ($jnskd == "komite")
	{
	//ketahui nilai per bulan
	$qnil = mysql_query("SELECT m_uang_spp.*, siswa_kelas.* ".
				"FROM m_uang_spp, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = m_uang_spp.kd_tapel ".
				"AND siswa_kelas.kd_kelas = m_uang_spp.kd_kelas ".
				"AND m_uang_spp.kd_tapel = '$tapelkd' ".
				"AND m_uang_spp.kd_kelas = '$kelkd'");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_uang = nosql($rnil['nilai']);


	echo '<p>
	<strong>HISTORY PEMBAYARAN</strong>
	('.xduit2($nil_uang).'/Bulan)';

/*
	//daftar
	$qdftx = mysql_query("SELECT siswa_uang_spp.*, ".
				"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
				"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
				"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
				"FROM siswa_uang_spp ".
				"WHERE kd_siswa = '$swkd' ".
				"AND kd_tapel = '$tapelkd' ".
				"AND kd_kelas = '$kelkd'");
	$rdftx = mysql_fetch_assoc($qdftx);
	$tdftx = mysql_num_rows($qdftx);
*/

	//daftar
	$qdftx = mysql_query("SELECT siswa_uang_spp.*, ".
				"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
				"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
				"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
				"FROM siswa_uang_spp ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd' ".
				"AND kd_kelas = '$kelkd'");
	$rdftx = mysql_fetch_assoc($qdftx);
	$tdftx = mysql_num_rows($qdftx);



	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="120" align="center"><strong><font color="'.$warnatext.'">Bulan</font></strong></td>
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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
		$dft_kd = nosql($rdftx['kd']);
		$dft_bln = nosql($rdftx['bln']);
		$dft_thn = nosql($rdftx['thn']);
		$dft_nilai = nosql($rdftx['nilai']);
		$dft_xtgl = nosql($rdftx['xtgl']);
		$dft_xbln = nosql($rdftx['xbln']);
		$dft_xthn = nosql($rdftx['xthn']);
		$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";
		$dft_status = nosql($rdftx['lunas']);

		//jika null
		if ($dft_tgl_bayar == "00/00/0000")
			{
			$dft_tgl_bayar = "-";
			}


		//nek lunas
		if ($dft_status == 'true')
			{
			$dft_status_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
			}
		else if ($dft_status == 'false')
			{
			$dft_status_ket = "<font color=\"blue\"><strong>Belum Bayar</strong></font>";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td align="right">
		'.$arrbln[$dft_bln].' '.$dft_thn.'
		</td>
		<td>
		'.$dft_tgl_bayar.'
		</td>
		<td>
		'.$dft_status_ket.'
		</td>
		</tr>';
		}
	while ($rdftx = mysql_fetch_assoc($qdftx));

	echo '</table>';

	}



//uang sip
else if ($jnskd == "sip")
	{
	//ketahui kode siswa, dari suatu siswa_kelas
	$qske = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
				"FROM siswa_kelas, m_tapel ".
				"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
				"AND siswa_kelas.kd_siswa = '$siw_kd' ".
				"ORDER BY m_tapel.tahun1 ASC");
	$rske = mysql_fetch_assoc($qske);
	$tske = mysql_num_rows($qske);
	$ske_tapelkd = nosql($rske['kd_tapel']);


	//kelas terakhir
	$qnil = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
				"FROM siswa_kelas, m_tapel ".
				"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
				"AND siswa_kelas.kd_siswa = '$siw_kd' ".
				"ORDER BY m_tapel.tahun1 DESC");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_kelkd = nosql($rnil['kd_kelas']);
	$swp_kelkd = nosql($rnil['kd_kelas']);

	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$swp_kelkd'");
	$rkelx = mysql_fetch_assoc($qkelx);
	$kelx_kelas = balikin($rkelx['kelas']);

	$swp_kelas = "$kelx_kelas";


	//total uang pangkal
	$qpkl = mysql_query("SELECT * FROM m_uang_pangkal ".
				"WHERE kd_tapel = '$tapelkd'");
	$rpkl = mysql_fetch_assoc($qpkl);
	$pkl_nilai = nosql($rpkl['nilai']);


	//yang telah dibayar
	$qccx = mysql_query("SELECT SUM(nilai) AS nilai FROM siswa_uang_pangkal ".
				"WHERE kd_siswa = '$siw_kd'");
	$rccx = mysql_fetch_assoc($qccx);
	$ccx_nilai = nosql($rccx['nilai']);

	//sisa
	$nil_sisa = $pkl_nilai - $ccx_nilai;


	echo '<p>
	<strong>HISTORY PEMBAYARAN</strong>
	<br>
	('.xduit2($pkl_nilai).')
	<p>';

	//total bayar
	$qdftx2 = mysql_query("SELECT SUM(nilai) AS total ".
				"FROM siswa_uang_pangkal ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd'");
	$rdftx2 = mysql_fetch_assoc($qdftx2);
	$dftx2_total = nosql($rdftx2['total']);


	//keterangan
	if ($dftx2_total == $pkl_nilai)
		{
		$nil_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
		}
	else
		{
		$nil_ket = "<font color=\"blue\"><strong>Belum Lunas</strong></font>";
		}



	//daftar
	$qdftx = mysql_query("SELECT siswa_uang_pangkal.*, ".
				"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
				"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
				"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
				"FROM siswa_uang_pangkal ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd' ".
				"ORDER BY tgl_bayar DESC");
	$rdftx = mysql_fetch_assoc($qdftx);
	$tdftx = mysql_num_rows($qdftx);

	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
	<td width="150" align="center"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
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
		$dft_kd = nosql($rdftx['kd']);
		$dft_bln = nosql($rdftx['bln']);
		$dft_thn = nosql($rdftx['thn']);
		$dft_nilai = nosql($rdftx['nilai']);
		$dft_xtgl = nosql($rdftx['xtgl']);
		$dft_xbln = nosql($rdftx['xbln']);
		$dft_xthn = nosql($rdftx['xthn']);
		$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";

		//jika null
		if ($dft_tgl_bayar == "00/00/0000")
			{
			$dft_tgl_bayar = "-";
			}



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$dft_tgl_bayar.'
		</td>
		<td align="right">
		'.xduit2($dft_nilai).'
		</td>
		</tr>';
		}
	while ($rdftx = mysql_fetch_assoc($qdftx));

	echo '</table>
	<p>
	Total Bayar :
	<br>
	Rp.	<input name="nil_total" type="text" size="10" value="'.$dftx2_total.'" style="text-align:right" class="input" readonly>,00
	</p>

	<p>
	Keterangan :
	<br>
	'.$nil_ket.'
	</p>
	</p>';
	}



//uang osis
else if ($jnskd == "osis")
	{
	//kelas terakhir
	$qnil = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
				"FROM siswa_kelas, m_tapel ".
				"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
				"AND siswa_kelas.kd_siswa = '$siw_kd' ".
				"AND siswa_kelas.kd_ruang <> '' ".
				"ORDER BY m_tapel.tahun1 DESC");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_kelkd = nosql($rnil['kd_kelas']);
	$swp_kelkd = nosql($rnil['kd_kelas']);

	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$swp_kelkd'");
	$rkelx = mysql_fetch_assoc($qkelx);
	$kelx_kelas = balikin($rkelx['kelas']);

	$swp_kelas = "$kelx_kelas";



	//total uang
	$qpkl = mysql_query("SELECT * FROM m_uang_osis ".
				"WHERE kd_tapel = '$tapelkd'");
	$rpkl = mysql_fetch_assoc($qpkl);
	$pkl_nilai = nosql($rpkl['nilai']);


	//yang telah dibayar
	$qccx = mysql_query("SELECT SUM(nilai) AS nilai FROM siswa_uang_osis ".
					"WHERE kd_siswa = '$cc_kd'");
	$rccx = mysql_fetch_assoc($qccx);
	$ccx_nilai = nosql($rccx['nilai']);

	//sisa
	$nil_sisa = $pkl_nilai - $ccx_nilai;


	echo '<p>
	<strong>HISTORY PEMBAYARAN</strong>
	<br>
	('.xduit2($pkl_nilai).')
	<p>';

	//total bayar
	$qdftx2 = mysql_query("SELECT SUM(nilai) AS total ".
				"FROM siswa_uang_osis ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd'");
	$rdftx2 = mysql_fetch_assoc($qdftx2);
	$dftx2_total = nosql($rdftx2['total']);


	//keterangan
	if ($dftx2_total == $pkl_nilai)
		{
		$nil_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
		}
	else
		{
		$nil_ket = "<font color=\"blue\"><strong>Belum Lunas</strong></font>";
		}



	//daftar
	$qdftx = mysql_query("SELECT siswa_uang_osis.*, ".
				"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
				"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
				"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
				"FROM siswa_uang_osis ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd' ".
				"ORDER BY tgl_bayar DESC");
	$rdftx = mysql_fetch_assoc($qdftx);
	$tdftx = mysql_num_rows($qdftx);

	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
	<td width="150" align="center"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
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
		$dft_kd = nosql($rdftx['kd']);
		$dft_bln = nosql($rdftx['bln']);
		$dft_thn = nosql($rdftx['thn']);
		$dft_nilai = nosql($rdftx['nilai']);
		$dft_xtgl = nosql($rdftx['xtgl']);
		$dft_xbln = nosql($rdftx['xbln']);
		$dft_xthn = nosql($rdftx['xthn']);
		$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";

		//jika null
		if ($dft_tgl_bayar == "00/00/0000")
			{
			$dft_tgl_bayar = "-";
			}



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$dft_tgl_bayar.'
		</td>
		<td align="right">
		'.xduit2($dft_nilai).'
		</td>
		</tr>';
		}
	while ($rdftx = mysql_fetch_assoc($qdftx));

	echo '</table>
	<p>
	Total Bayar :
	<br>
	Rp.	<input name="nil_total" type="text" size="10" value="'.$dftx2_total.'" style="text-align:right" class="input" readonly>,00
	</p>

	<p>
	Keterangan :
	<br>
	'.$nil_ket.'
	</p>';
	}



//uang syukuran
else if ($jnskd == "syukuran")
	{
	//kelas terakhir
	$qnil = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
				"FROM siswa_kelas, m_tapel ".
				"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
				"AND siswa_kelas.kd_siswa = '$siw_kd' ".
				"ORDER BY m_tapel.tahun1 DESC");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_kelkd = nosql($rnil['kd_kelas']);
	$swp_kelkd = nosql($rnil['kd_kelas']);



	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$swp_kelkd'");
	$rkelx = mysql_fetch_assoc($qkelx);
	$kelx_kelas = balikin($rkelx['kelas']);


	$swp_kelas = "$kelx_kelas";





	//total uang pangkal
	$qpkl = mysql_query("SELECT * FROM m_uang_syukuran ".
				"WHERE kd_tapel = '$tapelkd'");
	$rpkl = mysql_fetch_assoc($qpkl);
	$pkl_nilai = nosql($rpkl['nilai']);


	//yang telah dibayar
	$qccx = mysql_query("SELECT SUM(nilai) AS nilai FROM siswa_uang_syukuran ".
				"WHERE kd_siswa = '$siw_kd'");
	$rccx = mysql_fetch_assoc($qccx);
	$ccx_nilai = nosql($rccx['nilai']);

	//sisa
	$nil_sisa = $pkl_nilai - $ccx_nilai;


	echo '<p>
	<strong>HISTORY PEMBAYARAN</strong>
	<br>
	('.xduit2($pkl_nilai).')
	<p>';

	//total bayar
	$qdftx2 = mysql_query("SELECT SUM(nilai) AS total ".
				"FROM siswa_uang_syukuran ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd'");
	$rdftx2 = mysql_fetch_assoc($qdftx2);
	$dftx2_total = nosql($rdftx2['total']);


	//keterangan
	if ($dftx2_total == $pkl_nilai)
		{
		$nil_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
		}
	else
		{
		$nil_ket = "<font color=\"blue\"><strong>Belum Lunas</strong></font>";
		}



	//daftar
	$qdftx = mysql_query("SELECT siswa_uang_syukuran.*, ".
				"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
				"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
				"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
				"FROM siswa_uang_syukuran ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd' ".
				"ORDER BY tgl_bayar DESC");
	$rdftx = mysql_fetch_assoc($qdftx);
	$tdftx = mysql_num_rows($qdftx);

	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
	<td width="150" align="center"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
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
		$dft_kd = nosql($rdftx['kd']);
		$dft_bln = nosql($rdftx['bln']);
		$dft_thn = nosql($rdftx['thn']);
		$dft_nilai = nosql($rdftx['nilai']);
		$dft_xtgl = nosql($rdftx['xtgl']);
		$dft_xbln = nosql($rdftx['xbln']);
		$dft_xthn = nosql($rdftx['xthn']);
		$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";

		//jika null
		if ($dft_tgl_bayar == "00/00/0000")
			{
			$dft_tgl_bayar = "-";
			}




		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$dft_tgl_bayar.'
		</td>
		<td align="right">
		'.xduit2($dft_nilai).'
		</td>
		</tr>';
		}
	while ($rdftx = mysql_fetch_assoc($qdftx));

	echo '</table>
	<p>
	Total Bayar :
	<br>
	Rp.	<input name="nil_total" type="text" size="10" value="'.$dftx2_total.'" style="text-align:right" class="input" readonly>,00
	</p>

	<p>
	Keterangan :
	<br>
	'.$nil_ket.'
	</p>';
	}


//uang praktek
else if ($jnskd == "praktek")
	{
	//ketahui nilai per bulan
	$qnil = mysql_query("SELECT m_uang_praktek.*, siswa_kelas.* ".
				"FROM m_uang_praktek, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = m_uang_praktek.kd_tapel ".
				"AND siswa_kelas.kd_kelas = m_uang_praktek.kd_kelas ".
				"AND m_uang_praktek.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_siswa = '$siw_kd'");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_kelkd = nosql($rnil['kd_kelas']);
	$nil_uang = nosql($rnil['nilai']);

	//total uang
	$cc_sebesar = $jml_bln * $nil_uang;


	//ketahui bulan yang belum dibayar
	$qswp = mysql_query("SELECT siswa_uang_praktek.*, siswa_kelas.* ".
				"FROM siswa_uang_praktek, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = siswa_uang_praktek.kd_tapel ".
				"AND siswa_kelas.kd_kelas = siswa_uang_praktek.kd_kelas ".
				"AND siswa_uang_praktek.kd_tapel = '$tapelkd' ".
				"AND siswa_uang_praktek.kd_siswa = siswa_kelas.kd_siswa ".
				"AND siswa_kelas.kd_siswa = '$siw_kd' ".
				"AND siswa_uang_praktek.lunas = 'false'");
	$rswp = mysql_fetch_assoc($qswp);
	$tswp = mysql_num_rows($qswp);

	//kelas-nya
	$swp_kelkd = nosql($rnil['kd_kelas']);

	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$swp_kelkd'");
	$rkelx = mysql_fetch_assoc($qkelx);
	$kelx_kelas = balikin($rkelx['kelas']);


	$swp_kelas = "$kelx_kelas";


	echo '<p>
	<strong>HISTORY PEMBAYARAN</strong>
	('.xduit2($nil_uang).'/Bulan)';


	//daftar
	$qdftx = mysql_query("SELECT siswa_uang_praktek.*, ".
				"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
				"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
				"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
				"FROM siswa_uang_praktek ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd' ".
				"AND kd_kelas = '$nil_kelkd'");
	$rdftx = mysql_fetch_assoc($qdftx);
	$tdftx = mysql_num_rows($qdftx);

	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="120" align="center"><strong><font color="'.$warnatext.'">Bulan</font></strong></td>
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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
		$dft_kd = nosql($rdftx['kd']);
		$dft_bln = nosql($rdftx['bln']);
		$dft_thn = nosql($rdftx['thn']);
		$dft_nilai = nosql($rdftx['nilai']);
		$dft_xtgl = nosql($rdftx['xtgl']);
		$dft_xbln = nosql($rdftx['xbln']);
		$dft_xthn = nosql($rdftx['xthn']);
		$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";
		$dft_status = nosql($rdftx['lunas']);

		//jika null
		if ($dft_tgl_bayar == "00/00/0000")
			{
			$dft_tgl_bayar = "-";
			}


		//nek lunas
		if ($dft_status == 'true')
			{
			$dft_status_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
			}
		else if ($dft_status == 'false')
			{
			$dft_status_ket = "<font color=\"blue\"><strong>Belum Bayar</strong></font>";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td align="right">
		'.$arrbln[$dft_bln].' '.$dft_thn.'
		</td>
		<td>
		'.$dft_tgl_bayar.'
		</td>
		<td>
		'.$dft_status_ket.'
		</td>
		</tr>';
		}
	while ($rdftx = mysql_fetch_assoc($qdftx));

	echo '</table>
	</p>';
	}



//uang perawatan
else if ($jnskd == "perawatan")
	{
	//ketahui nilai per bulan
	$qnil = mysql_query("SELECT m_uang_perawatan.*, siswa_kelas.* ".
				"FROM m_uang_perawatan, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = m_uang_perawatan.kd_tapel ".
				"AND siswa_kelas.kd_kelas = m_uang_perawatan.kd_kelas ".
				"AND m_uang_perawatan.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_siswa = '$siw_kd'");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_kelkd = nosql($rnil['kd_kelas']);
	$nil_uang = nosql($rnil['nilai']);

	//total uang
	$cc_sebesar = $jml_bln * $nil_uang;


	//ketahui bulan yang belum dibayar
	$qswp = mysql_query("SELECT siswa_uang_perawatan.*, siswa_kelas.* ".
				"FROM siswa_uang_perawatan, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = siswa_uang_perawatan.kd_tapel ".
				"AND siswa_kelas.kd_kelas = siswa_uang_perawatan.kd_kelas ".
				"AND siswa_uang_perawatan.kd_tapel = '$tapelkd' ".
				"AND siswa_uang_perawatan.kd_siswa = siswa_kelas.kd_siswa ".
				"AND siswa_kelas.kd_siswa = '$siw_kd' ".
				"AND siswa_uang_perawatan.lunas = 'false'");
	$rswp = mysql_fetch_assoc($qswp);
	$tswp = mysql_num_rows($qswp);

	//kelas-nya
	$swp_kelkd = nosql($rnil['kd_kelas']);


	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$swp_kelkd'");
	$rkelx = mysql_fetch_assoc($qkelx);
	$kelx_kelas = balikin($rkelx['kelas']);


	$swp_kelas = "$kelx_kelas";


	echo '<p>
	<strong>HISTORY PEMBAYARAN</strong>
	('.xduit2($nil_uang).'/Bulan)';


	//daftar
	$qdftx = mysql_query("SELECT siswa_uang_perawatan.*, ".
				"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
				"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
				"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
				"FROM siswa_uang_perawatan ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd' ".
				"AND kd_kelas = '$nil_kelkd'");
	$rdftx = mysql_fetch_assoc($qdftx);
	$tdftx = mysql_num_rows($qdftx);

	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="120" align="center"><strong><font color="'.$warnatext.'">Bulan</font></strong></td>
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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
		$dft_kd = nosql($rdftx['kd']);
		$dft_bln = nosql($rdftx['bln']);
		$dft_thn = nosql($rdftx['thn']);
		$dft_nilai = nosql($rdftx['nilai']);
		$dft_xtgl = nosql($rdftx['xtgl']);
		$dft_xbln = nosql($rdftx['xbln']);
		$dft_xthn = nosql($rdftx['xthn']);
		$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";
		$dft_status = nosql($rdftx['lunas']);

		//jika null
		if ($dft_tgl_bayar == "00/00/0000")
			{
			$dft_tgl_bayar = "-";
			}


		//nek lunas
		if ($dft_status == 'true')
			{
			$dft_status_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
			}
		else if ($dft_status == 'false')
			{
			$dft_status_ket = "<font color=\"blue\"><strong>Belum Bayar</strong></font>";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td align="right">
		'.$arrbln[$dft_bln].' '.$dft_thn.'
		</td>
		<td>
		'.$dft_tgl_bayar.'
		</td>
		<td>
		'.$dft_status_ket.'
		</td>
		</tr>';
		}
	while ($rdftx = mysql_fetch_assoc($qdftx));

	echo '</table>
	</p>';
	}


//uang lab.bahasa
else if ($jnskd == "lab")
	{
	//ketahui nilai per bulan
	$qnil = mysql_query("SELECT m_uang_lab.*, siswa_kelas.* ".
				"FROM m_uang_lab, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = m_uang_lab.kd_tapel ".
				"AND siswa_kelas.kd_kelas = m_uang_lab.kd_kelas ".
				"AND m_uang_lab.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_siswa = '$siw_kd'");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_kelkd = nosql($rnil['kd_kelas']);
	$nil_uang = nosql($rnil['nilai']);

	//total uang
	$cc_sebesar = $jml_bln * $nil_uang;


	//ketahui bulan yang belum dibayar
	$qswp = mysql_query("SELECT siswa_uang_lab.*, siswa_kelas.* ".
				"FROM siswa_uang_lab, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = siswa_uang_lab.kd_tapel ".
				"AND siswa_kelas.kd_kelas = siswa_uang_lab.kd_kelas ".
				"AND siswa_uang_lab.kd_tapel = '$tapelkd' ".
				"AND siswa_uang_lab.kd_siswa = siswa_kelas.kd_siswa ".
				"AND siswa_kelas.kd_siswa = '$siw_kd' ".
				"AND siswa_uang_lab.lunas = 'false'");
	$rswp = mysql_fetch_assoc($qswp);
	$tswp = mysql_num_rows($qswp);

	//kelas-nya
	$swp_kelkd = nosql($rnil['kd_kelas']);

	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$swp_kelkd'");
	$rkelx = mysql_fetch_assoc($qkelx);
	$kelx_kelas = balikin($rkelx['kelas']);

	$swp_kelas = "$kelx_kelas";


	echo '<p>
	<strong>HISTORY PEMBAYARAN</strong>
	('.xduit2($nil_uang).'/Bulan)';


	//daftar
	$qdftx = mysql_query("SELECT siswa_uang_lab.*, ".
				"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
				"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
				"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
				"FROM siswa_uang_lab ".
				"WHERE kd_siswa = '$siw_kd' ".
				"AND kd_tapel = '$tapelkd' ".
				"AND kd_kelas = '$nil_kelkd'");
	$rdftx = mysql_fetch_assoc($qdftx);
	$tdftx = mysql_num_rows($qdftx);

	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="120" align="center"><strong><font color="'.$warnatext.'">Bulan</font></strong></td>
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
	<td width="100" align="center"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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
		$dft_kd = nosql($rdftx['kd']);
		$dft_bln = nosql($rdftx['bln']);
		$dft_thn = nosql($rdftx['thn']);
		$dft_nilai = nosql($rdftx['nilai']);
		$dft_xtgl = nosql($rdftx['xtgl']);
		$dft_xbln = nosql($rdftx['xbln']);
		$dft_xthn = nosql($rdftx['xthn']);
		$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";
		$dft_status = nosql($rdftx['lunas']);

		//jika null
		if ($dft_tgl_bayar == "00/00/0000")
			{
			$dft_tgl_bayar = "-";
			}


		//nek lunas
		if ($dft_status == 'true')
			{
			$dft_status_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
			}
		else if ($dft_status == 'false')
			{
			$dft_status_ket = "<font color=\"blue\"><strong>Belum Bayar</strong></font>";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td align="right">
		'.$arrbln[$dft_bln].' '.$dft_thn.'
		</td>
		<td>
		'.$dft_tgl_bayar.'
		</td>
		<td>
		'.$dft_status_ket.'
		</td>
		</tr>';
		}
	while ($rdftx = mysql_fetch_assoc($qdftx));

	echo '</table>
	</p>';
	}




echo '<br>
</form>
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
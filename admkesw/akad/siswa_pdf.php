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
require("../../inc/class/siswa.php");


nocache;



//start class
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//nilai
$filenya = "siswa_pdf.php";
$judul = "Data Diri Siswa :";
$judulz = $judul;
$swkd = nosql($_REQUEST['swkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);






//isi *START
ob_start();


$pdf->SetY(10);
$pdf->Headerku();
$pdf->SetFont('Times','',10);


//query /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qnil = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS lahir_tgl, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS lahir_bln, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS lahir_thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_nis = nosql($rnil['nis']);
$y_nama = balikin($rnil['nama']);
$y_panggilan = balikin($rnil['panggilan']);
$y_jkelkd = nosql($rnil['kd_kelamin']);

$y_tmp_lahir = balikin($rnil['tmp_lahir']);
$y_lahir_tgl = nosql($rnil['lahir_tgl']);
$y_lahir_bln = nosql($rnil['lahir_bln']);
$y_lahir_thn = nosql($rnil['lahir_thn']);

$y_agmkd = nosql($rnil['kd_agama']);
$y_warga_negara = balikin2($rnil['warga_negara']);
$y_anak_ke = nosql($rnil['anak_ke']);
$y_jml_sdr_kandung = nosql($rnil['jml_sdr_kandung']);
$y_jml_sdr_tiri = nosql($rnil['jml_sdr_tiri']);
$y_jml_sdr_angkat = nosql($rnil['jml_sdr_angkat']);
$y_yatim_piatu = balikin2($rnil['yatim_piatu']);
$y_bahasa = balikin2($rnil['bhs_harian']);
$y_filex = $rnil['filex'];


//kelamin
$qjkelx = mysql_query("SELECT * FROM m_kelamin ".
						"WHERE kd = '$y_jkelkd'");
$rjkelx = mysql_fetch_assoc($qjkelx);
$jkelx_kd = nosql($rjkelx['kd']);
$jkelx_kelamin = balikin($rjkelx['kelamin']);


//agama
$qagmx = mysql_query("SELECT * FROM m_agama ".
						"WHERE kd = '$y_agmkd'");
$ragmx = mysql_fetch_assoc($qagmx);
$agmx_kd = nosql($ragmx['kd']);
$agmx_agama = balikin($ragmx['agama']);



//nek null foto
if (empty($y_filex))
	{
	$nil_foto = "$sumber/img/foto_blank.jpg";
	}
else
	{
	$nil_foto = "$sumber/filebox/siswa/$swkd/$y_filex";
	}




//A. KETERANGAN TENTANG DIRI SISWA //////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->WriteHTML('<p>
<strong>A. KETERANGAN TENTANG DIRI SISWA</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
NIS
</td>
<td width="10">: </td>
<td>
<strong>'.$y_nis.'</strong>
</td>
</tr>

<tr valign="top">
<td width="200">
1. Nama Siswa
</td>
<td width="10"></td>
<td></td>
</tr>

<tr valign="top">
<td width="200">
     <dd>
a. Nama Lengkap
</dd>
</td>
<td width="10">: </td>
<td>
<strong>'.$y_nama.'</strong>
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>
b. Panggilan
</dd>
</td>
<td width="10">: </td>
<td>
'.$y_panggilan.'
</td>
</tr>

<tr valign="top">
<td width="200">
2. Jenis Kelamin
</td>
<td width="10">: </td>
<td>
'.$jkelx_kelamin.'
</td>
</tr>

<tr valign="top">
<td width="200">
3. TTL
</td>
<td width="10">: </td>
<td>
'.$y_tmp_lahir.', '.$y_lahir_tgl.' '.$arrbln1[$y_lahir_bln].' '.$y_lahir_thn.'
</td>
</tr>

<tr valign="top">
<td width="200">
4. Agama
</td>
<td width="10">: </td>
<td>
'.$agmx_agama.'
</td>
</tr>

<tr valign="top">
<td width="200">
5. Kewarganegaraan
</td>
<td width="10">: </td>
<td>
'.$y_warga_negara.'
</td>
</tr>

<tr valign="top">
<td width="200">
6. Anak Keberapa
</td>
<td width="10">: </td>
<td>
'.$y_anak_ke.'
</td>
</tr>

<tr valign="top">
<td width="200">
7. Jumlah Saudara Kandung
</td>
<td width="10">: </td>
<td>
'.$y_jml_sdr_kandung.'
</td>
</tr>

<tr valign="top">
<td width="200">
8. Jumlah Saudara Tiri
</td>
<td width="10">: </td>
<td>
'.$y_jml_sdr_tiri.'
</td>
</tr>

<tr valign="top">
<td width="200">
9. Jumlah Saudara Angkat
</td>
<td width="10">: </td>
<td>
'.$y_jml_sdr_angkat.'
</td>
</tr>

<tr valign="top">
<td width="200" valign="top">
10. Anak Yatim / Anak Piatu
<br>
/ Yatim Piatu
</td>
<td width="10" valign="top">: </td>
<td valign="top">
'.$y_yatim_piatu.'
</td>
</tr>

<tr valign="top">
<td width="200" valign="top">
11. Bahasa Sehari - hari
<br>
di Rumah
</td>
<td width="10" valign="top">: </td>
<td valign="top">
'.$y_bahasa.'
</td>
</tr>
</table>');





//image foto profil /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->SetY(45);
$pdf->SetX(145);
$pdf->WriteHTML('<img src="'.$nil_foto.'" alt="'.$y_nama.'" width="150" height="200" border="5">');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//kembalikan posisi /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->SetY(140);
$pdf->SetX(0);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//B. KETERANGAN TEMPAT TINGGAL //////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qnil = mysql_query("SELECT m_siswa_tmp_tinggal.*, siswa_kelas.* ".
						"FROM m_siswa_tmp_tinggal, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_tmp_tinggal.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_alamat = balikin2($rnil['alamat']);
$y_telp = balikin2($rnil['telp']);
$y_tinggal_dgn = balikin2($rnil['tinggal_dgn']);
$y_jarak = balikin2($rnil['jarak']);


$pdf->WriteHTML('<p>
<strong>B. KETERANGAN TEMPAT TINGGAL</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
12. Alamat
</td>
<td width="10">: </td>
<td>
'.$y_alamat.'
</td>
</tr>

<tr valign="top">
<td width="200">
13. Telp.
</td>
<td width="10">: </td>
<td>
'.$y_telp.'
</td>
</tr>

<tr valign="top">
<td width="200">
14. Tinggal dengan Orang Tua
<br>
/ Saudara / di Asrama / Kos.
</td>
<td width="10">: </td>
<td>
'.$y_tinggal_dgn.'
</td>
</tr>

<tr valign="top">
<td width="200">
15. Jarak tempat tinggal
<br>
ke sekolah
</td>
<td width="10">: </td>
<td>
'.$y_jarak.'
</td>
</tr>
</table>');





//C. KETERANGAN KESEHATAN ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qnil = mysql_query("SELECT m_siswa_kesehatan.*, siswa_kelas.* ".
						"FROM m_siswa_kesehatan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_kesehatan.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_gol_darah = balikin2($rnil['gol_darah']);
$y_penyakit = balikin2($rnil['penyakit']);
$y_kelainan = balikin2($rnil['kelainan']);
$y_berat = balikin2($rnil['berat']);
$y_tinggi = balikin2($rnil['tinggi']);


$pdf->WriteHTML('<p>
<strong>C. KETERANGAN KESEHATAN</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
16. Golongan Darah
</td>
<td width="10">: </td>
<td>
'.$y_gol_darah.'
</td>
</tr>

<tr valign="top">
<td width="200">
17. Penyakit yang pernah diderita
<br>
TBC/Cacar/Malaria/dan lain - lain
</td>
<td width="10">: </td>
<td>
'.$y_penyakit.'
</td>
</tr>

<tr valign="top">
<td width="200">
18. Kelainan Jasmani
</td>
<td width="10">: </td>
<td>
'.$y_kelainan.'
</td>
</tr>

<tr valign="top">
<td width="200">
19. Tinggi / Berat Badan
</td>
<td width="10">: </td>
<td>
'.$y_tinggi.' Cm / '.$y_berat.' Kg.
</td>
</tr>
</table>');





//D. KETERANGAN PENDIDIKAN //////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query pendidikan /////////////////////////////////////////////////////////////////////////////////////////////////////////
$qnil = mysql_query("SELECT m_siswa_pendidikan.*, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_pendidikan.tgl_sttb, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_pendidikan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_pendidikan.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_lulusan = balikin2($rnil['lulusan']);
$y_no_sttb = balikin2($rnil['no_sttb']);
$y_tgl_sttb = nosql($rnil['tgl']);
$y_bln_sttb = nosql($rnil['bln']);
$y_thn_sttb = nosql($rnil['thn']);
$y_lama = balikin2($rnil['lama']);


//query pindahan ///////////////////////////////////////////////////////////////////////////////////////////////////////////
$qnil2 = mysql_query("SELECT m_siswa_pindahan.*, siswa_kelas.* ".
						"FROM m_siswa_pindahan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_pindahan.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil2 = mysql_fetch_assoc($qnil2);
$y_dari = balikin2($rnil2['dari']);
$y_alasan = balikin2($rnil2['alasan']);


//query diterima ///////////////////////////////////////////////////////////////////////////////////////////////////////////
$qnil3 = mysql_query("SELECT m_siswa_diterima.*, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_diterima.tgl, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_diterima, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_diterima.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil3 = mysql_fetch_assoc($qnil3);
$y_kelas = balikin2($rnil3['kelas']);
$y_keahlian = balikin2($rnil3['keahlian']);
$y_tgl_terima = nosql($rnil3['tgl']);
$y_bln_terima = nosql($rnil3['bln']);
$y_thn_terima = nosql($rnil3['thn']);



$pdf->WriteHTML('<p>
<strong>D. KETERANGAN PENDIDIKAN</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
20. Pendidikan Sebelumnya
</td>
<td width="10"></td>
<td></td>
</tr>

<tr valign="top">
<td width="200">
     <dd>a. Lulusan dari</dd>
</td>
<td width="10">: </td>
<td>
'.$y_lulusan.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>b. Tanggal dan No. STTB</dd>
</td>
<td width="10">: </td>
<td>
'.$y_tgl_sttb.' '.$arrbln1[$y_bln_sttb].' '.$y_thn_sttb.' / '.$y_no_sttb.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>c. Lama Belajar</dd>
</td>
<td width="10">: </td>
<td>
'.$y_lama.' Tahun.
</td>
</tr>

<tr valign="top">
<td width="200">
21. Pindahan
</td>
<td width="10"></td>
<td></td>
</tr>

<tr valign="top">
<td width="200">
     <dd>a. Dari Sekolah</dd>
</td>
<td width="10">: </td>
<td>
'.$y_dari.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>b. Alasan</dd>
</td>
<td width="10">: </td>
<td>
'.$y_alasan.'
</td>
</tr>

<tr valign="top">
<td width="200">
22. Diterima di Sekolah ini
</td>
<td width="10"></td>
<td></td>
</tr>

<tr valign="top">
<td width="200">
     <dd>a. Di Kelas</dd>
</td>
<td width="10">: </td>
<td>
'.$y_kelas.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>b. Keahlian</dd>
</td>
<td width="10">: </td>
<td>
'.$y_keahlian.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>c. Tanggal</dd>
</td>
<td width="10">: </td>
<td>
'.$y_tgl_terima.' '.$arrbln1[$y_bln_terima].' '.$y_thn_terima.'
</td>
</tr>
</table>');





//E. KETERANGAN TENTANG AYAH KANDUNG ////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qnil = mysql_query("SELECT m_siswa_ayah.*, ".
						"DATE_FORMAT(m_siswa_ayah.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_ayah.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_ayah.tgl_lahir, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_ayah, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_ayah.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_nama = balikin2($rnil['nama']);
$y_tmp_lahir = balikin2($rnil['tmp_lahir']);
$y_tgl_lahir = nosql($rnil['tgl']);
$y_bln_lahir = nosql($rnil['bln']);
$y_thn_lahir = nosql($rnil['thn']);
$y_agmkd = nosql($rnil['kd_agama']);
$y_warga_negara = balikin2($rnil['warga_negara']);
$y_pendidikan = balikin2($rnil['pendidikan']);
$y_pekkd = nosql($rnil['kd_pekerjaan']);
$y_penghasilan = balikin2($rnil['penghasilan']);
$y_alamat = balikin2($rnil['alamat']);
$y_telp = balikin2($rnil['telp']);
$y_hidup = balikin2($rnil['hidup']);


//agama
$qagmx = mysql_query("SELECT * FROM m_agama ".
						"WHERE kd = '$y_agmkd'");
$ragmx = mysql_fetch_assoc($qagmx);
$agmx_kd = nosql($ragmx['kd']);
$agmx_agama = balikin($ragmx['agama']);


//pekerjaan
$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
						"WHERE kd = '$y_pekkd'");
$rpekx = mysql_fetch_assoc($qpekx);
$pekx_kd = nosql($rpekx['kd']);
$pekx_pekerjaan = balikin($rpekx['pekerjaan']);


$pdf->WriteHTML('<p>
<strong>E. KETERANGAN TENTANG AYAH KANDUNG</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
23. Nama
</td>
<td width="10">: </td>
<td>
'.$y_nama.'
</td>
</tr>

<tr valign="top">
<td width="200">
24. Tempat dan Tanggal Lahir
</td>
<td width="10">: </td>
<td>
'.$y_tmp_lahir.', '.$y_tgl_lahir.' '.$arrbln1[$y_bln_lahir].' '.$y_thn_lahir.'
</td>
</tr>

<tr valign="top">
<td width="200">
25. Agama
</td>
<td width="10">: </td>
<td>
'.$agmx_agama.'
</td>
</tr>

<tr valign="top">
<td width="200">
26. Kewarganegaraan
</td>
<td width="10">: </td>
<td>
'.$y_warga_negara.'
</td>
</tr>

<tr valign="top">
<td width="200">
27. Pendidikan
</td>
<td width="10">: </td>
<td>
'.$y_pendidikan.'
</td>
</tr>

<tr valign="top">
<td width="200">
28. Pekerjaan
</td>
<td width="10">: </td>
<td>
'.$pekx_pekerjaan.'
</td>
</tr>

<tr valign="top">
<td width="200">
29. Penghasilan per Bulan
</td>
<td width="10">: </td>
<td>
'.xduit2($y_penghasilan).'
</td>
</tr>

<tr valign="top">
<td width="200">
30. Alamat Rumah / Telepon
</td>
<td width="10">: </td>
<td>
'.$y_alamat.' / '.$y_telp.'
</td>
</tr>

<tr valign="top">
<td width="200">
31. Masih Hidup
<br>
/ Meninggal Dunia, Tahun
</td>
<td width="10">: </td>
<td>
'.$y_hidup.'
</td>
</tr>
</table>');





//F. KETERANGAN TENTANG IBU KANDUNG ////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qnil = mysql_query("SELECT m_siswa_ibu.*, ".
						"DATE_FORMAT(m_siswa_ibu.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_ibu.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_ibu.tgl_lahir, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_ibu, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_ibu.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_nama = balikin2($rnil['nama']);
$y_tmp_lahir = balikin2($rnil['tmp_lahir']);
$y_tgl_lahir = nosql($rnil['tgl']);
$y_bln_lahir = nosql($rnil['bln']);
$y_thn_lahir = nosql($rnil['thn']);
$y_agmkd = nosql($rnil['kd_agama']);
$y_warga_negara = balikin2($rnil['warga_negara']);
$y_pendidikan = balikin2($rnil['pendidikan']);
$y_pekkd = nosql($rnil['kd_pekerjaan']);
$y_penghasilan = balikin2($rnil['penghasilan']);
$y_alamat = balikin2($rnil['alamat']);
$y_telp = balikin2($rnil['telp']);
$y_hidup = balikin2($rnil['hidup']);


//agama
$qagmx = mysql_query("SELECT * FROM m_agama ".
						"WHERE kd = '$y_agmkd'");
$ragmx = mysql_fetch_assoc($qagmx);
$agmx_kd = nosql($ragmx['kd']);
$agmx_agama = balikin($ragmx['agama']);


//pekerjaan
$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
						"WHERE kd = '$y_pekkd'");
$rpekx = mysql_fetch_assoc($qpekx);
$pekx_kd = nosql($rpekx['kd']);
$pekx_pekerjaan = balikin($rpekx['pekerjaan']);


$pdf->WriteHTML('<p>
<strong>F. KETERANGAN TENTANG IBU KANDUNG</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
32. Nama
</td>
<td width="10">: </td>
<td>
'.$y_nama.'
</td>
</tr>

<tr valign="top">
<td width="200">
33. Tempat dan Tanggal Lahir
</td>
<td width="10">: </td>
<td>
'.$y_tmp_lahir.', '.$y_tgl_lahir.' '.$arrbln1[$y_bln_lahir].' '.$y_thn_lahir.'
</td>
</tr>

<tr valign="top">
<td width="200">
34. Agama
</td>
<td width="10">: </td>
<td>
'.$agmx_agama.'
</td>
</tr>

<tr valign="top">
<td width="200">
35. Kewarganegaraan
</td>
<td width="10">: </td>
<td>
'.$y_warga_negara.'
</td>
</tr>

<tr valign="top">
<td width="200">
36. Pendidikan
</td>
<td width="10">: </td>
<td>
'.$y_pendidikan.'
</td>
</tr>

<tr valign="top">
<td width="200">
37. Pekerjaan
</td>
<td width="10">: </td>
<td>
'.$pekx_pekerjaan.'
</td>
</tr>

<tr valign="top">
<td width="200">
38. Penghasilan per Bulan
</td>
<td width="10">: </td>
<td>
'.xduit2($y_penghasilan).'
</td>
</tr>

<tr valign="top">
<td width="200">
39. Alamat Rumah / Telepon
</td>
<td width="10">: </td>
<td>
'.$y_alamat.' / '.$y_telp.'
</td>
</tr>

<tr valign="top">
<td width="200">
40. Masih Hidup
<br>
/ Meninggal Dunia, Tahun
</td>
<td width="10">: </td>
<td>
'.$y_hidup.'
</td>
</tr>
</table>');





//G. KETERANGAN TENTANG WALI ///////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qnil = mysql_query("SELECT m_siswa_wali.*, ".
						"DATE_FORMAT(m_siswa_wali.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_wali.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_wali.tgl_lahir, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_wali, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_wali.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_nama = balikin2($rnil['nama']);
$y_tmp_lahir = balikin2($rnil['tmp_lahir']);
$y_tgl_lahir = nosql($rnil['tgl']);
$y_bln_lahir = nosql($rnil['bln']);
$y_thn_lahir = nosql($rnil['thn']);
$y_agmkd = nosql($rnil['kd_agama']);
$y_warga_negara = balikin2($rnil['warga_negara']);
$y_pendidikan = balikin2($rnil['pendidikan']);
$y_pekkd = nosql($rnil['kd_pekerjaan']);
$y_penghasilan = balikin2($rnil['penghasilan']);
$y_alamat = balikin2($rnil['alamat']);
$y_telp = balikin2($rnil['telp']);


//agama
$qagmx = mysql_query("SELECT * FROM m_agama ".
						"WHERE kd = '$y_agmkd'");
$ragmx = mysql_fetch_assoc($qagmx);
$agmx_kd = nosql($ragmx['kd']);
$agmx_agama = balikin($ragmx['agama']);


//pekerjaan
$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
						"WHERE kd = '$y_pekkd'");
$rpekx = mysql_fetch_assoc($qpekx);
$pekx_kd = nosql($rpekx['kd']);
$pekx_pekerjaan = balikin($rpekx['pekerjaan']);


$pdf->WriteHTML('<p>
<strong>G. KETERANGAN TENTANG WALI</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
41. Nama
</td>
<td width="10">: </td>
<td>
'.$y_nama.'
</td>
</tr>

<tr valign="top">
<td width="200">
42. Tempat dan Tanggal Lahir
</td>
<td width="10">: </td>
<td>
'.$y_tmp_lahir.', '.$y_tgl_lahir.' '.$arrbln1[$y_bln_lahir].' '.$y_thn_lahir.'
</td>
</tr>

<tr valign="top">
<td width="200">
43. Agama
</td>
<td width="10">: </td>
<td>
'.$agmx_agama.'
</td>
</tr>

<tr valign="top">
<td width="200">
44. Kewarganegaraan
</td>
<td width="10">: </td>
<td>
'.$y_warga_negara.'
</td>
</tr>

<tr valign="top">
<td width="200">
45. Pendidikan
</td>
<td width="10">: </td>
<td>
'.$y_pendidikan.'
</td>
</tr>

<tr valign="top">
<td width="200">
46. Pekerjaan
</td>
<td width="10">: </td>
<td>
'.$pekx_pekerjaan.'
</td>
</tr>

<tr valign="top">
<td width="200">
47. Penghasilan per Bulan
</td>
<td width="10">: </td>
<td>
'.xduit2($y_penghasilan).'
</td>
</tr>

<tr valign="top">
<td width="200">
48. Alamat Rumah / Telepon
</td>
<td width="10">: </td>
<td>
'.$y_alamat.' / '.$y_telp.'
</td>
</tr>
</table>');





//H. KEGEMARAN SISWA ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qnil = mysql_query("SELECT m_siswa_hobi.*, siswa_kelas.* ".
						"FROM m_siswa_hobi, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_hobi.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_kesenian = balikin2($rnil['kesenian']);
$y_olah_raga = balikin2($rnil['olah_raga']);
$y_organisasi = balikin2($rnil['organisasi']);
$y_lain = balikin2($rnil['lain_lain']);


$pdf->WriteHTML('<p>
<strong>H. KEGEMARAN SISWA</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
49. Kesenian
</td>
<td width="10">: </td>
<td>
'.$y_kesenian.'
</td>
</tr>

<tr valign="top">
<td width="200">
50. Olah Raga
</td>
<td width="10">: </td>
<td>
'.$y_olah_raga.'
</td>
</tr>

<tr valign="top">
<td width="200">
51. Kemasyarakatan / Organisasi
</td>
<td width="10">: </td>
<td>
'.$y_organisasi.'
</td>
</tr>

<tr valign="top">
<td width="200">
52. Lain - Lain
</td>
<td width="10">: </td>
<td>
'.$y_lain.'
</td>
</tr>
</table>');





//I. KETERANGAN PERKEMBANGAN SISWA /////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qnil = mysql_query("SELECT m_siswa_perkembangan.*, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_perkembangan.tgl, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_perkembangan, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_perkembangan.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_bea_siswa = balikin2($rnil['bea_siswa']);
$y_tgl_tinggal = nosql($rnil['tgl']);
$y_bln_tinggal = nosql($rnil['bln']);
$y_thn_tinggal = nosql($rnil['thn']);
$y_alasan = balikin2($rnil['alasan']);
$y_tamat = balikin2($rnil['tamat']);
$y_no_sttb = balikin2($rnil['no_sttb']);


$pdf->WriteHTML('<p>
<strong>I. KETERANGAN PERKEMBANGAN SISWA</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
53. Menerima Bea Siswa
</td>
<td width="10">: </td>
<td>
'.$y_bea_siswa.'
</td>
</tr>

<tr valign="top">
<td width="200">
54. Meninggalkan Sekolah
</td>
<td width="10"></td>
<td></td>
</tr>

<tr valign="top">
<td width="200">
     <dd>a. Tanggal </dd>
</td>
<td width="10">: </td>
<td>
'.$y_tgl_tinggal.' '.$arrbln1[$y_bln_tinggal].' '.$y_thn_tinggal.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>b. Alasan</dd>
</td>
<td width="10">: </td>
<td>
'.$y_alasan.'
</td>
</tr>

<tr valign="top">
<td width="200">
55. Akhir Pendidikan
</td>
<td width="10"></td>
<td></td>
</tr>

<tr valign="top">
<td width="200">
     <dd>a. Tamat Belajar</dd>
</td>
<td width="10">: </td>
<td>
'.$y_tamat.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>b. STTB Nomor</dd>
</td>
<td width="10">: </td>
<td>
'.$y_no_sttb.'
</td>
</tr>
</table>');





//J. KETERANGAN SETELAH SELESAI PENDIDIKAN /////////////////////////////////////////////////////////////////////////////////////////////
//query
$qnil = mysql_query("SELECT m_siswa_selesai.*, ".
						"DATE_FORMAT(m_siswa_selesai.tgl, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa_selesai.tgl, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa_selesai.tgl, '%Y') AS thn, ".
						"siswa_kelas.* ".
						"FROM m_siswa_selesai, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa_selesai.kd_siswa ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rnil = mysql_fetch_assoc($qnil);
$y_melanjutkan_di = balikin2($rnil['melanjutkan_di']);
$y_bekerja = balikin2($rnil['bekerja']);
$y_tgl_kerja = nosql($rnil['tgl']);
$y_bln_kerja = nosql($rnil['bln']);
$y_thn_kerja = nosql($rnil['thn']);
$y_instansi = balikin2($rnil['instansi']);
$y_penghasilan = balikin2($rnil['penghasilan']);


$pdf->WriteHTML('<p>
<strong>J. KETERANGAN SETELAH SELESAI PENDIDIKAN</strong>
</p>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="200">
56. Melanjutkan di
</td>
<td width="10">: </td>
<td>
'.$y_melanjutkan_di.'
</td>
</tr>

<tr valign="top">
<td width="200">
57. Bekerja
</td>
<td width="10">: </td>
<td>
'.$y_bekerja.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>a. Tanggal Mulai Bekerja</dd>
</td>
<td width="10">: </td>
<td>
'.$y_tgl_kerja.' '.$arrbln1[$y_bln_kerja].' '.$y_thn_kerja.'
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>b. Nama Perusahaan</dd>
     <br>
	 <dd>/ Lembaga / Lain-lain</dd>
</td>
<td width="10">: </td>
<td>
<input name="instansi" type="text" value="'.$y_instansi.'" size="30">
</td>
</tr>

<tr valign="top">
<td width="200">
     <dd>c. Penghasilan</dd>
</td>
<td width="10">: </td>
<td>
'.xduit2($y_penghasilan).'
</td>
</tr>
</table>');






//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("print_siswa_$y_nis.pdf",I);


//diskonek
xclose($koneksi);
exit();
?>
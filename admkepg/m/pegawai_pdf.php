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

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/pegawai.php");


nocache;

//nilai
$filenya = "pegawai_pdf.php";
$judul = "Profil Pegawai";
$judulku = $judul;
$pkd = nosql($_REQUEST['pkd']);
$s = nosql($_REQUEST['s']);




//start class
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);





//isi *START
ob_start();



//VIEW //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->SetY(10);
$pdf->Headerku();
$pdf->SetFont('Times','',10);


//xheadline($judul);





		//data query -> datadiri
		$qnil = mysql_query("SELECT m_pegawai.*, DATE_FORMAT(m_pegawai.tgl_lahir, '%d') AS lahir_tgl, ".
								"DATE_FORMAT(m_pegawai.tgl_lahir, '%m') AS lahir_bln, ".
								"DATE_FORMAT(m_pegawai.tgl_lahir, '%Y') AS lahir_thn ".
								"FROM m_pegawai ".
								"WHERE kd = '$pkd'");
		$rnil = mysql_fetch_assoc($qnil);
		$y_nip = nosql($rnil['nip']);
		$y_nuptk = nosql($rnil['nuptk']);
		$y_nama = balikin($rnil['nama']);
		$y_no_karpeg = nosql($rnil['no_karpeg']);
		$y_kode = nosql($rnil['kode']);

		$tmp_lahir = balikin($rnil['tmp_lahir']);

		$lahir_tgl = nosql($rnil['lahir_tgl']);
		$lahir_bln = nosql($rnil['lahir_bln']);
		$lahir_thn = nosql($rnil['lahir_thn']);

		$jkelkd = nosql($rnil['kd_kelamin']);
		$agmkd = nosql($rnil['kd_agama']);

		$y_alamat = balikin($rnil['alamat']);
		$y_telp = balikin($rnil['telp']);
		$y_gol_darah = balikin($rnil['gol_darah']);
		$y_filex = $rnil['filex'];


		//judul
		$pdf->SetFont('Times','B',14);
		$pdf->writeHTML('<table bgcolor="'.$warna02.'" width="700" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td>
		<big>
		<strong>PROFIL : '.$y_nip.'.'.$y_nama.'</strong>
		</big>
		</td>
		</tr>
		</table>
		<hr>
		<br>');

		$pdf->SetFont('Times','',10);
		$pdf->writeHTML('<table width="700" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td>
		<h1><strong>DATA DIRI</strong></h1>
		</td>
		</tr>
		</table>
		<hr width="40">

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		NIP
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y_nip.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		NUPTK
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y_nuptk.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Kode
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y_kode.'</strong>,

		No. KarPeg :
		<strong>'.$y_no_karpeg.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Nama
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y_nama.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		TTL
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$tmp_lahir.', '.$lahir_tgl.' '.$arrbln1[$lahir_bln].' '.$lahir_thn.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Jenis Kelamin
		</td>
		<td width="10">: </td>
		<td>');

		//terpilih
		$qjkelx = mysql_query("SELECT * FROM m_kelamin ".
								"WHERE kd = '$jkelkd'");
		$rjkelx = mysql_fetch_assoc($qjkelx);
		$jkelx_kd = nosql($rjkelx['kd']);
		$jkelx_kelamin = balikin($rjkelx['kelamin']);

		$pdf->writeHTML('<strong>'.$jkelx_kelamin.'</strong>,

		Agama : ');

		//terpilih
		$qagmx = mysql_query("SELECT * FROM m_agama ".
								"WHERE kd = '$agmkd'");
		$ragmx = mysql_fetch_assoc($qagmx);
		$agmx_kd = nosql($ragmx['kd']);
		$agmx_agama = balikin($ragmx['agama']);

		$pdf->writeHTML('<strong>'.$agmx_agama.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Alamat
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y_alamat.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Telp.
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y_telp.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Golongan Darah
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y_gol_darah.'</strong>
		</td>
		</tr>
		</table>
		<br>
		<br>
		<br>');





		//data query -> keluarga
		$qnil2 = mysql_query("SELECT m_pegawai_keluarga.*, ".
								"DATE_FORMAT(tgl_nikah, '%d') AS nikah_tgl, ".
								"DATE_FORMAT(tgl_nikah, '%m') AS nikah_bln, ".
								"DATE_FORMAT(tgl_nikah, '%Y') AS nikah_thn, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%d') AS pasangan_tgl, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%m') AS pasangan_bln, ".
								"DATE_FORMAT(tgl_lahir_pasangan, '%Y') AS pasangan_thn, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%d') AS anak1_tgl, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%m') AS anak1_bln, ".
								"DATE_FORMAT(anak1_tgl_lahir, '%Y') AS anak1_thn, ".
								"DATE_FORMAT(anak2_tgl_lahir, '%d') AS anak2_tgl, ".
								"DATE_FORMAT(anak2_tgl_lahir, '%m') AS anak2_bln, ".
								"DATE_FORMAT(anak2_tgl_lahir, '%Y') AS anak2_thn, ".
								"DATE_FORMAT(anak3_tgl_lahir, '%d') AS anak3_tgl, ".
								"DATE_FORMAT(anak3_tgl_lahir, '%m') AS anak3_bln, ".
								"DATE_FORMAT(anak3_tgl_lahir, '%Y') AS anak3_thn ".
								"FROM m_pegawai_keluarga ".
								"WHERE kd_pegawai = '$pkd'");
		$rnil2 = mysql_fetch_assoc($qnil2);
		$y2_nama_ayah = balikin2($rnil2['nama_ayah']);
		$y2_nama_ibu = balikin2($rnil2['nama_ibu']);
		$y2_nikah_tgl = nosql($rnil2['nikah_tgl']);
		$y2_nikah_bln = nosql($rnil2['nikah_bln']);
		$y2_nikah_thn = nosql($rnil2['nikah_thn']);
		$y2_pasangan_nama = balikin2($rnil2['nama_pasangan']);
		$y2_pasangan_tmp_lahir = balikin2($rnil2['tmp_lahir_pasangan']);
		$y2_pasangan_tgl = nosql($rnil2['pasangan_tgl']);
		$y2_pasangan_bln = nosql($rnil2['pasangan_bln']);
		$y2_pasangan_thn = nosql($rnil2['pasangan_thn']);
		$y2_pasangan_kerja = balikin2($rnil2['pekerjaan_pasangan']);
		$y2_pasangan_nip = nosql($rnil2['nip_pasangan']);
		$y2_pasangan_gaji = nosql($rnil2['gaji_pasangan']);

		//kawin
		$y2_kawin_nil = nosql($rnil2['status_kawin']);

		if ($y2_kawin_nil == "true")
			{
			$y2_kawin = "Kawin";
			}
		else
			{
			$y2_kawin = "Belum Kawin";
			}




		//anak1
		$y2_anak1_nama = balikin2($rnil2['anak1_nama']);
		$y2_anak1_tmp_lahir = balikin2($rnil2['anak1_tmp_lahir']);
		$y2_anak1_tgl = nosql($rnil2['anak1_tgl']);
		$y2_anak1_bln = nosql($rnil2['anak1_bln']);
		$y2_anak1_thn = nosql($rnil2['anak1_thn']);
		$y2_anak1_kelamin = nosql($rnil2['anak1_kelamin']);
		$y2_anak1_sekolah = balikin2($rnil2['anak1_sekolah']);
		$y2_anak1_tunjangan = balikin2($rnil2['anak1_tunjangan']);

		//anak2
		$y2_anak2_nama = balikin2($rnil2['anak2_nama']);
		$y2_anak2_tmp_lahir = balikin2($rnil2['anak2_tmp_lahir']);
		$y2_anak2_tgl = nosql($rnil2['anak2_tgl']);
		$y2_anak2_bln = nosql($rnil2['anak2_bln']);
		$y2_anak2_thn = nosql($rnil2['anak2_thn']);
		$y2_anak2_kelamin = nosql($rnil2['anak2_kelamin']);
		$y2_anak2_sekolah = balikin2($rnil2['anak2_sekolah']);
		$y2_anak2_tunjangan = balikin2($rnil2['anak2_tunjangan']);

		//anak3
		$y2_anak3_nama = balikin2($rnil2['anak3_nama']);
		$y2_anak3_tmp_lahir = balikin2($rnil2['anak3_tmp_lahir']);
		$y2_anak3_tgl = nosql($rnil2['anak3_tgl']);
		$y2_anak3_bln = nosql($rnil2['anak3_bln']);
		$y2_anak3_thn = nosql($rnil2['anak3_thn']);
		$y2_anak3_kelamin = nosql($rnil2['anak3_kelamin']);
		$y2_anak3_sekolah = balikin2($rnil2['anak3_sekolah']);
		$y2_anak3_tunjangan = balikin2($rnil2['anak3_tunjangan']);

		$pdf->writeHTML('<table width="700" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td>
		<h1><strong>KELUARGA</strong></h1>
		</td>
		</tr>
		</table>
		<hr width="40">

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Nama Ayah
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_nama_ayah.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Nama Ibu
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_nama_ibu.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Kawin / Belum Kawin
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_kawin.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Tgl. Nikah
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_nikah_tgl.' '.$arrbln1[$y2_nikah_bln].' '.$y2_nikah_thn.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Nama Istri / Suami
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_pasangan_nama.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		TTL. Istri / Suami
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_pasangan_tmp_lahir.', '.$y2_pasangan_tgl.' '.$arrbln1[$y2_pasangan_bln].' '.$y2_pasangan_thn.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Pekerjaan Istri / Suami
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_pasangan_kerja.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		NIP. Istri / Suami
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_pasangan_nip.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Gaji Istri / Suami
		</td>
		<td width="10">: </td>
		<td>
		<strong>Rp. '.$y2_pasangan_gaji.',00</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Anak I
		</td>
		<td></td>
		<td></td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Nama</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak1_nama.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>TTL</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak1_tmp_lahir.'</strong>, <strong>'.$y2_anak1_tgl.' '.$arrbln1[$y2_anak1_bln].' '.$y2_anak1_thn.'</strong>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		<dd>Jenis Kelamin</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak1_kelamin.'</strong>
		</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Sekolah</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak1_sekolah.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Tunjangan</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak1_tunjangan.'</strong>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Anak II
		</td>
		<td></td>
		<td></td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Nama</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak2_nama.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>TTL</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak2_tmp_lahir.'</strong>, <strong>'.$y2_anak2_tgl.' '.$arrbln1[$y2_anak2_bln].' '.$y2_anak2_thn.'</strong>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		<dd>Jenis Kelamin</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak2_kelamin.'</strong>
		</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Sekolah</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak2_sekolah.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Tunjangan</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak2_tunjangan.'</strong>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>

		<tr valign="top">
		<td width="150">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Anak III
		</td>
		<td></td>
		<td></td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Nama</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak3_nama.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>TTL</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak3_tmp_lahir.'</strong>, <strong>'.$y2_anak3_tgl.' '.$arrbln1[$y2_anak3_bln].' '.$y2_anak3_thn.'</strong>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		<dd>Jenis Kelamin</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak3_kelamin.'</strong>
		</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Sekolah</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak3_sekolah.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Tunjangan</dd>
		</td>
		<td width="10">: </td>
		<td>
		<strong>'.$y2_anak3_tunjangan.'</strong>
		</td>
		</tr>
		</table>
		<br>
		<br>
		<br>');





		//data query -> diklat
		$qnil3 = mysql_query("SELECT * FROM m_pegawai_diklat ".
								"WHERE kd_pegawai = '$pkd' ".
								"AND kd = '$dkkd'");
		$rnil3 = mysql_fetch_assoc($qnil3);
		$y3_nama_diklat = balikin2($rnil3['nama']);
		$y3_penyelenggara = balikin2($rnil3['penyelenggara']);
		$y3_tmp_diklat = balikin2($rnil3['tempat']);
		$y3_tahun_diklat = nosql($rnil3['tahun']);
		$y3_lama_diklat = nosql($rnil3['lama']);


		$pdf->writeHTML('<table width="700" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td>
		<h1><strong>DIKLAT</strong></h1>
		</td>
		</tr>
		</table>
		<hr width="40">');

		//query
		$qdk = mysql_query("SELECT * FROM m_pegawai_diklat ".
								"WHERE kd_pegawai = '$pkd' ".
								"ORDER BY nama ASC");
		$rdk = mysql_fetch_assoc($qdk);
		$tdk = mysql_num_rows($qdk);

		if ($tdk != 0)
			{
			$pdf->writeHTML('<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td><strong><font color="'.$warnatext.'">Nama Diklat</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Penyelenggara</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Tempat</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Tahun</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Lama</font></strong></td>
			</tr>');

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
				$dk_kd = nosql($rdk['kd']);
				$dk_nama = balikin2($rdk['nama']);
				$dk_penyelenggara = balikin2($rdk['penyelenggara']);
				$dk_tempat = balikin2($rdk['tempat']);
				$dk_tahun = balikin2($rdk['tahun']);
				$dk_lama = balikin2($rdk['lama']);

				$pdf->writeHTML('<tr valign="top">
				<td>'.$dk_nama.'</td>
				<td>'.$dk_penyelenggara.'</td>
				<td>'.$dk_tempat.'</td>
				<td>'.$dk_tahun.'</td>
				<td>'.$dk_lama.'</td>
		        </tr>');
				}
			while ($rdk = mysql_fetch_assoc($qdk));

			$pdf->writeHTML('</table>
			<br>
			<br>
			<br>');
			}

		else
			{
			$pdf->writeHTML('<font color="red"><strong>BELUM ADA DATA Diklat. </strong></font>
			<br>
			<br>
			<br>');
			}



		//data query -> mengajar
		$qnil4 = mysql_query("SELECT * FROM m_pegawai_mengajar ".
								"WHERE kd_pegawai = '$pkd'");
		$rnil4 = mysql_fetch_assoc($qnil4);
		$y4_ajar1_pddkn = balikin2($rnil4['mengajar1']);
		$y4_ajar1_jam = nosql($rnil4['jml_jam1']);
		$y4_ajar2_pddkn = balikin2($rnil4['mengajar2']);
		$y4_ajar2_jam = nosql($rnil4['jml_jam2']);


		$pdf->writeHTML('<table width="700" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td>
		<h1><strong>MENGAJAR</strong></h1>
		</td>
		</tr>
		</table>
		<hr width="40">

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Mengajar I
		</td>
		<td width="1"></td>
		<td>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Program Pendidikan</dd>
		</td>
		<td width="1">: </td>
		<td>
		<strong>'.$y4_ajar1_pddkn.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jumlah Jam</dd>
		</td>
		<td width="1">: </td>
		<td>
		<strong>'.$y4_ajar1_jam.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Mengajar II
		</td>
		<td width="1"></td>
		<td>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Program Pendidikan</dd>
		</td>
		<td width="1">: </td>
		<td>
		<strong>'.$y4_ajar2_pddkn.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jumlah Jam</dd>
		</td>
		<td width="1">: </td>
		<td>
		<strong>'.$y4_ajar2_jam.'</strong>
		</td>
		</tr>
		</table>
		<br>
		<br>
		<br>');





		//data query -> mk
		$qnil5 = mysql_query("SELECT * FROM m_pegawai_mk ".
								"WHERE kd_pegawai = '$pkd'");
		$rnil5 = mysql_fetch_assoc($qnil5);
		$y5_mk1_bln = nosql($rnil5['sk_bln']);
		$y5_mk1_thn = nosql($rnil5['sk_thn']);
		$y5_mk2_bln = nosql($rnil5['s_bln']);
		$y5_mk2_thn = nosql($rnil5['s_thn']);


		$pdf->writeHTML('<table width="700" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td>
		<h1><strong>MASA KERJA</strong></h1>
		</td>
		</tr>
		</table>
		<hr width="40">

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		SESUAI SK
		</td>
		<td width="1"></td>
		<td>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jml.Tahun</dd>
		</td>
		<td width="1">: </td>
		<td>
		'.$y5_mk1_thn.'
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jml.Bulan</dd>
		</td>
		<td width="1">: </td>
		<td>
		'.$y5_mk1_bln.'
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		KESELURUHAN
		</td>
		<td width="1"></td>
		<td>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jml.Tahun</dd>
		</td>
		<td width="1">: </td>
		<td>
		'.$y5_mk2_thn.'
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		<dd>Jml.Bulan</dd>
		</td>
		<td width="1">: </td>
		<td>
		'.$y5_mk2_bln.'
		</td>
		</tr>
		</table>
		<br>
		<br>
		<br>');





		//data query -> pekerjaan
		$qnil6 = mysql_query("SELECT m_pegawai_pekerjaan.*, ".
								"DATE_FORMAT(tmt_awal, '%d') AS awal_tgl, ".
								"DATE_FORMAT(tmt_awal, '%m') AS awal_bln, ".
								"DATE_FORMAT(tmt_awal, '%Y') AS awal_thn, ".
								"DATE_FORMAT(tmt_akhir, '%d') AS akhir_tgl, ".
								"DATE_FORMAT(tmt_akhir, '%m') AS akhir_bln, ".
								"DATE_FORMAT(tmt_akhir, '%Y') AS akhir_thn ".
								"FROM m_pegawai_pekerjaan ".
								"WHERE kd_pegawai = '$pkd'");
		$rnil6 = mysql_fetch_assoc($qnil6);
		$y6_status = nosql($rnil6['kd_status']);
		$y6_pangkat = nosql($rnil6['kd_pangkat']);
		$y6_golongan = nosql($rnil6['kd_golongan']);
		$y6_jabatan = nosql($rnil6['kd_jabatan']);
		$y6_awal_tgl = nosql($rnil6['awal_tgl']);
		$y6_awal_bln = nosql($rnil6['awal_bln']);
		$y6_awal_thn = nosql($rnil6['awal_thn']);
		$y6_akhir_tgl = nosql($rnil6['akhir_tgl']);
		$y6_akhir_bln = nosql($rnil6['akhir_bln']);
		$y6_akhir_thn = nosql($rnil6['akhir_thn']);


		$pdf->writeHTML('<table width="700" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td>
		<h1><strong>PEKERJAAN</strong></h1>
		</td>
		</tr>
		</table>
		<hr width="40">

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Status
		</td>
		<td width="1">: </td>
		<td>');

		//terpilih
		$qstx = mysql_query("SELECT * FROM m_status ".
								"WHERE kd = '$y6_status'");
		$rstx = mysql_fetch_assoc($qstx);
		$stx_kd = nosql($rstx['kd']);
		$stx_status = balikin($rstx['status']);

		$pdf->writeHTML('<strong>'.$stx_status.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		Pangkat
		</td>
		<td width="1">: </td>
		<td>');

		//terpilih
		$qpkx = mysql_query("SELECT * FROM m_pangkat ".
								"WHERE kd = '$y6_pangkat'");
		$rpkx = mysql_fetch_assoc($qpkx);
		$pkx_kd = nosql($rpkx['kd']);
		$pkx_pangkat = balikin($rpkx['pangkat']);

		$pdf->writeHTML('<strong>'.$pkx_pangkat.'</strong>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Golongan
		</td>
		<td width="1">: </td>
		<td>');

		//terpilih
		$qgolx = mysql_query("SELECT * FROM m_golongan ".
								"WHERE kd = '$y6_golongan'");
		$rgolx = mysql_fetch_assoc($qgolx);
		$golx_kd = nosql($rgolx['kd']);
		$golx_golongan = balikin($rgolx['golongan']);

		$pdf->writeHTML('<strong>'.$golx_golongan.'</strong>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		Jabatan
		</td>
		<td width="1">: </td>
		<td>');

		//terpilih
		$qjbtx = mysql_query("SELECT * FROM m_jabatan ".
								"WHERE kd = '$y6_jabatan'");
		$rjbtx = mysql_fetch_assoc($qjbtx);
		$jbtx_kd = nosql($rjbtx['kd']);
		$jbtx_jabatan = balikin($rjbtx['jabatan']);

		$pdf->writeHTML('<strong>'.$jbtx_jabatan.'</strong>
		</td>
		</tr>


		<tr valign="top">
		<td width="150">
		TMT. Awal
		</td>
		<td width="1">: </td>
		<td>
		<strong>'.$y6_awal_tgl.' '.$arrbln1[$y6_awal_bln].' '.$y6_awal_thn.'</strong>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		TMT. Akhir
		</td>
		<td width="1">: </td>
		<td>
		'.$y6_akhir_tgl.' '.$arrbln1[$y6_akhir_bln].' '.$y6_akhir_thn.'
		</td>
		</tr>
		</table>
		<br>
		<br>
		<br>');





		//data query -> pendidikan
		$qnil7 = mysql_query("SELECT * FROM m_pegawai_pendidikan ".
								"WHERE kd_pegawai = '$pkd' ".
								"AND kd = '$pddkkd'");
		$rnil7 = mysql_fetch_assoc($qnil7);
		$y7_ijazah = nosql($rnil7['kd_ijazah']);
		$y7_akta = nosql($rnil7['kd_akta']);
		$y7_lulus = nosql($rnil7['thn_lulus']);
		$y7_jurusan = balikin2($rnil7['jurusan']);
		$y7_nama_pt = balikin2($rnil7['nama_pt']);


		$pdf->writeHTML('<table width="700" border="0" cellspacing="3" cellpadding="0">
		<tr valign="top">
		<td>
		<h1><strong>PENDIDIKAN</strong></h1>
		</td>
		</tr>
		</table>
		<hr width="40">');

		//query
		$qdk = mysql_query("SELECT * FROM m_pegawai_pendidikan ".
								"WHERE kd_pegawai = '$pkd'");
		$rdk = mysql_fetch_assoc($qdk);
		$tdk = mysql_num_rows($qdk);

		if ($tdk != 0)
			{
			$pdf->writeHTML('<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="100"><strong><font color="'.$warnatext.'">Ijazah</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Akta</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Tahun Lulus</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Jurusan</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Nama PT</font></strong></td>
			</tr>');

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
				$dk_kd = nosql($rdk['kd']);
				$dk_kd_ijazah = nosql($rdk['kd_ijazah']);
				$dk_kd_akta = nosql($rdk['kd_akta']);
				$dk_lulus = nosql($rdk['thn_lulus']);
				$dk_jurusan = balikin2($rdk['jurusan']);
				$dk_nama_pt = balikin2($rdk['nama_pt']);


				//terpilih
				$qijz = mysql_query("SELECT * FROM m_ijazah ".
										"WHERE kd = '$dk_kd_ijazah'");
				$rijz = mysql_fetch_assoc($qijz);
				$ijz_kd = nosql($rijz['kd']);
				$ijz_ijazah = balikin($rijz['ijazah']);


				//akta
				$qakt = mysql_query("SELECT * FROM m_akta ".
										"WHERE kd = '$dk_kd_akta'");
				$rakt = mysql_fetch_assoc($qakt);
				$akt_kd = nosql($rakt['kd']);
				$akt_akta = balikin($rakt['akta']);

				$pdf->writeHTML('<tr valign="top">
				<td>'.$ijz_ijazah.'</td>
				<td>'.$akt_akta.'</td>
				<td>'.$dk_lulus.'</td>
				<td>'.$dk_jurusan.'</td>
				<td>'.$dk_nama_pt.'</td>
		        </tr>');
				}
			while ($rdk = mysql_fetch_assoc($qdk));
			}

		else
			{
			$pdf->writeHTML('<font color="red"><strong>BELUM ADA DATA Pendidikan.</strong></font>');
			}



$pdf->writeHTML('<br>
<br>
<br>');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("profil_guru_$y_nip.pdf",I);



//diskonek
xclose($koneksi);
exit();
?>
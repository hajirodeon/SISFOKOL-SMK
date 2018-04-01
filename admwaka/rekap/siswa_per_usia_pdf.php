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



//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/siswa_per_usia.php");

nocache;


//start class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$judul = "Rekap Data Siswa (Berdasarkan Usia)";
$judulz = $judul;
$batas = 22; //jumlah data per halaman



//isi *START
ob_start();

$pdf->SetFont('Times','',8);
$pdf->SetFillColor(233,233,233);



//query
$q = mysql_query("SELECT DISTINCT(m_siswa.nis) AS msnis ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"ORDER BY m_siswa.nama ASC");
$r = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);
$npage = ($total/$batas);



//query
for ($we=0;$we<=($npage);$we++)
	{
	//tambah halaman
	$pdf->AddPage();

	//nilai
	$page = $we + 1;

	//nek null
	if (empty($we))
		{
		$ken = $we;
		}
	else if ($we == 1)
		{
		$ken = $batas;
		}
	else
		{
		$ken = $batas * $we;
		}

	//judul
	//nek halaman satu, $we=0
	if ($we == 0)
		{
		$pdf->SetY(50);
		}
	else
		{
		//kolom header
		$pdf->SetY(40);
		}

	//kolom header
	$pdf->SetFont('Times','',8);

	$pdf->Cell(42,10,'NOMOR',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(7,5,'Urut',1,0,'C',1);
	$pdf->Cell(15,5,'NIS',1,0,'C',1);
	$pdf->Cell(20,5,'NISN',1,0,'C',1);

	$pdf->SetY($pdf->GetY()-10);
	$pdf->SetX(52);
	$pdf->Cell(40,15,'NAMA',1,0,'C',1);
	$pdf->Cell(7,15,'L/P',1,0,'C',1);
	$pdf->Cell(7,15,'KLS',1,0,'C',1);
	$pdf->Cell(40,15,'TTL.',1,0,'C',1);
	$pdf->Cell(10,15,'USIA',1,0,'C',1);
	$pdf->Cell(10,15,'UASBN',1,0,'C',1);
	$pdf->Cell(40,15,'ASAL SEKOLAH',1,0,'C',1);
	$pdf->Cell(70,5,'IDENTITAS ORANG TUA',1,0,'C',1);
	$pdf->Ln();

	$pdf->SetY($pdf->GetY());
	$pdf->SetX(206);
	$pdf->Cell(30,10,'NAMA',1,0,'C',1);
	$pdf->Cell(20,10,'Pend.',1,0,'C',1);
	$pdf->Cell(20,10,'Pekerjaan',1,0,'C',1);










	//kolom data
	//nek halaman satu, $we=0
	if ($we == 0)
		{
		$pdf->SetY(65);
		}
	else
		{
		$pdf->SetY(55);
		}

	$qx = "SELECT DISTINCT(m_siswa.nis) AS msnis ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"ORDER BY m_siswa.nama ASC";
	$qr = $qx;

	$count = mysql_num_rows(mysql_query($qx));
	$result = mysql_query("$qr LIMIT ".$ken.", ".$batas);
	$data = mysql_fetch_array($result);

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
		$i_nis = nosql($data['msnis']);


		//siswa
		$qnixu = mysql_query("SELECT m_siswa.*, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
					"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
					"m_siswa.kd AS mskd ".
					"FROM m_siswa ".
					"WHERE m_siswa.nis = '$i_nis'");
		$rnixu = mysql_fetch_assoc($qnixu);
		$nixu_kd = nosql($rnixu['mskd']);
		$nixu_nisn = nosql($rnixu['nisn']);
		$nixu_nm = balikin($rnixu['nama']);


		$kd_kelamin = nosql($rnixu['kd_kelamin']);
		$tmp_lahir = balikin2($rnixu['tmp_lahir']);
		$tgl_lahir = nosql($rnixu['tgl']);
		$bln_lahir = nosql($rnixu['bln']);
		$thn_lahir = nosql($rnixu['thn']);
		$ttl = "$tmp_lahir, $tgl_lahir $arrbln1[$bln_lahir] $thn_lahir";


		//kelamin
		$qmin = mysql_query("SELECT * FROM m_kelamin ".
					"WHERE kd = '$kd_kelamin'");
		$rmin = mysql_fetch_assoc($qmin);
		$min_kelamin = balikin2($rmin['kelamin']);


		//orang tua - ayah
		$qtun = mysql_query("SELECT * FROM m_siswa_ayah ".
					"WHERE kd_siswa = '$nixu_kd'");
		$rtun = mysql_fetch_assoc($qtun);
		$tun_nama = balikin2($rtun['nama']);
		$tun_kd_pendidikan = nosql($rtun['kd_pendidikan']);

		$dt_ayah_pekerjaan = balikin($rtun['kd_pekerjaan']);
		$qayah_pek = mysql_query("SELECT * FROM m_pekerjaan ".
						"WHERE kd = '$dt_ayah_pekerjaan'");
		$rayah_pek = mysql_fetch_assoc($qayah_pek);
		$dt_ayah_pekerjaan = balikin($rayah_pek['pekerjaan']);


		//terpilih
		$qpki = mysql_query("SELECT * FROM m_pendidikan ".
					"WHERE kd = '$tun_kd_pendidikan'");
		$rpki = mysql_fetch_assoc($qpki);
		$dt_ayah_pendidikan = balikin($rpki['pendidikan']);



		//lulusan dari
		$qpend = mysql_query("SELECT * FROM m_siswa_pendidikan ".
					"WHERE kd_siswa = '$nixu_kd'");
		$rpend = mysql_fetch_assoc($qpend);
		$nama_sekolah = balikin2($rpend['nama_sekolah']);
		$uasbn = nosql($rpend['r_uasbn']);


		//tmp_tinggal
		$qtpg = mysql_query("SELECT * FROM m_siswa_tmp_tinggal ".
					"WHERE kd_siswa = '$nixu_kd'");
		$rtpg = mysql_fetch_assoc($qtpg);
		$dt_alamat = balikin($rtpg['alamat']);
		$alamat = "$dt_alamat";



		//kelas saat ini
		$qkel = mysql_query("SELECT siswa_kelas.*, m_kelas.* ".
					"FROM siswa_kelas, m_kelas ".
					"WHERE siswa_kelas.kd_kelas = m_kelas.kd ".
					"AND siswa_kelas.kd_siswa = '$nixu_kd'");
		$rkel = mysql_fetch_assoc($qkel);
		$kel_kelas = balikin($rkel['kelas']);


		//ketahui usianya
		//jika null
		if ((empty($thn_lahir)) OR ($thn_lahir == "0000"))
			{
			$selisih_thn = 0;
			}
		else
			{
			if (($utgl >= $tgl_lahir) AND ($ubln >= $bln_lahir) AND ($uthn >= $thn_lahir))
				{
				$selisih_thn = round($uthn - $thn_lahir);
				}
			else
				{
				$selisih_thn = round($uthn - ($thn_lahir + 1));
				}
			}

		//list data
		$pdf->Cell(7,5,$nomer,1,0,'C');
		$pdf->Cell(15,5,$i_nis,1,0,'L');
		$pdf->Cell(20,5,$nixu_nisn,1,0,'L');
		$pdf->Cell(40,5,$nixu_nm,1,0,'L');
		$pdf->Cell(7,5,$min_kelamin,1,0,'L');
		$pdf->Cell(7,5,$kel_kelas,1,0,'L');
		$pdf->Cell(40,5,$ttl,1,0,'L');
		$pdf->Cell(10,5,$selisih_thn,1,0,'L');
		$pdf->Cell(10,5,$uasbn,1,0,'L');
		$pdf->Cell(40,5,$nama_sekolah,1,0,'L');
		$pdf->Cell(30,5,$tun_nama,1,0,'L');
		$pdf->Cell(20,5,$dt_ayah_pendidikan,1,0,'L');
		$pdf->Cell(20,5,$dt_ayah_pekerjaan,1,0,'L');
		$pdf->Ln();
		}
	while ($data = mysql_fetch_assoc($result));
	}


//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("Rekap_siswa_per_usia.pdf",I);
?>
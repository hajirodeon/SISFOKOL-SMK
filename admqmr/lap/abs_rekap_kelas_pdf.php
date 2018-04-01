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
require("../../inc/class/lap_abs_rekap_kelas.php");

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
$keakd = nosql($_REQUEST['keakd']);
$kelkd = nosql($_REQUEST['kelkd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$judul = "LAPORAN REKAP ABSENSI per KELAS RUANG";
$judulz = $judul;
$batas = 28; //jumlah data per halaman



//isi *START
ob_start();

$pdf->SetFont('Times','',10);

//query
$q = mysql_query("SELECT DISTINCT(siswa_kelas.kd_siswa) AS swkd ".
					"FROM siswa_absensi, siswa_kelas, m_siswa ".
					"WHERE siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
					"AND siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_keahlian = '$keakd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn' ".
					"AND siswa_absensi.kd_absensi <> '' ".
					"AND round(TIME_FORMAT(siswa_absensi.jam, '%H')) <> '00' ".
					"ORDER BY m_siswa.nis ASC");
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
	$pdf->SetFont('Times','',10);
	$pdf->RotatedText(20,5,'NIS',0);
	$pdf->RotatedText(50,5,'Nama Siswa',0);
	$pdf->RotatedText(50,5,'Ket.',0);



	//kolom data
	//nek halaman satu, $we=0
	if ($we == 0)
		{
		$pdf->SetY(55);
		}
	else
		{
		$pdf->SetY(45);
		}

	$qx = "SELECT DISTINCT(siswa_kelas.kd_siswa) AS swkd ".
			"FROM siswa_absensi, siswa_kelas, m_siswa ".
			"WHERE siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
			"AND siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_keahlian = '$keakd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
			"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn' ".
			"AND siswa_absensi.kd_absensi <> '' ".
			"AND round(TIME_FORMAT(siswa_absensi.jam, '%H')) <> '00' ".
			"ORDER BY m_siswa.nis ASC";
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
		$kd = nosql($data['swkd']);


		//siswa
		$qnixu = mysql_query("SELECT * FROM m_siswa ".
								"WHERE kd = '$kd'");
		$rnixu = mysql_fetch_assoc($qnixu);
		$nixu_nis = nosql($rnixu['nis']);
		$nixu_nm = balikin($rnixu['nama']);

		//detail
		$qnitu = mysql_query("SELECT siswa_absensi.*, siswa_kelas.*, m_siswa.*,  ".
								"round(DATE_FORMAT(siswa_absensi.tgl, '%d')) AS abs_tgl ".
								"FROM siswa_absensi, siswa_kelas, m_siswa ".
								"WHERE siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
								"AND siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_kelas.kd_tapel = '$tapelkd' ".
								"AND siswa_kelas.kd_keahlian = '$keakd' ".
								"AND siswa_kelas.kd_kelas = '$kelkd' ".
								"AND siswa_kelas.kd_siswa = '$kd' ".
								"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn' ".
								"AND siswa_absensi.kd_absensi <> '' ".
								"AND round(TIME_FORMAT(siswa_absensi.jam, '%H')) <> '00'");
		$rnitu = mysql_fetch_assoc($qnitu);
		$tnitu = mysql_num_rows($qnitu);


		//list data
		$pdf->Cell(20,5*$tnitu*4,$nixu_nis,1,0,'L');
		$pdf->Cell(50,5*$tnitu*4,$nixu_nm,1,0,'L');

		//kotak i aja
		$u_nil = 80;
		$pdf->SetX($u_nil);
		$pdf->Cell(50,5*$tnitu*4,'',1,0,'L');


		do
			{
			//nilai
			$nitu_abs_kd = nosql($rnitu['kd_absensi']);
			$nitu_abs_tgl = nosql($rnitu['abs_tgl']);
			$nitu_jam_xjam = substr($rnitu['jam'],0,2);
			$nitu_jam_xmnt = substr($rnitu['jam'],3,2);
			$nitu_perlu = balikin($rnitu['keperluan']);

			//nek empty
			if ($nitu_jam_xjam == "00")
				{
				$nitu_jam_xjam = "";

				if ($nitu_jam_xmnt == "00")
					{
					$nitu_jam_xmnt = "";
					}
				}


			//absensinya
			$qbein = mysql_query("SELECT * FROM m_absensi ".
									"WHERE kd = '$nitu_abs_kd'");
			$rbein = mysql_fetch_assoc($qbein);
			$bein_kd = nosql($rbein['kd']);
			$bein_abs = balikin($rbein['absensi']);

			$u_tgl = "Tgl. : $nitu_abs_tgl. Jam : $nitu_jam_xjam:$nitu_jam_xmnt";
			$u_ket = "Ket : $bein_abs";
			$u_perlu = "Keperluan : $nitu_perlu";

			//posisi
			$u_nil = 80;
			$pdf->SetX($u_nil);
			$pdf->Cell(50,5,$u_tgl,0,0,'L');
			$pdf->Ln();
			$pdf->SetX($u_nil);
			$pdf->Cell(50,5,$u_ket,0,0,'L');
			$pdf->Ln();
			$pdf->SetX($u_nil);
			$pdf->Cell(50,5,$u_perlu,0,0,'L');
			$pdf->Ln();
			$pdf->SetX($u_nil);
			$pdf->Cell(50,5,'',0,0,'L');
			$pdf->Ln();
			}
		while ($rnitu = mysql_fetch_assoc($qnitu));

//		$pdf->Ln();
		}
	while ($data = mysql_fetch_assoc($result));
	}


//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("Rekap_Absensi_per_Kelas.pdf",I);
?>
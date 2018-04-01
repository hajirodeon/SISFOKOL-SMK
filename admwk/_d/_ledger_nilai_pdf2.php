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



//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/ledger_nilai.php");

nocache;

//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$rukd = nosql($_REQUEST['rukd']);
$judul = "LEGGER NILAI";



//start class
$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//kelas
$qk = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rk = mysql_fetch_assoc($qk);
$rkel = nosql($rk['kelas']);


//keahlian
$qpro = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_bidang = balikin($rpro['bidang']);
$pro_program = balikin($rpro['program']);
$pro_keah = "$pro_program";



//ruang
$qu = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$rukd'");
$ru = mysql_fetch_assoc($qu);
$rru = balikin($ru['ruang']);
$kelas = "$rkel-$rru";


//smt
$qmt = mysql_query("SELECT * FROM m_smt ".
			"WHERE kd = '$smtkd'");
$rmt = mysql_fetch_assoc($qmt);
$smt = balikin($rmt['smt']);

//tapel
$qtp = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rtp = mysql_fetch_assoc($qtp);
$thn1 = nosql($rtp['tahun1']);
$thn2 = nosql($rtp['tahun2']);
$tapel = "$thn1/$thn2";






//header page /////////////////////////////////////////////////////////////////////////////////////////////////
$batas1 = 8; //jumlah data per halaman

//query
$q = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
			"siswa_kelas.*, siswa_kelas.kd AS skkd ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_keahlian = '$keahkd' ".
			"AND siswa_kelas.kd_ruang = '$rukd' ".
			"ORDER BY round(siswa_kelas.no_absen) ASC");
$r = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);
$npage = 0;




//tambah halaman
$pdf->AddPage();

$pdf->SetY(10);
$pdf->SetX(10);
$pdf->Headerku();

$pdf->SetFont('Times','B',18);
$pdf->Cell(190,5,'LEGGER NILAI',0,0,'C');

//kolom data
$pdf->SetY(60);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Times','B',10);
$pdf->Cell(20,40,'NIS',1,0,'C',1);
$pdf->Cell(50,40,'NAMA',1,0,'C',1);
$pdf->Cell(10,40,'SMT',1,0,'C',1);
$pdf->Cell(10,40,'KKM',1,0,'C',1);



//jenis mapel
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"ORDER BY round(no) ASC");
$rjnsp = mysql_fetch_assoc($qjnsp);
$tjnsp = mysql_num_rows($qjnsp);

do
	{
	//nilai jenis...
	$jnsp_kd = nosql($rjnsp['kd']);
	$jnsp_no = nosql($rjnsp['no']);
	$jnsp_jenis = balikin($rjnsp['jenis']);


	//query
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
				"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
				"ORDER BY round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);


	//jika muatan lokal, satu ato dua
	if ($jnsp_no == "4")
		{
		$pdf->Cell(5*$tpel,5,'MULOK',1,0,'C',1);
		}
	else
		{
		$pdf->Cell(5*$tpel,5,$jnsp_jenis,1,0,'C',1);
		}
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));




//jumlah dan rangking
$qpelx = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
			"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
			"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
			"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
			"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
			"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd'");
$rpelx = mysql_fetch_assoc($qpelx);
$tpelx = mysql_num_rows($qpelx);

$pdf->GetX();
$nil_jml = $pdf->GetX();
$pdf->Cell(10,40,'',1,0,'L',1);
$pdf->TextWithDirection($nil_jml+6,98,'JUMLAH','U');
$pdf->Cell(5,40,'',1,0,'L',1);
$pdf->TextWithDirection($nil_jml+14,98,'PERINGKAT','U');
$pdf->Ln();



$pdf->SetY(60);
$pdf->SetX($nil_jml+15);
$pdf->Cell(15,5,"ABSEN",1,0,'C',1);


$qabs = mysql_query("SELECT * FROM m_absensi ".
			"ORDER BY absensi2 DESC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

$pdf->SetY(65);
$pdf->SetX($nil_jml+15);
$nil_jml2 = $pdf->GetX();

do
	{
	$i_nom = $i_nom + 5;
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);
	$abs_absensi2 = balikin($rabs['absensi2']);

	$pdf->Cell(5,35,'',1,0,'L',1);
	$pdf->TextWithDirection($nil_jml2+$i_nom-1.5,98,$abs_absensi,'U');
	}
while ($rabs = mysql_fetch_assoc($qabs));






$pdf->SetY(60);
$pdf->SetX($nil_jml2+15);
$pdf->Cell(21,5,"PRIBADI",1,0,'C',1);


//pribadi
$qabs = mysql_query("SELECT * FROM m_pribadi ".
			"ORDER BY pribadi ASC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

$pdf->SetY(65);
$pdf->SetX($nil_jml2+15);
$nil_jml3 = $pdf->GetX();

do
	{
	$i_nom = $i_nom + 7;
	$abs_kd = nosql($rabs['kd']);
	$abs_pribadi = balikin($rabs['pribadi']);

	$pdf->Cell(7,35,'',1,0,'L',1);
	$pdf->TextWithDirection($nil_jml3+$i_nom-17,98,$abs_pribadi,'U');
	}
while ($rabs = mysql_fetch_assoc($qabs));





/*
$nil_jml2 = $pdf->GetX();
$pdf->SetX($nil_jml2);
$qabs = mysql_query("SELECT * FROM m_absensi ".
			"ORDER BY absensi2 DESC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

do
	{
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi2 = balikin($rabs['absensi2']);

	$pdf->Cell(5,5,$abs_absensi2,1,0,'C',1);
	}
while ($rabs = mysql_fetch_assoc($qabs));

*/







//mapel-nya...
//jenis mapel
$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"ORDER BY round(no) ASC");
$rjnsp = mysql_fetch_assoc($qjnsp);
$tjnsp = mysql_num_rows($qjnsp);

$pdf->SetY(55);


do
	{
	//nilai jenis...
	$jnsp_kd = nosql($rjnsp['kd']);
	$jnsp_no = nosql($rjnsp['no']);
	$jnsp_jenis = balikin($rjnsp['jenis']);


	//query
	$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
				"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
				"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
				"ORDER BY round(m_prog_pddkn.no) ASC, ".
				"round(m_prog_pddkn.no_sub) ASC");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);

	do
		{
		//nilai
		$pelkd = nosql($rpel['pelkd']);
		$pelno = nosql($rpel['no']);
		$pel = substr(balikin2($rpel['xpel']),0,25);


/*
		//jika mulok
		if ($pelno == "4")
			{
//			$pdf->Rotate(90,71,39);
			$pdf->Cell(40,5,$pel,1,0,'L',1);
			$pdf->Rotate(0);
			$pdf->Ln();
			}
		else
			{
			$pdf->SetFont('Times','',8);
//			$pdf->Rotate(90,71,39);
			$pdf->Rotate(90,77.5,32.5);
			$pdf->Cell(35,5,$pel,1,0,'L',1);
			$pdf->Rotate(0);
			$pdf->Ln();
			}
*/

		$pdf->SetFont('Times','',8);
		$pdf->Rotate(90,77.5,32.5);
		$pdf->Cell(35,5,$pel,1,0,'L',1);
		$pdf->Rotate(0);
		$pdf->Ln();
		}
	while ($rpel = mysql_fetch_assoc($qpel));
	}
while ($rjnsp = mysql_fetch_assoc($qjnsp));





//query
for ($we=0;$we<=($npage);$we++)
	{
	//nilai
	$page = $we + 1;

	//nek null
	if (empty($we))
		{
		$ken = $we;
		}
	else if ($we == 1)
		{
		$ken = $batas1;
		}
	else
		{
		$ken = $batas1 * $we;
		}








	//kolom nilai /////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->Ln();
	$pdf->SetFont('Times','',8);



	$qx = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
		"siswa_kelas.*, siswa_kelas.kd AS skkd ".
		"FROM m_siswa, siswa_kelas ".
		"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
		"AND siswa_kelas.kd_tapel = '$tapelkd' ".
		"AND siswa_kelas.kd_kelas = '$kelkd' ".
		"AND siswa_kelas.kd_keahlian = '$keahkd' ".
		"AND siswa_kelas.kd_keahlian_kompetensi = '$kompkd' ".
//		"AND siswa_kelas.kd_ruang = '$rukd' ".
		"ORDER BY round(siswa_kelas.no_absen) ASC";
	$qr = $qx;

	$count = mysql_num_rows(mysql_query($qx));
	$result = mysql_query("$qr LIMIT ".$ken.", ".$batas1);
	$data = mysql_fetch_array($result);

	$pdf->SetY(100);
	$pdf->SetX(10);

	do
		{
		//nilai
		$jnspx_skkd = nosql($data['skkd']);
		$jnspx_nis = nosql($data['nis']);
		$jnspx_nama = balikin($data['nama']);
		$uts_nomer = $uts_nomer + 10;
		$uas_nomer = $uas_nomer + 10;
		$pdf->Cell(20,10,$jnspx_nis,1,0,'L');
		$pdf->Cell(50,10,$jnspx_nama,1,0,'L');





		//rangking ////////////////////////////////////////////////////////////////////////////////////////////
		//query
		$qpelx = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
					"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
					"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
					"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
					"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
					"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
					"ORDER BY round(m_prog_pddkn.no_sub) ASC");
		$rpelx = mysql_fetch_assoc($qpelx);
		$tpelx = mysql_num_rows($qpelx);

		$pdf->SetX(87+($tpelx*5));

		//query
		$qkunilx2 = mysql_query("SELECT * FROM siswa_rangking ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_keahlian ='$keahkd' ".
						"AND kd_keahlian_kompetensi ='$kompkd' ".
						"AND kd_kelas ='$kelkd' ".
						"AND kd_ruang = '$rukd' ".
						"AND kd_siswa_kelas = '$jnspx_skkd' ".
						"AND kd_smt = '$smtkd'");
		$rkunilx2 = mysql_fetch_assoc($qkunilx2);
		$tkunilx2 = mysql_num_rows($qkunilx2);
		$kunilx2_rangking = nosql($rkunilx2['rangking']);

		//jumlah nilai
		$qniku = mysql_query("SELECT SUM(uas) AS total ".
					"FROM siswa_nilai_prog_pddkn ".
					"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
					"AND kd_smt = '$smtkd'");
		$rniku = mysql_fetch_assoc($qniku);
		$niku_total = nosql($rniku['total']);


		$pdf->Cell(10,10,$niku_total,1,0,'C');
		$pdf->Cell(5,10,$kunilx2_rangking,1,0,'C');



		//absensi /////////////////////////////////////////////////////////////////////////////////////
		$qabs = mysql_query("SELECT * FROM m_absensi ".
					"ORDER BY absensi2 DESC");
		$rabs = mysql_fetch_assoc($qabs);
		$tabs = mysql_num_rows($qabs);

		do
			{
			$abs_kd = nosql($rabs['kd']);
			$abs_absensi2 = balikin($rabs['absensi2']);

			//jml. absensi...
			$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
						"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
						"AND kd_absensi = '$abs_kd'");
			$rbsi = mysql_fetch_assoc($qbsi);
			$tbsi = mysql_num_rows($qbsi);

			$pdf->Cell(5,10,$tbsi,1,0,'C');
			}
		while ($rabs = mysql_fetch_assoc($qabs));


		//kelulusan ///////////////////////////////////////////////////////////////////////////////
		$pdf->SetX(80);
		$nil_awal = $pdf->SetX(80);
		$pdf->Cell(15,5,'Kelulusan',1,0,'L');


		//jenis mapel
		$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
					"ORDER BY round(no) ASC");
		$rjnsp = mysql_fetch_assoc($qjnsp);
		$tjnsp = mysql_num_rows($qjnsp);

		do
			{
			//nilai jenis...
			$jnsp_kd = nosql($rjnsp['kd']);
			$jnsp_no = nosql($rjnsp['no']);
			$jnsp_jenis = balikin($rjnsp['jenis']);

			//query
			$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
						"ORDER BY round(m_prog_pddkn.no_sub) ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);



			do
				{
				//nilai
				$pelkd = nosql($rpel['pelkd']);
				$pel = substr(balikin2($rpel['xpel']),0,25);
				$pdf->SetFont('Times','',8);

				//nilai mapel..
				$qkunil = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
				$rkunil = mysql_fetch_assoc($qkunil);
				$tkunil = mysql_num_rows($qkunil);
				$kunil_nilai = nosql($rkunil['nil_raport']);

				$pdf->Cell(5,5,$kunil_nilai,1,0,'L');
				}
			while ($rpel = mysql_fetch_assoc($qpel));
			}
		while ($rjnsp = mysql_fetch_assoc($qjnsp));

		$pdf->Ln();




/*
		//perbaikan /////////////////////////////////////////////////////////////////////////////
		$pdf->SetX(80);
		$pdf->Cell(15,5,'Perbaikan',1,0,'L');

		//jenis mapel
		$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
					"ORDER BY round(no) ASC");
		$rjnsp = mysql_fetch_assoc($qjnsp);
		$tjnsp = mysql_num_rows($qjnsp);

		do
			{
			//nilai jenis...
			$jnsp_kd = nosql($rjnsp['kd']);
			$jnsp_no = nosql($rjnsp['no']);
			$jnsp_jenis = balikin($rjnsp['jenis']);

			//query
			$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian_kompetensi = '$kompkd' ".
						"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
						"ORDER BY round(m_prog_pddkn.no_sub) ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);



			do
				{
				//nilai
				$pelkd = nosql($rpel['pelkd']);
				$pel = substr(balikin2($rpel['xpel']),0,25);
				$pdf->SetFont('Times','',8);

				//nilai mapel..
				$qkunil = mysql_query("SELECT * FROM siswa_nilai_raport ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
				$rkunil = mysql_fetch_assoc($qkunil);
				$tkunil = mysql_num_rows($qkunil);
				$kunil_nilai = nosql($rkunil['nil_remidi']);


				$pdf->Cell(5,5,$kunil_nilai,1,0,'L');
				}
			while ($rpel = mysql_fetch_assoc($qpel));
			}
		while ($rjnsp = mysql_fetch_assoc($qjnsp));

*/


		$pdf->Ln();
		}
	while ($data = mysql_fetch_assoc($result));
	}





/*

//jika mulai halaman 2 ///////////////////////////////////////////////////////////////////////////////////////
$batas2 = 13; //jumlah data per halaman
$batas_min = $batas1 + $batas2;

//total halaman, mulai ke-2 dan seterusnya
$jml_data_sisa = ($total - $batas1) + $batas2;




//query
$q = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
			"siswa_kelas.*, siswa_kelas.kd AS skkd ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_keahlian = '$keahkd' ".
			"AND siswa_kelas.kd_ruang = '$rukd' ".
			"ORDER BY round(siswa_kelas.no_absen) ASC LIMIT $batas_min, $jml_data_sisa");
$r = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);
$npage = ($total/$batas2)+2;


//query
for ($we=1;$we<=($npage);$we++)
	{
	//tambah halaman
	$pdf->AddPage();


	//nilai
	$page = $we + 1;

	//nek null
	if ($we == 1)
		{
		$ken = $batas1;
		$ken2 = $batas2;
		}
	else
		{
		$ken = (($we-1)*$batas2) + $batas1;
		$ken2 = $batas2;
		}



	//kolom data
	$pdf->SetY(10);
	$pdf->SetFillColor(233,233,233);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(20,40,'NIS',1,0,'C',1);
	$pdf->Cell(50,40,'NAMA',1,0,'C',1);
	$pdf->Cell(7,40,'',1,0,'C',1);



	//jenis mapel
	$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
				"ORDER BY round(no) ASC");
	$rjnsp = mysql_fetch_assoc($qjnsp);
	$tjnsp = mysql_num_rows($qjnsp);

	do
		{
		//nilai jenis...
		$jnsp_kd = nosql($rjnsp['kd']);
		$jnsp_no = nosql($rjnsp['no']);
		$jnsp_jenis = balikin($rjnsp['jenis']);


		//query
		$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
					"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
					"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
					"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
					"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
					"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
					"ORDER BY round(m_prog_pddkn.no_sub) ASC");
		$rpel = mysql_fetch_assoc($qpel);
		$tpel = mysql_num_rows($qpel);



		//jika muatan lokal, satu ato dua
		if ($jnsp_no == "4")
			{
			$pdf->Cell(5*$tpel,5,'',1,0,'C',1);
			}
		else
			{
			$pdf->Cell(5*$tpel,5,$jnsp_jenis,1,0,'C',1);
			}
		}
	while ($rjnsp = mysql_fetch_assoc($qjnsp));



	//jumlah dan rangking
	$qpelx = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn_kelas.* ".
				"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd'");
	$rpelx = mysql_fetch_assoc($qpelx);
	$tpelx = mysql_num_rows($qpelx);


	$pdf->GetX();
	$nil_jml = $pdf->GetX();
	$pdf->Cell(10,40,'',1,0,'L',1);
	$pdf->TextWithDirection($nil_jml+6,48,'JUMLAH','U');
	$pdf->Cell(5,40,'',1,0,'L',1);
	$pdf->TextWithDirection($nil_jml+14,48,'PERINGKAT','U');
	$pdf->Cell(15,35,'',1,0,'L',1);
	$pdf->TextWithDirection($nil_jml+24,43,'PRESENSI','U');


	$pdf->Ln();
	$pdf->SetX($nil_jml+15);
	$qabs = mysql_query("SELECT * FROM m_absensi ".
				"ORDER BY absensi2 DESC");
	$rabs = mysql_fetch_assoc($qabs);
	$tabs = mysql_num_rows($qabs);

	do
		{
		$abs_kd = nosql($rabs['kd']);
		$abs_absensi2 = balikin($rabs['absensi2']);

		$pdf->Cell(5,5,$abs_absensi2,1,0,'C',1);
		}
	while ($rabs = mysql_fetch_assoc($qabs));





	//mapel-nya...
	//jenis mapel
	$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
				"ORDER BY round(no) ASC");
	$rjnsp = mysql_fetch_assoc($qjnsp);
	$tjnsp = mysql_num_rows($qjnsp);

	$pdf->SetY(55);


	do
		{
		//nilai jenis...
		$jnsp_kd = nosql($rjnsp['kd']);
		$jnsp_no = nosql($rjnsp['no']);
		$jnsp_jenis = balikin($rjnsp['jenis']);


		//query
		$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
					"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
					"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
					"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
					"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
					"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
					"ORDER BY round(m_prog_pddkn.no_sub) ASC");
		$rpel = mysql_fetch_assoc($qpel);
		$tpel = mysql_num_rows($qpel);

		do
			{
			//nilai
			$pelkd = nosql($rpel['pelkd']);
			$pelno = nosql($rpel['no']);
			$pel = substr(balikin2($rpel['xpel']),0,25);


			//jika mulok
			if ($pelno == "4")
				{
				$pdf->Rotate(90,46,14);
				$pdf->Cell(40,5,$pel,1,0,'L',1);
				$pdf->Rotate(0);
				$pdf->Ln();
				}
			else
				{
				$pdf->SetFont('Times','',8);
				$pdf->Rotate(90,46,14);
				$pdf->Cell(35,5,$pel,1,0,'L',1);
				$pdf->Rotate(0);
				$pdf->Ln();
				}
			}
		while ($rpel = mysql_fetch_assoc($qpel));
		}
	while ($rjnsp = mysql_fetch_assoc($qjnsp));




	//kolom nilai /////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->Ln();
	$pdf->SetFont('Times','',8);



	$qx = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
		"siswa_kelas.*, siswa_kelas.kd AS skkd ".
		"FROM m_siswa, siswa_kelas ".
		"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
		"AND siswa_kelas.kd_tapel = '$tapelkd' ".
		"AND siswa_kelas.kd_kelas = '$kelkd' ".
		"AND siswa_kelas.kd_keahlian = '$keahkd' ".
		"AND siswa_kelas.kd_ruang = '$rukd' ".
		"ORDER BY round(siswa_kelas.no_absen) ASC";
	$qr = $qx;

	$count = mysql_num_rows(mysql_query($qx));
	$result = mysql_query("$qr LIMIT $ken, $ken2");
	$data = mysql_fetch_array($result);

	$pdf->SetY(50);
	$pdf->SetX(10);

	do
		{
		//nilai
		$jnspx_skkd = nosql($data['skkd']);
		$jnspx_nis = nosql($data['nis']);
		$jnspx_nama = balikin($data['nama']);
		$uts_nomer = $uts_nomer + 10;
		$uas_nomer = $uas_nomer + 10;
		$pdf->Cell(20,10,$jnspx_nis,1,0,'L');
		$pdf->Cell(50,10,$jnspx_nama,1,0,'L');





		//rangking ////////////////////////////////////////////////////////////////////////////////////////////
		//query
		$qpelx = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
					"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
					"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
					"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
					"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
					"ORDER BY round(m_prog_pddkn.no_sub) ASC");
		$rpelx = mysql_fetch_assoc($qpelx);
		$tpelx = mysql_num_rows($qpelx);

		$pdf->SetX(87+($tpelx*5));

		//query
		$qkunilx2 = mysql_query("SELECT * FROM siswa_rangking ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_keahlian ='$keahkd' ".
						"AND kd_kelas ='$kelkd' ".
						"AND kd_ruang = '$rukd' ".
						"AND kd_siswa_kelas = '$jnspx_skkd' ".
						"AND kd_smt = '$smtkd'");
		$rkunilx2 = mysql_fetch_assoc($qkunilx2);
		$tkunilx2 = mysql_num_rows($qkunilx2);
		$kunilx2_rangking = nosql($rkunilx2['rangking']);

		//jumlah nilai UAS atau NU
		$qniku = mysql_query("SELECT SUM(uas) AS total ".
					"FROM siswa_nilai_prog_pddkn ".
					"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
					"AND kd_smt = '$smtkd'");
		$rniku = mysql_fetch_assoc($qniku);
		$niku_total = nosql($rniku['total']);


		$pdf->Cell(10,10,$niku_total,1,0,'C');
		$pdf->Cell(5,10,$kunilx2_rangking,1,0,'C');



		//absensi /////////////////////////////////////////////////////////////////////////////////////
		$qabs = mysql_query("SELECT * FROM m_absensi ".
					"ORDER BY absensi2 DESC");
		$rabs = mysql_fetch_assoc($qabs);
		$tabs = mysql_num_rows($qabs);

		do
			{
			$abs_kd = nosql($rabs['kd']);
			$abs_absensi2 = balikin($rabs['absensi2']);

			//jml. absensi...
			$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
						"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
						"AND kd_absensi = '$abs_kd'");
			$rbsi = mysql_fetch_assoc($qbsi);
			$tbsi = mysql_num_rows($qbsi);

			$pdf->Cell(5,10,$tbsi,1,0,'C');
			}
		while ($rabs = mysql_fetch_assoc($qabs));


		//NU : Nilai Ulangan ///////////////////////////////////////////////////////////////////////////////
		$pdf->SetX(80);
		$nil_awal = $pdf->SetX(80);
		$pdf->Cell(7,5,'NU',1,0,'L');

		//jenis mapel
		$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
					"ORDER BY round(no) ASC");
		$rjnsp = mysql_fetch_assoc($qjnsp);
		$tjnsp = mysql_num_rows($qjnsp);

		do
			{
			//nilai jenis...
			$jnsp_kd = nosql($rjnsp['kd']);
			$jnsp_no = nosql($rjnsp['no']);
			$jnsp_jenis = balikin($rjnsp['jenis']);

			//query
			$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
						"ORDER BY round(m_prog_pddkn.no_sub) ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);



			do
				{
				//nilai
				$pelkd = nosql($rpel['pelkd']);
				$pel = substr(balikin2($rpel['xpel']),0,25);
				$pdf->SetFont('Times','',8);

				//nilai mapel..
				$qkunil = mysql_query("SELECT * FROM siswa_nilai_prog_pddkn ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
				$rkunil = mysql_fetch_assoc($qkunil);
				$tkunil = mysql_num_rows($qkunil);
				$kunil_nilai = nosql($rkunil['total_kognitif']);

				//nilai ulangan diambil dari uas.
				$kunil_uas = nosql($rkunil['uas']);


				//nek null
				if (empty($tkunil))
					{
					$kunil_uas = "-";
					}

				$pdf->Cell(5,5,$kunil_uas,1,0,'L');
				}
			while ($rpel = mysql_fetch_assoc($qpel));
			}
		while ($rjnsp = mysql_fetch_assoc($qjnsp));

		$pdf->Ln();



		//NP : Nilai Perbaikan /////////////////////////////////////////////////////////////////////////////
		$pdf->SetX(80);
		$pdf->Cell(7,5,'NP',1,0,'L');

		//jenis mapel
		$qjnsp = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
					"ORDER BY round(no) ASC");
		$rjnsp = mysql_fetch_assoc($qjnsp);
		$tjnsp = mysql_num_rows($qjnsp);

		do
			{
			//nilai jenis...
			$jnsp_kd = nosql($rjnsp['kd']);
			$jnsp_no = nosql($rjnsp['no']);
			$jnsp_jenis = balikin($rjnsp['jenis']);

			//query
			$qpel = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS pelkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
						"AND m_prog_pddkn.kd_jenis = '$jnsp_kd' ".
						"ORDER BY round(m_prog_pddkn.no_sub) ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);



			do
				{
				//nilai
				$pelkd = nosql($rpel['pelkd']);
				$pel = substr(balikin2($rpel['xpel']),0,25);
				$pdf->SetFont('Times','',8);

				//nilai mapel..
				$qkunil = mysql_query("SELECT * FROM siswa_nilai_prog_pddkn ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$pelkd'");
				$rkunil = mysql_fetch_assoc($qkunil);
				$tkunil = mysql_num_rows($qkunil);
				$kunil_nilai = nosql($rkunil['total_kognitif']);
				$kunil_remidi = nosql($rkunil['remidi']);


				//nek null
				if (empty($tkunil))
					{
					$kunil_remidi = "-";
					}

				$pdf->Cell(5,5,$kunil_remidi,1,0,'L');
				}
			while ($rpel = mysql_fetch_assoc($qpel));
			}
		while ($rjnsp = mysql_fetch_assoc($qjnsp));


		$pdf->Ln();
		}
	while ($data = mysql_fetch_assoc($result));
	}

*/




//output-kan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->Output("legger_nilai.pdf",I);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
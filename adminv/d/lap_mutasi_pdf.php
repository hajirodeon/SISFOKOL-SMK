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
require("../../inc/class/lap_mutasi.php");

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
$smtkd = nosql($_REQUEST['smtkd']);
$judul = "Laporan Mutasi Barang Persediaan";
$judulz = $judul;
$batas = 22; //jumlah data per halaman



//tapel
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);



//smt
$qstx = mysql_query("SELECT * FROM m_smt ".
			"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);




//isi *START
ob_start();

$pdf->SetFont('Times','',8);
$pdf->SetFillColor(233,233,233);



//query
$q = mysql_query("SELECT * FROM inv_brg ".
			"ORDER BY kode ASC");
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
		$pdf->SetY(55);
		}
	else
		{
		//kolom header
		$pdf->SetY(45);
		}

	//kolom header
	$pdf->SetFont('Times','',8);

	$pdf->Cell(20,10,'Kode',1,0,'C',1);
	$pdf->Cell(30,10,'Nama Barang',1,0,'C',1);
	$pdf->Cell(60,5,'Nilai Awal Semester',1,0,'C',1);
	$pdf->Cell(60,5,'Mutasi',1,0,'C',1);
	$pdf->Cell(60,5,'Nilai Akhir Semester',1,0,'C',1);


	$pdf->SetY($pdf->GetY()+5);
	$pdf->SetX(60);
	$pdf->Cell(30,5,'Jumlah',1,0,'C',1);
	$pdf->Cell(30,5,'Rupiah',1,0,'C',1);
	$pdf->Cell(20,5,'Tambah',1,0,'C',1);
	$pdf->Cell(20,5,'Kurang',1,0,'C',1);
	$pdf->Cell(20,5,'Jumlah',1,0,'C',1);
	$pdf->Cell(30,5,'Jumlah',1,0,'C',1);
	$pdf->Cell(30,5,'Rupiah',1,0,'C',1);





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

	$qx = "SELECT * FROM inv_brg ".
			"ORDER BY kode ASC";
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
		$dft_kd = nosql($data['kd']);
		$dft_kode = nosql($data['kode']);
		$dft_harga = nosql($data['harga']);
		$dft_brg = balikin($data['nama']);
		$dft_stkd = nosql($data['kd_satuan']);


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


		$dataku1 = "$kusi_sisa $stu_satuan";
		$dataku2 = "$kusi_rupiah";
		$dataku3 = "$jml_tambah $stu_satuan";
		$dataku4 = "$jml_kurang $stu_satuan";
		$dataku5 = "$jml_selisih $stu_satuan";
		$dataku6 = "$kusi2_sisa $stu_satuan";
		$dataku7 = "$kusi2_rupiah";


		//list data
		$pdf->Cell(20,5,$dft_kode,1,0,'L');
		$pdf->Cell(30,5,$dft_brg,1,0,'L');
		$pdf->Cell(30,5,$dataku1,1,0,'R');
		$pdf->Cell(30,5,$dataku2,1,0,'R');
		$pdf->Cell(20,5,$dataku3,1,0,'R');
		$pdf->Cell(20,5,$dataku4,1,0,'R');
		$pdf->Cell(20,5,$dataku5,1,0,'R');
		$pdf->Cell(30,5,$dataku6,1,0,'R');
		$pdf->Cell(30,5,$dataku7,1,0,'R');

		$pdf->Ln();
		}
	while ($data = mysql_fetch_assoc($result));
	}


//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("lap_mutasi.pdf",I);
?>
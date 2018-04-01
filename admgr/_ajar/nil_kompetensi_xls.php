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


nocache;

//nilai
$filenya = "nil_kompetensi_xls.php";
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
$progkd = nosql($_REQUEST['progkd']);
$mmkd= nosql($_REQUEST['mmkd']);
$s = nosql($_REQUEST['s']);
$limit = "50";



//mapel e...
$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
			"WHERE kd = '$progkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_pel = balikin($rowstdx['xpel']);


//nama file e...
$i_filename = "Nilai_$stdx_pel.xls";
$i_judul = "Nilai";



// Function penanda awal file (Begin Of File) Excel
function xlsBOF()
	{
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	return;
	}

// Function penanda akhir file (End Of File) Excel
function xlsEOF()
	{
	echo pack("ss", 0x0A, 0x00);
	return;
	}



echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';




header("Content-Type: application/x-msexcel");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$i_filename");
header("Expires: 0");
header("Pragma: no-cache");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// memanggil function penanda awal file excel
xlsBOF();


//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
		"siswa_kelas.*, siswa_kelas.kd AS skkd ".
		"FROM m_siswa, siswa_kelas ".
		"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
		"AND siswa_kelas.kd_tapel = '$tapelkd' ".
		"AND siswa_kelas.kd_kelas = '$kelkd' ".
		"AND siswa_kelas.kd_keahlian = '$keahkd' ".
		"ORDER BY m_siswa.nis ASC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kelkd=$kelkd&smtkd=$smtkd&mmkd=$mmkd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//kelas program pendidikan
$qhi = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd, ".
			"m_prog_pddkn.*, m_prog_pddkn.kd AS mkkd ".
			"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
			"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
			"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
			"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
			"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$progkd'");
$rowhi = mysql_fetch_assoc($qhi);
$totalhi = mysql_num_rows($qhi);
$hi_mpkd = nosql($rowhi['mpkd']);


//jumlah kompetensi
$qku4xu = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
			"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
			"AND right(kode,2) <> '.0'");
$rowku4xu = mysql_fetch_assoc($qku4xu);
$totalku4xu = mysql_num_rows($qku4xu);



//nek ada
if ($count != 0)
	{
	//kelas program pendidikan
	$qhi = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS mpkd, ".
				"m_prog_pddkn.*, m_prog_pddkn.kd AS mkkd ".
				"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
				"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
				"AND m_prog_pddkn_kelas.kd_keahlian = '$keahkd' ".
				"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
				"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$progkd'");
	$rowhi = mysql_fetch_assoc($qhi);
	$totalhi = mysql_num_rows($qhi);
	$hi_mpkd = nosql($rowhi['mpkd']);

	echo '<table border="0" cellpadding="3" cellspacing="0">
	<tr>
	<td width="100"><strong>NIS</strong></td>
	<td width="200"><strong>Nama</strong></td>';

	//query-kategori
	$qku = mysql_query("SELECT DISTINCT(left(kode,1)) AS katkd ".
				"FROM m_prog_pddkn_kompetensi ".
				"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
				"AND right(kode,2) <> '.0' ".
				"ORDER BY kode ASC");
	$rowku = mysql_fetch_assoc($qku);
	$totalku = mysql_num_rows($qku);


	do
		{
		//nilai
		$ku_katkd= nosql($rowku['katkd']);


		//sub
		$qku2 = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND right(kode,2) <> '.0' ".
					"AND left(kode,1) = '$ku_katkd' ".
					"ORDER BY kode ASC");
		$rowku2 = mysql_fetch_assoc($qku2);
		$totalku2 = mysql_num_rows($qku2);


		do
			{
			//nilai
			$ku2_kode = nosql($rowku2['kode']);

			echo '<td width="50" align="center"><strong>'.$ku2_kode.'</strong></td>';
			}
		while ($rowku2 = mysql_fetch_assoc($qku2));

		echo '<td width="50" align="center"><strong>NS'.$ku_katkd.'</strong></td>
		<td width="50" align="center"><strong>NK'.$ku_katkd.'</strong></td>';
		}
	while ($rowku = mysql_fetch_assoc($qku));


	echo '<td width="50" align="center"><strong>NR</strong></td>
	</tr>';

	do
		{
		$i_kd = nosql($data['mskd']);
		$i_skkd = nosql($data['skkd']);
		$i_nis = nosql($data['nis']);
		$i_nama = balikin($data['nama']);


		echo '<tr>
		<td valign="top">
		'.$i_nis.'
		</td>
		<td valign="top">
		'.$i_nama.'
		</td>';


		//query-kategori
		$qku = mysql_query("SELECT DISTINCT(left(kode,1)) AS katkd ".
					"FROM m_prog_pddkn_kompetensi ".
					"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
					"AND right(kode,2) <> '.0' ".
					"ORDER BY kode ASC");
		$rowku = mysql_fetch_assoc($qku);
		$totalku = mysql_num_rows($qku);


		do
			{
			//nilai
			$ku_katkd = nosql($rowku['katkd']);


			//sub
			$qku2 = mysql_query("SELECT * FROM m_prog_pddkn_kompetensi ".
						"WHERE kd_prog_pddkn_kelas = '$hi_mpkd' ".
						"AND right(kode,2) <> '.0' ".
						"AND left(kode,1) = '$ku_katkd' ".
						"ORDER BY kode ASC");
			$rowku2 = mysql_fetch_assoc($qku2);
			$totalku2 = mysql_num_rows($qku2);


			do
				{
				//nilai
				$ku2_kd = nosql($rowku2['kd']);
				$ku2_kode = nosql($rowku2['kode']);

				//nilainya
				$qdtu = mysql_query("SELECT * FROM siswa_nilai_kompetensi ".
							"WHERE kd_siswa_kelas = '$i_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn_kompetensi = '$ku2_kd'");
				$rdtu = mysql_fetch_assoc($qdtu);
				$tdtu = mysql_num_rows($qdtu);
				$dtu_nkd = nosql($rdtu['nil_nkd']);

				echo '<td>'.$dtu_nkd.'</td>';
				}
			while ($rowku2 = mysql_fetch_assoc($qku2));



			//nilainya
			$qdtu2 = mysql_query("SELECT * FROM siswa_nilai_kompetensi2 ".
						"WHERE kd_siswa_kelas = '$i_skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd' ".
						"AND sk = '$ku_katkd'");
			$rdtu2 = mysql_fetch_assoc($qdtu2);
			$tdtu2 = mysql_num_rows($qdtu2);
			$dtu2_ns = nosql($rdtu2['nil_ns']);
			$dtu2_nk = nosql($rdtu2['rata_nk']);


			echo '<td>'.$dtu2_ns.'</td>
			<td>'.$dtu2_nk.'</td>';
			}
		while ($rowku = mysql_fetch_assoc($qku));


		//nilainya
		$qdtu21 = mysql_query("SELECT * FROM siswa_nilai_raport ".
					"WHERE kd_siswa_kelas = '$i_skkd' ".
					"AND kd_prog_pddkn = '$progkd' ".
					"AND kd_smt = '$smtkd'");
		$rdtu21 = mysql_fetch_assoc($qdtu21);
		$tdtu21 = mysql_num_rows($qdtu21);
		$dtu21_raport = nosql($rdtu21['nil_raport']);

		echo '<td width="10">'.$dtu21_raport.'</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}


// memanggil function penanda akhir file excel
xlsEOF();
exit();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//diskonek
xclose($koneksi);
exit();
?>
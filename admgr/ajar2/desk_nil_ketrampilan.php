<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "desk_nil_ketrampilan.php";
$judul = "Deskripsi Penilaian Ketrampilan";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"skkd=$skkd&jnskd=$jnskd&progkd=$progkd&page=$page";

$limit = "50";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);


		//nilai
		$xnilruh = "nil_sangat";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_sangat = $xnilruhxx;
		
		$xnilruh = "nil_kurang";
		$xnilruh1 = "$xnilruh$k";
		$xnilruhxx = nosql($_POST["$xnilruh1"]);
		$inil_kurang = $xnilruhxx;
	
	
		$xnilnuts = "nil_raport_p";
		$xnilnuts1 = "$xnilnuts$k";
		$xnilhuruf = substr(nosql($_POST["$xnilnuts1"]),0,1);

		



		//entry...
		$qcc1 = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$xskkdxx' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		$rcc1 = mysql_fetch_assoc($qcc1);
		$tcc1 = mysql_num_rows($qcc1);


		//jika ada, update
		if ($tcc1 != 0)
			{
			mysql_query("UPDATE siswa_nilai_raport SET nil_pengetahuan_sangat = '$inil_sangat', ".
							"nil_pengetahuan_kurang = '$inil_kurang' ".
							"WHERE kd_siswa_kelas = '$xskkdxx' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
			}

		//jika blm ada, insert
		else
			{
			mysql_query("INSERT INTO siswa_nilai_raport(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
							"nil_pengetahuan_sangat, nil_pengetahuan_kurang, postdate) VALUES ".
							"('$xyzb', '$xskkdxx', '$smtkd', '$progkd', ".
							"'$inil_sangat', '$inil_kurang', '$today')");
			
			}




		//jika
		if ($xnilhuruf == "A")
			{
			$detaile = "Sudah sangat menguasai kompetensi";
			}
		else if ($xnilhuruf == "B")
			{
			$detaile = "Sudah menguasai kompetensi";
			}
		else if ($xnilhuruf == "C")
			{
			$detaile = "Cukup menguasai kompetensi";
			}
		else if ($xnilhuruf == "D")
			{
			$detaile = "Kurang menguasai kompetensi";
			}




		//cek
		$qcc2 = mysql_query("SELECT * FROM m_prog_pddkn_deskripsi ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_prog_pddkn = '$progkd' ".
								"AND kd_smt = '$smtkd'");
		$rcc2 = mysql_fetch_assoc($qcc2);
		$cc2_p_isi = balikin($rcc2['p_isi']);
		
	
		//desk
		$detaile_desk = "$detaile $cc2_p_isi. Terutama dalam $inil_sangat. Tetapi kurang dalam $inil_kurang.";

		
		//update lg...					
		mysql_query("UPDATE siswa_nilai_raport SET nil_k_pengetahuan = '$detaile_desk' ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");

		}




	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";
	xloc($ke);
	exit();
	}










//reset
if ($_POST['btnRST'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);




		//ke mysql
		mysql_query("UPDATE siswa_nilai_raport SET nil_pengetahuan_sangat = '', ".
						"nil_pengetahuan_kurang = '', ".
						"nil_k_pengetahuan = '' ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");


		}




	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";
	xloc($ke);
	exit();
	}








//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jndks = nosql($_POST['jnskd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
	xloc($ke);
	exit();
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
		pekem($pesan,$ke);
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "file_importnya$kd.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);


			//re-direct
			$ke = "desk_nil_pengetahuan_import.php?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&filex_namex2=$filex_namex2";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);

	//require
	include("../../inc/class/excel/excelwriter.inc.php");


	//mapel e...
	$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$progkd'");
	$rowstdx = mysql_fetch_assoc($qstdx);
	$stdx_kd = nosql($rowstdx['kd']);
	$stdx_jnskd = nosql($rowstdx['kd_jenis']);
	$stdx_pel = strip(balikin($rowstdx['xpel']));


	//nama file e...
	$excelfile = "Deskripsi_Pengetahuan_$stdx_pel.xls";
	$i_judul = "Deskripsi_Pengetahuan";



	//lokasi hasil konversi
	$lokasi	   = '../../filebox/excel/';
	$excel=new ExcelWriter($lokasi.$excelfile);
	
	


	//bikin...
	$myArr = array("NO","NIS","NAMA","NAP","ANGKA","HURUF","SANGAT_DIKUASAI","KURANG_DIKUASAI","DESKRIPSI");
	$excel->writeLine($myArr);



	//data
	$qdt = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"ORDER BY m_siswa.nama ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_skkd = nosql($rdt['skkd']);
		$dt_no = nosql($rdt['no_absen']);
		$dt_nis = nosql($rdt['nis']);
		$dt_nama = balikin($rdt['nama']);

		//nil prog_pddkn
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$dt_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_nil_raport = nosql($rxpel['nil_raport_pengetahuan']);
		$xpel_nil_raport_a = nosql($rxpel['nil_raport_pengetahuan_a']);
		$xpel_nil_raport_p = nosql($rxpel['nil_raport_pengetahuan_p']);
		$xpel_nil_sangat = balikin($rxpel['nil_pengetahuan_sangat']);
		$xpel_nil_kurang = balikin($rxpel['nil_pengetahuan_kurang']);
		$xpel_nil_desk = balikin($rxpel['nil_k_pengetahuan']);

		
		

		//ciptakan
		$myArr = array($dt_nox,$dt_nis,$dt_nama,$xpel_nil_raport,$xpel_nil_raport_a,$xpel_nil_raport_p, 
							$xpel_nil_sangat,$xpel_nil_kurang,$xpel_nil_desk);		
		$excel->writeLine($myArr);
		
		}
	while ($rdt = mysql_fetch_assoc($qdt));



	$excel -> close();
	
	
	$ke = "$lokasi$excelfile";
	xloc($ke);
	exit();
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//focus....focus...
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/menu/admgr.php");




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php?tapelkd='.$tapelkd.'" title="Daftar Mata Pelajaran">Daftar Mata Pelajaran</a>]</td>
</tr>
</table>


<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>,

Kelas : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mata Pelajaran : ';
//terpilih
$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd = '$progkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_jnskd = nosql($rowstdx['kd_jenis']);
$stdx_pel = balikin($rowstdx['prog_pddkn']);

//jenis
$qjnsx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"WHERE kd = '$stdx_jnskd'");
$rjnsx = mysql_fetch_assoc($qjnsx);
$tjnsx = mysql_num_rows($qjnsx);
$jnsx_jenis = balikin($rjnsx['jenis']);

echo '<strong>'.$jnsx_jenis.' --> '.$stdx_pel.'</strong>,

Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>,


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="jnskd" type="hidden" value="'.$stdx_jnskd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
</td>
</tr>
</table>
<br>';


//nek drg
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

else if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($progkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>MATA PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	//jika import
	if ($s == "import")
		{
		echo '<p>
		Silahkan Masukkan File yang akan Di-Import :
		<br>
		<input name="filex_xls" type="file" size="30">
		<br>
		<input name="s" type="hidden" value="'.$s.'">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnIM2" type="submit" value="IMPORT >>">
		</p>';
		}
	else
		{
		//daftar siswa
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"ORDER BY m_siswa.nama ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&jnskd=$jnskd&progkd=$progkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);





	
		echo '<table width="1200" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td><strong>NAMA</strong></td>
		<td width="50"><strong>NILAI PRAKTEK</strong></td>
		<td width="50"><strong>NILAI FOLIO</strong></td>
		<td width="50"><strong>NILAI PROYEK</strong></td>
		<td width="50"><strong>DESKRIPSI</strong></td>
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

			//nilainya
			$i_nomer = $i_nomer + 1;
			$i_skkd = nosql($data['skkd']);
			$i_nis = nosql($data['nis']);
			$i_nama = balikin($data['nama']);





			//nil mapel
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$i_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_praktek_rata = balikin($rxpel['rata_praktek']);
			$xpel_folio_rata = balikin($rxpel['rata_folio']);
			$xpel_proyek_rata = balikin($rxpel['rata_proyek']);
			

			
			if ($xpel_praktek_rata >= "96")
				{
				$xpel_praktek = "A";
				$xpel_praktek_ket = "Sudah sangat terampil dalam pengerjaan praktik, ";
				}
			else if (($xpel_praktek_rata < "96") AND ($xpel_praktek_rata >= "91"))
				{
				$xpel_praktek = "A-";
				$xpel_praktek_ket = "Sudah sangat terampil dalam pengerjaan praktik, ";
				}
			else if (($xpel_praktek_rata < "91") AND ($xpel_praktek_rata >= "85"))
				{
				$xpel_praktek = "B+";
				$xpel_praktek_ket = "Sudah terampil dalam pengerjaan praktik, ";
				}
			else if (($xpel_praktek_rata < "85") AND ($xpel_praktek_rata >= "80"))
				{
				$xpel_praktek = "B";
				$xpel_praktek_ket = "Sudah terampil dalam pengerjaan praktik, ";
				}
			else if (($xpel_praktek_rata < "80") AND ($xpel_praktek_rata >= "75"))
				{
				$xpel_praktek = "B-";
				$xpel_praktek_ket = "Sudah terampil dalam pengerjaan praktik, ";
				}
			else if (($xpel_praktek_rata < "75") AND ($xpel_praktek_rata >= "70"))
				{
				$xpel_praktek = "C+";
				$xpel_praktek_ket = "Sudah cukup terampil dalam pengerjaan praktik, ";
				}
			else if (($xpel_praktek_rata < "70") AND ($xpel_praktek_rata >= "65"))
				{
				$xpel_praktek = "C";
				$xpel_praktek_ket = "Sudah cukup terampil dalam pengerjaan praktik, ";
				}
			else if (($xpel_praktek_rata < "65") AND ($xpel_praktek_rata >= "60"))
				{
				$xpel_praktek = "C-";
				$xpel_praktek_ket = "Sudah cukup terampil dalam pengerjaan praktik, ";
				}
			else if (($xpel_praktek_rata < "60") AND ($xpel_praktek_rata >= "55"))
				{
				$xpel_praktek = "D+";
				$xpel_praktek_ket = "Masih kurang terampil dalam pengerjaan praktik, ";
				}
			else if ($xpel_praktek_rata < "54")
				{
				$xpel_praktek = "D";
				$xpel_praktek_ket = "Masih kurang terampil dalam pengerjaan praktik, ";
				}

			




			if ($xpel_folio_rata >= "96")
				{
				$xpel_folio = "A";
				$xpel_folio_ket = "mengerjakan porto folio dengan sangat baik, ";
				}
			else if (($xpel_folio_rata < "96") AND ($xpel_folio_rata >= "91"))
				{
				$xpel_folio = "A-";
				$xpel_folio_ket = "mengerjakan porto folio dengan sangat baik, ";
				}
			else if (($xpel_folio_rata < "91") AND ($xpel_folio_rata >= "85"))
				{
				$xpel_folio = "B+";
				$xpel_folio_ket = "mengerjakan porto folio dengan baik, ";
				}
			else if (($xpel_folio_rata < "85") AND ($xpel_folio_rata >= "80"))
				{
				$xpel_folio = "B";
				$xpel_folio_ket = "mengerjakan porto folio dengan baik, ";
				}
			else if (($xpel_folio_rata < "80") AND ($xpel_folio_rata >= "75"))
				{
				$xpel_folio = "B-";
				$xpel_folio_ket = "mengerjakan porto folio dengan baik, ";
				}
			else if (($xpel_folio_rata < "75") AND ($xpel_folio_rata >= "70"))
				{
				$xpel_folio = "C+";
				$xpel_folio_ket = "mengerjakan porto folio dengan cukup baik, ";
				}
			else if (($xpel_folio_rata < "70") AND ($xpel_folio_rata >= "65"))
				{
				$xpel_folio = "C";
				$xpel_folio_ket = "mengerjakan porto folio dengan cukup baik, ";
				}
			else if (($xpel_folio_rata < "65") AND ($xpel_folio_rata >= "60"))
				{
				$xpel_folio = "C-";
				$xpel_folio_ket = "mengerjakan porto folio dengan cukup baik, ";
				}
			else if (($xpel_folio_rata < "60") AND ($xpel_folio_rata >= "55"))
				{
				$xpel_folio = "D+";
				$xpel_folio_ket = "masih kurang terampil dalam porto folio, ";
				}
			else if ($xpel_folio_rata < "54")
				{
				$xpel_folio = "D";
				$xpel_folio_ket = "masih kurang terampil dalam porto folio, ";
				}





			if ($xpel_proyek_rata >= "96")
				{
				$xpel_proyek = "A";
				$xpel_proyek_ket = "sangat baik dalam pengerjaan proyek";
				}
			else if (($xpel_proyek_rata < "96") AND ($xpel_proyek_rata >= "91"))
				{
				$xpel_proyek = "A-";
				$xpel_proyek_ket = "sangat baik dalam pengerjaan proyek";
				}
			else if (($xpel_proyek_rata < "91") AND ($xpel_proyek_rata >= "85"))
				{
				$xpel_proyek = "B+";
				$xpel_proyek_ket = "sudah baik dalam pengerjaan proyek";
				}
			else if (($xpel_proyek_rata < "85") AND ($xpel_proyek_rata >= "80"))
				{
				$xpel_proyek = "B";
				$xpel_proyek_ket = "sudah baik dalam pengerjaan proyek";
				}
			else if (($xpel_proyek_rata < "80") AND ($xpel_proyek_rata >= "75"))
				{
				$xpel_proyek = "B-";
				$xpel_proyek_ket = "sudah baik dalam pengerjaan proyek";
				}
			else if (($xpel_proyek_rata < "75") AND ($xpel_proyek_rata >= "70"))
				{
				$xpel_proyek = "C+";
				$xpel_proyek_ket = "cukup baik dalam pengerjaan proyek";
				}
			else if (($xpel_proyek_rata < "70") AND ($xpel_proyek_rata >= "65"))
				{
				$xpel_proyek = "C";
				$xpel_proyek_ket = "cukup baik dalam pengerjaan proyek";
				}
			else if (($xpel_proyek_rata < "65") AND ($xpel_proyek_rata >= "60"))
				{
				$xpel_proyek = "C-";
				$xpel_proyek_ket = "cukup baik dalam pengerjaan proyek";
				}
			else if (($xpel_proyek_rata < "60") AND ($xpel_proyek_rata >= "55"))
				{
				$xpel_proyek = "D+";
				$xpel_proyek_ket = "tetapi masih kurang terampil dalam pengerjaan proyek";
				}
			else if ($xpel_proyek_rata < "54")
				{
				$xpel_proyek = "D";
				$xpel_proyek_ket = "tetapi masih kurang terampil dalam pengerjaan proyek";
				}

			
			
			//desk
			$xpel_desk = "$xpel_praktek_ket$xpel_folio_ket$xpel_proyek_ket";



			//simpan 
			mysql_query("UPDATE siswa_nilai_raport SET nil_k_ketrampilan = '$xpel_desk', ".
							"nil_praktek_p = '$xpel_praktek', ".
							"nil_folio_p = '$xpel_folio', ".
							"nil_proyek_p = '$xpel_proyek', ".
							"nil_praktek_k = '$xpel_praktek_ket', ".
							"nil_folio_k = '$xpel_folio_ket', ".
							"nil_proyek_k = '$xpel_proyek_ket' ".
							"WHERE kd_siswa_kelas = '$i_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input name="skkd'.$i_nomer.'" type="hidden" value="'.$i_skkd.'">
			'.$i_nis.'
			</td>
			<td>
			'.$i_nama.'
			</td>

			<td>
			<input name="nil_praktek'.$i_nomer.'" type="text" value="'.$xpel_praktek.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_folio'.$i_nomer.'" type="text" value="'.$xpel_folio.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_proyek'.$i_nomer.'" type="text" value="'.$xpel_proyek.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			
			<td>
			<input name="nil_desk'.$i_nomer.'" type="text" value="'.$xpel_desk.'" size="30">
			</td>
			
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));


		echo '</table>';
		}
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

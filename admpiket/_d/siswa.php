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
require("../../inc/cek/admhubin.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa.php";
$judul = "Data Siswa";
$judulku = "[$hubin_session : $nip36_session. $nm36_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$swkd = nosql($_REQUEST['swkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&page=$page";







//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	$tapelkd = nosql($_POST['tapelkd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}





//jika simpan
if ($_POST['btnSMPDUDI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$page = nosql($_POST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$xkdt = "skkd";
		$xkdt1 = "$xkdt$i";
		$xkdtxx = nosql($_POST["$xkdt1"]);

		$xkst = "dudi_nama";
		$xkst1 = "$xkst$i";
		$xkstxx = nosql($_POST["$xkst1"]);

		$xkstw = "dudi_alamat";
		$xkstw1 = "$xkstw$i";
		$xkstwxx = nosql($_POST["$xkstw1"]);

		$xksty = "dudi_waktu";
		$xksty1 = "$xksty$i";
		$xkstyxx = nosql($_POST["$xksty1"]);

		$xkstz = "dudi_nilai";
		$xkstz1 = "$xkstz$i";
		$xkstzxx = nosql($_POST["$xkstz1"]);

		$xkstu = "dudi_predikat";
		$xkstu1 = "$xkstu$i";
		$xkstuxx = nosql($_POST["$xkstu1"]);



		//cek
		$qcc = mysql_query("SELECT * FROM siswa_nilai_dudi ".
								"WHERE kd_siswa_kelas = '$xkdtxx'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		
		//jika ada
		if (!empty($tcc))
			{
			//update
			mysql_query("UPDATE siswa_nilai_dudi SET nama = '$xkstxx', ".
							"alamat = '$xkstwxx', ".
							"waktu = '$xkstyxx', ".
							"nilai = '$xkstzxx', ".
							"predikat = '$xkstuxx' ".
							"WHERE kd_siswa_kelas = '$xkdtxx'");				
			}
		else if (empty($tcc))
			{
			//insert
			mysql_query("INSERT INTO siswa_nilai_dudi(kd, kd_siswa_kelas, nama, ".
							"alamat, waktu, nilai, predikat) VALUES ".
							"('$x', '$xkdtxx', '$xkstxx', ".
							"'$xkstwxx', '$xkstyxx', '$xkstzxx', '$xkstuxx')");
			}

						
		}



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&page=$page";
	xloc($ke);
	exit();
	}







//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);

	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');



	//nama file e...
	$i_filename = "DataSiswa.xls";
	$i_judul = "DataSiswa";


	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}



	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->set_column(0,0,5);
	$worksheet1->set_column(0,1,10);
	$worksheet1->set_column(0,2,30);
	$worksheet1->set_column(0,3,10);
	$worksheet1->set_column(0,4,10);
	$worksheet1->write_string(0,0,"NO.");
	$worksheet1->write_string(0,1,"NIS");
	$worksheet1->write_string(0,2,"NAMA");
	$worksheet1->write_string(0,3,"NAMA_DUDI");
	$worksheet1->write_string(0,4,"ALAMAT");
	$worksheet1->write_string(0,5,"LAMA_WAKTU");
	$worksheet1->write_string(0,6,"NILAI");
	$worksheet1->write_string(0,7,"PREDIKAT");



	//data
	$qdt = mysql_query("SELECT m_siswa.*, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
						"m_siswa.kd AS mskd, ".
						"siswa_kelas.*, siswa_kelas.kd AS skkd  ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"ORDER BY m_siswa.nis ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_skkd = nosql($rdt['skkd']);
		$dt_no = nosql($rdt['no_absen']);
		$dt_nis = nosql($rdt['nis']);
		$dt_nama = balikin($rdt['nama']);

			
		//daftar dudi
		$qkuti = mysql_query("SELECT * FROM siswa_nilai_dudi ".
								"WHERE kd_siswa_kelas = '$dt_skkd' ".
								"ORDER BY nama ASC");
		$rkuti = mysql_fetch_assoc($qkuti);
		$tkuti = mysql_num_rows($qkuti);
		$kuti_nama = balikin($rkuti['nama']);
		$kuti_alamat = balikin($rkuti['alamat']);
		$kuti_waktu = balikin($rkuti['waktu']);
		$kuti_nilai = balikin($rkuti['nilai']);
		$kuti_predikat = balikin($rkuti['predikat']);


		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_nis);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$kuti_nama);
		$worksheet1->write_string($dt_nox,4,$kuti_alamat);
		$worksheet1->write_string($dt_nox,5,$kuti_waktu);
		$worksheet1->write_string($dt_nox,6,$kuti_nilai);
		$worksheet1->write_string($dt_nox,7,$kuti_predikat);
		}
	while ($rdt = mysql_fetch_assoc($qdt));

	//close
	$workbook->close();


	//diskonek
	xclose($koneksi);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}

	
	

//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&s=import";
	xloc($ke);
	exit();
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&s=import";
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
			$filex_namex2 = "file_importnya.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);


			//re-direct
			$ke = "siswa_import.php?tapelkd=$tapelkd&filex_namex2=$filex_namex2";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}

	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/admhubin.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
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
		
		//query DATA
		$tapelkd = nosql($_REQUEST['tapelkd']);
	
		//nis
		if ($crkd == "cr01")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);
	
			$sqlcount = "SELECT m_siswa.*, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
							"m_siswa.kd AS mskd, ".
							"siswa_kelas.*, siswa_kelas.kd AS skkd  ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND m_siswa.nis LIKE '%$kunci%' ".
							"ORDER BY m_siswa.nis ASC";
			$sqlresult = $sqlcount;
	
			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}
	
		//nama
		else if ($crkd == "cr02")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);
	
			$sqlcount = "SELECT m_siswa.*, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
							"m_siswa.kd AS mskd, ".
							"siswa_kelas.*, siswa_kelas.kd AS skkd  ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND m_siswa.nama LIKE '%$kunci%' ".
							"ORDER BY m_siswa.nama ASC";
			$sqlresult = $sqlcount;
	
			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}
	
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);
	
			$sqlcount = "SELECT m_siswa.*, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
							"m_siswa.kd AS mskd, ".
							"siswa_kelas.*, siswa_kelas.kd AS skkd  ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"ORDER BY m_siswa.nis ASC";
			$sqlresult = $sqlcount;
	
			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}
	
	
	
		echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warna02.'">
		<td>';
		echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
		echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
		<option value="'.$filenya.'?tapelkd='.$tapelkd.'&crkd=cr01&crtipe=NIS&kunci='.$kunci.'">NIS</option>
		<option value="'.$filenya.'?tapelkd='.$tapelkd.'&crkd=cr02&crtipe=Nama&kunci='.$kunci.'">Nama</option>
		</select>
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kunci" type="text" value="'.$kunci.'" size="30">
		<input name="crkd" type="hidden" value="'.$crkd.'">
		<input name="crtipe" type="hidden" value="'.$crtipe.'">
		<input name="btnCARI" type="submit" value="CARI >>">
		<input name="btnRST" type="submit" value="RESET">
		</td>
		</tr>
		</table>
		<br>';
	
		//nek ada
		if ($count != 0)
			{
			echo '<input name="btnIM" type="submit" value="IMPORT">
			<input name="btnEX" type="submit" value="EXPORT">
			<table width="100%" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warnaheader.'">
			<td width="50"><strong>NIS</strong></td>
			<td><strong>Nama</strong></td>
			<td width="50"><strong>Nama DU/DI</strong></td>
			<td width="50"><strong>Alamat</strong></td>
			<td width="50"><strong>Waktu</strong></td>
			<td width="50"><strong>Nilai</strong></td>
			<td width="50"><strong>Predikat</strong></td>		
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
	
				$nomx = $nomx + 1;
	
				$i_kd = nosql($data['mskd']);
				$i_skkd = nosql($data['skkd']);
				$i_nis = nosql($data['nis']);
				$i_nama = balikin($data['nama']);
	
	
			
				//daftar dudi
				$qkuti = mysql_query("SELECT * FROM siswa_nilai_dudi ".
										"WHERE kd_siswa_kelas = '$i_skkd' ".
										"ORDER BY nama ASC");
				$rkuti = mysql_fetch_assoc($qkuti);
				$tkuti = mysql_num_rows($qkuti);
				$kuti_nama = balikin($rkuti['nama']);
				$kuti_alamat = balikin($rkuti['alamat']);
				$kuti_waktu = balikin($rkuti['waktu']);
				$kuti_nilai = balikin($rkuti['nilai']);
				$kuti_predikat = balikin($rkuti['predikat']);
	
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td valign="top">
				'.$i_nis.'
				</td>
				<td valign="top">
				'.$i_nama.'
				</td>
				<td>
				<input type="hidden" name="skkd'.$nomx.'" value="'.$i_skkd.'">
				<input type="text" name="dudi_nama'.$nomx.'" value="'.$kuti_nama.'" size="20">
				</td>
				<td>
				<input type="text" name="dudi_alamat'.$nomx.'" value="'.$kuti_alamat.'" size="20">
				</td>
				<td>
				<input type="text" name="dudi_waktu'.$nomx.'" value="'.$kuti_waktu.'" size="20">
				</td>
				<td>
				<input type="text" name="dudi_nilai'.$nomx.'" value="'.$kuti_nilai.'" size="10">
				</td>
				<td>
				<input type="text" name="dudi_predikat'.$nomx.'" value="'.$kuti_predikat.'" size="10">
				</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));
	
			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td>
			<input name="jml" type="hidden" value="'.$limit.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="total" type="hidden" value="'.$count.'">
			<input name="btnSMPDUDI" type="submit" value="SIMPAN">
			<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
			</td>
			</tr>
			</table>';
			}
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
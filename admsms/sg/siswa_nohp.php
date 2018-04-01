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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsms.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "siswa_nohp.php";
$judul = "Siswa : No.HP";
$judulku = "[$sms_session : $nip32_session. $nm32_session] ==> $judul";
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$pkd = nosql($_REQUEST['pkd']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}





//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);
	$pkd = nosql($_POST['pkd']);
	$nohp = nosql($_POST['nohp']);
	$page = nosql($_POST['page']);


	//cek
	$qcc = mysql_query("SELECT * FROM sms_nohp_siswa ".
				"WHERE kd_siswa = '$pkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//jika ada
	if ($tcc != 0)
		{
		//update
		mysql_query("UPDATE sms_nohp_siswa ".
				"SET nohp = '$nohp' ".
				"WHERE kd_siswa = '$pkd'");
		}
	else
		{
		//insert
		mysql_query("INSERT INTO sms_nohp_siswa (kd, kd_siswa, nohp) VALUES ".
				"('$x', '$pkd', '$nohp')");
		}


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci&page=$page";
	xloc($ke);
	exit();
	}
	

	
	
	
//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
		
	
		
	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "nohp_siswa.xls";
	$i_judul = "Daftar SISWA";


	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$i_filename" );
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}


	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->set_column(0,0,10);
	$worksheet1->set_column(0,1,30);
	$worksheet1->set_column(0,2,20);


	$worksheet1->write_string(0,0,"NIS");
	$worksheet1->write_string(0,1,"NAMA");
	$worksheet1->write_string(0,2,"NO_HP");



	//data
	$qdt = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"ORDER BY round(m_siswa.nis) ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
	  	{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_pkd = nosql($rdt['kd']);
		$dt_nip = nosql($rdt['nis']);
		$dt_nama = balikin($rdt['nama']);


		//nohp-nya...
		$qkulx = mysql_query("SELECT * FROM sms_nohp_siswa ".
								"WHERE kd_siswa = '$dt_pkd'");
		$rkulx = mysql_fetch_assoc($qkulx);
		$kulx_nohp = nosql($rkulx['nohp']);

		//jika null
		if (empty($kulx_nohp))
			{
			$kulx_nohp = "+62";
			}


		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nip);
		$worksheet1->write_string($dt_nox,1,$dt_nama);
		$worksheet1->write_string($dt_nox,2,$kulx_nohp);
		}
	while ($rdt = mysql_fetch_assoc($qdt));


	//close
	$workbook->close();


	//diskonek
	xclose($koneksi);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci&page=$page";
	xloc($ke);
	exit();
	}

	
	



//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
		

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=import";
	xloc($ke);
	exit();
	}



//fungsi baca file excel
function parseExcel($excel_file_name_with_path)
	{
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);

	$colname=array('NIS', 'NAMA', 'NO_HP', );

	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++)
		{
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++)
			{
			$product[$i-1][$j-1]=$data->sheets[0]['cells'][$i][$j];
			$product[$i-1][$colname[$j-1]]=$data->sheets[0]['cells'][$i][$j];
			}
		}

	return $product;
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=import";
		pekem($pesan,$ke);
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox/excel";
			chmod($path1,0777);

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex");


			//file-nya...
			$uploadfile = "$path1/$filex_namex";

			//require
			require_once '../../inc/class/excel/excel.php';

			$prod=parseExcel($uploadfile);
			$cprod = count($prod);
			for($i=1;$i<$cprod;$i++)
				{
				$i_xyz = md5("$x$i");
				$i_nip = addslashes($prod[$i][0]);
				$i_nama = addslashes($prod[$i][1]);
				$i_nohp = addslashes($prod[$i][2]);
//				$i_nohp = balikin(addslashes($prod[$i][2]));



				//cek /////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_siswa ".
									"WHERE nis = '$i_nip'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_kd = nosql($rcc['kd']);


				$qcc1 = mysql_query("SELECT * FROM sms_nohp_siswa ".
										"WHERE kd_siswa = '$cc_kd'");
				$rcc1 = mysql_fetch_assoc($qcc1);
				$tcc1 = mysql_num_rows($qcc1);
				$cc1_kd = nosql($rcc1['kd']);


				//jika ada, update
				if ($tcc1 != 0)
					{
					//update
					mysql_query("UPDATE sms_nohp_siswa SET nohp = '$i_nohp' ".
									"WHERE kd_siswa = '$cc_kd'");
					}

				//jika blm ada, insert
				else
					{
					//nohp-nya
					mysql_query("INSERT INTO sms_nohp_siswa(kd, kd_siswa, nohp) VALUES ".
									"('$i_xyz', '$cc_kd', '$i_nohp')");
					}


				}


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex";
			chmod($path1,0777);
			unlink ($path1);


			//re-direct
			$ke = "siswa_nohp.php?tapelkd=$tapelkd&kelkd=$kelkd";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//isi *START
ob_start();

//menu
require("../../inc/menu/admsms.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
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

echo '</select>,



Kelas : ';

echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd <> '$kelkd' ".
			"ORDER BY kelas ASC, no ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
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
else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>';
	echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
	echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
	<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&crkd=cr01&crtipe=NIP&kunci='.$kunci.'">NIP</option>
	<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&crkd=cr05&crtipe=Nama&kunci='.$kunci.'">Nama</option>
	</select>
	<input name="kunci" type="text" value="'.$kunci.'" size="20">
	<input name="crkd" type="hidden" value="'.$crkd.'">
	<input name="crtipe" type="hidden" value="'.$crtipe.'">
	<input name="btnCARI" type="submit" value="CARI >>">
	<input name="btnRST" type="submit" value="RESET">
	</td>
	</tr>
	</table>
	<br>';


	//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (empty($s))
		{
		//nis
		if ($crkd == "cr01")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND m_siswa.nis LIKE '%$kunci%' ".
					"ORDER BY round(m_siswa.nis) ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}



		//nama
		else if ($crkd == "cr05")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND m_siswa.nama LIKE '%$kunci%' ".
					"ORDER BY round(m_siswa.nama) ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND m_siswa.nis LIKE '%$kunci%' ".
					"ORDER BY round(m_siswa.nis) ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		if ($count != 0)
			{
			//view data
			echo '<input name="btnIM" type="submit" value="IMPORT">
			<input name="btnEX" type="submit" value="EXPORT">
			<table width="800" border="1" cellspacing="0" cellpadding="3">
			<tr bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="200"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
			<td width="250"><strong><font color="'.$warnatext.'">No.HP</font></strong></td>
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
				$i_nomer = $i_nomer + 1;
				$i_kd = nosql($data['kd']);
				$i_nis = balikin2($data['nis']);
				$i_nama = balikin($data['nama']);


				//nohp-nya..
				$qkun = mysql_query("SELECT * FROM sms_nohp_siswa ".
							"WHERE kd_siswa = '$i_kd'");
				$rkun = mysql_fetch_assoc($qkun);
				$kun_nohp = nosql($rkun['nohp']);


				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<a href="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'&s=edit&pkd='.$i_kd.'" title="EDIT...">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>'.$i_nis.'</td>
				<td>'.$i_nama.'</td>
				<td>'.$kun_nohp.'</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="800" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
			</tr>
			</table>';
			}
		else
			{
			echo '<p>
			<font color="red">
			<strong>TIDAK ADA DATA.</strong>
			</font>
			</p>';
			}
		}





	//jika edit ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($s == "edit")
		{
		//nilai
		$pkd = nosql($_REQUEST['pkd']);

		//data query -> datadiri
		$qnil = mysql_query("SELECT * FROM m_siswa ".
					"WHERE kd = '$pkd'");
		$rnil = mysql_fetch_assoc($qnil);
		$y_nis = nosql($rnil['nis']);
		$y_nama = balikin($rnil['nama']);


		//nohp-nya...
		$qkulx = mysql_query("SELECT * FROM sms_nohp_siswa ".
					"WHERE kd_siswa = '$pkd'");
		$rkulx = mysql_fetch_assoc($qkulx);
		$kulx_nohp = nosql($rkulx['nohp']);

		//jika null
		if (empty($kulx_nohp))
			{
			$kulx_nohp = "+62";
			}


		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top">
		<td>
		<p>
		<strong>'.$y_nis.'. '.$y_nama.'</strong>
		</p>
		<p>
		<input name="nohp" type="text" value="'.$kulx_nohp.'" size="30" onKeyPress="return numbersonly(this, event)">
		</p>
		<p>
		<INPUT type="hidden" name="page" value="'.$page.'">
		<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
		<INPUT type="hidden" name="kelkd" value="'.$kelkd.'">
		<INPUT type="hidden" name="crkd" value="'.$crkd.'">
		<INPUT type="hidden" name="crtipe" value="'.$crtipe.'">
		<INPUT type="hidden" name="kunci" value="'.$kunci.'">
		<INPUT type="hidden" name="pkd" value="'.$pkd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">

		</p>
		</td>
		</tr>
		</table>';
		}

		

	//jika import //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($s == "import")
		{
		echo '<p>
		Silahkan Masukkan File yang akan Di-Import :
		<br>
		<input name="filex_xls" type="file" size="30">
		<br>
		<input name="s" type="hidden" value="'.$s.'">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnIM2" type="submit" value="IMPORT >>">
		</p>
		<p>
		<strong><em>NB. Pastikan Semua Kolom Data yang akan di-import, Telah Sesuai dengan Data Master.</em></strong>
		</p>';
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
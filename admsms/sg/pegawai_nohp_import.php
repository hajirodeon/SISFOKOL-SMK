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
require("../../inc/cek/admsms.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "pegawai_nohp_import.php";
$judul = "Pegawai : Import No.Hp";
$judulku = "[$sms_session : $nip32_session. $nm32_session] ==> $judul";
$juduly = $judul;




//PROSES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//fungsi baca file excel
function parseExcel($excel_file_name_with_path)
	{
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);

	$colname=array('NIP', 'NAMA', 'NO_HP', );

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





//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$filex_namex = $_POST['filex_namex'];


	//hapus file
	$path1 = "../../filebox/excel/$filex_namex";
	chmod($path1,0777);
	unlink ($path1);

	//re-direct
	$ke = "pegawai_nohp.php";
	xloc($ke);
	exit();
	}





//import sekarang
if ($_POST['btnIMx'])
	{
	//nilai
	$filex_namex = $_POST['filex_namex'];

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "pegawai_nohp.php?s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox/excel";

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


				//nohp-nya
				//mysql_query("INSERT INTO sms_nohp_pegawai(kd, kd_pegawai, nohp) VALUES ".
				//		"('$i_xyz', '$i_nip', '$i_nohp')");


				//cek /////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd ".
							"FROM m_pegawai ".
							"WHERE m_pegawai.nip = '$i_nip'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_kd = nosql($rcc['mpkd']);


				$qcc1 = mysql_query("SELECT sms_nohp_pegawai.* ".
							"FROM sms_nohp_pegawai ".
							"WHERE kd_pegawai = '$cc_kd'");
				$rcc1 = mysql_fetch_assoc($qcc1);
				$tcc1 = mysql_num_rows($qcc1);
				$cc1_kd = nosql($rcc1['mpkd']);


				//jika ada, update
				if ($tcc1 != 0)
					{
					//update
					mysql_query("UPDATE sms_nohp_pegawai SET nohp = '$i_nohp' ".
							"WHERE kd_pegawai = '$cc_kd'");
					}

				//jika blm ada, insert
				else
					{
					//nohp-nya
					mysql_query("INSERT INTO sms_nohp_pegawai(kd, kd_pegawai, nohp) VALUES ".
							"('$i_xyz', '$cc_kd', '$i_nohp')");
					}




				}


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex";
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "pegawai_nohp.php";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "pegawai_nohp.php?s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/admsms.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">';

//nama file...
$filex_namex = $_REQUEST['filex_namex'];

//nilai
$path1 = "../../filebox/excel/$filex_namex";

//file-nya...
$uploadfile = $path1;


echo '<p>
Nama File Yang di-Import : <strong>'.$filex_namex.'</strong>
<br>
<input name="filex_namex" type="hidden" value="'.$filex_namex.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="btnBTL" type="submit" value="<< BATAL">
<input name="btnIMx" type="submit" value="IMPORT Sekarang>>">
</p>
</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
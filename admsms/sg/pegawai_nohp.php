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
$filenya = "pegawai_nohp.php";
$judul = "Pegawai : No.HP";
$judulku = "[$sms_session : $nip32_session. $nm32_session] ==> $judul";
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$pkd = nosql($_REQUEST['pkd']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}







//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//cek
	if (empty($kunci))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?kunci=$kunci";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);

	//re-direct
	$ke = "$filenya?kunci=$kunci";
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$kunci = cegah($_POST['kunci']);
	$pkd = nosql($_POST['pkd']);
	$nohp = nosql($_POST['nohp']);
	$page = nosql($_POST['page']);


	//cek
	$qcc = mysql_query("SELECT * FROM sms_nohp_pegawai ".
				"WHERE kd_pegawai = '$pkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//jika ada
	if ($tcc != 0)
		{
		//update
		mysql_query("UPDATE sms_nohp_pegawai ".
				"SET nohp = '$nohp' ".
				"WHERE kd_pegawai = '$pkd'");
		}
	else
		{
		//insert
		mysql_query("INSERT INTO sms_nohp_pegawai (kd, kd_pegawai, nohp) VALUES ".
				"('$x', '$pkd', '$nohp')");
		}


	//re-direct
	$ke = "$filenya?kunci=$kunci&page=$page";
	xloc($ke);
	exit();
	}






//export
if ($_POST['btnEX'])
	{
	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "nohp_pegawai.xls";
	$i_judul = "Daftar Pegawai";


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


	$worksheet1->write_string(0,0,"NIP");
	$worksheet1->write_string(0,1,"NAMA");
	$worksheet1->write_string(0,2,"NO_HP");



	//data
	$qdt = mysql_query("SELECT * FROM m_pegawai ".
				"ORDER BY round(nip) ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
	  	{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_pkd = nosql($rdt['kd']);
		$dt_nip = nosql($rdt['nip']);
		$dt_nama = balikin($rdt['nama']);


		//nohp-nya...
		$qkulx = mysql_query("SELECT * FROM sms_nohp_pegawai ".
					"WHERE kd_pegawai = '$dt_pkd'");
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
	xloc($filenya);
	exit();
	}






//ke import
if ($_POST['btnIM'])
	{
	//re-direct
	$ke = "$filenya?s=import";
	xloc($ke);
	exit();
	}




//import
if ($_POST['btnIM2'])
	{
	//nilai
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=import";
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

			//re-direct
			$ke = "pegawai_nohp_import.php?filex_namex=$filex_namex";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
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
<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="btnCARI" type="submit" value="CARI >>">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>
<br>';


//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (empty($s))
	{
	//jika kunci ada
	if (!empty($kunci))
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
				"WHERE nama LIKE '%$kunci%' ".
				"ORDER BY nama ASC";
		$sqlresult = $sqlcount;
		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
				"ORDER BY nama ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	if ($count != 0)
		{
		//view data
		echo '<input name="btnIM" type="submit" value="IMPORT">
		<input name="btnEX" type="submit" value="EXPORT">
		<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
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
			$i_nama = balikin($data['nama']);


			//nohp-nya..
			$qkun = mysql_query("SELECT * FROM sms_nohp_pegawai ".
						"WHERE kd_pegawai = '$i_kd'");
			$rkun = mysql_fetch_assoc($qkun);
			$kun_nohp = nosql($rkun['nohp']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<a href="'.$filenya.'?kunci='.$kunci.'&s=edit&pkd='.$i_kd.'" title="EDIT...">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_nama.'</td>
			<td>'.$kun_nohp.'</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="600" border="0" cellspacing="0" cellpadding="3">
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

	//data query
	$qnil = mysql_query("SELECT * FROM m_pegawai ".
				"WHERE kd = '$pkd'");
	$rnil = mysql_fetch_assoc($qnil);
	$y_nip = nosql($rnil['nip']);
	$y_nama = balikin($rnil['nama']);


	//nohp-nya...
	$qkulx = mysql_query("SELECT * FROM sms_nohp_pegawai ".
				"WHERE kd_pegawai = '$pkd'");
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
	<strong>'.$y_nama.'</strong>
	</p>
	<p>
	<input name="nohp" type="text" value="'.$kulx_nohp.'" size="30" onKeyPress="return numbersonly(this, event)">
	</p>
	<p>
	<INPUT type="hidden" name="page" value="'.$page.'">
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
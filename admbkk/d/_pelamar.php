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
require("../../inc/cek/admbkk.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pelamar.php";
$judul = "Data Pelamar";
$judulku = "[$bkk_session : $nip15_session. $nm15_session] ==> $judul";
$judulx = $judul;


$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$tapelkd  = nosql($_REQUEST['tapelkd']);
$lowkd  = nosql($_REQUEST['lowkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//jika null
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($lowkd))
	{
	$diload = "document.formx.low.focus();";
	}




//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$lowkd = nosql($_POST['lowkd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd";
	xloc($ke);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$lowkd = nosql($_POST['lowkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$lowkd = nosql($_POST['lowkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd";
	xloc($ke);
	exit();
	}






//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$lowkd = nosql($_POST['lowkd']);
	$jml = nosql($_POST['jml']);


	for ($k=1;$k<=$jml;$k++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$k";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM bkk_calon ".
				"WHERE kd_lowongan = '$lowkd' ".
				"AND kd = '$kd'");
		}



	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd";
	xloc($ke);
	exit();
	}






//export
if ($_POST['btnEX'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$lowkd = nosql($_POST['lowkd']);

	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "Daftar_Pelamar.xls";
	$i_judul = "Daftar Pelamar";


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
	$worksheet1->set_column(0,1,20);
	$worksheet1->set_column(0,2,20);
	$worksheet1->set_column(0,3,20);
	$worksheet1->set_column(0,4,20);
	$worksheet1->set_column(0,5,20);
	$worksheet1->set_column(0,6,20);
	$worksheet1->set_column(0,7,20);
	$worksheet1->set_column(0,8,20);
	$worksheet1->set_column(0,9,20);
	$worksheet1->set_column(0,10,20);
	$worksheet1->set_column(0,11,20);
	$worksheet1->set_column(0,12,20);
	$worksheet1->set_column(0,13,20);
	$worksheet1->set_column(0,14,20);
	$worksheet1->set_column(0,15,20);
	$worksheet1->set_column(0,16,20);
	$worksheet1->set_column(0,17,20);
	$worksheet1->set_column(0,18,20);
	$worksheet1->set_column(0,19,20);
	$worksheet1->set_column(0,20,20);
	$worksheet1->set_column(0,21,20);
	$worksheet1->set_column(0,22,20);
	$worksheet1->set_column(0,23,20);
	$worksheet1->set_column(0,24,20);
	$worksheet1->set_column(0,25,20);
	$worksheet1->set_column(0,26,20);
	$worksheet1->set_column(0,27,20);
	$worksheet1->set_column(0,28,20);
	$worksheet1->set_column(0,29,20);
	$worksheet1->set_column(0,29,20);


	//data ne...
	$qdt = mysql_query("SELECT bkk_lowongan.*, bkk_calon.* ".
				"FROM bkk_lowongan, bkk_calon ".
				"WHERE bkk_calon.kd_lowongan = bkk_lowongan.kd ".
				"AND bkk_lowongan.kd_tapel = '$tapelkd' ".
				"AND bkk_lowongan.kd = '$lowkd' ".
				"ORDER BY bkk_calon.no_tes ASC");
	$rdt = mysql_fetch_assoc($qdt);



	do
		{
		$dt_nox = $dt_nox + 1;
		$dt_notes = nosql($rdt['no_tes']);
		$dt_nama = balikin($rdt['nama']);
		$dt_1 = balikin($rdt['panggilan']);
		$dt_2 = balikin($rdt['kelamin']);
		$dt_3 = balikin($rdt['tmp_lahir']);
		$dt_4 = balikin($rdt['tgl_lahir']);
		$dt_5 = balikin($rdt['agama']);
		$dt_6 = balikin($rdt['nikah']);
		$dt_7 = balikin($rdt['tb']);
		$dt_8 = balikin($rdt['bb']);
		$dt_9 = balikin($rdt['pernah_kerja']);
		$dt_10 = balikin($rdt['no_ktp']);
		$dt_11 = balikin($rdt['masa_ktp']);
		$dt_12 = balikin($rdt['alamat']);
		$dt_13 = balikin($rdt['kab']);
		$dt_14 = balikin($rdt['propinsi']);
		$dt_15 = balikin($rdt['kode_pos']);
		$dt_16 = balikin($rdt['alamat2']);
		$dt_17 = balikin($rdt['kab2']);
		$dt_18 = balikin($rdt['propinsi2']);
		$dt_19 = balikin($rdt['kode_pos2']);
		$dt_20 = balikin($rdt['pendidikan']);
		$dt_21 = balikin($rdt['nama_sekolah']);
		$dt_22 = balikin($rdt['kota_sekolah']);
		$dt_23 = balikin($rdt['jurusan']);
		$dt_24 = balikin($rdt['nilai']);
		$dt_25 = balikin($rdt['tahun_lulus']);
		$dt_26 = balikin($rdt['asal_lamaran']);
		$dt_27 = balikin($rdt['postdate']);
		$dt_28 = balikin($rdt['nohp']);



		$worksheet1->write_string(0,0,"no_urut");
		$worksheet1->write_string(0,1,"no_tes");
		$worksheet1->write_string(0,2,"nama");
		$worksheet1->write_string(0,3,"panggilan");
		$worksheet1->write_string(0,4,"kelamin");
		$worksheet1->write_string(0,5,"tmp_lahir");
		$worksheet1->write_string(0,6,"tgl_lahir");
		$worksheet1->write_string(0,7,"agama");
		$worksheet1->write_string(0,8,"nikah");
		$worksheet1->write_string(0,9,"tb");
		$worksheet1->write_string(0,10,"bb");
		$worksheet1->write_string(0,11,"pernah_kerja");
		$worksheet1->write_string(0,12,"no_ktp");
		$worksheet1->write_string(0,13,"masa_ktp");
		$worksheet1->write_string(0,14,"alamat");
		$worksheet1->write_string(0,15,"kab");
		$worksheet1->write_string(0,16,"propinsi");
		$worksheet1->write_string(0,17,"kode_pos");
		$worksheet1->write_string(0,18,"alamat2");
		$worksheet1->write_string(0,19,"kab2");
		$worksheet1->write_string(0,20,"propinsi2");
		$worksheet1->write_string(0,21,"kode_pos2");
		$worksheet1->write_string(0,22,"nohp");
		$worksheet1->write_string(0,23,"pendidikan");
		$worksheet1->write_string(0,24,"nama_sekolah");
		$worksheet1->write_string(0,25,"kota_sekolah");
		$worksheet1->write_string(0,26,"jurusan");
		$worksheet1->write_string(0,27,"nilai");
		$worksheet1->write_string(0,28,"tahun_lulus");
		$worksheet1->write_string(0,29,"asal_lamaran");
		$worksheet1->write_string(0,30,"postdate");



		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_notes);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$dt_1);
		$worksheet1->write_string($dt_nox,4,$dt_2);
		$worksheet1->write_string($dt_nox,5,$dt_3);
		$worksheet1->write_string($dt_nox,6,$dt_4);
		$worksheet1->write_string($dt_nox,7,$dt_5);
		$worksheet1->write_string($dt_nox,8,$dt_6);
		$worksheet1->write_string($dt_nox,9,$dt_7);
		$worksheet1->write_string($dt_nox,10,$dt_8);
		$worksheet1->write_string($dt_nox,11,$dt_9);
		$worksheet1->write_string($dt_nox,12,$dt_10);
		$worksheet1->write_string($dt_nox,13,$dt_11);
		$worksheet1->write_string($dt_nox,14,$dt_12);
		$worksheet1->write_string($dt_nox,15,$dt_13);
		$worksheet1->write_string($dt_nox,16,$dt_14);
		$worksheet1->write_string($dt_nox,17,$dt_15);
		$worksheet1->write_string($dt_nox,18,$dt_16);
		$worksheet1->write_string($dt_nox,19,$dt_17);
		$worksheet1->write_string($dt_nox,20,$dt_18);
		$worksheet1->write_string($dt_nox,21,$dt_19);
		$worksheet1->write_string($dt_nox,22,$dt_20);
		$worksheet1->write_string($dt_nox,23,$dt_28);
		$worksheet1->write_string($dt_nox,24,$dt_21);
		$worksheet1->write_string($dt_nox,25,$dt_22);
		$worksheet1->write_string($dt_nox,26,$dt_23);
		$worksheet1->write_string($dt_nox,27,$dt_24);
		$worksheet1->write_string($dt_nox,28,$dt_25);
		$worksheet1->write_string($dt_nox,29,$dt_26);
		$worksheet1->write_string($dt_nox,30,$dt_27);
		}
	while ($rdt = mysql_fetch_assoc($qdt));


	//close
	$workbook->close();


	//diskonek
	xclose($koneksi);


	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd";
	xloc($ke);
	exit();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();

//menu
require("../../inc/menu/admbkk.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();


//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");
require("../../inc/js/editor2.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" bgcolor="'.$warnaover.'" cellspacing="0" cellpadding="3">
<tr valign="top">
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

echo '<option value="'.$tpx_kd.'" selected>--'.$tpx_thn1.'/'.$tpx_thn2.'--</option>';

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


Lowongan : ';
echo "<select name=\"low\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM bkk_lowongan ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND kd = '$lowkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_nama = balikin($rowtpx['nama']);

echo '<option value="'.$tpx_kd.'" selected>--'.$tpx_nama.'--</option>';

$qtp = mysql_query("SELECT * FROM bkk_lowongan ".
			"WHERE kd_tapel = '$tapelkd' ".
			"ORDER BY nama ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = balikin($rowtp['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&lowkd='.$tpkd.'">'.$tpth1.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';



//cek
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($lowkd))
	{
	echo '<p>
	<strong><font color="#FF0000">NAMA LOWONGAN Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warna01.'">
	<td>
	<INPUT type="submit" name="btnEX" value="EXPORT EXCEL >>">
	</td>
	<td align="right">';
	echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&lowkd='.$lowkd.'&crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
	<option value="'.$filenya.'?tapelkd='.$tapelkd.'&lowkd='.$lowkd.'&crkd=cr01&crtipe=NOTES&kunci='.$kunci.'">NO.TES</option>
	<option value="'.$filenya.'?tapelkd='.$tapelkd.'&lowkd='.$lowkd.'&crkd=cr02&crtipe=NAMA&kunci='.$kunci.'">NAMA</option>
	<option value="'.$filenya.'?tapelkd='.$tapelkd.'&lowkd='.$lowkd.'&crkd=cr03&crtipe=ALAMAT&kunci='.$kunci.'">ALAMAT</option>
	<option value="'.$filenya.'?tapelkd='.$tapelkd.'&lowkd='.$lowkd.'&crkd=cr04&crtipe=ASAL SEKOLAH&kunci='.$kunci.'">ASAL SEKOLAH</option>
	<option value="'.$filenya.'?tapelkd='.$tapelkd.'&lowkd='.$lowkd.'&crkd=cr05&crtipe=NILAI&kunci='.$kunci.'">NILAI</option>
	</select>
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="lowkd" type="hidden" value="'.$lowkd.'">
	<input name="kunci" type="text" value="'.$kunci.'" size="20">
	<input name="crkd" type="hidden" value="'.$crkd.'">
	<input name="crtipe" type="hidden" value="'.$crtipe.'">
	<input name="btnCARI" type="submit" value="CARI >>">
	<input name="btnRST" type="submit" value="RESET">
	</td>
	</tr>
	</table>';


	//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (empty($s))
		{
		//no_tes
		if ($crkd == "cr01")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT bkk_calon.kd AS swkd ".
					"FROM bkk_lowongan, bkk_calon ".
					"WHERE bkk_calon.kd_lowongan = bkk_lowongan.kd ".
					"AND bkk_calon.no_tes LIKE '%$kunci%' ".
					"AND bkk_lowongan.kd_tapel = '$tapelkd' ".
					"AND bkk_lowongan.kd = '$lowkd' ".
					"ORDER BY bkk_calon.no_tes ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		//nama
		else if ($crkd == "cr02")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT bkk_calon.kd AS swkd ".
					"FROM bkk_lowongan, bkk_calon ".
					"WHERE bkk_calon.kd_lowongan = bkk_lowongan.kd ".
					"AND bkk_calon.nama LIKE '%$kunci%' ".
					"AND bkk_lowongan.kd_tapel = '$tapelkd' ".
					"AND bkk_lowongan.kd = '$lowkd' ".
					"ORDER BY bkk_calon.nama ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}


		//alamat2
		else if ($crkd == "cr03")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT bkk_calon.kd AS swkd ".
					"FROM bkk_lowongan, bkk_calon ".
					"WHERE bkk_calon.kd_lowongan = bkk_lowongan.kd ".
					"AND bkk_calon.alamat LIKE '%$kunci%' ".
					"AND bkk_lowongan.kd_tapel = '$tapelkd' ".
					"AND bkk_lowongan.kd = '$lowkd' ".
					"ORDER BY bkk_calon.alamat ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		//nama sekolah
		else if ($crkd == "cr04")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT bkk_calon.kd AS swkd ".
					"FROM bkk_lowongan, bkk_calon ".
					"WHERE bkk_calon.kd_lowongan = bkk_lowongan.kd ".
					"AND bkk_calon.nama_sekolah LIKE '%$kunci%' ".
					"AND bkk_lowongan.kd_tapel = '$tapelkd' ".
					"AND bkk_lowongan.kd = '$lowkd' ".
					"ORDER BY bkk_calon.nama_sekolah ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}


		//nilai
		else if ($crkd == "cr05")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT bkk_calon.kd AS swkd ".
					"FROM bkk_lowongan, bkk_calon ".
					"WHERE bkk_calon.kd_lowongan = bkk_lowongan.kd ".
					"AND bkk_calon.nilai LIKE '%$kunci%' ".
					"AND bkk_lowongan.kd_tapel = '$tapelkd' ".
					"AND bkk_lowongan.kd = '$lowkd' ".
					"ORDER BY bkk_calon.nilai ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT bkk_calon.kd AS swkd ".
					"FROM bkk_lowongan, bkk_calon ".
					"WHERE bkk_calon.kd_lowongan = bkk_lowongan.kd ".
					"AND bkk_lowongan.kd_tapel = '$tapelkd' ".
					"AND bkk_lowongan.kd = '$lowkd' ".
					"ORDER BY bkk_calon.no_tes ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&lowkd=$lowkd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}


		if ($count != 0)
			{
			//view data
			echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="10"><strong><font color="'.$warnatext.'">NO.TES</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
			<td><strong><font color="'.$warnatext.'">ALAMAT</font></strong></td>
			<td width="200"><strong><font color="'.$warnatext.'">ASAL SEKOLAH</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">NILAI</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
				$nomer = $nomer + 1;
				$i_kd = nosql($data['swkd']);



				//detail calon
				$qdt = mysql_query("SELECT * FROM bkk_calon ".
							"WHERE kd_lowongan = '$lowkd' ".
							"AND kd = '$i_kd'");
				$rdt = mysql_fetch_assoc($qdt);
				$dt_notes = nosql($rdt['no_tes']);
				$dt_nama = balikin($rdt['nama']);
				$dt_alamat = balikin($rdt['alamat2']);
				$dt_nama_sekolah = balikin($rdt['nama_sekolah']);
				$dt_nilai = nosql($rdt['nilai']);
				$dt_postdate = $rdt['postdate'];



				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$i_kd.'">
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
				</td>
				<td>'.$dt_notes.'</td>
				<td>'.$dt_nama.'</td>
				<td>'.$dt_alamat.'</td>
				<td>'.$dt_nama_sekolah.'</td>
				<td>'.$dt_nilai.'</td>
				<td>'.$dt_postdate.'</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="300">
			<input name="jml" type="hidden" value="'.$limit.'">
			<input name="s" type="hidden" value="'.nosql($_REQUEST['s']).'">
			<input name="kd" type="hidden" value="'.nosql($_REQUEST['kd']).'">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPS" type="submit" value="HAPUS">
			</td>
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




	//jika add / edit ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if (($s == "baru") OR ($s == "edit"))
		{
		//nilai
		$kd = nosql($_REQUEST['kd']);


		//data query
		$qnil = mysql_query("SELECT * FROM bkk_lowongan ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd = '$kd'");
		$rnil = mysql_fetch_assoc($qnil);
		$e_nama = balikin($rnil['nama']);
		$e_isi = balikin($rnil['isi']);


		echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="150">
		Nama Lowongan
		</td>
		<td width="5">:</td>
		<td>
		<input name="e_nama" type="text" value="'.$e_nama.'" size="50">
		</td>
		</tr>
		<tr valign="top">
		<td width="150">
		Isi Lowongan
		</td>
		<td width="5">:</td>
		<td>
		<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$e_isi.'</textarea>
		</td>
		</tr>

		<tr valign="top">
		<td width="150">
		&nbsp;
		</td>
		<td width="5">&nbsp;</td>
		<td>
		<INPUT type="hidden" name="s" value="'.$s.'">
		<INPUT type="hidden" name="kd" value="'.$kd.'">
		<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
		<INPUT type="submit" name="btnBTL" value="BATAL">
		<INPUT type="submit" name="btnSMP" value="SIMPAN >>">
		</td>
		</tr>
		</table>';
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
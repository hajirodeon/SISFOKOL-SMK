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
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nil_pengetahuan.php";
$judul = "Penilaian Pengetahuan";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$keahkd = nosql($_REQUEST['keahkd']);
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
			"keahkd=$keahkd&skkd=$skkd&jnskd=$jnskd&progkd=$progkd&page=$page";

$limit = "50";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$jndks = nosql($_POST['jnskd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
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
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
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
			$ke = "nil_pengetahuan_import.php?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&filex_namex2=$filex_namex2";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
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
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);


	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//mapel e...
	$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$progkd'");
	$rowstdx = mysql_fetch_assoc($qstdx);
	$stdx_kd = nosql($rowstdx['kd']);
	$stdx_jnskd = nosql($rowstdx['kd_jenis']);
	$stdx_pel = strip(balikin($rowstdx['xpel']));


	//nama file e...
	$i_filename = "Nilai_Pengetahuan_$stdx_pel.xls";
	$i_judul = "Nilai_Pengetahuan_$stdx_pel";


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
	$worksheet1->write_string(0,0,"NO");
	$worksheet1->write_string(0,1,"NIS");
	$worksheet1->write_string(0,2,"NAMA");
	$worksheet1->write_string(0,3,"UH_1");
	$worksheet1->write_string(0,4,"UH_2");
	$worksheet1->write_string(0,5,"UH_3");
	$worksheet1->write_string(0,6,"UH_4");
	$worksheet1->write_string(0,7,"UH_5");
	$worksheet1->write_string(0,8,"UH_6");
	$worksheet1->write_string(0,9,"UH_7");
	$worksheet1->write_string(0,10,"UH_8");
	$worksheet1->write_string(0,11,"UH_9");
	$worksheet1->write_string(0,12,"RATA_UH");
	$worksheet1->write_string(0,13,"PN_1");
	$worksheet1->write_string(0,14,"PN_2");
	$worksheet1->write_string(0,15,"PN_3");
	$worksheet1->write_string(0,16,"PN_4");
	$worksheet1->write_string(0,17,"PN_5");
	$worksheet1->write_string(0,18,"PN_6");
	$worksheet1->write_string(0,19,"PN_7");
	$worksheet1->write_string(0,20,"PN_8");
	$worksheet1->write_string(0,21,"PN_9");
	$worksheet1->write_string(0,22,"RATA_PN");
	$worksheet1->write_string(0,23,"NH");
	$worksheet1->write_string(0,24,"NUTS");
	$worksheet1->write_string(0,25,"NUAS");
	$worksheet1->write_string(0,26,"NR");
	$worksheet1->write_string(0,27,"RAPORT_A");
	$worksheet1->write_string(0,28,"RAPORT_P");
	$worksheet1->write_string(0,29,"CATATAN");




	//data
	$qdt = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND siswa_kelas.kd_keahlian = '$keahkd' ".
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

		//nil prog_pddkn
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$dt_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_nil_nh1 = nosql($rxpel['nil_nh1']);
		$xpel_nil_nh2 = nosql($rxpel['nil_nh2']);
		$xpel_nil_nh3 = nosql($rxpel['nil_nh3']);
		$xpel_nil_nh4 = nosql($rxpel['nil_nh4']);
		$xpel_nil_nh5 = nosql($rxpel['nil_nh5']);
		$xpel_nil_nh6 = nosql($rxpel['nil_nh6']);
		$xpel_nil_nh7 = nosql($rxpel['nil_nh7']);
		$xpel_nil_nh8 = nosql($rxpel['nil_nh8']);
		$xpel_nil_nh9 = nosql($rxpel['nil_nh9']);
		$xpel_rata_nh = nosql($rxpel['rata_nh']);
		$xpel_nil_tugas1 = nosql($rxpel['nil_tugas1']);
		$xpel_nil_tugas2 = nosql($rxpel['nil_tugas2']);
		$xpel_nil_tugas3 = nosql($rxpel['nil_tugas3']);
		$xpel_nil_tugas4 = nosql($rxpel['nil_tugas4']);
		$xpel_nil_tugas5 = nosql($rxpel['nil_tugas5']);
		$xpel_nil_tugas6 = nosql($rxpel['nil_tugas6']);
		$xpel_nil_tugas7 = nosql($rxpel['nil_tugas7']);
		$xpel_nil_tugas8 = nosql($rxpel['nil_tugas8']);
		$xpel_nil_tugas9 = nosql($rxpel['nil_tugas9']);
		$xpel_rata_tugas = nosql($rxpel['rata_tugas']);
		$xpel_nil_nh = nosql($rxpel['nil_nh']);
		$xpel_nil_uts = nosql($rxpel['nil_uts']);
		$xpel_nil_uas = nosql($rxpel['nil_uas']);
		$xpel_nil_raport = nosql($rxpel['nil_raport_pengetahuan']);
		$xpel_nil_raport_a = nosql($rxpel['nil_raport_pengetahuan_a']);
		$xpel_nil_raport_p = nosql($rxpel['nil_raport_pengetahuan_p']);
		$xpel_catatan = nosql($rxpel['nil_k_pengetahuan']);


		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_nis);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$xpel_nil_nh1);
		$worksheet1->write_string($dt_nox,4,$xpel_nil_nh2);
		$worksheet1->write_string($dt_nox,5,$xpel_nil_nh3);
		$worksheet1->write_string($dt_nox,6,$xpel_nil_nh4);
		$worksheet1->write_string($dt_nox,7,$xpel_nil_nh5);
		$worksheet1->write_string($dt_nox,8,$xpel_nil_nh6);
		$worksheet1->write_string($dt_nox,9,$xpel_nil_nh7);
		$worksheet1->write_string($dt_nox,10,$xpel_nil_nh8);
		$worksheet1->write_string($dt_nox,11,$xpel_nil_nh9);
		$worksheet1->write_string($dt_nox,12,$xpel_rata_nh);
		$worksheet1->write_string($dt_nox,13,$xpel_nil_tugas1);
		$worksheet1->write_string($dt_nox,14,$xpel_nil_tugas2);
		$worksheet1->write_string($dt_nox,15,$xpel_nil_tugas3);
		$worksheet1->write_string($dt_nox,16,$xpel_nil_tugas4);
		$worksheet1->write_string($dt_nox,17,$xpel_nil_tugas5);
		$worksheet1->write_string($dt_nox,18,$xpel_nil_tugas6);
		$worksheet1->write_string($dt_nox,19,$xpel_nil_tugas7);
		$worksheet1->write_string($dt_nox,20,$xpel_nil_tugas8);
		$worksheet1->write_string($dt_nox,21,$xpel_nil_tugas9);
		$worksheet1->write_string($dt_nox,22,$xpel_rata_tugas);
		$worksheet1->write_string($dt_nox,23,$xpel_nil_nh);
		$worksheet1->write_string($dt_nox,24,$xpel_nil_uts);
		$worksheet1->write_string($dt_nox,25,$xpel_nil_uas);
		$worksheet1->write_string($dt_nox,26,$xpel_nil_raport);
		$worksheet1->write_string($dt_nox,27,$xpel_nil_raport_a);
		$worksheet1->write_string($dt_nox,28,$xpel_nil_raport_p);
		$worksheet1->write_string($dt_nox,29,$xpel_catatan);
		}
	while ($rdt = mysql_fetch_assoc($qdt));


	//close
	$workbook->close();


	//diskonek
	xclose($koneksi);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&smtkd=$smtkd&progkd=$progkd";
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

echo '<strong>'.$btxkelas.'</strong>,


Program Keahlian : ';
//terpilih
$qprgx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$keahkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['program']);

echo '<strong>'.$prgx_prog.'</strong>
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&progkd='.$progkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>,


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="keahkd" type="hidden" value="'.$keahkd.'">
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

else if (empty($keahkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>PROGRAM KEAHLIAN Belum Dipilih...!</strong></font>
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
						"AND siswa_kelas.kd_keahlian = '$keahkd' ".
						"ORDER BY m_siswa.nis ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&keahkd=$keahkd&smtkd=$smtkd&jnskd=$jnskd&progkd=$progkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);



		echo '<input name="btnIM" type="submit" value="IMPORT">
		<input name="btnEX" type="submit" value="EXPORT">
		<table width="1000" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td><strong>NAMA</strong></td>
		<td width="50"><strong>RATA UH</strong></td>
		<td width="50"><strong>RATA PN</strong></td>
		<td width="50"><strong>NH</strong></td>
		<td width="50"><strong>NUTS</strong></td>
		<td width="50"><strong>NUAS</strong></td>
		<td width="50"><strong>NR</strong></td>
		<td width="50"><strong>RAPORT A</strong></td>
		<td width="50"><strong>RAPORT P</strong></td>
		<td width="250"><strong>CATATAN</strong></td>
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
			$xpel_nil_rata_uh = nosql($rxpel['rata_nh']);
			$xpel_nil_rata_pn = nosql($rxpel['rata_tugas']);
			$xpel_nil_nh = nosql($rxpel['nil_nh']);
			$xpel_nil_nuts = nosql($rxpel['nil_uts']);
			$xpel_nil_nuas = nosql($rxpel['nil_uas']);
			$xpel_nil_nr = nosql($rxpel['nil_raport_pengetahuan']);
			$xpel_nil_nr_a = nosql($rxpel['nil_raport_pengetahuan_a']);
			$xpel_nil_nr_p = nosql($rxpel['nil_raport_pengetahuan_p']);
			$xpel_nil_k = balikin($rxpel['nil_k_pengetahuan']);





			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input name="skkd'.$i_nomer.'" type="hidden" value="'.$i_skkd.'">
			'.$i_nis.'
			</td>
			<td>
			'.$i_nama.'
			</td>

			<td>
			<input name="nil_rata_uh'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_uh.'" size="3" style="text-align:right" class="input" readonly>
			</td>

			<td>
			<input name="nil_rata_pn'.$i_nomer.'" type="text" value="'.$xpel_nil_rata_pn.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_nh'.$i_nomer.'" type="text" value="'.$xpel_nil_nh.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_nuts'.$i_nomer.'" type="text" value="'.$xpel_nil_nuts.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_nuas'.$i_nomer.'" type="text" value="'.$xpel_nil_nuas.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport'.$i_nomer.'" type="text" value="'.$xpel_nil_nr.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport_a'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_a.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport_p'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_p.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_catatan'.$i_nomer.'" type="text" value="'.$xpel_nil_k.'" size="30" style="text-align:right" class="input" readonly>
			</td>
			
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));


		echo '</table>
		<table width="400" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="page" type="hidden" value="'.$page.'">
		'.$pagelist.'
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

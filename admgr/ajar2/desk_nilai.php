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
$filenya = "desk_nilai.php";
$judul = "Setting Deskripsi Nilai Pengetahuan";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$mmkd = nosql($_REQUEST['mmkd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";

$limit = "50";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if($_POST['btnSMP'])
	{
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$mmkd = nosql($_POST['mmkd']);
		
	$e_p_isi = cegah($_POST['p_editor']);
	$e_k_isi = cegah($_POST['k_editor']);

	//cek
	$qcc = mysql_query("SELECT * FROM m_prog_pddkn_deskripsi ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_prog_pddkn = '$progkd' ".
							"AND kd_smt = '$smtkd'");
	$tcc = mysql_num_rows($qcc);
	
	//jika null, insert
	if (empty($tcc))
		{	
		$kdku = $x;
		
		//query
		mysql_query("INSERT INTO m_prog_pddkn_deskripsi(kd, kd_tapel, kd_kelas, kd_prog_pddkn, kd_smt, ".
						"p_isi, k_isi, postdate) VALUES ".
						"('$kdku', '$tapelkd', '$kelkd', '$progkd', '$smtkd', ".
						"'$e_p_isi', '$e_k_isi', '$today')");

		}
	else 
		{
		//query
		mysql_query("UPDATE m_prog_pddkn_deskripsi SET p_isi = '$e_p_isi', ".
						"k_isi = '$e_k_isi', ".
						"postdate = '$today' ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_prog_pddkn = '$progkd' ".
						"AND kd_smt = '$smtkd'");
		}



	//re-direct
	$ke = "$filenya?mmkd=$mmkd&tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}





//jika reset
if($_POST['btnRST'])
	{
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$mmkd = nosql($_POST['mmkd']);
		
	//hapus
	mysql_query("DELETE FROM m_prog_pddkn_deskripsi ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_kelas = '$kelkd' ".
					"AND kd_prog_pddkn = '$progkd' ".
					"AND kd_smt = '$smtkd'");
	


	//re-direct
	$ke = "$filenya?mmkd=$mmkd&tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&smtkd=$smtkd";
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

//menu
require("../../inc/menu/admgr.php");

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


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
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
$btxkelas = nosql($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>,


Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
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

	echo '<option value="'.$filenya.'?mmkd='.$mmkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&progkd='.$progkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
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
$stdx_pel = balikin($rowstdx['prog_pddkn']);

echo '<strong>'.$stdx_pel.'</strong>
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="mmkd" type="hidden" value="'.$mmkd.'">
</td>
</tr>
</table>';




//nek drg
if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	//cek
	$qcc2 = mysql_query("SELECT * FROM m_prog_pddkn_deskripsi ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_prog_pddkn = '$progkd' ".
							"AND kd_smt = '$smtkd'");
	$rcc2 = mysql_fetch_assoc($qcc2);
	$cc2_p_isi = balikin($rcc2['p_isi']);
	$cc2_k_isi = balikin($rcc2['k_isi']);



	echo '<p>
	Kompetensi Pengetahuan Yang Harus Dikuasai : 
	<br>
	<textarea id="p_editor" name="p_editor" rows="10" cols="100">'.$cc2_p_isi.'</textarea>
	</p>
	
	<br>

	<button name="btnSMP" id="btnSMP" type="submit" value="SIMPAN" class="search_btn">SIMPAN</button>
	<button name="btnRST" id="btnRST" type="submit" value="RESET" class="search_btn">RESET</button>';
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
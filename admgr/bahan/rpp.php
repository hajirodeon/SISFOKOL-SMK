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
$filenya = "rpp.php";
$judul = "Data RPP";
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
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$mmkd = nosql($_POST['mmkd']);
		
	$e_isi = cegah2($_POST['editor']);

	//cek
	$qcc = mysql_query("SELECT * FROM guru_rpp ".
							"WHERE kd_guru_prog_pddkn = '$mmkd' ".
							"AND kd_smt = '$smtkd'");
	$tcc = mysql_num_rows($qcc);
	
	//jika null, insert
	if (empty($tcc))
		{	
		$kdku = $x;
		
		//query
		mysql_query("INSERT INTO guru_rpp(kd, kd_guru_prog_pddkn, kd_smt, isi, postdate) VALUES ".
						"('$kdku', '$mmkd', '$smtkd', '$e_isi', '$today')");

		}
	else 
		{
		//query
		mysql_query("UPDATE guru_rpp SET isi = '$e_isi', ".
						"postdate = '$today' ".
						"WHERE kd_guru_prog_pddkn = '$mmkd' ".
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
	$keahkd = nosql($_POST['keahkd']);
	$progkd = nosql($_POST['progkd']);
	$mmkd = nosql($_POST['mmkd']);
		
	//hapus
	$qcc = mysql_query("DELETE FROM guru_rpp ".
							"WHERE kd_guru_prog_pddkn = '$mmkd' ".
							"AND kd_smt = '$smtkd'");
	$tcc = mysql_num_rows($qcc);
	


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
require("../../inc/js/editor.js");


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
	//detail
	$qx = mysql_query("SELECT * FROM guru_rpp ".
							"WHERE kd_guru_prog_pddkn = '$mmkd' ".
							"AND kd_smt = '$smtkd'");
	$rowx = mysql_fetch_assoc($qx);
	$e_isi = balikin2($rowx['isi']);
	$e_postdate = $rowx['postdate'];

	//pecah titik - titik
	$e_isi2 = pathasli2($e_isi);
	
	

	$e_isi22 = $e_isi2;
	
	
	echo '<p>
	Update Terakhir :
	<br>
	<b>'.$e_postdate.'</b>
	</p>
	
	<p>
	Isi : 
	<br>
	<textarea id="editor" name="editor" rows="50" cols="80" style="width: 100%">'.$e_isi22.'</textarea>
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
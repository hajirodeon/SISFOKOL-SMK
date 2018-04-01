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
$filenya = "nil_sikap_spiritual.php";
$judul = "Penilaian Sikap Spiritual";
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



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$keahkd = nosql($_POST['keahkd']);
	$kompkd = nosql($_POST['kompkd']);
	$progkd = nosql($_POST['progkd']);
	$page = nosql($_POST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_keahlian = '$keahkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"ORDER BY m_siswa.nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	do
		{
		$nomer = $nomer + 1;
		$i_kd = nosql($data['mskd']);
		$i_nis = nosql($data['nis']);
		$i_nama = balikin2($data['nama']);


	
		//query
		$q = mysql_query("SELECT * FROM m_sikap_antarteman ".
								"ORDER BY round(no) ASC");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);

		do
			{
			$nomerx = $nomerx + 1;
			$xyz = md5("$x$nomer$nomerx");
			$e_kd = nosql($row['kd']);
			$e_no = nosql($row['no']);
			$e_nama = balikin($row['nama']);

			//ambil nilai
			$xyz = md5("$x$nomerx");
			
			$yuk = "pilkd";
			$yuhu = "$nomer$yuk$nomerx";
			$kd = nosql($_POST["$yuhu"]);
	
			$yuk = "pil";
			$yuhu = "$nomer$yuk$nomerx";
			$pilnil = nosql($_POST["$yuhu"]);
			
	

			//del
			mysql_query("DELETE FROM siswa_sikap_observasi ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_mapel = '$progkd' ". 
								"AND kd_siswa = '$i_kd' ". 
								"AND kd_ket = '$e_kd'");
	
								
			//insert
			mysql_query("INSERT INTO siswa_sikap_observasi(kd, kd_siswa, kd_tapel, kd_kelas, ".
								"kd_mapel, kd_ket, pilihan, tgl, postdate) VALUES ".
								"('$xyz', '$i_kd', '$tapelkd', '$kelkd', ".
								"'$progkd', '$e_kd', '$pilnil', '$today', '$today')");
			}
		while ($row = mysql_fetch_assoc($q));
	
		}
	while ($data = mysql_fetch_assoc($result));



	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&keahkd=$keahkd&".
			"kompkd=$kompkd&smtkd=$smtkd&progkd=$progkd";
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
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_keahlian = '$keahkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"ORDER BY m_siswa.nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&keahkd=$keahkd&kompkd=$kompkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	//nek ada
	if ($count != 0)
		{
		echo '<table border="1" cellpadding="3" cellspacing="0">
	    <tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td width="250"><strong>Nama</strong></td>';
	
		//query
		$q = mysql_query("SELECT * FROM m_sikap_observasi ".
								"ORDER BY round(no) ASC");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);

		do
			{
			$i_kd = nosql($row['kd']);
			$i_no = nosql($row['no']);
			$i_nama = balikin($row['nama']);

			echo '<td width="50" valign="top"><strong>'.$i_nama.'</strong></td>';
			}
		while ($row = mysql_fetch_assoc($q));
					
	  	echo '</tr>';

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

			$nomer = $nomer + 1;

			$i_kd = nosql($data['mskd']);
			$i_nis = nosql($data['nis']);
			$i_nama = balikin2($data['nama']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">
			<input name="kd'.$nomer.'" type="hidden" value="'.$i_kd.'">
			'.$i_nis.'
			</td>
			<td valign="top">'.$i_nama.'</td>';

	
			//query
			$q = mysql_query("SELECT * FROM m_sikap_observasi ".
									"ORDER BY round(no) ASC");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);
	
			do
				{
				$nomerx = $nomerx + 1;
				$i_kd = nosql($row['kd']);
				$i_no = nosql($row['no']);
				$i_nama = balikin($row['nama']);

				echo '<td valign="top">
				<input name="'.$nomer.'pilkd'.$nomerx.'" type="hidden" value="'.$i_kd.'">
				<select name="'.$nomer.'pil'.$nomerx.'">
				<option value="" selected></option>
				<option value="1">Tidak Pernah</option>
				<option value="2">Kadang - kadang</option>
				<option value="3">Sering</option>
				<option value="4">Selalu</option>
				</select>
				</td>';
				}
			while ($row = mysql_fetch_assoc($q));

			
			echo '</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="900" border="0" cellspacing="0" cellpadding="3">
		<tr>';
		
		//last update
		$qku = mysql_query("SELECT * FROM siswa_sikap_observasi ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_mapel = '$progkd'");
		$rku = mysql_fetch_assoc($qku);
		$ku_tgl = $rku['tgl'];
	
		
		echo '<td>
		<input name="jml" type="hidden" value="'.$total.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		[Kiriman terakhir : <b>'.$ku_tgl.'</b>].
		</td>
			
		<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
		</tr>
		</table>';
		}

	else
		{
		echo '<p>
		<font color="red"><strong>TIDAK ADA DATA.</strong></font>
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

<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v4.0_(NyurungBAN)                          ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS	: 081-829-88-54                                 ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "guru_rpp.php";
$judul = "Data RPP Guru";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$keakd = nosql($_REQUEST['keakd']);
$kompkd = nosql($_REQUEST['kompkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);
$ke = "$filenya?tapelkd=$tapelkd&keakd=$keakd&kompkd=$kompkd&jnskd=$jnskd";




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($keakd))
	{
	$diload = "document.formx.keahlian.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.kompetensi.focus();";
	}
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$keakd = nosql($_POST['keakd']);
	$kompkd = nosql($_POST['kompkd']);
	$kelkd = nosql($_POST['kelkd']);
	$jnskd = nosql($_POST['jnskd']);
	$pelkd = nosql($_POST['pelkd']);
	$gurkd = nosql($_POST['gurkd']);

	//nek null
	if ((empty($pelkd)) OR (empty($gurkd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qc = mysql_query("SELECT m_guru_prog_pddkn.*, m_guru.* ".
					"FROM m_guru_prog_pddkn, m_guru ".
					"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
					"AND m_guru.kd_tapel = '$tapelkd' ".
					"AND m_guru.kd_keahlian = '$keakd' ".
					"AND m_guru.kd_keahlian_kompetensi = '$kompkd' ".
					"AND m_guru.kd_kelas = '$kelkd' ".
					"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd' ".
//					"AND m_guru_prog_pddkn.kd_guru = '$gurkd'");
					"AND m_guru.kd_pegawai = '$gurkd'");
		$rc = mysql_fetch_assoc($qc);
		$tc = mysql_num_rows($qc);
		$guru = balikin2($rx['nama']);

		//nek ada, msg
		if ($tc != 0)
			{
			//re-direct
			$pesan = "Guru Tersebut Telah Mengajar Mata Pelajaran Tersebut. Silahkan Ganti...!";
			pekem($pesan,$ke);
			}
		else
			{
			//deteksi
			$qcc = mysqL_query("SELECT m_guru.*, m_guru.kd AS mgkd, ".
						"m_pegawai.*, m_pegawai.kd AS mpkd ".
						"FROM m_guru, m_pegawai ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_guru.kd_pegawai = '$gurkd' ".
//						"AND m_guru.kd = '$gurkd' ".
						"AND m_guru.kd_tapel = '$tapelkd' ".
						"AND m_guru.kd_keahlian = '$keakd' ".
						"AND m_guru.kd_keahlian_kompetensi = '$kompkd' ".
						"AND m_guru.kd_kelas = '$kelkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$cc_mgkd = nosql($rcc['mgkd']);
			$cc_mpkd = nosql($rcc['mpkd']);
			$cc_nip = nosql($rcc['nip']);
			$cc_nm = balikin($rcc['nama']);
			$cc_xyz = md5("$today");


			//nek iya
			if ($tcc != 0)
				{
				//query
				mysql_query("INSERT INTO m_guru_prog_pddkn(kd, kd_prog_pddkn, kd_guru) VALUES ".
						"('$x', '$pelkd', '$cc_mgkd')");
				}
			else
				{
				//query
				mysql_query("INSERT INTO m_guru(kd, kd_tapel, kd_keahlian, kd_keahlian_kompetensi, ".
						"kd_kelas, kd_pegawai) VALUES ".
						"('$cc_xyz', '$tapelkd', '$keakd', '$kompkd', ".
						"'$kelkd', '$gurkd')");


				//query
				mysql_query("INSERT INTO m_guru_prog_pddkn(kd, kd_prog_pddkn, kd_guru) VALUES ".
					"('$x', '$pelkd', '$cc_xyz')");
				}


			//re-direct
			xloc($ke);
			exit();
			}
		}
	}



//jika hapus
if ($s == "hapus")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$keakd = nosql($_REQUEST['keakd']);
	$kompkd = nosql($_REQUEST['kompkd']);
	$kelkd = nosql($_REQUEST['kelkd']);
	$jnskd = nosql($_REQUEST['jnskd']);
	$pelkd = nosql($_REQUEST['pelkd']);
	$gurkd = nosql($_REQUEST['gurkd']);
	$gkd = nosql($_REQUEST['gkd']);

	//query
	mysql_query("DELETE FROM m_guru_prog_pddkn ".
			"WHERE kd = '$gkd'");

	//re-direct
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admwaka.php");
xheadline($judul);

//VIEW //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$ke.'">
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


Program Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
				"WHERE kd = '$keakd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['program']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$keakd' ".
			"ORDER BY program ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>,



Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd = '$kompkd'");
$rowkeax = mysql_fetch_assoc($qkeax);
$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['kompetensi']);
$keax_singk = nosql($rowkeax['singkatan']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$keakd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['kompetensi']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Jenis Mata Pelajaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd = '$jnskd'");
$rowjnx = mysql_fetch_assoc($qjnx);
$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['jenis']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY jenis ASC");
$rowjn = mysql_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['jenis']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="keakd" type="hidden" value="'.$keakd.'">
<input name="kompkd" type="hidden" value="'.$kompkd.'">
<input name="jnskd" type="hidden" value="'.$jnskd.'">
</td>
</tr>
</table>
<br>';


//nek blm
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($keakd))
	{
	echo '<p>
	<strong><font color="#FF0000">PROGRAM KEAHLIAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($kompkd))
	{
	echo '<p>
	<strong><font color="#FF0000">KOMPETENSI KEAHLIAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($jnskd))
	{
	echo '<p>
	<strong><font color="#FF0000">JENIS Mata Pelajaran Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	//query
	$q = mysql_query("SELECT DISTINCT(m_pegawai.nip) AS nip ".
						"FROM m_guru, m_pegawai ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"AND m_guru.kd_keahlian = '$keakd' ".
						"AND m_guru.kd_keahlian_kompetensi = '$kompkd' ".
						"ORDER BY round(m_pegawai.nip) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	if ($total != 0)
		{
		echo '<table width="700" border="1" cellpadding="3" cellspacing="0">
    	<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong>No.</strong></td>
		<td width="5" valign="top"><strong>NIP</strong></td>
    	<td valign="top"><strong><font color="'.$warnatext.'">Guru</font></strong></td>
    	<td width="300" valign="top"><strong><font color="'.$warnatext.'">Kelas - Mata Pelajaran</font></strong></td>
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

			$nomer = $nomer + 1;
			$i_nip = nosql($row['nip']);

			//detail
			$qpd = mysql_query("SELECT * FROM m_pegawai ".
						"WHERE nip = '$i_nip'");
			$rpd = mysql_fetch_assoc($qpd);
			$pd_kd = nosql($rpd['kd']);
			$pd_nama = balikin($rpd['nama']);


			//nek null
			if (empty($i_nip))
				{
				$i_nip = "-";
				}

			echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">'.$nomer.'. </td>
    			<td valign="top">'.$i_nip.'</td>
			<td valign="top">
			'.$pd_nama.'
			</td>
			<td valign="top">';
			//pel-nya
			$quru = mysql_query("SELECT m_guru_prog_pddkn.*, m_guru_prog_pddkn.kd AS mgkd, m_guru.* ".
									"FROM m_guru_prog_pddkn, m_guru ".
									"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
									"AND m_guru.kd_pegawai = '$pd_kd'");
			$ruru = mysql_fetch_assoc($quru);


			do
				{
				$gkd = nosql($ruru['mgkd']);
				$kd_prog_pddkn = nosql($ruru['kd_prog_pddkn']);
				$pkd = nosql($ruru['kd_prog_pddkn']);
				$kd_kelas = nosql($ruru['kd_kelas']);


				//mapel
				$q1 = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$kd_prog_pddkn'");
				$r1 = mysql_fetch_assoc($q1);
				$gpel = balikin($r1['prog_pddkn']);


				//kelas
				$q2 = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$kd_kelas'");
				$r2 = mysql_fetch_assoc($q2);
				$gkelas = balikin($r2['kelas']);


				//nek null
				if (empty($gkd))
					{
					echo "-";
					}
				else
					{
					echo '<strong></strong>('.$gkelas.') '.$gpel.'
					<br>';
										
					//looping smt 
					$qst = mysql_query("SELECT * FROM m_smt ".
											"ORDER BY smt ASC");
					$rowst = mysql_fetch_assoc($qst);
					
					do
						{
						$st_kd = nosql($rowst['kd']);
						$st_smt = nosql($rowst['smt']);
					
					
						$qx = mysql_query("SELECT * FROM guru_rpp ".
											"WHERE kd_guru_prog_pddkn = '$gkd' ".
											"AND kd_smt = '$st_kd'");
						$rowx = mysql_fetch_assoc($qx);
						$e_isi = balikin2($rowx['isi']);
						$e_postdate = $rowx['postdate'];
									
						//jika ada
						if (!empty($e_postdate))
							{	
							echo '<font color=green>
							[Semester : <b>'.$st_smt.'</b>].
							[<a href="guru_rpp_view.php?gkd='.$gkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'&progkd='.$pelkd.'&mpkd='.$pelx_mpkd.'&kompkd='.$kompkd.'&smtkd='.$st_kd.'" target="_blank"><img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>]. 
							<br>
							[Last Update : <b>'.$e_postdate.'</b>].
							</font>
							<br><br>';
							}
						else
							{
							echo '[Semester : <b>'.$st_smt.'</b>]. 
							<br>
							[Last Update : <b>'.$e_postdate.'</b>].
							<br><br>';
							}
						}
					while ($rowst = mysql_fetch_assoc($qst));
					
					
					echo '<br>';
					}
				}
			while ($ruru = mysql_fetch_assoc($quru));



			echo '</td>
    		</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
    	<tr>
    	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
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
?>
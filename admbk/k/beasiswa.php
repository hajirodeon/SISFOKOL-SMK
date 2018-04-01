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
require("../../inc/cek/admbk.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "beasiswa.php";
$judul = "Beasiswa Siswa";
$judulku = "[$bk_session : $nip91_session.$nm91_session] ==> $judul";
$juduly = $judul;
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$nis = nosql($_REQUEST['nis']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&page=$page";







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus daftar seorang siswa.
if ($s == "hapus")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$smtkd = nosql($_REQUEST['smtkd']);
	$pkd = nosql($_REQUEST['pkd']);

	mysql_query("DELETE FROM siswa_beasiswa ".
			"WHERE kd = '$pkd'");


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}







//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$ikd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM siswa_beasiswa ".
				"WHERE kd_siswa = '$ikd'");
		}


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}





//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}








//ke detail beasiswa
if ($_POST['btnSMPx'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$utgl = nosql($_POST['utgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_entry = "$uthn:$ubln:$utgl";
	$nis = nosql($_POST['nis']);
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);
	$kdx = nosql($_POST['kdx']);



	//cek
	if ((empty($nis)) OR (empty($utgl)) OR (empty($ubln)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?s=$s&tapelkd=$tapelkd&smtkd=$smtkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM m_siswa ".
					"WHERE nis = '$nis'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_kd = nosql($rcc['kd']);

		//nek ada
		if ($tcc != 0)
			{
			//re-direct
			$ke = "$filenya?s=$s&a=detail&nis=$nis&&tapelkd=$tapelkd&smtkd=$smtkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Tidak Ada Siswa dengan NIS : $nis. Harap Diperhatikan...!!";
			$ke = "$filenya?s=$s&nis=$nis&tapelkd=$tapelkd&smtkd=$smtkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
			pekem($pesan,$ke);
			exit();
			}
		}
	}






//simpan beasiswa
if ($_POST['btnSMPx2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$utgl = nosql($_POST['utgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_entry = "$uthn:$ubln:$utgl";
	$nis = nosql($_POST['nis']);
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);
	$jnskd = nosql($_POST['jnskd']);
	$kdx = nosql($_POST['kdx']);
	$swkd = nosql($_POST['swkd']);




	//cek
	if (empty($jnskd))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?s=$s&nis=$nis&a=detail&jnskd=$jnskd&tapelkd=$tapelkd&smtkd=$smtkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//insert
		mysql_query("INSERT INTO siswa_beasiswa (kd, kd_tapel, kd_smt, ".
				"kd_siswa, kd_beasiswa, tgl, postdate) VALUES ".
				"('$x', '$tapelkd', '$smtkd', ".
				"'$swkd', '$jnskd', '$tgl_entry', '$today')");


		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//focus....focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}



//isi *START
ob_start();

//menu
require("../../inc/menu/admbk.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
xheadline($judul);



echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>


[<a href="'.$filenya.'?s=baru&smtkd='.$smtkd.'&tapelkd='.$tapelkd.'">Tulis Baru</a>].
</td>
</tr>
</table>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="page" type="hidden" value="'.$page.'">
<br>';


//nek drg
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}


else if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}


else
	{
	//jika entry
	if ($s == "baru")
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		Tanggal : ';
		echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
		echo '<option value="'.$utgl.'">'.$utgl.'</option>';
		for ($itgl=1;$itgl<=31;$itgl++)
			{
			echo '<option value="'.$filenya.'?s='.$s.'&tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&utgl='.$itgl.'">'.$itgl.'</option>';
			}
		echo '</select>';

		echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
		echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
		for ($i=1;$i<=12;$i++)
			{
			//nilainya
			if ($i<=6) //bulan juli sampai desember
				{
				$ibln = $i + 6;

				echo '<option value="'.$filenya.'?s='.$s.'&tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
				}

			else if ($i>6) //bulan januari sampai juni
				{
				$ibln = $i - 6;

				echo '<option value="'.$filenya.'?s='.$s.'&tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
				}
			}

		echo '</select>
		</td>
		</tr>
		</table>';

		//query
		$qccx = mysql_query("SELECT m_siswa.* ".
					"FROM m_siswa ".
					"WHERE nis = '$nis'");
		$rccx = mysql_fetch_assoc($qccx);
		$tccx = mysql_num_rows($qccx);
		$e_swkd = nosql($rccx['kd']);
		$e_nama = balikin($rccx['nama']);






		//entry
		echo '<p>
		NIS :
		<br>
		<input type="text" name="nis" value="'.$nis.'" size="10">
		<br>
		<br>

		<input type="submit" name="btnBTL" value="BATAL">
		<input type="submit" name="btnSMPx" value="DETAIL >>">
		<input type="hidden" name="s" value="'.$s.'">
		<input type="hidden" name="utgl" value="'.$utgl.'">
		<input type="hidden" name="ubln" value="'.$ubln.'">
		<input type="hidden" name="uthn" value="'.$uthn.'">
		<input type="hidden" name="kdx" value="'.$kdx.'">
		<input type="hidden" name="swkd" value="'.$e_swkd.'">
		</p>';



		//jika detail beasiswa
		if ($a == "detail")
			{
			echo '<p>
			<hr>
			Nama Siswa : <strong>'.$nis.'.'.$e_nama.'</strong>
			<hr>
			</p>

			<p>
			<strong>BEASISWA YANG DIPEROLEH :</strong>
			</p>

			<p>
			Jenis Beasiswa :
			<br>';
			echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

			//terpilih
			$qtpx = mysql_query("SELECT * FROM m_beasiswa ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd = '$jnskd'");
			$rowtpx = mysql_fetch_assoc($qtpx);
			$tpx_kd = nosql($rowtpx['kd']);
			$tpx_jenis = balikin($rowtpx['jenis']);
			$tpx_dari = balikin($rowtpx['dari']);
			$tpx_awal = balikin($rowtpx['tanggal_awal']);
			$tpx_akhir = balikin($rowtpx['tanggal_akhir']);

			echo '<option value="'.$tpx_kd.'">--'.$tpx_jenis.' [Dari : '.$tpx_dari.']. [Berlaku mulai '.$tpx_awal.' sampai '.$tpx_akhir.'].--</option>';

			$qtp = mysql_query("SELECT * FROM m_beasiswa ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd <> '$jnskd' ".
						"ORDER BY jenis ASC");
			$rowtp = mysql_fetch_assoc($qtp);

			do
				{
				$tpkd = nosql($rowtp['kd']);
				$tpjenis = balikin($rowtp['jenis']);
				$tpdari = balikin($rowtp['dari']);
				$tpawal = balikin($rowtp['tanggal_awal']);
				$tpakhir = balikin($rowtp['tanggal_akhir']);

				echo '<option value="'.$filenya.'?s='.$s.'&a=detail&nis='.$nis.'&&tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'&jnskd='.$tpkd.'">'.$tpjenis.' [Dari : '.$tpdari.']. [Berlaku mulai '.$tpawal.' sampai '.$tpakhir.'].</option>';
				}
			while ($rowtp = mysql_fetch_assoc($qtp));

			echo '</select>
			</p>

			<p>

			<input type="submit" name="btnSMPx2" value="SIMPAN >>">
			<input type="hidden" name="s" value="'.$s.'">
			<input type="hidden" name="utgl" value="'.$utgl.'">
			<input type="hidden" name="ubln" value="'.$ubln.'">
			<input type="hidden" name="uthn" value="'.$uthn.'">
			<input type="hidden" name="jnskd" value="'.$jnskd.'">
			<input type="hidden" name="kdx" value="'.$kdx.'">
			<input type="hidden" name="nis" value="'.$nis.'">
			<input type="hidden" name="swkd" value="'.$e_swkd.'">
			</p>';
			}
		}

	else
		{
		//query
		$qcc = mysql_query("SELECT DISTINCT(kd_siswa) AS swkd ".
					"FROM siswa_beasiswa, m_siswa ".
					"WHERE siswa_beasiswa.kd_siswa = m_siswa.kd ".
					"AND siswa_beasiswa.kd_tapel = '$tapelkd' ".
					"AND siswa_beasiswa.kd_smt = '$smtkd' ".
					"ORDER BY m_siswa.nis ASC");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);



		//jika ada
		if ($tcc != 0)
			{
			echo '<p>
			<table width="980" border="1" cellspacing="0" cellpadding="3">
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="250"><strong><font color="'.$warnatext.'">Siswa</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Beasiswa Yang Diperoleh</font></strong></td>
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

				$i_nomer = $i_nomer + 1;
				$i_kd = nosql($rcc['swkd']);



				//detail siswa
				$qswi = mysql_query("SELECT * FROM m_siswa ".
							"WHERE kd = '$i_kd'");
				$rswi = mysql_fetch_assoc($qswi);
				$swi_nis = nosql($rswi['nis']);
				$swi_nama = balikin($rswi['nama']);



				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$i_nomer.'" value="'.$i_kd.'">
				</td>
				<td>
				<strong>'.$swi_nis.'. '.$swi_nama.'</strong>
				</td>
				<td>';



				//data beasiswa
				$qdt = mysql_query("SELECT siswa_beasiswa.*, siswa_beasiswa.kd AS pkd, m_beasiswa.* ".
							"FROM siswa_beasiswa, m_beasiswa ".
							"WHERE siswa_beasiswa.kd_beasiswa = m_beasiswa.kd ".
							"AND siswa_beasiswa.kd_tapel = '$tapelkd' ".
							"AND siswa_beasiswa.kd_smt = '$smtkd' ".
							"AND siswa_beasiswa.kd_siswa = '$i_kd' ".
							"ORDER BY m_beasiswa.jenis ASC");
				$rdt = mysql_fetch_assoc($qdt);
				$tdt = mysql_num_rows($qdt);


				do
					{
					//nilai
					$dt_pkd = nosql($rdt['pkd']);
					$dt_jenis = balikin($rdt['jenis']);
					$dt_postdate = $rdt['postdate'];


					echo "<strong>$dt_jenis.</strong>
					[<em>$dt_postdate</em>].
					[<a href=\"$filenya?s=hapus&tapelkd=$tapelkd&smtkd=$smtkd&pkd=$dt_pkd\">HAPUS</a>].
					<hr>";
					}
				while ($rdt = mysql_fetch_assoc($qdt));

				echo '</td>
				</tr>';
				}
			while ($rcc = mysql_fetch_assoc($qcc));

			echo '</table>
			<table width="980" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td width="500">
			<input type="hidden" name="utgl" value="'.$utgl.'">
			<input type="hidden" name="ubln" value="'.$ubln.'">
			<input type="hidden" name="uthn" value="'.$uthn.'">
			<input name="jml" type="hidden" value="'.$tcc.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="kd" type="hidden" value="'.$kdx.'">
			<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tcc.')">
			<input name="btnBTL" type="reset" value="BATAL">
			<input name="btnHPS" type="submit" value="HAPUS">
			</td>
			<td align="right">Total : <strong><font color="#FF0000">'.$tcc.'</font></strong> Data. '.$pagelist.'</td>
			</tr>
			</table>
			</p>';
			}
		else
			{
			echo '<p>
			<font color="red">
			<b>TIDAK ADA DATA BEASISWA</b>
			</font>
			</p>';
			}
		}

	}


echo '<br>
<br>
<br>
</form>';


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
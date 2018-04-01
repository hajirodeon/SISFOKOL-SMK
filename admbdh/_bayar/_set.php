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
require("../../inc/cek/admbdh.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "set.php";
$judul = "Set Keuangan";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$jnskd = nosql($_REQUEST['jnskd']);
$jenis = cegah($_REQUEST['jenis']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);

$ke = "$filenya?jnskd=$jnskd&jenis=$jenis";





//focus...
if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$jnskd = nosql($_POST['jnskd']);
	$jenis = nosql($_POST['jenis']);
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);


	//cek komite ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($jnskd == "komite")
		{
		//looping
		$qccx = mysql_query("SELECT * FROM m_kelas ".
					"ORDER BY round(no) ASC");
		$rccx = mysql_fetch_assoc($qccx);
		$tccx = mysql_num_rows($qccx);

		do
			{
			//nilai
			$nomer = $nomer + 1;
			$xyz = md5("$x$nomer");
			$ccx_kd = nosql($rccx['kd']);

			//ambil nilai
			$xnspp = "nil_komite";
			$xnspp1 = "$ccx_kd$xnspp";
			$xnsppxx = nosql($_POST["$xnspp1"]);

			//cek
			$qcc = mysql_query("SELECT * FROM m_uang_spp ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$ccx_kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya
			if ($tcc != 0)
				{
				///update
				mysql_query("UPDATE m_uang_spp SET nilai = '$xnsppxx' ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$ccx_kd'");
				}
				else
				{
				//baru
				mysql_query("INSERT INTO m_uang_spp (kd, kd_tapel, kd_kelas, nilai) VALUES ".
						"('$xyz', '$tapelkd', '$ccx_kd', '$xnsppxx')");
				}
			}
		while ($rccx = mysql_fetch_assoc($qccx));
		}




	//cek praktek ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "praktek")
		{
		//looping
		$qccx = mysql_query("SELECT * FROM m_kelas ".
					"ORDER BY round(no) ASC");
		$rccx = mysql_fetch_assoc($qccx);
		$tccx = mysql_num_rows($qccx);

		do
			{
			//nilai
			$nomer = $nomer + 1;
			$xyz = md5("$x$nomer");
			$ccx_kd = nosql($rccx['kd']);

			//ambil nilai
			$xnspp = "nil_komite";
			$xnspp1 = "$ccx_kd$xnspp";
			$xnsppxx = nosql($_POST["$xnspp1"]);

			//cek
			$qcc = mysql_query("SELECT * FROM m_uang_praktek ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$ccx_kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya
			if ($tcc != 0)
				{
				///update
				mysql_query("UPDATE m_uang_praktek SET nilai = '$xnsppxx' ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$ccx_kd'");
				}
				else
				{
				//baru
				mysql_query("INSERT INTO m_uang_praktek (kd, kd_tapel, kd_kelas, nilai) VALUES ".
						"('$xyz', '$tapelkd', '$ccx_kd', '$xnsppxx')");
				}
			}
		while ($rccx = mysql_fetch_assoc($qccx));
		}




	//cek perawatan ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "perawatan")
		{
		//looping
		$qccx = mysql_query("SELECT * FROM m_kelas ".
					"ORDER BY round(no) ASC");
		$rccx = mysql_fetch_assoc($qccx);
		$tccx = mysql_num_rows($qccx);

		do
			{
			//nilai
			$nomer = $nomer + 1;
			$xyz = md5("$x$nomer");
			$ccx_kd = nosql($rccx['kd']);

			//ambil nilai
			$xnspp = "nil_komite";
			$xnspp1 = "$ccx_kd$xnspp";
			$xnsppxx = nosql($_POST["$xnspp1"]);

			//cek
			$qcc = mysql_query("SELECT * FROM m_uang_perawatan ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$ccx_kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya
			if ($tcc != 0)
				{
				///update
				mysql_query("UPDATE m_uang_perawatan SET nilai = '$xnsppxx' ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$ccx_kd'");
				}
				else
				{
				//baru
				mysql_query("INSERT INTO m_uang_perawatan (kd, kd_tapel, kd_kelas, nilai) VALUES ".
						"('$xyz', '$tapelkd', '$ccx_kd', '$xnsppxx')");
				}
			}
		while ($rccx = mysql_fetch_assoc($qccx));
		}






	//cek lab.bahasa ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "lab")
		{
		//looping
		$qccx = mysql_query("SELECT * FROM m_kelas ".
					"ORDER BY round(no) ASC");
		$rccx = mysql_fetch_assoc($qccx);
		$tccx = mysql_num_rows($qccx);

		do
			{
			//nilai
			$nomer = $nomer + 1;
			$xyz = md5("$x$nomer");
			$ccx_kd = nosql($rccx['kd']);

			//ambil nilai
			$xnspp = "nil_komite";
			$xnspp1 = "$ccx_kd$xnspp";
			$xnsppxx = nosql($_POST["$xnspp1"]);

			//cek
			$qcc = mysql_query("SELECT * FROM m_uang_lab ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$ccx_kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya
			if ($tcc != 0)
				{
				///update
				mysql_query("UPDATE m_uang_lab SET nilai = '$xnsppxx' ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$ccx_kd'");
				}
				else
				{
				//baru
				mysql_query("INSERT INTO m_uang_lab (kd, kd_tapel, kd_kelas, nilai) VALUES ".
						"('$xyz', '$tapelkd', '$ccx_kd', '$xnsppxx')");
				}
			}
		while ($rccx = mysql_fetch_assoc($qccx));
		}





	//cek SIP ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "sip")
		{
		//nilai
		$nil_sip = nosql($_POST['nil_sip']);

		//cek
		$qcc = mysql_query("SELECT * FROM m_uang_pangkal ".
					"WHERE kd_tapel = '$tapelkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek iya
		if ($tcc != 0)
			{
			///update
			mysql_query("UPDATE m_uang_pangkal SET nilai = '$nil_pangkal' ".
					"WHERE kd_tapel = '$tapelkd'");
			}
		else
			{
			//baru
			mysql_query("INSERT INTO m_uang_pangkal (kd, kd_tapel, nilai) VALUES ".
					"('$x', '$tapelkd', '$nil_sip')");
			}
		}






	//cek OSIS ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "osis")
		{
		//nilai
		$nil_osis = nosql($_POST['nil_osis']);

		//cek
		$qcc = mysql_query("SELECT * FROM m_uang_osis ".
					"WHERE kd_tapel = '$tapelkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek iya
		if ($tcc != 0)
			{
			///update
			mysql_query("UPDATE m_uang_osis SET nilai = '$nil_osis' ".
					"WHERE kd_tapel = '$tapelkd'");
			}
		else
			{
			//baru
			mysql_query("INSERT INTO m_uang_osis (kd, kd_tapel, nilai) VALUES ".
					"('$x', '$tapelkd', '$nil_osis')");
			}
		}





	//cek syukuran ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "syukuran")
		{
		//nilai
		$nil_syukuran = nosql($_POST['nil_syukuran']);

		//cek
		$qcc = mysql_query("SELECT * FROM m_uang_syukuran ".
					"WHERE kd_tapel = '$tapelkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek iya
		if ($tcc != 0)
			{
			///update
			mysql_query("UPDATE m_uang_syukuran SET nilai = '$nil_syukuran' ".
					"WHERE kd_tapel = '$tapelkd'");
			}
		else
			{
			//baru
			mysql_query("INSERT INTO m_uang_syukuran (kd, kd_tapel, nilai) VALUES ".
					"('$x', '$tapelkd', '$nil_syukuran')");
			}
		}



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?jnskd=$jnskd&jenis=$jenis&tapelkd=$tapelkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/menu/admbdh.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Jenis Keuangan : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$jenis.'" selected>'.$jenis.'</option>
<option value="'.$filenya.'?jnskd=komite&jenis=Uang Komite">Uang Komite</option>
<option value="'.$filenya.'?jnskd=sip&jenis=Uang SIP">Uang SIP</option>
<option value="'.$filenya.'?jnskd=osis&jenis=Uang OSIS">Uang OSIS</option>
<option value="'.$filenya.'?jnskd=syukuran&jenis=Uang Syukuran">Uang Syukuran</option>
<option value="'.$filenya.'?jnskd=praktek&jenis=Uang Praktek">Uang Praktek</option>
<option value="'.$filenya.'?jnskd=perawatan&jenis=Uang Perawatan">Uang Perawatan</option>
<option value="'.$filenya.'?jnskd=lab&jenis=Uang Lab.Bahasa">Uang Lab.Bahasa</option>
</select>
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($jnskd))
	{
	echo '<p>
	<font color="#FF0000"><strong>JENIS KEUANGAN Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	//jika komite//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($jnskd == "komite")
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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

			echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&jenis='.$jenis.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
			}
		while ($rowtp = mysql_fetch_assoc($qtp));

		echo '</select>
		</td>
		</tr>
		</table>';


		if (empty($tapelkd))
			{
			echo '<p>
			<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
			</p>';
			}
		else
			{
			//daftar kelas
			$qbt = mysql_query("SELECT * FROM m_kelas ".
									"ORDER BY no ASC");
			$rowbt = mysql_fetch_assoc($qbt);

			echo '<br>
			<table width="250" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warnaheader.'">
			<td width="50" valign="top"><strong>Tingkat</strong></td>
			<td valign="top"><strong>Nilai</strong></td>
			</tr>';


			do
				{
				//nilai
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

				$btkd = nosql($rowbt['kd']);
				$btno = nosql($rowbt['no']);
				$btkelas = balikin($rowbt['kelas']);


				//nilai uangnya...
				$qku = mysql_query("SELECT * FROM m_uang_spp ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$btkd'");
				$rku = mysql_fetch_assoc($qku);
				$tku = mysql_num_rows($qku);
				$ku_nilai = nosql($rku['nilai']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td valign="top">'.$btkelas.'</td>
				<td valign="top">
				Rp.	<input name="'.$btkd.'nil_komite" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
				</td>
				</tr>';
				}
			while ($rowbt = mysql_fetch_assoc($qbt));

			echo '</table>

			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="jenis" type="hidden" value="'.$jenis.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}
		}






	//jika praktek//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "praktek")
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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

			echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&jenis='.$jenis.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
			}
		while ($rowtp = mysql_fetch_assoc($qtp));

		echo '</select>
		</td>
		</tr>
		</table>';


		if (empty($tapelkd))
			{
			echo '<p>
			<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
			</p>';
			}
		else
			{
			//daftar kelas
			$qbt = mysql_query("SELECT * FROM m_kelas ".
									"ORDER BY no ASC");
			$rowbt = mysql_fetch_assoc($qbt);

			echo '<br>
			<table width="250" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warnaheader.'">
			<td width="50" valign="top"><strong>Tingkat</strong></td>
			<td valign="top"><strong>Nilai</strong></td>
			</tr>';


			do
				{
				//nilai
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

				$btkd = nosql($rowbt['kd']);
				$btno = nosql($rowbt['no']);
				$btkelas = balikin($rowbt['kelas']);


				//nilai uangnya...
				$qku = mysql_query("SELECT * FROM m_uang_praktek ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$btkd'");
				$rku = mysql_fetch_assoc($qku);
				$tku = mysql_num_rows($qku);
				$ku_nilai = nosql($rku['nilai']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td valign="top">'.$btkelas.'</td>
				<td valign="top">
				Rp.	<input name="'.$btkd.'nil_komite" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
				</td>
				</tr>';
				}
			while ($rowbt = mysql_fetch_assoc($qbt));

			echo '</table>

			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="jenis" type="hidden" value="'.$jenis.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}
		}




	//jika perawatan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "perawatan")
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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

			echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&jenis='.$jenis.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
			}
		while ($rowtp = mysql_fetch_assoc($qtp));

		echo '</select>
		</td>
		</tr>
		</table>';


		if (empty($tapelkd))
			{
			echo '<p>
			<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
			</p>';
			}
		else
			{
			//daftar kelas
			$qbt = mysql_query("SELECT * FROM m_kelas ".
									"ORDER BY no ASC");
			$rowbt = mysql_fetch_assoc($qbt);

			echo '<br>
			<table width="250" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warnaheader.'">
			<td width="50" valign="top"><strong>Tingkat</strong></td>
			<td valign="top"><strong>Nilai</strong></td>
			</tr>';


			do
				{
				//nilai
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

				$btkd = nosql($rowbt['kd']);
				$btno = nosql($rowbt['no']);
				$btkelas = balikin($rowbt['kelas']);


				//nilai uangnya...
				$qku = mysql_query("SELECT * FROM m_uang_perawatan ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$btkd'");
				$rku = mysql_fetch_assoc($qku);
				$tku = mysql_num_rows($qku);
				$ku_nilai = nosql($rku['nilai']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td valign="top">'.$btkelas.'</td>
				<td valign="top">
				Rp.	<input name="'.$btkd.'nil_komite" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
				</td>
				</tr>';
				}
			while ($rowbt = mysql_fetch_assoc($qbt));

			echo '</table>

			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="jenis" type="hidden" value="'.$jenis.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}
		}






	//jika lab.bahasa //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "lab")
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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

			echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&jenis='.$jenis.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
			}
		while ($rowtp = mysql_fetch_assoc($qtp));

		echo '</select>
		</td>
		</tr>
		</table>';


		if (empty($tapelkd))
			{
			echo '<p>
			<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
			</p>';
			}
		else
			{
			//daftar kelas
			$qbt = mysql_query("SELECT * FROM m_kelas ".
									"ORDER BY no ASC");
			$rowbt = mysql_fetch_assoc($qbt);

			echo '<br>
			<table width="250" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warnaheader.'">
			<td width="50" valign="top"><strong>Tingkat</strong></td>
			<td valign="top"><strong>Nilai</strong></td>
			</tr>';


			do
				{
				//nilai
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

				$btkd = nosql($rowbt['kd']);
				$btno = nosql($rowbt['no']);
				$btkelas = balikin($rowbt['kelas']);


				//nilai uangnya...
				$qku = mysql_query("SELECT * FROM m_uang_lab ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$btkd'");
				$rku = mysql_fetch_assoc($qku);
				$tku = mysql_num_rows($qku);
				$ku_nilai = nosql($rku['nilai']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td valign="top">'.$btkelas.'</td>
				<td valign="top">
				Rp.	<input name="'.$btkd.'nil_komite" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
				</td>
				</tr>';
				}
			while ($rowbt = mysql_fetch_assoc($qbt));

			echo '</table>

			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="jenis" type="hidden" value="'.$jenis.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}
		}




	//jika SIP//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "sip")
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		Per PSB Tahun Pelajaran : ';
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

			echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&jenis='.$jenis.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
			}
		while ($rowtp = mysql_fetch_assoc($qtp));

		echo '</select>
		</td>
		</tr>
		</table>';


		if (empty($tapelkd))
			{
			echo '<p>
			<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
			</p>';
			}
		else
			{
			//nilai uangnya...
			$qku = mysql_query("SELECT * FROM m_uang_pangkal ".
						"WHERE kd_tapel = '$tapelkd'");
			$rku = mysql_fetch_assoc($qku);
			$tku = mysql_num_rows($qku);
			$ku_nilai = nosql($rku['nilai']);

			echo '<p>
			Rp.	<input name="nil_sip" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
			</p>
			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="jenis" type="hidden" value="'.$jenis.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}
		}





	//jika OSIS //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "osis")
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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

			echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&jenis='.$jenis.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
			}
		while ($rowtp = mysql_fetch_assoc($qtp));

		echo '</select>
		</td>
		</tr>
		</table>';


		if (empty($tapelkd))
			{
			echo '<p>
			<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
			</p>';
			}
		else
			{
			//nilai uangnya...
			$qku = mysql_query("SELECT * FROM m_uang_osis ".
						"WHERE kd_tapel = '$tapelkd'");
			$rku = mysql_fetch_assoc($qku);
			$tku = mysql_num_rows($qku);
			$ku_nilai = nosql($rku['nilai']);

			echo '<p>
			Rp.	<input name="nil_osis" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
			</p>
			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="jenis" type="hidden" value="'.$jenis.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}
		}






	//jika syukuran  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "syukuran")
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
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

			echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&jenis='.$jenis.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
			}
		while ($rowtp = mysql_fetch_assoc($qtp));

		echo '</select>
		</td>
		</tr>
		</table>';


		if (empty($tapelkd))
			{
			echo '<p>
			<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
			</p>';
			}
		else
			{
			//nilai uangnya...
			$qku = mysql_query("SELECT * FROM m_uang_syukuran ".
						"WHERE kd_tapel = '$tapelkd'");
			$rku = mysql_fetch_assoc($qku);
			$tku = mysql_num_rows($qku);
			$ku_nilai = nosql($rku['nilai']);

			echo '<p>
			Rp.	<input name="nil_syukuran" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
			</p>
			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="jenis" type="hidden" value="'.$jenis.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}
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
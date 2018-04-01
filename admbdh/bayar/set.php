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
$smtkd = nosql($_REQUEST['smtkd']);
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
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);


	//deteksi uang lain...
	$qcc2 = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"WHERE kd = '$jnskd'");
	$rcc2 = mysql_fetch_assoc($qcc2);
	$tcc2 = mysql_num_rows($qcc2);

	//jika ada
	if ($tcc2 != 0)
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
			$xnlain = "nili_lain";
			$xnlain1 = "$ccx_kd$xnlain";
			$xnlainxx = nosql($_POST["$xnlain1"]);

			//cek
			$qcc = mysql_query("SELECT * FROM m_uang_lain ".
						"WHERE kd_jenis = '$jnskd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_kelas = '$ccx_kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya
			if ($tcc != 0)
				{
				///update
				mysql_query("UPDATE m_uang_lain SET nilai = '$xnlainxx' ".
						"WHERE kd_jenis = '$jnskd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_kelas = '$ccx_kd'");
				}
			else
				{
				//baru
				mysql_query("INSERT INTO m_uang_lain (kd, kd_jenis, kd_tapel, kd_smt, kd_kelas, nilai) VALUES ".
						"('$xyz', '$jnskd', '$tapelkd', '$smtkd', '$ccx_kd', '$xnlainxx')");
				}
			}
		while ($rccx = mysql_fetch_assoc($qccx));
		}

	else
		{
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
				$xnkomite = "nil_komite";
				$xnkomite1 = "$ccx_kd$xnkomite";
				$xnkomitexx = nosql($_POST["$xnkomite1"]);

				//cek
				$qcc = mysql_query("SELECT * FROM m_uang_komite ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$ccx_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek iya
				if ($tcc != 0)
					{
					///update
					mysql_query("UPDATE m_uang_komite SET nilai = '$xnkomitexx' ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_kelas = '$ccx_kd'");
					}
					else
					{
					//baru
					mysql_query("INSERT INTO m_uang_komite (kd, kd_tapel, kd_kelas, nilai) VALUES ".
									"('$xyz', '$tapelkd', '$ccx_kd', '$xnkomitexx')");
					}
				}
			while ($rccx = mysql_fetch_assoc($qccx));
			}



		//cek SPI ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($jnskd == "spi")
			{
			//nilai
			$nil_spi = nosql($_POST['nil_spi']);


			//cek
			$qcc = mysql_query("SELECT * FROM m_uang_spi ".
									"WHERE kd_tapel = '$tapelkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya
			if ($tcc != 0)
				{
				///update
				mysql_query("UPDATE m_uang_spi SET nilai = '$nil_spi' ".
								"WHERE kd_tapel = '$tapelkd'");
				}
			else
				{
				//baru
				mysql_query("INSERT INTO m_uang_spi (kd, kd_tapel, nilai) VALUES ".
								"('$x', '$tapelkd', '$nil_spi')");
				}
			}




		//cek les /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($jnskd == "les")
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
				$xnles = "nil_les";
				$xnles1 = "$ccx_kd$xnles";
				$xnlesxx = nosql($_POST["$xnles1"]);

				//cek
				$qcc = mysql_query("SELECT * FROM m_uang_les ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$ccx_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek iya
				if ($tcc != 0)
					{
					///update
					mysql_query("UPDATE m_uang_les SET nilai = '$xnlesxx' ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_kelas = '$ccx_kd'");
					}
					else
					{
					//baru
					mysql_query("INSERT INTO m_uang_les (kd, kd_tapel, kd_kelas, nilai) VALUES ".
									"('$xyz', '$tapelkd', '$ccx_kd', '$xnlesxx')");
					}
				}
			while ($rccx = mysql_fetch_assoc($qccx));
			}
		}




	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?jnskd=$jnskd&jenis=$jenis&tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/admbdh.php");

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
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Jenis Keuangan : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$jenis.'" selected>'.$jenis.'</option>
<option value="'.$filenya.'?jnskd=komite&jenis=Uang Komite">Uang Komite</option>';

//keuangan lain
$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
			"ORDER BY nama ASC");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);

//jika ada
if ($tdt != 0)
	{
        do
		{
		$dt_kd = nosql($rdt['kd']);
		$dt_nama = balikin($rdt['nama']);

		echo '<option value="'.$filenya.'?jnskd='.$dt_kd.'&jenis='.$dt_nama.'">'.$dt_nama.'</option>';
		}
	while ($rdt = mysql_fetch_assoc($qdt));
	}

echo '</select>
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
	//deteksi uang lain... ////////////////////////////////////////////////////////////////////////////////
	$qcc2 = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"WHERE kd = '$jnskd'");
	$rcc2 = mysql_fetch_assoc($qcc2);
	$tcc2 = mysql_num_rows($qcc2);

	//jika ada
	if ($tcc2 != 0)
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

		echo '</select>,

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

			echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&jenis='.$jenis.'&tapelkd='.$tapelkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
			}
		while ($rowst = mysql_fetch_assoc($qst));

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

		else if (empty($smtkd))
			{
			echo '<p>
			<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
			</p>';
			}

		else
			{
			//daftar kelas
			$qbt = mysql_query("SELECT * FROM m_kelas ".
									"ORDER BY round(no) ASC, ".
									"kelas ASC");
			$rowbt = mysql_fetch_assoc($qbt);

			echo '<br>
			<table width="250" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warnaheader.'">
			<td width="50" valign="top"><strong>Kelas</strong></td>
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
				$btkelas = nosql($rowbt['kelas']);


				//nilai uangnya...
				$qku = mysql_query("SELECT * FROM m_uang_lain ".
							"WHERE kd_jenis = '$jnskd' ".
							"AND kd_tapel = '$tapelkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_kelas = '$btkd'");
				$rku = mysql_fetch_assoc($qku);
				$tku = mysql_num_rows($qku);
				$ku_nilai = nosql($rku['nilai']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td valign="top">'.$btkelas.'</td>
				<td valign="top">
				Rp.	<input name="'.$btkd.'nili_lain" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
				</td>
				</tr>';
				}
			while ($rowbt = mysql_fetch_assoc($qbt));

			echo '</table>

			<input name="jnskd" type="hidden" value="'.$jnskd.'">
			<input name="jenis" type="hidden" value="'.$jenis.'">
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="smtkd" type="hidden" value="'.$smtkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">';
			}
		}

	else
		{
		//jika komite //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
										"ORDER BY round(no) ASC, ".
										"kelas ASC");
				$rowbt = mysql_fetch_assoc($qbt);

				echo '<br>
				<table width="250" border="1" cellpadding="3" cellspacing="0">
				<tr bgcolor="'.$warnaheader.'">
				<td width="50" valign="top"><strong>Kelas</strong></td>
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
					$btkelas = nosql($rowbt['kelas']);


					//nilai uangnya...
					$qku = mysql_query("SELECT * FROM m_uang_komite ".
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



		//jika SPI //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($jnskd == "spi")
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
				$qku = mysql_query("SELECT * FROM m_uang_spi ".
										"WHERE kd_tapel = '$tapelkd'");
				$rku = mysql_fetch_assoc($qku);
				$tku = mysql_num_rows($qku);
				$ku_nilai = nosql($rku['nilai']);

				echo '<p>
				Rp.	<input name="nil_spi" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
				</p>
				<input name="jnskd" type="hidden" value="'.$jnskd.'">
				<input name="jenis" type="hidden" value="'.$jenis.'">
				<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
				<input name="btnSMP" type="submit" value="SIMPAN">
				<input name="btnBTL" type="submit" value="BATAL">';
				}
			}



		//jika les ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		else if ($jnskd == "les")
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
				<td width="50" valign="top"><strong>Kelas</strong></td>
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
					$btkelas = nosql($rowbt['kelas']);


					//nilai uangnya...
					$qku = mysql_query("SELECT * FROM m_uang_les ".
											"WHERE kd_tapel = '$tapelkd' ".
											"AND kd_kelas = '$btkd'");
					$rku = mysql_fetch_assoc($qku);
					$tku = mysql_num_rows($qku);
					$ku_nilai = nosql($rku['nilai']);

					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
					echo '<td valign="top">'.$btkelas.'</td>
					<td valign="top">
					Rp.	<input name="'.$btkd.'nil_les" type="text" size="10" value="'.$ku_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,00
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
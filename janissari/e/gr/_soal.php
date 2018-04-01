<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL JANISSARI                          ///////
/////// (customization)                             ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh :                               ///////
/////// Agus Muhajir, S.Kom                         ///////
/////// URL     :                                   ///////
///////     *http://sisfokol.wordpress.com          ///////
//////      *http://hajirodeon.wordpress.com        ///////
/////// E-Mail  :                                   ///////
///////     * hajirodeon@yahoo.com                  ///////
///////     * hajirodeon@gmail.com                  ///////
/////// HP/SMS  : 081-829-88-54                     ///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////



session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_gr.php");
require("../../../inc/class/paging.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$gmkd = nosql($_REQUEST['gmkd']);
$katkd = nosql($_REQUEST['katkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$filenya = "soal.php?gmkd=$gmkd&page=$page";


//focus...
if (empty($a))
	{
	$diload = "document.formx.judulx.focus();";
	}

else if ($a == "baru")
	{
	$diload = "document.formx.dt_no.focus();";
	}




//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}





//jika batal, entry soal baru
if ($_POST['btnBTL2'])
	{
	//nilai
	$a = nosql($_POST['a']);
	$katkd = nosql($_POST['katkd']);
	$page = nosql($_POST['page']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya&a=detail&katkd=$katkd";
	xloc($ke);
	exit();
	}





//nek edit
if ($s == "edit")
	{
	//nilai
	$katkd = nosql($_REQUEST['katkd']);

	//query
	$qnil = mysql_query("SELECT guru_mapel.*, guru_mapel_soal.* ".
							"FROM guru_mapel, guru_mapel_soal ".
							"WHERE guru_mapel_soal.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd = '$gmkd' ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel_soal.kd = '$katkd'");
	$rnil = mysql_fetch_assoc($qnil);
	$y_judulx = balikin($rnil['judul']);
	$y_bobot = nosql($rnil['bobot']);
	$y_waktu = nosql($rnil['waktu']);
	$y_status = nosql($rnil['status']);
	$y_postdate = $rnil['postdate'];
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$jml = nosql($_POST['jml']);
	$gmkd = nosql($_POST['gmkd']);
	$page = nosql($_POST['page']);


	for ($i=1;$i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);


		//del detail
		mysql_query("DELETE FROM guru_mapel_soal_detail ".
						"WHERE kd_guru_mapel_soal = '$kd'");

		//del data
		mysql_query("DELETE FROM guru_mapel_soal ".
						"WHERE kd_guru_mapel = '$gmkd' ".
						"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$gmkd = nosql($_POST['gmkd']);
	$katkd = nosql($_POST['katkd']);
	$judulx = cegah($_POST['judulx']);
	$bobot = nosql($_POST['bobot']);
	$waktu = nosql($_POST['waktu']);
	$status = nosql($_POST['status']);
	$page = nosql($_POST['page']);

	//nek null
	if ((empty($judulx)) OR (empty($waktu)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//nek edit
		if ($s == "edit")
			{
			//update
			mysql_query("UPDATE guru_mapel_soal SET judul = '$judulx', ".
							"bobot = '$bobot', ".
							"waktu = '$waktu', ".
							"status = '$status', ".
							"postdate = '$today' ".
							"WHERE kd_guru_mapel = '$gmkd' ".
							"AND kd = '$katkd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}





		//nek baru
		if (empty($s))
			{
			//cek
			$qcc = mysql_query("SELECT guru_mapel_soal.*, guru_mapel.* ".
									"FROM guru_mapel_soal, guru_mapel ".
									"WHERE guru_mapel_soal.kd_guru_mapel = '$gmkd' ".
									"AND guru_mapel.kd_user = '$kd1_session' ".
									"AND guru_mapel_soal.judul = '$judulx'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Ditemukan Duplikasi Judul Soal. Silahkan Diganti...!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//insert data
				mysql_query("INSERT INTO guru_mapel_soal(kd, kd_guru_mapel, judul, bobot, waktu, status, postdate) VALUES ".
								"('$x', '$gmkd', '$judulx', '$bobot', '$waktu', '$status', '$postdate')");

				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}
		}
	}





//jika simpan soal baru/edit
if ($_POST['btnSMP2'])
	{
	//ambil nilai
	$gmkd = nosql($_POST['gmkd']);
	$katkd = nosql($_POST['katkd']);
	$solkd = nosql($_POST['solkd']);
	$a = nosql($_POST['a']);
	$s = nosql($_POST['s']);
	$dt_no = nosql($_POST['dt_no']);
	$editor = cegah2($_POST['editor']);
	$kunci = nosql($_POST['kunci']);
	$page = nosql($_POST['page']);

	//cek entry
	if ((empty($dt_no)) OR (empty($editor)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya&katkd=$katkd&$solkd=$solkd&a=baru";
		pekem($pesan,$ke);
		exit();
		}

	else
		{
		//jika edit
		if ($a == "edit")
			{
			//insert
			mysql_query("UPDATE guru_mapel_soal_detail SET no = '$dt_no', ".
							"soal = '$editor', ".
							"kunci = '$kunci', ".
							"postdate = '$today'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya&katkd=$katkd&a=detail";
			xloc($ke);
			exit();
			}

		//jika baru
		else if ($a == "baru")
			{
			//cek nomor soal
			$qcc = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
									"WHERE kd_guru_mapel_soal = '$katkd' ".
									"AND no = '$dt_no'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//jika iya
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Soal Dengan Nomor Soal Tersebut, Telah Ada. Silahkan Diganti...!!";
				$ke = "$filenya&katkd=$katkd&$solkd=$solkd&a=baru";
				pekem($pesan,$ke);
				exit();
				}

			//jika tidak
			else
				{
				//insert
				mysql_query("INSERT INTO guru_mapel_soal_detail(kd, kd_guru_mapel_soal, no, soal, kunci, postdate) VALUES ".
								"('$solkd', '$katkd', '$dt_no', '$editor', '$kunci', '$today')");

				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya&katkd=$katkd&a=detail";
				xloc($ke);
				exit();
				}
			}
		}
	}




//jika bikin soal baru
if ($_POST['btnBR'])
	{
	//nilai
	$katkd = nosql($_POST['katkd']);
	$gmkd = nosql($_POST['gmkd']);
	$page = nosql($_POST['page']);

	//bikin folder, katkd //////////////////////////////////////////
	$path1 = "../../../filebox/e/soal/$katkd";

	//cek, sudah ada belum
	if (!file_exists($path1))
		{
		mkdir("$path1", $chmod);
		}


	//bikin folder, solkd //////////////////////////////////////////
	$path2 = "../../../filebox/e/soal/$katkd/$x";

	//cek, sudah ada belum
	if (!file_exists($path2))
		{
		mkdir("$path2", $chmod);
		}


	//re-direct
	$ke = "$filenya&katkd=$katkd&solkd=$x&a=baru";
	xloc($ke);
	exit();
	}




//jika hapus soal
if ($s == "hapus")
	{
	//nilai
	$katkd = nosql($_REQUEST['katkd']);
	$gmkd = nosql($_REQUEST['gmkd']);
	$a = nosql($_REQUEST['a']);
	$solkd = nosql($_REQUEST['solkd']);
	$page = nosql($_REQUEST['page']);

	//hapus
	mysql_query("DELETE FROM guru_mapel_soal_detail ".
					"WHERE kd_guru_mapel_soal = '$katkd' ".
					"AND kd = '$solkd'");

	//re-direct
	$ke = "$filenya&a=detail&katkd=$katkd";
	xloc($ke);
	exit();
	}





//jika ke daftar judul/topik/bab
if ($_POST['btnDF'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);
	$page = nosql($_POST['page']);

	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/openwindow.js");
require("../../../inc/js/swap.js");
require("../../../inc/js/checkall.js");
require("../../../inc/js/number.js");
require("../../../inc/js/editor.js");
require("../../../inc/menu/janissari.php");


//view : guru ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika belum pilih mapel
if (empty($gmkd))
	{
	//re-direct
	$ke = "mapel.php";
	xloc($ke);
	exit();
	}

//nek mapel telah dipilih
else
	{
	//mapel-nya...
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.* ".
							"FROM guru_mapel, m_mapel ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);


	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "soal.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> Soal";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td width="100">
		<p>
		<big><strong>:::Soal...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>';


		//jika baru / edit //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if (($a == "baru") OR ($a == "edit"))
			{
			//nilai
			$katkd = nosql($_REQUEST['katkd']);
			$gmkd = nosql($_REQUEST['gmkd']);
			$solkd = nosql($_REQUEST['solkd']);
			$page = nosql($_REQUEST['page']);

			//soalnya...
			$qtuj = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
									"WHERE kd_guru_mapel_soal = '$katkd' ".
									"AND kd = '$solkd'");
			$rtuj = mysql_fetch_assoc($qtuj);
			$tuj_no = nosql($rtuj['no']);
			$tuj_soal = pathasli2(balikin($rtuj['soal']));
			$tuj_kunci = nosql($rtuj['kunci']);



			//view
			echo '<strong>No. Soal : </strong>
			<input name="dt_no" type="text" value="'.$tuj_no.'" size="3" maxlength="3" onKeyPress="return numbersonly(this, event)">
			<br>
			<br>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td>
			<strong>Isi Soal (Disertai Opsinya : A, B, C, D, E) :</strong>
			</td>
			<td align="right">
			<input name="btnUPL" type="button" value="FileBox Image & Video >>"OnClick="javascript:MM_openBrWindow(\'soal_filebox.php?katkd='.$katkd.'&solkd='.$solkd.'\',\'FileBOX Image (.jpg) :\',\'width=650,height=300,toolbar=no,menubar=no,location=no,scrollbars=yes,resize=no\')">
			</td>
			</tr>
			</table>
			<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$tuj_soal.'</textarea>
			<br>
			<br>

			<strong>Kunci Jawaban :</strong>
			<br>
			<select name="kunci">
			<option value="'.$tuj_kunci.'" selected>'.$tuj_kunci.'</option>
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
			<option value="D">D</option>
			<option value="E">E</option>
			</select>
			<br>
			<br>

			<input name="a" type="hidden" value="'.$a.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="katkd" type="hidden" value="'.$katkd.'">
			<input name="gmkd" type="hidden" value="'.$gmkd.'">
			<input name="solkd" type="hidden" value="'.$solkd.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="btnSMP2" type="submit" value="SIMPAN">
			<input name="btnBTL2" type="submit" value="BATAL">';
			}



		//jika detail topik/judul, alias daftar soalnya... //////////////////////////////////////////////////////////////////////////////
		else if ($a == "detail")
			{
			//nilai
			$katkd = nosql($_REQUEST['katkd']);
			$gmkd = nosql($_REQUEST['gmkd']);
			$solkd = nosql($_REQUEST['solkd']);
			$page = nosql($_REQUEST['page']);

			//query
			$qdt = mysql_query("SELECT * FROM guru_mapel_soal ".
									"WHERE kd_guru_mapel = '$gmkd' ".
									"AND kd = '$katkd'");
			$rdt = mysql_fetch_assoc($qdt);
			$tdt = mysql_num_rows($qdt);
			$dt_kd = nosql($rdt['kd']);
			$dt_judul = balikin($rdt['judul']);
			$dt_bobot = nosql($rdt['bobot']);
			$dt_waktu = nosql($rdt['waktu']);
			$dt_status = nosql($rdt['status']);

			//jika true
			if ($dt_status == "true")
				{
				$dt_statusx = "<font color=\"blue\">AKTIF</font>";
				}
			//false
			else if ($dt_status == "false")
				{
				$dt_statusx = "Tidak Aktif";
				}



			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT * FROM guru_mapel_soal_detail ".
								"WHERE kd_guru_mapel_soal = '$dt_kd' ".
								"ORDER BY round(no) ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya&a=detail&katkd=$katkd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);

			echo '<table width="950" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td>
			Judul/Topik/Bab :
			<strong>'.$dt_judul.'</strong>
			<br>

			Bobot per Soal :
			<strong>'.$dt_bobot.'</strong>
			<br>

			Waktu Maksimal Mengerjakan :
			<strong>'.$dt_waktu.'</strong> Menit.
			<br>

			Status :
			<strong>'.$dt_statusx.'</strong>
			</td>
			</tr>
			</table>
			<input name="a" type="hidden" value="'.$a.'">
			<input name="gmkd" type="hidden" value="'.$gmkd.'">
			<input name="katkd" type="hidden" value="'.$katkd.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="btnBR" type="submit" value="Buat Soal Baru">
			<input name="btnDF" type="submit" value="Daftar Judul/Topik/Bab">
			<br>
			<br>';

			//jika ada
			if ($count != 0)
				{
				echo '<table width="950" border="1" cellpadding="3" cellspacing="0">
				<tr bgcolor="'.$e_warnaheader.'">
				<td><strong>No.</strong></td>
				<td><strong>Soal</strong></td>
				</tr>';

				do
					{
					//nilai
					$d_kd = nosql($data['kd']);
					$d_no = nosql($data['no']);
					$d_soal = balikin2($data['soal']);
					$d_kunci = nosql($data['kunci']);
					$d_postdate = $data['postdate'];

					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td width="10" valign="top">
					<strong>'.$d_no.'</strong>.
					</td>
					<td valign="top">
					'.$d_soal.'
					<br>
					<br>

					[Kunci Jawaban : <strong>'.$d_kunci.'</strong>].
					[<a href="'.$filenya.'&a=edit&katkd='.$katkd.'&solkd='.$d_kd.'" title="Edit..."><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>].
					[<a href="'.$filenya.'&a=detail&katkd='.$katkd.'&solkd='.$d_kd.'&s=hapus" title="Hapus..."><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>].
					[Postdate : <em>'.$d_postdate.'</em>]
					</td>
					</tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="950" border="0" cellpadding="3" cellspacing="0">
				<tr>
				<td align="right">
				<font color="blue"><strong>'.$count.'</strong></font> Data Soal
				'.$pagelist.'</td>
				</tr>
				</table>';
				}

			//tidak ada
			else
				{
				echo '<font color="blue"><strong>Belum Ada Soal. Silakan Buat Soal Dahulu...!!</strong></font>';
				}
			}


		//jika daftar topik/judul ///////////////////////////////////////////////////////////////////////////////////////////////////////
		else
			{
			//jika true
			if ($y_status == "true")
				{
				$y_statusx = "AKTIF";
				}
			//false
			else if ($y_status == "false")
				{
				$y_statusx = "Tidak Aktif";
				}

			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td>
			<strong>Judul/Topik/Bab : </strong>
			<br>
			<input name="judulx" type="text" value="'.$y_judulx.'" size="50">
			<br>
			<br>

			<strong>Bobot per Soal : </strong>
			<br>
			<input name="bobot" type="text" value="'.$y_bobot.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
			<br>
			<br>

			<strong>Waktu Maksimal Mengerjakan : </strong>
			<br>
			<input name="waktu" type="text" value="'.$y_waktu.'" size="3" maxlength="3" onKeyPress="return numbersonly(this, event)" '.$x_enter.'> Menit.
			<br>
			<br>

			<strong>Status : </strong>
			<br>
			<select name="status">
			<option value="'.$y_status.'" selected>'.$y_statusx.'</option>
			<option value="true">AKTIF</option>
			<option value="false">Tidak Aktif</option>
			</select>


			<input name="gmkd" type="hidden" value="'.$gmkd.'">
			<input name="katkd" type="hidden" value="'.$katkd.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">
			</td>
			</tr>
			</table>
			<br>';

			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT guru_mapel.*, guru_mapel_soal.*, guru_mapel_soal.kd AS katkd ".
							"FROM guru_mapel, guru_mapel_soal ".
							"WHERE guru_mapel_soal.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel.kd = '$gmkd' ".
							"ORDER BY guru_mapel_soal.judul ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = $filenya;
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//nek ada
			if ($count != 0)
				{
				echo '<table width="900" border="1" cellpadding="3" cellspacing="0">
				<tr bgcolor="'.$e_warnaheader.'">
				<td width="1">&nbsp;</td>
				<td width="1">&nbsp;</td>
				<td valign="top"><strong>Judul/Topik/Bab</strong></td>
				<td width="100" valign="top"><strong>Bobot per Soal</strong></td>
				<td width="100" valign="top"><strong>Waktu</strong></td>
				<td width="100" valign="top"><strong>Status</strong></td>
				<td width="100" valign="top"><strong>Soal</strong></td>
				<td width="100" valign="top"><strong>Nilai Siswa</strong></td>
				</tr>';

				do
			  		{
					if ($warna_set ==0)
						{
						$warna = $e_warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $e_warna02;
						$warna_set = 0;
						}

					$nomer = $nomer + 1;

					$katkd = nosql($data['katkd']);
					$judulx = balikin($data['judul']);
					$bobot = nosql($data['bobot']);
					$waktu = nosql($data['waktu']);
					$status = nosql($data['status']);

					//jika true
					if ($status == "true")
						{
						$statusx = "<font color=\"blue\">AKTIF</font>";
						}
					//false
					else if ($status == "false")
						{
						$statusx = "Tidak Aktif";
						}


					//jml. soal
					$qju = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
											"WHERE kd_guru_mapel_soal = '$katkd'");
					$rju = mysql_fetch_assoc($qju);
					$tju = mysql_num_rows($qju);
					$jml_soal = $tju;


					//jml. siswa yang ikut test online
					$qsto = mysql_query("SELECT * FROM siswa_mapel_soal ".
											"WHERE kd_guru_mapel = '$gmkd' ".
											"AND kd_guru_mapel_soal = '$katkd'");
					$rsto = mysql_fetch_assoc($qsto);
					$tsto = mysql_num_rows($qsto);
					$jml_siswa = $tsto;



					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td width="1">
					<input name="kd'.$nomer.'" type="hidden" value="'.$katkd.'">
					<input type="checkbox" name="item'.$nomer.'" value="'.$katkd.'">
					</td>
					<td width="1">
					<a href="'.$filenya.'&s=edit&katkd='.$katkd.'" title="Edit Judul/Topik/Bab : '.$judulx.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
					</td>
					<td valign="top">
					'.$judulx.'
					</td>
					<td valign="top">
					<strong>'.$bobot.'</strong>
					</td>
					<td valign="top">
					<strong>'.$waktu.'</strong> Menit.
					</td>
					<td valign="top">
					<strong>'.$statusx.'</strong>
					</td>
					<td valign="top">
					[<strong>'.$jml_soal.'</strong> Soal].
					[<a href="'.$filenya.'&a=detail&katkd='.$katkd.'" title="Edit Soal : '.$judulx.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>].
					</td>
					<td valign="top">
					[<strong>'.$jml_siswa.'</strong> Siswa]
					[<a href="soal_siswa.php?gmkd='.$gmkd.'&katkd='.$katkd.'" title="Daftar Nilai Siswa Yang Ikut Test Online : '.$judulx.'"><img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>].
					</td>
					</tr>';
			  		}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="900" border="0" cellspacing="0" cellpadding="3">
			    	<tr>
				<td width="250">
				<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
				<input name="btnBTL" type="reset" value="BATAL">
				<input name="btnHPS" type="submit" value="HAPUS">
				<input name="jml" type="hidden" value="'.$count.'">
				<input name="s" type="hidden" value="'.$s.'">
				<input name="page" type="hidden" value="'.$page.'">
				</td>
				<td align="right"><font color="blue"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
			    	</tr>
				</table>';
				}
			else
				{
				echo '<font color="blue"><strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong></font>';
				}
			}
		}

	//jika tidak
	else
		{
		//re-direct
		$pesan = "Silahkan Lihat Daftar Mata Pelajaran.";
		$ke = "mapel.php";
		pekem($pesan,$ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
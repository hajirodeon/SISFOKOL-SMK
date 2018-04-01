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
$kelkd = nosql($_REQUEST['kelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$filenya = "soal_siswa.php?gmkd=$gmkd&page=$page";





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika ke daftar judul/topik/bab
if ($_POST['btnDF'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);

	//re-direct
	$ke = "soal.php?gmkd=$gmkd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
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
		$filenya = "soal_siswa.php?gmkd=$gmkd&katkd=$katkd";
		$judul = "E-Learning : $pel_nm --> Daftar Siswa Yang Ikut Test Online";
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
		<big><strong>:::Daftar Siswa Yang Ikut Test Online...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>';

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



		//query siswa yang ikut test online
		$p = new Pager();
		$start = $p->findStart($limit);


		//jika ada query kelas
		if (!empty($kelkd))
			{
			$sqlcount = "SELECT siswa_mapel_soal.*, siswa_mapel_soal.kd AS mskd, ".
					"m_user.*, m_user.kd AS mukd, m_kelas.* ".
					"FROM siswa_mapel_soal, m_user, m_kelas ".
					"WHERE siswa_mapel_soal.kd_user = m_user.kd ".
					"AND m_user.kd_kelas = m_kelas.kd ".
					"AND m_kelas.kd = '$kelkd' ".
					"AND siswa_mapel_soal.kd_guru_mapel = '$gmkd' ".
					"AND siswa_mapel_soal.kd_guru_mapel_soal = '$katkd' ".
					"ORDER BY round(m_user.nomor) ASC";
			$sqlresult = $sqlcount;
			}
		else
			{
			$sqlcount = "SELECT siswa_mapel_soal.*, siswa_mapel_soal.kd AS mskd, ".
					"m_user.*, m_user.kd AS mukd ".
					"FROM siswa_mapel_soal, m_user ".
					"WHERE siswa_mapel_soal.kd_user = m_user.kd ".
					"AND siswa_mapel_soal.kd_guru_mapel = '$gmkd' ".
					"AND siswa_mapel_soal.kd_guru_mapel_soal = '$katkd' ".
					"ORDER BY round(m_user.nomor) ASC";
			$sqlresult = $sqlcount;
			}

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = $filenya;
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);

		echo '<table width="950" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		Judul/Topik/Bab :
		<strong>'.$dt_judul.'</strong>
		<br>

		Bobot :
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
		<input name="gmkd" type="hidden" value="'.$gmkd.'">
		<input name="btnDF" type="submit" value="Daftar Judul/Topik/Bab">
		<br>
		<br>

		Kelas : ';

		echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

		//terpilih
		$qbtx = mysql_query("SELECT * FROM m_kelas ".
								"WHERE kd = '$kelkd'");
		$rowbtx = mysql_fetch_assoc($qbtx);
		$btxkd = nosql($rowbtx['kd']);
		$btxkelas = nosql($rowbtx['kelas']);

		echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

		$qbt = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd <> '$kelkd' ".
					"ORDER BY kelas ASC");
		$rowbt = mysql_fetch_assoc($qbt);

		do
			{
			$btkd = nosql($rowbt['kd']);
			$btkelas = nosql($rowbt['kelas']);

			echo '<option value="'.$filenya.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
			}
		while ($rowbt = mysql_fetch_assoc($qbt));

		echo '</select>


		[<a href="soal_siswa_pdf.php?gmkd='.$gmkd.'&katkd='.$katkd.'&kelkd='.$kelkd.'" target="_blank" title="Rekap PDF"><img src="'.$sumber.'/img/pdf.gif" width="16" height="16" border="0"></a>].';

		//jika ada
		if ($count != 0)
			{
			echo '<table width="950" border="1" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$e_warnaheader.'">
			<td><strong>Siswa</strong></td>
			<td width="50"><strong>Kelas</strong></td>
			<td width="50"><strong>Jml. Soal</strong></td>
			<td width="100"><strong>Jml. Soal Yang Dikerjakan</strong></td>
			<td width="100"><strong>Jml. Jawaban Benar</strong></td>
			<td width="100"><strong>Jml. Jawaban Salah</strong></td>
			<td width="100"><strong>Mulai Pengerjaan</strong></td>
			<td width="100"><strong>Selesai Pengerjaan</strong></td>
			<td width="50"><strong>Skor</strong></td>
			</tr>';

			do
				{
				//nilai
				$d_mskd = nosql($data['mskd']);
				$d_kelkd = nosql($data['kd_kelas']);
				$d_mukd = nosql($data['mukd']);
				$d_no = nosql($data['nomor']);
				$d_nama = balikin($data['nama']);


				//jumlah soal
				$qsol = mysql_query("SELECT guru_mapel_soal.*, guru_mapel_soal_detail.* ".
										"FROM guru_mapel_soal, guru_mapel_soal_detail ".
										"WHERE guru_mapel_soal_detail.kd_guru_mapel_soal = guru_mapel_soal.kd ".
										"AND guru_mapel_soal.kd_guru_mapel = '$gmkd' ".
										"AND guru_mapel_soal.kd = '$katkd'");
				$rsol = mysql_fetch_assoc($qsol);
				$tsol = mysql_num_rows($qsol);


				//soal yang dikerjakan
				$qsyd = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
										"WHERE kd_user = '$d_mukd' ".
										"AND kd_guru_mapel = '$gmkd' ".
										"AND kd_guru_mapel_soal = '$katkd'");
				$rsyd = mysql_fetch_assoc($qsyd);
				$tsyd = mysql_num_rows($qsyd);


				//jml. jawaban BENAR
				$qju = mysql_query("SELECT siswa_mapel_soal_detail.*, guru_mapel_soal_detail.* ".
										"FROM siswa_mapel_soal_detail, guru_mapel_soal_detail ".
										"WHERE siswa_mapel_soal_detail.kd_guru_mapel_soal_detail = guru_mapel_soal_detail.kd ".
										"AND siswa_mapel_soal_detail.kd_user = '$d_mukd' ".
										"AND siswa_mapel_soal_detail.kd_guru_mapel = '$gmkd' ".
										"AND siswa_mapel_soal_detail.kd_guru_mapel_soal = '$katkd' ".
										"AND siswa_mapel_soal_detail.jawab = guru_mapel_soal_detail.kunci");
				$rju = mysql_fetch_assoc($qju);
				$tju = mysql_num_rows($qju);


				//jml. jawaban SALAH
				$tsalah = round($tsyd - $tju);

				//waktu mulai dan akhir
				$qjux = mysql_query("SELECT * FROM siswa_mapel_soal ".
										"WHERE kd_user = '$d_mukd' ".
										"AND kd_guru_mapel = '$gmkd' ".
										"AND kd_guru_mapel_soal = '$katkd'");
				$rjux = mysql_fetch_assoc($qjux);
				$wk_mulai = $rjux['waktu_mulai'];
				$wk_akhir = $rjux['waktu_akhir'];

				//skor
				$t_skor = round($tju * $dt_bobot);





				//kelas e
				$qkel = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$d_kelkd'");
				$rkel = mysql_fetch_assoc($qkel);
				$i_kelas = balikin($rkel['kelas']);


				//jika null
				if (empty($i_kelas))
					{
					$i_kelas = "-";
					}

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td valign="top">
				'.$d_no.'. '.$d_nama.'
				</td>
				<td valign="top">
				'.$i_kelas.'
				</td>
				<td valign="top">
				'.$tsol.'
				</td>
				<td valign="top">
				'.$tsyd.'
				</td>
				<td valign="top">
				'.$tju.'
				</td>
				<td valign="top">
				'.$tsalah.'
				</td>
				<td valign="top">
				'.$wk_mulai.'
				</td>
				<td valign="top">
				'.$wk_akhir.'
				</td>
				<td valign="top">
				'.$t_skor.'
				</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</table>
			<table width="950" border="0" cellpadding="3" cellspacing="0">
			<tr>
			<td align="right">
			<font color="blue"><strong>'.$count.'</strong></font> Siswa
			'.$pagelist.'
			</td>
			</tr>
			</table>';
			}

		//tidak ada
		else
			{
			echo '<p>
			<font color="blue"><strong>Tidak Ada Siswa Yang Mengerjakan. Mungkin Lain Waktu.</strong></font>
			</p>';
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
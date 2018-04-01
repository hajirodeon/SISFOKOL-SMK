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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admpiket.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pegawai.php";
$judul = "Absensi Pegawai";
$judulku = "[$piket_session : $nip33_session.$nm33_session] ==> $judul";
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);

$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}



//ke daftar pegawai
if ($_POST['btnDF'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$kd = nosql($_POST['kd']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tkhir = nosql($_POST['tkhir']);


	//looping
	for ($p=1;$p<=$tkhir;$p++)
		{
		$xijam = "ijam";
		$xijam1 = "$xijam$p";
		$xijamxx = nosql($_POST["$xijam1"]);

		$ximnt = "imnt";
		$ximnt1 = "$ximnt$p";
		$ximntxx = nosql($_POST["$ximnt1"]);

		$xiabs = "iabs";
		$xiabs1 = "$xiabs$p";
		$xiabsxx = nosql($_POST["$xiabs1"]);

		$xiperlu = "iperlu";
		$xiperlu1 = "$xiperlu$p";
		$xiperluxx = cegah($_POST["$xiperlu1"]);


		//khusus
		$tgl_abs = "$uthn:$ubln:$p";
		$jam_abs = "$xijamxx:$ximntxx";


		//cek
		$qcc = mysql_query("SELECT * FROM pegawai_absensi ".
								"WHERE kd_pegawai = '$kd' ".
								"AND round(DATE_FORMAT(tgl, '%d')) = '$p' ".
								"AND round(DATE_FORMAT(tgl, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(tgl, '%Y')) = '$uthn'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_sakd = nosql($rcc['kd']);
		$cc_abskd = nosql($rcc['kd_absensi']);



		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE pegawai_absensi SET kd_absensi = '$xiabsxx', ".
							"jam = '$jam_abs', ".
							"keperluan = '$xiperluxx', ".
							"postdate = '$today' ".
							"WHERE kd = '$cc_sakd'");
			}
		else
			{
			//insert
			$xx = md5("$x$p");

			mysql_query("INSERT INTO pegawai_absensi(kd, kd_pegawai, kd_absensi, tgl, jam, keperluan, postdate) VALUES ".
							"('$xx', '$kd', '$xiabsxx', '$tgl_abs', '$jam_abs', '$xiperluxx', '$today')");
			}
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?s=absensi&kd=$kd&ubln=$ubln&uthn=$uthn";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////











//isi *START
ob_start();

//menu
require("../../inc/menu/admpiket.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();


//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?crkd=cr01&crtipe=NIP&kunci='.$kunci.'">NIP</option>
<option value="'.$filenya.'?crkd=cr02&crtipe=NUPTK&kunci='.$kunci.'">NUPTK</option>
<option value="'.$filenya.'?crkd=cr03&crtipe=Kode&kunci='.$kunci.'">Kode</option>
<option value="'.$filenya.'?crkd=cr04&crtipe=No.Karpeg&kunci='.$kunci.'">No.Karpeg</option>
<option value="'.$filenya.'?crkd=cr05&crtipe=Nama&kunci='.$kunci.'">Nama</option>
</select>
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="btnCARI" type="submit" value="CARI >>">
<input name="btnRST" type="submit" value="RESET">


<input name="s" type="hidden" value="'.$s.'">
<input name="kd" type="hidden" value="'.$kd.'">
<input name="ubln" type="hidden" value="'.$ubln.'">
<input name="uthn" type="hidden" value="'.$uthn.'">
</td>
</tr>
</table>';


//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (empty($s))
	{
	//nip
	if ($crkd == "cr01")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE nip LIKE '%$kunci%' ".
						"ORDER BY round(nip) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//nuptk
	else if ($crkd == "cr02")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE nuptk LIKE '%$kunci%' ".
						"ORDER BY round(nuptk) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//kode
	else if ($crkd == "cr03")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE kode LIKE '%$kunci%' ".
						"ORDER BY round(kode) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//no_karpeg
	else if ($crkd == "cr04")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE no_karpeg LIKE '%$kunci%' ".
						"ORDER BY round(no_karpeg) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//nama
	else if ($crkd == "cr05")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE nama LIKE '%$kunci%' ".
						"ORDER BY nama ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_pegawai ".
						"ORDER BY round(nip) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}


	if ($count != 0)
		{
		//view data
		echo '<table width="800" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="200"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
		<td width="200"><strong><font color="'.$warnatext.'">NUPTK</font></strong></td>
		<td width="75"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td width="75"><strong><font color="'.$warnatext.'">No. Karpeg</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="1">&nbsp;</td>
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

			//nilai
			$nomer = $nomer + 1;
			$kd = nosql($data['kd']);
			$usernamex = nosql($data['usernamex']);
			$passwordx = nosql($data['passwordx']);
			$nip = balikin2($data['nip']);
			$nuptk = balikin2($data['nuptk']);
			$kode = balikin2($data['kode']);
			$no_karpeg = balikin2($data['no_karpeg']);
			$nama = balikin($data['nama']);




			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$nip.'</td>
			<td>'.$nuptk.'</td>
			<td>'.$kode.'</td>
			<td>'.$no_karpeg.'</td>
			<td>'.$nama.'</td>
			
			<td>
			<a href="pegawai.php?page='.$page.'&kd='.$kd.'&s=absensi">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
    		</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA.</strong>
		</font>
		</p>';
		}
	}


else if ($s == "absensi")
	{
	//detail
	$qku = mysql_query("SELECT * FROM m_pegawai ".
							"WHERE kd = '$kd'");
	$rku = mysql_fetch_assoc($qku);
	$ku_nip = nosql($rku['nip']);
	$ku_nama = balikin($rku['nama']);
							
	
	echo '<p>
	NIP : <b>'.$ku_nip.'</b> 
	</p>
	<p>
	Nama : <b>'.$ku_nama.'</b>
	</p>
	
	
	<input name="btnBTL" type="submit" value="DAFTAR PEGAWAI LAINNYA >>">
	<hr>

	<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	Bulan : ';
	echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
	echo '<option value="'.$ubln.'" selected>'.$arrbln[$ubln].'</option>';
	for ($i=1;$i<=12;$i++)
		{
		echo '<option value="'.$filenya.'?s=absensi&kd='.$kd.'&ubln='.$i.'">'.$arrbln[$i].'</option>';
		}
	
	echo '</select>, 
	
	Tahun : ';
	echo "<select name=\"uthnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
	echo '<option value="'.$uthn.'" selected>'.$uthn.'</option>
	<option value="'.$filenya.'?s=absensi&kd='.$kd.'&ubln='.$ubln.'&uthn='.$tahun.'">'.$tahun.'</option>
	</select>
	</td>
	</tr>
	</table>
	<br>';
	
	
	if (empty($_REQUEST['ubln']))
		{
		echo '<h4>
		<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
		</h4>';
		}
	else if (empty($_REQUEST['uthn']))
		{
		echo '<h4>
		<font color="#FF0000"><strong>TAHUN Belum Dipilih...!</strong></font>
		</h4>';
		}
	else
		{
		echo '<table width="750" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
	  	<td width="30"><strong>Tgl.</strong></td>
		<td width="75"><strong>Hari</strong></td>
		<td width="150"><strong>Jam</strong></td>
		<td width="100"><strong>Ket.</strong></td>
		<td><strong>Keperluan</strong></td>
		<td width="150"><strong>Postdate</strong></td>
		</tr>';
	
		//mendapatkan jumlah tanggal maksimum dalam suatu bulan
		$tgl = 0;
		$bulan = $ubln;
		$bln = $bulan + 1;
		$thn = $uthn;
	
		$lastday = mktime (0,0,0,$bln,$tgl,$thn);
	
		//total tanggal dalam sebulan
		$tkhir = strftime ("%d", $lastday);
	
		//lopping tgl
		for ($i=1;$i<=$tkhir;$i++)
			{
			//ketahui harinya
			$day = $i;
			$month = $bulan;
			$year = $thn;
	
	
			//mencari hari
			$a = substr($year, 2);
				//mengambil dua digit terakhir tahun
	
			$b = (int)($a/4);
				//membagi tahun dengan 4 tanpa memperhitungkan sisa
	
			$c = $month;
				//mengambil angka bulan
	
			$d = $day;
				//mengambil tanggal
	
			$tot1 = $a + $b + $c + $d;
				//jumlah sementara, sebelum dikurangani dengan angka kunci bulan
	
			//kunci bulanan
			if ($c == 1)
				{
				$kunci = "2";
				}
	
			else if ($c == 2)
				{
				$kunci = "7";
				}
	
			else if ($c == 3)
				{
				$kunci = "1";
				}
	
			else if ($c == 4)
				{
				$kunci = "6";
				}
	
			else if ($c == 5)
				{
				$kunci = "5";
				}
	
			else if ($c == 6)
				{
				$kunci = "3";
				}
	
			else if ($c == 7)
				{
				$kunci = "2";
				}
	
			else if ($c == 8)
				{
				$kunci = "7";
				}
	
			else if ($c == 9)
				{
				$kunci = "5";
				}
	
			else if ($c == 10)
				{
				$kunci = "4";
				}
	
			else if ($c == 11)
				{
				$kunci = "2";
				}
	
			else if ($c == 12)
				{
				$kunci = "1";
				}
	
			$total = $tot1 - $kunci;
	
			//angka hari
			$hari = $total%7;
	
			//jika angka hari == 0, sebenarnya adalah 7.
			if ($hari == 0)
				{
				$hari = ($hari +7);
				}
	
			//kabisat, tahun habis dibagi empat alias tanpa sisa
			$kabisat = (int)$year % 4;
	
			if ($kabisat ==0)
				{
				$hri = $hri-1;
				}
	
	
	
			//hari ke-n
			if ($hari == 3)
				{
				$hri = 4;
				$dino = "Rabu";
				}
	
			else if ($hari == 4)
				{
				$hri = 5;
				$dino = "Kamis";
				}
	
			else if ($hari == 5)
				{
				$hri = 6;
				$dino = "Jum'at";
				}
	
			else if ($hari == 6)
				{
				$hri = 7;
				$dino = "Sabtu";
				}
	
			else if ($hari == 7)
				{
				$hri = 1;
				$dino = "Minggu";
				}
	
			else if ($hari == 1)
				{
				$hri = 2;
				$dino = "Senin";
				}
	
			else if ($hari == 2)
				{
				$hri = 3;
				$dino = "Selasa";
				}
	
	
			//nek minggu, abang ngi wae
			if ($hri == 1)
				{
				$warna = "red";
				$mggu_attr = "disabled";
				}
			else
				{
				if ($warna_set ==0)
					{
					$warna = $warna01;
					$warna_set = 1;
					$mggu_attr = "";
					}
				else
					{
					$warna = $warna02;
					$warna_set = 0;
					$mggu_attr = "";
					}
				}
	
	
			//nilai data
			$qdtf = mysql_query("SELECT * FROM pegawai_absensi ".
									"WHERE kd_pegawai = '$kd' ".
									"AND round(DATE_FORMAT(tgl, '%d')) = '$i' ".
									"AND round(DATE_FORMAT(tgl, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(tgl, '%Y')) = '$uthn'");
			$rdtf = mysql_fetch_assoc($qdtf);
			$dtf_perlu = balikin($rdtf['keperluan']);
			$dtf_abskd = balikin($rdtf['kd_absensi']);
			$dtf_postdate = $rdtf['postdate'];
			$dtf_jam_xjam = substr($rdtf['jam'],0,2);
			$dtf_jam_xmnt = substr($rdtf['jam'],3,2);
	
			//nek empty
			if ($dtf_jam_xjam == "00")
				{
				$dtf_jam_xjam = "";
	
				if ($dtf_jam_xmnt == "00")
					{
					$dtf_jam_xmnt = "";
					}
				}
	
	
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i.'.</td>
			<td>'.$dino.'</td>
			<td>
			<input name="ijam'.$i.'" type="text" value="'.$dtf_jam_xjam.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)" '.$mggu_attr.'>
			<input name="imnt'.$i.'" type="text" value="'.$dtf_jam_xmnt.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)" '.$mggu_attr.'>
			</td>
			<td>';
	
			echo '<select name="iabs'.$i.'" '.$mggu_attr.'>';
	
			//absensinya
			$qbein = mysql_query("SELECT * FROM m_absensi ".
									"WHERE kd = '$dtf_abskd'");
			$rbein = mysql_fetch_assoc($qbein);
			$bein_kd = nosql($rbein['kd']);
			$bein_abs = balikin($rbein['absensi']);
	
	
			echo '<option value="'.$bein_kd.'" selected>'.$bein_abs.'</option>';
	
			//absensi
			$qsen = mysql_query("SELECT * FROM m_absensi ".
									"WHERE kd <> '$bein_kd' ".
									"ORDER BY absensi ASC");
			$rsen = mysql_fetch_assoc($qsen);
	
			do
				{
				$sen_kd = nosql($rsen['kd']);
				$sen_abs = balikin($rsen['absensi']);
	
				echo '<option value="'.$sen_kd.'">'.$sen_abs.'</option>';
				}
			while ($rsen = mysql_fetch_assoc($qsen));
	
			echo '<option value="">-</option>';
			echo '</select>';
	
	
			echo '</td>
			<td>
			<input name="iperlu'.$i.'" type="text" value="'.$dtf_perlu.'" size="20" '.$mggu_attr.'>
			</td>
			<td>
			'.$dtf_postdate.'
			</td>
			</tr>';
			}
	
		echo '</table>
		<input name="tkhir" type="hidden" value="'.$tkhir.'">
		<input name="btnSMP" type="submit" value="SIMPAN">';
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

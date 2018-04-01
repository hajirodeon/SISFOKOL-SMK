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
require("../../inc/cek/admpus.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "member.php";
$judul = "Member";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$diload = "document.formx.no.focus();";
$judulx = $judul;
$limit = "8";

$s = nosql($_REQUEST['s']);
$m = nosql($_REQUEST['m']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
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






//ke daftar member
if ($_POST['btnDFT'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);



	//ambil semua
	for ($k=1;$k<=$jml;$k++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$k";
		$kd = nosql($_POST["$yuhu"]);

		//nek $kd gak null
		if (!empty($kd))
			{
			//hapus file
			$qcc = mysql_query("SELECT * FROM m_user ".
						"WHERE kd = '$kd'");
			$rcc = mysql_fetch_assoc($qcc);
			$cc_filex = $rcc['filex'];
			$path1 = "../../filebox/member/$kd/$cc_filex";
			chmod($path1,0777);
			unlink ($path1);
			}

		//del
		mysql_query("DELETE FROM m_user ".
				"WHERE kd = '$kd'");
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}





//jika simpan
if ($_POST['btnSMP1'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$m = nosql($_POST['m']);
	$kd = nosql($_POST['kd']);




	//jika baru ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($s == "add")
		{
		//nilai
		$nomor = nosql($_POST['nomor']);
		$nama1 = cegah($_POST['nama1']);
		$kode = nosql($_POST['kode']);
		$tmp_lahir = cegah($_POST['tmp_lahir']);

		$lahir_tgl = nosql($_POST['lahir_tgl']);
		$lahir_bln = nosql($_POST['lahir_bln']);
		$lahir_thn = nosql($_POST['lahir_thn']);
		$tgl_lahir = "$lahir_thn:$lahir_bln:$lahir_tgl";

		$kelamin = nosql($_POST['kelamin']);
		$agama = nosql($_POST['agama']);
		$alamat = cegah($_POST['alamat']);
		$telp = cegah($_POST['telp']);
		$email = cegah($_POST['email']);
		$status = cegah($_POST['status']);
		$posisi = cegah($_POST['posisi']);
		$ket = cegah($_POST['ket']);


		//nek null
		if ((empty($nomor)) OR (empty($nama1)))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
			$ke = "$filenya?s=add&kd=$x";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_user ".
						"WHERE nomor = '$nomor'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Nomor Induk Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=add&kd=$x";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//set akses
				$x_userx = $nomor;
				$x_passx = md5($nomor);

				//insert
				mysql_query("INSERT INTO m_user(kd, usernamex, passwordx, nomor, ".
						"nama, tmp_lahir, tgl_lahir, kelamin, agama, ".
						"alamat, telp, email, status, posisi, ket) VALUES ".
						"('$kd', '$x_userx', '$x_passx', '$nomor', ".
						"'$nama1', '$tmp_lahir', '$tgl_lahir', '$kelamin', '$agama', ".
						"'$alamat', '$telp', '$email', '$status', '$posisi', '$ket')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&kd=$kd";
				xloc($ke);
				exit();
				}
			}
		}


	//jika edit ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($s == "edit")
		{
		$nomor = nosql($_POST['nomor']);
		$nama1 = cegah($_POST['nama1']);
		$kode = nosql($_POST['kode']);
		$tmp_lahir = cegah($_POST['tmp_lahir']);

		$lahir_tgl = nosql($_POST['lahir_tgl']);
		$lahir_bln = nosql($_POST['lahir_bln']);
		$lahir_thn = nosql($_POST['lahir_thn']);
		$tgl_lahir = "$lahir_thn:$lahir_bln:$lahir_tgl";

		$kelamin = nosql($_POST['kelamin']);
		$agama = nosql($_POST['agama']);
		$alamat = cegah($_POST['alamat']);
		$telp = cegah($_POST['telp']);
		$email = cegah($_POST['email']);
		$status = cegah($_POST['status']);
		$posisi = cegah($_POST['posisi']);
		$ket = cegah($_POST['ket']);


		//cek
		$qcc = mysql_query("SELECT * FROM m_user ".
					"WHERE nomor = '$nomor'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek lebih dari 1
		if ($tcc > 1)
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Ditemukan Duplikasi Nomor Induk : $nomor. Silahkan Diganti...!";
			$ke = "$filenya?s=edit&kd=$kd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//set akses
			$x_userx = $nomor;
			$x_passx = md5($nomor);

			//update
			mysql_query("UPDATE m_user SET usernamex = '$x_userx', ".
					"passwordx = '$x_passx', ".
					"nomor = '$nomor', ".
					"nama = '$nama1', ".
					"tmp_lahir = '$tmp_lahir', ".
					"tgl_lahir = '$tgl_lahir', ".
					"kelamin = '$kelamin', ".
					"agama = '$agama', ".
					"alamat = '$alamat', ".
					"telp = '$telp', ".
					"email = '$email', ".
					"status = '$status', ".
					"posisi = '$posisi',  ".
					"ket = '$ket' ".
					"WHERE kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&kd=$kd";
			xloc($ke);
			exit();
			}
		}
	}






//jika ganti foto profil ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnGNT'])
	{
	//nilai
	$filex_namex = strip(strtolower($_FILES['filex_foto']['name']));
	$kd = nosql($_POST['kd']);

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=edit&kd=$kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".jpg")
			{
			//nilai
			$path1 = "../../filebox/member/$kd";

			//cek, sudah ada belum
			if (!file_exists($path1))
				{
				//nilai
				chmod($path1,0777);

				//bikin folder kd_user
				mkdir("$path1", $chmod);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/member/$kd/$filex_namex");


				//chmod
	                        $path3 = "../../filebox/member/$kd/$filex_namex";
				chmod($path1,0755);
				chmod($path3,0755);


				//cek
				$qcc = mysql_query("SELECT * FROM m_user ".
							"WHERE kd = '$kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//query
					mysql_query("UPDATE m_user SET filex = '$filex_namex' ".
							"WHERE kd = '$kd'");
					}
				else
					{
					mysql_query("INSERT INTO m_user(kd, filex) VALUES ".
							"('$kd', '$filex_namex')");
					}


				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&kd=$kd";
				xloc($ke);
				exit();
				}
			else
				{
				//hapus file yang ada dulu
				//query
				$qcc = mysql_query("SELECT * FROM m_user ".
							"WHERE kd = '$kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//hapus file
				$cc_filex = $rcc['filex'];
				$path1 = "../../filebox/member/$kd/$cc_filex";
				chmod($path1,0777);
				unlink ($path1);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/member/$kd/$filex_namex");

				//nek ada
				if ($tcc != 0)
					{
					//query
					mysql_query("UPDATE m_user SET filex = '$filex_namex', ".
							"postdate = '$today' ".
							"WHERE kd = '$kd'");
					}
				else
					{
					mysql_query("INSERT INTO m_user(kd, filex) VALUES ".
							"('$kd', '$filex_namex')");
					}

				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&kd=$kd";
				xloc($ke);
				exit();
				}
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			$ke = "$filenya?s=edit&kd=$kd";
			pekem($pesan,$ke);
			exit();
			}
		}
	}







//print barcode
if ($_POST['btnPRT'])
	{
	//ambil class barcode
	require('../../inc/class/ean13_member.php');

	$pdf=new PDF_EAN13();
	$pdf->AddPage();


	//jumlah datanya, dalam satu halaman
	$jml_baris = $limit;


	for ($i=1;$i<=$jml_baris;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kdx = nosql($_POST["$yuhu"]);


		//jika gak null
		if (!empty($kdx))
			{
			//query
			$qx = mysql_query("SELECT * FROM m_user ".
						"WHERE kd = '$kdx'");
			$rowx = mysql_fetch_assoc($qx);
			$e_barkode = nosql($rowx['nomor']);
			$e_nama = balikin($rowx['nama']);
			$e_status = balikin($rowx['status']);
			$e_status2 = "[$e_status]";


			$pdf->EAN13(30,30*$i,$e_barkode, $e_barkode, $e_nama, $e_status2);
			}
		}


	$pdf->Output();
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admpus.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="500">';
xheadline($judul);
echo ' [<a href="'.$filenya.'?s=add&kd='.$x.'" title="Entry Data Baru">Entry Data Baru</a>]
</td>
<td align="right">';
echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?crkd=cr01&crtipe=NO&kunci='.$kunci.'">No.Induk</option>
<option value="'.$filenya.'?crkd=cr05&crtipe=Nama&kunci='.$kunci.'">Nama</option>
</select>
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="btnCARI" type="submit" value="CARI >>">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>
<br>';


//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (empty($s))
	{
	//no
	if ($crkd == "cr01")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM m_user ".
				"WHERE nomor LIKE '%$kunci%' ".
				"ORDER BY round(nomor) ASC";
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

		$sqlcount = "SELECT * FROM m_user ".
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

		$sqlcount = "SELECT * FROM m_user ".
				"ORDER BY round(nomor) ASC";
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
		echo '<table width="990" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="150"><strong><font color="'.$warnatext.'">No. Induk</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="200"><strong><font color="'.$warnatext.'">Alamat</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Telp.</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Status</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Posisi</font></strong></td>
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
			$nip = balikin2($data['nomor']);
			$nama = balikin($data['nama']);
			$alamat = balikin($data['alamat']);
			$telp = balikin($data['telp']);
			$status = balikin($data['status']);
			$posisi = balikin($data['posisi']);


			//set akses
			if ((empty($usernamex)) OR (empty($passwordx)))
				{
				$x_userx = $nip;
				$x_passx = md5($nip);

				mysql_query("UPDATE m_user SET usernamex = '$x_userx', ".
						"passwordx = '$x_passx' ".
						"WHERE kd = '$kd'");
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
			</td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$kd.'" title="EDIT..."><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>'.$nip.'</td>
			<td>'.$nama.'</td>
			<td>'.$alamat.'</td>
			<td>'.$telp.'</td>
			<td>'.$status.'</td>
			<td>'.$posisi.'</td>
	    		</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="990" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="300">
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		<input name="btnPRT" type="submit" value="PRINT BARCODE">
		</td>
		<td align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
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




//jika add / edit ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else
	{
	//nilai
	$kd = nosql($_REQUEST['kd']);


	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr valign="top">
	<td width="80%">';


	//data query
	$qnil = mysql_query("SELECT m_user.*, DATE_FORMAT(m_user.tgl_lahir, '%d') AS lahir_tgl, ".
				"DATE_FORMAT(m_user.tgl_lahir, '%m') AS lahir_bln, ".
				"DATE_FORMAT(m_user.tgl_lahir, '%Y') AS lahir_thn ".
				"FROM m_user ".
				"WHERE kd = '$kd'");
	$rnil = mysql_fetch_assoc($qnil);
	$y_noinduk = nosql($rnil['nomor']);
	$y_nama = balikin($rnil['nama']);

	$tmp_lahir = balikin($rnil['tmp_lahir']);

	$lahir_tgl = nosql($rnil['lahir_tgl']);
	$lahir_bln = nosql($rnil['lahir_bln']);
	$lahir_thn = nosql($rnil['lahir_thn']);

	$jkelkd = balikin($rnil['kelamin']);
	$agmkd = balikin($rnil['agama']);

	$y_alamat = balikin($rnil['alamat']);
	$y_telp = balikin($rnil['telp']);
	$y_email = balikin($rnil['email']);
	$y_status = balikin($rnil['status']);
	$y_ket = balikin($rnil['ket']);
	$y_filex = $rnil['filex'];


	echo '***<big><strong>DATA DIRI</strong></big>
	<hr>

	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="150">
	No.Induk
	</td>
	<td>: </td>
	<td>
	<input name="nomor" type="text" value="'.$y_noinduk.'" size="30">
	</td>
	</tr>

	<tr valign="top">
	<td width="150">
	Nama
	</td>
	<td>: </td>
	<td>
	<input name="nama1" type="text" value="'.$y_nama.'" size="30">
	</td>
	</tr>

	<tr valign="top">
	<td width="150">
	TTL
	</td>
	<td>: </td>
	<td>
	<input name="tmp_lahir" type="text" value="'.$tmp_lahir.'" size="30">,
	<select name="lahir_tgl">
	<option value="'.$lahir_tgl.'" selected>'.$lahir_tgl.'</option>';
	for ($i=1;$i<=31;$i++)
		{
		echo '<option value="'.$i.'">'.$i.'</option>';
		}

	echo '</select>
	<select name="lahir_bln">
	<option value="'.$lahir_bln.'" selected>'.$arrbln1[$lahir_bln].'</option>';
	for ($j=1;$j<=12;$j++)
		{
		echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
		}

	echo '</select>
	<select name="lahir_thn">
	<option value="'.$lahir_thn.'" selected>'.$lahir_thn.'</option>';
	for ($k=$lahir01;$k<=$lahir02;$k++)
		{
		echo '<option value="'.$k.'">'.$k.'</option>';
		}
	echo '</select>
	</td>
	</tr>

	<tr valign="top">
	<td width="150">
	Jenis Kelamin
	</td>
	<td>: </td>
	<td>
	<select name="kelamin">
	<option value="'.$jkelkd.'">'.$jkelkd.'</option>
	<option value="L">Laki</option>
	<option value="P">Perempuan</option>
	</select>,

	Agama :
	<select name="agama">
	<option value="'.$agmkd.'">'.$agmkd.'</option>
	<option value="Islam">Islam</option>
	<option value="Kristen">Kristen</option>
	<option value="Katolik">Katolik</option>
	<option value="Hindu">Hindu</option>
	<option value="Budha">Budha</option>
	</select>
	</td>
	</tr>

	<tr valign="top">
	<td width="150">
	Alamat
	</td>
	<td>: </td>
	<td>
	<input name="alamat" type="text" value="'.$y_alamat.'" size="50">
	</td>
	</tr>

	<tr valign="top">
	<td width="150">
	Telp.
	</td>
	<td>: </td>
	<td>
	<input name="telp" type="text" value="'.$y_telp.'" size="30">
	</td>
	</tr>

	<tr valign="top">
	<td width="150">
	E-Mail
	</td>
	<td>: </td>
	<td>
	<input name="email" type="text" value="'.$y_email.'" size="30">
	</td>
	</tr>


	<tr valign="top">
	<td width="150">
	Status Jabatan (Guru/Staf/Kepala Sekolah/Waka/Siswa/. . .dll).
	</td>
	<td>: </td>
	<td>
	<input name="status" type="text" value="'.$y_status.'" size="30">
	</td>
	</tr>



	<tr valign="top">
	<td width="150">
	Posisi (Bisa berupa ruang kelas siswa, atau ruang kerja keberadaan user).
	</td>
	<td>: </td>
	<td>
	<input name="posisi" type="text" value="'.$y_posisi.'" size="30">
	</td>
	</tr>



	<tr valign="top">
	<td width="150">
	Ket.
	</td>
	<td>: </td>
	<td>
	<input name="ket" type="text" value="'.$y_ket.'" size="30">
	</td>
	</tr>

	</table>



	</td>
	<td width="1%">
	</td>
	<td>';

	//nek null foto
	if (empty($y_filex))
		{
		$nil_foto = "$sumber/img/foto_blank.jpg";
		}
	else
		{
		$nil_foto = "$sumber/filebox/member/$kd/$y_filex";
		}

	echo '<img src="'.$nil_foto.'" alt="'.$y_nama.'" width="150" height="200" border="5">
	<br>
	<br>
	<input name="filex_foto" type="file" size="15">
	<br>
	<input name="btnGNT" type="submit" value="GANTI">
	</td>
	</tr>
	</table>

	<input name="s" type="hidden" value="'.nosql($_REQUEST['s']).'">
	<input name="m" type="hidden" value="'.nosql($_REQUEST['m']).'">
	<input name="kd" type="hidden" value="'.nosql($_REQUEST['kd']).'">
	<input name="btnSMP1" type="submit" value="SIMPAN">
	<input name="btnDFT" type="submit" value="DAFTAR MEMBER >>">';
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
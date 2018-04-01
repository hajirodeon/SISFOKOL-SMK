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
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$filenya = "profil.php";
$judul = "Profil";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$juduli = $judul;




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	$ke = "../../index.php";
	xloc($ke);
	exit();
	}





//ganti foto profil
if ($_POST['btnGNT'])
	{
	//nilai
	$filex_namex = strip(strtolower($_FILES['filex_foto']['name']));


	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".jpg")
			{
			//nilai
			$path1 = "../../../filebox/profil/$kd1_session";
			$path2 = "../../../filebox/profil";
			chmod($path1,0777);
			chmod($path2,0777);


			//cek, sudah ada belum
			if (!file_exists($path1))
				{
				//bikin folder kd_user
				mkdir("$path1", $chmod);

				//mengkopi file
				move_uploaded_file($_FILES['filex_foto']['tmp_name'],"../../../filebox/profil/$kd1_session/$filex_namex");

				//query
				mysql_query("UPDATE user_blog SET foto_path = '$filex_namex' ".
								"WHERE kd_user = '$kd1_session'");

				//null-kan
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			else
				{
				//hapus file yang ada dulu
				//query
				$qcc = mysql_query("SELECT * FROM user_blog ".
										"WHERE kd_user = '$kd1_session'");
				$rcc = mysql_fetch_assoc($qcc);

				//hapus file
				$cc_filex = $rcc['foto_path'];
				$path1 = "../../../filebox/profil/$kd1_session/$cc_filex";
				chmod($path1,0777);
				unlink ($path1);

				//mengkopi file
				move_uploaded_file($_FILES['filex_foto']['tmp_name'],"../../../filebox/profil/$kd1_session/$filex_namex");

				//query
				mysql_query("UPDATE user_blog SET foto_path = '$filex_namex', ".
								"postdate = '$today' ".
								"WHERE kd_user = '$kd1_session'");

				//null-kan
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			pekem($pesan,$filenya);
			exit();
			}
		}
	}





//nek simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$tmp_lahir = cegah($_POST['tmp_lahir']);
	$lxtgl = nosql($_POST['lxtgl']);
	$lxbln = nosql($_POST['lxbln']);
	$lxthn = nosql($_POST['lxthn']);
	$tgl_lahir = "$lxthn:$lxbln:$lxtgl";
	$alamat = cegah($_POST['alamat']);
	$email = cegah($_POST['email']);
	$situs = cegah($_POST['situs']);
	$telp = cegah($_POST['telp']);
	$agama = cegah($_POST['agama']);
	$hobi = cegah($_POST['hobi']);
	$aktivitas = cegah($_POST['aktivitas']);
	$tertarik = cegah($_POST['tertarik']);
	$makanan = cegah($_POST['makanan']);
	$minuman = cegah($_POST['minuman']);
	$musik = cegah($_POST['musik']);
	$film = cegah($_POST['film']);
	$buku = cegah($_POST['buku']);
	$idola = cegah($_POST['idola']);
	$pend_akhir = cegah($_POST['pend_akhir']);
	$pend_thnlulus = cegah($_POST['pend_thnlulus']);
	$moto = cegah($_POST['moto']);
	$kata_mutiara = cegah($_POST['kata_mutiara']);




	//update
	mysql_query("UPDATE user_blog SET tmp_lahir = '$tmp_lahir', ".
					"tgl_lahir = '$tgl_lahir', ".
					"alamat = '$alamat', ".
					"email = '$email', ".
					"situs = '$situs', ".
					"telp = '$telp', ".
					"agama = '$agama', ".
					"hobi = '$hobi', ".
					"aktivitas = '$aktivitas', ".
					"tertarik = '$tertarik', ".
					"makanan = '$makanan', ".
					"minuman = '$minuman', ".
					"musik = '$musik', ".
					"film = '$film', ".
					"buku = '$buku', ".
					"idola = '$idola', ".
					"pend_akhir = '$pend_akhir', ".
					"pend_thnlulus = '$pend_thnlulus', ".
					"moto = '$moto', ".
					"kata_mutiara = '$kata_mutiara', ".
					"postdate = '$today' ".
					"WHERE kd_user = '$kd1_session'");

	//re-direct
	$ke = "../../index.php";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();



//focus
$diload = "document.formx.tmp_lahir.focus();";


require("../../../inc/js/swap.js");
require("../../../inc/js/number.js");
require("../../../inc/js/openwindow.js");
require("../../../inc/menu/janissari.php");





//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query data
$qdt = mysql_query("SELECT DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
						"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
						"DATE_FORMAT(tgl_lahir, '%Y') AS lthn, ".
						"user_blog.* ".
						"FROM user_blog ".
						"WHERE kd_user = '$kd1_session'");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);
$dt_tmp_lahir = balikin($rdt['tmp_lahir']);
$dt_tgl = nosql($rdt['ltgl']);
$dt_bln = nosql($rdt['lbln']);
$dt_thn = nosql($rdt['lthn']);
$dt_foto_path = $rdt['foto_path'];
$dt_alamat = balikin($rdt['alamat']);
$dt_email = balikin($rdt['email']);
$dt_situs = balikin($rdt['situs']);
$dt_telp = balikin($rdt['telp']);
$dt_agama = balikin($rdt['agama']);
$dt_hobi = balikin($rdt['hobi']);
$dt_aktivitas = balikin($rdt['aktivitas']);
$dt_tertarik = balikin($rdt['tertarik']);
$dt_makanan = balikin($rdt['makanan']);
$dt_minuman = balikin($rdt['minuman']);
$dt_musik = balikin($rdt['musik']);
$dt_film = balikin($rdt['film']);
$dt_buku = balikin($rdt['buku']);
$dt_idola = balikin($rdt['idola']);
$dt_pend_akhir = balikin($rdt['pend_akhir']);
$dt_pend_thnlulus = balikin($rdt['pend_thnlulus']);
$dt_moto = balikin($rdt['moto']);
$dt_kata_mutiara = balikin($rdt['kata_mutiara']);


//jika tgl lahir empty
if (($dt_tgl == "00") OR ($dt_bln == "00") OR ($dt_thn == "0000"))
	{
	$dt_tgl = "";
	$dt_bln = "";
	$dt_thn = "";
	}






echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FDF0DE" valign="top">
<td>


<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
//judul
xheadline($judul);
echo '</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="700" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>

<p>
<strong>TTL : </strong>
<br>
<input name="tmp_lahir" type="text" value="'.$dt_tmp_lahir.'" size="20">,
<select name="lxtgl">
<option value="'.$dt_tgl.'" selected>'.$dt_tgl.'</option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}

echo '</select>
<select name="lxbln">
<option value="'.$dt_bln.'" selected>'.$arrbln1[$dt_bln].'</option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>
<select name="lxthn">
<option value="'.$dt_thn.'" selected>'.$dt_thn.'</option>';
for ($k=$lahir01;$k<=$lahir02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>
</p>

<p>
<strong>Alamat :</strong>
<br>
<input name="alamat" type="text" value="'.$dt_alamat.'" size="40">
</p>

<p>
<strong>E-Mail :</strong>
<br>
<input name="email" type="text" value="'.$dt_email.'" size="40">
</p>

<p>
<strong>Situs/Blog :</strong>
<br>
http://<input name="situs" type="text" value="'.$dt_situs.'" size="40">
</p>

<p>
<strong>Telp/HP :</strong>
<br>
<input name="telp" type="text" value="'.$dt_telp.'" size="30">
</p>


<p>
<strong>Agama : </strong>
<br>
<select name="agama">
<option value="'.$dt_agama.'" selected>'.$dt_agama.'</option>
<option value="Islam">Islam</option>
<option value-"Kristen">Kristen</option>
<option value="Katholik">Katholik</option>
<option value="Budha">Budha</option>
<option value="Hindu">Hindu</option>
<option value="Konghuchu">Konghuchu</option>
<option value="Kepercayaan">Kepercayaan</option>
</select>
</p>

<p>
<strong>Hobi :</strong>
<br>
<textarea name="hobi" cols="30" rows="3" wrap="virtual">'.$dt_hobi.'</textarea>
</p>

<p>
<strong>Aktivitas :</strong>
<br>
<textarea name="aktivitas" cols="30" rows="3" wrap="virtual">'.$dt_aktivitas.'</textarea>
</p>

<p>
<strong>Tertarik :</strong>
<br>
<textarea name="tertarik" cols="30" rows="3" wrap="virtual">'.$dt_tertarik.'</textarea>
</p>

<p>
<strong>Makanan Favorit :</strong>
<br>
<textarea name="makanan" cols="30" rows="3" wrap="virtual">'.$dt_makanan.'</textarea>
</p>

<p>
<strong>Minuman Favorit :</strong>
<br>
<textarea name="minuman" cols="30" rows="3" wrap="virtual">'.$dt_minuman.'</textarea>
</p>

<p>
<strong>Musik Favorit :</strong>
<br>
<textarea name="musik" cols="30" rows="3" wrap="virtual">'.$dt_musik.'</textarea>
</p>

<p>
<strong>Film Favorit :</strong>
<br>
<textarea name="film" cols="30" rows="3" wrap="virtual">'.$dt_film.'</textarea>
</p>

<p>
<strong>Buku Favorit :</strong>
<br>
<textarea name="buku" cols="30" rows="3" wrap="virtual">'.$dt_buku.'</textarea>
</p>

<p>
<strong>Idola :</strong>
<br>
<textarea name="idola" cols="30" rows="3" wrap="virtual">'.$dt_idola.'</textarea>
</p>

<p>
<strong>Pendidikan Terakhir :</strong>
<br>
<input name="pend_akhir" type="text" value="'.$dt_pend_akhir.'" size="40">
</p>

<p>
<strong>Tahun Lulus :</strong>
<br>
<input name="pend_thnlulus" type="text" value="'.$dt_pend_thnlulus.'" size="4" onKeyPress="return numbersonly(this, event)">
</p>

<p>
<strong>TagLine/Moto :</strong>
<br>
<textarea name="moto" cols="30" rows="3" wrap="virtual">'.$dt_moto.'</textarea>
</p>

<p>
<strong>Kata Mutiara :</strong>
<br>
<textarea name="kata_mutiara" cols="30" rows="3" wrap="virtual">'.$dt_kata_mutiara.'</textarea>
</p>


<p>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>

</td>

<td width="220">
<p>';

//nek null foto
if (empty($dt_foto_path))
	{
	$nil_foto = "$sumber/img/foto_blank.jpg";
	}
else
	{
	//gawe thumnail
	$nil_foto = "$sumber/filebox/profil/$kd1_session/$dt_foto_path";
	}

echo '<img src="'.$nil_foto.'" alt="'.$nm1_session.'" width="195" height="300" border="5">
<br><br>
<input name="filex_foto" type="file" size="15">
<br>
<input name="btnGNT" type="submit" value="GANTI">
</p>

<p>
<input name="btnTBN" type="button" value="Membuat Thumbnail"OnClick="javascript:MM_openBrWindow(\'profil_thumb.php\',\'Membuat Thumbnail\',\'width=650,height=300,toolbar=no,menubar=no,location=no,scrollbars=yes,resize=no\')">
</p>
</td>
</tr>
</table>

<br>
<br>';
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
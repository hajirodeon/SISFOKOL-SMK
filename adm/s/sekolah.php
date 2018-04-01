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

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "sekolah.php";
$judul = "Set Sekolah";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$isek_nama = cegah2($_POST["isek_nama"]);
	$isek_alamat = cegah2($_POST["isek_alamat"]);
	$isek_kontak = cegah2($_POST["isek_kontak"]);
	$isek_kota = cegah2($_POST["isek_kota"]);

	//cek
	//nek null
	if ((empty($isek_nama)) OR (empty($isek_alamat)) OR (empty($isek_kontak)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}

	else
		{
		//perintah SQL
		mysql_query("UPDATE set_sekolah SET sek_nama = '$isek_nama', ".
						"sek_alamat = '$isek_alamat', ".
						"sek_kontak = '$isek_kontak', ".
						"sek_kota = '$isek_kota'");




		//auto-kembali
		$pesan = "SET SEKOLAH BERHASIL DIGANTI.";
		$ke = "../index.php";
		pekem($pesan, $ke);
		exit();
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
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//deteksi .png
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".png")
			{
			//nilai
			$path1 = "../../filebox/logo";

			//cek, sudah ada belum
			if (!file_exists($path1))
				{
				//bikin folder kd_user
				mkdir("$path1", $chmod);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/logo/$filex_namex");

				//query
				mysql_query("UPDATE set_sekolah SET filex = '$filex_namex'");


				//null-kan
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			else
				{
				//hapus file yang ada dulu
				$path1 = "../../filebox/logo/$cc_filex";
				unlink ($path1);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/logo/$filex_namex");

				//query
				mysql_query("UPDATE set_sekolah SET filex = '$filex_namex'");


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
			$pesan = "Bukan FIle Image .png . Harap Diperhatikan...!!";
			pekem($pesan,$filenya);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//menu
require("../../inc/menu/adm.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" enctype="multipart/form-data" name="formx">
<p>
Nama Sekolah : <br>
<input name="isek_nama" type="text" size="30" value="'.$sek_nama.'">
</p>
<p>
Alamat : <br>
<input name="isek_alamat" type="text" size="30" value="'.$sek_alamat.'">
</p>
<p>
Kontak : <br>
<input name="isek_kontak" type="text" size="30" value="'.$sek_kontak.'">
</p>
<p>
Kota : <br>
<input name="isek_kota" type="text" size="30" value="'.$sek_kota.'">
</p>

<p>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="reset" value="BATAL">

<iframe frameborder="0" width="1" src="http://omahbiasawae.com/user_sisfokol/pengguna.php?isek_nama='.$sek_nama.'&isek_alamat='.$sek_alamat.'&isek_kontak='.$sek_kontak.'&isek_kota='.$sek_kota.'" scrolling="no" name="frku" height="1"></iframe>
</p>

<hr>

<p>
Ganti Logo Sekolah :
</p>';

//nek null foto
if (empty($sek_filex))
	{
	$nil_foto = "$sumber/img/foto_blank.jpg";
	}
else
	{
	$nil_foto = "$sumber/filebox/logo/$sek_filex";
	}

echo '<p>
<img src="'.$nil_foto.'" width="50" height="50" border="1">
<br>
<br>
<input name="filex_foto" type="file" size="15">
<br>
<input name="btnGNT" type="submit" value="GANTI">
</p>
</form>';
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
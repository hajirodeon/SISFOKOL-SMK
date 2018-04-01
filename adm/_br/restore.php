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
$filenya = "restore.php";
$judul = "Restore Database";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//upload and restore
if ($_POST['btnUPL'])
	{
	$filex_namex = strip(strtolower($_FILES['filex']['name']));

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
		$path1 = "../../filebox";
		$path2 = "../../filebox/restore";
		chmod($path1,0777);
		chmod($path2,0777);

		//deteksi .sql
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".sql")
			{
			//upload dahulu...
			move_uploaded_file($_FILES['filex']['tmp_name'],"../../filebox/restore/$filex_namex");


			//restore database //////////////////////////////////////////////////////////////////////////////////////////////////////////
			//require
			require("../../inc/class/mysql_restore.php");

			//koneksi
			$link_db = @mysql_connect($xhostname, $xusername, $xpassword);


			//restore
			mysql_select_db($xdatabase);
			$query_db = fread(fopen("../../filebox/restore/$filex_namex", "r"), filesize("../../filebox/restore/$filex_namex"));
			$mqr = @get_magic_quotes_runtime();
			@set_magic_quotes_runtime(0);
			@set_magic_quotes_runtime($mqr);
			$pieces  = split_sql2($query_db);

			for ($i=0; $i<count($pieces); $i++)
				{
				$pieces[$i] = trim($pieces[$i]);

				if(!empty($pieces[$i]) && $pieces[$i] != "#")
					{
					$pieces[$i] = str_replace( "#__", '', $pieces[$i]);

					if (!$result = mysql_query ($pieces[$i]))
						{
						$errors[] = array ( mysql_error(), $pieces[$i] );
						}
					}
				}



			//hapus file yang telah di-upload dan di-restore
			$path1 = "../../filebox/restore/$filex_namex";
			chmod($path1,0777);
			unlink ($path1);

			//re-direct
			$pesan = "Import Berhasil Dilakukan. Silahkan Lakukan Penyalinan/Copy Folder FileBox ke Folder Web ini. Terima Kasih.";
			pekem($pesan,$filenya);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .sql . Harap Diperhatikan...!!";
			pekem($pesan,$filenya);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//js
require("../../inc/menu/adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<p>
<input name="filex" type="file" size="30">
<br>
<input name="btnUPL" type="submit" value="UPLOAD & RESTORE >>">
</p>
<p>
<strong>NB. </strong>
<br>
<UL>
<LI>
Jangan Sampai Salah Memilih File Database yang akan Anda Restore. Bila Salah, akan Fatal akibatnya...
</LI>
<br>

<LI>
Restore Database ini akan menimpa atau replace semua Table, Database yang sedang dipakai.
Jika Anda yakin, Silahkan Lanjutkan.
</LI>
<br>

<LI>
Tapi bila masih ragu dan tidak yakin, Harap lakukan Backup Database terlebih Dahulu.
</LI>
<br>

<LI>
Selama proses Restore Database, Harap Tunggu Sebentar, sampai muncul pesan Restore Database telah berhasil.
</LI>
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
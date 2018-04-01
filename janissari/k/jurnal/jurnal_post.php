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
require("../../../inc/class/paging.php");
require("../../../inc/class/pagingx.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$filenya = "jurnal_post.php";
$judul = "Entry/Edit Jurnal";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$juduli = $judul;
$s = nosql($_REQUEST['s']);
$jurkd = nosql($_REQUEST['jurkd']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//bikin folder
//jika baru
if ($s == "baru")
	{
	//nilai
	$path1 = "../../../filebox/jurnal/$jurkd";
	$path2 = "../../../filebox/jurnal/$jurkd/$filex_namex";
	chmod($path1,0777);
	chmod($path2,0777);


	//cek, sudah ada belum
	if (!file_exists($path1))
		{
		mkdir("$path1", $chmod);
		}
	}





//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	$ke = "jurnal.php";
	xloc($ke);
	exit();
	}




//nek simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$jurkd = nosql($_POST['jurkd']);
	$kategorix = nosql($_POST['kategorix']);
	$judulx = cegah($_POST['judulx']);
	$rangkumanx = cegah2($_POST['rangkumanx']);
	$isix = cegah2($_POST['editor']);


	//cek null
	if ((empty($kategorix)) OR (empty($judulx)) OR (empty($rangkumanx)) OR (empty($isix)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "jurnal_post.php?s=baru&jurkd=$jurkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//nek baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM user_blog_jurnal ".
									"WHERE kd_user = '$kd1_session' ".
									"AND kd_kategori = '$kategorix' ".
									"AND judul = '$judulx'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Jurnal Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=baru";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert
				mysql_query("INSERT INTO user_blog_jurnal(kd, kd_user, kd_kategori, judul, rangkuman, isi, postdate) VALUES ".
								"('$jurkd', '$kd1_session', '$kategorix', '$judulx', '$rangkumanx', '$isix', '$today')");

				//re-direct
				$ke = "jurnal.php";
				xloc($ke);
				exit();
				}
			}


		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM user_blog_jurnal ".
									"WHERE kd_user = '$kd1_session' ".
									"AND kd_kategori = '$kategorix' ".
									"AND judul = '$judulx'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek iya, lebih dari 1
			if ($tcc > 1)
				{
				//re-direct
				$pesan = "Ditemukan Duplikasi Jurnal Tersebut. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=edit&jurkd=$jurkd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//update
				mysql_query("UPDATE user_blog_jurnal SET kd_kategori = '$kategorix', ".
								"judul = '$judulx', ".
								"rangkuman = '$rangkumanx', ".
								"isi = '$isix' ".
								"WHERE kd_user = '$kd1_session' ".
								"AND kd = '$jurkd'");

				//re-direct
				$ke = "jurnal.php";
				xloc($ke);
				exit();
				}
			}
		}
	}



//nek edit
if ($s == "edit")
	{
	//query
	$qdt = mysql_query("SELECT * FROM user_blog_jurnal ".
							"WHERE kd_user = '$kd1_session' ".
							"AND kd = '$jurkd'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_judul = balikin($rdt['judul']);
	$dt_rangkuman = balikin($rdt['rangkuman']);
	$dt_isi = balikin($rdt['isi']);
	$dt_katkd = nosql($rdt['kd_kategori']);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();



//focus
$diload = "document.formx.kategorix.focus();";


//js
require("../../../inc/js/editor.js");
require("../../../inc/js/openwindow.js");
require("../../../inc/menu/janissari.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//daftar kategori
$qkat = mysql_query("SELECT * FROM user_blog_kategori ".
						"WHERE kd_user = '$kd1_session' ".
						"ORDER BY kategori ASC");
$rkat = mysql_fetch_assoc($qkat);

//kat terpilih
$qkatx = mysql_query("SELECT * FROM user_blog_kategori ".
						"WHERE kd_user = '$kd1_session' ".
						"AND kd = '$dt_katkd'");
$rkatx = mysql_fetch_assoc($qkatx);
$katx_kd = nosql($rkatx['kd']);
$katx_kat = balikin($rkatx['kategori']);


echo '<table width="100%" border="0" cellspacing="0" cellpadding="4">
<tr bgcolor="#FDF0DE" valign="top">
<td>';
//judul
xheadline($judul);

echo '<p>
<strong>Kategori :</strong>
<br>
<select name="kategorix">
<option value="'.$katx_kd.'" selected>'.$katx_kat.'</option>';

do
	{
	//nilai
	$kat_kd = nosql($rkat['kd']);
	$kat_kat = balikin($rkat['kategori']);

	echo '<option value="'.$kat_kd.'">'.$kat_kat.'</option>';
	}
while ($rkat = mysql_fetch_assoc($qkat));

echo '</select>
</p>

<p>
<strong>Judul :</strong>
<br>
<input name="judulx" type="text" value="'.$dt_judul.'" size="50">
</p>

<p>
<strong>Rangkuman : </strong>
<br>
<textarea name="rangkumanx" cols="50" rows="5" wrap="virtual">'.$dt_rangkuman.'</textarea>
</p>

<p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<strong>Isi Jurnal : </strong>
</td>
<td align="right">
<input name="btnUPL" type="button" value="FileBox Image >>" OnClick="javascript:MM_openBrWindow(\'jurnal_post_filebox.php?jurkd='.$jurkd.'\',\'FileBOX Image (.jpg) :\',\'width=650,height=300,toolbar=no,menubar=no,location=no,scrollbars=yes,resize=no\')">
</td>
</tr>
</table>

<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$dt_isi.'</textarea>
</p>

<p>
<input name="s" type="hidden" value="'.$s.'">
<input name="jurkd" type="hidden" value="'.$jurkd.'">
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>


</td>
<td width="1%">
</td>

<td width="1%">';

//ambil sisi
require("../../../inc/menu/k_sisi.php");

echo '<br>
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
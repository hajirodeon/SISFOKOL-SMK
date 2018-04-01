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
$uskd = nosql($_REQUEST['uskd']);

//dia...
$qtem = mysql_query("SELECT * FROM m_user ".
						"WHERE kd = '$uskd'");
$rtem = mysql_fetch_assoc($qtem);
$ttem = mysql_num_rows($qtem);
$tem_no = nosql($rtem['nomor']);
$tem_nama = balikin($rtem['nama']);
$tem_tipe = nosql($rtem['tipe']);

//jika tidak ada, kembali ke aku sendiri
if ((empty($uskd)) OR ($ttem == 0))
	{
	//re-direct
	$ke = "$sumber/janissari/k/profil/profil.php";
	xloc($ke);
	exit();
	}

//judul profil
$qpfi = mysql_query("SELECT * FROM m_user ".
						"WHERE kd = '$uskd'");
$rpfi = mysql_fetch_assoc($qpfi);
$pfi_no = nosql($rpfi['nomor']);
$pfi_nama = balikin($rpfi['nama']);
$pfi_tipe = nosql($rpfi['tipe']);


//judul
$filenya = "profil.php";
$judul = "Profil";
$juduli = $judul;
$judulku = "Halaman : $pfi_no.$pfi_nama [$pfi_tipe] --> $judul";





//isi *START
ob_start();




require("../../../inc/js/swap.js");
require("../../../inc/js/number.js");
require("../../../inc/menu/janissari.php");




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query data
$qdt = mysql_query("SELECT DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
						"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
						"DATE_FORMAT(tgl_lahir, '%Y') AS lthn, ".
						"user_blog.* ".
						"FROM user_blog ".
						"WHERE kd_user = '$uskd'");
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
	$dt_tgl_lahir = "-";
	}
else
	{
	$dt_tgl_lahir = "$dt_tgl $arrbln1[$dt_bln] $dt_thn";
	}


echo '<table bgcolor="#E9FFBB" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="80%">';
//judul
xheadline($judul);
echo '<p>
<strong>TTL : </strong>
<br>
'.$dt_tmp_lahir.', '.$dt_tgl_lahir.'
</p>

<p>
<strong>Alamat :</strong>
<br>
'.$dt_alamat.'
</p>

<p>
<strong>E-Mail :</strong>
<br>
'.$dt_email.'
</p>

<p>
<strong>Situs/Blog :</strong>
<br>
'.$dt_situs.'
</p>

<p>
<strong>Telp/HP :</strong>
<br>
'.$dt_telp.'
</p>


<p>
<strong>Agama : </strong>
<br>
'.$dt_agama.'
</p>

<p>
<strong>Hobi :</strong>
<br>
'.$dt_hobi.'
</p>

<p>
<strong>Aktivitas :</strong>
<br>
'.$dt_aktivitas.'
</p>

<p>
<strong>Tertarik :</strong>
<br>
'.$dt_tertarik.'
</p>

<p>
<strong>Makanan Favorit :</strong>
<br>
'.$dt_makanan.'
</p>

<p>
<strong>Minuman Favorit :</strong>
<br>
'.$dt_minuman.'
</p>

<p>
<strong>Musik Favorit :</strong>
<br>
'.$dt_musik.'
</p>

<p>
<strong>Film Favorit :</strong>
<br>
'.$dt_film.'
</p>

<p>
<strong>Buku Favorit :</strong>
<br>
'.$dt_buku.'
</p>

<p>
<strong>Idola :</strong>
<br>
'.$dt_idola.'
</p>

<p>
<strong>Pendidikan Terakhir :</strong>
<br>
'.$dt_pend_akhir.'
</p>

<p>
<strong>Tahun Lulus :</strong>
<br>
'.$dt_pend_thnlulus.'
</p>

<p>
<strong>TagLine/Moto :</strong>
<br>
'.$dt_moto.'
</p>

<p>
<strong>Kata Mutiara :</strong>
<br>
'.$dt_kata_mutiara.'
</p>
<br>
<br>
<br>
</td>

<td width="1%">
</td>

<td>';

//ambil sisi
require("../../../inc/menu/p_sisi.php");

echo '<br>
<br>
<br>
</td>
</tr>
</table>';
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
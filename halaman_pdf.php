<?php
//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require_once("inc/class/dompdf/dompdf_config.inc.php");


nocache;

//nilai
$filenya = "halaman.php";
$kd = nosql($_REQUEST['kd']);








//detail
$qku = mysql_query("SELECT cp_artikel.*, cp_m_kategori.nama AS katnama ".
					"FROM cp_artikel, cp_m_kategori ".
					"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
					"AND cp_artikel.kd = '$kd'");
$rku = mysql_fetch_assoc($qku);
$ku_katkd = nosql($rku['kd_kategori']);
$ku_katnama = balikin($rku['katnama']);
$ku_judul2 = balikin($rku['judul']);
$ku_isi = balikin($rku['isi']);
$ku_postdate = $rku['postdate'];

//pecah titik - titik
$ku_isi2 = pathasli1($ku_isi);



//judul
$judul = "$ku_judul2";
$judulku = $judul;



$filenya_pdf2 = strip("$judul");
$filenya_pdf = "$filenya_pdf2.pdf";





//isi *START
ob_start();




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table border="0" width="100%" cellspacing="0" cellpadding="5">
<tr valign="top">
<td bgcolor="white">
<p>
<h1>
'.$ku_judul2.'
</h1>
<i>
Dikirim : <b>'.$ku_postdate.'</b>
</i>
<br>

<p>
'.$ku_isi2.'
</p>
<br>
<br>

<hr>';


//query
$qku2 = mysql_query("SELECT cp_artikel_komentar.* ".
						"FROM cp_artikel_komentar ".
						"WHERE cp_artikel_komentar.kd_artikel = '$kd'");
$rku2 = mysql_fetch_assoc($qku2);
$tku2 = mysql_num_rows($qku2);

if ($qku2 != 0)
	{
	//view data
	echo '<table width="100%" border="0" cellspacing="3" cellpadding="3">';


	do
		{
		//nilai
		$nomer = $nomer + 1;
		$i_kd = nosql($rku2['kd']);
		$i_nama = balikin($rku2['nama']);
		$i_alamat = balikin($rku2['alamat']);
		$i_email = balikin($rku2['email']);
		$i_isi = balikin($rku2['isi']);
		$i_postdate = $rku2['postdate'];


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$i_isi.'
		<br>
		<i>
		['.$i_nama.']. ['.$i_alamat.']. ['.$i_email.']. ['.$i_postdate.'].
		</i>
		</td>
		</tr>';
		}
	while ($rku2 = mysql_fetch_assoc($qku2));

	echo '</table>';
	}
else
	{
	echo '<p>
	&nbsp;
	<font color="blue">
	<strong>BELUM ADA DATA.</strong>
	</font>
	</p>';
	}


echo '</td>

</tr>
</table>
<br>



</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$htmlbuffer=ob_get_contents();
ob_end_clean();


$dompdf = new DOMPDF();
$dompdf->load_html($htmlbuffer);
$dompdf->render();
$dompdf->stream($filenya_pdf);
//$dompdf->stream("nyoba.pdf");

?>

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

//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/class/paging.php");
require("../../../inc/class/pagingx.php");
$tpl = LoadTpl("../../../template/janissari.html");


nocache;

//nilai
$filenya = "link.php";
$judul = "Link Favorit";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$linkkd = nosql($_REQUEST['linkkd']);



//focus...
$diload = "document.formx.d_judul.focus();";


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





//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$jml = nosql($_POST['jml']);

	for ($i=1;$i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del data
		mysql_query("DELETE FROM user_blog_link ".
						"WHERE kd_user = '$kd1_session' ".
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
	$linkkd = nosql($_POST['linkkd']);
	$d_judul = cegah($_POST['d_judul']);
	$d_url = cegah($_POST['d_url']);


	//nek null
	if ((empty($d_judul)) OR (empty($d_url)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
		$ke = "$filenya?s=baru";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//nek edit
		if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM user_blog_link ".
									"WHERE kd_user = '$kd1_session' ".
									"AND judul = '$d_judul'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek lebih dari 1
			if ($tcc > 1)
				{
				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Ditemukan Duplikasi Link. Silahkan Diganti...!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//update
				mysql_query("UPDATE user_blog_link SET judul = '$d_judul', ".
								"url = '$d_url' ".
								"WHERE kd_user = '$kd1_session' ".
								"AND kd = '$linkkd'");

				//diskonek
				xfree($qcc);
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();

				}
			}





		//nek baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM user_blog_link ".
									"WHERE kd_user = '$kd1_session' ".
									"AND judul = '$d_judul'");
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
				$pesan = "Ditemukan Duplikasi Link. Silahkan Diganti...!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//insert data
				mysql_query("INSERT INTO user_blog_link(kd, kd_user, judul, url) VALUES ".
								"('$x', '$kd1_session', '$d_judul', '$d_url')");

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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();


//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/js/checkall.js");
require("../../../inc/menu/janissari.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="100%" height="300" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FDF0DE" valign="top">
<td>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td>';
xheadline($judul);

echo ' (<a href="'.$filenya.'?s=baru" title="Tulis Baru">Tulis Baru</a>)</td>
</tr>
</table>';

//nek edit //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($s == "edit")
	{
	//nilai
	$linkkd = nosql($_REQUEST['linkkd']);

	//query
	$qnil = mysql_query("SELECT * FROM user_blog_link ".
							"WHERE kd_user = '$kd1_session' ".
							"AND kd = '$linkkd'");
	$rnil = mysql_fetch_assoc($qnil);
	$y_judul = balikin($rnil['judul']);
	$y_url = balikin($rnil['url']);

	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td>
	<strong>Judul : </strong>
	<br>
	<input name="d_judul" type="text" value="'.$y_judul.'" size="30">
	<br>
	<br>

	<strong>URL :</strong>
	<br>
	http://<input name="d_url" type="text" value="'.$y_url.'" size="50" '.$x_enter.'>
	<br>
	<br>

	<input name="s" type="hidden" value="'.$s.'">
	<input name="linkkd" type="hidden" value="'.$linkkd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</td>
	</tr>
	</table>
	<br>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//nek baru //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($s == "baru")
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td>
	<strong>Judul : </strong>
	<br>
	<input name="d_judul" type="text" value="" size="30">
	<br>
	<br>

	<strong>URL :</strong>
	<br>
	http://<input name="d_url" type="text" value="" size="50" '.$x_enter.'>
	<br>
	<br>

	<input name="s" type="hidden" value="'.$s.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</td>
	</tr>
	</table>
	<br>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//query view ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else
	{
	$qdt = mysql_query("SELECT * FROM user_blog_link ".
							"WHERE kd_user = '$kd1_session' ".
							"ORDER BY judul ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//nek ada
	if ($tdt != 0)
		{
		echo '<table width="500" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td valign="top"><strong>Link</strong></td>
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

			$nomer = $nomer + 1;

			$kd = nosql($rdt['kd']);
			$i_judul = balikin($rdt['judul']);
			$i_url = balikin($rdt['url']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td width="1">
			<input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
			</td>
			<td width="1">
			<a href="'.$filenya.'?s=edit&linkkd='.$kd.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td valign="top">
			<a href="http://'.$i_url.'" target="_blank" title="'.$i_judul.'">'.$i_judul.'</a>
			</td>
			</tr>';
	  		}
		while ($rdt = mysql_fetch_assoc($qdt));

		echo '</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
	    	<tr>
		<td width="250">
		<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		<input name="jml" type="hidden" value="'.$tdt.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="linkkd" type="hidden" value="'.$linkkd.'">
		</td>
		<td align="right"><font color="#FF0000"><strong>'.$tdt.'</strong></font> Data</td>
	    	</tr>
		</table>';
		}
	else
		{
		echo '<font color="red"><strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong></font>';
		}
	}


echo '</td>
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
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
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "kurikulum.php";
$judul = "Set Kurikulum";
$judulku = "[$waka_session : $nip10_session. $nm10_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);




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



//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT * FROM m_kurikulum ".
							"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_nama = balikin($rowx['nama']);
	$e_status = nosql($rowx['aktif']);

	//jika aktif
	if ($e_status == "true")
		{
		$e_status_ket = "AKTIF";
		}
	else if ($e_status == "false")
		{
		$e_status_ket = "Tidak Aktif";
		}
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$kd = nosql($_POST['kd']);
	$status = nosql($_POST['status']);


	//netralkan dulu ya...
	mysql_query("UPDATE m_kurikulum SET aktif = 'false'");

	//set dulu
	mysql_query("UPDATE m_kurikulum SET aktif = '$status' ".
					"WHERE kd = '$kd'");

	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//menu
require("../../inc/menu/admwaka.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();

//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';


//jika edit
if ($s == "edit")
	{
	echo '<p>
	Nama Kurikulum :
	<br>
	<b>
	'.$e_nama.'
	</b>
	</p>
	
	<p>
	Status :
	<br>
	<select name="status">
	<option value="'.$e_status.'" selected>-'.$e_status_ket.'-</option>
	<option value="true" selected>Aktif</option>
	<option value="false" selected>Tidak Aktif</option>
	</select>
	</p>
	
	<p>
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';
	}



//query
$q = mysql_query("SELECT * FROM m_kurikulum ".
					"ORDER BY no ASC");
$row = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);


if ($total != 0)
	{
	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">Nama Kurikulum</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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
		$i_kd = nosql($row['kd']);
		$i_nama = nosql($row['nama']);
		$i_status = nosql($row['aktif']);


		//jika aktif
		if ($i_status == "true")
			{
			$i_status_ket = "[<font color='red'><strong>AKTIF</strong></font>].";
			$warna = "orange";
			}
		else if ($i_status == "false")
			{
			$i_status_ket = "";
			}


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>
		'.$i_nama.'
		</td>
		<td>
		'.$i_status_ket.'
		</td>
	    </tr>';
		}
	while ($row = mysql_fetch_assoc($q));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>TIDAK ADA DATA. </strong>
	</font>
	</p>';
	}

echo '</form>';
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

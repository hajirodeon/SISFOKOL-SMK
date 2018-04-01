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
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "komentar.php";
$judul = "Daftar Komentar";
$judulku = "$judul  [$adm_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$katkd = nosql($_REQUEST['katkd']);
$kdku = nosql($_REQUEST['kdku']);








//jika daftar
if($_POST['btnDF'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
	
	



//jika hapus data
if($_POST['btnHPS'])
	{
	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM cp_artikel_komentar ".
						"WHERE kd = '$kd'");
		}



	//re-direct
	xloc($filenya);
	exit();
	}






//jika balas
if ($_POST['btnSMP'])
	{
	//nilai
	$kdku = nosql($_POST['kdku']);
	$katkd = nosql($_POST['katkd']);
	$s = nosql($_POST['s']);
	$e_balas = cegah($_POST['e_balas']);
	
	
	//insert
	mysql_query("INSERT INTO cp_artikel_komentar(kd, kd_artikel, isi, postdate) VALUES ".
					"('$x', '$katkd', '$e_balas', '$today')");
	
	
	//re-direct
	xloc($filenya);
	exit();
	}
	






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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/editor.js");
xheadline($judul);




echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">';

//jika balas
if ($s == "balas")
	{
	//rincian komentar
	$qku = mysql_query("SELECT * FROM cp_artikel_komentar ".
							"WHERE kd = '$kdku'");
	$rku = mysql_fetch_assoc($qku);
	$ku_isi = balikin($rku['isi']);
	$ku_nama = balikin($rku['nama']);
	
	echo '<p>
	Komentar : 
	<br>
	<u><b>'.$ku_isi.'</b></u>
	</p>
	
	<p>
	Dari nama : <b>'.$ku_nama.'</b>.
	</p>
	
	<p>
	Isi Balasan : 
	<br>
	<textarea id="e_balas" name="e_balas" rows="20" cols="80" style="width: 100%"></textarea>
	</p>
	
	<p>
	<input name="s" id="s" type="hidden" value="'.$s.'">
	<input name="kdku" id="kdku" type="hidden" value="'.$kdku.'">
	<input name="katkd" id="katkd" type="hidden" value="'.$katkd.'">
	<button name="btnSMP" id="btnSMP" type="submit" value="SIMPAN" class="search_btn"><img src="'.$sumber.'/img/save.png" alt="simpan">SIMPAN</button>
	<button name="btnBTL" id="btnBTL" type="reset" value="BATAL" class="search_btn"><img src="'.$sumber.'/img/reset.png" alt="batal">BATAL</button>
	</p>
	';
	}

else 
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlcount = "SELECT * FROM cp_artikel_komentar ".
					"ORDER BY postdate DESC";
	$sqlresult = $sqlcount;
	
	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	
	
	if ($count != 0)
		{
		//view data
		echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">Postdate</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Judul Artikel</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Alamat</font></strong></td>
		<td><strong><font color="'.$warnatext.'">E-Mail</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Isi</font></strong></td>
		<td width="10"><strong><font color="'.$warnatext.'">BALAS</font></strong></td>
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
			$i_kd = nosql($data['kd']);
			$i_katkd = nosql($data['kd_artikel']);
			$i_nama = balikin($data['nama']);
			$i_alamat = balikin($data['alamat']);
			$i_email = balikin($data['email']);
			$i_isi = balikin($data['isi']);
			$i_postdate = $data['postdate'];
	
	
			//detail artikel
			$qku = mysql_query("SELECT * FROM cp_artikel ".
								"WHERE kd = '$i_katkd'");
			$rku = mysql_fetch_assoc($qku);
			$ku_artikel = balikin($rku['judul']);
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$i_kd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>'.$i_postdate.'</td>
			<td>'.$ku_artikel.'</td>
			<td>'.$i_nama.'</td>
			<td>'.$i_alamat.'</td>
			<td>'.$i_email.'</td>
			<td>'.$i_isi.'</td>
			<td>
			<a href="'.$filenya.'?s=balas&kdku='.$i_kd.'&katkd='.$i_katkd.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));
	
		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="300">
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="s" type="hidden" value="'.nosql($_REQUEST['s']).'">
		<input name="m" type="hidden" value="'.nosql($_REQUEST['m']).'">
		<input name="kdku" type="hidden" value="'.nosql($_REQUEST['kdku']).'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
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



echo '</form>';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>
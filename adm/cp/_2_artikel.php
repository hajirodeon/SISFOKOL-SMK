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
$filenya = "artikel.php";
$judul = "Data Artikel";
$judulku = "$judul  [$adm_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kdku = nosql($_REQUEST['kdku']);
$katkd = nosql($_REQUEST['katkd']);








//jika daftar
if($_POST['btnDF'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
	
	

//jika simpan
if($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kdku = nosql($_POST['kdku']);
	$e_judul = cegah($_POST['e_judul']);
	$e_isi = cegah2($_POST['editor']);
	$e_kategori2 = cegah($_POST['e_kategori2']);
	$e_submenu = cegah($_POST['e_submenu']);
	$e_headline = cegah($_POST['e_headline']);


	
	//nek null
	if ((empty($e_kategori2)) OR (empty($e_judul)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=baru&kdku=$x";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ((empty($s)) OR ($s == "baru"))
			{
			$kdku = $x;
			
			//query
			mysql_query("INSERT INTO cp_artikel(kd, kd_kategori, judul, isi, postdate, kd_submenu, kd_posisi) VALUES ".
							"('$kdku', '$e_kategori2', '$e_judul', '$e_isi', '$today', '$e_submenu', '$e_headline')");

			//update submenu
			mysql_query("UPDATE cp_m_submenu SET kd_artikel = '$kdku' ".
							"WHERE kd = '$e_submenu'");

			//update headline
			mysql_query("UPDATE cp_m_posisi SET kd_artikel = '$kdku' ".
							"WHERE kd = '$e_headline'");
								
			//re-direct
			$ke = "$filenya?s=edit&kdku=$kdku";
			xloc($ke);
			exit();
			}
		else 
			{
			//query
			mysql_query("UPDATE cp_artikel SET judul = '$e_judul', ".
							"isi = '$e_isi', ".
							"kd_kategori = '$e_kategori2', ".
							"kd_submenu = '$e_submenu', ".
							"kd_posisi = '$e_headline', ".
							"postdate = '$today' ".
							"WHERE kd = '$kdku'");

			//update submenu
			mysql_query("UPDATE cp_m_submenu SET kd_artikel = '$kdku' ".
							"WHERE kd = '$e_submenu'");

			//update headline
			mysql_query("UPDATE cp_m_posisi SET kd_artikel = '$kdku' ".
							"WHERE kd = '$e_headline'");
			
			//re-direct
			$ke = "$filenya?s=edit&kdku=$kdku";
			xloc($ke);
			exit();
			}
		}


	exit();
	}






//jika hapus data
if($_POST['btnHPS'])
	{
	//ambil nilai
	$katkd = nosql($_POST['katkd']);


	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM cp_artikel ".
						"WHERE kd = '$kd'");

						
		//update headline
		mysql_query("UPDATE cp_m_posisi SET kd_artikel = '' ".
						"WHERE kd_artikel = '$kd'");
					
		}



	//re-direct
	$ke = "$filenya?katkd=$katkd";
	xloc($ke);
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




echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Kategori : ';
echo "<select name=\"e_kategori\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx2 = mysql_query("SELECT * FROM cp_m_kategori ".
						"WHERE kd = '$katkd'");
$rowstx2 = mysql_fetch_assoc($qstx2);
$stx2_kd = nosql($rowstx2['kd']);
$stx2_kode1 = nosql($rowstx2['no']);
$stx2_nama1 = balikin($rowstx2['nama']);

echo '<option value="'.$stx2_kd.'" selected>--'.$stx2_nama1.'--</option>';

$qst = mysql_query("SELECT * FROM cp_m_kategori ".
						"ORDER BY nama ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_kode1 = nosql($rowst['kode']);
	$st_nama1 = balikin($rowst['nama']);

	//query
	$q = mysql_query("SELECT * FROM cp_artikel ".
						"WHERE kd_kategori = '$st_kd'");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	echo '<option value="'.$filenya.'?katkd='.$st_kd.'">'.$st_nama1.' [Jumlah : '.$total.'].</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>

<input name="katkd" type="hidden" value="'.$katkd.'">
<input name="s" type="hidden" value="'.$s.'">
</td>
</tr>
</table>
</p>

[<a href="'.$filenya.'?s=baru&kdku='.$x.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>Entri Baru]';




//jika edit
//tampilkan form
if (($s == 'baru') OR ($s == 'edit'))
	{
	//query
	$qx = mysql_query("SELECT cp_artikel.*, ".
						"cp_m_kategori.nama AS mknama ".
						"FROM cp_artikel, cp_m_kategori ".
						"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
						"AND cp_artikel.kd = '$kdku'");
	$rowx = mysql_fetch_assoc($qx);
	$e_judul = balikin($rowx['judul']);
	$e_isi = balikin2($rowx['isi']);
	$e_kategori = balikin($rowx['mknama']);
	$katkd = nosql($rowx['kd_kategori']);
	$submenukd = nosql($rowx['kd_submenu']);
	$poskd = nosql($rowx['kd_posisi']);
	$e_postdate = $rowx['postdate'];

	//pecah titik - titik
	$e_isi2 = pathasli2($e_isi);
	
	
	echo '<h2>Entri Baru/Edit</h2>
	<hr>
		
	<p>
	Judul : 
	<br>
	<input name="e_judul" id="e_judul" type="text" value="'.$e_judul.'" size="50">
	</p>
	
	<p>
	Isi : 
	<br>
	<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$e_isi2.'</textarea>
	</p>
	<br>
	
	<p>
	Kategori :
	<br>
	<select name="e_kategori2" id="e_kategori2">';
	
	//terpilih
	$qstx2 = mysql_query("SELECT * FROM cp_m_kategori ".
							"WHERE kd = '$katkd'");
	$rowstx2 = mysql_fetch_assoc($qstx2);
	$stx2_kd = nosql($rowstx2['kd']);
	$stx2_kode1 = nosql($rowstx2['no']);
	$stx2_nama1 = balikin($rowstx2['nama']);
	
	echo '<option value="'.$stx2_kd.'" selected>--'.$stx2_nama1.'--</option>';
	
	$qst = mysql_query("SELECT * FROM cp_m_kategori ".
							"ORDER BY nama ASC");
	$rowst = mysql_fetch_assoc($qst);
	
	do
		{
		$st_kd = nosql($rowst['kd']);
		$st_kode1 = nosql($rowst['kode']);
		$st_nama1 = balikin($rowst['nama']);
	
		//query
		$q = mysql_query("SELECT * FROM cp_artikel ".
							"WHERE kd_kategori = '$st_kd'");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);
	
	
	
		echo '<option value="'.$st_kd.'">'.$st_nama1.' [Jumlah : '.$total.'].</option>';
		}
	while ($rowst = mysql_fetch_assoc($qst));
	
	echo '</select>
	</p>
	
	

	<p>
	Bila Menjadi SubMenu Navigasi :
	<br>
	<select name="e_submenu" id="e_submenu">';
	
	//terpilih
	$qstx2 = mysql_query("SELECT cp_m_menu.nama AS mmenu, ".
								"cp_m_submenu.* ".
								"FROM cp_m_submenu, cp_m_menu ".
								"WHERE cp_m_submenu.kd_menu = cp_m_menu.kd ".
								"AND cp_m_submenu.kd = '$submenukd'");
	$rowstx2 = mysql_fetch_assoc($qstx2);
	$stx2_kd = nosql($rowstx2['kd']);
	$stx2_nama1 = balikin($rowstx2['nama']);
	
	echo '<option value="'.$stx2_kd.'" selected>--'.$stx2_nama1.'--</option>';
	
	$qst = mysql_query("SELECT cp_m_menu.nama AS mmenu, ".
							"cp_m_submenu.* ".
							"FROM cp_m_submenu, cp_m_menu ".
							"WHERE cp_m_submenu.kd_menu = cp_m_menu.kd ".
							"ORDER BY cp_m_menu.nama ASC, ".
							"cp_m_submenu.nama ASC");
	$rowst = mysql_fetch_assoc($qst);
	
	do
		{
		$st_kd = nosql($rowst['kd']);
		$st_mmenu = balikin($rowst['mmenu']);
		$st_nama1 = balikin($rowst['nama']);
	
	
		echo '<option value="'.$st_kd.'">['.$st_mmenu.']. '.$st_nama1.'</option>';
		}
	while ($rowst = mysql_fetch_assoc($qst));
	
	echo '<option value="">-</option>
	</select>
	</p>

	
	
	<p>
	Bila Menjadi Headline Halaman Depan :
	<br>
	<select name="e_headline" id="e_headline">';
	
	//terpilih
	$qstx2 = mysql_query("SELECT cp_m_posisi.* ".
								"FROM cp_m_posisi ".
								"WHERE kd = '$poskd'");
	$rowstx2 = mysql_fetch_assoc($qstx2);
	$stx2_kd = nosql($rowstx2['kd']);
	$stx2_nama1 = balikin($rowstx2['nama']);
	
	echo '<option value="'.$stx2_kd.'" selected>--'.$stx2_nama1.'--</option>';
	
	$qst = mysql_query("SELECT * FROM cp_m_posisi ".
							"ORDER BY round(no) ASC");
	$rowst = mysql_fetch_assoc($qst);
	
	do
		{
		$st_kd = nosql($rowst['kd']);
		$st_nama1 = balikin($rowst['nama']);
	
	
		echo '<option value="'.$st_kd.'">'.$st_nama1.'</option>';
		}
	while ($rowst = mysql_fetch_assoc($qst));
	
	echo '<option value="">-</option>
	</select>
	</p>
		
	<p>
	<input name="kdku" id="kdku" type="hidden" value="'.$kdku.'">
	<input name="katkd" id="katkd" type="hidden" value="'.$katkd.'">
	<button name="btnSMP" id="btnSMP" type="submit" value="SIMPAN" class="search_btn"><img src="'.$sumber.'/img/save.png" alt="simpan">SIMPAN</button>
	<button name="btnDF" id="btnDF" type="submit" value="KEMBALI KE DAFTAR" class="search_btn"><img src="'.$sumber.'/img/reset.png" alt="batal">KEMBALI KE DAFTAR >></button>
	</p>';
	}
else 
	{
	//jika null
	if (empty($katkd))
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT * FROM cp_artikel ".
						"ORDER BY postdate DESC";
		$sqlresult = $sqlcount;
	
		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}
	else 
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT * FROM cp_artikel ".
						"WHERE kd_kategori = '$katkd' ".
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
			<td width="1">&nbsp;</td>
			<td width="200"><strong><font color="'.$warnatext.'">Judul</font></strong></td>
			<td><strong><font color="'.$warnatext.'">ISI</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Postdate</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">SubMenu Navigasi</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Headline</font></strong></td>
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
				$i_judul = balikin($data['judul']);
				$i_isi = balikin($data['isi']);
				$i_postdate = $data['postdate'];
				$i_submenukd = nosql($data['kd_submenu']);
				$i_poskd = nosql($data['kd_posisi']);
	
				//detail
				$qku = mysql_query("SELECT cp_m_menu.nama AS mmenu, ".
										"cp_m_submenu.* ".
										"FROM cp_m_submenu, cp_m_menu ".
										"WHERE cp_m_submenu.kd_menu = cp_m_menu.kd ".
										"AND cp_m_submenu.kd = '$i_submenukd'");
				$rku = mysql_fetch_assoc($qku);
				$ku_mmenu = balikin($rku['mmenu']);
				$ku_nama = balikin($rku['nama']);	


				//detail
				$qku2 = mysql_query("SELECT * FROM cp_m_posisi ".
										"WHERE kd = '$i_poskd'");
				$rku2 = mysql_fetch_assoc($qku2);
				$ku2_nama = balikin($rku2['nama']);	


	
				//pecah titik - titik
				$i_isi2 = pathasli2($i_isi);
	
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$i_kd.'">
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	    		</td>
				<td>
				<a href="'.$filenya.'?s=edit&kdku='.$i_kd.'" title="EDIT..."><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
				</td>
				<td>'.$i_judul.'</td>
				<td>'.$i_isi2.'</td>
				<td>'.$i_postdate.'</td>
				<td>['.$ku_mmenu.']. '.$ku_nama.'</td>
				<td>'.$ku2_nama.'</td>
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
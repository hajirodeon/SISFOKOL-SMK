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



require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");

nocache;


$filenya = "artikel.php";
$filenyax = "i_artikel.php";


//tampilkan form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'input'))
//if ((isset($_REQUEST['aksi']) && $_REQUEST['aksi'] == 'input'))
	{
	$katkd = nosql($_GET['katkd']);

	echo '<form name="formx" id="formx">
	<h2>Entri Baru</h2>
	<hr>
		
	<p>
	Judul : 
	<br>
	<input name="e_judul" id="e_judul" type="text" value="'.$e_tapel.'" size="50">
	</p>
	
	<p>
	Isi : 
	<br>
	<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">akuhajir</textarea>
	</p>
	<br>
	
	
	
	<p>
	<input name="kdku" id="kdku" type="hidden" value="'.$x.'">
	<input name="katkd" id="katkd" type="hidden" value="'.$katkd.'">
	<button name="btnSMP" id="btnSMP" type="submit" value="SIMPAN" class="search_btn"><img src="'.$sumber.'/img/save.png" alt="simpan">SIMPAN</button>
	<button name="btnDF" id="btnDF" type="submit" value="KEMBALI KE DAFTAR" class="search_btn"><img src="'.$sumber.'/img/reset.png" alt="batal">KEMBALI KE DAFTAR >></button>
	</p>
	</form>';
	}




//tampilkan form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'edit'))
	{
	//nilai
	$kdku = nosql($_GET['kdku']);
	$s = "edit";

	//query
	$qx = mysql_query("SELECT cp_artikel.*, ".
						"cp_m_kategori.nama AS mknama ".
						"FROM cp_artikel, cp_m_kategori ".
						"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
						"AND cp_artikel.kd = '$kdku'");
	$rowx = mysql_fetch_assoc($qx);
	$e_judul = balikin($rowx['judul']);
	$e_isi = balikin($rowx['isi']);
	$e_kategori = balikin($rowx['mknama']);
	$katkd = nosql($rowx['kd_kategori']);
	$e_postdate = $rowx['postdate'];




	echo '<form name="formx2" id="formx2">
	<h2>Edit</h2>
	<hr>

	
	<p>
	Judul : 
	<br>
	<input name="e_judul" id="e_judul" type="text" value="'.$e_judul.'" size="50">
	</p>
	
	<p>
	Isi :
	<br>
	<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$e_isi.'</textarea>
	</p>

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
	<input name="s" id="s" type="hidden" value="'.$s.'">
	<input name="kdku" id="kd" type="hidden" value="'.$kdku.'">
	<input name="katkd" id="katkd" type="hidden" value="'.$katkd.'">
	<button name="btnSMP2" id="btnSMP2" type="submit" value="SIMPAN" class="search_btn"><img src="'.$sumber.'/img/save.png" alt="simpan">SIMPAN</button>
	<button name="btnDF2" id="btnDF2" type="submit" value="KEMBALI KE DAFTAR" class="search_btn"><img src="'.$sumber.'/img/reset.png" alt="batal">KEMBALI KE DAFTAR >></button>
	</p>	
	</form>
	<hr>';
	}








//tampilkan data
if(isset($_GET['aksi']) && $_GET['aksi'] == 'daftar')
	{
	//nilai
	$katkd = nosql($_GET['katkd']);
	
	//jika null
	if (empty($katkd))
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT cp_artikel.*, ".
						"cp_m_kategori.nama AS mknama ".
						"FROM cp_artikel, cp_m_kategori ".
						"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
						"ORDER BY cp_artikel.postdate DESC, ".
						"cp_m_kategori.nama ASC";
		$sqlresult = $sqlcount;
	
		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katkd=$katkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}
	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT cp_artikel.*, ".
						"cp_m_kategori.nama AS mknama ".
						"FROM cp_artikel, cp_m_kategori ".
						"WHERE cp_artikel.kd_kategori = cp_m_kategori.kd ".
						"AND cp_m_kategori.kd = '$katkd' ".
						"ORDER BY cp_artikel.postdate DESC, ".
						"cp_m_kategori.nama ASC";
		$sqlresult = $sqlcount;
	
		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katkd=$katkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		
		
				
//		echo '[<a href="#" onclick="$(\'#fdata\').hide();$(\'#finput\').load(\''.$filenyax.'?katkd='.$_GET[katkd].'&aksi=input\', );"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>Entri Baru]';
?>
		[<a href="#" onclick="$('#fdata').hide();$('#finput').load('<?php
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


 echo $filenyax;?>?katkd=<?php
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


 $_GET[katkd];?>&aksi=input', function() {
      tinyMCE.init({ 
	      	theme : "advanced", 
	        mode : "textareas", 
	        plugins : "fullpage", 
	        theme_advanced_buttons3_add : "fullpage"  
      });  
    }
    
    );"><img src="<?php
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


 echo $sumber;?>/img/edit.gif" width="16" height="16" border="0"></a>Entri Baru]

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



		}
		
		
	if ($count != 0)
		{
		echo '<form name="formx3" id="formx3">
		<table width="1100" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="250"><strong><font color="'.$warnatext.'">Judul</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Isi</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Postdate</font></strong></td>
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
			$kd = nosql($data['kd']);
			$i_judul = balikin($data['judul']);
			$i_isi = balikin($data['isi']);
			$i_kategori = balikin($data['mknama']);
			$i_postdate = $data['postdate'];


			
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" class="cb-elementa" name="itema'.$nomer.'" id="itema'.$nomer.'" value="'.$kd.'">
			</td>
			<td>
			<a href="#" onclick="$(\'#fdata\').hide();$(\'#finput\').load(\''.$filenyax.'?aksi=edit&kdku='.$kd.'\');">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_judul.'</td>
			<td>'.$i_isi.'</td>
			<td>'.$i_kategori.'</td>
			<td>'.$i_postdate.'</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '<tr valign="top" bgcolor="'.$warnaheader.'">
		<td><input type="checkbox" class="checkAlla"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="jml" id="jml" type="hidden" value="'.$count.'">
		<input name="katkd" id="katkd" type="hidden" value="'.$katkd.'">
		<button name="btnHPS" id="btnHPS" type="submit" value="HAPUS" class="search_btn"><img src="'.$sumber.'/img/trash.png" alt="delete">HAPUS</button>
		Total : <strong><font color="#FF0000">'.$count.'</font></strong> Data. 		
		'.$pagelist.'
		</td>
		</tr>
		</table>
		</form>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
		</font>
		</p>';
		}


	exit();
	}





//jika simpan baru
if(isset($_GET['aksi']) && $_GET['aksi'] == 'simpan')
	{
	sleep(1);
	$s = nosql($_POST['s']);
	$katkd = nosql($_POST['katkd']);
	$kdku = nosql($_POST['kdku']);

	$e_judul = cegah($_POST['e_judul']);
	$e_isi = cegah($_POST['e_isi']);


	
	//nek null
	if ((empty($katkd)) OR (empty($e_judul)))
		{
		echo '<p>
		<b>
		<font color="red">
		Input Tidak Lengkap. Harap Diulangi...!!
		</font>
		</b>
		</p>';
		}
	else
		{

		//query
		mysql_query("INSERT INTO cp_artikel(kd, kd_kategori, judul, isi, postdate, kd_submenu) VALUES ".
						"('$kdku', '$katkd', '$e_judul', '$e_isi', '$today', '$e_submenu')");

						
		echo '<p>
		<b>
		<font color="red">
		Input Berhasil.
		</font>
		</b>
		</p>';
		}


	exit();
	}







//jika simpan edit
if(isset($_GET['aksi']) && $_GET['aksi'] == 'simpan2')
	{
	sleep(1);	
	$s = nosql($_POST['s']);
	$kdku = nosql($_POST['kdku']);
	$katkd = nosql($_POST['katkd']);

	$e_judul = cegah($_POST['e_judul']);
	$e_isi = cegah($_POST['e_isi']);
	$e_kategori2 = cegah($_POST['e_kategori2']);


	
	//nek null
	if ((empty($katkd)) OR (empty($e_judul)))
		{
		echo '<p>
		<b>
		<font color="red">
		Input Tidak Lengkap. Harap Diulangi...!!
		</font>
		</b>
		</p>';
		}
	else
		{
		//query
		mysql_query("UPDATE cp_artikel SET judul = '$e_judul', ".
						"isi = '$e_isi', ".
						"kd_kategori = '$e_kategori2', ".
						"postdate = '$today' ".
						"WHERE kd = '$kdku'");
												
						
		echo '<p>
		<b>
		<font color="red">
		Update Berhasil.
		</font>
		</b>
		</p>';
		}


	exit();
	}












//jika hapus data artikel
if(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus')
	{
	//ambil nilai
	$katkd = nosql($_POST['katkd']);
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "itema";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM cp_artikel ".
						"WHERE kd = '$kd'");
		}



	echo '<p>
	<b>
	<font color="red">
	Berhasil Dihapus.
	</font>
	</b>
	</p>';

	//re-direct
	xloc($filenya);
	exit();
	}







//jika ke home
if(isset($_GET['aksi']) && $_GET['aksi'] == 'home')
	{
	//re-direct
	xloc($filenya);

	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
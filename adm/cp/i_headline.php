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
nocache;


$filenyax = "i_headline.php";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//tampilkan data
if(isset($_GET['aksi']) && $_GET['aksi'] == 'daftar')
	{
	//query
	$q = mysql_query("SELECT cp_m_posisi.* ".
						"FROM cp_m_posisi ".
						"ORDER BY round(cp_m_posisi.no) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	if ($total != 0)
		{
		echo '<form name="formx3" id="formx3">
		<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="50"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="250"><strong><font color="'.$warnatext.'">Terhubung Halaman</font></strong></td>
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
			$kd = nosql($row['kd']);
			$e_no = balikin($row['no']);
			$e_headline = balikin($row['nama']);
			$e_mmenu = balikin($row['mmenu']);
			
			
			//ketahui artikelnya
			$qku = mysql_query("SELECT * FROM cp_artikel ".
									"WHERE kd_posisi = '$kd'");
			$rku = mysql_fetch_assoc($qku);
			$ku_kd = nosql($rku['kd']);
			$ku_judul = balikin($rku['judul']);
			
			//update headline
			mysql_query("UPDATE cp_m_posisi SET kd_artikel = '$ku_kd' ".
							"WHERE kd = '$kd'");
			

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" class="cb-element" name="item'.$nomer.'" id="item'.$nomer.'" value="'.$kd.'">
			</td>
			<td>'.$e_no.'</td>
			<td>'.$e_headline.'</td>
			<td>';
			
			//jika gak  null
			if (!empty($ku_kd))
				{
				echo '[<a href="artikel.php?s=edit&kdku='.$ku_kd.'" title="EDIT..."><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>].
				'.$ku_judul.'';
				}
				
			echo '</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '<tr valign="top" bgcolor="'.$warnaheader.'">
		<td><input type="checkbox" class="checkAll"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="jml" id="jml" type="hidden" value="'.$total.'">
		<button name="btnHPS" id="btnHPS" type="submit" value="HAPUS" class="search_btn"><img src="'.$sumber.'/img/trash.png" alt="delete">HAPUS</button>
		Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
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

	//diskonek
	xclose($koneksi);
	exit();
	}









//jika hapus
if(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus')
	{
	sleep(1);
	//ambil nilai
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("UPDATE cp_m_posisi SET kd_artikel = '' ".
						"WHERE kd = '$kd'");
						
		//del
		mysql_query("UPDATE cp_artikel SET kd_posisi = '' ".
						"WHERE kd_posisi = '$kd'");
		
		}



	echo '<p>
	<b>
	<font color="red">
	Berhasil Dihapus.
	</font>
	</b>
	</p>';


	//diskonek
	xclose($koneksi);
	exit();
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
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



//nilai
$maine = "$sumber/index.php";

//data menu
//query
$q = mysql_query("SELECT * FROM cp_m_menu ".
					"ORDER BY no ASC");
$row = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="1300" border="0" cellspacing="0" cellpadding="5">
<tr height="10" bgcolor="black" background="'.$sumber.'/img/bg_hitam.png">';

do
	{
	$nomer = $nomer + 1;
	$kd = nosql($row['kd']);
	$e_no = balikin($row['no']);
	$e_menu = balikin($row['nama']);

	//query
	$q2 = mysql_query("SELECT cp_m_submenu.*, ".
						"cp_m_menu.nama AS mmenu ".
						"FROM cp_m_submenu, cp_m_menu ".
						"WHERE cp_m_submenu.kd_menu = cp_m_menu.kd ".
						"AND cp_m_menu.kd = '$kd' ".
						"ORDER BY round(cp_m_submenu.no) ASC");
	$row2 = mysql_fetch_assoc($q2);
	$total2 = mysql_num_rows($q2);

	echo "<td onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";

	echo '<A href="#" class="headerku2" data-flexmenu="flexmenu'.$nomer.'">.::<strong>'.$e_menu.'</strong>&nbsp;&nbsp;</A>
	<UL id="flexmenu'.$nomer.'" class="flexdropdownmenu">';
	do
		{
		$nomer = $nomer + 1;
		$kd = nosql($row2['kd']);
		$e_no = balikin($row2['no']);
		$e_submenu = balikin($row2['nama']);
		
		
		//ketahui artikelnya
		$qku = mysql_query("SELECT * FROM cp_artikel ".
								"WHERE kd_submenu = '$kd'");
		$rku = mysql_fetch_assoc($qku);
		$ku_kd = nosql($rku['kd']);
		$ku_judul = balikin($rku['judul']);
	
		echo '<LI>
		<a class="headerku2" href="'.$sumber.'/halaman.php?kd='.$ku_kd.'" title="'.$ku_judul.'">'.$ku_judul.'</a>
		</LI>';
	
		}
	while ($row2 = mysql_fetch_assoc($q2));


	echo '</UL>
	
	</td>';
	}
while ($row = mysql_fetch_assoc($q));


echo "<td onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
echo '<A href="'.$sumber.'/guru.php" class="headerku2" data-flexmenu="flexmenu40">.::<strong>GURU</strong>&nbsp;&nbsp;</A>
</td>';
	
echo "<td onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
echo '<A href="'.$sumber.'/siswa.php" class="headerku2" data-flexmenu="flexmenu41">.::<strong>SISWA</strong>&nbsp;&nbsp;</A>
</td>';

echo '</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

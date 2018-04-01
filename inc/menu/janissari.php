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
$maine = "$sumber/janissari/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>HOME</strong></a>&nbsp;&nbsp;| ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//kaplingku /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>KaplingKu</strong></A>&nbsp;&nbsp;|
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/janissari/k/profil/profil.php" title="Profil">Profil</a>
</LI>

<LI>
<a href="'.$sumber.'/janissari/k/status/status.php" title="Status">Status</a>
</LI>

<LI>
<a href="'.$sumber.'/janissari/k/note/note.php" title="Note">Note</a>
</LI>

<LI>
<a href="'.$sumber.'/janissari/k/msg/msg.php" title="Message">Message</a>
</LI>

<LI>
<a href="'.$sumber.'/janissari/k/kategori/kategori.php" title="Kategori">Kategori</a>
</LI>

<LI>
<a href="#" title="Tulisanku">Tulisanku</a>
<UL>
	<LI>
	<a href="'.$sumber.'/janissari/k/jurnal/jurnal.php" title="Jurnal">Jurnal</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/janissari/k/buletin/buletin.php" title="Buletin">Buletin</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/janissari/k/artikel/artikel.php" title="Artikel">Artikel</a>
	</LI>
</UL>
</LI>

<LI>
<a href="#" title="Koleksi">Koleksi</a>
<UL>
	<LI>
	<a href="'.$sumber.'/janissari/k/album/album.php" title="Album Foto">Album Foto</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/janissari/k/link/link.php" title="Link Favorit">Link Favorit</a>
	</LI>
</UL>
</LI>

<LI>
<a href="'.$sumber.'/janissari/k/logs/logs.php" title="Logs History">Logs History</a>
</LI>
</UL>';
//kaplingku /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//temanku ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu3"><strong>TEMANKU</strong></A>&nbsp;&nbsp;|
<UL id="flexmenu3" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/janissari/k/temanku/temanku.php" title="Daftar Temanku">Daftar</a>
</LI>
<LI>
<a href="'.$sumber.'/janissari/k/temanku/status.php" title="Status Temanku">Status</a>
</LI>
<LI>
<a href="'.$sumber.'/janissari/k/temanku/note.php" title="Note Temanku">Note</a>
</LI>
<LI>
<a href="'.$sumber.'/janissari/k/temanku/artikel.php" title="Artikel Temanku">Artikel</a>
</LI>
<LI>
<a href="'.$sumber.'/janissari/k/temanku/jurnal.php" title="Jurnal Temanku">Jurnal</a>
</LI>
<LI>
<a href="'.$sumber.'/janissari/k/temanku/buletin.php" title="Buletin Temanku">Buletin</a>
</LI>
<LI>
<a href="'.$sumber.'/janissari/k/temanku/ultah.php" title="Ulang Tahun Temanku">Ulang Tahun</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






echo '<a href="'.$sumber.'/'.$janiskd.'/index.php" title="SISFOKOL" class="menuku"><strong>SISFOKOL</strong></a>&nbsp;&nbsp;|';






//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '</td>
<td align="right">
[<font color="orange"><strong>'.$tipe_session.' : </strong></font>
<font color="red"><strong>'.$no1_session.'. '.$nm1_session.'</strong></font>]
</td>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<td width="10%" align="right">
<A href="'.$sumber.'/logout.php" title="Logout / KELUAR"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
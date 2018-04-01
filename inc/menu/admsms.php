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
$maine = "$sumber/admsms/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>Home</strong></a>&nbsp;&nbsp; | ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu1"><strong>SETTING</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu1" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admsms/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









//sms gateway //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu10" class="menuku"><strong>SMS GATEWAY</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu10" class="flexdropdownmenu">

<LI>
<a href="#" title="Siswa">Siswa</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admsms/sg/siswa_nohp.php" title="No.HP Siswa">No.HP Siswa</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsms/sg/siswa_info.php" title="Info">Info</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsms/sg/siswa_kirim_info.php" title="Kirim Info">Kirim Info</a>
	</LI>
	</UL>
</LI>
<LI>
<a href="#" title="Pegawai">Pegawai</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admsms/sg/pegawai_nohp.php" title="No.HP Pegawai">No.HP Pegawai</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsms/sg/pegawai_info.php" title="Info">Info</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsms/sg/pegawai_kirim_info.php" title="Kirim Info">Kirim Info</a>
	</LI>
	</UL>
</LI>


<LI>
<a href="'.$sumber.'/admsms/sg/poll.php?s=topik" title="Polling SMS">Polling SMS</a>
</LI>

<LI>
<a href="'.$sumber.'/admsms/sg/sms.php?s=inbox" title="Inbox">Inbox</a>
</LI>
<LI>
<a href="'.$sumber.'/admsms/sg/sms.php?s=outbox" title="OutBox">OutBox</a>
</LI>
<LI>
<a href="'.$sumber.'/admsms/sg/sms.php?s=sentitem" title="SentItem">SentItem</a>
</LI>
</UL>';
//sms gateway //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu27" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu27" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admsms/p/absensi.php" title="Absensi Kunjungan">Absensi Kunjungan</a>
</LI>
<LI>
<a href="'.$sumber.'/admsms/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admsms/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admsms/p/koleksi_buku.php" title="Koleksi Buku">Koleksi Buku</a>
</LI>
<LI>
<a href="'.$sumber.'/admsms/p/koleksi_majalah.php" title="Koleksi Majalah">Koleksi Majalah</a>
</LI>
<LI>
<a href="'.$sumber.'/admsms/p/koleksi_cd.php" title="Koleksi CD">Koleksi CD</a>
</LI>
</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//jejaring sosial ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$sumber.'/janissari/index.php" title="E-Network" class="menuku"><strong>E-Network</strong>&nbsp;&nbsp;</A> | ';
//jejaring sosial ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="'.$sumber.'/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
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
$maine = "$sumber/admkepg/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>Home</strong>&nbsp;&nbsp;</A> | ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu1"><strong>SETTING</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu1" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admkepg/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>MASTER</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admkepg/m/pangkat.php" title="Pangkat">Pangkat</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/jabatan.php" title="Jabatan">Jabatan</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/golongan.php" title="Golongan">Golongan</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/gapok.php" title="Gaji Pokok">Gaji Pokok</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/agama.php" title="Agama">Agama</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/pekerjaan.php" title="Pekerjaan">Pekerjaan</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/ijazah.php" title="Ijazah">Ijazah</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/status.php" title="Status">Status</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/akta.php" title="Akta">Akta</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/m/pegawai.php" title="Pegawai">Pegawai</a>
</LI>
</UL>';
//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//statistik ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu82"><strong>STATISTIK</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu82" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admkepg/st/jml_pegawai_agama.php" title="Jumlah Pegawai Menurut Agama">Jumlah Pegawai Menurut Agama</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/st/jml_pegawai_ijazah.php" title="Jumlah Pegawai Menurut Ijazah">Jumlah Pegawai Menurut Ijazah</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/st/jml_pegawai_pangkat.php" title="Jumlah Pegawai Menurut Pangkat">Jumlah Pegawai Menurut Pangkat</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/st/jml_pegawai_jabatan.php" title="Jumlah Pegawai Menurut Jabatan">Jumlah Pegawai Menurut Jabatan</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/st/jml_pegawai_umur.php" title="Jumlah Pegawai Menurut Umur">Jumlah Pegawai Menurut Umur</a>
</LI>
</UL>';
//inventaris ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu27" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu27" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admkepg/p/absensi.php" title="Absensi Kunjungan">Absensi Kunjungan</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/p/koleksi_buku.php" title="Koleksi Buku">Koleksi Buku</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/p/koleksi_majalah.php" title="Koleksi Majalah">Koleksi Majalah</a>
</LI>
<LI>
<a href="'.$sumber.'/admkepg/p/koleksi_cd.php" title="Koleksi CD">Koleksi CD</a>
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
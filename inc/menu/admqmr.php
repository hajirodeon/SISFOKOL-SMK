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
$maine = "$sumber/admqmr/index.php";


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
<a href="'.$sumber.'/admqmr/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>DATA</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="#" title="Mata Pelajaran">Mata Pelajaran</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admqmr/m/mapel.php" title="Data Mata Pelajaran">Data Mata Pelajaran</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admqmr/m/mapel_kelas.php" title="Mata Pelajaran per Kelas">Mata Pelajaran per Kelas</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Guru">Guru</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admqmr/m/guru.php" title="Guru">Guru</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admqmr/m/guru_mapel_k.php" title="Guru Mata Pelajaran per Kelas">Guru Mata Pelajaran per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admqmr/m/guru_mapel_tmp.php" title="Penempatan Guru Mengajar">Penempatan Guru Mengajar</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admqmr/m/wk.php" title="Wali Kelas">Wali Kelas</a>
	</LI>
	</UL>
</LI>


<LI>
<a href="#" title="Siswa">Siswa</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admqmr/m/siswa.php" title="Data Siswa">Data Siswa</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admqmr/m/siswa_tmp_k.php" title="Data Siswa per Kelas">Data Siswa per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admqmr/m/siswa_tmp_keah.php" title="Data Siswa per Keahlian">Data Siswa per Keahlian</a>
	</LI>
	</UL>
</LI>
</UL>';
//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$sumber.'/admqmr/jwl/jadwal.php" title="Jadwal Pelajaran" class="menuku"><strong>Jadwal Pelajaran</strong>&nbsp;&nbsp;</A> | ';
//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//laporan ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu3"><strong>LAPORAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu3" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admqmr/lap/keamanan.php" title="Keamanan Sekolah">Keamanan Sekolah</a>
</LI>
<LI>
<a href="'.$sumber.'/admqmr/lap/kebersihan.php" title="Kebersihan Sekolah">Kebersihan Sekolah</a>
</LI>

<LI>
<a href="'.$sumber.'/admqmr/lap/raport.php" title="Raport Siswa">Raport Siswa</a>
</LI>

<LI>
<a href="'.$sumber.'/admqmr/lap/abs_rekap_kelas.php" title="Rekap Absensi per Kelas">Rekap Absensi per Kelas</a>
</LI>
</UL>';
//laporan ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu27" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu27" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admqmr/p/absensi.php" title="Absensi Kunjungan">Absensi Kunjungan</a>
</LI>
<LI>
<a href="'.$sumber.'/admqmr/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admqmr/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admqmr/p/koleksi_buku.php" title="Koleksi Buku">Koleksi Buku</a>
</LI>
<LI>
<a href="'.$sumber.'/admqmr/p/koleksi_majalah.php" title="Koleksi Majalah">Koleksi Majalah</a>
</LI>
<LI>
<a href="'.$sumber.'/admqmr/p/koleksi_cd.php" title="Koleksi CD">Koleksi CD</a>
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
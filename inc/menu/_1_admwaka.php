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
$maine = "$sumber/admwaka/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>HOME</strong>&nbsp;&nbsp;</a> | ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu1"><strong>SETTING</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu1" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admwaka/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>MASTER</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admwaka/m/tapel.php" title="Tahun Pelajaran">Tahun Pelajaran</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/m/kelas.php" title="Kelas">Kelas</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/m/ruang.php" title="Ruang">Ruang</a>
</LI>
</UL>';
//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//akademik //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu3"><strong>AKADEMIK</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu3" class="flexdropdownmenu">
<LI>
<a href="#" title="Keahlian">Keahlian</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/keahlian_prog.php" title="Program Keahlian">Program Keahlian</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/keahlian_komp.php" title="Kompetensi Keahlian">Kompetensi Keahlian</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Mata Pelajaran">Mata Pelajaran</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/prog_pddkn.php" title="Data Mata Pelajaran">Data Mata Pelajaran</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/prog_pddkn_kelas.php" title="Mata Pelajaran per Kelas">Mata Pelajaran per Kelas</a>
	</LI>
	</UL>
</LI>


<LI>
<a href="#" title="Sikap">Sikap</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admwaka/sikap/dirisendiri.php" title="Data Sikap Jujur">Data Sikap Jujur</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/sikap/antarteman.php" title="Data Sikap Disiplin">Data Sikap Disiplin</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/sikap/observasi.php" title="Data Sikap Spiritual">Data Sikap Spiritual</a>
	</LI>
	</UL>
</LI>



<LI>
<a href="#" title="Guru">Guru</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/guru_prog_pddkn_tmp.php" title="Penempatan Guru Mengajar">Penempatan Guru Mengajar</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/wk.php" title="Wali Kelas">Wali Kelas</a>
	</LI>
	</UL>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/akad/siswa.php" title="Siswa">Siswa</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/siswa_tmp_k.php" title="Penempatan Siswa per Kelas">Penempatan Siswa per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/siswa_tmp_kea.php" title="Penempatan Siswa per Keahliean">Penempatan Siswa per Keahlian</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/siswa_kenaikan.php" title="Kenaikan Kelas">Kenaikan Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/siswa_history.php" title="History Kelas">History Kelas</a>
	</LI>
	</UL>
</LI>
</UL>';
//akademik //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu4"><strong>JADWAL</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu4" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admwaka/jwal/pel.php" title="Jadwal Pelajaran per Kelas">Jadwal Pelajaran per Kelas</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/jwal/pel_hari.php" title="Jadwal Pelajaran per Hari">Jadwal Pelajaran per Hari</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/jwal/guru.php" title="Jadwal Guru Mengajar">Jadwal Guru Mengajar</a>
</LI>
</UL>';
//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//statistik ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu82"><strong>STATISTIK</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu82" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admwaka/st/jml_siswa_kelas.php" title="Jumlah Siswa Menurut Kelas">Jumlah Siswa Menurut Kelas</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/st/jml_siswa_kelamin.php" title="Jumlah Siswa Menurut Kelamin">Jumlah Siswa Menurut Kelamin</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/st/jml_siswa_umur.php" title="Jumlah Siswa Menurut Umur">Jumlah Siswa Menurut Umur</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/st/jml_siswa_agama.php" title="Jumlah Siswa Menurut Agama">Jumlah Siswa Menurut Agama</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/st/rata_nilai_siswa_kelas.php" title="Rata - Rata Nilai Siswa per Kelas">Rata - Rata Nilai Siswa per Kelas</a>
</LI>
</UL>';
//statistik ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//rekap //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu41"><strong>REKAP DATA</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu41" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admwaka/rekap/nilai_siswa.php" title="Nilai Siswa">Nilai Siswa</a>
</LI>

<LI>
<a href="#" title="Rekap Data Siswa">Data Siswa</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admwaka/rekap/siswa_per_abjad.php" title="Data Siswa per Abjad">Data Siswa per Abjad</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/rekap/siswa_per_kelas.php" title="Data Siswa per Kelas">Data Siswa per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/rekap/siswa_per_kelamin.php" title="Data Siswa per Jenis Kelamin">Data Siswa per Jenis Kelamin</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/rekap/siswa_per_usia.php" title="Data Siswa per Jenis Kelamin">Data Siswa per Usia</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/rekap/siswa_per_income.php" title="Data Siswa per Income ORTU">Data Siswa per Income ORTU</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/rekap/siswa_per_pddkn.php" title="Data Siswa per Pendidikan ORTU">Data Siswa per Pendidikan ORTU</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/rekap/siswa_per_kerja.php" title="Data Siswa per Pekerjaan ORTU">Data Siswa per Pekerjaan ORTU</a>
	</LI>
	</UL>
</LI>
</UL>';
//rekap //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu27" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu27" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admwaka/p/absensi.php" title="Absensi Kunjungan">Absensi Kunjungan</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/p/koleksi_buku.php" title="Koleksi Buku">Koleksi Buku</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/p/koleksi_majalah.php" title="Koleksi Majalah">Koleksi Majalah</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/p/koleksi_cd.php" title="Koleksi CD">Koleksi CD</a>
</LI>
</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//jejaring sosial ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$sumber.'/janissari/index.php" title="E-Network" class="menuku"><strong>E-Network</strong>&nbsp;&nbsp;</A> | ';
//jejaring sosial ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="'.$sumber.'/admwaka/logout.php" class="menuku" title="Logout / KELUAR"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

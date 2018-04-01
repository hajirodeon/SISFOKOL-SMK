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
$maine = "$sumber/admtu/index.php";


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
<a href="'.$sumber.'/admtu/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>MASTER</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/m/tapel.php" title="Tahun Pelajaran">Tahun Pelajaran</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/kelas.php" title="Kelas">Kelas</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/ruang.php" title="Ruang">Ruang</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/pangkat.php" title="Pangkat">Pangkat</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/jabatan.php" title="Jabatan">Jabatan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/golongan.php" title="Golongan">Golongan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/gapok.php" title="Gaji Pokok">Gaji Pokok</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/agama.php" title="Agama">Agama</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/pekerjaan.php" title="Pekerjaan">Pekerjaan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/ijazah.php" title="Ijazah">Ijazah</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/status.php" title="Status">Status</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/akta.php" title="Akta">Akta</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/pegawai.php" title="Pegawai">Pegawai</a>
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
	<a href="'.$sumber.'/admtu/akad/keahlian_prog.php" title="Program Keahlian">Program Keahlian</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/keahlian_komp.php" title="Kompetensi Keahlian">Kompetensi Keahlian</a>
	</LI>
	</UL>
</LI>';


/*
echo '<LI>
<a href="'.$sumber.'/admtu/akad/ekstra.php" title="Ekstra">Ekstra</a>
</LI>';
*/

echo '
<LI>
<a href="#" title="Standar Kompetensi">Standar Kompetensi</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admtu/akad/prog_pddkn.php" title="Data Standar Kompetensi">Data Standar Kompetensi</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/prog_pddkn_kelas.php" title="Standar Kompetensi per Kelas">Standar Kompetensi per Kelas</a>
	</LI>';

/*
	echo '<LI>
	<a href="'.$sumber.'/admtu/akad/prog_pddkn_kompetensi.php" title="Data Kompetensi Standar Kompetensi">Data Kompetensi Standar Kompetensi</a>
	</LI>';
*/

	echo '</UL>
</LI>

<LI>
<a href="#" title="Guru">Guru</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admtu/akad/guru.php" title="Data Guru">Data Guru</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/guru_prog_pddkn.php" title="Guru per Standar Kompetensi">Guru per Standar Kompetensi</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/guru_prog_pddkn_kelas.php" title="Guru Standar Kompetensi per Kelas">Guru Standar Kompetensi per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/guru_prog_pddkn_tmp.php" title="Penempatan Guru Mengajar">Penempatan Guru Mengajar</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/wk.php" title="Wali Kelas">Wali Kelas</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="'.$sumber.'/admtu/akad/siswa.php" title="Siswa">Siswa</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa.php" title="Data Siswa">Data Siswa</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_tmp_k.php" title="Penempatan Siswa per Kelas">Penempatan Siswa per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_tmp_kea.php" title="Penempatan Siswa per Keahliean">Penempatan Siswa per Keahlian</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_kenaikan.php" title="Kenaikan Kelas">Kenaikan Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_history.php" title="History Kelas">History Kelas</a>
	</LI>
	</UL>
</LI>
</UL>';
//akademik //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu4"><strong>JADWAL</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu4" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/jwal/pel.php" title="Jadwal Pelajaran">Jadwal Pelajaran</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/jwal/guru.php" title="Jadwal Guru Mengajar">Jadwal Guru Mengajar</a>
</LI>
</UL>';
//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





/*
//penilaian /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu14"><strong>PENILAIAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu14" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/nil/nil_kompetensi.php" title="Kompetensi">Kompetensi</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/nil/nil_prog_pddkn.php" title="Program Pendidikan">Program Pendidikan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/nil/nil_raport.php" title="Raport">Raport</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/nil/rangking.php" title="Rangking">Rangking</a>
</LI>
</UL>';
//penilaian /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/




/*
//absensi ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu6"><strong>ABSENSI</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu6" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/abs/harian.php" title="Absensi Harian Siswa">Absensi Harian Siswa</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/abs/rekap_kelas.php" title="Rekap Absensi per Kelas">Rekap Absensi Per Kelas</a>
</LI>
</UL>';
//absensi ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/




/*
//inventaris ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu7"><strong>INVENTARIS</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu7" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/inv/bangunan.php" title="Daftar Bangunan">Daftar Bangunan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/inv/tanah.php" title="Daftar Tanah">Daftar Tanah</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/inv/brg.php" title="Daftar Barang">Daftar Barang</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/inv/tmp_brg.php" title="Penempatan per Barang">Penempatan per Barang</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/inv/tmp_kelas.php" title="Penempatan per Kelas">Penempatan per Kelas</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/inv/lab.php" title="Laboratorium">Laboratorium</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/inv/peng_lab.php" title="Penggunaan Lab.">Penggunaan Lab.</a>
</LI>
</UL>';
//inventaris ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/




//statistik ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu82"><strong>STATISTIK</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu82" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/st/jml_siswa_kelas.php" title="Jumlah Siswa Menurut Kelas">Jumlah Siswa Menurut Kelas</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/jml_siswa_kelamin.php" title="Jumlah Siswa Menurut Kelamin">Jumlah Siswa Menurut Kelamin</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/jml_siswa_umur.php" title="Jumlah Siswa Menurut Umur">Jumlah Siswa Menurut Umur</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/jml_siswa_agama.php" title="Jumlah Siswa Menurut Agama">Jumlah Siswa Menurut Agama</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/rata_nilai_siswa_kelas.php" title="Rata - Rata Nilai Siswa per Kelas">Rata - Rata Nilai Siswa per Kelas</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/jml_pegawai_agama.php" title="Jumlah Pegawai Menurut Agama">Jumlah Pegawai Menurut Agama</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/jml_pegawai_ijazah.php" title="Jumlah Pegawai Menurut Ijazah">Jumlah Pegawai Menurut Ijazah</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/jml_pegawai_pangkat.php" title="Jumlah Pegawai Menurut Pangkat">Jumlah Pegawai Menurut Pangkat</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/jml_pegawai_jabatan.php" title="Jumlah Pegawai Menurut Jabatan">Jumlah Pegawai Menurut Jabatan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/st/jml_pegawai_umur.php" title="Jumlah Pegawai Menurut Umur">Jumlah Pegawai Menurut Umur</a>
</LI>
</UL>';
//inventaris ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//rekap //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu41"><strong>REKAP DATA</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu41" class="flexdropdownmenu">
<LI>
<a href="#" title="Rekap Data Siswa">Data Siswa</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admtu/rekap/siswa_transkrip.php" title="Transkrip Nilai Siswa">Transkrip Nilai Siswa</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/rekap/siswa_per_abjad.php" title="Data Siswa per Abjad">Data Siswa per Abjad</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/rekap/siswa_per_kelas.php" title="Data Siswa per Kelas">Data Siswa per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/rekap/siswa_per_kelamin.php" title="Data Siswa per Jenis Kelamin">Data Siswa per Jenis Kelamin</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/rekap/siswa_per_usia.php" title="Data Siswa per Jenis Kelamin">Data Siswa per Usia</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/rekap/siswa_per_income.php" title="Data Siswa per Income ORTU">Data Siswa per Income ORTU</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/rekap/siswa_per_pddkn.php" title="Data Siswa per Pendidikan ORTU">Data Siswa per Pendidikan ORTU</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/rekap/siswa_per_kerja.php" title="Data Siswa per Pekerjaan ORTU">Data Siswa per Pekerjaan ORTU</a>
	</LI>
	</UL>
</LI>
</UL>';
//rekap //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu27" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu27" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/p/baru.php" title="Koleksi Item Terbaru">Koleksi Item Terbaru</a>
</LI>
</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="'.$sumber.'/admtu/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
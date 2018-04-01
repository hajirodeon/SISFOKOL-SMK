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
$maine = "$sumber/admpus/index.php";


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
<a href="'.$sumber.'/admpus/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>MASTER</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admpus/m/jenis.php" title="Data Jenis/Klasifikasi">Data Jenis/Klasifikasi</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/penerbit.php" title="Data Penerbit">Data Penerbit</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/perolehan.php" title="Data Perolehan">Data Perolehan</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/bahasa.php" title="Data Bahasa">Data Bahasa</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/kota.php" title="Data Kota">Data Kota</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/jmajalah.php" title="Data Jenis Majalah">Data Jenis Majalah</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/majalah.php" title="Data Majalah">Data Majalah</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/masa.php" title="Data Masa">Data Masa</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/denda.php" title="Data Denda">Data Denda</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/negara.php" title="Data Negara">Data Negara</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/pustaka.php" title="Data Pustaka">Data Pustaka</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/m/rak.php" title="Data Rak">Data Rak</a>
</LI>
</UL>';
//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//item ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu4"><strong>KOLEKSI</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu4" class="flexdropdownmenu">
<LI>
<a href="#" title="Koleksi Buku">Koleksi Buku</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admpus/item/buku.php" title="Data Buku">Data Buku</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/buku_klasifikasi.php" title="Data Buku per Klasifikasi">Data Buku per Klasifikasi</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/buku_print_barcode.php" title="Print BarCode">Print BarCode</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/buku_print_label.php" title="Print Label Buku">Print Label Buku</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/buku_print_katalog.php" title="Print Kartu Katalog">Print Kartu Katalog</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/buku_pinjam.php" title="Boleh Dipinjam">Boleh Dipinjam</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/buku_nopinjam.php" title="Belum Bisa Dipinjam">Belum Bisa Dipinjam</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Koleksi Majalah">Koleksi Majalah</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admpus/item/majalah.php" title="Data Majalah">Data Majalah</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/majalah_print_barcode.php" title="Print BarCode">Print BarCode</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/majalah_pinjam.php" title="Boleh Dipinjam">Boleh Dipinjam</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/majalah_nopinjam.php" title="Belum Bisa Dipinjam">Belum Bisa Dipinjam</a>
	</LI>
	</UL>
</LI>


<LI>
<a href="#" title="Koleksi CD">Koleksi CD</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admpus/item/cd.php" title="Data CD">Data CD</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/cd_print_barcode.php" title="Print BarCode">Print BarCode</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/cd_pinjam.php" title="Boleh Dipinjam">Boleh Dipinjam</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/item/cd_nopinjam.php" title="Belum Bisa Dipinjam">Belum Bisa Dipinjam</a>
	</LI>
	</UL>
</LI>

</UL>';
//item ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//stock /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu31"><strong>STOCK</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu31" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admpus/st/stock_buku.php" title="Stock Buku">Stock Buku</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/st/stock_majalah.php" title="Stock Majalah">Stock Majalah</a>
</LI>
<LI>
<a href="'.$sumber.'/admpus/st/stock_cd.php" title="Stock CD">Stock CD</a>
</LI>
</UL>';
//stock /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//pinjam ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu41"><strong>PINJAM</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu41" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admpus/p/pinjam_user.php" title="User Peminjam">User Peminjam</a>
</LI>
</UL>';
//pinjam /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//rekap ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu43"><strong>REKAP</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu43" class="flexdropdownmenu">
<LI>
<a href="#" title="Item">Item</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admpus/r/keadaan_buku.php" title="Keadaan Buku dan Bahan Lain">Keadaan Buku dan Bahan Lain</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/penambahan_koleksi.php" title="Tabel Penambahan Jumlah Koleksi">Tabel Penambahan Jumlah Koleksi</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Peminjaman">Peminjaman</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admpus/r/item_belum_kembali.php" title="Item Belum Kembali">Item Belum Kembali</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/item_harian.php" title="Item Kembali Hari ini">Item Kembali Hari ini</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/item.php" title="per Item">per Item</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/item_sedang.php" title="Sedang Dipinjam">Sedang Dipinjam</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/item_rangking.php" title="Rangking Item">Rangking Item</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/peminjam_rangking.php" title="Rangking Peminjam">Rangking Peminjam</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/peminjam_klasifikasi.php" title="Laporan Peminjam Menurut Klasifikasi">Laporan Peminjam Menurut Klasifikasi</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/statistik_pinjam_bulanan.php" title="Statistik Peminjaman per Bulan">Statistik Peminjaman per Bulan</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Pengunjung">Pengunjung</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admpus/r/absensi.php" title="Absensi Pengunjung">Absensi Pengunjung</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admpus/r/kunjungan_anggota.php" title="Laporan Kunjungan Anggota">Laporan Kunjungan Anggota</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="'.$sumber.'/admpus/r/bebas_pinjam.php" title="Bebas Pinjam">Bebas Pinjam</a>
</LI>

</UL>';
//rekap /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









//jejaring sosial ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$sumber.'/janissari/index.php" title="E-Network" class="menuku"><strong>E-Network</strong>&nbsp;&nbsp;</A> | ';
//jejaring sosial ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="'.$sumber.'/logout.php" class="menuku" title="Logout / KELUAR"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
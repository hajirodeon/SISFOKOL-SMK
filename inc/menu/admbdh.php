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
$maine = "$sumber/admbdh/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>HOME</strong>&nbsp;&nbsp;</a> | ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu1" class="menuku"><strong>SETTING</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu1" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admbdh/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//bayar /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu2" class="menuku"><strong>PEMBAYARAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admbdh/bayar/m_uang_lain.php" title="Data Keuangan Lain">Data Keuangan Lain</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/bayar/set.php" title="Set Keuangan">Set Keuangan</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/bayar/siswa_komite.php" title="Uang Komite">Uang Komite</a>
</LI>';


//keuangan lain
$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
			"ORDER BY nama ASC");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);

//jika ada
if ($tdt != 0)
	{
        do
		{
		$dt_kd = nosql($rdt['kd']);
		$dt_nama = balikin($rdt['nama']);

		echo '<LI>
		<a href="'.$sumber.'/admbdh/bayar/siswa_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
		</LI>';
		}
	while ($rdt = mysql_fetch_assoc($qdt));
	}


echo '<LI>
<a href="#" title="Laporan Harian">Laporan Harian</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_harian_komite.php" title="Uang Komite">Uang Komite</a>
	</LI>';

	//keuangan lain
	$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//jika ada
	if ($tdt != 0)
		{
		do
			{
			$dt_kd = nosql($rdt['kd']);
			$dt_nama = balikin($rdt['nama']);

			echo '<LI>
			<a href="'.$sumber.'/admbdh/bayar/siswa_harian_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
			</LI>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}

	echo '</UL>
</LI>

<LI>
<a href="#" title="Laporan Bulanan">Laporan Bulanan</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_bulanan_komite.php" title="Uang Komite">Uang Komite</a>
	</LI>';

	//keuangan lain
	$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//jika ada
	if ($tdt != 0)
		{
		do
			{
			$dt_kd = nosql($rdt['kd']);
			$dt_nama = balikin($rdt['nama']);

			echo '<LI>
			<a href="'.$sumber.'/admbdh/bayar/siswa_bulanan_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
			</LI>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}


	echo '</UL>
</LI>


<LI>
<a href="#" title="Laporan Tahunan">Laporan Tahunan</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_tahunan_komite.php" title="Uang Komite">Uang Komite</a>
	</LI>';

	//keuangan lain
	$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//jika ada
	if ($tdt != 0)
		{
		do
			{
			$dt_kd = nosql($rdt['kd']);
			$dt_nama = balikin($rdt['nama']);

			echo '<LI>
			<a href="'.$sumber.'/admbdh/bayar/siswa_tahunan_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
			</LI>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}


	echo '</UL>
</LI>



<LI>
<a href="#" title="Laporan per Tanggal">Laporan per Tanggal</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_tgl_komite.php" title="Uang Komite">Uang Komite</a>
	</LI>';

	//keuangan lain
	$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//jika ada
	if ($tdt != 0)
		{
		do
			{
			$dt_kd = nosql($rdt['kd']);
			$dt_nama = balikin($rdt['nama']);

			echo '<LI>
			<a href="'.$sumber.'/admbdh/bayar/siswa_tgl_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
			</LI>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}


	echo '</UL>
</LI>
</UL>';
//pembayaran ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//tabungan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu3" class="menuku"><strong>TABUNGAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu3" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admbdh/nabung/set.php" title="Set Debet/Kredit/Saldo">Set Debet/Kredit/Saldo</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/nabung/siswa.php" title="Debet/Kredit Siswa">Debet/Kredit Siswa</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/nabung/lap_harian.php" title="Laporan Tabungan Harian">Laporan Tabungan Harian</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/nabung/lap_bulanan.php" title="Laporan Tabungan Bulanan">Laporan Tabungan Bulanan</a>
</LI>
</UL>';
//tabungan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu29" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu29" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admbdh/p/absensi.php" title="Absensi Kunjungan">Absensi Kunjungan</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/p/koleksi_buku.php" title="Koleksi Buku">Koleksi Buku</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/p/koleksi_majalah.php" title="Koleksi Majalah">Koleksi Majalah</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/p/koleksi_cd.php" title="Koleksi CD">Koleksi CD</a>
</LI>

</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="'.$sumber.'/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
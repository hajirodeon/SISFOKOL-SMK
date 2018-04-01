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



///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMP_v4.0_(NyurungBAN)                          ///////
/////// (Sistem Informasi Sekolah untuk SMP)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS	: 081-829-88-54                                 ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////


session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
$tpl = LoadTpl("../../template/window.html");


nocache;

//nilai
$filenya = "daftar_setoran_komite_prt.php";
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$rukd = nosql($_REQUEST['rukd']);


$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd";




//judul
$judul = "Daftar Setoran Uang KOMITE Bulanan";
$judulku = $judul;
$judulx = $judul;





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "daftar_setoran_komite.php?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="center">';
xheadline($judul);

echo '<br>
Tahun Pelajaran : ';
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo ''.$tpx_thn1.'/'.$tpx_thn2.',


Kelas : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = nosql($rowbtx['kelas']);


//ruang
$qstx = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$rukd'");
$rowstx = mysql_fetch_assoc($qstx);
$ruang = nosql($rowstx['ruang']);

echo ''.$btxkelas.'/'.$ruang.'</td>
</tr>
</table>';


//query
$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_ruang = '$rukd' ".
			"ORDER BY round(siswa_kelas.no_absen) ASC");
$rdata = mysql_fetch_assoc($qdata);
$tdata = mysql_num_rows($qdata);



echo '<p>
<TABLE WIDTH=100% BORDER=1 CELLPADDING=4 CELLSPACING=0>
	<TR align="center" bgcolor="'.$warnaheader.'">
		<TD COLSPAN=2>
			<strong>Nomor</strong>
		</TD>
		<TD ROWSPAN=2>
			<strong>NAMA</strong>
		</TD>
		<TD ROWSPAN=2 width="10">
			<strong>L/P</strong>
		</TD>
		<TD COLSPAN=12>
			<strong>Tgl.Pembayaran</strong>
		</TD>
		<TD ROWSPAN=2 width="50">
			<strong>Ket.</strong>
		</TD>
	</TR>
	<TR align="center" bgcolor="'.$warnaheader.'">
		<TD WIDTH=14>
			<strong>No.</strong>
		</TD>
		<TD WIDTH=41>
			<strong>NIS</strong>
		</TD>
		<TD>
			<strong>Jul</strong>
		</TD>
		<TD>
			<strong>Agust</strong>
		</TD>
		<TD>
			<strong>Sept</strong>
		</TD>
		<TD>
			<strong>Okto</strong>
		</TD>
		<TD>
			<strong>Nop</strong>
		</TD>
		<TD>
			<strong>Des</strong>
		</TD>
		<TD>
			<strong>Jan</strong>
		</TD>
		<TD>
			<strong>Feb</strong>
		</TD>
		<TD>
			<strong>Mar</strong>
		</TD>
		<TD>
			<strong>Apr</strong>
		</TD>
		<TD>
			<strong>Mei</strong>
		</TD>
		<TD>
			<strong>Jun</strong>
		</TD>
	</TR> ';



//nek ada
if ($tdata != 0)
	{
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

		$i_kd = nosql($rdata['mskd']);
		$i_kd_kelamin = nosql($rdata['kd_kelamin']);
		$i_nis = nosql($rdata['nis']);
		$i_abs = nosql($rdata['no_absen']);
		$i_nama = balikin2($rdata['nama']);

		//nek null
		if (empty($abs))
			{
			$abs = "00";
			}
		else if (strlen($abs) == 1)
			{
			$abs = "0$abs";
			}



		//kelamin
		$qkmin = mysql_query("SELECT * FROM m_kelamin ".
					"WHERE kd = '$i_kd_kelamin'");
		$rkmin = mysql_fetch_assoc($qkmin);
		$kmin_kelamin = nosql($rkmin['kelamin']);



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">'.$i_abs.'</td>
		<td valign="top">'.$i_nis.'</td>
		<td valign="top">'.$i_nama.'</td>
		<td valign="top">'.$kmin_kelamin.'</td>';

		for ($i=1;$i<=12;$i++)
			{
			//nilainya
			if ($i<=6) //bulan juli sampai desember
				{
				$ibln = $i + 6;

				//cek
				$qccu = mysql_query("SELECT DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
							"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
							"DATE_FORMAT(tgl_bayar, '%Y') AS xthn, ".
							"siswa_uang_komite.* ".
							"FROM siswa_uang_komite ".
							"WHERE kd_siswa = '$i_kd' ".
							"AND kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND bln = '$ibln' ".
							"AND thn = '$tpx_thn1' ".
							"AND lunas = 'true'");
				$rccu = mysql_fetch_assoc($qccu);
				$tccu = mysql_num_rows($qccu);
				$ccu_tgl = nosql($rccu['xtgl']);
				$ccu_bln = nosql($rccu['xbln']);
				}

			if ($i>6) //bulan januari sampai juni
				{
				$ibln = $i - 6;

				//cek
				$qccu = mysql_query("SELECT DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
							"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
							"DATE_FORMAT(tgl_bayar, '%Y') AS xthn, ".
							"siswa_uang_komite.* ".
							"FROM siswa_uang_komite ".
							"WHERE kd_siswa = '$i_kd' ".
							"AND kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND bln = '$ibln' ".
							"AND thn = '$tpx_thn2' ".
							"AND lunas = 'true'");
				$rccu = mysql_fetch_assoc($qccu);
				$tccu = mysql_num_rows($qccu);
				$ccu_tgl = nosql($rccu['xtgl']);
				$ccu_bln = nosql($rccu['xbln']);
				}


			echo '<td valign="top">'.$ccu_tgl.'/'.$ccu_bln.'</td>';
			}

		echo '<td valign="top">'.$i_ket.'</td>
		</tr>';
		}
	while ($rdata = mysql_fetch_assoc($qdata));
	}

echo '</table>
</p>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
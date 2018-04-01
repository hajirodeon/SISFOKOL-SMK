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



session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admpiket.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "rekap.php";
$judul = "Rekap Absensi";
$judulku = "[$piket_session : $nip33_session.$nm33_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$ke = "$filenya?ubln=$ubln&uthn=$uthn";





//focus...
if (empty($ubln))
	{
	$diload = "document.formx.ubln.focus();";
	}

else if (empty($uthn))
	{
	$diload = "document.formx.uthn.focus();";
	}








//isi *START
ob_start();

//menu
require("../../inc/menu/admpiket.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Bulan : ';
echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.'" selected>'.$arrbln[$ubln].'</option>';
for ($i=1;$i<=12;$i++)
	{
	echo '<option value="'.$filenya.'?ubln='.$i.'">'.$arrbln[$i].'</option>';
	}

echo '</select>, 

Tahun : ';
echo "<select name=\"uthnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$uthn.'" selected>'.$uthn.'</option>
<option value="'.$filenya.'?ubln='.$ubln.'&uthn='.$tahun.'">'.$tahun.'</option>
</select>


</td>
</tr>
</table>
<br>';


//nek blm dipilih
if (empty($_REQUEST['ubln']))
	{
	echo '<h4>
	<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
	</h4>';
	}

else if (empty($_REQUEST['uthn']))
	{
	echo '<h4>
	<font color="#FF0000"><strong>TAHUN Belum Dipilih...!</strong></font>
	</h4>';
	}

else
	{
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT DISTINCT(pegawai_absensi.kd_pegawai) AS swkd ".
					"FROM pegawai_absensi, m_pegawai ".
					"WHERE pegawai_absensi.kd_pegawai = m_pegawai.kd ".
					"AND round(DATE_FORMAT(pegawai_absensi.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(pegawai_absensi.tgl, '%Y')) = '$uthn' ".
					"AND pegawai_absensi.kd_absensi <> '' ".
					"AND round(TIME_FORMAT(pegawai_absensi.jam, '%H')) <> '00' ".
					"ORDER BY m_pegawai.nip ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = $ke;
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="100"><strong>NIP</strong></td>
	<td width="150"><strong>Nama</strong></td>
	<td></td>
	</tr>';

	if ($count != 0)
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

			//nilai
			$dtf_swkd = nosql($data['swkd']);

			//siswa
			$qnixu = mysql_query("SELECT * FROM m_pegawai ".
									"WHERE kd = '$dtf_swkd'");
			$rnixu = mysql_fetch_assoc($qnixu);
			$nixu_nip = nosql($rnixu['nip']);
			$nixu_nm = balikin($rnixu['nama']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$nixu_nip.'</td>
			<td>'.$nixu_nm.'</td>
			<td>';
			//detail
			$qnitu = mysql_query("SELECT pegawai_absensi.*, m_pegawai.*,  ".
									"round(DATE_FORMAT(pegawai_absensi.tgl, '%d')) AS abs_tgl ".
									"FROM pegawai_absensi, m_pegawai ".
									"WHERE pegawai_absensi.kd_pegawai = m_pegawai.kd ".
									"AND pegawai_absensi.kd_pegawai = '$dtf_swkd' ".
									"AND round(DATE_FORMAT(pegawai_absensi.tgl, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(pegawai_absensi.tgl, '%Y')) = '$uthn' ".
									"AND pegawai_absensi.kd_absensi <> '' ".
									"AND round(TIME_FORMAT(pegawai_absensi.jam, '%H')) <> '00'");
			$rnitu = mysql_fetch_assoc($qnitu);

			do
				{
				//nilai
				$nitu_abs_kd = nosql($rnitu['kd_absensi']);
				$nitu_abs_tgl = nosql($rnitu['abs_tgl']);
				$nitu_jam_xjam = substr($rnitu['jam'],0,2);
				$nitu_jam_xmnt = substr($rnitu['jam'],3,2);
				$nitu_perlu = balikin($rnitu['keperluan']);


				//nek empty
				if ($nitu_jam_xjam == "00")
					{
					$nitu_jam_xjam = "";

					if ($nitu_jam_xmnt == "00")
						{
						$nitu_jam_xmnt = "";
						}
					}


				//absensinya
				$qbein = mysql_query("SELECT * FROM m_absensi ".
										"WHERE kd = '$nitu_abs_kd'");
				$rbein = mysql_fetch_assoc($qbein);
				$bein_kd = nosql($rbein['kd']);
				$bein_abs = balikin($rbein['absensi']);


				echo 'Tgl. : <strong>'.$nitu_abs_tgl.'</strong>,
				Jam : <strong>'.$nitu_jam_xjam.':'.$nitu_jam_xmnt.'</strong>
				<br>
				Ket. : <strong>'.$bein_abs.'</strong>
				<br>
				Keperluan. : <strong>'.$nitu_perlu.'</strong>
				<br>
				<br>';
				}
			while ($rnitu = mysql_fetch_assoc($qnitu));

			echo '</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));
		}
	echo '</table>
	<table width="700" border="0" cellspacing="0" cellpadding="3">
  	<tr>
    	<td align="right">'.$pagelist.'</td>
	</tr>
	</table>';
	}

echo '</form>
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
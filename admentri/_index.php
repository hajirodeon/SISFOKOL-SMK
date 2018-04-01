<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/admentri.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang...";
$judulku = "$judul  [$entri_session : $nip37_session.$nm37_session]";
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);




//isi *START
ob_start();

//menu
require("../inc/menu/admentri.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();



//isi *START
ob_start();


//js
require("../inc/js/jumpmenu.js");
require("../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,


Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd <> '$kelkd' ".
					"ORDER BY no ASC, ".
					"kelas ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
</td>
</tr>
</table>
<br>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<h4>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</h4>';
	}


else if (empty($kelkd))
	{
	echo '<h4>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</h4>';
	}

else
	{
	//query
	$q = mysql_query("SELECT DISTINCT(m_prog_pddkn_kelas.kd_prog_pddkn) AS mpkd ".
						"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
						"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
						"ORDER BY round(m_prog_pddkn.no) ASC, ".
						"round(m_prog_pddkn.no_sub) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	echo '<table width="700" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="'.$warnaheader.'">
	<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama Mata Pelajaran</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
	<td width="50"><strong>Nilai Absensi</strong></td>
	<td width="50"><strong>Nilai Pengetahuan</strong></td>
	<td width="50"><strong>Nilai Ketrampilan</strong></td>
	<td width="50"><strong>Nilai Sikap</strong></td>
    </tr>';

	if ($total != 0)
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
			$mpkd = nosql($row['mpkd']);


			//detail e
			$qdti = mysql_query("SELECT m_prog_pddkn_kelas.*, m_prog_pddkn_kelas.kd AS pkd, ".
									"m_prog_pddkn.* ".
									"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
									"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
									"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
									"AND m_prog_pddkn_kelas.kd_prog_pddkn = '$mpkd'");
			$rdti = mysql_fetch_assoc($qdti);
			$dti_pel = balikin($rdti['prog_pddkn']);
			$dti_kkm = nosql($rdti['kkm']);



			//guru-nya
			$quru = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd, m_guru.*, m_guru_prog_pddkn.*, ".
									"m_guru_prog_pddkn.kd AS mgmkd ".
									"FROM m_pegawai, m_guru, m_guru_prog_pddkn ".
									"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
									"AND m_guru_prog_pddkn.kd_guru = m_guru.kd ".
									"AND m_guru.kd_tapel = '$tapelkd' ".
									"AND m_guru.kd_kelas = '$kelkd' ".
									"AND m_guru_prog_pddkn.kd_prog_pddkn = '$mpkd'");
			$ruru = mysql_fetch_assoc($quru);
			$gnam = balikin2($ruru['nama']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$nomer.'.</td>
			<td>
			'.$dti_pel.'
			<br>
			[Guru : '.$gnam.'].
			</td>
			<td>
			'.$dti_kkm.'
			</td>
			<td>
			<a href="ajar/nil_absensi.php?mmkd='.$dty_gurkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$mpkd.'"
			title="Kelas = '.$btxkelas.', Pelajaran = '.$dti_pel.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="ajar/nil_pengetahuan.php?mmkd='.$dty_gurkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$mpkd.'&mpkd='.$mpkd.'"
			title="Kelas = '.$btxkelas.', Pelajaran = '.$dti_pel.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="ajar/nil_ketrampilan.php?mmkd='.$dty_gurkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$mpkd.'&mpkd='.$mpkd.'"
			title="Kelas = '.$btxkelas.', Pelajaran = '.$dti_pel.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="ajar/nil_sikap.php?mmkd='.$dty_gurkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$mpkd.'&mpkd='.$mpkd.'"
			title="Kelas = '.$btxkelas.', Pelajaran = '.$dti_pel.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));
		}

	echo '</table>';		

	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
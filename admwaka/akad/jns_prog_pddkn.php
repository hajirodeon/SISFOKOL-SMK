<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "jns_prog_pddkn.php";
$judul = "Set Jenis Mata Pelajaran";
$judulku = "[$waka_session : $nip10_session. $nm10_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$progkd = nosql($_REQUEST['progkd']);
$kompkd = nosql($_REQUEST['kompkd']);
$ke = "$filenya?progkd=$progkd&kompkd=$kompkd";


//focus
if (empty($progkd))
	{
	$diload = "document.formx.program.focus();";
	}
else if (empty($kompkd))
	{
	$diload = "document.formx.kompetensi.focus();";
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan - pindahkan
if ($_POST['btnSMP'])
	{
	//nilai
	$progkd = nosql($_POST['progkd']);
	$kompkd = nosql($_POST['kompkd']);
	$jenisnya = nosql($_POST['jenisnya']);
	$jml = nosql($_POST['jml']);

	//nek null
	if (empty($jenisnya))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//ambil semua
		for ($i=1;$i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kdix = nosql($_POST["$yuhu"]);

			//update
			mysql_query("UPDATE m_prog_pddkn SET kd_jenis = '$jenisnya' ".
							"WHERE kd_keahlian = '$progkd' ".
							"AND kd_keahlian_kompetensi = '$kompkd' ".
							"AND kd = '$kdix'");
			}

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		xloc($ke);
		exit();
		}
	}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admwaka.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Program Keahlian : ';
echo "<select name=\"program\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd = '$progkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_program = balikin($rowtpx['program']);

echo '<option value="'.$tpx_kd.'">--'.$tpx_program.'--</option>';

$qtp = mysql_query("SELECT * FROM m_keahlian ".
			"WHERE kd <> '$progkd' ".
			"ORDER BY program ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tp_kd = nosql($rowtp['kd']);
	$tp_program = balikin($rowtp['program']);

	echo '<option value="'.$filenya.'?progkd='.$tp_kd.'">'.$tp_program.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,


Kompetensi Keahlian : ';
echo "<select name=\"kompetensi\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd = '$kompkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_kompetensi = balikin($rowtpx['kompetensi']);

echo '<option value="'.$tpx_kd.'">--'.$tpx_kompetensi.'--</option>';

$qtp = mysql_query("SELECT * FROM m_keahlian_kompetensi ".
			"WHERE kd_keahlian = '$progkd' ".
			"AND kd <> '$kompkd' ".
			"ORDER BY kompetensi ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tp_kd = nosql($rowtp['kd']);
	$tp_kompetensi = balikin($rowtp['kompetensi']);

	echo '<option value="'.$filenya.'?progkd='.$progkd.'&kompkd='.$tp_kd.'">'.$tp_kompetensi.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';


//nek blm
if (empty($progkd))
	{
	echo '<p>
	<strong><font color="#FF0000">PROGRAM KEAHLIAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($kompkd))
	{
	echo '<p>
	<strong><font color="#FF0000">KOMPETENSI KEAHLIAN Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	//query
	$q = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd_keahlian = '$progkd' ".
						"AND kd_keahlian_kompetensi = '$kompkd' ".
						"ORDER BY prog_pddkn ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	echo '<p>
	<input name="progkd" type="hidden" value="'.$progkd.'">
	<input name="kompkd" type="hidden" value="'.$kompkd.'">
	</p>
	<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">SINGKATAN</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">JENIS</font></strong></td>
	</tr>';

	if ($total != 0)
		{
		do {
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
			$kd = nosql($row['kd']);
			$i_jnskd = nosql($row['kd_jenis']);
			$no = nosql($row['no']);
			$no_sub = nosql($row['no_sub']);
			$no_sub2 = nosql($row['no_sub2']);
			$pel = balikin($row['prog_pddkn']);
			$xpel = balikin($row['xpel']);



			//jenisnya
			$qku = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
									"WHERE kd = '$i_jnskd'");
			$rku = mysql_fetch_assoc($qku);
			$ku_jenis = balikin($rku['jenis']);		


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>			
			<input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
			<input name="item'.$nomer.'" type="checkbox" value="'.$kd.'">
        	</td>
			<td>'.$pel.'</td>
			<td>'.$xpel.'</td>
			<td>'.$ku_jenis.'</td>
	       	</tr>';
			}
		while ($row = mysql_fetch_assoc($q));
		}

	echo '</table>
	<table width="600" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input name="jml" type="hidden" value="'.$total.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
	<input name="btnBTL" type="reset" value="BATAL">

	<select name="jenisnya">
	<option value="">-JENIS-</option>';

	//daftar jenis
	$qbtx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
							"ORDER BY jenis ASC");
	$rowbtx = mysql_fetch_assoc($qbtx);

	do
		{
		$btkdx = nosql($rowbtx['kd']);
		$btkelasx = balikin($rowbtx['jenis']);

		echo '<option value="'.$btkdx.'">'.$btkelasx.'</option>';
		}
	while ($rowbtx = mysql_fetch_assoc($qbtx));

	echo '</select>
	<input name="btnSMP" type="submit" value="PINDAHKAN &gt;&gt;&gt;">

	<p>
	Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.
	</p>
	</td>
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
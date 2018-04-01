<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL JANISSARI                          ///////
/////// (customization)                             ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh :                               ///////
/////// Agus Muhajir, S.Kom                         ///////
/////// URL     :                                   ///////
///////     *http://sisfokol.wordpress.com          ///////
//////      *http://hajirodeon.wordpress.com        ///////
/////// E-Mail  :                                   ///////
///////     * hajirodeon@yahoo.com                  ///////
///////     * hajirodeon@gmail.com                  ///////
/////// HP/SMS  : 081-829-88-54                     ///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////



session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_gr.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$gmkd = nosql($_REQUEST['gmkd']);
$filenya = "polling.php?gmkd=$gmkd";



//focus
$diload = "document.formx.topik.focus();";


//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}




//nek simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);
	$topik = cegah($_POST['topik']);
	$opsi1 = cegah($_POST['opsi1']);
	$opsi2 = cegah($_POST['opsi2']);
	$opsi3 = cegah($_POST['opsi3']);
	$opsi4 = cegah($_POST['opsi4']);
	$opsi5 = cegah($_POST['opsi5']);


	//cek null
	if ((empty($topik)) OR (empty($opsi1)) OR (empty($opsi2)) OR (empty($opsi3)) OR (empty($opsi4)) OR (empty($opsi5)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya&s=baru";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//hapus yang ada...
		mysql_query("DELETE FROM guru_mapel_polling ".
						"WHERE kd_guru_mapel = '$gmkd'");

		//entry baru
		mysql_query("INSERT INTO guru_mapel_polling(kd, kd_guru_mapel, topik, opsi1, opsi2, opsi3, opsi4, opsi5, postdate) VALUES ".
						"('$x', '$gmkd', '$topik', '$opsi1', '$opsi2', '$opsi3', '$opsi4', '$opsi5', '$today')");

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		///re-direct
		xloc($filenya);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/js/checkall.js");
require("../../../inc/menu/janissari.php");


//view : guru ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika belum pilih mapel
if (empty($gmkd))
	{
	//re-direct
	$ke = "mapel.php";
	xloc($ke);
	exit();
	}

//nek mapel telah dipilih
else
	{
	//mapel-nya...
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.* ".
							"FROM guru_mapel, m_mapel ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);


	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "polling.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> Polling";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    	<td>
		<p>
		<big><strong>:::Polling...</strong></big>
		[<a href="'.$filenya.'&s=baru" title="Buat Baru">Buat Baru</a>]
		</p>
		</td>
  		</tr>
		</table>
		<br>';


		//jika tulis baru
		if ($s == "baru")
			{
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td>
			Topik :
			<br>
			<input name="topik" type="text" value="" size="50">
			<br>
			<br>

			Opsi #01 :
			<br>
			<input name="opsi1" type="text" value="" size="30">
			<br>
			<br>

			Opsi #02 :
			<br>
			<input name="opsi2" type="text" value="" size="30">
			<br>
			<br>

			Opsi #03 :
			<br>
			<input name="opsi3" type="text" value="" size="30">
			<br>
			<br>

			Opsi #04 :
			<br>
			<input name="opsi4" type="text" value="" size="30">
			<br>
			<br>

			Opsi #05 :
			<br>
			<input name="opsi5" type="text" value="" size="30">
			<br>
			<br>

			<input name="gmkd" type="hidden" value="'.$gmkd.'">
			<input name="btnSMP" type="submit" value="SIMPAN">
			<input name="btnBTL" type="submit" value="BATAL">
			</td>
			</tr>
			</table>
			<br>';
			}

		//jika view
		else
			{
			//js
			require("../../../inc/js/wz_jsgraphics.js");
			require("../../../inc/js/pie.js");


			//cek
			$qcc = mysql_query("SELECT * FROM guru_mapel_polling ".
									"WHERE kd_guru_mapel = '$gmkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$cc_topik = balikin($rcc['topik']);
			$cc_opsi1 = balikin($rcc['opsi1']);
			$cc_opsi2 = balikin($rcc['opsi2']);
			$cc_opsi3 = balikin($rcc['opsi3']);
			$cc_opsi4 = balikin($rcc['opsi4']);
			$cc_opsi5 = balikin($rcc['opsi5']);
			$cc_nil_opsi1 = nosql($rcc['nil_opsi1']);
			$cc_nil_opsi2 = nosql($rcc['nil_opsi2']);
			$cc_nil_opsi3 = nosql($rcc['nil_opsi3']);
			$cc_nil_opsi4 = nosql($rcc['nil_opsi4']);
			$cc_nil_opsi5 = nosql($rcc['nil_opsi5']);

			//jika nol
			if ((empty($cc_nil_opsi1)) AND (empty($cc_nil_opsi2)) AND (empty($cc_nil_opsi3)) AND (empty($cc_nil_opsi4))
				AND (empty($cc_nil_opsi5)))
				{
				$cc_nil_opsi1 = 1;
				$cc_nil_opsi2 = 1;
				$cc_nil_opsi3 = 1;
				$cc_nil_opsi4 = 1;
				$cc_nil_opsi5 = 1;
				}



			//jika ada
			if ($tcc != 0)
				{
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr valign="top">
				<td width="400">
				Topik :
				<br>
				<strong>'.$cc_topik.'</strong>
				<br>
				<br>

				<ul>
				<li>
				Opsi #01 : [<strong>'.$cc_nil_opsi1.'</strong> vote]
				<br>
				<strong>'.$cc_opsi1.'</strong>
				<br>
				<br>
				</li>

				<li>
				Opsi #02 : [<strong>'.$cc_nil_opsi2.'</strong> vote]
				<br>
				<strong>'.$cc_opsi2.'</strong>
				<br>
				<br>
				</li>

				<li>
				Opsi #03 : [<strong>'.$cc_nil_opsi3.'</strong> vote]
				<br>
				<strong>'.$cc_opsi3.'</strong>
				<br>
				<br>
				</li>

				<li>
				Opsi #04 : [<strong>'.$cc_nil_opsi4.'</strong> vote]
				<br>
				<strong>'.$cc_opsi4.'</strong>
				<br>
				<br>
				</li>

				<li>
				Opsi #05 : [<strong>'.$cc_nil_opsi5.'</strong> vote]
				<br>
				<strong>'.$cc_opsi5.'</strong>
				<br>
				<br>
				</li>

				</ul>

				</td>
				<td>
				<div id="pieCanvas" style="position:absolute; height:350px; width:380px; z-index:1; left: 400px; top: 150px;"></div>

				<script type="text/javascript">
				var p = new pie();
				p.add("Opsi #1 ",'.$cc_nil_opsi1.');
				p.add("Opsi #2 ",'.$cc_nil_opsi2.');
				p.add("Opsi #3 ",'.$cc_nil_opsi3.');
				p.add("Opsi #4 ",'.$cc_nil_opsi4.');
				p.add("Opsi #5 ",'.$cc_nil_opsi5.');
				p.render("pieCanvas", "Grafik Polling")

				</script>

				</td>
				</tr>
				</table>
				<br>';
				}

			//tidak ada
			else
				{
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr valign="top">
				<td>
				<font color="blue"><strong>Belum Ada Data Polling. Silahkan Entry Baru...!!</strong></font>
				</td>
				</tr>
				</table>
				<br>';
				}
			}
		}

	//jika tidak
	else
		{
		//re-direct
		$pesan = "Silahkan Lihat Daftar Mata Pelajaran.";
		$ke = "mapel.php";
		pekem($pesan,$ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
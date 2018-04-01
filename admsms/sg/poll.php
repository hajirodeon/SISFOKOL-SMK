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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsms.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "poll.php";
$diload = "document.formx.topik.focus();";
$judul = "Polling SMS";
$judulku = "[$sms_session : $nip32_session. $nm32_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);


//banyaknya opsi
$jml_opsi = "5";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}



//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT * FROM sms_poll ".
				"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_topik = balikin2($rowx['topik']);
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$topik = cegah2($_POST['topik']);

	//nek null
	if (empty($topik))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//jika baru
		if ($s == "baru")
			{

			//cek
			$qcc = mysql_query("SELECT * FROM sms_poll ".
						"WHERE topik = '$topik'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Topik Polling Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO sms_poll(kd, topik, postdate) VALUES ".
						"('$kd', '$topik', '$today')");



				for ($k=1;$k<=$jml_opsi;$k++)
					{
					//ambil nilai
					$yuk = "opsi";
					$yuhu = "$yuk$k";
					$opsiku = nosql($_POST["$yuhu"]);

					$yuk2 = "opsi";
					$yuk22 = "_kode";
					$yuhu2 = "$yuk2$k$yuk22";
					$opsiku2 = nosql($_POST["$yuhu2"]);


					mysql_query("INSERT INTO sms_poll_opsi(kd, kd_poll, kode, opsi) VALUES ".
							"('$k', '$kd', '$opsiku', '$opsiku2')");
					}



				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}


		//jika update
		else if ($s == "edit")
			{
			//query
			mysql_query("UPDATE sms_poll SET topik = '$topik' ".
					"WHERE kd = '$kd'");


			//looping opsi
			for ($m=1;$m<=$jml_opsi;$m++)
				{
				//ambil nilai
				$yuk = "opsi";
				$yuhu = "$yuk$m";
				$opsiku = nosql($_POST["$yuhu"]);

				$yuk2 = "opsi";
				$yuk22 = "_kode";
				$yuhu2 = "$yuk2$m$yuk22";
				$opsiku2 = nosql($_POST["$yuhu2"]);


				//update
				mysql_query("UPDATE sms_poll_opsi SET kode = '$opsiku2', ".
						"opsi = '$opsiku' ".
						"WHERE kd_poll = '$kd' ".
						"AND kd = '$m'");
				}



			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM sms_poll ".
				"WHERE kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/admsms.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();


//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<br>
[<a href="'.$filenya.'?s=baru&kd='.$x.'">BARU</a>]';


//jika baru / edit
if (($s == "baru") OR ($s == "edit"))
	{
	echo '<p>
	<input name="topik" type="text" value="'.$e_topik.'" size="50">
	</p>';


	for ($k=1;$k<=$jml_opsi;$k++)
		{
		//data ne opsi
		$qdt1 = mysql_query("SELECT * FROM sms_poll_opsi ".
					"WHERE kd_poll = '$kd' ".
					"AND kd = '$k'");
		$rdt1 = mysql_fetch_assoc($qdt1);
		$dt1_opsi = balikin($rdt1['opsi']);
		$dt1_kode = nosql($rdt1['kode']);


		echo '<p>
		Opsi #'.$k.' :
		<input name="opsi'.$k.'" type="text" value="'.$dt1_opsi.'" size="30">,
		Kode SMS :
		<input name="opsi'.$k.'_kode" type="text" value="'.$dt1_kode.'" size="5" maxlength="5">
		</p>';
		}

	echo '<p>
	<INPUT type="hidden" name="s" value="'.$s.'">
	<INPUT type="hidden" name="kd" value="'.$kd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';
	}

else
	{
	//query
	$q = mysql_query("SELECT * FROM sms_poll ".
				"ORDER BY postdate DESC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);


	//jika ada
	if ($total != 0)
		{
		$i_kd = nosql($row['kd']);
		$i_topik = balikin2($row['topik']);


		echo '<p>Topik : <strong>'.$i_topik.'</strong>
		<br>';




		for ($k=1;$k<=$jml_opsi;$k++)
			{
			//data ne opsi
			$qdt1 = mysql_query("SELECT * FROM sms_poll_opsi ".
						"WHERE kd_poll = '$i_kd' ".
						"AND kd = '$k'");
			$rdt1 = mysql_fetch_assoc($qdt1);
			$dt1_opsi = balikin($rdt1['opsi']);
			$dt1_kode = nosql($rdt1['kode']);
			$dt1_nilai = nosql($rdt1['nilai']);


			echo '<p>
			Opsi #'.$k.' :
			<input name="opsi'.$k.'" type="text" value="'.$dt1_opsi.'" size="30" class="input" readonly>,
			Kode SMS :
			<input name="opsi'.$k.'_kode" type="text" value="'.$dt1_kode.'" size="5" maxlength="5" class="input" readonly>,
			Nilai Vote :
			<input name="opsi'.$k.'_nilai" type="text" value="'.$dt1_nilai.'" size="5" maxlength="5" class="input" readonly>
			</p>';
			}



		echo '[<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>].
		</p>';

		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
		</font>
		</p>';
		}
	}

echo '</form>';
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
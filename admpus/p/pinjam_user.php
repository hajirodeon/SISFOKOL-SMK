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
require("../../inc/cek/admpus.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pinjam_user.php";
$judul = "User Pinjam";
$judulku = "[$pus_session : $nip9_session. $nm9_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$no_member = nosql($_REQUEST['no_member']);
$pg_kd = nosql($_REQUEST['pg_kd']);
$p_tgl = nosql($_REQUEST['p_tgl']);
$p_bln = nosql($_REQUEST['p_bln']);
$p_thn = nosql($_REQUEST['p_thn']);
$k_tgl = nosql($_REQUEST['k_tgl']);
$k_bln = nosql($_REQUEST['k_bln']);
$k_thn = nosql($_REQUEST['k_thn']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





//focus
if (empty($no_member))
	{
	$diload = "document.formx.no_member.focus();";
	}
else if (($s == "baru") AND (empty($a)))
	{
	$diload = "document.formx.btnDTI.focus();";
	}
else if (($s == "baru") AND ($a == "detail"))
	{
	$diload = "document.formx.kode0.focus();";
	}







//jika null
if (empty($p_tgl))
	{
	$p_tgl = round($tanggal);
	}
if (empty($p_bln))
	{
	$p_bln = round($bulan);
	}
if (empty($p_thn))
	{
	$p_thn = round($tahun);
	}

$p_pinjam = "$p_thn-$p_bln-$p_tgl";





//data...
$qdt = mysql_query("SELECT * FROM m_user ".
						"WHERE nomor = '$no_member'");
$rdt = mysql_fetch_assoc($qdt);
$dt_nip = nosql($rdt['nomor']);
$dt_kd = nosql($rdt['kd']);
$dt_nama = balikin2($rdt['nama']);
$dt_tipe = balikin2($rdt['tipe']);












//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ok..
if ($_POST['btnOK'])
	{
	//nilai
	$no_member = nosql($_POST['no_member']);

	//bila barcode, ada 13 digit. hilangkan angka terakhir.
	if (strlen($no_member) == '12')
		{
		$kodeu1 = substr($no_member,0,11);
		$kodeu2 = round($kodeu1);
		$no_member = $kodeu2;
		}



	//cek
	if (empty($no_member))
		{
		//re-direct
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//cek lagi
		$qcc = mysql_query("SELECT * FROM m_user ".
								"WHERE nomor = '$no_member'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_kd = nosql($rcc['kd']);

		//jika ada
		if ($tcc != 0)
			{
			//re-direct
			$ke = "$filenya?no_member=$no_member&pg_kd=$cc_kd&s=baru";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Belum Ada Anggota Dengan Nomor Tersebut. Harap Diperhatikan...!!";
			pekem($pesan,$filenya);
			exit();
			}
		}
	}





//pinjam baru
if ($_POST['btnBR'])
	{
	//nilai
	$no_member = nosql($_POST['no_member']);
	$pg_kd = nosql($_POST['pg_kd']);

	//re-direct
	$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&s=baru";
	xloc($ke);
	exit();
	}





//pernah pinjam
if ($_POST['btnPR'])
	{
	//nilai
	$no_member = nosql($_POST['no_member']);
	$pg_kd = nosql($_POST['pg_kd']);

	//re-direct
	$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&s=pernah";
	xloc($ke);
	exit();
	}





//sedang pinjam
if ($_POST['btnSD'])
	{
	//nilai
	$no_member = nosql($_POST['no_member']);
	$pg_kd = nosql($_POST['pg_kd']);

	//re-direct
	$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd";
	xloc($ke);
	exit();
	}





//jika detail item
if ($_POST['btnDTI'])
	{
	//nilai
	$no_member = nosql($_POST['no_member']);
	$pg_kd = nosql($_POST['pg_kd']);
	$pinjam_tgl = nosql($_POST['pinjam_tgl']);
	$pinjam_bln = nosql($_POST['pinjam_bln']);
	$pinjam_thn = nosql($_POST['pinjam_thn']);
	$tgl_pinjam = "$pinjam_thn:$pinjam_bln:$pinjam_tgl";


	//null . . .?
	if ((empty($pinjam_tgl)) OR (empty($pinjam_bln)) OR (empty($pinjam_thn)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&p_tgl=$pinjam_tgl&p_bln=$pinjam_bln&p_thn=$pinjam_thn&&s=baru";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&p_tgl=$pinjam_tgl&p_bln=$pinjam_bln&p_thn=$pinjam_thn&&s=baru&a=detail";
		xloc($ke);
		exit();
		}
	}










//kembalikan item
if ($_POST['btnKBL'])
	{
	//nilai
	$no_member = nosql($_POST['no_member']);
	$pg_kd = nosql($_POST['pg_kd']);
	$total = nosql($_POST['total']);

	//ambil semua
//	for ($i=1; $i<=$limit;$i++)
	for ($i=1; $i<=$total;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		$yuk2 = "jml_hari";
		$yuhu2 = "$yuk2$i";
		$kd2 = nosql($_POST["$yuhu2"]);


		//ketahui jml. yg dipinjam
		$qcc = mysql_query("SELECT kd_item ".
					"FROM perpus_pinjam ".
//					"WHERE kd_user = '$pg_kd' ".
					"WHERE kd_user = '$no_member' ".
					"AND kd = '$kd'");
		$rcc = mysql_fetch_assoc($qcc);
		$cc_itemkd = nosql($rcc['kd_item']);


		mysql_query("UPDATE perpus_item SET tersedia = '1' ".
				"WHERE kd = '$cc_itemkd'");

		mysql_query("UPDATE perpus_item2 SET tersedia = '1' ".
				"WHERE kd = '$cc_itemkd'");

		mysql_query("UPDATE perpus_item3 SET tersedia = '1' ".
				"WHERE kd = '$cc_itemkd'");

		mysql_query("UPDATE perpus_item4 SET tersedia = '1' ".
				"WHERE kd = '$cc_itemkd'");


		//jika terlambat
		if (!empty($kd2))
			{
			//update ke pernah pinjam
			mysql_query("UPDATE perpus_pinjam SET iskembali = '1', ".
					"tgl_kembali2 = '$today', ".
					"isterlambat = '1' ".
					"WHERE kd_user = '$no_member' ".
//					"WHERE kd_user = '$pg_kd' ".
					"AND kd = '$kd'");
			}
		else
			{
			//update ke pernah pinjam
			mysql_query("UPDATE perpus_pinjam SET iskembali = '1', ".
					"tgl_kembali2 = '$today' ".
//					"WHERE kd_user = '$pg_kd' ".
					"WHERE kd_user = '$no_member' ".
					"AND kd = '$kd'");
			}
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd";
	xloc($ke);
	exit();
	}







//proses input baru /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//kode
//if ($_POST['kode0'])
if (($_POST['kode0']) OR ($_POST['btnOK2']))
//if ($_POST['btnOK2'])
	{
	//nilai
	$no_member = nosql($_POST['no_member']);
	$pg_kd = nosql($_POST['pg_kd']);
	$p_tgl = nosql($_POST['p_tgl']);
	$p_bln = nosql($_POST['p_bln']);
	$p_thn = nosql($_POST['p_thn']);
	$tgl_pinjam = "$p_thn:$p_bln:$p_tgl";
	$kodeu = nosql($_POST['kode0']);
//	$jmlx = nosql($_POST['jmlx']);
	$jmlx = "1";
	$item_jml = $jmlx;
	$jam_pinjam = "$jam:$menit:$detik";




	//jika null
	if (empty($kodeu))
		{
		//re-direct
		$pesan = "Entri Masih Kosong. Harap Diperhatikan...!!";
		$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&s=baru&a=detail";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
/*
		//bila barcode, ada 12 digit. tambahkan satu angka dibelakang
		if (strlen($kodeu) == '12')
			{
			$kodeu11 = "$kodeu";
			$kodeu21 = "7";
			$kodeu = $kodeu;
			}
*/

$kodeu = substr($kodeu,0,12);


		//cek, barkode-kah...? lebih dari 10 angka, BARCODE ////////////////////////////////////////////////////////////////////////////////
//		if ((strlen($kodeu) > 10) AND (is_numeric($kodeu)))
		if (is_numeric($kodeu))
			{
			//cek input
			$qcr = mysql_query("SELECT kd, kode FROM perpus_item ".
						"WHERE barkode = '$kodeu' ".
						"OR kd = '$kodeu'");
			$rcr = mysql_fetch_assoc($qcr);
			$tcr = mysql_num_rows($qcr);

			//cek input
			$qcr2 = mysql_query("SELECT kd, kode FROM perpus_item2 ".
						"WHERE barkode = '$kodeu' ".
						"OR kd = '$kodeu'");
			$rcr2 = mysql_fetch_assoc($qcr2);
			$tcr2 = mysql_num_rows($qcr2);

			//cek input
			$qcr3 = mysql_query("SELECT kd, kode FROM perpus_item3 ".
						"WHERE barkode = '$kodeu' ".
						"OR kd = '$kodeu'");
			$rcr3 = mysql_fetch_assoc($qcr3);
			$tcr3 = mysql_num_rows($qcr3);

			//cek input
			$qcr4 = mysql_query("SELECT kd, kode FROM perpus_item4 ".
						"WHERE barkode = '$kodeu' ".
						"OR kd = '$kodeu'");
			$rcr4 = mysql_fetch_assoc($qcr4);
			$tcr4 = mysql_num_rows($qcr4);

			//jika ada
			if ($tcr != 0)
				{
				$kodex = nosql($rcr['kode']);
				$brgkd = nosql($rcr['kd']);
				$pustaka_kode = "1";
				$ceku = "$tcr";
				}
			else if ($tcr2 != 0)
				{
				$kodex = nosql($rcr2['kode']);
				$brgkd = nosql($rcr2['kd']);
				$pustaka_kode = "2";
				$ceku = "$tcr2";
				}
			else if ($tcr3 != 0)
				{
				$kodex = nosql($rcr3['kode']);
				$brgkd = nosql($rcr3['kd']);
				$pustaka_kode = "3";
				$ceku = "$tcr3";
				}
			else if ($tcr4 != 0)
				{
				$kodex = nosql($rcr4['kode']);
				$brgkd = nosql($rcr4['kd']);
				$pustaka_kode = "4";
				$ceku = "$tcr4";
				}
			}
		else
			{
			//cek input
			$qcr = mysql_query("SELECT kd, kode FROM perpus_item ".
						"WHERE barkode = '$kodeu' ".
						"OR kd = '$kodeu'");
			$rcr = mysql_fetch_assoc($qcr);
			$tcr = mysql_num_rows($qcr);

			//cek input
			$qcr2 = mysql_query("SELECT kd, kode FROM perpus_item2 ".
						"WHERE barkode = '$kodeu' ".
						"OR kd = '$kodeu'");
			$rcr2 = mysql_fetch_assoc($qcr2);
			$tcr2 = mysql_num_rows($qcr2);

			//cek input
			$qcr3 = mysql_query("SELECT kd, kode FROM perpus_item3 ".
						"WHERE barkode = '$kodeu' ".
						"OR kd = '$kodeu'");
			$rcr3 = mysql_fetch_assoc($qcr3);
			$tcr3 = mysql_num_rows($qcr3);

			//cek input
			$qcr4 = mysql_query("SELECT kd, kode FROM perpus_item4 ".
						"WHERE barkode = '$kodeu' ".
						"OR kd = '$kodeu'");
			$rcr4 = mysql_fetch_assoc($qcr4);
			$tcr4 = mysql_num_rows($qcr4);

			//jika ada
			if ($tcr != 0)
				{
				$kodex = nosql($rcr['kode']);
				$brgkd = nosql($rcr['kd']);
				$pustaka_kode = "1";
				$ceku = "$tcr";
				}
			else if ($tcr2 != 0)
				{
				$kodex = nosql($rcr2['kode']);
				$brgkd = nosql($rcr2['kd']);
				$pustaka_kode = "2";
				$ceku = "$tcr2";
				}
			else if ($tcr3 != 0)
				{
				$kodex = nosql($rcr3['kode']);
				$brgkd = nosql($rcr3['kd']);
				$pustaka_kode = "3";
				$ceku = "$tcr3";
				}
			else if ($tcr4 != 0)
				{
				$kodex = nosql($rcr4['kode']);
				$brgkd = nosql($rcr4['kd']);
				$pustaka_kode = "4";
				$ceku = "$tcr4";
				}
			}


		//nek kode barang tidak ada. atau salah
//		if ($tcr == 0)
		if ($ceku == 0)
			{
			//null-kan
			xclose($koneksi);

			//re-direct
			$pesan = "Tidak ada Barang dengan Kode/Barcode tersebut. $kodeu2. Harap Diulangi...!!";
			$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&s=baru&a=detail";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//jika pustaka 1
			if ($pustaka_kode == "1")
				{
				$tblku = "perpus_item";
				}
			else if ($pustaka_kode == "2")
				{
				$tblku = "perpus_item2";
				}
			else if ($pustaka_kode == "3")
				{
				$tblku = "perpus_item3";
				}
			else if ($pustaka_kode == "4")
				{
				$tblku = "perpus_item4";
				}


			//cek
			$qcc = mysql_query("SELECT kd FROM $tblku ".
						"WHERE kd = '$brgkd' ".
						"AND tersedia = '1'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

/*
			//cek
			$qcc = mysql_query("SELECT kd FROM $tblku ".
						"WHERE kd = '$brgkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
*/


			//jika gak ada
			if ($tcc == 0)
				{
				//re-direct
				$pesan = "Item Tersebut Tidak Ada. Harap Diperhatikan...!!";
				$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&s=baru&a=detail";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//cek, boleh dipinjam atau tidak
				$qbleh = mysql_query("SELECT kd, status ".
							"FROM $tblku ".
							"WHERE kd = '$brgkd'");
				$rbleh = mysql_fetch_assoc($qbleh);
				$bleh_status = nosql($rbleh['status']);


				//jika boleh
				if ($bleh_status == "true")
					{
					//ketahui lama dan denda
					$qku = mysql_query("SELECT * FROM perpus_m_denda ".
										"WHERE kd_pustaka = '$pustaka_kode'");
					$rku = mysql_fetch_assoc($qku);
					$ku_maksjkw = nosql($rku['maksjkw']);

					//ketahui tanggal jatuh temponya
					$p_kembali = add_days($p_pinjam,$ku_maksjkw);
					$k_thn = substr($p_kembali,0,4);
					$k_bln = substr($p_kembali,5,2);
					$k_tgl = substr($p_kembali,-2);
					$tgl_kembali = "$k_thn:$k_bln:$k_tgl";



/*
					//insert
					mysql_query("INSERT INTO perpus_pinjam(kd, kd_user, kd_pustaka, tgl_pinjam, jam, tgl_kembali, kd_item, admin) VALUES ".
							"('$x', '$pg_kd', '$pustaka_kode', '$tgl_pinjam', '$jam_pinjam', '$tgl_kembali', '$brgkd', '$adm_session')");
*/
					//insert
					mysql_query("INSERT INTO perpus_pinjam(kd, kd_user, kd_pustaka, tgl_pinjam, jam, tgl_kembali, kd_item, admin) VALUES ".
							"('$x', '$no_member', '$pustaka_kode', '$tgl_pinjam', '$jam_pinjam', '$tgl_kembali', '$brgkd', '$adm_session')");


					//update sisa stock
					mysql_query("UPDATE $tblku SET tersedia = '0' ".
							"WHERE kd = '$brgkd'");

					//rangking
					$qkki = mysql_query("SELECT kd FROM perpus_item_rangking ".
								"WHERE kd_item = '$brgkd'");
					$rkki = mysql_fetch_assoc($qkki);
					$tkki = mysql_num_rows($qkki);
					$kki_jml = nosql($rkki['jml']);
					$kki_total = round($kki_jml + 1);

					//ada...?
					if ($tkki != 0)
						{
						//update rangking
						mysql_query("UPDATE perpus_item_rangking SET jml = '$kki_total' ".
								"WHERE kd_item = '$brgkd'");
						}
					else
						{
						//insert
						mysql_query("INSERT INTO perpus_item_rangking(kd, kd_item, jml) VALUES ".
								"('$x', '$brgkd', '$kki_total')");
						}


					//re-direct
					$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&s=baru&a=detail";
					xloc($ke);
					exit();
					}

				//jika tidak boleh dipinjam
				else
					{
					//re-direct
					$pesan = "Item ini Belum Bisa Dipinjam. Harap Diperhatikan...!!";
					$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&s=baru&a=detail";
					pekem($pesan,$ke);
					exit();
					}
				}
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//proses hapus //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($a == "hapus")
	{
	//nilai
	$kdx = nosql($_REQUEST['kdx']);
	$no_member = nosql($_REQUEST['no_member']);
	$itemkd = nosql($_REQUEST['itemkd']);
	$pg_kd = nosql($_REQUEST['pg_kd']);
	$p_tgl = nosql($_REQUEST['p_tgl']);
	$p_bln = nosql($_REQUEST['p_bln']);
	$p_thn = nosql($_REQUEST['p_thn']);
	$tgl_pinjam = "$p_thn:$p_bln:$p_tgl";
	$ke = "$filenya?no_member=$no_member&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&s=baru&a=detail";

	mysql_query("UPDATE perpus_item SET tersedia = '1' ".
			"WHERE kd = '$itemkd'");

	mysql_query("UPDATE perpus_item2 SET tersedia = '1' ".
			"WHERE kd = '$itemkd'");

	mysql_query("UPDATE perpus_item3 SET tersedia = '1' ".
			"WHERE kd = '$itemkd'");

	mysql_query("UPDATE perpus_item4 SET tersedia = '1' ".
			"WHERE kd = '$itemkd'");
	//del
	mysql_query("DELETE FROM perpus_pinjam ".
//			"WHERE kd_user = '$pg_kd' ".
			"WHERE kd_user = '$no_member' ".
			"AND kd = '$kdx'");


	//null-kan
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//menu
require("../../inc/menu/admpus.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();




//js
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/js/checkall.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Nomor Anggota Perpus :
<br>
<INPUT type="text" name="no_member" value="'.$no_member.'" size="20">
<INPUT type="submit" name="btnOK" value=">>">
</p>';



//jika null
if (empty($no_member))
	{
	echo '<p>
	<font color="red">
	<strong>Masukkan Dahulu, Nomor Anggota Perpustakaan.</strong>
	</font>
	</p>';
	}
else
	{
	echo '<p>
	Nomor Anggota :
	<input name="pg_no" type="text" value="'.$dt_nip.'" size="20" class="input" readonly>,
	Nama :
	<input name="pg_nama" type="text" value="'.$dt_nama.'" size="30" class="input" readonly>,
	Posisi :
	<input name="pg_posisi" type="text" value="'.$dt_tipe.'" size="30" class="input" readonly>
	</p>
	<hr>';


	//jika iya...
	if (!empty($no_member))
		{
		//jika pinjam baru
		if ($s == "baru")
			{
			$d1_nil = "disabled";
			}

		//jika pernah pinjam
		else if ($s == "pernah")
			{
			$d2_nil = "disabled";
			}

		//jika sedang pinjam
		else if (empty($s))
			{
			$d3_nil = "disabled";
			}


		echo '<p>
		<INPUT type="hidden" name="pg_kd" value="'.$dt_kd.'">
		<INPUT type="hidden" name="s" value="'.$s.'">
		<INPUT type="hidden" name="a" value="'.$a.'">
		<input name="btnBR" type="submit" value="Pinjam Baru >>" '.$d1_nil.'>
		<input name="btnPR" type="submit" value="Pernah Pinjam >>" '.$d2_nil.'>
		<input name="btnSD" type="submit" value="Sedang Pinjam >>" '.$d3_nil.'>
		<hr>
		</p>';

		//jika baru
		if ($s == "baru")
			{
/*
			//jika detail
			if ($a == "detail")
				{
				$st_detail = "disabled";
				}
*/

			echo '<p>
			Tgl. Pinjam :
			<select name="pinjam_tgl" '.$st_detail.'>
			<option value="'.$p_tgl.'" selected>'.$p_tgl.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="pinjam_bln" '.$st_detail.'>
			<option value="'.$p_bln.'" selected>'.$arrbln[$p_bln].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="pinjam_thn" '.$st_detail.'>
			<option value="'.$p_thn.'" selected>'.$p_thn.'</option>';
			for ($k=$pinjam01;$k<=$pinjam02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			<input name="p_tgl" type="hidden" value="'.$p_tgl.'">
			<input name="p_bln" type="hidden" value="'.$p_bln.'">
			<input name="p_thn" type="hidden" value="'.$p_thn.'">
			<input name="btnDTI" type="submit" value="Detail Item >>" '.$st_detail.'>
			</p>';



			//detail item
			if ($a == "detail")
				{
				echo 'Kode/Barkode :
				<input name="kode0" type="text" size="15" value="" class="xinput1"
				onKeyDown="var keyCode = event.keyCode;
				if (keyCode == 13)
					{
					document.formx.kodex.value = document.formx.kode0.value;
					document.formx.submit();
					}
				">

				<input name="btnOK2" type="submit" value=">>">
				<table width="700" border="1" cellpadding="3" cellspacing="0">
				<tr>
				<td width="150"><strong>Kode</strong></td>
				<td width="150"><strong>Barcode</strong></td>
				<td><strong>Nama Item</strong></td>
				<td width="50"><strong>Pustaka</strong></td>
				<td width="50"><strong>Lama Pinjam</strong></td>
				<td width="200"><strong>Tgl.Kembali</strong></td>
				<td width="1">&nbsp;</td>
				</tr>';



				//data ne ////////////////////////////////////////////////////////////////////////////////////////////////////
				$qcob = mysql_query("SELECT * FROM perpus_pinjam ".
//							"WHERE perpus_pinjam.kd_user = '$pg_kd' ".
							"WHERE perpus_pinjam.kd_user = '$no_member' ".
							"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d')) = '$p_tgl' ".
							"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$p_bln' ".
							"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$p_thn' ".
							"AND perpus_pinjam.iskembali = '0' ".
							"ORDER BY tgl_pinjam DESC, ".
							"jam DESC");
				$rcob = mysql_fetch_assoc($qcob);
				$tcob = mysql_num_rows($qcob);


				//nek gak null
				if ($tcob != 0)
					{
					do
						{
						$nomerx = $nomerx + 1;

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



						$i_pkd = nosql($rcob['kd']);
						$i_itemkd = nosql($rcob['kd_item']);
						$i_userkd = $pg_kd;
						$i_tgl_pinjam = $rcob['tgl_pinjam'];
						$i_tgl_kembali = $rcob['tgl_kembali'];


						//brg item
						$qtemx = mysql_query("SELECT * FROM perpus_item ".
									"WHERE kd = '$i_itemkd'");
						$rtemx = mysql_fetch_assoc($qtemx);
						$ttemx = mysql_num_rows($qtemx);

						//brg item
						$qtemx2 = mysql_query("SELECT * FROM perpus_item2 ".
									"WHERE kd = '$i_itemkd'");
						$rtemx2 = mysql_fetch_assoc($qtemx2);
						$ttemx2 = mysql_num_rows($qtemx2);

						//brg item
						$qtemx3 = mysql_query("SELECT * FROM perpus_item3 ".
									"WHERE kd = '$i_itemkd'");
						$rtemx3 = mysql_fetch_assoc($qtemx3);
						$ttemx3 = mysql_num_rows($qtemx3);

						//brg item
						$qtemx4 = mysql_query("SELECT * FROM perpus_item4 ".
									"WHERE kd = '$i_itemkd'");
						$rtemx4 = mysql_fetch_assoc($qtemx4);
						$ttemx4 = mysql_num_rows($qtemx4);

						//jika ada
						if ($ttemx != 0)
							{
							$temx_kode = balikin2($rtemx['kode']);
							$temx_barkode = nosql($rtemx['barkode']);
							$temx_nama = balikin2($rtemx['judul']);
							$temx_pustaka = "Buku";
							$temx_pustakakd = "1";
							}
						else if ($ttemx2 != 0)
							{
							$temx_kode = balikin2($rtemx2['kode']);
							$temx_barkode = nosql($rtemx2['barkode']);
							$temx_nama = balikin2($rtemx2['topik']);
							$temx_pustaka = "Majalah";
							$temx_pustakakd = "2";
							}
						else if ($ttemx3 != 0)
							{
							$temx_kode = balikin2($rtemx3['kode']);
							$temx_barkode = nosql($rtemx3['barkode']);
							$temx_nama = balikin2($rtemx3['judul']);
							$temx_pustaka = "CD";
							$temx_pustakakd = "3";
							}
						else if ($ttemx4 != 0)
							{
							$temx_kode = balikin2($rtemx4['kode']);
							$temx_barkode = nosql($rtemx4['barkode']);
							$temx_nama = balikin2($rtemx4['judul']);
							$temx_pustaka = "Referensi";
							$temx_pustakakd = "4";
							}




						//ketahui lama dan denda
						$qku = mysql_query("SELECT * FROM perpus_m_denda ".
												"WHERE kd_pustaka = '$temx_pustakakd'");
						$rku = mysql_fetch_assoc($qku);
						$ku_maksjkw = nosql($rku['maksjkw']);
						$temx_lama = "$ku_maksjkw Hari";

						//ketahui tanggal jatuh temponya
						$p_kembali = add_days($p_pinjam,$ku_maksjkw);
						$k_thn = substr($p_kembali,0,4);
						$k_bln = substr($p_kembali,5,2);
						$k_tgl = substr($p_kembali,-2);
						$tgl_kembali = "$k_tgl/$k_bln/$k_thn";



						echo "<tr valign=\"top\" bgcolor=\"$warna\"
						onkeyup=\"this.bgColor='$warnaover';\"
						onkeydown=\"this.bgColor='$warna';\"
						onmouseover=\"this.bgColor='$warnaover';\"
						onmouseout=\"this.bgColor='$warna';\">";
						echo '<td>
						<input name="kd'.$nomerx.'" type="hidden" value="'.$i_kd.'">
						<input name="kode'.$nomerx.'" type="text" value="'.$temx_kode.'" size="15" class="xinput" readonly>
						</td>
						<td>
						<input name="barkode'.$nomerx.'" type="text" value="'.$temx_barkode.'" size="20" class="xinput" readonly>
						</td>
						<td>
						<input name="nm'.$nomerx.'" type="text" value="'.$temx_nama.'" size="50" class="xinput" readonly>
						</td>
						<td>
						<input name="pustaka'.$nomerx.'" type="text" value="'.$temx_pustaka.'" size="10" class="xinput" readonly>
						</td>
						<td>
						<input name="lama2'.$nomerx.'" type="text" value="'.$temx_lama.'" size="10" class="xinput" readonly>
						</td>
						<td>
						<input name="kembali'.$nomerx.'" type="text" value="'.$tgl_kembali.'" size="10" class="xinput" readonly>
						</td>
						<td>
						<a href="'.$filenya.'?kdx='.$i_pkd.'&itemkd='.$i_itemkd.'&no_member='.$no_member.'&pg_kd='.$pg_kd.'&p_tgl='.$p_tgl.'&p_bln='.$p_bln.'&p_thn='.$p_thn.'&k_tgl='.$k_tgl.'&k_bln='.$k_bln.'&k_thn='.$k_thn.'&s=baru&a=hapus" title="'.$temx_nama.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>
						</td>
						</tr>';
						}
					while ($rcob = mysql_fetch_assoc($qcob));
					}

				echo '</table>
				<input name="kdx" type="hidden" value="">
				<input name="kodex" type="hidden" value="">';
				}
			}



		//pernah pinjam
		else if ($s == "pernah")
			{
			//data pinjam item
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
					"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
					"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
					"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
					"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
					"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
					"DATE_FORMAT(perpus_pinjam.tgl_kembali2, '%d') AS k_tgl2, ".
					"DATE_FORMAT(perpus_pinjam.tgl_kembali2, '%m') AS k_bln2, ".
					"DATE_FORMAT(perpus_pinjam.tgl_kembali2, '%Y') AS k_thn2, ".
					"perpus_pinjam.* ".
					"FROM perpus_pinjam ".
//					"WHERE kd_user = '$pg_kd' ".
					"WHERE kd_user = '$no_member' ".
					"AND iskembali = '1' ".
					"ORDER BY tgl_pinjam DESC, ".
					"tgl_kembali2 DESC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?no_member=$no_member&pg_kd=$pg_kd&s=pernah";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//jika ada
			if ($count != 0)
				{
				echo '<table width="1100" border="1" cellspacing="0" cellpadding="3">
				<tr bgcolor="'.$warnaheader.'">
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
				<td width="50"><strong>Kode</strong></td>
				<td width="50"><strong>Barcode</strong></td>
				<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
				<td width="50"><strong><font color="'.$warnatext.'">Pustaka</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Seharusnya Kembali</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pengembalian</font></strong></td>
				<td width="50"><strong><font color="'.$warnatext.'">Terlambat</font></strong></td>
				<td width="50"><strong><font color="'.$warnatext.'">Denda</font></strong></td>
				</tr>';

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

					$nox = $nox + 1;
					$buk_kd = nosql($data['kd']);
					$buk_ptgl = nosql($data['p_tgl']);
					$buk_pbln = nosql($data['p_bln']);
					$buk_pthn = nosql($data['p_thn']);
					$buk_ktgl = nosql($data['k_tgl']);
					$buk_kbln = nosql($data['k_bln']);
					$buk_kthn = nosql($data['k_thn']);
					$buk_ktgl2 = nosql($data['k_tgl2']);
					$buk_kbln2 = nosql($data['k_bln2']);
					$buk_kthn2 = nosql($data['k_thn2']);
					$buk_itemkd = nosql($data['kd_item']);
//					$buk_jml = nosql($data['jml']);
					$buk_status = nosql($data['status']);
					$buk_jml_telat = nosql($data['jml_hari_telat']);
					$buk_denda = nosql($data['denda']);


					//jika ada telat
					if (!empty($buk_jml_telat))
						{
						$buk_jml_telat2 = "$buk_jml_telat Hari";
						$warna = "red";
						}
					else
						{
						$buk_jml_telat2 = "-";
						}


					//jika gak null
					if (!empty($buk_denda))
						{
						$buk_denda2 = "Rp. $buk_denda";
						}
					else
						{
						$buk_dend2 = $buk_denda;
						}


					//brg item
					$qtemx = mysql_query("SELECT * FROM perpus_item ".
								"WHERE kd = '$buk_itemkd'");
					$rtemx = mysql_fetch_assoc($qtemx);
					$ttemx = mysql_num_rows($qtemx);

					//brg item
					$qtemx2 = mysql_query("SELECT * FROM perpus_item2 ".
								"WHERE kd = '$buk_itemkd'");
					$rtemx2 = mysql_fetch_assoc($qtemx2);
					$ttemx2 = mysql_num_rows($qtemx2);

					//brg item
					$qtemx3 = mysql_query("SELECT * FROM perpus_item3 ".
								"WHERE kd = '$buk_itemkd'");
					$rtemx3 = mysql_fetch_assoc($qtemx3);
					$ttemx3 = mysql_num_rows($qtemx3);

					//brg item
					$qtemx4 = mysql_query("SELECT * FROM perpus_item4 ".
								"WHERE kd = '$buk_itemkd'");
					$rtemx4 = mysql_fetch_assoc($qtemx4);
					$ttemx4 = mysql_num_rows($qtemx4);

					//jika ada
					if ($ttemx != 0)
						{
						$temx_kode = balikin2($rtemx['kode']);
						$temx_barkode = nosql($rtemx['barkode']);
						$temx_nama = balikin2($rtemx['judul']);
						$temx_pustaka = "Buku";
						$temx_pustakakd = "1";
						}
					else if ($ttemx2 != 0)
						{
						$temx_kode = balikin2($rtemx2['kode']);
						$temx_barkode = nosql($rtemx2['barkode']);
						$temx_nama = balikin2($rtemx2['topik']);
						$temx_pustaka = "Majalah";
						$temx_pustakakd = "2";
						}
					else if ($ttemx3 != 0)
						{
						$temx_kode = balikin2($rtemx3['kode']);
						$temx_barkode = nosql($rtemx3['barkode']);
						$temx_nama = balikin2($rtemx3['judul']);
						$temx_pustaka = "CD";
						$temx_pustakakd = "3";
						}
					else if ($ttemx4 != 0)
						{
						$temx_kode = balikin2($rtemx4['kode']);
						$temx_barkode = nosql($rtemx4['barkode']);
						$temx_nama = balikin2($rtemx4['judul']);
						$temx_pustaka = "Referensi";
						$temx_pustakakd = "4";
						}




					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>'.$buk_ptgl.' '.$arrbln1[$buk_pbln].' '.$buk_pthn.'</td>
					<td>'.$temx_kode.'</td>
					<td>'.$temx_barkode.'</td>
					<td><strong>'.$temx_nama.'</strong></td>
					<td>'.$temx_pustaka.'</td>
					<td>'.$buk_ktgl.' '.$arrbln1[$buk_kbln].' '.$buk_kthn.'</td>
					<td>'.$buk_ktgl2.' '.$arrbln1[$buk_kbln2].' '.$buk_kthn2.'</td>
					<td>'.$buk_jml_telat2.'</td>
					<td>'.$buk_denda2.'</td>
				        </tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="700" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
				</tr>
				</table>';
				}
			else
				{
				echo '<p>
				<font color="red">
				<strong>BELUM PERNAH PINJAM ITEM. . .</strong>
				</font>
				</p>';
				}
			}



		//daftar aja..., sedang pinjam...
		else
			{
			//data pinjam item
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
						"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
						"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
						"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
						"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
						"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
						"perpus_pinjam.* ".
						"FROM perpus_pinjam ".
//						"WHERE kd_user = '$pg_kd' ".
						"WHERE kd_user = '$no_member' ".
						"AND iskembali = '0' ".
						"ORDER BY tgl_pinjam DESC, ".
						"jam DESC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?no_member=$no_member&pg_kd=$pg_kd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//jika ada
			if ($count != 0)
				{
				echo '<table width="1100" border="1" cellspacing="0" cellpadding="3">
				<tr bgcolor="'.$warnaheader.'">
				<td width="1">&nbsp;</td>
				<td width="50"><strong>Kode</strong></td>
				<td width="50"><strong>Barcode</strong></td>
				<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
				<td width="50"><strong><font color="'.$warnatext.'">Pustaka</font></strong></td>
				<td width="130"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
				<td width="130"><strong><font color="'.$warnatext.'">Tgl. Kembali Seharusnya</font></strong></td>
				<td width="130"><strong><font color="'.$warnatext.'">Tgl. Kembali Sekarang</font></strong></td>
				<td width="100"><strong><font color="'.$warnatext.'">Terlambat</font></strong></td>
				<td width="100"><strong><font color="'.$warnatext.'">Denda</font></strong></td>
				</tr>';

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

					$nox = $nox + 1;
					$buk_kd = nosql($data['kd']);
					$buk_ptgl = nosql($data['p_tgl']);
					$buk_pbln = nosql($data['p_bln']);
					$buk_pthn = nosql($data['p_thn']);
					$buk_ktgl = nosql($data['k_tgl']);
					$buk_kbln = nosql($data['k_bln']);
					$buk_kthn = nosql($data['k_thn']);
					$buk_itemkd = nosql($data['kd_item']);
					$buk_status = nosql($data['status']);





					//brg item
					$qtemx = mysql_query("SELECT * FROM perpus_item ".
								"WHERE kd = '$buk_itemkd'");
					$rtemx = mysql_fetch_assoc($qtemx);
					$ttemx = mysql_num_rows($qtemx);

					//brg item
					$qtemx2 = mysql_query("SELECT * FROM perpus_item2 ".
								"WHERE kd = '$buk_itemkd'");
					$rtemx2 = mysql_fetch_assoc($qtemx2);
					$ttemx2 = mysql_num_rows($qtemx2);

					//brg item
					$qtemx3 = mysql_query("SELECT * FROM perpus_item3 ".
								"WHERE kd = '$buk_itemkd'");
					$rtemx3 = mysql_fetch_assoc($qtemx3);
					$ttemx3 = mysql_num_rows($qtemx3);

					//brg item
					$qtemx4 = mysql_query("SELECT * FROM perpus_item4 ".
								"WHERE kd = '$buk_itemkd'");
					$rtemx4 = mysql_fetch_assoc($qtemx4);
					$ttemx4 = mysql_num_rows($qtemx4);

					//jika ada
					if ($ttemx != 0)
						{
						$temx_kode = balikin2($rtemx['kode']);
						$temx_barkode = nosql($rtemx['barkode']);
						$temx_nama = balikin2($rtemx['judul']);
						$temx_pustaka = "Buku";
						$temx_pustakakd = "1";
						}
					else if ($ttemx2 != 0)
						{
						$temx_kode = balikin2($rtemx2['kode']);
						$temx_barkode = nosql($rtemx2['barkode']);
						$temx_nama = balikin2($rtemx2['topik']);
						$temx_pustaka = "Majalah";
						$temx_pustakakd = "2";
						}
					else if ($ttemx3 != 0)
						{
						$temx_kode = balikin2($rtemx3['kode']);
						$temx_barkode = nosql($rtemx3['barkode']);
						$temx_nama = balikin2($rtemx3['judul']);
						$temx_pustaka = "CD";
						$temx_pustakakd = "3";
						}
					else if ($ttemx4 != 0)
						{
						$temx_kode = balikin2($rtemx4['kode']);
						$temx_barkode = nosql($rtemx4['barkode']);
						$temx_nama = balikin2($rtemx4['judul']);
						$temx_pustaka = "Referensi";
						$temx_pustakakd = "4";
						}





					//ketahui lama dan denda
					$qku = mysql_query("SELECT * FROM perpus_m_denda ".
											"WHERE kd_pustaka = '$temx_pustakakd'");
					$rku = mysql_fetch_assoc($qku);
					$ku_maksjkw = nosql($rku['maksjkw']);
					$ku_denda = nosql($rku['denda']);



					//ketahui selisih hari
					$tgl_kembali = "$buk_kthn-$buk_kbln-$buk_ktgl";
					$tgl_sekarang = "$tahun-$bulan-$tanggal";

					//selisih
					$selisih = strtotime ($tgl_sekarang) - strtotime ($tgl_kembali);
					$selisih = $selisih / 86400;

					//jika kurang
					if (floor($selisih) < 0)
						{
						$selisih = "0";
						}



					//jml.denda
					$jml_denda = $ku_denda * $selisih;



					//masukkan tanggal saat ini
					mysql_query("UPDATE perpus_pinjam SET tgl_kembali2 = '$today', ".
							"denda = '$jml_denda', ".
							"jml_hari_telat = '$selisih' ".
							"WHERE kd_user = '$pg_kd' ".
							"AND kd_item = '$buk_itemkd' ".
							"AND round(DATE_FORMAT(tgl_pinjam, '%d')) = '$buk_ptgl' ".
							"AND round(DATE_FORMAT(tgl_pinjam, '%m')) = '$buk_pbln' ".
							"AND round(DATE_FORMAT(tgl_pinjam, '%Y')) = '$buk_pthn'");




					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
					<input name="jml_hari'.$nox.'" type="hidden" value="'.$selisih.'">
					<input type="checkbox" name="item'.$nox.'" value="'.$buk_kd.'">
			        	</td>
					<td>'.$temx_kode.'</td>
					<td>'.$temx_barkode.'</td>
					<td><strong>'.$temx_nama.'</strong></td>
					<td>'.$temx_pustaka.'</td>
					<td>'.$buk_ptgl.' '.$arrbln1[$buk_pbln].' '.$buk_pthn.'</td>
					<td>'.$buk_ktgl.' '.$arrbln1[$buk_kbln].' '.$buk_kthn.'</td>
					<td>'.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</td>
					<td>'.$selisih.' Hari</td>
					<td>Rp.'.$jml_denda.',00</td>
			        	</tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="700" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td width="300">
				<input name="s" type="hidden" value="'.$s.'">
				<input name="total" type="hidden" value="'.$count.'">
				<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
				<input name="btnKBL" type="submit" value="KEMBALIKAN">
				</td>
				<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
				</tr>
				</table>';
				}
			else
				{
				echo '<p>
				<font color="red">
				<strong>TIDAK ADA DATA. SEDANG TIDAK MELAKUKAN PEMINJAMAN ITEM. . .</strong>
				</font>
				</p>';
				}
			}
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

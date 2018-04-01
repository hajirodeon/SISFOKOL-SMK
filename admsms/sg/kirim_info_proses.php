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



require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/sms.php");



//nilai
$filenya = "kirim_info_proses.php";
$fkrm = nosql($_REQUEST['fkrm']);

//jika NO
if ($fkrm == "no")
	{
	echo '';
	}
else
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);


	//kirim
	if (($_POST['btnKRM']) OR (!$swkd))
		{
		//nilai
		$swkd = nosql($_REQUEST['swkd']);
		$swnis = nosql($_REQUEST['swnis']);
		$tapelkd = nosql($_REQUEST['tapelkd']);
		$kelkd = nosql($_REQUEST['kelkd']);
		$s = nosql($_REQUEST['s']);

		//jika null
		if (empty($s))
			{
			$s = "aktif";
			}



		//isi info
		$qx4 = mysql_query("SELECT * FROM sms_info");
		$rowx4 = mysql_fetch_assoc($qx4);
		$x4_info = balikin2($rowx4['info']);




		//total
		$qdata = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"ORDER BY round(m_siswa.nis) ASC");
		$rdata = mysql_fetch_assoc($qdata);
		$tdata = mysql_num_rows($qdata);
		$data_swkd = nosql($rdata['mskd']);
		$data_swnis = nosql($rdata['msnis']);

		//jml.data
		$jml_data = $tdata;
		$delay_detik = "5";


		//jika ada data
		if ($tdata != 0)
			{
			//jika null
			if (empty($swkd))
				{
				$i_swkd = $data_swkd;
				$i_swnis = $data_swnis;
				}
			else
				{
				//siswa terpilih lanjutan...
				$qsmku = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND round(m_siswa.nis) > '$swnis' ".
							"ORDER BY round(m_siswa.nis) ASC");
				$rsmku = mysql_fetch_assoc($qsmku);
				$tsmku = mysql_num_rows($qsmku);
				$i_swkd = nosql($rsmku['mskd']);
				$i_swnis = nosql($rsmku['nis']);
				}



			//siswa terpilih
			$qsmkux = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND m_siswa.kd = '$swkd' ".
						"AND m_siswa.nis = '$swnis'");
			$rsmkux = mysql_fetch_assoc($qsmkux);
			$tsmkux = mysql_num_rows($qsmkux);
			$smkux_swkd = balikin($rsmkux['mskd']);
			$smkux_nis = balikin($rsmkux['nis']);
			$smkux_nama = balikin($rsmkux['nama']);


			//cek punya no.hp
			$qcc = mysql_query("SELECT * FROM sms_nohp_siswa ".
						"WHERE kd_siswa = '$smkux_swkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$cc_nohp = nosql($rcc['nohp']);

			//jika ada
			if ($tcc != 0)
				{
				$cc_hpku = "[$cc_nohp]";
				}
			else
				{
				$cc_hpku = "[<font color=\"red\"><strong>TIDAK PUNYA NO.HP</strong></font>]";
				}





			//ketahui siswa terakhir
			$qsmkux2 = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"ORDER BY round(m_siswa.nis) DESC");
			$rsmkux2 = mysql_fetch_assoc($qsmkux2);
			$tsmkux2 = mysql_num_rows($qsmkux2);
			$smkux2_swkd = nosql($rsmkux2['mskd']);
			$smkux2_nis = nosql($rsmkux2['nis']);
			$smkux2_nama = balikin($rsmkux2['nama']);



			//jika aktif
			if (($smkux_nis < $smkux2_nis) AND ($s == "aktif"))
				{
				echo '<script>
				setTimeout("location.href=\''.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&swkd='.$i_swkd.'&swnis='.$i_swnis.'&s=aktif\'", '.$delay_detik.'000);
				</script>';

				//jika null
				if (empty($smkux_nis))
					{
					echo '';
					}
				else
					{
					echo '<p>
					'.$smkux_nis.'.'.$smkux_nama.'
					<br>
					'.$cc_hpku.'
					</p>';

					//kirim sms-nya
					//kirim sms, melalui service mysql khusus gammu
					mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID, SendingDateTime) VALUES ".
							"('$cc_nohp', '$x4_info', 'gammu', '$today')");


					//simpan ke database ///////////////////////////////////////////////////////
					mysql_query("INSERT INTO sms_info_sent (kd, kd_siswa, info, postdate) VALUES ".
							"('$x', '$i_swkd', '$x4_info', '$today')");
					}

				echo '<div id="loading"><img src="'.$sumber.'/img/loading.gif" width="16" height="16"><font color="white" style="background-color:red; width:200px;">&nbsp;<strong>Sedang Mengirim SMS...</strong>&nbsp;</font></div>';
				}

			//siswa terakhir...
			else if (($smkux_nis == $smkux2_nis) AND ($s == "aktif"))
				{
				echo '<script>
				setTimeout("location.href=\''.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&s=selesai\'", '.$delay_detik.'000);
				</script>

				<p>
				'.$smkux_nis.'.'.$smkux_nama.'
				<br>
				'.$cc_hpku.'
				</p>';


				//kirim sms via gammu //////////////////////////////////////////////////////
				$sms = new gammu($gammu_bin,$gammu_config,$gammu_config_section);


				//Sending SMS
				$sms->Send($cc_nohp,$x4_info,$response);
				echo '<pre>';
				print_r($response); echo '</pre>';



				//simpan ke database ///////////////////////////////////////////////////////
				mysql_query("INSERT INTO sms_info_sent (kd, kd_siswa, info, postdate) VALUES ".
						"('$x', '$i_swkd', '$x4_info', '$today')");

				echo '<div id="loading"><img src="'.$sumber.'/img/loading.gif" width="16" height="16"><font color="white" style="background-color:red; width:200px;">&nbsp;<strong>Sedang Mengirim SMS...</strong>&nbsp;</font></div>';
				}

			//selesai...
			else if ($s == "selesai")
				{
				echo '<p>[<font color="red">
				<strong>SELESAI</strong>
				</font>].</p>';
				}
			}
		else
			{
			echo '<p>
			<font color="red">
			<strong>TIDAK ADA DATA. HARAP DIPERHATIKAN...!!</strong>
			</font>
			</p>';
			}
		}
	}




//diskonek
xclose($koneksi);
exit();
?>
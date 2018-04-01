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

//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/class/paging.php");
require("../../../inc/class/pagingx.php");
$tpl = LoadTpl("../../../template/janissari.html");


nocache;

//nilai
$filenya = "logs.php";
$judul = "Logs History";
$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
$judulx = $judul;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//isi *START
ob_start();


//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/menu/janissari.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="100%" height="300" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FDF0DE" valign="top">
<td>';
//judul
xheadline($judul);

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT kd AS kdx, postdate AS pd FROM user_blog_status ". //status
					"WHERE kd_user = '$kd1_session' ".
						"UNION ".
					"SELECT kd AS kdx, postdate AS pd FROM user_blog_note ". //note
					"WHERE kd_user = '$kd1_session' ".
						"UNION ".
					"SELECT kd AS kdx, postdate AS pd FROM user_blog_artikel ". //artikel
					"WHERE kd_user = '$kd1_session' ".
						"UNION ".
					"SELECT kd AS kdx, postdate AS pd FROM user_blog_buletin ". //buletin
					"WHERE kd_user = '$kd1_session' ".
						"UNION ".
					"SELECT kd AS kdx, postdate AS pd FROM user_blog_jurnal ". //jurnal
					"WHERE kd_user = '$kd1_session' ".
						"UNION ".
					"SELECT user_blog_status_msg.kd AS kdx, user_blog_status_msg.postdate AS pd  ". //komentar status
					"FROM user_blog_status, user_blog_status_msg ".
					"WHERE user_blog_status_msg.kd_user_blog_status = user_blog_status.kd ".
					"AND user_blog_status.kd_user = '$kd1_session' ".
					"OR user_blog_status_msg.dari = '$kd1_session' ".
						"UNION ".
					"SELECT user_blog_note_msg.kd AS kdx, user_blog_note_msg.postdate AS pd  ". //komentar note
					"FROM user_blog_note, user_blog_note_msg ".
					"WHERE user_blog_note_msg.kd_user_blog_note = user_blog_note.kd ".
					"AND user_blog_note.kd_user = '$kd1_session' ".
					"OR user_blog_note_msg.dari = '$kd1_session' ".
						"UNION ".
					"SELECT user_blog_artikel_msg.kd AS kdx, user_blog_artikel_msg.postdate AS pd  ". //komentar artikel
					"FROM user_blog_artikel, user_blog_artikel_msg ".
					"WHERE user_blog_artikel_msg.kd_user_blog_artikel = user_blog_artikel.kd ".
					"AND user_blog_artikel.kd_user = '$kd1_session' ".
					"OR user_blog_artikel_msg.dari = '$kd1_session' ".
						"UNION ".
					"SELECT user_blog_buletin_msg.kd AS kdx, user_blog_buletin_msg.postdate AS pd  ". //komentar buletin
					"FROM user_blog_buletin, user_blog_buletin_msg ".
					"WHERE user_blog_buletin_msg.kd_user_blog_buletin = user_blog_buletin.kd ".
					"AND user_blog_buletin.kd_user = '$kd1_session' ".
					"OR user_blog_buletin_msg.dari = '$kd1_session' ".
						"UNION ".
					"SELECT user_blog_jurnal_msg.kd AS kdx, user_blog_jurnal_msg.postdate AS pd  ". //komentar jurnal
					"FROM user_blog_jurnal, user_blog_jurnal_msg ".
					"WHERE user_blog_jurnal_msg.kd_user_blog_jurnal = user_blog_jurnal.kd ".
					"AND user_blog_jurnal.kd_user = '$kd1_session' ".
					"OR user_blog_jurnal_msg.dari = '$kd1_session' ".
						"UNION ".
					"SELECT kd AS kdx, postdate AS pd FROM user_blog ". //profil
					"WHERE kd_user = '$kd1_session' ".
						"UNION ".
					"SELECT kd AS kdx, postdate AS pd FROM user_blog_msg ". //kirim dan terima message
					"WHERE kd_user = '$kd1_session' ".
					"OR untuk = '$kd1_session' ".
						"UNION ".
					"SELECT kd AS kdx, postdate AS pd  ". //album foto
					"FROM user_blog_album ".
					"WHERE kd_user = '$kd1_session' ".
						"UNION ".
					"SELECT kd AS kdx, postdate AS pd  ". //komentar foto
					"FROM user_blog_album_msg ".
					"WHERE dari = '$kd1_session' ".
						"ORDER BY pd DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);

echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">';

do
	{
	//nilai
	$nomer = $nomer + 1;
	$dt_kd = nosql($data['kdx']);
	$dt_postdate = $data['pd'];

	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td valign="top">';


	//status ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc1 = mysql_query("SELECT * FROM user_blog_status ".
							"WHERE kd = '$dt_kd'");
	$rcc1 = mysql_fetch_assoc($qcc1);
	$tcc1 = mysql_num_rows($qcc1);

	if($tcc1 != 0)
		{
		$cc1_status = balikin($rcc1['status']);

		echo '<p>['.$dt_postdate.']. <br>
		[<font color="red"><strong>Update STATUS</strong></font>].
		[<a href="'.$sumber.'/janissari/k/status/status.php?s=view&stkd='.$dt_kd.'#'.$dt_kd.'" title="'.$cc1_status.'">'.$cc1_status.'</a>].
		</p>
		<br>';
		}



	//note //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc2 = mysql_query("SELECT * FROM user_blog_note ".
							"WHERE kd = '$dt_kd'");
	$rcc2 = mysql_fetch_assoc($qcc2);
	$tcc2 = mysql_num_rows($qcc2);

	if ($tcc2 != 0)
		{
		$cc2_note = balikin($rcc2['note']);

		echo '<p>['.$dt_postdate.']. <br>
		[<font color="red"><strong>Update NOTE</strong></font>].
		[<a href="'.$sumber.'/janissari/k/note/note.php?s=view&stkd='.$dt_kd.'#'.$dt_kd.'" title="'.$cc2_note.'">'.$cc2_note.'</a>].
		</p>
		<br>';
		}



	//artikel ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc3 = mysql_query("SELECT * FROM user_blog_artikel ".
							"WHERE kd = '$dt_kd'");
	$rcc3 = mysql_fetch_assoc($qcc3);
	$tcc3 = mysql_num_rows($qcc3);

	if ($tcc3 != 0)
		{
		$cc3_judul = balikin($rcc3['judul']);

		echo '<p>['.$dt_postdate.']. <br>
		[<font color="red"><strong>Update ARTIKEL</strong></font>].
		[<a href="'.$sumber.'/janissari/k/artikel/artikel.php?s=view&artkd='.$dt_kd.'#'.$dt_kd.'" title="'.$cc3_judul.'">'.$cc3_judul.'</a>].
		</p>
		<br>';
		}



	//buletin ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc4 = mysql_query("SELECT * FROM user_blog_buletin ".
							"WHERE kd = '$dt_kd'");
	$rcc4 = mysql_fetch_assoc($qcc4);
	$tcc4 = mysql_num_rows($qcc4);

	if ($tcc4 != 0)
		{
		$cc4_judul = balikin($rcc4['judul']);

		echo '<p>['.$dt_postdate.']. <br>
		[<font color="red"><strong>Update BULETIN</strong></font>].
		[<a href="'.$sumber.'/janissari/k/buletin/buletin.php?s=view&bulkd='.$dt_kd.'#'.$dt_kd.'" title="'.$cc4_judul.'">'.$cc4_judul.'</a>].
		</p>
		<br>';
		}



	//jurnal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc5 = mysql_query("SELECT * FROM user_blog_jurnal ".
							"WHERE kd = '$dt_kd'");
	$rcc5 = mysql_fetch_assoc($qcc5);
	$tcc5 = mysql_num_rows($qcc5);

	if ($tcc5 != 0)
		{
		$cc5_judul = balikin($rcc5['judul']);

		echo '<p>['.$dt_postdate.']. <br>
		[<font color="red"><strong>Update JURNAL</strong></font>].
		[<a href="'.$sumber.'/janissari/k/jurnal/jurnal.php?s=view&jurkd='.$dt_kd.'#'.$dt_kd.'" title="'.$cc5_judul.'">'.$cc5_judul.'</a>].
		</p>
		<br>';
		}



	//komentar status ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc6 = mysql_query("SELECT user_blog_status.*, user_blog_status.kd AS stkd, ".
							"user_blog_status_msg.*, ".
							"user_blog_status_msg.postdate AS stpd ".
							"FROM user_blog_status, user_blog_status_msg ".
							"WHERE user_blog_status_msg.kd_user_blog_status = user_blog_status.kd ".
							"AND user_blog_status_msg.kd = '$dt_kd'");
	$rcc6 = mysql_fetch_assoc($qcc6);
	$tcc6 = mysql_num_rows($qcc6);

	if($tcc6 != 0)
		{
		$cc6_msg = balikin($rcc6['msg']);
		$cc6_dari = nosql($rcc6['dari']);
		$cc6_kd = nosql($rcc6['stkd']);
		$cc6_stpd = $rcc6['stpd'];
		$cc6_uskd = nosql($rcc6['kd_user']);

		//oleh...
		$qtuse = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$cc6_dari'");
		$rtuse = mysql_fetch_assoc($qtuse);
		$tuse_kd = nosql($rtuse['kd']);
		$tuse_no = nosql($rtuse['nomor']);
		$tuse_nm = balikin($rtuse['nama']);
		$tuse_tipe = nosql($rtuse['tipe']);

		echo '<p>['.$cc6_stpd.']. <br>
		[<font color="red"><strong>Komentar STATUS</strong></font>]. ';

		//jika diri sendiri
		if ($cc6_uskd == $kd1_session)
			{
			echo '[<a href="'.$sumber.'/janissari/k/status/status.php?s=view&stkd='.$cc6_kd.'#'.$cc6_kd.'" title="'.$cc6_msg.'">'.$cc6_msg.'</a>].';
			}
		else
			{
			echo '[<a href="'.$sumber.'/janissari/p/status/status.php?uskd='.$cc6_uskd.'&s=view&stkd='.$cc6_kd.'#'.$cc6_kd.'" title="'.$cc6_msg.'">'.$cc6_msg.'</a>].';
			}

		echo '<br>
		[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
		</p>
		<br>';
		}



	//komentar note /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc7 = mysql_query("SELECT user_blog_note.*, user_blog_note.kd AS notkd, ".
							"user_blog_note_msg.*, ".
							"user_blog_note_msg.postdate AS notpd ".
							"FROM user_blog_note, user_blog_note_msg ".
							"WHERE user_blog_note_msg.kd_user_blog_note = user_blog_note.kd ".
							"AND user_blog_note_msg.kd = '$dt_kd'");
	$rcc7 = mysql_fetch_assoc($qcc7);
	$tcc7 = mysql_num_rows($qcc7);

	if($tcc7 != 0)
		{
		$cc7_msg = balikin($rcc7['msg']);
		$cc7_dari = nosql($rcc7['dari']);
		$cc7_kd = nosql($rcc7['notkd']);
		$cc7_notpd = $rcc7['notpd'];
		$cc7_uskd = nosql($rcc7['kd_user']);


		//oleh...
		$qtuse = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$cc7_dari'");
		$rtuse = mysql_fetch_assoc($qtuse);
		$tuse_kd = nosql($rtuse['kd']);
		$tuse_no = nosql($rtuse['nomor']);
		$tuse_nm = balikin($rtuse['nama']);
		$tuse_tipe = nosql($rtuse['tipe']);

		echo '<p>['.$cc7_notpd.']. <br>
		[<font color="red"><strong>Komentar NOTE</strong></font>]. ';

		//jika diri sendiri
		if ($cc7_uskd == $kd1_session)
			{
			echo '[<a href="'.$sumber.'/janissari/k/note/note.php?s=view&stkd='.$cc7_kd.'#'.$cc7_kd.'" title="'.$cc7_msg.'">'.$cc7_msg.'</a>].';
			}
		else
			{
			echo '[<a href="'.$sumber.'/janissari/p/note/note.php?uskd='.$cc7_uskd.'&s=view&stkd='.$cc7_kd.'#'.$cc7_kd.'" title="'.$cc7_msg.'">'.$cc7_msg.'</a>].';
			}

		echo '<br>
		[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
		</p>
		<br>';
		}



	//komentar artikel //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc8 = mysql_query("SELECT user_blog_artikel.*, user_blog_artikel.kd AS artkd, ".
							"user_blog_artikel_msg.*, ".
							"user_blog_artikel_msg.postdate AS artpd ".
							"FROM user_blog_artikel, user_blog_artikel_msg ".
							"WHERE user_blog_artikel_msg.kd_user_blog_artikel = user_blog_artikel.kd ".
							"AND user_blog_artikel_msg.kd = '$dt_kd'");
	$rcc8 = mysql_fetch_assoc($qcc8);
	$tcc8 = mysql_num_rows($qcc8);

	if($tcc8 != 0)
		{
		$cc8_msg = balikin($rcc8['msg']);
		$cc8_dari = nosql($rcc8['dari']);
		$cc8_kd = nosql($rcc8['artkd']);
		$cc8_artpd = $rcc8['artpd'];
		$cc8_uskd = nosql($rcc8['kd_user']);

		//oleh...
		$qtuse = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$cc8_dari'");
		$rtuse = mysql_fetch_assoc($qtuse);
		$tuse_kd = nosql($rtuse['kd']);
		$tuse_no = nosql($rtuse['nomor']);
		$tuse_nm = balikin($rtuse['nama']);
		$tuse_tipe = nosql($rtuse['tipe']);

		echo '<p>['.$cc8_artpd.']. <br>
		[<font color="red"><strong>Komentar ARTIKEL</strong></font>]. ';

		//jika diri sendiri
		if ($cc8_uskd == $kd1_session)
			{
			echo '[<a href="'.$sumber.'/janissari/k/artikel/artikel.php?s=view&artkd='.$cc8_kd.'#'.$cc8_kd.'" title="'.$cc8_msg.'">'.$cc8_msg.'</a>].';
			}
		else
			{
			echo '[<a href="'.$sumber.'/janissari/p/artikel/artikel.php?uskd='.$cc8_uskd.'&s=view&artkd='.$cc8_kd.'#'.$cc8_kd.'" title="'.$cc8_msg.'">'.$cc8_msg.'</a>].';
			}

		echo '<br>
		[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
		</p>
		<br>';
		}



	//komentar buletin //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc9 = mysql_query("SELECT user_blog_buletin.*, user_blog_buletin.kd AS bulkd, ".
							"user_blog_buletin_msg.*, ".
							"user_blog_buletin_msg.postdate AS bulpd ".
							"FROM user_blog_buletin, user_blog_buletin_msg ".
							"WHERE user_blog_buletin_msg.kd_user_blog_buletin = user_blog_buletin.kd ".
							"AND user_blog_buletin_msg.kd = '$dt_kd'");
	$rcc9 = mysql_fetch_assoc($qcc9);
	$tcc9 = mysql_num_rows($qcc9);

	if($tcc9 != 0)
		{
		$cc9_msg = balikin($rcc9['msg']);
		$cc9_dari = nosql($rcc9['dari']);
		$cc9_kd = nosql($rcc9['bulkd']);
		$cc9_bulpd = $rcc9['bulpd'];
		$cc9_uskd = nosql($rcc9['kd_user']);

		//oleh...
		$qtuse = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$cc9_dari'");
		$rtuse = mysql_fetch_assoc($qtuse);
		$tuse_kd = nosql($rtuse['kd']);
		$tuse_no = nosql($rtuse['nomor']);
		$tuse_nm = balikin($rtuse['nama']);
		$tuse_tipe = nosql($rtuse['tipe']);

		echo '<p>['.$cc9_bulpd.']. <br>
		[<font color="red"><strong>Komentar BULETIN</strong></font>]. ';

		//jika diri sendiri
		if ($cc9_uskd == $kd1_session)
			{
			echo '[<a href="'.$sumber.'/janissari/k/buletin/buletin.php?s=view&bulkd='.$cc9_kd.'#'.$cc9_kd.'" title="'.$cc9_msg.'">'.$cc9_msg.'</a>].';
			}
		else
			{
			echo '[<a href="'.$sumber.'/janissari/p/buletin/buletin.php?uskd='.$cc9_uskd.'&s=view&bulkd='.$cc9_kd.'#'.$cc9_kd.'" title="'.$cc9_msg.'">'.$cc9_msg.'</a>].';
			}

		echo '<br>
		[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
		</p>
		<br>';
		}



	//komentar jurnal ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc10 = mysql_query("SELECT user_blog_jurnal.*, user_blog_jurnal.kd AS jurkd, ".
							"user_blog_jurnal_msg.*, ".
							"user_blog_jurnal_msg.postdate AS jurpd ".
							"FROM user_blog_jurnal, user_blog_jurnal_msg ".
							"WHERE user_blog_jurnal_msg.kd_user_blog_jurnal = user_blog_jurnal.kd ".
							"AND user_blog_jurnal_msg.kd = '$dt_kd'");
	$rcc10 = mysql_fetch_assoc($qcc10);
	$tcc10 = mysql_num_rows($qcc10);

	if($tcc10 != 0)
		{
		$cc10_msg = balikin($rcc10['msg']);
		$cc10_dari = nosql($rcc10['dari']);
		$cc10_kd = nosql($rcc10['jurkd']);
		$cc10_jurpd = $rcc10['jurpd'];
		$cc10_uskd = nosql($rcc10['kd_user']);

		//oleh...
		$qtuse = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$cc10_dari'");
		$rtuse = mysql_fetch_assoc($qtuse);
		$tuse_kd = nosql($rtuse['kd']);
		$tuse_no = nosql($rtuse['nomor']);
		$tuse_nm = balikin($rtuse['nama']);
		$tuse_tipe = nosql($rtuse['tipe']);

		echo '<p>['.$cc10_jurpd.']. <br>
		[<font color="red"><strong>Komentar JURNAL</strong></font>]. ';

		//jika diri sendiri
		if ($cc10_uskd == $kd1_session)
			{
			echo '[<a href="'.$sumber.'/janissari/k/jurnal/jurnal.php?s=view&jurkd='.$cc10_kd.'#'.$cc10_kd.'" title="'.$cc10_msg.'">'.$cc10_msg.'</a>].		';
			}
		else
			{
			echo '[<a href="'.$sumber.'/janissari/p/jurnal/jurnal.php?uskd='.$cc10_uskd.'&s=view&jurkd='.$cc10_kd.'#'.$cc10_kd.'" title="'.$cc10_msg.'">'.$cc10_msg.'</a>].		';
			}

		echo '<br>
		[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
		</p>
		<br>';
		}



	//update profil /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc11 = mysql_query("SELECT * FROM user_blog ".
							"WHERE kd = '$dt_kd'");
	$rcc11 = mysql_fetch_assoc($qcc11);
	$tcc11 = mysql_num_rows($qcc11);

	if($tcc11 != 0)
		{
		$cc11_postdate = $rcc11['postdate'];

		echo '<p>['.$cc11_postdate.']. <br>
		[<font color="red"><strong>UPDATE PROFIL</strong></font>].
		</p>
		<br>';
		}



	//message ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc12 = mysql_query("SELECT * FROM user_blog_msg ".
							"WHERE kd = '$dt_kd'");
	$rcc12 = mysql_fetch_assoc($qcc12);
	$tcc12 = mysql_num_rows($qcc12);

	if($tcc12 != 0)
		{
		//kirim message
		$cc12_msg = balikin($rcc12['msg']);
		$cc12_dari = balikin($rcc12['kd_user']);
		$cc12_untuk = nosql($rcc12['untuk']);
		$cc12_kd = nosql($rcc12['kd']);
		$cc12_postdate = $rcc12['postdate'];

		//jika kirim
		if ($cc12_dari == $kd1_session)
			{
			//user-nya
			$qtuse = mysql_query("SELECT * FROM m_user ".
									"WHERE kd = '$cc12_untuk'");
			$rtuse = mysql_fetch_assoc($qtuse);
			$tuse_kd = nosql($rtuse['kd']);
			$tuse_no = nosql($rtuse['nomor']);
			$tuse_nm = balikin($rtuse['nama']);
			$tuse_tipe = nosql($rtuse['tipe']);

			echo '<p>['.$cc12_postdate.'].<br>
			[<font color="red"><strong>Kirim MESSAGE</strong></font>].
			<em>'.$cc12_msg.'</em>
			<br>
			[Untuk : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">'.$tuse_no.'. '.$tuse_nm.'</a></strong>].
			</p>
			<br>';
			}

		//jika terima
		else if ($cc12_untuk == $kd1_session)
			{
			//user-nya
			$qtuse = mysql_query("SELECT * FROM m_user ".
									"WHERE kd = '$cc12_dari'");
			$rtuse = mysql_fetch_assoc($qtuse);
			$tuse_kd = nosql($rtuse['kd']);
			$tuse_no = nosql($rtuse['nomor']);
			$tuse_nm = balikin($rtuse['nama']);
			$tuse_tipe = nosql($rtuse['tipe']);

			echo '<p>['.$cc12_postdate.'].<br>
			[<font color="red"><strong>Terima MESSAGE</strong></font>].
			<em>'.$cc12_msg.'</em>
			<br>
			[Dari : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">'.$tuse_no.'. '.$tuse_nm.'</a></strong>].
			[<em><a href="'.$sumber.'/janissari/k/msg/msg_post.php?s=tulis&userkd='.$tuse_kd.'" title="Reply ke : '.$tuse_no.'. '.$tuse_nm.'">REPLY</a></em>].
			</p>
			<br>';
			}
		}



	//update album //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc13 = mysql_query("SELECT * FROM user_blog_album ".
							"WHERE kd = '$dt_kd'");
	$rcc13 = mysql_fetch_assoc($qcc13);
	$tcc13 = mysql_num_rows($qcc13);

	if($tcc13 != 0)
		{
		$cc13_kd = nosql($rcc13['kd']);
		$cc13_judul = balikin($rcc13['judul']);
		$cc13_postdate = $rcc13['postdate'];

		echo '<p>['.$cc13_postdate.']. <br>
		[<font color="red"><strong>UPDATE ALBUM FOTO</strong></font>].
		[<a href="'.$sumber.'/janissari/k/album/album_detail.php?alkd='.$cc13_kd.'" title="'.$cc13_judul.'">'.$cc13_judul.'.</a>].
		</p>
		<br>';
		}


	//komentar foto /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qcc14 = mysql_query("SELECT user_blog_album.*, user_blog_album_filebox.*, ".
							"user_blog_album_filebox.kd AS fkd, user_blog_album_msg.*, ".
							"user_blog_album_msg.postdate AS fpd ".
							"FROM user_blog_album, user_blog_album_filebox, user_blog_album_msg ".
							"WHERE user_blog_album_filebox.kd_album = user_blog_album.kd ".
							"AND user_blog_album_msg.kd_user_blog_album = user_blog_album_filebox.kd ".
							"AND user_blog_album_msg.kd = '$dt_kd'");
	$rcc14 = mysql_fetch_assoc($qcc14);
	$tcc14 = mysql_num_rows($qcc14);

	if($tcc14 != 0)
		{
		$cc14_msg = balikin($rcc14['msg']);
		$cc14_dari = nosql($rcc14['dari']);
		$cc14_kd = nosql($rcc14['kd_album']);
		$cc14_fkd = nosql($rcc14['fkd']);
		$cc14_uskd = nosql($rcc14['kd_user']);
		$cc14_fpd = $rcc14['fpd'];

		//oleh...
		$qtuse = mysql_query("SELECT * FROM m_user ".
								"WHERE kd = '$cc14_dari'");
		$rtuse = mysql_fetch_assoc($qtuse);
		$tuse_kd = nosql($rtuse['kd']);
		$tuse_no = nosql($rtuse['nomor']);
		$tuse_nm = balikin($rtuse['nama']);
		$tuse_tipe = nosql($rtuse['tipe']);

		echo '<p>['.$cc14_fpd.']. <br>
		[<font color="red"><strong>Komentar FOTO</strong></font>]. ';

		//jika diri sendiri
		if ($cc14_uskd == $kd1_session)
			{
			echo '[<a href="'.$sumber.'/janissari/k/album/album_detail_view.php?s=view&alkd='.$cc14_kd.'&fkd='.$cc14_fkd.'#'.$cc14_fkd.'" title="'.$cc14_msg.'">'.$cc14_msg.'</a>].';
			}
		else
			{
			echo '[<a href="'.$sumber.'/janissari/p/album/album_detail_view.php?uskd='.$cc14_uskd.'&s=view&alkd='.$cc14_kd.'&fkd='.$cc14_fkd.'#'.$cc14_fkd.'" title="'.$cc10_msg.'">'.$cc14_msg.'</a>].		';
			}

		echo '<br>
		[Oleh : <strong><a href="'.$sumber.'/janissari/p/index.php?uskd='.$tuse_kd.'" title="('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'">('.$tuse_tipe.'). '.$tuse_no.'. '.$tuse_nm.'</a></strong>].
		</p>
		<br>';
		}

	echo '</td>
	</tr>';
	}
while ($data = mysql_fetch_assoc($result));


echo '</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="right">
<hr size="1">
<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
<hr size="1">
</td>
</tr>
</table>

<br>
<br>
<br>
</td>
<td width="1%">
</td>

<td width="1%">';

//ambil sisi
require("../../../inc/menu/k_sisi.php");

echo '<br>
<br>
<br>

</td>
</td>
</tr>
</table>';
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
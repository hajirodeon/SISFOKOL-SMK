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
require("../../../inc/class/paging.php");




//nilai
$kd1_session = nosql($_SESSION['kd1_session']);
$gmkd = nosql($_REQUEST['gmkd']);
$s = nosql($_REQUEST['s']);
$filenya = "chatroom_refresh2.php?gmkd=$gmkd";
$judulku = "Chat Refresh2";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika view
if ($s == "view")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT guru_mapel_chatroom.*, guru_mapel_chatroom.postdate AS cpd, ".
					"m_user.*, m_user.kd AS mukd ".
					"FROM guru_mapel_chatroom, m_user ".
					"WHERE guru_mapel_chatroom.kd_user = m_user.kd ".
					"AND guru_mapel_chatroom.kd_guru_mapel = '$gmkd' ".
					"ORDER BY guru_mapel_chatroom.postdate DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$limit = $chatdatalist; //maksimal
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	//nek ada
	if ($count != 0)
		{
		do
			{
			$feh_mukd = nosql($data['kd']);
			$feh_nomor = nosql($data['nomor']);
			$feh_nama = balikin($data['nama']);
			$feh_msg = balikin($data['msg']);
			$feh_postdate = $data['cpd'];

			//jika iya, diri sendiri
			if ($feh_mukd == $kd1_session)
				{
				$warna_chat = "blue";
				$d_oleh = "<em><strong>Diriku</strong></em>";
				}

			//jika teman...
			else
				{
				$warna_chat = "blue";
				$d_oleh = "<a href=\"$sumber/janissari/p/index.php?uskd=$feh_mukd\" target=\"_parent\" title=\"$feh_nomor.$feh_nama\"><strong>$feh_nomor.$feh_nama</strong></a>";
				}

			echo '[<em>'.$feh_postdate.'</em>]. [<font color="'.$warna_chat.'">'.$d_oleh.'</font>].
			'.$feh_msg.' <br><br>';
			}
		while ($data = mysql_fetch_assoc($result));
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//diskonek
xfree($result);
exit();
?>
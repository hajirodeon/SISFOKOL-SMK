<?php
sleep(1);

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");


//nilai
$limit = "15";
$return_arr = array();
$tapelkd = cegah($_GET['tapelkd']);
$term = cegah($_GET['term']);

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT m_siswa.* ".
				"FROM m_siswa, siswa_kelas ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND (m_siswa.nis LIKE '%$term%' ".
				"OR m_siswa.nama LIKE '%$term%')";
$sqlresult = $sqlcount;
$target = $filenya;
$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);



do
	{
	$row_array["p_kd"] = nosql($data["kd"]);
	$row_array["p_nis"] = nosql($data["nis"]);
	$row_array["p_nama"] = balikin($data["nama"]);

	$row_array["swkd"] = nosql($data["kd"]);
	$row_array["swnama"] = balikin($data["nama"]);

	$i_nama = balikin($data["nama"]);
	$i_nis = nosql($data["nis"]);


	$row_array["value"] = balikin($data["nis"]);
	$row_array["label"] = "$i_nis  [$i_nama]";
	$row_array["description"] = balikin($data["nama"]);

	array_push($return_arr, $row_array);
	}
while ($data = mysql_fetch_assoc($result));



header("Content-Type: text/json");
echo json_encode($return_arr);

//null-kan
xclose($koneksi);
exit();
?>
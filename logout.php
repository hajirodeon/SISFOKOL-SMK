<?php
session_start();


//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
$tpl = LoadTpl("template/iklan.html");



nocache;



//ambil
$nilai = "logout.php?s=index";
$s = nosql($_REQUEST['s']);


//isi *START
ob_start();
	

//jika null
if (empty($s))
	{
	?>
	<script type="text/javascript">
	$(document).ready(function() {
	
	setTimeout(function() {
	   window.location.href = "<?php echo $nilai;?>"
	  }, 5000);
	
	$('#loading').show();
	
	});
	</script>
	
	
	<style>
	  #foo_header {
	    position: fixed;
	    top: 0;
	  }
	
	</style>
	
	
	<div id="foo_header">
	<div id="loading" style="display:none">
	<img src="img/progress-bar.gif" height="20">
	<br>
	Sebentar lagi lanjut...
	</div>
	
	</div>
	
	
	<table width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top" align="center">
	<td bgcolor="red">
	Iklan OmahBIASAWAE
	</td>
	</tr>
	<tr valign="top" align="center">
	<td>
	<iframe frameborder="0" width="1000" src="http://omahbiasawae.com/iklan/iklan_banner.php" scrolling="yes" name="frku" height="300"></iframe>
	</td>
	</tr>
	
	<tr valign="top" align="center">
	<td bgcolor="red">
	Iklan OmahBIASAWAE
	</td>
	</tr>
	
	</table>
	
	<?php
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}


else
	{
	//hapus session
	session_unset();
	session_destroy();
	
	
	//re-direct
	xloc($sumber);
	exit();
	}
	
	
	
//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");

exit();
?>
<?php 
require_once("dompdf_config.inc.php");
	if ( get_magic_quotes_gpc() )
	$str = stripslashes($str);
	$name=$title." Certificate ".date('m-Y').".pdf";
	$arrachment_flag=false;
	if($download_flag)
	$arrachment_flag=$download_flag;
	$dompdf = new DOMPDF();
	$dompdf->load_html($str);
	$dompdf->set_paper('a3','portrait');
	$dompdf->render();
	$dompdf->stream($name, array("Attachment" => $arrachment_flag));  
	exit();

?>



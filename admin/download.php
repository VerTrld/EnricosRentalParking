<?php 
if(isset($_GET['download']))
$file_name = $_GET['download'];
$file_url = 'userQr/'  . $file_name;
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$file_name."\""); 
readfile($file_url);
exit;
?>
<?php
session_start();
echo"<script type='text/javascript'>location.href = '/';</script>";
$file = $_SESSION['download'];
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Content-Length: ' . filesize($file));
header('Pragma: public');

?>

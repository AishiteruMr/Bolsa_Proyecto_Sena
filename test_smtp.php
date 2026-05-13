<?php
$smtp = fsockopen('smtp.gmail.com', 587, $errno, $errstr, 10);
if (!$smtp) { echo 'FALLO conexion: ' . $errstr; exit; }
echo "Conectado OK\n";
echo fread($smtp, 512);
fwrite($smtp, "EHLO test\r\n");
echo fread($smtp, 512);
fwrite($smtp, "STARTTLS\r\n");
echo fread($smtp, 512);
fclose($smtp);
echo "\nPUERTO 587 ACCESIBLE\n";

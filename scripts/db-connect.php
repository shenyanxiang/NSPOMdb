<?php
header('Content-type:text/html;charset=utf8');

$cfg = parse_ini_file("/var/www/cgi-bin/OBMicro/config.ini");

$host = 'localhost';
$db = 'OBMicro';
$user = $cfg["username"];
$pass = $cfg["password"];

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass")or die('Could not connect: ' . pg_last_error());
?>
<?php
header('Content-type: application/json; charset=utf8');

$cfg = parse_ini_file("/var/www/cgi-bin/OBMicro/config.ini");

$host = 'localhost';
$db = 'OBMicro';
$user = $cfg["username"];
$pass = $cfg["password"];

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());

$reference_query = "SELECT * FROM public.reference";
$reference_result = pg_query($conn, $reference_query);

$data = [];
while ($row = pg_fetch_assoc($reference_result)) {
    $data[] = $row;
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);
pg_free_result($reference_result);
pg_close($conn);
?>
<?php
header('Content-type: application/json; charset=utf8');

$cfg = parse_ini_file("/var/www/cgi-bin/OBMicro/config.ini");

$host = 'localhost';
$db = 'OBMicro';
$user = $cfg["username"];
$pass = $cfg["password"];

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());

$recall_query = "SELECT * FROM public.recall_event";
$recall_result = pg_query($conn, $recall_query);

$nonEmptyRows = [];
$emptyRows = [];

while ($row = pg_fetch_assoc($recall_result)) {
    if (
        !empty($row['product_description']) &&
        !empty($row['dosage_form']) &&
        !empty($row['micro']) &&
        !empty($row['link']) &&
        !empty($row['country']) &&
        !empty($row['product_category']) &&
        !empty($row['date']) &&
        !empty($row['classification']) &&
        !empty($row['recall_reason'])
    ) {
        $nonEmptyRows[] = $row; // 保存所有列均非空的行
    } else {
        $emptyRows[] = $row; // 保存包含空值的行
    }
}

// 合并，先展示非缺省行，再展示有缺省值的行
$data = array_merge($nonEmptyRows, $emptyRows);

echo json_encode($data, JSON_UNESCAPED_UNICODE);

pg_free_result($recall_result);
pg_close($conn);
?>
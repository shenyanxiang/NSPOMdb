<?php
header('Content-type: application/json; charset=utf8');

// 读取数据库配置
$cfg = parse_ini_file("/var/www/cgi-bin/OBMicro/config.ini");

$host = 'localhost';
$db = 'OBMicro';
$user = $cfg["username"];
$pass = $cfg["password"];

// 数据库连接
$conn = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());

// 获取前端传递的参数
$micro_name = isset($_GET['micro_name']) ? $_GET['micro_name'] : '';

if (empty($micro_name)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or invalid micro_name parameter.']);
    exit;
}

// 查询数据库
$query = "SELECT * FROM public.\"ARG_info_fungi\" WHERE micro_query = $1 OR micro_name = $2";
$result = pg_query_params($conn, $query, [$micro_name, $micro_name]);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Database query failed: ' . pg_last_error()]);
    pg_close($conn);
    exit;
}

// 处理查询结果
$data = [];
while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

// 关闭数据库连接
pg_free_result($result);
pg_close($conn);

// 返回 JSON 数据
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
<?php
header('Content-type: application/json; charset=utf8');

$cfg = parse_ini_file("/var/www/cgi-bin/OBMicro/config.ini");

$host = 'localhost';
$db = 'OBMicro';
$user = $cfg["username"];
$pass = $cfg["password"];

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());

// 1. 获取召回事件统计（每种剂型的欧盟/FDA数量）
$recall_stats = [];
$recall_query = "
    SELECT
        dosage_form,
        SUM(CASE WHEN source = 'European Commission' THEN 1 ELSE 0 END) AS european_commission_count,
        SUM(CASE WHEN source = 'FDA' THEN 1 ELSE 0 END) AS fda_count,
        SUM(CASE WHEN source = 'MHRA' THEN 1 ELSE 0 END) AS mhra_count,
        SUM(CASE WHEN source = 'TGA' THEN 1 ELSE 0 END) AS tga_count
    FROM
        public.recall_event
    GROUP BY dosage_form
";
$recall_result = pg_query($conn, $recall_query);
while ($stat = pg_fetch_assoc($recall_result)) {
    $recall_stats[$stat['dosage_form']] = [
        'european_commission_count' => intval($stat['european_commission_count']),
        'fda_count' => intval($stat['fda_count']),
        'mhra_count' => intval($stat['mhra_count']),
        'tga_count' => intval($stat['tga_count'])
    ];
}

// 2. 查询剂型列表
$dosage_query = "SELECT * FROM public.dosage_list";
$dosage_result = pg_query($conn, $dosage_query);

$data = [];
while ($row = pg_fetch_assoc($dosage_result)) {
    $dosage_form = $row['dosage_form'];
    // 合并 recall 统计数据
    $row['european_commission_count'] = isset($recall_stats[$dosage_form]) ? $recall_stats[$dosage_form]['european_commission_count'] : 0;
    $row['fda_count'] = isset($recall_stats[$dosage_form]) ? $recall_stats[$dosage_form]['fda_count'] : 0;
    $row['mhra_count'] = isset($recall_stats[$dosage_form]) ? $recall_stats[$dosage_form]['mhra_count'] : 0;
    $row['tga_count'] = isset($recall_stats[$dosage_form]) ? $recall_stats[$dosage_form]['tga_count'] : 0;
    $data[] = $row;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

pg_free_result($dosage_result);
pg_close($conn);
?>
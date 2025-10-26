<?php
header('Content-Type: application/json');

// 开始会话以支持 $_SESSION 使用
session_start();

// 获取 runID 参数
if (!isset($_GET['runID'])) {
    http_response_code(400); // 返回 HTTP 400 错误（Bad Request）
    echo json_encode(['error' => 'runID parameter is required']);
    exit;
}

$runID = $_GET['runID'];

// 定义 JSON 文件路径
$baseDir = '/var/www/cgi-bin/OBMicro/ARG-VFG-finder/jobs'; // 修改为实际 JSON 文件目录
$jsonFilePath = $baseDir . '/' . $runID . '/Antibiotic_Resistance_Gene.json';

// 检查 JSON 文件是否存在
if (!file_exists($jsonFilePath)) {
    http_response_code(404); // 返回 HTTP 404 错误（Not Found）
    echo json_encode(['error' => 'JSON file not found for the specified runID']);
    exit;
}

// 读取 JSON 文件内容
try {
    $jsonData = file_get_contents($jsonFilePath);
    if ($jsonData === false) {
        throw new Exception('Failed to read JSON file');
    }

    // 将 JSON 数据解析为 PHP 数组
    $data = json_decode($jsonData, true);
    if ($data === null) {
        throw new Exception('Failed to decode JSON file');
    }

    // 返回 JSON 数据
    echo json_encode($data);
} catch (Exception $e) {
    http_response_code(500); // 返回 HTTP 500 错误（Internal Server Error）
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
?>
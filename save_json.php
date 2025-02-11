<?php
// 保存前端提交的 JSON 到固定配置文件 "json_files/config.json"，同时备份旧版本到 history/ 目录
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);
$jsonData = isset($input['json']) ? $input['json'] : '';
if (!$jsonData) {
    echo json_encode(["success" => false, "error" => "未收到有效的 JSON 数据"]);
    exit;
}

// 验证 JSON 格式
if (json_decode($jsonData) === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "error" => "提交的数据不是有效的 JSON 格式"]);
    exit;
}

// 确保配置目录存在
$configDir = 'json_files/';
if (!is_dir($configDir)) {
    mkdir($configDir, 0777, true);
}

$configFile = $configDir . 'config.json';
$historyDir = 'history/';
if (!is_dir($historyDir)) {
    mkdir($historyDir, 0777, true);
}

// 如果配置文件存在，则备份旧版本到 history 目录
if (file_exists($configFile)) {
    $timestamp = date("YmdHis");
    $backupFile = $historyDir . "config_" . $timestamp . ".json";
    copy($configFile, $backupFile);
}

// 保存新配置
$result = file_put_contents($configFile, $jsonData);
if ($result === false) {
    echo json_encode(["success" => false, "error" => "写入配置文件失败"]);
} else {
    echo json_encode(["success" => true]);
}
?>

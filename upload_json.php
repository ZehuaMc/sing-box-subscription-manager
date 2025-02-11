<?php
// 处理上传的 JSON 文件，并保存到固定配置文件 "json_files/config.json"，同时备份旧版本到 history/ 目录
header('Content-Type: application/json');

$configDir = 'json_files/';
if (!is_dir($configDir)) {
    mkdir($configDir, 0777, true);
}
$configFile = $configDir . 'config.json';
$historyDir = 'history/';
if (!is_dir($historyDir)) {
    mkdir($historyDir, 0777, true);
}

if (!isset($_FILES['jsonFile'])) {
    echo json_encode(["success" => false, "error" => "未上传文件"]);
    exit;
}

$file = $_FILES['jsonFile'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "error" => "文件上传出错"]);
    exit;
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext !== 'json') {
    echo json_encode(["success" => false, "error" => "只允许上传 JSON 文件"]);
    exit;
}

$content = file_get_contents($file['tmp_name']);
if (json_decode($content) === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "error" => "上传的文件不是有效的 JSON 格式"]);
    exit;
}

// 备份旧配置（如果存在）
if (file_exists($configFile)) {
    $timestamp = date("YmdHis");
    $backupFile = $historyDir . "config_" . $timestamp . ".json";
    copy($configFile, $backupFile);
}

$result = file_put_contents($configFile, $content);
if ($result === false) {
    echo json_encode(["success" => false, "error" => "写入配置文件失败"]);
} else {
    echo json_encode(["success" => true]);
}
?>

<?php
// raw.php 返回固定配置文件 "json_files/config.json" 的原始内容，要求通过 GET 参数 pwd 提供正确密码
$config = include 'config.php';
$requiredRawPassword = $config['rawAccessPassword'];

if (!isset($_GET['pwd']) || $_GET['pwd'] !== $requiredRawPassword) {
    header('HTTP/1.1 403 Forbidden');
    echo "Access Denied: Invalid raw access password.";
    exit;
}

if (!isset($_GET['file']) || empty($_GET['file'])) {
    header('HTTP/1.1 400 Bad Request');
    echo "Bad Request: File parameter is missing.";
    exit;
}

$fileName = basename($_GET['file']);
$configFile = 'json_files/' . $fileName;
if (!file_exists($configFile)) {
    header('HTTP/1.1 404 Not Found');
    echo "File not found.";
    exit;
}

$jsonText = file_get_contents($configFile);
$data = json_decode($jsonText, true);
if ($data === null) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Invalid JSON content in file.";
    exit;
}

// 如果提供了 ep 参数，则用 endpoints.json 中对应的 endpoints 替换配置中的 endpoints 字段
if (isset($_GET['ep']) && !empty($_GET['ep'])) {
    $epKey = $_GET['ep'];
    $endpointsFile = 'endpoints.json';
    if (file_exists($endpointsFile)) {
        $epContent = file_get_contents($endpointsFile);
        $epData = json_decode($epContent, true);
        if ($epData !== null && isset($epData[$epKey])) {
            $data['endpoints'] = $epData[$epKey];
        }
    }
}

header('Content-Type: application/json');
// 增加 JSON_UNESCAPED_SLASHES 标志，防止斜杠被转义
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

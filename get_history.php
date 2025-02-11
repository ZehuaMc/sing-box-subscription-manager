<?php
// 列出 history/ 目录下的历史版本文件（文件名格式：config_YYYYMMDDHHMMSS.json）
header('Content-Type: application/json');
$historyDir = 'history/';
$response = ["success" => false];
if (!is_dir($historyDir)) {
    $response['error'] = "历史目录不存在";
    echo json_encode($response);
    exit;
}
$files = scandir($historyDir);
$history = [];
foreach ($files as $file) {
    if (preg_match('/^config_\d{14}\.json$/', $file)) {
        $history[] = $file;
    }
}
$response['success'] = true;
$response['history'] = $history;
echo json_encode($response);
?>

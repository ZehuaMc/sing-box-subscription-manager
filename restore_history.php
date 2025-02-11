<?php
// 根据提交的历史版本文件名恢复配置，将指定历史文件复制到 json_files/config.json
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['file'])) {
    echo json_encode(["success" => false, "error" => "缺少文件参数"]);
    exit;
}
$fileName = basename($input['file']);
$historyFile = 'history/' . $fileName;
$configFile = 'json_files/config.json';
if (!file_exists($historyFile)) {
    echo json_encode(["success" => false, "error" => "指定的历史文件不存在"]);
    exit;
}
if (!is_dir('json_files')) {
    mkdir('json_files', 0777, true);
}
$result = copy($historyFile, $configFile);
if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "恢复配置失败"]);
}
?>

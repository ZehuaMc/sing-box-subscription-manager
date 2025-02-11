<?php
// 删除指定的历史版本文件（history 目录下）
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['file'])) {
    echo json_encode(["success" => false, "error" => "缺少文件参数"]);
    exit;
}
$fileName = basename($input['file']);
$historyFile = 'history/' . $fileName;
if (!file_exists($historyFile)) {
    echo json_encode(["success" => false, "error" => "指定的历史文件不存在"]);
    exit;
}
$result = unlink($historyFile);
if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "删除历史文件失败"]);
}
?>

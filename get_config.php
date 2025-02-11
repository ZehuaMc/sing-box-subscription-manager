<?php
// 返回固定配置文件 "json_files/config.json" 的内容
header('Content-Type: application/json');
$configFile = 'json_files/config.json';
if (file_exists($configFile)) {
    $json = file_get_contents($configFile);
    $data = json_decode($json, true);
    if ($data === null) {
        echo json_encode(["error" => "配置文件内容无效"]);
    } else {
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
} else {
    // 如果配置不存在，则返回空 JSON 对象
    echo json_encode(new stdClass());
}
?>

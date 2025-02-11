<?php
// endpoints_manager.php 用于管理 endpoints.json 中的配置：列出、添加、更新、删除操作
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$action = isset($data['action']) ? $data['action'] : '';

$endpointsFile = 'endpoints.json';
if (!file_exists($endpointsFile)) {
    // 如果文件不存在，则创建一个空对象
    file_put_contents($endpointsFile, json_encode(new stdClass(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$endpoints = json_decode(file_get_contents($endpointsFile), true);
if ($endpoints === null) {
    $endpoints = [];
}

$response = ["success" => false];

if ($action === 'list') {
    $response['success'] = true;
    $response['endpoints'] = $endpoints;
} elseif ($action === 'add') {
    // 添加新的 endpoints 配置，要求传入 key 和 data
    if (!isset($data['key']) || !isset($data['data'])) {
        $response['error'] = "缺少参数";
    } else {
        $key = $data['key'];
        if (isset($endpoints[$key])) {
            $response['error'] = "该 key 已存在，请使用 update 操作";
        } else {
            $endpoints[$key] = $data['data'];
            file_put_contents($endpointsFile, json_encode($endpoints, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $response['success'] = true;
        }
    }
} elseif ($action === 'update') {
    // 更新已存在的 endpoints 配置，要求传入 key 和 data
    if (!isset($data['key']) || !isset($data['data'])) {
        $response['error'] = "缺少参数";
    } else {
        $key = $data['key'];
        $endpoints[$key] = $data['data'];
        file_put_contents($endpointsFile, json_encode($endpoints, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $response['success'] = true;
    }
} elseif ($action === 'delete') {
    // 删除 endpoints 配置，要求传入 key
    if (!isset($data['key'])) {
        $response['error'] = "缺少 key 参数";
    } else {
        $key = $data['key'];
        if (isset($endpoints[$key])) {
            unset($endpoints[$key]);
            file_put_contents($endpointsFile, json_encode($endpoints, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $response['success'] = true;
        } else {
            $response['error'] = "指定的 key 不存在";
        }
    }
} else {
    $response['error'] = "未知的操作";
}
echo json_encode($response);
?>

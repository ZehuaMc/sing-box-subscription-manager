<?php
/**
 * config.php
 * 统一保存项目全局配置参数，其他文件通过 include 引入该文件以获取密码等配置。
 */
return [
    // 登录密码的 bcrypt 哈希（明文密码为 "123456"）
    'loginPasswordHash' => '$2a$10$ru9RYjj.QBXjehdB9HVJ7OUo1JySJIG0pxTmy98A3Mc3Z1aC4yt7q',
    // Raw 访问密码（明文）
    'rawAccessPassword' => '123456'
];
?>

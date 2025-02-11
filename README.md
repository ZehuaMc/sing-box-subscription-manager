# sing-box-subscription-manager

**SingBox 订阅链接与 Endpoint(WireGuard) 管理**

上传和管理 Sing-Box 配置文件，管理不同的 WireGuard 节点（Endpoints）。

<img src="https://image.200502.xyz/i/2025/02/12/3h2b3o-0.webp" alt="屏幕截图_12-2-2025_2951_sing-box.200502.xyz" style="zoom: 33%;" />

# Feature

- **配置文件上传与编辑**
   可以上传 Sing-Box 的配置文件，并通过内置的代码编辑器（基于 CodeMirror）进行实时编辑。
- **订阅链接生成**
   支持生成订阅链接的功能，可在生成订阅链接时选择不同的 Endpoints，从而切换 WireGuard 节点配置，满足多设备组网需求。
- **Endpoint 管理**
   可以添加、修改或删除 Endpoint配置。
- **历史版本管理**
   每次配置保存时，系统会自动备份旧版本，方便查看历史版本。

# Warn
务必修改`config.php`内的密码，可以使用[在线Bcrypt加密工具](https://qr9.net/bcrypt)生成


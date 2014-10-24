# AcFun 自动签到程序
从 `泷涯的 AcFun 签到程序` 看到了，但是感觉应该有个好看的 UI。

于是，做出来了~

## 配置数据库
SAE 的话直接上传上去、配置好 config.yaml 即可。

如果是自己的服务器，将 `db-config-sample.php` 做个拷贝到 `db-config.php` 然后照着填写。

然后，导入 `install.sql` 到数据库即可。

## 配置后台
Corn 添加 `sign.php` 到每日执行即可。

如果需要浏览器访问地址签到，请在 `config.php` 将 `C_CLI_SIGN` 改为 `0`。
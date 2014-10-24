<?php // 如果你是 SAE 的话不需要填写此处

define ('C_MYSQL_DB', 	'ac_sign'); // 名称

// 如果你需要使用 php.ini 默认
define ('C_MYSQL_HOST', ini_get ('mysql.default_host')); // 服务器
define ('C_MYSQL_PORT', ini_get ('mysql.default_port')); // 端口

// 如果你想手动指定
// define ('C_MYSQL_HOST', ''); // 服务器
// define ('C_MYSQL_PORT', ''); // 端口

define ('C_MYSQL_USER', 'root'); // 用户名
define ('C_MYSQL_PASS', ''); // 密码
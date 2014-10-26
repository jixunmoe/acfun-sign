<?php // 初始化

include 'config.php';

if (defined('SAE_MYSQL_HOST_M')) {
	// SAE 环境
	define ('C_MYSQL_HOST', SAE_MYSQL_HOST_M);
	define ('C_MYSQL_PORT', SAE_MYSQL_PORT);
	define ('C_MYSQL_DB', 	SAE_MYSQL_DB);
	define ('C_MYSQL_USER', SAE_MYSQL_USER);
	define ('C_MYSQL_PASS', SAE_MYSQL_PASS);
} else {
	// 其它环境
	include 'db-config.php';
}

// 数据库
try {
	$db = new PDO (
		sprintf ('mysql:host=%s;port=%s;dbname=%s;charset=utf8', 
			C_MYSQL_HOST, C_MYSQL_PORT, C_MYSQL_DB
		),  C_MYSQL_USER, C_MYSQL_PASS
	);
} catch (Exception $e) {
	echo '<h1>数据库连接失败!</h1>';
	exit ;
}
// 时区改成天朝
date_default_timezone_set ('Asia/Shanghai');
$db -> query ('SET time_zone = "+08:00";');

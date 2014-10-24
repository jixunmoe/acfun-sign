<?php

include 'init.php';


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


if (C_CLI_SIGN && php_sapi_name() !== 'cli') {
	include 'tpl/error.php';
	exit ;
}

include 'functions.php';

define ('today', date('Y-m-d'));
$db_getNotSigned = $db -> prepare ('SELECT * FROM `ac_sign` WHERE `lastSign`<>:today AND `disabled`=0');

$db_getNotSigned -> execute (array (
	':today' => today
));

if (!C_CLI_SIGN) header ('Content-Type: Text/Plain');

$db_updLastSign = $db -> prepare ('SELECT `ac_sign` SET `lastSign`=:today WHERE `id`=:id');
$db_disableBad  = $db -> prepare ('SELECT `ac_sign` SET `disabled`=0 WHERE `id`=:id');

print ("开始签到 .. \n");

while ($row = $db_getNotSigned -> fetch (PDO::FETCH_ASSOC)) {
	printf ("为 %s[%d] 签到: \t", $row['user'], $row['id']);

	// $r = do_sign_acfun ($row);
	$r = 'nyll';
	$signStatus = json_decode (trim($r), false);

	if (!$signStatus) {
		print '无效的请求 [服务器拒绝]';
		print $r;
		continue;
	}

	printf ("%s(%d)\t", $signStatus -> result, isset($signStatus -> status) ? $signStatus -> status : 0);

	if ($signStatus -> success) {
		print '(成功)';

		$db_updLastSign -> execute (array (
			':today' => today,
			':id' => $row['id']
		));
	} else if ( isset($signStatus -> status) && $signStatus -> status === 401 ) {
		print '(Cookie 失效)';
		$db_disableBad  -> execute (array (
			':today' => today,
			':id' => $row['id']
		));
	} else {
		print '(未知错误)';
	}

	print "\n";
}
print ("签到完毕!");

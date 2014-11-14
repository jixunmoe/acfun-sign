<?php

include 'init.php';

if (DEBUG) {
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);	
}

if (C_CLI_SIGN && php_sapi_name() !== 'cli') {
	include 'tpl/error.php';
	exit ;
}

include 'functions.php';

$db_getNotSigned = $db -> prepare ('SELECT * FROM `ac_sign` WHERE `lastSign` <> DATE(NOW()) AND `disabled`=0');
$db_getNotSigned -> execute ();

if (!C_CLI_SIGN) header ('Content-Type: Text/Plain');

$db_updLastSign = $db -> prepare ('UPDATE `ac_sign` SET `lastSign`=DATE(NOW()) WHERE `id`=:id');
$db_disableBad  = $db -> prepare ('UPDATE `ac_sign` SET `disabled`=0 WHERE `id`=:id');

print ("开始签到 .. \n");

while ($row = $db_getNotSigned -> fetch (PDO::FETCH_ASSOC)) {
	printf ("为 %s[%d] 签到: \t", $row['user'], $row['id']);

	$r = do_sign_acfun ($row);
	$signStatus = json_decode (trim($r), false);

	if (!$signStatus) {
		print "无效的请求 [服务器拒绝]\n";
		continue;
	}

	printf ("%s(%d)\t",
		isset($signStatus -> result) ? $signStatus -> result : '',
		isset($signStatus -> status) ? $signStatus -> status : 0);

	if ($signStatus -> success) {
		print '(成功)';

		$db_updLastSign -> execute (array (
			':id' => $row['id']
		));
	} else if ( isset($signStatus -> status) && $signStatus -> status === 401 ) {
		print '(Cookie 失效)';
		$db_disableBad  -> execute (array (
			':id' => $row['id']
		));
		// 不捡肥皂
		continue;
	} else {
		print '(未知错误)';
	}

	print "\t捡肥皂 ... ";
	$drift = json_decode (do_drift_acfun($row), false);
	if ($drift->success) {
		print '成功!';
	} else {
		printf('%s (%d)', $drift->result, $drift->status);
	}
	
	print "\t在线时间 ... ";
	$user_online = json_decode(do_online_acfun ($row));
	print $user_online->success ? '成功! level: ' . $user_online->level : '失败 :<';

	print "\n";
}
print "签到完毕!\n";

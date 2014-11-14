<?php

function do_acfun_action ($url, $row) {
	$c = curl_init ('http://www.acfun.tv' . $url);
	curl_setopt ($c, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt ($c, CURLOPT_HEADER, FALSE);
	curl_setopt ($c, CURLOPT_COOKIE, build_cookie($row));
	return (object)array (
		'c' => $c,
		'header' => array (
			'User-Agent: Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36',
			'Referer: http://www.acfun.tv/member/',
			'X-Requested-With: XMLHttpRequest'
		)
	);
}

// 签到 +3 香蕉
function do_sign_acfun ($row) {
	$q = do_acfun_action('/member/checkin.aspx', $row);
	$q -> header[] = 'Content-Length: 0';
	curl_setopt ($q -> c, CURLOPT_POST, TRUE);
	curl_setopt($q -> c, CURLOPT_HTTPHEADER, $q -> header);
	$ret = curl_exec ($q -> c);
	curl_close ($q -> c);
	return $ret;
}

// 捡肥皂 +2 香蕉
function do_drift_acfun ($row) {
	$q = do_acfun_action('/api/mail.aspx?name=getDrift', $row);
	curl_setopt($q -> c, CURLOPT_HTTPHEADER, $q -> header);
	$ret = curl_exec ($q -> c);
	curl_close ($q -> c);
	return $ret;
}

function do_online_acfun ($row) {
	$q = do_acfun_action('/online.aspx', $row);
	curl_setopt($q -> c, CURLOPT_HTTPHEADER, $q -> header);
	$ret = curl_exec ($q -> c);
	curl_close ($q -> c);
	return $ret;
}

function build_cookie ($row) {
	return sprintf( 'auth_key=%s; auth_key_ac_sha1=%s', $row['auth_key'], $row['auth_sha1'] );
}

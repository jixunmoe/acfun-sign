<?php

function do_sign_acfun ($row) {
	$c = curl_init ('http://www.acfun.tv/member/checkin.aspx');
	// $c = curl_init ('http://localhost/fun/checkin.php');
	curl_setopt ($c, CURLOPT_HTTPHEADER, array (
		'User-Agent: Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36',
		'Referer: http://www.acfun.tv/member/',
		'X-Requested-With: XMLHttpRequest',
		
		// 如果没有会报错
		'Content-Length: 0'
	));
	curl_setopt ($c, CURLOPT_POST, TRUE);
	curl_setopt ($c, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt ($c, CURLOPT_HEADER, FALSE);
	curl_setopt ($c, CURLOPT_COOKIE, build_cookie($row));
	$ret = curl_exec ($c);
	curl_close ($c);
	return $ret ;
}

function build_cookie ($row) {
	return sprintf( 'auth_key=%s; auth_key_ac_sha1=%s', $row['auth_key'], $row['auth_sha1'] );
}

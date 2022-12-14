<?php
// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('./inc/config.inc.php');

unset($username);
if (isset($_COOKIE['login'])) {
	list($c_username, $cookie_hash, $id) = explode(',', $_COOKIE['login']);
	if (md5($c_username.CONF["secret"]) === $cookie_hash) {
		$username = $c_username;
	} else {
		print "You have sent a bad cookie.";
	}
}
if (isset($username)) {
	echo 'Logged in as <b>'.$username.'</b>, <a href="/logout.php">click here</a> to log out<hr>';
} else {
	die('Not logged in, <a href="/login.html">click here</a> to log in<hr>');
}

<?php
require_once('./inc/verifylogin.inc.php');
echo '<a href="./enterbooking.php">Back</a><hr>';
// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('inc/functions.inc.php');

delete_booking($_GET['ref']);

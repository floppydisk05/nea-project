<a href="/">Back</a>
<hr>
<?php
// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$secret = "cupcakes";
require_once('./inc/config.inc.php');
require_once('./inc/functions.inc.php');
if (validate_login($_POST['uname'], $_POST['pword'])) {
    $id = get_user_id($_POST['uname']);
    setcookie('login', $_POST['uname'].','.md5($_POST['uname'].$secret).','.$id);
} else {
    echo 'wrong login';
}

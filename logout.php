<?php
setcookie('login', '', time()-3600);
?>
<p>You have been successfully logged out! Redirecting you to the login in 2 seconds...</p>
<meta http-equiv="Refresh" content="2; url='/login.php'" />

<?php
require_once ("includes/sec_session.php");
sec_session_start();

// Unset all session values 
$_SESSION = array();
 
// get session parameters 
$params = session_get_cookie_params();
 
// Delete the actual cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// Destroy session 
session_destroy();

?>
<html>
<body>
	<div>Your SSO session has been destroyed. You have NOT been logged out of Wild Apricot.	</div>
	<div><a href="sample-sso.php">Start a new session</a></div>
</body>
</html>


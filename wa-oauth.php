<?
require_once ("includes/sec_session.php");
sec_session_start();

if (isset($_GET['code'])) {

	if (isset($_GET['state']) && $_GET['state'] != '') {	
	
		// get authorization code
		$authorization_code = $_GET['code'];

		// get destination and decode for redirect
		$state = urldecode($_GET['state']);

		// attempt single sign-on connection
		require_once ("includes/wild_apricot_sso.php");	

		// verify sign-on and redirect to destination
		if ($_SESSION['WA_Login_Verified']) {
			header("location: $state");
		} else {			
			// handle failure
			session_destroy();
			die("API request failed.");
		}

	} else {		
		// handle failure
		session_destroy();
		die("No destination specified.");
	}
	
} else {	
	// handle failure
	session_destroy();
	die("Authorization code not found.");
}

<?
include_once ("includes/sec_session.php");
sec_session_start();

// get authorization code
if (isset($_GET['code'])) {
	$authorization_code = $_GET['code'];
} else {
	session_destroy();
	die("Authorization code not found.");
}

// get destination
if (isset($_GET['state']) && $_GET['state'] != '') {
	$state = $_GET['state'];
} else {
	session_destroy();
	die("No destination specified.");
}

// attempt single sign-on connection
require ("includes/wild_apricot_sso.php");

// decode destination
$state = urldecode($state);

// verify sign-on and redirect to destination
if ($_SESSION['WA_Login_Verified']) {
	header("location: $state");
} else {
	session_destroy();
	die("API request failed.");
}

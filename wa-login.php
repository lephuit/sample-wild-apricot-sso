<?
include_once ("includes/constants.php");

$account_id 		= ACCOUNT_ID;
$client_id 		= CLIENT_ID;
$processing_path 	= "https://".PROCESSING_PATH;
$auth_domain 		= "https://".WILD_APRICOT_DOMAIN;
$redirect_uri 		= "{$processing_path}/wa-oauth.php";
$accountUrl 		= "{$auth_domain}/sys/login/OAuthLogin";
$state 			= urlencode($_SERVER['QUERY_STRING']); // encode for successful pass-through

$queryParams = array(
	'client_id' => $client_id, 
	'redirect_uri' => $redirect_uri, 
	'scope' => 'contacts_me',
	'response_type' => 'authorization_code',
	'claimed_account_id' => $account_id,
	'state' => $state
);

$url = $accountUrl . '?' . http_build_query($queryParams);

header("location: $url");

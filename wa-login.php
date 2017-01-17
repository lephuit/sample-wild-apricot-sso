<?

// ** SET VARIABLES ------------------------
$account_id = '{YOUR_ACCOUNT_ID}';
$client_id = '{YOUR_CLIENT_ID}';
$processing_domain = "https://{YOUR_PROCESSING_DOMAIN}";
$auth_domain = "https://{YOUR_WILD_APRICOT_DOMAIN}";

// ** BUILD URLS ------------------------
$redirect_uri = "{$processing_domain}/sso/wa-oauth.php";
$accountUrl = "{$auth_domain}/sys/login/OAuthLogin";

// ** END SET VARIABLES --------------------

$state = $_SERVER['QUERY_STRING'];

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
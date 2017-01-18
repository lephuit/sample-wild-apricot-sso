<?php
include_once ("includes/wa_helper_class_sso.php");
include_once ("includes/constants.php");

$waApiClient = WaApiClient::getInstance();

// set API application credentials here
$client_id = CLIENT_ID;
$client_secret = CLIENT_SECRET;
$processing_path = "https://".PROCESSING_PATH;

// build redirect url
$redirect_uri = "{$processing_path}/wa-oauth.php";

// request access token
try {
	$waApiClient->initTokenByAuthCode($authorization_code);

	// assign parent account id to url
	$account_id = $waApiClient->getAccountId();
	$accountUrl = 'https://api.wildapricot.org/v2/Accounts/'.$account_id.'/';
			
	// get contact data
	if( $contact = getContactsList() ) {
		$_SESSION['first_name'] = $contact['FirstName'];
		$_SESSION['last_name'] = $contact['LastName'];
		$_SESSION['email'] = $contact['Email'];
		$_SESSION['display_name'] = $contact['DisplayName'];
		$_SESSION['organization_name'] = $contact['Organization'];
		$_SESSION['membership_level'] = $contact['MembershipLevel']['Name'];
		$_SESSION['membership_status'] = $contact['Status'];
		$_SESSION['member_id'] = $contact['Id'];
		$_SESSION['is_admin'] = $contact['IsAccountAdministrator'];
		$_SESSION['tos_accepted'] = $contact['TermsOfUseAccepted'];
		$_SESSION['WA_Login_Verified'] = true;
		$_SESSION['timestamp'] = new DateTime();
	}
	
} catch (Exception $e) {
	error_log($e->getMessage());
}

function getContactsList()
{
   global $waApiClient;
   global $accountUrl;
   $queryParams = array(
	  '$async' => 'false'
   ); 
   $url = $accountUrl . '/Contacts/Me';
   return $waApiClient->makeRequest($url);
}
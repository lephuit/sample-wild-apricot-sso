<?
function check_WA_login($url,$request,$query_string) {
	
	if (!$_SESSION['WA_Login_Verified']) {
		
		// initiate sign-on
		if ($query_string != '') {
			$request .= "?".$query_string;
		}
		$url .= "?".$request;
		header("location: $url");
		
	} else {
		
		// user is logged in
		return true;
	}
}
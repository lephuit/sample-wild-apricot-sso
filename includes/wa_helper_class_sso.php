<?

/**
 * API helper class. You can copy whole class in your PHP application.
 */
class WaApiClient
{
   const AUTH_URL = 'https://oauth.wildapricot.org/auth/token';
   
   private $tokenScope = 'contacts_me';	   

   private static $_instance;
   private $token;
   private $token_data;
   
   public function initTokenByAuthCode($authorization_code, $scope = null)
   {
      if ($scope) {
         $this->tokenScope = $scope;
      }

      $this->token_data = $this->getAuthTokenByAuthCode($authorization_code);
      
      $this->token 			= $this->token_data['access_token'];
      $this->expires_in 	= $this->token_data['expires_in'];
      $this->refresh_token 	= $this->token_data['refresh_token'];
      $this->account_id 	= $this->token_data['Permissions'][0]['AccountId'];
      
      $_SESSION['access_token'] 	= $this->token;
      $_SESSION['expires_in'] 		= $this->expires_in;
      $_SESSION['refresh_token'] 	= $this->refresh_token;
      $_SESSION['account_id'] 		= $this->account_id;
      
      if (!$this->token) {
         throw new Exception('Unable to get authorization token.');
      }
   }
   
   public function getAccountId() 
   {
       if (!$this->account_id) {
           throw new Exception('Account id not initialized.');
       }	
       
       return $this->account_id;
   }

   // this function makes authenticated request to API
   // -----------------------
   // $url is an absolute URL
   // $verb is an optional parameter.
   // Use 'GET' to retrieve data,
   //     'POST' to create new record
   //     'PUT' to update existing record
   //     'DELETE' to remove record
   // $data is an optional parameter - data to sent to server. Pass this parameter with 'POST' or 'PUT' requests.
   // ------------------------
   // returns object decoded from response json

   public function makeRequest($url, $verb = 'GET', $data = null)
   {	  
      if (!$this->token) {
         throw new Exception('Access token is not initialized. Call initTokenByAuthCode before performing requests.');
      }
      		  
	  $ch = curl_init();
	  $headers = array(
		 'Authorization: Bearer ' . $this->token,
		 'Content-Type: application/json'
	  );
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  if ($data) {
		 $jsonData = json_encode($data);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	  }

	  $jsonResult = curl_exec($ch);
	  $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	  // *** exception on total loss   
	  if ($jsonResult === false) {
		  throw new Exception(curl_errno($ch) . ': ' . curl_error($ch));
	  }
	  
      curl_close($ch);
      return json_decode($jsonResult, true);
   }

   private function getAuthTokenByAuthCode($authorization_code)
   {
      global $client_id;
      global $client_secret;
      global $redirect_uri;
      global $state;
      
      $data = sprintf("grant_type=%s&code=%s&client_id=%s&redirect_uri=%s&scope=%s",'authorization_code',$authorization_code, $client_id, $redirect_uri, $this->tokenScope);
      $authorizationHeader = "Authorization: Basic " . base64_encode( $client_id.":".$client_secret);
      return $this->getAuthToken($data, $authorizationHeader);
   }

   private function getAuthToken($data, $authorizationHeader)
   {      
      $ch = curl_init();

      $headers = array(
         $authorizationHeader,
         'Content-Type: application/x-www-form-urlencoded'
      );
      
      $auth_url = WaApiClient::AUTH_URL;
      
      curl_setopt($ch, CURLOPT_URL, $auth_url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	  
	  $result = json_decode(curl_exec($ch) , true);      
      $status = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
      
      if ($result === false) {
          throw new Exception(curl_errno($ch) . ': ' . curl_error($ch));
      }

      curl_close($ch);
      return $result;
   }

   public static function getInstance()
   {
      if (!is_object(self::$_instance)) {
         self::$_instance = new self();
      }

      return self::$_instance;
   }

   public final function __clone()
   {
      throw new Exception('It\'s impossible to clone singleton "' . __CLASS__ . '"!');
   }

   private function __construct()
   {
      if (!extension_loaded('curl')) {
         throw new Exception('cURL library is not loaded');
      }
   }

   public function __destruct()
   {
      $this->token = null;
   }
}
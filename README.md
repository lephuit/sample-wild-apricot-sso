# sample-wild-apricot-sso
Sample Wild Apricot SSO Authentication

### Notes
This is a bare-bones application for authenticating your account using the Wild Apricot SSO service. It isn't designed to be fancy. You will, of course, want to provide proper error handling as this script simply dies in case of error.

I am not affiliated with Wild Apricot; I am simply a user who has faced many of the same issues you are dealing with now.

### Modify includes/constants.php to provide your domain paths and API credentials.
1. constants.php
  * {YOUR_ACCOUNT_ID} -> Your Wild Apricot master account ID: find in Settings under Account
  * {YOUR_CLIENT_ID} -> API client id
  * {YOUR_CLIENT_SECRET} -> API client secret
  * {YOUR_PROCESSING_PATH} -> Your PHP server path to index.php (e.g., example.com or example.com/sso_test)
  * {YOUR_WILD_APRICOT_DOMAIN} -> Your Wild Apricot domain (e.g., mysite.com)

You will most likely wish to develop a method for defining custom session names in includes/sec_session.php prior to moving to a production environment. 

### Running the application
Simply navigate to index.php to initialize the single sign-on service.
* If you are already logged in to your Wild Apricot account, no further action is required.  You should see your account details displayed on the page once you are authenticated.
* If you are not logged in to Wild Apricot, you will be presented with the "ugly" login screen.  We prefer to forward members through a protected page on our site (therefore leveraging the normal login) rather than providing the actual off-site link for our production applications.

### Query strings
The application is also designed allow the passthrough of query strings (e.g., index.php?myvar=true).
Any query strings will pass directly to the destination page, allowing them to be used following authentication.

### Additional notes
By design, the SSO application is only able to access the "contacts_me" scope. You will need to perform a secondary API call to retrieve any additional information once you have a valid contact id at your disposal.

Of course, you must have an API application defined in Wild Apricot, and it must be set to accept SSO connections.

### Credits
The Wild Apricot helper file was taken from Wild Apricot's sample PHP application, apart from some minor changes to accept the authorization headers required for SSO.<br/>
https://github.com/WildApricot/ApiSamples/blob/master/PHP/sampleApplication.php

The secure session script was originally from a WikiHow on secure PHP login scripts.<br/>
http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL

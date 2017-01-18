# sample-wild-apricot-sso
### Sample Wild Apricot SSO Authentication

### Introduction
This is a bare-bones application for authenticating your account using the Wild Apricot SSO service. It isn't designed to be fancy. You will, of course, want to provide proper error handling as this script simply dies in case of error.

I am not affiliated with Wild Apricot; I am simply a user who has faced many of the same issues you are dealing with now.

### Getting started
1. I am assuming that you already have an SSL certificate in place on your Wild Apricot domain. Otherwise, you may (will?) need to set your primary domain to your "mysitename.wildapricot.org" included domain through the Wild Apricot settings.
2. You must have an API application defined in Wild Apricot, and it must be set to "Authorize users via Wild Apricot single sign-on service."
3. Start by downloading or cloning the contents of this repository to your PHP server. If you are planning on using the SSO service on pages in your site root (mysite.com/your_secure_page.php), clone the files such that sample-sso.php is found in the same directory as the pages you wish to secure.

### Modify includes/constants.php to provide your domain paths and API credentials.
1. includes/constants.php
  * {YOUR_ACCOUNT_ID} - Your Wild Apricot master account ID (find in Wild Apricot settings under Account)
  * {YOUR_CLIENT_ID} - API client id from authorized application
  * {YOUR_CLIENT_SECRET} - API client secret from authorized application
  * {YOUR_PROCESSING_PATH} - Your PHP server path to sample-sso.php (e.g., **myserver.com** if in your site root or **myserver.com/path_to_sample_sso** when placed in a directory)
  * {YOUR_WILD_APRICOT_DOMAIN} - Your Wild Apricot domain (e.g., **mywildapricotsite.com**)

You will most likely wish to develop a method for defining custom session names in includes/sec_session.php prior to moving to a production environment...among other things.

### Running the application
Simply navigate to **sample-sso.php** to initialize the single sign-on service.
* If you are already logged in to your Wild Apricot account, no further action is required.  You should see your account details displayed on the page once you are authenticated.
* If you are not logged in to Wild Apricot, you will be presented with the "ugly" login screen.  We prefer to forward members through a protected page on our site (therefore leveraging the normal login) rather than providing the actual off-site link for our production applications.

### Query strings
The application is also designed allow the passthrough of query strings (e.g., sample-sso.php?foo=true&bar=false).
Any query strings will pass directly to the destination page, allowing them to be used following successful authentication.

### Notes
By design, the SSO application is only able to access the "contacts_me" scope. You will need to perform a secondary API call to retrieve any additional information once you have a valid contact id at your disposal.

### Credits
The Wild Apricot helper file was taken from Wild Apricot's sample PHP application, apart from some minor changes to accept the authorization headers required for SSO.<br/>
https://github.com/WildApricot/ApiSamples/blob/master/PHP/sampleApplication.php

The secure session script was originally from a WikiHow on secure PHP login scripts.<br/>
http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL

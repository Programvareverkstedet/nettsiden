# General Authorization Code Flow OAuth2-Client

This client is made for Authorization Code Flow for now.

To use this general OAuth2 client-class, include it with
```
	require_once('OAuth2Client.php');
	$oauth2 = new OAuth2([
		"client_id" 		 => $client_id,
		"client_secret" 	 => $client_secret,
		"redirect_uri" 		 => $redirect_uri,
		"auth" 				 => $auth,
		"token" 			 => $token,
		"authorization_type" => $authorization_type,
		"session" 			 => $session,
		"verify" 			 => $verify,
		"grant_type" 		 => $grant_type,
		"response_type" 	 => $response_type
	]);
```

```(string) $client_id``` is client id of the OAuth2 application  
```(string) $client_secret``` is client secret of the OAuth2 application  
```(string) $redirect_uri``` is the specified redirect-uri for the OAuth2 application  
```(string) $auth``` is the full url for authorization  
```(string) $token``` is the full token url  

Optional -

```(string) $authorization_type``` defaults to Bearer  
```(boolean) $session``` specifies whether the state is to be saved in _SESSION storage, defaults to false  
```(boolean) $verify``` is whether to verify SSL of host and peer, defaults to true  
```(string) $grant_type``` defaults to 'authorization_code'  
```(string) $response_type``` defaults to "code"  


To start the redirect phase  

```$oauth2->redirect($state);``` ($state defaults to false)  


To get access token

```$oauth2->get_access_token();``` returns the access_token.  


(Optional value is $state, to check up against _SESSION variables)


To get identity

```$oauth->get_identity($access_token, $user_url);```

```(string) $user_url``` is the endpoint for fetching info, example: https://auth.dataporten.no/userinfo

returns the identity-object as returned from the OAuth2-provider.

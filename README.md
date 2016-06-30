# General OAuth2-Client

To use this general OAuth2 client-class, include it with
``` require_once('OAuth2Client.php'); 
	$oauth2 = new OAuth2( $client_id, $client_secret, $redirect_uri, $auth, $token, $user, $authorization_type, $session, $verify, $grant_type, $response_type);
```

$client_id is client id of the OAuth2 application

$client_secret is client secret of the OAuth2 application

$redirect_uri is the specified redirect-uri for the OAuth2 application

$auth is the full url for authorization

$token is the full token url

$user is the full identity url (example: https://auth.dataporten.no/userinfo)


Optional - 

$authorization_type defaults to Bearer

$session specifies whether the state is to be saved in _SESSION storage, defaults to false

$verify is whether to verify SSL of host and peer, defaults to false

$grant_type defaults to 'authorization_code'

$response_type defaults to 'code'


To start the redirect phase

``` $oauth2->redirect($state); ```

($state defaults to false)


To get access token

``` $oauth2->get_access_token(); ```

returns the access_token.

(Optional value is $state, to check up against _SESSION variables)


To get identity

``` $oauth->get_identity($access_token); ```

returns the identity-object as returned from the OAuth2-provider.


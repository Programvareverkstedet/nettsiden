<?php

# go to https://auth.dataporten.no/

$dataportenConfig = [
	'client_id' => "",
	'client_secret' => "",
	'redirect_uri' => "",
	'auth' => "https://auth.dataporten.no/oauth/authorization",#Authorization endpoint
	'token' => "https://auth.dataporten.no/oauth/token",#Token endpoint
	
	/* OPTIONAL */

	# 'authorization_type' => "Bearer",
	# 'session' => false,
	# 'verify' => 1,
	# 'grant_type' => "authorization_code",
	# 'response_type' => "code",
	# 'scope' => "",
];

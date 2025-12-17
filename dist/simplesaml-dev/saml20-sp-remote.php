<?php

$metadata['http://localhost:1080/simplesaml/sp'] = [
    'AssertionConsumerService' => [
        [
            'Location' => 'http://localhost:1080/simplesaml/module.php/saml/sp/saml2-acs.php/default-sp',
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],
    ],
    'SingleLogoutService' => [
        [
            'Location' => 'http://localhost:1080/simplesaml/module.php/saml/sp/saml2-logout.php/default-sp',
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
    ],
];

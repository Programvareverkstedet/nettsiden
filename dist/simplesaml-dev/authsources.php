<?php

declare(strict_types=1);
$config = [
    // This is used by the service provider to contact the identity provider
    'default-sp' => [
      'saml:SP',
      'entityID' => 'http://localhost:1080/simplesaml/sp',
      'idp' => 'http://localhost:1080/simplesaml/idp',
    ],

    // This is used by the identity provider to authenticate users
    'example-userpass' => [
        'exampleauth:UserPass',
        'users' => [
            'user:user' => [
                'uid' => ['user'],
                'group' => ['users'],
                'cn' => 'Ole Petter',
                'mail' => 'user+test@pvv.ntnu.no',
            ],
            'admin:admin' => [
                'uid' => ['admin'],
                'group' => ['admin'],
                'cn' => 'Admin Adminsson',
                'mail' => 'admin+test@pvv.ntnu.no',
            ],
        ],
    ],

    // This is also used by the identity provider to authenticate IDP admins
    // See http://localhost:1080/simplesaml/admin/
    'admin' => [
      'core:AdminPassword',
    ],
];

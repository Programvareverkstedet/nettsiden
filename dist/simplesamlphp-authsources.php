<?php

declare(strict_types=1);
$config = [

  /* This is the name of this authentication source, and will be used to access it later. */
  'default-sp' => [
    'saml:SP',
    'entityID' => 'https://www.pvv.ntnu.no/simplesaml/',
    'idp' => 'https://idp.pvv.ntnu.no/',
  ],
];

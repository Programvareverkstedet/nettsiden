<?php

declare(strict_types=1);
$metadata['https://idp.pvv.ntnu.no/'] =  [
  'metadata-set' => 'saml20-idp-remote',
  'entityid' => 'https://idp.pvv.ntnu.no/',
  'SingleSignOnService' => [
    0 => [
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://idp.pvv.ntnu.no/simplesaml/saml2/idp/SSOService.php',
    ],
  ],
  'SingleLogoutService' => [
    0 => [
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://idp.pvv.ntnu.no/simplesaml/saml2/idp/SingleLogoutService.php',
    ],
  ],
  'certData' => 'MIIDpTCCAo2gAwIBAgIJAJIgibrB7NvsMA0GCSqGSIb3DQEBCwUAMGkxCzAJBgNVBAYTAk5PMR4wHAYDVQQKDBVQcm9ncmFtdmFyZXZlcmtzdGVkZXQxGDAWBgNVBAMMD2lkcC5wdnYubnRudS5ubzEgMB4GCSqGSIb3DQEJARYRZHJpZnRAcHZ2Lm50bnUubm8wHhcNMTcxMTEzMjI0NTQyWhcNMjcxMTEzMjI0NTQyWjBpMQswCQYDVQQGEwJOTzEeMBwGA1UECgwVUHJvZ3JhbXZhcmV2ZXJrc3RlZGV0MRgwFgYDVQQDDA9pZHAucHZ2Lm50bnUubm8xIDAeBgkqhkiG9w0BCQEWEWRyaWZ0QHB2di5udG51Lm5vMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAveLujCsgVCRA360y5yezy8FcSPhaqodggDqY12UTkYOMQLBFaph6uUL4oCUlXZqxScrAYVRt9yw+7BYpcm0p51VZzVCsfMxRVkn+O1eUvsaXq3f13f87QHKYP2f0uqkGf5PvnKIdSaI/ix8WJhD8XT+h0OkHEcaBvUtSG7zbEhvG21WPHwgw2rvZSneArQ8tOitZC0u8VXSfdhtf6ynRseo0xC95634UwQAZivhQ2v4A6Tp57QG5DCXIJ9/z3PkINx3KB/hOeh0EP6Dpbp+7V0/t9778E3whpm4llrH144kzROhA7EgUgkZOjAVjxGCYlcj3xQPnnItihVOZ5B5qLwIDAQABo1AwTjAdBgNVHQ4EFgQUPLhrB+Qb/Kzz7Car9GJkKmEkz6swHwYDVR0jBBgwFoAUPLhrB+Qb/Kzz7Car9GJkKmEkz6swDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAd+4E6t0j8/p8rbZE8y/gZ9GsiRhxkR4l6JbMRUfEpqHKi415qstChRcP2Lo3Yd5qdmj9tLDWoPsqet1QgyTTmQTgUmPhhMOQDqSh90LuqEJseKWafXGS/SfWLH6MWVmzDV5YofJEw2ThPiU58GiS06OLS2poq1eAesa2LQ22J8yYisXM4sxImIFte+LYQ1+1evfBWcvU1vrGsQ0VLJHdef9WoXp1swUFhq4Zk0c7gjHiB1CFVlExAAlk9L6W3CVXmKIYlf4eUnEBGkC061Ir42+uhAMWO9Y/L1NEuboTyd2KAI/6JdKdzpmfk7zPVxWlNxNCZ7OPNuvOKp6VlpB2EA==',
  'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
];

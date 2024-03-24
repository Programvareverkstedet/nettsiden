{ php }:

php.buildComposerProject rec {
  src = ./..;
  pname = "pvv-nettsiden";
  version = "0.0.1";
  vendorHash = "sha256-DSn0ifj7Hjjia1SF/1wfziD/IdsiOES8XNDVz3F/cTI=";

  passthru.simplesamlphpPath = "share/php/pvv-nettsiden/vendor/simplesamlphp/simplesamlphp";

  postInstall = ''
    install -Dm444 dist/simplesamlphp-config.php      $out/${passthru.simplesamlphpPath}/config/config.php
    install -Dm444 dist/simplesamlphp-authsources.php $out/${passthru.simplesamlphpPath}/config/authsources.php
    install -Dm444 dist/simplesamlphp-idp.php         $out/${passthru.simplesamlphpPath}/metadata/saml20-idp-remote.php

    install -Dm444 dist/config.source-env.php $out/share/php/pvv-nettsiden/config.php
  '';
}

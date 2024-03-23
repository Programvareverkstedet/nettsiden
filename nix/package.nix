{ php }:

php.buildComposerProject {
  src = ./..;
  pname = "pvv-nettsiden";
  version = "0.0.1";
  vendorHash = "sha256-DSn0ifj7Hjjia1SF/1wfziD/IdsiOES8XNDVz3F/cTI=";

  postInstall = ''
    simplesamlphp="$out/share/php/pvv-nettsiden/vendor/simplesamlphp/simplesamlphp"

    mkdir -p $simplesamlphp/config
    mkdir -p $simplesamlphp/metadata

    cp dist/simplesamlphp-config.php      $simplesamlphp/config/config.php
    cp dist/simplesamlphp-authsources.php $simplesamlphp/config/authsources.php
    cp dist/simplesamlphp-idp.php         $simplesamlphp/metadata/saml20-idp-remote.php

    cp dist/config.source-env.php $out/share/php/pvv-nettsiden/config.php

    ln -s $simplesamlphp/www $out/share/php/pvv-nettsiden/www/simplesaml
  '';
}

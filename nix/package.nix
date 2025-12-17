{ lib
, php
, extra_files ? { }
}:

php.buildComposerProject rec {
  src = lib.fileset.toSource {
    root = ./..;
    fileset = lib.fileset.difference
      (lib.fileset.unions [
        ../dist
        ../inc
        ../src
        ../www
        ../composer.json
        ../composer.lock
      ])
      (lib.fileset.unions [
        (lib.fileset.maybeMissing ../www/simplesaml)
        (lib.fileset.maybeMissing ../www/simplesaml-idp)
      ]);
  };
  pname = "pvv-nettsiden";
  version = "0.0.1";
  vendorHash = "sha256-7I7Fdp5DvCwCdYY66Mv0hZ+a8xRzQt+WMUKG544k7Fc=";

  passthru.simplesamlphpPath = "share/php/pvv-nettsiden/vendor/simplesamlphp/simplesamlphp";

  postInstall = ''
    install -Dm644 dist/simplesaml-prod/config.php            "$out"/${passthru.simplesamlphpPath}/config/config.php
    install -Dm644 dist/simplesaml-prod/authsources.php       "$$out/${passthru.simplesamlphpPath}/config/authsources.php
    install -Dm644 dist/simplesaml-prod/saml20-idp-remote.php "$$out/${passthru.simplesamlphpPath}/metadata/saml20-idp-remote.php
    install -Dm644 dist/config.source-env.php                 "$$out/share/php/pvv-nettsiden/config.php

    ${lib.pipe extra_files [
      (lib.mapAttrsToList (target_path: source_path: ''
        mkdir -p $(dirname "$out/${target_path}")
        cp -r "${source_path}" "$out/${target_path}"
      ''))
      (lib.concatStringsSep "\n")
    ]}
  '';
}

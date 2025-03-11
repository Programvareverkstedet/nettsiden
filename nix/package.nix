{ lib
, php
, extra_files ? { }
}:

php.buildComposerProject rec {
  src = ./..;
  pname = "pvv-nettsiden";
  version = "0.0.1";
  vendorHash = "sha256-8UYf7FhrTKgCa2e8GwhU8EF1AfWzZtgseTZqUAGOL0U=";

  passthru.simplesamlphpPath = "share/php/pvv-nettsiden/vendor/simplesamlphp/simplesamlphp";

  postInstall = ''
    install -Dm644 dist/simplesamlphp-config.php      $out/${passthru.simplesamlphpPath}/config/config.php
    install -Dm644 dist/simplesamlphp-authsources.php $out/${passthru.simplesamlphpPath}/config/authsources.php
    install -Dm644 dist/simplesamlphp-idp.php         $out/${passthru.simplesamlphpPath}/metadata/saml20-idp-remote.php
    install -Dm644 dist/config.source-env.php         $out/share/php/pvv-nettsiden/config.php

    ${lib.pipe extra_files [
      (lib.mapAttrsToList (target_path: source_path: ''
        mkdir -p $(dirname "$out/${target_path}")
	cp -r "${source_path}" "$out/${target_path}"
      ''))
      (lib.concatStringsSep "\n")
    ]}
  '';
}

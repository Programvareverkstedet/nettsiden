{ lib, php }:

php.buildComposerProject (finalAttrs: {
  pname = "pvv-nettsiden";
  version = "1.0.0";

  patchPhase = ''ls -la'';
  src = ./.; # TODO: Use builtins.filterSource or similar to clean the source dir


  vendorHash = "sha256-APKvVTr7AeCfA1WAzvh6Ex5l8f4Oy46eUoM80vCWMgk=";
})

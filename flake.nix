{
  description = "Programvareverkstedet/nettsiden PHP environment";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixpkgs-unstable";
  };

  outputs = { self, nixpkgs }:
  let
    systems = [
      "x86_64-linux"
      "aarch64-linux"
      "aarch64-darwin"
    ];
    forAllSystems = f: nixpkgs.lib.genAttrs systems (system: let
      pkgs = nixpkgs.legacyPackages.${system};
    in f system pkgs);
  in {
    packages = forAllSystems (system: pkgs: {
      default = self.packages.${system}.pvv-nettsiden;
      pvv-nettsiden = pkgs.callPackage ./nix/package.nix { php = pkgs.php82; };
    });

    overlays = forAllSystems (system: pkgs: {
      default = prev: final: {
        inherit (self.packages.${system}) pvv-nettsiden;
        formats = final.formats // { php = import ./nix/php-generator.nix { pkgs = final; lib = final.lib; }; };
      };
    });

    nixosModules.default = nix/module.nix;

    devShells = forAllSystems (system: pkgs: {
      default = pkgs.callPackage ./nix/shell.nix { inherit pkgs; };
    });

    # TODO:
    # - Relicense the project to GPL or something
    # - Write a module for the project
  };
}
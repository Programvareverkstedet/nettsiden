{ pkgs }:
let
  phpEnv = pkgs.php84.buildEnv {
    extensions = { enabled, all }: enabled ++ (with all; [ iconv mbstring pdo_mysql pdo_sqlite ]);
  };
in
pkgs.mkShellNoCC {
  buildInputs = with pkgs; [
    phpEnv
    php84Packages.composer
    php84Packages.php-parallel-lint
    php84Packages.php-cs-fixer
    sqlite-interactive
    sql-formatter
    openssl
  ];
}

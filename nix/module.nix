{ config, lib, pkgs, ... }:
let
  cfg = config.services.pvv-nettsiden;
  inherit (lib) mkDefault mkEnableOption mkPackageOption mkIf mkOption types mdDoc;
  format = pkgs.formats.php { };
in
{
  options.services.pvv-nettsiden = {
    enable = mkEnableOption (lib.mdDoc "Enable pvv-nettsiden");

    package = mkPackageOption pkgs "pvv-nettsiden" { };

    user = mkOption {
      type = types.str;
      default = "pvv-nettsiden";
      description = mdDoc "User to run php-fpm and own the image directories";
    };

    group = mkOption {
      type = types.str;
      default = "pvv-nettsiden";
      description = mdDoc "Group to run php-fpm and own the image directories";
    };

    domainName = mkOption {
      type = types.str;
      default = "www.pvv.no";
      description = mdDoc "Domain name for the website";
    };

    enableNginx = mkEnableOption "nginx" // { default = true; };
    useSSL = mkEnableOption "secure cookies" // { default = true; };

    settings = mkOption {
      description = "Settings for the website";
      default = { };
      type = types.submodule {
        freeformType = format.type;
        options = lib.mapAttrsRecursiveCond
          (attrs: !(attrs ? "type"))
          (_: option: option // { type = types.either option.type format.lib.types.raw; })
        {
          GALLERY = {
            DIR = mkOption {
              type = types.path;
              default = "/var/lib/pvv-nettsiden/gallery";
              description = mdDoc "Directory where the gallery is located. See documentation at TODO";
            };

            SERVER_PATH = mkOption {
              type = types.str;
              default = "/static/gallery";
              description = mdDoc "Path to the gallery on the server";
            };
          };

          SLIDESHOW = {
            DIR = mkOption {
              type = types.path;
              default = "/var/lib/pvv-nettsiden/slideshow";
              description = mdDoc "Directory where the slideshow is located. See documentation at TODO";
            };

            SERVER_PATH = mkOption {
              type = types.str;
              default = "/static/slideshow";
              description = mdDoc "Path to the slideshow on the server";
            };
          };

          DB = {
            DSN = mkOption {
              type = types.str;
              default = "sqlite:/var/lib/pvv-nettsiden/pvv-nettsiden.db";
              example = "pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass";
              description = mdDoc "Database connection string, see https://www.php.net/manual/en/pdo.construct.php";
            };

            USER = mkOption {
              type = with types; nullOr str;
              default = null;
              example = "pvv-nettsiden";
              description = mdDoc "Database user";
            };

            PASS = mkOption {
              type = with types; nullOr str;
              default = null;
              description = mdDoc "Database password. Recommends: null, set in extraConfig";
            };
          };
        };
      };
    };
  };


  config = mkIf cfg.enable {
    users.users = mkIf (cfg.user == "pvv-nettsiden") {
      "pvv-nettsiden" = {
        description = "PVV Website Service User";
        group = cfg.group;
        createHome = false;
        isSystemUser = true;
      };
    };

    users.groups = mkIf (cfg.group == "pvv-nettsiden") {
      "pvv-nettsiden" = { };
    };

    services.nginx = mkIf cfg.enableNginx {
      enable = true;

      recommendedGzipSettings = mkDefault true;
      recommendedProxySettings = mkDefault true;

      virtualHosts."${cfg.domainName}" = {
        forceSSL = mkDefault cfg.useSSL;
        enableACME = mkDefault true;
        locations = {
          "/" = {
            root = "${cfg.package}/share/php/pvv-nettsiden/www/";
            index = "index.php";
          };

          "~ \\.php$".extraConfig = ''
            include ${pkgs.nginx}/conf/fastcgi_params;
            fastcgi_param SCRIPT_FILENAME ${cfg.package}/share/php/pvv-nettsiden/www$fastcgi_script_name;
            fastcgi_pass unix:${config.services.phpfpm.pools."pvv-nettsiden".socket};
          '';

          ${cfg.settings.GALLERY.SERVER_PATH} = {
            root = cfg.settings.GALLERY.DIR;
          };

          ${cfg.settings.SLIDESHOW.SERVER_PATH} = {
            root = cfg.settings.SLIDESHOW.DIR;
          };
        };
      };

    };

    services.phpfpm.pools.pvv-nettsiden = {
      user = cfg.user;
      group = cfg.group;

      phpEnv.PVV_CONFIG_FILE = toString (format.generate "pvv-nettsiden-conf.php" cfg.settings);

      settings = {
        "listen.owner" = config.services.nginx.user;
        "listen.group" = config.services.nginx.group;
        "pm" = mkDefault "ondemand";
        "pm.max_children" = mkDefault 32;
        "pm.process_idle_timeout" = mkDefault "10s";
        "pm.max_requests" = mkDefault 500;
      };
    };
  };
}

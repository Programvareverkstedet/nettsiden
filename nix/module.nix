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
        options = let
          phpSpecialType = types.addCheck types.attrs (v: v ? _phpType);
        in lib.mapAttrsRecursiveCond
          (attrs: !(attrs ? "type"))
          (_: option: option // { type = types.either option.type phpSpecialType; })
        {
          DOOR_SECRET = mkOption {
            type = types.str;
            description = mdDoc "Secret for the door sensor API";
          };

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

          SAML = {
            COOKIE_SALT = mkOption {
              type = types.str;
              description = mdDoc "Salt for the SAML cookies";
            };

            COOKIE_SECURE = mkOption {
              type = types.bool;
              default = true;
              description = mdDoc "Whether to set the secure flag on the SAML cookies";
            };

            ADMIN_NAME = mkOption {
              type = types.str;
              description = mdDoc "Name for the admin user";
            };

            ADMIN_EMAIL = mkOption {
              type = types.str;
              description = mdDoc "Email for the admin user";
            };

            ADMIN_PASSWORD = mkOption {
              type = types.str;
              description = mdDoc "Password for the admin user";
            };

            TRUSTED_DOMAINS = mkOption {
              type = types.listOf types.str;
              default = [ cfg.domainName ];
              description = mdDoc "List of trusted domains for the SAML service";
            };
          };

          CACHE_DIRECTORY = mkOption {
            type = types.path;
            default = "/var/cache/pvv-nettsiden/simplesamlphp";
            description = mdDoc "List of trusted domains for the SAML service";
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

    systemd.tmpfiles.settings."10-pvv-nettsiden".${cfg.settings.CACHE_DIRECTORY}.d = {
      inherit (cfg) user group;
      mode = "0770";
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

          # based on https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#configuring-nginx
          "^~ /simplesaml/" = {
            alias = "${cfg.package}/${cfg.package.passthru.simplesamlphpPath}/public/";
            index = "index.php";

            extraConfig = ''
              location ~ ^/simplesaml/(?<phpfile>.+?\.php)(?<pathinfo>/.*)?$ {
                include ${pkgs.nginx}/conf/fastcgi_params;
                fastcgi_pass unix:${config.services.phpfpm.pools."pvv-nettsiden".socket};
                fastcgi_param SCRIPT_FILENAME ${cfg.package}/${cfg.package.passthru.simplesamlphpPath}/public/$phpfile;

                # Must be prepended with the baseurlpath
                fastcgi_param SCRIPT_NAME /simplesaml/$phpfile;

                fastcgi_param PATH_INFO $pathinfo if_not_empty;
              }
            '';
          };

          "^~ ${cfg.settings.GALLERY.SERVER_PATH}" = {
            root = cfg.settings.GALLERY.DIR;
            extraConfig = ''
              rewrite ^${cfg.settings.GALLERY.SERVER_PATH}/(.*)$ /$1 break;
            '';
          };

          "^~ ${cfg.settings.SLIDESHOW.SERVER_PATH}" = {
            root = cfg.settings.SLIDESHOW.DIR;
            extraConfig = ''
              rewrite ^${cfg.settings.SLIDESHOW.SERVER_PATH}/(.*)$ /$1 break;
            '';
          };
        };
      };

    };

    services.phpfpm.pools.pvv-nettsiden = {
      user = cfg.user;
      group = cfg.group;

      phpEnv.PVV_CONFIG_FILE = let
        # { DB.DSN = "..."; } -> { DB_DSN = "..."; }.
        flattenSettings = prefix: lib.concatMapAttrs (name: value: let
          name' = if prefix == "" then name else "${prefix}_${name}";
        in
          if lib.isAttrs value && !(value ? _phpType)
          then flattenSettings name' value
          else { ${name'} = value; });
      in toString (format.generate "pvv-nettsiden-conf.php" (flattenSettings "" cfg.settings));

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

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


  config = mkIf cfg.enable (let
    # NOTE: This should absolutely not be necessary, but for some reason this file refuses to import
    #       the toplevel configuration file.
    # NOTE: Nvm, don't this this was the problem after all?
    finalPackage = cfg.package.overrideAttrs (_: _: {
      postInstall = let
        f = x: lib.escapeShellArg (format.lib.valueToString x);
      in cfg.package.postInstall + ''
        substituteInPlace $out/${cfg.package.passthru.simplesamlphpPath}/config/config.php \
          --replace '$SAML_COOKIE_SECURE'   ${f cfg.settings.SAML.COOKIE_SECURE} \
          --replace '$SAML_COOKIE_SALT'     ${f cfg.settings.SAML.COOKIE_SALT} \
          --replace '$SAML_ADMIN_PASSWORD'  ${f cfg.settings.SAML.ADMIN_PASSWORD} \
          --replace '$SAML_ADMIN_NAME'      ${f cfg.settings.SAML.ADMIN_NAME} \
          --replace '$SAML_ADMIN_EMAIL'     ${f cfg.settings.SAML.ADMIN_EMAIL} \
          --replace '$SAML_TRUSTED_DOMAINS' ${f cfg.settings.SAML.TRUSTED_DOMAINS} \
          --replace '$CACHE_DIRECTORY'      ${f cfg.settings.CACHE_DIRECTORY}
      '';
    });
  in {
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
            root = "${finalPackage}/share/php/pvv-nettsiden/www/";
            index = "index.php";
          };

          "~ \\.php$".extraConfig = ''
            include ${pkgs.nginx}/conf/fastcgi_params;
            fastcgi_param SCRIPT_FILENAME ${finalPackage}/share/php/pvv-nettsiden/www$fastcgi_script_name;
            fastcgi_pass unix:${config.services.phpfpm.pools."pvv-nettsiden".socket};
          '';

          # based on https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#configuring-nginx
          "^~ /simplesaml/" = {
            alias = "${finalPackage}/${finalPackage.passthru.simplesamlphpPath}/public/";
            index = "index.php";

            extraConfig = ''
              location ~ ^/simplesaml/(?<phpfile>.+?\.php)(?<pathinfo>/.*)?$ {
                include ${pkgs.nginx}/conf/fastcgi_params;
                fastcgi_pass unix:${config.services.phpfpm.pools."pvv-nettsiden".socket};
                fastcgi_param SCRIPT_FILENAME ${finalPackage}/${finalPackage.passthru.simplesamlphpPath}/public/$phpfile;

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
  });
}

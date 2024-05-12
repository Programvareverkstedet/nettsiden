<?php

require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$door = new \pvv\side\Door($pdo);
$doorEntry = (object)($door->getCurrent());

?>
{
  "api_compatibility": ["14"],
  "space": "Programvareverkstedet",
  "logo": "https://git.pvv.ntnu.no/Drift/pvv-nixos-config/raw/branch/main/assets/logo_blue_regular.png",
  "url": "https://www.pvv.ntnu.no/",
  "location": {
    "address": "Sem Sælands vei 1, 7034 Trondheim, Norway",
    "timezone": "Europe/Oslo",
    "lon": 10.242,
    "lat": 63.250
  },
  "contact": {
    "irc": "irc://irc.pvv.ntnu.no/pvv",
    "email": "pvv@pvv.ntnu.no",
    "ext_discord": "https://discord.gg/8VTBr6Q",
    "gopher": "gopher://isvegg.pvv.ntnu.no",
    "matrix": "#pvv:pvv.ntnu.no"
  },
  "issue_report_channels": ["email"],
  "state": {
    "open": <?php echo($doorEntry->open ? "true" : "false"); ?>,
    "lastchange": <?php echo($doorEntry->time ? $doorEntry->time : 0); ?>
  },
  "feeds": {
    "wiki": {
      "type": "atom",
      "url": "https://www.pvv.ntnu.no/w/api.php?hidebots=1&urlversion=1&action=feedrecentchanges&feedformat=atom"
    }
  },
  "projects": [
    "https://github.com/Programvareverkstedet/",
    "https://git.pvv.ntnu.no/",
    "https://www.pvv.ntnu.no/prosjekt/"
  ],
  "links": [
    {
      "name": "Events",
      "url": "https://www.pvv.ntnu.no/hendelser/",
      "description": "Upcoming events at Programvareverkstedet"
    },
    {
      "name": "YouTube",
      "url": "https://www.youtube.com/@pvvntnu5640"
    },
    {
      "name": "LinkedIn",
      "url": "https://www.linkedin.com/company/pvvntnu/"
    },
    {
      "name": "Facebook",
      "url": "https://www.facebook.com/pvvntnu/"
    }
  ]
}

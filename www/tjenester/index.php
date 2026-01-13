<?php

namespace pvv\side;

require_once \dirname(__DIR__, 2) . implode(\DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

# TODO: no me gusta galore, please choose some better colors, omg

# Light blue monochromatic color palette
$colorPalette = [
  "#D1F8EF60",
  "#3674B560",
  "#A1E3F960",
  "#578FCA60",
];

function rgbToHsl(int $r, int $g, int $b): array
{
    // Assert valid RGB range
    if ($r < 0 || $r > 255 || $g < 0 || $g > 255 || $b < 0 || $b > 255) {
        throw new \InvalidArgumentException('RGB values must be between 0 and 255');
    }

    $r /= 255;
    $g /= 255;
    $b /= 255;

    $max = max($r, $g, $b);
    $min = min($r, $g, $b);
    $delta = $max - $min;

    $l = ($max + $min) / 2;

    if ($delta == 0) {
        $h = 0;
        $s = 0;
    } else {
        $s = $delta / (1 - abs(2 * $l - 1));

        if ($max === $r) {
            $h = 60 * (($g - $b) / $delta);
            if ($h < 0) {
                $h += 360;
            }
        } elseif ($max === $g) {
            $h = 60 * ((($b - $r) / $delta) + 2);
        } else {
            $h = 60 * ((($r - $g) / $delta) + 4);
        }
    }

    return [
        'h' => round($h, 2),
        's' => round($s * 100, 2),
        'l' => round($l * 100, 2),
    ];
}

function hslToRgb(float $h, float $s, float $l): array
{
    // Assert valid HSL ranges
    if ($h < 0 || $h > 360) {
        throw new \InvalidArgumentException('Hue must be between 0 and 360');
    }
    if ($s < 0 || $s > 100 || $l < 0 || $l > 100) {
        throw new \InvalidArgumentException('Saturation and Lightness must be between 0 and 100');
    }

    $s /= 100;
    $l /= 100;

    $c = (1 - abs(2 * $l - 1)) * $s;
    $m = $l - $c / 2;

    // Determine hue sector explicitly
    if ($h < 60) {
        $r1 = $c;
        $g1 = ($h / 60) * $c;
        $b1 = 0;
    } elseif ($h < 120) {
        $r1 = (2 - $h / 60) * $c;
        $g1 = $c;
        $b1 = 0;
    } elseif ($h < 180) {
        $r1 = 0;
        $g1 = $c;
        $b1 = (($h - 120) / 60) * $c;
    } elseif ($h < 240) {
        $r1 = 0;
        $g1 = (4 - $h / 60) * $c;
        $b1 = $c;
    } elseif ($h < 300) {
        $r1 = (($h - 240) / 60) * $c;
        $g1 = 0;
        $b1 = $c;
    } else { // h < 360
        $r1 = $c;
        $g1 = 0;
        $b1 = (6 - $h / 60) * $c;
    }

    return [
        'r' => (int) round(($r1 + $m) * 255),
        'g' => (int) round(($g1 + $m) * 255),
        'b' => (int) round(($b1 + $m) * 255),
    ];
}

function generateHighlightColor(string $hexColor): string {
    $r = hexdec(substr($hexColor, 1, 2));
    $g = hexdec(substr($hexColor, 3, 2));
    $b = hexdec(substr($hexColor, 5, 2));
    $a = hexdec(substr($hexColor, 7, 2));

    $hsl = rgbToHsl($r, $g, $b);

    // Increase lightness by 20%, cap at 100%
    $hsl['l'] = min(100, $hsl['l'] + 20);

    $rgb = hslToRgb($hsl['h'], $hsl['s'], $hsl['l']);

    return sprintf(
        "#%02x%02x%02x%02x",
        $rgb['r'],
        $rgb['g'],
        $rgb['b'],
        $a,
    );
}

$services = [
    "vcs" => [
        "title" => "Versjonskontroll og utvikling",
        "services" => [
        [
            "name" => "Gitea",
            "description" => "Vår interne git-tjener, åpen for alle medlemmer",
            "link" => "https://git.pvv.ntnu.no",
            "link_text" => "Gå til git.pvv.ntnu.no",
            "image" => "img/gitea.svg",
        ],
        [
            "name" => "GitHub",
            "description" => "Speiling av våre mest interessante prosjekter på GitHub",
            "link" => "https://github.com/Programvareverkstedet/",
            "link_text" => "Gå til GitHub",
            "image" => "img/github.png",
        ],
        [
            "name" => "Codeberg",
            "description" => "Speiling av våre mest interessante prosjekter på Codeberg",
            "link" => "https://codeberg.org/Programvareverkstedet/",
            "link_text" => "Gå til Codeberg",
            "image" => "img/codeberg.svg",
        ]
        ]
    ],
    "webmail" => [
        "title" => "Epostklienter",
        "services" => [
            [
                "name" => "Roundcube",
                "description" => "En av våre webmail-klienter for epost.",
                "link" => "https://webmail.pvv.ntnu.no/",
                "link_text" => "Gå til Roundcube",
                "image" => "img/roundcube.svg",
            ],
            [
                "name" => "Snappymail",
                "description" => "En annen av våre webmail-klienter for epost.",
                "link" => "https://snappymail.pvv.ntnu.no/",
                "link_text" => "Gå til Snappymail",
                "image" => "img/snappymail.svg",
            ],
            [
                "name" => "Alps",
                "description" => "Jaggu enda en webmail-klient for epost.",
                "link" => "https://alps.pvv.ntnu.no/",
                "link_text" => "Gå til Alps",
                "image" => "img/alps.svg",
            ],
        ],
    ],
    "communication" => [
        "title" => "Kommunikasjon",
        "services" => [
            [
                "name" => "Matrix via Element",
                "description" => implode(
                    " ",
                    [
                      "Åpen kommunikasjonsprotokoll som støtter ende-til-ende-kryptering og utallige kule funksjoner.",
                      "Vårt space er bridget sammen med Discord, så du får alle de samme meldingene.",
                      "#pvv:pvv.ntnu.no",
                    ],
                ),
                "link" => "https://chat.pvv.ntnu.no",
                "link_text" => "Gå til chat.pvv.ntnu.no",
                "image" => "img/element.svg",
            ],
            [
                "name" => "Discord",
                "description" => "Vår hovedkanal, her finner du alt fra ofisielle announcements til memes og driftsdiskusjoner.",
                "link" => "https://discord.gg/WpaHGV8K",
                "link_text" => "Gå til Discord",
                "image" => "img/discord.svg",
            ],
            [
                "name" => "Epost",
                "description" => "Som PVV-medlem får du din egen @pvv.ntnu.no-adresse, som kan brukes med alle vanlige epostprotokoller.",
                "link" => "https://webmail.pvv.ntnu.no/",
                "link_text" => "Gå til Rouncubcube webmail",
                "image" => "img/email.png",
            ],
            [
                "name" => "IRC",
                "description" => "Hvis Discord er for proprietært og Matrix er for hypermoderne er kanskje IRC for deg. Vi har en kanal på IRCNet, #pvv.",
                "link" => "irc://irc.pvv.ntnu.no/pvv",
                "link_text" => "Koble til med IRC",
                "image" => "img/irc.png",
            ],
        ],
    ],
    "hosting" => [
        "title" => "Verting og nettsider",
        "services" => [
            [
                "name" => "Brukernettsider",
                "description" => "Alle brukere får automatisk en egen side for html og php. Denne er offentlig på pvv.ntnu.no/~brukernavn.",
                "link" => "https://wiki.pvv.ntnu.no/wiki/Tjenester/Hjemmesider",
                "link_text" => "Gå til dokumentasjon på wiki",
                "image" => "img/php.png",
            ],
            [
                "name" => "Gopherhull",
                "description" => "PVV driver en egen gopher-tjener for nostalgikere og retroentusiaster.",
                "link" => "https://wiki.pvv.ntnu.no/wiki/Tjenester/Gopherhull",
                "link_text" => "Se dokumentasjon for gophertjening",
                "image" => "img/gopher.png",
            ],
            [
                "name" => "Wiki",
                "description" => "PVVs wiki er åpen for alle medlemmer, og kan brukes til dokumentasjon, notater, prosjektsider og mye mer.",
                "link" => "https://wiki.pvv.ntnu.no",
                "link_text" => "Gå til wiki.pvv.ntnu.no",
                "image" => "img/mediawiki.svg",
            ],
            [
                "name" => "PVV-siden",
                "description" => "Du befinner deg nå på PVV sin offisielle hjemmeside. Den er skrevet i PHP og kjører på en egen server.",
                "link" => "https://git.pvv.ntnu.no/Projects/nettsiden",
                "link_text" => "Se koden på gitea",
                "image" => "../pvv-logo.png",
            ],
        ],
    ],
    "recreational" => [
        "title" => "Underholdning og fritid",
        "services" => [
            [
                "name" => "Minecraft",
                "description" => "Vi har en egen Minecraft-server for medlemmer, som du kan koble til med IP-adressen minecraft.pvv.ntnu.no. Spør om whitelist på matrix/discord.",
                "link" => "https://minecraft.pvv.ntnu.no",
                "link_text" => "Gå til verdenskartet vårt",
                "image" => "img/minecraft.png",
            ],
            [
                "name" => "MiniFlux RSS reader",
                "description" => "Trenger du en cross-platform RSS/Atom-leser for å følge med på omverdenen som det er 1990? ",
                "link" => "https://feeds.pvv.ntnu.no",
                "link_text" => "Gå til MiniFlux",
                "image" => "img/rss.svg",
            ],
            [
                "name" => "Bildegalleri",
                "description" => "PVV har et felles bildegalleri, der alle kan legge relevante bilder, som automatisk blir inkludert på nettsiden.",
                "link" => "https://www.pvv.ntnu.no/galleri/",
                "link_text" => "Se galleriet",
                "image" => "img/gallery.png",
            ],
        ],
    ],
];

$servicesArrayKeys = array_keys($services);
for ($i = 0; $i < count($services); $i++) {
    $servicesKey = $servicesArrayKeys[$i];
    $services[$servicesKey]['bgcolor'] = $colorPalette[$i % count($colorPalette)];
}

?>
<!DOCTYPE html>
<html lang="no">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="stylesheet" href="/css/normalize.css">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/services.css">
  <meta name="theme-color" content="#024" />
  <title>Tjenesteverkstedet</title>
  <style>
    <?php foreach ($services as $categoryId => $category):
      $categoryClass = '.category-' . htmlspecialchars($categoryId);
    ?>
      <?php echo $categoryClass; ?> {
        background: linear-gradient(135deg, <?php echo generateHighlightColor($category['bgcolor']) ?>, <?php echo $category['bgcolor']; ?>);
      }
    <?php endforeach; ?>
  </style>
</head>

<header>Tjenesteverkstedet</header>

<body>
  <nav>
    <?php echo navbar(1, 'tjenester'); ?>
    <?php echo loginbar($sp, $pdo); ?>
  </nav>
  <main>
    <div class="serviceGrid">
      <?php foreach ($services as $categoryId => $category):
        $categoryClass = 'category-' . htmlspecialchars($categoryId);
      ?>

        <div class="baseServiceCard categoryTitleCard <?php echo $categoryClass; ?>">
          <h3 class="categoryTitle">
            <?php echo htmlspecialchars($category['title']); ?>
          </h3>
        </div>

        <?php foreach ($category['services'] as $service): ?>
        <div class="baseServiceCard serviceCard <?php echo $categoryClass; ?>">
          <div class="serviceContent">
            <h3 class="serviceTitle"><?php echo htmlspecialchars($service['name']); ?></h3>
            <p class="serviceDescription"><?php echo htmlspecialchars($service['description']); ?></p>
            <div class="serviceLink">
              <a href="<?php echo htmlspecialchars($service['link']); ?>" target="_blank">
                <?php echo htmlspecialchars($service['link_text']); ?>
              </a>
            </div>
          </div>

          <img class="serviceImage"
               src="<?php echo htmlspecialchars($service['image']); ?>"
               alt="<?php echo htmlspecialchars($service['name']); ?> logo">
        </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </main>
</body>

</html>

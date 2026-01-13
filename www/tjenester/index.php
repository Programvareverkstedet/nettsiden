<?php

namespace pvv\side;

require_once \dirname(__DIR__, 2) . implode(\DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$services = [
    "Versjonskontroll og utvikling" => [
        [
            "name" => "Gitea",
            "description" => "Vår interne git-tjener, åpen for alle medlemmer",
            "link" => "https://git.pvv.ntnu.no",
            "link_text" => "Gå til git.pvv.ntnu.no",
            "image" => "img/gitea.png",
        ],
        [
            "name" => "GitHub",
            "description" => "Våre offentlige kodebrønner, åpent for verden!",
            "link" => "https://github.com/Programvareverkstedet/",
            "link_text" => "Gå til GitHub",
            "image" => "img/github.png",
        ],
    ],
    "Kommunikasjon" => [
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
            "image" => "img/element.png",
        ],
        [
            "name" => "Discord",
            "description" => "Vår hovedkanal, her finner du alt fra ofisielle announcements til memes og driftsdiskusjoner.",
            "link" => "https://discord.gg/WpaHGV8K",
            "link_text" => "Gå til Discord",
            "image" => "img/discord.png",
        ],
        [
            "name" => "Epost",
            "description" => "Som PVV-medlem får du din egen @pvv.ntnu.no-adresse, som kan brukes med alle vanlige epostprotokoller.",
            "link" => "https://www.pvv.ntnu.no/mail/",
            "link_text" => "Gå til Webmail",
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
    "Hosting" => [
        [
            "name" => "Brukernettsider",
            "description" => "Alle brukere får automatisk en egen side for html og php. Denne er offentlig på pvv.ntnu.no/~brukernavn.",
            "link" => "https://wiki.pvv.ntnu.no/wiki/Tjenester/Hjemmesider",
            "link_text" => "Gå til dokumentasjon på wiki",
            "image" => "img/php.png",
        ],
        [
            "name" => "PVV-siden",
            "description" => "Du befinner deg nå på PVV sin offisielle hjemmeside. Den er skrevet i PHP og kjører på en egen server.",
            "link" => "https://git.pvv.ntnu.no/Projects/nettsiden",
            "link_text" => "Se koden på gitea",
            "image" => "../pvv-logo.png",
        ],
        [
            "name" => "Proxmox @blossom",
            "description" => "Blossom er den sterkeste av våre VM-tjenere, her kan du kjøre enten fulle VM-er eller konteinere. Bare Drift har tilgang på disse tjenerne.",
            "link" => "https://blossom.pvv.ntnu.no:8006",
            "link_text" => "Gå til blossom.pvv.ntnu.no",
            "image" => "img/proxmox.png",
        ],
        [
            "name" => "Proxmox @bubbles",
            "description" => "Bubbles er den svakeste av våre VM-tjenere.",
            "link" => "https://bubbles.pvv.ntnu.no:8006",
            "link_text" => "Gå til bubbles.pvv.ntnu.no",
            "image" => "img/proxmox.png",
        ],
        [
            "name" => "Proxmox @buttercup",
            "description" => "Buttercup er en av våre VM-tjenere.",
            "link" => "https://buttercup.pvv.ntnu.no:8006",
            "link_text" => "Gå til buttercup.pvv.ntnu.no",
            "image" => "img/proxmox.png",
        ],
    ],
    "Underholdning" => [
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
            "image" => "img/rss.png",
        ],
        [
            "name" => "Bildegalleri",
            "description" => "PVV har et felles bildegalleri, der alle kan legge relevante bilder, som automatisk blir inkludert på nettsiden.",
            "link" => "https://www.pvv.ntnu.no/galleri/",
            "link_text" => "Se galleriet",
            "image" => "img/gallery.png",
        ],
    ],
]

?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="/favicon.ico">
<link rel="stylesheet" href="/css/normalize.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/services.css">
<meta name="theme-color" content="#024" />
<title>Tjenesteverkstedet</title>

<header>Tjenesteverkstedet</header>

<body>
  <nav>
    <?php echo navbar(1, 'tjenester'); ?>
    <?php echo loginbar($sp, $pdo); ?>
  </nav>
  <main>
    <div class="serviceWrapper">
      <?php foreach ($services as $category => $serviceList): ?>
      <div class="categoryContainer">
        <div class="categoryLabel"><?php echo htmlspecialchars($category); ?></div>
        <div class="categoryContent">
          <?php foreach ($serviceList as $service): ?>
          <div class="service">
            <div class="serviceContent">
              <h2 class="serviceTitle"><?php echo htmlspecialchars($service['name']); ?></h2>
              <p class="serviceDescription"><?php echo htmlspecialchars($service['description']); ?></p>
              <div class="serviceLink"><a href="<?php echo htmlspecialchars($service['link']); ?>" target="_blank"><?php echo htmlspecialchars($service['link_text']); ?></a></div>
            </div>
            <img class="serviceImage" src="<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['name']); ?>-logo">
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </main>
</body>

</html>

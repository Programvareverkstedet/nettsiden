<?php

namespace pvv\side;

require_once \dirname(__DIR__, 2) . implode(\DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$services = [
    "vcs" => [
        "title" => "Versjonskontroll og utvikling",
        "services" => [
        [
            "name" => "Gitea",
            "description" => "Vår interne git-tjener, åpen for alle medlemmer. Kommer med CI/CD, nettside-artefakter, pakke-register og mye mer.",
            "link" => "https://git.pvv.ntnu.no",
            "link_text" => "Gå til git.pvv.ntnu.no",
            "image" => "img/gitea.svg",
        ],
        [
            "name" => "GitHub",
            "description" => "Speiling av våre mest interessante prosjekter på GitHub",
            "link" => "https://github.com/Programvareverkstedet/",
            "link_text" => "Gå til GitHub",
            "image" => "img/github.svg",
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
                "description" => "Vår hovedkanal, her finner du alt fra offisielle announcements til memes og driftsdiskusjoner.",
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
                "name" => "Brukerdatabaser",
                "description" => "PVV har en MariaDB server som er tilgjengelig for bruk av alle medlemmer, gjennom et spesielt administatorverktøy.",
                "link" => "https://git.pvv.ntnu.no/Projects/muscl",
                "link_text" => "Se prosjektsiden til administatorverktøyet",
                "image" => "img/database.svg",
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
    "physical" => [
        "title" => "Fysiske tjenester",
        "services" => [
            [
                "name" => "Dibbler",
                "description" => "PVV har en liten kiosk-datamaskin som lar deg kjøpe godis og pølser, drevet av PVVVV-samlespleisegruppa.",
                "link" => "https://wiki.pvv.ntnu.no/wiki/Tjenester/Dibbler",
                "link_text" => "Se dokumentasjon på wiki",
                "image" => "img/dibbler.png",
            ],
            // [
            //     "name" => "Worblehat",
            //     "description" => "Bibliotekssystemet vårt, som lar deg finne og låne bøker i PVVs bibliotek.",
            //     "link" => "https://wiki.pvv.ntnu.no/wiki/Tjenester/Worblehat",
            //     "link_text" => "Se dokumentasjon på wiki",
            //     "image" => "img/worblehat.png",
            // ],
            [
                "name" => "Grzegorz",
                "description" => "Grzegorz er en musikkspiller, den spiller mye dank. Du kan styre den med vevgrensesnitt og diverse API-er.",
                "link" => "https://georg.pvv.ntnu.no",
                "link_text" => "Gå til Georg's vevgrensesnitt",
                "image" => "img/grzegorz.png",
            ],
            [
                "name" => "Dørbjelle",
                "description" => "PVVs dørbjelle er koblet til internett, og lar deg ringe på hvis du spør botten pent på Discord eller Matrix",
                "link" => "https://wiki.pvv.ntnu.no/wiki/Tjenester/D%C3%B8rbjelle",
                "link_text" => "Se dokumentasjon på wiki",
                "image" => "img/doorbell.png",
            ],
            [
                "name" => "Terminaler",
                "description" => "PVV har flere terminaler plassert på terminalrommet; her kan du logge inn med PVV-brukeren din og gjøre øvinger eller lære om Linux.",
                "link" => "https://wiki.pvv.ntnu.no/wiki/Tjenester/Terminaler",
                "link_text" => "Se dokumentasjon på wiki",
                "image" => "img/terminal.png",
            ],
        ],
    ],
    "other" => [
        "title" => "Annet",
        "services" => [
            [
                "name" => "Minecraft",
                "description" => "Vi har en egen Minecraft-server for medlemmer, som du kan koble til med IP-adressen minecraft.pvv.ntnu.no. Spør om whitelist på matrix/discord.",
                "link" => "https://minecraft.pvv.ntnu.no",
                "link_text" => "Gå til verdenskartet vårt",
                "image" => "img/minecraft.png",
            ],
            [
                "name" => "Mapcrafter",
                "description" => "Det finnes enda et verdenskart for minecraft, mapcrafter. Her kan du se verdenskartet fra en mer isometrisk vinkel.",
                "link" => "http://isvegg.pvv.ntnu.no/kart",
                "link_text" => "Gå til det andre verdenskartet vårt",
                "image" => "img/mapcrafter.webp",
            ],
            // [
            //     "name" => "MiniFlux RSS reader",
            //     "description" => "Trenger du en cross-platform RSS/Atom-leser for å følge med på omverdenen som det er 1990? ",
            //     "link" => "https://feeds.pvv.ntnu.no",
            //     "link_text" => "Gå til MiniFlux",
            //     "image" => "img/rss.svg",
            // ],
            [
                "name" => "Bildegalleri",
                "description" => "PVV har et felles bildegalleri, der alle kan legge relevante bilder, som automatisk blir inkludert på nettsiden.",
                "link" => "https://www.pvv.ntnu.no/galleri/",
                "link_text" => "Se galleriet",
                "image" => "img/gallery.png",
            ],
	    [
                "name" => "Vaultwarden",
                "description" => implode(
                    " ",
		    [
                      "PVV har en passordlagringstjeneste, hvor medlemmer kan lagre passordene sine, og drift kan dele passord mellom seg.",
                      "Passordene blir kryptert og dekryptert på klientsiden, så det er ikke mulig for drift å snoke rundt i passordene dine."
                    ],
                ),
                "link" => "https://pw.pvv.ntnu.no/",
                "link_text" => "Gå til vevgrensesnittet",
                "image" => "img/vaultwarden.svg",
            ],
        ],
    ],
];

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
  </head>

  <body>
    <header>Tjenesteverkstedet</header>

    <nav>
      <?php echo navbar(1, 'tjenester'); ?>
      <?php echo loginbar($sp, $pdo); ?>
    </nav>

    <main>
      <div class="serviceWrapper">
        <?php foreach ($services as $categoryName => $category): ?>
        <div class="categoryContainer">
          <div class="categoryLabel"><?php echo htmlspecialchars($category['title']); ?></div>
          <div class="categoryContent">
            <?php foreach ($category['services'] as $service): ?>
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

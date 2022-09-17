<?php namespace pvv\side;
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/services.css">
<meta name="theme-color" content="#024" />
<title>Tjenesteverkstedet</title>

<header>Tjenesteverkstedet</header>

<body>
        <nav>
                <?= navbar(1, 'tjenester'); ?>
                <?= loginbar($sp, $pdo); ?>
        </nav>
        <main>

          <div class="categoryContainer">
            <div class="categoryLabel">Versjonskontroll og utvikling</div>
            <div class="categoryContent">

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">GitHub</h2>
                  <p class="serviceDescription">Våre offentlige kodebrønner, åpent for verden!</p>
                  <div class="serviceLink"><a href="https://github.com/Programvareverkstedet/" target="_blank">Gå til GitHub</a></div>
                </div>
                <img class="serviceImage" src="img/github.png" alt="GitHub-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Gogs</h2>
                  <p class="serviceDescription">Vår interne git-tjener, åpen for alle medlemmer</p>
                  <div class="serviceLink"><a href="https://git.pvv.ntnu.no" target="_blank">Gå til git.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/gogs.png" alt="Gogs-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Dev og Trac</h2>
                  <p class="serviceDescription">Trac er vårt gamle prosjektsystem. Her kan du lage og dele prosjekter om du er for hipster for github.</p>
                  <div class="serviceLink"><a href="https://dev.pvv.ntnu.no/projects/pvv-dev/" target="_blank">Gå til dev.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/trac.png" alt="Trac-logo">
              </div>

            </div>
          </div>

          <div class="categoryContainer">
            <div class="categoryLabel">Kommunikasjon</div>
            <div class="categoryContent">

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Matrix via Element</h2>
                  <p class="serviceDescription">Åpen kommunikasjonsprotokoll som støtter ende-til-ende-kryptering og utallige kule funksjoner. Vårt space er bridget sammen med Discord, så du får alle de samme meldingene. <b>#pvv:pvv.ntnu.no</b></p>
                  <div class="serviceLink">
                    <a href="https://chat.pvv.ntnu.no" target="_blank">Gå til chat.pvv.ntnu.no(medlem)</a>
                    <a href="https://matrix.to/#/#pvv:pvv.ntnu.no" target="_blank">Gå til #pvv:pvv.ntnu.no(offentlig)</a>
                  </div>
                </div>
                <img class="serviceImage" src="img/element.png" alt="Element-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Discord</h2>
                  <p class="serviceDescription">Vår hovedkanal, her finner du alt fra ofisielle announcements til memes og driftsdiskusjoner.</p>
                  <div class="serviceLink"><a href="https://discord.gg/WpaHGV8K" target="_blank">Gå til Discord</a></div>
                </div>
                <img class="serviceImage" src="img/discord.png" alt="Discord-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Epost</h2>
                  <p class="serviceDescription">Som PVV-medlem får du din egen @pvv.ntnu.no-adresse, som kan brukes med alle vanlige epostprotokoller.</p>
                  <div class="serviceLink">
                    <a href="https://www.pvv.ntnu.no/mail/" target="_blank">Gå til Webmail</a>
                    <a href="https://www.pvv.ntnu.no/pvv/Drift/Mail/IMAP_POP3/" target="_blank">IMAP/POP/SMTP-innstillinger</a>
                  </div>
                </div>
                <img class="serviceImage" src="img/email.png" alt="Epost-ikon">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">IRC</h2>
                  <p class="serviceDescription">Hvis Discord er for proprietært og Matrix er for hypermoderne er kanskje IRC for deg. Vi har en kanal på IRCNet, <b>#pvv</b>.</p>
                  <div class="serviceLink"><a href="irc://irc.pvv.ntnu.no/pvv" target="_blank">Koble til med IRC</a></div>
                </div>
                <img class="serviceImage" src="img/irc.png" alt="IRC-ikon">
              </div>

            </div>
          </div>


          <div class="categoryContainer">
            <div class="categoryLabel">Virtualisering</div>
            <div class="categoryContent">

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Proxmox @joshua</h2>
                  <p class="serviceDescription">Joshua er en av våre VM-tjenere, her kan du kjøre enten fulle VM-er eller konteinere.</p>
                  <div class="serviceLink"><a href="https://joshua.pvv.ntnu.no:8006" target="_blank">Gå til joshua.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/proxmox.png" alt="Proxmox-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Proxmox @andresbu</h2>
                  <p class="serviceDescription">Andresbu er en kraftigere VM-tjener, men har fortsatt en del rusk i maskineriet. Brukes på eget ansvar.</p>
                  <div class="serviceLink"><a href="https://andresbu.pvv.ntnu.no:8006" target="_blank">Gå til andresbu.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/proxmox.png" alt="Proxmox-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">ESXI @asgore</h2>
                  <p class="serviceDescription">Asgore er vår eldste og største VM-tjener, og kjører ESXI.</p>
                  <div class="serviceLink"><a href="https://asgore.pvv.ntnu.no" target="_blank">Gå til asgore.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/esxi.png" alt="ESXI-logo">
              </div>

            </div>
          </div>

          <div class="categoryContainer">
            <div class="categoryLabel">Underholdning</div>
            <div class="categoryContent">

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Minecraft</h2>
                  <p class="serviceDescription">Vi har en egen Minecraft-server <b>for medlemmer</b>, som du kan koble til med IP-adressen <b>minecraft.pvv.ntnu.no</b>. Spør om whitelist på matrix/discord.</p>
                  <div class="serviceLink"><a href="https://minecraft.pvv.ntnu.no" target="_blank">Gå til verdenskartet vårt</a></div>
                </div>
                <img class="serviceImage" src="img/minecraft.png" alt="Minecraft-logo">
              </div>

              <!-- Bokhylle /brzeczyszczykiewicz ? -->              

            </div>
          </div>
      </main>
</body>

</html>

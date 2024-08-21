<?php namespace pvv\side;
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
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
                <?= navbar(1, 'tjenester'); ?>
                <?= loginbar($sp, $pdo); ?>
        </nav>
        <main>

        <div class="serviceWrapper">

          <div class="categoryContainer">
            <div class="categoryLabel">Versjonskontroll og utvikling</div>
            <div class="categoryContent">

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Gitea</h2>
                  <p class="serviceDescription">Vår interne git-tjener, åpen for alle medlemmer</p>
                  <div class="serviceLink"><a href="https://git.pvv.ntnu.no" target="_blank">Gå til git.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/gitea.png" alt="Gitea-logo">
              </div>

	      <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">GitHub</h2>
                  <p class="serviceDescription">Våre offentlige kodebrønner, åpent for verden!</p>
                  <div class="serviceLink"><a href="https://github.com/Programvareverkstedet/" target="_blank">Gå til GitHub</a></div>
                </div>
                <img class="serviceImage" src="img/github.png" alt="GitHub-logo">
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
                  </div>
                  <div class="serviceLink">
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
                  </div>
                  <div class="serviceLink">
                    <a href="https://wiki.pvv.ntnu.no/wiki/Drift/Mail/IMAP_POP3" target="_blank">IMAP/POP/SMTP-innstillinger</a>
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
            <div class="categoryLabel">Hosting</div>
            <div class="categoryContent">

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Brukernettsider</h2>
                  <p class="serviceDescription">Alle brukere får automatisk en egen side for html og php. Denne er offentlig på pvv.ntnu.no/~brukernavn.</p>
                  <div class="serviceLink"><a href="https://wiki.pvv.ntnu.no/wiki/Tjenester/Hjemmesider" target="_blank">Gå til dokumentasjon på wiki</a></div>
                </div>
                <img class="serviceImage" src="img/php.png" alt="En elephpant">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">PVV-siden</h2>
                  <p class="serviceDescription">Du befinner deg nå på PVV sin offisielle hjemmeside. Den er skrevet i PHP og kjører på en egen server.</p>
                  <div class="serviceLink"><a href="https://git.pvv.ntnu.no/Projects/nettsiden" target="_blank">Se koden på gitea</a></div>
                </div>
                <img class="serviceImage" src="../pvv-logo.png" alt="PVV-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Proxmox @joshua</h2>
                  <p class="serviceDescription">Joshua er en av våre VM-tjenere, her kan du kjøre enten fulle VM-er eller konteinere. Bare Drift har tilgang på disse tjenerne.</p>
                  <div class="serviceLink"><a href="https://joshua.pvv.ntnu.no:8006" target="_blank">Gå til joshua.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/proxmox.png" alt="Proxmox-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Proxmox @andresbu</h2>
                  <p class="serviceDescription">Andresbu er en kraftigere VM-tjener, men har fortsatt en del rusk i maskineriet.</p>
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
                  <div class="serviceLink"><a href="https://isvegg.pvv.ntnu.no/kart/" target="_blank">Gå til verdenskartet vårt</a></div>
                </div>
                <img class="serviceImage" src="img/minecraft.png" alt="Minecraft-logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">MiniFlux RSS reader</h2>
                  <p class="serviceDescription">Trenger du en cross-platform RSS/Atom-leser for å følge med på omverdenen som det er 1990? </p>
                  <div class="serviceLink"><a href="https://feeds.pvv.ntnu.no" target="_blank">Gå til MiniFlux</a></div>
                </div>
                <img class="serviceImage" src="img/rss.png" alt="RSS-Ikon">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Bildegalleri</h2>
                  <p class="serviceDescription">PVV har et felles bildegalleri, der alle kan legge relevante bilder, som automatisk blir inkludert på nettsiden.</p>
                  <div class="serviceLink">
                    <a href="https://www.pvv.ntnu.no/galleri/" target="_blank">Se galleriet</a>
                  </div>
                  <div class="serviceLink">
                    <a href="https://wiki.pvv.ntnu.no/wiki/Bildedeling" target="_blank">Opplasting</a>
                  </div>
                </div>
                <img class="serviceImage" src="img/gallery.png" alt="RSS-Ikon">
              </div>

              <!-- Bokhylle /brzeczyszczykiewicz ? -->              

            </div>
          </div>
        </div>
      </main>
</body>

</html>

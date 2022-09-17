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
                <img class="serviceImage" src="img/github.png" alt="GitHub logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Gogs</h2>
                  <p class="serviceDescription">Vår interne git-tjener, åpen for alle medlemmer</p>
                  <div class="serviceLink"><a href="https://git.pvv.ntnu.no" target="_blank">Gå til git.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/gogs.png" alt="Gogs logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Dev og Trac</h2>
                  <p class="serviceDescription">Trac er vårt gamle prosjektsystem. Her kan du lage og dele prosjekter om du er for hipster for github.</p>
                  <div class="serviceLink"><a href="https://dev.pvv.ntnu.no/projects/pvv-dev/" target="_blank">Gå til dev.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/trac.png" alt="Trac logo">
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
                  <div class="serviceLink"><a href="https://chat.pvv.ntnu.no" target="_blank">Gå til chat.pvv.ntnu.no</a></div>
                </div>
                <img class="serviceImage" src="img/element.png" alt="Element logo">
              </div>

              <div class="service">
                <div class="serviceContent">
                  <h2 class="serviceTitle">Discord</h2>
                  <p class="serviceDescription">Vår hovedkanal, her finner du alt fra ofisielle announcements til memes og driftsdiskusjoner.</p>
                  <div class="serviceLink"><a href="https://discord.gg/WpaHGV8K" target="_blank">Gå til Discord</a></div>
                </div>
                <img class="serviceImage" src="img/discord.png" alt="Discord logo">
              </div>
        
            </div>
          </div>
      </main>
</body>

</html>

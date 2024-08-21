<?php 
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
?>
<!DOCTYPE html>
<html lang="no">
  <head>
    <style>
      p {hyphens: auto;}
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/webmail.css">
    <meta name="theme-color" content="#024" />
    <title>Mailverkstedet</title>
  </head>
  <body>
    <header>Mail&shy;verk&shy;stedet</header>

    <main>
      <h2>Bruk en av våre webmail-klienter</h2>
      <ul id="webmail">
        <li id="roundcube"><div><a href="https://webmail.pvv.ntnu.no/roundcube/"><span class="mailname">Roundcube</span></a>
        <li id="snappymail"><div><a href="https://snappymail.pvv.ntnu.no/"><span class="mailname">SnappyMail</span></a>
      </ul>

      <h2>Eller bruk en lokal e-postklient</h2>
      <div id="lokalmail">
        Informasjon om oppsett og bruk av e-post finner du på <a href="https://wiki.pvv.ntnu.no/wiki/Drift/Mail">wiki-en vår</a>.
        <br>
        Du kan for eksempel bruke en grafisk klient som <a href="https://www.thunderbird.net/">Thunderbird</a>, eller en terminaldrevet klient som <a href="https://neomutt.org/">(neo)</a><a href="http://www.mutt.org/">mutt</a>, <a href="https://aerc-mail.org/">aerc</a> eller <a href="https://alpineapp.email/">alpine</a>.
      </div>
    </main>

    <nav>
      <?= navbar(1, "mail"); ?>
      <?= loginbar($sp, $pdo); ?>
    </nav>
  </body>
</html>


# Programvareverkstedets nettside

A website created with the latest and greatest web technologies.
May contain blackjack and other things one tends to include in awesome projects.

## Installation

    git clone --recursive https://github.com/Programvareverkstedet/nettsiden.git

Put it in a folder your webserver can find.

## Development setup

The development environment can be setup with:

    nix develop

For this you will need to install the nix package manager and possibly set the experimental features in your nix config, likely located at /etc/nix/nix.conf or $HOME/.config/nix/nix.conf.

Installing nix with your package manager might not work without some tweaking, but the upstream script should just work which you can find [here](https://nixos.org/download/).

    experimental-features = flakes nix-command

You can then run the server with:

    runDev

### Admin account

Login goes through `idp.pvv.ntnu.no` via SAML, so you have to use your PVV account.
(This only works if you use access the local development site via the the hostname `localhost`)
To make your account into an admin account, run:

    sqlite3 pvv.sqlite "INSERT INTO users (uname, groups) VALUES ('YOUR_USERNAME', 1);"

## Hosting

![](./.gitea/hosting.jpg)

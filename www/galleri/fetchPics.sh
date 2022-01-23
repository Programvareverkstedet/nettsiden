#!/usr/bin/env bash
outfolder="bilder/pvv-photos"
folders=$(find /home/pvv -maxdepth 3 -name 'pvv-photos' 2>/dev/null)

for imgfolder in $folders; do
    user=$(echo $imgfolder | cut -d "/" -f5)
    destination="$outfolder/$user"
    mkdir -p $destination
    rsync -rvz --delete "$imgfolder/" "$destination"
done
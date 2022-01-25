#!/usr/bin/env bash
outfolder="bilder/pvv-photos"
folders=$(ssh pvv@microbel.pvv.ntnu.no -i /home/pvv/c/pvv/.ssh/photofetcher 'find /home/pvv -maxdepth 3 -name "pvv-photos" 2>/dev/null')
unamefile="usernames.txt"
> $unamefile # Empty the file

for imgfolder in $folders; do
    user=$(echo $imgfolder | cut -d "/" -f5)
    realname="$(getent passwd $user | cut -d ':' -f 5)"
    echo "$user:$realname" >> $unamefile
    destination="$outfolder/$user"
    mkdir -p $destination
    rsync -rtvz --delete "$imgfolder/" "$destination" # Copy and keep timestamps
done
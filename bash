#!/bin/bash

directory="/home/gwgtelecomcom/public_html/" 
publicHtmlPermission="0555"
indexFile="$directory/index.php"
indexFilePermission="0444"

check_and_fix_permissions() {
    path=$1
    expectedPermission=$2

    if [ ! -e "$path" ]; then
        echo "[]: $path "
        return 1
    fi

    currentPermission=$(stat -c "%a" "$path")

    if [ "$currentPermission" != "$expectedPermission" ]; then
        chmod "$expectedPermission" "$path"
        echo "$path ke $expectedPermission"
    fi
}

while true; do
    check_and_fix_permissions "$directory" "$publicHtmlPermission"
    check_and_fix_permissions "$indexFile" "$indexFilePermission"

    sleep 0.1
done

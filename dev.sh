#!/bin/sh

DIR="$(cd "$(dirname "$0")" && pwd)"

docker rm -f dropzonedemo
docker run --name=dropzonedemo -d -p 9181:80 \
    -v $DIR/uploads:/var/www/uploads \
    -v $DIR/www:/var/www/html \
    dropzone

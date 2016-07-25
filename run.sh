#!/bin/sh

DIR="$(cd "$(dirname "$0")" && pwd)"

docker build -t dropzone .

docker rm -f dropzonedemo
docker run --name=dropzonedemo -d -p 9181:80 \
    -v $DIR/uploads:/var/www/uploads \
    dropzone

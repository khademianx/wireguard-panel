#!/bin/bash

docker info >/dev/null 2>&1

# Ensure that Docker is running...
if [ $? -ne 0 ]; then
    echo "Docker is not running."

    curl -fsSL https://get.docker.com | sh
fi

cd /opt/wireguard &&
    docker compose pull &&
    docker compose down &&
    docker compose up -d

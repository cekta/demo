#!/usr/bin/env bash

cd docker || exit 1
docker-compose -f docker-compose.yml build
docker-compose -f docker-compose.yml push

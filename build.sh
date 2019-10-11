#!/usr/bin/env bash

cd build || exit 1
docker-compose build
docker-compose push

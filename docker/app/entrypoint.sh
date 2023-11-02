#!/usr/bin/env sh

composer install
./app migrate -i


if [ $# == 0 ]; then
  set -- php -S 0.0.0.0:8080 -t public "$@"
fi

echo
echo "Running $@"
echo

exec "$@"
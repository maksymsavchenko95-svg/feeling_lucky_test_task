#!/bin/sh
set -e

[ -f .env ] || cp .env.example .env
composer install --no-interaction --no-progress
grep -q '^APP_KEY=..*' .env || php artisan key:generate
php artisan migrate --force

exec docker-php-entrypoint "$@"

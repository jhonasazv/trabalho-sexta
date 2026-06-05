#!/bin/sh
set -e

cd /var/www

# create .env if missing
if [ ! -f .env ]; then
    cp .env.example .env
fi

# generate app key if missing
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# clear config cache (optional but useful)
php artisan config:clear || true

# start Laravel dev server
php artisan serve --host=0.0.0.0 --port=8000
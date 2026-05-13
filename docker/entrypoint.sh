#!/bin/bash
set -e

echo "================================================"
echo " estithmarcom-ksa API Starting..."
echo "================================================"

cd /var/www/html

echo "[1/4] Running migrations..."
su -s /bin/bash www-data -c "php artisan migrate --force"

echo "[2/4] Creating storage link..."
su -s /bin/bash www-data -c "php artisan storage:link --force"

echo "[3/4] Clearing & caching config..."
su -s /bin/bash www-data -c "php artisan optimize:clear"
su -s /bin/bash www-data -c "php artisan config:cache"
su -s /bin/bash www-data -c "php artisan route:cache"

echo "[4/4] Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf

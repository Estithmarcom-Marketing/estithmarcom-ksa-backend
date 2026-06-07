#!/bin/bash
set -e

echo "================================================"
echo " estithmarcom-ksa API Starting..."
echo "================================================"

cd /var/www/html

echo "[1/5] Running migrations..."
su -s /bin/bash www-data -c "php artisan migrate --force"

echo "[2/5] Creating storage link..."
su -s /bin/bash www-data -c "php artisan storage:link --force"

echo "[3/5] Publishing log-viewer assets..."
su -s /bin/bash www-data -c "php artisan vendor:publish --tag=log-viewer-assets --force"
# Assets in storage kopieren damit Nginx sie über das storage Volume lesen kann
cp -r /var/www/html/public/vendor /var/www/html/storage/app/public/

echo "[4/5] Clearing & caching config..."
su -s /bin/bash www-data -c "php artisan optimize:clear"
su -s /bin/bash www-data -c "php artisan config:cache"
su -s /bin/bash www-data -c "php artisan route:cache"

echo "[5/5] Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf

#!/bin/sh
echo "Run Migration & Seeder"
php artisan migrate --force

echo "Run Migration & Seeder"
php artisan wireguard:key

echo "App install was successful"

/usr/bin/supervisord  -c "/etc/supervisor/conf.d/supervisord.conf"

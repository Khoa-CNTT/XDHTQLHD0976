web: php -S 0.0.0.0:$PORT -t public
release: composer install && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
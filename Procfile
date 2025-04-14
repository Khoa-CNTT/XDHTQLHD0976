web: vendor/bin/heroku-php-nginx public/
release: 
  php artisan migrate --force && 
  php artisan optimize && 
  php artisan cache:clear
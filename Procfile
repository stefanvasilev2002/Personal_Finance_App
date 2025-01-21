web: vendor/bin/heroku-php-apache2 public/
release: mkdir -p storage/app/public && mkdir -p public/storage && cp -r storage/app/public/* public/storage/ && php artisan config:cache && php artisan view:cache && php artisan migrate --force && npm install && npm run build

web: vendor/bin/heroku-php-apache2 public/
release: mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs public/storage && php artisan config:cache && php artisan view:cache && php artisan migrate --force && npm install && npm run build

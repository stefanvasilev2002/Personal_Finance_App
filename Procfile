web: vendor/bin/heroku-php-apache2 public/
release: mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs public/storage && php artisan config:clear && php artisan view:clear && php artisan cache:clear && php artisan config:cache && php artisan view:cache && php artisan optimize:clear && npm ci --production=false && npm run build

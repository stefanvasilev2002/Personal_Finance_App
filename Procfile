web: vendor/bin/heroku-php-apache2 public/
release: mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs public/storage resources/views && php artisan config:cache && php artisan view:cache && php artisan route:cache && npm ci --production=false && npm run build

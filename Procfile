web: vendor/bin/heroku-php-apache2 public/
release: mkdir -p public/storage && php artisan storage:link && php artisan config:cache && php artisan migrate --force && npm install && npm run build

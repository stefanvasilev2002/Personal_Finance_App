web: vendor/bin/heroku-php-apache2 public/
release: php artisan storage:link && php artisan migrate --force && npm install && npm run build

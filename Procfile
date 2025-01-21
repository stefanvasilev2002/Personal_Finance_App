web: vendor/bin/heroku-php-apache2 public/
release: mkdir -p storage/framework/{sessions,views,cache} && cp -r /tmp/build_*/resources/views/* /app/resources/views/ && php artisan config:cache && php artisan view:cache && npm ci --production=false && npm run build

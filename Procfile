web: vendor/bin/heroku-php-apache2 public/
release: mkdir -p /app/resources/views && cp -r resources/views/* /app/resources/views/ && mkdir -p storage/framework/{sessions,views,cache} && php artisan view:cache && npm ci --production=false && npm run build

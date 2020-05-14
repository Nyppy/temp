FROM php:7.2-fpm-alpine

COPY . /var/www

WORKDIR /var/www

RUN apk —no-cache add \
postgresql-dev \
freetype-dev \
libpng-dev libjpeg-turbo \
libmcrypt-dev \
jpeg-dev \
libjpeg libjpeg-turbo-dev \
git sudo \
curl curl-dev \
bash \
jpegoptim \
optipng \
pngquant \
gifsicle \
gettext-dev icu-dev

RUN chown -R www-data:www-data \
/var/www/storage
# /var/www/bootstrap/cache

# Install composer
RUN curl -sS https://getcomposer.org/installer | php — \
—filename=composer \
—install-dir=/usr/local/bin && \
echo "alias composer='composer'" » /root/.bashrc && \
composer update

# RUN php artisan optimize
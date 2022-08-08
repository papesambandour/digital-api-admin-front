FROM tangramor/nginx-php8-fpm
#FROM php:8.0.2-apache-buster
# copy source code
COPY . /var/www/html
ENV TZ Africa/Dakar
# China php composer mirror: https://mirrors.cloud.tencent.com/composer/
ENV COMPOSERMIRROR="https://mirrors.cloud.tencent.com/composer/"
# China npm mirror: https://registry.npm.taobao.org
ENV NPMMIRROR="https://registry.npm.taobao.org"
# start.sh will replace default web root from /var/www/html to $WEBROOT
ENV WEBROOT /var/www/html/public
# start.sh will create laravel storage folder structure if $CREATE_LARAVEL_STORAGE = 1
ENV CREATE_LARAVEL_STORAGE "1"

WORKDIR /var/www/html
RUN composer install --ignore-platform-reqs
RUN chown -Rf www-data.www-data /var/www/html

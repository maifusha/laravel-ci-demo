FROM git.maifusha.com:5005/docker/nginx-phpfpm:latest

MAINTAINER LiXin "1045909037@qq.com"

COPY supervisor.ini /etc/supervisor/conf.d/supervisor.ini

COPY . /var/www/html

RUN composer install --no-dev --prefer-dist --optimize-autoloader --quiet \
    && cnpm install && npm run production

RUN chown -R www-data:www-data /var/www/html

VOLUME /var/www/html/storage

HEALTHCHECK --interval=5s --timeout=3s \
  CMD curl --fail http://localhost/ || exit 1

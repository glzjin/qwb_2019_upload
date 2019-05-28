FROM ctftraining/base_image_nginx_mysql_php_73

LABEL Author="glzjin <i@zhaoj.in>" Blog="https://www.zhaoj.in"

COPY ./files /tmp/

RUN cp -rf /tmp/html /var/www/ \
    && cp -f /tmp/nginx.conf /etc/nginx/nginx.conf \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/public/upload \
    && sed -i 's/skip-network/#skip-network/' /etc/my.cnf.d/mariadb-server.cnf

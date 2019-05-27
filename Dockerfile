FROM ctftraining/base_image_nginx_mysql_php_73

LABEL Author="glzjin <i@zhaoj.in>"
LABEL Blog="https://www.zhaoj.in"

ENV FLAG "flag{glzjin_wants_a_girl_friend}"

COPY files/html /var/www/html
COPY files/nginx.conf /etc/nginx/nginx.conf
COPY ./files/flag.sh /flag.sh
RUN chown -R www-data:www-data /var/www/html \
    && sed -i 's/skip-network/#skip-network/' /etc/my.cnf.d/mariadb-server.cnf

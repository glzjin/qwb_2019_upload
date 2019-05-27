FROM phusion/baseimage

LABEL Author="glzjin <i@zhaoj.in>"
LABEL Blog="https://www.zhaoj.in"

COPY files /tmp/

RUN sed -i "s/http:\/\/archive.ubuntu.com/http:\/\/mirrors.163.com/g" /etc/apt/sources.list \
    && apt update \
    && apt install apache2 -y \
    && debconf-set-selections /tmp/mysql-passwd && apt install mysql-server -y \
    && apt install php libapache2-mod-php php-mcrypt php-mysql php-gd -y \
    && chmod u+x /tmp/init_db.sh \
    && /tmp/init_db.sh \
    && rm -f /var/www/html/index.html \
    && cp -rf /tmp/html /var/www/ \
    && chown -R www-data:www-data /var/www/html/ \
    && cp -f /tmp/000-default.conf /etc/apache2/sites-enabled/ \
    && cp -f /tmp/apache2.conf /etc/apache2/ \
    && ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/ \
    && echo 'flag{glzjin_wants_a_girl_friend}' > /flag \
    && cp /tmp/start.sh /etc/my_init.d/ \
    && chmod u+x /etc/my_init.d/start.sh \
    && rm -rf /tmp/*

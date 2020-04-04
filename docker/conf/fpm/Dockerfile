FROM php:fpm

RUN apt-get update && \
    apt-get install -y libldap2-dev wget && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv ./composer.phar /usr/local/bin/composer 

CMD ["php-fpm"]
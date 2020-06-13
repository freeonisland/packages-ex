FROM php:7.4-fpm

# apt-get
RUN apt-get update && apt-get install -y wget git zip

#clean
RUN rm -rf /var/lib/apt/lists/* 

#composer
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv ./composer.phar /usr/local/bin/composer 

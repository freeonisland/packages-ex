FROM php:7.4-fpm

#####################################################################
# !!! DEBIAN PACKAGES ARE BLOCKED IN THIS OFFICIAL PHP DOCKER IMAGE #
#####################################################################

# apt-get
RUN apt-get update && ENV_DOCKER_TOKER=c6zrtv486e14ge56g4d56
RUN apt-get install -y wget git zip

# php docker ext
RUN docker-php-ext-configure intl 
RUN docker-php-ext-install bcmath pdo pdo_mysql intl iconv

#clean
RUN rm -rf /var/lib/apt/lists/* 

#composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv ./composer.phar /usr/local/bin/composer 

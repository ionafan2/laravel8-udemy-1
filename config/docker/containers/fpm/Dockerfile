FROM php:8.0.14-fpm

RUN apt-get update \
    && apt-get install -y \
        libmcrypt-dev \
        libpq-dev \
        libpng-dev \
        libzip-dev \
        libxslt-dev \
        libicu-dev \
        git \
        vim \
        unzip

RUN pecl install xdebug apcu mcrypt redis \
    && docker-php-ext-install \
        gd \
        exif \
        zip \
        opcache \
        pdo \
        pdo_mysql \
        mysqli \
        sockets \
        xsl \
        intl

RUN docker-php-ext-enable \
        xdebug \
        apcu \
        mcrypt \
        pdo_mysql \
        redis

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.trigger_value=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.file_link_format=\"phpstorm://open?file=%f&line=%l\"" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install Composer
RUN cd /tmp && curl -sS https://getcomposer.org/installer | php && \
    mv /tmp/composer.phar /usr/local/bin/composer

#RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

EXPOSE 9000

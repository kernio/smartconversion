FROM php:7.3-fpm

RUN apt-get update -y
RUN echo "deb http://ftp.de.debian.org/debian stretch main" >> /etc/apt/sources.list
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y libpq-dev libxml2-dev
RUN apt-get install -y zlib1g-dev libzip-dev
RUN apt-get install -y libpng-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-install gd

# Install Dependencies
RUN apt-get update -yqq \
&& ACCEPT_EULA=Y apt-get install -y locales \
&& echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
&& echo "de_DE.UTF-8 UTF-8" > /etc/locale.gen \
&& locale-gen

RUN curl -s -f -L -o /tmp/installer.php https://getcomposer.org/installer && \
    php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer && \
    composer --ansi --version  --no-interaction

COPY ./php_ext.ini /usr/local/etc/php/conf.d/
COPY ./www.conf /usr/local/etc/php-fpm.d/

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog && \
    rm -rf /tmp/pear

RUN usermod -u 1000 www-data

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000



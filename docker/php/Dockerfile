FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    cron \
    libonig-dev \
    libxml2-dev \
    libgmp-dev \
    supervisor \
    zip \
    unzip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug


#Install supervisor
#RUN apt-get install -y supervisor
#COPY ./docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
#CMD ["/usr/bin/supervisord"]

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd gmp
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

WORKDIR /var/www/html
# Куда же без composer'а.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/html



# Add docker custom crontab
ADD ./docker/php/laravel_docker_crontab /etc/cron.d/laravel_docker_crontab

# Specify crontab file for running
RUN crontab /etc/cron.d/laravel_docker_crontab
RUN chmod 0600 /etc/cron.d/laravel_docker_crontab
RUN touch /var/log/cron.log

# execute crontab
#CMD ["cron", "-f"]
#CMD service cron start
COPY ./docker/php/supervisord.conf /etc/supervisor
COPY ./docker/php/conf.d/* /etc/supervisor/conf.d

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]



#CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]


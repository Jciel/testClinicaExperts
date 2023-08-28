FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod headers
RUN a2enmod remoteip

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
		zlib1g-dev \
        libonig-dev \
		libzip-dev \
		unzip \
		libpng-dev \
		libpq-dev \
		libxml2-dev \
		openssl \
        cron \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
	&& docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql session xml mbstring

# Copie o arquivo cronjob para o contêiner
COPY ./Docker/cronjob /etc/cron.d/cronjob
RUN chmod 0644 /etc/cron.d/cronjob
RUN crontab /etc/cron.d/cronjob

COPY . .

RUN chmod -R 777 /var/www/html/storage/logs/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-interaction

CMD ["apache2-foreground"]


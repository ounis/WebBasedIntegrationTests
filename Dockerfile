FROM php:apache as base
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update \
     && apt-get install -y libzip-dev wget unzip \
     && docker-php-ext-install zip

COPY ./ /app
WORKDIR /app

ARG scriptaculous=scriptaculous-js-1.9.0

RUN wget https://script.aculo.us/dist/${scriptaculous}.zip -O /tmp/scriptaculous.zip

RUN unzip /tmp/scriptaculous.zip -d /tmp/

RUN mkdir /app/www/scripts

RUN cp "/tmp/${scriptaculous}/lib/"* /app/www/scripts/
RUN cp "/tmp/${scriptaculous}/src/"* /app/www/scripts/
 
RUN composer install

RUN ls -R /app/www

RUN chmod -R 777 /app

ENV APACHE_DOCUMENT_ROOT=/app/www
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
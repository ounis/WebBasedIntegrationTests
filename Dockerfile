FROM php:apache AS base

RUN apt-get update \
     && apt-get install -y libzip-dev wget unzip \
     && docker-php-ext-install zip \
     && rm -rf /var/lib/apt/lists/*

COPY ./ /app
WORKDIR /app

# Prototype + script.aculo.us are fetched from Google's Hosted Libraries CDN.
# The old script.aculo.us download host serves a certificate that does not
# match its hostname, so the previous `wget https://script.aculo.us/...` broke
# the build; this CDN is stable and its TLS is valid. script.aculo.us 1.9.0
# ships prototype 1.6.1, but 1.7.1.0 is a compatible drop-in and is what the
# CDN offers under the prototype path. The loader resolves its own modules
# relative to the scriptaculous.js script tag, so all files live side by side.
ARG scriptaculous=1.9.0
ARG prototype=1.7.1.0
RUN mkdir -p /app/www/scripts \
     && cd /app/www/scripts \
     && wget -q "https://ajax.googleapis.com/ajax/libs/prototype/${prototype}/prototype.js" \
     && for f in scriptaculous builder effects dragdrop controls slider sound; do \
          wget -q "https://ajax.googleapis.com/ajax/libs/scriptaculous/${scriptaculous}/$f.js"; \
        done

RUN ls -R /app/www

RUN chmod -R 777 /app

ENV APACHE_DOCUMENT_ROOT=/app/www
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

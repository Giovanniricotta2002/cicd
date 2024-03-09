FROM php:8.2-apache

COPY --chown=root:root symfony.conf /etc/apache2/sites-available/symfony.conf

RUN apt-get -qq update && \
    apt-get -qq install libpq-dev libicu-dev locales && \
    echo -e "en_US.UTF-8 UTF-8\nfr_FR.UTF-8 UTF-8" >> /etc/locale.gen && locale-gen && \
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    docker-php-ext-install opcache pdo_pgsql intl && \
    rm -fr /var/lib/apt/lists && \
    ln -sf /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    useradd --uid 1000 --home /var/www ynov && \
    mkdir -p /var/log/app && mkdir /var/www/app && a2dissite 000-default && a2ensite symfony && \
    chown -R 1000:1000 /var/www && \
    sed -i -e 's/www-data/ynov/' /etc/apache2/envvars && \
    curl https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/app


COPY ./ /var/www/app/

ENV LANG=fr_FR.UTF-8
ENV LANGUAGE=fr_FR.UTF-8

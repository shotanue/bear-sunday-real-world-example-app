FROM alpine:3.10.3 AS App

ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /composer/vendor/bin:$PATH

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk --update --no-cache add \
    php7 \
    php7-ctype \
    php7-curl \
    php7-dom \
    php7-fileinfo \
    php7-ftp \
    php7-iconv \
    php7-json \
    php7-mbstring \
    php7-mysqlnd \
    php7-openssl \
    php7-pdo \
    php7-pdo_sqlite \
    php7-phar \
    php7-posix \
    php7-session \
    php7-simplexml \
    php7-sqlite3 \
    php7-tokenizer \
    php7-xml \
    php7-xmlreader \
    php7-xmlwriter \
    php7-zlib \
    && rm -rf /var/cache/apk/* /var/tmp/* /tmp/*

RUN composer config -g repos.packagist composer https://packagist.jp \
    && composer global require hirak/prestissimo

VOLUME /var/app

WORKDIR /var/app

ENTRYPOINT ["top"]

#ENTRYPOINT ["composer"]
#CMD ["server"]

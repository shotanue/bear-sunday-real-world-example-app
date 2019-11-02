FROM php:7.3-cli-alpine3.10 AS build-extensions

RUN apk add --update --no-cache autoconf make g++ gcc php7-dev

RUN pecl install swoole xdebug

#############################################
FROM php:7.3-cli-alpine3.10 AS base-image

COPY --from=build-extensions  /usr/local/lib/php/extensions/no-debug-non-zts-20180731/swoole.so \
                             /usr/local/lib/php/extensions/no-debug-non-zts-20180731/swoole.so

# swoole requires libstdc++
RUN apk add --update --no-cache libstdc++
RUN docker-php-ext-enable swoole

WORKDIR /var/app

#############################################
FROM base-image AS development

COPY --from=build-extensions /usr/local/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so \
                            /usr/local/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so

RUN apk update
RUN docker-php-ext-enable xdebug

EXPOSE 8080 9000
VOLUME /var/app

ENTRYPOINT ["php"]
CMD ["bin/swoole.php"]

#############################################
FROM base-image AS composer

ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /composer/vendor/bin:$PATH

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer config -g repos.packagist composer https://packagist.jp \
    && composer global require hirak/prestissimo

ENTRYPOINT ["composer"]
VOLUME /var/app

#############################################
FROM composer AS package

COPY . .
RUN rm -rf vendor var/tmp/* var/log/* \
 && composer install --no-dev \
 && composer compile

#############################################
FROM base-image AS ship

# remove composer
COPY --from=package /var/app /var/app

RUN rm -rf tests

EXPOSE 8080

ENTRYPOINT ["php"]
CMD ["bin/swoole.php"]

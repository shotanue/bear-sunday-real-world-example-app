FROM docker.pkg.github.com/shotanue/swoole-app/docker-dev:7.3-alpine3.10 AS base-image

WORKDIR /var/app
VOLUME /var/app

RUN docker-php-ext-install pdo_mysql

#############################################
FROM base-image AS composer

ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /composer/vendor/bin:$PATH

COPY --from=composer:1.9.1 /usr/bin/composer /usr/bin/composer

# install migration tool
RUN cd /tmp \
 && curl -sSLO https://github.com/k0kubun/sqldef/releases/download/v0.5.7/mysqldef_linux_amd64.tar.gz \
 && tar zxvf mysqldef_linux_amd64.tar.gz -C /usr/bin

ENTRYPOINT ["composer"]
CMD [""]

#############################################
FROM base-image AS development

EXPOSE 8080 9000

ENTRYPOINT ["php"]
CMD ["bin/swoole.php"]

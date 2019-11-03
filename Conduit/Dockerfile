FROM docker.pkg.github.com/shotanue/swoole-app/docker:7.3-alpine3.10 AS base-image

ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /composer/vendor/bin:$PATH

WORKDIR /var/app

#############################################
FROM base-image AS ship

# without vendor/ and tests/
# @see .dockerignore
COPY  . .

COPY --from=composer:1.9.1 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev \
 && composer compile \
 && rm -rf /usr/bin/composer /composer

EXPOSE 8080

ENTRYPOINT ["php"]
CMD ["bin/swoole.php"]

#############################################
FROM ship AS test

COPY --from=composer:1.9.1 /usr/bin/composer /usr/bin/composer
RUN composer install

# Because of .dockerignore, this stage has no tests.
VOLUME /var/app/tests

ENTRYPOINT ["composer"]
CMD ["test"]

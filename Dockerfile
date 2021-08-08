FROM php:8.0.9-alpine3.14
LABEL maintainer="dersonsena@gmail.com"

EXPOSE 80

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/app
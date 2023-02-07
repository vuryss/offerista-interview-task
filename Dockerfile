FROM composer:2.5 AS composer
FROM mlocati/php-extension-installer:latest AS extension-installer
FROM php:8.2-cli-alpine3.17

# ENV Config
ENV PHP_CS_FIXER_IGNORE_ENV=1

# Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Extension installer
COPY --from=extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Symfony CLI
ENV SYMFONY_CLI_VERSION=5.4.21
RUN wget -q https://github.com/symfony-cli/symfony-cli/releases/download/v${SYMFONY_CLI_VERSION}/symfony-cli_${SYMFONY_CLI_VERSION}_x86_64.apk \
    && apk add --no-cache --allow-untrusted symfony-cli_${SYMFONY_CLI_VERSION}_x86_64.apk \
    && rm -rf symfony-cli_${SYMFONY_CLI_VERSION}_x86_64.apk \
    && rm -rf /var/cache/apk/*

# System packages
RUN apk add git

# Install extra extensions for PHP
RUN install-php-extensions intl apcu opcache ds

# Use default production PHP configuration
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Ensure a non-root user and group with ID 1000 exists
COPY docker/scripts/ensure-non-root-user.sh /root/ensure-non-root-user.sh
RUN chmod a+x /root/ensure-non-root-user.sh && sh /root/ensure-non-root-user.sh

# Ensure application directory exists with correct permissions
RUN mkdir -p /app && chown -R user:user /app

USER 1000

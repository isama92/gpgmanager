FROM php:8.1
LABEL MAINTAINER="Stefano Borzoni <isama92@gmail.com>"

WORKDIR /app

# update the os and install its packages

RUN apt-get update \
  && apt-get autoremove -y

RUN apt-get install -y --no-install-recommends\
    ca-certificates curl git\
    libzip-dev zip zlib1g-dev unzip

# gnupg
RUN apt install -y --no-install-recommends libgpgme11-dev \
    && pecl install gnupg \
    && docker-php-ext-enable gnupg

# cleanup
RUN rm -rf /var/lib/apt/lists/*

# xdebug
RUN pecl install xdebug-3.1.5
RUN docker-php-ext-enable xdebug

# add local user
RUN useradd -u 1000 -m local

# copy config files
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

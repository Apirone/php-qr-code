ARG PHP_VERSION=8.2

FROM composer:2 as composer

FROM php:${PHP_VERSION}-apache

# Set user and group ID's
ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}
ENV APACHE_RUN_USER=appuser
ENV APACHE_RUN_GROUP=appuser

# Surpresses debconf complaints of trying to install apt packages interactively
# https://github.com/moby/moby/issues/4032#issuecomment-192327844

ARG DEBIAN_FRONTEND=noninteractive

# Add composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Add user and group before install, for correct file permission
RUN addgroup --gid $GID appuser \
    && adduser --system --disabled-login --disabled-password --no-create-home --uid $UID --gid $GID appuser

# persistent dependencies
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
    # Ghostscript is required for rendering PDF previews
    ghostscript \
    ; \
    rm -rf /var/lib/apt/lists/*

# install the PHP extensions we need (https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions)
RUN set -ex; \
    # \
    # savedAptMark="$(apt-mark showmanual)"; \
    # \
    apt-get update; \
    apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libicu-dev \
    libjpeg-dev \
    libmagickwand-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    ; \
    \
    docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    ; \
    docker-php-ext-install -j "$(nproc)" \
    bcmath \
    exif \
    gd \
    intl \
    zip \
    ;
    # ; \
    # # some misbehaving extensions end up outputting to stdout 🙈 (https://github.com/docker-library/wordpress/issues/669#issuecomment-993945967)
    # out="$(php -r 'exit(0);')"; \
    # [ -z "$out" ]; \
    # err="$(php -r 'exit(0);' 3>&1 1>&2 2>&3)"; \
    # [ -z "$err" ]; \
    # \
    # extDir="$(php -r 'echo ini_get("extension_dir");')"; \
    # [ -d "$extDir" ]; \
    # # reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
    # apt-mark auto '.*' > /dev/null; \
    # apt-mark manual $savedAptMark; \
    # ldd "$extDir"/*.so \
    # | awk '/=>/ { so = $(NF-1); if (index(so, "/usr/local/") == 1) { next }; gsub("^/(usr/)?", "", so); print so }' \
    # | sort -u \
    # | xargs -r dpkg-query --search \
    # | cut -d: -f1 \
    # | sort -u \
    # | xargs -rt apt-mark manual; \
    # \
    # apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
    # rm -rf /var/lib/apt/lists/*; \
    # \
    # ! { ldd "$extDir"/*.so | grep 'not found'; }; \
    # # check for output like "PHP Warning:  PHP Startup: Unable to load dynamic library 'foo' (tried: ...)
    # err="$(php --version 3>&1 1>&2 2>&3)"; \
    # [ -z "$err" ]

# Install xdebug
# Prevent to install xdebug for php version less than 8
# Older php versions are not longer supported
RUN if [ $(php -r "echo PHP_MAJOR_VERSION;") = "8" ]; then \
        pecl install xdebug && \
        docker-php-ext-enable xdebug && \
        mkdir /var/log/xdebug; \
    fi

# Cleanup
RUN rm -rf /usr/src/*

USER ${APACHE_RUN_USER}

CMD ["apache2-foreground"]

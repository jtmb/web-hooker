ARG ALPINE_VERSION=3.18
FROM alpine:${ALPINE_VERSION}
# Setup document root
WORKDIR /var/www/html

# Install packages and remove default server definition
RUN apk add --no-cache jq bash openrc
RUN apk add --no-cache \
  curl \
  nginx \
  php82 \
  php82-ctype \
  php82-curl \
  php82-dom \
  php82-fpm \
  php82-gd \
  php82-intl \
  php82-mbstring \
  php82-mysqli \
  php82-opcache \
  php82-openssl \
  php82-phar \
  php82-session \
  php82-xml \
  php82-xmlreader \
  supervisor

# Configure nginx - http
COPY config/nginx.conf /etc/nginx/nginx.conf
# Configure nginx - default server
COPY config/conf.d /etc/nginx/conf.d/

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php82/php-fpm.d/www.conf
COPY config/php.ini /etc/php82/conf.d/custom.ini

# copy app files
COPY front-end /var/www/html

# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY config/supervisord.conf /etc/supervisord.conf

# Make sure files/folders needed by the processes are accessible when they run under the nobody user
RUN mkdir -p /data/web-hooker/webhooks
RUN chown -R 1000.1000 /var/www/html /run /var/lib/nginx /var/log/nginx /data

# Create symlink for php
RUN ln -s /usr/bin/php82 /usr/bin/php

# Switch to use a non-root user from here on
USER 1000

# # Add application
# COPY --chown=nobody src/ /var/www/html/

# Expose the port nginx is reachable on
EXPOSE 8080

ARG DASHBOARD_USER:admin
ARG DASHBOARD_PASSWORD:changeme

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping

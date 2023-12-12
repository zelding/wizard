FROM debian:bullseye

LABEL wizard.debian.php.version="8.3"
LABEL wizard.debian.php.description="PHP 8.3"

RUN set -ex; \
  apt update -q -y; \
  DEBIAN_FRONTEND=noninteractive apt upgrade -q -y; \
  DEBIAN_FRONTEND=noninteractive apt install -y \
  locales-all \
  ca-certificates \
  lsb-release \
  software-properties-common \
  apt-transport-https \
  dirmngr \
  curl \
  wget \
  gnupg \
  zip \
  unzip \
  xz-utils \
  pkg-config

ENV DOCKERIZE_VERSION v0.7.0

RUN wget -O - https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz | tar xzf - -C /usr/local/bin
##  rm ./dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz;

##ADD dockerize "/usr/local/bin/dockerize"

RUN set -ex; \
    apt update -q -y; \
    DEBIAN_FRONTEND=noninteractive apt install -y \
    git \
    libicu-dev \
    default-libmysqlclient-dev \
    acl \
    libfcgi0ldbl \
    jpegoptim \
    pngquant \
    libjpeg-turbo-progs \
    links; \
    curl -sL https://github.com/fabpot/local-php-security-checker/releases/download/v1.2.0/local-php-security-checker_1.2.0_linux_amd64 -o /bin/local-php-security-checker; \
    chmod +x /bin/local-php-security-checker

ENV PHP_VERSION 8.3

RUN set -ex; \
    curl -fsSL https://packages.sury.org/php/apt.gpg | apt-key add -; \
    echo "deb https://packages.sury.org/php/ bullseye main" > /etc/apt/sources.list.d/php.list; \
    apt update -q -y; \
    DEBIAN_FRONTEND=noninteractive apt install -y \
    php${PHP_VERSION} \
    php${PHP_VERSION}-apcu \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-cli \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-gd \
    php${PHP_VERSION}-intl \
    php${PHP_VERSION}-dev \
    php${PHP_VERSION}-memcached \
    php${PHP_VERSION}-mysql \
    php${PHP_VERSION}-opcache \
    php${PHP_VERSION}-readline \
    php${PHP_VERSION}-redis \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-zip \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-imagick
    ##php${PHP_VERSION}-xdebug

RUN rm -rf /var/lib/apt/lists/*; \
    ln -s /usr/sbin/php-fpm${PHP_VERSION} /usr/sbin/php-fpm; \
    update-alternatives --set php /usr/bin/php${PHP_VERSION}; \
    wget http://browscap.org/stream?q=Lite_PHP_BrowsCapINI -O /etc/php/browscap.ini; \
    cd /etc/php/${PHP_VERSION}/cli; \
    rm -rf conf.d; \
    ln -s ../fpm/conf.d; \
    mkdir /etc/php/template.d; \
    mkdir /etc/nginx; \
    mkdir -p /var/socks/php/${PHP_VERSION}; \
    mkdir -p /data; \
    mkdir -p /run/php; \
    mkdir -p /var/run/mysqld

ADD ./scripts/install-composer.sh /install-composer.sh
ADD ./scripts/entrypoint.sh /entrypoint.sh
ADD ./templates /etc/php/template.d

# Install Composer
RUN set -ex; \
    ./install-composer.sh

WORKDIR /data

EXPOSE 8120
EXPOSE 9000

STOPSIGNAL SIGTERM

ENTRYPOINT ["/entrypoint.sh"]

CMD ["php-fpm"]

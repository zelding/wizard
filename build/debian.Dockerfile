FROM debian:bullseye

LABEL wizard.debian.version="Bullseye"
LABEL wizard.debian.description="Debian Bullseye (11)"

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
  pkg-config; \
  wget -q https://github.com/jwilder/dockerize/releases/download/v0.6.1/dockerize-linux-amd64-v0.6.1.tar.gz; \
  tar -C /usr/local/bin -xzvf dockerize-linux-amd64-v0.6.1.tar.gz; \
  rm dockerize-linux-amd64-v0.6.1.tar.gz

STOPSIGNAL SIGTERM

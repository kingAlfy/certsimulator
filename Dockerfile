FROM php:8.2-apache

LABEL maintainer="kingAlfy <al2367.arg@gmail.com>"
LABEL version="0.1"
LABEL description="Laravel API and NextJS frontend application"

RUN apt-get update

# Starters
RUN apt install -y git nano zip 7zip curl

# Nodejs 20 and NPM
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash
RUN apt install -y nodejs

# Composer installation
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

EXPOSE 80
EXPOSE 3000
EXPOSE 8000
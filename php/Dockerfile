FROM php:8.1-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update
RUN apt-get install nano default-mysql-client git-all zip -y

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
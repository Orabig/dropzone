FROM php:5.6-apache

MAINTAINER Benoit Chauvet "benoit.chauvet@gmail.com"

COPY www /var/www/html

RUN mkdir /var/www/uploads
RUN chown www-data /var/www/uploads

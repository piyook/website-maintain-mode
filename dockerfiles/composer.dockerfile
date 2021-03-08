FROM composer:latest
 
WORKDIR /var/www/html
 
## REMEMBER to run docker-compose run --rm composer <command> in order to use bind mount to local src file
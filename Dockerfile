FROM beatpop/php-fpm:7.2.10-odebug
LABEL "MAINTAINER" "huangzq@suancloud.cn"

COPY ./ /var/www/html/

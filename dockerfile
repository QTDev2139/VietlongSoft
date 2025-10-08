FROM php:8.2-apache
RUN a2enmod rewrite
RUN apt-get update && apt-get install -y gnupg2 curl apt-transport-https unixodbc-dev libgssapi-krb5-2 \
 && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
 && curl https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list \
 && apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 \
 && pecl install sqlsrv pdo_sqlsrv \
 && docker-php-ext-enable sqlsrv pdo_sqlsrv
RUN echo "date.timezone=Asia/Ho_Chi_Minh" > /usr/local/etc/php/conf.d/timezone.ini
WORKDIR /var/www/html
COPY . /var/www/html
COPY docker-start.sh /usr/local/bin/docker-start.sh
RUN chmod +x /usr/local/bin/docker-start.sh
ENV PORT=8080
EXPOSE 8080
CMD ["docker-start.sh"]

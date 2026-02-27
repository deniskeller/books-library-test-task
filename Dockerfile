# Dockerfile
FROM php:8.4-apache

# Устанавливаем расширения PHP для работы с MySQL
RUN docker-php-ext-install pdo_mysql mysqli

# Включаем модуль mod_rewrite
RUN a2enmod rewrite headers expires deflate

# Копируем все файлы проекта
COPY . /var/www/html/

# Меняем корневую папку Apache на public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ВАЖНО: Разрешаем .htaccess для всей папки
RUN echo "<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n\
\n\
<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/htaccess.conf

# Устанавливаем права
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
RUN a2enconf htaccess

WORKDIR /var/www/html

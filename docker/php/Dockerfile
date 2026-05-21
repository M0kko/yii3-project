FROM php:8.4-apache-bookworm
# Замена репозиториев на рабочее зеркало (Яндекс)
RUN sed -i 's|deb.debian.org/debian|mirror.yandex.ru/debian|g' /etc/apt/sources.list.d/debian.sources \
    && sed -i 's|deb.debian.org/debian-security|mirror.yandex.ru/debian-security|g' /etc/apt/sources.list.d/debian.sources
RUN printf '<Directory /var/www/html/public>\n\
 Options Indexes FollowSymLinks\n\
 AllowOverride All\n\
 Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/yii3-public.conf \
 && a2enconf yii3-public
# Теперь установка пакетов должна работать
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
 /etc/apache2/sites-available/*.conf \
 /etc/apache2/apache2.conf \
 /etc/apache2/conf-available/*.conf
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
RUN docker-php-ext-install pdo_mysql
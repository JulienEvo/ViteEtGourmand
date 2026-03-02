
FROM php:8.2-apache

# Installation des dépendances
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    unzip \
    git \
    libxml2-dev \
    pkg-config \
    libonig-dev \
    && apt-get clean  \
    && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring zip intl

# Installation de MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier le projet dans le container
COPY . /var/www/

# DocumentRoot sur le dossier public
RUN sed -ri -e 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!/var/www/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permissions
RUN chown -R www-data:www-data /var/www/public

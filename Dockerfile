FROM php:8.4-apache

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd pdo_mysql zip bcmath mbstring exif pcntl xml

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# FIX Apache (MPM)
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.conf \
    && a2enmod mpm_prefork \
    && a2enmod rewrite

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Permisos Laravel
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Instalar dependencias
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Ajustar DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Usar puerto dinámico Railway
CMD apache2-foreground
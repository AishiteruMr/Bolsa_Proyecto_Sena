FROM php:8.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm

# Instalar extensión para instalar extensiones de PHP fácilmente
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

# Instalar extensiones PHP necesarias (incluyendo pdo_mysql)
RUN install-php-extensions pdo_mysql bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de PHP y Node
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install && npm run build

# Configurar permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer puerto para servidor web (Railway lo gestiona)
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000

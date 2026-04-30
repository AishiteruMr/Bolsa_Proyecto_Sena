FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy project files
COPY . .

# Run post-install scripts (e.g., package discovery)
RUN composer dump-autoload --optimize

# Set up permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Update DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Configure Apache to use $PORT at runtime (Railway provides PORT dynamically)
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf \
    && sed -i 's|<VirtualHost \*:80>|<VirtualHost *:${PORT}>|g' /etc/apache2/sites-available/000-default.conf

# Default PORT for local development; Railway overrides this at runtime
ENV PORT=80
EXPOSE ${PORT}

CMD ["apache2-foreground"]

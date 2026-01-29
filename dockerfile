FROM php:8.3-apache

# --------------------------------------------------
# 1. System dependencies + PHP extensions
# --------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    supervisor \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    gd \
    mbstring \
    exif \
    pcntl \
    bcmath \
    opcache \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# 2. Apache configuration for Laravel
# --------------------------------------------------
RUN a2enmod rewrite headers \
    && sed -i 's|DocumentRoot .*|DocumentRoot /var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf \
    && printf "<Directory /var/www/html/public>\n\
    Options -Indexes +FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>\n" >> /etc/apache2/apache2.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable Apache error logging to stdout/stderr
RUN sed -i 's|ErrorLog .*|ErrorLog /proc/self/fd/2|g' /etc/apache2/apache2.conf \
    && sed -i 's|CustomLog .*|CustomLog /proc/self/fd/1 combined|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|ErrorLog .*|ErrorLog /proc/self/fd/2|g' /etc/apache2/sites-available/000-default.conf

# --------------------------------------------------
# 3. Install Composer
# --------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --------------------------------------------------
# 4. Set working directory
# --------------------------------------------------
WORKDIR /var/www/html

# --------------------------------------------------
# 5. Copy composer files first (for better caching)
# --------------------------------------------------
COPY composer.json composer.lock ./

# --------------------------------------------------
# 6. Install PHP dependencies
# --------------------------------------------------
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --no-interaction \
    --prefer-dist

# --------------------------------------------------
# 7. Copy application source
# --------------------------------------------------
COPY . .

# --------------------------------------------------
# 8. Complete composer setup
# --------------------------------------------------
RUN composer dump-autoload --optimize --no-dev

# --------------------------------------------------
# 9. Create required Laravel directories
# --------------------------------------------------
RUN mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/app/public \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# --------------------------------------------------
# 10. Fix permissions
# --------------------------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache \
    && chmod -R 755 /var/www/html

# --------------------------------------------------
# 11. Supervisor config
# --------------------------------------------------
COPY docker/supervisor/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# --------------------------------------------------
# 12. PHP Configuration for production
# --------------------------------------------------
RUN echo "memory_limit = 256M" > /usr/local/etc/php/conf.d/memory.ini \
    && echo "upload_max_filesize = 20M" >> /usr/local/etc/php/conf.d/memory.ini \
    && echo "post_max_size = 20M" >> /usr/local/etc/php/conf.d/memory.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/memory.ini

# --------------------------------------------------
# 13. Git safe directory
# --------------------------------------------------
RUN git config --system --add safe.directory /var/www/html

# --------------------------------------------------
# 14. Entrypoint
# --------------------------------------------------
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
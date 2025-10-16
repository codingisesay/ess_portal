# 1️⃣ Use PHP 8.3 with Apache
FROM php:8.3-apache

# 2️⃣ Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3️⃣ Enable Apache mod_rewrite
RUN a2enmod rewrite

# 4️⃣ Set Laravel working directory
WORKDIR /var/www/html 

# 5️⃣ Copy only composer files first to leverage cache
COPY composer.json composer.lock ./

# 6️⃣ Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 7️⃣ Configure Composer for network reliability
RUN composer config --global process-timeout 600 \
    && composer config --global github-protocols https

# 8️⃣ Install PHP dependencies (prefer-source for reliability)
RUN composer install --no-dev --optimize-autoloader --prefer-source --no-scripts

# 9️⃣ Copy the rest of the application
COPY . .

# 🔹 Run post-autoload scripts
RUN composer run-script post-autoload-dump

# 🔹 Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 🔹 Configure Apache to serve Laravel public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 🔹 Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 10️⃣ Expose Apache port
EXPOSE 80

# 11️⃣ Start Apache
CMD ["/usr/local/bin/docker-entrypoint.sh"]

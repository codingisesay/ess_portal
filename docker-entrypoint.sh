#!/bin/bash
set -e

echo "Starting Laravel application..."

# Clear all caches
echo "Clearing caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# Generate application key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Create storage link
echo "Creating storage link..."
php artisan storage:link --force || true

# Cache configuration for better performance
if [ "$APP_ENV" = "production" ]; then
    echo "Caching configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Run migrations (optional - uncomment if needed)
# echo "Running migrations..."
# php artisan migrate --force

# Fix permissions one final time
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Application is ready!"

# Execute the main command
exec "$@"
#!/bin/bash
set -e

# Run storage link (ignore if it already exists)
php artisan storage:link || true
php artisan queue:work || true

# Continue with original CMD
exec apache2-foreground

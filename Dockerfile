FROM php:8.3-fpm

# Install the application dependencies
RUN apt-get update && apt-get install -y \
netcat-openbsd \
git \
curl \
zip \
unzip \
libxml2-dev \
libpng-dev \
libonig-dev

# Install the php extention
RUN docker-php-ext-install \
pdo_mysql \
mbstring \
exif \
pcntl \
bcmath \
gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define image directory
WORKDIR /var/www

# Copy ONLY composer configuration files first
COPY composer.json composer.lock ./

# Run the optimized installation
RUN composer install \
    --no-scripts \
    --prefer-dist \
    --no-dev \
    --no-autoloader \
    --no-interaction

    
# Copy in the source code
COPY . .

# Continue the skipped script from compose
RUN composer dump-autoload --optimize
    
# Port
EXPOSE 9000
    
# Copy the entrypoint script and make it executable
RUN mv /var/www/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

# Start PHP-FPM (This is the default command in the base image)
CMD ["php-fpm"]
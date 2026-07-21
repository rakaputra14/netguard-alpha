#Stage 1 
FROM php:8.3-fpm AS php-base
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
# Install the php extension
RUN docker-php-ext-install \
pdo_mysql \
mbstring \
exif \
pcntl \
bcmath \
gd
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
#install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

#Stage 2
FROM node:24-alpine AS asset-compiler
# Set workdir
WORKDIR /app
# Copy dependencies list
COPY package*.json ./
# Run npm install
RUN npm install
# Copy source file
COPY . .
# Run build
RUN npm run build

#Stage 3
FROM php-base AS vendor-staging
# Set workdir
WORKDIR /var/www
# Copy composer configuration files first
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
RUN composer dump-autoload --no-dev --classmap-authoritative

#Stage 4
FROM php-base AS app
# Set workdir
WORKDIR /var/www/
# Copy source file
COPY . .
# Copy pre-compiled vendor
COPY --from=vendor-staging /var/www/vendor ./vendor
# Copy pre-compiled front-end assets
COPY --from=asset-compiler /app/public ./public
# Storage linking
RUN php artisan storage:link --force
# Permission setting for php-fpm
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache
# Copy the entrypoint script and make it executable
RUN mv /var/www/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
# Port
EXPOSE 9000
# Process handover to php-fpm
USER www-data
# Entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
# Start PHP-FPM (This is the default command in the base image)
CMD ["php-fpm"]

#Stage 5
From nginx:alpine AS web
# Set workdir
WORKDIR /var/www/
# Copy custom nginx config to default path
COPY docker-compose/nginx/*.conf /etc/nginx/conf.d
# Copy public folder from source file
COPY ./public ./public
# Copy pre-compiled frontend asset that nginx needs
COPY --from=asset-compiler /app/public/build ./public/build
# Run the web-service and keeps it runnning by making it a foreground process by shutting daemon off"
CMD ["nginx", "-g", "daemon off;"]
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    default-mysql-client \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
    zip \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite and handle MPM modules
RUN a2enmod rewrite && \
    a2dismod mpm_event 2>/dev/null || true && \
    a2enmod mpm_prefork

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application code
COPY . /var/www/html

# Set Apache document root to public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Create Apache vhost configuration for Laravel
RUN echo '<Directory /var/www/html/public>\n\
    Options -Indexes +FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/laravel.conf && \
    a2enconf laravel

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create storage directories with proper permissions
RUN mkdir -p storage/app storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Copy and make entrypoint script executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Use the entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

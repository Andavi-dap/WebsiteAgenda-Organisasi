FROM php:8.2-apache

# Install system dependencies & extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    uncurl \
    git

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type d -chmod=755 \
    && find /var/www -type f -chmod=644

# Change document root to public
RUN sed -i -s 's/var\/www\/html/var\/www\/public/g' /etc/apache2/sites-available/000-default.conf

# Enable Apache Rewrite Module
RUN a2enmod rewrite

EXPOSE 80
CMD ["apache2-foreground"]
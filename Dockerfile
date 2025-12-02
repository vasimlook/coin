FROM php:8.1-cli

# Suppress interactive prompts during package install
ENV DEBIAN_FRONTEND=noninteractive

# 2. Install necessary system packages and PHP extensions in a single RUN
RUN apt-get update \
    && apt-get install -y \
       git \
       unzip \
       curl \
       libpng-dev \
       libzip-dev \
       libjpeg62-turbo-dev \
       libfreetype6-dev \
       libonig-dev \
       libxml2-dev \
       libicu-dev \
       libmagickwand-dev \
       libmemcached-dev \
       zlib1g-dev \
       build-essential \
       pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
       pdo_mysql \
       mbstring \
       exif \
       pcntl \
       bcmath \
       zip \
       mysqli \
       gd \
       intl \
    && pecl install imagick redis\
    && docker-php-ext-enable imagick redis\
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 3. Set your working directory
WORKDIR /var/www/html

# 4. Copy your application files into the container
COPY . .

# 5. (Optional) Install Composer in the container if needed
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6. (Optional) Run Composer install if your project needs packages
# RUN composer install --no-dev --optimize-autoloader

# 7. Expose port 9000 for the built-in server
EXPOSE 9000

# 8. Run CodeIgniter's Spark server on host 0.0.0.0, port 9000
CMD ["php", "-S", "0.0.0.0:9000"]

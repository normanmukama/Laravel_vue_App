FROM php:8.3.2

# Install system dependencies and libraries for PHP extensions
RUN apt-get update -y && \
    apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    pkg-config \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Install Node.js and npm from NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install pdo mbstring

# Set the working directory
WORKDIR /app

# Copy the source code
COPY . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies (including Tailwind CSS and Vue3 Datatables)
RUN npm install

# Build the front-end assets
RUN npm run build

# Set the command to start the Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8181"]

# Expose the port for the Laravel server
EXPOSE 8181

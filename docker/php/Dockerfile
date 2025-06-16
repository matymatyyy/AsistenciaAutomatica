FROM php:8.2-fpm

# Instalar dependencias y extensiones necesarias para Symfony
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario para la aplicación (opcional pero recomendado)
RUN useradd -G www-data,root -d /var/www appuser && \
    mkdir -p /var/www && \
    chown -R appuser:www-data /var/www


WORKDIR /var/www

USER appuser
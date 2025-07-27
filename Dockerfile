FROM php:8.2-apache

# Instalación de dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip curl git \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev

# Instalación de extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Copiar Composer desde imagen oficial
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Configurar el Virtual Host de Apache para Laravel
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|' /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite para URLs amigables
RUN a2enmod rewrite

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Crear directorios de cache y storage si no existen
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache

#  Crear directorio para la documentación de Swagger 
RUN mkdir -p /var/www/public/docs

# Permisos para Laravel y la documentación de Swagger
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public/docs

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 80

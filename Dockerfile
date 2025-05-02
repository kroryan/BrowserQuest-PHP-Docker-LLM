FROM php:8.0-cli

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip pcntl

# Instalar composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /app

# Copiar archivos del proyecto
COPY . /app/

# Instalar dependencias de composer
RUN composer install

# Configurar para que workerman use 0.0.0.0 como host
# En lugar de modificar los archivos, exponemos los puertos correctamente
EXPOSE 8000 8787

# Preparar script de inicio
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Comando de inicio
CMD ["docker-entrypoint.sh"]
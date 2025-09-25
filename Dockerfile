FROM php:8.2-apache

# Install PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy app files
COPY . /var/www/html/

# Create a writable sessions directory
RUN mkdir -p /var/www/html/sessions \
    && chown -R www-data:www-data /var/www/html/sessions \
    && chmod -R 770 /var/www/html/sessions

# Fix permissions for app
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Set PHP session save path
RUN echo "session.save_path = \"/var/www/html/sessions\"" > /usr/local/etc/php/conf.d/session.ini

EXPOSE 80

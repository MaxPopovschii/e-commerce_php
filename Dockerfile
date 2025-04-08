# Immagine base con PHP e Apache
FROM php:8.2-apache

# Abilita mod_rewrite per il routing (necessario per l'MVC)
RUN a2enmod rewrite

# Copia tutto il progetto nella directory root del server
COPY . /var/www/html/

# Imposta permessi (utile in ambienti hosting/docker)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Attiva gli errori in fase di sviluppo
RUN echo "display_errors=On\nerror_reporting=E_ALL" > /usr/local/etc/php/conf.d/error.ini

# Configura Apache per supportare .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Espone la porta standard
EXPOSE 80

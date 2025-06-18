FROM ubuntu:16.04

# Install Apache and PHP (insecure, no hardening)
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php php-mysqli && \
    apt-get clean

# Create uploads directory with open permissions
RUN mkdir -p /var/www/html/uploads && chmod 777 /var/www/html/uploads

# Copy app files
COPY . /var/www/html/

# Expose port 80
EXPOSE 80

CMD ["apachectl", "-D", "FOREGROUND"] 
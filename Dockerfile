# Use official PHP base image with CLI + Apache support
FROM php:8.2-cli

# Install dependencies required for SQLite and PDO
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Copy project files into container
COPY . /app
WORKDIR /app

# Expose the port the app will run on
EXPOSE 10000

# Start the PHP server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]


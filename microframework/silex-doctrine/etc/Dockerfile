FROM php:7.1-fpm
RUN apt-get update && apt-get install -y --no-install-recommends \

&& \

# Cleanup

	apt-get clean && \
	rm -rf /var/lib/apt/lists/* && \

# Install some extra PHP Extension

	docker-php-ext-install \
        pdo \
        pdo_mysql \

	&& curl -sS https://getcomposer.org/installer \ | php -- --install-dir=/usr/local/bin --filename=composer

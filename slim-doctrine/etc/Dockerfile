FROM php:7.1-fpm
RUN apt-get update && apt-get install -y --no-install-recommends \

# For bz2

		libbz2-dev \

# For postgres

        #libpq-dev \

# For gd

		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng12-dev \
		libxpm-dev \
		libvpx-dev \

# For ftp

		libssl-dev \

# For mcrypt

		libmcrypt-dev \

# For memcached

		libmemcached-dev \
	&& \

# Cleanup

	apt-get clean && \
	rm -rf /var/lib/apt/lists/* && \

# Configure GD package for JPEG support

	docker-php-ext-configure gd \
		--with-freetype-dir=/usr/lib/x86_64-linux-gnu/ \
		--with-jpeg-dir=/usr/lib/x86_64-linux-gnu/ \
		--with-xpm-dir=/usr/lib/x86_64-linux-gnu/ \
		--with-vpx-dir=/usr/lib/x86_64-linux-gnu/ \
	&& \

# Install some extra PHP Extension

	docker-php-ext-install \
        #pgsql \
        pdo \
        #pdo_pgsql \
        pdo_mysql \

		bcmath \
		bz2 \
		exif \
		ftp \
		gd \
		gettext \
		mbstring \
		mcrypt \
		# opcache \
		shmop \
		sockets \
		sysvmsg \
		sysvsem \
		sysvshm \
        zip \

    && curl -sS https://getcomposer.org/installer \ | php -- --install-dir=/usr/local/bin --filename=composer

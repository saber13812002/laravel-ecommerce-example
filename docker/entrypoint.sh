#!/bin/sh

# check database connection
until nc -z -v -w30 $DB_HOST 3306 > /dev/null 2>&1
do
	echo "Waiting for database connection..."
	# wait for 5 seconds before check again
	sleep 10
done

# Set APP_KEY env var if has not set or is empty
if [ -n "$APP_KEY" ]; then
	echo "set APP_KEY from admin-provided environment variable"
	echo "APP_KEY=$APP_KEY" > /var/www/html/storage/app_key.env
elif [ -f /var/www/html/.env ]; then
	echo "set APP_KEY from previously .env file"
	echo $(awk '/^APP_KEY=/{print}' /var/www/html/.env) > /var/www/html/storage/app_key.env
elif [ -f /var/www/html/storage/app_key.env ]; then
	echo "set APP_KEY from previously saved file at storage/app_key.env"
else
	# generate APP_KEY by artisan & save it to storage/app_key.env for subsequential use
	echo "set APP_KEY from 'php artisan key:generate'"
	echo "APP_KEY=" >> /var/www/html/.env
	/usr/local/bin/php /var/www/html/artisan key:generate
	
	echo $(awk '/^APP_KEY=/{print}' /var/www/html/.env) > /var/www/html/storage/app_key.env
fi
cat /var/www/html/storage/app_key.env
export $(cat /var/www/html/storage/app_key.env | xargs)

# Clear the cache
rm -rf /var/www/html/storage/cache/*
/usr/local/bin/php /var/www/html/artisan config:cache


# Run migrations if APP_ENV is not 'production' and is not empty. empty variable interpreted as 'production'
if [ -z "$APP_ENV" -o "$APP_ENV" = 'production' ]; then
	echo "NOTE: you must run migrations and initialization commands manually or automated by ci tools where needed on production!\n"
	echo "NOTE: if you are on another environment, please set APP_ENV variable to your environment key"
else
	/usr/local/bin/php /var/www/html/artisan migrate --seed
	# /usr/local/bin/php /var/www/html/artisan ecommerce:install
	/usr/local/bin/php /var/www/html/artisan admin:install
fi

/usr/local/sbin/php-fpm -F
composer install
app migrations:migrate -n --allow-no-migration
php-fpm

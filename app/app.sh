#!/bin/bash

cd /var/www/html/case-php
php artisan migrate
php artisan test
php artisan queue:work
